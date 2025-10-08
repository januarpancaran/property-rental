<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Property::with(['photos', 'owner'])
            ->where('status', 'available');

        // Filters
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $properties = $query->paginate(10);

        return view('properties.index', compact('properties'));
    }

    /**
     * Display all listing of the resource.
     */
    public function adminIndex(Request $request)
    {
        $query = Property::with(['photos', 'owner']);

        // Filters
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $properties = $query->latest()->paginate(10);

        return view('admin.properties.index', compact('properties'));
    }

    /**
     * Display landlord's own properties
     */
    public function myProperties(Request $request)
    {
        $query = Auth::user()->properties()->with(['photos']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        $properties = $query->latest()->paginate(12);

        return view('properties.my.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('properties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'property_type' => 'required|in:apartment,house,condo,townhouse,studio',
            'rent_amount' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'area_sqm' => 'required|numeric|min:0',
            'photos' => 'nullable|array|max:10',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $validated['user_id'] = Auth::id();

        $property = Property::create($validated);

        // Handle photo uploads
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $file) {
                $fileName = time() . '_' . $index . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('properties/' . $property->id, $fileName, 'public');

                $property->photos()->create([
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                    'alt_text' => $property->title,
                    'sort_order' => $index,
                    'is_featured' => $index === 0 // First photo is featured
                ]);
            }
        }

        return redirect()->route('properties.show', $property)
            ->with('success', 'Property created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        $property->load(['photos', 'owner', 'bookings' => function ($query) {
            $query->with('user')->latest()->limit(5);
        }]);

        return view('properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        if ($property->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized to edit this property');
        }

        return view('properties.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        if ($property->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized to edit this property');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'property_type' => 'required|in:apartment,house,condo,townhouse,studio',
            'rent_amount' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'area_sqm' => 'required|numeric|min:0',
            'status' => 'sometimes|in:available,rented,maintenance',
            'new_photos' => 'nullable|array|max:10',
            'new_photos.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $property->update($validated);

        // Handle new photo uploads
        if ($request->hasFile('new_photos')) {
            $currentPhotoCount = $property->photos()->count();
            $maxPhotos = 10;

            foreach ($request->file('new_photos') as $index => $file) {
                if ($currentPhotoCount >= $maxPhotos) {
                    break;
                }

                $fileName = time() . '_' . $index . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('properties/' . $property->id, $fileName, 'public');

                $property->photos()->create([
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                    'alt_text' => $property->title,
                    'sort_order' => PropertyPhoto::getNextSortOrder($property->id),
                    'is_featured' => $currentPhotoCount === 0 // First photo is featured
                ]);

                $currentPhotoCount++;
            }
        }

        return redirect()->route('properties.show', $property)
            ->with('success', 'Property updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        if ($property->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized to delete this property');
        }

        $property->delete();

        return redirect()->route('properties.index')
            ->with('success', 'Property deleted successfully!');
    }

    /**
     * Delete property photo
     */
    public function deletePhoto(PropertyPhoto $photo)
    {
        // Check ownership
        if ($photo->property->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized to delete this photo');
        }

        $photo->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Show availability calendar
     */
    public function availability(Property $property)
    {
        // Check ownership
        if ($property->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized to view availability for this property');
        }

        $availability = $property->availabilityCalendar()
            ->where('date', '>=', now())
            ->orderBy('date')
            ->get();

        return view('properties.availability', compact('property', 'availability'));
    }


    /**
     * Block dates in availability calendar
     */
    public function blockDates(Request $request, Property $property)
    {
        // Check ownership
        if ($property->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized to manage availability for this property');
        }

        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Block dates in the range
        $currentDate = $startDate;
        while ($currentDate <= $endDate) {
            $property->availabilityCalendar()->updateOrCreate(
                ['date' => $currentDate],
                ['status' => 'blocked']
            );
            $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        }

        return redirect()->back()->with('success', 'Dates blocked successfully!');
    }

    /**
     * Set pricing override for specific dates
     */
    public function setPricing(Request $request, Property $property)
    {
        // Check ownership
        if ($property->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized to manage pricing for this property');
        }

        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'price_override' => 'required|numeric|min:0',
        ]);

        $property->availabilityCalendar()->updateOrCreate(
            ['date' => $request->date],
            [
                'price_override' => $request->price_override,
                'status' => 'available'
            ]
        );

        return redirect()->back()->with('success', 'Pricing updated successfully!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Property;
use App\Models\PropertyPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPropertyController extends Controller
{
    /**
     * Display a listing of the resource (admin only).
     */
    public function index(Request $request)
    {
        $this->authorizeAdmin();

        $query = Property::with(['photos', 'owner']);

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorizeAdmin();
        $users = User::all(['id', 'first_name', 'last_name', 'email']);
        return view('admin.properties.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

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
            'user_id' => 'required|exists:users,id',
            'photos' => 'nullable|array|max:10',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $property = Property::create($validated);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $file) {
                $fileName = time() . '_' . $index . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('properties/' . $property->id, $fileName, 'public');

                $property->photos()->create([
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                    'alt_text' => $property->title,
                    'sort_order' => $index,
                    'is_featured' => $index === 0
                ]);
            }
        }

        return redirect()->route('admin.properties.index')
            ->with('success', 'Property created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        $this->authorizeAdmin();
        $property->load(['photos', 'owner', 'bookings' => fn($q) => $q->with('user')->latest()->limit(5)]);
        return view('admin.properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        $this->authorizeAdmin();
        $users = User::all(['id', 'first_name', 'last_name', 'email']);
        return view('admin.properties.edit', compact('property', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        $this->authorizeAdmin();

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
            'user_id' => 'required|exists:users,id',
            'new_photos' => 'nullable|array|max:10',
            'new_photos.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $property->update($validated);

        if ($request->hasFile('new_photos')) {
            $currentPhotoCount = $property->photos()->count();
            foreach ($request->file('new_photos') as $index => $file) {
                if ($currentPhotoCount >= 10)
                    break;
                $fileName = time() . '_' . $index . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('properties/' . $property->id, $fileName, 'public');
                $property->photos()->create([
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                    'alt_text' => $property->title,
                    'sort_order' => PropertyPhoto::getNextSortOrder($property->id),
                    'is_featured' => $property->photos()->count() === 0
                ]);
                $currentPhotoCount++;
            }
        }

        return redirect()->route('admin.properties.index')
            ->with('success', 'Property updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        $this->authorizeAdmin();
        $property->delete();
        return redirect()->route('admin.properties.index')
            ->with('success', 'Property deleted successfully!');
    }

    /**
     * Delete property photo (admin only).
     */
    public function deletePhoto(PropertyPhoto $photo)
    {
        $this->authorizeAdmin();
        $photo->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Show availability calendar (admin only).
     */
    public function availability(Property $property)
    {
        $this->authorizeAdmin();
        $availability = $property->availabilityCalendars()
            ->where('date', '>=', now())
            ->orderBy('date')
            ->get();
        return view('admin.properties.availability', compact('property', 'availability'));
    }

    /**
     * Block dates in availability calendar (admin only).
     */
    public function blockDates(Request $request, Property $property)
    {
        $this->authorizeAdmin();

        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $currentDate = $request->start_date;
        while ($currentDate <= $request->end_date) {
            $property->availabilityCalendars()->updateOrCreate(
                ['date' => $currentDate],
                ['status' => 'blocked']
            );
            $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        }

        return redirect()->back()->with('success', 'Dates blocked successfully!');
    }

    /**
     * Set pricing override (admin only).
     */
    public function setPricing(Request $request, Property $property)
    {
        $this->authorizeAdmin();

        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'price_override' => 'required|numeric|min:0',
        ]);

        $property->availabilityCalendars()->updateOrCreate(
            ['date' => $request->date],
            ['price_override' => $request->price_override, 'status' => 'available']
        );

        return redirect()->back()->with('success', 'Pricing updated successfully!');
    }

    /**
     * Helper: Ensure user is admin.
     */
    private function authorizeAdmin()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access only.');
        }
    }
}
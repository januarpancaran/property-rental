<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use App\Models\User;
use App\Models\AvailabilityCalendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with(['property', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $properties = Property::all(['id', 'title']);
        $users = User::all(['id', 'first_name', 'last_name']);

        return view('admin.bookings.create', compact('properties', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'user_id' => 'required|exists:users,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'payment_status' => 'required|in:unpaid,paid,failed',
            'booking_status' => 'required|in:pending,confirmed,cancelled,completed',
            'notes' => 'nullable|string',
        ]);

        $property = Property::findOrFail($validatedData['property_id']);

        // Check for overlapping bookings
        $hasOverlap = Booking::where('property_id', $validatedData['property_id'])
            ->where('booking_status', '!=', 'cancelled')
            ->where(function ($q) use ($validatedData) {
                $q->whereBetween('check_in_date', [$validatedData['check_in_date'], $validatedData['check_out_date']])
                    ->orWhereBetween('check_out_date', [$validatedData['check_in_date'], $validatedData['check_out_date']])
                    ->orWhere(function ($sub) use ($validatedData) {
                        $sub->where('check_in_date', '<=', $validatedData['check_in_date'])
                            ->where('check_out_date', '>=', $validatedData['check_out_date']);
                    });
            })
            ->exists();

        if ($hasOverlap) {
            return back()->withErrors(['dates' => 'These dates overlap with an existing booking.']);
        }

        // Check availability calendar
        if (!$property->isAvailableForDates($validatedData['check_in_date'], $validatedData['check_out_date'])) {
            return back()->withErrors(['dates' => 'The property is not available for the selected dates.']);
        }

        // Calculate total amount (match user flow: daily rate from monthly rent)
        $checkIn = Carbon::parse($validatedData['check_in_date']);
        $checkOut = Carbon::parse($validatedData['check_out_date']);
        $nights = $checkIn->diffInDays($checkOut);
        $dailyRate = $property->rent_amount / 30;
        $totalAmount = $nights * $dailyRate;
        $validatedData['total_amount'] = $totalAmount;

        try {
            DB::beginTransaction();

            $booking = Booking::create($validatedData);

            // Block each date in availability calendar (check_out is exclusive)
            $currentDate = $validatedData['check_in_date'];
            while ($currentDate < $validatedData['check_out_date']) {
                AvailabilityCalendar::updateOrCreate(
                    [
                        'property_id' => $validatedData['property_id'],
                        'date' => $currentDate,
                    ],
                    ['status' => 'booked']
                );
                $currentDate = Carbon::parse($currentDate)->addDay()->toDateString();
            }

            DB::commit();
            return redirect()->route('admin.bookings.index')->with('success', 'Booking created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create booking: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $booking->load(['property', 'user']);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        $properties = Property::all(['id', 'title']);
        $users = User::all(['id', 'first_name', 'last_name']);
        return view('admin.bookings.edit', compact('booking', 'properties', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $validatedData = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'user_id' => 'required|exists:users,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'payment_status' => 'required|in:unpaid,paid,failed',
            'booking_status' => 'required|in:pending,confirmed,cancelled,completed',
            'notes' => 'nullable|string',
        ]);

        $property = Property::findOrFail($validatedData['property_id']);

        // Free old dates
        $oldCurrent = $booking->check_in_date;
        while ($oldCurrent < $booking->check_out_date) {
            AvailabilityCalendar::updateOrCreate(
                [
                    'property_id' => $booking->property_id,
                    'date' => $oldCurrent,
                ],
                ['status' => 'available']
            );
            $oldCurrent = Carbon::parse($oldCurrent)->addDay()->toDateString();
        }

        // Check overlap (excluding self)
        $hasOverlap = Booking::where('property_id', $validatedData['property_id'])
            ->where('id', '!=', $booking->id)
            ->where('booking_status', '!=', 'cancelled')
            ->where(function ($q) use ($validatedData) {
                $q->whereBetween('check_in_date', [$validatedData['check_in_date'], $validatedData['check_out_date']])
                    ->orWhereBetween('check_out_date', [$validatedData['check_in_date'], $validatedData['check_out_date']])
                    ->orWhere(function ($sub) use ($validatedData) {
                        $sub->where('check_in_date', '<=', $validatedData['check_in_date'])
                            ->where('check_out_date', '>=', $validatedData['check_out_date']);
                    });
            })
            ->exists();

        if ($hasOverlap) {
            // Re-block old dates on failure
            $tempDate = $booking->check_in_date;
            while ($tempDate < $booking->check_out_date) {
                AvailabilityCalendar::updateOrCreate(
                    ['property_id' => $booking->property_id, 'date' => $tempDate],
                    ['status' => 'booked']
                );
                $tempDate = Carbon::parse($tempDate)->addDay()->toDateString();
            }
            return back()->withErrors(['dates' => 'These dates overlap with an existing booking.']);
        }

        if (!$property->isAvailableForDates($validatedData['check_in_date'], $validatedData['check_out_date'])) {
            // Re-block old dates
            $tempDate = $booking->check_in_date;
            while ($tempDate < $booking->check_out_date) {
                AvailabilityCalendar::updateOrCreate(
                    ['property_id' => $booking->property_id, 'date' => $tempDate],
                    ['status' => 'booked']
                );
                $tempDate = Carbon::parse($tempDate)->addDay()->toDateString();
            }
            return back()->withErrors(['dates' => 'The property is not available for the new selected dates.']);
        }

        // Recalculate amount
        $checkIn = Carbon::parse($validatedData['check_in_date']);
        $checkOut = Carbon::parse($validatedData['check_out_date']);
        $nights = $checkIn->diffInDays($checkOut);
        $dailyRate = $property->rent_amount / 30;
        $validatedData['total_amount'] = $nights * $dailyRate;

        try {
            DB::beginTransaction();

            $booking->update($validatedData);

            // Block new dates
            $currentDate = $validatedData['check_in_date'];
            while ($currentDate < $validatedData['check_out_date']) {
                AvailabilityCalendar::updateOrCreate(
                    [
                        'property_id' => $validatedData['property_id'],
                        'date' => $currentDate,
                    ],
                    ['status' => 'booked']
                );
                $currentDate = Carbon::parse($currentDate)->addDay()->toDateString();
            }

            DB::commit();
            return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();

            // Best-effort: try to restore old dates
            $tempDate = $booking->check_in_date;
            while ($tempDate < $booking->check_out_date) {
                AvailabilityCalendar::updateOrCreate(
                    ['property_id' => $booking->property_id, 'date' => $tempDate],
                    ['status' => 'booked']
                );
                $tempDate = Carbon::parse($tempDate)->addDay()->toDateString();
            }

            return back()->with('error', 'Failed to update booking: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        try {
            DB::beginTransaction();

            // Free all booked dates
            $currentDate = $booking->check_in_date;
            while ($currentDate < $booking->check_out_date) {
                AvailabilityCalendar::updateOrCreate(
                    [
                        'property_id' => $booking->property_id,
                        'date' => $currentDate,
                    ],
                    ['status' => 'available']
                );
                $currentDate = Carbon::parse($currentDate)->addDay()->toDateString();
            }

            $booking->delete();
            DB::commit();
            return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted and dates freed!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete booking: ' . $e->getMessage());
        }
    }
}
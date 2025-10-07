<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use App\Models\AvailabilityCalendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display user's own bookings
     */
    public function index()
    {
        $bookings = Auth::user()->bookings()
            ->with(['property.photos', 'property.owner'])
            ->latest()
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Display all bookings for admin
     */
    public function adminIndex()
    {
        $bookings = Booking::with(['property', 'user'])
            ->latest()
            ->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking
     */
    public function create(Request $request)
    {
        $property = null;
        if ($request->has('property_id')) {
            $property = Property::with(['photos', 'owner'])->findOrFail($request->property_id);

            // Check if property is available
            if ($property->status !== 'available') {
                return redirect()->back()
                    ->withErrors(['property' => 'This property is not available for booking.']);
            }
        }

        return view('bookings.create', compact('property'));
    }

    /**
     * Store a newly created booking
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'notes' => 'nullable|string|max:500',
        ]);

        $property = Property::findOrFail($validated['property_id']);

        // Check if property is available
        if ($property->status !== 'available') {
            return redirect()->back()
                ->withErrors(['property' => 'This property is not available for booking.'])
                ->withInput();
        }

        // Check if user is trying to book their own property
        if ($property->user_id === Auth::id()) {
            return redirect()->back()
                ->withErrors(['property' => 'You cannot book your own property.'])
                ->withInput();
        }

        // Check for date conflicts
        $hasConflict = Booking::hasOverlappingBooking(
            $validated['property_id'],
            $validated['check_in_date'],
            $validated['check_out_date']
        );

        if ($hasConflict) {
            return redirect()->back()
                ->withErrors(['dates' => 'Selected dates are not available.'])
                ->withInput();
        }

        // Check availability calendar
        if (!$property->isAvailableForDates($validated['check_in_date'], $validated['check_out_date'])) {
            return redirect()->back()
                ->withErrors(['dates' => 'Selected dates are blocked or unavailable.'])
                ->withInput();
        }

        // Calculate total amount
        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);
        $nights = $checkIn->diffInDays($checkOut);
        $dailyRate = $property->rent_amount / 30; // Convert monthly to daily
        $totalAmount = $nights * $dailyRate;

        $booking = Booking::create([
            'property_id' => $validated['property_id'],
            'user_id' => Auth::id(),
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'total_amount' => $totalAmount,
            'notes' => $validated['notes'] ?? null,
            'booking_status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        // Block dates in availability calendar
        $currentDate = $validated['check_in_date'];
        while ($currentDate < $validated['check_out_date']) {
            AvailabilityCalendar::updateOrCreate(
                [
                    'property_id' => $validated['property_id'],
                    'date' => $currentDate
                ],
                ['status' => 'booked']
            );
            $currentDate = Carbon::parse($currentDate)->addDay()->toDateString();
        }

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking request submitted successfully! Waiting for landlord confirmation.');
    }

    /**
     * Display the specified booking
     */
    public function show(Booking $booking)
    {
        // Check if user can view this booking
        if (
            $booking->user_id !== Auth::id() &&
            $booking->property->user_id !== Auth::id() &&
            !Auth::user()->isAdmin()
        ) {
            abort(403, 'Unauthorized to view this booking');
        }

        $booking->load(['property.photos', 'user', 'property.owner']);

        return view('bookings.show', compact('booking'));
    }

    /**
     * Confirm a booking (landlord action)
     */
    public function confirm(Booking $booking)
    {
        // Check if user owns the property
        if ($booking->property->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized to confirm this booking');
        }

        if ($booking->booking_status !== 'pending') {
            return redirect()->back()
                ->withErrors(['booking' => 'Only pending bookings can be confirmed.']);
        }

        $booking->update(['booking_status' => 'confirmed']);

        return redirect()->back()
            ->with('success', 'Booking confirmed successfully!');
    }

    /**
     * Cancel a booking
     */
    public function cancel(Request $request, Booking $booking)
    {
        // Check if user can cancel this booking
        $canCancel = $booking->user_id === Auth::id() ||
            $booking->property->user_id === Auth::id() ||
            Auth::user()->isAdmin();

        if (!$canCancel) {
            abort(403, 'Unauthorized to cancel this booking');
        }

        if (!in_array($booking->booking_status, ['pending', 'confirmed'])) {
            return redirect()->back()
                ->withErrors(['booking' => 'This booking cannot be cancelled.']);
        }

        $booking->update([
            'booking_status' => 'cancelled',
            'notes' => $booking->notes . "\n\nCancelled by: " . Auth::user()->full_name .
                " on " . now()->format('Y-m-d H:i:s')
        ]);

        // Free up the availability calendar
        AvailabilityCalendar::where('property_id', $booking->property_id)
            ->whereBetween('date', [$booking->check_in_date->toDateString(), $booking->check_out_date->toDateString()])
            ->where('status', 'booked')
            ->update(['status' => 'available']);

        return redirect()->back()
            ->with('success', 'Booking cancelled successfully!');
    }

    /**
     * Mark booking as completed
     */
    public function complete(Booking $booking)
    {
        // Check if user owns the property or is admin
        if ($booking->property->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized to complete this booking');
        }

        if ($booking->booking_status !== 'confirmed') {
            return redirect()->back()
                ->withErrors(['booking' => 'Only confirmed bookings can be completed.']);
        }

        $booking->update(['booking_status' => 'completed']);

        return redirect()->back()
            ->with('success', 'Booking marked as completed!');
    }

    /**
     * Get bookings for a specific property (for property owners)
     */
    public function propertyBookings(Property $property)
    {
        // Check if user owns the property
        if ($property->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized to view bookings for this property');
        }

        $bookings = $property->bookings()
            ->with(['user'])
            ->latest()
            ->paginate(10);

        return view('properties.bookings', compact('property', 'bookings'));
    }

    /**
     * Check availability for dates (AJAX endpoint)
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        $property = Property::findOrFail($request->property_id);

        // Check for booking conflicts
        $hasBookingConflict = Booking::hasOverlappingBooking(
            $request->property_id,
            $request->check_in_date,
            $request->check_out_date
        );

        // Check availability calendar
        $hasCalendarConflict = !$property->isAvailableForDates(
            $request->check_in_date,
            $request->check_out_date
        );

        $isAvailable = !$hasBookingConflict && !$hasCalendarConflict && $property->status === 'available';

        // Calculate pricing
        $checkIn = Carbon::parse($request->check_in_date);
        $checkOut = Carbon::parse($request->check_out_date);
        $nights = $checkIn->diffInDays($checkOut);
        $dailyRate = $property->rent_amount / 30;
        $totalAmount = $nights * $dailyRate;

        return response()->json([
            'available' => $isAvailable,
            'nights' => $nights,
            'daily_rate' => $dailyRate,
            'total_amount' => $totalAmount,
            'formatted_total' => 'Rp ' . number_format($totalAmount, 0, ',', '.'),
            'message' => $isAvailable ? 'Dates are available!' : 'Selected dates are not available.'
        ]);
    }
}

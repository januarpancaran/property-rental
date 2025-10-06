<?php

namespace App\Http\Controllers;

use App\Model\Booking;
use App\Model\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::With(['property','property_owner'])
        ->where('user_id',auth()->id());
        return view('bookings.index', compact('bookings'));
    }

    public function landlordIndex()
    {
        $bookings = Booking::with(['property', 'user'])
            ->whereHas('property', function ($q) {
                $q->where('owner_id', auth()->id());
            })
            ->paginate(10);

        return view('bookings.landlord_index', compact('bookings'));
    }

    public function create()
    {
        return view('bookings.create');
    }
    
    public function store(Request $request)
    {
        $validated['user_id'] = Auth::id();
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:start_date'
        ]);
        $validated['payment_status'] = 'pending';
        $validated['booking_status'] = 'pending';

        $booking = Booking::create($validated);
        return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
    }

    /**
     * Tenant: Cancel Booking
     */
    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking cancelled.');
    }

    /**
     * Landlord: Confirm Booking
     */
    public function confirm(Booking $booking)
    {
        if ($booking->property->owner_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $booking->update(['status' => 'confirmed']);

        return back()->with('success', 'Booking confirmed.');
    }

    /**
     * Landlord: Cancel Booking
     */
    public function landlordCancel(Booking $booking)
    {
        if ($booking->property->owner_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking cancelled by landlord.');
    }

    /**
     * Landlord: Complete Booking
     */
    public function complete(Booking $booking)
    {
        if ($booking->property->owner_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $booking->update(['status' => 'completed']);

        return back()->with('success', 'Booking marked as completed.');
    }
}

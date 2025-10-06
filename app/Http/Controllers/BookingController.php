<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $bookings = Booking::with(['user', 'property'])->latest()->get();
        } elseif ($user->role === 'landlord') {
            $bookings = Booking::whereHas('property', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['user', 'property'])->latest()->get();
        } else {
            $bookings = Booking::where('user_id', $user->id)->with(['property'])->latest()->get();
        }

        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $properties = Property::all();
        return view('bookings.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Booking::create([
            'user_id' => Auth::id(),
            'property_id' => $request->property_id,
            'status' => 'pending',
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
    }

    public function confirm(Booking $booking)
    {
        if (Auth::user()->role === 'landlord' || Auth::user()->role === 'admin') {
            $booking->update(['status' => 'confirmed']);
        }
        return back()->with('success', 'Booking confirmed.');
    }

    public function cancel(Booking $booking)
    {
        $user = Auth::user();
        if (
            $user->role === 'admin' ||
            $user->id === $booking->user_id ||
            ($user->role === 'landlord' && $booking->property->user_id === $user->id)
        ) {
            $booking->update(['status' => 'cancelled']);
        }
        return back()->with('success', 'Booking cancelled.');
    }

    public function complete(Booking $booking)
    {
        if (Auth::user()->role === 'landlord' || Auth::user()->role === 'admin') {
            $booking->update(['status' => 'completed']);
        }
        return back()->with('success', 'Booking completed.');
    }
}

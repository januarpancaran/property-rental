<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function confirm(Booking $booking)
    {
        // Check authorization
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Check if booking already has a paid order
        if ($booking->isPaid()) {
            return redirect()->route('bookings.show', $booking)
                ->with('info', 'This booking is paid.');
        }

        // Check if booking is cancelled
        if ($booking->isCancelled()) {
            return redirect()->route('bookings.index')
                ->with('error', 'This booking is cancelled.');
        }

        return view('orders.confirm', compact('booking'));
    }

    public function process(Booking $booking)
    {
        // Check authorization
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Check if booking already has a pending or paid order
        $existingOrder = Order::where('booking_id', $booking->id)
            ->whereIn('payment_status', ['pending', 'paid'])
            ->first();

        if ($existingOrder) {
            if ($existingOrder->isPaid()) {
                return redirect()->route('bookings.show', $booking)
                    ->with('info', 'This booking is paid.');
            }
            return redirect()->route('orders.waiting', $existingOrder);
        }

        $expiredHours = (int) config('services.payment.expired_hours', 24);

        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'booking_id' => $booking->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'amount' => $booking->total_amount,
            'payment_status' => 'pending',
            'expired_at' => now()->addHours($expiredHours),
        ]);

        // Create Virtual Account via Payment Gateway API
        try {
            $response = Http::withHeaders([
                'X-API-Key' => config('services.payment.api_key'),
                'Accept' => 'application/json',
            ])->withoutVerifying()->post(config('services.payment.base_url') . '/virtual-account/create', [
                'external_id' => $order->order_number,
                'amount' => $order->amount,
                'customer_name' => auth()->user()->full_name,
                'customer_email' => auth()->user()->email,
                'customer_phone' => auth()->user()->phone ?? '081234567890',
                'description' => 'Pembayaran Booking ' . $booking->property->title,
                'expired_duration' => $expiredHours,
                'callback_url' => route('orders.success', $order),
                'metadata' => [
                    'booking_id' => $booking->id,
                    'property_id' => $booking->property_id,
                    'user_id' => auth()->id(),
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();

                $order->update([
                    'va_number' => $data['data']['va_number'],
                    'payment_url' => $data['data']['payment_url'],
                ]);

                return redirect()->route('orders.waiting', $order);
            } else {
                $order->update(['payment_status' => 'failed']);
                return redirect()->route('bookings.show', $booking)
                    ->with('error', 'Failed to create order. Please try again.');
            }
        } catch (\Exception $e) {
            $order->update(['payment_status' => 'failed']);
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'An Error Occured: ' . $e->getMessage());
        }
    }

    public function waiting(Order $order)
    {
        // Check authorization
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Load relationships
        $order->load(['booking.property.photos', 'user']);

        if ($order->isPaid()) {
            return redirect()->route('orders.success', $order);
        }

        if ($order->isExpired()) {
            return redirect()->route('bookings.show', $order->booking)
                ->with('error', 'This order is expired.');
        }

        return view('orders.waiting', compact('order'));
    }

    public function checkStatus(Order $order)
    {
        // Check authorization
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return response()->json([
            'status' => $order->payment_status,
            'paid_at' => $order->paid_at?->toISOString(),
        ]);
    }

    public function success(Order $order)
    {
        // Check authorization
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Load relationships
        $order->load(['booking.property.photos', 'user']);

        if (!$order->isPaid()) {
            return redirect()->route('orders.waiting', $order);
        }

        return view('orders.success', compact('order'));
    }

    public function index()
    {
        $orders = auth()->user()->orders()
            ->with(['booking.property'])
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Check authorization
        if ($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $order->load(['booking.property.photos', 'user']);

        return view('orders.show', compact('order'));
    }
}

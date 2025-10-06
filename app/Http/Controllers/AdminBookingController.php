<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use App\Models\User;
use App\Models\AvailabilityCalendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'payment_status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $isAvailable = $this->checkAvailability(
            $validatedData['property_id'],
            $validatedData['check_in_date'],
            $validatedData['check_out_date']
        );

        if (!$isAvailable) {
            return back()->withErrors(['dates' => 'Properti tidak tersedia untuk tanggal yang dipilih.'])
                ->withInput();
        }

        $calculatedAmount = $this->calculateTotalAmount(
            $validatedData['property_id'],
            $validatedData['check_in_date'],
            $validatedData['check_out_date']
        );

        if ($calculatedAmount <= 0) {
            return back()->withErrors(['amount' => 'Gagal menghitung jumlah booking. Pastikan harga ditetapkan di Kalender Ketersediaan untuk tanggal tersebut.'])
                ->withInput();
        }

        $validatedData['total_amount'] = $calculatedAmount;

        try {
            DB::beginTransaction();
            
            $booking = Booking::create($validatedData);

            $endDateForUpdate = date('Y-m-d', strtotime('-1 day', strtotime($validatedData['check_out_date'])));
            AvailabilityCalendar::where('property_id', $validatedData['property_id'])
                ->whereBetween('date', [$validatedData['check_in_date'], $endDateForUpdate])
                ->update(['status' => 'booked']);

            DB::commit();
            return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat booking: ' . $e->getMessage())->withInput();
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
            'payment_status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $oldEndDate = date('Y-m-d', strtotime('-1 day', strtotime($booking->check_out_date)));
            AvailabilityCalendar::where('property_id', $booking->property_id)
                ->whereBetween('date', [$booking->check_in_date, $oldEndDate])
                ->update(['status' => 'available']);

            $isAvailable = $this->checkAvailability(
                $validatedData['property_id'],
                $validatedData['check_in_date'],
                $validatedData['check_out_date']
            );

            if (!$isAvailable) {
                DB::rollBack();
                // Rollback status ke 'available' karena gagal
                return back()->withErrors(['dates' => 'Properti tidak tersedia untuk tanggal baru yang dipilih.'])
                    ->withInput();
            }

            $calculatedAmount = $this->calculateTotalAmount(
                $validatedData['property_id'],
                $validatedData['check_in_date'],
                $validatedData['check_out_date']
            );

            if ($calculatedAmount <= 0) {
                DB::rollBack();
                return back()->withErrors(['amount' => 'Gagal menghitung jumlah booking baru.'])
                    ->withInput();
            }

            $validatedData['total_amount'] = $calculatedAmount;

            $booking->update($validatedData);

            $newEndDate = date('Y-m-d', strtotime('-1 day', strtotime($validatedData['check_out_date'])));
            AvailabilityCalendar::where('property_id', $validatedData['property_id'])
                ->whereBetween('date', [$validatedData['check_in_date'], $newEndDate])
                ->update(['status' => 'booked']);

            DB::commit();
            return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui booking: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        try {
            DB::beginTransaction();

            AvailabilityCalendar::where('property_id', $booking->property_id)
                ->whereBetween('date', [$booking->check_in_date, date('Y-m-d', strtotime('-1 day', strtotime($booking->check_out_date)))])
                ->update(['status' => 'available']);

            $booking->delete();

            DB::commit();
            return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dihapus dan tanggal dikosongkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus booking: ' . $e->getMessage());
        }
    }

    protected function checkAvailability($propertyId, $checkIn, $checkOut)
    {
        $checkIn = date('Y-m-d', strtotime($checkIn));
        $checkOut = date('Y-m-d', strtotime($checkOut));

        $endDate = date('Y-m-d', strtotime('-1 day', strtotime($checkOut)));
        $calendarEntryCount = AvailabilityCalendar::where('property_id', $propertyId)
            ->whereBetween('date', [$checkIn, $endDate])
            ->count();

        $dateDiff = strtotime($endDate) - strtotime($checkIn);
        $totalDays = floor($dateDiff / (60 * 60 * 24)) + 1;

        $requiredDays = (int) $totalDays;
        return $calendarEntryCount === $requiredDays;
    }

    protected function calculateTotalAmount($propertyId, $checkIn, $checkOut)
    {
        $checkIn = date('Y-m-d', strtotime($checkIn));
        $checkOut = date('Y-m-d', strtotime($checkOut));
        $endDate = date('Y-m-d', strtotime('-1 day', strtotime($checkOut)));

        $totalAmount = AvailabilityCalendar::where('property_id', $propertyId)
            ->whereBetween('date', [$checkIn, $endDate])
            ->sum('price_override');

        return $totalAmount ?? 0;
    }
}

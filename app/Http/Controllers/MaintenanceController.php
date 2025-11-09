<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MaintenanceController extends Controller
{
    /**
     * Tampilan daftar untuk Tenant (Hanya permintaan mereka sendiri)
     */
    public function indexTenant()
    {
        // Tenant hanya bisa melihat permintaan yang mereka buat (user_id mereka)
        $maintenances = Auth::user()->maintenances()->latest()->paginate(10);

        return view('maintenances.tenant.index', compact('maintenances'));
    }

    /**
     * Tampilan daftar untuk Admin/Landlord (Manajemen)
     */
    public function indexManage()
    {
        $user = Auth::user();
        $query = Maintenance::latest();

        if ($user->isLandlord()) {
            // Landlord hanya melihat permintaan dari properti yang mereka miliki
            $propertyIds = $user->properties()->pluck('id');
            $query->whereIn('property_id', $propertyIds);
        }
        // Admin melihat semua (default query)

        $maintenances = $query->paginate(10);

        return view('maintenances.manage.index', compact('maintenances'));
    }

    /**
     * Tampilkan form pembuatan permintaan baru
     */
    public function create()
    {
        $user = Auth::user();

        // Ambil properti yang disewa/dimiliki user saat ini
        if ($user->isTenant()) {
            // Asumsi properti disewa melalui activeContracts()
            $properties = Property::whereIn('id', $user->activeBookings()->pluck('property_id'))->get();
        } elseif ($user->isLandlord()) {
            $properties = $user->properties;
        } else {
            $properties = Property::all(); // Admin
        }

        return view('maintenances.create', compact('properties'));
    }

    /**
     * Simpan permintaan perawatan baru
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'property_id' => [
                'required',
                'exists:properties,id',
                // Pastikan tenant hanya bisa request untuk properti yang mereka sewa/tempati
                Rule::in($user->isTenant() ? $user->activeBookings()->pluck('property_id')->toArray() : Property::pluck('id')->toArray()),
            ],
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'priority' => ['required', 'string', Rule::in(['low', 'medium', 'high', 'urgent'])],
        ]);

        Maintenance::create([
            'user_id' => $user->id,
            'status' => 'pending',
            'property_id' => $validated['property_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'priority' => $validated['priority'],
        ]);

        // TODO: Trigger notifikasi ke Landlord/Admin
        return redirect()->route('tenant.maintenances.index')->with('success', 'Permintaan perawatan berhasil diajukan!');
    }

    /**
     * Tampilan detail untuk Tenant (hanya milik sendiri)
     */
    public function showTenant(Maintenance $maintenance)
    {
        // Otorisasi: Pastikan permintaan milik user yang sedang login
        if ($maintenance->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke permintaan ini.');
        }

        return view('maintenances.tenant.show', compact('maintenance'));
    }

    /**
     * Tampilan detail untuk Admin/Landlord (manajemen)
     */
    public function showManage(Maintenance $maintenance)
    {
        $user = Auth::user();

        // Otorisasi Landlord: Pastikan properti milik Landlord
        if ($user->isLandlord() && $maintenance->property->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke permintaan perawatan properti ini.');
        }
        // Admin bisa melihat semua, sudah di-handle oleh middleware can:view_property_maintenance

        return view('maintenances.manage.show', compact('maintenance'));
    }


    /**
     * Update status, jadwal, atau penugasan (Hanya untuk Admin/Landlord)
     */
    public function update(Request $request, Maintenance $maintenance)
    {
        // Otorisasi Landlord: Pastikan properti milik Landlord
        $user = Auth::user();
        if ($user->isLandlord() && $maintenance->property->user_id !== $user->id) {
            abort(403, 'Anda tidak berwenang mengelola permintaan perawatan properti ini.');
        }

        $validated = $request->validate([
            'status' => ['nullable', Rule::in(['pending', 'in_progress', 'completed', 'cancelled'])],
            'scheduled_date' => 'nullable|date',
            'assigned_to' => 'nullable|string|max:255',
            'estimated_cost' => 'nullable|numeric|min:0',
        ]);

        // Gunakan helper methods di model
        if (isset($validated['scheduled_date']) || isset($validated['assigned_to'])) {
            $maintenance->schedule(
                $validated['scheduled_date'] ?? $maintenance->scheduled_date,
                $validated['assigned_to'] ?? $maintenance->assigned_to
            );
        }

        // Update status umum dan biaya
        $maintenance->update(array_filter([
            'status' => $validated['status'] ?? null,
            'estimated_cost' => $validated['estimated_cost'] ?? null,
        ]));

        // TODO: Trigger notifikasi ke Tenant
        return back()->with('success', 'Permintaan perawatan berhasil diperbarui.');
    }

    /**
     * Tandai sebagai Selesai (Completed)
     */
    public function complete(Maintenance $maintenance)
    {
        // Otorisasi: Dibatasi oleh middleware can:complete_maintenance
        if (Auth::user()->isLandlord() && $maintenance->property->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berwenang mengelola permintaan perawatan properti ini.');
        }

        if (!$maintenance->isCompleted()) {
            $maintenance->markCompleted();
            // TODO: Trigger notifikasi penyelesaian ke Tenant
            return back()->with('success', 'Permintaan perawatan berhasil ditandai sebagai Selesai.');
        }

        return back()->with('warning', 'Permintaan perawatan sudah Selesai.');
    }

    /**
     * Batalkan Permintaan (Cancel)
     */
    public function cancel(Maintenance $maintenance)
    {
        // Otorisasi: Dibatasi oleh middleware can:cancel_maintenance
        if (Auth::user()->isLandlord() && $maintenance->property->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berwenang mengelola permintaan perawatan properti ini.');
        }

        if (!$maintenance->isCancelled()) {
            $maintenance->cancel();
            // TODO: Trigger notifikasi pembatalan ke Tenant
            return back()->with('success', 'Permintaan perawatan berhasil dibatalkan.');
        }

        return back()->with('warning', 'Permintaan perawatan sudah dibatalkan.');
    }
}

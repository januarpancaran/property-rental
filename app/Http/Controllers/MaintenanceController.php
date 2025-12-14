<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Notifications\MaintenanceCreatedNotification;
use App\Notifications\MaintenanceUpdatedNotification;
use App\Notifications\MaintenanceCompletedNotification;
use App\Notifications\MaintenanceCancelledNotification;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of maintenance requests for tenants (only their own).
     */
    public function indexTenant()
    {
        $maintenances = Auth::user()->maintenances()->latest()->paginate(10);
        return view('maintenances.tenant.index', compact('maintenances'));
    }

    /**
     * Display a listing for admin/landlord (management view).
     */
    public function indexManage()
    {
        $user = Auth::user();
        $query = Maintenance::latest();

        if ($user->isLandlord()) {
            $propertyIds = $user->properties()->pluck('id');
            $query->whereIn('property_id', $propertyIds);
        }

        $maintenances = $query->paginate(10);
        return view('maintenances.manage.index', compact('maintenances'));
    }

    /**
     * Show the form to create a new maintenance request.
     */
    public function create()
    {
        $user = Auth::user();

        if ($user->isTenant()) {
            $properties = Property::whereIn('id', $user->activeBookings()->pluck('property_id'))->get();
        } elseif ($user->isLandlord()) {
            $properties = $user->properties;
        } else {
            $properties = Property::all(); // Admin
        }

        return view('maintenances.create', compact('properties'));
    }

    /**
     * Store a new maintenance request.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'property_id' => [
                'required',
                'exists:properties,id',
                Rule::in($user->isTenant() ? $user->activeBookings()->pluck('property_id')->toArray() : Property::pluck('id')->toArray()),
            ],
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'priority' => ['required', 'string', Rule::in(['low', 'medium', 'high', 'urgent'])],
        ]);

        $maintenance = Maintenance::create([
            'user_id' => $user->id,
            'status' => 'pending',
            'property_id' => $validated['property_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'priority' => $validated['priority'],
        ]);

        // Notify landlord (property owner)
        $landlord = $maintenance->property->owner;
        $landlord->notify(new MaintenanceCreatedNotification($maintenance));

        // Optional: Notify admin if you want system-wide alerts

        return redirect()->route('tenant.maintenances.index')
            ->with('success', 'Maintenance request submitted successfully!');
    }

    /**
     * Show maintenance detail for tenant (own requests only).
     */
    public function showTenant(Maintenance $maintenance)
    {
        if ($maintenance->user_id !== Auth::id()) {
            abort(403, 'You do not have access to this maintenance request.');
        }
        return view('maintenances.tenant.show', compact('maintenance'));
    }

    /**
     * Show maintenance detail for admin/landlord.
     */
    public function showManage(Maintenance $maintenance)
    {
        $user = Auth::user();
        if ($user->isLandlord() && $maintenance->property->user_id !== $user->id) {
            abort(403, 'You do not have access to this property\'s maintenance requests.');
        }
        return view('maintenances.manage.show', compact('maintenance'));
    }

    /**
     * Update maintenance request (status, schedule, etc.) – for admin/landlord only.
     */
    public function update(Request $request, Maintenance $maintenance)
    {
        $user = Auth::user();
        if ($user->isLandlord() && $maintenance->property->user_id !== $user->id) {
            abort(403, 'You are not authorized to manage this maintenance request.');
        }

        $validated = $request->validate([
            'status' => ['nullable', Rule::in(['pending', 'in_progress', 'completed', 'cancelled'])],
            'scheduled_date' => 'nullable|date',
            'assigned_to' => 'nullable|string|max:255',
            'estimated_cost' => 'nullable|numeric|min:0',
        ]);

        if (isset($validated['scheduled_date']) || isset($validated['assigned_to'])) {
            $maintenance->schedule(
                $validated['scheduled_date'] ?? $maintenance->scheduled_date,
                $validated['assigned_to'] ?? $maintenance->assigned_to
            );
        }

        $maintenance->update(array_filter([
            'status' => $validated['status'] ?? null,
            'estimated_cost' => $validated['estimated_cost'] ?? null,
        ]));

        // Notify tenant about update
        $tenant = $maintenance->user;
        $tenant->notify(new MaintenanceUpdatedNotification($maintenance));

        return back()->with('success', 'Maintenance request updated successfully.');
    }

    /**
     * Mark maintenance as completed.
     */
    public function complete(Maintenance $maintenance)
    {
        if (Auth::user()->isLandlord() && $maintenance->property->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to manage this maintenance request.');
        }

        if (!$maintenance->isCompleted()) {
            $maintenance->markCompleted();

            // Notify tenant
            $tenant = $maintenance->user;
            $tenant->notify(new MaintenanceCompletedNotification($maintenance));

            return back()->with('success', 'Maintenance request marked as completed.');
        }

        return back()->with('warning', 'This maintenance request is already completed.');
    }

    /**
     * Cancel a maintenance request.
     */
    public function cancel(Maintenance $maintenance)
    {
        if (Auth::user()->isLandlord() && $maintenance->property->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to manage this maintenance request.');
        }

        if (!$maintenance->isCancelled()) {
            $maintenance->cancel();

            // Notify tenant
            $tenant = $maintenance->user;
            $tenant->notify(new MaintenanceCancelledNotification($maintenance));

            return back()->with('success', 'Maintenance request cancelled successfully.');
        }

        return back()->with('warning', 'This maintenance request is already cancelled.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('role')->paginate(10);
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Data
        $validatedData = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:15'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
            'date_of_birth' => ['required', 'date'],
            'occupation' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'in:active,inactive,pending'],
            'role' => ['required', 'exists:roles,id'],
        ]);

        try {
            // 2. Buat User Baru
            $user = User::create([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'password' => Hash::make($validatedData['password']),
                'date_of_birth' => $validatedData['date_of_birth'],
                'occupation' => $validatedData['occupation'],
                'status' => $validatedData['status'],
            ]);
            
            $roleId = $validatedData['role'];
            $role = Role::findOrFail($roleId);
            $user->update(['role_id' => $roleId]); 

            return redirect()->route('admin.user.index')
                ->with('success', 'User ' . $user->first_name . ' ' . $user->last_name . ' berhasil dibuat.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat user. Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('role')->findOrFail($id);
        return view('admin.user.show', compact('user'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        
        $currentRoleId = $user->role_id ? $user->role_id : null; 

        return view('admin.user.edit', compact('user', 'roles', 'currentRoleId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // 1. Validasi Data
        $validatedData = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'string', 'max:15'],
            'password' => ['nullable', 'string','confirmed', Password::defaults()], 
            'date_of_birth' => ['required', 'date'],
            'occupation' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'in:active,inactive,pending'],
            'role' => ['required', 'exists:roles,id'],
        ]);

        $updateData = [
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'date_of_birth' => $validatedData['date_of_birth'],
            'occupation' => $validatedData['occupation'],
            'status' => $validatedData['status'],
        ];

        if (!empty($validatedData['password'])) {
            $updateData['password'] = Hash::make($validatedData['password']);
        }

        try {
            $user->update($updateData);

            $roleId = $validatedData['role'];
            $role = Role::findOrFail($roleId);
            $user->update(['role_id' => $roleId]); 

            return redirect()->route('admin.user.index')
                ->with('success', 'User ' . $user->first_name . ' ' . $user->last_name . ' berhasil diperbarui.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui user. Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = User::findOrFail($id);

        $role->delete();

        return redirect()->route('admin.user.index')->with('success', 'User deleted successfully!');
    }
}

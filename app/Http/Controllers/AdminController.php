<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    // ========= List internal users =========
    public function index()
    {
        $user    = auth()->user();
        $isAdmin = $user->hasRole('administrator');

        if ($isAdmin) {
            $admins      = User::role(['administrator', 'agent', 'sales-agent', 'billing-agent', 'support'])->get();
            $pending     = User::whereDoesntHave('roles')->where('status', 'pending')->get();
            $roles       = Role::all();
            $permissions = Permission::orderBy('name')->get();
        } else {
            $admins      = User::role('sales-agent')->where('created_by', $user->id)->get();
            $pending     = collect();
            $roles       = Role::where('name', 'sales-agent')->get();
            $permissions = collect();
        }

        return view('admin.admin', compact('admins', 'pending', 'roles', 'permissions', 'isAdmin'));
    }

    // ========= Create internal user =========
    public function store(Request $request)
    {
        $user    = auth()->user();
        $isAdmin = $user->hasRole('administrator');

        $allowedRoles = $isAdmin ? 'required|exists:roles,name' : 'required|in:sales-agent';

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role'     => $allowedRoles,
        ]);

        $newUser = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'status'     => 'approved',
            'created_by' => $user->id,
        ]);

        $newUser->assignRole($request->role);

        return redirect()->route('admin')->with('success', 'User created successfully.');
    }

    // ========= Update internal user =========
    public function update(Request $request, User $user)
    {
        $authUser = auth()->user();
        $isAdmin  = $authUser->hasRole('administrator');

        if (!$isAdmin && ($user->created_by !== $authUser->id || !$user->hasRole('sales-agent'))) {
            abort(403);
        }

        $allowedRoles = $isAdmin ? 'required|exists:roles,name' : 'required|in:sales-agent';

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role'     => $allowedRoles,
            'status'   => 'required|in:approved,pending,rejected',
        ]);

        $data = [
            'name'   => $request->name,
            'email'  => $request->email,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $user->syncRoles($request->role);

        return redirect()->route('admin')->with('success', 'User updated successfully.');
    }

    // ========= Update role permissions =========
    public function updatePermissions(Request $request)
    {
        $roles = Role::where('name', '!=', 'administrator')->get();

        foreach ($roles as $role) {
            $permissionIds = $request->input("permissions.{$role->id}", []);
            $permissions   = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();
            $role->syncPermissions($permissions);
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('admin')->with('success', 'Permissions updated successfully.');
    }

    // ========= Convert pending user to prospect =========
    public function convertToProspect(User $user)
    {
        $parts     = explode(' ', trim($user->name), 2);
        $firstName = $parts[0];
        $lastName  = $parts[1] ?? null;

        Contact::create([
            'first_name'     => $firstName,
            'last_name'      => $lastName,
            'email'          => $user->email,
            'password'       => $user->password,
            'status'         => 'prospect',
            'pipeline_stage' => 'new',
        ]);

        $user->delete();

        return redirect()->route('admin')->with('success', 'Usuario convertido a prospecto correctamente.');
    }

    // ========= Delete internal user =========
    public function destroy(User $user)
    {
        $authUser = auth()->user();
        $isAdmin  = $authUser->hasRole('administrator');

        if ($user->id === $authUser->id) {
            return redirect()->route('admin')->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        if (!$isAdmin && ($user->created_by !== $authUser->id || !$user->hasRole('sales-agent'))) {
            abort(403);
        }

        $user->delete();

        return redirect()->route('admin')->with('success', 'User deleted successfully.');
    }
}
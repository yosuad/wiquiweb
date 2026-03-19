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
        $admins = User::role(['administrator', 'agent', 'sales-agent', 'billing-agent', 'support'])
            ->get();

        $pending = User::whereDoesntHave('roles')->where('status', 'pending')->get();

        $roles       = Role::all();
        $permissions = Permission::orderBy('name')->get();

        return view('admin.admin', compact('admins', 'pending', 'roles', 'permissions'));
    }

    // ========= Create internal user =========
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role'     => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'status'   => 'approved',
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin')->with('success', 'User created successfully.');
    }

    // ========= Update internal user =========
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role'     => 'required|exists:roles,name',
        ]);

        $data = [
            'name'   => $request->name,
            'email'  => $request->email,
            'status' => 'approved',
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

        // Limpiar cache de permisos de Spatie
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
        if ($user->id === auth()->id()) {
            return redirect()->route('admin')->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $user->delete();

        return redirect()->route('admin')->with('success', 'User deleted successfully.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    // ========= List internal users =========
    public function index()
    {
        $admins = User::role(['administrator', 'agent', 'sales-agent', 'billing-agent', 'support'])
            ->get();

        $roles = Role::all();

        return view('admin.admin', compact('admins', 'roles'));
    }

    // ========= Create internal user =========
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role'  => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt('password'),
            'status'   => 'approved',
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin')->with('success', 'User created successfully.');
    }

    // ========= Update internal user =========
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|exists:roles,name',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        $user->syncRoles($request->role);

        return redirect()->route('admin')->with('success', 'User updated successfully.');
    }

    // ========= Delete internal user =========
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin')->with('success', 'User deleted successfully.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    // ========= List internal users =========
    public function index()
    {
        $admins = User::role(['administrator', 'agent', 'sales-agent', 'billing-agent', 'support'])
            ->get();

        $pending = User::whereDoesntHave('roles')->where('status', 'pending')->get();

        $roles = Role::all();

        return view('admin.admin', compact('admins', 'pending', 'roles'));
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
            'name'   => $request->name,
            'email'  => $request->email,
            'status' => 'approved',
        ]);

        $user->syncRoles($request->role);

        return redirect()->route('admin')->with('success', 'User updated successfully.');
    }

    // ========= Convert pending user to prospect =========
    public function convertToProspect(User $user)
    {
        // Separar nombre en first_name y last_name
        $parts     = explode(' ', trim($user->name), 2);
        $firstName = $parts[0];
        $lastName  = $parts[1] ?? null;

        Contact::create([
            'first_name' => $firstName,
            'last_name'  => $lastName,
            'email'      => $user->email,
            'password'   => $user->password,
            'status'     => 'prospect',
            'pipeline_stage' => 'new',
        ]);

        $user->delete();

        return redirect()->route('admin')->with('success', 'Usuario convertido a prospecto correctamente.');
    }

    // ========= Delete internal user =========
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin')->with('success', 'User deleted successfully.');
    }
}
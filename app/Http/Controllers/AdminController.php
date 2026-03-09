<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    // ========= Listar administradores =========
    public function index()
    {
        $admins = User::role(['admin', 'editor', 'agente-cobros', 'agente-ventas', 'soporte'])
            ->get();

        $roles = Role::all();

        return view('admin.admin', compact('admins', 'roles'));
    }

    // ========= Crear usuario interno =========
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

        return redirect()->route('admin')->with('success', 'Usuario creado correctamente.');
    }

    // ========= Actualizar usuario interno =========
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

        return redirect()->route('admin')->with('success', 'Usuario actualizado correctamente.');
    }

    // ========= Eliminar usuario interno =========
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin')->with('success', 'Usuario eliminado correctamente.');
    }
}
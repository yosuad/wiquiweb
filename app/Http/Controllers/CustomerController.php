<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // ========= Listar clientes =========
    public function index()
    {
        $customers = User::role('customer')
            ->with(['services.service'])
            ->paginate();

        return view('admin.customers', compact('customers'));
    }

    // ========= Actualizar cliente =========
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|unique:users,email,' . $user->id,
            'phone'   => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'status'  => 'nullable|in:approved,rejected',
            'task'    => 'nullable|string',
        ]);

        $user->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'company' => $request->company,
            'address' => $request->address,
            'status'  => $request->status,
        ]);

        return redirect()->route('customers')->with('success', 'Cliente actualizado correctamente.');
    }

    // ========= Eliminar cliente =========
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('customers')->with('success', 'Cliente eliminado correctamente.');
    }
}
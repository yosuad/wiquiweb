<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServicePrice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    // ========= Listar servicios =========
    public function index()
    {
        $services = Service::all();

        return view('admin.services', compact('services'));
    }

    // ========= Vista crear servicio =========
    public function create()
    {
        return view('admin.services.create');
    }

    // ========= Crear servicio =========
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:services,name',
            'description' => 'nullable|string',
        ]);

        Service::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->route('services.index')->with('success', 'Servicio creado correctamente.');
    }

    // ========= Vista editar servicio =========
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    // ========= Actualizar servicio =========
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:services,name,' . $service->id,
            'description' => 'nullable|string',
        ]);

        $service->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->route('services.index')->with('success', 'Servicio actualizado correctamente.');
    }

    // ========= Eliminar servicio =========
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Servicio eliminado correctamente.');
    }

    // ========= Vista precios =========
    public function prices(Service $service)
    {
        $prices = $service->prices()->get();

        return view('admin.services.prices', compact('service', 'prices'));
    }

    // ========= Agregar precio =========
    public function storePrice(Request $request, Service $service)
    {
        $request->validate([
            'region'        => 'required|in:colombia,exterior',
            'client_type'   => 'required|in:natural,empresa,emprendimiento,artista,organizacion_social',
            'billing_cycle' => 'required|in:monthly,annual,one_time',
            'price'         => 'required|numeric|min:0',
            'plan'          => 'nullable|string|max:100',
        ]);

        $service->prices()->create([
            'region'        => $request->region,
            'client_type'   => $request->client_type,
            'billing_cycle' => $request->billing_cycle,
            'plan'          => $request->plan,
            'price'         => $request->price,
            'currency'      => 'USD',
        ]);

        return redirect()->route('services.prices', $service->id)
            ->with('success', 'Precio agregado correctamente.');
    }

    // ========= Vista editar precio =========
    public function editPrice(Service $service, ServicePrice $price)
    {
        return view('admin.services.prices-edit', compact('service', 'price'));
    }

    // ========= Actualizar precio =========
    public function updatePrice(Request $request, Service $service, ServicePrice $price)
    {
        $request->validate([
            'region'        => 'required|in:colombia,exterior',
            'client_type'   => 'required|in:natural,empresa,emprendimiento,artista,organizacion_social',
            'billing_cycle' => 'required|in:monthly,annual,one_time',
            'price'         => 'required|numeric|min:0',
            'plan'          => 'nullable|string|max:100',
        ]);

        $price->update([
            'region'        => $request->region,
            'client_type'   => $request->client_type,
            'billing_cycle' => $request->billing_cycle,
            'plan'          => $request->plan,
            'price'         => $request->price,
        ]);

        return redirect()->route('services.prices', $service->id)
            ->with('success', 'Precio actualizado correctamente.');
    }

    // ========= Eliminar precio =========
    public function destroyPrice(Service $service, ServicePrice $price)
    {
        $price->delete();

        return redirect()->route('services.prices', $service->id)
            ->with('success', 'Precio eliminado correctamente.');
    }
}
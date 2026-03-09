<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Subscription;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    // ========= Listar facturas =========
    public function index()
    {
        $invoices = Invoice::with(['user', 'service', 'agent'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.billing', compact('invoices'));
    }

    // ========= Detalle de factura =========
    public function show(Invoice $invoice)
    {
        $invoice->load(['user', 'service', 'agent']);

        $history = Invoice::with(['service'])
            ->where('user_id', $invoice->user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.billing.show', compact('invoice', 'history'));
    }

    // ========= Actualizar estado de factura =========
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'status'  => 'required|in:pendiente,pagado,aprobado',
            'paid_at' => 'nullable|date',
        ]);

        $invoice->update([
            'status'  => $request->status,
            'paid_at' => $request->status === 'pagado' ? now() : null,
        ]);

        if ($request->status === 'aprobado') {
            return redirect()->route('billing.subscription', $invoice->id)
                ->with('info', 'Factura aprobada. Configura la suscripción y la reunión con soporte.');
        }

        return redirect()->route('billing.show', $invoice->id)
            ->with('success', 'Factura actualizada correctamente.');
    }

    // ========= Vista suscripción =========
    public function subscription(Invoice $invoice)
    {
        $invoice->load(['user', 'service']);
        $services = \App\Models\Service::where('type', 'recurrente')->get();
        $supports = \App\Models\User::role('support')->get();

        return view('admin.billing.subscription', compact('invoice', 'services', 'supports'));
    }

    // ========= Guardar suscripción y activar cliente =========
    public function storeSubscription(Request $request, Invoice $invoice)
    {
        $request->validate([
            'service_id'    => 'required|exists:services,id',
            'billing_cycle' => 'required|in:monthly,annual',
            'amount'        => 'required|numeric|min:0',
            'starts_at'     => 'required|date',
            'support_id'    => 'required|exists:users,id',
            'meeting_at'    => 'required|date',
        ]);

        // Crear suscripción
        Subscription::create([
            'user_id'        => $invoice->user_id,
            'service_id'     => $request->service_id,
            'invoice_id'     => $invoice->id,
            'region'         => $invoice->region,
            'client_type'    => $invoice->client_type,
            'billing_cycle'  => $request->billing_cycle,
            'amount'         => $request->amount,
            'starts_at'      => $request->starts_at,
            'next_billing_at'=> $request->starts_at,
            'support_id'     => $request->support_id,
            'meeting_at'     => $request->meeting_at,
            'status'         => 'activa',
        ]);

        // Activar cliente
        $user = $invoice->user;
        $user->syncRoles(['customer']);

        return redirect()->route('customers')
            ->with('success', 'Cliente activado y suscripción configurada correctamente.');
    }

    // ========= Eliminar factura =========
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('billing')->with('success', 'Factura eliminada correctamente.');
    }
}
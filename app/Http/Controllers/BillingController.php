<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Contact;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    // ========= List invoices =========
    public function index(Request $request)
    {
        $search = $request->input('search');
        $user   = auth()->user();

        $contacts = Contact::whereHas('services.invoices')
            ->with(['services.invoices' => function($q) {
                $q->orderBy('created_at', 'desc');
            }, 'services.service'])
            ->when($search, function($q) use ($search) {
                $q->where(function($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                      ->orWhere('last_name', 'like', "%$search%")
                      ->orWhere('company_name', 'like', "%$search%");
                });
            })
            // billing-agent solo ve sus clientes asignados
            ->when(!$user->hasRole('administrator'), function($q) use ($user) {
                $q->where('assigned_to', $user->id);
            })
            ->orderBy('first_name')
            ->get();

        return view('admin.billing', compact('contacts', 'search'));
    }

    // ========= Invoice detail =========
    public function show(Contact $contact)
    {
        // Verificar acceso
        if (!auth()->user()->hasRole('administrator') && $contact->assigned_to !== auth()->id()) {
            abort(403);
        }

        $invoices = Invoice::with(['contactService.service', 'contactService.contact'])
            ->whereHas('contactService', fn($q) => $q->where('contact_id', $contact->id))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.billing.show', compact('contact', 'invoices'));
    }

    // ========= Update invoice status =========
    public function update(Request $request, Invoice $invoice)
    {
        // Verificar acceso al contacto de la factura
        $contact = $invoice->contactService->contact;
        if (!auth()->user()->hasRole('administrator') && $contact->assigned_to !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'status'       => 'required|in:pending,paid,approved,courtesy,cancelled',
            'payment_link' => 'nullable|url',
        ]);

        $invoice->update([
            'status'       => $request->status,
            'payment_link' => $request->payment_link,
            'paid_at'      => $request->status === 'paid' ? now() : $invoice->paid_at,
            'approved_at'  => in_array($request->status, ['approved', 'courtesy']) ? now() : $invoice->approved_at,
        ]);

        // Activate as customer when invoice is approved or courtesy
        if (in_array($request->status, ['approved', 'courtesy'])) {
            $contact->update(['status' => 'customer']);

            \App\Models\ContactLog::create([
                'contact_id' => $contact->id,
                'created_by' => auth()->id(),
                'type'       => 'status_change',
                'from'       => 'prospect',
                'to'         => 'customer',
            ]);
        }

        return redirect()->route('billing.show', $invoice->contactService->contact_id)
            ->with('success', 'Invoice updated successfully.');
    }

    // ========= Delete invoice =========
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('billing')->with('success', 'Invoice deleted successfully.');
    }

    // ========= Print / Download invoice =========
    public function invoice(Invoice $invoice)
    {
        // Verificar acceso
        $contact = $invoice->contactService->contact;
        if (!auth()->user()->hasRole('administrator') && $contact->assigned_to !== auth()->id()) {
            abort(403);
        }

        $invoice->load([
            'contactService.contact',
            'contactService.service',
            'contactService.servicePrice',
        ]);

        $history = Invoice::with(['contactService.service'])
            ->whereHas('contactService', function($q) use ($invoice) {
                $q->where('contact_id', $invoice->contactService->contact_id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.billing.invoice', compact('invoice', 'history'));
    }
}
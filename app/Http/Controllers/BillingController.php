<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Contact;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    // ========= List invoices =========
    public function index()
    {
        $invoices = Invoice::with(['contactService.contact', 'contactService.service'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.billing', compact('invoices'));
    }

    // ========= Invoice detail =========
    public function show(Invoice $invoice)
    {
        $invoice->load(['contactService.contact', 'contactService.service']);

        $history = Invoice::with(['contactService.service'])
            ->whereHas('contactService', function($q) use ($invoice) {
                $q->where('contact_id', $invoice->contactService->contact_id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.billing.show', compact('invoice', 'history'));
    }

    // ========= Update invoice status =========
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'status'       => 'required|in:pending,paid,approved,cancelled',
            'payment_link' => 'nullable|url',
        ]);

        $invoice->update([
            'status'       => $request->status,
            'payment_link' => $request->payment_link,
            'paid_at'      => $request->status === 'paid'     ? now() : $invoice->paid_at,
            'approved_at'  => $request->status === 'approved' ? now() : $invoice->approved_at,
        ]);

        // Activate as customer only when invoice is approved
        if ($request->status === 'approved') {
            $contact = $invoice->contactService->contact;
            $contact->update(['status' => 'customer']);

            \App\Models\ContactLog::create([
                'contact_id' => $contact->id,
                'created_by' => auth()->id(),
                'type'       => 'status_change',
                'from'       => 'prospect',
                'to'         => 'customer',
            ]);
        }

        return redirect()->route('billing.show', $invoice->id)
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
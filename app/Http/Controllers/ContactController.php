<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use App\Models\Service;
use App\Models\ServicePrice;
use App\Models\ContactService;
use App\Models\Invoice;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // ========= List prospects =========
    public function index()
    {
        $prospects = Contact::where('status', 'prospect')
            ->with('agent')
            ->latest()
            ->paginate(15);

        return view('admin.prospects', compact('prospects'));
    }

    // ========= List lost prospects =========
    public function lost()
    {
        $prospects = Contact::where('status', 'lost')
            ->with('agent')
            ->latest()
            ->paginate(15);

        return view('admin.prospects.lost', compact('prospects'));
    }

    // ========= Create prospect view =========
    public function create()
    {
        $agents = User::role('sales-agent')->get();

        return view('admin.prospects.create', compact('agents'));
    }

    // ========= Store prospect =========
    public function store(Request $request)
    {
        $request->validate([
            'first_name'       => 'required|string|max:255',
            'last_name'        => 'nullable|string|max:255',
            'email'            => 'nullable|email|unique:contacts,email',
            'phone'            => 'nullable|string|max:20',
            'whatsapp'         => 'nullable|string|max:20',
            'company_name'     => 'nullable|string|max:255',
            'origin'           => 'nullable|in:facebook,instagram,referral,web',
            'service_interest' => 'nullable|string|max:255',
            'assigned_to'      => 'nullable|exists:users,id',
            'status'           => 'nullable|in:prospect,customer,lost',
        ]);

        Contact::create([
            'first_name'       => $request->first_name,
            'last_name'        => $request->last_name,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'whatsapp'         => $request->whatsapp,
            'company_name'     => $request->company_name,
            'origin'           => $request->origin,
            'service_interest' => $request->service_interest,
            'assigned_to'      => $request->assigned_to ?? auth()->id(),
            'status'           => $request->status ?? 'prospect',
            'password'         => bcrypt('password'),
        ]);

        return redirect()->route('prospects.index')->with('success', 'Prospect created successfully.');
    }

    // ========= Edit prospect view =========
    public function edit(Contact $contact)
    {
        $agents     = User::role(['administrator', 'agent', 'sales-agent'])->get();
        $redirectTo = url()->previous() === route('prospects.lost') ? 'prospects.lost' : 'prospects.index';

        return view('admin.prospects.edit', compact('contact', 'agents', 'redirectTo'));
    }

    // ========= Update prospect =========
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'first_name'       => 'required|string|max:255',
            'last_name'        => 'nullable|string|max:255',
            'email'            => 'nullable|email|unique:contacts,email,' . $contact->id,
            'phone'            => 'nullable|string|max:20',
            'whatsapp'         => 'nullable|string|max:20',
            'company_name'     => 'nullable|string|max:255',
            'origin'           => 'nullable|in:facebook,instagram,referral,web',
            'service_interest' => 'nullable|string|max:255',
            'assigned_to'      => 'nullable|exists:users,id',
            'status'           => 'nullable|in:prospect,customer,lost',
        ]);

        $contact->update([
            'first_name'       => $request->first_name,
            'last_name'        => $request->last_name,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'whatsapp'         => $request->whatsapp,
            'company_name'     => $request->company_name,
            'origin'           => $request->origin,
            'service_interest' => $request->service_interest,
            'assigned_to'      => $request->assigned_to,
            'status'           => $request->status,
        ]);

        if ($request->status === 'customer') {
            return redirect()->route('prospects.close', $contact->id)
                ->with('info', 'Prospect closed. Complete the details to generate the invoice.');
        }

        $redirectTo = $request->input('redirect_to', 'prospects.index');

        return redirect()->route($redirectTo)->with('success', 'Prospect updated successfully.');
    }

    // ========= Close sale view =========
    public function close(Contact $contact)
    {
        $services = Service::all();

        return view('admin.prospects.close', compact('contact', 'services'));
    }

    // ========= Generate invoice =========
    public function generateInvoice(Request $request, Contact $contact)
    {
        $request->validate([
            'service_id'       => 'required|exists:services,id',
            'service_price_id' => 'required|exists:service_prices,id',
            'billing_cycle'    => 'required|in:monthly,annual,one_time',
            'amount'           => 'required|numeric|min:0',
        ]);

        $servicePrice = ServicePrice::findOrFail($request->service_price_id);

        // Create contracted service
        $contactService = ContactService::create([
            'contact_id'       => $contact->id,
            'service_id'       => $request->service_id,
            'service_price_id' => $request->service_price_id,
            'price'            => $servicePrice->price,
            'currency'         => $servicePrice->currency,
            'billing_cycle'    => $request->billing_cycle,
            'status'           => 'active',
            'started_at'       => now(),
        ]);

        // Create invoice
        Invoice::create([
            'contact_service_id' => $contactService->id,
            'amount'             => $request->amount,
            'created_by'         => auth()->id(),
            'status'             => 'pending',
        ]);

        // Update contact status to customer
        $contact->update(['status' => 'customer']);

        return redirect()->route('billing')->with('success', 'Invoice generated successfully.');
    }

    // ========= Contact notes =========
    public function notes(Contact $contact)
    {
        return view('admin.prospects.notes', compact('contact'));
    }

    // ========= Delete contact =========
    public function destroy(Request $request, Contact $contact)
    {
        $contact->delete();

        $redirectTo = $request->input('redirect_to', 'prospects.index');

        return redirect()->route($redirectTo)->with('success', 'Contact deleted successfully.');
    }
}
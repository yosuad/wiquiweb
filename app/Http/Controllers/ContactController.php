<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use App\Models\ContactLog;
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
        $prospects = Contact::where(function($q) {
                $q->where('status', 'prospect')
                ->orWhere(function($q2) {
                    $q2->where('status', 'customer')
                        ->doesntHave('services');
                });
            })
            ->with(['agent', 'services.invoices'])
            ->orderByRaw("FIELD(pipeline_stage, 'pending_payment', 'closing', 'new')")
            ->latest()
            ->paginate(15);

        return view('admin.prospects', compact('prospects'));
    }

    public function lost()
    {
        $prospects = Contact::where('status', 'lost')->with('agent')->latest()->paginate(15);
        return view('admin.prospects.lost', compact('prospects'));
    }

    public function customers()
    {
        $customers = Contact::where('status', 'customer')->with(['agent', 'services.service'])->latest()->paginate(15);
        return view('admin.customers', compact('customers'));
    }

    public function show(Contact $contact)
    {
        $contact->load(['agent', 'services.service', 'services.invoices']);
        $services = Service::all();
        return view('admin.customers.show', compact('contact', 'services'));
    }

    public function customerEdit(Contact $contact)
    {
        $agents = User::role(['administrator', 'agent', 'sales-agent'])->get();
        $logs   = ContactLog::where('contact_id', $contact->id)->with('author')->latest()->get();
        return view('admin.customers.edit', compact('contact', 'agents', 'logs'));
    }

    public function customerUpdate(Request $request, Contact $contact)
    {
        $request->validate([
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'nullable|string|max:255',
            'email'        => 'nullable|email|unique:contacts,email,' . $contact->id,
            'phone'        => 'nullable|string|max:20',
            'whatsapp'     => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'assigned_to'  => 'nullable|exists:users,id',
            'status'       => 'nullable|in:customer,lost',
        ]);

        if ($request->assigned_to && $request->assigned_to != $contact->assigned_to) {
            ContactLog::create(['contact_id' => $contact->id, 'created_by' => auth()->id(), 'type' => 'assignment_change', 'from' => $contact->agent?->name, 'to' => User::find($request->assigned_to)?->name]);
        }

        if ($request->status && $request->status !== $contact->status) {
            ContactLog::create(['contact_id' => $contact->id, 'created_by' => auth()->id(), 'type' => 'status_change', 'from' => $contact->status, 'to' => $request->status]);
        }

        if ($request->status === 'lost') {
            $contact->services()->where('status', 'active')->update(['status' => 'cancelled']);
            Invoice::whereHas('contactService', fn($q) => $q->where('contact_id', $contact->id))->where('status', 'pending')->update(['status' => 'cancelled']);
        }

        $contact->update([
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'email'        => $request->email,
            'phone'        => $request->phone,
            'whatsapp'     => $request->whatsapp,
            'company_name' => $request->company_name,
            'assigned_to'  => $request->assigned_to,
            'status'       => $request->status,
        ]);

        return $request->status === 'lost'
            ? redirect()->route('prospects.lost')->with('success', 'Customer marked as lost.')
            : redirect()->route('customers')->with('success', 'Customer updated successfully.');
    }

    public function create()
    {
        $agents = User::role('sales-agent')->get();
        return view('admin.prospects.create', compact('agents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'       => 'required|string|max:255',
            'last_name'        => 'nullable|string|max:255',
            'email'            => 'nullable|email|unique:contacts,email',
            'phone'            => 'nullable|string|max:20',
            'whatsapp'         => 'nullable|string|max:20',
            'company_name'     => 'nullable|string|max:255',
            'origin'           => 'nullable|in:facebook,instagram,referido,web,agente,meta',
            'client_type'      => 'nullable|in:persona_natural,empresa,emprendimiento,artista,organizacion_social',
            'service_interest' => 'nullable|string|max:255',
            'assigned_to'      => 'nullable|exists:users,id',
            'status'           => 'nullable|in:prospect,customer,lost',
        ]);

        $contact = Contact::create([
            'first_name'       => $request->first_name,
            'last_name'        => $request->last_name,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'whatsapp'         => $request->whatsapp,
            'company_name'     => $request->company_name,
            'origin'           => $request->origin,
            'client_type'      => $request->client_type,
            'service_interest' => $request->service_interest,
            'assigned_to'      => $request->assigned_to ?? auth()->id(),
            'status'           => $request->status ?? 'prospect',
            'pipeline_stage'   => 'new',
            'password'         => bcrypt('password'),
        ]);

        ContactLog::create(['contact_id' => $contact->id, 'created_by' => auth()->id(), 'type' => 'status_change', 'from' => null, 'to' => $contact->status]);

        if ($request->assigned_to) {
            ContactLog::create(['contact_id' => $contact->id, 'created_by' => auth()->id(), 'type' => 'assignment_change', 'from' => null, 'to' => User::find($request->assigned_to)?->name]);
        }

        return redirect()->route('prospects.index')->with('success', 'Prospect created successfully.');
    }

    public function edit(Contact $contact)
    {
        $agents = User::role(['administrator', 'agent', 'sales-agent'])->get();
        $from   = request()->get('from');
        $redirectTo = match($from) {
            'lost'  => 'prospects.lost',
            default => url()->previous() === route('prospects.lost') ? 'prospects.lost' : 'prospects.index',
        };
        $logs = ContactLog::where('contact_id', $contact->id)->with('author')->latest()->get();
        return view('admin.prospects.edit', compact('contact', 'agents', 'redirectTo', 'logs'));
    }

    public function update(Request $request, Contact $contact)
    {

       $request->validate([
            'first_name'       => 'required|string|max:255',
            'last_name'        => 'nullable|string|max:255',
            'email'            => 'nullable|email|unique:contacts,email,' . $contact->id,
            'phone'            => 'nullable|string|max:20',
            'whatsapp'         => 'nullable|string|max:20',
            'company_name'     => 'nullable|string|max:255',
            'origin'           => 'nullable|in:facebook,instagram,referido,web,agente,meta',
            'client_type'      => 'nullable|in:persona_natural,empresa,emprendimiento,artista,organizacion_social',
            'service_interest' => 'nullable|string|max:255',
            'assigned_to'      => 'nullable|exists:users,id',
            'status'           => 'nullable|in:prospect,customer,lost',
        ]);

        if ($request->status && $request->status !== $contact->status && $request->status !== 'customer') {
            ContactLog::create(['contact_id' => $contact->id, 'created_by' => auth()->id(), 'type' => 'status_change', 'from' => $contact->status, 'to' => $request->status]);
        }

        if ($request->assigned_to && $request->assigned_to != $contact->assigned_to) {
            ContactLog::create(['contact_id' => $contact->id, 'created_by' => auth()->id(), 'type' => 'assignment_change', 'from' => $contact->agent?->name, 'to' => User::find($request->assigned_to)?->name]);
        }

        if ($request->status === 'lost' && $contact->status === 'customer') {
            $contact->services()->where('status', 'active')->update(['status' => 'cancelled']);
            Invoice::whereHas('contactService', fn($q) => $q->where('contact_id', $contact->id))->where('status', 'pending')->update(['status' => 'cancelled']);
        }

        $contact->update([
            'first_name'       => $request->first_name,
            'last_name'        => $request->last_name,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'whatsapp'         => $request->whatsapp,
            'company_name'     => $request->company_name,
            'origin'           => $request->has('origin') ? $request->origin : $contact->origin,
            'client_type'      => $request->has('client_type') ? $request->client_type : $contact->client_type,
            'service_interest' => $request->has('service_interest') ? $request->service_interest : $contact->service_interest,
            'assigned_to'      => $request->assigned_to,
            'status'           => $request->status === 'customer' ? 'prospect' : $request->status,
            'pipeline_stage'   => $request->status === 'customer' ? 'closing' : 'new',
        ]);

        if ($request->status === 'customer') {
            return redirect()->route('prospects.close', $contact->id)->with('info', 'Prospect closed. Complete the details to generate the invoice.');
        }

        return redirect()->route($request->input('redirect_to', 'prospects.index'))->with('success', 'Prospect updated successfully.');
    }

    public function close(Contact $contact)
    {
        $services = Service::all();
        return view('admin.prospects.close', compact('contact', 'services'));
    }

   public function generateInvoice(Request $request, Contact $contact)
    {
        $request->validate([
            'service_id'       => 'required|exists:services,id',
            'service_price_id' => 'required|exists:service_prices,id',
            'billing_cycle'    => 'required|in:monthly,annual,one_time',
            'amount'           => 'required|numeric|min:0',
        ]);

        $servicePrice = ServicePrice::findOrFail($request->service_price_id);
        $existing     = ContactService::where('contact_id', $contact->id)
                            ->where('service_id', $request->service_id)
                            ->whereIn('status', ['active', 'cancelled'])
                            ->first();

        if ($existing) {
            $existing->update([
                'status'           => 'active',
                'service_price_id' => $request->service_price_id,
                'price'            => $servicePrice->price,
                'currency'         => $servicePrice->currency,
                'billing_cycle'    => $request->billing_cycle,
                'started_at'       => now(),
            ]);
            $contactService = $existing;
        } else {
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
        }

        Invoice::create([
            'contact_service_id' => $contactService->id,
            'amount'             => $request->amount,
            'created_by'         => auth()->id(),
            'status'             => 'pending',
            'period_start'       => $request->billing_cycle === 'monthly' ? now()->startOfMonth() : null,
            'period_end'         => $request->billing_cycle === 'monthly' ? now()->endOfMonth()   : null,
        ]);

        $contact->update(['pipeline_stage' => 'pending_payment']);

        return redirect()->route('billing')->with('success', 'Invoice generated successfully.');
    }

    public function notes(Contact $contact)
    {
        return view('admin.prospects.notes', compact('contact'));
    }

    public function destroy(Request $request, Contact $contact)
    {
        $contact->delete();
        return redirect()->route($request->input('redirect_to', 'prospects.index'))->with('success', 'Contact deleted successfully.');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactLog;
use App\Models\ContactService;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\ServicePrice;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Prospectos y clientes del CRM (panel admin).
 *
 * Teléfonos: antes de validar se normalizan a formato E.164 (+573205693258)
 * con Contact::normalizePhone(), para que la regla "unique" compare
 * siempre el mismo formato.
 */
class ContactController extends Controller
{
    // ========= Helper: filtrar por rol =========
    private function scopeByRole($query)
    {
        $user = auth()->user();

        if ($user->hasRole('administrator')) {
            return $query;
        }

        return $query->where('assigned_to', $user->id);
    }

    // ========= Helper: normalizar teléfonos antes de validar =========
    private function normalizePhones(Request $request): void
    {
        $request->merge([
            'whatsapp' => Contact::normalizePhone($request->input('whatsapp')),
            'phone' => Contact::normalizePhone($request->input('phone')),
        ]);
    }

    // ========= Helper: mensajes de validación de contacto =========
    private function contactMessages(): array
    {
        return [
            'whatsapp.unique' => 'Este WhatsApp ya está registrado en otro contacto.',
            'whatsapp.phone' => 'Revisa el número de WhatsApp: no parece válido para el país elegido.',
            'phone.phone' => 'Revisa el número de teléfono: no parece válido para el país elegido.',
            'email.unique' => 'Este correo ya está registrado en otro contacto.',
        ];
    }

    // ========= List prospects =========
    public function index()
    {
        $query = Contact::where(function ($q) {
            $q->where('status', 'prospect')
                ->orWhere(function ($q2) {
                    $q2->where('status', 'customer')
                        ->doesntHave('services');
                });
        })
            ->with(['agent', 'services.invoices'])
            ->orderByRaw("FIELD(pipeline_stage, 'pending_payment', 'closing', 'new')")
            ->latest();

        $prospects = $this->scopeByRole($query)->paginate(15);

        return view('admin.prospects.index', compact('prospects'));
    }

    public function lost()
    {
        $query = Contact::where('status', 'lost')->with('agent')->latest();
        $prospects = $this->scopeByRole($query)->paginate(15);

        return view('admin.prospects.lost', compact('prospects'));
    }

    public function customers()
    {
        $query = Contact::where('status', 'customer')->with(['agent', 'services.service'])->latest();
        $customers = $this->scopeByRole($query)->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(Contact $contact)
    {
        if (! auth()->user()->hasRole('administrator') && $contact->assigned_to !== auth()->id()) {
            abort(403);
        }

        $contact->load(['agent', 'services.service', 'services.invoices']);
        $services = Service::all();

        return view('admin.customers.show', compact('contact', 'services'));
    }

    public function customerEdit(Contact $contact)
    {
        if (! auth()->user()->hasRole('administrator') && $contact->assigned_to !== auth()->id()) {
            abort(403);
        }

        $agents = User::role(['administrator', 'agent', 'sales-agent'])->get();
        $logs = ContactLog::where('contact_id', $contact->id)->with('author')->latest()->get();

        return view('admin.customers.edit', compact('contact', 'agents', 'logs'));
    }

    public function customerUpdate(Request $request, Contact $contact)
    {
        if (! auth()->user()->hasRole('administrator') && $contact->assigned_to !== auth()->id()) {
            abort(403);
        }

        $this->normalizePhones($request);

        // Un cliente debe tener todos sus datos (se usan en las facturas).
        // Solo dejan de ser obligatorios si se marca como Perdido.
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required_if:status,customer|nullable|string|max:255',
            'email' => 'required|email|unique:contacts,email,'.$contact->id,
            'phone' => 'nullable|phone:INTERNATIONAL',
            'whatsapp' => 'required|phone:INTERNATIONAL|unique:contacts,whatsapp,'.$contact->id,
            'company_name' => 'required_if:status,customer|nullable|string|max:255',
            'document_type' => 'required_if:status,customer|nullable|in:national_id,tax_id,rut,foreign_id,passport,ein',
            'document_number' => 'required_if:status,customer|nullable|string|max:30',
            'address' => 'required_if:status,customer|nullable|string|max:255',
            'assigned_to' => 'required_if:status,customer|nullable|exists:users,id',
            'status' => 'nullable|in:customer,lost',
        ], $this->contactMessages() + [
            'last_name.required_if' => 'El apellido es obligatorio para un cliente.',
            'company_name.required_if' => 'La empresa es obligatoria para un cliente.',
            'document_type.required_if' => 'El tipo de documento es obligatorio para un cliente.',
            'document_number.required_if' => 'El número de documento es obligatorio para un cliente.',
            'address.required_if' => 'La dirección es obligatoria para un cliente.',
            'assigned_to.required_if' => 'Asigna un agente al cliente.',
        ]);

        if ($request->assigned_to && $request->assigned_to != $contact->assigned_to) {
            ContactLog::create(['contact_id' => $contact->id, 'created_by' => auth()->id(), 'type' => 'assignment_change', 'from' => $contact->agent?->name, 'to' => User::find($request->assigned_to)?->name]);
        }

        if ($request->status && $request->status !== $contact->status) {
            ContactLog::create(['contact_id' => $contact->id, 'created_by' => auth()->id(), 'type' => 'status_change', 'from' => $contact->status, 'to' => $request->status]);
        }

        if ($request->status === 'lost') {
            $contact->services()->where('status', 'active')->update(['status' => 'cancelled']);
            Invoice::whereHas('contactService', fn ($q) => $q->where('contact_id', $contact->id))->where('status', 'pending')->update(['status' => 'cancelled']);
        }

        $contact->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'whatsapp' => $request->whatsapp,
            'company_name' => $request->company_name,
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
            'address' => $request->address,
            'assigned_to' => $request->assigned_to,
            'status' => $request->status,
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
        $this->normalizePhones($request);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:contacts,email',
            'phone' => 'nullable|phone:INTERNATIONAL',
            'whatsapp' => 'required|phone:INTERNATIONAL|unique:contacts,whatsapp',
            'company_name' => 'nullable|string|max:255',
            'origin' => 'nullable|in:facebook,instagram,referido,web,agente,meta',
            'client_type' => 'nullable|in:persona_natural,empresa,emprendimiento,artista,organizacion_social',
            'service_interest' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'nullable|in:prospect,customer,lost',
        ], $this->contactMessages());

        $contact = Contact::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'whatsapp' => $request->whatsapp,
            'company_name' => $request->company_name,
            'origin' => $request->origin,
            'client_type' => $request->client_type,
            'service_interest' => $request->service_interest,
            'assigned_to' => $request->assigned_to ?? auth()->id(),
            'status' => $request->status ?? 'prospect',
            'pipeline_stage' => 'new',
            'password' => bcrypt('password'),
        ]);

        ContactLog::create(['contact_id' => $contact->id, 'created_by' => auth()->id(), 'type' => 'status_change', 'from' => null, 'to' => $contact->status]);

        if ($request->assigned_to) {
            ContactLog::create(['contact_id' => $contact->id, 'created_by' => auth()->id(), 'type' => 'assignment_change', 'from' => null, 'to' => User::find($request->assigned_to)?->name]);
        }

        return redirect()->route('prospects.index')->with('success', 'Prospect created successfully.');
    }

    public function edit(Contact $contact)
    {
        if (! auth()->user()->hasRole('administrator') && $contact->assigned_to !== auth()->id()) {
            abort(403);
        }

        $agents = User::role(['administrator', 'agent', 'sales-agent'])->get();
        $from = request()->get('from');
        $redirectTo = match ($from) {
            'lost' => 'prospects.lost',
            default => url()->previous() === route('prospects.lost') ? 'prospects.lost' : 'prospects.index',
        };
        $logs = ContactLog::where('contact_id', $contact->id)->with('author')->latest()->get();

        return view('admin.prospects.edit', compact('contact', 'agents', 'redirectTo', 'logs'));
    }

    public function update(Request $request, Contact $contact)
    {
        if (! auth()->user()->hasRole('administrator') && $contact->assigned_to !== auth()->id()) {
            abort(403);
        }

        $this->normalizePhones($request);

        // Al pasar a Cliente ("customer") todos los datos son obligatorios:
        // se usan para el cierre y la factura. "required_if" lo valida en el servidor.
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required_if:status,customer|nullable|string|max:255',
            'email' => 'required|email|unique:contacts,email,'.$contact->id,
            'phone' => 'nullable|phone:INTERNATIONAL',
            'whatsapp' => 'required|phone:INTERNATIONAL|unique:contacts,whatsapp,'.$contact->id,
            'company_name' => 'required_if:status,customer|nullable|string|max:255',
            'origin' => 'required_if:status,customer|nullable|in:facebook,instagram,referido,web,agente,meta',
            'client_type' => 'required_if:status,customer|nullable|in:persona_natural,empresa,emprendimiento,artista,organizacion_social',
            'service_interest' => 'required_if:status,customer|nullable|string|max:255',
            'assigned_to' => 'required_if:status,customer|nullable|exists:users,id',
            'status' => 'nullable|in:prospect,customer,lost',
        ], $this->contactMessages() + [
            'last_name.required_if' => 'El apellido es obligatorio para pasar a Cliente.',
            'company_name.required_if' => 'La empresa es obligatoria para pasar a Cliente.',
            'origin.required_if' => 'El origen es obligatorio para pasar a Cliente.',
            'client_type.required_if' => 'El tipo de cliente es obligatorio para pasar a Cliente.',
            'service_interest.required_if' => 'El servicio de interés es obligatorio para pasar a Cliente.',
            'assigned_to.required_if' => 'Asigna un agente para pasar a Cliente.',
        ]);

        if ($request->status && $request->status !== $contact->status && $request->status !== 'customer') {
            ContactLog::create(['contact_id' => $contact->id, 'created_by' => auth()->id(), 'type' => 'status_change', 'from' => $contact->status, 'to' => $request->status]);
        }

        if ($request->assigned_to && $request->assigned_to != $contact->assigned_to) {
            ContactLog::create(['contact_id' => $contact->id, 'created_by' => auth()->id(), 'type' => 'assignment_change', 'from' => $contact->agent?->name, 'to' => User::find($request->assigned_to)?->name]);
        }

        if ($request->status === 'lost' && $contact->status === 'customer') {
            $contact->services()->where('status', 'active')->update(['status' => 'cancelled']);
            Invoice::whereHas('contactService', fn ($q) => $q->where('contact_id', $contact->id))->where('status', 'pending')->update(['status' => 'cancelled']);
        }

        $contact->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'whatsapp' => $request->whatsapp,
            'company_name' => $request->company_name,
            'origin' => $request->has('origin') ? $request->origin : $contact->origin,
            'client_type' => $request->has('client_type') ? $request->client_type : $contact->client_type,
            'service_interest' => $request->has('service_interest') ? $request->service_interest : $contact->service_interest,
            'assigned_to' => $request->assigned_to,
            'status' => $request->status === 'customer' ? 'prospect' : $request->status,
            'pipeline_stage' => $request->status === 'customer' ? 'closing' : 'new',
        ]);

        if ($request->status === 'customer') {
            return redirect()->route('prospects.close', $contact->id)->with('info', 'Prospect closed. Complete the details to generate the invoice.');
        }

        return redirect()->route($request->input('redirect_to', 'prospects.index'))->with('success', 'Prospect updated successfully.');
    }

    public function close(Contact $contact)
    {
        $services = Service::all();

        $prices = ServicePrice::all()->mapWithKeys(fn ($p) => [
            $p->service_id.'_'.$p->region.'_'.$p->client_type.'_'.$p->billing_cycle => [
                'price' => $p->price,
                'id' => $p->id,
                'currency' => $p->currency,
            ],
        ]);

        return view('admin.prospects.close', compact('contact', 'services', 'prices'));
    }

    public function generateInvoice(Request $request, Contact $contact)
    {
        $request->validate([
            'document_type' => 'required|in:national_id,tax_id,rut,foreign_id,passport,ein',
            'document_number' => 'required|string|max:30',
            'address' => 'required|string|max:255',
            'region' => 'required|in:colombia,international',
            'client_type' => 'required|in:persona_natural,empresa,emprendimiento,artista,organizacion_social',
            'service_id' => 'required|exists:services,id',
            'service_price_id' => 'required|exists:service_prices,id',
            'billing_cycle' => 'required|in:monthly,annual,one_time',
            'amount' => 'required|numeric|min:0',
            'billing_month' => 'required_if:billing_cycle,monthly|nullable|date_format:Y-m',
            'description' => 'nullable|string|max:255',
        ]);

        $contact->update([
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
            'address' => $request->address,
            'region' => $request->region,
            'client_type' => $request->client_type,
        ]);

        $servicePrice = ServicePrice::findOrFail($request->service_price_id);

        $existing = ContactService::where('contact_id', $contact->id)
            ->where('service_id', $request->service_id)
            ->where('description', $request->description)
            ->where('status', 'active')
            ->first();

        $contactService = $existing ?? ContactService::create([
            'contact_id' => $contact->id,
            'service_id' => $request->service_id,
            'description' => $request->description,
            'service_price_id' => $request->service_price_id,
            'price' => $servicePrice->price,
            'currency' => $servicePrice->currency,
            'billing_cycle' => $request->billing_cycle,
            'status' => 'active',
            'started_at' => now(),
        ]);

        $periodStart = null;
        $periodEnd = null;

        if ($request->billing_cycle === 'monthly' && $request->billing_month) {
            $periodStart = \Carbon\Carbon::createFromFormat('Y-m', $request->billing_month)->startOfMonth();
            $periodEnd = \Carbon\Carbon::createFromFormat('Y-m', $request->billing_month)->endOfMonth();
        }

        Invoice::create([
            'contact_service_id' => $contactService->id,
            'amount' => $request->amount,
            'created_by' => auth()->id(),
            'status' => 'pending',
            'period_start' => $periodStart,
            'period_end' => $periodEnd,
        ]);

        $contact->update(['pipeline_stage' => 'pending_payment']);

        if (auth()->user()->can('view billing')) {
            return redirect()->route('billing')->with('success', 'Invoice generated successfully.');
        }

        return redirect()->route('customers.show', $contact->id)->with('success', 'Invoice generated successfully.');
    }

    // ========= Update contact service status =========
    public function updateServiceStatus(Request $request, ContactService $contactService)
    {
        $request->validate([
            'status' => 'required|in:active,suspended,cancelled',
        ]);

        $contactService->update(['status' => $request->status]);

        if ($request->status === 'cancelled') {
            $contactService->invoices()->where('status', 'pending')->update(['status' => 'cancelled']);
        }

        return redirect()->back()->with('success', 'Service status updated.');
    }

    public function destroy(Request $request, Contact $contact)
    {
        $contact->delete();

        return redirect()->route($request->input('redirect_to', 'prospects.index'))->with('success', 'Contact deleted successfully.');
    }

    public function updateServiceDescription(Request $request, ContactService $contactService)
    {
        $request->validate(['description' => 'nullable|string|max:255']);
        $contactService->update(['description' => $request->description]);

        return redirect()->back()->with('success', 'Description updated.');
    }
}

<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactLog;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    // ========= Formulario de contacto del sitio =========
    public function storeContact(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'whatsapp' => 'required|string|max:20',
            'email' => 'nullable|email|unique:contacts,email',
            'service_interest' => 'nullable|string|max:100',
        ]);

        $this->createLead([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'whatsapp' => $request->whatsapp,
            'email' => $request->email,
            'origin' => 'web',
            'service_interest' => $request->service_interest ?? 'pagina_web',
        ]);

        return response()->json(['success' => true]);
    }

    // ========= Formulario de campañas de Meta =========
    public function storeMeta(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'whatsapp' => 'required|string|max:30',
            'email' => 'nullable|email|unique:contacts,email',
        ]);

        $this->createLead([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'whatsapp' => $request->whatsapp,
            'email' => $request->email,
            'origin' => 'meta',
            'service_interest' => 'pagina_web',
        ]);

        return response()->json(['message' => '¡Gracias! Nos pondremos en contacto contigo pronto.']);
    }

    // ========= Helper: crea el prospecto y registra el log =========
    private function createLead(array $data): Contact
    {
        $contact = Contact::create($data + [
            'status' => 'prospect',
            'pipeline_stage' => 'new',
            'password' => bcrypt('password'),
        ]);

        ContactLog::create([
            'contact_id' => $contact->id,
            'created_by' => null,
            'type' => 'status_change',
            'from' => null,
            'to' => 'prospect',
        ]);

        return $contact;
    }
}

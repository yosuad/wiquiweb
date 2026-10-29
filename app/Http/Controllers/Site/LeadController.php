<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Formularios públicos de leads (sitio web y campañas de Meta).
 *
 * Si la persona ya existe (mismo WhatsApp o mismo correo), NO se crea un
 * duplicado: se actualiza el contacto existente y se deja constancia en su
 * historial (contact_logs), para que el equipo sepa que volvió a escribir.
 * Un lead perdido que vuelve se reactiva como prospecto nuevo.
 *
 * Política de privacidad (Ley 1581): se valida que se aceptó y se guarda la
 * fecha en privacy_accepted_at.
 *
 * Servicios: la lista única está en config/leads.php.
 *
 * Campañas de Meta: la campaña y el anuncio llegan desde el enlace del anuncio
 * (utm_campaign / utm_content). Se guardan en el contacto solo la primera vez;
 * si el lead vuelve por otro anuncio, queda registrado en su historial.
 */
class LeadController extends Controller
{
    /*
    |--------------------------------------------------------------------
    | FORMULARIOS
    |--------------------------------------------------------------------
    */

    /**
     * Formulario de contacto del sitio (página de contacto y sección del inicio).
     * El visitante elige el servicio en el selector "¿Qué necesitas?".
     */
    public function storeContact(Request $request)
    {
        $data = $this->validateLead($request, [
            'first_name' => 'required|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'service_interest' => 'nullable|string',
            'privacy' => 'accepted',                                   // ← NUEVO
        ], [
            'privacy.accepted' => 'Debes aceptar la Política de Privacidad.',   // ← NUEVO
        ]);

        $this->registerLead(array_merge($data, [
            'origin' => 'web',
            'service_interest' => $this->resolveService($data['service_interest'] ?? null),   // ← CAMBIO
        ]), 'Formulario web');

        return response()->json(['success' => true]);
    }

    /**
     * Formulario de campañas de Meta.
     * Del enlace del anuncio llegan (como campos ocultos):
     * - servicio     (?servicio=landing_page) → si no es válido, el servicio por defecto
     * - utm_campaign (nombre de la campaña)   → columna campaign
     * - utm_content  (nombre del anuncio)     → columna ad
     */
    public function storeMeta(Request $request)
    {
        $data = $this->validateLead($request, [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'service_interest' => 'nullable|string',
            'utm_campaign' => 'nullable|string|max:255',
            'utm_content' => 'nullable|string|max:255',
            'privacy' => 'accepted',
        ], [
            'privacy.accepted' => 'Debes aceptar la Política de Privacidad.',
        ]);

        $this->registerLead(array_merge($data, [
            'origin' => 'meta',
            'service_interest' => $this->resolveService($data['service_interest'] ?? null),   // ← CAMBIO
            'campaign' => $data['utm_campaign'] ?? null,
            'ad' => $data['utm_content'] ?? null,
        ]), 'Formulario Meta');

        return response()->json(['message' => '¡Gracias! Nos pondremos en contacto contigo pronto.']);
    }

    /*
    |--------------------------------------------------------------------
    | HELPERS PRIVADOS
    |--------------------------------------------------------------------
    */

    /**
     * Devuelve el servicio si está en la lista única (config/leads.php);
     * si no, el servicio por defecto. Así nunca se guarda un valor desconocido.   ← NUEVO
     */
    private function resolveService(?string $service): string
    {
        return array_key_exists((string) $service, config('leads.services'))
            ? $service
            : config('leads.default_service');
    }

    /**
     * Normaliza el WhatsApp y valida los campos comunes + los propios del formulario.
     * No se valida "unique": si ya existe, registerLead() lo maneja.
     */
    private function validateLead(Request $request, array $extraRules, array $extraMessages = []): array
    {
        $request->merge([
            'whatsapp' => Contact::normalizePhone($request->input('whatsapp')),
        ]);

        return $request->validate($extraRules + [
            'whatsapp' => 'required|phone:INTERNATIONAL',
            'email' => 'required|email|max:255',
        ], $extraMessages + [
            'whatsapp.phone' => 'Revisa tu número de WhatsApp: no parece válido para el país elegido.',
        ]);
    }

    /**
     * Crea el lead o, si ya existe, actualiza el contacto existente.
     *
     * @param  array  $data  Datos validados + origin + service_interest (+ campaign, ad)
     * @param  string  $source  Nombre del formulario para el historial
     */
    private function registerLead(array $data, string $source): Contact
    {
        return DB::transaction(function () use ($data, $source) {
            // Se busca primero por WhatsApp (dato principal) y luego por correo
            $existing = Contact::where('whatsapp', $data['whatsapp'])->first()
                ?? Contact::where('email', $data['email'])->first();

            return $existing
                ? $this->handleReturningLead($existing, $data, $source)
                : $this->createLead($data);
        });
    }

    /**
     * Lead nuevo: se crea como prospecto en la etapa "Nuevo".
     */
    private function createLead(array $data): Contact
    {
        $contact = Contact::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,
            'whatsapp' => $data['whatsapp'],
            'email' => $data['email'],
            'origin' => $data['origin'],
            'campaign' => $data['campaign'] ?? null,
            'ad' => $data['ad'] ?? null,
            'service_interest' => $data['service_interest'],
            'status' => 'prospect',
            'pipeline_stage' => 'new',
            'privacy_accepted_at' => ! empty($data['privacy']) ? now() : null,
            'password' => bcrypt('password'),
        ]);

        $this->log($contact, 'status_change', null, 'prospect');

        return $contact;
    }

    /**
     * Lead que vuelve: no se duplica, se deja constancia en el historial.
     * La campaña y el anuncio originales NO se cambian; los nuevos quedan en el historial.
     */
    private function handleReturningLead(Contact $contact, array $data, string $source): Contact
    {
        // 1. Constancia de que volvió a escribir (con la campaña y el anuncio, si vino por uno)
        $this->log($contact, 'returned', null, $this->describeSource($source, $data));

        // 1b. Escribió otro nombre: se registran los dos (el equipo decide cuál es el correcto).
        //     Antes se completa el apellido si estaba vacío, para no marcar como
        //     "otro nombre" a quien solo agregó el apellido que le faltaba.
        $previousName = trim($contact->first_name.' '.$contact->last_name);

        if (! $contact->last_name && ! empty($data['last_name'])) {
            $contact->last_name = $data['last_name'];
        }

        $newName = trim($data['first_name'].' '.($data['last_name'] ?? ''));
        $currentName = trim($contact->first_name.' '.$contact->last_name);

        if (strcasecmp($currentName, $newName) !== 0) {
            $this->log($contact, 'name_mismatch', $previousName, $newName);
        }

        // 2. Escribió otro WhatsApp: se registran los dos (el equipo decide cuál es el correcto)
        if ($contact->whatsapp !== $data['whatsapp']) {
            $this->log($contact, 'whatsapp_mismatch', $contact->whatsapp, $data['whatsapp']);
        }

        // 3. Escribió otro correo: igual, se registran los dos
        if (strcasecmp($contact->email, $data['email']) !== 0) {
            $this->log($contact, 'email_mismatch', $contact->email, $data['email']);
        }

        // 4. Estaba perdido: se reactiva como prospecto nuevo
        if ($contact->status === 'lost') {
            $this->log($contact, 'status_change', 'lost', 'prospect');

            $contact->status = 'prospect';
            $contact->pipeline_stage = 'new';
        }

        // 5. Pidió otro servicio: queda en el historial (el anterior → el nuevo)
        //    y el campo se actualiza al último que pidió
        if (! empty($data['service_interest']) && $contact->service_interest !== $data['service_interest']) {
            $this->log($contact, 'service_change', $contact->service_interest, $data['service_interest']);
            $contact->service_interest = $data['service_interest'];
        }

        // 6. Volvió a aceptar la política: se renueva la fecha de aceptación
        if (! empty($data['privacy'])) {
            $contact->privacy_accepted_at = now();
        }

        // 7. Si no tenía campaña (ej: llegó por la web), se guarda la del anuncio actual
        if (! $contact->campaign && ! empty($data['campaign'])) {
            $contact->campaign = $data['campaign'];
            $contact->ad = $data['ad'] ?? null;
        }

        $contact->save();

        return $contact;
    }

    /**
     * Texto para el historial: el formulario y, si vino por un anuncio,
     * la campaña y el anuncio. Ej: "Formulario Meta · Landing-MX-Nov · Video-testimonio"
     */
    private function describeSource(string $source, array $data): string
    {
        return collect([$source, $data['campaign'] ?? null, $data['ad'] ?? null])
            ->filter()
            ->implode(' · ');
    }

    /**
     * Registra un evento en el historial del contacto.
     * created_by = null porque lo genera el sistema (no un usuario del panel).
     */
    private function log(Contact $contact, string $type, ?string $from, ?string $to): void
    {
        ContactLog::create([
            'contact_id' => $contact->id,
            'created_by' => null,
            'type' => $type,
            'from' => $from,
            'to' => $to,
        ]);
    }
}

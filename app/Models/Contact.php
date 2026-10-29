<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Propaganistas\LaravelPhone\PhoneNumber;

/**
 * Contacto del CRM: prospecto, cliente o lead perdido.
 *
 * Teléfonos (whatsapp, phone):
 * - Se guardan SIEMPRE en formato internacional E.164: +573205693258
 *   (un solo formato para todos los países → la regla "unique" es confiable).
 * - Se muestran con formato legible usando los accessors:
 *   $contact->whatsapp_formatted → +57 320 5693258
 *   $contact->whatsapp_link      → https://wa.me/573205693258
 *
 * Campañas de Meta (campaign, ad): campaña y anuncio que trajeron al lead
 * la primera vez (utm_campaign / utm_content del enlace del anuncio).
 */
class Contact extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * País que se asume cuando un número llega sin indicativo (+).
     * El 70% de los leads son de Colombia y suelen escribir solo 3205693258.
     */
    public const DEFAULT_PHONE_COUNTRY = 'CO';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'whatsapp',
        'phone',
        'company_name',
        'address',
        'document_type',
        'document_number',
        'region',
        'client_type',
        'origin',
        'campaign',          // ← NUEVO
        'ad',                // ← NUEVO
        'service_interest',
        'assigned_to',
        'status',
        'pipeline_stage',
        'is_active',
        'privacy_accepted_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'privacy_accepted_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // ========= Teléfonos: normalización =========

    /**
     * Convierte cualquier forma de escribir un número al formato E.164.
     *
     * - Con indicativo (+52 33 1234 5678)  → +523312345678
     * - Sin indicativo (3205693258)         → se asume Colombia → +573205693258
     * - Si no se puede interpretar, se devuelve tal cual (la validación
     *   del controlador se encarga de rechazarlo).
     *
     * Se usa en dos momentos:
     * 1. En los controladores, ANTES de validar, para que "unique"
     *    compare el número ya normalizado.
     * 2. En los mutadores, al guardar, como garantía final.
     */
    public static function normalizePhone(?string $value): ?string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        try {
            $phone = str_starts_with($value, '+')
                ? new PhoneNumber($value)
                : new PhoneNumber($value, self::DEFAULT_PHONE_COUNTRY);

            return $phone->formatE164();
        } catch (\Throwable) {
            return $value;
        }
    }

    // ========= Mutators =========

    public function setWhatsappAttribute($value)
    {
        $this->attributes['whatsapp'] = static::normalizePhone($value);
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = static::normalizePhone($value);
    }

    // ========= Accessors (solo para mostrar) =========

    /**
     * WhatsApp con formato legible: +57 320 5693258
     */
    public function getWhatsappFormattedAttribute(): ?string
    {
        return static::formatForDisplay($this->whatsapp);
    }

    /**
     * Teléfono con formato legible.
     */
    public function getPhoneFormattedAttribute(): ?string
    {
        return static::formatForDisplay($this->phone);
    }

    /**
     * Enlace para abrir el chat de WhatsApp: https://wa.me/573205693258
     */
    public function getWhatsappLinkAttribute(): ?string
    {
        return $this->whatsapp
            ? 'https://wa.me/'.ltrim($this->whatsapp, '+')
            : null;
    }

    /**
     * Da formato internacional legible a un número E.164.
     * Si el número no se puede interpretar, se muestra tal cual.
     * Público: también lo usa el componente <x-contact-history>.
     */
    public static function formatForDisplay(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        try {
            return (new PhoneNumber($value))->formatInternational();
        } catch (\Throwable) {
            return $value;
        }
    }

    // ========= Relationships =========

    public function agent()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function services()
    {
        return $this->hasMany(ContactService::class);
    }

    public function notes()
    {
        return $this->hasMany(ContactNote::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Contact extends Authenticatable
{
    use HasFactory, Notifiable;

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
        'assigned_to',
        'status',
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
            'email_verified_at'   => 'datetime',
            'privacy_accepted_at' => 'datetime',
            'password'            => 'hashed',
            'is_active'           => 'boolean',
        ];
    }

    // ========= Mutators =========

    public function setWhatsappAttribute($value)
    {
        if ($value) {
            $digits = preg_replace('/\D/', '', $value);
            if (strlen($digits) === 10) {
                $this->attributes['whatsapp'] = '+57 ' . substr($digits, 0, 3) . ' ' . substr($digits, 3, 3) . ' ' . substr($digits, 6, 2) . ' ' . substr($digits, 8, 2);
            } elseif (strlen($digits) === 12 && str_starts_with($digits, '57')) {
                $digits = substr($digits, 2);
                $this->attributes['whatsapp'] = '+57 ' . substr($digits, 0, 3) . ' ' . substr($digits, 3, 3) . ' ' . substr($digits, 6, 2) . ' ' . substr($digits, 8, 2);
            } else {
                $this->attributes['whatsapp'] = $value;
            }
        } else {
            $this->attributes['whatsapp'] = null;
        }
    }

    public function setPhoneAttribute($value)
    {
        if ($value) {
            $digits = preg_replace('/\D/', '', $value);
            if (strlen($digits) === 10) {
                $this->attributes['phone'] = '+57 ' . substr($digits, 0, 3) . ' ' . substr($digits, 3, 3) . ' ' . substr($digits, 6, 2) . ' ' . substr($digits, 8, 2);
            } elseif (strlen($digits) === 12 && str_starts_with($digits, '57')) {
                $digits = substr($digits, 2);
                $this->attributes['phone'] = '+57 ' . substr($digits, 0, 3) . ' ' . substr($digits, 3, 3) . ' ' . substr($digits, 6, 2) . ' ' . substr($digits, 8, 2);
            } else {
                $this->attributes['phone'] = $value;
            }
        } else {
            $this->attributes['phone'] = null;
        }
    }

    // ========= Relationships =========

    // Assigned agent
    public function agent()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Contracted services
    public function services()
    {
        return $this->hasMany(ContactService::class);
    }

    // Notes
    public function notes()
    {
        return $this->hasMany(ContactNote::class);
    }
}
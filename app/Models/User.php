<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'status',
        'phone',
        'whatsapp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
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

    // Contacts assigned to this agent
    public function assignedContacts()
    {
        return $this->hasMany(Contact::class, 'assigned_to');
    }

    // Invoices created by this agent
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'created_by');
    }

    // Notes written by this agent
    public function contactNotes()
    {
        return $this->hasMany(ContactNote::class, 'created_by');
    }
}
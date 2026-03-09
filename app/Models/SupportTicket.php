<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = [
        'contact_service_id',
        'assigned_to',
        'subject',
        'description',
        'status',
        'priority',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'resolved_at' => 'datetime',
        ];
    }

    public function contactService()
    {
        return $this->belongsTo(ContactService::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
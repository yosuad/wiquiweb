<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = [
        'contact_id',
        'created_by',
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

    // Client this ticket belongs to
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    // Agent who created the ticket
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Agent assigned to the ticket
    public function agent()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
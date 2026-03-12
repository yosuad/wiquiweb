<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicketNote extends Model
{
    protected $fillable = [
        'ticket_id',
        'created_by',
        'note',
    ];

    public function ticket()
    {
        return $this->belongsTo(SupportTicket::class, 'ticket_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
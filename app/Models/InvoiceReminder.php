<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceReminder extends Model
{
    protected $fillable = [
        'invoice_id',
        'reminder_number',
        'sent_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'sent_at'         => 'datetime',
            'reminder_number' => 'integer',
        ];
    }

    // ========= Relationships =========

    // Invoice this reminder belongs to
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
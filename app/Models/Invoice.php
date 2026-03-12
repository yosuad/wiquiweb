<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'contact_service_id',
        'amount',
        'period_start',
        'period_end',
        'payment_link',
        'created_by',
        'status',
        'paid_at',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'amount'      => 'decimal:2',
            'paid_at'     => 'datetime',
            'approved_at' => 'datetime',
        ];
    }

    // ========= Relationships =========

    // Contracted service this invoice belongs to
    public function contactService()
    {
        return $this->belongsTo(ContactService::class);
    }

    // Agent who created the invoice
    public function agent()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Overdue reminders
    public function reminders()
    {
        return $this->hasMany(InvoiceReminder::class);
    }
}
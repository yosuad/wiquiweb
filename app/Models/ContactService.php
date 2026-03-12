<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactService extends Model
{
    
    protected $fillable = [
    'contact_id',
    'service_id',
    'description',
    'service_price_id',
    'price',
    'currency',
    'billing_cycle',
    'status',
    'started_at',
    'ends_at',
    ];

    protected function casts(): array
    {
        return [
            'price'      => 'decimal:2',
            'started_at' => 'date',
            'ends_at'    => 'date',
        ];
    }

    // ========= Relationships =========

    // Contact who contracted the service
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    // Contracted service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Catalog price used at time of contract
    public function servicePrice()
    {
        return $this->belongsTo(ServicePrice::class);
    }

    // Invoices for this contracted service
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
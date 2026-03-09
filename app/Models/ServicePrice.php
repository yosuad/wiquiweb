<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePrice extends Model
{
    protected $fillable = [
        'service_id',
        'region',
        'client_type',
        'type',
        'billing_cycle',
        'plan',
        'price',
        'currency',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    // ========= Relationships =========

    // Service this price belongs to
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Contracted services using this price
    public function contactServices()
    {
        return $this->hasMany(ContactService::class);
    }

    // ========= Accessors =========

    // Price converted to COP
    public function getPriceCopAttribute()
    {
        return $this->price * config('settings.usd_to_cop');
    }
}
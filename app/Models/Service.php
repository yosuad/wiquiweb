<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    // ========= Relationships =========

    // Service prices
    public function prices()
    {
        return $this->hasMany(ServicePrice::class);
    }

    // Contacts who have this service contracted
    public function contacts()
    {
        return $this->hasMany(ContactService::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactNote extends Model
{
    protected $fillable = [
        'contact_id',
        'created_by',
        'note',
    ];

    // ========= Relationships =========

    // Contact this note belongs to
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    // Agent who wrote the note
    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
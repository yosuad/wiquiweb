<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactLog extends Model
{
    protected $fillable = ['contact_id', 'created_by', 'type', 'from', 'to'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
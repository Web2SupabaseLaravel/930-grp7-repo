<?php

namespace App\Models;

class Patient extends User
{
    protected static function booted()
    {
        static::addGlobalScope('patient', function ($query) {
            $query->where('role_id', 1); 
        });
    }
}

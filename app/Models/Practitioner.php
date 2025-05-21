<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Practitioner extends Model
{
    protected $fillable = [
        'name',
        'specialization',
        'qualifications',
        'phone',
        'email',
        'working_hours',
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'practitioner_service');
    }
}

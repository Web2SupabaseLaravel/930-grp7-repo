<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    

    protected $fillable = [
        'user_id',
        'appointment_at',
        'service',
        'status',
        'practitioner_id',
        'service_id',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

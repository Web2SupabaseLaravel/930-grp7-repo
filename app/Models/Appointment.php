<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'practitioner_id',
        'service_id',
        'appointment_date',
        'appointment_time',
        'status',
    ];

   public function patient()
{
    return $this->belongsTo(User::class, 'patient_id');
}


    public function practitioner()
    {
        return $this->belongsTo(Practitioner::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    
}

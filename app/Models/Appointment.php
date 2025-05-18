<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
 protected $table = 'appointments';

    protected $primaryKey = 'appointment_id';

    protected $fillable = [
        'patiant_id',
        'practitioner_id',
        'service_id',
        'appointment_date',
        'appointment_time',
        'status',
    ];
public function patient()
{
    return $this->belongsTo(User::class, 'patiant_id');
}


    public function practitioner()
    {
        return $this->belongsTo(Practitioner::class, 'practitioner_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }





}

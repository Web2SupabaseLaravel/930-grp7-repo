<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;

class Practitioner extends Model
{
    use HasFactory;

    protected $primaryKey = 'Practitioners_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'specialization',
        'qualifications',
        'contact',
        'working_hours',
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'practitioner_service', 'Practitioners_id', 'service_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Practitioner extends Model
{
    use HasFactory;

    protected $table = 'practitioners';
    protected $fillable = ['user_id','specialization','qualifications','contact','working_hours'];

    public function services()
    {
        return $this->belongsToMany(
            Service::class,
            'practitioner_service',
            'practitioner_id',
            'service_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

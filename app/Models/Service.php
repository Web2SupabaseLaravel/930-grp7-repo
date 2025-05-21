<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'duration_minutes',
        'price',
    ];

    public function practitioners()
    {
        return $this->belongsToMany(Practitioner::class, 'practitioner_service');
    }
}

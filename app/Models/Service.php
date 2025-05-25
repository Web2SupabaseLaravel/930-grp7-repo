<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'description', 'name', 'duration_minutes', 'price'
    ];
    public function practitioners()
{
    return $this->belongsToMany(Practitioner::class);
}

}


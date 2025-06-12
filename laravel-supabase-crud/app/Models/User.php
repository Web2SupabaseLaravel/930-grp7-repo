<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;


    public $timestamps = false; // إذا ما عندك created_at و updated_at في Supabase

protected $fillable = [
    'name', 'email', 'password','age', 'role_id'
];


public function role(): BelongsTo
{
    return $this->belongsTo(Role::class, 'role_id', 'id');
}

}

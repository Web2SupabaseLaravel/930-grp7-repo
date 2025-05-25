<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Role;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory;  use Notifiable;
      use HasRoles;


protected $primaryKey = 'id';
public $incrementing = true;
protected $keyType = 'int';

    protected $fillable = [
        'name', 'email', 'password', 'role_id',
        
    ];

    
    public function role()
    {
        return $this->belongsTo(Role::class);

    }

    public function practitioner()
{
    return $this->hasOne(\App\Models\Practitioner::class);
}

public function isAdmin(): bool
{
    return $this->role_id === Role::ADMIN;
}

public function isPractitioner(): bool
{
    return $this->role_id === Role::PRACTITIONER;
}

public function isPatient(): bool
{
    return $this->role_id === Role::PATIENT;
}

}


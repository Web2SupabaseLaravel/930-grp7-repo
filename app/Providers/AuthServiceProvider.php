<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
    ];


public function boot()
{
    Gate::define('manage-practitioners', function (User $user) {
        return $user->role === 'admin';
    });
}
}

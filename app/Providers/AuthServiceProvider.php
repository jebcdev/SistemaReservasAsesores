<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // Mapea tus modelos a sus políticas aquí
    ];

    public function boot()
    {
        $this->registerPolicies();

        // Define tus gates aquí
        Gate::define('role_admin', function ($user) {
            return $user->role_id === 1;
        });

        Gate::define('role_consultant', function ($user) {
            return $user->role_id === 2;
        });

        Gate::define('role_user', function ($user) {
            return $user->role_id === 3;
        });
    }
}

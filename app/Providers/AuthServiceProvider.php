<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
        Passport::tokensExpireIn(now()->addSecond(60));

        Passport::tokensCan([
            'create-post' => 'Crear un post',
            'read-post' => 'Leer un post',
            'update-post' => 'Actualizar un post',
            'delete-post' => 'Borrar un post'
        ]);

        Passport::setDefaultScope([
            'read-post'
        ]);
    }
}

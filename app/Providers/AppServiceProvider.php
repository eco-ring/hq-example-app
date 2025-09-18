<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Passport::authorizationView(
            fn ($params) => Inertia::render('auth/oauth/Authorize', [
                'request' => $params['request'],
                'authToken' => $params['authToken'],
                'client' => $params['client'],
                'user' => $params['user'],
                'scopes' => $params['scopes'],
            ])
        );

        Passport::tokensCan([
            'user:read' => 'Retrieve the user info',
        ]);
    }
}

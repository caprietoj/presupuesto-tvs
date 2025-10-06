<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Auth\IntranetUserProvider;
use App\Auth\IntranetUser;

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
        // Registrar el provider personalizado de intranet
        Auth::provider('intranet', function ($app, array $config) {
            return new IntranetUserProvider(
                $app['hash'],
                IntranetUser::class
            );
        });
    }
}

<?php
namespace Thecodework\TwoFactorAuthentication;

use Illuminate\Support\ServiceProvider;

class TwoFactorAuthenticationServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/routes.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', '2fa');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // $this->publishes([
        //      __DIR__.'/../database/migrations/' => database_path('migrations')
        // ], 'migrations');
    }
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // register
    }
}

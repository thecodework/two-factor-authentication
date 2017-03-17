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
        // date_default_timezone_set('Asia/Kolkata');
        $this->loadRoutesFrom(__DIR__ . '/routes/routes.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', '2fa');

        // $this->publishes([
        //     __DIR__.'/resources/views' => base_path('resources/views/2fa')
        // ]);
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

    /**
     * returns view file paths
     *
     * @return array|string[]
     */
    public function views()
    {
        return [
            __DIR__ . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views',
        ];
    }
}

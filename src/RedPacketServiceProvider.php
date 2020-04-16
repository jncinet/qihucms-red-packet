<?php

namespace Qihucms\RedPacket;

use Illuminate\Support\ServiceProvider;

class RedPacketServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes.php');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'red_packet');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/red_packet'),
        ]);

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'red_packet');
    }
}

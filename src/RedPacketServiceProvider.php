<?php

namespace Qihucms\RedPacket;

use Illuminate\Support\ServiceProvider;
use Qihucms\RedPacket\Commands\InstallCommand;
use Qihucms\RedPacket\Commands\UninstallCommand;
use Qihucms\RedPacket\Commands\UpdateRedPacketCommand;
use Qihucms\RedPacket\Commands\UpgradeCommand;

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
        if (file_exists(app_path('Plugins/RedPacketPlugin.php'))) {
            if ($this->app->runningInConsole()) {
                $this->commands([
                    InstallCommand::class,
                    UpgradeCommand::class,
                    UninstallCommand::class,
                    // 定时更新红包状态
                    UpdateRedPacketCommand::class,
                ]);
            }

            $this->loadRoutesFrom(__DIR__ . '/../routes.php');

            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

            $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'red_packet');

            $this->publishes([
                __DIR__ . '/../resources/lang' => resource_path('lang/vendor/red_packet'),
            ]);

            $this->loadViewsFrom(__DIR__ . '/../resources/views', 'red_packet');
        }
    }
}

<?php

namespace MalikAbdullah1318\LaravelInstaller;

use Illuminate\Support\ServiceProvider;
use MalikAbdullah1318\LaravelInstaller\Installer;

class InstallerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/installer.php',
            'installer'
        );

        $this->app->singleton(
            Installer::class,
            function () {
                return new Installer();
            }
        );
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/installer.php' =>
                config_path('installer.php'),
        ], 'installer-config');

        $this->loadRoutesFrom(
            __DIR__ . '/../routes/web.php'
        );

        $this->loadViewsFrom(
            __DIR__ . '/../resources/views',
            'installer'
        );
    }
}
<?php

namespace MalikAbdullah1318\LaravelInstaller;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use MalikAbdullah1318\LaravelInstaller\Http\Middleware\InstallerNotInstalled;

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
            fn () => new Installer()
        );
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/installer.php' =>
                config_path('installer.php'),
        ], 'installer-config');

        $this->loadViewsFrom(
            __DIR__ . '/../resources/views',
            'installer'
        );

        Route::aliasMiddleware(
            'installer.not.installed',
            InstallerNotInstalled::class
        );

        $this->loadRoutesFrom(
            __DIR__ . '/../routes/installer.php'
        );
    }
}
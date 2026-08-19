<?php

namespace MalikAbdullah1318\LaravelInstaller;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use MalikAbdullah1318\LaravelInstaller\Http\Middleware\InstallerNotInstalled;
use MalikAbdullah1318\LaravelInstaller\Environment\EnvironmentManager;
use MalikAbdullah1318\LaravelInstaller\InstallerState;
use MalikAbdullah1318\LaravelInstaller\Http\Middleware\RedirectToInstaller;

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

        $this->app->singleton(
            EnvironmentManager::class,
            fn () => new EnvironmentManager()
        );

        $this->app->singleton(
            InstallerState::class,
            fn () => new InstallerState()
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

        $this->app['router']->pushMiddlewareToGroup(
            RedirectToInstaller::class
        );

        $this->loadRoutesFrom(
            __DIR__ . '/../routes/installer.php'
        );
    }
}
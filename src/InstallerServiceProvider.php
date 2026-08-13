<?php

namespace MalikAbdullah1318\LaravelInstaller;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use MalikAbdullah1318\LaravelInstaller\Http\Middleware\InstallerNotInstalled;
use MalikAbdullah1318\LaravelInstaller\Environment\EnvironmentManager;

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
    }

    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Installer Session
        |--------------------------------------------------------------------------
        */

        Config::set('session.driver', 'file');

        /*
        |--------------------------------------------------------------------------
        | Temporary Application Key
        |--------------------------------------------------------------------------
        |
        | The installer runs before the application's .env exists.
        | Laravel's cookie/session system still requires an encryption key.
        |
        */

        if (! config('app.key')) {
            Config::set(
                'app.key',
                'base64:' . base64_encode(
                    random_bytes(32)
                )
            );
        }

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
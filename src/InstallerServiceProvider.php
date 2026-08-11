<?php

namespace MalikAbdullah1318\LaravelInstaller;

use Illuminate\Support\ServiceProvider;
use MalikAbdullah1318\LaravelInstaller\Installer;
use MalikAbdullah1318\LaravelInstaller\Requirements\ComposerRequirements;
use MalikAbdullah1318\LaravelInstaller\Requirements\RequirementsChecker;

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
        $this->app->singleton(
            RequirementsChecker::class,
            function () {
                return (new RequirementsChecker())
                    ->add(new ComposerRequirements());
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
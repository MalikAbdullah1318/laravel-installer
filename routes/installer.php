<?php

use Illuminate\Support\Facades\Route;
use MalikAbdullah1318\LaravelInstaller\Http\Controllers\InstallerController;

Route::middleware(['web', 'installer.not.installed'])
    ->prefix('install')
    ->name('installer.')
    ->group(function () {

        Route::get('/', [
            InstallerController::class,
            'welcome',
        ])->name('welcome');

        Route::get('/requirements', [
            InstallerController::class,
            'requirements',
        ])->name('requirements');

        /*
        |--------------------------------------------------------------------------
        | Database
        |--------------------------------------------------------------------------
        */

        Route::get('/database', [
            InstallerController::class,
            'database',
        ])->name('database');

        Route::post('/database/test', [
            InstallerController::class,
            'testDatabase',
        ])->name('database.test');

        Route::post('/database/configure', [
            InstallerController::class,
            'configureDatabase',
        ])->name('database.configure');

        /*
        |--------------------------------------------------------------------------
        | Migrations
        |--------------------------------------------------------------------------
        */

        Route::get('/migrations', [
            InstallerController::class,
            'migrations',
        ])->name('migrations');

        Route::post('/migrations/run', [
            InstallerController::class,
            'runMigrations',
        ])->name('migrations.run');

    });
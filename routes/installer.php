<?php

use Illuminate\Support\Facades\Route;
use MalikAbdullah1318\LaravelInstaller\Http\Controllers\InstallerController;

Route::middleware('installer.not.installed')
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

    });
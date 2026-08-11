<?php

use Illuminate\Support\Facades\Route;
use MalikAbdullah1318\LaravelInstaller\Installer;

Route::prefix(config('installer.route'))->group(function () {

    Route::get('/', function () {

        if (app(Installer::class)->isInstalled()) {
            abort(404);
        }

        return view('installer::installer.welcome');

    })->name('installer.welcome');

});
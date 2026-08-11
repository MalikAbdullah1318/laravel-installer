<?php

use Illuminate\Support\Facades\Route;
use MalikAbdullah1318\LaravelInstaller\Installer;

Route::middleware(function ($request, $next) {

    if (app(Installer::class)->isInstalled()) {
        abort(404);
    }

    return $next($request);

})->prefix(config('installer.route'))->group(function () {

    Route::get('/', function () {
        return view('installer::installer.welcome');
    })->name('installer.welcome');

});
<?php

namespace MalikAbdullah1318\LaravelInstaller\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use MalikAbdullah1318\LaravelInstaller\Installer;
use Symfony\Component\HttpFoundation\Response;

class RedirectToInstaller
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        $installer = app(Installer::class);

        if (! $installer->isInstalled()) {

            /*
            |--------------------------------------------------------------------------
            | Don't redirect installer pages
            |--------------------------------------------------------------------------
            */

            if (
                $request->is('install') ||
                $request->is('install/*')
            ) {
                return $next($request);
            }

            return redirect()->route(
                'installer.welcome'
            );
        }

        return $next($request);
    }
}
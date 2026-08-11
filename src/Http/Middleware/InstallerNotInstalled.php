<?php

namespace MalikAbdullah1318\LaravelInstaller\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use MalikAbdullah1318\LaravelInstaller\Installer;
use Symfony\Component\HttpFoundation\Response;

class InstallerNotInstalled
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $installer = app(Installer::class);

        if ($installer->isInstalled()) {
            return redirect('/');
        }

        return $next($request);
    }
}
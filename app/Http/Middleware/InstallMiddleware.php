<?php

namespace App\Http\Middleware;

use App\Http\Controllers\InstallController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InstallMiddleware
{
    /**
     * Handle an incoming request.
     *
     * If the app is NOT installed, redirect to the installer.
     * If the app IS installed and user is trying to access installer, redirect away.
     */
    public function handle(Request $request, Closure $next, string $guard = 'install'): Response
    {
        $isInstalled = InstallController::isInstalled();
        $isInstallRoute = $request->is('install') || $request->is('install/*');

        // Guard: redirect TO installer (used on normal routes)
        if ($guard === 'require' && !$isInstalled && !$isInstallRoute) {
            return redirect()->route('install.requirements');
        }

        // Guard: redirect AWAY from installer (used on install routes)
        if ($guard === 'install' && $isInstalled && $isInstallRoute) {
            return redirect('/');
        }

        return $next($request);
    }
}

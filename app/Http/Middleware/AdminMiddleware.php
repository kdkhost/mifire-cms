<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Ensures the user is authenticated and has admin privileges.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check() || ! Auth::user()->isAdmin()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Acesso não autorizado.'], 403);
            }

            return redirect()->route('login')
                ->with('error', 'Acesso restrito a administradores.');
        }

        if (! Auth::user()->is_active) {
            Auth::logout();
            $request->session()->invalidate();

            return redirect()->route('login')
                ->with('error', 'Sua conta está desativada.');
        }

        return $next($request);
    }
}

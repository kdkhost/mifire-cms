<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se o modo de manutenção está ativo no banco de dados
        $isMaintenance = Setting::get('maintenance_mode', false);

        if ($isMaintenance) {
            // Se for uma rota de admin, migração ou o usuário for admin logado, permite o acesso
            if (str_contains($_SERVER['REQUEST_URI'], 'force-migrate') || $request->is('admin*') || $request->is('admin/login') || (auth()->check() && auth()->user()->is_admin)) {
                return $next($request);
            }

            // Caso contrário, exibe a página de manutenção
            return response()->view('site.maintenance', [
                'settings' => Setting::pluck('value', 'key')
            ], 503);
        }

        return $next($request);
    }
}

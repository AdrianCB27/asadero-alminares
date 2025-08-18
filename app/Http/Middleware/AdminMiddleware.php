<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->admin) {
            // Si no está logueado o no es admin, lo echamos fuera
            return redirect()->route('tienda')->with('error', 'No tienes permiso para acceder.');
        }

        return $next($request);
    }
}

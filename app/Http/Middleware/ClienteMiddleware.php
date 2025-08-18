<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ClienteMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->admin) {
            return redirect()->route('admin.dashboard')->with('error', 'Esa página es solo para clientes.');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
        public function handle(Request $request, Closure $next): Response
    {
    // Si l'utilisateur n'est pas connecté OU n'est pas admin
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403, "Accès interdit : Vous n'êtes pas administrateur.");
    }

    return $next($request);
    }
}

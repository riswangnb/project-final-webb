<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->isAdmin()) {
            // Jika user adalah admin, redirect ke admin dashboard
            return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak. Silakan gunakan dashboard admin.');
        }

        return $next($request);
    }
}

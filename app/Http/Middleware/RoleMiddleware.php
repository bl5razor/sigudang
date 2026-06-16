<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {

        // cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // cek apakah role user sesuai
        if (!in_array(Auth::user()->role, $roles)) {

            // jika tidak sesuai, redirect ke dashboard
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
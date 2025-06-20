<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika belum login, redirect ke login
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Silakan login untuk mengakses panel admin');
        }

        // Jika bukan admin, tampilkan 404
        if (Auth::user()->role !== 'admin') {
            return response()->view('404', [], 404);
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleProtection
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$allowedRoles): Response
    {
        // Jika belum login dan role guest tidak diizinkan
        if (!Auth::check() && !in_array('guest', $allowedRoles)) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Jika sudah login, cek role
        if (Auth::check()) {
            $userRole = Auth::user()->role;
            
            // Jika role tidak sesuai yang diizinkan
            if (!in_array($userRole, $allowedRoles)) {
                // Log unauthorized access attempt
                Log::warning('Unauthorized access attempt', [
                    'user_id' => Auth::user()->user_id,
                    'user_role' => $userRole,
                    'allowed_roles' => $allowedRoles,
                    'requested_url' => $request->url()
                ]);
                
                return response()->view('404', ['userRole' => $userRole], 404);
            }
        }

        return $next($request);
    }
}
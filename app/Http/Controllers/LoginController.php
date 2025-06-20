<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login()
    {
        // Jika sudah login, redirect ke home sesuai role
        if (Auth::check()) {
            return $this->redirectToUserHome();
        }
        
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $role = $user->role;

            // Debug log
            Log::info('User logged in', [
                'user_id' => $user->user_id,
                'email' => $user->email,
                'role' => $role,
                'name' => $user->name
            ]);

            return $this->redirectToUserHome();
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    private function redirectToUserHome()
    {
        $user = Auth::user();
        $role = $user->role;

        // Log untuk debugging
        Log::info('Redirecting user based on role', [
            'user_id' => $user->user_id,
            'email' => $user->email,
            'role' => $role,
            'name' => $user->name
        ]);

        switch ($role) {
            case 'ekspor':
                return redirect()->route('ekspor');
            case 'impor':
                return redirect()->route('importir');
            case 'admin':
                // Redirect ke Filament admin panel
                return redirect('/admin1');
            default:
                // Logout user dengan role yang tidak valid
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Role tidak valid: ' . $role . '. Silakan hubungi administrator.',
                ]);
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        
        // Log logout activity
        if ($user) {
            Log::info('User logged out', [
                'user_id' => $user->user_id,
                'email' => $user->email,
                'role' => $user->role,
                'name' => $user->name
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}
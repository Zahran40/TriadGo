<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login()
    {
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

            if ($role === 'ekspor') {
                return redirect()->route('ekspor');
            } elseif ($role === 'impor') {
                return redirect()->route('importir');
            } elseif ($role === 'admin') {
                // Redirect admin langsung ke panel admin
                return redirect('/admin1');
            } else {
                // Jika role tidak dikenali, logout dan redirect ke login
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Role tidak valid: ' . $role,
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }
}
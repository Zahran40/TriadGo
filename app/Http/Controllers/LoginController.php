<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

            $role = Auth::user()->role;

            if ($role === 'ekspor') {
                return redirect()->route('ekspor');
            } elseif ($role === 'impor') {
                return redirect()->route('importir');
            } elseif ($role === 'admin') {
                return redirect('/admin1');
            } else {
                return redirect('/');
            }
        }

        return back()->withErrors([
            'email' => 'Wrong email/password.',
        ]);
    }
}
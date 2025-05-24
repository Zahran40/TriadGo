<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('homepage');
    }

    public function userprofile()
    {
        return view('user-profile');
    }

    public function edit()
    {
        return view('profile-edit');
    }

    public function signup()
    {
        return view('sign-up');
    }

    public function login()
    {
        return view('login');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users|regex:/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/',
            'country' => 'nullable|string|max:255',
            'phone' => 'nullable|string|min:10|max:15|regex:/^[0-9]+$/',
            'password' => 'required|string|min:8|confirmed|',
            'role' => 'required|string|in:ekspor,impor',
        ]);

        // Create a new user instance
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->country = $request->country;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;

        // Save the user to the database
        $user->save();

        return redirect()->route('login')->with('success', 'User registered successfully.');
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
            } else {
                return redirect('/');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);


    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil keluar.');

    }

    //Halaman untuk Importir
    public function homeimportir()
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Anda harus login terlebih dahulu.');
        }
        if (Auth::user()->role === 'ekspor') {
            return redirect()->route('ekspor')->with('error', 'Anda tidak bisa mengakses halaman importir.');
        }
        if (Auth::user()->role !== 'impor') {
            return redirect('/')->with('error', 'Anda tidak bisa mengakses halaman tersebut.');
        }
        return view('importir');
    }



    //Halaman untuk Eksportir
    public function homeeksportir()
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Anda harus login terlebih dahulu.');
        }
        if (Auth::user()->role === 'impor') {
            return redirect()->route('importir')->with('error', 'Anda tidak bisa mengakses halaman eksportir.');
        }
        if (Auth::user()->role !== 'ekspor') {
            return redirect('/')->with('error', 'Anda tidak bisa mengakses halaman tersebut.');
        }
        return view('eksportir');
    }

    public function formeksportir()
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Anda harus login terlebih dahulu.');
        }
        if (Auth::user()->role === 'impor') {
            return redirect()->route('importir')->with('error', 'Anda tidak bisa mengakses halaman eksportir.');
        }
        if (Auth::user()->role !== 'ekspor') {
            return redirect('/')->with('error', 'Anda tidak bisa mengakses halaman tersebut.');
        }
        return view('formeksportir');


    }

}
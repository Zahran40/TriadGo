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

    public function invoice()
    {
        return view('invoice');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users|regex:/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/',
            'country' => 'nullable|string|max:255',
            // Validasi phone: format E.164 (nomor internasional dengan tanda plus, 8-20 digit)
            'phone' => ['required', 'regex:/^\\+[1-9][0-9]{7,19}$/'],
            'password' => 'required|string|min:8|confirmed|',
            'role' => 'required|string|in:ekspor,impor',
        ]);

        // Create a new user instance
       $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'country' => $request->country,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'role' => $request->role,
       ]);
        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->country = $request->country;
        // $user->phone = $request->phone;
        // $user->password = bcrypt($request->password);
        // $user->role = $request->role;

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


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have successfully logged out.');

    }

    //Halaman untuk Importir
    public function homeimportir()
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Please login first.');
        }
        if (Auth::user()->role === 'ekspor') {
            return redirect()->route('ekspor')->with('error', 'Unable to access importir page.');
        }
        if (Auth::user()->role !== 'impor') {
            return redirect('/')->with('error', 'Access denied.');
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
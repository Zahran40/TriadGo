<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function signup()
    {
        return view('sign-up');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users|regex:/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/',
            'country' => 'required|string|max:255',
            'phone' => 'required|string|min:10|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:ekspor,impor',
        ], [
            'phone.min' => 'Nomor telepon minimal 10 digit.',
            'phone.max' => 'Nomor telepon maksimal 20 digit.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'country' => $request->country,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        // Setelah registrasi berhasil, arahkan ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login dengan akun Anda.');
    }
}
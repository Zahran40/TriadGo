<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function signup()
    {
        return view('sign-up');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users|regex:/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/',
                'country' => 'required|string|max:255',
                'phone' => 'required|string|min:10|max:20|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|string|in:ekspor,impor',
            ], [
                'name.required' => 'Nama wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar.',
                'email.regex' => 'Format email tidak valid.',
                'country.required' => 'Negara wajib dipilih.',
                'phone.required' => 'Nomor telepon wajib diisi.',
                'phone.min' => 'Nomor telepon minimal 10 digit.',
                'phone.max' => 'Nomor telepon maksimal 20 digit.',
                'phone.unique' => 'Nomor telepon sudah terdaftar.',
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'role.required' => 'Role wajib dipilih.',
                'role.in' => 'Role tidak valid.',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'country' => $request->country,
                'phone' => $request->phone,
                'password' => $request->password,
                'role' => $request->role,
            ]);

            // Check if request expects JSON (AJAX request)
            if ($request->expectsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => true,
                    'message' => 'Pendaftaran berhasil! Silakan login dengan akun Anda.',
                    'redirect' => route('login')
                ]);
            }

            // Setelah registrasi berhasil, arahkan ke halaman login dengan pesan sukses
            return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login dengan akun Anda.');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            if ($request->expectsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }
            
            throw $e; // Re-throw for normal form submission
            
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            
            if ($request->expectsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.'
                ], 500);
            }
            
            return back()->withInput()->with('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
        }
    }
}
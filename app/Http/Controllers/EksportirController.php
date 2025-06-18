<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EksportirController extends Controller
{
    public function homeeksportir()
    {
        // Middleware sudah handle auth & role check
        // Jika sampai sini, berarti user sudah pasti role 'ekspor'
        return view('eksportir');
    }

    public function formeksportir()
    {
        // Middleware sudah handle auth & role check
        // Jika sampai sini, berarti user sudah pasti role 'ekspor'
        return view('formeksportir');
    }

    // public function myproduct()
    // {
    //     return view('myproduct');
    // }

    // public function detailproducteksportir()
    // {
    //     // Middleware sudah handle auth & role check
    //     // Jika sampai sini, berarti user sudah pasti role 'ekspor'
    //     return view('detailproductekspor');
    // }

    public function response()
    {
        // Middleware sudah handle auth & role check
        // Jika sampai sini, berarti user sudah pasti role 'ekspor'
        return view('response');
    }
}
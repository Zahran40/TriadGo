<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class EksportirController extends Controller
{
    public function homeeksportir()
{
    if (!Auth::check()) {
        return view('404');
    }
    
    if (Auth::user()->role !== 'ekspor') {
        return view('404');
    }
    return view('eksportir');
}

public function formeksportir()
{
    if (!Auth::check()) {
        return view('404');
    }

    
    if (Auth::user()->role !== 'ekspor') {
        return view('404');
    }
    return view('formeksportir');
}
}

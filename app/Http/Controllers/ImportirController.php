<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ImportirController extends Controller
{
    public function homeimportir()
    {
        // Middleware sudah handle auth & role check
        
        return view('importir');
    }
}
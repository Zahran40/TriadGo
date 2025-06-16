<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class ImportirController extends Controller
{
    public function homeimportir()
{
    if (!Auth::check()) {
        return view('404');
    }
   
    if (Auth::user()->role !== 'impor') {
        return view('404');
    }
    return view('importir');
}

 public function formImportir()
    {
        return view('formImportir');
    }
}

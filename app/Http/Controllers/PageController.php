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
         if (!Auth::check()) {
        return view('404');
    }
        
        return view('user-profile');
    }


    public function catalog()
    {
        if (!Auth::check()) {
            return view('404');
        }
        return view('catalog'); 
    }
   
    

    public function invoice()
    {
        return view('invoice');
    }
    

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have successfully logged out.');

    }

    



}
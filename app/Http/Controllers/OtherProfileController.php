<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtherProfileController extends Controller
{
    public function show($userId)
    {
        // Prevent users from viewing their own profile through this route
        if (Auth::id() == $userId) {
            return redirect()->route('user.profile');
        }

        // Get the user with their products if they're an exporter
        $user = User::findOrFail($userId);
        
        $products = collect(); // Empty collection by default
        
        // If user is an exporter, get their approved products
        if ($user->role === 'ekspor') {
            $products = Product::where('user_id', $userId)
                              ->where('status', 'approved')
                              ->orderBy('created_at', 'desc')
                              ->get();
        }

        return view('other-profile', compact('user', 'products'));
    }
}
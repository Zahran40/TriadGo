<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\CheckoutOrder;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Access denied. Admin only.');
        }

        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_orders' => CheckoutOrder::count(),
            'pending_orders' => CheckoutOrder::where('status', 'pending')->count(),
            'completed_orders' => CheckoutOrder::where('status', 'paid')->count(),
            'total_revenue' => CheckoutOrder::where('status', 'paid')->sum('total_amount')
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Access denied. Admin only.');
        }

        $users = User::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function products()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Access denied. Admin only.');
        }

        $products = Product::with('user')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.products', compact('products'));
    }

    public function orders()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Access denied. Admin only.');
        }

        $orders = CheckoutOrder::with('user')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.orders', compact('orders'));
    }
}

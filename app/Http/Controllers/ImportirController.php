<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\CheckoutOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ImportirController extends Controller
{
    public function homeimportir()
    {
        // Get top 6 approved products for carousel
        $topProducts = Product::with('user')
                             ->where('status', 'approved')
                             ->orderBy('created_at', 'desc')
                             ->limit(6)
                             ->get();

        return view('importir', compact('topProducts'));
    }

    public function catalog(Request $request)
    {
        // Start query for approved products with user info
        $query = Product::with('user')->where('status', 'approved');

        // Apply search filter if provided
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('product_name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('product_description', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('category', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('country_of_origin', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Apply country filter if provided
        if ($request->filled('country')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('country', $request->country);
            });
        }

        $products = $query->orderBy('created_at', 'desc')->get();

        // Get countries sesuai dengan form eksportir
        $countries = collect([
            'Indonesia', 'Malaysia', 'Thailand', 'Singapore', 'Vietnam', 
            'Philippines', 'Brunei', 'Cambodia', 'Laos', 'Myanmar',
            'China', 'India', 'Others'
        ])->sort();

        return view('catalog', compact('products', 'countries'));
    }

    public function formimportir()
    {
        return view('formImportir');
    }

    public function showProductDetail($id)
{
    // Contoh: ambil data produk dari model Product
    $product = Product::findOrFail($id);
    return view('detailproductimportir', compact('product'));
}

    public function myOrders()
    {
        // Get orders for current logged in user
        $orders = CheckoutOrder::where('user_id', Auth::id())
                              ->orderBy('created_at', 'desc')
                              ->get();

        return view('my-orders', compact('orders'));
    }
}

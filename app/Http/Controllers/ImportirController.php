<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\CheckoutOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Exception;

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

    public function requestimportir()
    {
        return view('requestimportir');
    }

    public function detail($id)
    {
        // Debug: Check if we reach this method
        error_log("Detail method called with ID: " . $id);
        
        try {
            // Cari produk berdasarkan product_id dengan relasi user
            $product = Product::with('user','comments.user')
                             ->where('product_id', $id)
                             ->where('status', 'approved') // Hanya produk yang approved
                             ->first(); // Using first() instead of firstOrFail() for debugging

            error_log("Product query result: " . ($product ? "Found: " . $product->product_name : "Not found"));

            if (!$product) {
                error_log("Product with ID $id not found or not approved");
                abort(404, 'Product not found or not approved');
            }

            // Pastikan user yang mengakses adalah importir
            if (!Auth::check()) {
                error_log("User not authenticated");
                return redirect()->route('login');
            }

            if (Auth::user()->role !== 'impor') {
                error_log("User role is: " . Auth::user()->role . " (expected: impor)");
                abort(403, 'Access denied. This page is for importers only.');
            }

            error_log("About to return view with product: " . $product->product_name);
            
            return view('detailproductimportir', compact('product'));
            
        } catch (Exception $e) {
            error_log("Exception in detail method: " . $e->getMessage());
            throw $e;
        }
    }

    public function showProductDetail($id)
    {
        // Alias untuk fungsi detail yang lebih konsisten
        return $this->detail($id);
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

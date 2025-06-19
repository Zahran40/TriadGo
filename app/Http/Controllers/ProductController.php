<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Store product dengan auto-generated SKU
     */
    public function myProducts()
    {
        // Get products for current logged in user
        $products = Product::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('myproduct', compact('products'));
    }

    public function show($id)
    {
        $product = Product::with('user')
            ->where('product_id', $id)
            ->where('user_id', Auth::id()) // Only show own products
            ->first();

        if (!$product) {
            return redirect()->route('myproduct')->with('error', 'Product not found or unauthorized access');
        }

        return view('detailproductekspor', compact('product'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'required|string',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0.01',
            'stock_quantity' => 'required|integer|min:1',
            // REMOVE product_sku validation - akan auto generate
            'weight' => 'required|numeric|min:0.1',
            'country_of_origin' => 'required|string',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        try {
            $productData = $request->except(['product_sku']); // Remove manual SKU
            $productData['user_id'] = Auth::id();

            // Handle image upload
            if ($request->hasFile('product_image')) {
                $image = $request->file('product_image');
                $imageName = 'product_' . Auth::id() . '_' . time() . '.' . $image->extension();

                $uploadPath = public_path('uploads/products');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $image->move($uploadPath, $imageName);
                $productData['product_image'] = 'uploads/products/' . $imageName;
            }

            // SKU akan auto-generate di Model boot method
            $product = Product::create($productData);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully!',
                'product_sku' => $product->product_sku, // Return generated SKU
                'status' => $product->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create product: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::where('product_id', $id)
                ->where('user_id', Auth::id())
                ->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found or unauthorized'
                ], 404);
            }

            // Delete image file if exists
            if ($product->product_image && file_exists(public_path($product->product_image))) {
                unlink(public_path($product->product_image));
            }

            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product: ' . $e->getMessage()
            ], 500);
        }
    }



    public function updateField(Request $request, $id)
    {
        try {
            $product = Product::where('product_id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $field = $request->input('field');
            $value = $request->input('value');

            // Validate fields
            $allowedFields = ['productName', 'price', 'stock', 'weight'];
            if (!in_array($field, $allowedFields)) {
                return response()->json(['success' => false, 'message' => 'Invalid field']);
            }

            // Map field names to database columns
            $fieldMap = [
                'productName' => 'product_name',
                'price' => 'price',
                'stock' => 'stock_quantity',
                'weight' => 'weight'
            ];

            $dbField = $fieldMap[$field];

            // Validate values
            if ($field === 'productName') {
                if (strlen($value) < 3) {
                    return response()->json(['success' => false, 'message' => 'Product name must be at least 3 characters']);
                }
            } else {
                if (!is_numeric($value) || $value < 0) {
                    return response()->json(['success' => false, 'message' => ucfirst($field) . ' must be a positive number']);
                }
            }

            // Update the product
            $product->update([$dbField => $value]);

            return response()->json([
                'success' => true,
                'message' => ucfirst($field) . ' updated successfully',
                'value' => $value
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update: ' . $e->getMessage()
            ], 500);
        }
    }
}

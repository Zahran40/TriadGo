<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * @method User getCurrentUser()
 */

class CartController extends Controller
{
    // Helper method to get current authenticated user
    private function getCurrentUser()
    {
        if (!Auth::check()) {
            return null;
        }
        
        return Auth::user();
    }

    // Get cart items for the authenticated user
    public function index()
    {
        try {
            $user = $this->getCurrentUser();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $cartItems = $user->getCartWithProducts();
            
            return response()->json([
                'success' => true,
                'cart_items' => $cartItems,
                'cart_count' => $user->getCartCount(),
                'cart_total' => $user->getCartTotal()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading cart: ' . $e->getMessage()
            ], 500);
        }
    }

    // Add item to cart
    public function add(Request $request)
    {
        try {
            $user = $this->getCurrentUser();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $request->validate([
                'product_id' => 'required|exists:products,product_id',
                'quantity' => 'required|integer|min:1|max:10'
            ]);

            $product = Product::where('product_id', $request->product_id)->first();
            
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            // Check stock
            if ($request->quantity > $product->stock_quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock. Available: ' . $product->stock_quantity
                ], 400);
            }

            DB::beginTransaction();
            try {
                // Check if item already exists in cart
                $cartItem = Cart::where('user_id', $user->user_id)
                               ->where('product_id', $request->product_id)
                               ->first();

                if ($cartItem) {
                    // Update quantity if item exists
                    $newQuantity = $cartItem->quantity + $request->quantity;
                    
                    if ($newQuantity > $product->stock_quantity) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Total quantity would exceed stock. Available: ' . $product->stock_quantity
                        ], 400);
                    }
                    
                    $cartItem->update(['quantity' => $newQuantity]);
                } else {
                    // Create new cart item
                    $cartItem = Cart::create([
                        'user_id' => $user->user_id,
                        'product_id' => $request->product_id,
                        'quantity' => $request->quantity,
                        'price' => $product->price
                    ]);
                }

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Item added to cart successfully',
                    'cart_item' => $cartItem->load('product'),
                    'cart_count' => $user->getCartCount()
                ]);

            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add item to cart: ' . $e->getMessage()
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // Update cart item quantity
    public function update(Request $request, $id)
    {
        try {
            $user = $this->getCurrentUser();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $request->validate([
                'quantity' => 'required|integer|min:1|max:10'
            ]);

            $cartItem = Cart::where('id', $id)
                           ->where('user_id', $user->user_id)
                           ->first();

            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart item not found'
                ], 404);
            }

            // Check stock
            if ($request->quantity > $cartItem->product->stock_quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock. Available: ' . $cartItem->product->stock_quantity
                ], 400);
            }

            $cartItem->update(['quantity' => $request->quantity]);

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully',
                'cart_item' => $cartItem->load('product'),
                'cart_count' => $user->getCartCount(),
                'cart_total' => $user->getCartTotal()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating cart: ' . $e->getMessage()
            ], 500);
        }
    }

    // Remove item from cart
    public function remove($id)
    {
        try {
            $user = $this->getCurrentUser();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $cartItem = Cart::where('id', $id)
                           ->where('user_id', $user->user_id)
                           ->first();

            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart item not found'
                ], 404);
            }

            $cartItem->delete();

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
                'cart_count' => $user->getCartCount(),
                'cart_total' => $user->getCartTotal()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error removing item: ' . $e->getMessage()
            ], 500);
        }
    }

    // Clear all cart items
    public function clear()
    {
        try {
            $user = $this->getCurrentUser();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            Cart::where('user_id', $user->user_id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error clearing cart: ' . $e->getMessage()
            ], 500);
        }
    }

    // Get cart count
    public function count()
    {
        try {
            $user = $this->getCurrentUser();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            return response()->json([
                'success' => true,
                'count' => $user->getCartCount()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting cart count: ' . $e->getMessage()
            ], 500);
        }
    }
}

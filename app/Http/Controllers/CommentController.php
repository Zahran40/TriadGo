<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    // ❌ Remove constructor middleware
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Store komentar baru
     */
    public function store(Request $request, $productId)
    {
        // ✅ Manual auth check
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login first.'
            ], 401);
        }

        $request->validate([
            'comment_text' => 'required|min:10|max:1000',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        // Cek apakah produk exists dan approved
        $product = Product::where('product_id', $productId)
                         ->where('status', 'approved')
                         ->firstOrFail();

        // Pastikan user adalah importir
        if (Auth::user()->role !== 'impor') {
            return response()->json([
                'success' => false,
                'message' => 'Only importers can comment on products.'
            ], 403);
        }

        // Cek apakah user sudah pernah komentar produk ini
        $existingComment = Comment::where('product_id', $productId)
                                 ->where('user_id', Auth::id())
                                 ->first();

        if ($existingComment) {
            return response()->json([
                'success' => false,
                'message' => 'You have already commented on this product.'
            ], 400);
        }

        // Buat komentar baru
        $comment = Comment::create([
            'product_id' => $productId,
            'user_id' => Auth::id(),
            'comment_text' => $request->comment_text,
            'rating' => $request->rating
        ]);

        // Load relasi untuk response
        $comment->load('user');

        return response()->json([
            'success' => true,
            'message' => 'Comment added successfully!',
            'comment' => [
                'id' => $comment->comment_id,
                'user_name' => $comment->user->name,
                'user_country' => $comment->user->country,
                'comment_text' => $comment->comment_text,
                'rating' => $comment->rating,
                'stars' => $comment->stars,
                'created_at' => $comment->created_at->format('M d, Y \a\t H:i'),
                'user_profile_picture' => $comment->user->profile_picture
            ]
        ]);
    }

    /**
     * Get komentar untuk produk tertentu
     */
    public function getComments($productId)
    {
        $comments = Comment::with('user')
                          ->forProduct($productId)
                          ->orderBy('created_at', 'desc')
                          ->get();

        return response()->json([
            'success' => true,
            'comments' => $comments->map(function ($comment) {
                return [
                    'id' => $comment->comment_id,
                    'user_name' => $comment->user->name,
                    'user_country' => $comment->user->country,
                    'comment_text' => $comment->comment_text,
                    'rating' => $comment->rating,
                    'stars' => $comment->stars,
                    'created_at' => $comment->created_at->format('M d, Y \a\t H:i'),
                    'user_profile_picture' => $comment->user->profile_picture
                ];
            })
        ]);
    }

    /**
     * Response page - Tampilkan semua komentar untuk produk milik user
     */
    
/**
 * ✅ RESPONSE PAGE - UPDATED WITH BETTER DATA STRUCTURE
 */
public function response()
{
    try {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        if (Auth::user()->role !== 'ekspor') {
            abort(403, 'Access denied. This page is for exporters only.');
        }

        // Get semua komentar untuk produk-produk milik user ini dengan join manual
        $comments = Comment::join('products', 'comments.product_id', '=', 'products.product_id')
                          ->join('users', 'comments.user_id', '=', 'users.user_id')
                          ->where('products.user_id', Auth::id())
                          ->select(
                              'comments.*',
                              'products.product_name',
                              'products.product_id as product_id', // ✅ ADD THIS
                              'users.name as user_name',
                              'users.country as user_country',
                              'users.profile_picture as user_profile_picture',
                              'users.user_id as reviewer_user_id' // ✅ ADD THIS
                          )
                          ->orderBy('comments.created_at', 'desc')
                          ->get();

        // ✅ ENHANCE COMMENTS DATA
        $comments = $comments->map(function ($comment) {
            // Create user object for easier access
            $comment->user = (object) [
                'user_id' => $comment->reviewer_user_id,
                'name' => $comment->user_name,
                'country' => $comment->user_country,
                'profile_picture' => $comment->user_profile_picture
            ];
            
            return $comment;
        });

        // Group komentar berdasarkan produk
        $commentsByProduct = $comments->groupBy('product_name');

        Log::info('Response page loaded with ' . $comments->count() . ' comments');

        return view('response', compact('comments', 'commentsByProduct'));

    } catch (\Exception $e) {
        Log::error('Response page error: ' . $e->getMessage());
        
        $comments = collect([]);
        $commentsByProduct = collect([]);
        
        return view('response', compact('comments', 'commentsByProduct'))
            ->with('error', 'Error loading comments data.');
    }
}
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class EksportirController extends Controller
{
    public function homeeksportir()
    {
        try {
            // ✅ GET RECENT COMMENTS FOR THIS EXPORTER'S PRODUCTS
            $recentComments = Comment::join('products', 'comments.product_id', '=', 'products.product_id')
                                    ->join('users', 'comments.user_id', '=', 'users.user_id')
                                    ->where('products.user_id', Auth::id())
                                    ->select(
                                        'comments.*',
                                        'products.product_name',
                                        'products.product_image',
                                        'products.product_id as product_id',
                                        'users.name as reviewer_name',
                                        'users.country as reviewer_country',
                                        'users.profile_picture as reviewer_profile_picture',
                                        'users.user_id as reviewer_user_id'
                                    )
                                    ->orderBy('comments.created_at', 'desc')
                                    ->limit(3)
                                    ->get();

            // ✅ ENHANCE COMMENTS DATA
            $recentComments = $recentComments->map(function ($comment) {
                $comment->user = (object) [
                    'user_id' => $comment->reviewer_user_id,
                    'name' => $comment->reviewer_name,
                    'country' => $comment->reviewer_country ?? 'Unknown',
                    'profile_picture' => $comment->reviewer_profile_picture
                ];
                
                $comment->product = (object) [
                    'product_id' => $comment->product_id,
                    'product_name' => $comment->product_name,
                    'product_image' => $comment->product_image
                ];
                
                return $comment;
            });

            // ✅ STATISTICS
            $totalComments = Comment::join('products', 'comments.product_id', '=', 'products.product_id')
                                   ->where('products.user_id', Auth::id())
                                   ->count();

            $averageRating = Comment::join('products', 'comments.product_id', '=', 'products.product_id')
                                   ->where('products.user_id', Auth::id())
                                   ->avg('comments.rating');

            $totalProducts = Product::where('user_id', Auth::id())
                                   ->where('status', 'approved')
                                   ->count();

            return view('eksportir', compact(
                'recentComments',
                'totalComments',
                'averageRating',
                'totalProducts'
            ));

        } catch (\Exception $e) {
            Log::error('Eksportir home error: ' . $e->getMessage());
            
            return view('eksportir', [
                'recentComments' => collect([]),
                'totalComments' => 0,
                'averageRating' => 0,
                'totalProducts' => 0
            ]);
        }
    }

    public function formeksportir()
    {
        return view('formeksportir');
    }

    // public function response()
    // {
    //     return view('response');
    // }


    // public function detailproducteksportir()
    // {
    //     // Middleware sudah handle auth & role check
    //     // Jika sampai sini, berarti user sudah pasti role 'ekspor'
    //     return view('detailproductekspor');
    // }

   

    public function requesteksportir()
    {
        $user = Auth::user();
        
        $pendingRequests = ProductRequest::where('status', ProductRequest::STATUS_PENDING)
                                ->with('importir')
                                ->orderBy('created_at', 'desc')
                                ->get();

        $myRequests = ProductRequest::where('eksportir_user_id', $user->user_id)
                            ->with(['importir', 'product'])
                            ->orderBy('updated_at', 'desc')
                            ->get();

        Log::info('EksportirController::requesteksportir', [
            'user_id' => $user->user_id,
            'pending_count' => $pendingRequests->count(),
            'my_requests_count' => $myRequests->count()
        ]);

        return view('requesteksportir', compact('pendingRequests', 'myRequests'));
    }

}
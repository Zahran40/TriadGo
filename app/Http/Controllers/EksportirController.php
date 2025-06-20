<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Tracking;
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
        return view('requesteksportir');
    }
 
   public function transactions()
    {
        $transactions = Transaction::where('user_id', Auth::id())->get();
        return view('transactions', compact('transactions'));
    }

//     public function store(Request $request)
//     {
//     // Validasi data $request di sini

//     Transaction::create([
//         'nomor_resi' => $request->nomor_resi,
//         'negara_tujuan' => $request->negara_tujuan,
//         'status' => $request->status,
//         'estimasi_sampai' => $request->estimasi_sampai,
//         'user_id' => Auth::id(), // <-- ini penting
//     ]);

//     // Redirect atau response setelah simpan
//     return redirect()->route('transactions')->with('success', 'Transaksi berhasil ditambahkan!');
//     }

        public function trackingDetail($id)
        {
            $transaction = Transaction::findOrFail($id);
            return view('trackingekspor', compact('transaction'));
        }

        public function updateTracking(Request $request, $id)
        {
            $transaction = Transaction::findOrFail($id);
            $transaction->update($request->only(['status', 'estimasi_sampai']));
            return redirect()->route('trackingekspor.detail', $id)->with('success', 'Data berhasil diupdate!');
        }


       public function showTracking($id)
        {
            $transaction = Transaction::findOrFail($id);
            $trackings = Tracking::where('transaction_id', $id)->orderBy('created_at')->get();
            return view('trackingekspor', compact('transaction', 'trackings'));
        }

        public function addTracking(Request $request, $transaction_id)
        {
            $request->validate(['status' => 'required|string|max:255']);
            Tracking::create([
                'transaction_id' => $transaction_id,
                'status' => $request->status,
            ]);
            return redirect()->route('trackingekspor.detail', $transaction_id)->with('success', 'Tracking berhasil ditambahkan!');
        }

}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as HttpRequest;
use App\Models\ProductRequest;
use App\Models\Notification;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RequestController extends Controller
{
    /**
     * Show request form for importir
     */
    public function importirRequestForm()
    {
        if (!Auth::check() || Auth::user()->role !== 'importir') {
            return redirect()->route('login')->with('error', 'Access denied. Importir only.');
        }

        $user = Auth::user();
        $pendingRequests = ProductRequest::where('importir_user_id', $user->id)
                                ->where('status', ProductRequest::STATUS_PENDING)
                                ->orderBy('created_at', 'desc')
                                ->get();

        $approvedRequests = ProductRequest::where('importir_user_id', $user->id)
                                ->where('status', ProductRequest::STATUS_APPROVED)
                                ->with(['eksportir', 'product'])
                                ->orderBy('approved_at', 'desc')
                                ->get();

        return view('requestimportir', compact('pendingRequests', 'approvedRequests'));
    }
    
    /**
     * Store new request from importir - PERBAIKI METHOD INI
     */
    public function storeImportirRequest(HttpRequest $request)
    {
        try {
            // PERBAIKI: Role check untuk importir, bukan eksportir
            if (!Auth::check() || Auth::user()->role !== 'importir') {
                return response()->json(['error' => 'Access denied. Importir only.'], 403);
            }

            // PERBAIKI: Validasi input request
            $request->validate([
                'request_text' => 'required|string|max:1000'
            ]);

            // PERBAIKI: Create new ProductRequest
            $productRequest = ProductRequest::create([
                'importir_user_id' => Auth::id(),
                'request_text' => $request->request_text,
                'status' => ProductRequest::STATUS_PENDING
            ]);

            Log::info('New product request created', [
                'request_id' => $productRequest->id,
                'importir_user_id' => Auth::id(),
                'request_text' => $request->request_text
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Request sent!'
            ]);

        } catch (\Exception $e) {
            Log::error('Error creating product request: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occured: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show requests for eksportir
     */
    public function eksportirRequestList()
    {
        if (!Auth::check() || Auth::user()->role !== 'eksportir') {
            return redirect()->route('login')->with('error', 'Access denied. Eksporter only.');
        }

        $pendingRequests = ProductRequest::where('status', ProductRequest::STATUS_PENDING)
                                ->with('importir')
                                ->orderBy('created_at', 'desc')
                                ->get();

        $myRequests = ProductRequest::where('eksportir_user_id', Auth::id())
                            ->with(['importir', 'product'])
                            ->orderBy('updated_at', 'desc')
                            ->get();

        return view('requesteksportir', compact('pendingRequests', 'myRequests'));
    }
    
    /**
     * Approve request by eksportir - PERBAIKI METHOD INI
     */
    public function approveRequest(HttpRequest $request, $requestId)
    {
        if (!Auth::check() || Auth::user()->role !== 'eksportir') {
            return response()->json(['error' => 'Access denied'], 403);
        }

        // PERBAIKI: Gunakan ProductRequest, bukan Request
        $productRequest = ProductRequest::findOrFail($requestId);
        
        // PERBAIKI: Gunakan ProductRequest constants
        if ($productRequest->status !== ProductRequest::STATUS_PENDING) {
            return response()->json(['error' => 'Request already processed'], 400);
        }

        $productId = $request->input('product_id');

        // PERBAIKI: Gunakan Auth::id(), bukan Auth::user()->user_id
        $productRequest->approve(Auth::id(), $productId);

        // Create notification for importir
        Notification::createNotification(
            $productRequest->importir_user_id,
            'Request Disetujui',
            'Permintaan produk Anda telah disetujui oleh eksportir ' . Auth::user()->name,
            Notification::TYPE_REQUEST_APPROVED,
            $productRequest->id,
            'product_request'
        );

        Log::info('Product request approved', [
            'request_id' => $requestId,
            'eksportir_user_id' => Auth::id(), // PERBAIKI
            'importir_user_id' => $productRequest->importir_user_id
        ]);

        return response()->json(['success' => true, 'message' => 'Request berhasil disetujui']);
    }

    /**
     * Reject request by eksportir - PERBAIKI METHOD INI
     */
    public function rejectRequest($requestId)
    {
        if (!Auth::check() || Auth::user()->role !== 'eksportir') {
            return response()->json(['error' => 'Access denied'], 403);
        }

        // PERBAIKI: Gunakan ProductRequest, bukan Request
        $productRequest = ProductRequest::findOrFail($requestId);
        
        // PERBAIKI: Gunakan ProductRequest constants
        if ($productRequest->status !== ProductRequest::STATUS_PENDING) {
            return response()->json(['error' => 'Request already processed'], 400);
        }

        // PERBAIKI: Gunakan Auth::id(), bukan Auth::user()->user_id
        $productRequest->reject(Auth::id());

        // Create notification for importir
        Notification::createNotification(
            $productRequest->importir_user_id,
            'Request Ditolak',
            'Permintaan produk Anda telah ditolak oleh eksportir ' . Auth::user()->name,
            Notification::TYPE_REQUEST_REJECTED,
            $productRequest->id,
            'product_request'
        );

        Log::info('Product request rejected', [
            'request_id' => $requestId,
            'eksportir_user_id' => Auth::id(), // PERBAIKI
            'importir_user_id' => $productRequest->importir_user_id
        ]);

        return response()->json(['success' => true, 'message' => 'Request berhasil ditolak']);
    }

    /**
     * Delete request - PERBAIKI METHOD INI
     */
    public function deleteRequest($requestId)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // PERBAIKI: Gunakan ProductRequest, bukan Request
        $productRequest = ProductRequest::findOrFail($requestId);
        
        // Check if user owns the request or is eksportir who handled it
        $user = Auth::user();
        // PERBAIKI: Gunakan Auth::id(), bukan $user->user_id
        if ($productRequest->importir_user_id !== Auth::id() && 
            $productRequest->eksportir_user_id !== Auth::id() &&
            $user->role !== 'eksportir') {
            return response()->json(['error' => 'Access denied'], 403);
        }

        $productRequest->delete();

        Log::info('Product request deleted', [
            'request_id' => $requestId,
            'deleted_by' => Auth::id() // PERBAIKI
        ]);

        return response()->json(['success' => true, 'message' => 'Request berhasil dihapus']);
    }
}
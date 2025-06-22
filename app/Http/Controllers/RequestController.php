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
        if (!Auth::check() || Auth::user()->role !== 'impor') {
            return redirect()->route('login')->with('error', 'Access denied. Importir only.');
        }

        $user = Auth::user();
        $pendingRequests = ProductRequest::where('importir_user_id', $user->user_id)
                                ->where('status', ProductRequest::STATUS_PENDING)
                                ->with('eksportir')
                                ->orderBy('created_at', 'desc')
                                ->get();

        $approvedRequests = ProductRequest::where('importir_user_id', $user->user_id)
                                ->where('status', ProductRequest::STATUS_APPROVED)
                                ->with(['eksportir', 'product'])
                                ->orderBy('approved_at', 'desc')
                                ->get();

        return view('requestimportir', compact('pendingRequests', 'approvedRequests'));
    }

    /**
     * Store new request from importir
     */
    public function storeImportirRequest(HttpRequest $request)
    {
        $request->validate([
            'request_text' => 'required|string|max:1000'
        ]);

        if (!Auth::check() || Auth::user()->role !== 'impor') {
            return redirect()->route('login')->with('error', 'Access denied. Importir only.');
        }

        $productRequest = ProductRequest::create([
            'importir_user_id' => Auth::user()->user_id,
            'request_text' => $request->request_text,
            'status' => ProductRequest::STATUS_PENDING
        ]);

        Log::info('New product request created', [
            'request_id' => $productRequest->id,
            'importir_user_id' => Auth::user()->user_id,
            'request_text' => $request->request_text
        ]);

        return redirect()->back()->with('success', 'Request berhasil dikirim! Eksportir akan meninjau permintaan Anda.');
    }

    /**
     * Show requests for eksportir
     */
    public function eksportirRequestList()
    {
        if (!Auth::check() || Auth::user()->role !== 'ekspor') {
            return redirect()->route('login')->with('error', 'Access denied. Eksportir only.');
        }

        $pendingRequests = ProductRequest::where('status', ProductRequest::STATUS_PENDING)
                                ->with('importir')
                                ->orderBy('created_at', 'desc')
                                ->get();

        $myRequests = ProductRequest::where('eksportir_user_id', Auth::user()->user_id)
                            ->with(['importir', 'product'])
                            ->orderBy('updated_at', 'desc')
                            ->get();

        return view('requesteksportir', compact('pendingRequests', 'myRequests'));
    }

    /**
     * Approve request by eksportir
     */
    public function approveRequest(HttpRequest $request, $requestId)
    {
        if (!Auth::check() || Auth::user()->role !== 'ekspor') {
            return response()->json(['error' => 'Access denied'], 403);
        }

        $productRequest = ProductRequest::findOrFail($requestId);
        
        if ($productRequest->status !== ProductRequest::STATUS_PENDING) {
            return response()->json(['error' => 'Request already processed'], 400);
        }

        $productId = $request->input('product_id'); // Optional: if eksportir wants to link existing product

        $productRequest->approve(Auth::user()->user_id, $productId);

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
            'eksportir_user_id' => Auth::user()->user_id,
            'importir_user_id' => $productRequest->importir_user_id
        ]);

        return response()->json(['success' => true, 'message' => 'Request berhasil disetujui']);
    }

    /**
     * Reject request by eksportir
     */
    public function rejectRequest($requestId)
    {
        if (!Auth::check() || Auth::user()->role !== 'ekspor') {
            return response()->json(['error' => 'Access denied'], 403);
        }

        $productRequest = ProductRequest::findOrFail($requestId);
        
        if ($productRequest->status !== ProductRequest::STATUS_PENDING) {
            return response()->json(['error' => 'Request already processed'], 400);
        }

        $productRequest->reject(Auth::user()->user_id);

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
            'eksportir_user_id' => Auth::user()->user_id,
            'importir_user_id' => $productRequest->importir_user_id
        ]);

        return response()->json(['success' => true, 'message' => 'Request berhasil ditolak']);
    }

    /**
     * Delete request
     */
    public function deleteRequest($requestId)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $productRequest = ProductRequest::findOrFail($requestId);
        
        // Check if user owns the request or is eksportir who handled it
        $user = Auth::user();
        if ($productRequest->importir_user_id !== $user->user_id && 
            $productRequest->eksportir_user_id !== $user->user_id &&
            $user->role !== 'eksportir') {
            return response()->json(['error' => 'Access denied'], 403);
        }

        $productRequest->delete();

        Log::info('Product request deleted', [
            'request_id' => $requestId,
            'deleted_by' => $user->user_id
        ]);

        return response()->json(['success' => true, 'message' => 'Request berhasil dihapus']);
    }
}

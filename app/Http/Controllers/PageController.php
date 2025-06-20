<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contactus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function home()
    {
        try {
            // ✅ Debug: Check database connection
            Log::info('🔍 Starting homepage data fetch...');
            
            // ✅ Debug: Check if table exists
            $tableExists = DB::select("SHOW TABLES LIKE 'contactus_tabel'");
            Log::info('Table exists check: ' . (count($tableExists) > 0 ? 'YES' : 'NO'));
            
            // ✅ Debug: Raw query to check data
            $rawData = DB::select('SELECT * FROM contactus_tabel ORDER BY created_at DESC LIMIT 6');
            Log::info('Raw data count: ' . count($rawData));
            Log::info('Raw data: ' . json_encode($rawData));
            
            // ✅ Get testimonials using Eloquent
            $testimonials = Contactus::orderBy('created_at', 'desc')->take(6)->get();
            
            // ✅ Debug: Log Eloquent results
            Log::info('Eloquent testimonials count: ' . $testimonials->count());
            Log::info('Eloquent testimonials: ' . $testimonials->toJson());
            
            // ✅ Debug: Check first testimonial details
            if ($testimonials->count() > 0) {
                $first = $testimonials->first();
                Log::info('First testimonial details: ' . json_encode([
                    'id' => $first->id,
                    'name' => $first->name,
                    'email' => $first->email,
                    'message' => $first->message,
                    'created_at' => $first->created_at
                ]));
            }
            
            // ✅ Force pass data to view
            $viewData = [
                'testimonials' => $testimonials
            ];
            
            Log::info('View data prepared: ' . json_encode([
                'testimonials_count' => $testimonials->count(),
                'testimonials_type' => get_class($testimonials)
            ]));
            
            return view('homepage', $viewData);
            
        } catch (\Exception $e) {
            Log::error('❌ Error in homepage controller: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Return with empty collection
            return view('homepage', [
                'testimonials' => collect([])
            ]);
        }
    }

    public function userprofile()
    {
        if (!Auth::check()) {
            return view('404');
        }
        
        return view('user-profile');
    }

    public function invoice()
    {
        return view('invoice');
    }
    
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('homepage')->with('success', 'You have been successfully logged out');
    }

    public function transactions()
    {
        return view('transactions');
    }
}
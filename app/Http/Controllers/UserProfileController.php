<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('user-profile', compact('user'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id() . ',user_id',
            'phone' => 'required|string|max:20|unique:users,phone,' . Auth::id() . ',user_id',
            'country' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = Auth::user();
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'country' => $request->country,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile: ' . $e->getMessage()
            ], 500);
        }
    }

    // Tambah method untuk upload foto profil
    public function uploadProfilePicture(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid image file',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = Auth::user();
            
            if ($request->hasFile('profile_picture')) {
                // Delete old profile picture if exists
                if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
                    unlink(public_path($user->profile_picture));
                }

                $image = $request->file('profile_picture');
                $imageName = 'profile_' . $user->user_id . '_' . time() . '.' . $image->extension();
                
                // Create directory if not exists
                $uploadPath = public_path('uploads/profiles');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                // Move uploaded file
                $image->move($uploadPath, $imageName);
                
                // Update user profile picture path
                $user->update([
                    'profile_picture' => 'uploads/profiles/' . $imageName
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Profile picture updated successfully',
                    'profile_picture_url' => asset('uploads/profiles/' . $imageName)
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No image file uploaded'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload profile picture: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy()
    {
        try {
            $user = Auth::user();
            
            // Delete profile picture if exists
            if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
                unlink(public_path($user->profile_picture));
            }
            
            Auth::logout();
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Account deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete account: ' . $e->getMessage()
            ], 500);
        }
    }
}
<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contactus;

class ContactusController extends Controller
{
    public function storeContactUs(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        try {
            Contactus::create([
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message,
            ]);

            return redirect()->route('homepage')
                           ->with('success', 'Thank you for contacting us! Your message has been sent successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Sorry, there was an error sending your message. Please try again.')
                           ->withInput();
        }
    }
}
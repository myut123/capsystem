<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Facade;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class OtpController extends Controller
{
    // Send OTP to the registered email
    public function showEmailForm()
    {
        $userId = Session::get('user_id'); // Get the user ID from the session
        $user = DB::table('users')->where('id', $userId)->first(); // Fetch the user details
        
        if (!$user) {
            return redirect()->route('login.view')->with('error', 'User not found. Please log in.');
        }
        
        return view('login_and_Signup.emailOtp', ['user' => $user]); // Pass the user to the view
            
    }

    // Send OTP to the logged-in user's email
    public function sendOtp(Request $request)
    {
        
       {
            // Get the email from the form input
            $email = $request->input('email'); // Use the email from the form
        
            // Validate the email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return response()->json(['message' => 'Invalid email address'], 400);
            }
        
            // Store the user ID in the session (since you're already logged in, you can fetch the user ID from the session)
            $userId = Session::get('user_id'); // Get the user ID from the session
            if (!$userId) {
                return response()->json(['message' => 'User not found. Please log in.'], 404);
            }
        
            // Retrieve the user by ID
            $user = DB::table('users')->where('id', $userId)->first();
        
            if (!$user) {
                return response()->json(['message' => 'No user found'], 404);
            }
        
            // Optionally, you can store the email in the session if you want to keep it
            Session::put('email', $email); // Store the email in the session if needed
        
            // Generate a 6-digit OTP
            $otp = rand(100000, 999999);
        
            // Store OTP in session with expiration time (5 minutes)
            Session::put('otp', $otp);
            Session::put('otp_expires', now()->addMinutes(2));
        
            // Send OTP via email
            try {
                Mail::raw("Your OTP for verification is: $otp", function ($message) use ($email) {
                    $message->to($email)
                            ->subject('Email Verification OTP');
                });
            } catch (\Exception $e) {
                Log::error('Mail sending failed: ' . $e->getMessage());
                return response()->json(['message' => 'Failed to send OTP. Please try again.'], 500);
            }
        
            return redirect()->route('view.otp')->with('success', 'OTP sent to your email. Please verify.');
        }
        
    }
    // Show the OTP input page
    public function viewOtp()
    {
        return view('login_and_Signup.otp');
    }

    // Verify the OTP entered by the user
   // Verify the OTP entered by the user
   public function verifyOtp(Request $request)
   {
       // Combine the array of OTP digits into a single string
       $otp = implode('', $request->input('otp')); 

    // Fetch OTP and expiration time from the session
    $sessionOtp = Session::get('otp');
    $otpExpires = Session::get('otp_expires');

    // Check if the session OTP and expiration exist
    if (!$sessionOtp || !$otpExpires) {
        return redirect()->back()->with('error', 'No OTP found or OTP expired. Please request a new OTP.');
    }

    // Validate the OTP and check if it has expired
    if ($sessionOtp != $otp || now()->greaterThan($otpExpires)) {
        return redirect()->back()->with('error', 'Invalid or expired OTP');
    }

    // If OTP is valid, mark the user as verified in the database
    $userId = Session::get('user_id');
    DB::table('users')->where('id', $userId)->update(['is_verified' => 'verified', 'updated_at' => now()]);

    // Clear OTP from session
    Session::forget(['otp', 'otp_expires']);
    
    return redirect()->route('login.view')->with('success', 'OTP verification successful.');
   }
   
    // Resend the OTP
    public function resendOtp(Request $request)
    {
    
        // If validation passes, proceed to send OTP
        $email = Session::get('email');

        // Check if the email exists in the session
        if (!$email) {
            return redirect()->back()->withErrors(['email' => 'No email found in session.']);
        }
    
        // If the email is found, proceed to resend the OTP
        $request->merge(['email' => $email]); // Add the email to the request
    
        return $this->sendOtp($request);
    }
    
}

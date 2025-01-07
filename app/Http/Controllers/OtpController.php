<?php

namespace App\Http\Controllers;

use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class OtpController extends Controller
{
    // Show the email verification form
    public function showVerifyEmailForm()
    {
        return view('auth.verify-email');
    }

    // Handle sending OTP
    public function sendOtp(Request $request)
    {
        // Validate the email
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;

        // Generate a 6-digit OTP without leading zeros
        $otp = rand(100000, 999999); // Always 6 digits

        // Create or update the OTP record
        Otp::updateOrCreate(
            ['email' => $email],
            [
                'otp' => $otp, // Stored as integer
                'expires_at' => Carbon::now()->addMinutes(10),
            ]
        );

        // Send the OTP to the user's email
        Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($email) {
            $message->to($email)
                    ->subject('Your OTP Code');
        });

        // Store the email in session
        $request->session()->put('verified_email', $email);

        return redirect()->route('verify.otp')->with('success', 'OTP has been sent to your email.');
    }

    // Show the OTP verification form
    public function showVerifyOtpForm(Request $request)
    {
        if (!$request->session()->has('verified_email')) {
            return redirect()->route('verify.email')->with('error', 'Please verify your email first.');
        }

        return view('auth.verify-otp');
    }

    // Handle OTP verification
    public function verifyOtp(Request $request)
    {
        // Validate the OTP input
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        // Retrieve the email from session
        $email = $request->session()->get('verified_email');

        if (!$email) {
            return redirect()->route('verify.email')->with('error', 'Session expired. Please verify your email again.');
        }

        $otpInput = (int) trim($request->otp); // Convert input to integer

        // Find the OTP record
        $otpRecord = Otp::where('email', $email)->first();

        if (!$otpRecord) {
            return redirect()->back()->with('error', 'No OTP request found for this email.');
        }

        // Check if OTP is expired
        if (Carbon::now()->greaterThan($otpRecord->expires_at)) {
            $otpRecord->delete(); // Remove expired OTP
            return redirect()->back()->with('error', 'OTP has expired. Please request a new one.');
        }

        // Log OTP values for debugging
        Log::info('OTP Verification Attempt', [
            'email' => $email,
            'otp_input' => $otpInput,
            'otp_stored' => $otpRecord->otp,
        ]);

        // Check if OTP matches
        if ($otpInput !== $otpRecord->otp) {
            Log::warning('OTP mismatch for email: ' . $email);
            return redirect()->back()->with('error', 'Invalid OTP. Please try again.');
        }

        // OTP is valid
        // Mark the email as verified in session
        $request->session()->put('email_verified', true);

        // Optionally, delete the OTP record
        $otpRecord->delete();

        return redirect()->route('register')->with('success', 'Email verified. You can now register.');
    }
}

<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ForgotPasswordBasic extends Controller
{
    // Show forgot password form
    public function showForgotPasswordForm()
    {
        return view('content.authentications.auth-forgot-password-basic');
    }

    // Send OTP
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $email = $request->email;

        if (session('otp_sent_at') && now()->diffInSeconds(session('otp_sent_at')) < 60) {
            return response()->json(['success' => false, 'message' => 'Please wait before requesting another OTP.']);
        }

        $otp = rand(100000, 999999);
        session([
            'otp' => $otp,
            'otp_expiration' => now()->addMinutes(1),
            'otp_sent_at' => now(),
            'email' => $email
        ]);

        try {
            Mail::to($email)->send(new OtpMail($otp));
            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully.',
                'redirect' => route('otp-verification')
            ]);
        } catch (\Exception $e) {
            Log::error('OTP email error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to send OTP.']);
        }
    }

    // Show OTP verification form
    public function showOtpVerificationForm()
    {
        return view('content.authentications.otp-verification');
    }

    // Verify OTP & Update Password
    public function verifyOtpAndUpdatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|numeric|digits:6',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if ($request->otp != session('otp')) {
            return back()->with('error', 'Invalid OTP.');
        }

        $user = User::where('email', session('email'))->first();
        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        Session::forget(['otp', 'email']);

        return redirect()->route('auth-login-basic')->with('success', 'Password updated successfully.');
    }
}
<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class RegisterBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-register-basic');
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|string|min:6|confirmed',
      'otp' => 'required|numeric|digits:6',
    ]);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }

    // Validate OTP
    $storedOtp = session('otp');
    $otpExpiration = session('otp_expiration');

    if (!$storedOtp || !$otpExpiration || now()->greaterThan(Carbon::parse($otpExpiration))) {
      return redirect()->back()->with('error', 'OTP has expired. Please request a new one.');
    }

    if ($request->input('otp') != $storedOtp) {
      return redirect()->back()->with('error', 'Invalid OTP. Please try again.');
    }

    // Create user
    User::create([
      'name' => $request->input('name'),
      'email' => $request->input('email'),
      'password' => Hash::make($request->input('password')),
    ]);

    // Clear OTP session
    Session::forget(['otp', 'otp_expiration']);

    // ✅ Redirect to login page with a success message
    return redirect()->route('auth-login-basic')->with('success', 'Registration successful. Please log in.');
  }

  public function sendOtp1(Request $request)
  {
    $request->validate([
      'email' => 'required|email|unique:users,email',
    ]);

    $email = $request->email;

    // Prevent frequent OTP requests (2 minutes delay)
    if (session('otp_sent_at') && now()->diffInSeconds(session('otp_sent_at')) < 30) {
      return response()->json(['success' => false, 'message' => 'Please wait before requesting another OTP.']);
    }

    // Generate OTP and store in session
    $otp = rand(100000, 999999);
    session([
      'otp' => $otp,
      'otp_expiration' => now()->addMinutes(1),
      'otp_sent_at' => now(),
    ]);

    try {
      // Send OTP via email
      Mail::to($email)->send(new OtpMail($otp));

      return response()->json([
        'success' => true,
        'message' => 'OTP sent successfully.'
      ]);
    } catch (\Exception $e) {
      Log::error('OTP email error: ' . $e->getMessage());
      return response()->json([
        'success' => false,
        'message' => 'Failed to send OTP. Please check your email settings.'
      ]);
    }
  }
}
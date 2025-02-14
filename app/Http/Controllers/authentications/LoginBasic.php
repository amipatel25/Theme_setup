<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginBasic extends Controller
{
  // Show login form
  public function index()
  {
    if (Auth::check()) {
      return redirect()->route('dashboard-analytics');
    }

    return view('content.authentications.auth-login-basic');
  }

  // Handle login
  public function login(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|string',
      'password' => 'required|string',
    ]);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }

    $email = $request->input('email');
    $password = $request->input('password');

    // Attempt to find the user by email
    $user = DB::table('users')->where('email', $email)->first();

    if ($user) {
      if (Hash::check($password, $user->password)) {
        Auth::loginUsingId($user->id);

        // Store the success message in session
        return redirect()->route('dashboard-analytics')->with('success', 'You have successfully logged in!');
      } else {
        return redirect()->back()->with('error', '⚠️ Invalid credentials. Please try again.');
      }
    } else {
      return redirect()->back()->with('error', '⚠️ No account found with that email.');
    }
  }

  // Handle logout
  public function logout()
  {
    Auth::logout();
    return redirect()->route('auth-login-basic');
  }
}

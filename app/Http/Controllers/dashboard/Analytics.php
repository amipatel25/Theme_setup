<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Analytics extends Controller
{
  public function __construct()
  {
    $this->middleware('auth'); // Ensure this page is only accessible to authenticated users
  }

  public function index()
  {
    // If the user is authenticated, return the dashboard analytics view
    if (Auth::check()) {
      return view('content.dashboard.dashboards-analytics');
    }

    // Redirect to login if not authenticated (though this should be handled by the middleware)
    return redirect()->route('auth-login-basic');
  }
}
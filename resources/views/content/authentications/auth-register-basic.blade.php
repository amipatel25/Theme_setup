@extends('layouts.blankLayout')

@section('title', 'Register Basic - Pages')

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register Card -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="{{ url('/') }}" class="app-brand-link gap-2">
                              <span class="app-brand-logo demo">
                                <img src="{{ asset('assets/img/icon.png') }}" alt="Brand Logo" width="40"
                                    height="35">
                            </span>
                                <span class="app-brand-text demo text-body fw-bold" style="text-transform: capitalize;">
                                    {{ config('variables.templateName') }}
                                </span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Adventure starts here 🚀</h4>
                        <p class="mb-4">Make your app management easy and fun!</p>

                        <!-- Registration Form -->
                        <form id="formAuthentication" class="mb-3" action="{{ route('auth-register-basic-store') }}"
                            method="POST">
                            @csrf

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="Enter your name" value="{{ old('name') }}"
                                    required>
                                @error('name')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}"
                                    required>
                                @error('email')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">{{ __('Password') }}</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="Enter your password" required>
                                    <span class="input-group-text cursor-pointer">
                                        <i class="bx bx-hide"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation" placeholder="Confirm your password" required>
                                    <span class="input-group-text cursor-pointer">
                                        <i class="bx bx-hide"></i>
                                    </span>
                                </div>
                                @error('password_confirmation')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- OTP Section -->
                            <div class="mb-3">
                                <label for="otp" class="form-label">{{ __('Enter OTP') }}</label>
                                <input type="text" class="form-control @error('otp') is-invalid @enderror" id="otp"
                                    name="otp" disabled>
                                @error('otp')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="button" id="send-otp-btn" class="btn btn-primary">{{ __('Send OTP') }}</button>
                            <br><br>
                            <!-- Terms and Conditions -->
                            {{-- <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox"
                                        id="terms" name="terms" required>
                                    <label class="form-check-label" for="terms">
                                        I agree to
                                        <a href="javascript:void(0);">privacy policy & terms</a>
                                    </label>
                                </div>
                                @error('terms')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div> --}}

                            <!-- General Error Message -->
                            @if (session('error'))
                                <div class="alert alert-danger text-center p-2">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <button type="submit" id="signup-btn" class="btn btn-primary d-grid w-100" disabled>
                                {{ __('Sign Up') }}
                            </button>
                        </form>

                        <p class="text-center">
                            <span>Already have an account?</span>
                            <a href="{{ url('auth/login-basic') }}">
                                <span>Sign in instead</span>
                            </a>
                        </p>
                    </div>
                </div>
                <!-- Register Card -->
            </div>
        </div>
    </div>

    <!-- JavaScript for Sending OTP -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#send-otp-btn').on('click', function() {
                var email = $('#email').val().trim();

                if (!email) {
                    alert('Please enter a valid email.');
                    return;
                }

                $('#send-otp-btn').prop('disabled', true).text('Sending...');

                $.ajax({
                    url: '{{ route('send-otp-register') }}',
                    method: 'POST',
                    data: {
                        email: email,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            alert(response.message || 'OTP sent successfully.');
                            $('#otp').prop('disabled', false);
                            $('#signup-btn').prop('disabled', false);
                        } else {
                            alert(response.message || 'Error sending OTP.');
                        }
                        $('#send-otp-btn').prop('disabled', false).text('Send OTP');
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Error sending OTP. Please try again.');
                        $('#send-otp-btn').prop('disabled', false).text('Send OTP');
                    }
                });
            });
        });
    </script>

@endsection

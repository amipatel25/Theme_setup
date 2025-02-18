@extends('layouts.blankLayout')

@section('title', 'OTP Verification - Pages')

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- OTP Verification Card -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="{{ url('/') }}" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <img src="{{ asset('assets/img/icon.png') }}" alt="Brand Logo" width="40" height="35">
                                </span>
                                <span class="app-brand-text demo text-body fw-bold" style="text-transform: capitalize;">
                                    {{ config('variables.templateName') }}
                                </span>
                            </a>
                        </div>
                        <!-- /Logo -->

                        <h4 class="mb-2">Verify OTP 🔐</h4>
                        <p class="mb-4">Enter the OTP sent to your email to reset your password.</p>

                        <!-- ✅ Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <!-- ❌ Error Message -->
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form id="otpVerificationForm" action="{{ route('verify-otp') }}" method="POST">
                            @csrf

                            <!-- OTP Input -->
                            <div class="mb-3">
                                <label for="otp" class="form-label">{{ __('OTP') }}</label>
                                <input type="text" id="otp" name="otp" class="form-control" placeholder="Enter OTP" required>
                                @error('otp')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="mb-3 form-password-toggle">
                                <label for="password" class="form-label">{{ __('New Password') }}</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" name="password" class="form-control" required
                                        placeholder="Enter new password">
                                    <span class="input-group-text cursor-pointer" id="toggle-password">
                                        <i class="bx bx-hide"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3 form-password-toggle">
                                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required placeholder="Confirm new password">
                                    <span class="input-group-text cursor-pointer" id="toggle-password-confirm">
                                        <i class="bx bx-hide"></i>
                                    </span>
                                </div>
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100" id="setNewPasswordButton" disabled>
                                {{ __('Reset Password') }}
                            </button>
                        </form>
                        <br>
                        <div class="text-center">
                            <a href="{{ route('auth-login-basic') }}" class="d-flex align-items-center justify-content-center">
                                <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                                Back to login
                            </a>
                        </div>
                    </div>
                </div>
                <!-- OTP Verification Card -->
            </div>
        </div>
    </div>

    <!-- ✅ JavaScript for Handling Button State -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otpInput = document.getElementById('otp');
            const passwordInput = document.getElementById('password');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const setNewPasswordButton = document.getElementById('setNewPasswordButton');

            function validateForm() {
                const otpValue = otpInput.value.trim();
                const passwordValue = passwordInput.value.trim();
                const passwordConfirmationValue = passwordConfirmationInput.value.trim();

                // Enable button only if OTP is entered and passwords match
                if (otpValue !== '' && passwordValue !== '' && passwordConfirmationValue !== '' && passwordValue === passwordConfirmationValue) {
                    setNewPasswordButton.disabled = false;
                } else {
                    setNewPasswordButton.disabled = true;
                }
            }

            // Add event listeners to all input fields
            otpInput.addEventListener('input', validateForm);
            passwordInput.addEventListener('input', validateForm);
            passwordConfirmationInput.addEventListener('input', validateForm);
        });
    </script>
@endsection

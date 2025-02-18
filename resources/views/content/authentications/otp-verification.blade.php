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
                                <img src="{{ asset('assets/img/logo_main.png') }}" alt="Brand Logo" width="40"
                                    height="35">
                            </span>
                                <span class="app-brand-text demo text-body fw-bold" style="text-transform: capitalize;">
                                    {{ config('variables.templateName') }}
                                </span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Verify OTP 🔐</h4>
                        <p class="mb-4">Enter the OTP sent to your email to reset your password.</p>

                        <!-- ✅ Toast Notification -->
                        <div id="toast-success"
                            class="toast align-items-center text-bg-success border-0 position-fixed top-0 end-0 m-3"
                            role="alert" aria-live="assertive" aria-atomic="true" style="display: none;">
                            <div class="d-flex">
                                <div class="toast-body">
                                    Password reset successfully! Redirecting...
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                                    aria-label="Close"></button>
                            </div>
                        </div>

                        <!-- Display Global Error Messages -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="otpVerificationForm" action="{{ route('verify-otp') }}" method="POST">
                            @csrf

                            <!-- OTP Input -->
                            <div class="mb-3">
                                <label for="otp" class="form-label">{{ __('OTP') }}</label>
                                <input type="text" id="otp" name="otp" class="form-control"
                                    placeholder="Enter OTP" required>
                                @error('otp')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('New Password') }}</label>
                                <input type="password" id="password" name="password" class="form-control" required
                                    placeholder="Enter new password">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control" required placeholder="Confirm new password">
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">{{ __('Reset Password') }}</button>
                        </form>
                        <br>
                        <div class="text-center">
                          <a href="{{ url('auth/login-basic') }}"
                              class="d-flex align-items-center justify-content-center">
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

    <!-- ✅ JavaScript for Handling Toast & Redirect -->
    <script>
        $(document).ready(function() {
            $('#otpVerificationForm').on('submit', function(event) {
                event.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('verify-otp') }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            // ✅ Show Toast Message
                            var toastEl = $('#toast-success');
                            toastEl.show();
                            var toast = new bootstrap.Toast(toastEl[0]);
                            toast.show();

                            // ✅ Redirect to login page after 3 seconds
                            setTimeout(() => {
                                window.location.href =
                                    '{{ route('auth-login-basic') }}';
                            }, 3000);
                        } else {
                            $('#alert-container').html(
                                `<div class="alert alert-danger">${response.message}</div>`
                            );
                        }
                    },
                    error: function(xhr) {
                        $('#alert-container').html(
                            '<div class="alert alert-danger">OTP verification failed. Try again.</div>'
                        );
                    }
                });
            });
        });
    </script>
@endsection

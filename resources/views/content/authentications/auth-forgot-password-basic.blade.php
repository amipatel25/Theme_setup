@extends('layouts/blankLayout')

@section('title', 'Forgot Password - Pages')

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <div class="card">
                    <div class="card-body">
                        <div class="app-brand justify-content-center">
                            <a href="{{ url('/') }}" class="app-brand-link gap-2">
                              <span class="app-brand-logo demo">
                                <img src="{{ asset('assets/img/icon.png') }}" alt="Brand Logo" width="40"
                                    height="35">
                            </span>
                                <span
                                    class="app-brand-text demo text-body fw-bold" style="text-transform: capitalize;">{{ config('variables.templateName') }}</span>
                            </a>
                        </div>

                        <h4 class="mb-2">Forgot Password? 🔒</h4>
                        <p class="mb-4">Enter your email to receive a reset OTP.</p>

                        <div id="alert-container"></div>

                        <form id="forgotPasswordForm">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter your email" required>
                            </div>
                            <button type="button" class="btn btn-primary d-grid w-100" id="send-otp-btn">Send OTP</button>
                            <br>
                        </form>

                        <div class="text-center">
                            <a href="{{ url('auth/login-basic') }}"
                                class="d-flex align-items-center justify-content-center">
                                <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                                Back to login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                    url: '{{ route('send-otp-forgot-password') }}', // Corrected route
                    method: 'POST',
                    data: {
                        email: email,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        let alertType = response.success ? 'success' : 'danger';
                        $('#alert-container').html(
                            `<div class="alert alert-${alertType}">${response.message}</div>`
                        );

                        if (response.success) {
                            setTimeout(() => {
                                window.location.href = response.redirect;
                            }, 2000);
                        }

                        $('#send-otp-btn').prop('disabled', false).text('Send OTP');
                    },
                    error: function(xhr) {
                        $('#alert-container').html(
                            '<div class="alert alert-danger">Error sending OTP. Try again.</div>'
                        );
                        $('#send-otp-btn').prop('disabled', false).text('Send OTP');
                    }
                });
            });
        });
    </script>
@endsection

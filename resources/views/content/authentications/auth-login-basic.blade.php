@extends('layouts.blankLayout')

@section('title', 'Login Basic - Pages')

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
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

                        <h4 class="mb-2" style="text-transform: capitalize;">Welcome to
                            {{ config('variables.templateName') }}! 👋</h4>
                        <p class="mb-4">Please sign in to your account and start the adventure</p>

                        <!-- ✅ SweetAlert2 Success Message -->
                        @if (session('success'))
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Thank You!',
                                        text: '{{ session('success') }}',
                                        confirmButtonColor: '#28a745',
                                        confirmButtonText: 'OK',
                                        allowOutsideClick: false
                                    });
                                });
                            </script>
                        @endif

                        <!-- ✅ Error Alert -->
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- ✅ Login Form -->
                        <form id="formAuthentication" class="mb-3" action="{{ route('auth-login-basic-submit') }}"
                            method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Enter your email" autofocus required>
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="Enter your password" required>
                                    <span class="input-group-text cursor-pointer">
                                        <i class="bx bx-hide"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <a href="{{ url('/auth/forgot-password') }}" class="float-end mb-1">
                                    <span>Forgot Password?</span>
                                </a>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>

                        <p class="text-center">
                            <span>New on our platform?</span>
                            <a href="{{ route('auth-register-basic') }}">
                                <span>Create an account</span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ SweetAlert2 Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

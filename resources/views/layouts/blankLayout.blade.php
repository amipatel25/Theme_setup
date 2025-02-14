@extends('layouts/commonMaster')

@section('layoutContent')
    <!-- Content -->
    @yield('content')
    <!--/ Content -->

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
@endsection

@php
$configData = Helper::appClasses();
$customizerHidden = 'customizer-hide';
@endphp

{{-- @extends('layouts/layoutMaster') --}}
@extends('layouts.blankLayout')

@section('title', 'Forgot Password')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="position-relative">
  <div class="authentication-wrapper authentication-basic container-p-y p-4 p-sm-0">
    <div class="authentication-inner py-6">
      <div class="card p-3 p-1">
        <div class="card-body mt-1">
          <h4 class="mb-1">Forgot Password? 🔒</h4>
          <p class="mb-5">Enter your email and we'll send you instructions to reset your password</p>
          <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" autofocus>
              <label>Email</label>
            </div>
            <button type="submit" class="btn btn-primary d-grid w-100">Send Reset Link</button>
          </form>
          <div class="text-center mt-2">
            <a href="{{route('login')}}" class="d-flex align-items-center justify-content-center">
              <i class="ri-arrow-left-s-line scaleX-n1-rtl ri-20px me-1_5"></i>
              Back to login
            </a>
          </div>
        </div>
      </div>
      <img alt="mask"
        src="{{asset('assets/img/illustrations/auth-basic-forgot-password-mask-'.$configData['style'].'.png') }}"
        class="authentication-image d-none d-lg-block"
        data-app-light-img="illustrations/auth-basic-forgot-password-mask-light.png"
        data-app-dark-img="illustrations/auth-basic-forgot-password-mask-dark.png" />
    </div>
  </div>
</div>
@endsection
@php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
$configData = Helper::appClasses();
$customizerHidden = 'customizer-hide';
@endphp

{{-- @extends('layouts/layoutMaster') --}}
@extends('layouts.blankLayout')

@section('title', 'Register')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('page-script')
<script src="{{asset('assets/js/pages-auth.js')}}"></script>
@endsection

@section('content')
<div class="position-relative">
  <div class="authentication-wrapper authentication-basic container-p-y p-4 p-sm-0">
    <div class="authentication-inner py-6">
      <div class="card p-3 pt-5 pb-5 ">
        <div class="card-body mt-1">
          <h4 class="mb-1">Registrasi Akun Anda Disini 🚀</h4>
          <p class="mb-3">Lengkapi formulir register berikut ini!</p>
          <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="name" name="name" :value="old('name')" required
                placeholder="Enter your username" autofocus autocomplete="name">
              <label for="username">Username</label>
              <input :messages="$errors->get('name')" class="invalid-feedback" />
            </div>
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="email" name="email" :value="old('email')"
                placeholder="Enter your email">
              <label for="email">Email</label>
              <span :messages="$errors->get('email')" class="invalid-feedback" />
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="input-group input-group-merge">
                <div class="form-floating form-floating-outline">
                  <input type="password" name="password" required autocomplete="new-password" class="form-control"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                  <label for="password">Password</label>
                </div>
                <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                <x-input-error :messages="$errors->get('password')"
                  class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback" />
              </div>
            </div>
            <div class="mb-5 form-password-toggle">
              <div class="input-group input-group-merge">
                <div class="form-floating form-floating-outline">
                  <input type="password" name="password_confirmation" required autocomplete="new-password"
                    class="form-control"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="Password" />
                  <label for="password">Confirm Password</label>
                </div>
                <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                <x-input-error :messages="$errors->get('password_confirmation')"
                  class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback" />
              </div>
            </div>
            <button type="submit" class="btn btn-primary d-grid w-100" style="margin-top:40px; margin-bottom:20px">
              Sign up
            </button>
          </form>
          <p class="text-center">
            <span>Already have an account?</span>
            <a href="{{route('login')}}">
              <span>Sign in instead</span>
            </a>
          </p>
        </div>
      </div>
      <!-- Register Card -->
      <img alt="mask" src="{{asset('assets/img/illustrations/auth-basic-register-mask-'.$configData['style'].'.png') }}"
        class="authentication-image d-none d-lg-block"
        data-app-light-img="illustrations/auth-basic-register-mask-light.png"
        data-app-dark-img="illustrations/auth-basic-register-mask-dark.png" />
    </div>
  </div>
</div>
@endsection


{{-- <x-guest-layout>
  <form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div>
      <x-input-label for="name" :value="__('Name')" />
      <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus
        autocomplete="name" />
      <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Email Address -->
    <div class="mt-4">
      <x-input-label for="email" :value="__('Email')" />
      <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
        autocomplete="username" />
      <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-4">
      <x-input-label for="password" :value="__('Password')" />

      <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
        autocomplete="new-password" />

      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
      <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

      <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"
        required autocomplete="new-password" />

      <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end mt-4">
      <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        href="{{ route('login') }}">
        {{ __('Already registered?') }}
      </a>

      <x-primary-button class="ms-4">
        {{ __('Register') }}
      </x-primary-button>
    </div>
  </form>
</x-guest-layout> --}}
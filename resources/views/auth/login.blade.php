@extends('layouts/fullLayoutMaster')

@section('title', 'Login Page')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-auth.css')) }}">
@endsection

@section('content')
<div class="auth-wrapper auth-v2">
  <div class="auth-inner row m-0">
      <!-- Brand logo-->
      <a class="brand-logo" href="javascript:void(0);">        
        <img src="{{ asset('images/logo/job_portal_logo.png') }}" alt="Logo" style="width: 220px;">
      </a>
      <!-- /Brand logo-->
      <!-- Left Text-->
      <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
          <img class="img-fluid" src="{{asset('images/pages/login-v2.svg')}}" alt="Login V2" />
        </div>
      </div>
      <!-- /Left Text-->
      <!-- Login-->
      <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
        <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
          <h2 class="card-title font-weight-bold mb-1">Welcome to NaukriWala! &#x1F44B;</h2>
          <p class="card-text mb-2">Please sign-in to your account and start the adventure</p>
          <form class="auth-login-form mt-1" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="login-email" class="form-label">Email</label><span
                        class="invalid-feedback">*</span>
                <input type="text" class="form-control" id="login-email" name="email"
                       placeholder="john@example.com" aria-describedby="login-email" tabindex="1" autofocus
                       value="{{ old('email') }}"/>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <div class="d-flex justify-content-between">
                    <label for="login-password">Password<span class="invalid-feedback">*</span></label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            <small>Forgot Password?</small>
                        </a>
                    @endif
                </div>
                <div class="input-group input-group-merge form-password-toggle">
                    <input type="password" class="form-control form-control-merge" id="login-password"
                           name="password" tabindex="2"
                           placeholder="············"
                           aria-describedby="login-password"/>
                    <div class="input-group-append">
                        <span class="input-group-text cursor-pointer eyeButton"
                              data-parent="login-password"><i data-feather="eye"></i></span>
                    </div>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="remember-me" name="remember-me"
                           tabindex="3" {{ old('remember-me') ? 'checked' : '' }} />
                    <label class="custom-control-label" for="remember-me"> Remember Me </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block" tabindex="4">Sign in</button>
        </form>
          <p class="text-center mt-2">
            <span>New on our platform?</span>
          </p>
          <div class="d-flex justify-content-center">
              <a class="btn btn-outline-primary mr-2" href="{{ route('recruiter-register') }}">Recruiter</a>
              <a class="btn btn-outline-secondary" href="{{ route('candidate-register') }}">Candidate</a>
          </div>
      </div>
    </div>
    <!-- /Login-->
  </div>
</div>
@endsection

@section('vendor-script')
<script src="{{asset(mix('vendors/js/forms/validation/jquery.validate.min.js'))}}"></script>
@endsection


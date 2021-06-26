@extends('layouts/fullLayoutMaster')

@section('title', 'Recruiter / Candidate Login')

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-auth.css')) }}">
@endsection

@section('content')
    <div class="auth-wrapper auth-v1 px-2">
        <div class="auth-inner py-2">
            <!-- Login v1 -->
            <div class="card mb-0">
                <div class="card-body">
                    <p class="text-left"><a href="/"><span><i data-feather="arrow-left"></i> Home</span></a></p>
                    <a href="javascript:void(0);" class="brand-logo">
                        <img src="{{ asset('images/logo/job_portal_logo.png') }}" alt="Logo"
                             style="width: 300px; height: 200px;">
                    </a>

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
                                       placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
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
                    <ul class="text-center mt-2 p-0" style="list-style-type:none;">
                        <li style="font-size: 12px">Register As</li>
                        <li class="mt-1"><a href="{{ route('recruiter-register') }}">Recruiter</a> / <a href="{{ route('candidate-register') }}">Candidate</a></li>
                    </ul>
                </div>
            </div>
            <!-- /Login v1 -->
        </div>
    </div>
@endsection


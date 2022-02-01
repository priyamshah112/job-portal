@extends('layouts/fullLayoutMaster')

@section('title', 'Login Page')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-auth.css')) }}">
<style>
    html .content.app-content{
        padding: 0px;
    }
    html .content{
        margin-left: 0px;
    }
</style>
@endsection

@section('content')
<div class="auth-wrapper auth-v1 px-2">
  <div class="auth-inner py-2">
    <!-- Login v1 -->
    <div class="card mb-0">
      <div class="card-body">
        <a href="javascript:void(0);" class="brand-logo">
          <img src="{{ asset('images/logo/job_portal_logo.png') }}" alt="Logo" style="width: 160px;">
        </a>

        <h4 class="card-title mb-1">Verify Your Email Address! </h4>
        @if (session('resent'))
        <div class="alert-box alert-success" role="alert" id="success">
          <div class="alert-body">
          {{ __('A fresh verification link has been sent to your email address.') }}</div>
        </div>
        @endif
        <p class="card-text mb-2">{{ __('Before proceeding, please check your email for a verification link.') }}</p>
        <p class="card-text">{{ __('If you did not receive the email') }},

          <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
          </form>
        </p>
      </div>
    </div>
  </div>
</div>
@endsection
<script>
    $(document).ready(function(){
        $("#success").delay(5000).slideUp(300);
    });
</script>

@extends('layouts/fullLayoutMaster')

@section('title', 'Account Blocked')

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-auth.css')) }}">
    <style>
        html .content.app-content {
            padding: 0px;
        }

        html .content {
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
                        <img src="{{ asset('images/logo/job_portal_logo.png') }}" alt="Logo"
                            style="width: 300px; height: 200px;">
                    </a>
                    <h1>Account has been blocked.</h1>
                    <p>
                        You may contact <a
                            href="mailto:info@naukriwala.com">info@naukriwala.com</a> for any doubts
                    </p>
                </div>
            </div>
            <!-- /Login v1 -->
        </div>
    </div>
@endsection

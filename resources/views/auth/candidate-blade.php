@extends('layouts/fullLayoutMaster')

@section('title', 'Register Page')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-auth.css')) }}">
@endsection

@section('content')
<div class="auth-wrapper auth-v1 px-2">
    <div class="auth-inner py-2">
        <!-- Register v1 -->
        <div class="card mb-0">
            <div class="card-body">
                {{-- <a href="javascript:void(0);" class="brand-logo">
                    <img src="{{ asset('images/logo/job_portal_logo.png') }}" alt="Logo"
                         style="width: 300px;">
                </a> --}}
                <H3 class="text-center"><strong>Candidate - Signup</strong></H3>

                <form class="auth-register-form" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                       id="first_name" name="first_name" placeholder="First Name"
                                       aria-describedby="first_name" tabindex="1" autofocus
                                       value="{{ old('first_name') }}" />
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                       id="last_name" name="last_name" placeholder="Last Name" aria-describedby="last_name"
                                       tabindex="1" autofocus value="{{ old('last_name') }}" />
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                   <div class="form-group">
                       <label for="dateOfBirth" class="form-label">Date of Birth</label>
                       <input type="date"  class="form-control @error('dateOfBirth') is-invalid @enderror"
                              id="dob" name="dateOfBirth" placeholder="Last Name" aria-describedby="dateOfBirth"
                              tabindex="1" autofocus value="{{ old('dob') }}" />
                       @error('dateOfBirth')
                       <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                       @enderror
                   </div>
                   <div class="form-group">
                       <label for="gender" class="form-label">Gender</label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="any">Any</option>
                        </select>
                       @error('gender')
                       <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                       @enderror
                   </div>
                    <div class="form-group">
                        <label for="permanent_address" class="form-label">Permanent Address</label>
                        <input type="text" class="form-control @error('permanent_address') is-invalid @enderror"
                               id="permanent_address" name="permanent_address" placeholder="Redmond, Washington, United States"
                               aria-describedby="company_address" tabindex="2" value="{{ old('permanent_address') }}" />
                        @error('permanent_address')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="company_mobile_1" class="form-label">Primary Number</label>
                                <input type="text" class="form-control @error('company_mobile_1') is-invalid @enderror"
                                       id="company_mobile_1" name="company_mobile_1" placeholder="090256 65566"
                                       aria-describedby="company_mobile_1" tabindex="2"
                                       value="{{ old('company_mobile_1') }}" maxlength="10"
                                       onkeyup="this.value=this.value.replace(/[^\d]/,'')" />
                                @error('company_mobile_1')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="company_mobile_2" class="form-label">Alternative Number</label>
                                <input type="text" class="form-control @error('company_mobile_2') is-invalid @enderror"
                                       id="company_mobile_2" name="company_mobile_2" placeholder="090256 65566"
                                       aria-describedby="company_mobile_2" tabindex="2"
                                       value="{{ old('company_mobile_2') }}" maxlength="10"
                                       onkeyup="this.value=this.value.replace(/[^\d]/,'')" />
                                @error('company_mobile_2')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                               name="email" placeholder="microsoft@outlook.com" aria-describedby="email" tabindex="2"
                               value="{{ old('email') }}" />
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col">
                        <div class="form-group">
                            <label for="department_id" class="form-label">Department Type</label><span class="invalid-feedback">*</span>
                            <select class="select2-size-lg form-control" id="department_id"
                                name="department_id">
                                <option value="">Select Option</option>
                            </select>
                            @error('department_id')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="no_of_employees" class="form-label">No of Emplyees</label>
                                <select class="form-control @error('no_of_employees') is-invalid @enderror"
                                        id="no_of_employees" name="no_of_employees">
                                    <option value="">Select Option</option>
                                    <option @if (old('no_of_employees') == 'Below 10') selected="selected" @endif>Below 10</option>
                                    <option @if (old('no_of_employees') == '10-20') selected="selected" @endif>10-20</option>
                                    <option @if (old('no_of_employees') == '20-50') selected="selected" @endif>20-50</option>
                                    <option @if (old('no_of_employees') == '50-100') selected="selected" @endif>50-100</option>
                                    <option @if (old('no_of_employees') == 'More than 100') selected="selected" @endif>More than 100</option>
                                </select>
                                @error('no_of_employees')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="annual_turnover" class="form-label">Annual Turnover</label>
                                <select class="form-control @error('annual_turnover') is-invalid @enderror"
                                        id="annual_turnover" name="annual_turnover">
                                    <option value="">Select Option</option>
                                    <option @if (old('annual_turnover') == 'Below Rs. 10 Lacs') selected="selected" @endif>Below Rs. 10 Lacs</option>
                                    <option @if (old('annual_turnover') == '10-30 Lacs') selected="selected" @endif>10-30 Lacs</option>
                                    <option @if (old('annual_turnover') == '30- 60 Lacs') selected="selected" @endif>30- 60 Lacs</option>
                                    <option @if (old('annual_turnover') == '60- 100 Lacs') selected="selected" @endif>60- 100 Lacs</option>
                                    <option @if (old('annual_turnover') == '1Crore - 5 Crore') selected="selected" @endif>1Crore - 5 Crore</option>
                                    <option @if (old('annual_turnover') == 'More than 5 Crore') selected="selected" @endif>More than 5 Crore</option>
                                </select>
                                @error('annual_turnover')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="register-password" class="form-label">Password</label>
                        <div
                            class="input-group input-group-merge form-password-toggle @error('password') is-invalid @enderror">
                            <input type="password"
                                   class="form-control form-control-merge @error('password') is-invalid @enderror"
                                   id="register-password" name="password"
                                   placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                   aria-describedby="register-password" tabindex="3" />
                            <div class="input-group-append">
                                <span class="input-group-text cursor-pointer eyeButton" data-parent="register-password"><i data-feather="eye"></i></span>
                            </div>
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="register-password-confirm" class="form-label">Confirm Password</label>

                        <div class="input-group input-group-merge form-password-toggle">
                            <input type="password" class="form-control form-control-merge"
                                   id="register-password-confirm" name="password_confirmation"
                                   placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                   aria-describedby="register-password" tabindex="3" />
                            <div class="input-group-append">
                                <span class="input-group-text cursor-pointer eyeButton" data-parent="register-password-confirm"><i data-feather="eye"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="register-privacy-policy"
                                   tabindex="4" required/>
                            <label class="custom-control-label" for="register-privacy-policy">
                                I agree to <a href="javascript:void(0);">privacy policy & terms</a>
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" tabindex="5">Sign up</button>
                </form>

                <p class="text-center mt-2">
                    <span>Already have an account?</span>
                    @if (Route::has('login'))
                    <a href="{{ route('login') }}">
                        <span>Sign in instead</span>
                    </a>
                    @endif
                </p>

                {{-- <div class="divider my-2"> --}}
                    {{-- <div class="divider-text">or</div> --}}
                    {{-- </div> --}}

                {{-- <div class="auth-footer-btn d-flex justify-content-center"> --}}
                    {{-- <a href="javascript:void(0)" class="btn btn-facebook"> --}}
                        {{-- <i data-feather="facebook"></i> --}}
                        {{-- </a> --}}
                    {{-- <a href="javascript:void(0)" class="btn btn-twitter white"> --}}
                        {{-- <i data-feather="twitter"></i> --}}
                        {{-- </a> --}}
                    {{-- <a href="javascript:void(0)" class="btn btn-google"> --}}
                        {{-- <i data-feather="mail"></i> --}}
                        {{-- </a> --}}
                    {{-- <a href="javascript:void(0)" class="btn btn-github"> --}}
                        {{-- <i data-feather="github"></i> --}}
                        {{-- </a> --}}
                    {{-- </div> --}}
            </div>
        </div>
        <!-- /Register v1 -->
    </div>
</div>
@endsection

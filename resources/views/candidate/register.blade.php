@extends('layouts/fullLayoutMaster')

@section('title', 'Register Page')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection
@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-auth.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-user.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection
@section('content')
    <div class="auth-wrapper auth-v1 px-2">
        <div class="auth-inner py-2">
            <!-- Register v1 -->
            <div class="card mb-0">
                <div class="card-body">
                    {{-- <a href="javascript:void(0);" class="brand-logo">
                    <img src="{{ asset('images/logo/job_portal_logo.png') }}" alt="Logo"
                         style="width: 300px; height: 200px;">
                </a> --}}
                    <h3 class="text-center"><strong>Candidate - Signup</strong></h3>
                    <form class="auth-register-form" id="candidate" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="first_name" class="form-label">First Name</label><span class="invalid-feedback">*</span>
                                    <input type="text" class="form-control"
                                        id="first_name" name="first_name" placeholder="First Name"
                                        aria-describedby="first_name" tabindex="1" autofocus />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="last_name" class="form-label">Last Name</label><span class="invalid-feedback">*</span>
                                    <input type="text" class="form-control"
                                        id="last_name" name="last_name" placeholder="Last Name" aria-describedby="last_name"
                                        tabindex="1" autofocus />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">                                
                                <div class="form-group">
                                    <label for="dateOfBirth" class="form-label">Date of Birth</label><span class="invalid-feedback">*</span>
                                    <input type="date" class="form-control" id="dob"
                                        name="dateOfBirth" placeholder="Last Name" aria-describedby="dateOfBirth" tabindex="1"
                                        autofocus />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="gender">Gender<span class="invalid-feedback">*</span></label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="transgender">Transgender</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="permanent_address" class="form-label">Permanent Address</label><span class="invalid-feedback">*</span>
                            <input type="text" class="form-control"
                                id="permanent_address" name="permanent_address"
                                placeholder="Redmond, Washington, United States" aria-describedby="company_address"
                                tabindex="2"/>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="firstName">{{ __('Current State') }}<span class="invalid-feedback">*</span></label>
                                    <select name="state" id="state" class="select2-size-lg form-control">
                                        <option value="">Select State</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="firstName">{{ __('Current  City') }}<span class="invalid-feedback">*</span></label>
                                    <select name="city" id="city" class="select2-size-lg form-control">
                                        <option value="">Select City</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="company_mobile_1" class="form-label">Primary Number</label><span class="invalid-feedback">*</span>
                                    <input type="text" class="form-control"
                                        id="company_mobile_1" name="company_mobile_1" placeholder="090256 65566"
                                        aria-describedby="company_mobile_1" tabindex="2" maxlength="10"
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="company_mobile_2" class="form-label">Alternative Number</label>
                                    <input type="text" class="form-control"
                                        id="company_mobile_2" name="company_mobile_2" placeholder="090256 65566"
                                        aria-describedby="company_mobile_2" tabindex="2" maxlength="10"
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label><span class="invalid-feedback">*</span>
                            <input type="email" class="form-control" id="email"
                                name="email" placeholder="microsoft@outlook.com" aria-describedby="email" tabindex="2"/>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Alternate Email</label>
                            <input type="email" class="form-control" id="alt_email"
                                name="alt_email" placeholder="microsoft@outlook.com" aria-describedby="alt_email" tabindex="2" />
                        </div>
                        <div class="form-group">
                            <label>Qualification</label>
                            <div class="form-group">
                                <select class="select2-size-lg form-control" id="qualification_id"
                                    name="qualification_id">
                                    <option value="">Select Qualification</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Category</label><span class="invalid-feedback">*</span>
                            <div class="row">
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" checked type="radio" name="category" id="exampleRadios1"
                                            value="fresher">
                                        <label class="form-check-label" for="exampleRadios1">
                                            Fresher
                                        </label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="category" id="exampleRadios2"
                                            value="experienced">
                                        <label class="form-check-label" for="exampleRadios2">
                                            Experienced
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="department_id" class="form-label">Department Type</label><span class="invalid-feedback">*</span>
                            <select class="select2-size-lg form-control" id="department_id"
                                name="department_id">
                                <option value="">Select Option</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="firstName">Skills</label><span class="invalid-feedback">*</span>
                            <select  class="" id="skills" size="1" name="skills" multiple style="background-color: #fff">
                                <option>Codeigniter</option>
                                <option value="Laravel">Laravel</option>
                                <option value="YII">YII</option>
                                <option value="Zend">Zend</option>
                                <option value="Symfony">Symfony</option>
                                <option value="Phalcon">Phalcon</option>
                                <option value="Slim">Slim</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="firstName">{{ __('Preferred Job State') }}<span class="invalid-feedback">*</span></label>
                                    <select name="job_state" id="job_state" class="select2-size-lg form-control">
                                        <option value="">Select State</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="firstName">{{ __('Preferred Job City') }}<span class="invalid-feedback">*</span></label>
                                    <select name="job_city" id="job_city" class="select2-size-lg form-control">
                                        <option value="">Select City</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="about">About Me</label><span class="invalid-feedback">*</span>
                            <textarea
                                    class="form-control"
                                    id="exampleFormControlTextarea1"
                                    rows="3"
                                    placeholder="About" name="about"
                            ></textarea>
                        </div>
                        <div class="form-group">
                            <label for="register-password" class="form-label">Password</label><span class="invalid-feedback">*</span>
                            <div
                                class="input-group input-group-merge form-password-toggle">
                                <input type="password"
                                    class="form-control form-control-merge"
                                    id="register-password" name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="register-password" tabindex="3" />
                                <div class="input-group-append">
                                    <span class="input-group-text cursor-pointer eyeButton"
                                        data-parent="register-password"><i data-feather="eye"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="register-password-confirm" class="form-label">Confirm Password</label>

                            <div class="input-group input-group-merge form-password-toggle">
                                <input type="password" class="form-control form-control-merge"
                                    id="register-password-confirm" name="password_confirmation"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="register-password" tabindex="3" />
                                <div class="input-group-append">
                                    <span class="input-group-text cursor-pointer eyeButton"
                                        data-parent="register-password-confirm"><i data-feather="eye"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input name="policy" class="custom-control-input" type="checkbox" id="register-privacy" tabindex="4"/>
                                <label class="custom-control-label" for="register-privacy">
                                    I agree to <a href="javascript:void(0);">privacy policy & terms</a>
                                </label>
                            </div>
                        </div>
                        <input type="hidden" name="form_type" value="candidate">
                        <div data-callback="enableButton"  id="recaptcha-container" class="mb-1 mt-1"></div>
                        <button type="submit" disabled id="subbtn" class="btn btn-primary btn-block" tabindex="5">Sign up</button>
                    </form>
                    <div id="otpcontainer" style="display: none;">
                        <div class="form-group">
                            <label for="last_name" class="form-label">OTP</label><span
                                    class="invalid-feedback">*</span>
                            <input type="text" class="form-control" id="otp" name="otp" placeholder="Please enter your OTP!" />
                        </div>
                        <p style="font-size: 12px; margin-bottom: 3px" class="text-muted mb-0 text-sm-left">OTP Sent to your primary mobile number.</p>
                        <button type="submit" id="otpbtn" class="btn btn-primary btn-block" tabindex="5">Verify OTP</button>
                        <p class="text-center mt-2">
                            <span class="lm-2 rm-2 cursor-pointer"><a id="goback">Go back to Resend OTP</a> </span>
                        </p>
                    </div>
                    <p class="text-center mt-2">
                        <span class="lm-2 rm-2"><a href="/">Home</a> / </span>
                        <span class="lm-2 rm-2"><a href="/login">Login</a></span>
                    </p>
                </div>
                <!-- /Register v1 -->
            </div>
        </div>
    </div>
@endsection
@section('vendor-script')
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
{{-- Vendor js files --}}
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap4.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.bootstrap4.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{asset(mix('js/main/config.js'))}}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{asset(mix('js/main/candidate-register.js'))}}"></script>
@endsection

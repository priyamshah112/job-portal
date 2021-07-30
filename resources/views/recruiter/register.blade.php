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
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('content')
<div class="auth-wrapper auth-v2">
  <div class="auth-inner row m-0">
    <!-- Brand logo-->
    <a class="d-none d-lg-block brand-logo" href="javascript:void(0);">
        <img src="{{ asset('images/logo/job_portal_logo.png') }}" alt="Logo" style="width: 220px;">
    </a>
    <!-- /Brand logo-->
    <!-- Left Text-->
    <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
      <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
        <img class="img-fluid" src="{{asset('images/pages/register-v2.svg')}}" alt="Register V2" />
      </div>
    </div>
      <!-- /Left Text-->
      <!-- Register-->
    <div class="d-flex col-lg-4 align-items-center auth-bg px-1 p-lg-2">
      <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-1 mx-auto">          
        <a class="d-lg-none align-items-center justify-content-center" href="javascript:void(0);">
            <img class="w-100 p-2" src="{{ asset('images/logo/job_portal_logo1.png') }}" alt="Logo">
        </a>
        <h2 class="card-title font-weight-bold mb-1">Recruiter SignUp 🚀</h2>
        <p class="card-text mb-2">Make your app management easy and fun!</p>
        <form id="recruiter-form">
            @csrf
            <div class="row">
                <div class="col-sm-12 col-lg-6">
                  <div class="form-group">
                      <label for="first_name" class="form-label">First Name</label><span
                              class="invalid-feedback">*</span>
                      <input type="text" class="form-control"
                             id="first_name" name="first_name" placeholder="First Name" autofocus />
                  </div>
                </div>
                <div class="col-sm-12 col-lg-6">  
                  <div class="form-group">
                      <label for="last_name" class="form-label">Last Name</label><span
                              class="invalid-feedback">*</span>
                      <input type="text" class="form-control"
                             id="last_name" name="last_name" placeholder="Last Name" />
                  </div>
                </div>
            </div>
            <div class="form-group">
                <label for="company_name" class="form-label">Company Name</label><span
                        class="invalid-feedback">*</span>
                <input type="text" class="form-control"
                       id="company_name" name="company_name" placeholder="Microsoft" >
            </div>
            <div class="form-group">
                <label for="company_address" class="form-label">Company Address</label><span
                        class="invalid-feedback">*</span>
                <input type="text" class="form-control"
                       id="company_address" name="company_address"
                       placeholder="Redmond, Washington, United States" />
            </div>            
            <div class="row">
              <div class="col-sm-12 col-lg-6">
                  <div class="form-group">
                      <label for="firstName">{{ __('State') }}<span
                                  class="invalid-feedback">*</span></label>
                      <select name="state" id="state" class="form-control">
                          <option value="">Select State</option>
                      </select>
                  </div>
              </div>
              <div class="col-sm-12 col-lg-6">
                  <div class="form-group">
                      <label for="firstName">{{ __('City') }}<span
                                  class="invalid-feedback">*</span></label>
                      <select name="city" id="city" class="form-control">
                        <option value="">Select City</option>
                      </select>
                  </div>
              </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-6">
                    <div class="form-group">
                        <label for="company_landline_1" class="form-label">Landline 1</label>
                        <input type="text"
                              class="form-control"
                              id="company_landline_1" name="company_landline_1" placeholder="1800 102 1100" maxlength="14"
                              oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <div class="form-group">
                        <label for="company_landline_2" class="form-label">Landline 2</label>
                        <input type="text"
                              class="form-control"
                              id="company_landline_2" name="company_landline_2" placeholder="1800 102 1100" maxlength="14"
                              oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-6">
                    <div class="form-group">
                        <label for="mobile_number" class="form-label">Primary Number</label><span
                                class="invalid-feedback">*</span>
                        <input type="text"
                              class="form-control"
                              id="mobile_number" name="mobile_number" placeholder="090256 65566" maxlength="10"
                              oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <div class="form-group">
                        <label for="company_mobile_2" class="form-label">Alternative Number</label>
                        <input type="text"
                              class="form-control"
                              id="company_mobile_2" name="company_mobile_2" placeholder="090256 65566" maxlength="10"
                              oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Email</label><span class="invalid-feedback">*</span>
                <input type="email" class="form-control"
                       name="email" placeholder="microsoft@outlook.com"  />
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="form-group">
                        <label for="industry_segment" class="form-label">Industry Segment</label><span
                                class="invalid-feedback">*</span>
                        <select class="form-control"
                                id="industry_segment" name="industry_segment">
                            <option value="">Select Option</option>
                            <option>
                                Manufacturing
                            </option>
                            <option>
                                Service
                            </option>
                            <option>
                                Outsorcing
                            </option>
                            <option>
                                Trading/ Retail
                            </option>
                            <option>
                                Showroom
                            </option>
                            <option>
                                Distribution
                            </option>
                            <option>
                                Construction
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-6">
                    <div class="form-group">
                        <label for="no_of_employees" class="form-label">No of Emplyees</label><span
                                class="invalid-feedback">*</span>
                        <select class="form-control"
                                id="no_of_employees" name="no_of_employees">
                            <option value="">Select Option</option>
                            <option>
                                Below
                                10
                            </option>
                            <option>10-20
                            </option>
                            <option>20-50
                            </option>
                            <option>
                                50-100
                            </option>
                            <option>
                                More than
                                100
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <div class="form-group">
                        <label for="annual_turnover" class="form-label">Annual Turnover</label><span
                                class="invalid-feedback">*</span>
                        <select class="form-control"
                                id="annual_turnover" name="annual_turnover">
                            <option value="">Select Option</option>
                            <option>
                                Below
                                Rs. 10 Lacs
                            </option>
                            <option>
                                10-30
                                Lacs
                            </option>
                            <option>
                                30- 60
                                Lacs
                            </option>
                            <option>
                                60- 100
                                Lacs
                            </option>
                            <option>
                                1Crore
                                - 5 Crore
                            </option>
                            <option>
                                More
                                than 5 Crore
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
              <label for="register-password" class="form-label">Password</label><span class="invalid-feedback">*</span>
              <div class="input-group input-group-merge form-password-toggle">
                  <input type="password"
                         class="form-control form-control-merge"
                         id="register-password" name="password"
                         placeholder="············" />
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
                          placeholder="············" />
                    <div class="input-group-append">
                        <span class="input-group-text cursor-pointer eyeButton"
                              data-parent="register-password-confirm"><i data-feather="eye"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" name="policy" type="checkbox" id="register-privacy-policy"
                          tabindex="4"/>
                    <label class="custom-control-label" for="register-privacy-policy">
                        I agree to <a href="javascript:void(0);">privacy policy & terms</a>
                    </label>
                </div>
            </div>
            <input type="hidden" name="form_type" value="recruiter">
            <div data-callback="enableButton"  id="recaptcha-container" class="mb-1 mt-1"></div>
            <button type="submit" disabled id="signupbtn" class="btn btn-primary btn-block" tabindex="5">Sign up</button>
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
          <span>Already have an account?</span>
          <a href="{{route('login')}}"><span>&nbsp;Sign in instead</span></a>
        </p>
      </div>
    </div>
  <!-- /Register-->
  </div>
</div>
@endsection

@section('vendor-script')
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{asset(mix('js/main/config.js'))}}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{asset(mix('js/main/recruiter/register.js'))}}"></script>
@endsection
@extends('layouts/fullLayoutMaster')

@section('title', 'Register Page')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
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
                    <H3 class="text-center"><strong>Recruiter - Signup</strong></H3>

                    <form id="recruiter-form">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="first_name" class="form-label">First Name</label><span
                                            class="invalid-feedback">*</span>
                                    <input type="text" class="form-control"
                                           id="first_name" name="first_name" placeholder="First Name" autofocus />
                                </div>
                            </div>
                            <div class="col">
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
                            <div class="col">
                                <div class="form-group">
                                    <label for="firstName">{{ __('State') }}<span
                                                class="invalid-feedback">*</span></label>
                                    <select name="state" id="state" class="form-control">
                                        <option value="">Select State</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="firstName">{{ __('City') }}<span
                                                class="invalid-feedback">*</span></label>
                                    <select name="city" id="city" class="form-control"></select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="company_landline_1" class="form-label">Landline 1</label>
                                    <input type="text"
                                           class="form-control"
                                           id="company_landline_1" name="company_landline_1" placeholder="1800 102 1100" maxlength="14"
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                                </div>
                            </div>
                            <div class="col">
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
                            <div class="col">
                                <div class="form-group">
                                    <label for="company_mobile_1" class="form-label">Primary Number</label><span
                                            class="invalid-feedback">*</span>
                                    <input type="text"
                                           class="form-control"
                                           id="company_mobile_1" name="company_mobile_1" placeholder="090256 65566" maxlength="10"
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                                </div>
                            </div>
                            <div class="col">
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
                            <div class="col">
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
                            <div class="col">
                                <div class="form-group">
                                    <label for="industry_type" class="form-label">Industry Type</label><span
                                            class="invalid-feedback">*</span>
                                    <select class="form-control"
                                            id="industry_type" name="industry_type">
                                        <option value="">Select Option</option>
                                        <option>
                                            Banking and
                                            Insurance
                                        </option>
                                        <option>IT
                                        </option>
                                        <option>
                                            Education
                                        </option>
                                        <option>Engg
                                        </option>
                                        <option>Food
                                        </option>
                                        <option>Pharma
                                        </option>
                                        <option>
                                            Civil
                                            Construction
                                        </option>
                                        <option>
                                            Chemical
                                        </option>
                                        <option>
                                            Civil
                                            Hardware
                                        </option>
                                        <option>
                                            Consumer
                                            durables
                                        </option>
                                        <option>FMCG
                                        </option>
                                        <option>
                                            Hospitality
                                        </option>
                                        <option>
                                            Aviation
                                        </option>
                                        <option>
                                            Electronics
                                        </option>
                                        <option>
                                            Home
                                            Appliances
                                        </option>
                                        <option>Others
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
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
                            <div class="col">
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
                            <label for="register-password" class="form-label">Password</label><span
                                    class="invalid-feedback">*</span>
                            <div
                                    class="input-group input-group-merge form-password-toggle">
                                <input type="password"
                                       class="form-control form-control-merge"
                                       id="register-password" name="password"
                                       placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
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
                                       placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
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
                        <span class="lm-2 rm-2"><a href="/">Home</a> / </span>
                        <span class="lm-2 rm-2"><a href="/login">Login</a></span>
                    </p>
                </div>
            </div>
        </div>
        <!-- /Register v1 -->
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
@endsection
@section('page-script')
    <script type="text/javascript">
        var state = '';
        var city = '';
        $.getJSON("/data/statecity.json", function (json) {
            var options = Object.keys(json);
            $.each(options, function (key, value) {
                $("#state").append('<option ' + (state == value ? 'selected' : '') + ' value="' + value + '">' + value + '</option>');
            });
        });
        if (city.trim() != '') {
            setcity()
        }
        $('#state').on('change', function () {
            $("#city").html('');
            setcity();
        });

        function setcity() {
            $.getJSON("/data/statecity.json", function (json) {
                var options = Object.keys(json);
                var id = $("#state option:selected").text();
                console.log(id);
                let values = json[id];
                $.each(values, function (key, value) {
                    $("#city").append('<option ' + (city == value ? 'selected' : '') + ' value="' + value + '">' + value + '</option>');
                });
            });
        }
    </script>
<script src="{{asset(mix('js/main/recruiter-register.js'))}}"></script>
@endsection


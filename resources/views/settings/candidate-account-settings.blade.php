@extends('layouts/contentLayoutMaster')

@section('title', 'Candidate Profile')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection
@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('content')
    <!-- account setting page -->
    <section id="page-account-settings">
        <div class="row">
            <!-- left menu section -->

            <div class="col-md-3 mb-2 mb-md-0">
                <ul class="nav nav-pills flex-column nav-left">
                    <!-- general -->
                    <li class="nav-item">
                        <a class="nav-link active" id="account-pill-general" data-toggle="pill"
                            href="#account-vertical-general" aria-expanded="true">
                            <i data-feather="user" class="font-medium-3 mr-1"></i>
                            <span class="font-weight-bold">General</span>
                        </a>
                    </li>
                    <!-- change password -->
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-password" data-toggle="pill" href="#account-vertical-password"
                            aria-expanded="false">
                            <i data-feather="lock" class="font-medium-3 mr-1"></i>
                            <span class="font-weight-bold">Change Password</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!--/ left menu section -->

            <!-- right content section -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- general tab -->
                            <div role="tabpanel" class="tab-pane active" id="account-vertical-general"
                                aria-labelledby="account-pill-general" aria-expanded="true">

                                <!-- form -->
                                <form enctype="multipart/form-data" method="POST" class="update-user-details">
                                    @csrf
                                    <div class="row">
                                        <div class="media mb-2">
                                            <a href="javascript:void(0);" class="mr-25">
                                                <img src="{{ auth()->user()->img_path ? asset(auth()->user()->img_path . '/' . auth()->user()->image_name) : asset('images/portrait/small/avatar-s-11.jpg') }}"
                                                    id="account-upload-img" class="rounded mr-50" alt="profile image"
                                                    height="80" width="80" />
                                            </a>
                                            <div class="media-body mt-75 ml-1">
                                                <input type="file" name="profile_picture"
                                                    class="myfileupload @error('account-upload') @enderror btn btn-outline-primary"
                                                    accept="image/*" id="profile_picture">
                                                <p class="filetext">Select Your File(Must be .PNG .JPEG and less than 2MB)
                                                </p>
                                                @error('profile_picture')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-name">Name</label><span class="invalid-feedback">*</span>
                                                <input type="text" class="form-control" id="account-name" name="name"
                                                    placeholder="Name" value="{{ auth()->user()->first_name }}" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-e-mail">E-mail</label><span class="invalid-feedback">*</span>
                                                <input type="email" class="form-control" id="account-e-mail" name="email"
                                                    placeholder="Email" disabled value="{{ auth()->user()->email }}" />
                                            </div>
                                        </div>
                                        {{-- <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="company_name">Comapany Name</label>
                                                <input type="text" class="form-control" id="company_name"
                                                    name="company_name" placeholder="Comapany Name"
                                                    value="{{ $recruiterInfo->company_name ? $recruiterInfo->company_name : '' }}" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="company_address">Comapany Address</label>
                                                <input type="text" class="form-control" id="company_address"
                                                    name="company_address" placeholder="Comapany Address"
                                                    value="{{ $recruiterInfo->company_address ? $recruiterInfo->company_address : '' }}" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="company_phone">Contact Number</label>
                                                <input type="text" class="form-control" id="company_phone"
                                                    name="company_phone" placeholder="Contact Number" maxlength="10"
                                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                    value="{{ $recruiterInfo->company_phone ? $recruiterInfo->company_phone : '' }}" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="industry_type">Industry Type</label>
                                                <select class="form-control @error('industry_type') is-invalid @enderror"
                                                    id="industry_type" name="industry_type">
                                                    <option @if ($recruiterInfo->industry_type == 'Banking and Insurance') selected="selected" @endif>Banking
                                                        and Insurance</option>
                                                    <option @if ($recruiterInfo->industry_type == 'IT') selected="selected" @endif>IT
                                                    </option>
                                                    <option @if ($recruiterInfo->industry_type == 'Education') selected="selected" @endif>
                                                        Education</option>
                                                    <option @if ($recruiterInfo->industry_type == 'Engg') selected="selected" @endif>Engg
                                                    </option>
                                                    <option @if ($recruiterInfo->industry_type == 'Food') selected="selected" @endif>Food
                                                    </option>
                                                    <option @if ($recruiterInfo->industry_type == 'Pharma') selected="selected" @endif>Pharma
                                                    </option>
                                                    <option @if ($recruiterInfo->industry_type == 'Civil Construction') selected="selected" @endif>Civil
                                                        Construction</option>
                                                    <option @if ($recruiterInfo->industry_type == 'Chemical') selected="selected" @endif>Chemical
                                                    </option>
                                                    <option @if ($recruiterInfo->industry_type == 'Civil Hardware') selected="selected" @endif>Civil
                                                        Hardware</option>
                                                    <option @if ($recruiterInfo->industry_type == 'Consumer durables') selected="selected" @endif>Consumer
                                                        durables</option>
                                                    <option @if ($recruiterInfo->industry_type == 'FMCG') selected="selected" @endif>FMCG
                                                    </option>
                                                    <option @if ($recruiterInfo->industry_type == 'Hospitality') selected="selected" @endif>
                                                        Hospitality</option>
                                                    <option @if ($recruiterInfo->industry_type == 'Aviation') selected="selected" @endif>Aviation
                                                    </option>
                                                    <option @if ($recruiterInfo->industry_type == 'Electronics') selected="selected" @endif>
                                                        Electronics</option>
                                                    <option @if ($recruiterInfo->industry_type == 'Home Appliances') selected="selected" @endif>Home
                                                        Appliances</option>
                                                    <option @if ($recruiterInfo->industry_type == 'Others') selected="selected" @endif>Others
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="no_of_employees">No of Employees</label>
                                                <select class="form-control @error('no_of_employees') is-invalid @enderror"
                                                    id="no_of_employees" name="no_of_employees">
                                                    <option @if ($recruiterInfo->no_of_employees == 'Below 10') selected="selected" @endif>Below 10
                                                    </option>
                                                    <option @if ($recruiterInfo->no_of_employees == '10-20') selected="selected" @endif>10-20
                                                    </option>
                                                    <option @if ($recruiterInfo->no_of_employees == '20-50') selected="selected" @endif>20-50
                                                    </option>
                                                    <option @if ($recruiterInfo->no_of_employees == '50-100') selected="selected" @endif>50-100
                                                    </option>
                                                    <option @if ($recruiterInfo->no_of_employees == 'More than 100') selected="selected" @endif>More
                                                        than 100</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="annual_turnover">Annual Turnover</label>
                                                <select class="form-control @error('annual_turnover') is-invalid @enderror"
                                                    id="annual_turnover" name="annual_turnover">
                                                    <option @if ($recruiterInfo->annual_turnover == 'Below Rs. 10 Lacs') selected="selected" @endif>Below
                                                        Rs. 10 Lacs</option>
                                                    <option @if ($recruiterInfo->annual_turnover == '10-30 Lacs') selected="selected" @endif>10-30
                                                        Lacs</option>
                                                    <option @if ($recruiterInfo->annual_turnover == '30- 60 Lacs') selected="selected" @endif>30- 60
                                                        Lacs</option>
                                                    <option @if ($recruiterInfo->annual_turnover == '60- 100 Lacs') selected="selected" @endif>60- 100
                                                        Lacs</option>
                                                    <option @if ($recruiterInfo->annual_turnover == '1Crore - 5 Crore') selected="selected" @endif>1Crore -
                                                        5 Crore</option>
                                                    <option @if ($recruiterInfo->annual_turnover == 'More than 5 Crore') selected="selected" @endif>More
                                                        than 5 Crore</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="annual_turnover">Industry Segment</label>
                                                <select class="form-control @error('industry_segment') is-invalid @enderror"
                                                    id="industry_segment" name="industry_segment">
                                                    <option @if ($recruiterInfo->industry_segment == 'Manufacturing') selected="selected" @endif>
                                                        Manufacturing</option>
                                                    <option @if ($recruiterInfo->industry_segment == 'Service') selected="selected" @endif>Service
                                                    </option>
                                                    <option @if ($recruiterInfo->industry_segment == 'Outsorcing') selected="selected" @endif>
                                                        Outsorcing</option>
                                                </select>
                                            </div>
                                        </div> --}}
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary mt-2 mr-1 data-submit">Save
                                                changes</button>
                                            <button type="reset" class="btn btn-outline-secondary mt-2"
                                                hidden>Cancel</button>
                                        </div>
                                    </div>
                                </form>
                                <!--/ form -->
                            </div>
                            <!--/ general tab -->

                            <!-- change password -->
                            <div class="tab-pane fade" id="account-vertical-password" role="tabpanel"
                                aria-labelledby="account-pill-password" aria-expanded="false">
                                <!-- form -->
                                <form class="change-password" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-old-password">Old Password</label><span class="invalid-feedback">*</span>
                                                <div class="input-group form-password-toggle input-group-merge">
                                                    <input type="password" class="form-control" id="account-old-password"
                                                        name="old_password" placeholder="Old Password" autocomplete />
                                                    <div class="input-group-append">
                                                        <div class="input-group-text cursor-pointer eyeButton" 
                                                        data-parent="account-old-password">
                                                            <i data-feather="eye"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-new-password">New Password</label><span class="invalid-feedback">*</span>
                                                <div class="input-group form-password-toggle input-group-merge">
                                                    <input type="password" id="account-new-password" name="new_password"
                                                        class="form-control" placeholder="New Password" autocomplete />
                                                    <div class="input-group-append">
                                                        <div class="input-group-text cursor-pointer eyeButton"
                                                        data-parent="account-new-password">
                                                            <i data-feather="eye"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-retype-new-password">Retype New Password</label><span class="invalid-feedback">*</span>
                                                <div class="input-group form-password-toggle input-group-merge">
                                                    <input type="password" class="form-control"
                                                        id="account-retype-new-password" name="confirm_password"
                                                        placeholder="New Password" autocomplete />
                                                    <div class="input-group-append">
                                                        <div class="input-group-text cursor-pointer eyeButton"
                                                        data-parent="account-retype-new-password"><i
                                                                data-feather="eye"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary mr-1 mt-1 data-submit">Save
                                                changes</button>
                                            <button type="reset" class="btn btn-outline-secondary mt-1">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                                <!--/ form -->
                            </div>
                            <!--/ change password -->
                        </div>
                    </div>
                </div>
            </div>
            <!--/ right content section -->
        </div>
    </section>
    <!-- / account setting page -->
@endsection

@section('vendor-script')
    <!-- vendor files -->
    {{-- select2 min js --}}
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    {{-- jQuery Validation JS --}}
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection
@section('page-script')
<!-- Page js files -->
<script src="{{ asset(mix('js/main/candidate-settings.js')) }}"></script>
@endsection

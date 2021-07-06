@extends('layouts/contentLayoutMaster')

@section('title', 'Recruiter Profile')

@section('vendor-style')
<!-- vendor css files -->
<link rel='stylesheet' href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
<link rel='stylesheet' href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">
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
    @if (session()->has('success-message'))
        <div class="alert-box alert-success" id="success">
            {{ session()->get('success-message') }}
        </div>
    @endif
    @if (session()->has('error-message'))
        <div class="alert alert-danger">
            {{ session()->get('error-message') }}
        </div>
    @endif
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
                        <a class="nav-link" id="account-pill-password" data-toggle="pill"
                           href="#account-vertical-password"
                           aria-expanded="false">
                            <i data-feather="lock" class="font-medium-3 mr-1"></i>
                            <span class="font-weight-bold">Change Password</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-attachments" data-toggle="pill"
                           href="#account-vertical-attachments"
                           aria-expanded="false">
                            <i data-feather="file" class="font-medium-3 mr-1"></i>
                            <span class="font-weight-bold">Attachments</span>
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
                                <form class="update-user-details" enctype="multipart/form-data" method="POST"
                                      action="{{ route('changeRecruiterInfo') }}">
                                    <div class="row">
                                        <div class="media mb-2">
                                            <a href="javascript:void(0);" class="mr-25">
                                                <img src="{{ auth()->user()->img_path ? asset(auth()->user()->img_path . '/' . auth()->user()->image_name) : asset('images/portrait/small/avatar-s-11.jpg') }}"
                                                     id="account-upload-img" class="rounded mr-50" alt="profile image"
                                                     height="80" width="80"/>
                                            </a>
                                            <div class="media-body mt-75 ml-1">
                                                <input type="file" name="profile_picture"
                                                       class="myfileupload btn btn-outline-primary"
                                                       accept="image/*" id="profile_picture">
                                                <p class="filetext">Select Your File(Must be .PNG .JPEG and less than
                                                    2MB)
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-name">First Name<span
                                                            class="invalid-feedback">*</span></label>
                                                <input type="text" class="form-control" id="account-name" name="first_name"
                                                       placeholder="Name" value="{{ auth()->user()->first_name }}"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-name">Last Name<span
                                                            class="invalid-feedback">*</span></label>
                                                <input type="text" class="form-control" id="account-name" name="last_name"
                                                       placeholder="Name" value="{{ auth()->user()->last_name }}"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-e-mail">E-mail<span
                                                            class="invalid-feedback">*</span></label>
                                                <input type="email" class="form-control" id="account-e-mail"
                                                       name="email"
                                                       placeholder="Email" disabled
                                                       value="{{ auth()->user()->email }}"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="company_name">Company Name</label>
                                                <input type="text" class="form-control" id="company_name"
                                                       name="company_name" placeholder="Comapany Name"
                                                       value="{{ $recruiterInfo->company_name ? $recruiterInfo->company_name : '' }}"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">

                                            <label for="firstName">{{ __('State') }}<span
                                                        class="invalid-feedback">*</span></label>
                                            <select name="state" id="state" class="form-control">
                                                <option value="">Select State</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="firstName">{{ __('City') }}<span
                                                            class="invalid-feedback">*</span></label>
                                                <select name="city" id="city" class="form-control"></select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="company_landline_1">Contact Landline 1</label>
                                                <input type="text" class="form-control" id="company_landline_1"
                                                       name="company_landline_1" placeholder="Contact Landline 1"
                                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                       value="{{ $recruiterInfo->company_landline_1 ? $recruiterInfo->company_landline_1 : '' }}"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="company_landline_2">Contact Landline 2</label>
                                                <input type="text" class="form-control" id="company_landline_2"
                                                       name="company_landline_2" placeholder="Contact Landline 2"
                                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                       value="{{ $recruiterInfo->company_landline_2 ? $recruiterInfo->company_landline_2 : '' }}"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="company_mobile_1">Primary Number<span
                                                            class="invalid-feedback">*</span></label>
                                                <input type="text" class="form-control" id="company_mobile_1"
                                                       readonly
                                                       name="company_mobile_1" placeholder="Mobile 1"
                                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                       value="{{ auth()->user()->mobile_number ? auth()->user()->mobile_number : '' }}"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="company_mobile_2">Alternative Number</label>
                                                <input type="text" class="form-control" id="company_mobile_2"
                                                       name="company_mobile_2" placeholder="090256 65566"
                                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                       value="{{ $recruiterInfo->company_mobile_2 ? $recruiterInfo->company_mobile_2 : '' }}"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="department_id">Department Type
                                                    <span class="invalid-feedback">*</span>
                                                </label>
                                                <select class="select2-size-lg form-control" id="department_id"
                                                    name="department_id">
                                                    <option value="">Select Option</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="no_of_employees">No of Employees<span
                                                            class="invalid-feedback">*</span></label>
                                                <select class="form-control"
                                                        id="no_of_employees" name="no_of_employees">
                                                    <option @if ($recruiterInfo->no_of_employees == 'Below 10') selected="selected" @endif>
                                                        Below 10
                                                    </option>
                                                    <option @if ($recruiterInfo->no_of_employees == '10-20') selected="selected" @endif>
                                                        10-20
                                                    </option>
                                                    <option @if ($recruiterInfo->no_of_employees == '20-50') selected="selected" @endif>
                                                        20-50
                                                    </option>
                                                    <option @if ($recruiterInfo->no_of_employees == '50-100') selected="selected" @endif>
                                                        50-100
                                                    </option>
                                                    <option @if ($recruiterInfo->no_of_employees == 'More than 100') selected="selected" @endif>
                                                        More
                                                        than 100
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="annual_turnover">Annual Turnover<span
                                                            class="invalid-feedback">*</span></label>
                                                <select class="form-control"
                                                        id="annual_turnover" name="annual_turnover">
                                                    <option @if ($recruiterInfo->annual_turnover == 'Below Rs. 10 Lacs') selected="selected" @endif>
                                                        Below
                                                        Rs. 10 Lacs
                                                    </option>
                                                    <option @if ($recruiterInfo->annual_turnover == '10-30 Lacs') selected="selected" @endif>
                                                        10-30
                                                        Lacs
                                                    </option>
                                                    <option @if ($recruiterInfo->annual_turnover == '30- 60 Lacs') selected="selected" @endif>
                                                        30- 60
                                                        Lacs
                                                    </option>
                                                    <option @if ($recruiterInfo->annual_turnover == '60- 100 Lacs') selected="selected" @endif>
                                                        60- 100
                                                        Lacs
                                                    </option>
                                                    <option @if ($recruiterInfo->annual_turnover == '1Crore - 5 Crore') selected="selected" @endif>
                                                        1Crore -
                                                        5 Crore
                                                    </option>
                                                    <option @if ($recruiterInfo->annual_turnover == 'More than 5 Crore') selected="selected" @endif>
                                                        More
                                                        than 5 Crore
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="annual_turnover">Industry Segment<span
                                                            class="invalid-feedback">*</span></label>
                                                <select class="form-control"
                                                        id="industry_segment" name="industry_segment">
                                                    <option @if ($recruiterInfo->industry_segment == 'Manufacturing') selected="selected" @endif>
                                                        Manufacturing
                                                    </option>
                                                    <option @if ($recruiterInfo->industry_segment == 'Service') selected="selected" @endif>
                                                        Service
                                                    </option>
                                                    <option @if ($recruiterInfo->industry_segment == 'Outsorcing') selected="selected" @endif>
                                                        Outsorcing
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 text-right">
                                            <button type="submit" class="btn btn-primary mt-2 mr-1 data-submit">Save
                                                changes
                                            </button>
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
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-old-password">Old Password</label>
                                                <div class="input-group form-password-toggle input-group-merge">
                                                    <input type="password" class="form-control"
                                                           id="account-old-password"
                                                           name="old_password" placeholder="Old Password" autocomplete/>
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
                                                <label for="account-new-password">New Password</label>
                                                <div class="input-group form-password-toggle input-group-merge">
                                                    <input type="password" id="account-new-password" name="new_password"
                                                           class="form-control" placeholder="New Password"
                                                           autocomplete/>
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
                                                <label for="account-retype-new-password">Retype New Password</label>
                                                <div class="input-group form-password-toggle input-group-merge">
                                                    <input type="password" class="form-control"
                                                           id="account-retype-new-password" name="confirm_password"
                                                           placeholder="New Password" autocomplete/>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text cursor-pointer eyeButton"
                                                             data-parent="account-retype-new-password"><i
                                                                    data-feather="eye"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 text-right">
                                            <button type="submit" class="btn btn-primary mr-1 mt-1 data-submit">Save
                                                changes
                                            </button>
                                            <button type="reset" class="btn btn-outline-secondary mt-1">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                                <!--/ form -->
                            </div>
                            <div role="tabpanel" class="tab- fade" id="account-vertical-attachments"
                                 aria-labelledby="account-pill-general">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Add your Attachments Here!</h4>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text">
                                                    Supported Files: Images, Pdf.
                                                </p>
                                                <form action="#" class="dropzone dropzone-area" id="dpz-multiple-files1">
                                                    <div class="dz-message">Drop files here or click to upload.</div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h4>Attachments : </h4>
                                <hr>
                                @if(count($recruiterInfo->attachments)>0)
                                <div id="myatt" class="myattachments">
                                    @foreach($recruiterInfo->attachments as $att)
                                        <div class="media mb-1 previtem">
                                            @if(strtolower($att->extension) == 'pdf')
                                            <img src="{{asset('images/icons/pdf.png')}}"  class="mr-1" alt="pdf" height="50" width="40">
                                            @else
                                            <img src="{{asset('images/icons/img.png')}}"  class="mr-1" alt="pdf" height="50" width="40">
                                            @endif
                                            <div class="media-body">
                                                <h5 class="mb-1 font-weight-bold text-break">{{$att->file_name}}</h5>
                                                <p>
                                                    <button onclick="removeFile('{{$att->id}}', this)" class="btn btn-danger btn-sm mr-1"><i data-feather="trash-2"></i> Remove</button>
                                                    <button onclick="preview('{{$att->file_path}}', '{{$att->extension}}')" class="btn btn-primary btn-sm mr-1"><i data-feather="eye"></i> View</button>
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @else
                                <div id="myatt" class="myattachments">No Attachments Found</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ right content section -->
        </div>
    </section>
    <!-- / account setting page -->
<div class="modal" id="previewmodal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attachment Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="previewHolder"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('vendor-script')
{{-- select2 min js --}}
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
{{-- jQuery Validation JS --}}
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>

@endsection
@section('page-script')
<style>
    .file {
        position: relative;
        background: linear-gradient(to right, lightblue 50%, transparent 50%);
        background-size: 200% 100%;
        background-position: right bottom;
        transition:all 1s ease;
    }
    .file.done {
        background: lightgreen;
    }
    .file a {
        display: block;
        position: relative;
        padding: 5px;
        color: black;
    }
</style>
    <!-- Page js files -->
<script src="{{asset(mix('js/main/config.js'))}}"></script>
    <script>
        $(document).ready(function () {
            $("#success").delay(5000).slideUp(300);
        });
        var state = '{!! old('state', $recruiterInfo->state) !!}';
        var city = '{!! old('city', $recruiterInfo->city) !!}';
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
<script src="{{ asset(mix('js/main/recruiter-profile.js')) }}"></script>
@endsection

@extends('layouts/contentLayoutMaster')

@section('title', 'Recruiters')

@section('vendor-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap4.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">
@endsection

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-user.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('content')
<div class="float-right" style="margin-top: -50px">
    <a href="{{route('recruiters')}}" class="btn btn-primary">Back</a>
</div>
<!-- cateory list start -->
<section class="app-category-list">
    <!-- list section start -->
    <div class="card">
        <div class="card-body tab-content">
            @if(!$user)
            <h4 class="text-center">Invalid Recruiter!</h4>
            @else
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item">
                    <a
                            class="nav-link d-flex align-items-center active"
                            id="account-tab"
                            data-toggle="tab"
                            href="#account"
                            aria-controls="account"
                            role="tab"
                            aria-selected="true"
                    >
                        <i data-feather="user"></i><span class="d-none d-sm-block">Account</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                            class="nav-link d-flex align-items-center"
                            id="information-tab"
                            data-toggle="tab"
                            href="#information"
                            aria-controls="information"
                            role="tab"
                            aria-selected="false"
                    >
                        <i data-feather="info"></i><span class="d-none d-sm-block">Company Info</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                            class="nav-link d-flex align-items-center"
                            id="att-tab"
                            data-toggle="tab"
                            href="#attachments"
                            aria-controls="attachments"
                            role="tab"
                            aria-selected="false"
                    >
                        <i data-feather="file"></i><span class="d-none d-sm-block">Attachments</span>
                    </a>
                </li>
            </ul>
            <!-- Account Tab starts -->
            <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                <form id="admin-recruiter-edit-form-1">
                    <div class="row mt-2">
                        <div class="col-12">
                            <h4 class="mb-1">
                                <i data-feather="user" class="font-medium-4 mr-25"></i>
                                <span class="align-middle">Personal Information</span>
                            </h4>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            @if($user->img_path == null && $user->img_name ==null)
                            <img class="round mr-1" src="/images/avatars/default_user.jpeg" alt="avatar"
                                 height="100px"
                                 width="100px">
                            @else
                            <img class="round mr-1" src='/{{$user->img_path}}/{{$user->image_name}}'
                                 height="100px"
                                 width="100px">
                            @endif
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="first_name">First Name</label><span
                                        class="invalid-feedback">*</span>
                                <input type="text" class="form-control" value='{{$user->first_name}}'
                                       name="first_name" id="first_name"
                                />
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="lastName">Last Name</label><span
                                        class="invalid-feedback">*</span>
                                <input type="text" class="form-control" value='{{$user->last_name}}'
                                       name="last_name"
                                       id="last_name"
                                />
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label><span class="invalid-feedback">*</span>
                                <input type="email" class="form-control" value='{{$user->email}}'
                                       name="email"
                                       id="email" readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="mobile">Mobile</label><span class="invalid-feedback">*</span>
                                <input type="text" class="form-control" value='{{$user->mobile_number}}'
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       name="mobile_number" id="mobile_number"
                                />
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="status">Status</label><span class="invalid-feedback">*</span>
                                <select class="form-control"
                                        id="status" name="status">
                                    <option value="1"
                                            {{ $user->active == 1 ? 'selected' : ''}}>Active
                                    </option>
                                    <option value="0"
                                            {{ $user->active == 0 ? 'selected' : ''}}>InActive
                                    </option>
                                    <option value="2"
                                            {{ $user->active == 2 ? 'selected' : ''}}>Blocked
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="text-right col-12">
                            <input type="hidden" name="id" value="{{$user->id}}">
                            <button type="submit" id="data-submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane" id="information" aria-labelledby="information-tab" role="tabpanel">
                <form id="admin-recruiter-edit-form-2"">
                    <div class="row mt-2">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="companyName">Company Name</label><span class="invalid-feedback">*</span>
                                <input type="text" class="form-control"
                                       value='{{$user->recruiter->company_name}}'
                                       name="company_name" id="company_name"/>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="address">Company Address</label><span
                                        class="invalid-feedback">*</span>
                                <input type="text" class="form-control"
                                       value='{{$user->recruiter->company_address}}'
                                       name="company_address" id="company_address"/>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="company_landline_1">Company Landline 1</label>
                                <input type="number" class="form-control"
                                       value='{{$user->recruiter->company_landline_1}}'
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       name="company_landline_1" id="company_landline_1"/>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="company_landline_2">Company Landline 2</label>
                                <input type="number" class="form-control"
                                       value='{{$user->recruiter->company_landline_2}}'
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       name="company_landline_2" id="company_landline_2"/>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="company_mobile_1">Company Primary Number</label><span
                                class="invalid-feedback">*</span>
                                <input type="number" class="form-control"
                                       value='{{$user->recruiter->company_mobile_1}}'
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       name="company_mobile_1" id="company_mobile_1"/>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="company_mobile_2">Company Alternative Number</label>
                                <input type="number" class="form-control"
                                       value='{{$user->recruiter->company_mobile_2}}'
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       name="company_mobile_2" id="company_mobile_2"/>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="state">{{ __('State') }}<span
                                            class="invalid-feedback">*</span></label>
                                <select name="state" id="state" class="form-control">
                                    <option value="">Select State</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="city">{{ __('City') }}<span
                                            class="invalid-feedback">*</span></label>
                                <select name="city" id="city" class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label>Department Type</label><span class="invalid-feedback">*</span>
                                <select class="select2-size-lg form-control" id="department_id"
                                    name="department_id">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="employee">No of Employees</label><span class="invalid-feedback">*</span>
                                <select class="form-control"
                                        id="no_of_employees" name="no_of_employees">
                                    <option @if ($user->recruiter->no_of_employees == 'Below 10')
                                        selected="selected" @endif>Below 10
                                    </option>
                                    <option @if ($user->recruiter->no_of_employees == '10-20') selected="selected"
                                        @endif>10-20
                                    </option>
                                    <option @if ($user->recruiter->no_of_employees == '20-50') selected="selected"
                                        @endif>20-50
                                    </option>
                                    <option @if ($user->recruiter->no_of_employees == '50-100') selected="selected"
                                        @endif>50-100
                                    </option>
                                    <option @if ($user->recruiter->no_of_employees == 'More than 100')
                                        selected="selected" @endif>More than 100
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="turnover">Annual Turnover</label><span class="invalid-feedback">*</span>
                                <select class="form-control"
                                        id="annual_turnover" name="annual_turnover">
                                    <option @if ($user->recruiter->annual_turnover == 'Below Rs. 10 Lacs')
                                        selected="selected" @endif>Below Rs. 10 Lacs
                                    </option>
                                    <option @if ($user->recruiter->annual_turnover == '10-30 Lacs')
                                        selected="selected" @endif>10-30 Lacs
                                    </option>
                                    <option @if ($user->recruiter->annual_turnover == '30- 60 Lacs')
                                        selected="selected" @endif>30- 60 Lacs
                                    </option>
                                    <option @if ($user->recruiter->annual_turnover == '60- 100 Lacs')
                                        selected="selected" @endif>60- 100 Lacs
                                    </option>
                                    <option @if ($user->recruiter->annual_turnover == '1Crore - 5 Crore')
                                        selected="selected" @endif>1Crore - 5 Crore
                                    </option>
                                    <option @if ($user->recruiter->annual_turnover == 'More than 5 Crore')
                                        selected="selected" @endif>More than 5 Crore
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="docName">Document Name</label>
                                <input type="text" class="form-control"
                                       value='{{$user->recruiter->doc_name}}'
                                       name="doc_name" id="doc_name"/>
                            </div>
                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="text-right col-12">
                            <input type="hidden" name="id" value="{{$user->id}}">
                            <button type="submit" id="data-submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane" id="attachments" aria-labelledby="information-tab" role="tabpanel">
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
                @if(count($user->recruiter->attachments)>0)
                <div id="myatt" class="myattachments">
                    @foreach($user->recruiter->attachments as $att)
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
        @endif
    </div>
    </div>
    <!-- list section end -->
</section>
<!-- category list ends -->

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
{{-- Vendor js files --}}
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
<script src="{{asset(mix('js/main/config.js'))}}"></script>
@endsection

@section('page-script')
<script>
    $(document).ready(function () {
        $("#success").delay(5000).slideUp(300);
    });
    $(document).ready(function () {
        $("#error").delay(5000).slideUp(300);
    });
    feather.replace();
    let state = '{!! old('state', $user->recruiter->state) !!}';
    let city = '{!! old('city', $user->recruiter->city) !!}';
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
<script id="psc" data-id="{{$user->recruiter->id}}" src="{{asset(mix('js/main/admin/recruiter-edit.js'))}}">
    @endsection

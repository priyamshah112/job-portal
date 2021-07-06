@extends('layouts.contentLayoutMaster')

@section('title', 'Job Fair')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap4.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">>
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
@endsection

@section('content')
<!-- Vertical Wizard -->
<div class="float-right" style="margin-top: -50px">
    <a href="{{ url('/job-fair') }}" class="btn btn-primary">Back</a>
</div>
<section>
    <div class="card p-2">
        <form id="job-fair-create-form" method='post' files=true enctype='multipart/form-data'>
            @csrf
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="form-group">
                        <label for="name" class="form-label">Fair Name*</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="" />
                    </div>
                </div>            
                <div class="col-lg-4 col-md-6">
                    <label for="description" class="form-label">Description*</label>
                    <textarea class="form-control" rows="2" id="description"
                        placeholder="Description" name="description"
                    ></textarea>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="form-group">
                        <label for="img_name" class="form-label">Banner Image*</label>
                        <input type="file" class="form-control" name="img_name" id="img_name" />
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-lg-4 col-md-6">
                    <div class="form-group">
                        <label for="organizer_name" class="form-label">Organizer Name*</label>
                        <input type="text" class="form-control" id="organizer_name" name="organizer_name" placeholder="Name" value="" />
                    </div>
                </div>  
                <div class="col-lg-4 col-md-6">
                    <div class="form-group">
                        <label for="address" class="form-label">Fair Address*</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="" />
                    </div>
                </div>  
                <div class="col-lg-4 col-md-6">
                    <div class="form-group">
                        <label for="mobile_number" class="form-label">Mobile Number*</label>                        <input type="text"
                            class="form-control"
                            id="mobile_number" name="mobile_number" placeholder="90256 65566" maxlength="10"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                    </div>
                </div> 
            </div>
            <div class="row mt-1"> 
                <div class="col-lg-4 col-md-6">
                    <div class="form-group">
                        <label for="email" class="form-label">Email*</label>
                        <input type="email" class="form-control" name="email" placeholder="xyx@jobportal.com" />
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="form-group">
                        <label for="type" class="form-label">Type*</label>
                        <select class="form-control" id="type" name="type">
                            <option value="">Select Options</option>
                            <option value="online">Online</option>
                            <option value="offline">Offline</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="form-group">
                        <label for="price" class="form-label">Price*</label>
                        <select class="form-control" id="price" name="price">
                            <option value="">Select Options</option>
                            <option value="free">Free</option>
                            <option value="price">Price</option>
                        </select>
                    </div>
                </div>  
            </div>
            <div class="row mt-1">
                <div class="col-lg-4 col-md-6">
                    <div class="form-group">
                        <label for="number_of_days" class="form-label">Number Of Days*</label>                        
                        <input type="text"
                            class="form-control"
                            id="number_of_days" name="number_of_days" placeholder="2"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                    </div>
                </div> 
                <div class="col-lg-4 col-md-6">
                    <div class="form-group">
                        <label for="start_date" class="form-label">Start Date*</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"/>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="form-group">
                        <label for="end_date" class="form-label">End Date*</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"/>
                    </div>
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-lg-4 col-md-6">
                    <div class="form-group">
                        <label for="start_time" class="form-label">Start Time*</label>
                        <input type="time" class="form-control" id="start_time" name="start_time"/>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="form-group">
                        <label for="end_time" class="form-label">End Time*</label>
                        <input type="time" class="form-control" id="end_time" name="end_time"/>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="form-group">
                        <label for="department_id" class="form-label">Department Type*</label>
                        <select class="select2-size-lg form-control" id="department_id"
                            name="department_id">
                            <option value="">Select Option</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label for="additional_info" class="form-label">Additional Info</label>
                    <textarea class="form-control" rows="2" id="additional_info"
                        placeholder="Additional Info" name="additional_info"
                    ></textarea>
                </div>
            </div>
            <div class="text-right mt-2">
                <button type="submit" id="data-submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</section>
<!-- /Vertical Wizard -->
@endsection

@section('vendor-script')
<!-- vendor files -->

<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{asset(mix('js/main/config.js'))}}"></script>
@endsection
@section('page-script')
<!-- Page js files -->
<script src="{{asset(mix('js/main/admin/job-fair-create.js'))}}">
@endsection

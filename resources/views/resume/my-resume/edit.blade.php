@extends('layouts.contentLayoutMaster')

@section('title', 'Edit My Resume')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-user.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-file-uploader.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
@endsection

@section('content')
<!-- Vertical Wizard --> 
@php
    $category = $candidate->category == 'fresher' || $candidate->category == "" ? 'fresher' : 'experience';
@endphp
<section class="modern-vertical-wizard">
    <div class="bs-stepper vertical wizard-modern modern-vertical-wizard-resume">
        <div class="bs-stepper-header">
            <div class="step" data-target="#personal-info-vertical-modern">
                <button type="button" class="step-trigger">
                <span class="bs-stepper-box">
                    <i data-feather="user" class="font-medium-3"></i>
                </span>
                <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Personal Info</span>
                    <span class="bs-stepper-subtitle">Add Personal Info</span>
                </span>
                </button>
            </div>
            <div class="step" data-target="#qualification-vertical-modern">
                <button type="button" class="step-trigger">
                <span class="bs-stepper-box">
                    <i data-feather="layers" class="font-medium-3"></i>
                </span>
                <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Qualifications</span>
                    <span class="bs-stepper-subtitle">Add Qualifications</span>
                </span>
                </button>
            </div>
            <div class="step" data-target="#address-step-vertical-modern">
                <button type="button" class="step-trigger">
                <span class="bs-stepper-box">
                    <i data-feather="map-pin" class="font-medium-3"></i>
                </span>
                <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Address</span>
                    <span class="bs-stepper-subtitle">Add Address</span>
                </span>
                </button>
            </div>
            <div class="step" data-target="#contact-vertical-modern">
                <button type="button" class="step-trigger">
                <span class="bs-stepper-box">
                    <i data-feather="phone" class="font-medium-3"></i>
                </span>
                <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Contact</span>
                    <span class="bs-stepper-subtitle">Add Contacts</span>
                </span>
                </button>
            </div>
        </div>
        <div class="bs-stepper-content pt-2">
            <div id="personal-info-vertical-modern" class="content">
                <form class="personal-info-form">
                    <div class="content-header">
                        <h5 class="mb-0">Personal Info</h5>
                        <small>Enter Your Personal Info.</small>
                    </div>
                    <div class="row mt-1 ml-0 mr-0">
                        <div class="media">
                            <a href="javascript:void(0);" class="mr-25">
                                <img src="{{ auth()->user()->img_path ? asset(auth()->user()->img_path . '/' . auth()->user()->image_name) : asset('images/portrait/small/avatar-s-11.jpg') }}"
                                    id="account-upload-img" class="rounded mr-50" alt="profile image"
                                    height="80" width="80"/>
                            </a>
                            <div class="media-body mt-75 ml-1">
                                <input type="file" name="img_name"
                                    class="myfileupload btn btn-outline-primary"
                                    accept="image/*" id="img_name">
                                <p class="filetext">Select Your File(Must be .PNG .JPEG)
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="first_name" class="form-label">First Name</label><span class="invalid-feedback">*</span>
                                <input type="text"
                                    class="form-control"
                                    id="first_name" name="first_name" placeholder="First Name"
                                    value="{{ old('first_name',$candidate->user->first_name)}}"
                                />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="last_name" class="form-label">Last Name</label><span class="invalid-feedback">*</span>
                                <input type="text" class="form-control"
                                    id="last_name" name="last_name" placeholder="Last Name"
                                    value="{{ old('last_name',$candidate->user->last_name)}}"
                                />                            
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">                    
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="dateOfBirth" class="form-label">Date of Birth</label><span class="invalid-feedback">*</span>
                                <input class="form-control"
                                    id="dateOfBirth" name="dateOfBirth" placeholder="Last Name" 
                                    value="{{ $candidate->dateOfBirth }}"
                                />                            
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="gender">Gender<span class="invalid-feedback">*</span></label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option value="male" @if ($candidate->gender == 'male') selected="selected" @endif>Male</option>
                                    <option value="female" @if ($candidate->gender == 'female') selected="selected" @endif>Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1 mb-1">                    
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="about" class="form-label">About</label><span class="invalid-feedback">*</span>
                                <textarea class="form-control"
                                    rows="3" id="about"
                                    placeholder="About" name="about"
                                >{{ old('test',$candidate->about)}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-personal-update ">
                            <span class="align-middle d-sm-inline-block d-none">Update Personal Info</span>
                            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div id="address-step-vertical-modern" class="content">
                <form class="address-form">
                    <div class="content-header">
                        <h5 class="mb-0">Address</h5>
                        <small>Enter Your Address.</small>
                    </div>
                    <div class="row mt-2">                    
                        <div class="col-12">
                            <div class="form-group">
                                <label for="permanent_address" class="form-label">Permanent Address</label><span class="invalid-feedback">*</span>
                                <input type="text" class="form-control"
                                    id="permanent_address" name="permanent_address"
                                    placeholder="Redmond, Washington, United States"
                                    value="{{ old('permanent_address',$candidate->permanent_address) }}"
                                />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="state">{{ __('State') }}<span class="invalid-feedback">*</span></label>
                                <select name="state" id="state" class="form-control" previous-selected="{{$candidate->state}}">
                                    <option value="">Select State</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="city">{{ __('City') }}<span
                                            class="invalid-feedback">*</span></label>
                                <select name="city" id="city" class="form-control" previous-selected="{{$candidate->city}}">
                                    <option value="">Select City</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    @php
                        $state = $candidate->preferred_state !== null ? json_decode($candidate->preferred_state) : [];
                        $city = $candidate->preferred_city !== null ? json_decode($candidate->preferred_city) : [];
                    @endphp
                    <small>Add Preferred Locations</small>
                    <div class="row mt-1">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="preferred_state_1" class="form-label">Job Location State</label>
                                <span class="invalid-feedback">*</span>
                                <select name="preferred_state_1" id="preferred_state_1" class="form-control" previous-selected="{{count($state) > 0 ? $state[0] : ''}}">
                                    <option value="">Select State</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="preferred_city_1" class="form-label">Job Location City</label>
                                <span class="invalid-feedback">*</span>
                                <select name="preferred_city_1" id="preferred_city_1" class="form-control" previous-selected="{{count($city) > 0 ? $city[0] : ''}}">
                                    <option value="">Select City</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <select name="preferred_state_2" id="preferred_state_2" class="form-control" previous-selected="{{count($state) > 1 ? $state[1] : ''}}">
                                    <option value="">Select State</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <select name="preferred_city_2" id="preferred_city_2" class="form-control" previous-selected="{{count($city) > 1 ? $city[1] : ''}}">
                                    <option value="">Select City</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <select name="preferred_state_3" id="preferred_state_3" class="form-control" previous-selected="{{count($state) > 2 ? $state[2] : ''}}">
                                    <option value="">Select State</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <select name="preferred_city_3" id="preferred_city_3" class="form-control" previous-selected="{{count($city) > 2 ? $city[2] : ''}}">
                                    <option value="">Select City</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-primary btn-prev">
                            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>
                        <button type="submit" class="btn btn-primary btn-update-address">
                            <span class="align-middle d-sm-inline-block d-none">Update Address</span>
                            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div id="contact-vertical-modern" class="content">
                <form class="contact-form">
                    <div class="content-header">
                        <h5 class="mb-0">Contact</h5>
                        <small>Add Contacts</small>
                    </div>
                    <div class="row mt-1">                    
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label><span class="invalid-feedback">*</span>
                                <input type="email" class="form-control" id="email"
                                    name="email" placeholder="microsoft@outlook.com" readonly
                                    value="{{ old('email',$candidate->user->email) }}"
                                />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="alt_email" class="form-label">Alternate Email</label>
                                <input type="email" class="form-control" id="alt_email"
                                    name="alt_email" placeholder="microsoft@outlook.com" value="{{ old('alt_email',$candidate->alt_email) }}"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="mobile_number" class="form-label">Primary Number</label><span class="invalid-feedback">*</span>
                                <input type="text" class="form-control"
                                    id="mobile_number" name="mobile_number" placeholder="090256 65566" readonly
                                    value="{{ old('mobile_number',$candidate->user->mobile_number) }}" maxlength="10"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                />                            
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="alt_mobile_number" class="form-label">Alternative Number</label>
                                <input type="text" class="form-control"
                                    id="alt_mobile_number" name="alt_mobile_number" placeholder="090256 65566"
                                    value="{{ old('alt_mobile_number',$candidate->alt_mobile_number) }}" maxlength="10"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                />                            
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-primary btn-prev">
                            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>
                        <button type="submit" class="btn btn-primary btn-update-contact">
                            <span class="align-middle d-sm-inline-block d-none">Update Contact</span>
                            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div id="qualification-vertical-modern" class="content">
                <form class="qualification-form">
                    <div class="content-header">
                        <h5 class="mb-0">Qualification</h5>
                        <small>Add Qualifications</small>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="category" class="form-label mr-2">Category <span class="invalid-feedback">*</span> </label>
                                <input type="radio" name="category" id="fresher"  value="fresher"{{ $category == "fresher" ? "checked" : "" }}  > <label for="fresher" class="mr-1"> Fresher </label>
                                <input type="radio" name="category"  id="experience" value="experience" {{ $category == "experience" ? "checked" : "" }}/> <label for="experience"> Experience </label>                                
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="qualification_id" class="form-label">Latest Qualification</label><span class="invalid-feedback">*</span>
                                <select name="qualification_id" id="qualification_id" class="form-control" previous-selected="{{$candidate->qualification_id}}">
                                    <option value="">Select Qualification</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="firstName">Skills</label><span class="invalid-feedback">*</span>                            
                                <select class="select2" id="skills" name="skills[]" multiple previous-selected="{{$candidate->skills}}">
                                    <option value="">Select Skills</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="department_id" class="form-label">Department Type</label><span class="invalid-feedback">*</span>
                                <select class="select2-size-lg form-control" id="department_id"
                                    name="department_id" previous-selected="{{$candidate->department_id}}">
                                    <option value="">Select Department</option>
                                </select>
                            </div>
                        </div> 
                    </div>                    
                    <div class="content-header mt-1 experienceCategory {{ $category === 'fresher' ? 'd-none' : ''}}">
                        <h6 class="mb-0">Previous Company Details</h6>
                        <small>Enter the following details about your previous job</small>
                    </div>
                    <div class="row mt-1 experienceCategory {{ $category === 'fresher' ? 'd-none' : ''}}">                       
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="previous_company" class="form-label">Company Name</label><span class="invalid-feedback">*</span>  
                                <input type="text" class="form-control"
                                    id="previous_company" name="previous_company"
                                    value="{{ old('previous_company',$candidate->previous_company) }}"
                                />                          
                            </div>
                        </div>  
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="previous_position" class="form-label">Position</label><span class="invalid-feedback">*</span>
                                <select class="form-control"
                                        id="previous_position" name="previous_position">
                                    <option value="">Select Position</option>                                    
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1 experienceCategory {{ $category === 'fresher' ? 'd-none' : ''}}"> 
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="experience" class="form-label">Total Experience Year</label><span class="invalid-feedback">*</span>  
                                <input type="text" class="form-control"
                                    id="experience" name="experience"
                                    value="{{ old('experience',$candidate->experience) }}" maxlength="2"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                />                          
                            </div>
                        </div>                        
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="previous_ctc" class="form-label">CTC</label><span class="invalid-feedback">*</span>  
                                <input type="text" class="form-control"
                                    id="previous_ctc" name="previous_ctc"
                                    value="{{ old('previous_ctc',$candidate->previous_ctc) }}"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                />                          
                            </div>
                        </div>                     
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="expected_salary" class="form-label">Monthly Expected Salary</label><span class="invalid-feedback">*</span>  
                                <input type="text" class="form-control"
                                    id="expected_salary" name="expected_salary"
                                    value="{{ old('expected_salary',$candidate->expected_salary) }}"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                />                          
                            </div>
                        </div>  
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-primary btn-prev">
                            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>
                        <button type="submit" class="btn btn-primary btn-update-qualification">Update Qualification</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('vendor-script')
<!-- vendor files -->
<script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{asset(mix('js/main/config.js'))}}"></script>
@endsection
@section('page-script')
<!-- Page js files -->
<script src="{{asset(mix('js/main/candidate/resume-edit.js'))}}">
@endsection

@extends('layouts.contentLayoutMaster')

@section('title', 'Create Job')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">

@endsection
@section('content')
<section>    
    <div class="row match-height">
        <div class="col-sm-12 col-md-12 col-12">
            <div class="card card-app-design">
                <div class="card-body text-center">
                    @if(!empty($recruiter_package))
                        <h4 class="card-title mt-1 mb-75 pt-25">Your package is : <span class="text-primary font-weight-bold">{{$recruiter_package->package['plan_name']}}</span></h4>
                        <h5 class="card-title mt-1 mb-75 pt-25">Availed quota : <span class="text-primary font-weight-bold">{{$recruiter_package->post_quota_used ? $recruiter_package->post_quota_used : 0 }} / {{$recruiter_package->package['post_quota']}}</span></h5>
                    @else
                        <h5 class="card-title mt-1 mb-75 pt-25">No Active Plan</h5>                            
                    @endif
                </div>
            </div>
        </div>         
    </div>
</section>
<section class="horizontal-wizard">
    <div class="bs-stepper horizontal-wizard-job-create">
        <div class="bs-stepper-header">
            <div class="step" data-target="#job-details">
                <button type="button" class="step-trigger">
                <span class="bs-stepper-box">1</span>
                <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Job Details</span>
                    <span class="bs-stepper-subtitle">Enter Job Details</span>
                </span>
                </button>
            </div>
            <div class="line">
                <i data-feather="chevron-right" class="font-medium-2"></i>
            </div>
            <div class="step" data-target="#criteria">
                <button type="button" class="step-trigger">
                <span class="bs-stepper-box">2</span>
                <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Criteria</span>
                    <span class="bs-stepper-subtitle">Enter Your Criteria</span>
                </span>
                </button>
            </div>
            <div class="line">
                <i data-feather="chevron-right" class="font-medium-2"></i>
            </div>
            <div class="step" data-target="#location">
                <button type="button" class="step-trigger">
                <span class="bs-stepper-box">3</span>
                <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Locations</span>
                    <span class="bs-stepper-subtitle">Add Locations</span>
                </span>
                </button>
            </div>
        </div>
        <div class="bs-stepper-content">
            <div id="job-details" class="content">
                <div class="content-header">
                    <h5 class="mb-0">Job Details</h5>
                    <small class="text-muted">Enter Job Details.</small>
                </div>
                <form class="job-detail-form">
                    <div class="row mt-2">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="position_id">{{ __('Job Post') }}<span class="invalid-feedback">*</span></label>
                                <select class="form-control select2" id="position_id" name="position_id"
                                    placeholder="Position">
                                    <option value="">Select Position</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="num_position">{{ __('Number of Positions') }}<span class="invalid-feedback">*</span></label>
                                <input type="number" class="form-control" name="num_position" id="num_position"
                                    placeholder="Number of Positions" />
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="salary_min">{{ __('Min. Salary P/Month') }}<span class="invalid-feedback">*</span></label>
                                <input type="text" class="form-control" name="salary_min" id="salary_min"                                
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    placeholder="Salary" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="salary_max">{{ __(' Max. Salary P/Month') }}<span class="invalid-feedback">*</span></label>
                                <input type="text" class="form-control" name="salary_max" id="salary_max"                                
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    placeholder="Salary" />
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="description">{{ __('Description') }}<span class="invalid-feedback">*</span></label>
                                <textarea type="text" class="form-control"
                                          rows="4"
                                    name="description" placeholder="Description">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary btn-prev" disabled>
                            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>
                        <button type="submit" class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none">Next</span>
                            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div id="criteria" class="content">
                <div class="content-header">
                <h5 class="mb-0">Criteria</h5>
                <small>Enter Your Criterias</small>
                </div>
                <form class="criteria-form">
                    <div class="row mt-2">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="qualification_id">{{ __('Qualification') }}<span class="invalid-feedback">*</span></label>
                                <select class="select2 form-control" id="qualification_id"
                                    name="qualification_id[]" multiple>
                                    <option value="">Select Qualification</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="skills">{{ __('Skills') }}</label><span class="invalid-feedback">*</span>
                                <select id="skills"  class="select2 form-control" size="1" placeholder="Select Skills" name="skills[]" multiple>
                                    <option value="">Select Skills</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">  
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="department_id">{{ __('Department') }}</label><span class="invalid-feedback">*</span>
                                <select id="department_id"  class="select2 form-control" name="department_id">
                                    <option value="">Select Department</option>
                                </select>
                            </div>
                        </div>                   
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="gender">Preferred Gender<span class="invalid-feedback">*</span></label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="any">Any</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="firstName">{{ __(' Min. Exp In Yrs') }}<span class="invalid-feedback">*</span></label>
                                <input class="form-control" id="minexp"
                                    name="experience" placeholder="Experience" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="maxexperience">{{ __(' Max. Exp In Yrs') }}<span class="invalid-feedback">*</span></label>
                                <input type="number" class="form-control" id="maxexperience"
                                       name="maxexperience" placeholder="Experience" />
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="age_min">{{ __('Minimum Age') }}<span class="invalid-feedback">*</span></label>
                                <input type="number" class="form-control" name="age_min"
                                    placeholder="Age" id="age_min" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="age_max">{{ __('Maximum Age') }}<span class="invalid-feedback">*</span></label>
                                <input type="number" class="form-control" name="age_max"
                                    placeholder="Age" id="age_max" />
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">   
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="deadline">{{ __('Application Deadline') }}<span class="invalid-feedback">*</span></label>
                                <input type="text" id="deadline" class="form-control"
                                    name="deadline" />
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-primary btn-prev">
                            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>
                        <button type="submit" class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none">Next</span>
                            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div id="location" class="content">
                <div class="content-header">
                <h5 class="mb-0">Locations</h5>
                <small>Enter Available Job Locations.</small>
                </div>
                <form class="location-form">
                    <div class="row mt-2">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="state">{{ __('State') }}<span class="invalid-feedback">*</span></label>
                                <select name="state[]" class="form-control state">
                                    <option value="">Select State</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="city">{{ __('City') }}<span class="invalid-feedback">*</span></label>
                                <select name="city[]" class="form-control city">
                                    <option value="">Select City</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    @if(!empty($recruiter_package))                           
                        @for ($i=1 ; $i < $recruiter_package->package->location_quota; $i++)
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <select name="state[]" class="form-control state">
                                            <option value="">Select State</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <select name="city[]" class="form-control city">
                                            <option value="">Select City</option>
                                        </select>
                                    </div>
                                </div>
                            </div>                        
                        @endfor
                    @endif
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-primary btn-prev">
                            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>                        
                        <div>
                            <button type="button" class="btn btn-primary btn-submit mr-2" data-type="1">View Your Job Posting</button>
                            {{-- <button type="button" class="btn btn-success btn-submit" data-type="0">
                                <span class="align-middle d-sm-inline-block d-none">Submit</span>
                            </button> --}}
                        </div>
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
@endsection
@section('page-script')
    <script src="{{asset(mix('js/main/config.js'))}}"></script>
    <script src="{{asset(mix('js/main/recruiter/job-create.js'))}}"></script>
@endsection

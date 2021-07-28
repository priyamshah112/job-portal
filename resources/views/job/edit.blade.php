@extends('layouts.contentLayoutMaster')

@section('title', 'Edit Job')

@section('vendor-style')
    <!-- vendor css files -->
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

@endsection
@section('content')
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
                    <input type="hidden" name="job_id" value="{{$job->id}}">
                    <div class="row mt-2">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="position">{{ __('Job Post') }}<span class="invalid-feedback">*</span></label>
                                <input type="text" class="form-control" name="position"
                                    placeholder="Position" value="{{ $job->position}}"/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="num_position">{{ __('Number of Positions') }}<span class="invalid-feedback">*</span></label>
                                <input type="number" class="form-control" name="num_position" id="num_position"
                                    placeholder="Number of Positions" value="{{ $job->num_position}}"/>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="salary_min">{{ __('Min. Salary P/Month') }}<span class="invalid-feedback">*</span></label>
                                <input type="number" class="form-control" name="salary_min" id="salary_min"
                                    placeholder="Salary" value="{{ $job->salary_min}}"/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="salary_max">{{ __(' Max. Salary P/Month') }}<span class="invalid-feedback">*</span></label>
                                <input type="number" class="form-control" name="salary_max" id="salary_max"
                                    placeholder="Salary" value="{{ $job->salary_max}}"/>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="description">{{ __('Description') }}<span class="invalid-feedback">*</span></label>
                                <textarea type="text" class="form-control"
                                    rows="4" name="description" placeholder="Description">{{ $job->description }}</textarea>
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
                                    name="qualification_id[]" previous-selected="{{$job->qualification_id}}" multiple>
                                    <option value="">Select Qualification</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="skills">{{ __('Skills') }}</label><span class="invalid-feedback">*</span>
                                <select id="skills" class="select2 form-control" size="1" name="skills[]" multiple }}>
                                    @php
                                        if($job->skills !== null)
                                        {
                                            $skills = json_decode($job->skills);
                                        }
                                        else
                                        {
                                            $skills = [];
                                        }                                           
                                    @endphp
                                    <option value="Codeigniter" {{in_array('Codeigniter', $skills) ? 'selected' : ''}}>Codeigniter</option>
                                    <option value="CakePHP" {{in_array('CakePHP', $skills) ? 'selected' : ''}}>CakePHP</option>
                                    <option value="Laravel" {{in_array('Laravel', $skills) ? 'selected' : ''}}>Laravel</option>
                                    <option value="YII" {{in_array('YII', $skills) ? 'selected' : ''}}>YII</option>
                                    <option value="Zend" {{in_array('Zend', $skills) ? 'selected' : ''}}>Zend</option>
                                    <option value="Symfony" {{in_array('Symfony', $skills) ? 'selected' : ''}}>Symfony</option>
                                    <option value="Phalcon" {{in_array('Phalcon', $skills) ? 'selected' : ''}}>Phalcon</option>
                                    <option value="Slim" {{in_array('Slim', $skills) ? 'selected' : ''}}>Slim</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="experience">{{ __(' Min. Exp In Yrs') }}<span class="invalid-feedback">*</span></label>
                                <input type="number" class="form-control" id="minexp"
                                    name="experience" value="{{ $job->experience }}" placeholder="Experience" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="maxexperience">{{ __(' Max. Exp In Yrs') }}<span class="invalid-feedback">*</span></label>
                                <input type="number" class="form-control" id="maxexperience"
                                       name="maxexperience" value="{{ $job->maxexperience }}" placeholder="Experience" />
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="age_min">{{ __('Minimum Age') }}<span class="invalid-feedback">*</span></label>
                                <input type="number" class="form-control" name="age_min"
                                    placeholder="Age" value="{{$job->age_min}}" id="age_min" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="age_max">{{ __('Maximum Age') }}<span class="invalid-feedback">*</span></label>
                                <input type="number" class="form-control" name="age_max"
                                    placeholder="Age" value="{{$job->age_max}}" id="age_max" />
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">                        
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="gender">Preferred Gender<span class="invalid-feedback">*</span></label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option value="male" @if ($job->gender == 'male') selected="selected" @endif>Male</option>
                                    <option value="female" @if ($job->gender == 'female') selected="selected" @endif>Female</option>
                                    <option value="any" @if ($job->gender == 'any') selected="selected" @endif>Any</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="deadline">{{ __('Application Deadline') }}<span class="invalid-feedback">*</span></label>
                                <input type="date" id="datepicker" class="form-control"
                                    name="deadline" value="{{ $job->deadline }}" />
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
                @php
                    $state = $job->state !== null ? json_decode($job->state) : [];
                    $city = $job->city !== null ? json_decode($job->city) : [];
                @endphp
                <form class="location-form">
                    <div class="row mt-2">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="state">{{ __('State') }}<span class="invalid-feedback">*</span></label>
                                <select name="state[]" class="form-control state" previous-selected="{{count($state) > 0 ? $state[0] : ''}}">
                                    <option value="">Select State</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="city">{{ __('City') }}<span class="invalid-feedback">*</span></label>
                                <select name="city[]" class="form-control city" previous-selected="{{count($city) > 0 ? $city[0] : ''}}">
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
                                        <select name="state[]" class="form-control state" previous-selected="{{count($state) > $i ? $state[$i] : ''}}">
                                            <option value="">Select State</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <select name="city[]" class="form-control city" previous-selected="{{count($city) > $i ? $city[$i] : ''}}">
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
                            <button type="button" class="btn btn-primary btn-submit mr-2" data-type="1">Save as Draft</button>
                            <button type="button" class="btn btn-success btn-submit" data-type="0">
                                <span class="align-middle d-sm-inline-block d-none">Submit</span>
                            </button>
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

@endsection
@section('page-script')
    <script src="{{asset(mix('js/main/config.js'))}}"></script>
    <script src="{{asset(mix('js/main/recruiter/job-edit.js'))}}"></script>
@endsection

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
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">

<link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-user.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection
@section('content')
<div class="float-right" style="margin-top: -50px">
    <a href="{{route('jobs')}}" class="btn btn-primary">Back</a>
</div>
    <div class="container">
        <div class="card">
            <div class="card-body">

                @if($job->draft == 1)
                    <form class="auth-login-form mt-2" method="POST" id="job-form">
                        @csrf
                        <div class="row mt-2">
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label for="position">Job Post</label><span class="invalid-feedback">*</span>
                                    <input type="text" class="form-control" name="position"
                                        placeholder="Position" value="{{ $job->position}}"/>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label for="num_position">Number of Positions</label><span class="invalid-feedback">*</span>
                                    <input type="number" class="form-control" name="num_position"
                                        placeholder="Number of Positions" value="{{ $job->num_position}}"/>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label for="state">{{ __('State') }}<span class="invalid-feedback">*</span></label>
                                    <select name="state" id="state" class="form-control" previous-selected={{$job->state}}>
                                        <option value="">Select State</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label for="city">{{ __('City') }}<span class="invalid-feedback">*</span></label>
                                    <select name="city" id="city" class="form-control" previous-selected={{$job->city}}>
                                        <option value="">Select City</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label for="age_min">Minimum Age</label><span class="invalid-feedback">*</span>
                                    <input type="number" class="form-control" name="age_min" id="age_min"
                                        placeholder="Minimum Age" value="{{$job->age_min}}"/>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label for="age_max">Maximum Age</label><span class="invalid-feedback">*</span>
                                    <input type="number" class="form-control" name="age_max" id="age_max"
                                        placeholder="Maximum Age" value="{{$job->age_max}}"/>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label for="gender">preferred Gender<span class="invalid-feedback">*</span></label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="">Select Gender</option>
                                        <option value="male" @if ($job->gender == 'male') selected="selected" @endif>Male</option>
                                        <option value="female" @if ($job->gender == 'female') selected="selected" @endif>Female</option>
                                        <option value="transgender" @if ($job->gender == 'transgender') selected="selected" @endif>Transgender</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label for="firstName">{{ __('Min. Salary P/Month') }}</label><span class="invalid-feedback">*</span>
                                    <input type="number" class="form-control" name="salary_min" id="salary_min"
                                        placeholder="Minimum Salary" value="{{ $job->salary_min}}"/>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label for="firstName">{{ __(' Max. Salary P/Month') }}</label><span class="invalid-feedback">*</span>
                                    <input type="number" class="form-control" name="salary_max" id="salary_max"
                                        placeholder="Maximum Salary" value="{{ $job->salary_max }}"/>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label for="experience">{{ __(' Min. Exp In Yrs') }}</label><span class="invalid-feedback">*</span>
                                    <input type="number" class="form-control" value="{{ $job->experience }}" name="experience" id="experience"
                                        placeholder="Experience" />
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label for="maxexperience">{{ __(' Max. Exp In Yrs') }}<span class="invalid-feedback">*</span></label>
                                    <input type="number" class="form-control" id="maxexperience" value="{{ $job->maxexperience }}"
                                        name="maxexperience" placeholder="Experience" />
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label for="firstName">Deadline</label><span class="invalid-feedback">*</span>
                                    <input type="date" class="form-control" value="{{ $job->deadline }}" name="deadline" />
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label for="firstName">Qualification</label><span class="invalid-feedback">*</span>
                                    <select id="qualification_id"  class="form-control" size="1" placeholder="Select Qualification" name="qualification_id" previous-selected="{{$job->qualification_id}}"
                                            multiple>
                                        <option value="">Select Qualification</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label for="firstName">Skills</label><span class="invalid-feedback">*</span>
                                    <select id="skills" class="form-control" size="1" name="skills" multiple }}>
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
                            <div class="col-lg-6 col-md-12 col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label><span class="invalid-feedback">*</span>
                                    <textarea
                                            class="form-control"
                                            id="exampleFormControlTextarea1"
                                            rows="4"
                                            placeholder="Description" name="description"
                                    >{{ $job->description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-right mt-2">
                            <input type="hidden" name="id" value="{{$job->id}}">
                            <button type="button" id="saveForLater" class="btn btn-primary">Save as Draft</button>
                            <button type="button" id="save" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                @else
                    <h2>Submitted Jobs can't be edited...!</h2>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('vendor-script')
<script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection
@section('page-script')
<script src="{{asset(mix('js/main/config.js'))}}"></script>
<script src="{{asset(mix('js/main/recruiter/job-edit.js'))}}"></script>
@endsection

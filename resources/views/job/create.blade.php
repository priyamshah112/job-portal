<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-file-uploader.css')) }}">
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
@extends('layouts.contentLayoutMaster')

@section('title', 'Create Job')

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
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-file-uploader.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-user.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">

@endsection
@section('content')
    <div class="float-right" style="margin-top: -50px">
        <a href="{{ route('jobs') }}" class="btn btn-primary">Back</a>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-body shadow-md">
                @if(session()->has('message'))
                <div class="alert-box alert-success" id="success">
                    <strong> {{session()->get('message')}} </strong>
                </div>
                @endif
                <form class="auth-login-form mt-2" method="POST" id="job-form">
                    <div class="row mt-2">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="position">{{ __('Job Post') }}<span class="invalid-feedback">*</span></label>
                                <input type="text" class="form-control" name="position"
                                    placeholder="Position" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="firstName">{{ __('Number of Positions') }}<span class="invalid-feedback">*</span></label>
                                <input type="number" class="form-control" name="noOfPosts"
                                    placeholder="Number of Positions" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="firstName">{{ __('State') }}<span class="invalid-feedback">*</span></label>
                                <select name="state" id="state" class="form-control">
                                    <option value="">Select State</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="firstName">{{ __('City') }}<span class="invalid-feedback">*</span></label>
                                <select name="city" id="city" class="form-control">
                                    <option value="">Select City</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="firstName">{{ __('Minimum Age') }}<span class="invalid-feedback">*</span></label>
                                <input type="number" class="form-control" name="minAge"
                                    placeholder="Age" id="min_age" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="firstName">{{ __('Maximum Age') }}<span class="invalid-feedback">*</span></label>
                                <input type="number" class="form-control" name="maxAge"
                                    placeholder="Age" id="max_age" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="gender">Preferred Gender<span class="invalid-feedback">*</span></label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="transgender">Transgender</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="firstName">{{ __('Min. Salary P/Month') }}<span class="invalid-feedback">*</span></label>
                                <input type="number" class="form-control" name="minSalary" id="minsal"
                                    placeholder="Salary" />
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="firstName">{{ __(' Max. Salary P/Month') }}<span class="invalid-feedback">*</span></label>
                                <input type="number" class="form-control" name="maxSalary" id="maxsal"
                                    placeholder="Salary" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="firstName">{{ __(' Min. Exp In Yrs') }}<span class="invalid-feedback">*</span></label>
                                <input type="number" class="form-control" id="minexp"
                                    name="experience" placeholder="Experience" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="firstName">{{ __(' Max. Exp In Yrs') }}<span class="invalid-feedback">*</span></label>
                                <input type="number" class="form-control" id="maxexp"
                                       name="maxexperience" placeholder="Experience" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="firstName">{{ __('Application Deadline') }}<span class="invalid-feedback">*</span></label>
                                <input type="date" id="datepicker" class="form-control"
                                    name="deadline" />
                            </div>
                        </div>
                    </div>
<!--                    <div class="row mt-2">-->
<!--                       -->
<!--                    </div>-->
                    <div class="row mt-2">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="firstName">{{ __('Qualification') }}<span class="invalid-feedback">*</span></label>
                                <select class="form-control" id="qualification_id"
                                    name="qualification_id" multiple>
                                    <option value="">Select Qualification</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="firstName">{{ __('Skills') }}</label><span class="invalid-feedback">*</span>
                                <select id="skills"  class="form-control" size="1" placeholder="Select Skills" name="skills" multiple>
                                    <option value="Codeigniter">Codeigniter</option>
                                    <option value="Laravel">Laravel</option>
                                    <option value="YII">YII</option>
                                    <option value="Zend">Zend</option>
                                    <option value="Symfony">Symfony</option>
                                    <option value="Phalcon">Phalcon</option>
                                    <option value="Slim">Slim</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-md-12">
                            <div class="form-group">
                                <label for="description">{{ __('Description') }}<span class="invalid-feedback">*</span></label>
                                <textarea type="text" class="form-control"
                                          rows="4"
                                    name="description" placeholder="Description">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="text-right mt-2">
                        <button type="button" id="saveForLater" class="btn btn-primary">Save as Draft</button>
                        <button type="button" id="save" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>

@endsection
@section('page-script')
    <script src="{{asset(mix('js/main/config.js'))}}"></script>
    <script id="pcs" mode="create" src="{{asset(mix('js/main/recruiter/job-create.js'))}}"></script>
@endsection

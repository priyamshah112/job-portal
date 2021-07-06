<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">

@extends('layouts.contentLayoutMaster')

@section('title', 'Edit Job')

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
                @if(session()->has('message'))
                <div class="alert-box alert-success" id="success">
                    <strong> {{ session()->get('message') }} </strong>
                </div>
                @endif

                @if($job->draft == 1)
                <form class="auth-login-form mt-2" method="POST" id="job-form">
                    @csrf
                    <div class="row mt-2">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="position">Job Post</label><span class="invalid-feedback">*</span>
                                <input type="text" class="form-control" value="{{ $job->position }}" name="position"
                                    placeholder="Position" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="firstName">Number of Positions</label><span class="invalid-feedback">*</span>
                                <input type="number" class="form-control" value="{{ $job->num_position }}" name="noOfPosts"
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
                                <select name="city" id="city" class="form-control"></select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="firstName">Minimum Age</label><span class="invalid-feedback">*</span>
                                <input type="number" class="form-control" value="{{ $job->age_min }}" name="minAge" id="min_age"
                                    placeholder="Minimum Age" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="firstName">Maximum Age</label><span class="invalid-feedback">*</span>
                                <input type="number" class="form-control" value="{{ $job->age_max }}" name="maxAge" id="max_age"
                                    placeholder="Maximum Age" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="gender">preferred Gender<span class="invalid-feedback">*</span></label>
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
                                <label for="firstName">{{ __('Min. Salary P/Month') }}</label><span class="invalid-feedback">*</span>
                                <input type="number" class="form-control" value="{{ $job->salary_min }}" name="minSalary" id="minsal"
                                    placeholder="Minimum Salary" />
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="firstName">{{ __(' Max. Salary P/Month') }}</label><span class="invalid-feedback">*</span>
                                <input type="number" class="form-control" value="{{ $job->salary_max }}" name="maxSalary" id="maxsal"
                                       placeholder="Maximum Salary" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="firstName">{{ __(' Min. Exp In Yrs') }}</label><span class="invalid-feedback">*</span>
                                <input type="number" class="form-control" value="{{ $job->experience }}" name="experience" id="minexp"
                                    placeholder="Experience" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="firstName">{{ __(' Max. Exp In Yrs') }}<span class="invalid-feedback">*</span></label>
                                <input type="number" class="form-control" id="maxexp" value="{{ $job->maxexperience }}"
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
                                <select id="qualification_id"  class="form-control" size="1" placeholder="Select Qualification" name="qualification_id"
                                        multiple>
                                    <option value="BCA">BCA</option>
                                    <option value="IT">IT</option>
                                    <option value="BE">BE</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="firstName">Skills</label><span class="invalid-feedback">*</span>
                                <select id="skills" class="form-control" size="1" name="skills" multiple>
                                    <option value="Codeigniter">Codeigniter</option>
                                    <option value="CakePHP">CakePHP</option>
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
    <script type="text/javascript">
        var state = '{!! $job->state !!}';
        var city = '{!! $job->city !!}';
        var skills = {!! $job->skills !!};
        var qualification_id = {!! $job->qualification_id !!};
        var assetPath1 = $('body').attr('data-asset-path');
        $('#skills').select2().val(skills ? skills : []).trigger('change');
        $('#qualification_id').select2().val(qualification_id ? qualification_id : []).trigger('change');

        $.ajax({
            url: `${assetPath1}api/v1/states/101`,
            type: "GET",
            dataType: 'json',
            success: function (res) {
                $('#state').html('<option value="">Select State</option>');
                res.data.forEach(item => {
                    $("#state").append('<option value="' + item
                        .id + '">' + item.name + '</option>');
                });
                

                $.ajax({
                    url: `${assetPath1}api/v1/cities/${res.data[0].id}`,
                    type: "GET",
                    dataType: 'json',
                    success: function (res) {
                        $('#city').html('<option value="">Select City</option>');
                        res.data.forEach(item => {
                            $("#city").append('<option value="' + item
                                .id + '">' + item.name + '</option>');
                        });

                    }
                });

            }
        });
        
        $('#state').on('change', function () {
            var id = this.value;
            $("#city").html('');
            $.ajax({
                url: `${assetPath1}api/v1/cities/${id}`,
                type: "GET",
                dataType: 'json',
                success: function (res) {
                    $('#city').html('<option value="">Select City</option>');
                    res.data.forEach(item => {
                        $("#city").append('<option value="' + item
                            .id + '">' + item.name + '</option>');
                    });

                }
            });
        });
    </script>
<script id="pcs" mode="edit" src="{{asset(mix('js/main/recruiter-create-job.js'))}}"></script>
@endsection

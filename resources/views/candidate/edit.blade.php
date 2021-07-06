@extends('layouts.contentLayoutMaster')

@section('title', 'Edit Candidate')

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
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-user.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-file-uploader.css')) }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
@endsection

@section('content')
    <!-- Vertical Wizard -->
    <div class="float-right" style="margin-top: -50px">
        <a href="{{ route('candidates') }}" class="btn btn-primary">Back</a>
    </div>
    <section class="vertical-wizard">
        <div class="bs-stepper vertical vertical-wizard-example">
            <div class="bs-stepper-content">
                <form id="admin-candidate-edit-form">
                    @csrf
                    <div class="row mt-2">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="first_name" class="form-label">First Name</label><span class="invalid-feedback">*</span>
                                <input type="text"
                                       class="form-control @error('first_name') is-invalid @enderror"
                                       id="first_name" name="first_name" placeholder="First Name"
                                       aria-describedby="first_name" tabindex="1" autofocus
                                       value="{{ old('first_name',$candidate->user->first_name)}}"/>
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="last_name" class="form-label">Last Name</label><span class="invalid-feedback">*</span>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                       id="last_name" name="last_name" placeholder="Last Name"
                                       aria-describedby="last_name"
                                       tabindex="1" autofocus value="{{ old('last_name',$candidate->user->last_name)}}"/>
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="dateOfBirth" class="form-label">Date of Birth</label><span class="invalid-feedback">*</span>
                                <input type="date" class="form-control @error('dateOfBirth') is-invalid @enderror"
                                       id="dob" name="dateOfBirth" placeholder="Last Name"
                                       aria-describedby="dateOfBirth"
                                       tabindex="1" autofocus value="{{ old('dateOfBirth',$candidate->dateOfBirth)}}"/>
                                @error('dateOfBirth')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="permanent_address" class="form-label">Permanent Address</label><span class="invalid-feedback">*</span>
                                <input type="text" class="form-control @error('permanent_address') is-invalid @enderror"
                                       id="permanent_address" name="permanent_address"
                                       placeholder="Redmond, Washington, United States"
                                       aria-describedby="company_address" tabindex="2"
                                       value="{{ old('permanent_address',$candidate->permanent_address) }}"/>
                                @error('permanent_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="current_location_state">{{ __('State') }}<span
                                            class="invalid-feedback">*</span></label>
                                <select name="current_location_state" id="current_location_state" class="form-control">
                                    <option value="">Select State</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="current_location_citys">{{ __('City') }}<span
                                            class="invalid-feedback">*</span></label>
                                <select name="current_location_city" id="current_location_city" class="form-control"></select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label><span class="invalid-feedback">*</span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                       name="email" placeholder="microsoft@outlook.com" aria-describedby="email"
                                       tabindex="2"
                                       value="{{ old('email',$candidate->user->email) }}"/>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Alternate Email</label>
                                <input type="email" class="form-control @error('alt_email') is-invalid @enderror" id="email"
                                       name="alt_email" placeholder="microsoft@outlook.com" aria-describedby="email"
                                       tabindex="2"
                                       value="{{ old('alt_email',$candidate->alt_email) }}"/>
                                @error('alt_email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="qualification_id" class="form-label">Qualification</label><span class="invalid-feedback">*</span>
                                <input type="text" class="form-control @error('qualification_id') is-invalid @enderror" id="qualification_id"
                                       name="qualification_id" placeholder="Qualification"
                                       tabindex="2"
                                       value="{{ old('qualification_id',$candidate->qualification_id) }}"/>

                                @error('qualification_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="firstName">Skills</label><span class="invalid-feedback">*</span>
                                @php
                                $skills = json_decode($candidate->skills);
                                @endphp
                                @if(!($skills == null))
                                <select id="skills" placeholder="Select Skills" name="skills[]" multiple>
                                    @foreach ($skills as $skill)
                                    <option value="{{ $skill }}" selected>{{ $skill }}</option>
                                    @endforeach
                                    <option value="Symfony">Symfony</option>
                                    <option value="Phalcon">Phalcon</option>
                                    <option value="Slim">Slim</option>
                                </select>
                                @else
                                <select id="skills" name="skills[]" multiple>
                                    <option value="Codeigniter">Codeigniter</option>
                                    <option value="CakePHP">CakePHP</option>
                                    <option value="Laravel">Laravel</option>
                                    <option value="YII">YII</option>
                                    <option value="Zend">Zend</option>
                                    <option value="Symfony">Symfony</option>
                                    <option value="Phalcon">Phalcon</option>
                                    <option value="Slim">Slim</option>
                                </select>
                                @endif
                                @error('skills')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="job_location_state" class="form-label">Job Location State</label>
                                <span class="invalid-feedback">*</span>
                                <select name="job_location_state" id="job_location_state" class="form-control">
                                    <option value="">Select State</option>
                                </select>
                                @error('job_location_state')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="job_location_city" class="form-label">Job Location City</label>
                                <span class="invalid-feedback">*</span>
                                <select name="job_location_city" id="job_location_city" class="form-control">
                                </select>
                                @error('job_location_city')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="category" class="form-label mr-2">Category <span class="invalid-feedback">*</span> </label>
                                @php  $cat = old('category',$candidate->category) @endphp
                                <input type="radio" name="category" id="fresher"  value="fresher"{{ ($cat == "fresher")? "checked" : "" }}  > <label for="fresher" class="mr-1"> Fresher </label>
                                <input type="radio" name="category"  id="experience" value="experienced" {{ ($cat == "experienced")? "checked" : "" }}/> <label for="experience"> Experienced </label>
                                @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="department_id" class="form-label">Department Type</label><span class="invalid-feedback">*</span>
                                <select class="select2-size-lg form-control" id="department_id"
                                    name="department_id">
                                    <option value="">Select Option</option>
                                </select>
                                @error('department_id')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="department_id" class="form-label">Department Type</label><span class="invalid-feedback">*</span>
                                <select class="select2-size-lg form-control" id="department_id"
                                    name="department_id">
                                    <option value="">Select Option</option>
                                </select>
                                @error('category_type')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="company_mobile_1" class="form-label">Primary Number</label><span class="invalid-feedback">*</span>
                                <input type="text"
                                       class="form-control @error('company_mobile_1') is-invalid @enderror"
                                       id="company_mobile_1" name="company_mobile_1" placeholder="090256 65566"
                                       aria-describedby="company_mobile_1" tabindex="2"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       value="{{ old('company_mobile_1',$candidate->user->mobile_number) }}" maxlength="10"
                                       />
                                @error('company_mobile_1')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="company_mobile_2" class="form-label">Alternative Number</label>
                                <input type="text"
                                       class="form-control @error('company_mobile_2') is-invalid @enderror"
                                       id="company_mobile_2" name="company_mobile_2" placeholder="090256 65566"
                                       aria-describedby="company_mobile_2" tabindex="2"
                                       value="{{ old('company_mobile_2',$candidate->mobile_number) }}" maxlength="10"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                                @error('company_mobile_2')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="about" class="form-label">About</label><span class="invalid-feedback">*</span>
                                <textarea
                                        class="form-control @error('about') is-invalid @enderror"
                                        rows="3" id="about"
                                        placeholder="About" name="about"
                                >{{ old('test',$candidate->about)}}</textarea>
                                @error('about')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="text-right mt-2">
                        <button type="submit" id="data-submit" class="btn btn-primary">Update Resume Information</button>
                    </div>
                </form>
            </div>
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
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script type="text/javascript">
        $(document).ready(function() {

            hide();
            $("input[name='category']").change(function() {
                hide();
            });
            var multipleCancelButton = new Choices('#skills', {
                removeItemButton: true,
                searchResultLimit: 10,
                renderChoiceLimit: 10
            });

        });

        function hide() {
            const value = $("input[name='category']:checked").val();
            if (value === "experienced") {
                $("#companyCategory").show();
                $("#industry").show();
            } else {
                $("#companyCategory").hide();
            }
        }

        var job_location_state = '{!! old('
        job_location_state
        ', $candidate->job_location_state) !!}';
        var job_location_city = '{!! old('
        job_location_city
        ', $candidate->job_location_city) !!}';

        $.getJSON("/data/statecity.json", function(json) {
            var options = Object.keys(json);
            $.each(options, function(key, value) {
                $("#job_location_state").append('<option ' + (job_location_state==value ? 'selected' : '') + ' value="' + value + '">' + value + '</option>');
            });
        });
        if (job_location_city.trim() != '') {
            setJobcity()
        }
        $('#job_location_state').on('change', function() {
            $("#job_location_city").html('');
            setJobcity();
        });
        function setJobcity(){
            $.getJSON("/data/statecity.json", function(json) {
                var options = Object.keys(json);
                var id = $( "#job_location_state option:selected" ).text();
                console.log(id);
                let values = json[id];
                $.each(values, function(key, value) {
                    $("#job_location_city").append('<option ' + (job_location_city==value ? 'selected' : '') + ' value="' + value + '">' + value + '</option>');
                });
            });
        }

        var current_location_state = '{!! old('
        current_location_state
        ', $candidate->current_location_state) !!}';
        var current_location_city = '{!! old('
        current_location_city
        ', $candidate->current_location_city) !!}';
        $.getJSON("/data/statecity.json", function(json) {
            var options = Object.keys(json);
            $.each(options, function(key, value) {
                $("#current_location_state").append('<option ' + (current_location_state==value ? 'selected' : '') + ' value="' + value + '">' + value + '</option>');
            });
        });
        if (current_location_city.trim() != '') {
            setcity()
        }
        $('#current_location_state').on('change', function() {
            $("#current_location_city").html('');
            setcity();
        });
        function setcity(){
            $.getJSON("/data/statecity.json", function(json) {
                var options = Object.keys(json);
                var id = $( "#current_location_state option:selected" ).text();
                console.log(id);
                let values = json[id];
                $.each(values, function(key, value) {
                    $("#current_location_city").append('<option ' + (current_location_city==value ? 'selected' : '') + ' value="' + value + '">' + value + '</option>');
                });
            });
        }
    </script>
<script src="{{asset(mix('js/main/admin-candidate-edit.js'))}}">
@endsection

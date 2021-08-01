@extends('layouts/contentLayoutMaster')

@section('title', 'Feedback')


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

<link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-user.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('content')
<!-- Feedback Form -->

<div class="container">
    <div class="card mb-0">
        <div class="card-body">
            <h4 class="text-left">Feedback Form</h4>
            <form class="auth-login-form mt-2" method="POST" id="feedback-form">
                <div class="row mt-2">
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <label for="feedback-name" class="form-label">Name </label>
                            <input type="text" class="form-control"  placeholder="" tabindex="1" autofocus
                                   value="{{auth()->user()->first_name}}" readonly/>
                        </div>
                        <div class="form-group">
                            <label for="login-email" class="form-label">Email</label>
                            <input type="email" class="form-control" placeholder="" aria-describedby="login-email"
                                   tabindex="1" value="{{auth()->user()->email }}" readonly/>
                        </div>
                        <div class="form-group">
                            <label for="feedback-subject" class="form-label">Subject</label><span
                                    class="invalid-feedback">*</span>
                            <input type="text" class="form-control"
                                   id="feedback-subject" name="subject" placeholder="Subject" tabindex="1"
                                   value="{{ old('subject') }}"/>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1" class="form-label">Attachment (Optional)</label>
                            <input type="file" name="fileToUpload" class="myfileupload"
                                   id="exampleFormControlFile1"
                                   accept="image/jpeg, image/png">
                            <p class="filetext">Select Your File(Must be .PNG .JPEG and less than 5MB)</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <label for="feedback" class="form-label">Feedback</label><span
                                    class="invalid-feedback">*</span>
                            <textarea rows="12" class="form-control"
                                      id="feedback" name="feedback"
                                      placeholder="Feedback Message">{{ old('feedback') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="text-right mt-2">
                    <button type="submit" id="data-submit" class="btn btn-primary">Submit</button>
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
<script id="pcs" src="{{asset(mix('js/main/feedback.js'))}}"></script>
@endsection

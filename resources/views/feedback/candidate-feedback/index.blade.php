@extends('layouts/contentLayoutMaster')

@section('title', 'Candidate Feedback')

@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
  {{-- Page Css files --}}
<style>

</style>
@endsection

@section('content')
<!-- Feedback Form -->

<div class="container">
    <div class="card mb-0">
        <div class="card-body">
            <h4 class="text-center">Feedback Form</h4>
            @if(session()->has('message'))
            <div class="alert-box alert-success" id="success">
                <strong> {{ session()->get('message') }} </strong>
            </div>
            @endif


            <form enctype="multipart/form-data" class="auth-login-form mt-2">
                @csrf

                <div class="form-group">
                    <label for="feedback-name" class="form-label">Name </label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="feedback-name" name="name" placeholder="" tabindex="1" autofocus value="{{auth()->user()->first_name}}" readonly/>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="login-email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="login-email" name="email" placeholder="" aria-describedby="login-email" tabindex="1" value="{{auth()->user()->email }}" readonly/>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="feedback-subject" class="form-label">Subject</label><span class="invalid-feedback">*</span>
                    <input type="text" class="form-control @error('subject') is-invalid @enderror" id="feedback-subject" name="subject" placeholder="Subject" tabindex="1" value="{{ old('subject') }}" />
                    @error('subject')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="feedback" class="form-label">Feedback</label><span class="invalid-feedback">*</span>
                    <textarea rows="5" class="form-control @error('feedback') is-invalid @enderror" id="feedback" name="feedback" placeholder="Feedback Message">{{ old('feedback') }}</textarea>
                    @error('feedback')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleFormControlFile1" class="form-label">Attachment (Optional)</label>
                    <input type="file" name="fileToUpload" class="myfileupload @error('fileToUpload') @enderror" id="exampleFormControlFile1">
                    <p class="filetext">Select Your File(Must be .PNG .JPEG and less than 5MB)</p>
                    @error('fileToUpload')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="text-right mt-2">
                    <button type="submit" class="btn btn-primary btn-block" tabindex="4">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('vendor-script')

@endsection

@section('page-script')
<script>
    $(document).ready(function(){
        $("#success").delay(5000).slideUp(300);
    });

</script>
@endsection

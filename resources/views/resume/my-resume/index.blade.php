<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-file-uploader.css')) }}">
@extends('layouts.contentLayoutMaster')

@section('title', 'Resume')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
@endsection

@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-file-uploader.css')) }}">
<style>
    .bs-stepper-content {
        padding: 0px !important;
    }

    .timeline {
        border-left: 2px solid #E6E9ED;
        padding: 1rem 0;
    }

    .timeline-card {
        position: relative;
        margin-left: 31px;
        border-left: 2px solid;
        margin-bottom: 2rem;
    }

    .timeline-card:last-child {
        margin-bottom: 1rem;
    }

    .timeline-card:before {
        content: '';
        display: inline-block;
        position: absolute;
        background-color: #fff;
        border-radius: 10px;
        width: 12px;
        height: 12px;
        top: 20px;
        left: -41px;
        border: 2px solid;
        z-index: 2;
    }

    .timeline-card:after {
        content: '';
        display: inline-block;
        position: absolute;
        background-color: currentColor;
        width: 29px;
        height: 2px;
        top: 25px;
        left: -29px;
        z-index: 1;
    }

    .timeline-card-primary {
        border-left-color: #4A89DC;
    }

    .timeline-card-primary:before {
        border-color: #4A89DC;
    }

    .timeline-card-primary:after {
        background-color: #4A89DC;
    }

    .timeline-card-success {
        border-left-color: #37BC9B;
    }

    .timeline-card-success:before {
        border-color: #37BC9B;
    }

    .timeline-card-success:after {
        background-color: #37BC9B;
    }

    html {
        scroll-behavior: smooth;
    }

    .site-title {
        font-size: 1.25rem;
        line-height: 2.5rem;
    }

    .nav-link {
        padding: 0;
        font-size: 1.25rem;
        line-height: 2.5rem;
        color: rgba(0, 0, 0, 0.5);
    }

    .nav-link:hover,
    .nav-link:focus,
    .active .nav-link {
        color: rgba(0, 0, 0, 0.8);
    }

    .cover {
        border-radius: 10px;
    }

    .cover-bg {
        background-color: #4A89DC;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.12'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3Cpath d='M6 5V0H5v5H0v1h5v94h1V6h94V5H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        border-radius: 10px 10px 0 0;
    }

    .avatarr {
        max-width: 216px;
        border-radius: unset;
        max-height: 216px;
        margin-top: 20px;
        text-align: center;
        margin-left: auto;
        margin-right: auto;
    }

    .avatarr img.aim {
        border-radius: unset;
        /*filter: grayscale(100%);*/
    }

    footer a:not(.nav-link) {
        color: inherit;
        border-bottom: 1px dashed;
        text-decoration: none;
        cursor: pointer;
    }

    @media (min-width: 48em) {
        .site-title {
            float: left;
        }

        .site-nav {
            float: right;
        }

        .avatarr {
            margin-bottom: -80px;
            margin-left: 0;
        }
    }

    @media print {
        body {
            background-color: #fff;
        }

        .container {
            width: auto;
            max-width: 100%;
            padding: 0;
        }

        .cover, .cover-bg {
            border-radius: 0;
        }

        .cover.shadow-lg {
            box-shadow: none !important;
        }

        .cover-bg {
            padding: 5rem !important;
            padding-bottom: 10px !important;
        }

        .avatarr {
            margin-top: -10px;
        }

        .about-section {
            padding: 6.5rem 5rem 2rem !important;
        }

        .skills-section,
        .work-experience-section,
        .education-section,
        .contant-section {
            padding: 1.5rem 5rem 2rem !important;
        }

        .page-break {
            padding-top: 5rem;
            page-break-before: always;
        }
    }

    .badgeNew {
        color: #000;
        background-color: #f1f1f1;
        display: inline-block;
        padding: .25em .4em;
        font-size: 14px;
        font-weight: 500;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: .25rem;
    }
    .head{
        font-size: 34px;
        font-weight: 900;
    }
</style>
@endsection

@section('content')
<!-- Vertical Wizard -->
@if($userType == 'admin' || $userType == 'recruiter')
    <div class="float-right" style="margin-top: -50px">
        <a href="{{url()->previous()}}" class="btn btn-primary">BACK</a>
    </div>
@else
    <div class="float-right" style="margin-top: -50px">
        <a href="{{route('candidate-resume-edit')}}" class="btn btn-primary">Edit Resume</a>
    </div>
@endif

<section class="vertical-wizard">
    <div class="bs-stepper vertical vertical-wizard-example">
        <div class="bs-stepper-content">
            <div class="cover-bg p-3 p-lg-4 text-white">
                <div class="row">
                    <div class="col-lg-4 col-md-5">
                        <div class="avatarr hover-effect bg-white shadow-sm p-1">
                            @if ($candidate->user->img_path)
                            <img class="aim"
                                 src="/{{ $candidate->user->img_path . '/' . $candidate->user->image_name }}"
                                 width="190" height="190"/>
                            @else
                            <img class="aim" src="/images/portrait/small/avatar-s-11.jpg" width="190" height="190"/>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7 text-left text-md-start d-flex">
                        <h1 style="align-self: flex-end" class="head mt-2 text-white" data-aos="fade-left"
                            data-aos-delay="0">{{$candidate->user->first_name.' '. $candidate->user->last_name}}</h1>

                    </div>
                </div>
            </div>
            <div class="about-section pt-4 px-3 px-lg-4 mt-1 pb-3">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="h3 mb-1"><strong>My Profile</strong></h2>
                        <p style="text-indent: 50px;"> {{$candidate->about}}</p>
                        <hr class="p-0 text-primary mt-2">
                        <h6 class="mt-2"><strong>Professional Skills</strong></h6>
                        <div class="row">
                            <div class="col-md-6">
                                @foreach($candidate->skillNames as $skill)
                                <h4 class="badgeNew ml-4"> {{$skill}} </h4>
                                @endforeach
                            </div>
                        </div>
                        <hr class="p-0 text-primary mt-2">
                        <h6><strong>Qualification</strong></h6>
                        <div>
                            @if ($candidate->qualification !== null)
                                <h4 class="badgeNew ml-4"> {{$candidate->qualification->name}} </h4>                                
                            @endif
                        </div>
                        @if($candidate->category === 'experience')
                            <hr class="p-0 text-primary mt-2">
                            <h6><strong>Experience</strong></h6>
                            <div>
                                <p class="badgeNew ml-4">Company Name: {{$candidate->previous_company}}</p>
                                <p class="badgeNew ml-4">Experience  In Years: {{$candidate->experience}}</p>
                                <p class="badgeNew ml-4">Position: {{$candidate->previous_position_detail['name']}}</p>
                                <p class="badgeNew ml-4">CTC: {{$candidate->previous_ctc}} ₹</p>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="row mt-2">
                            <div class="col-sm-4">
                                <div class="pb-1 font-weight-bold"><i data-feather="calendar"></i> Date of Birth</div>
                            </div>
                            <div class="col-sm-8">
                                <div class="pb-1 text-secondary">{{$candidate->dateOfBirth}}</div>
                            </div>
                            <div class="col-sm-4">
                                <div class="pb-1 font-weight-bold"><i data-feather="user"></i> Gender</div>
                            </div>
                            <div class="col-sm-8">
                                <div class="pb-1 text-secondary">{{$candidate->gender}}</div>
                            </div>
                            <div class="col-sm-4">
                                <div class="pb-1 font-weight-bold"><i data-feather="mail"></i> Email</div>
                            </div>
                            <div class="col-sm-8">
                                <div class="pb-1 text-secondary">{{$candidate->user->email}}</div>
                            </div>
                            <div class="col-sm-4">
                                <div class="pb-1 font-weight-bold"><i data-feather="mail"></i> Alternate Email</div>
                            </div>
                            <div class="col-sm-8">
                                @if(!($candidate->alt_email == null))
                                <div class="pb-1 text-secondary">{{ $candidate->alt_email }}</div>
                                @else
                                <div class="pb-1 text-secondary"> -</div>
                                @endif
                            </div>
                            <div class="col-sm-4">
                                <div class="pb-1 font-weight-bold"><i data-feather="phone"></i> Phone</div>
                            </div>
                            <div class="col-sm-8">
                                <div class="pb-1 text-secondary">{{$candidate->user->mobile_number}}</div>
                            </div>
                            <div class="col-sm-4">
                                <div class="pb-1 font-weight-bold"><i data-feather="phone"></i> Phone 2</div>
                            </div>
                            <div class="col-sm-8">
                                @if(!($candidate->alt_mobile_number == null))
                                <div class="pb-1 text-secondary">{{$candidate->alt_mobile_number}}</div>
                                @else
                                <div class="pb-1 text-secondary"> -</div>
                                @endif
                            </div>
                            <div class="col-sm-4">
                                <div class="pb-1 font-weight-bold"><i data-feather="map-pin"></i> Address</div>
                            </div>
                            <div class="col-sm-8">
                                <div class="pb-1 text-secondary">{{$candidate->permanent_address}}</div>
                            </div>
                            <div class="col-sm-4">
                                <div class="pb-1 font-weight-bold"><i data-feather="map-pin"></i> State</div>
                            </div>
                            <div class="col-sm-8">
                                <div class="pb-1 text-secondary">{{$candidate->state_detail ? $candidate->state_detail->name : ''}}</div>
                            </div>
                            <div class="col-sm-4">
                                <div class="pb-1 font-weight-bold"><i data-feather="map-pin"></i> City</div>
                            </div>
                            <div class="col-sm-8">
                                <div class="pb-1 text-secondary">{{$candidate->city_detail ? $candidate->city_detail->name : ''}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3" id="capturedVideo"
                    style="display: {{ $capturedVideo ? 'block' : 'none' }};text-align: center">
                    <h3>Video CV</h3>
                    <video width="600" height="500" controls class="w-100">
                        <source
                            src="{{ URL::asset($candidate->video_resume_path . '/' . $candidate->video_resume_name) }}"
                            type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- /Vertical Wizard -->
@endsection

@section('vendor-script')
<!-- vendor files -->
<script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
@endsection
@section('page-script')
<!-- Page js files -->
<script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-file-uploader.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
<script src="{{asset(mix('js/scripts/components/components-collapse.js'))}}"></script>
@endsection

<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">

@extends('layouts.contentLayoutMaster')

@section('title', 'View Job')

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
        .badgeNew{
            color: #000;
            background-color: #f1f1f1;
            display: inline-block;
            padding: .25em .4em;
            font-size: 16px;
            font-weight: 500;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25rem;
        }
    </style>
@endsection
@section('content')
    <div class="float-right" style="margin-top: -50px">
        <a href="{{ route('jobs') }}" class="btn btn-primary">Back</a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 d-flex">
                                <h5 class="text-primary">Position: </h5>
                                <h5 class="ml-1 mb-0 lead">{{ $job->position }}</h5>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <hr class="p-0 text-primary mt-0">
                            </div>
                            <div class="col-lg-12 col-md-6 d-flex">
                                <h5 class="text-primary">Description : </h5>
                                <h5 class="ml-1 mb-0 lead">{{$job->description}}</h5>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 p-0">
                            <hr class="p-0 text-primary mt-0">
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="text-primary">Age (Min - Max)</h5>
                                <h5 class="mt-1">{{ $job->age_min }} - {{ $job->age_max }}</h5>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 p-0">
                            <hr class="p-0 text-primary mt-0">
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="text-primary">Salary (Min - Max)</h5>
                                <h5 class="mt-1">( ₹ {{ $job->salary_min }} - ₹ {{ $job->salary_max }} ) / PM</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="text-primary">Required Skills</h5>
                            </div>
                            <div class="col-lg-12 col-md-1">
                                <hr class="p-0 text-primary mt-0">
                            </div>
                            <div class="col-lg-12 text-left mt-1">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 text-left rounded rounded-2 m-0 p-0">
                                        @if($skills)
                                            @foreach ($skills as $skill)
                                            <h5 class="badgeNew ml-1">{{ $skill }}</h5>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="text-primary">Required Qualification</h5>
                            </div>
                            <div class="col-lg-12 col-md-1">
                                <hr class="p-0 text-primary mt-0">
                            </div>
                            <div class="col-lg-12 text-left mt-1">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 text-left rounded rounded-2 m-0 p-0">
                                        @if($skills)
                                            @foreach ($qualification as $qual)
                                            <h5 class="badgeNew ml-1">{{ $qual }}
                                            </h5>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="card rounded rounded-1 shodow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <h5 class="text-primary center-text">Job Location</h5>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <hr class="text-primary mt-0">
                            </div>
                            <div class="col-lg-12 col-md-6">
                                <p><i data-feather="navigation"
                                      class="text-success font-small-4 mr-2"></i>{{ $job->city }},
                                    {{ $job->state }}</p>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <h5 class="text-primary center-text">Experience (Min - Max)</h5>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <hr class="text-primary mt-0">
                            </div>
                            <div class="col-lg-12 col-md-6">
                                <p>
                                    {{ $job->experience }} - {{ $job->maxexperience }}
                                </p>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <h5 class="text-primary center-text">Application Deadline</h5>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <hr class="text-primary mt-0">
                            </div>
                            <div class="col-lg-12 col-md-6">
                                <p>
                                    <i class="fab fa-home"></i>
                                    {{ $job->deadline }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('vendor-script')


@endsection
@section('page-script')
    <script>
        $(document).ready(function() {
            var multipleCancelButton = new Choices('#skills', {
                removeItemButton: true,
                searchResultLimit: 10,
                renderChoiceLimit: 10
            });
            var multipleCancelButton = new Choices('#qualification', {
                removeItemButton: true,
                searchResultLimit: 10,
                renderChoiceLimit: 10
            });

        });

    </script>

@endsection

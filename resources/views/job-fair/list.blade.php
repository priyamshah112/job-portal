@extends('layouts/contentLayoutMaster')

@section('title', 'Job Fair')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection
@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/custom/job-fair.css')) }}">
@endsection

@php
    $role = auth()->user()->user_type;
@endphp
@section('content')

@if($role === 'admin')
<div class="float-right" style="margin-top: -50px">
    <a href="{{route('job-fair-store')}}" class="btn btn-primary">Add Job Fair</a>
</div>
@endif
<section>
  @if(count($job_fairs) > 0)
    <div class="row match-height job-fair-list">
        @foreach ($job_fairs as $job)
            <div class="col-sm-4 col-md-4 col-lg-3 job-fair-item" data-id="{{$job->id}}">            
                <!-- Modal -->
                <div class="modal fade" id="view-job-fair-modal-{{ $job->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Job Fair Details - {{ $job->name}}</h5>
                                <button type="button" class="close modal-close-button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>{{$job->organizer_name}} - {{$job->department['name']}} - {{$job->type}}</p>
                                <p>{{$job->description}}</p>
                                <p>
                                <i data-feather='map-pin'></i>
                                <span>{{$job->address}}</span>
                                </p>
                                <p>
                                <i data-feather='mail'></i>
                                <span>{{$job->email}}</span>
                                </p>
                                <p>
                                <i data-feather='phone-call'></i>
                                <span>{{$job->mobile_number}}</span>
                                </p>
                                <p>
                                    <i data-feather='clock'></i>
                                    <span>{{$job->start}} To {{$job->end}}</span>
                                </p>                            
                                <p>{{$job->price === 'free' ? 'Free' : 'Amount: '.($job->amount ? $job->amount : "-") .' rupees'}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card job-fair-item">
                    <div class="btn-group more-icon">
                        <a class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown"><i data-feather='more-vertical'></i></a>
                        <div class="dropdown-menu dropdown-menu-right"> 
                            
                            @if($role === 'admin') 
                                @if ($job->draft === '1')
                                    <a href="{{route('job-fair-edit', $job->id)}}" class="dropdown-item">Edit</a>                                
                                @endif                         
                                @if ($job->draft === '0')
                                    <a href="javascript:;" class="dropdown-item job-fair-view" data-toggle="modal" data-target="#view-job-fair-modal-{{ $job->id}}">View</a>                                
                                @endif                         
                                <a href="javascript:;" class="dropdown-item job-fair-delete" job_fair_id="{{$job->id}}"> Delete</a>
                            @else
                            <a href="javascript:;" class="dropdown-item job-fair-view" data-toggle="modal" data-target="#view-job-fair-modal-{{ $job->id}}">View</a>
                            @endif
                        </div>
                    </div>
                    <div>
                    <img class="card-img-top" src="{{$job->img_path}}" alt="Card image cap" />
                    </div>
                    <div class="card-body job-card-body">
                        <h4 class="card-title mb-1 text-center">
                            {{$job->name}}
                        </h4>
                        <div class="job-fair-details">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="media">
                                    <div class="media-body mb-media-body">
                                        <p class="card-text">{{$job->organizer_name}} - {{$job->department['name']}} - {{$job->type}}</p>                                        
                                        <p class="mt-75">
                                            {{$job->price === 'free' ? 'Free' : 'Amount: '.($job->amount ? $job->amount : "-") .' rupees'}}
                                        </p>
                                        <p class="mt-75">
                                            <i data-feather='map-pin'></i>
                                            <span>{{$job->address}}</span>
                                        </p>
                                        <p class="mt-75">
                                            <i data-feather='clock'></i>
                                            <span>{{$job->start}} To {{$job->end}}</span>
                                        </p>
                                    </div>
                                    @if($role === 'admin')
                                        @if ($job->draft === '1')
                                            <button type="button" class="btn btn-primary btn-block mt-2 status-btn">
                                                Draft
                                            </button>
                                        @endif
                                        @if ($job->draft === '0')
                                            <a href="{{route('job-fair.payments', $job->id)}}" class="btn btn-success btn-block mt-2 status-btn">
                                                Published
                                            </a>
                                        @endif
                                    @elseif($role === 'recruiter')
                                        <a href="{{route('job-fair.jobs',  $job->id)}}" class="btn btn-primary btn-block mt-2 status-btn">
                                            Result
                                        </a>
                                    @else
                                        <button type="button" class="btn btn-primary btn-block mt-2 status-btn apply" data-id="{{$job->id}}">
                                            Apply
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        @endforeach  
    </div>        
  @else
      <div class="text-center mt-3">No Jobs Fair Found</div>
  @endif 
</section>
@endsection

@section('vendor-script')
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection
@section('page-script')
<!-- Page js files -->
<script src="{{ asset(mix('js/main/config.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
@if($role === 'admin' || $role === 'recruiter')
    <script src="{{ asset(mix('js/main/job-fair.js')) }}"></script>
@else
    <script src="{{ asset(mix('js/main/candidate/job-fair.js')) }}"></script>
@endif
@endsection
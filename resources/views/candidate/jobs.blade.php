@extends('layouts/contentLayoutMaster')

@section('title', 'Jobs List')

@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
  <style>
    .job-card{
      margin-left: 50px;
      padding-left: 50px;
    }
    .job-company-logo{
      width: 100px;
      height: 100px;
      position: absolute;
      left: -50px;
      top: 50px;
      border-radius: 5px;
      box-shadow: 7px 9px 14px -9px rgba(0,0,0,0.75);
      -webkit-box-shadow: 7px 9px 14px -9px rgba(0,0,0,0.75);
      -moz-box-shadow: 7px 9px 14px -9px rgba(0,0,0,0.75);
    }
    .job-empty-logo{
      width: 100px;
      height: 100px;
      position: absolute;
      left: -50px;
      top: 50px;
      border-radius: 5px;
      box-shadow: 7px 9px 14px -9px rgba(0,0,0,0.75);
      -webkit-box-shadow: 7px 9px 14px -9px rgba(0,0,0,0.75);
      -moz-box-shadow: 7px 9px 14px -9px rgba(0,0,0,0.75);
      display: flex;
      align-items: center;
      justify-content: center;
      background: #f8f8f8;
      font-weight: bold;

    }
  </style>
@endsection

@section('content')
<!-- cateory list start -->
<section class="job-list">
  <!-- list section start -->
  @if(count($jobs) > 0)
    @foreach ($jobs as $job)
      <div class="job-item" data-id="{{$job->id}}">
        <div class="modal fade" id="view-job-modal-{{ $job->id}}" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h3 class="modal-title text-primary">{{$job->position['name']}}</h3>
                      <button type="button" class="close modal-close-button" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body"> 
                    <p class="card-text">
                      <strong>Company Name:</strong> 
                      {{$job->recruiter_details['recruiter']->company_name}}
                    </p>
                    <p class="card-text">
                      <strong>Location:</strong>                  
                      @foreach ($job->stateNames as $state)
                        {{$state}}
                      @endforeach
                    </p>
                    <p class="card-text">
                      <strong>Salary Expected:</strong> {{$job->salary_min}} - {{$job->salary_max}} Rupees
                    </p>
                    <p class="card-text">
                      <strong>Role Description:</strong> {{$job->description}}
                    </p>
                    <p class="card-text">
                      <strong>Experience:</strong> {{$job->experience}} - {{$job->maxexperience}} Years
                    </p>
                    <p class="card-text">
                      <strong>Age Criteria:</strong> {{$job->age_min}} - {{$job->age_max}} Years
                    </p>
                    <p class="card-text">
                      <strong>Technical Skills:</strong> 
                      @foreach ($job->skillNames as $skill)
                          @if($loop->last)
                            {{$skill}}.
                          @else
                            {{$skill}},  
                          @endif
                      @endforeach
                    </p>
                    <div class="card-text">
                      <strong>Deadline to Apply:</strong> {{$job->deadline}}
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary modal-close-button" data-dismiss="modal">
                      Close
                    </button>
                    <button type="button" class="btn btn-success modal-close-button apply" data-dismiss="modal" data-id={{$job->id}}>
                      Apply
                    </button>
                  </div>
              </div>
          </div>
        </div>
        <div class="card job-card">
          @if($job->recruiter_details['img_path'] !== null)
            <img class="img-responsive job-company-logo" src="{{$job->recruiter_details['img_path']}}/{{$job->recruiter_details['image_name']}}"/>
          @else
            <div class="job-empty-logo">Logo</div>
          @endif
          <div class="card-header border-bottom pb-1">
            <h5 class="card-text">
              {{$job->position['name']}}
            </h5>
            <h5 class="card-text">
              {{$job->recruiter_details['recruiter']->company_name}}
            </h5>
          </div>
          <div class="card-body pt-2">
            <div class="d-flex justify-content-between">
              <p class="card-text">
                <strong>Location:</strong>                                  
                @foreach ($job->stateNames as $state)
                  {{$state}}
                @endforeach
              </p>
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#view-job-modal-{{ $job->id}}">View</button>
            </div>
            <p class="card-text">
              <strong>Technical Skills:</strong> 
              @foreach ($job->skillNames as $skill)
                @if($loop->last)
                  {{$skill}}.
                @else
                  {{$skill}},  
                @endif
              @endforeach
            </p>
            <div class="d-flex justify-content-between">
              <div class="card-text text-danger">
                <strong>Deadline to Apply:</strong> {{$job->deadline}}
              </div>
              <div class="card-text">
                <strong>Percent Matching: </strong> {{$job->score}}%
              </div>
            </div>
          </div>
        </div>    
      </div>
    @endforeach  
  @else
      <div class="text-center mt-3">No Jobs Found</div>
  @endif  
  <!-- list section end -->
</section>
<!-- category list ends -->
@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
  <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{asset(mix('js/main/config.js'))}}"></script>
@endsection

@section('page-script')
<script src="{{asset(mix('js/main/config.js'))}}"></script>
<script src="{{asset(mix('js/main/candidate/jobs.js'))}}"></script>
@endsection

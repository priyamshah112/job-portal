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
                      <h3 class="modal-title text-primary">{{$job->position}}</h3>
                      <button type="button" class="close modal-close-button" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body"> 
                    <p class="card-text">
                      <strong>Location:</strong> {{$job->state}}, {{$job->city}}
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
                      <strong>Technical Skills:</strong> @foreach (json_decode($job->skills) as $skill)
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
        <div class="card">
          <div class="card-header border-bottom pb-1">
            <h5 class="card-text">{{$job->position}}</h5>
            <h5 class="card-text">Job</h5>
          </div>
          <div class="card-body pt-2">
            <div class="d-flex justify-content-between">
              <p class="card-text">
                <strong>Location:</strong> {{$job->state}}, {{$job->city}}
              </p>
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#view-job-modal-{{ $job->id}}">View</button>
            </div>
            <p class="card-text">
              <strong>Technical Skills:</strong> @foreach (json_decode($job->skills) as $skill)
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
                <strong>Percent Matching: </strong> {{$job->score}}
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

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

@section('content')

@if(auth()->user()->user_type === 'admin')
<div class="float-right" style="margin-top: -50px">
    <a href="{{route('job-fair-store')}}" class="btn btn-primary">Add Job Fair</a>
</div>
@endif
<section>
  @if(auth()->user()->user_type === 'admin')
  <!-- Modal -->
  <div class="modal fade" id="job-fair-edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Job Fair</h5>
                <button type="button" class="close modal-close-button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">              
              <form id="job-fair-update-form" method='post' files=true enctype='multipart/form-data'>
                  @csrf
                  <div class="row">
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                              <label for="name" class="form-label">Fair Name*</label>
                              <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="" />
                          </div>
                      </div>            
                      <div class="col-lg-4 col-md-6">
                          <label for="description" class="form-label">Description*</label>
                          <textarea class="form-control" rows="2" id="description"
                              placeholder="Description" name="description"
                          ></textarea>
                      </div>
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                              <label for="img_name" class="form-label">Banner Image</label>
                              <input type="file" class="form-control" name="img_name" id="img_name" />
                          </div>
                      </div>
                  </div>
                  <div class="row mt-2">
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                              <label for="organizer_name" class="form-label">Organizer Name*</label>
                              <input type="text" class="form-control" id="organizer_name" name="organizer_name" placeholder="Name" value="" />
                          </div>
                      </div>  
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                              <label for="address" class="form-label">Fair Address*</label>
                              <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="" />
                          </div>
                      </div>  
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                              <label for="mobile_number" class="form-label">Mobile Number*</label>                        <input type="text"
                                  class="form-control"
                                  id="mobile_number" name="mobile_number" placeholder="90256 65566" maxlength="10"
                                  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                          </div>
                      </div>  
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                              <label for="email" class="form-label">Email*</label>
                              <input type="email" class="form-control" name="email" placeholder="xyx@jobportal.com" />
                          </div>
                      </div>
                  </div>
                  <div class="row mt-1">
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                              <label for="type" class="form-label">Type*</label>
                              <select class="form-control" id="type" name="type">
                                  <option value="">Select Options</option>
                                  <option value="online">Online</option>
                                  <option value="offline">Offline</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                              <label for="price" class="form-label">Price*</label>
                              <select class="form-control" id="price" name="price">
                                  <option value="">Select Options</option>
                                  <option value="free">Free</option>
                                  <option value="price">Price</option>
                              </select>
                          </div>
                      </div>  
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                              <label for="number_of_days" class="form-label">Number Of Days*</label>                        
                              <input type="text"
                                  class="form-control"
                                  id="number_of_days" name="number_of_days" placeholder="2"
                                  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                          </div>
                      </div> 
                  </div>
                  <div class="row mt-1">
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                              <label for="start_date" class="form-label">Start Date*</label>
                              <input type="date" class="form-control" id="start_date" name="start_date"/>
                          </div>
                      </div>
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                              <label for="end_date" class="form-label">End Date*</label>
                              <input type="date" class="form-control" id="end_date" name="end_date"/>
                          </div>
                      </div>
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                              <label for="start_time" class="form-label">Start Time*</label>
                              <input type="time" class="form-control" id="start_time" name="start_time"/>
                          </div>
                      </div>
                  </div>
                  <div class="row mt-1">
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                              <label for="end_time" class="form-label">End Time*</label>
                              <input type="time" class="form-control" id="end_time" name="end_time"/>
                          </div>
                      </div>
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                              <label for="department_id" class="form-label">Department Type*</label>
                              <select class="select2-size-lg form-control" id="department_id"
                                  name="department_id">
                                  <option value="">Select Option</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-lg-4 col-md-6">
                          <label for="additional_info" class="form-label">Additional Info</label>
                          <textarea class="form-control" rows="2" id="additional_info"
                              placeholder="Additional Info" name="additional_info"
                          ></textarea>
                      </div>
                  </div>
                  <div class="text-right mt-2">
                      <button type="submit" id="data-update" class="btn btn-primary">Update</button>
                  </div>
              </form>
            </div>
        </div>
    </div>
  </div>
  @endif

  <div class="row match-height job-fair-list">
      @foreach ($job_fairs as $job)
          <div class="col-sm-4 col-md-4 col-lg-3">            
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
                      </div>
                  </div>
              </div>
            </div>

            <div class="card job-fair-item">
                @if(auth()->user()->user_type === 'admin')
                <div class="btn-group more-icon">
                    <a class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown"><i data-feather='more-vertical'></i></a>
                    <div class="dropdown-menu dropdown-menu-right">                           
                        <a href="javascript:;" class="dropdown-item job-fair-edit" job_fair_id='{{$job->id}}'>Edit</a>
                        <a href="javascript:;" class="dropdown-item job-fair-delete" job_fair_id="{{$job->id}}"> Delete</a>
                    </div>
                </div>
                @endif
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
                                <div class="media-body">
                                    <p class="card-text">{{$job->organizer_name}} - {{$job->department['name']}} - {{$job->type}}</p>
                                    <p class="card-text">
                                      <i data-feather='map-pin'></i>
                                      <small>{{$job->address}}</small>
                                    </p>
                                    <p>
                                        <i data-feather='clock'></i>
                                        <small>{{$job->start}} To {{$job->end}}</small>
                                    </p>
                                    <button type="button" class="btn btn-primary btn-block mt-2" data-toggle="modal" data-target="#view-job-fair-modal-{{ $job->id}}">
                                      View Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>            
      @endforeach
  </div>  
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
<script src="{{ asset(mix('js/main/job-fair.js')) }}"></script>
@endsection
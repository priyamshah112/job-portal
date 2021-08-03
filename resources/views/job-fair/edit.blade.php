@extends('layouts.contentLayoutMaster')

@section('title', 'Edit Job Fair')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">

@endsection
@section('content')
<section class="horizontal-wizard">
    <div class="bs-stepper horizontal-wizard-job-fair-create">
        <div class="bs-stepper-header">
            <div class="step" data-target="#job-fair-details">
                <button type="button" class="step-trigger">
                <span class="bs-stepper-box">1</span>
                <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Job Fair Details</span>
                    <span class="bs-stepper-subtitle">Enter Job Fair Details</span>
                </span>
                </button>
            </div>
            <div class="line">
                <i data-feather="chevron-right" class="font-medium-2"></i>
            </div>            
            <div class="step" data-target="#contacts">
                <button type="button" class="step-trigger">
                <span class="bs-stepper-box">2</span>
                <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Contacts</span>
                    <span class="bs-stepper-subtitle">Enter Your Contacts</span>
                </span>
                </button>
            </div>
            <div class="line">
                <i data-feather="chevron-right" class="font-medium-2"></i>
            </div>            
            <div class="step" data-target="#date-time">
                <button type="button" class="step-trigger">
                <span class="bs-stepper-box">3</span>
                <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Event Date Time </span>
                    <span class="bs-stepper-subtitle">Enter Your Event Date Time </span>
                </span>
                </button>
            </div>
        </div>
        <div class="bs-stepper-content">
            <div id="job-fair-details" class="content">
                <div class="content-header">
                    <h5 class="mb-0">Job Fair Details</h5>
                    <small class="text-muted">Enter Job Fair Details.</small>
                </div>
                <form class="job-fair-detail-form">
                    <input type="hidden" name="job_fair_id" value="{{$job_fair->id}}" />
                    <div class="row mt-2">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Fair Name*</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$job_fair->name}}" />
                            </div>
                        </div> 
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="img_name" class="form-label">Banner Image*</label>
                                <input type="file" class="form-control" name="img_name" id="img_name" accept="image/jpeg,image/png" />
                            </div>
                        </div> 
                    </div>                    
                    <div class="row mt-2">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="organizer_name" class="form-label">Organizer Name*</label>
                                <input type="text" class="form-control" id="organizer_name" name="organizer_name" placeholder="Name" value="{{$job_fair->organizer_name}}" />
                            </div>
                        </div> 
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="department_id" class="form-label">Department Type*</label>
                                <select class="select2-size-lg form-control" id="department_id"
                                    name="department_id" previous-selected="{{$job_fair->department_id}}">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">                         
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="type" class="form-label">Type*</label>
                                <select class="form-control" id="type" name="type">
                                    <option value="">Select Options</option>
                                    <option value="online" {{$job_fair->type === 'online' ? 'selected' : ''}}>Online</option>
                                    <option value="offline" {{$job_fair->type === 'offline' ? 'selected' : ''}}>Offline</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="price" class="form-label">Price*</label>
                                <select class="form-control" id="price" name="price">
                                    <option value="">Select Options</option>
                                    <option value="free" {{$job_fair->price === 'free' ? 'selected' : ''}}>Free</option>
                                    <option value="price" {{$job_fair->price === 'price' ? 'selected' : ''}}>Price</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1 amount-box {{$job_fair->price === 'price' ? '' : 'd-none'}}">
                        <div class="col-lg-5 col-md-6">
                            <div class="form-group">
                                <label for="amount" class="form-label">Amount*</label>                        
                                <input type="text"
                                    class="form-control"
                                    id="amount" name="amount" placeholder="1000" maxlength="10"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    value="{{$job_fair->amount}}"/>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1 mb-2">           
                        <div class="col-lg-12 col-md-12">
                            <label for="description" class="form-label">Description*</label>
                            <textarea class="form-control" rows="4" id="description"
                                placeholder="Description" name="description"
                            >{{$job_fair->description}}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary btn-prev" disabled>
                            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>
                        <button type="submit" class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none">Next</span>
                            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div id="contacts" class="content">
                <div class="content-header">
                    <h5 class="mb-0">Contacts</h5>
                    <small>Enter Your Contacts</small>
                </div>
                <form class="contact-form">
                    <div class="row mt-2"> 
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="mobile_number" class="form-label">Mobile Number*</label>                     
                                <input type="text"
                                    class="form-control"
                                    id="mobile_number" name="mobile_number" placeholder="90256 65566" maxlength="10"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    value="{{$job_fair->mobile_number}}"
                                />
                            </div>
                        </div> 
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email*</label>
                                <input type="email" class="form-control" name="email" placeholder="xyx@jobportal.com" 
                                    value="{{$job_fair->email}}"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="address" class="form-label">Fair Address*</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="{{$job_fair->address}}" />
                            </div>
                        </div> 
                    </div>
                    <div class="row mt-1 mb-2">                        
                        <div class="col-lg-12 col-md-12">
                            <label for="additional_info" class="form-label">Additional Info</label>
                            <textarea class="form-control" rows="4" id="additional_info"
                                placeholder="Additional Info" name="additional_info"
                            >{{$job_fair->additional_info}}</textarea>
                        </div>
                    </div> 
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-primary btn-prev">
                            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>
                        <button type="submit" class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none">Next</span>
                            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div id="date-time" class="content">
                <div class="content-header">
                    <h5 class="mb-0">Event Date - Time</h5>
                    <small>Enter Your Event Date - Time</small>
                </div> 
                <form class="date-time-form">                   
                    <div class="row mt-2">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">                                
                                <label for="dates">Start - End Date</label>
                                <input
                                    type="text"
                                    id="dates"
                                    name="dates"
                                    class="form-control flatpickr-range"
                                    placeholder="YYYY-MM-DD to YYYY-MM-DD"
                                    value="{{$job_fair->start_date !== null && $job_fair->end_date !== null ? $date = $job_fair->start_date.' to '.$job_fair->end_date : "" }}"
                                />
                            </div>
                        </div>   
                    </div>
                    <div class="row mt-1 mb-2">                                              
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="start_time" class="form-label">Start Time*</label>
                                <input type="text" class="form-control flatpickr-time" id="start_time" name="start_time" value="{{$job_fair->start_time}}" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="end_time" class="form-label">End Time*</label>
                                <input type="text" class="form-control flatpickr-time" id="end_time" name="end_time" value="{{$job_fair->end_time}}" />
                            </div>
                        </div>
                    </div>               
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-primary btn-prev">
                            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>                       
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-submit mr-2" data-type="1">Save as Draft</button>
                            <button type="submit" class="btn btn-success btn-submit" data-type="0">
                                <span class="align-middle d-sm-inline-block d-none">Submit</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection


@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>

@endsection
@section('page-script')
    <script src="{{asset(mix('js/main/config.js'))}}"></script>
    <script src="{{asset(mix('js/main/admin/job-fair-edit.js'))}}"></script>
@endsection

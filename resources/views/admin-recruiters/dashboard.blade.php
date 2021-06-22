
@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard Analytics')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap.min.css')) }}">
@endsection
@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/charts/chart-apex.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-invoice-list.css')) }}">
@endsection

@section('content')
    <!-- Dashboard Analytics Start -->
    <section id="dashboard-analytics">
        <div class="row match-height">
            <!-- Greetings Card starts -->
        {{--    <div class="col-lg-6 col-md-12 col-sm-12">--}}
        {{--      <div class="card card-congratulations">--}}
        {{--        <div class="card-body text-center">--}}
        {{--          <img--}}
        {{--            src="{{asset('images/elements/decore-left.png')}}"--}}
        {{--            class="congratulations-img-left"--}}
        {{--            alt="card-img-left"--}}
        {{--          />--}}
        {{--          <img--}}
        {{--            src="{{asset('images/elements/decore-right.png')}}"--}}
        {{--            class="congratulations-img-right"--}}
        {{--            alt="card-img-right"--}}
        {{--          />--}}
        {{--          <div class="avatar avatar-xl bg-primary shadow">--}}
        {{--            <div class="avatar-content">--}}
        {{--              <i data-feather="award" class="font-large-1"></i>--}}
        {{--            </div>--}}
        {{--          </div>--}}
        {{--          <div class="text-center">--}}
        {{--            <h1 class="mb-1 text-white">Congratulations {{ \Illuminate\Support\Str::ucfirst(\Illuminate\Support\Facades\Auth::user()->name) }},</h1>--}}
        {{--            <p class="card-text m-auto w-75">--}}
        {{--              You have done <strong>57.6%</strong> more sales today. Check your new badge in your profile.--}}
        {{--            </p>--}}
        {{--          </div>--}}
        {{--        </div>--}}
        {{--      </div>--}}
        {{--    </div>--}}
        <!-- Greetings Card ends -->

            <!-- Subscribers Chart Card starts -->
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header flex-column align-items-start pb-0">
                        <div class="avatar bg-light-primary p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather="book" class="font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="font-weight-bolder mt-1">5 <small class="card-text">Jobs Created</small></h2>
                    </div>
                    {{-- <div id="gained-chart"></div> --}}
                </div>
            </div>
            <!-- Subscribers Chart Card ends -->

            <!-- Orders Chart Card starts -->
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header flex-column align-items-start pb-0">
                        <div class="avatar bg-light-warning p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather="users" class="font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="font-weight-bolder mt-1">20 <small class="card-text">Candidates</small></h2>
                    </div>
                    {{-- <div id="order-chart"></div> --}}
                </div>
            </div>
            <!-- Orders Chart Card ends -->
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header flex-column align-items-start pb-0">
                        <div class="avatar bg-light-success p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather="users" class="font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="font-weight-bolder mt-1">5 <small class="card-text">Selected Candidates</small></h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header flex-column align-items-start pb-0">
                        <div class="avatar bg-light-danger p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather="book" class="font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="font-weight-bolder mt-1">20 <small class="card-text">Amount Spent</small></h2>

                    </div>
                </div>
            </div>
        </div>

        <div class="row match-height">
            <!-- Avg Sessions Chart Card starts -->
        {{--    <div class="col-lg-6 col-12">--}}
        {{--      <div class="card">--}}
        {{--        <div class="card-body">--}}
        {{--          <div class="row pb-50">--}}
        {{--            <div class="col-sm-6 col-12 d-flex justify-content-between flex-column order-sm-1 order-2 mt-1 mt-sm-0">--}}
        {{--              <div class="mb-1 mb-sm-0">--}}
        {{--                <h2 class="font-weight-bolder mb-25">2.7K</h2>--}}
        {{--                <p class="card-text font-weight-bold mb-2">Sales</p>--}}
        {{--                <div class="font-medium-2">--}}
        {{--                  <span class="text-success mr-25">+5.2%</span>--}}
        {{--                  <span>vs last 7 days</span>--}}
        {{--                </div>--}}
        {{--              </div>--}}
        {{--              <button type="button" class="btn btn-primary">View Details</button>--}}
        {{--            </div>--}}
        {{--            <div class="col-sm-6 col-12 d-flex justify-content-between flex-column text-right order-sm-2 order-1">--}}
        {{--              <div class="dropdown chart-dropdown">--}}
        {{--                <button--}}
        {{--                  class="btn btn-sm border-0 dropdown-toggle p-50"--}}
        {{--                  type="button"--}}
        {{--                  id="dropdownItem5"--}}
        {{--                  data-toggle="dropdown"--}}
        {{--                  aria-haspopup="true"--}}
        {{--                  aria-expanded="false"--}}
        {{--                >--}}
        {{--                  Last 7 Days--}}
        {{--                </button>--}}
        {{--                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownItem5">--}}
        {{--                  <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>--}}
        {{--                  <a class="dropdown-item" href="javascript:void(0);">Last Month</a>--}}
        {{--                  <a class="dropdown-item" href="javascript:void(0);">Last Year</a>--}}
        {{--                </div>--}}
        {{--              </div>--}}
        {{--              <div id="avg-sessions-chart"></div>--}}
        {{--            </div>--}}
        {{--          </div>--}}
        {{--          <hr />--}}
        {{--          <div class="row avg-sessions pt-50">--}}
        {{--            <div class="col-6 mb-2">--}}
        {{--              <p class="mb-50">Goal: $100000</p>--}}
        {{--              <div class="progress progress-bar-primary" style="height: 6px">--}}
        {{--                <div--}}
        {{--                  class="progress-bar"--}}
        {{--                  role="progressbar"--}}
        {{--                  aria-valuenow="50"--}}
        {{--                  aria-valuemin="50"--}}
        {{--                  aria-valuemax="100"--}}
        {{--                  style="width: 50%"--}}
        {{--                ></div>--}}
        {{--              </div>--}}
        {{--            </div>--}}
        {{--            <div class="col-6 mb-2">--}}
        {{--              <p class="mb-50">Users: 100K</p>--}}
        {{--              <div class="progress progress-bar-warning" style="height: 6px">--}}
        {{--                <div--}}
        {{--                  class="progress-bar"--}}
        {{--                  role="progressbar"--}}
        {{--                  aria-valuenow="60"--}}
        {{--                  aria-valuemin="60"--}}
        {{--                  aria-valuemax="100"--}}
        {{--                  style="width: 60%"--}}
        {{--                ></div>--}}
        {{--              </div>--}}
        {{--            </div>--}}
        {{--            <div class="col-6">--}}
        {{--              <p class="mb-50">Retention: 90%</p>--}}
        {{--              <div class="progress progress-bar-danger" style="height: 6px">--}}
        {{--                <div--}}
        {{--                  class="progress-bar"--}}
        {{--                  role="progressbar"--}}
        {{--                  aria-valuenow="70"--}}
        {{--                  aria-valuemin="70"--}}
        {{--                  aria-valuemax="100"--}}
        {{--                  style="width: 70%"--}}
        {{--                ></div>--}}
        {{--              </div>--}}
        {{--            </div>--}}
        {{--            <div class="col-6">--}}
        {{--              <p class="mb-50">Duration: 1yr</p>--}}
        {{--              <div class="progress progress-bar-success" style="height: 6px">--}}
        {{--                <div--}}
        {{--                  class="progress-bar"--}}
        {{--                  role="progressbar"--}}
        {{--                  aria-valuenow="90"--}}
        {{--                  aria-valuemin="90"--}}
        {{--                  aria-valuemax="100"--}}
        {{--                  style="width: 90%"--}}
        {{--                ></div>--}}
        {{--              </div>--}}
        {{--            </div>--}}
        {{--          </div>--}}
        {{--        </div>--}}
        {{--      </div>--}}
        {{--    </div>--}}
        <!-- Avg Sessions Chart Card ends -->

            <!-- Support Tracker Chart Card starts -->
        {{--    <div class="col-lg-6 col-12">--}}
        {{--      <div class="card">--}}
        {{--        <div class="card-header d-flex justify-content-between pb-0">--}}
        {{--          <h4 class="card-title">Courses</h4>--}}
        {{--          <div class="dropdown chart-dropdown">--}}
        {{--            <button--}}
        {{--              class="btn btn-sm border-0 dropdown-toggle p-50"--}}
        {{--              type="button"--}}
        {{--              id="dropdownItem4"--}}
        {{--              data-toggle="dropdown"--}}
        {{--              aria-haspopup="true"--}}
        {{--              aria-expanded="false"--}}
        {{--            >--}}
        {{--              Last 7 Days--}}
        {{--            </button>--}}
        {{--            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownItem4">--}}
        {{--              <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>--}}
        {{--              <a class="dropdown-item" href="javascript:void(0);">Last Month</a>--}}
        {{--              <a class="dropdown-item" href="javascript:void(0);">Last Year</a>--}}
        {{--            </div>--}}
        {{--          </div>--}}
        {{--        </div>--}}
        {{--        <div class="card-body">--}}
        {{--          <div class="row">--}}
        {{--            <div class="col-sm-2 col-12 d-flex flex-column flex-wrap text-center">--}}
        {{--              <h1 class="font-large-2 font-weight-bolder mt-2 mb-0">200+</h1>--}}
        {{--              <p class="card-text">Courses</p>--}}
        {{--            </div>--}}
        {{--            <div class="col-sm-10 col-12 d-flex justify-content-center">--}}
        {{--              <div id="support-trackers-chart"></div>--}}
        {{--            </div>--}}
        {{--          </div>--}}
        {{--          <div class="d-flex justify-content-between mt-1">--}}
        {{--            <div class="text-center">--}}
        {{--              <p class="card-text mb-50">New Courses</p>--}}
        {{--              <span class="font-large-1 font-weight-bold">29</span>--}}
        {{--            </div>--}}
        {{--            <div class="text-center">--}}
        {{--              <p class="card-text mb-50">Draft Courses</p>--}}
        {{--              <span class="font-large-1 font-weight-bold">63</span>--}}
        {{--            </div>--}}
        {{--            <div class="text-center">--}}
        {{--              <p class="card-text mb-50">Average Response Time</p>--}}
        {{--              <span class="font-large-1 font-weight-bold">1d</span>--}}
        {{--            </div>--}}
        {{--          </div>--}}
        {{--        </div>--}}
        {{--      </div>--}}
        {{--    </div>--}}
        <!-- Support Tracker Chart Card ends -->
        </div>

        <div class="row match-height">
            <!-- Timeline Card -->
        {{--    <div class="col-lg-4 col-12">--}}
        {{--      <div class="card card-user-timeline">--}}
        {{--        <div class="card-header">--}}
        {{--          <div class="d-flex align-items-center">--}}
        {{--            <i data-feather="list" class="user-timeline-title-icon"></i>--}}
        {{--            <h4 class="card-title">User Timeline</h4>--}}
        {{--          </div>--}}
        {{--        </div>--}}
        {{--        <div class="card-body">--}}
        {{--          <ul class="timeline ml-50 mb-0">--}}
        {{--            <li class="timeline-item">--}}
        {{--              <span class="timeline-point timeline-point-indicator"></span>--}}
        {{--              <div class="timeline-event">--}}
        {{--                <h6>12 Invoices have been paid</h6>--}}
        {{--                <p>Invoices are paid to the company</p>--}}
        {{--                <div class="media align-items-center">--}}
        {{--                  <img class="mr-1" src="{{asset('images/icons/json.png')}}" alt="data.json" height="23" />--}}
        {{--                  <h6 class="media-body mb-0">data.json</h6>--}}
        {{--                </div>--}}
        {{--              </div>--}}
        {{--            </li>--}}
        {{--            <li class="timeline-item">--}}
        {{--              <span class="timeline-point timeline-point-warning timeline-point-indicator"></span>--}}
        {{--              <div class="timeline-event">--}}
        {{--                <h6>Client Meeting</h6>--}}
        {{--                <p>Project meeting with Carl</p>--}}
        {{--                <div class="media align-items-center">--}}
        {{--                  <div class="avatar mr-50">--}}
        {{--                    <img--}}
        {{--                      src="{{asset('images/portrait/small/avatar-s-9.jpg')}}"--}}
        {{--                      alt="Avatar"--}}
        {{--                      width="38"--}}
        {{--                      height="38"--}}
        {{--                    />--}}
        {{--                  </div>--}}
        {{--                  <div class="media-body">--}}
        {{--                    <h6 class="mb-0">Carl Roy (Client)</h6>--}}
        {{--                    <p class="mb-0">CEO of Infibeam</p>--}}
        {{--                  </div>--}}
        {{--                </div>--}}
        {{--              </div>--}}
        {{--            </li>--}}
        {{--            <li class="timeline-item">--}}
        {{--              <span class="timeline-point timeline-point-info timeline-point-indicator"></span>--}}
        {{--              <div class="timeline-event">--}}
        {{--                <h6>Create a new project</h6>--}}
        {{--                <p>Add files to new design folder</p>--}}
        {{--                <div class="avatar-group">--}}
        {{--                  <div--}}
        {{--                    data-toggle="tooltip"--}}
        {{--                    data-popup="tooltip-custom"--}}
        {{--                    data-placement="bottom"--}}
        {{--                    data-original-title="Billy Hopkins"--}}
        {{--                    class="avatar pull-up"--}}
        {{--                  >--}}
        {{--                    <img--}}
        {{--                      src="{{asset('images/portrait/small/avatar-s-9.jpg')}}"--}}
        {{--                      alt="Avatar"--}}
        {{--                      width="33"--}}
        {{--                      height="33"--}}
        {{--                    />--}}
        {{--                  </div>--}}
        {{--                  <div--}}
        {{--                    data-toggle="tooltip"--}}
        {{--                    data-popup="tooltip-custom"--}}
        {{--                    data-placement="bottom"--}}
        {{--                    data-original-title="Amy Carson"--}}
        {{--                    class="avatar pull-up"--}}
        {{--                  >--}}
        {{--                    <img--}}
        {{--                      src="{{asset('images/portrait/small/avatar-s-6.jpg')}}"--}}
        {{--                      alt="Avatar"--}}
        {{--                      width="33"--}}
        {{--                      height="33"--}}
        {{--                    />--}}
        {{--                  </div>--}}
        {{--                  <div--}}
        {{--                    data-toggle="tooltip"--}}
        {{--                    data-popup="tooltip-custom"--}}
        {{--                    data-placement="bottom"--}}
        {{--                    data-original-title="Brandon Miles"--}}
        {{--                    class="avatar pull-up"--}}
        {{--                  >--}}
        {{--                    <img--}}
        {{--                      src="{{asset('images/portrait/small/avatar-s-8.jpg')}}"--}}
        {{--                      alt="Avatar"--}}
        {{--                      width="33"--}}
        {{--                      height="33"--}}
        {{--                    />--}}
        {{--                  </div>--}}
        {{--                  <div--}}
        {{--                    data-toggle="tooltip"--}}
        {{--                    data-popup="tooltip-custom"--}}
        {{--                    data-placement="bottom"--}}
        {{--                    data-original-title="Daisy Weber"--}}
        {{--                    class="avatar pull-up"--}}
        {{--                  >--}}
        {{--                    <img--}}
        {{--                      src="{{asset('images/portrait/small/avatar-s-7.jpg')}}"--}}
        {{--                      alt="Avatar"--}}
        {{--                      width="33"--}}
        {{--                      height="33"--}}
        {{--                    />--}}
        {{--                  </div>--}}
        {{--                  <div--}}
        {{--                    data-toggle="tooltip"--}}
        {{--                    data-popup="tooltip-custom"--}}
        {{--                    data-placement="bottom"--}}
        {{--                    data-original-title="Jenny Looper"--}}
        {{--                    class="avatar pull-up"--}}
        {{--                  >--}}
        {{--                    <img--}}
        {{--                      src="{{asset('images/portrait/small/avatar-s-20.jpg')}}"--}}
        {{--                      alt="Avatar"--}}
        {{--                      width="33"--}}
        {{--                      height="33"--}}
        {{--                    />--}}
        {{--                  </div>--}}
        {{--                </div>--}}
        {{--              </div>--}}
        {{--            </li>--}}
        {{--            <li class="timeline-item">--}}
        {{--              <span class="timeline-point timeline-point-danger timeline-point-indicator"></span>--}}
        {{--              <div class="timeline-event">--}}
        {{--                <h6>Update project for client</h6>--}}
        {{--                <p class="mb-0">Update files as per new design</p>--}}
        {{--              </div>--}}
        {{--            </li>--}}
        {{--          </ul>--}}
        {{--        </div>--}}
        {{--      </div>--}}
        {{--    </div>--}}
        <!--/ Timeline Card -->

            <!-- Sales Stats Chart Card starts -->
        {{--    <div class="col-lg-4 col-md-6 col-12">--}}
        {{--      <div class="card">--}}
        {{--        <div class="card-header d-flex justify-content-between align-items-start pb-1">--}}
        {{--          <div>--}}
        {{--            <h4 class="card-title mb-25">Sales</h4>--}}
        {{--            <p class="card-text">Last 6 months</p>--}}
        {{--          </div>--}}
        {{--          <div class="dropdown chart-dropdown">--}}
        {{--            <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-toggle="dropdown"></i>--}}
        {{--            <div class="dropdown-menu dropdown-menu-right">--}}
        {{--              <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>--}}
        {{--              <a class="dropdown-item" href="javascript:void(0);">Last Month</a>--}}
        {{--              <a class="dropdown-item" href="javascript:void(0);">Last Year</a>--}}
        {{--            </div>--}}
        {{--          </div>--}}
        {{--        </div>--}}
        {{--        <div class="card-body">--}}
        {{--          <div class="d-inline-block mr-1">--}}
        {{--            <div class="d-flex align-items-center">--}}
        {{--              <i data-feather="circle" class="font-small-3 text-primary mr-50"></i>--}}
        {{--              <h6 class="mb-0">Sales</h6>--}}
        {{--            </div>--}}
        {{--          </div>--}}
        {{--          <div class="d-inline-block">--}}
        {{--            <div class="d-flex align-items-center">--}}
        {{--              <i data-feather="circle" class="font-small-3 text-info mr-50"></i>--}}
        {{--              <h6 class="mb-0">Visits</h6>--}}
        {{--            </div>--}}
        {{--          </div>--}}
        {{--          <div id="sales-visit-chart" class="mt-50"></div>--}}
        {{--        </div>--}}
        {{--      </div>--}}
        {{--    </div>--}}
        <!-- Sales Stats Chart Card ends -->
{{--            Current package--}}
            <div class="col-sm-12 col-md-12 col-12">
                <div class="card card-app-design">
                    <div class="card-body text-center">
                        <h4 class="card-title mt-1 mb-75 pt-25">Your package is : <span class="text-primary font-weight-bold">Basic - 1DR9.99</span></h4>
                        <h5 class="card-title mt-1 mb-75 pt-25">Package Duration : <span class="text-primary font-weight-bold">12 Apr, 2021 - 12 May, 2021</span></h5>
                        <h5 class="card-title mt-1 mb-75 pt-25">Availed quota : <span class="text-primary font-weight-bold">1 / 10</span></h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-12 text-center mb-2">
                <div class="row">
                    <div class="col">

                    </div>
                    <div class="col">
                        <h1 class="mb-75 pt-25">Upgrade Package</h1>
                    </div>
                    <div class="col text-right">
                 <div class="btn btn-primary p-1">7 days free trail</div>
                    </div>
                </div>
            </div>
            <!-- App Design Card -->
            <div class="col-lg-3 col-md-6 col-12">
              <div class="card card-app-design">
                <div class="card-body text-center">
                    <h2 class="mt-1 mb-75 pt-25 text-danger">Bronze  Plan</h2>
                    <h2 class="mt-1 mb-75 pt-25 text-primary">1 Year</h2>
                    <h5 class="mt-1 mb-75 pt-25">12 Job Posting / can View 600 Applied and Unapplied</h5>
                    <h6 class="mt-1 mb-75 pt-25">Only Can Add three Locations  in one Job Posting </h6>
                  <button type="button" class="btn btn-primary btn-block">Buy Now</button>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card card-app-design">
                    <div class="card-body text-center">
                        {{--                  <div class="badge badge-light-primary">03 Sep, 20</div>--}}
                        <h2 class="mt-1 mb-75 pt-25 text-danger">Silver  Plan</h2>
                        <h2 class="mt-1 mb-75 pt-25 text-primary">1 Year</h2>
                        <h5 class="mt-1 mb-75 pt-25">40 Job Posting / Can View 3000 CV Applied</h5>
                        <h6 class="mt-1 mb-75 pt-25">Non Appliedd Can Add Only 5 Location for One Job Posting</h6>
                        <button type="button" class="btn btn-primary btn-block">Buy Now</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card card-app-design">
                    <div class="card-body text-center">
                        {{--                  <div class="badge badge-light-primary">03 Sep, 20</div>--}}
                        <h2 class="mt-1 mb-75 pt-25 text-danger"><strong>Gold Plan</strong></h2>
                        <h2 class="mt-1 mb-75 pt-25 text-primary">1 Year</h2>
                        <h5 class="mt-1 mb-75 pt-25">100 Job Posting / Can View 10000 CV Applied and Non Applied </h5>
                        <h6 class="mt-1 mb-75 pt-25"> Can Add 7 Location for One Job Posting</h6>
                        <button type="button" class="btn btn-primary btn-block">Buy Now</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card card-app-design">
                    <div class="card-body text-center">
                        {{--                  <div class="badge badge-light-primary">03 Sep, 20</div>--}}
                        <h2 class="mt-1 mb-75 pt-25 text-info"><strong>Agency Plan  Basic</strong></h2>
                        <h2 class="mt-1 mb-75 pt-25 text-primary">1 Year</h2>
                        <h4 class=" mt-1 mb-75 pt-25">Can Access  2500 CVs In a Year Through Search Criteria</h4>
                        <h6 class=" mt-1 mb-75 pt-25">Job Posting 12 In a Year with Three Locations Only </h6>
                        <button type="button" class="btn btn-primary btn-block">Buy Now</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card card-app-design">
                    <div class="card-body text-center">
                        {{--                  <div class="badge badge-light-primary">03 Sep, 20</div>--}}
                        <h2 class="mt-1 mb-75 pt-25 text-info"><strong>Agency Plan Gold</strong></h2>
                        <h2 class="mt-1 mb-75 pt-25 text-primary">1 Year</h2>
                        <h6 class="card-title mt-1 mb-75 pt-25">Can Access 8000 CVs in a Year / </h6>
                        <h6 class="card-title mt-1 mb-75 pt-25">Can Post Job 100</h6>
                        <button type="button" class="btn btn-primary btn-block">Buy Now</button>
                    </div>
                </div>
            </div>
        <!--/ App Design Card -->
        </div>

        <!-- List DataTable -->
{{--        <div class="row">--}}
{{--            <div class="col-12">--}}
{{--                <div class="card invoice-list-wrapper">--}}
{{--                    <div class="card-datatable table-responsive">--}}
{{--                        <table class="invoice-list-table table">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th></th>--}}
{{--                                <th>#</th>--}}
{{--                                --}}{{--                <th><i data-feather="trending-up"></i></th>--}}
{{--                                <th>Orders</th>--}}
{{--                                <th>Total</th>--}}
{{--                                <th class="text-truncate">Course Taken Date</th>--}}
{{--                                <th>Amount Paid</th>--}}
{{--                                --}}{{--                <th>Invoice Status</th>--}}
{{--                                --}}{{--                <th class="cell-fit">Actions</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <!--/ List DataTable -->
    </section>
    <!-- Dashboard Analytics end -->
@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/moment.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap.min.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/pages/dashboard-analytics.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/pages/app-invoice-list.js')) }}"></script>
@endsection

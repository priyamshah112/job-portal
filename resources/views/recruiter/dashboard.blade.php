
@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard Analytics')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection
@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/charts/chart-apex.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('content')
    <!-- Dashboard Analytics Start -->
    <section id="dashboard-analytics">
        <div class="row match-height">
            <!-- Subscribers Chart Card starts -->
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header flex-column align-items-start pb-0">
                        <div class="avatar bg-light-primary p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather="book" class="font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="font-weight-bolder mt-1">{{$jobs_count}} <small class="card-text">Jobs Created</small></h2>
                    </div>
                    <div id="jobs-chart"></div>
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
                        <h2 class="font-weight-bolder mt-1">{{$candidates_count}} <small class="card-text">Candidates</small></h2>
                    </div>
                    <div id="candidates-chart"></div>
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
                        <h2 class="font-weight-bolder mt-1">{{$total_hired_count}} <small class="card-text">Selected Candidates</small></h2>
                    </div>
                    <div id="selected-chart"></div>
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
                        <h2 class="font-weight-bolder mt-1">{{$amount_spent}} <small class="card-text">Amount Spent</small></h2>
                    </div>
                    <div id="amount-spent-chart"></div>
                </div>
            </div>
        </div>

        <div class="row match-height">
            <div class="col-sm-12 col-md-12 col-12">
                <div class="card card-app-design">
                    <div class="card-body text-center">
                        @if(!empty($active_plan) && $active_plan->package !== null)
                            <h4 class="card-title mt-1 mb-75 pt-25">Your package is : <span class="text-primary font-weight-bold">{{$active_plan->package['plan_name']}}</span></h4>
                            <h5 class="card-title mt-1 mb-75 pt-25">Package Duration : <span class="text-primary font-weight-bold">{{$active_plan->from_date}} - {{$active_plan->to_date}}</span></h5>
                            <h5 class="card-title mt-1 mb-75 pt-25">Availed quota : <span class="text-primary font-weight-bold">{{$active_plan->post_quota_used ? $active_plan->post_quota_used : 0 }} / {{$active_plan->package['post_quota']}}</span></h5>
                        @else
                            <h5 class="card-title mt-1 mb-75 pt-25">No Active Plan</h5>                            
                        @endif
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
                        <div class="btn btn-primary p-1">30 days free trail</div>
                    </div>
                </div>
            </div>
            <!-- App Design Card -->
            @foreach ($packages as $package)
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card card-app-design">
                    <div class="card-body text-center">
                        <h4 class="mt-1 mb-75 pt-25 text-danger">{{$package->plan_name}}</h4>
                        <h2 class="mt-1 mb-75 pt-25 {{$package->amount === 0 ? 'text-success' : 'text-primary'}}">{{$package->amount === 0 ? 'Free' : $package->amount.' Rs'}}</h2>
                        <h5 class="mt-1 mb-75 pt-25">{{$package->post_quota === 'unlimited' ? 'Unlimited' : $package->post_quota }} Job Posting</h5>
                        @php
                            $numberToWord = [
                                1 => 'one',
                                3 => 'three'
                            ]
                        @endphp
                        <h5 class="mt-1 mb-75 pt-25">Package Duration: {{ $package->duration }} Months</h5>
                        <h6 class="mt-1 mb-75 pt-25">Only can add {{$numberToWord[$package->location_quota]}} locations  in one job posting </h6>
                    <button type="button" class="btn btn-primary btn-block buy-button" data-id="{{$package->id}}"  data-plan="{{$package->plan_name}}">Buy Now</button>
                    </div>
                </div>
            </div>                
            @endforeach            
        </div>
    </section>
    <!-- Dashboard Analytics end -->
@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="{{asset(mix('js/main/config.js'))}}"></script>
    <script src="{{ asset(mix('js/main/recruiter/dashboard.js')) }}"></script>
@endsection

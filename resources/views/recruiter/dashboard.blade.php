
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
            @foreach ($packages as $package)
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card card-app-design">
                    <div class="card-body text-center">
                        <h2 class="mt-1 mb-75 pt-25 text-danger">{{$package->plan_name}}</h2>
                        <h2 class="mt-1 mb-75 pt-25 text-primary">{{$package->duration}} Days</h2>
                        <h5 class="mt-1 mb-75 pt-25">{{$package->post_quota}} Job Posting / can View 600 Applied and Unapplied</h5>
                        <h6 class="mt-1 mb-75 pt-25">Only Can Add three Locations  in one Job Posting </h6>
                    <button type="button" class="btn btn-primary btn-block">Buy Now</button>
                    </div>
                </div>
            </div>                
            @endforeach            
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

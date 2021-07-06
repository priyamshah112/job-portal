@extends('layouts/contentLayoutMaster')

@section('title', 'Jobs List')

@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap4.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-user.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
  <style>
    .dataTables_wrapper div:nth-child(1), .dataTables_wrapper div:nth-child(3) {
        padding: 0 10px;
    }
    .action-cell{
      min-width: 80px;
    }
</style>
@endsection
@section('content')
<div class="float-right" style="margin-top: -50px">
    <a href="{{route('jobs-create')}}" class="btn btn-primary">Add Job</a>
</div>
<!-- cateory list start -->
<section class="app-category-list" >
  <!-- list section start -->
  <div class="card">
    <div class="card-datatable table-responsive pt-0">
      <table id="pageTable"  class="category-list-table table">
        <thead class="thead-light">
          <tr>
            <th>Position</th>
            <th>Number of Posisions</th>
            <th>Experience</th>
            <th>Deadline</th>
            <th>Created At</th>
            <th>Score</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
  <!-- list section end -->
</section>
<!-- category list ends -->
@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
  <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap4.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.bootstrap4.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{asset(mix('js/main/config.js'))}}"></script>
@endsection

@section('page-script')
<script src="{{asset(mix('js/main/config.js'))}}"></script>
<script src="{{asset(mix('js/main/recruiter/applied-candidate.js'))}}"></script>
@endsection
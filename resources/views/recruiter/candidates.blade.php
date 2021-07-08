@extends('layouts/contentLayoutMaster')

@section('title', 'Applied Candidate List')

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
    .action-cell{
      min-width: 80px;
    }
    .candidate-profile{
      padding: 0px !important;
    }
    .candidate-profile img{
      width: 40px;
      height: 40px;
    }
</style>
@endsection
@section('content')
<!-- cateory list start -->
<section class="app-category-list" >
  <!-- list section start -->
  <div class="card">
    <div class="card-datatable table-responsive pt-0">
      <table id="pageTable"  class="category-list-table table">
        <thead class="thead-light">
          <tr>
            <th>Profile</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Position</th>
            <th>Category</th>
            <th>Deadline</th>
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
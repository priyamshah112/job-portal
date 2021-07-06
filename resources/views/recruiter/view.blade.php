@extends('layouts/contentLayoutMaster')

@section('title', 'Recruiters')

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
@endsection

@section('content')
    <div class="float-right" style="margin-top: -50px">
        <a href="{{route('recruiters')}}" class="btn btn-primary">Back</a>
    </div>
    <!-- cateory list start -->
    <section class="app-category-list">
        <!-- list section start -->
        <div class="card">
            <div class="card-body">
                @if(!$user)
                    <h4 class="text-center">Invalid Recruiter!</h4>
                @else
                    <div class="row">
                        <div class="col-md-4 border-right">
                            <div class="col-12">
                                <h2 class="text-primary"><span
                                            class="d-none d-sm-block"><i data-feather="user"></i> Personal Info</span>
                                </h2>
                            </div>
                            <div class="row mt-2 justify-content-center">
                                <div class="col-lg-12 col-md-12 text-center">
                                    @if($user->img_path == null && $user->img_name ==null)
                                        <img class="round mr-1" src="/images/avatars/default_user.jpeg"
                                             alt="avatar"
                                             height="100px"
                                             width="100px">
                                    @else
                                        <img class="round mr-1" src='/{{$user->img_path}}/{{$user->image_name}}'
                                             height="100px"
                                             width="100px">
                                    @endif
                                </div>
                                <div class="col-lg-8 col-md-8 mt-2 text-center">
                                    <div class="col-lg-12 col-md-12">
                                        <h3 class="text-black-900">{{$user->first_name}} {{$user->last_name}}</h3>
                                    </div>
                                    <div class="col-lg-12 col-md-12 mt-1">
                                        <a href="mailto:{{$user->email}}"> <h5>{{$user->email}}</h5></a>
                                    </div>
                                    <div class="col-lg-12 col-md-12 mt-1">
                                        <a href="tel:{{$user->mobile_number}}"><h5>{{$user->mobile_number}}</h5></a>
                                    </div>
                                    <div class="col-lg-12 col-md-12 mt-1">
                                        @if($user->active == 1)
                                            <span class="badge badge-success">Active</span>
                                        @elseif($user->active == 2)
                                            <span class="badge badge-danger">Blocked</span>
                                        @else
                                            <span class="badge badge-warning">In-Active</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="col-12">
                                <h2 class="text-primary"><span
                                            class="d-none d-sm-block"><i data-feather="info"></i> Company Info</span>
                                </h2>
                            </div>
                            <div class="col-lg-12 col-md-12 mt-1">
                                <h4><span><i class="text-info"
                                             data-feather="briefcase"></i> </span> {{$user->recruiter->company_name}}
                                </h4>
                            </div>
                            <div class="col-lg-12 col-md-12 mt-1">
                                <h4><span><i class="text-success"
                                             data-feather="navigation"></i> </span> {{$user->recruiter->company_address}}
                                </h4>
                            </div>
                            <hr class="text-primary ml-2 mr-2">
                            <div class="col-lg-12 col-md-12 mt-1">
                                <p><span>Landline 1 - </span>
                                    <a href="tel:{{$user->recruiter->company_landline_1}}">{{$user->recruiter->company_landline_1}}</a>
                                </p>
                            </div>
                            <div class="col-lg-12 col-md-12 mt-1">
                                <p><span>Landline 2 - </span>
                                    <a href="tel:{{$user->recruiter->company_landline_2}}">{{$user->recruiter->company_landline_2}}</a>
                                </p>
                            </div>
                            <div class="col-lg-12 col-md-12 mt-1">
                                <p><span>Primary Number - </span>
                                    <a href="tel:{{$user->recruiter->company_mobile_1}}">{{$user->recruiter->company_mobile_1}}</a>
                                </p>
                            </div>
                            <div class="col-lg-12 col-md-12 mt-1">
                                <p><span>Alternative Number - </span>
                                    <a href="tel:{{$user->recruiter->company_mobile_2}}">{{$user->recruiter->company_mobile_2}}</a>
                                </p>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <hr class="p-1 text-primary">
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="row">
                                    <div class="col-md-4 text-left">
                                        <h4 class="ml-2 bg-lightNew p-1 rounded rounded-lg"><strong>Industry Type</strong>
                                        </h4>
                                    </div>
                                    <div class="col-md-8 text-left">
                                        <h4 class="ml-2 bg-lightNew p-1 rounded rounded-lg">
                                            {{$user->recruiter->department_id ? $user->recruiter->department_id : '-'}}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 mt-1">
                                <div class="row">
                                    <div class="col-md-4 text-left">
                                        <h4 class="ml-2 bg-lightNew p-1 rounded rounded-lg"><strong>No of
                                                Employees</strong></h4>
                                    </div>
                                    <div class="col-md-8 text-left">
                                        <h4 class="ml-2 bg-lightNew p-1 rounded rounded-lg">
                                            {{$user->recruiter->no_of_employees ? $user->recruiter->no_of_employees : '-'}}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 mt-1">
                                <div class="row">
                                    <div class="col-md-4 text-left">
                                        <h4 class="ml-2 bg-lightNew p-1 rounded rounded-lg"><strong>Annual
                                                Turnover</strong></h4>
                                    </div>
                                    <div class="col-md-8 text-left">
                                        <h4 class="ml-2 bg-lightNew p-1 rounded rounded-lg">
                                            {{$user->recruiter->annual_turnover ? $user->recruiter->annual_turnover : '-'}}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 mt-1">
                                <div class="row">
                                    <div class="col-md-4 text-left ml-0 mr-0">
                                        <h4 class="ml-2 bg-lightNew p-1 rounded rounded-lg"><strong>Document Name</strong>
                                        </h4>
                                    </div>
                                    <div class="col-md-8 text-left ml-0 mr-0">
                                        <h4 class="ml-2 bg-lightNew p-1 rounded rounded-lg">
                                            {{$user->recruiter->doc_name ? $user->recruiter->doc_name : '-'}}</h4>
                                    </div>
                                </div>
                            </div>
                            <h4 class="mt-2">Attachments : </h4>
                            <hr>
                            @if(count($user->recruiter->attachments)>0)
                            <div id="myatt" class="myattachments">
                                @foreach($user->recruiter->attachments as $att)
                                <div class="media mb-1 previtem">
                                    @if(strtolower($att->extension) == 'pdf')
                                    <img src="{{asset('images/icons/pdf.png')}}"  class="mr-1" alt="pdf" height="50" width="40">
                                    @else
                                    <img src="{{asset('images/icons/img.png')}}"  class="mr-1" alt="pdf" height="50" width="40">
                                    @endif
                                    <div class="media-body">
                                        <h5 class="mb-1 font-weight-bold">{{$att->file_name}}</h5>
                                        <p>
                                            <button onclick="preview('{{$att->file_path}}', '{{$att->extension}}')" class="btn btn-primary btn-sm mr-1"><i data-feather="eye"></i> View</button>
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div id="myatt" class="myattachments">No Attachments Found</div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <!-- list section end -->
    </section>
    <!-- category list ends -->
<div class="modal" id="previewmodal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attachment Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="previewHolder"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('vendor-script')
    {{-- Vendor js files --}}
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
    {{-- Page js files --}}
    <script>
        function preview(path, ex) {
            $("#previewHolder").html('');
            if (ex == 'pdf') {
                $("#previewHolder").html('<embed src="/'+path+'" style="height: 100%;width: 100%;min-height: 500px;" />');
            } else {
                $("#previewHolder").html('<img src="/'+path+'" style="height: 100%; width: 100%;">');
            }
            $("#previewmodal").modal('show');
        }
    </script>
@endsection


@extends('layouts/contentLayoutMaster')

@section('title', 'Courses')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">
@endsection

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-file-uploader.css')) }}">
@endsection

@section('content')
<!-- Basic Inputs start -->
<section id="basic-input">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Upload a new Course</h4>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Course Title</label>
                <input type="text" class="form-control" id="basicInput" placeholder="Enter Course Name" />
              </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicSelect">Course Category</label>
                <select class="form-control" id="basicSelect">
                  <option>--Please select a category--</option>
                  <option>Cardiology</option>
                  <option>Biostatistics</option>
                  <option>Pathology</option>
                </select>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Course Overview</h4>
              </div>
              <div class="card-body">
                <p class="card-text">All breif details about contents of  <code>the course.</code>.</p>
                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="exampleFormControlTextarea1">Breif</label>
                      <textarea
                              class="form-control"
                              id="exampleFormControlTextarea1"
                              rows="3"
                              placeholder="Textarea"
                      ></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Course Objectives</h4>
                  </div>
                  <div class="card-body">
                    <p class="card-text">
                      Upload All Course Related Objectives. Let users understand what they will gain from this course.
                    </p>
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" id="basicInput" placeholder="Enter Objectives" />
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <a href="#">
                            <i data-feather='trash-2'></i>
                          </a>
                        </span>
                      </div>
                    </div>
                    <a class="btn btn-primary" href="#" role="button"><i data-feather='plus'></i>
                      Add more Objectives</a>
                    </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Course Lectures</h4>
                  </div>
                  <div class="card-body">
                    <p class="card-text">
                      Upload All Media Related to this Course. Bet it Videos, Images, PDFs, Course Documents etc.
                    </p>
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" id="basicInput" placeholder="Enter Lecture Name" />
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <a href="#" data-toggle="modal" data-target="#inlineForm">
                            <i data-feather='upload'></i>
                          </a>
                        </span>
                        <br>
                        <span class="input-group-text">
                          <a href="#">
                            <i data-feather='trash-2'></i>
                          </a>
                        </span>
                      </div>
                    </div>
                    <a class="btn btn-primary" href="#" role="button" target="_blank"><i data-feather='plus'></i>
                      Add more lectures</a>
                    <div
                            class="modal fade text-left"
                            id="inlineForm"
                            tabindex="-1"
                            role="dialog"
                            aria-labelledby="myModalLabel33"
                            aria-hidden="true"
                    >
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel33">Lecture Details</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="col-12">
                              <div class="card">
                                <div class="card-header">
                                  <h4 class="card-title">Multiple Media Upload</h4>
                                </div>
                                <div class="card-body">
                                  <form action="#" class="dropzone dropzone-area" id="dpz-multiple-files">
                                    <div class="dz-message">Drop files here or click to upload.</div>
                                  </form>
                                </div>
                                <a class="btn btn-primary" href="#" role="button" target="_blank">Save</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-8">
              <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                  <div class="demo-inline-spacing">
                    <a class="btn btn-primary" href="#" role="button" target="_blank">Save</a>
                    <button class="btn btn-outline-secondary waves-effect" type="button">Draft</button>
                  </div>
                </div>
              </div>
            </div>
{{--            <div class="col-xl-4 col-md-6 col-12 mb-1">--}}
{{--              <div class="form-group">--}}
{{--                <label for="disabledInput">Disabled Input</label>--}}
{{--                <input type="text" class="form-control" id="disabledInput" disabled />--}}
{{--              </div>--}}
{{--            </div>--}}
{{--            <div class="col-xl-4 col-md-6 col-12">--}}
{{--              <div class="form-group">--}}
{{--                <label for="helperText">With Helper Text</label>--}}
{{--                <input type="text" id="helperText" class="form-control" placeholder="Name" />--}}
{{--                <p><small class="form-text">Find helper text here for given textbox.</small></p>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--            <div class="col-xl-4 col-md-6 col-12">--}}
{{--              <div class="form-group">--}}
{{--                <label for="disabledInput">Readonly Input</label>--}}
{{--                <input--}}
{{--                  type="text"--}}
{{--                  class="form-control"--}}
{{--                  id="readonlyInput"--}}
{{--                  readonly="readonly"--}}
{{--                  value="You can't update me :P"--}}
{{--                />--}}
{{--              </div>--}}
{{--            </div>--}}
{{--            <div class="col-xl-4 col-md-6 col-12">--}}
{{--              <div class="form-group">--}}
{{--                <label for="disabledInput">Readonly Static Text</label>--}}
{{--                <p class="form-control-static" id="staticInput">email@pixinvent.com</p>--}}
{{--              </div>--}}
{{--            </div>--}}
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Basic Inputs end -->

<!-- Input Sizing start -->
{{--<section id="input-sizing">--}}
{{--  <div class="row match-height">--}}
{{--    <div class="col-md-6 col-12">--}}
{{--      <div class="card">--}}
{{--        <div class="card-header">--}}
{{--          <h4 class="card-title">Sizing Options</h4>--}}
{{--        </div>--}}
{{--        <div class="card-body">--}}
{{--          <div class="row">--}}
{{--            <div class="col-12">--}}
{{--              <p class="card-text">--}}
{{--                For different sizes of Input, Use classes like <code>.form-control-lg</code> &amp;--}}
{{--                <code>.form-control-sm</code> for Large, Small input box.--}}
{{--              </p>--}}
{{--              <div class="form-group">--}}
{{--                <label for="largeInput">Large</label>--}}
{{--                <input id="largeInput" class="form-control form-control-lg" type="text" placeholder="Large Input" />--}}
{{--              </div>--}}
{{--              <div class="form-group">--}}
{{--                <label for="defaultInput">Default</label>--}}
{{--                <input id="defaultInput" class="form-control" type="text" placeholder="Normal Input" />--}}
{{--              </div>--}}
{{--              <div class="form-group">--}}
{{--                <label for="smallInput">Small</label>--}}
{{--                <input id="smallInput" class="form-control form-control-sm" type="text" placeholder="Small Input" />--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--        </div>--}}
{{--      </div>--}}
{{--    </div>--}}
{{--    <div class="col-md-6 col-12">--}}
{{--      <div class="card">--}}
{{--        <div class="card-header">--}}
{{--          <h4 class="card-title">Horizontal form label sizing</h4>--}}
{{--        </div>--}}
{{--        <div class="card-body">--}}
{{--          <div class="row">--}}
{{--            <div class="col-12">--}}
{{--              <p class="card-text mb-2">--}}
{{--                Be sure to use <code>.col-form-label-sm</code> or <code>.col-form-label-lg</code> to your--}}
{{--                <code>&lt;label&gt;</code>s or <code>&lt;legend&gt;</code>s to correctly follow the size of--}}
{{--                <code>.form-control-lg</code> and <code>.form-control-sm</code>.--}}
{{--              </p>--}}
{{--              <div class="form-group row">--}}
{{--                <label for="colFormLabelLg" class="col-sm-3 col-form-label col-form-label-lg">Large</label>--}}
{{--                <div class="col-sm-9">--}}
{{--                  <input--}}
{{--                    type="text"--}}
{{--                    class="form-control form-control-lg"--}}
{{--                    id="colFormLabelLg"--}}
{{--                    placeholder="Large Input"--}}
{{--                  />--}}
{{--                </div>--}}
{{--              </div>--}}
{{--              <div class="form-group row">--}}
{{--                <label for="colFormLabel" class="col-sm-3 col-form-label">Default</label>--}}
{{--                <div class="col-sm-9">--}}
{{--                  <input type="text" class="form-control" id="colFormLabel" placeholder="Normal Input" />--}}
{{--                </div>--}}
{{--              </div>--}}
{{--              <div class="form-group row">--}}
{{--                <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Small</label>--}}
{{--                <div class="col-sm-9">--}}
{{--                  <input--}}
{{--                    type="text"--}}
{{--                    class="form-control form-control-sm"--}}
{{--                    id="colFormLabelSm"--}}
{{--                    placeholder="Small Input"--}}
{{--                  />--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--        </div>--}}
{{--      </div>--}}
{{--    </div>--}}
{{--  </div>--}}
{{--</section>--}}
<!-- Input Sizing end -->

<!-- Floating Label Inputs start -->
{{--<section id="floating-label-input">--}}
{{--  <div class="row">--}}
{{--    <div class="col-md-12">--}}
{{--      <div class="card">--}}
{{--        <div class="card-header">--}}
{{--          <h4 class="card-title">Floating Label Inputs</h4>--}}
{{--        </div>--}}
{{--        <div class="card-body">--}}
{{--          <div class="row">--}}
{{--            <div class="col-12 mb-1">--}}
{{--              <p>--}}
{{--                For Floating Label Inputs, need to use <code>.form-label-group</code> class & add attribute--}}
{{--                <code>disabled</code> for disabled Floating Label Input.--}}
{{--              </p>--}}
{{--            </div>--}}
{{--            <div class="col-sm-6 col-12">--}}
{{--              <div class="form-label-group">--}}
{{--                <input type="text" class="form-control" id="floating-label1" placeholder="Label-placeholder" />--}}
{{--                <label for="floating-label1">Label-placeholder</label>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--            <div class="col-sm-6 col-12">--}}
{{--              <div class="form-label-group">--}}
{{--                <input--}}
{{--                  type="text"--}}
{{--                  class="form-control"--}}
{{--                  id="floating-label-disable"--}}
{{--                  placeholder="Label-placeholder"--}}
{{--                  disabled--}}
{{--                />--}}
{{--                <label for="floating-label-disable">Disabled-placeholder</label>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--        </div>--}}
{{--      </div>--}}
{{--    </div>--}}
{{--  </div>--}}
{{--</section>--}}
<!-- Floating Label Inputs end -->

<!-- Basic File Browser start -->
{{--<section id="input-file-browser">--}}
{{--  <div class="row">--}}
{{--    <div class="col-md-12">--}}
{{--      <div class="card">--}}
{{--        <div class="card-header">--}}
{{--          <h4 class="card-title">File input</h4>--}}
{{--        </div>--}}
{{--        <div class="card-body">--}}
{{--          <div class="row">--}}
{{--            <div class="col-lg-6 col-md-12">--}}
{{--              <div class="form-group">--}}
{{--                <label for="basicInputFile">Simple File Input</label>--}}
{{--                <input type="file" class="form-control-file" id="basicInputFile" />--}}
{{--              </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-6 col-md-12">--}}
{{--              <div class="form-group">--}}
{{--                <label for="customFile">With Browse button</label>--}}
{{--                <div class="custom-file">--}}
{{--                  <input type="file" class="custom-file-input" id="customFile" />--}}
{{--                  <label class="custom-file-label" for="customFile">Choose file</label>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--        </div>--}}
{{--      </div>--}}
{{--    </div>--}}
{{--  </div>--}}
{{--</section>--}}
<!-- Basic File Browser end -->

<!-- validations start -->
{{--<section class="validations" id="validation">--}}
{{--  <div class="row">--}}
{{--    <div class="col-12">--}}
{{--      <div class="card">--}}
{{--        <div class="card-header">--}}
{{--          <h4 class="card-title">Input Validation States</h4>--}}
{{--        </div>--}}
{{--        <div class="card-body">--}}
{{--          <div class="row">--}}
{{--            <div class="col-12">--}}
{{--              <p>--}}
{{--                You can indicate invalid and valid form fields with <code>.is-invalid</code> and <code>.is-valid</code>.--}}
{{--                Note that <code>.invalid-feedback</code> is also supported with these classes.--}}
{{--              </p>--}}
{{--            </div>--}}
{{--            <div class="col-sm-6 col-12">--}}
{{--              <label for="valid-state">Valid State</label>--}}
{{--              <input--}}
{{--                type="text"--}}
{{--                class="form-control is-valid"--}}
{{--                id="valid-state"--}}
{{--                placeholder="Valid"--}}
{{--                value="Valid"--}}
{{--                required--}}
{{--              />--}}
{{--              <div class="valid-feedback">This is valid state.</div>--}}
{{--            </div>--}}
{{--            <div class="col-sm-6 col-12">--}}
{{--              <label for="invalid-state">Invalid State</label>--}}
{{--              <input--}}
{{--                type="text"--}}
{{--                class="form-control is-invalid"--}}
{{--                id="invalid-state"--}}
{{--                placeholder="Invalid"--}}
{{--                value="Invalid"--}}
{{--                required--}}
{{--              />--}}
{{--              <div class="invalid-feedback">This is invalid state.</div>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--        </div>--}}
{{--      </div>--}}
{{--    </div>--}}
{{--  </div>--}}
{{--</section>--}}
<!-- validations end -->

<!-- Tooltip validations start -->
{{--<section class="tooltip-validations" id="tooltip-validation">--}}
{{--  <div class="row">--}}
{{--    <div class="col-12">--}}
{{--      <div class="card">--}}
{{--        <div class="card-header">--}}
{{--          <h4 class="card-title">Input Validation States with Tootltips</h4>--}}
{{--        </div>--}}
{{--        <div class="card-body">--}}
{{--          <p>--}}
{{--            <code>.{valid/invalid}-feedback</code> classes for <code>.{valid/invalid}-tooltip</code> classes to display--}}
{{--            validation feedback in a styled tooltip.--}}
{{--          </p>--}}
{{--          <form class="needs-validation" novalidate>--}}
{{--            <div class="form-row">--}}
{{--              <div class="col-md-4 col-12 mb-3">--}}
{{--                <label for="validationTooltip01">First name</label>--}}
{{--                <input--}}
{{--                  type="text"--}}
{{--                  class="form-control"--}}
{{--                  id="validationTooltip01"--}}
{{--                  placeholder="First name"--}}
{{--                  value="Mark"--}}
{{--                  required--}}
{{--                />--}}
{{--                <div class="valid-tooltip">Looks good!</div>--}}
{{--              </div>--}}
{{--              <div class="col-md-4 col-12 mb-3">--}}
{{--                <label for="validationTooltip02">Last name</label>--}}
{{--                <input--}}
{{--                  type="text"--}}
{{--                  class="form-control"--}}
{{--                  id="validationTooltip02"--}}
{{--                  placeholder="Last name"--}}
{{--                  value="Otto"--}}
{{--                  required--}}
{{--                />--}}
{{--                <div class="valid-tooltip">Looks good!</div>--}}
{{--              </div>--}}
{{--              <div class="col-md-4 col-12 mb-3">--}}
{{--                <label for="validationTooltip03">City</label>--}}
{{--                <input type="text" class="form-control" id="validationTooltip03" placeholder="City" required />--}}
{{--                <div class="invalid-tooltip">Please provide a valid city.</div>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--            <button class="btn btn-primary" type="submit">Submit</button>--}}
{{--          </form>--}}
{{--        </div>--}}
{{--      </div>--}}
{{--    </div>--}}
{{--  </div>--}}
{{--</section>--}}
<!-- Tooltip validations end -->
@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
@endsection

@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/form-tooltip-valid.js')) }}"></script>
  <script>
    $('#inlineForm').on('shown.bs.modal', function (e) {
      $(function (){
        'use strict';

        var singleFile = $('#dpz-single-file');
        var multipleFiles = $("#dpz-multiple-files");

        // Multiple Files
        multipleFiles.dropzone({
          paramName: 'file', // The name that will be used to transfer the file
          maxFilesize: 0.5, // MB
          clickable: true
        });
      });
    });
  </script>
@endsection

@extends('layouts/contentLayoutMaster')

@section('title', 'Video Resume')

@section('vendor-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-user.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
    </style>
@endsection

@section('content')
    <!-- cateory list start -->
    @if (session()->has('success-message'))
        <div class="alert-box alert-success" id="success">
            {{ session()->get('success-message') }}
        </div>
    @endif
    @if (session()->has('error-message'))
        <div class="alert alert-danger">
            {{ session()->get('error-message') }}
        </div>
    @endif
    <section class="app-category-list">
        <!-- list section start -->
        <div class="modal fade" id="sample-video-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title text-primary">Sample Video</h3>
                        <button type="button" class="close modal-close-button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body d-flex justify-content-center p-0"> 
                        <video height="450px" controls>
                            <source
                                src="{{ URL::asset('images/video/VID-20210808-WA0002.mp4')}}"
                                type="video/mp4">
                                Your browser does not support the video tag.
                        </video> 
                    </div>
                </div>
            </div>
          </div>
        <div class="card p-2">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center capturedVideo {{ $capturedVideo ? '' : 'd-none' }}">
                    <div class="d-flex justify-content-center">
                        <video height="500" controls>
                            <source
                                src="{{ URL::asset($candidate->video_resume_path . '/' . $candidate->video_resume_name) }}"
                                type="video/mp4">
                                Your browser does not support the video tag.
                        </video>  
                    </div> 
                    <div class="d-flex justify-content-center mt-3">
                        <button class="btn btn-success rounded-lg mr-1 record-again">Record again</button>
                        <a class="btn btn-outline-danger delete-video">Delete</a>
                    </div>
                </div>
                <div class="col-md-12 newVideo {{ $capturedVideo ? 'd-none' : '' }}">
                    <div class="col-md-12 videoPreview text-center">
                        <h2 class="text-primary">Capture Video</h2>
                        <div class="textPreview mt-1">
                            <h4 class="text-dark">Tell us something about you, Remember your first Impression must be
                                impactful!</h4>
                            <br>
                            <h4 class="text-dark">Here are something hints that might help you!</h4>
                            <div class="text-black">
                                <p>1) Give a short introduction about yourself</p>
                                <p>2) Show case any project or internship experience. Explain what it was and how it
                                    helped
                                    others.</p>
                                <p>3) You may elaborate on your skills.</p>
                                <p>4) Narrate any leadership or management scenario.</p>
                            </div>
                            <p class="text-danger">*The recoding will automatically stop after 60 seconds</p>
                            <div class="btn btn-success rounded-lg m-1 startButton"> Start</div>
                            <button class="btn btn-outline-warning" data-toggle="modal" data-target="#sample-video-modal">Sample Video</div>
                        </div>
                        <div class="preVideo d-none">
                            <video id="preview" width="600" height="500" autoplay muted></video>
                            <br />
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <progress value="120" max="60" class="countDownProgress"></progress><br/>
                                    <p> Video end in <span class="countDown"> </span> seconds</p>
                                </div>
                            </div>
                            <div class="btn-group">
                                <div class="btn btn-danger rounded-lg m-1 stopButton"> Stop</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 recorded text-center d-none">
                        <h2>Recorded Video Resume</h2>
                        <video id="recording" width="600" height="500" controls></video>
                        <br /><br />
                        <button id="saveVideo" class="btn btn-primary"
                            data-url="{{ route('candidate-video-resume-store') }}">save</button>
                        <a class="btn btn-danger record-again">Record again</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- list section end -->
    </section>
    <!-- category list ends -->
@endsection

@section('vendor-script')
    {{-- Vendor js files --}}
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{asset(mix('js/main/config.js'))}}"></script>
<script>
    const isRtl = $("html").attr("data-textdirection") === "rtl";
    const assetPath = $("body").attr("data-asset-path");
    var preview = document.getElementById('preview'),
        recording = document.getElementById("recording"),
        capturedVideo = $('.capturedVideo'),
        newVideo = $('.newVideo'),
        startButton = $('.startButton'),
        stopButton = $('.stopButton'),
        recordAgain = $('.record-again');
        videoPreview = $('.videoPreview'),
        textPreview = $('.textPreview');
        preVideo = $('.preVideo'),
        recorded = $('.recorded'),
        countDown = $('.countDown'),
        countDownProgress = $('.countDownProgress'),
        saveButton = $('#saveVideo');

    window.stop = function(stream) {
        stream.getTracks().forEach(track => track.stop());
    }

    let formData = new FormData();

    startButton.on('click', function(){
        textPreview.addClass('d-none');
        preVideo.removeClass('d-none');
        navigator.mediaDevices.getUserMedia({
            video: true,
            audio: true
        }).then(stream => {
            preview.srcObject = stream;
            let chunks = [];
            let stopped = false;

            const mediaRecorder = new MediaRecorder(stream, {mimeType: 'video/webm'});
            
            mediaRecorder.start();

            stopButton.on('click', function() {
                stopRecording();
            });

            progressCountdown(60);

            var videoTimer = setInterval(() => {
                stopRecording();
                clearInterval(videoTimer);
            }, 60000);

            function stopRecording()
            { 
                if(!stopped){
                    mediaRecorder.stop();
                    stop(preview.srcObject);
                    preVideo.addClass('d-none');
                    recorded.removeClass('d-none');
                    stopped = true;
                }
            }

            mediaRecorder.onstop = function(e) {
                recording.src = URL.createObjectURL(new Blob(chunks));
                let recordedBlob = new Blob(chunks, {
                    type: "video/webm"
                });
                formData.append('video', recordedBlob);
            }

            mediaRecorder.ondataavailable = function(e) {
                chunks.push(e.data);
            }            
        })
    })

    recordAgain.on('click', function(){
        capturedVideo.addClass('d-none');
        newVideo.removeClass('d-none');
        recorded.addClass('d-none');
        textPreview.removeClass('d-none');
    });

    saveButton.on('click', function(){
        disableSaveButton(true);
        $.ajax({
            url: this.getAttribute('data-url'),
            method: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function(res) {
                location.reload();
            },
            failure: function(err)
            {
                disableSaveButton(false);
            }
        });
    });

    $('.delete-video').on('click', function(){
        blockPage(true);
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete it!',
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-outline-danger ml-1'
            },
            buttonsStyling: false
            }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: `${assetPath}api/v1/candidate/video-resume-delete`,
                    type: 'DELETE',
                    success: function (res) {
                    // console.log(res.data);
                        toastr['warning']('👋 Successfully deleted Video Resume', 'Deleted!', {
                            closeButton: true,
                            tapToDismiss: false,
                            rtl: isRtl
                        });
                        blockPage(false);
                        window.location.reload();
                    },
                    error: function (err) {
                        console.log('An error occurred.',err);    
                        Swal.fire({                            
                            title: 'Error!',
                            icon: 'error',
                            text: err.statusText,
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                        blockPage(false);
                    },
                })
            }
        });
    })

    function progressCountdown(timeleft) {
        var countdownTimer = setInterval(() => {
            timeleft--;
            countDown.html(timeleft);
            countDownProgress.val(timeleft);
            if (timeleft <= 0) {
                clearInterval(countdownTimer);
            }
        }, 1000);
    }

    function disableSaveButton(status) {
        if (status) {
            saveButton.attr('disabled', 'disabled');
            saveButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="ml-25 align-middle">Loading</span>');
        } else {
            saveButton.removeAttr('disabled');
            saveButton.html('Save');
        }
    }

    function blockPage(status) {
        if (status) {
            $.blockUI({
                message:
                '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-0">Please wait...</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
                css: {
                backgroundColor: 'transparent',
                color: '#fff',
                border: '0'
                },
                overlayCSS: {
                opacity: 0.7
                }
            });
        } else {
            $('.blockUI').remove();
        }
    }
</script>
@endsection

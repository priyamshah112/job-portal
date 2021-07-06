@extends('layouts/contentLayoutMaster')

@section('title', 'Video Resume')

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
        <div class="card p-2">
            <div class="row justify-content-center">
                <div class="col-md-12" id="capturedVideo"
                    style="display: {{ $capturedVideo ? 'block' : 'none' }};text-align: center">
                    <div class="float-right">
                        <div id="editButton" class="btn btn-success rounded-lg m-1">Record again</div>
                    </div>
                    <video width="600" height="500" controls>
                        <source
                            src="{{ URL::asset($candidate->video_resume_path . '/' . $candidate->video_resume_name) }}"
                            type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <div id="afterRecorded" style="display: none;text-align: center">
                    <div class="text-center">
                        <p>Preparing video resume. please wait...</p>
                        <div class="col-md-12 text-center">
                            <progress value="0" max="60" id="pageBeginCountdownVideo"></progress><br/>
                            <p><span id="pageBeginCountdownTextVideo"> </span> seconds</p>
                        </div>
                    </div>
                </div>
                <div id="newVideo" style="display: {{ $capturedVideo ? 'none' : 'block' }};text-align: center">
                    <div class="col-md-12 text-center" id="videoPreview" style="text-align: center">
                        <h2 class="text-primary">Capture Video Resume</h2>
                        <div id="textPreview" style="display: block;" class="text-center mt-1">
                            <h4 class="text-dark">Tell us something about you, Remember your first Impression must be
                                impactful!</h4>
                            <br>
                            <h4 class="text-dark">Here are something hints that might help you!</h4>
                            <div class="text-left text-black">
                                <p>1) Give a short introduction about yourself</p>
                                <p>2) Show case any project or internship experience. Explain what it was and how it
                                    helped
                                    others.</p>
                                <p>3) You may elaborate on your skills.</p>
                                <p>4) Narrate any leadership or management scenario.</p>
                            </div>
                            <p class="text-danger">*The recoding will automatically stop after 60 seconds</p>
                        </div>
                        <div id="preVideo" style="display: none; text-align: center">
                            <video id="preview" width="600" height="500" autoplay muted></video>
                            <br />
                            <div class="row begin-countdown">
                                <div class="col-md-12 text-center">
                                    <progress value="120" max="60" id="pageBeginCountdown"></progress><br/>
                                    <p> Video end in <span id="pageBeginCountdownText"> </span> seconds</p>
                                </div>
                            </div>
                        </div>
                        <br /><br />
                        <div class="btn-group">
                            <div id="startButton" class="btn btn-success rounded-lg m-1"> Start</div>
                            <div id="stopButton" class="btn btn-danger rounded-lg m-1" style="display:none;"> Stop</div>
                        </div>
                    </div>
                    <div class="col-md-12 text-center" id="recorded" style="display:none">
                        <h2>Recorded Video Resume</h2>
                        <video id="recording" width="600" height="500" controls></video>
                        <br /><br />
                        <a id="downloadButton" class="btn btn-primary"
                            data-url="{{ route('candidate-video-resume-store') }}">save</a>
                        <a id="resetButton" class="btn btn-danger">Record again</a>
                        <a id="downloadLocalButton" class="btn btn-primary" hidden>Download</a>
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
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap4.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.bootstrap4.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
    <script>
        let preview = document.getElementById("preview");
        let videoPreview = document.getElementById("videoPreview");
        let recording = document.getElementById("recording");
        let startButton = document.getElementById("startButton");
        let stopButton = document.getElementById("stopButton");
        let downloadButton = document.getElementById("downloadButton");
        let logElement = document.getElementById("log");
        let recorded = document.getElementById("recorded");
        let downloadLocalButton = document.getElementById("downloadLocalButton");
        let resetButton = document.getElementById("resetButton");
        let preVideo = document.getElementById("preVideo");
        let textPreview = document.getElementById("textPreview");
        let editButton = document.getElementById("editButton");
        let afterRecorded = document.getElementById("afterRecorded");
        let newVideo = document.getElementById("newVideo");

        let recordingTimeMS = 60000; //video limit 60 sec
        var localstream;

        window.log = function(msg) {
            //logElement.innerHTML += msg + "\n";
            console.log(msg);
        }

        window.wait = function(delayInMS) {
            return new Promise(resolve => setTimeout(resolve, delayInMS));
        }

        window.startRecording = function(stream, lengthInMS) {
            ProgressCountdown(60, 'pageBeginCountdown', 'pageBeginCountdownText').then(value => {
            });

            let recorder = new MediaRecorder(stream);
            let data = [];

            recorder.ondataavailable = event => data.push(event.data);
            recorder.start();
            log(recorder.state + " for " + (lengthInMS / 1000) + " seconds...");

            let stopped = new Promise((resolve, reject) => {
                recorder.onstop = resolve;
                recorder.onerror = event => reject(event.name);
            });

            let recorded = wait(lengthInMS).then(
                () => {
                    recorder.state == "recording" && recorder.stop();
                }
            );

            return Promise.all([
                    stopped,
                    recorded
                ])
                .then(() => data);
        }

        window.stop = function(stream) {
            stream.getTracks().forEach(track => track.stop());
        }
        var formData = new FormData();
        if (startButton) {
            startButton.addEventListener("click", function() {
                preVideo.style.display = "block";
                textPreview.style.display = "none";
                startButton.innerHTML = "recording...";
                recorded.style.display = "none";
                stopButton.style.display = "inline-block";
                downloadButton.innerHTML = "rendering..";
                navigator.mediaDevices.getUserMedia({
                        video: true,
                        audio: true
                    }).then(stream => {
                        preview.srcObject = stream;
                        localstream = stream;
                        //downloadButton.href = stream;
                        preview.captureStream = preview.captureStream || preview.mozCaptureStream;
                        return new Promise(resolve => preview.onplaying = resolve);
                    }).then(() => startRecording(preview.captureStream(), recordingTimeMS))
                    .then(recordedChunks => {
                        let recordedBlob = new Blob(recordedChunks, {
                            type: "video/webm"
                        });
                        recording.src = URL.createObjectURL(recordedBlob);

                        formData.append('_token', document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content'));
                        formData.append('video', recordedBlob);

                        downloadLocalButton.href = recording.src;
                        downloadLocalButton.download = "RecordedVideo.webm";
                        log("Successfully recorded " + recordedBlob.size + " bytes of " +
                            recordedBlob.type + " media.");
                        startButton.innerHTML = "Start";
                        stopButton.style.display = "none";
                        recorded.style.display = "block";
                        downloadButton.innerHTML = "Save";
                        preVideo.style.display = "none";
                        videoPreview.style.display = "none";
                        afterRecorded.style.display = "none";
                        newVideo.style.display = "block";
                        stop(preview.srcObject);
                        localstream.getTracks()[0].stop();
                    })
                    .catch(log);
            }, false);
        }
        if (downloadButton) {
            downloadButton.addEventListener("click", function() {
                $.ajax({
                    url: this.getAttribute('data-url'),
                    method: 'POST',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        location.reload();
                        if (res.success) {
                            
                        }
                    }
                });
            }, false);
        }
        if (stopButton) {
            stopButton.addEventListener("click", function() {
                stop(preview.srcObject);
                startButton.innerHTML = "Start";
                stopButton.style.display = "none";
                recorded.style.display = "block";
                downloadButton.innerHTML = "Save";
                textPreview.style.display = "none";
                preVideo.style.display = "none";
                videoPreview.style.display = "none";
                recorded.style.display = "display";
                afterRecorded.style.display = "block";
                newVideo.style.display = "none";
                localstream.getTracks()[0].stop();
                $('#pageBeginCountdownVideo').attr('value', $('#pageBeginCountdown').val());
                ProgressCountdownForVideo($('#pageBeginCountdown').val(), 'pageBeginCountdownVideo', 'pageBeginCountdownTextVideo').then(value => {
            });

            }, false);
        }
        if (resetButton) {
            resetButton.addEventListener("click", function() {
                // stop(preview.srcObject);
                startButton.innerHTML = "Start";
                stopButton.style.display = "none";
                recorded.style.display = "block";
                downloadButton.innerHTML = "Save";
                textPreview.style.display = "block";
                preVideo.style.display = "none";
                videoPreview.style.display = "block";
                recorded.style.display = "none";
                localstream.getTracks().forEach(track => track.stop());
            }, false);
        }
        if (editButton) {
            editButton.addEventListener("click", function() {
                $('#preVideo').hide();
                $('#newVideo').show();
                $('#capturedVideo').hide();
            }, false);
        }

        function ProgressCountdown(timeleft, bar, text) {
            return new Promise((resolve, reject) => {
                var countdownTimer = setInterval(() => {
                    timeleft--;
                    document.getElementById(bar).value = timeleft;
                    document.getElementById(text).textContent = timeleft;
                    if (timeleft <= 0) {
                        clearInterval(countdownTimer);
                        resolve(true);
                    }
                }, 1000);
            });
        }
        function ProgressCountdownForVideo(timeleft, bar, text) {
            return new Promise((resolve, reject) => {
                var countdownTimer = setInterval(() => {
                    timeleft--;
                    document.getElementById(bar).value = timeleft;
                    document.getElementById(text).textContent = timeleft;
                    if (timeleft <= 0) {
                        clearInterval(countdownTimer);
                        resolve(true);
                    }
                }, 1000);
            });
        }

        $(document).ready(function() {
            $("#success").delay(5000).slideUp(300);
        });

    </script>
    {{-- <script src="{{ asset(mix('js/user-list.js')) }}"></script> --}}
@endsection

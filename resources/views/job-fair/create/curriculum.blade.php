<div id="curriculum" class="content">
    <div class="content-header">
        <h5 class="mb-0">Curriculum</h5>
        <small class="text-muted">Enter Your Chapters here.</small>
    </div>

    <div class="card shadow-none collapse-icon">
        <div class="collapse-border" id="lesson-containers">            
        </div>
        <div class="scrolling-inside-modal">
            <!-- Modal -->
            <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalScrollableTitle">Add A New Lesson</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="form form-vertical">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group ">
                                            <label class="form-label" for="lesson_name">Lesson Name</label>
                                            <input type="text" id="lesson_name" class="form-control" placeholder="Lesson Name" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="first-name-vertical">Select Course</label>
                                            <select class="select2 form-control form-control-lg">
                                                <option value="AK">--select a course--</option>
                                                <option value="AK">Pathology</option>
                                                <option value="HI">Biostatistics</option>
                                                <option value="HI">BioPhysics</option>
                                                <option value="CA">Cardiology</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="first-name-vertical">Select Chapter</label>
                                            <select class="select2 form-control form-control-lg">
                                                <option value="AK">--select a chapter--</option>
                                                <option value="AK">Chapter 1</option>
                                                <option value="AK">Chapter 2</option>
                                                <option value="HI">Chapter 3</option>
                                                <option value="HI">Chapter 4</option>
                                                <option value="CA">Chapter 5</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="first-name-vertical">Select type of lesson</label>
                                            <select class="select2 form-control form-control-lg">
                                                <option value="AK">Video</option>
                                                <option value="AK">Quiz</option>
                                                <option value="HI">Multi-media</option>
                                                <option value="HI">PDFs</option>
                                                <option value="CA">Audio</option>
                                                <option value="CA">Download</option>
                                                <option value="CA">Presentation</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="">Upload Lesson Material</label>
                                            <div class="dropzone dropzone-area" id="dpz-multiple-files">
                                                <div class="dz-message">Drop files here or click to upload.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">More Information (Optional)</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                                placeholder="Textarea"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="reset" class="btn btn-primary mr-1" id="addNewLesson" data-dismiss="modal">Submit</button>
                                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="field">
        <div id="field0">
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="form-label" for="vertical-username">Chapter Name</label>
                    <input type="text" id="chapter_name" class="form-control" placeholder="Chapter Name" />
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-12">
            <button type="button" class="btn btn-outline-secondary" id="add-more">Add More</button>
        </div>
    </div>
    <br><br>
    <div class="d-flex justify-content-between">
        <button class="btn btn-primary btn-prev">
            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
            <span class="align-middle d-sm-inline-block d-none">Previous</span>
        </button>
        <button class="btn btn-primary btn-next">
            <span class="align-middle d-sm-inline-block d-none">Next</span>
            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
        </button>
    </div>
</div>
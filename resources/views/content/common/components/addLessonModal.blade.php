<button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModalScrollable">
    <i data-feather="plus"></i>Add new Lesson
</button>
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
                            <button type="reset" class="btn btn-primary mr-1">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
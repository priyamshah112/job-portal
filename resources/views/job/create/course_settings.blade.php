<div id="course_settings" class="content">
    <div class="content-header">
        <h5 class="mb-0">Course Settings</h5>
        <small>Add Course Settings</small>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Category</label>
            <select class="select2 form-control form-control-lg">
                <option value="AK">Bio-Statistics</option>
                <option value="HI">Bio-physics</option>
                <option value="CA">Surgery</option>
                <option value="NV">Medical Thesis</option>
                <option value="OR">Biology</option>
                <option value="WA">Zoology</option>
                <option value="AZ">Chemistry</option>
                <option value="CO">Physics</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label class="form-label" for="vertical-address">Course Name</label>
            <input
                    type="text"
                    id="vertical-address"
                    class="form-control"
                    placeholder="Biophysics and Statistics"
            />
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="exampleFormControlTextarea1">Course Description</label>
            <textarea
                    class="form-control"
                    id="exampleFormControlTextarea1"
                    rows="3"
                    placeholder="What is the Course All about"
            ></textarea>
        </div>
        <div class="form-group col-md-6">
            <label class="form-label" for="vertical-landmark">Course Image</label>
            <input type="file" id="vertical-landmark" class="form-control"
                   placeholder="Image"/>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Instructor</label>
            <select class="select2 form-control form-control-lg">
                <option value="AK">John Wick</option>
                <option value="HI">Al Pacino</option>
                <option value="CA">Robert De Niro</option>
                <option value="NV">John Constantine</option>
                <option value="OR">George Clooney</option>
                <option value="WA">Audrey Hepburn</option>
                <option value="AZ">Samantha Williams</option>
                <option value="CO">Leonardo Di Caprio</option>
            </select>
        </div>
    </div>
    
    <div class="content-header">
        <h5 class="mb-0">Pricing</h5>
        <small>Enter Pricing Information.</small>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <div class="custom-control custom-radio">
                <input type="radio" id="customRadio2" name="customRadio" value="paid" class="custom-control-input"/>
                <label class="custom-control-label" for="customRadio2">Paid</label>
            </div>
        </div>
        <div class="form-group col-md-6">
            <div class="custom-control custom-radio">
                <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input" value="free"/>
                <label class="custom-control-label" for="customRadio1">Free</label>
            </div>
        </div>
    </div>
    <div class="row" id="price_box" style="display: none;">
        <div class="form-group col-md-6">
            <label class="form-label" for="vertical-address">Original Price</label>
            <input
                    type="number"
                    id="vertical-address"
                    class="form-control"
                    placeholder="786 KD"
            />
        </div>
        <div class="form-group col-md-6">
            <label class="form-label" for="vertical-address">Offer Price</label>
            <input
                    type="number"
                    id="vertical-address"
                    class="form-control"
                    placeholder="520 KD"
            />
        </div>
    </div>
    <div class="row" id="date_range_box" style="display: none;">
        <div class="form-group col-md-3">
            <label for="pd-default">From Date</label>
            <input type="text" id="pd-default" class="form-control pickadate" placeholder="18 June, 2021"/>
        </div>
        <div class="form-group col-md-3">
            <label for="pd-default">To Date</label>
            <input type="text" id="pd-default" class="form-control pickadate" placeholder="18 June, 2021"/>
        </div>
    </div>
    <div class="d-flex justify-content-between">
        <button class="btn btn-outline-secondary btn-prev" disabled>
            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
            <span class="align-middle d-sm-inline-block d-none">Previous</span>
        </button>
        <button class="btn btn-primary btn-next">
            <span class="align-middle d-sm-inline-block d-none">Next</span>
            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
        </button>
    </div>
</div>

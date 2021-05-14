<div id="pricing-details" class="content">
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
        <button class="btn btn-primary btn-prev">
            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
            <span class="align-middle d-sm-inline-block d-none">Previous</span>
        </button>
        <button class="btn btn-success btn-submit">Save</button>
    </div>
</div>


let token = $('meta[name="csrf-token"]').attr('content');
let submitBtn = $('#data-submit');
const isRtl = $("html").attr("data-textdirection") === "rtl";
const assetPath = $("body").attr("data-asset-path");

let jobFairCreateForm = $('#job-fair-create-form');

//custom validators
jQuery.validator.addMethod("validate_email", function(value, element) {
    if (value.length > 1) {
        if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
            return true;
        } else {
            return false;
        }
    } else {
        return true;
    }

}, "Please enter a valid email address.");


$.ajax({
    url: `${assetPath}api/v1/departments`,
    type: "GET",
    dataType: 'json',
    success: function(res) {
        res.data.forEach(item => {
            $("#department_id").append('<option value="' + item.id + '">' + item.name + '</option>');
        });
        let department_id = $("#department_id").attr('previous-selected');
        $("#department_id").find('option[value=' + department_id + ']').prop('selected',true);
    },
    failure: function(err){
        console.log(err);
    }
});

let validator = jobFairCreateForm.validate({
    rules: {
        name: {required: true},
        description: {required: true},
        img_name: {required: true},
        organizer_name: {required: true},
        address: {required: true},
        mobile_number: {required: true},
        email: {required: true},
        company_mobile_1: {required: true},
        email: {required: true,validate_email: true},
        type: {required: true},
        price: {required: true},
        number_of_days: {required: true},
        start_date: {required: true},
        end_date: {required: true},
        start_time: {required: true},
        end_time: {required: true},
        department_id: {required: true},
    }
});

jobFairCreateForm.on('submit', function (e) {
    let formData = new FormData(this);
    e.preventDefault();
    let isValid = jobFairCreateForm.valid();
    if (isValid) {   
        disableSubmitButton(true);
        $.ajax({
            method: "POST",
            url: `${assetPath}api/v1/admin/job-fair/create`,
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
        })
        .done(function (response) {
            toastr['success']('👋 Created Successfully.', 'Success!', {
                closeButton: true,
                tapToDismiss: false,
                rtl: isRtl
            });
            disableSubmitButton(false)
            window.location.replace('/job-fair')
        })
        .fail(function (error) {
            if (error.status === 422) {
                let errors = error.responseJSON.message;
                let showErrors = {}
                Object.keys(errors).forEach((key) => {
                    showErrors = {
                        ...showErrors,
                        [key]: errors[key]
                    }
                });
                validator.showErrors(showErrors);
            } else {
                toastr["error"]("", "Something wrong, Please try again!", {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: isRtl,
                });
            }
            disableSubmitButton(false)
        });
    }
});

function disableSubmitButton(status) {
    if (status) {
        submitBtn.attr('disabled', 'disabled');
        submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="ml-25 align-middle">Loading</span>');
    } else {
        submitBtn.removeAttr('disabled');
        submitBtn.html('Submit');
    }
}
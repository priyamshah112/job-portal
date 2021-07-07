'use strict';
const isRtl = $("html").attr("data-textdirection") === "rtl";
const assetPath = $("body").attr("data-asset-path");
let feedbackForm = $('#feedback-form');
let mode = $('#pcs').attr('data-mode');
let submitBtn = $('#data-submit');
let validator = feedbackForm.validate({
    rules: {
        subject: {required: true},
        feedback: {required: true},
    }
});
feedbackForm.on('submit', function (e) {
    e.preventDefault();
    let isValid = feedbackForm.valid();
    if (isValid) {
        let formdata = new FormData(this);

        let url = '';
        if (mode == 'candidate') {
            url = "".concat(assetPath, "api/v1/candidate/feedback");
        } else {
            url = "".concat(assetPath, "api/v1/recruiter/feedback");
        }
        disableSubmitButton(true);
        $.ajax({
            method: "POST",
            url: url,
            data: formdata,
            contentType: false,
            processData: false,
            cache: false,
        })
        .done(function (response) {
            feedbackForm.trigger('reset');
            toastr['info']('👋 Submited Successfully.', 'Success!', {
                closeButton: true,
                tapToDismiss: false,
                rtl: isRtl
            });
            disableSubmitButton(false)
        })
        .fail(function (err) {
            if (err.status === 422) {
                let errors = err.responseJSON.message;
                console.log(errors, err)
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
        })
    }
});
submitBtn.on('click', function (e) {
    // feedbackForm.submit();
    console.log('pclick');
});
console.log('looo');

function disableSubmitButton(status) {
    if (status) {
        submitBtn.attr('disabled', 'disabled');
        submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="ml-25 align-middle">Loading</span>');
    } else {
        submitBtn.removeAttr('disabled');
        submitBtn.html('Submit');
    }
}

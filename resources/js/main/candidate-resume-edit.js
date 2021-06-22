'use strict';
let token = $('meta[name="csrf-token"]').attr('content');
let submitBtn = $('#data-submit');
const isRtl = $("html").attr("data-textdirection") === "rtl";
const assetPath = $("body").attr("data-asset-path");

let candidateResumeEditForm = $('#candidate-resume-edit-form');
let validator = candidateResumeEditForm.validate({
    rules: {
        first_name: {required: true},
        last_name: {required: true},
        dateOfBirth: {required: true},
        permanent_address: {required: true},
        current_location_state: {required: true},
        current_location_city: {required: true},
        company_mobile_1: {required: true},
        email: {required: true},
        category: {required: true},
        industry_type: {required: true},
        skills: {required: true},
        education: {required: true},
        about: {required: true},
        job_location_state: {required: true},
        job_location_city: {required: true},
    }
});
candidateResumeEditForm.on('submit', function (e) {
    let formData = new FormData(this);
    e.preventDefault();
    let isValid = candidateResumeEditForm.valid();
    if (isValid) {
        Swal.fire({
            title: 'Are you sure?',
            text: '',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No.'
        }).then((result) => {
            if (result.value) {

                const url = "".concat(assetPath, "api/v1/candidate/candidate-resume-update");
                disableSubmitButton(true);
                $.ajax({
                    method: "POST",
                    url: url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                })
                    .done(function (response) {
                        let data = JSON.parse(response);
                        $('#account-upload-img').attr('src', data.imagePath);
                        $('#navProfileImage').attr('src', data.imagePath);
                        toastr['info']('👋 Updated Successfully.', 'Updated!', {
                            closeButton: true,
                            tapToDismiss: false,
                            rtl: isRtl
                        });
                        disableSubmitButton(false)
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
            } else {
                result.dismiss;
            }
        });
    }
});

function disableSubmitButton(status) {
    if (status) {
        submitBtn.attr('disabled', 'disabled');
        submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="ml-25 align-middle">Loading</span>');
    } else {
        submitBtn.removeAttr('disabled');
        submitBtn.html('Update Resume Information');
    }
}

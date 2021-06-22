$(function () {
    'use strict';

    // variables
    var userDetailsForm = $('.update-user-details'),
        changePasswordForm = $('.change-password'),
        flat_picker = $('.flatpickr'),
        accountUploadImg = $('#account-upload-img'),
        accountUploadBtn = $('#account-upload');

    var isRtl = $('html').attr('data-textdirection') === 'rtl';
    var submitBtn = $('.data-submit');
    var token = $('meta[name="csrf-token"]').attr('content');
    var assetPath = $('body').attr('data-asset-path');

    // Update user photo on click of button
    if (accountUploadBtn) {
        accountUploadBtn.on('change', function (e) {
            var reader = new FileReader(),
                files = e.target.files;
            reader.onload = function () {
                if (accountUploadImg) {
                    accountUploadImg.attr('src', reader.result);
                }
            };
            reader.readAsDataURL(files[0]);
        });
    }

    // flatpickr init
    if (flat_picker.length) {
        flat_picker.flatpickr({
            onReady: function (selectedDates, dateStr, instance) {
                if (instance.isMobile) {
                    $(instance.mobileInput).attr('step', null);
                }
            }
        });
    }

    // jQuery Validation
    // --------------------------------------------------------------------
    if (userDetailsForm.length) {

        let validator = userDetailsForm.validate({
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                }
            }
        });
        userDetailsForm.on('submit', function (e) {
            e.preventDefault();
            var isValid = userDetailsForm.valid();
            const url = "".concat(assetPath, "api/v1/candidate/changeCandidateInfo");
            if (isValid) {
                disableSubmitButton(true);
                $.ajax({
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    url: url,
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                }).done((response) => {
                    response = JSON.parse(response);
                    if (response.status != 1) {
                        toastr["info"]("👋 " + response.msg, "Info!", {
                            closeButton: true,
                            tapToDismiss: false,
                            rtl: isRtl,
                        });
                        disableSubmitButton(false);
                        return;
                    }
                    toastr["success"]("👋 " + response.msg, "Updated!", {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: isRtl,
                    });
                    $('#account-upload-img').attr('src', response.imagePath);
                    $('#navProfileImage').attr('src', response.imagePath);
                    disableSubmitButton(false);
                }).fail((error) => {
                    toastr["error"]("👋 " + error.msg, "Error!", {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: isRtl,
                    });
                    validator.showErrors(showErrors);
                });
            }
        });
    }

    if (changePasswordForm.length) {
        let validator = changePasswordForm.validate({
            rules: {
                old_password: {
                    required: true
                },
                new_password: {
                    required: true,
                    minlength: 6
                },
                confirm_password: {
                    required: true,
                    minlength: 6,
                    equalTo: '#account-new-password'
                }
            }
        });
        changePasswordForm.on('submit', function (e) {
            e.preventDefault();
            var isValid = changePasswordForm.valid();
            const url = "".concat(assetPath, "api/v1/candidate/changeCandidatePassword");
            if (isValid) {
                disableSubmitButton(true);
                $.ajax({
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    url: url,
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                }).done((response) => {
                    response = JSON.parse(response);
                    if (response.status != 1) {
                        toastr["info"]("" + response.msg, "Error!", {
                            closeButton: true,
                            tapToDismiss: false,
                            rtl: isRtl,
                        });
                        disableSubmitButton(false);
                        return;
                    }
                    toastr["success"]("👋 " + response.msg, "Updated!", {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: isRtl,
                    });
                    changePasswordForm.trigger('reset');
                    disableSubmitButton(false);
                }).fail((error) => {
                    toastr["info"]("👋 " + error.msg, "Error!", {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: isRtl,
                    });
                    validator.showErrors(showErrors);
                });
            }
        });
    }

    function disableSubmitButton(status) {
        if (status) {
            submitBtn.attr('disabled', 'disabled');
            submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="ml-25 align-middle">Loading</span>');
        } else {
            submitBtn.removeAttr('disabled');
            submitBtn.html('Save Changes');
        }
    }
});

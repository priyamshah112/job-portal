Dropzone.autoDiscover = false;
var isRtl = $('html').attr('data-textdirection') === 'rtl',
assetPath = $("body").attr("data-asset-path")
department = $("#department_id").select2();

$.ajax({
    url: `${assetPath}api/v1/departments`,
    type: "GET",
    dataType: 'json',
    success: function(res) {
        res.data.forEach(item => {
            $("#department_id").append('<option value="' + item.id + '">' + item.name + '</option>');
        });
        let department_id = $("#department_id").attr('previous-selected');
        if(department_id !== "")
        {
            department.select2('val', [department_id]);
        }
    },
    failure: function(err){
        console.log(err);
    }
});

function preview(path, ex) {
    $("#previewHolder").html('');
    if (ex == 'pdf') {
        $("#previewHolder").html('<embed src="/'+path+'" style="height: 100%;width: 100%;min-height: 500px;" />');
    } else {
        $("#previewHolder").html('<img src="/'+path+'" style="height: 100%; width: 100%;">');
    }
    $("#previewmodal").modal('show');
}

function removeFile(id, dom) {
    Swal.fire({
        title: 'Do you want Delete?',
        showCancelButton: true,
        confirmButtonText: `Yeah`,
    }).then((result) => {
        if (!result.isConfirmed) {
            return
        }
        let url = '/api/v1/recruiter/attachments/delete';
        $.ajax({
            method: "POST",
            url: url,
            data: {id},
        }).done((response) => {
            if (typeof response == 'string') {
                response = JSON.parse(response);
            }
            toastr["success"]("👋 " + response.message, "Removed!", {
                closeButton: true,
                tapToDismiss: false,
                rtl: isRtl,
            });
            $(dom).closest('.previtem').remove();
            if ($('#myatt').html().toString().trim() == '') {
                $('#myatt').html('<div id="myatt" class="myattachments">No Attachments Found</div>');
            }
        }).fail((error) => {
            console.log(error)
            if (error.responseJSON && error.responseJSON.errors && typeof error.responseJSON.errors == 'object') {
                let msg = error.responseJSON.errors.id.join(', ');
                toastr["error"]("👋 " + msg, "Error!", {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: isRtl,
                });
                return;
            }
            console.log('sd')
            toastr["error"]('👋 Something wrong Please try again', "Error!", {
                closeButton: true,
                tapToDismiss: false,
                rtl: isRtl,
            });
        });
    });
}

$(function () {
    'use strict';
    var token = $('meta[name="csrf-token"]').attr('content');
    const fileupload = $('#dpz-multiple-files1');
    let drop = fileupload.dropzone({
        paramName: 'file', // The name that will be used to transfer the file
        maxFilesize: 20, // MB
        addRemoveLinks: true,
        dictRemoveFile: ' Remove',
        url: '/api/v1/recruiter/attachments/upload',
        headers: {'X-CSRF-TOKEN': token },
        acceptedFiles: 'image/*,application/pdf',
        init: function () {
            this.on("success", function (file, response) {
                let includes = $('#myatt').html().toString().includes('No Attachments Found');
                if (includes) {
                    $('#myatt').html('');
                }
                let json = JSON.parse(response);
                if (json.status==1 && json.data) {
                    let a = '<div class="media mb-1 previtem">';
                    if (json.data.extension == 'pdf') {
                        a += '<img src="/images/icons/pdf.png"  class="mr-1" alt="pdf" height="50" width="40">';
                    } else {
                        a += '<img src="/images/icons/img.png"  class="mr-1" alt="pdf" height="50" width="40">';
                    }
                    a += '<div class="media-body">';
                    a += '<h5 class="mb-1 font-weight-bold text-break">'+json.data.file_name+'</h5>';
                    a += '<p><button onclick="removeFile('+json.data.id+', this)" class="btn btn-danger btn-sm mr-1"><i data-feather="trash-2"></i> Remove</button>' +
                        '<button onclick="preview(\''+json.data.file_path+'\', \''+json.data.extension+'\')" class="btn btn-primary btn-sm mr-1"><i data-feather="eye"></i> View</button></p>' +
                        '</div></div>';
                    $('#myatt').append(a);
                    feather.replace();
                    toastr["success"]("👋 Uploaded Successfully", "Success!", {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: isRtl,
                    });
                }
            });

            this.on("error", function (file, error, xhr) {
                let msg = '';
                if (error.errors && typeof error.errors.file == 'object') {
                    msg = error.errors.file.join(', ');
                    toastr["error"]("👋 " + msg, "Error!", {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: isRtl,
                    });
                    return;
                }
                toastr["error"]("👋 " + error.message ? error.message : 'Something wrong Please try again', "Error!", {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: isRtl,
                });
            });

            this.on("complete", (file) => {
                this.removeFile(file);
            });
        }
    });

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
                first_name: { required: true },
                last_name: { required: true },
                email: { required: true, email: true },
                company_name: { required: true },
                state: { required: true },
                city: { required: true },
                company_mobile_1: { required: true },
                department_id: { required: true },
                no_of_employees: { required: true },
                annual_turnover: { required: true },
                industry_segment: { required: true },
            }
        });
        userDetailsForm.on('submit', function (e) {
            e.preventDefault();
            var isValid = userDetailsForm.valid();
            const url = "".concat(assetPath, "api/v1/recruiter/changeRecruiterInfo");
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
                    toastr["error"]("👋 " + response.msg, "Error!", {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: isRtl,
                    });
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
            const url = "".concat(assetPath, "api/v1/recruiter/changeRecruiterPassword");
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
                    toastr["info"]("👋 " + response.msg, "Error!", {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: isRtl,
                    });
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

'use strict';
Dropzone.autoDiscover = false;
let token = $('meta[name="csrf-token"]').attr('content');
let rid = $('#psc').attr('data-id');

function preview(path, ex) {
    $("#previewHolder").html('');
    if (ex == 'pdf') {
        $("#previewHolder").html('<embed src="/' + path + '" style="height: 100%;width: 100%;min-height: 500px;" />');
    } else {
        $("#previewHolder").html('<img src="/' + path + '" style="height: 100%; width: 100%;">');
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
        let url = '/api/v1/admin/recruiters/attachments/delete';
        $.ajax({
            method: "POST",
            url: url,
            data: {id, recruiter_id: rid},
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

const fileupload = $('#dpz-multiple-files1');
let drop = fileupload.dropzone({
    paramName: 'file', // The name that will be used to transfer the file
    maxFilesize: 20, // MB
    addRemoveLinks: true,
    dictRemoveFile: ' Remove',
    url: '/api/v1/admin/recruiters/attachments/upload',
    headers: {'X-CSRF-TOKEN': token},
    params: {recruiter_id: rid},
    acceptedFiles: 'image/*,application/pdf',
    init: function () {
        this.on("success", function (file, response) {
            let includes = $('#myatt').html().toString().includes('No Attachments Found');
            if (includes) {
                $('#myatt').html('');
            }
            let json = JSON.parse(response);
            if (json.status == 1 && json.data) {
                let a = '<div class="media mb-1 previtem">';
                if (json.data.extension == 'pdf') {
                    a += '<img src="/images/icons/pdf.png"  class="mr-1" alt="pdf" height="50" width="40">';
                } else {
                    a += '<img src="/images/icons/img.png"  class="mr-1" alt="pdf" height="50" width="40">';
                }
                a += '<div class="media-body">';
                a += '<h5 class="mb-1 font-weight-bold text-break">' + json.data.file_name + '</h5>';
                a += '<p><button onclick="removeFile(' + json.data.id + ', this)" class="btn btn-danger btn-sm mr-1"><i data-feather="trash-2"></i> Remove</button>' +
                    '<button onclick="preview(\'' + json.data.file_path + '\', \'' + json.data.extension + '\')" class="btn btn-primary btn-sm mr-1"><i data-feather="eye"></i> View</button></p>' +
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

let submitBtn = $('#data-submit');
const isRtl = $("html").attr("data-textdirection") === "rtl";
const assetPath = $("body").attr("data-asset-path");
let adminRecruiterEditForm1 = $('#admin-recruiter-edit-form-1');
let adminRecruiterEditForm2 = $('#admin-recruiter-edit-form-2');
let validator1 = adminRecruiterEditForm1.validate({
    rules: {
        first_name: {required: true},
        last_name: {required: true},
        email: {required: true},
        mobile_number: {required: true},
        status: {required: true},
    }
});
let validator2 = adminRecruiterEditForm2.validate({
    rules: {
        company_name: {required: true},
        company_address: {required: true},
        company_mobile_1: {required: true},
        state: {required: true},
        city: {required: true},
        department_id: {required: true},
        no_of_employees: {required: true},
        annual_turnover: {required: true},
    }
});
adminRecruiterEditForm1.on('submit', function (e) {
    var config = {};
    e.preventDefault();
    adminRecruiterEditForm1.serializeArray().map(function (item) {
        if (config[item.name]) {
            if (typeof (config[item.name]) === "string") {
                config[item.name] = [config[item.name]];
            }
            config[item.name].push(item.value);
        } else {
            config[item.name] = item.value;
        }
    });
    let isValid = adminRecruiterEditForm1.valid();
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
                const url = "".concat(assetPath, "api/v1/admin/update-recruiters-account");
                disableSubmitButton(true);
                $.ajax({
                    method: "POST",
                    url: url,
                    data: config,
                })
                    .done(function (response) {
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
                            validator1.showErrors(showErrors);
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
adminRecruiterEditForm2.on('submit', function (e) {
    var config = {};
    e.preventDefault();

    adminRecruiterEditForm2.serializeArray().map(function (item) {
        if (config[item.name]) {
            if (typeof (config[item.name]) === "string") {
                config[item.name] = [config[item.name]];
            }
            config[item.name].push(item.value);
        } else {
            config[item.name] = item.value;
        }
    });
    let isValid = adminRecruiterEditForm2.valid();
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
                const url = "".concat(assetPath, "api/v1/admin/update-recruiters-company");
                disableSubmitButton(true);
                $.ajax({
                    method: "POST",
                    url: url,
                    data: config,
                })
                    .done(function (response) {
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
                            validator1.showErrors(showErrors);
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
        submitBtn.html('Update');
    }
}

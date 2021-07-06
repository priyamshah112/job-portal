const isRtl = $("html").attr("data-textdirection") === "rtl";
var table = null;
var selectedJobFairToEdit = null,
    updateBtn = $('.btn-update');
const assetPath = $("body").attr("data-asset-path");
const jobFairEditModal = $('#job-fair-edit-modal');
let jobFairUpdateForm = $('#job-fair-update-form');

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

$('.job-fair-edit').on('click', function(){ 
    clearForm()   

    let id = $(this).attr('job_fair_id');
    selectedJobFairToEdit = id;

    jobFairEditModal.modal('show');

    $.ajax({
        url: `${assetPath}api/v1/admin/job-fair/show/${id}`,
        type: 'GET',
        success: function (res) {
            console.log(res.data);
            let data = res.data;
            Object.keys(data).forEach((key) => {
                if(key !== 'img_name')
                {
                    if(key === 'department_id')
                    {
                        $(`[name="${key}"]`).select2('val', [data[key]]); 
                    }
                    else
                    {
                        $(`[name="${key}"]`).val(data[key]);
                    }
                }
            });
        },
        error: function (err) {
            console.log('An error occurred.',err);
            jobFairEditModal.modal('hide');
            Swal.fire({                            
            title: 'Error!',
            icon: 'error',
            text: err.statusText,
            customClass: {
                confirmButton: 'btn btn-success'
            }
            });
        },
    })
});

let validator = jobFairUpdateForm.validate({
    rules: {
        name: {required: true},
        description: {required: true},
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

jobFairUpdateForm.on('submit', function (e) {
    let formData = new FormData(this);
    e.preventDefault();
    let isValid = jobFairUpdateForm.valid();
    if (isValid && selectedJobFairToEdit !== null) {   
        disableSubmitButton(true);
        $.ajax({
            method: "POST",
            url: `${assetPath}api/v1/admin/job-fair/update/${selectedJobFairToEdit}?_method=PUT`,
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
        })
        .done(function (response) {
            toastr['info']('👋 Updated Successfully.', 'Updated!', {
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

$('.job-fair-delete').on('click', function(){
    let id = $(this).attr('job_fair_id');
    Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it!',
    customClass: {
        confirmButton: 'btn btn-primary',
        cancelButton: 'btn btn-outline-danger ml-1'
    },
    buttonsStyling: false
    }).then(function (result) {
    if (result.value) {
        $.ajax({
        url: `${assetPath}api/v1/admin/job-fair/delete/${id}`,
        type: 'DELETE',
        success: function (res) {
            toastr['warning']('👋 Job Fair Deleted Successfully', 'Deleted!', {
            closeButton: true,
            tapToDismiss: false,
            rtl: isRtl
            });
            window.location.reload();
        },
        error: function (err) {
            console.log('An error occurred.',err);
            Swal.fire({                            
                title: 'Error!',
                icon: 'error',
                text: err.statusText,
                customClass: {
                confirmButton: 'btn btn-success'
                }
            });
        },
        })
    }
    });               
});

$('.modal-close-button').on('click', function(){
    clearForm();
});

function clearForm(){       
    $('#job-fair-update-form').trigger('reset');
    jobFairEditModal.modal('hide');
    selectedJobFairToEdit = null;
} 

function disableSubmitButton(status) {
    if (status) {
        updateBtn.attr('disabled', 'disabled');
        updateBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="ml-25 align-middle">Loading</span>');
    } else {
        updateBtn.removeAttr('disabled');
        updateBtn.html('Update');
    }
}

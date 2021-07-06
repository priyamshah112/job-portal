'use strict';
let token = $('meta[name="csrf-token"]').attr('content');
let submitBtn = $('#data-submit');
const isRtl = $("html").attr("data-textdirection") === "rtl";
const assetPath = $("body").attr("data-asset-path");

let candidateResumeEditForm = $('#candidate-resume-edit-form');

var multipleCancelButton = new Choices('#skills', {
    removeItemButton: true,
    searchResultLimit: 10,
    renderChoiceLimit: 10
});

$('input[name="category"]').on('change', function() {
    let category = $(this).val();
    if (category === "experienced") {
        $("#companyCategory").show();
        $("#department_id").show();
    } else {
        $("#companyCategory").hide();
    }
})

$.ajax({
    url: `${assetPath}api/v1/qualifications`,
    type: "GET",
    dataType: 'json',
    success: function(res) {
        res.data.forEach(item => {
            $("#qualification_id").append('<option value="' + item.id + '">' + item.name + '</option>');
        });
        let qualification_id = $("#qualification_id").attr('previous-selected');
        $("#qualification_id").find('option[value=' + qualification_id + ']').prop('selected',true);
    },
    failure: function(err){
        console.log(err);
    }
});

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

$.ajax({
    url: `${assetPath}api/v1/states/101`,
    type: "GET",
    dataType: 'json',
    success: function (res) {
        res.data.forEach(item => {
            $("#current_location_state").append('<option value="' + item
                .id + '">' + item.name + '</option>');
            $("#job_location_state").append('<option value="' + item
                .id + '">' + item.name + '</option>');
        });   

        let current_location_state = $("#current_location_state").attr('previous-selected');
        $("#current_location_state").find('option[value=' + current_location_state + ']').prop('selected',true);

        let job_location_state = $("#job_location_state").attr('previous-selected');
        $("#job_location_state").find('option[value=' + job_location_state + ']').prop('selected',true);
        
        $.ajax({
            url: `${assetPath}api/v1/cities/${current_location_state}`,
            type: "GET",
            dataType: 'json',
            success: function (res) {
                $('#current_location_city').html('<option value="">Select City</option>');
                res.data.forEach(item => {
                    $("#current_location_city").append('<option value="' + item
                        .id + '">' + item.name + '</option>');
                });

                let current_location_city = $("#current_location_city").attr('previous-selected');
                $("#current_location_city").find('option[value=' + current_location_city + ']').prop('selected',true);
            }
        });

        $.ajax({
            url: `${assetPath}api/v1/cities/${job_location_state}`,
            type: "GET",
            dataType: 'json',
            success: function (res) {
                $('#job_location_city').html('<option value="">Select City</option>');
                res.data.forEach(item => {
                    $("#job_location_city").append('<option value="' + item
                        .id + '">' + item.name + '</option>');
                });
                
                let job_location_city = $("#job_location_city").attr('previous-selected');
                $("#job_location_city").find('option[value=' + job_location_city + ']').prop('selected',true);                
            }
        });
    }
});

$('#current_location_state').on('change', function () {
    var id = this.value;
    $("#current_location_city").html('');
    $.ajax({
        url: `${assetPath}api/v1/cities/${id}`,
        type: "GET",
        dataType: 'json',
        success: function (res) {
            $('#current_location_city').html('<option value="">Select City</option>');
            res.data.forEach(item => {
                $("#current_location_city").append('<option value="' + item
                    .id + '">' + item.name + '</option>');
            });

        }
    });
});

$('#job_location_state').on('change', function () {
    var id = this.value;
    $("#job_location_city").html('');
    $.ajax({
        url: `${assetPath}api/v1/cities/${id}`,
        type: "GET",
        dataType: 'json',
        success: function (res) {
            $('#job_location_city').html('<option value="">Select City</option>');
            res.data.forEach(item => {
                $("#job_location_city").append('<option value="' + item
                    .id + '">' + item.name + '</option>');
            });

        }
    });
});

let validator = candidateResumeEditForm.validate({
    rules: {
        first_name: {required: true},
        last_name: {required: true},
        dateOfBirth: {required: true},
        gender: {required: true},
        permanent_address: {required: true},
        current_location_state: {required: true},
        current_location_city: {required: true},
        company_mobile_1: {required: true},
        email: {required: true},
        category: {required: true},
        department_id: {required: true},
        skills: {required: true},
        qualification_id: {required: true},
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

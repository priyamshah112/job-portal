'use strict';
const isRtl = $("html").attr("data-textdirection") === "rtl";
const assetPath = $("body").attr("data-asset-path");
let jobform = $('#job-form');
let draft = $('#saveForLater');
let save = $('#save');
let type = 0;
let mode = $('#pcs').attr('mode')

//initial
$('#qualification_id').select2();
$('#skills').select2();

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
            $("#state").append('<option value="' + item
                .id + '">' + item.name + '</option>');
        });  
    }
});

$('#state').on('change', function () {
    var id = this.value;
    $("#city").html('');
    $.ajax({
        url: `${assetPath}api/v1/cities/${id}`,
        type: "GET",
        dataType: 'json',
        success: function (res) {
            $('#city').html('<option value="">Select City</option>');
            res.data.forEach(item => {
                $("#city").append('<option value="' + item
                    .id + '">' + item.name + '</option>');
            });

        }
    });
});

let validator = jobform.validate({
    rules: {
        position: { required: true},
        noOfPosts: { required: true },
        state: { required: { depends: function () { return !type;}} },
        city: { required: { depends: function () { return !type;}} },
        minAge: { required: { depends: function () { return !type;}}},
        maxAge: { required: { depends: function () { return !type;}}, min: function() {
                return parseInt($('#min_age').val());
            }},
        gender: {required: true},
        minSalary: { required: { depends: function () { return !type;}}},
        maxSalary: { required: { depends: function () { return !type;}}, min: function() {
            return parseInt($('#minsal').val());
        }},
        experience: { required: { depends: function () { return !type;}}},
        maxexperience: { required: { depends: function () { return !type;}}, min: function() {
            return parseInt($('#minexp').val());
        }},
        deadline: { required: { depends: function () { return !type;}} },
        qualification_id: { required: { depends: function () { return !type;}} },
        skills: { required: { depends: function () { return !type;}} },
        description: { required: { depends: function () { return !type;}} },
    },
    messages: {
        minAge: {
            max: 'Age is greater than Max Age'
        },
        maxAge: {
            min: 'Age is lesser than Min Age'
        },
        minSalary: {
            max: 'Salary is greater than Max Salary'
        },
        maxSalary: {
            min: 'Salary is lesser than Min Salary'
        },
        experience: {
            max: 'Experience is greater than Max Experience'
        },
        maxexperience: {
            min: 'Experience is lesser than Min Experience'
        }
    }
});

draft.on('click', function (e) {
    type = 1;
    execreate();
});
save.on('click', function (e) {
    type = 0;
    execreate();
});

function execreate() {
    var params = {};
    jobform.serializeArray().map(function(item) {
        if ( params[item.name] ) {
            if ( typeof(params[item.name]) === "string" ) {
                params[item.name] = [params[item.name]];
            }
            params[item.name].push(item.value);
        } else {
            params[item.name] = item.value;
        }
    });
    params['draft'] = type;
    let isvalid = jobform.valid()
    if(isvalid){
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
                if (!params.qualification_id) {
                    params['qualification_id'] = [];
                }
                if (!params.skills) {
                    params['skills'] = [];
                }
                if (params.qualification_id && typeof params.qualification_id === 'string') {
                    params['qualification_id'] = [params.qualification_id];
                }
                if (params.skills && typeof params.skills === 'string') {
                    params['skills'] = [params.skills];
                }
                if (type === 0) {
                    disableSubmitButton(true);
                } else {
                    disableSubmitButtonDraft(true);
                }
                let url = "".concat(assetPath, "api/v1/recruiter/jobs/create-job");
                if (mode == 'edit') {
                    url = "".concat(assetPath, "api/v1/recruiter/jobs/update");
                }
                $.ajax({
                    method: "POST",
                    url: url,
                    data: params,
                })
                    .done(function(response) {
                        let msg = 'Created Successfully.';
                        if (mode == 'edit') {
                            msg = 'Updated Successfully.';
                        }
                        toastr['info']('👋 ' + msg +' Redirecting to Job Page', mode == 'edit' ? 'Update!' : 'New!', {
                            closeButton: true,
                            tapToDismiss: false,
                            rtl: isRtl
                        });
                        if (type === 0) {
                            disableSubmitButton(false);
                        } else {
                            disableSubmitButtonDraft(false);
                        }
                        setTimeout(()=>{
                            window.location.href = '/jobs';
                        }, 2000)
                    })
                    .fail(function(error) {
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
                        }
                        else {
                            toastr["error"]("", "Something wrong, Please try again!", {
                                closeButton: true,
                                tapToDismiss: false,
                                rtl: isRtl,
                            });
                        }
                        if (type === 0) {
                            disableSubmitButton(false);
                        } else {
                            disableSubmitButtonDraft(false);
                        }
                    })
            }else{
                result.dismiss;
            }
        });
    }
}
function disableSubmitButton(status){
    if(status){
        draft.attr('disabled', 'disabled');
        save.attr('disabled', 'disabled');
        save.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="ml-25 align-middle">Loading</span>');
    }
    else{
        draft.removeAttr('disabled');
        save.removeAttr('disabled');
        save.html('Save');
    }
}

function disableSubmitButtonDraft(status){
    if(status){
        draft.attr('disabled', 'disabled');
        save.attr('disabled', 'disabled');
        draft.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="ml-25 align-middle">Loading</span>');
    }
    else{
        draft.removeAttr('disabled');
        save.removeAttr('disabled');
        draft.html('Save as Draft');
    }
}


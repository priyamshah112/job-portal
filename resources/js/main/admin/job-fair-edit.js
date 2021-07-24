const isRtl = $("html").attr("data-textdirection") === "rtl",
    horizontalWizard = document.querySelector('.horizontal-wizard-job-fair-create'),
    assetPath = $("body").attr("data-asset-path"),
    jobFairDetailForm = $('.job-fair-detail-form'),
    contactForm = $('.contact-form'),
    dateTimeForm = $('.date-time-form'),
    jobNextButton = $('.btn-next'),
    jobSubmitButton = $('.btn-submit');

var selectedJobFairId = $('input[name="job_fair_id"]').val(),
    type = 1;


//initial
$('.select2').select2();

$('.flatpickr-range').flatpickr({
    mode: 'range',
    minDate: "today",
});

$('.pickatime').pickatime();

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
        if(department_id !== '')
        {
            $("#department_id").find('option[value=' + department_id + ']').prop('selected',true);
        }
    },
    failure: function(err){
        console.log(err);
    }
});

$('#price').on('change', function(){
    let freeOrNot = $('#price').val();
    if(freeOrNot === 'price')
    {
        $('.amount-box').removeClass('d-none');
    }
    else
    {
        $('#amount').val("");
        $('.amount-box').addClass('d-none');
    }
});

var numberedStepper = new Stepper(horizontalWizard);

$(horizontalWizard)
    .find('.btn-prev')
    .on('click', function () {
        numberedStepper.previous();
    });


let jobFairDetailValidator = jobFairDetailForm.validate({
    rules: {
        name: {required: true},
        description: {required: true},
        organizer_name: {required: true},
        department_id: {required: true},
        type: {required: true},
        price: {required: true},
        amount: {
            required: { depends : function () { 
                return $('#price').val() === 'price' ? true : false;
                }
            }
        },
    }
});

let contactValidator = contactForm.validate({
    rules: {        
        address: {required: true},
        mobile_number: {required: true},
        email: {
            required: true,
            validate_email: true,
        },
    }
});

let dateTimeValidator = dateTimeForm.validate({
    rules: {
        dates: {required: true},
        end_date: {required: true},
        start_time: {required: true},
        end_time: {required: true},
    }
});

jobFairDetailForm.on('submit', function (e){
    e.preventDefault();
    let isValid = jobFairDetailValidator.valid();
    let formData = new FormData(this);
    if(isValid)
    {
        disableNextButton(true);
        $.ajax({
            method: "POST",
            url: `${assetPath}api/v1/admin/job-fair/details-update/${selectedJobFairId}`,
            data: formData,            
            processData: false,
            contentType: false,
        })
        .done(function(res) {
            selectedJobFairId = res.data.id;
            numberedStepper.next();
            disableNextButton(false);   
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
                jobFairDetailValidator.showErrors(showErrors);
            }
            else {
                toastr["error"]("", "Something wrong, Please try again!", {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: isRtl,
                });
            }
            disableNextButton(false);  
        })
    }
});

contactForm.on('submit', function (e){
    e.preventDefault();
    let isValid = contactValidator.valid();
    let formData = new FormData(this);
    if(isValid)
    {
        disableNextButton(true);
        $.ajax({
            method: "POST",
            url: `${assetPath}api/v1/admin/job-fair/contact-update/${selectedJobFairId}`,
            data: formData,
            processData: false,
            contentType: false,
        })
        .done(function(res) {
            // toastr['info']('👋 Job Updated Successfully', {
            //     closeButton: true,
            //     tapToDismiss: false,
            //     rtl: isRtl
            // });    
            numberedStepper.next();
            disableNextButton(false);   
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
                contactValidator.showErrors(showErrors);
            }
            else {
                toastr["error"]("", "Something wrong, Please try again!", {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: isRtl,
                });
            }
            disableNextButton(false);
        })
    }
})

$('.btn-submit').on('click', function (){
    type = $(this).attr('data-type');
    dateTimeForm.trigger('submit');
})

dateTimeForm.on('submit', function (e){
    e.preventDefault();
    let isValid = dateTimeValidator.valid();
    let formData = new FormData(this);
    formData.append('draft', type)
    if(isValid)
    {
        disableSubmitButton(true);
        $.ajax({
            method: "POST",
            url: `${assetPath}api/v1/admin/job-fair/event-date-time-update/${selectedJobFairId}`,
            data: formData,
            processData: false,
            contentType: false,
        })
        .done(function(res) {
            if(res.data.draft === 0)
            {
                toastr['success']('👋 Job Fair Created Successfully', {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: isRtl
                });  

            }
            else{
                toastr['info']('👋 Job Fair Updated Successfully', {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: isRtl
                });    
            }
            window.location.href = '/job-fair';
            disableSubmitButton(false);   
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
                contactValidator.showErrors(showErrors);
            }
            else {
                toastr["error"]("", "Something wrong, Please try again!", {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: isRtl,
                });
            }
            disableSubmitButton(false);
        })
    }
})

function disableNextButton(status) {
    if (status) {
        jobNextButton.attr('disabled', 'disabled');
        jobNextButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="ml-25 align-middle">Loading</span>');
    } else {
        jobNextButton.removeAttr('disabled');
        jobNextButton.html('Next');
    }
}

function disableSubmitButton(status) {
    if (status) {
        jobSubmitButton.attr('disabled', 'disabled');
        jobSubmitButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="ml-25 align-middle">Loading</span>');
    } else {
        jobSubmitButton.removeAttr('disabled');
        $('.btn-submit[data-type="1"]').html('Save As Draft');
        $('.btn-submit[data-type="0"]').html('Submit');
    }
}
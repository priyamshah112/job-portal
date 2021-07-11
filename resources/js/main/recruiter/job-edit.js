const isRtl = $("html").attr("data-textdirection") === "rtl",
    horizontalWizard = document.querySelector('.horizontal-wizard-job-create'),
    assetPath = $("body").attr("data-asset-path"),
    jobDetailForm = $('.job-detail-form'),
    criteriaForm = $('.criteria-form'),
    locationForm = $('.location-form'),
    jobNextButton = $('.btn-next'),
    jobSubmitButton = $('.btn-submit');

var selectedJobId = $('input[name="job_id"]').val(),
    type = 1;

//initial
$('#skills').select2();
let qualifications = $("#qualification_id").select2();

$.ajax({
    url: `${assetPath}api/v1/qualifications`,
    type: "GET",
    dataType: 'json',
    success: function(res) {
        res.data.forEach(item => {
            $("#qualification_id").append('<option value="' + item.id + '">' + item.name + '</option>');
        });
        
        let qualification_id = $("#qualification_id").attr('previous-selected');
        if(qualification_id !== '')
        {
            qualifications.select2('val',[JSON.parse(qualification_id)]);  
        }
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
        if(department_id !== '')
        {
            $("#department_id").find('option[value=' + department_id + ']').prop('selected',true);
        }
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
            $(".state").append('<option value="' + item
                .id + '">' + item.name + '</option>');
        }); 
        
        let states = $('select[name="state[]');
        states.each(function(i, el){
            let state = $(this).attr('previous-selected');
            if(state !== '')
            {
                
                let $this = $(this);
                $this.find('option[value=' + state + ']').prop('selected',true);
                $.ajax({
                    url: `${assetPath}api/v1/cities/${state}`,
                    type: "GET",
                    dataType: 'json',
                    success: function (res) {
                        $this.parents('.row').find('.city').html('<option value="">Select City</option>');
                        res.data.forEach(item => {
                            $this.parents('.row').find('.city').append('<option value="' + item
                                .id + '">' + item.name + '</option>');
                        });
                        let city = $this.parents('.row').find('.city').attr('previous-selected');
                        if(city !== '')
                        {
                            $this.parents('.row').find('.city').find('option[value=' + city + ']').prop('selected',true);
                        }
                    }
                });
            }
        })
    }
});

$('.state').on('change', function () {
    var id = this.value;
    let $this = $(this);
    $this.parents('.row').find('.city').html('');
    $.ajax({
        url: `${assetPath}api/v1/cities/${id}`,
        type: "GET",
        dataType: 'json',
        success: function (res) {
            $this.parents('.row').find('.city').html('<option value="">Select City</option>');
            res.data.forEach(item => {
                $this.parents('.row').find('.city').append('<option value="' + item
                    .id + '">' + item.name + '</option>');
            });

        }
    });
});

var numberedStepper = new Stepper(horizontalWizard);

$(horizontalWizard)
    .find('.btn-prev')
    .on('click', function () {
        numberedStepper.previous();
    });

let jobDetailValidator = jobDetailForm.validate({
    rules: {
        position: { required: true},
        num_position: { required: true },
        salary_min: { required: true },
        salary_max: { 
            required: true, 
            min: function() {
                return parseInt($('#salary_min').val());
            }
        },
        description: { required: true },
    },
    messages: {
        minSalary: {
            max: 'Salary is greater than Max Salary'
        },
        maxSalary: {
            min: 'Salary is lesser than Min Salary'
        }
    }
});

let criteriaValidator = criteriaForm.validate({
    rules: {
        age_min: { required: true },
        age_max: { required: true, min: function() {
                return parseInt($('#age_min').val());
            }
        },
        experience: { required: true },
        maxexperience: { 
            required: true, 
            min: function() {
                return parseInt($('#maxexperience').val());
            }
        },
        deadline: { required: true },
        'qualification_id[]': { required: true },
        'skills[]': { required: true },
        gender: { required: true },
    },
    messages: {
        minAge: {
            max: 'Age is greater than Max Age'
        },
        maxAge: {
            min: 'Age is lesser than Min Age'
        },
        experience: {
            max: 'Experience is greater than Max Experience'
        },
        maxexperience: {
            min: 'Experience is lesser than Min Experience'
        }
    }
});

let locationValidator = locationForm.validate({
    rules: {
        'state[]': { required: true },
        'city[]': { required: true },
    }
});

jobDetailForm.on('submit', function (e){
    e.preventDefault();
    let isValid = jobDetailValidator.valid();
    let formData = new FormData(this);
    if(isValid)
    {
        $.ajax({
            method: "POST",
            url: `${assetPath}api/v1/recruiter/jobs/job-detail-update/${selectedJobId}`,
            data: formData,            
            processData: false,
            contentType: false,
        })
        .done(function(res) {
            selectedJobId = res.data.id;

            // toastr['info']('👋 Job updated Successfully', {
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
                jobDetailValidator.showErrors(showErrors);
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

criteriaForm.on('submit', function (e){
    e.preventDefault();
    let isValid = criteriaValidator.valid();
    let formData = new FormData(this);
    if(isValid)
    {
        disableNextButton(true);
        $.ajax({
            method: "POST",
            url: `${assetPath}api/v1/recruiter/jobs/criteria-update/${selectedJobId}`,
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
                criteriaValidator.showErrors(showErrors);
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
    locationForm.trigger('submit');
})

locationForm.on('submit', function (e){
    e.preventDefault();
    let isValid = locationValidator.valid();
    let formData = new FormData(this);
    formData.append('draft', type)
    if(isValid)
    {
        disableSubmitButton(true);
        $.ajax({
            method: "POST",
            url: `${assetPath}api/v1/recruiter/jobs/location-update/${selectedJobId}`,
            data: formData,
            processData: false,
            contentType: false,
        })
        .done(function(res) {
            if(res.data.draft === 0)
            {
                toastr['success']('👋 Job Created Successfully', {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: isRtl
                });  

            }
            else{
                toastr['info']('👋 Job Updated Successfully', {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: isRtl
                });    
            }
            window.location.href = '/jobs';
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
                criteriaValidator.showErrors(showErrors);
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
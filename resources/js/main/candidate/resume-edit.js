var modernVerticalWizard = document.querySelector('.modern-vertical-wizard-resume'),
    select = $('.select2'),
    personalInfoForm = $('.personal-info-form'),
    addressForm = $('.address-form'),
    contactForm = $('.contact-form'),
    qualificationForm = $('.qualification-form'),
    personInfoUpdateButton = $('btn-update-personal'),
    addressUpdateButton = $('btn-update-address'),
    contactUpdateButton = $('btn-update-contact'),
    qualificationUpdateButton = $('btn-update-qualification'),
    token = $('meta[name="csrf-token"]').attr('content'),
    isRtl = $("html").attr("data-textdirection") === "rtl",
    assetPath = $("body").attr("data-asset-path")
    category =$('input[name="category"]');

let qualification = $("#qualification_id").select2(),
    skills = $("#skills").select2(),
    department = $("#department_id").select2(),
    position = $("#previous_position").select2(),
    categoryValue = $('#experience').prop("checked") ? 'experience' : 'fresher';

// custom validator
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

jQuery.validator.addMethod("notEqualEmail", function(value, element, param) {
    return this.optional(element) || value != $(param).val();
}, "This field should not be same as email.");

jQuery.validator.addMethod("notEqualMobile", function(value, element, param) {
    return this.optional(element) || value != $(param).val();
}, "This field should not be same as primary mobile number.");

jQuery.validator.addMethod(
    "validDOB",
    function(value, element) {  

        var currdate = new Date();
        var d = new Date(value);
        var setDate = new Date(d.getFullYear() + 18, d.getMonth(), d.getDate());
        if (currdate >= setDate){
            return true;
        }else{
            return false;
        }
    },
    "Sorry, you must be 18 years of age to apply"
);

category.on('change', function() {
    let category = $(this).val();
    if (category === "experience") {
        $(".experienceCategory").removeClass('d-none');
    } else {
        $(".experienceCategory").addClass('d-none');
        $("input[name='previous_company']").val('');
        position.select2('val', [""]);
        $("input[name='previous_ctc']").val('');
        $("input[name='experience']").val('');
        $("input[name='expected_salary']").val('');         
        $('#preferred_state_1').val('');
        $('#preferred_state_2').val('');
        $('#preferred_state_3').val('');
        $('#preferred_city_1').val('');
        $('#preferred_city_2').val('');
        $('#preferred_city_3').val('');
    }
    if($('#experience').prop("checked"))
    {
        categoryValue = 'experience';
    }
    else
    {
        categoryValue = 'fresher'
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
        if(qualification_id !== ""){
            qualification.select2('val',[qualification_id]);
        }
    },
    failure: function(err){
        console.log(err);
    }
});

$.ajax({
    url: `${assetPath}api/v1/skills`,
    type: "GET",
    dataType: 'json',
    success: function(res) {
        res.data.forEach(item => {
            $("#skills").append('<option value="' + item.id + '">' + item.name + '</option>');
        });
        let value = $("#skills").attr('previous-selected');
        if(value !== ""){
            skills.select2('val',[JSON.parse(value)]);
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
        if(department_id !== "")
        {
            department.select2('val', [department_id]);
        }
    },
    failure: function(err){
        console.log(err);
    }
});

$.ajax({
    url: `${assetPath}api/v1/positions`,
    type: "GET",
    dataType: 'json',
    success: function(res) {
        res.data.forEach(item => {
            $("#previous_position").append('<option value="' + item.id + '">' + item.name + '</option>');
        });
        let value = $("#previous_position").attr('previous-selected');
        if(value !== "")
        {
            position.select2('val', [value]);
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
            $("#state").append('<option value="' + item
                .id + '">' + item.name + '</option>');
            $("#preferred_state_1").append('<option value="' + item
                .id + '">' + item.name + '</option>');
            $("#preferred_state_2").append('<option value="' + item
                .id + '">' + item.name + '</option>');
            $("#preferred_state_3").append('<option value="' + item
                .id + '">' + item.name + '</option>');
        });   
        
        let state = $("#state").attr('previous-selected');
        if(state !== '')
        {
            $("#state").find('option[value=' + state + ']').prop('selected',true);
            $.ajax({
                url: `${assetPath}api/v1/cities/${state}`,
                type: "GET",
                dataType: 'json',
                success: function (res) {    
                    $('#city').html('<option value="">Select City</option>');
                    res.data.forEach(item => {
                        $("#city").append('<option value="' + item
                            .id + '">' + item.name + '</option>');
                    });
                    let city = $("#city").attr('previous-selected');
                    if(city !== '')
                    {
                        $("#city").find('option[value=' + city + ']').prop('selected',true);
                    }
                }
            });
        }

        let preferred_state_1 = $("#preferred_state_1").attr('previous-selected');
        if(preferred_state_1 !== '')
        {
            $("#preferred_state_1").find('option[value=' + preferred_state_1 + ']').prop('selected',true);
            $.ajax({
                url: `${assetPath}api/v1/cities/${preferred_state_1}`,
                type: "GET",
                dataType: 'json',
                success: function (res) {
                    if(categoryValue)
                    {
                        $('#preferred_city_1').html('<option value="">Select City</option><option value="all">All</option>');                
                    }
                    else
                    {
                        $('#preferred_city_1').html('<option value="">Select City</option>');
                    }
                    res.data.forEach(item => {
                        $("#preferred_city_1").append('<option value="' + item
                            .id + '">' + item.name + '</option>');
                    });
                    let preferred_city_1 = $("#preferred_city_1").attr('previous-selected');
                    if(preferred_city_1 !== '')
                    {
                        $("#preferred_city_1").find('option[value=' + preferred_city_1 + ']').prop('selected',true);
                    }
                }
            });
        }
        
        let preferred_state_2 = $("#preferred_state_2").attr('previous-selected');
        if(preferred_state_2 !== '')
        {
            $("#preferred_state_2").find('option[value=' + preferred_state_2 + ']').prop('selected',true);
            $.ajax({
                url: `${assetPath}api/v1/cities/${preferred_state_2}`,
                type: "GET",
                dataType: 'json',
                success: function (res) {
                    if(categoryValue)
                    {
                        $('#preferred_city_2').html('<option value="">Select City</option><option value="all">All</option>');                
                    }
                    else
                    {
                        $('#preferred_city_2').html('<option value="">Select City</option>');
                    }
                    res.data.forEach(item => {
                        $("#preferred_city_2").append('<option value="' + item
                            .id + '">' + item.name + '</option>');
                    });
                    let preferred_city_2 = $("#preferred_city_2").attr('previous-selected');
                    if(preferred_city_2 !== '')
                    {
                        $("#preferred_city_2").find('option[value=' + preferred_city_2 + ']').prop('selected',true);
                    }
                }
            });
        }
        
        let preferred_state_3 = $("#preferred_state_3").attr('previous-selected');
        if(preferred_state_3 !== '')
        {
            $("#preferred_state_3").find('option[value=' + preferred_state_3 + ']').prop('selected',true);
            $.ajax({
                url: `${assetPath}api/v1/cities/${preferred_state_3}`,
                type: "GET",
                dataType: 'json',
                success: function (res) {
                    if(categoryValue)
                    {
                        $('#preferred_city_3').html('<option value="">Select City</option><option value="all">All</option>');                
                    }
                    else
                    {
                        $('#preferred_city_3').html('<option value="">Select City</option>');
                    }
                    res.data.forEach(item => {
                        $("#preferred_city_3").append('<option value="' + item
                            .id + '">' + item.name + '</option>');
                    });
                    let preferred_city_3 = $("#preferred_city_3").attr('previous-selected');
                    if(preferred_city_3 !== '')
                    {
                        $("#preferred_city_3").find('option[value=' + preferred_city_3 + ']').prop('selected',true);
                    }
                }
            });
        }
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
            res.data.forEach(item => {
                $("#city").append('<option value="' + item
                    .id + '">' + item.name + '</option>');
            });

        }
    });
});

$('#preferred_state_1').on('change', function () {
    var id = this.value;
    $("#preferred_city_1").html('');
    $.ajax({
        url: `${assetPath}api/v1/cities/${id}`,
        type: "GET",
        dataType: 'json',
        success: function (res) {
            if(categoryValue === 'experience')
            {
                $('#preferred_city_1').html('<option value="">Select City</option><option value="all">All</option>');                
            }
            else
            {
                $('#preferred_city_1').html('<option value="">Select City</option>');
            }
            res.data.forEach(item => {
                $("#preferred_city_1").append('<option value="' + item
                    .id + '">' + item.name + '</option>');
            });

        }
    });
});

$('#preferred_state_2').on('change', function () {
    var id = this.value;
    $("#preferred_city_2").html('');
    $.ajax({
        url: `${assetPath}api/v1/cities/${id}`,
        type: "GET",
        dataType: 'json',
        success: function (res) {
            if(categoryValue === 'experience')
            {
                $('#preferred_city_2').html('<option value="">Select City</option><option value="all">All</option>');                
            }
            else
            {
                $('#preferred_city_2').html('<option value="">Select City</option>');
            }
            res.data.forEach(item => {
                $("#preferred_city_2").append('<option value="' + item
                    .id + '">' + item.name + '</option>');
            });

        }
    });
});

$('#preferred_state_3').on('change', function () {
    var id = this.value;
    $("#preferred_city_3").html('');
    $.ajax({
        url: `${assetPath}api/v1/cities/${id}`,
        type: "GET",
        dataType: 'json',
        success: function (res) {
            if(categoryValue === 'experience')
            {
                $('#preferred_city_3').html('<option value="">Select City</option><option value="all">All</option>');                
            }
            else
            {
                $('#preferred_city_3').html('<option value="">Select City</option>');
            }
            res.data.forEach(item => {
                $("#preferred_city_3").append('<option value="' + item
                    .id + '">' + item.name + '</option>');
            });

        }
    });
});

var modernVerticalStepper = new Stepper(modernVerticalWizard, {
    linear: false
});

$(modernVerticalWizard)
    .find('.btn-next')
    .on('click', function () {
        modernVerticalStepper.next();
});

$(modernVerticalWizard)
    .find('.btn-prev')
    .on('click', function () {
        modernVerticalStepper.previous();
});

let personalInfoValidator = personalInfoForm.validate({
    rules: {
        first_name: {required: true},
        last_name: {required: true},
        dateOfBirth: {
            required: true,            
            validDOB : true
        },
        gender: {required: true},
        about: {required: true}
    }
});

let addressValidator = addressForm.validate({
    rules: {
        permanent_address: {required: true},
        state: {required: true},
        city: {required: true},
        qualification_id: {required: true},
        preferred_state_1: {required: true},
        preferred_city_1: {required: true},
    }
});

let contactValidator = contactForm.validate({
    rules: {
        alt_email: {
            validate_email: true,
            notEqualEmail: "#email",
        },
        alt_mobile_number: {
            notEqualMobile: "#mobile_number"
        },
    }
})

let qualificationValidator = qualificationForm.validate({
    rules: {
        category: {required: true},
        department_id: {required: true},
        'skills[]': {required: true},
        qualification_id: {required: true},        
        previous_company: {required: { depends: function (){
            return categoryValue == 'experience' ? true : false; 
        }}},
        previous_position: {required: { depends: function (){
            return categoryValue == 'experience' ? true : false; 
        }}},
        experience: {required: { depends: function (){
            return categoryValue == 'experience' ? true : false; 
        }}},
        previous_ctc: {required: { depends: function (){
            return categoryValue == 'experience' ? true : false; 
        }}},
        expected_salary: {required: { depends: function (){
            return categoryValue == 'experience' ? true : false; 
        }}},
    }
});

personalInfoForm.on('submit', function (e) {
    e.preventDefault(); 
    let formData = new FormData(this);
    let isValid = personalInfoValidator.valid();
    if (isValid) {        
        disablePersonalInfoButton(true);
        $.ajax({
            method: "POST",
            url: `${assetPath}api/v1/candidate/personal-info-update`,
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
        })
        .done(function (res) {
            $('#account-upload-img').attr('src', res.data.imagePath);
            $('#navProfileImage').attr('src', res.data.imagePath);
            toastr['info']('👋 Updated Successfully.', 'Updated!', {
                closeButton: true,
                tapToDismiss: false,
                rtl: isRtl
            });
            modernVerticalStepper.next();
            disablePersonalInfoButton(false)
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
            disablePersonalInfoButton(false)
        });
    }
});

addressForm.on('submit', function (e) {
    e.preventDefault(); 
    let formData = new FormData(this);
    let isValid = addressValidator.valid();
    if (isValid) {        
        disableAddressButton(true);
        $.ajax({
            method: "POST",
            url: `${assetPath}api/v1/candidate/address-update`,
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
            modernVerticalStepper.next();
            disableAddressButton(false)
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
                addressValidator.showErrors(showErrors);
            } else {
                toastr["error"]("", "Something wrong, Please try again!", {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: isRtl,
                });
            }
            disableAddressButton(false)
        });
    }
});

contactForm.on('submit', function (e) {
    e.preventDefault(); 
    let formData = new FormData(this);      
    let isValid = contactValidator.valid();
    if (isValid) {       
        disableContactButton(true);
        $.ajax({
            method: "POST",
            url: `${assetPath}api/v1/candidate/contact-update`,
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
            modernVerticalStepper.next();
            disableContactButton(false)
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
                contactValidator.showErrors(showErrors);
            } else {
                toastr["error"]("", "Something wrong, Please try again!", {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: isRtl,
                });
            }
            disableContactButton(false)
        });
    }
});

qualificationForm.on('submit', function (e) {
    e.preventDefault(); 
    let formData = new FormData(this);
    let isValid = qualificationValidator.valid();
    if (isValid) {        
        disableQualificationButton(true);
        $.ajax({
            method: "POST",
            url: `${assetPath}api/v1/candidate/qualification-update`,
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
            modernVerticalStepper.next();
            disableQualificationButton(false)
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
                qualificationValidator.showErrors(showErrors);
            } else {
                toastr["error"]("", "Something wrong, Please try again!", {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: isRtl,
                });
            }
            disableQualificationButton(false)
        });
    }
});

function disablePersonalInfoButton(status) {
    if (status) {
        personInfoUpdateButton.attr('disabled', 'disabled');
        personInfoUpdateButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="ml-25 align-middle">Loading</span>');
    } else {
        personInfoUpdateButton.removeAttr('disabled');
        personInfoUpdateButton.html('Update Personal Info');
    }
}

function disableAddressButton(status) {
    if (status) {
        addressUpdateButton.attr('disabled', 'disabled');
        addressUpdateButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="ml-25 align-middle">Loading</span>');
    } else {
        addressUpdateButton.removeAttr('disabled');
        addressUpdateButton.html('Update Address');
    }
}

function disableContactButton(status) {
    if (status) {
        contactUpdateButton.attr('disabled', 'disabled');
        contactUpdateButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="ml-25 align-middle">Loading</span>');
    } else {
        contactUpdateButton.removeAttr('disabled');
        contactUpdateButton.html('Update Contact');
    }
}

function disableQualificationButton(status) {
    if (status) {
        qualificationUpdateButton.attr('disabled', 'disabled');
        qualificationUpdateButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="ml-25 align-middle">Loading</span>');
    } else {
        qualificationUpdateButton.removeAttr('disabled');
        qualificationUpdateButton.html('Update Qualification');
    }
}

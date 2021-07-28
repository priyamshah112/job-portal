var firebaseConfig = {
    apiKey: "AIzaSyCQTYgtTv_vBUTj8aTcuN0bvJHSAGQk8G0",
    authDomain: "jobportal-e8e2c.firebaseapp.com",
    projectId: "jobportal-e8e2c",
    storageBucket: "jobportal-e8e2c.appspot.com",
    messagingSenderId: "993691896805",
    appId: "1:993691896805:web:cbf521b6423793e3cffd0c",
    measurementId: "G-GP2GBYPJ4Q"
};
firebase.initializeApp(firebaseConfig);
var params = {};
let submitBtn = $('#signupbtn');
let otpbtn = $('#otpbtn');
const isRtl = $("html").attr("data-textdirection") === "rtl";
const assetPath = $("body").attr("data-asset-path");
let registerform = $('#recruiter-form');
let otpform = $('#otpcontainer');
otpform.hide();
registerform.show();
render();
coderesult = null;

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

jQuery.validator.addMethod("notEqualMobile", function(value, element, param) {
    return this.optional(element) || value != $(param).val();
}, "This field should not be same as primary number.");

//initial required data
$.ajax({
    url: `${assetPath}api/v1/qualifications`,
    type: "GET",
    dataType: 'json',
    success: function(res) {
        res.data.forEach(item => {
            $("#qualification_id").append('<option value="' + item.id + '">' + item.name + '</option>');
        });
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
    $('#city').html('');
    $.ajax({
        url: `${assetPath}api/v1/cities/${id}`,
        type: "GET",
        dataType: 'json',
        success: function (res) {
            $('#city').html('<option value="">Select City</option>');
            res.data.forEach(item => {
                $('#city').append('<option value="' + item
                    .id + '">' + item.name + '</option>');
            });

        }
    });
});

let validator = registerform.validate({
    rules: {
        first_name: {required: true},
        last_name: {required: true},
        company_name: {required: true},
        company_address: {required: true},
        state: {required: true},
        city: {required: true},
        company_landline_1: {required: false},
        company_landline_2: {required: false},
        mobile_number: {
            required: true, 
            minlength: 10
        },
        company_mobile_2: {
            required: false,
            minlength: 10,
            notEqualMobile: "#mobile_number",
        },
        email: {required: true, validate_email: true},
        industry_segment: {required: true},
        department_id: {required: true},
        no_of_employees: {required: true},
        annual_turnover: {required: true},
        password: { required: true, minlength: 8 },
        password_confirmation: { required: true, minlength: 8, equalTo: '#register-password' },
        policy: { required: true }
    },
    messages: {
        password_confirmation: {
            equalTo: 'Please Enter the Same Password again.'
        },
        policy: {
            required: 'Please accept!'
        },
        mobile_number: {
            minlength: 'Please enter valid mobile number.'
        }
    }
});
registerform.on('submit', function (e) {
    e.preventDefault();
    var isValid = registerform.valid();
    if(!isValid){
        return;
    }
    console.log(window.recaptchaVerifier)
    params = {};
    registerform.serializeArray().map(function(item) {
        if ( params[item.name] ) {
            if ( typeof(params[item.name]) === "string" ) {
                params[item.name] = [params[item.name]];
            }
            params[item.name].push(item.value);
        } else {
            params[item.name] = item.value;
        }
    });
    disableSubmitButton(true);
    const url = "".concat(assetPath, "api/v1/verifyemailphone");
    $.ajax({
        method: "POST",
        url: url,
        data: {
            mobile_number: params.mobile_number,
            email: params.email
        }
    }).done(function (response) {
        sendOTP();
    }).fail(function (err) {
            if (err.status === 422) {
                let errors = err.responseJSON.message;
                console.log(errors, err)
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
});
const otpvalidator = otpform.validate({
    otp: {required: true, min: 4}
});
otpform.on('submit', function(e) {
    e.preventDefault();
    console.log('submitotpform')
    var isValid = otpform.valid();
    if(!isValid){
        return;
    }
});

function render() {
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container',
        {
            callback: () => {
                submitBtn.removeAttr('disabled');
            },
            'expired-callback': function() {
                submitBtn.prop('disabled', true);
            }
        });
    recaptchaVerifier.render();
}
function disableSubmitButton(status) {
    if (status) {
        submitBtn.attr('disabled', 'disabled');
        submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="ml-25 align-middle">Loading</span>');
    } else {
        submitBtn.removeAttr('disabled');
        submitBtn.html('Sign up');
    }
}
function disableOTPButton(status) {
    if (status) {
        otpbtn.attr('disabled', 'disabled');
        otpbtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="ml-25 align-middle">Loading</span>');
    } else {
        otpbtn.removeAttr('disabled');
        otpbtn.html('Verify OTP');
    }
}
otpbtn.on('click', function() {
    if(!$('#otp').val() || $('#otp').val().length < 4) {
        toastr["error"]("", "Enter valid OTP.", {
            closeButton: true,
            tapToDismiss: false,
            rtl: isRtl,
        });
        return;
    }
    verify();
});
$('#goback').on('click', () => {
    registerform.show();
    otpform.hide();
    submitBtn.prop('disabled', true);
});
function sendOTP() {
    firebase.auth().signInWithPhoneNumber('+91' + params.mobile_number, window.recaptchaVerifier).then(function (confirmationResult) {
        window.confirmationResult = confirmationResult;
        coderesult = confirmationResult;
        console.log(coderesult);
        disableSubmitButton(false);
        registerform.hide();
        otpform.show();
    }).catch(function (error) {
        console.log(error)
        disableSubmitButton(false);
        if (error && error.message) {
            toastr["error"]("", error.message, {
                closeButton: true,
                tapToDismiss: false,
                rtl: isRtl,
            });
            return
        }
        toastr["error"]("", "Something wrong, Please try again!", {
            closeButton: true,
            tapToDismiss: false,
            rtl: isRtl,
        });
    });
}
function register() {
    const url = "".concat(assetPath, "api/v1/registerRecruiter");
    $.ajax({
        method: "POST",
        url: url,
        data: params
    }).done(function (response) {
        if (typeof response == 'string') {
            response = JSON.parse(response);
        }
        console.log('asdasdasd', response)
        if (!response.status) {
            toastr["error"]("", response.msg, {
                closeButton: true,
                tapToDismiss: false,
                rtl: isRtl,
            });
            disableOTPButton(false)
            registerform.show();
            otpform.hide();
            submitBtn.prop('disabled', true);
            return;
        }
        registerform.trigger('reset');
        window.location.href = "/pending-status";
    }).fail(function (err) {
        toastr["error"]("", "Something wrong, Please try again!", {
            closeButton: true,
            tapToDismiss: false,
            rtl: isRtl,
        });
        disableOTPButton(false)
        registerform.show();
        otpform.hide();
        submitBtn.prop('disabled', true);
    });
}

function verify() {
    var code = $("#otp").val();
    disableOTPButton(true);
    coderesult.confirm(code).then(function (result) {
        var user = result.user;
        console.log(user);
        register();
    }).catch(function (error) {
        console.log(error)
        disableOTPButton(false);
        if (error && error.message) {
            toastr["error"]("", 'Invalid OTP', {
                closeButton: true,
                tapToDismiss: false,
                rtl: isRtl,
            });
            return
        }
        toastr["error"]("", "Something wrong, Please try again!", {
            closeButton: true,
            tapToDismiss: false,
            rtl: isRtl,
        });
    });
}

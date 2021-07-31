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
let submitBtn = $('#subbtn');
let otpbtn = $('#otpbtn');
const isRtl = $("html").attr("data-textdirection") === "rtl";
const assetPath = $("body").attr("data-asset-path");
let registerform = $('#candidate');
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

let validator = registerform.validate({
    rules: {
        first_name: {required: true},
        last_name: {required: true},
        mobile_number: {required: true, minlength: 10},
        email: {
            required: true, 
            validate_email: true
        },
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
    if (!params.skills) {
        params['skills'] = [];
    }
    if (params.skills && typeof params.skills === 'string') {
        params['skills'] = [params.skills];
    }
    const url = "".concat(assetPath, "api/v1/registerCandidate");
    $.ajax({
        method: "POST",
        url: url,
        data: params
    }).done(function (response) {
        toastr["success"]("", response.message, {
            closeButton: true,
            tapToDismiss: false,
            rtl: isRtl,
        }); 
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
        $("#otp").val("");
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

/*=========================================================================================
	File Name: page-account-setting.js
	Description: Account setting.
	----------------------------------------------------------------------------------------
	Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
	Author: PIXINVENT
	Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(function () {
  'use strict';

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
        name: {
          required: true
        },
        email: {
          required: true,
          email: true
        }
      }
    });
    userDetailsForm.on('submit', function (e) {
      e.preventDefault();
      var isValid = userDetailsForm.valid();
      if(isValid){
        disableSubmitButton(true);
        $.ajax({
          url: `${assetPath}api/v1/users/changeInfo`,
          type: 'POST',
          headers: {'X-CSRF-TOKEN': token },
          data: new FormData(this),
          processData: false,
          contentType: false,
          success: function (res) {
            // userDetailsForm.trigger('reset');
            toastr['info']('👋 General Info updated Successfully.', 'Updated!', {
              closeButton: true,
              tapToDismiss: false,
              rtl: isRtl
            });
            window.location.reload();
            disableSubmitButton(false);
          },
          error: function (err) {
            console.log('An error occurred.',err);
            if (err.status === 422) {
              let errors = err.responseJSON.message;
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
              Swal.fire({                            
                title: 'Error!',
                icon: 'error',
                text: err.statusText,
                customClass: {
                  confirmButton: 'btn btn-success'
                }
              });
            }
            disableSubmitButton(false);
          },
        })
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
      if(isValid){
        disableSubmitButton(true);
        $.ajax({
          url: `${assetPath}api/v1/users/changePassword`,
          type: 'POST',
          headers: {'X-CSRF-TOKEN': token },
          data: new FormData(this),
          processData: false,
          contentType: false,
          success: function (res) {
            changePasswordForm.trigger('reset');
            toastr['info']('👋 Password updated Successfully.', 'Updated!', {
              closeButton: true,
              tapToDismiss: false,
              rtl: isRtl
            });
            disableSubmitButton(false)
          },
          error: function (err) {
            console.log('An error occurred.',err);
            if (err.status === 422) {
              let errors = err.responseJSON.message;
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
              Swal.fire({                            
                title: 'Error!',
                icon: 'error',
                text: err.statusText,
                customClass: {
                  confirmButton: 'btn btn-success'
                }
              });
            }
            disableSubmitButton(false)
          },
        })
      }
    });
  }

  function disableSubmitButton(status){
    if(status){
      submitBtn.attr('disabled', 'disabled');
      submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="ml-25 align-middle">Loading</span>');
    }
    else{
      submitBtn.removeAttr('disabled');
      submitBtn.html('Save Changes');
    }
  }
});

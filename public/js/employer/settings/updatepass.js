/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!****************************************************!*\
  !*** ./Resources/assets/js/settings/updatepass.js ***!
  \****************************************************/
 // Class definition

var KTSigninGeneral = function () {
  // Elements
  var form;
  var submitButton;
  var validator;
  var passwordMeter; // Handle form

  var handleForm = function handleForm(e) {
    // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    validator = FormValidation.formValidation(form, {
      fields: {
        'oldpassword': {
          validators: {
            notEmpty: {
              message: ' '
            },
            blank: {}
          }
        },
        'newpassword': {
          validators: {
            notEmpty: {
              message: ' '
            },
            callback: {
              message: 'Please enter valid password',
              callback: function callback(input) {
                var value = input.value;

                if (value === '') {
                  return true;
                }

                if (input.value.length > 0) {
                  return validatePassword();
                }
              }
            }
          }
        },
        'confirmpassword': {
          validators: {
            notEmpty: {
              message: ' '
            },
            identical: {
              compare: function compare() {
                return form.querySelector('[name="newpassword"]').value;
              },
              message: 'The password and its confirm are not the same'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap: new FormValidation.plugins.Bootstrap5({
          rowSelector: '.fv-row'
        })
      }
    }).on('core.form.valid', function () {
      FormValidation.utils.fetch('settings/checkoldpass', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        params: {
          oldpassword: form.querySelector('[name="oldpassword"]').value
        }
      }).then(function (response) {
        if (response.valid == false) {
          validator.updateValidatorOption('oldpassword', 'blank', 'message', 'Old Password is Miss Match').updateFieldStatus('oldpassword', 'Invalid', 'blank');
        } else {
          form.submit();
        }
      });
    }); // Handle form submit

    submitButton.addEventListener('click', function (e) {
      // Prevent button default action
      e.preventDefault(); // Validate form

      validator.validate().then(function (status) {
        if (status == 'Valid') {
          // Show loading indication
          submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click 

          submitButton.disabled = true; // Simulate ajax request

          setTimeout(function () {
            // Hide loading indication
            submitButton.removeAttribute('data-kt-indicator'); // Enable button

            submitButton.disabled = false; //    form.submit(); // submit form
          }, 2000);
        } else {
          // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
          Swal.fire({
            text: "Sorry, looks like there are some errors detected, please try again.",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
              confirmButton: "btn btn-primary"
            }
          });
        }
      });
    });
  };

  var validatePassword = function validatePassword() {
    return passwordMeter.getScore() === 100;
  }; // Public functions


  return {
    // Initialization
    init: function init() {
      form = document.querySelector('#kt_modal_updatepass_form');
      submitButton = document.querySelector('#kt_modal_updatepass_submit');
      passwordMeter = KTPasswordMeter.getInstance(form.querySelector('[data-kt-password-meter="true"]'));
      handleForm();
    }
  };
}(); // On document ready


KTUtil.onDOMContentLoaded(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  KTSigninGeneral.init();
  $('#updatepass_close_button').click(function () {
    $('#kt_modal_updatepass_form').trigger("reset"); //$('#mdluser_add').modal({show:false});

    $('#kt_modal_updatepass').modal('hide');
  });
});
/******/ })()
;
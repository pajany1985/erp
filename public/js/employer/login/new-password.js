/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!***************************************************!*\
  !*** ./Resources/assets/js/login/new-password.js ***!
  \***************************************************/
 // Class Definition

var KTPasswordResetNewPassword = function () {
  // Elements
  var form;
  var submitButton;
  var validator;
  var passwordMeter;

  var handleForm = function handleForm(e) {
    // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    validator = FormValidation.formValidation(form, {
      fields: {
        'password': {
          validators: {
            notEmpty: {
              message: 'The password is required'
            },
            callback: {
              message: 'Please enter valid password',
              callback: function callback(input) {
                if (input.value.length > 0) {
                  return validatePassword();
                }
              }
            }
          }
        },
        'confirm-password': {
          validators: {
            notEmpty: {
              message: 'The password confirmation is required'
            },
            identical: {
              compare: function compare() {
                return form.querySelector('[name="password"]').value;
              },
              message: 'The password and its confirm are not the same'
            }
          }
        },
        'toc': {
          validators: {
            notEmpty: {
              message: 'You must accept the terms and conditions'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger({
          event: {
            password: false
          }
        }),
        bootstrap: new FormValidation.plugins.Bootstrap5({
          rowSelector: '.fv-row',
          eleInvalidClass: '',
          eleValidClass: ''
        })
      }
    });
    submitButton.addEventListener('click', function (e) {
      e.preventDefault();
      validator.revalidateField('password');
      validator.validate().then(function (status) {
        if (status == 'Valid') {
          // Show loading indication
          submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click 

          submitButton.disabled = true;
          var actionurl = $('#actionurl').val();
          var password = $('#password').val();
          var cpass = $('#confirm-password').val();
          var employer_id = $('#employer_id').val(); // Simulate ajax request

          setTimeout(function () {
            // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
            $.ajax({
              url: actionurl,
              method: "post",
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              data: {
                "password": password,
                'cpass': cpass,
                'employer_id': employer_id
              },
              success: function success(data) {
                submitButton.removeAttribute('data-kt-indicator');
                submitButton.disabled = false;

                if (data.code == '1') {
                  Swal.fire({
                    text: "You have successfully reset your password!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                      confirmButton: "btn btn-primary"
                    }
                  }).then(function (result) {
                    if (result.isConfirmed) {
                      passwordMeter.reset(); // reset password meter

                      form.querySelector('[name="password"]').value = "";
                      form.querySelector('[name="confirm-password"]').value = "";
                      window.location.replace('/employer/logout'); // form.submit();
                    }
                  });
                } else {
                  Swal.fire({
                    text: "Password does not change, Please contact admin",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                      confirmButton: "btn btn-primary"
                    }
                  });
                }
              }
            });
          }, 1500);
        } else {// Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
          // Swal.fire({
          //     text: "Sorry, looks like there are some errors detected, please try again.",
          //     icon: "error",
          //     buttonsStyling: false,
          //     confirmButtonText: "Ok, got it!",
          //     customClass: {
          //         confirmButton: "btn btn-primary"
          //     }
          // });
        }
      });
    });
    form.querySelector('input[name="password"]').addEventListener('input', function () {
      if (this.value.length > 0) {
        validator.updateFieldStatus('password', 'NotValidated');
      }
    });
  };

  var validatePassword = function validatePassword() {
    return passwordMeter.getScore() === 100;
  }; // Public Functions


  return {
    // public functions
    init: function init() {
      form = document.querySelector('#kt_new_password_form');
      submitButton = document.querySelector('#kt_new_password_submit');
      passwordMeter = KTPasswordMeter.getInstance(form.querySelector('[data-kt-password-meter="true"]'));
      handleForm();
    }
  };
}(); // On document ready


KTUtil.onDOMContentLoaded(function () {
  KTPasswordResetNewPassword.init();
});
/******/ })()
;
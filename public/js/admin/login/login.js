/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!********************************************!*\
  !*** ./Resources/assets/js/login/login.js ***!
  \********************************************/
 // Class definition

var KTSigninGeneral = function () {
  // Elements
  var form;
  var submitButton;
  var validator; // Handle form

  var handleForm = function handleForm(e) {
    // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    validator = FormValidation.formValidation(form, {
      fields: {
        'username': {
          validators: {
            notEmpty: {
              message: 'Username is required'
            }
          }
        },
        'password': {
          validators: {
            notEmpty: {
              message: 'The password is required'
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

            submitButton.disabled = false;
            form.submit(); // submit form
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
  }; // Public functions


  return {
    // Initialization
    init: function init() {
      form = document.querySelector('#kt_sign_in_form');
      submitButton = document.querySelector('#kt_sign_in_submit');
      handleForm();
    }
  };
}(); // On document ready


KTUtil.onDOMContentLoaded(function () {
  KTSigninGeneral.init();
});
/******/ })()
;
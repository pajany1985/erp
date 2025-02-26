/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!******************************************!*\
  !*** ./Resources/assets/js/login/otp.js ***!
  \******************************************/
 // Class Definition

var KTSigninotps = function () {
  // Elements
  var form;
  var submitButton;
  var overlaytarget = document.querySelector("#kt_body");
  var overlayblockUI = new KTBlockUI(overlaytarget, {
    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>'
  }); // Handle form

  var handleForm = function handleForm(e) {
    // Handle form submit
    submitButton.addEventListener('click', function (e) {
      e.preventDefault();
      var validated = true;
      var inputs = [].slice.call(form.querySelectorAll('.otpclass'));
      inputs.map(function (input) {
        if (input.value === '' || input.value.length === 0) {
          validated = false;
        }
      });

      if (validated === true) {
        // Show loading indication
        submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click 

        submitButton.disabled = true; // Simulate ajax request

        setTimeout(function () {
          var inputval = '';
          inputs.map(function (input) {
            inputval += input.value;
          });
          var position_id = $('#position_id').val();
          var employer_id = $('#employer_id').val();
          var candidate_id = $('#candidate_id').val();
          $.ajax({
            url: "/verifyotp",
            method: "post",
            data: {
              "otpval": inputval,
              "position_id": position_id,
              "employer_id": employer_id,
              "candidate_id": candidate_id
            },
            success: function success(data) {
              // Hide loading indication
              submitButton.removeAttribute('data-kt-indicator'); // Enable button

              submitButton.disabled = false;

              if (data.success == '1') {
                inputs.map(function (input) {
                  input.value = '';
                });
                var redirectUrl = form.getAttribute('data-kt-redirect-url');

                if (redirectUrl) {
                  location.href = redirectUrl;
                } // Swal.fire({
                //     text: "You have been successfully verified!",
                //     icon: "success",
                //     buttonsStyling: false,
                //     confirmButtonText: "Ok, got it!",
                //     customClass: {
                //         confirmButton: "btn btn-primary"
                //     }
                // }).then(function (result) {
                //     if (result.isConfirmed) { 
                //     }
                // });

              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Please enter valid securtiy code and try again.',
                  customClass: {
                    confirmButton: "btn btn-danger"
                  }
                });
              }
            }
          }); // // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
        }, 1000);
      } else {
        swal.fire({
          text: "Please enter valid securtiy code and try again.",
          icon: "error",
          buttonsStyling: false,
          confirmButtonText: "Ok, got it!",
          customClass: {
            confirmButton: "btn fw-bold btn-light-primary"
          }
        }).then(function () {
          KTUtil.scrollTop();
        });
      }
    });
  };

  var resendOtp = function resendOtp() {
    $(".resendotp").on("click", function (e) {
      overlayblockUI.block();
      var inputs = [].slice.call(form.querySelectorAll('input[maxlength="1"]'));
      var position_id = $('#position_id').val();
      var employer_id = $('#employer_id').val();
      var candidate_id = $('#candidate_id').val();
      $.ajax({
        url: "/resendotp",
        method: "post",
        data: {
          "candidate_id": candidate_id
        },
        success: function success(data) {
          overlayblockUI.release();
          inputs.map(function (input) {
            input.value = ' ';
          });

          if (data.success == '1') {
            Swal.fire({
              text: "You have been successfully Resend the OTP, Please verify to login",
              icon: "success",
              buttonsStyling: false,
              confirmButtonText: "Ok, got it!",
              customClass: {
                confirmButton: "btn btn-primary"
              }
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Please try again.',
              customClass: {
                confirmButton: "btn btn-danger"
              }
            });
          }
        }
      });
    });
  }; // Public functions


  return {
    // Initialization
    init: function init() {
      form = document.querySelector('#kt_sing_in_two_steps_form');
      submitButton = document.querySelector('#kt_sing_in_two_steps_submit');
      handleForm();
      resendOtp();
    }
  };
}(); // On document ready


KTUtil.onDOMContentLoaded(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  KTSigninotps.init();
});
/******/ })()
;
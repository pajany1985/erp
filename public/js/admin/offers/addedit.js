/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!***********************************************!*\
  !*** ./Resources/assets/js/offers/addedit.js ***!
  \***********************************************/
 // Class definition

var KTCreateAccount = function () {
  // Elements
  var modal;
  var modalEl;
  var stepper;
  var form;
  var formSubmitButton;
  var formContinueButton;
  var addoredit = $('#addoredit').val(); // Variables

  var stepperObj;
  var validations = []; // Private Functions

  var initStepper = function initStepper() {
    // Initialize Stepper
    stepperObj = new KTStepper(stepper); // Handle navigation click

    stepperObj.on("kt.stepper.click", function (stepper) {
      // Validate form before change stepper step
      var validator = validations[stepper.getCurrentStepIndex() - 1]; // get validator for currnt step

      if (validator) {
        validator.validate().then(function (status) {
          //console.log('validated!');
          if (status == 'Valid') {
            stepperObj.goTo(stepperObj.getClickedStepIndex()); // go to clicked step

            KTUtil.scrollTop();
          } else {
            Swal.fire({
              text: "Sorry, looks like there are some errors detected, please try again.",
              icon: "error",
              buttonsStyling: false,
              confirmButtonText: "Ok, got it!",
              customClass: {
                confirmButton: "btn btn-primary"
              }
            }).then(function () {
              KTUtil.scrollTop();
            });
          }
        });
      } else {
        stepperObj.goTo(stepperObj.getClickedStepIndex()); // go to clicked step

        KTUtil.scrollTop();
      }
    }); // Stepper change event

    stepperObj.on('kt.stepper.changed', function (stepper) {
      //console.log(stepperObj.getCurrentStepIndex()); // If edit means we can allow all step to submit
      if (stepperObj.getCurrentStepIndex() === 3) {
        formSubmitButton.classList.remove('d-none');
        formSubmitButton.classList.add('d-inline-block');
        formContinueButton.classList.add('d-none');
      } else if (stepperObj.getCurrentStepIndex() === 4) {
        formSubmitButton.classList.add('d-none');
        formContinueButton.classList.add('d-none');
      } else {
        formSubmitButton.classList.remove('d-inline-block');
        formSubmitButton.classList.remove('d-none');
        formContinueButton.classList.remove('d-none');
      }
    }); // Validation before going to next page

    stepperObj.on('kt.stepper.next', function (stepper) {
      console.log('stepper.next');
      console.log(stepper.getCurrentStepIndex());
      console.log(stepper.getCurrentStepIndex() - 1); // Validate form before change stepper step

      var validator = validations[stepper.getCurrentStepIndex() - 1]; // get validator for currnt step

      console.log(validator);

      if (validator) {
        validator.validate().then(function (status) {
          console.log('validated!');

          if (status == 'Valid') {
            stepper.goNext();
            KTUtil.scrollTop();
          } else {
            Swal.fire({
              text: "Sorry, looks like there are some errors detected, please try again.",
              icon: "error",
              buttonsStyling: false,
              confirmButtonText: "Ok, got it!",
              customClass: {
                confirmButton: "btn btn-primary"
              }
            }).then(function () {
              KTUtil.scrollTop();
            });
          }
        });
      } else {
        stepper.goNext();
        KTUtil.scrollTop();
      }
    }); // Prev event

    stepperObj.on('kt.stepper.previous', function (stepper) {
      console.log('stepper.previous');
      stepper.goPrevious();
      KTUtil.scrollTop();
    });
  };

  var handleForm = function handleForm() {
    formSubmitButton.addEventListener('click', function (e) {
      // Validate form before change stepper step
      var validator0 = validations[0];
      var validator = validations[1]; // get validator for last form

      validator0.validate().then(function (status) {
        if (status != 'Valid') {
          Swal.fire({
            text: "Sorry, looks like there are some errors detected in Offer Details tab, please try again.",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
              confirmButton: "btn btn-primary"
            }
          }).then(function () {
            stepperObj.goTo(1);
            KTUtil.scrollTop();
          });
        } else {
          validator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
              // Prevent default button action
              e.preventDefault(); // Disable button to avoid multiple click 

              formSubmitButton.disabled = true; // Show loading indication

              formSubmitButton.setAttribute('data-kt-indicator', 'on'); // Simulate form submission

              setTimeout(function () {
                form.submit(); // Hide loading indication

                formSubmitButton.removeAttribute('data-kt-indicator'); // Enable button

                formSubmitButton.disabled = false;
                stepperObj.goNext(); //KTUtil.scrollTop();
              }, 2000);
            } else {
              Swal.fire({
                text: "Sorry, looks like there are some errors detected in Offer Setting tab, please try again.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                  confirmButton: "btn btn-primary"
                }
              }).then(function () {
                stepperObj.goTo(4);
                KTUtil.scrollTop();
              });
            }
          });
        }
      });
    });
  };

  var initValidation = function initValidation() {
    // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    // Step 1
    validations.push(FormValidation.formValidation(form, {
      fields: {
        "package": {
          validators: {
            notEmpty: {
              message: 'The field package is not valid'
            }
          }
        },
        offername: {
          validators: {
            notEmpty: {
              message: ' '
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap: new FormValidation.plugins.Bootstrap5({
          rowSelector: '.fv-row',
          eleInvalidClass: 'is-invalid',
          eleValidClass: '' // defaultMessageContainer: false,

        })
      }
    })); // Step 2

    validations.push(FormValidation.formValidation(form, {
      fields: {
        offer_amount: {
          validators: {
            notEmpty: {
              message: ' '
            },
            greaterThan: {
              message: 'The value must be greater than or equal to 1',
              min: 1
            },
            numeric: {
              message: 'Please give valid amount',
              transformer: function transformer($field, validatorName, validator) {
                var value = $field.val();
                return value.replace(',', '');
              }
            }
          }
        },
        expiryindays: {
          validators: {
            notEmpty: {
              message: ' '
            },
            greaterThan: {
              message: 'The value must be greater than or equal to 1',
              min: 1
            },
            regexp: {
              regexp: /^[0-9\s]+$/i,
              message: 'Please give the valid no. of days'
            }
          }
        },
        activefrom_date: {
          validators: {
            notEmpty: {
              message: ' '
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        // Bootstrap Framework Integration
        bootstrap: new FormValidation.plugins.Bootstrap5({
          rowSelector: '.fv-row',
          eleInvalidClass: 'is-invalid',
          eleValidClass: '' // defaultMessageContainer: false,

        })
      }
    }));

    if (addoredit == 'add') {
      $('#activefrom_date').daterangepicker({
        autoUpdateInput: false,
        showDropdowns: true,
        locale: {
          format: 'YYYY-MM-DD'
        },
        autoApply: true
      });
    } else {
      var from_date = $('#hidden_fromdate').val();
      var to_date = $('#hidden_todate').val();
      $('#activefrom_date').val(from_date + ' to ' + to_date);
      $('#activefrom_date').daterangepicker({
        autoUpdateInput: false,
        locale: {
          format: 'YYYY-MM-DD'
        },
        autoApply: true,
        startDate: from_date,
        endDate: to_date
      });
    }

    $('#activefrom_date').on('apply.daterangepicker', function (ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
      validations[1].revalidateField('activefrom_date');
    });
    $(".datebtn-clear").click(function () {
      var todaydate = new Date();
      $('#activefrom_date').val('');
      $('#activefrom_date').data('daterangepicker').setStartDate(todaydate);
      $('#activefrom_date').data('daterangepicker').setEndDate(todaydate);
    });
  };

  return {
    // Public Functions
    init: function init() {
      // Elements
      modalEl = document.querySelector('#kt_modal_create_account');

      if (modalEl) {
        modal = new bootstrap.Modal(modalEl);
      }

      stepper = document.querySelector('#kt_create_account_stepper');
      form = stepper.querySelector('#kt_create_offer_form');
      formSubmitButton = stepper.querySelector('[data-kt-stepper-action="submit"]');
      formContinueButton = stepper.querySelector('[data-kt-stepper-action="next"]');
      initStepper();
      initValidation();
      handleForm();
    }
  };
}(); // On document ready


KTUtil.onDOMContentLoaded(function () {
  KTCreateAccount.init();
  $(".check_status").on("change", function (e) {
    if ($('input[name="status_hidden"]').is(":checked")) {
      $('input[name="status"]').val('1');
    } else {
      $('input[name="status"]').val('0');
    }
  });
});
/******/ })()
;
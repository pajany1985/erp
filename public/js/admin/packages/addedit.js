/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!*************************************************!*\
  !*** ./Resources/assets/js/packages/addedit.js ***!
  \*************************************************/
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
    stepperObj = new KTStepper(stepper); // Stepper change event

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
            text: "Sorry, looks like there are some errors detected in Account Info tab, please try again.",
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
                text: "Sorry, looks like there are some errors detected in Package Setting tab, please try again.",
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
        name: {
          validators: {
            notEmpty: {
              message: ' '
            }
          }
        },
        package_amount: {
          validators: {
            notEmpty: {
              message: ' '
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
            regexp: {
              regexp: /^[0-9\s]+$/i,
              message: 'Please give the valid no. of days'
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
        max_positions: {
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
              message: 'Please give the valid no. of Positions'
            }
          }
        },
        no_of_question: {
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
              message: 'Please give the valid no. of Question'
            }
          }
        },
        // video_min: {
        // 	validators: {
        // 		notEmpty: {
        // 			message:' '
        // 		},
        // 		regexp: {
        // 			regexp: /^[0-9\s]+$/i,
        // 			message: 'Please give the valid no. of Minutes',
        // 		},
        // 	}
        // },
        max_retake_ques: {
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
              message: 'Please give the valid no. of Retake Count'
            }
          }
        },
        video_retain_period: {
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
        video_min_ques: {
          validators: {
            notEmpty: {
              message: ' '
            },
            regexp: {
              regexp: /^[0-9\s]+$/i,
              message: 'Please give the valid no. of Minutes'
            }
          }
        },
        video_storage_limit: {
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
              message: 'Please give the valid no. of GB'
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
      form = stepper.querySelector('#kt_create_package_form');
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
  $(".check_freepackage").on("change", function (e) {
    var packagecost = $('#packagecost').val();

    if ($('input[name="freepackage_hidden"]').is(":checked")) {
      $('input[name="freepackage"]').val('1');
      $('input[name="package_amount"]').val('0');
      $('#package_amountlabel').removeClass('required');
      $('#package_amountlabel, #package_amount').addClass('text-muted');
      $('#package_amount').prop('readonly', true);
      $('#package_amount').prop('required', false);
    } else {
      $('#package_amount').prop('readonly', false);
      $('#package_amount').prop('required', true);
      $('input[name="freepackage"]').val('0');
      $('input[name="package_amount"]').val(packagecost);
      $('#package_amountlabel').addClass('required');
      $('#package_amountlabel, #package_amount').removeClass('text-muted');
    }
  });
  /*
  	$("#package_amount").on("focusout", function(e) {  
  		if($(this).val()){
  		}
  	});
  */
});
/******/ })()
;
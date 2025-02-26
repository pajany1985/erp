/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!**************************************************!*\
  !*** ./Resources/assets/js/employers/addedit.js ***!
  \**************************************************/
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
    });

    if (addoredit == 'edit') {
      formSubmitButton.classList.add('btn-light-primary');
      formSubmitButton.classList.remove('btn-primary');
      formSubmitButton.classList.add('d-inline-block');
      formSubmitButton.classList.remove('d-none');
      formContinueButton.classList.remove('d-none');
    } // Stepper change event


    stepperObj.on('kt.stepper.changed', function (stepper) {
      //console.log(stepperObj.getCurrentStepIndex()); // If edit means we can allow all step to submit
      if (addoredit == 'add') {
        if (stepperObj.getCurrentStepIndex() === 4) {
          formSubmitButton.classList.remove('d-none');
          formSubmitButton.classList.add('d-inline-block');
          formContinueButton.classList.add('d-none');
        } else if (stepperObj.getCurrentStepIndex() === 5) {
          formSubmitButton.classList.add('d-none');
          formContinueButton.classList.add('d-none');
        } else {
          formSubmitButton.classList.remove('d-inline-block');
          formSubmitButton.classList.remove('d-none');
          formContinueButton.classList.remove('d-none');
        }
      } else {
        if (stepperObj.getCurrentStepIndex() === 4) {
          formSubmitButton.classList.add('btn-primary');
          formSubmitButton.classList.remove('btn-light-primary');
          formSubmitButton.classList.remove('d-none');
          formSubmitButton.classList.add('d-inline-block');
          formContinueButton.classList.add('d-none');
        } else {
          formSubmitButton.classList.add('btn-light-primary');
          formSubmitButton.classList.remove('btn-primary');
          formSubmitButton.classList.add('d-inline-block');
          formSubmitButton.classList.remove('d-none');
          formContinueButton.classList.remove('d-none');
        }
      }
    }); // Validation before going to next page

    stepperObj.on('kt.stepper.next', function (stepper) {
      //console.log('stepper.next');
      // Validate form before change stepper step
      var validator = validations[stepper.getCurrentStepIndex() - 1]; // get validator for currnt step

      if (validator) {
        validator.validate().then(function (status) {
          //console.log('validated!');
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
      var validator1 = validations[1];
      var validator2 = validations[2];
      var validator = validations[3]; // get validator for last form

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
          validator1.validate().then(function (status) {
            if (status != 'Valid') {
              Swal.fire({
                text: "Sorry, looks like there are some errors detected in Setup Location tab, please try again.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                  confirmButton: "btn btn-primary"
                }
              }).then(function () {
                stepperObj.goTo(2);
                KTUtil.scrollTop();
              });
            } else {
              validator2.validate().then(function (status) {
                if (status != 'Valid') {
                  Swal.fire({
                    text: "Sorry, looks like there are some errors detected in Company Info tab, please try again.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                      confirmButton: "btn btn-primary"
                    }
                  }).then(function () {
                    stepperObj.goTo(3);
                    KTUtil.scrollTop();
                  });
                } else {
                  validator.validate().then(function (status) {
                    console.log('validated!');

                    if (status == 'Valid') {
                      // Prevent default button action
                      e.preventDefault(); // Disable button to avoid multiple click 

                      formSubmitButton.disabled = true; // Show loading indication

                      formSubmitButton.setAttribute('data-kt-indicator', 'on');

                      if (addoredit == 'edit') {
                        $('#mdlcomments').modal({
                          backdrop: 'static',
                          keyboard: false
                        });
                        $('#mdlcomments').modal('show');
                      } else {
                        setTimeout(function () {
                          form.submit();
                          formSubmitButton.removeAttribute('data-kt-indicator');
                          formSubmitButton.disabled = false;
                          stepperObj.goNext();
                        }, 2000);
                      }
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
            }
          });
        }
      });
    }); // Payment status. For more info, plase visit the official plugin site: https://select2.org/

    $(form.querySelector('[name="payment_status"]')).on('change', function () {
      // Revalidate the field when an option is chosen
      validations[3].revalidateField('payment_status');
    }); // Package. For more info, plase visit the official plugin site: https://select2.org/

    $(form.querySelector('[name="package"]')).on('change', function () {
      // Revalidate the field when an option is chosen
      validations[3].revalidateField('package');
    }); // Country. For more info, plase visit the official plugin site: https://select2.org/

    $(form.querySelector('[name="country"]')).on('change', function () {
      // Revalidate the field when an option is chosen
      validations[1].revalidateField('country');
    });
    $(form.querySelector('[name="state"]')).on('change', function () {
      // Revalidate the field when an option is chosen
      validations[1].revalidateField('state');
    });
  };

  var validateFormComments = function validateFormComments() {
    $("#frmnotes").validate({
      // define validation rules
      errorClass: 'invalid-feedback',
      rules: {
        cmnt_area: {
          required: true,
          normalizer: function normalizer(value) {
            return $.trim(value);
          }
        }
      },
      highlight: function highlight(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        var elem = $(element);

        if (elem.hasClass("select2-hidden-accessible")) {
          $("#select2-" + elem.attr("id") + "-container").parent().addClass('is-invalid');
        } else {
          elem.addClass('is-invalid');
        }
      },
      unhighlight: function unhighlight(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        var elem = $(element);

        if (elem.hasClass("select2-hidden-accessible")) {
          $("#select2-" + elem.attr("id") + "-container").parent().removeClass('is-invalid');
        } else {
          elem.removeClass('is-invalid');
        }
      },
      errorPlacement: function errorPlacement(error, element) {
        var elem = $(element);

        if (elem.hasClass("select2-hidden-accessible")) {
          element = $("#select2-" + elem.attr("id") + "-container").parent();
          error.insertAfter(element);
        } else {
          error.insertAfter(element);
        }
      },
      submitHandler: function submitHandler(validform) {
        var employer_id = $('#cmtemployer_id').val();
        var admin_id = $('#admin_id').val();
        var cmnt_area = $('#cmnt_area').val();
        $.ajax({
          url: "/admin/employer/empnotes",
          type: 'post',
          data: {
            "employer_id": employer_id,
            "admin_id": admin_id,
            "cmnt_area": cmnt_area
          },
          beforeSend: function beforeSend() {
            //overlayblockUI.block();
            $('#cmnt_submit').attr('disabled', true);
          },
          success: function success(data) {
            form.submit();
            $('#cmnt_submit').attr('disabled', false);
            formSubmitButton.removeAttribute('data-kt-indicator');
            formSubmitButton.disabled = false;
            stepperObj.goNext();
          }
        }); // form.submit(); // submit the form
      }
    });
  };

  var initValidation = function initValidation() {
    // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    // Step 1
    // Placeholder
    Inputmask({
      "mask": "(999) 999-9999"
    }).mask("#phone");
    validations.push(FormValidation.formValidation(form, {
      fields: {
        first_name: {
          validators: {
            notEmpty: {
              message: ' '
            }
          }
        },
        last_name: {
          validators: {
            notEmpty: {
              message: ' '
            }
          }
        },
        phone: {
          validators: {
            notEmpty: {
              message: ' '
            },
            phone: {
              country: 'US',
              message: 'The value is not a valid phone number'
            }
          }
        },
        email: {
          validators: {
            notEmpty: {
              message: ' '
            },
            emailAddress: {
              message: 'The value is not a valid email address'
            },
            remote: {
              message: 'Email already exists',
              method: 'POST',
              data: function data() {
                return {
                  id: document.querySelector('[name="employer_id"]').value
                };
              },
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              url: '/admin/employers/checkemailexist'
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
        country: {
          validators: {
            notEmpty: {}
          }
        },
        address: {
          validators: {
            notEmpty: {
              message: ' '
            }
          }
        },
        city: {
          validators: {
            notEmpty: {
              message: ' '
            }
          }
        },
        state: {
          validators: {
            notEmpty: {}
          }
        },
        postcode: {
          validators: {
            notEmpty: {
              message: ' '
            },
            zipCode: {
              country: 'US',
              message: 'The value is not a valid postal code'
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
    })); // Step 3

    validations.push(FormValidation.formValidation(form, {
      fields: {
        company_name: {
          validators: {
            notEmpty: {
              message: ' '
            }
          }
        },
        company_website: {
          validators: {
            notEmpty: {
              message: ' '
            },
            uri: {
              message: 'The website address is not valid (e.g:https://yoursite.domain)'
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
    })); // Step 4

    validations.push(FormValidation.formValidation(form, {
      fields: {
        "package": {
          validators: {
            notEmpty: {}
          }
        },
        payment_status: {
          validators: {
            notEmpty: {}
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
      // validations[0].addField('password');
      validations[0].addField('password', {
        validators: {
          // Here, add your field validators.
          notEmpty: {
            message: ' '
          }
        }
      });
    }

    var $flatpickr = $("#expiration_date").flatpickr();
    $(".datebtn-clear").click(function () {
      $flatpickr.clear();
    });
  };

  var countryState = function countryState() {
    $('#country').on('change', function () {
      $.ajax({
        url: "dynamicstates",
        method: "post",
        data: {
          "country_id": this.value
        },
        success: function success(data) {
          if (data.success == '1') {
            $('#state').html(data.state_options);
          }
        }
      });
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
      form = stepper.querySelector('#kt_create_account_form');
      formSubmitButton = stepper.querySelector('[data-kt-stepper-action="submit"]');
      formContinueButton = stepper.querySelector('[data-kt-stepper-action="next"]');
      initStepper();
      initValidation();
      handleForm();
      countryState();
      validateFormComments();
    }
  };
}();

KTUtil.onDOMContentLoaded(function () {
  KTCreateAccount.init();
  $.validator.messages.required = '';
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
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!******************************************************!*\
  !*** ./Resources/assets/js/positions/positionadd.js ***!
  \******************************************************/
 // Class definition

var KTDatatablesServerSide = function () {
  // Shared variables
  var table;
  var dt;
  var filterPayment;
  var quill_desc;
  var quill_desc_change;
  var clr_cnt = 0;
  var form;
  var submitButton;
  var draftButton;
  var validator;
  var validations = [];
  var minutes = $('#max_qtn_min').val();
  var max_sec = minutes * 60;
  var midend_val = max_sec / 2;
  var addmore_button = $('#addmore_button').val(); // edit 
  // Export function end

  var progressbar = function progressbar() {
    var maxval = 'kt_question_repeater[0][maxval]';
    var minval = 'kt_question_repeater[0][minval]';
    var mintime_sec = "kt_question_repeater[0][time_minsec]";
    var maxtime_min = "kt_question_repeater[0][allowed_time_min]";
    var db_time_min = "kt_question_repeater[0][db_time_min]";
    var db_time_sec = 'kt_question_repeater[0][db_time_sec]';
    var maxval_value = midend_val;
    var minval_value = 10;

    if ($("[name='" + db_time_min + "']").val() != '') {
      maxval_value = $("[name='" + db_time_min + "']").val();
    }

    if ($("[name='" + db_time_sec + "']").val() != '') {
      minval_value = $("[name='" + db_time_sec + "']").val();
    }

    var slider = document.getElementsByClassName("kt_slider_sizes_sm")[0];
    noUiSlider.create(slider, {
      start: [minval_value, maxval_value],
      // tooltips: [wNumb({decimals: 0}), true],
      connect: true,
      margin: 10,
      range: {
        "min": 0,
        "max": max_sec
      },
      step: 1,
      format: wNumb({
        decimals: 0
      })
    });
    slider.noUiSlider.on("update", function (values, handle) {
      if (handle) {
        var float_minutes = Math.floor(values[handle] / 60); // var seconds = values[handle] - float_minutes * 60;

        var seconds = Math.floor(values[handle] % 60);

        if (seconds < 10) {
          seconds = "0" + seconds;
        }

        $("[name='" + maxtime_min + "']").val(float_minutes + ':' + seconds);
        $("[name='" + maxval + "']").html(float_minutes + ':' + seconds);
      } else {
        $("[name='" + minval + "']").html(values[handle]);
        $("[name='" + mintime_sec + "']").val(values[handle]);
      }
    });
    $(document).on("click", ".questemplate", function (e) {
      $("#mdltemplate").modal('show');
      var input_name = $(this).parents("div.repeat_items").find(".questiondiv").attr('name');
      $("#repeatinput_name").val(input_name);
    });
    $('#mdltemplate').on('hidden.bs.modal', function () {
      $(this).find("input[type=checkbox], input[type=radio]").prop("checked", "").end();
    });
  };

  var handleForm = function handleForm(e) {
    var questionValidators = {
      validators: {
        notEmpty: {
          message: ' '
        }
      }
    }; // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/

    validator = FormValidation.formValidation(form, {
      fields: {
        'position_title': {
          validators: {
            notEmpty: {
              message: ' '
            }
          }
        },
        'position_description': {
          validators: {
            notEmpty: {
              message: ' '
            }
          }
        },
        'kt_question_repeater[0][question]': questionValidators
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
    }); // Handle form submit

    submitButton.addEventListener('click', function (e) {
      $('#draft_ornot').val('1'); // Not Draft , It post the position

      var storageallow = $('#storageallow').val();
      var create_positionallowed = $('#create_positionallowed').val(); // Prevent button default action

      e.preventDefault();

      if (storageallow == '1' && create_positionallowed == '1') {
        // Validate form
        validator.validate().then(function (status) {
          if (status == 'Valid') {
            Swal.fire({
              html: "Are you ready to post this Interview live?",
              icon: "warning",
              buttonsStyling: false,
              showCancelButton: true,
              cancelButtonText: 'No',
              confirmButtonText: "Yes",
              customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: 'btn btn-light btn-active-light-primary'
              }
            }).then(function (result) {
              if (result.value) {
                // Show loading indication
                submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click 

                submitButton.disabled = true;
                draftButton.disabled = true; // Simulate ajax request

                setTimeout(function () {
                  // Hide loading indication
                  submitButton.removeAttribute('data-kt-indicator'); // Enable button

                  submitButton.disabled = false;
                  draftButton.disabled = false;
                  form.submit(); // submit form
                }, 2000);
              }
            });
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
      } else if (storageallow == '0') {
        Swal.fire({
          text: "Sorry, There is No Enough space available to Post a interview, Please Save it as Draft or upgrade your package.",
          icon: "error",
          buttonsStyling: false,
          confirmButtonText: "Ok, got it!",
          customClass: {
            confirmButton: "btn btn-primary"
          }
        });
      } else if (create_positionallowed == '0') {
        Swal.fire({
          text: "Sorry, Limit exceed to post the interview, Please Save it as Draft or upgrade your package.",
          icon: "error",
          buttonsStyling: false,
          confirmButtonText: "Ok, got it!",
          customClass: {
            confirmButton: "btn btn-primary"
          }
        });
      }
    }); // Draft form submit

    draftButton.addEventListener('click', function (e) {
      $('#draft_ornot').val('0'); // It is Draft 
      // Prevent button default action

      e.preventDefault(); // Validate form

      validator.validate().then(function (status) {
        if (status == 'Valid') {
          // Show loading indication
          draftButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click 

          draftButton.disabled = true;
          submitButton.disabled = true;
          var id = form.getAttribute('id');
          $.ajax({
            type: form.getAttribute('method'),
            url: form.getAttribute('action'),
            data: $('#' + id).serialize(),
            success: function success(data) {
              // Hide loading indication
              draftButton.removeAttribute('data-kt-indicator'); // Enable button

              draftButton.disabled = false;
              submitButton.disabled = false;

              if (data.success == '1') {
                Swal.fire({
                  html: "Your interview is saved as draft. Would you like to continue to edit this interview?",
                  icon: "warning",
                  buttonsStyling: false,
                  showCancelButton: true,
                  confirmButtonText: "Yes",
                  cancelButtonText: 'No, Return To Interviews',
                  customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: 'btn btn-light btn-active-light-primary'
                  }
                }).then(function (result) {
                  if (result.value) {
                    window.location.replace(data.route);
                  } else if (result.dismiss == 'cancel') {
                    window.location.replace("/employer");
                  }
                });
              }
            },
            error: function error(data) {
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
    $("#addmore_question").on("click", function (e) {
      var maxqstn_allowd = $('#max_qtn_allowed').val();
      var repeatlength = $('.repeat_items').length;
      var nextlength = parseInt(repeatlength);

      if (nextlength >= maxqstn_allowd) {
        $('#addmore_question').hide();
      } // Min Max silder Initialization for Repeater form


      var current_index = repeatlength - 1;
      var maxval = 'kt_question_repeater[' + current_index + '][maxval]';
      var minval = 'kt_question_repeater[' + current_index + '][minval]';
      var mintime_sec = 'kt_question_repeater[' + current_index + '][time_minsec]';
      var maxtime_min = 'kt_question_repeater[' + current_index + '][allowed_time_min]';
      var db_time_min = 'kt_question_repeater[' + current_index + '][db_time_min]';
      var db_time_sec = 'kt_question_repeater[' + current_index + '][db_time_sec]';
      var maxval_value = midend_val;
      var minval_value = 10;

      if ($("[name='" + db_time_min + "']").val() != '') {
        maxval_value = $("[name='" + db_time_min + "']").val();
      }

      if ($("[name='" + db_time_sec + "']").val() != '') {
        minval_value = $("[name='" + db_time_sec + "']").val();
      }

      var slider = document.getElementsByClassName("kt_slider_sizes_sm")[repeatlength - 1];
      noUiSlider.create(slider, {
        start: [minval_value, maxval_value],
        // tooltips: [wNumb({decimals: 0}), true],
        connect: true,
        margin: 10,
        range: {
          "min": 0,
          "max": max_sec
        },
        step: 1,
        format: wNumb({
          decimals: 0
        })
      });
      slider.noUiSlider.on("update", function (values, handle) {
        if (handle) {
          var float_minutes = Math.floor(values[handle] / 60);
          var seconds = Math.floor(values[handle] % 60);

          if (seconds < 10) {
            seconds = "0" + seconds;
          }

          $("[name='" + maxtime_min + "']").val(float_minutes + ':' + seconds);
          $("[name='" + maxval + "']").html(float_minutes + ':' + seconds);
        } else {
          $("[name='" + minval + "']").html(values[handle]);
          $("[name='" + mintime_sec + "']").val(values[handle]);
        }
      }); // Append Question Index and Set Required fields for Repeater form fields

      $(".repeat_items").each(function (index) {
        var repeatname = 'kt_question_repeater[' + index + '][questionlabel]';
        var qstnindex = parseInt(index) + 1;
        $("[name='" + repeatname + "']").html('Question ' + qstnindex);

        if (index > 0) {
          validator.addField('kt_question_repeater[' + index + '][question]', questionValidators);
        }
      });
    });
    $('#kt_question_repeater').on('click', '[data-repeater-delete]', function (event) {
      var maxqstn_allowd = $('#max_qtn_allowed').val();
      var index_delete = $(this).closest("[data-repeater-item]").index(); // Remove the Form validation for Deleted form in Repeater
      // validator.removeField('kt_question_repeater[' + index_delete + '][question]', questionValidators);

      var repeatlength = $('.repeat_items').length;
      var nextlength = parseInt(repeatlength) - 1;
      validator.removeField('kt_question_repeater[' + nextlength + '][question]', questionValidators);

      if (maxqstn_allowd > nextlength) {
        $('#addmore_question').show();
      } // Update the Question Index for Deleted form in Repeater


      $(".repeat_items").each(function (index) {
        if (index_delete >= index) {
          var indexid = parseInt(index_delete) + 1;
          var repeatname = 'kt_question_repeater[' + indexid + '][questionlabel]';
          var qstnindex = parseInt(index) + 1;
          $("[name='" + repeatname + "']").html('Question ' + qstnindex);
        }
      });
    });
    var maxqstn_allowd = $('#max_qtn_allowed').val();
    var repeatlength = $('.repeat_items').length;
    var nextlength = parseInt(repeatlength);

    if (nextlength >= maxqstn_allowd) {
      $('#addmore_question').hide();
    } // Append Question Index and Set Required fields for Repeater form fields


    $(".repeat_items").each(function (index) {
      var repeatname = 'kt_question_repeater[' + index + '][questionlabel]';
      var qstnindex = parseInt(index) + 1;
      $("[name='" + repeatname + "']").html('Question ' + qstnindex);

      if (index > 0) {
        validator.addField('kt_question_repeater[' + index + '][question]', questionValidators); // Min Max silder Initialization for Repeater form

        var current_index = index;
        var maxval = 'kt_question_repeater[' + current_index + '][maxval]';
        var minval = 'kt_question_repeater[' + current_index + '][minval]';
        var mintime_sec = 'kt_question_repeater[' + current_index + '][time_minsec]';
        var maxtime_min = 'kt_question_repeater[' + current_index + '][allowed_time_min]';
        var db_time_min = 'kt_question_repeater[' + current_index + '][db_time_min]';
        var db_time_sec = 'kt_question_repeater[' + current_index + '][db_time_sec]';
        var maxval_value = midend_val;
        var minval_value = 10;

        if ($("[name='" + db_time_min + "']").val() != '') {
          maxval_value = $("[name='" + db_time_min + "']").val();
        }

        if ($("[name='" + db_time_sec + "']").val() != '') {
          minval_value = $("[name='" + db_time_sec + "']").val();
        }

        var slider = document.getElementsByClassName("kt_slider_sizes_sm")[index];
        noUiSlider.create(slider, {
          start: [minval_value, maxval_value],
          // tooltips: [wNumb({decimals: 0}), true],
          connect: true,
          margin: 10,
          range: {
            "min": 0,
            "max": max_sec
          },
          step: 1,
          format: wNumb({
            decimals: 0
          })
        });
        slider.noUiSlider.on("update", function (values, handle) {
          if (handle) {
            var float_minutes = Math.floor(values[handle] / 60);
            var seconds = Math.floor(values[handle] % 60);

            if (seconds < 10) {
              seconds = "0" + seconds;
            }

            $("[name='" + maxtime_min + "']").val(float_minutes + ':' + seconds);
            $("[name='" + maxval + "']").html(float_minutes + ':' + seconds);
          } else {
            $("[name='" + minval + "']").html(values[handle]);
            $("[name='" + mintime_sec + "']").val(values[handle]);
          }
        });
      }
    });
  };

  var repeater = function repeater() {
    $('#kt_question_repeater').repeater({
      initEmpty: false,
      show: function show() {
        $(this).slideDown();
        KTDialer.createInstances();
      },
      hide: function hide(deleteElement) {
        $(this).slideUp(deleteElement);
      },
      isFirstItemUndeletable: true
    }); // First initialize the Min Max Slider

    progressbar();
  };

  var insertDefaultQuestion = function insertDefaultQuestion() {
    $(".insertqstn").on("click", function (e) {
      if ($('input[name="quesval"]').is(":checked")) {
        $('#save_hire').attr('data-kt-indicator', 'on');
        $('#save_hire').attr('disabled', 'true');
        var inputname = $('#repeatinput_name').val();
        var checked_question = $('input[name="quesval"]:checked').val();
        $("[name='" + inputname + "']").val(checked_question);
        setTimeout(function () {
          $('#save_hire').removeAttr('data-kt-indicator');
          $('#save_hire').removeAttr('disabled');
          $("#mdltemplate").modal('hide');
        }, 1000);
      } else {
        Swal.fire({
          text: "Please Select any one of your default question to insert",
          icon: "error",
          buttonsStyling: false,
          confirmButtonText: "Ok, got it!",
          customClass: {
            confirmButton: "btn btn-primary"
          }
        });
      }
    });
  }; // Public methods


  return {
    init: function init() {
      form = document.querySelector('#position_addfrm');
      submitButton = document.querySelector('#post_position_submit');
      draftButton = document.querySelector('#draft_position_submit');
      repeater();
      handleForm();
      insertDefaultQuestion();
    }
  };
}(); // On document ready


KTUtil.onDOMContentLoaded(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  KTDatatablesServerSide.init();
});
/******/ })()
;
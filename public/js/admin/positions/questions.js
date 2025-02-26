/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!****************************************************!*\
  !*** ./Resources/assets/js/positions/questions.js ***!
  \****************************************************/
 // Class definition

var KTDatatablesServerSide = function () {
  // Shared variables
  var table;
  var dt;
  var filterPayment;
  var validation;
  var addForm;
  var submitButton;
  var maxminValidators;
  var maxattemptsValidators;
  var questionValidators; // Shared variables
  // Private functions

  var initDatatable = function initDatatable() {
    dt = $("#kt_table_questions").DataTable({
      searchDelay: 500,
      processing: true,
      serverSide: true,
      order: [[1, 'desc']],
      stateSave: true,
      select: {
        style: 'multi',
        selector: 'td:first-child input[type="checkbox"]',
        className: 'row-selected'
      },
      ajax: {
        url: "/admin/loadquestions",
        data: function data(d) {
          d.position_id = $('#position_id').val();
        }
      },
      columns: [{
        data: 'id'
      }, {
        data: 'question'
      }, {
        data: 'allowed_attempts'
      }, {
        data: 'allowed_ans_time'
      }, {
        data: 'created_at'
      }, {
        data: null
      }],
      columnDefs: [{
        targets: 0,
        orderable: false,
        render: function render(data) {
          return "\n                            <div class=\"form-check form-check-sm form-check-custom form-check-solid\">\n                                <input class=\"form-check-input\" type=\"checkbox\" value=\"".concat(data, "\" />\n                            </div>");
        }
      }, {
        targets: -1,
        data: null,
        orderable: false,
        className: 'text-center',
        render: function render(data, type, row) {
          return row.actions;
        }
      }],
      // Add data-filter attribute
      createdRow: function createdRow(row, data, dataIndex) {
        $(row).find('td:eq(4)').attr('data-filter', data.CreditCardType);
      }
    });
    table = dt.$; // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw

    dt.on('draw', function () {
      initToggleToolbar();
      toggleToolbars(); // handleDeleteRows();

      KTMenu.createInstances();
    });
    dt.search('').draw();
  }; // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()


  var handleSearchDatatable = function handleSearchDatatable() {
    var filterSearch = document.querySelector('[data-kt-question-table-filter="search"]');
    filterSearch.addEventListener('keyup', function (e) {
      dt.search(e.target.value).draw();
    });
  }; // Filter Datatable


  var handleFilterDatatable = function handleFilterDatatable() {
    // Select filter options
    var filterForm = document.querySelector('[data-kt-question-table-filter="form"]');
    var filterButton = filterForm.querySelector('[data-kt-question-table-filter="filter"]');
    var selectOptions = filterForm.querySelectorAll('select'); // Filter datatable on submit

    filterButton.addEventListener('click', function () {
      // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
      dt.draw();
    });
  }; // Delete question


  var singleDelete = function singleDelete() {
    $(document).on("click", ".cfrmdelete", function (e) {
      var questionId = getquestionId($(this));
      swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        customClass: {
          confirmButton: "btn btn-warning",
          cancelButton: "btn btn-secondary"
        }
      }).then(function (result) {
        if (result.value) {
          $.ajax({
            url: "/admin/positions/qstndelete/" + questionId,
            type: "post",
            data: {
              '_method': "Post"
            },
            dataType: "json",
            success: function success(data) {
              swal.fire({
                title: 'Deleted!',
                text: 'Your selected records have been deleted!',
                type: 'success',
                icon: 'success',
                buttonsStyling: false,
                confirmButtonText: "OK",
                confirmButtonClass: "btn btn-primary"
              }).then(function (result) {
                location.reload();
              });
              dt.draw(); // delete row data from server and re-draw datatable
            }
          });
        }
      });
    });
  }; // Reset Filter


  var handleResetForm = function handleResetForm() {
    // Select reset button
    var resetButton = document.querySelector('[data-kt-question-table-filter="reset"]'); // Reset datatable

    resetButton.addEventListener('click', function () {
      // Select filter options
      var filterForm = document.querySelector('[data-kt-question-table-filter="form"]');
      var selectOptions = filterForm.querySelectorAll('select'); // Reset select2 values -- more info: https://select2.org/programmatic-control/add-select-clear-items

      selectOptions.forEach(function (select) {
        $(select).val('').trigger('change');
      }); // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()

      dt.search('').draw();
    });
  }; // Init toggle toolbar


  var initToggleToolbar = function initToggleToolbar() {
    // Toggle selected action toolbar
    // Select all checkboxes
    var container = document.querySelector('#kt_table_questions');
    var checkboxes = container.querySelectorAll('[type="checkbox"]'); // Select elements

    var deleteSelected = document.querySelector('[data-kt-question-table-select="delete_selected"]'); // Toggle delete selected toolbar

    checkboxes.forEach(function (c) {
      // Checkbox on click event
      c.addEventListener('click', function () {
        setTimeout(function () {
          toggleToolbars();
        }, 50);
      });
    });
  };

  var selectedDelete = function selectedDelete() {
    $('#kt_datatable_delete_all').on('click', function () {
      var checkboxes = document.querySelectorAll('[type="checkbox"]');
      var ids = [];
      checkboxes.forEach(function (c) {
        if (c.checked) {
          if (c.closest('tbody')) {
            ids.push(c.value);
          } // if(dt.row($(c.closest('tbody tr'))).data()!==undefined){
          //     console.log(dt.row($(c.closest('tbody tr td'))).data().id);
          // }

        }
      });

      if (ids.length > 0) {
        swal.fire({
          buttonsStyling: false,
          text: "Are you sure to delete " + ids.length + " selected records ?",
          type: "error",
          confirmButtonText: "Yes, delete!",
          confirmButtonClass: "btn btn-sm btn-bold btn-danger",
          showCancelButton: true,
          cancelButtonText: "No, cancel",
          cancelButtonClass: "btn btn-sm btn-bold btn-primary"
        }).then(function (result) {
          if (result.value) {
            $.ajax({
              url: "/admin/positions/questionmassdelete",
              method: "POST",
              data: {
                "id": ids
              },
              dataType: "json",
              success: function success(data) {
                if (data.success) {
                  swal.fire({
                    title: 'Deleted!',
                    text: 'Your selected records have been deleted!',
                    type: 'success',
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    confirmButtonClass: "btn btn-bold btn-primary"
                  }).then(function (result) {
                    location.reload();
                  });
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Permission Denied'
                  }).then(function (result) {
                    location.reload();
                  });
                } //   dt.draw(); // delete row data from server and re-draw datatable
                // window.location.replace('questions');

              }
            });
          }
        });
      }
    });
  };

  var updateStatus = function updateStatus() {
    $('#kt_datatable_group_action_form .menu-item').on('click', 'a', function (e) {
      var text = $.trim(this.text);
      if (text == 'New') var status = '1';else if (text == 'Completed') var status = '3';else var status = '2';
      var ids = [];
      var checkboxes = document.querySelectorAll('[type="checkbox"]');
      checkboxes.forEach(function (c) {
        if (c.checked) {
          if (c.closest('tbody')) {
            ids.push(c.value);
          } // if(dt.row($(c.closest('tbody tr'))).data()!==undefined){
          //     console.log(dt.row($(c.closest('tbody tr td'))).data().id);
          // }

        }
      });

      if (ids.length > 0) {
        swal.fire({
          buttonsStyling: false,
          text: "Are you sure to Update " + ids.length + " selected records ?",
          type: "error",
          confirmButtonText: "Yes, Update!",
          confirmButtonClass: "btn btn-sm btn-bold btn-danger",
          showCancelButton: true,
          cancelButtonText: "No, cancel",
          cancelButtonClass: "btn btn-sm btn-bold btn-primary"
        }).then(function (result) {
          if (result.value) {
            $.ajax({
              url: "questions/questionupdate",
              type: 'post',
              data: {
                "id": ids,
                "status": status
              },
              success: function success(data) {
                if (data.success) {
                  swal.fire({
                    title: 'Updated!',
                    text: 'Your selected records status have been Updated!',
                    type: 'success',
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    confirmButtonClass: "btn btn-sm btn-bold btn-primary"
                  }).then(function (result) {
                    window.location.replace('questions');
                  });
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Permission Denied'
                  }).then(function (result) {
                    window.location.replace('questions');
                  });
                } //   dt.draw(); // delete row data from server and re-draw datatable
                // window.location.replace('questions');

              }
            });
          } else {// window.location.replace('questions');
          }
        });
      }
    });
  };

  var updatepaymentStatus = function updatepaymentStatus() {
    $('#kt_datatable_paymentupdatestatus .menu-item').on('click', 'a', function (e) {
      var text = $.trim(this.text);
      if (text == 'Approved') var status = '1';else if (text == 'Pending') var status = '2';else if (text == 'Expired') var status = '3';else var status = '4';
      var ids = [];
      var checkboxes = document.querySelectorAll('[type="checkbox"]');
      checkboxes.forEach(function (c) {
        if (c.checked) {
          if (c.closest('tbody')) {
            ids.push(c.value);
          } // if(dt.row($(c.closest('tbody tr'))).data()!==undefined){
          //     console.log(dt.row($(c.closest('tbody tr td'))).data().id);
          // }

        }
      });

      if (ids.length > 0) {
        swal.fire({
          buttonsStyling: false,
          text: "Are you sure to Update the Payment status for" + ids.length + " selected records ?",
          type: "error",
          confirmButtonText: "Yes, Update!",
          confirmButtonClass: "btn btn-sm btn-bold btn-danger",
          showCancelButton: true,
          cancelButtonText: "No, cancel",
          cancelButtonClass: "btn btn-sm btn-bold btn-primary"
        }).then(function (result) {
          if (result.value) {
            $.ajax({
              url: "questions/questionupdatepayment",
              type: 'post',
              data: {
                "id": ids,
                "status": status
              },
              success: function success(data) {
                if (data.success) {
                  swal.fire({
                    title: 'Updated!',
                    text: 'Your selected records Payment status have been Updated!',
                    type: 'success',
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    confirmButtonClass: "btn btn-sm btn-bold btn-primary"
                  }).then(function (result) {
                    window.location.replace('questions');
                  });
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Permission Denied'
                  }).then(function (result) {
                    window.location.replace('questions');
                  });
                } //   dt.draw(); // delete row data from server and re-draw datatable
                // window.location.replace('questions');

              }
            });
          } else {// window.location.replace('questions');
          }
        });
      }
    });
  }; // Toggle toolbars


  var toggleToolbars = function toggleToolbars() {
    // Define variables
    var container = document.querySelector('#kt_table_questions');
    var toolbarBase = document.querySelector('[data-kt-question-table-toolbar="base"]');
    var toolbarSelected = document.querySelector('[data-kt-question-table-toolbar="selected"]'); // const selectedCount = document.querySelector('[data-kt-question-table-select="selected_count"]');
    // Select refreshed checkbox DOM elements

    var allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]'); // Detect checkboxes state & count

    var checkedState = false;
    var count = 0; // Count checked boxes

    allCheckboxes.forEach(function (c) {
      if (c.checked) {
        checkedState = true;
        count++;
      }
    }); // Toggle toolbars

    if (checkedState) {
      // selectedCount.innerHTML = count;
      toolbarBase.classList.add('d-none');
      toolbarSelected.classList.remove('d-none');
    } else {
      toolbarBase.classList.remove('d-none');
      toolbarSelected.classList.add('d-none');
    }
  };

  jQuery.validator.addMethod("phoneUS", function (phone_number, element) {
    phone_number = phone_number.replace(/\s+/g, "");
    return this.optional(element) || phone_number.length > 9 && phone_number.match(/^(\+?1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
  }, "Please specify a valid phone number");

  var validateForm = function validateForm() {
    $("#kt_modal_addedit_question_form").validate({
      errorClass: 'invalid-feedback',
      // define validation rules
      rules: {
        question: {
          required: true,
          normalizer: function normalizer(value) {
            return $.trim(value);
          }
        },
        max_attempts: {
          required: true,
          digits: true,
          remote: {
            url: "/admin/positions/checkmaxattempts",
            type: "post",
            data: {
              'max_qstn_attempts': function max_qstn_attempts() {
                return $('#max_qtn_attempt').val();
              },
              'addedit': '1'
            }
          }
        },
        max_minutes: {
          required: true,
          digits: true,
          remote: {
            url: "/admin/positions/checkmaxminutes",
            type: "post",
            data: {
              'max_qstn_min': function max_qstn_min() {
                return $('#max_qtn_min').val();
              },
              'addedit': '1'
            }
          }
        }
      },
      messages: {
        max_attempts: {
          digits: "Please give the valid no. of Attempts",
          remote: "Not Allowed Max of undefined attempts, Please check the package"
        },
        max_minutes: {
          digits: "Please give the valid no. of Minutes",
          remote: "Not Allowed Max of undefined Minutes, Please check the package"
        }
      },
      highlight: function highlight(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function unhighlight(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      },
      submitHandler: function submitHandler(form) {
        form.submit();
      }
    });
    questionValidators = {
      validators: {
        notEmpty: {
          message: ' '
        }
      }
    };
    maxattemptsValidators = {
      validators: {
        notEmpty: {
          message: ' '
        },
        regexp: {
          regexp: /^[0-9\s]+$/i,
          message: 'Please give the valid no. of Attempts'
        },
        remote: {
          message: 'Not Allowed Max of undefined attempts, Please check the package',
          method: 'POST',
          data: function data() {
            return {
              max_qstn_attempts: document.querySelector('[name="max_qtn_attempt"]').value
            };
          },
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: '/admin/positions/checkmaxattempts'
        }
      }
    };
    maxminValidators = {
      validators: {
        notEmpty: {
          message: ' '
        },
        regexp: {
          regexp: /^[0-9\s]+$/i,
          message: 'Please give the valid no. of Minutes'
        },
        remote: {
          message: 'Not Allowed Max of undefined Minutes, Please check the package',
          method: 'POST',
          data: function data() {
            return {
              max_qstn_min: document.querySelector('[name="max_qtn_min"]').value
            };
          },
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: '/admin/positions/checkmaxminutes'
        }
      }
    };
    validation = FormValidation.formValidation(addForm, {
      fields: {
        'kt_question_repeater[0][question]': questionValidators,
        'kt_question_repeater[0][max_attempts]': maxattemptsValidators,
        'kt_question_repeater[0][max_minutes]': maxminValidators
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        // Bootstrap Framework Integration
        submitButton: new FormValidation.plugins.SubmitButton(),
        bootstrap: new FormValidation.plugins.Bootstrap5({
          rowSelector: '.fv-row',
          eleInvalidClass: 'is-invalid',
          eleValidClass: '' // defaultMessageContainer: false,

        })
      }
    });
  };

  var getquestionId = function getquestionId(e) {
    return e.attr('data-questionid');
  }; // Add data


  var showAddform = function showAddform() {
    $("#btnadd_question").on("click", function (e) {
      $('#mdlquestion_add').modal({
        backdrop: 'static',
        keyboard: false
      });
      $('#mdlquestion_add').modal('show');
      selectDisableEnableOptions();
      var maxqstn_allowd = $('#max_qtn_allowed').val();
      var already_qstn_count = $('#already_qstn_count').val();
      var allowed = parseInt(maxqstn_allowd) - parseInt(already_qstn_count);
      var repeatlength_load = $('.repeat_items').length;
      var nextlength_load = parseInt(repeatlength_load);

      if (nextlength_load >= allowed) {
        $('#addmore_question').hide();
      }

      $("#addmore_question").on("click", function (e) {
        var repeatlength = $('.repeat_items').length;
        var nextlength = parseInt(repeatlength);

        if (nextlength >= allowed) {
          $('#addmore_question').hide();
        }

        console.log(repeatlength);
        $(".repeat_items").each(function (index) {
          console.log(index);

          if (index > 0) {
            validation.addField('kt_question_repeater[' + index + '][question]', questionValidators).addField('kt_question_repeater[' + index + '][max_attempts]', maxattemptsValidators).addField('kt_question_repeater[' + index + '][max_minutes]', maxminValidators);
          }
        });
      });
      $('#kt_question_repeater').on('click', '[data-repeater-delete]', function (event) {
        var index_delete = $(this).closest("[data-repeater-item]").index(); // validation.removeField('kt_question_repeater[' + index_delete + '][question]', questionValidators)
        // .removeField('kt_question_repeater[' + index_delete + '][max_attempts]', maxattemptsValidators)
        // .removeField('kt_question_repeater[' + index_delete + '][max_minutes]', maxminValidators);

        var repeatlength = $('.repeat_items').length;
        var nextlength = parseInt(repeatlength) - 1;
        validation.removeField('kt_question_repeater[' + nextlength + '][question]', questionValidators).removeField('kt_question_repeater[' + nextlength + '][max_attempts]', maxattemptsValidators).removeField('kt_question_repeater[' + nextlength + '][max_minutes]', maxminValidators);

        if (allowed > nextlength) {
          $('#addmore_question').show();
        }
      });
    });
  };

  var showEditform = function showEditform() {
    $(document).on("click", ".questionedit", function (e) {
      var question_id = getquestionId($(this));
      $('#kt_modal_addedit_question_form').attr('action', '/admin/positions/qstnupdate/' + question_id);
      $('#mdlquestion_addedit .modal-body').load('/admin/positions/qstnedit/' + question_id + '/edit', function () {
        $('#question_id').val(question_id);
        $('#mdlquestion_addedit').modal('show');
        selectDisableEnableOptions();
      });
    });
  };

  var repeater = function repeater() {
    $('#kt_question_repeater').repeater({
      initEmpty: false,
      show: function show() {
        $(this).slideDown();
      },
      hide: function hide(deleteElement) {
        $(this).slideUp(deleteElement);
      },
      isFirstItemUndeletable: true
    });
  };

  var handleForm = function handleForm() {
    submitButton.addEventListener('click', function (e) {
      // Validate form before change stepper step
      var validator = validation; // get validator for last form

      validator.validate().then(function (status) {
        console.log('validated!');

        if (status == 'Valid') {
          // Prevent default button action
          e.preventDefault(); // Disable button to avoid multiple click 

          submitButton.disabled = true; // Show loading indication

          submitButton.setAttribute('data-kt-indicator', 'on'); // Simulate form submission

          setTimeout(function () {
            addForm.submit(); // Hide loading indication

            submitButton.removeAttribute('data-kt-indicator'); // Enable button

            submitButton.disabled = false;
          }, 2000);
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
    });
  }; // Public methods


  return {
    init: function init() {
      addForm = document.querySelector('#kt_modal_add_question_form');
      submitButton = addForm.querySelector('[data-kt-questions-modal-action="submit"]');
      initDatatable();
      handleSearchDatatable();
      initToggleToolbar();
      handleFilterDatatable();
      handleResetForm();
      singleDelete();
      showAddform();
      showEditform();
      repeater();
      validateForm();
      selectedDelete();
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
  KTDatatablesServerSide.init();
  $.validator.messages.required = '';
  $('#close_button').click(function () {
    $('#kt_modal_addedit_question_form').trigger("reset"); //$('#mdlquestion_add').modal({show:false});

    $('#mdlquestion_addedit').modal('hide');
  });
  $('#add_close_button').click(function () {
    $('#kt_modal_add_question_form').trigger("reset"); //$('#mdlquestion_add').modal({show:false});

    $('#mdlquestion_add').modal('hide');
  });
  $('#kt_modal_export_questions').on('show.bs.modal', function () {
    var filterForm = document.querySelector('[data-kt-questions-modal-filter="form"]');
    var selectOptions = filterForm.querySelectorAll('select');
    selectOptions.forEach(function (select) {
      $(select).val('All').trigger('change');
    });
  });
});

function checkValset() {
  $(".check_status").on("change", function (e) {
    if ($('input[name="status_hidden"]').is(":checked")) {
      $('input[name="status"]').val('1');
    } else {
      $('input[name="status"]').val('0');
    }
  });
}

function selectDisableEnableOptions() {
  $('#employer_id').on('select2:select', function (e) {
    $("#position_id").prop("disabled", false);
  });
  $('#employer_id').on('select2:unselect', function (e) {
    $("#position_id").prop("disabled", true);
  });
  $('.setassessment').click(function () {
    var value = $(this).attr('data-assessment');
    $('#saveandsendlink').val(value);
  });
}
/******/ })()
;
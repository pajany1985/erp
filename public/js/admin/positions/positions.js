/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!****************************************************!*\
  !*** ./Resources/assets/js/positions/positions.js ***!
  \****************************************************/
 // Class definition

var KTDatatablesServerSide = function () {
  // Shared variables
  var table;
  var dt;
  var filterPayment; // Shared variables
  // Private functions

  var initDatatable = function initDatatable() {
    dt = $("#kt_table_positions").DataTable({
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
        url: "/admin/loadpositions",
        data: function data(d) {
          d.status = $('#status').val();
        }
      },
      columns: [{
        data: 'id'
      }, {
        data: 'name'
      }, {
        data: 'employer.first_name'
      }, {
        data: 'status'
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
        targets: 3,
        orderable: false,
        render: function render(data, type, row) {
          var status = {
            1: {
              'title': 'Active',
              'class': ' badge-light-success'
            },
            0: {
              'title': 'In Active',
              'class': ' badge-light-danger'
            }
          };
          return '<div class="badge ' + status[row.status]["class"] + ' fw-bolder">' + status[row.status].title + '</div>';
        }
      }, {
        targets: -1,
        data: null,
        orderable: false,
        className: 'text-end',
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
    var filterSearch = document.querySelector('[data-kt-position-table-filter="search"]');
    filterSearch.addEventListener('keyup', function (e) {
      dt.search(e.target.value).draw();
    });
  }; // Filter Datatable


  var handleFilterDatatable = function handleFilterDatatable() {
    // Select filter options
    var filterForm = document.querySelector('[data-kt-position-table-filter="form"]');
    var filterButton = filterForm.querySelector('[data-kt-position-table-filter="filter"]');
    var selectOptions = filterForm.querySelectorAll('select'); // Filter datatable on submit

    filterButton.addEventListener('click', function () {
      // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
      dt.draw();
    });
  }; // Delete position


  var singleDelete = function singleDelete() {
    $(document).on("click", ".cfrmdelete", function (e) {
      var positionId = getpositionId($(this));
      swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!"
      }).then(function (result) {
        if (result.value) {
          $.ajax({
            url: "positions/" + positionId,
            type: "post",
            data: {
              '_method': "delete"
            },
            dataType: "json",
            success: function success(data) {
              swal.fire({
                title: 'Deleted!',
                text: 'Your selected records have been deleted!',
                type: 'success',
                buttonsStyling: false,
                confirmButtonText: "OK",
                confirmButtonClass: "btn  btn-bold btn-primary"
              }); // dt.draw(); // delete row data from server and re-draw datatable

              window.location.replace('positions');
            }
          });
        }
      });
    });
  }; // Reset Filter


  var handleResetForm = function handleResetForm() {
    // Select reset button
    var resetButton = document.querySelector('[data-kt-position-table-filter="reset"]'); // Reset datatable

    resetButton.addEventListener('click', function () {
      // Select filter options
      var filterForm = document.querySelector('[data-kt-position-table-filter="form"]');
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
    var container = document.querySelector('#kt_table_positions');
    var checkboxes = container.querySelectorAll('[type="checkbox"]'); // Select elements

    var deleteSelected = document.querySelector('[data-kt-position-table-select="delete_selected"]'); // Toggle delete selected toolbar

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
              url: "positions/positionmassdelete",
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
                    confirmButtonClass: "btn  btn-bold btn-primary"
                  }).then(function (result) {
                    window.location.replace('positions');
                  });
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Permission Denied'
                  }).then(function (result) {
                    window.location.replace('positions');
                  });
                } //   dt.draw(); // delete row data from server and re-draw datatable
                // window.location.replace('positions');

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
      if (text == 'Active') var status = '1';else var status = '0';
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
              url: "positions/positionupdate",
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
                    window.location.replace('positions');
                  });
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Permission Denied'
                  }).then(function (result) {
                    window.location.replace('positions');
                  });
                } //   dt.draw(); // delete row data from server and re-draw datatable
                // window.location.replace('positions');

              }
            });
          } else {// window.location.replace('positions');
          }
        });
      }
    });
  }; // Toggle toolbars


  var toggleToolbars = function toggleToolbars() {
    // Define variables
    var container = document.querySelector('#kt_table_positions');
    var toolbarBase = document.querySelector('[data-kt-position-table-toolbar="base"]');
    var toolbarSelected = document.querySelector('[data-kt-position-table-toolbar="selected"]'); // const selectedCount = document.querySelector('[data-kt-position-table-select="selected_count"]');
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
    $("#kt_modal_edit_position_form").validate({
      errorClass: 'invalid-feedback',
      // define validation rules
      rules: {
        name: {
          required: true,
          normalizer: function normalizer(value) {
            return $.trim(value);
          }
        },
        position_description: {
          required: true
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
      submitHandler: function submitHandler(form) {
        form.submit(); // submit the form
      }
    });
  };

  var getpositionId = function getpositionId(e) {
    return e.attr('data-positionid');
  };

  var showEditform = function showEditform() {
    $(document).on("click", ".positionedit", function (e) {
      var position_id = getpositionId($(this));
      $('#kt_modal_edit_position_form').attr('action', 'positions/' + position_id);
      $('#mdlposition_edit .modal-body').load('positions/' + position_id + '/edit', function () {
        $('#position_id').val(position_id);
        $('#mdlposition_edit').modal('show');
        var empid = $('#editempid').val();
        checkValset();
      });
    });
  }; // var showmangeQuestion = function() {
  //     $(document).on("click", ".questionlist", function(e) {
  //     });
  // }
  //  Export  functions


  var exportclick = function exportclick() {
    var submitButton = document.querySelector('[data-kt-positions-modal-action="export_submit"]');
    $(document).on("click", ".export_submit", function (e) {
      $('.export_submit').submit();
      $('#kt_modal_export_positions').modal('hide');
    });
  }; // Export function end


  var copyurl = function copyurl() {
    // Select element
    var clipboard;
    var target = document.getElementById($(this).attr('id')); // Init clipboard -- for more info, please read the offical documentation: https://clipboardjs.com/

    clipboard = new ClipboardJS('.kt_clipboard_3');
    clipboard.on('success', function (e) {
      var _e$trigger$classList;

      var button = e.trigger;
      var currentLabel = e.trigger.innerHTML;
      var checkIcon = button.querySelector('.bi.bi-check');
      var svgIcon = button.querySelector('.svg-icon'); // Exit check icon when already showing

      if (checkIcon) {
        return;
      } // Create check icon


      checkIcon = document.createElement('i');
      checkIcon.classList.add('bi');
      checkIcon.classList.add('bi-check');
      checkIcon.classList.add('fs-2x'); // Append check icon

      button.appendChild(checkIcon); // Highlight target

      var classes = ['text-success', 'fw-boldest'];

      (_e$trigger$classList = e.trigger.classList).add.apply(_e$trigger$classList, classes); // Highlight button


      button.classList.add('btn-success'); // removeprimary_class

      button.classList.remove('btn-active-color-primary'); // Hide copy icon

      svgIcon.classList.add('d-none'); // Revert button label after 3 seconds

      setTimeout(function () {
        var _e$trigger$classList2;

        // Remove check icon
        svgIcon.classList.remove('d-none'); // Revert icon

        button.removeChild(checkIcon); // Remove target highlight

        (_e$trigger$classList2 = e.trigger.classList).remove.apply(_e$trigger$classList2, classes); // Remove button highlight


        button.classList.remove('btn-success');
        button.classList.add('btn-active-color-primary');
      }, 2000);
      e.clearSelection();
    });
  }; // Public methods


  return {
    init: function init() {
      initDatatable();
      handleSearchDatatable();
      initToggleToolbar();
      handleFilterDatatable();
      handleResetForm();
      singleDelete();
      showEditform();
      validateForm();
      exportclick();
      selectedDelete();
      updateStatus();
      copyurl();
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
    $('#kt_modal_add_position_form').trigger("reset"); //$('#mdlposition_add').modal({show:false});

    $('#mdlposition_add').modal('hide');
  });
  $('#kt_modal_export_positions').on('show.bs.modal', function () {
    var filterForm = document.querySelector('[data-kt-positions-modal-filter="form"]');
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
/******/ })()
;
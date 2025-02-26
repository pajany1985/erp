/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!**************************************************!*\
  !*** ./Resources/assets/js/packages/packages.js ***!
  \**************************************************/
 // Class definition

var KTDatatablesServerSide = function () {
  // Shared variables
  var table;
  var dt;
  var filterPayment; // Shared variables
  // Private functions

  var initDatatable = function initDatatable() {
    dt = $("#kt_table_packages").DataTable({
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
        url: "/admin/loadpackages",
        data: function data(d) {
          d.status = $('#status').val();
        }
      },
      columns: [{
        data: 'id'
      }, {
        data: 'name'
      }, {
        data: 'expiry_in_days'
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
    var filterSearch = document.querySelector('[data-kt-user-table-filter="search"]');
    filterSearch.addEventListener('keyup', function (e) {
      dt.search(e.target.value).draw();
    });
  }; // Filter Datatable


  var handleFilterDatatable = function handleFilterDatatable() {
    // Select filter options
    var filterForm = document.querySelector('[data-kt-user-table-filter="form"]');
    var filterButton = filterForm.querySelector('[data-kt-user-table-filter="filter"]');
    var selectOptions = filterForm.querySelectorAll('select'); // Filter datatable on submit

    filterButton.addEventListener('click', function () {
      var filterString = ''; // console.log(selectOptions);
      // Get filter values

      selectOptions.forEach(function (item, index) {
        if (item.value && item.value !== '') {
          if (index !== 0) {
            filterString += ' ';
          } // Build filter value options


          filterString += item.value;
        }
      }); // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()

      dt.search(filterString).draw();
    });
  }; // Delete user


  var singleDelete = function singleDelete() {
    $(document).on("click", ".cfrmdelete", function (e) {
      var userId = getpackageId($(this));
      swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!"
      }).then(function (result) {
        if (result.value) {
          $.ajax({
            url: "packages/" + userId,
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
              });
              dt.search('').draw();
              ; // delete row data from server and re-draw datatable
            }
          });
        }
      });
    });
  }; // Reset Filter


  var handleResetForm = function handleResetForm() {
    // Select reset button
    var resetButton = document.querySelector('[data-kt-user-table-filter="reset"]'); // Reset datatable

    resetButton.addEventListener('click', function () {
      // Select filter options
      var filterForm = document.querySelector('[data-kt-user-table-filter="form"]');
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
    var container = document.querySelector('#kt_table_packages');
    var checkboxes = container.querySelectorAll('[type="checkbox"]'); // Select elements

    var deleteSelected = document.querySelector('[data-kt-user-table-select="delete_selected"]'); // Toggle delete selected toolbar

    checkboxes.forEach(function (c) {
      // Checkbox on click event
      c.addEventListener('click', function () {
        setTimeout(function () {
          toggleToolbars();
        }, 50);
      });
    });
  }; // Toggle toolbars


  var toggleToolbars = function toggleToolbars() {
    // Define variables
    var container = document.querySelector('#kt_table_packages');
    var toolbarBase = document.querySelector('[data-kt-package-table-toolbar="base"]');
    var toolbarSelected = document.querySelector('[data-kt-package-table-toolbar="selected"]');
    var selectedCount = document.querySelector('[data-kt-package-table-select="selected_count"]'); // Select refreshed checkbox DOM elements

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
      selectedCount.innerHTML = count;
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
    $("#kt_modal_add_user_form").validate({
      errorClass: 'invalid-feedback',
      // define validation rules
      rules: {
        name: {
          required: true,
          normalizer: function normalizer(value) {
            return $.trim(value);
          }
        },
        email: {
          required: true,
          email: true,
          remote: {
            url: "emailvalidate",
            type: "post",
            data: {
              'id': function id() {
                return $('#user_id').val();
              }
            }
          },
          normalizer: function normalizer(value) {
            return $.trim(value);
          }
        },
        role_id: {
          required: true
        },
        user_name: {
          required: true,
          remote: {
            url: "usernamevalidate",
            type: "post",
            data: {
              'id': function id() {
                return $('#user_id').val();
              }
            }
          },
          normalizer: function normalizer(value) {
            return $.trim(value);
          }
        },
        password: {
          required: true,
          normalizer: function normalizer(value) {
            return $.trim(value);
          }
        },
        phoneno: {
          required: true,
          phoneUS: true,
          normalizer: function normalizer(value) {
            return $.trim(value);
          }
        }
      },
      messages: {
        user_name: {
          remote: "Username already exists"
        },
        email: {
          remote: "Email already exists"
        }
      },
      highlight: function highlight(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function unhighlight(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      },
      submitHandler: function submitHandler(form) {
        form.submit(); // submit the form
      }
    });
  };

  var getpackageId = function getpackageId(e) {
    return e.attr('data-packageid');
  }; // Add data


  var showAddform = function showAddform() {
    $("#btnadd_user").on("click", function (e) {
      $('#mdluser_add .modal-body').load('users/create', function () {
        $('#mdluser_add').modal('show');
        $('input[name="password"]').rules('add', {
          required: true
        }); //  var avatar1 = new KTImageInput('kt_image_1');

        var imageInputElement = document.querySelector("#kt_image_input_control");
        var imageInput = new KTImageInput(imageInputElement);
        checkValset();
      });
    });
  };

  var showEditform = function showEditform() {
    $(document).on("click", ".packageedit", function (e) {
      var package_id = getpackageId($(this));
      document.location.href = 'packages/' + package_id + '/edit';
    });
  }; //  Export  functions


  var exportclick = function exportclick() {
    var submitButton = document.querySelector('[data-kt-packages-modal-action="export_submit"]');
    $(document).on("click", ".export_submit", function (e) {
      $('.export_submit').submit();
      $('#kt_modal_export_packages').modal('hide');
    });
  }; // Export function end


  var selectedDelete = function selectedDelete() {
    $('#kt_datatable_delete_all').on('click', function () {
      var checkboxes = document.querySelectorAll('[type="checkbox"]');
      var ids = [];
      checkboxes.forEach(function (c) {
        if (c.checked) {
          if (c.closest('tbody')) {
            ids.push(c.value);
          }
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
              url: "packages/packagemassdelete",
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
                    window.location.replace('packages');
                  });
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Permission Denied'
                  }).then(function (result) {
                    window.location.replace('packages');
                  });
                } //   dt.draw(); // delete row data from server and re-draw datatable

              }
            });
          }
        });
      }
    });
  };

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
      showAddform();
      showEditform();
      validateForm();
      exportclick();
      selectedDelete();
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
  $('#kt_modal_export_users').on('show.bs.modal', function () {
    var filterForm = document.querySelector('[data-kt-users-modal-filter="form"]');
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
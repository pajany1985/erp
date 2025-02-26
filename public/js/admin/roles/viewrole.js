/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!***********************************************!*\
  !*** ./Resources/assets/js/roles/viewrole.js ***!
  \***********************************************/
 // Class definition

var KTDatatablesServerSide = function () {
  // Shared variables
  var table;
  var dt;
  var filterPayment; // Shared variables
  // Private functions

  var initDatatable = function initDatatable() {
    dt = $("#kt_table_users").DataTable({
      searchDelay: 500,
      processing: true,
      serverSide: true,
      order: [[4, 'desc']],
      stateSave: true,
      ajax: {
        url: "/admin/loadusers",
        data: function data(d) {
          d.role_search = $('#role').val();
        }
      },
      columns: [{
        data: 'name'
      }, {
        data: 'email'
      }, {
        data: 'username'
      }, {
        data: 'status'
      }, {
        data: 'created_at'
      }],
      columnDefs: [// {
        //     targets: 0,
        //     orderable: false,
        //     render: function (data) {
        //         return `
        //             <div class="form-check form-check-sm form-check-custom form-check-solid">
        //                 <input class="form-check-input" type="checkbox" value="${data}" />
        //             </div>`;
        //     }
        // },
        // {
        //     targets: 5,
        //     orderable: false,
        //     render: function (data, type, row) {
        //         var status = {
        //             1: {'title': 'Active', 'class': ' badge-light-success'},
        //             0: {'title': 'In Active', 'class': ' badge-light-danger'},
        //         };
        //         return '<div class="badge ' + status[row.status].class +  ' fw-bolder">' + status[row.status].title +'</div>';
        //     }
        // },
        // {
        //     targets: -1,
        //     data: null,
        //     orderable: false,
        //     className: 'text-end',
        //     render: function (data, type, row) {
        //         return row.actions;  
        //     },
        // },
      ] // Add data-filter attribute
      // createdRow: function (row, data, dataIndex) {
      //     $(row).find('td:eq(4)').attr('data-filter', data.CreditCardType);
      // }

    });
    table = dt.$; // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw

    dt.on('draw', function () {
      initToggleToolbar();
      toggleToolbars();
      KTMenu.createInstances();
    });
    dt.search('').draw();
  }; //Search Datatable --- official docs reference: https://datatables.net/reference/api/search()


  var handleSearchDatatable = function handleSearchDatatable() {
    var filterSearch = document.querySelector('[data-kt-roles-table-filter="search"]');
    filterSearch.addEventListener('keyup', function (e) {
      dt.search(e.target.value).draw();
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
    var container = document.querySelector('#kt_table_users');
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
    var container = document.querySelector('#kt_table_users');
    var toolbarBase = document.querySelector('[data-kt-view-roles-table-toolbar="base"]');
    var toolbarSelected = document.querySelector('[data-kt-view-roles-table-toolbar="selected"]'); // const selectedCount = document.querySelector('[data-kt-user-table-select="selected_count"]');
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
  }; // Public methods


  return {
    init: function init() {
      initDatatable();
      handleSearchDatatable();
      initToggleToolbar();
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
    $('#kt_modal_add_user_form').trigger("reset"); //$('#mdluser_add').modal({show:false});

    $('#mdluser_add').modal('hide');
  });
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
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!**************************************************************!*\
  !*** ./Resources/assets/js/employers/employertransaction.js ***!
  \**************************************************************/
 // Class definition

var KTDatatablesServerSide = function () {
  // Shared variables
  var table;
  var dt;
  var filterPayment; // Shared variables
  // Private functions

  var initDatatable = function initDatatable() {
    dt = $("#kt_table_trans").DataTable({
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
        url: "/admin/loademployertransactions",
        data: function data(d) {
          d.employer_search = $('#employer_id').val(), d.status = $('#statustrans').val();
        }
      },
      columns: [{
        data: 'package.name'
      }, {
        data: 'amount'
      }, {
        data: 'transaction_id'
      }, {
        data: 'status'
      }, {
        data: 'paid_date'
      }],
      columnDefs: [{
        targets: 3,
        orderable: false,
        render: function render(data, type, row) {
          var status = {
            0: {
              'title': 'Failure',
              'class': ' badge-light-danger'
            },
            1: {
              'title': 'Success',
              'class': 'badge-light-success'
            } // 3: {'title': 'Completed', 'class': ' badge-light-success'},

          };
          return '<div class="badge ' + status[row.status]["class"] + ' fw-bolder">' + status[row.status].title + '</div>';
        }
      }],
      // Add data-filter attribute
      createdRow: function createdRow(row, data, dataIndex) {
        $(row).find('td:eq(4)').attr('data-filter', data.CreditCardType);
      }
    });
    table = dt.$; // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw

    dt.on('draw', function () {
      // handleDeleteRows();
      KTMenu.createInstances();
    });
    dt.search('').draw();
  }; // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()


  var handleSearchDatatable = function handleSearchDatatable() {
    var filterSearch = document.querySelector('[data-kt-trans-table-filter="search"]');
    filterSearch.addEventListener('keyup', function (e) {
      dt.search(e.target.value).draw();
    });
  }; // Filter Datatable


  var handleFilterDatatable = function handleFilterDatatable() {
    // Select filter options
    var filterForm = document.querySelector('[data-kt-trans-table-filter="form"]');
    var filterButton = filterForm.querySelector('[data-kt-trans-table-filter="filter"]');
    var selectOptions = filterForm.querySelectorAll('select'); // Filter datatable on submit

    filterButton.addEventListener('click', function () {
      // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
      dt.draw();
    });
  }; // Delete user
  // Reset Filter


  var handleResetForm = function handleResetForm() {
    // Select reset button
    var resetButton = document.querySelector('[data-kt-trans-table-filter="reset"]'); // Reset datatable

    resetButton.addEventListener('click', function () {
      // Select filter options
      var filterForm = document.querySelector('[data-kt-trans-table-filter="form"]');
      var selectOptions = filterForm.querySelectorAll('select'); // Reset select2 values -- more info: https://select2.org/programmatic-control/add-select-clear-items

      selectOptions.forEach(function (select) {
        $(select).val('').trigger('change');
      }); // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()

      dt.search('').draw();
    });
  };

  var getuserId = function getuserId(e) {
    return e.attr('data-userid');
  }; //  Export  functions
  // var exportclick = function(){
  //     const submitButton = document.querySelector('[data-kt-users-modal-action="export_submit"]');
  //     $(document).on("click", ".export_submit", function(e) {
  //         $('.export_submit').submit();
  //         $('#kt_modal_export_users').modal('hide');
  //     });
  // }
  // Export function end
  // Public methods


  return {
    init: function init() {
      initDatatable();
      handleSearchDatatable();
      handleFilterDatatable();
      handleResetForm();
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
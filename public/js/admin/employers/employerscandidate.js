/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!*************************************************************!*\
  !*** ./Resources/assets/js/employers/employerscandidate.js ***!
  \*************************************************************/
 // Class definition

var KTDatatablesServerSide = function () {
  // Shared variables
  var table;
  var dt;
  var filterPayment; // Shared variables
  // Private functions

  var initDatatable = function initDatatable() {
    dt = $("#kt_table_candidates").DataTable({
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
        url: "/admin/loademployercandidates",
        data: function data(d) {
          d.employer_search = $('#employer_id').val(), d.status = $('#status').val();
        }
      },
      columns: [{
        data: 'first_name'
      }, {
        data: 'email'
      }, {
        data: 'position.name'
      }, {
        data: 'status'
      }, {
        data: 'created_at'
      }],
      columnDefs: [{
        targets: 0,
        // data: 'creator',
        orderable: false,
        render: function render(data, type, row) {
          var lname = '';

          if (row.first_name != null) {
            if (row.last_name != null) {
              lname = row.last_name;
            }

            return row.first_name + ' ' + lname;
          }

          return "<span>N/A</span>";
        }
      }, {
        targets: 3,
        orderable: false,
        render: function render(data, type, row) {
          var status = {
            1: {
              'title': 'New',
              'class': ' badge-secondary'
            },
            2: {
              'title': 'In Progress',
              'class': ' badge-light-primary'
            },
            3: {
              'title': 'Completed',
              'class': ' badge-light-success'
            },
            4: {
              'title': 'Hired',
              'class': ' badge-light-warning'
            },
            5: {
              'title': 'Archived',
              'class': ' badge-light-danger'
            }
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
      //  initToggleToolbar();
      KTMenu.createInstances();
    });
    dt.search('').draw();
  }; // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()


  var handleSearchDatatable = function handleSearchDatatable() {
    var filterSearch = document.querySelector('[data-kt-candidate-table-filter="search"]');
    filterSearch.addEventListener('keyup', function (e) {
      dt.search(e.target.value).draw();
    });
  };

  var handleFilterDatatable = function handleFilterDatatable() {
    // Select filter options
    var filterForm = document.querySelector('[data-kt-candidate-table-filter="form"]');
    var filterButton = filterForm.querySelector('[data-kt-candidate-table-filter="filter"]');
    var selectOptions = filterForm.querySelectorAll('select'); // Filter datatable on submit

    filterButton.addEventListener('click', function () {
      // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
      dt.draw();
    });
  }; // Reset Filter


  var handleResetForm = function handleResetForm() {
    // Select reset button
    var resetButton = document.querySelector('[data-kt-candidate-table-filter="reset"]'); // Reset datatable

    resetButton.addEventListener('click', function () {
      // Select filter options
      var filterForm = document.querySelector('[data-kt-candidate-table-filter="form"]');
      var selectOptions = filterForm.querySelectorAll('select'); // Reset select2 values -- more info: https://select2.org/programmatic-control/add-select-clear-items

      selectOptions.forEach(function (select) {
        $(select).val('').trigger('change');
      }); // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()

      dt.search('').draw();
    });
  };

  var getcandidateId = function getcandidateId(e) {
    return e.attr('data-candidateid');
  }; // Public methods


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
  $.validator.messages.required = '';
  $('#close_button').click(function () {
    $('#kt_modal_add_candidate_form').trigger("reset"); //$('#mdlcandidate_add').modal({show:false});

    $('#mdlcandidate_add').modal('hide');
  });
  $('#kt_modal_export_candidates').on('show.bs.modal', function () {
    var filterForm = document.querySelector('[data-kt-candidates-modal-filter="form"]');
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
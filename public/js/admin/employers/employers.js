/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!****************************************************!*\
  !*** ./Resources/assets/js/employers/employers.js ***!
  \****************************************************/
 // Class definition

var KTDatatablesServerSide = function () {
  // Shared variables
  var table;
  var dt;
  var filterPayment;
  var overlaytarget = document.querySelector("#commentlist");
  var overlayblockUI = new KTBlockUI(overlaytarget, {
    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span><span class="process_content">Processing Video</span></div>'
  }); // Export function end
  // Shared variables
  // Private functions

  var initDatatable = function initDatatable() {
    dt = $("#kt_table_employers").DataTable({
      searchDelay: 500,
      processing: true,
      serverSide: true,
      order: [[6, 'desc']],
      stateSave: true,
      select: {
        style: 'multi',
        selector: 'td:first-child input[type="checkbox"]',
        className: 'row-selected'
      },
      ajax: {
        url: "/admin/loademployers",
        data: function data(d) {
          d.package_search = $('#package').val(), d.status = $('#status').val(), d.payment_status = $('#payment_status').val();
          d.storage_percentage = $('#storage_percentage').val();
        }
      },
      columns: [{
        data: 'id'
      }, {
        data: 'first_name'
      }, {
        data: 'package.name'
      }, {
        data: 'payment_status'
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
          return "\n                    <div class=\"form-check form-check-sm form-check-custom form-check-solid\">\n                    <input class=\"form-check-input\" type=\"checkbox\" value=\"".concat(data, "\" />\n                    </div>");
        }
      }, {
        targets: 1,
        data: 'creator',
        className: 'd-flex align-items-center',
        render: function render(data, type, row) {
          if (row.company_logo != null && row.company_logo != '') {
            return '<div class="symbol symbol-circle symbol-50px overflow-hidden me-3"><a href="#"><div class="symbol-label"><img src="/uploads/employers/company_logo/' + row.company_logo + '" alt="' + row.first_name + '" class="w-100" /></div> </a> </div><div class="d-flex flex-column"><a href="employers/' + row.encrypt_id + '" class="text-gray-800 text-hover-primary mb-1">' + row.first_name + ' ' + row.last_name + '</a><span>' + row.email + '</span></div>';
          } else {
            return '<div class="symbol symbol-circle symbol-50px overflow-hidden me-3"><a href="#"> <div class="symbol-label fs-3 bg-light-danger text-danger">' + row.first_name.charAt(0) + row.last_name.charAt(0) + '</div> </a></div><div class="d-flex flex-column"><a href="employers/' + row.encrypt_id + '" class="text-gray-800 text-hover-primary mb-1">' + row.first_name + ' ' + row.last_name + '</a><span>' + row.email + '</span></div>';
          }
        }
      }, // {
      //     targets: 3,
      //     data: null,
      //     orderable: false,
      //     render: function (data, type, row) {
      //         return row.emp_storage;
      //     }
      // },
      // {
      //     targets:3,
      //     data: 'creator',
      //     render: function (data, type, row) {
      //         if(row.last_login != null){
      //         var date1 = new Date(row.last_login);
      //         var date2 = new Date();
      //         var timeDiff = Math.abs(date2.getTime() - date1.getTime());
      //         var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
      //             if(diffDays ==1 ){
      //                 return '<div class="badge badge-light fw-bolder">Today</div>';
      //             }else if(diffDays ==2 ){
      //                 return '<div class="badge badge-light fw-bolder">Yesterday</div>';
      //             }else{
      //                 return '<div class="badge badge-light fw-bolder">'+diffDays+' days ago</div>';
      //             }
      //         }else{
      //             return '<div class=" text-center">--</div>';
      //         } 
      //        }
      //    },
      {
        targets: 3,
        orderable: false,
        render: function render(data, type, row) {
          var status = {
            1: {
              'title': 'Approved',
              'class': ' badge-light-success'
            },
            2: {
              'title': 'Pending',
              'class': ' badge-light-warning'
            },
            3: {
              'title': 'Expired',
              'class': ' badge-light-dark'
            },
            4: {
              'title': 'Rejected',
              'class': ' badge-light-danger'
            }
          };
          return '<div class="badge ' + status[row.payment_status]["class"] + ' fw-bolder">' + status[row.payment_status].title + '</div>';
        }
      }, {
        targets: 4,
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
        className: 'text-center',
        render: function render(data, type, row) {
          return row.actions;
        }
      }] // Add data-filter attribute
      // createdRow: function (row, data, dataIndex) {
      //     $(row).find('td:eq(4)').attr('data-filter', data.CreditCardType);
      // }

    });
    table = dt.$; // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw

    dt.on('draw', function () {
      initToggleToolbar();
      toggleToolbars(); // handleDeleteRows();

      KTMenu.createInstances();
    }); // dt.search('').draw();
  }; // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()


  var handleSearchDatatable = function handleSearchDatatable() {
    var filterSearch = document.querySelector('[data-kt-employer-table-filter="search"]');
    filterSearch.addEventListener('keyup', function (e) {
      dt.search(e.target.value).draw();
    });
  }; // Filter Datatable


  var handleFilterDatatable = function handleFilterDatatable() {
    // Select filter options
    var filterForm = document.querySelector('[data-kt-employer-table-filter="form"]');
    var filterButton = filterForm.querySelector('[data-kt-employer-table-filter="filter"]');
    var selectOptions = filterForm.querySelectorAll('select'); // Filter datatable on submit

    filterButton.addEventListener('click', function () {
      var package_search = $('#package').val();
      var status = $('#status').val();
      var payment_status = $('#payment_status').val();
      var storage_percentage = $('#storage_percentage').val();
      $.ajax({
        url: "employers/empfiltersession",
        type: "post",
        data: {
          'package_search': package_search,
          'status': status,
          'payment_status': payment_status,
          'storage_percentage': storage_percentage
        },
        dataType: "json",
        success: function success(data) {
          dt.draw();
        }
      }); // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
      //   dt.draw();
    });
  }; //auto login


  var autologin = function autologin() {
    $(document).on("click", ".autologin", function (e) {
      var employerId = getemployerId($(this));
      window.open('/employer/appautologin/' + employerId);
    });
  }; // Delete employer


  var singleDelete = function singleDelete() {
    $(document).on("click", ".cfrmdelete", function (e) {
      var employerId = getemployerId($(this));
      swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!"
      }).then(function (result) {
        if (result.value) {
          $.ajax({
            url: "employers/" + employerId,
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
              dt.draw(); // delete row data from server and re-draw datatable
              // window.location.replace('employers');
            }
          });
        }
      });
    });
  }; // Reset Filter


  var handleResetForm = function handleResetForm() {
    // Select reset button
    var resetButton = document.querySelector('[data-kt-employer-table-filter="reset"]'); // Reset datatable

    resetButton.addEventListener('click', function () {
      // Select filter options
      var filterForm = document.querySelector('[data-kt-employer-table-filter="form"]');
      var selectOptions = filterForm.querySelectorAll('select'); // Reset select2 values -- more info: https://select2.org/programmatic-control/add-select-clear-items

      selectOptions.forEach(function (select) {
        $(select).val('').trigger('change');
      });
      $.ajax({
        url: "employers/empresetsession",
        type: "post",
        dataType: "json",
        success: function success(data) {
          dt.search('').draw();
        }
      }); // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()
      // dt.search('').draw();
    });
  }; // Init toggle toolbar


  var initToggleToolbar = function initToggleToolbar() {
    // Toggle selected action toolbar
    // Select all checkboxes
    var container = document.querySelector('#kt_table_employers');
    var checkboxes = container.querySelectorAll('[type="checkbox"]'); // Select elements

    var deleteSelected = document.querySelector('[data-kt-employer-table-select="delete_selected"]'); // Toggle delete selected toolbar

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
              url: "employers/employermassdelete",
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
                    window.location.replace('employers');
                  });
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Permission Denied'
                  }).then(function (result) {
                    window.location.replace('employers');
                  });
                } //   dt.draw(); // delete row data from server and re-draw datatable
                // window.location.replace('employers');

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
              url: "employers/employerupdate",
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
                    window.location.replace('employers');
                  });
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Permission Denied'
                  }).then(function (result) {
                    window.location.replace('employers');
                  });
                } //   dt.draw(); // delete row data from server and re-draw datatable
                // window.location.replace('employers');

              }
            });
          } else {// window.location.replace('employers');
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
              url: "employers/employerupdatepayment",
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
                    window.location.replace('employers');
                  });
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Permission Denied'
                  }).then(function (result) {
                    window.location.replace('employers');
                  });
                } //   dt.draw(); // delete row data from server and re-draw datatable
                // window.location.replace('employers');

              }
            });
          } else {// window.location.replace('employers');
          }
        });
      }
    });
  }; // Toggle toolbars


  var toggleToolbars = function toggleToolbars() {
    // Define variables
    var container = document.querySelector('#kt_table_employers');
    var toolbarBase = document.querySelector('[data-kt-employer-table-toolbar="base"]');
    var toolbarSelected = document.querySelector('[data-kt-employer-table-toolbar="selected"]'); // const selectedCount = document.querySelector('[data-kt-employer-table-select="selected_count"]');
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
    $("#kt_modal_add_employer_form").validate({
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
                return $('#employer_id').val();
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
                return $('#employer_id').val();
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

  var getemployerId = function getemployerId(e) {
    return e.attr('data-employerid');
  }; // Add data


  var showAddform = function showAddform() {
    $("#btnadd_employer").on("click", function (e) {
      $('#mdlemployer_add .modal-body').load('employers/create', function () {
        $('#mdlemployer_add').modal('show');
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
    $(document).on("click", ".employeredit", function (e) {
      var employer_id = getemployerId($(this)); // $('#kt_modal_add_employer_form').attr('action','employers/' + employer_id);
      // $('#mdlemployer_add .modal-body').load('employers/' + employer_id + '/edit',function() {
      //     $('#employer_id').val(employer_id);          		
      //     $('#mdlemployer_add').modal('show');
      //     $('input[name="password"]').rules('remove',  'required');
      //     var imageInputElement = document.querySelector("#kt_image_input_control");
      //     var imageInput = new KTImageInput(imageInputElement);     
      //     checkValset(); 
      // });

      document.location.href = 'employers/' + employer_id + '/edit';
    });
  };

  var showNotesAddList = function showNotesAddList() {
    $(document).on("click", ".employernote", function (e) {
      var employer_id = getemployerId($(this));
      var empid = $(this).attr('data-empid');
      var adminid = $(this).attr('data-adminid');
      $('#employer_id').val(employer_id);
      $('#admin_id').val(adminid);
      $('#mdlcomments').modal({
        backdrop: 'static',
        keyboard: false
      });
      $('#commentlist').load("/admin/employer/commentlist/" + employer_id);
      $('#mdlcomments').modal('show');
    });
    $('#close_button').click(function () {
      // $('#kt_modal_add_question_form').trigger("reset");
      //    $('#mdlquestion_add').modal({show:false});
      $('#mdlcomments').modal('hide');
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
      submitHandler: function submitHandler(form) {
        var employer_id = $('#employer_id').val();
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
            $('#commentlist').html('<div class="d-flex justify-content-center"><div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"><span class="sr-only">Loading...</span></div></div>');
          },
          success: function success(data) {
            console.log(data);
            $('#cmnt_area').val(''); // overlayblockUI.release();

            if (data.code == 1) {
              $('#commentlist').load("/admin/employer/commentlist/" + employer_id);
            } //alert("added successfully");

          }
        }); // form.submit(); // submit the form
      }
    });
  }; //  Export  functions


  var exportclick = function exportclick() {
    var submitButton = document.querySelector('[data-kt-employers-modal-action="export_submit"]');
    $(document).on("click", ".export_submit", function (e) {
      $('.export_submit').submit();
      $('#kt_modal_export_employers').modal('hide');
    });
  }; // Export function end
  // Public methods


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
      updateStatus();
      updatepaymentStatus();
      autologin();
      showNotesAddList();
      validateFormComments();
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
    $('#kt_modal_add_employer_form').trigger("reset"); //$('#mdlemployer_add').modal({show:false});

    $('#mdlemployer_add').modal('hide');
  });
  $('#kt_modal_export_employers').on('show.bs.modal', function () {
    var filterForm = document.querySelector('[data-kt-employers-modal-filter="form"]');
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
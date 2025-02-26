/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!****************************************************!*\
  !*** ./Resources/assets/js/candidate/candidate.js ***!
  \****************************************************/
 // Class definition

var KTDatatablesServerSide = function () {
  // Shared variables
  var table;
  var dt;
  var filterPayment;
  var ratediv = document.querySelector('.ratingdiv');
  var resetdiv = document.querySelector('.resetbtn'); // Shared variables
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
        url: "/employer/loadcandidates",
        data: function data(d) {
          d.positionid = $('#position_id').val(), d.candidatestatus = $('#candidate_status').val(), d.star_rate = $('#star_rating').val();
        }
      },
      columns: [{
        data: 'id'
      }, {
        data: 'created_at'
      }, {
        data: 'first_name'
      }, {
        data: 'email'
      }, {
        data: null
      }, {
        data: 'star_rate'
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
        targets: 2,
        // data: 'creator',
        render: function render(data, type, row) {
          var lname = '';

          if (row.first_name != null) {
            if (row.last_name != null) {
              lname = row.last_name;
            }

            return "<a class='text-hover-primary text-dark' href='/employer/candidate/detail/" + row.encrypt_id + "' >" + row.first_name + ' ' + lname + "</a>";
          }

          return "<span>N/A</span>";
        }
      }, {
        targets: 4,
        data: null,
        orderable: false,
        className: 'text-center',
        render: function render(data, type, row) {
          return row.resendinvite;
        }
      }, {
        targets: 5,
        // data: 'creator',
        orderable: false,
        render: function render(data, type, row) {
          return row.star_rate;
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
      toggleToolbars();
      rating(); // handleDeleteRows();

      KTMenu.createInstances();
    });
    dt.search('').draw();
  }; // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()


  var handleSearchDatatable = function handleSearchDatatable() {
    var filterSearch = document.querySelector('[data-kt-candidate-table-filter="search"]');
    filterSearch.addEventListener('keyup', function (e) {
      dt.search(e.target.value).draw();
    });
  }; // Filter Datatable


  var handleFilterDatatable = function handleFilterDatatable() {
    // Select filter options
    var filterForm = document.querySelector('[data-kt-candidate-table-filter="form"]');
    var filterButton = filterForm.querySelector('[data-kt-candidate-table-filter="filter"]');
    var selectOptions = filterForm.querySelectorAll('select'); // Filter datatable on submit

    filterButton.addEventListener('click', function (e) {
      if (e.target.value != 'undefined') {
        $('#star_rating').val(e.target.value);
        ratediv.classList.add('d-none');
        resetdiv.classList.remove('d-none');
      } // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()


      dt.draw();
    });
  };

  var handleStatusFilter = function handleStatusFilter() {
    var status = getUrlParameter('status');

    if (status) {
      $('#candidate_status').val(status);
      dt.draw();
      $('.emp_position_menulink').removeClass('active');
      var statdiv = document.querySelector('.emp_position_menulink[data-status^="' + status + '"]');
      statdiv.classList.add('active');
    }

    $(document).on("click", ".emp_position_menulink", function (e) {
      var candidate_status = $(this).attr('data-status');
      $('#candidate_status').val(candidate_status);
      dt.draw();
    });
  }; // Delete candidate


  var getUrlParameter = function getUrlParameter(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
  };

  var singleDelete = function singleDelete() {
    $(document).on("click", ".cfrmdelete", function (e) {
      var candidateId = getcandidateId($(this));
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
            url: "candidates/" + candidateId,
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
                icon: 'success',
                buttonsStyling: false,
                confirmButtonText: "OK",
                confirmButtonClass: "btn btn-primary"
              });
              dt.draw(); // delete row data from server and re-draw datatable
              // window.location.replace('candidates');
            }
          });
        }
      });
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
      });
      $('#star_rating').val('');
      $(".starrating_checkbox").prop('checked', false);
      ratediv.classList.remove('d-none');
      resetdiv.classList.add('d-none'); // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()

      dt.search('').draw();
    });
  }; // Init toggle toolbar


  var initToggleToolbar = function initToggleToolbar() {
    // Toggle selected action toolbar
    // Select all checkboxes
    var container = document.querySelector('#kt_table_candidates');
    var checkboxes = container.querySelectorAll('[type="checkbox"]'); // Select elements

    var deleteSelected = document.querySelector('[data-kt-candidate-table-select="delete_selected"]'); // Toggle delete selected toolbar

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
          title: 'Archiving candidate(s) permanently deletes all video recordings associated.',
          html: "Are you sure you would like to archive?",
          type: "warning",
          icon: "warning",
          buttonsStyling: false,
          showCancelButton: true,
          confirmButtonText: "Yes, archive",
          cancelButtonText: 'Cancel',
          closeOnConfirm: false,
          reverseButtons: true,
          customClass: {
            confirmButton: "btn btn-primary",
            cancelButton: 'btn btn-light btn-active-light-primary'
          }
        }).then(function (result) {
          if (result.value) {
            $.ajax({
              url: "/employer/candidate/candidatemassdelete",
              method: "POST",
              data: {
                "id": ids
              },
              dataType: "json",
              success: function success(data) {
                if (data.success) {
                  Swal.fire({
                    icon: 'success',
                    type: 'success',
                    title: 'Success!',
                    html: 'Candidate Updated Successfully!',
                    showConfirmButton: false,
                    timer: 1500
                  }).then(function (result) {
                    window.location.replace('candidate');
                  });
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Permission Denied'
                  }).then(function (result) {
                    window.location.replace('candidate');
                  });
                } //   dt.draw(); // delete row data from server and re-draw datatable
                // window.location.replace('candidates');

              }
            });
          }
        });
      }
    });
    $('#kt_datatable_restore_all').on('click', function () {
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
          text: "Are you sure to restore " + ids.length + " selected records ?",
          type: "warning",
          icon: "warning",
          confirmButtonText: "Yes, restore!",
          showCancelButton: true,
          cancelButtonText: "No, cancel",
          customClass: {
            confirmButton: "btn btn-primary",
            cancelButton: 'btn btn-light btn-active-light-primary'
          }
        }).then(function (result) {
          if (result.value) {
            $.ajax({
              url: "/employer/candidate/candidatemassrestore",
              method: "POST",
              data: {
                "id": ids
              },
              dataType: "json",
              success: function success(data) {
                if (data.success) {
                  swal.fire({
                    title: 'Restored!',
                    text: 'Your selected records have been restored!',
                    type: 'success',
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    confirmButtonClass: "btn btn-bold btn-primary"
                  }).then(function (result) {
                    window.location.replace('candidate');
                  });
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Permission Denied'
                  }).then(function (result) {
                    window.location.replace('candidate');
                  });
                } //   dt.draw(); // delete row data from server and re-draw datatable
                // window.location.replace('candidates');

              }
            });
          }
        });
      }
    });
    $('#kt_datatable_resendinvite_all').on('click', function () {
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
          text: "Are you sure to resend the invite mail for " + ids.length + " selected records ?",
          type: "warning",
          icon: "warning",
          confirmButtonText: "Yes, resend!",
          showCancelButton: true,
          cancelButtonText: "No, cancel",
          customClass: {
            confirmButton: "btn btn-primary",
            cancelButton: 'btn btn-light btn-active-light-primary'
          }
        }).then(function (result) {
          if (result.value) {
            $.ajax({
              url: "/employer/candidate/sendmassinvite",
              method: "POST",
              data: {
                "id": ids
              },
              dataType: "json",
              success: function success(data) {
                if (data.success) {
                  swal.fire({
                    title: 'Mail Sended!',
                    text: 'Invite Mail Sended to the Candidate!',
                    type: 'success',
                    icon: "success",
                    confirmButtonText: "OK",
                    confirmButtonClass: "btn btn-primary"
                  });
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Permission Denied'
                  }).then(function (result) {
                    window.location.replace('candidate');
                  });
                } //   dt.draw(); // delete row data from server and re-draw datatable
                // window.location.replace('candidates');

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
              url: "candidates/candidateupdate",
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
                    window.location.replace('candidates');
                  });
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Permission Denied'
                  }).then(function (result) {
                    window.location.replace('candidates');
                  });
                } //   dt.draw(); // delete row data from server and re-draw datatable
                // window.location.replace('candidates');

              }
            });
          } else {// window.location.replace('candidates');
          }
        });
      }
    });
  }; // Toggle toolbars


  var toggleToolbars = function toggleToolbars() {
    // Define variables
    var container = document.querySelector('#kt_table_candidates');
    var toolbarBase = document.querySelector('[data-kt-candidate-table-toolbar="base"]');
    var toolbarSelected = document.querySelector('[data-kt-candidate-table-toolbar="selected"]'); // const selectedCount = document.querySelector('[data-kt-candidate-table-select="selected_count"]');
    // Select refreshed checkbox DOM elements

    var allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]'); // Detect checkboxes state & count

    var checkedState = false;
    var count = 0; // Count checked boxes

    allCheckboxes.forEach(function (c) {
      if (c.checked) {
        checkedState = true;
        count++;
      }
    });
    var selected_status = $('#candidate_status').val();
    var overall_btn = '<button type="button" class="btn btn-danger" id="kt_datatable_delete_all" data-kt-candidate-table-select="delete_selected">Archive</button>'; // <button type="button" class="btn btn-danger" id="kt_datatable_delete_all" data-kt-candidate-table-select="delete_selected">Archive</button>

    if (selected_status == '1' || selected_status == '2') {
      overall_btn = '<button type="button" class="btn btn-light btn-active-light-primary px-6 align-self-center text-nowrap  mx-5" id="kt_datatable_resendinvite_all" data-kt-candidate-table-select="resendinvite_selected" >Resend Invite</button>\
            <button type="button" class="btn btn-danger" id="kt_datatable_delete_all" data-kt-candidate-table-select="delete_selected">Archive</button>';
    }

    if (selected_status == '5') {
      overall_btn = '<button type="button" class="btn btn-primary" id="kt_datatable_restore_all" data-kt-candidate-table-select="restore_selected">Restore</button>';
    } // Toggle toolbars


    if (checkedState) {
      toolbarSelected.innerHTML = overall_btn; // toolbarBase.classList.add('d-none');

      toolbarSelected.classList.remove('d-none');
    } else {
      // toolbarBase.classList.remove('d-none');
      toolbarSelected.classList.add('d-none');
    }

    selectedDelete();
  };

  jQuery.validator.addMethod("phoneUS", function (phone_number, element) {
    phone_number = phone_number.replace(/\s+/g, "");
    return this.optional(element) || phone_number.length > 9 && phone_number.match(/^(\+?1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
  }, "Please specify a valid phone number");

  var validateForm = function validateForm() {
    $("#kt_modal_add_candidate_form").validate({
      errorClass: 'invalid-feedback',
      // define validation rules
      rules: {
        email: {
          required: true,
          email: true,
          remote: {
            url: "candidates/emailvalidate",
            type: "post",
            data: {
              'id': function id() {
                return $('#candidate_id').val();
              },
              'position_id': function position_id() {
                return $('#position_id').val();
              }
            }
          },
          normalizer: function normalizer(value) {
            return $.trim(value);
          }
        },
        employer_id: {
          required: true
        },
        first_name: {
          required: true
        },
        last_name: {
          required: true
        },
        position_id: {
          required: true,
          remote: {
            url: "candidates/positionvalidate",
            type: "post",
            data: {
              'id': function id() {
                return $('#candidate_id').val();
              },
              'email': function email() {
                return $('#email').val();
              }
            }
          },
          normalizer: function normalizer(value) {
            return $.trim(value);
          }
        }
      },
      messages: {
        position_id: {
          remote: "Position already exists in the Same Email"
        },
        email: {
          remote: "Email already exists in the Same Position"
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
        var which_button = $('#saveandsendlink').val();

        if (which_button == '1') {
          $('#send_link').attr('data-kt-indicator', 'on');
          $('#send_link').attr('disabled', 'true');
          $('#send').attr('disabled', 'true');
        } else {
          $('#send').attr('data-kt-indicator', 'on');
          $('#send').attr('disabled', 'true');
          $('#send_link').attr('disabled', 'true');
        }

        form.submit();
        setTimeout(function () {
          if (which_button == '1') {
            $('#send_link').removeAttr('data-kt-indicator');
            $('#send_link').removeAttr('disabled');
            $('#send').removeAttr('disabled');
          } else {
            $('#send').removeAttr('data-kt-indicator');
            $('#send').removeAttr('disabled');
            $('#send_link').removeAttr('disabled');
          }
        }, 2000);
      }
    });
  };

  var getcandidateId = function getcandidateId(e) {
    return e.attr('data-candidateid');
  }; // Add data


  var showAddform = function showAddform() {
    $("#btnadd_candidate").on("click", function (e) {
      $('#mdlcandidate_add .modal-body').load('candidates/create', function () {
        $('#mdlcandidate_add').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#mdlcandidate_add').modal('show');
        $('#send_link').show();
        $('#employer_id').select2({
          dropdownParent: $('#mdlcandidate_add')
        }).on("change", function (e) {
          $.ajax({
            url: "candidates/employerposition",
            method: "post",
            data: {
              "employer_id": this.value
            },
            success: function success(data) {
              if (data.success == '1') {
                $('#position_id').html(data.position_options);
              }
            }
          });
          $(this).valid();
        });
        $('#position_id').select2({
          dropdownParent: $('#mdlcandidate_add')
        }).on("change", function (e) {
          $(this).valid();
        });
        selectDisableEnableOptions();
      });
    });
  };

  var showEditform = function showEditform() {
    $(document).on("click", ".candidateedit", function (e) {
      var candidate_id = getcandidateId($(this));
      $('#kt_modal_add_candidate_form').attr('action', 'candidates/' + candidate_id);
      $('#mdlcandidate_add .modal-body').load('candidates/' + candidate_id + '/edit', function () {
        $('#candidate_id').val(candidate_id);
        $('#mdlcandidate_add').modal('show');
        $('#send_link').hide();
        var empid = $('#editempid').val();
        var positionid = $('#editposition_id').val();
        $("#employer_id").select2().val(empid).trigger("change");
        $("#position_id").select2().val(positionid).trigger("change");
        $('#employer_id').select2({
          dropdownParent: $('#mdlcandidate_add')
        }).on("change", function (e) {
          $.ajax({
            url: "candidates/employerposition",
            method: "post",
            data: {
              "employer_id": this.value
            },
            success: function success(data) {
              if (data.success == '1') {
                $('#position_id').html(data.position_options);
              }
            }
          });
          $(this).valid();
        });
        $('#position_id').select2({
          dropdownParent: $('#mdlcandidate_add')
        }).on("change", function (e) {
          $(this).valid();
        });
        $("#position_id").prop("disabled", false);
        selectDisableEnableOptions();
      });
    });
  };

  var sendinvite = function sendinvite() {
    $(document).on("click", ".sendinvite", function (e) {
      var candidate_id = getcandidateId($(this));
      var text_message = "You want to resend the Invite Mail";
      swal.fire({
        title: "Are you sure?",
        text: text_message,
        type: "warning",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Send it!",
        customClass: {
          confirmButton: "btn btn-primary",
          cancelButton: "btn btn-secondary"
        }
      }).then(function (result) {
        if (result.value) {
          $.ajax({
            url: "/admin/candidates/sendinvite",
            type: "post",
            data: {
              "candidate_id": candidate_id
            },
            dataType: "json",
            success: function success(data) {
              if (data.code == 1) {
                swal.fire({
                  title: 'Mail Sended!',
                  text: 'Invite Mail Sended to the Candidate!',
                  type: 'success',
                  icon: "success",
                  confirmButtonText: "OK",
                  confirmButtonClass: "btn btn-primary"
                });
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Mail Not send Please check the credentails',
                  customClass: {
                    confirmButton: "btn btn-danger"
                  }
                });
              }

              dt.draw();
            }
          });
        }
      });
    });
  }; //  Export  functions


  var exportclick = function exportclick() {
    var submitButton = document.querySelector('[data-kt-candidates-modal-action="export_submit"]');
    $(document).on("click", ".export_submit", function (e) {
      $('.export_submit').submit();
      $('#kt_modal_export_candidates').modal('hide');
    });
  }; // Export function end


  var rating = function rating() {
    $('.rating').raty({
      path: '/media/raty/small_star',
      starHalf: 'star-half.svg',
      starOff: 'star-off.svg',
      starOn: 'star-on.svg',
      click: function click(score) {
        var candidateid = $(this).attr("data-canid");
        $.ajax({
          url: "/employer/candidate/rating",
          type: "post",
          data: {
            'candidate_id': candidateid,
            'rating': score
          }
        });
      }
    });
  };

  var archive = function archive() {
    $(document).on("click", ".cfrmarchive", function (e) {
      var cid = getcId($(this));
      swal.fire({
        title: 'Archiving candidate(s) permanently deletes all video recordings associated.',
        html: "Are you sure you would like to archive?",
        type: "warning",
        icon: "warning",
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: "Yes, archive",
        cancelButtonText: 'Cancel',
        closeOnConfirm: false,
        reverseButtons: true,
        customClass: {
          confirmButton: "btn btn-primary",
          cancelButton: 'btn btn-light btn-active-light-primary'
        }
      }).then(function (result) {
        if (result.value) {
          $.ajax({
            url: "/employer/candidate/" + cid,
            type: "post",
            data: {
              '_method': "delete"
            },
            dataType: "json",
            success: function success(data) {
              if (data.status == '1') {
                Swal.fire({
                  icon: 'success',
                  type: 'success',
                  title: 'Success!',
                  html: 'Candidate Updated Successfully!',
                  showConfirmButton: false,
                  timer: 1500
                }).then(function (result) {
                  dt.draw();
                  loadstatusCount();
                });
              }
            }
          });
        }
      });
    });
  };

  var restore = function restore() {
    $(document).on("click", ".restore", function (e) {
      var cid = getcId($(this));
      swal.fire({
        title: "Are you sure?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, restore it!"
      }).then(function (result) {
        if (result.value) {
          $.ajax({
            url: "/employer/candidate/restore",
            type: "post",
            data: {
              'cid': cid
            },
            dataType: "json",
            success: function success(data) {
              if (data.status == '1') {
                swal.fire({
                  title: 'Restored!',
                  text: 'Your selected records have been restored!',
                  type: 'success',
                  buttonsStyling: false,
                  confirmButtonText: "OK",
                  confirmButtonClass: "btn btn-bold btn-primary"
                }).then(function (result) {
                  dt.draw();
                  loadstatusCount();
                });
              }
            }
          });
        }
      });
    });
  };

  var loadstatusCount = function loadstatusCount() {
    $.ajax({
      url: "/employer/candidate/statuscount",
      type: "get",
      data: {
        'pid': $('#pid').val()
      },
      dataType: "json",
      success: function success(data) {
        $('.cntall').html(data.all_count);
        $('.cntcomp').html(data.complete_count);
        $('.cntincomp').html(data.incomplete_count);
        $('.cnthired').html(data.hired_count);
        $('.cntarch').html(data.archive_count);
      }
    });
  };

  var updateHire = function updateHire() {
    var cid = '';
    $("#mdl_hire").on('show.bs.modal', function (event) {
      var mdldata = $(event.relatedTarget);
      cid = getcId(mdldata);
    });
    $('#save_hire').click(function () {
      $.ajax({
        url: "/employer/candidate/hire",
        type: "post",
        data: {
          'cid': cid,
          'hire_date': $('#hire_date').val()
        },
        dataType: "json",
        success: function success(data) {
          if (data.status == '1') {
            $("#mdl_hire").modal('hide');
            swal.fire({
              title: 'Hired!',
              text: 'Your selected records have been Hired!',
              type: 'success',
              buttonsStyling: false,
              confirmButtonText: "OK",
              confirmButtonClass: "btn btn-bold btn-primary"
            }).then(function (result) {
              dt.draw();
              loadstatusCount();
            });
          }
        }
      });
    });
  };

  var getcId = function getcId(e) {
    return e.attr('data-candidateid');
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
      updateStatus();
      handleStatusFilter();
      sendinvite();
      rating();
      archive();
      restore();
      loadstatusCount();
      updateHire();
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
  $("#hire_date").daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    minYear: parseInt(moment().format("YYYY"))
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
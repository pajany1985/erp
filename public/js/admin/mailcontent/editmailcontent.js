/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!************************************************************!*\
  !*** ./Resources/assets/js/mailcontent/editmailcontent.js ***!
  \************************************************************/
 // Class definition

var EditMailcontentDataTable = function () {
  // Shared variables
  var table;
  var dt;
  var filterPayment; // Shared variables
  // Private functions

  var initDatatable = function initDatatable() {
    dt = $("#kt_table_mailcontent").DataTable({
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
        url: "/admin/loadmailcontents"
      },
      columns: [{
        data: 'mail_title'
      }, {
        data: 'updated_at'
      }, {
        data: 'actions'
      }],
      columnDefs: [{
        targets: 0,
        data: 'creator',
        className: 'd-flex align-items-center',
        render: function render(data, type, row) {
          return row.mail_title;
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
    }); //dt.search('').draw();
  };

  var editor = function editor() {
    var options = {
      selector: "#mailcontent",
      height: "480"
    }; // tinymce.init(options);

    tinymce.init({
      selector: 'textarea#mailcontent',
      plugins: 'code,table',
      table_toolbar: 'tableprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',
      height: 500,
      toolbar: 'undo redo | bold | italic | code | align | outdent indent | mybutton ',
      statusbar: false,
      setup: function setup(editor) {
        /* Menu items are recreated when the menu is closed and opened, so we need
           a variable to store the toggle menu item state. */
        var toggleState = false;
        /* example, adding a toolbar menu button */

        editor.ui.registry.addMenuButton('mybutton', {
          text: 'Insert Variables',
          fetch: function fetch(callback) {
            var items = [{
              type: 'menuitem',
              text: 'POSITION NAME',
              onAction: function onAction() {
                editor.insertContent('&nbsp;<b>%POSITION_NAME%</b>');
              }
            }, {
              type: 'menuitem',
              text: 'COMPANY NAME',
              onAction: function onAction() {
                editor.insertContent('&nbsp;<b>%COMPANY_NAME%</b>');
              }
            }, {
              type: 'menuitem',
              text: 'COMPANY LOGO',
              onAction: function onAction() {
                editor.insertContent('&nbsp;<b>%COMPANY_LOGO%</b>');
              }
            }, {
              type: 'menuitem',
              text: 'OUR LOGO',
              onAction: function onAction() {
                editor.insertContent('&nbsp;<b>%OUR_LOGO%</b>');
              }
            }, {
              type: 'menuitem',
              text: 'EMPLOYER  NAME',
              onAction: function onAction() {
                editor.insertContent('&nbsp;<b>%EMPLOYER_NAME%</b>');
              }
            }, {
              type: 'menuitem',
              text: 'EMPLOYER EMAIL',
              onAction: function onAction() {
                editor.insertContent('&nbsp;<b>%EMPLOYER_EMAIL%</b>');
              }
            }, {
              type: 'menuitem',
              text: 'EMPLOYER PHONE',
              onAction: function onAction() {
                editor.insertContent('&nbsp;<b>%EMPLOYER_PHONE%</b>');
              }
            }, {
              type: 'menuitem',
              text: 'EMPLOYER ADDRESS',
              onAction: function onAction() {
                editor.insertContent('&nbsp;<b>%EMPLOYER_ADDRESS%</b>');
              }
            }, {
              type: 'menuitem',
              text: 'SUBEMPLOYER NAME',
              onAction: function onAction() {
                editor.insertContent('&nbsp;<b>%SUBEMPLOYER_NAME%</b>');
              }
            }, {
              type: 'menuitem',
              text: 'SUBEMPLOYER EMAIL',
              onAction: function onAction() {
                editor.insertContent('&nbsp;<b>%SUBEMPLOYER_EMAIL%</b>');
              }
            }, {
              type: 'menuitem',
              text: 'SUBEMPLOYER PHONE',
              onAction: function onAction() {
                editor.insertContent('&nbsp;<b>%SUBEMPLOYER_PHONE%</b>');
              }
            }, {
              type: 'menuitem',
              text: 'CANDIDATE NAME',
              onAction: function onAction() {
                editor.insertContent('&nbsp;<b>%CANDIDATE_NAME%</b>');
              }
            }, {
              type: 'menuitem',
              text: 'CANDIDATE EMAIL',
              onAction: function onAction() {
                editor.insertContent('&nbsp;<b>%CANDIDATE_EMAIL%</b>');
              }
            }, {
              type: 'menuitem',
              text: 'LINK',
              onAction: function onAction() {
                editor.insertContent('&nbsp;<b>%LINK%</b>');
              }
            }, {
              type: 'menuitem',
              text: 'APP_LINK',
              onAction: function onAction() {
                editor.insertContent('&nbsp;<b>%APP_LINK%</b>');
              }
            }, {
              type: 'menuitem',
              text: 'URL',
              onAction: function onAction() {
                editor.insertContent('&nbsp;<b>%URL%</b>');
              }
            }, {
              type: 'menuitem',
              text: 'APP_URL',
              onAction: function onAction() {
                editor.insertContent('&nbsp;<b>%APP_URL%</b>');
              }
            }, {
              type: 'menuitem',
              text: 'OTP',
              onAction: function onAction() {
                editor.insertContent('&nbsp;<b>%OTP%</b>');
              }
            }, {
              type: 'menuitem',
              text: 'COUNT',
              onAction: function onAction() {
                editor.insertContent('&nbsp;<b>%COUNT%</b>');
              }
            }];
            callback(items);
          }
        });
      },
      content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });
  };

  var validateForm = function validateForm() {
    $("#kt_editmailcontent_form").validate({
      errorClass: 'invalid-feedback',
      ignore: ".ignore",
      errorElement: "strong",
      // define validation rules
      rules: {
        subject: {
          required: true
        },
        mailcontent: {
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
      }
    });
    $("#kt_editmailcontent_submit").click(function () {
      tinyMCE.triggerSave();
      var content = tinyMCE.activeEditor.getContent();
      $("textarea#mailcontent").html(content);
      var status;
      status = $("#kt_editmailcontent_form").valid(); //Validate again

      if (status == true) {
        $('#kt_editmailcontent_submit').attr('data-kt-indicator', 'on');
        $('#kt_editmailcontent_submit').attr('disabled', 'true');
        $("#kt_editmailcontent_form").submit();
      }
    });
  }; // Public methods


  return {
    init: function init() {
      initDatatable();
      editor();
      validateForm();
    }
  };
}(); // On document ready


KTUtil.onDOMContentLoaded(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  EditMailcontentDataTable.init(); //   $.validator.messages.required = '';  

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
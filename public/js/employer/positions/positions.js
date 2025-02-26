/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!****************************************************!*\
  !*** ./Resources/assets/js/positions/positions.js ***!
  \****************************************************/
 // Class definition

var KTSigninGeneral = function () {
  // Elements
  var form;
  var submitButton; // Handle form

  var initDatatable = function initDatatable(e) {
    $('body').on('click', '.pagination a', function (e) {
      e.preventDefault();
      $('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 10000;" src="https://i.imgur.com/v3KWF05.gif />');
      var url = $(this).attr('href');
      var status = $('#aside_status').val(); // window.history.pushState("", "", url);

      loadDatapage(url, status);
    });
  };

  var loadDatapage = function loadDatapage(url) {
    var status = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'all';
    $.ajax({
      type: 'GET',
      data: {
        'status': status
      },
      url: url
    }).done(function (data) {
      $('.loadpositions').html(data);
      initCountUp();
      KTMenu.createInstances();
    }).fail(function () {
      console.log("Failed to load data!");
    });
  }; // initCountUp this is in src/js/layout/app.js


  var initCountUp = function initCountUp() {
    var elements = [].slice.call(document.querySelectorAll('[data-kt-countup="true"]:not(.counted)'));
    elements.map(function (element) {
      if (KTUtil.isInViewport(element) && KTUtil.visible(element)) {
        var options = {};
        var value = element.getAttribute('data-kt-countup-value');
        value = parseFloat(value.replace(/,/g, ""));

        if (element.hasAttribute('data-kt-countup-start-val')) {
          options.startVal = parseFloat(element.getAttribute('data-kt-countup-start-val'));
        }

        if (element.hasAttribute('data-kt-countup-duration')) {
          options.duration = parseInt(element.getAttribute('data-kt-countup-duration'));
        }

        if (element.hasAttribute('data-kt-countup-decimal-places')) {
          options.decimalPlaces = parseInt(element.getAttribute('data-kt-countup-decimal-places'));
        }

        if (element.hasAttribute('data-kt-countup-prefix')) {
          options.prefix = element.getAttribute('data-kt-countup-prefix');
        }

        if (element.hasAttribute('data-kt-countup-separator')) {
          options.separator = element.getAttribute('data-kt-countup-separator');
        }

        if (element.hasAttribute('data-kt-countup-suffix')) {
          options.suffix = element.getAttribute('data-kt-countup-suffix');
        }

        var count = new countUp.CountUp(element, value, options);
        count.start();
        element.classList.add('counted');
      }
    });
  };

  var handleFilter = function handleFilter() {
    $(document).on("click", ".emp_position_menulink", function (e) {
      var status = $(this).attr('data-status');
      $('#aside_status').val(status);
      loadDatapage('/employer/', status);
    }); // unable create position, to show warning message to upgrade package

    $(document).on("click", ".createposition", function (e) {
      swal.fire({
        title: "You have reached the maximum limit creation of position.",
        html: 'Please upgrade your package to create more positions',
        type: "warning",
        icon: "warning",
        buttonsStyling: false,
        showCancelButton: false,
        confirmButtonText: "Ok",
        customClass: {
          confirmButton: "btn btn-primary"
        }
      });
    });
  };

  var archive = function archive() {
    $(document).on("click", ".cfrmarchive", function (e) {
      var id = $(this).attr('data-id');
      var redirect_link = $(this).attr('href');
      swal.fire({
        title: 'Archiving this interview permanently deletes all video recordings associated.',
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
            url: "/employer/position/" + id,
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
                  html: 'Position Status Updated successfully',
                  showConfirmButton: false,
                  timer: 1500
                }).then(function (result) {
                  window.location.reload();
                });
              }
            }
          });
        }
      });
    });
  };

  var duplicate = function duplicate() {
    $(document).on("click", ".duplicate", function (e) {
      var urldup = $(this).attr('data-urldup');
      swal.fire({
        html: 'Are you sure you want to duplicate this interview?',
        icon: "warning",
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: "Yes, I'm sure!",
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
            url: urldup,
            type: "get",
            dataType: "json",
            success: function success(data) {
              if (data.status == '1') {
                Swal.fire({
                  icon: 'success',
                  type: 'success',
                  title: 'Success!',
                  html: 'Position duplicated successfully!',
                  showConfirmButton: false,
                  timer: 1500
                }).then(function (result) {
                  window.location.replace(data.redirect_url);
                });
              }
            }
          });
        }
      });
    });
  };

  var copycareerurl = function copycareerurl() {
    var clipboard; // Select element

    var target = document.getElementById('kt_clipboard_3'); // Init clipboard -- for more info, please read the offical documentation: https://clipboardjs.com/

    clipboard = new ClipboardJS(target); // Success action handler

    clipboard.on('success', function (e) {
      var currentLabel = target.innerHTML; // Exit label update when already in progress

      if (target.innerHTML === 'Copied!') {
        return;
      } // Update button label


      target.innerHTML = 'Copied!'; // Revert button label after 3 seconds

      setTimeout(function () {
        target.innerHTML = currentLabel;
      }, 3000);
    });
  }; // Public functions


  return {
    // Initialization
    init: function init() {
      initDatatable();
      archive();
      duplicate();
      handleFilter();
      copycareerurl();
    }
  };
}(); // On document ready


KTUtil.onDOMContentLoaded(function () {
  KTSigninGeneral.init();
});
/******/ })()
;
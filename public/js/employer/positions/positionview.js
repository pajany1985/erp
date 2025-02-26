/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!*******************************************************!*\
  !*** ./Resources/assets/js/positions/positionview.js ***!
  \*******************************************************/
 // Class definition

var PositionView = function () {
  // Elements
  var form;
  var submitButton; // Handle form

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

  var commonfunc = function commonfunc() {
    $(document).on("click", ".modalshare", function (e) {
      var url = $(this).attr('data-href');
      var pid = $(this).attr('data-pid');
      console.log($(this).attr('data-href'));
      console.log($(this).attr('data-pid'));
      $("#mdlshare").modal("show");
      $('#link_val').val(url);
      $('#position_id').val(pid);
    });
  }; // Public functions


  return {
    // Initialization
    init: function init() {
      archive();
      duplicate();
      commonfunc();
    }
  };
}(); // On document ready


KTUtil.onDOMContentLoaded(function () {
  PositionView.init();
});
/******/ })()
;
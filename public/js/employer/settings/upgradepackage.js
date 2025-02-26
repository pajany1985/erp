/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!********************************************************!*\
  !*** ./Resources/assets/js/settings/upgradepackage.js ***!
  \********************************************************/
 // Class definition

var UpgradePackage = function () {
  // Elements
  var form;
  var submitButton;
  var validator; // Handle form

  var upgrade = function upgrade(e) {
    // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    $('#upgradeideal').click(function () {
      var email = $('#usermail').val();
      $.ajax({
        url: "/employer/settings/checkidealtraitsuser",
        method: "post",
        data: {
          "mailid": email
        },
        success: function success(data) {
          if (data == 1) {
            Swal.fire({
              buttonsStyling: false,
              text: "You email Id already exist in IdealTraits.",
              type: "warning",
              icon: "warning",
              confirmButtonText: "Ok Continue",
              showCancelButton: true,
              cancelButtonText: "Cancel",
              customClass: {
                confirmButton: "btn btn-warning",
                cancelButton: "btn btn-secondary"
              }
            }).then(function (result) {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                $.ajax({
                  url: "/employer/settings/mergeidealtraits",
                  method: "post",
                  data: {
                    "mailid": email
                  },
                  success: function success(data) {
                    if (data.result == 1) {
                      location.reload();
                    } else {
                      swal.fire({
                        text: "Something went wrong, Please contact admin",
                        type: "error"
                      }).then(function () {// location.reload();
                      });
                    }
                  }
                });
              }
            });
          } else {
            Swal.fire({
              buttonsStyling: false,
              text: "Continue registration with IdealTraits",
              type: "warning",
              icon: "warning",
              confirmButtonText: "Ok Continue",
              showCancelButton: true,
              cancelButtonText: "Cancel",
              customClass: {
                confirmButton: "btn btn-warning",
                cancelButton: "btn btn-secondary"
              }
            }).then(function (result) {
              /* Read more about isConfirmed, isDenied below */
              var datasplit = data.split("::");

              if (result.isConfirmed) {
                window.location.href = "http://localbusiness/register/account/172/" + datasplit[1];
              }
            });
          }
        }
      });
    });
  }; // Public functions


  return {
    init: function init() {
      upgrade();
    }
  };
}(); // On document ready


KTUtil.onDOMContentLoaded(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  UpgradePackage.init();
});
/******/ })()
;
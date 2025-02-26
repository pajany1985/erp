/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!**************************************************!*\
  !*** ./Resources/assets/js/settings/settings.js ***!
  \**************************************************/
 // Class definition

var KTSigninGeneral = function () {
  // Elements
  var table;
  var dt;
  var form;
  var submitButton;
  var validator;
  var url = document.location.toString();
  var originalImageURL;
  var originalLogoImageURL;
  var logo_image = document.getElementById('logo_image');
  var cropper;

  var usersDatatable = function usersDatatable() {
    dt = $("#kt_table_users").DataTable({
      searchDelay: 500,
      processing: true,
      serverSide: true,
      order: [[1, 'desc']],
      stateSave: true,
      // select: {
      //     style: 'multi',
      //     selector: 'td:first-child input[type="checkbox"]',
      //     className: 'row-selected'
      // },
      ajax: {
        url: "/employer/loadsubusers" //    data: function ( d ) {
        //        d.status =$('#status').val()
        //    }

      },
      columns: [{
        data: 'first_name'
      }, {
        data: 'email'
      }, {
        data: 'status'
      }, {
        data: 'created_at'
      }, {
        data: null
      }],
      columnDefs: [{
        targets: 0,
        // data: 'creator',
        orderable: false,
        render: function render(data, type, row) {
          return row.first_name + ' ' + row.last_name;
        }
      }, {
        targets: 2,
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
      }]
    });
    table = dt.$; // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw

    dt.on('draw', function () {
      // initToggleToolbar();
      // toggleToolbars();
      // handleDeleteRows();
      KTMenu.createInstances();
    });
    dt.search('').draw();
  };

  var company_logochoose = function company_logochoose() {
    $("#business_logo").change(function () {
      // bannerimagecrop
      var file;
      file = $(this)[0].files[0];
      var height;
      var width;
      var options;
      var uploadedImageName = file.name;
      var uploadedImageType = file.type;
      var uploadedImageURL = URL.createObjectURL(file);

      if (cropper) {
        cropper.destroy();
        cropper = null;
      }

      $('#logo_image').attr('src', uploadedImageURL); //cropper = new Cropper(image, options);

      cropper = new Cropper(logo_image, {
        // aspectRatio: 1858 / 600, 
        aspectRatio: 269 / 73,
        autoCropArea: 1
      }); // $('#logo_imageEditor').modal({backdrop: 'static', keyboard: false});

      $('#logo_imageEditor').modal("show"); // console.log(file);
    });
    $(".logo_cropimage").click(function () {
      var canvas;

      if (cropper) {
        canvas = cropper.getCroppedCanvas();
        logo_image.src = canvas.toDataURL();
        canvas.toBlob(function (blob) {
          url = URL.createObjectURL(blob);
          var reader = new FileReader();
          reader.readAsDataURL(blob);

          reader.onloadend = function () {
            var base64data = reader.result; //   uploadlogoimage(base64data);				
          };
        }, 'image/png', 1);
      }
    });
    $('#logo_ZoomInBtn').click(function () {
      if (cropper) {
        cropper.zoom(0.1);
      }
    });
    $('#logo_ZoomOutBtn').click(function () {
      if (cropper) {
        cropper.zoom(-0.1);
      }
    });
    $('#logo_Zoomreset').click(function () {
      if (cropper) {
        cropper.destroy();
        cropper = null;
      }

      $('#logo_image').attr('src', originalLogoImageURL);
      cropper = new Cropper(logo_image, {
        autoCropArea: 1,
        aspectRatio: 269 / 73 // aspectRatio: 1858 / 600,				 

      });
    });
  };

  var company_video = function company_video() {
    $("#company_video").change(function () {
      var file;
      file = $(this)[0].files[0];
      var height;
      var width;
      var options;
      var uploadedVideoName = file.name;
      var uploadedVideoType = file.type;
      var uploadedVideoURL = URL.createObjectURL(file);
      document.querySelector("#upload_videotag").src = uploadedVideoURL;
    });
  };

  var hideshowcompanyvideofield = function hideshowcompanyvideofield() {
    $(".welcomeradio").on("change", function (e) {
      if ($('input[name="welcome_radio"]').is(":checked")) {
        var welcome_radio = $('input[name="welcome_radio"]:checked').val();

        if (welcome_radio == 'upload') {
          $("#upload_videodiv").css("display", "block");
          $("#videourl_embedurl").css("display", "none");
        } else if (welcome_radio == 'url') {
          $("#upload_videodiv").css("display", "none");
          $("#videourl_embedurl").css("display", "block");
        }
      } else {
        $("#upload_videodiv").css("display", "none");
        $("#videourl_embedurl").css("display", "none");
      }
    });
  };

  var validateUserForm = function validateUserForm() {
    $("#kt_modal_new_user_form").validate({
      errorClass: 'invalid-feedback',
      // define validation rules
      rules: {
        fname: {
          required: true,
          normalizer: function normalizer(value) {
            return $.trim(value);
          }
        },
        lname: {
          required: true,
          normalizer: function normalizer(value) {
            return $.trim(value);
          }
        },
        email: {
          required: true,
          email: true,
          remote: {
            url: "checkemailexist",
            type: "post"
          },
          normalizer: function normalizer(value) {
            return $.trim(value);
          }
        }
      },
      messages: {
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
        // form.submit(); // submit the form
        var first_name = $('#fname').val();
        var usercount = $('#usercount').val();
        $.ajax({
          url: form.action,
          type: form.method,
          data: $(form).serialize(),
          beforeSend: function beforeSend() {
            $('#kt_modal_new_user_submit').attr('data-kt-indicator', 'on');
            $('#kt_modal_new_user_submit').attr('disabled', 'true');
          },
          success: function success(data) {
            $('#kt_modal_new_user_submit').removeAttr('data-kt-indicator');
            $('#kt_modal_new_user_submit').removeAttr('disabled');
            $('#kt_modal_new_user_form').trigger("reset");
            $('#kt_modal_new_user').modal('hide');

            if (data.code == 1) {
              swal.fire({
                title: 'User Added Successfully!',
                html: "We've sent <strong>" + capitalize(first_name) + "</strong> an email with a link to finish setting up their user account.<br><br>" + "Once they've completed this, they will become active and will have full access to the information in your account  ",
                type: 'success',
                icon: "success",
                confirmButtonText: "OK",
                confirmButtonClass: "btn btn-primary"
              }).then(function (result) {
                if (usercount > 0) {
                  dt.draw();
                } else {
                  $('.usernotpresent').css('display', 'none');
                  $('.userpresent').css('display', 'block');
                  dt.draw();
                }
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'User Not Created, Please contact Admin',
                customClass: {
                  confirmButton: "btn btn-danger"
                }
              });
            }
          }
        });
      }
    });
    $(".check_status").on("change", function (e) {
      if ($('input[name="status_hidden"]').is(":checked")) {
        $('input[name="status"]').val('1');
      } else {
        $('input[name="status"]').val('0');
      }
    });
  };

  var singleDelete = function singleDelete() {
    var master_id = $('#master_id').val();
    $(document).on("click", ".cfrmdelete", function (e) {
      var userId = getuserId($(this));
      swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!"
      }).then(function (result) {
        if (result.value) {
          $.ajax({
            url: "subuser/" + userId,
            type: "post",
            data: {
              '_method': "post",
              'master_id': master_id
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
              }).then(function (result) {
                if (data.remain_subuser == 0) {
                  $('.usernotpresent').css('display', 'block');
                  $('.userpresent').css('display', 'none');
                }
              });
              dt.draw(); // delete row data from server and re-draw datatable
              // window.location.replace('users');
            }
          });
        }
      });
    });
  };

  var getuserId = function getuserId(e) {
    return e.attr('data-userid');
  };

  var validateAccoutnSetting = function validateAccoutnSetting() {
    $("#kt_account_setting_form").validate({
      errorClass: 'invalid-feedback',
      // define validation rules
      rules: {
        firstname: {
          required: true,
          normalizer: function normalizer(value) {
            return $.trim(value);
          }
        },
        lastname: {
          required: true,
          normalizer: function normalizer(value) {
            return $.trim(value);
          }
        },
        phone: {
          required: true,
          normalizer: function normalizer(value) {
            return $.trim(value);
          }
        },
        email: {
          required: true,
          email: true,
          remote: {
            url: "checkemailexist",
            type: "post",
            data: {
              'id': function id() {
                return $('#authuser').val();
              }
            }
          },
          normalizer: function normalizer(value) {
            return $.trim(value);
          }
        }
      },
      messages: {
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
  }; // Public functions


  return {
    // Initialization
    init: function init() {
      form = document.querySelector('#kt_sign_in_form');
      submitButton = document.querySelector('#kt_sign_in_submit');
      company_logochoose();
      usersDatatable();
      company_video();
      hideshowcompanyvideofield();
      validateUserForm();
      singleDelete();
      validateAccoutnSetting();
    }
  };
}(); // On document ready


KTUtil.onDOMContentLoaded(function () {
  KTSigninGeneral.init();
  $.validator.messages.required = '';
  $('#close_button').click(function () {
    $('#kt_modal_new_user_form').trigger("reset"); //$('#mdluser_add').modal({show:false});

    $('#kt_modal_new_user').modal('hide');
  });
});

function capitalize(str) {
  var strVal = '';
  str = str.split(' ');

  for (var chr = 0; chr < str.length; chr++) {
    strVal += str[chr].substring(0, 1).toUpperCase() + str[chr].substring(1, str[chr].length) + ' ';
  }

  return strVal;
}
/******/ })()
;
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!********************************************************!*\
  !*** ./Resources/assets/js/positions/shareposition.js ***!
  \********************************************************/
 // Class definition

var Share = function () {
  // Shared variables
  var clr_cnt = 0;
  var form;
  var submitButton;
  var validator; // Export function end

  var sharelink = function sharelink() {
    var target = document.getElementById('link_val');
    var button = document.getElementById('cpy_link');
    ;
    var clipboard = new ClipboardJS(button, {
      container: document.getElementById('mdlshare'),
      target: target,
      text: function text() {
        return target.value;
      }
    }); // Success action handler

    clipboard.on('success', function (e) {
      var currentLabel = button.innerHTML; // Exit label update when already in progress

      if (button.innerHTML === 'Copied!') {
        return;
      } // Update button label


      button.innerHTML = 'Copied!'; // Revert button label after 3 seconds

      setTimeout(function () {
        button.innerHTML = currentLabel;
      }, 3000);
    });
  };

  var shareemail = function shareemail() {
    clr_cnt = 0;
    var input = document.getElementById('shareemail');
    var tagify = new Tagify(input, {
      pattern: /^.{0,20}$/,
      // Validate typed tag(s) by Regex. Here maximum chars length is defined as "20"
      delimiters: ", ",
      // add new tags when a comma or a space character is entered
      maxTags: 6,
      transformTag: transformTag
    }); // document.getElementsByClassName('cancelbtn').addEventListener('click', tagify.removeAllTags.bind(tagify))

    function transformTag(tagData) {
      if (clr_cnt >= 4) clr_cnt = 0;
      var states = ['brandideal', 'warningideal', 'successideal', 'infoideal']; // tagData.class = 'tagify__tag tagify__tag--' + states[KTUtil.getRandomInt(0, 3)];

      tagData["class"] = 'tagify__tag tagify__tag--' + states[clr_cnt];
      clr_cnt++;
    }

    tagify.on('add', function (e) {
      console.log(e.detail);
      $('#toemaildummy').val('1');
      $('.tagify').css('border-color', '#e2e5ec');
    });
    tagify.on('remove', function (e) {
      console.log(e.detail);
      var tag_len = tagify.value.length;

      if (tag_len == 0) {
        $('#toemaildummy').val('');
        $('.tagify').css('border-color', '#f1416c'); // error color
      }
    });
    tagify.on('invalid', function (e) {
      var tag_len = tagify.value.length;

      if (tag_len == 0) {
        $('.tagify').css('border-color', '#f1416c');
      }

      if (e.detail.message == "already exists") {
        swal.fire({
          text: e.detail.data.value + " Already exists",
          type: "error"
        });
      } else if (e.detail.message == 'number of tags exceeded') {
        swal.fire({
          text: "Number of tags exceeded",
          type: "warning"
        });
      } else {
        swal.fire({
          text: "Enter Valid Email Address",
          type: "error"
        });
      }
    });
    $('#mdlshare').on('hidden.bs.modal', tagify.removeAllTags.bind(tagify)); // Remove all tags when modal popup is closed
  };

  var handle = function handle(e) {
    $("#shareform").validate({
      // errorClass: 'invalid-feedback',
      // define validation rules
      rules: {
        link_val: {
          required: true,
          normalizer: function normalizer(value) {
            return $.trim(value);
          }
        }
      },
      highlight: function highlight(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function unhighlight(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      },
      submitHandler: function submitHandler(form) {
        //form.submit(); // submit the form
        var check_tomail = $('#toemaildummy').val();
        var shareemail = $('#shareemail').val();
        var link_val = $('#link_val').val();
        var routeurl = $('#routeurl').val();
        var positionid = $('#position_id').val();

        if (check_tomail != '') {
          // $('#sendreusmeform').submit();  
          $('.tagify').css('border-color', '#e2e5ec');
          $.ajax({
            url: routeurl,
            type: 'post',
            data: {
              "shareemail": shareemail,
              "link_val": link_val,
              "positionid": positionid
            },
            beforeSend: function beforeSend() {
              $('#btnshare').attr('data-kt-indicator', 'on');
              $('#btnshare').attr('disabled', 'true');
              $('#sharelater').attr('disabled', 'true');
            },
            success: function success(data) {
              $('#btnshare').removeAttr('data-kt-indicator');
              $('#btnshare').removeAttr('disabled');
              $('#sharelater').removeAttr('disabled');
              $('#mdlshare').modal('hide');
              $('#shareform')[0].reset();
              $('#toemaildummy').val('');
              $('.tagify__tag').remove();

              if (data.response == 'success') {
                Swal.fire({
                  icon: 'success',
                  type: 'success',
                  title: 'Invite Mail Sent Successfully',
                  showConfirmButton: false,
                  timer: 1500
                }).then(function (result) {
                  window.location.reload();
                });
              } else {
                swal.fire({
                  text: "Email could not send",
                  type: "error"
                });
              }
            }
          }); //border-color:#e2e5ec
        } else {
          $('.tagify').css('border-color', '#f1416c'); // error color

          Swal.fire({
            text: "Please Fill the Share Email .",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
              confirmButton: "btn btn-primary"
            }
          });
        }
      }
    });
    $('.storagefull').click(function () {
      Swal.fire({
        text: "Sorry, There is No Enough space available to Post a position, Please upgrade your package .",
        icon: "error",
        buttonsStyling: false,
        confirmButtonText: "Ok, got it!",
        customClass: {
          confirmButton: "btn btn-primary"
        }
      });
    });
  }; // Public methods


  return {
    init: function init() {
      form = document.querySelector('#shareform');
      submitButton = document.querySelector('#btnshare');
      sharelink();
      shareemail();
      handle();
      $("#mdlshare").on('show.bs.modal', function (event) {
        var mdldata = $(event.relatedTarget);
        var url = mdldata.data('href');
        var pid = mdldata.data('pid');
        $('#link_val').val(url);
        $('#position_id').val(pid);
      });
      var post_success = $('#post_success').val();

      if (post_success == '1') {
        $('.shareclick').trigger('click');
        $('.shareurl').on('click', function (e) {
          $("#mdlshare").modal("show");
          var url = $(this).attr('data-href');
          var pid = $(this).attr('data-pid');
          $('#link_val').val(url);
          $('#position_id').val(pid);
        });
        $('.shareurl').trigger('click');
        $('#post_success').val('');
      }
    }
  };
}(); // On document ready


KTUtil.onDOMContentLoaded(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  Share.init();
  $.validator.messages.required = '';
});
/******/ })()
;
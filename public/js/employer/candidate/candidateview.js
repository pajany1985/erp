/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!********************************************************!*\
  !*** ./Resources/assets/js/candidate/candidateview.js ***!
  \********************************************************/
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

  var rating = function rating() {
    $('.rating').raty({
      path: '/media/raty/small_star',
      starHalf: 'star-half.svg',
      starOff: 'star-off.svg',
      starOn: 'star-on.svg',
      cancelButton: true,
      cancelOff: 'redo.svg',
      cancelOn: 'redo1.svg',
      click: function click(score) {
        var cid = getcId($(this));
        $.ajax({
          url: "/employer/candidate/rating",
          type: "post",
          data: {
            'candidate_id': cid,
            'rating': score
          }
        });
      }
    });
    $(document).on("click", ".open_cmtmdl", function (e) {
      var cmnt_qstinon = $(this).attr('data-cmtqstn');
      $('#cmnt_question_no').val(cmnt_qstinon); // $('#comment_modal').

      $('#comment_modal').modal({
        backdrop: 'static',
        keyboard: false
      });
      $('#comment_modal').modal('show');
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
                  window.location.reload();
                });
              }
            }
          });
        }
      });
    });
  };

  var getcId = function getcId(e) {
    return e.attr('data-candidateid');
  };

  var videoplay = function videoplay() {
    $(document).on("click", ".videodiv", function (e) {
      var datakeyval = $(this).attr('data-keyval');
      $('#upload_videotag' + datakeyval).trigger('play');
      $('#videoplay' + datakeyval).css('display', 'none');
      $('#custom-opacity' + datakeyval).css('opacity', '');
      $('#videopause' + datakeyval).css('display', 'block');
    });
    $(document).on("click", ".videodivpause", function (e) {
      var datakeyval = $(this).attr('data-keyval');
      $('#upload_videotag' + datakeyval).trigger('pause');
      $('#videopause' + datakeyval).css('display', 'none');
      $('#custom-opacity' + datakeyval).css('opacity', '1');
      $('#videoplay' + datakeyval).css('display', 'block');
    });
  };

  var restore = function restore() {
    $('#restore').click(function () {
      $('#frmcandidate').attr('action', '/employer/candidate/restore');
      $('#frmcandidate').submit();
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
              text: 'Your selected records have been hired!',
              type: 'success',
              buttonsStyling: false,
              confirmButtonText: "OK",
              confirmButtonClass: "btn btn-bold btn-primary"
            }).then(function (result) {
              location.reload();
            });
          }
        }
      });
    });
    $('.downloadzip').click(function () {
      var zipurl = $(this).attr('data-url');
      $.ajax({
        url: zipurl,
        type: "get",
        //   data: { 'cid':cid, 'hire_date': $('#hire_date').val()  },
        dataType: "json",
        success: function success(data) {
          if (data.status == '1') {
            Swal.fire({
              text: "Sorry, There is a Invalid candidate, Contact as Admin .",
              icon: "error",
              buttonsStyling: false,
              confirmButtonText: "Ok, got it!",
              customClass: {
                confirmButton: "btn btn-primary"
              }
            }).then(function (result) {
              location.reload();
            });
          } else if (data.status == '2') {
            Swal.fire({
              text: "Sorry, There is No Questions and Videos are available, Contact as Admin .",
              icon: "error",
              buttonsStyling: false,
              confirmButtonText: "Ok, got it!",
              customClass: {
                confirmButton: "btn btn-primary"
              }
            }).then(function (result) {
              location.reload();
            });
          } else if (data.status == '3') {
            Swal.fire({
              text: "Sorry, There is No Attempts or Videos are available .",
              icon: "error",
              buttonsStyling: false,
              confirmButtonText: "Ok, got it!",
              customClass: {
                confirmButton: "btn btn-primary"
              }
            }).then(function (result) {
              location.reload();
            });
          } else if (data.status == '4') {
            location.href = data.downloadurl;
          }
        }
      });
    });
  };

  var validateForm = function validateForm() {
    $("#activity").on("change", function () {
      overlayblockUI.block();
      $('#commentlist').html('<div class="d-flex justify-content-center"><div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"><span class="sr-only">Loading...</span></div></div>');
      var candidate_id = $('#candidate_id').val();
      var filter = $(this).val().toLowerCase();

      if (filter != '') {
        $('#commentlist').load("/employer/candidate/commentlist/" + candidate_id + "/" + filter);
      } else {
        $('#commentlist').load("/employer/candidate/commentlist/" + candidate_id);
      }
    });
    $("#frmcomment").validate({
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
        var candidate_id = $('#candidate_id').val();
        var cmnt_area = $('#cmnt_area').val();
        $.ajax({
          url: "/employer/candidate/createactivity",
          type: 'post',
          data: {
            "candidate_id": candidate_id,
            "cmnt_area": cmnt_area
          },
          beforeSend: function beforeSend() {
            overlayblockUI.block();
            $('#commentlist').html('<div class="d-flex justify-content-center"><div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"><span class="sr-only">Loading...</span></div></div>');
          },
          success: function success(data) {
            console.log(data);
            $('#cmnt_area').val('');
            overlayblockUI.release();

            if (data.code == 1) {
              $('#commentlist').load("/employer/candidate/commentlist/" + candidate_id);
            } //alert("added successfully");

          }
        }); // form.submit(); // submit the form
      }
    });
    $("#kt_candidates_comment_form").validate({
      // define validation rules
      errorClass: 'invalid-feedback',
      rules: {
        comment: {
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
        var candidate_id = $('#candidate_id').val();
        var cmnt_question_no = $('#cmnt_question_no').val();
        var cmnt_area = $('#comment').val();
        $.ajax({
          url: "/employer/candidate/questioncomment",
          type: 'post',
          data: {
            "cmnt_question_no": cmnt_question_no,
            "candidate_id": candidate_id,
            "cmnt_area": cmnt_area
          },
          beforeSend: function beforeSend() {
            $('#add_cmnt').addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);
          },
          success: function success(data) {
            $('#comment').val('');
            $('#kt_candidates_comment_form')[0].reset();
            $("#kt_candidates_comment_form").validate().resetForm();
            $('#comment_modal').modal('hide');

            if (data.code == 1) {
              $('#add_cmnt').removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
              Swal.fire({
                icon: 'success',
                type: 'success',
                title: 'Comment Added Successfully',
                showConfirmButton: false,
                timer: 1500
              });
            } else {
              swal.fire({
                text: "Comment Not Added, try again",
                type: "error"
              });
            } //alert("added successfully");

          }
        }); //   form.submit(); // submit the form
      }
    });
  };

  var sendinvite = function sendinvite() {
    $(document).on("click", ".sendinvite", function (e) {
      var candidate_id = getcandidateId($(this));
      var text_message = "You want to Resend the Invite Mail";
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
            }
          });
        }
      });
    });
  };

  var questioncomments = function questioncomments() {
    $('.idealcomments').on("focusout", function (e) {
      var comment_val = $(this).val().trim();

      if (comment_val != '') {
        $(this).removeClass('is-invalid');
      } else {
        $(this).addClass('is-invalid');
      }
    });
    $(".submitcomment").on("click", function (e) {
      var form = $(this).attr('data-formid');
      var txtname = $(this).attr('data-txtname');
      var loopid = $(this).attr('data-loopid');
      var comment_val = $('#' + txtname).val().trim();
      var question_id = $('#question_id' + loopid).val();
      var employer_id = $('#employer_id' + loopid).val();
      var candidate_id = $('#candidate_id' + loopid).val();
      var overlaytargetloop = document.querySelector("#commentlist" + loopid);
      var overlayblockUIloop = new KTBlockUI(overlaytargetloop, {
        message: '<div class="blockui-message"><span class="spinner-border text-primary"></span><span class="process_content">Processing Video</span></div>'
      });

      if (comment_val != '') {
        $('#' + txtname).removeClass('is-invalid');
        $.ajax({
          url: "/employer/addcomments",
          type: 'post',
          data: {
            "candidate_id": candidate_id,
            "question_id": question_id,
            "employer_id": employer_id,
            "comment_val": comment_val
          },
          beforeSend: function beforeSend() {
            // overlayblockUIloop.block();
            $('#commentlist' + loopid).html('<div class="d-flex justify-content-center"><div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"><span class="sr-only">Loading...</span></div></div>');
          },
          success: function success(data) {
            $('#cmnt_area').val(''); // overlayblockUIloop.release();

            if (data.response == '1') {
              $('#' + txtname).val(''); // $('#commentlist'+loopid).html(data.comments);

              $('#commentlist' + loopid).load("/employer/qstncommentlist/" + question_id + '/' + candidate_id);
            }
          }
        });
      } else {
        $('#' + txtname).addClass('is-invalid');
      }
    });
  };

  var getcandidateId = function getcandidateId(e) {
    return e.attr('data-candidateid');
  };

  var videocontrols = function videocontrols() {
    $(".video_player_box").each(function (index) {
      $("#playpausebtn" + index).on("click", function (e) {
        playPause(this, 'upload_videotag' + index); // video play pause
      });
      $("#seekslider" + index).on("change", function (e) {
        // slider moves
        var videoelement = document.getElementById("upload_videotag" + index);
        var finish_time = $(this).attr('data-finishedtime');
        vidSeek(this, videoelement, finish_time, index);
      });
      $("#upload_videotag" + index).on("timeupdate", function (e) {
        // video tag 
        var seekslider = document.getElementById("seekslider" + index);
        var finish_time = $(this).attr('data-finishedtime');
        seektimeupdate(this, seekslider, finish_time, index);
      });
      var finishtime = $("#upload_videotag" + index).attr('data-finishedtime');
      var loaddurtimetext = document.getElementById("durtimetext" + index);
      var loaddurmins = Math.floor(finishtime / 60);
      var loaddursecs = Math.floor(finishtime - loaddurmins * 60);

      if (loaddursecs < 10) {
        loaddursecs = "0" + loaddursecs;
      }

      if (loaddurmins < 10) {
        loaddurmins = "0" + loaddurmins;
      }

      loaddurtimetext.innerHTML = loaddurmins + ":" + loaddursecs;
    });
  }; // Public methods


  return {
    init: function init() {
      rating();
      videoplay();
      archive();
      updateHire();
      restore();
      validateForm();
      sendinvite();
      questioncomments();
      videocontrols();
    }
  };
}(); // On document ready


KTUtil.onDOMContentLoaded(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $("#hire_date").daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    minYear: parseInt(moment().format("YYYY"))
  });
  KTDatatablesServerSide.init();
  $.validator.messages.required = '';
});

function playPause(btn, vid) {
  var vid = document.getElementById(vid);
  var loopid = $(btn).attr('data-loopid');

  if (vid.paused) {
    $('video').each(function (index) {
      $(this).get(0).pause();
      $("#playpausebtn" + index).css('background', "url(/play.png)"); // This can pasue all video records and set to play icon

      $('#videocard' + index).removeClass('overflow-hidden');
      $('#videocard' + index).addClass('overlay-block');
    });
    vid.play(); // btn.innerHTML = "Pause";

    btn.style.background = "url(/pause.png)";
    $('#videocard' + loopid).removeClass('overlay-block');
    $('#videocard' + loopid).addClass('overflow-hidden');
  } else {
    vid.pause(); // btn.innerHTML = "Play";

    btn.style.background = "url(/play.png)";
    $('#videocard' + loopid).removeClass('overflow-hidden');
    $('#videocard' + loopid).addClass('overlay-block');
  }
}

function vidSeek(seekslider, vid, finish_time, index) {
  // console.log(vid.duration);
  var finish_time = finish_time;
  var btn = document.getElementById("playpausebtn" + index);

  if (vid.duration != 'Infinity') {
    finish_time = vid.duration;
  }

  var seekto = finish_time * (seekslider.value / 100);
  vid.currentTime = seekto;

  if (vid.currentTime >= finish_time) {
    btn.style.background = "url(/play.png)";
  }

  var min = seekslider.min;
  var max = seekslider.max;
  var value = seekslider.value;
  seekslider.style.background = "linear-gradient(to right, white 0%, white ".concat((value - min) / (max - min) * 100, "%, #b3b4b5 ").concat((value - min) / (max - min) * 100, "%, #b3b4b5 100%)");

  seekslider.oninput = function () {
    this.style.background = "linear-gradient(to right, white 0%, white ".concat((this.value - this.min) / (this.max - this.min) * 100, "%, #b3b4b5 ").concat((this.value - this.min) / (this.max - this.min) * 100, "%, #b3b4b5 100%)");
  };
}

function seektimeupdate(vid, seekslider, finish_time, index) {
  var curtimetext = document.getElementById("curtimetext" + index);
  var durtimetext = document.getElementById("durtimetext" + index);
  var btn = document.getElementById("playpausebtn" + index);
  var finish_time = finish_time;

  if (vid.duration != 'Infinity') {
    finish_time = vid.duration;
  }

  var nt = vid.currentTime * (100 / finish_time);
  seekslider.value = nt;

  if (vid.currentTime >= finish_time) {
    btn.style.background = "url(/play.png)";
    $('#videocard' + index).removeClass('overflow-hidden');
    $('#videocard' + index).addClass('overlay-block');
  }

  var curmins = Math.floor(vid.currentTime / 60);
  var cursecs = Math.floor(vid.currentTime - curmins * 60);
  var durmins = Math.floor(finish_time / 60);
  var dursecs = Math.floor(finish_time - durmins * 60);

  if (cursecs < 10) {
    cursecs = "0" + cursecs;
  }

  if (dursecs < 10) {
    dursecs = "0" + dursecs;
  }

  if (curmins < 10) {
    curmins = "0" + curmins;
  }

  if (durmins < 10) {
    durmins = "0" + durmins;
  }

  curtimetext.innerHTML = curmins + ":" + cursecs;
  durtimetext.innerHTML = durmins + ":" + dursecs;
  var min = seekslider.min;
  var max = seekslider.max;
  var value = seekslider.value;
  seekslider.style.background = "linear-gradient(to right, #0086FF 0%, #0086FF ".concat((value - min) / (max - min) * 100, "%, #b3b4b5 ").concat((value - min) / (max - min) * 100, "%, #b3b4b5 100%)");

  seekslider.oninput = function () {
    this.style.background = "linear-gradient(to right, #0086FF 0%, #0086FF ".concat((this.value - this.min) / (this.max - this.min) * 100, "%, #b3b4b5 ").concat((this.value - this.min) / (this.max - this.min) * 100, "%, #b3b4b5 100%)");
  };
}
/******/ })()
;
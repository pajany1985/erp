"use strict";

// Class definition
var RecordVideo = function () {
  var max_retry = 10;
  var block_size = 194304;
  var max_threads = 4;
  var maxloop = 0;
  var uploadWorker = new Worker('/js/candidate/uploadWorker.js');
  var curr_threads = 0;
  var logs = [];
  var stack = [];
  var ajaxData = [];
  var intervalId = null;
  var formSubmitButton;
  var stepperform;

  uploadWorker.onmessage = function(e) {
    console.log(e.data);
    const { status, file, index, retry, block, file_name, stepconstid } = e.data;
    curr_threads--;
    console.log('status', status);
    console.log('stepid', stepconstid);
    if (!status) {
      stack.push({ file, index, retry, stepconstid });
      console.log('stack push ');
      console.log(stack);
    } else {
      logs[block] = true;
      ajaxData['data'] = { file_name, stepconstid };
      console.log('check function call ');
      console.log(logs);
      check();
    }
  };

  var loadcurstep_id = document.querySelector(".current").getAttribute("data-stepid");
  var stepid = loadcurstep_id;
  savecandidatelog('question_' + stepid);
  console.log(stepid);
  var countdown = 3;

  $('#stremdiv_' + stepid).html('<video id="streamVideo_' + stepid + '" playsinline autoplay muted width="100%" height="auto" class="no-mirror"> </video>');
  $('#viddiv_' + stepid).html('<video id="playvideo_' + stepid + '"  width="100%" height="auto"> </video>');
  var stepper = document.querySelector("#kt_stepper_example_basic1");
  var stepperobj = new KTStepper(stepper);
  var totalstep = stepperobj.totalStepsNumber;
  console.log('total step ' + totalstep);
  stepperobj.goTo(stepid);

  if (totalstep == stepperobj.getCurrentStepIndex()) {
    $('#submitrecord').css('display', 'block');
    $('#submitrecord').css('pointer-events', 'auto');
  } else {
    $('#submitrecord').css('display', 'none');
    $('#submitrecord').css('pointer-events', 'none');
  }

  stepperobj.on("kt.stepper.next", function (stepper) {
    console.log('total next ' + stepperobj.getCurrentStepIndex());
    stepperobj.goNext();
    streamVideo();
  });

  stepperobj.on("kt.stepper.change", function() {
    console.log('total change ' + stepperobj.getCurrentStepIndex());
    var curntstep = stepperobj.getCurrentStepIndex();
    stepid = stepperobj.getCurrentStepIndex() + 1;
    savecandidatelog('question_' + stepid);

    $('#viddiv_' + curntstep).html('');
    $('#stremdiv_' + curntstep).html('');
    $('#viddiv_' + stepid).html('<video id="playvideo_' + stepid + '"  width="100%" height="auto" > </video>');
    $('#stremdiv_' + stepid).html('<video id="streamVideo_' + stepid + '" playsinline autoplay muted width="100%" height="auto" class="no-mirror"> </video>');
    $('.stoprecord').prop('disabled', true);
    $('.stoprecord').css('display', 'none');
    $('.stoprecord').removeClass('btn-danger');
    $('.stoprecord').addClass('btn-dark');
    $('.startrecord').prop('disabled', false);
    $('.startrecord').css('display', '');
    $('.startfunction').show();
    $('.completefunction').hide();
    countdown = 3;

    if (totalstep == stepid) {
      $('#submitrecord').css('display', 'block');
      $('#submitrecord').css('pointer-events', 'auto');
    }
  });

  stepperobj.on("kt.stepper.previous", function (stepper) {
    stepperobj.goPrevious();
  });

  var streamBlock = document.querySelector("#streamBlock_" + stepid);
  var playBlock = document.querySelector("#playvideo_" + stepid);
  var StrblockUI;
  const recordButton = document.querySelector('button#record_' + stepid);
  var IntrcountDwn;
  var timerInterval;
  // const mimeType = 'video/webm;codecs=h264,opus';
  var newmimeType;
  let mediaRecorder;
  // let recordedBlobs;
  let recordedBlobs = [];
  var fineshedTime;
  var reTake = 0;
  var playvideo_source;
  var overlaytarget = document.querySelector("#kt_content_container");
  var overlayblockUI = new KTBlockUI(overlaytarget, {
    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span><span class="process_content">Processing Video</span></div>',
  });

  // new 
  let chunkCount = 0;
  let successfulUploads = 0;
  let totalChunks = 0;
  let start = 0;
  let pendingChunks = new Map();
  let filename; // Replace with your actual filename
  let stepconstid; 
  let mimeType = 'video/mp4; codecs="avc1.42E01E, mp4a.40.2"';
  let chunkmimedatatype='';
  // new end


  var extension='.mp4';

    const userAgent = navigator.userAgent || navigator.vendor || window.opera;
    console.log('userAgent');
    console.log(userAgent);
    // alert(userAgent);
    if (/iPad|iPhone|iPod|Macintosh/.test(userAgent)) {
        // iOS or macOS
        mimeType = 'video/mp4; codecs="avc1.42E01E, mp4a.40.2"';
        extension='.mp4';
        
    } else if (/Windows/.test(userAgent)) {
        // Windows
        mimeType = 'video/webm; codecs=vp8, opus';
        extension='.webm';
    } else {
        // Default to MP4 if the OS is not identified (e.g., Linux or other systems)
        mimeType = 'video/webm; codecs=vp8, opus';
        extension='.webm';
    }
    console.log(extension);

  var startTimer = function startTimer() {
    var timemin = $('.countdown_' + stepid).attr('data-timecount');
    var minsec = $('.countdown_' + stepid).attr('data-minsec');
    var timer2 = timemin + ":01";
    var secondsinc_count = 0;
    timerInterval = setInterval(function () {
      var timer = timer2.split(':');
      var minutes = parseInt(timer[0], 10);
      var seconds = parseInt(timer[1], 10);
      --seconds;
      secondsinc_count++;
      minutes = seconds < 0 ? --minutes : minutes;
      seconds = seconds < 0 ? 59 : seconds;
      seconds = seconds < 10 ? '0' + seconds : seconds;

      if (secondsinc_count >= minsec) {
        $('.stoprecord').prop('disabled', false);
        $('.stoprecord').removeClass('btn-dark');
        $('.stoprecord').addClass('btn-danger');
      }

      $('#recorded_sec_' + stepid).val(secondsinc_count);
      $('.countdown_' + stepid).html(' ' + minutes + 'M ' + seconds + 'S');

      if (seconds <= 0 && minutes <= 0) { clearInterval(timerInterval); stopRecording() }
      timer2 = minutes + ':' + seconds;
    }, 1000);
  };

  var recordCountDown = function recordCountDown() {
    $('#counter_' + stepid).show();
    if (countdown == 0) {
      clearInterval(IntrcountDwn);
      startRecording();
    } else {
      document.getElementById("counter_" + stepid).innerHTML = countdown;
    }
    countdown = countdown - 1;
  };

  var startRecording = function startRecording() {
    recordedBlobs = [];
    $('#msg').hide();

    try {
      mediaRecorder = new MediaRecorder(window.stream,{mimeType: mimeType,
        videoBitsPerSecond: 1500000, // Lower bitrate for compatibility
        audioBitsPerSecond: 96000 // Standard bitrate for AAC
      });
    } catch (e) {
      console.error('Exception while creating MediaRecorder:', e);
      return;
    }

    //test
    mediaRecorder.start(1000);

    mediaRecorder.onstop = async (event) => {
      await confirmAllChunksUploaded();
      recordplay();
      console.log('Recorder stopped: ', event);
      console.log('Recorded Blobs: ', recordedBlobs);
    };

    mediaRecorder.onstart = (event) => {
      // test
      // mimeType = mediaRecorder.mimeType || 'video/webm';
      
      // let extension;
  
      // // mimeType = 'video/mp4'
      // extension = '.mp4';
      var timedisplay = $('.countdown_' + stepid).attr('data-timedisplay');
      $('#counter_' + stepid).hide();
      $('.startrecord').hide();
      $('#streamBlock_' + stepid).removeClass('overlay-block');
      $('.countdown_' + stepid).html(timedisplay);
      $('.timecount_' + stepid).css('display', 'block');
      $('.stoprecord').css('display', '');
      startTimer();
      var today = new Date();
      const year = today.getFullYear();
      const month = (today.getMonth() + 1);
      const d = today.getDate();
      const hour = today.getHours();
      const mins = today.getMinutes();
      const sec = today.getSeconds();
      let randvalue = Math.floor((Math.random() * 100000) + 1);
      // filename = year + '' + month + '' + d + '' + hour + '' + mins + '' + sec + '' + randvalue + ".mp4";
      filename = `${year}${month}${d}${hour}${mins}${sec}${randvalue}${extension}`;
      stepconstid =stepid;
      console.log('stepconstid',stepconstid);
      console.log('filename',filename);
    };

    // mediaRecorder.ondataavailable = handleDataAvailable;

      mediaRecorder.ondataavailable = event => {
        if (event.data && event.data.size > 0) {
              // pendingChunks.push({ data: event.data, start });
              // sendChunkToServer(event.data, start, filename, stepconstid);
              // start += event.data.size;
              const chunk = { data: event.data, start, filename, stepconstid };
              console.log(chunk);
              pendingChunks.set(start, chunk);
              sendChunkToServer(chunk);
              start += event.data.size;
              console.log('MIME type:', chunk.data.type);
              chunkmimedatatype=chunk.data.type;
          }
      };

      function sendChunkToServer(chunk) {
        const formData = new FormData();
        formData.append('blob', chunk.data);
        formData.append('start', chunk.start);
        formData.append('filename', chunk.filename);
        formData.append('stepconstid', chunk.stepconstid);
        formData.append('api_token', $('#auth_token_' + chunk.stepconstid).val());
        formData.append('cid', $('#cid_' + chunk.stepconstid).val());
        formData.append('qid', $('#qid_' + chunk.stepconstid).val());
    
        $.ajax({
            url: '/api/savevideo', // Your server endpoint
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.status === true) {
                    console.log('Chunk uploaded successfully:', data);
                    pendingChunks.delete(chunk.start);
                    recordedBlobs.push(chunk.data); // Keep track of uploaded chunks
                } else {
                    console.error('Chunk upload failed:', data.message);
                    // Retry uploading the chunk if it failed
                    setTimeout(() => sendChunkToServer(chunk), 1000);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error uploading chunk:', error);
                // Retry uploading the chunk in case of error
                setTimeout(() => sendChunkToServer(chunk), 1000);
            }
        });
      }

        function confirmAllChunksUploaded() {
          const checkInterval = setInterval(() => {
              if (pendingChunks.size === 0) {
                  clearInterval(checkInterval);
                  console.log('All chunks have been uploaded successfully.');
                  saveFileNameToDatabase(filename, stepconstid);
              } else {
                  console.log('Waiting for all chunks to be uploaded...');
              }
          }, 1000); // Check every second
        }


        function saveFileNameToDatabase(filename, stepconstid) {
          // alert(chunkmimedatatype);
          $.ajax({
              url: "/api/savevideoattempt",
              method: "post",
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              data: {
                  "recorded_sec": $('#recorded_sec_' + stepconstid).val(),
                  "cid": $('#cid_' + stepconstid).val(),
                  "qid": $('#qid_' + stepconstid).val(),
                  "file_name": filename,
                  "api_token": $('#auth_token_' + stepconstid).val()
              },
              success: function(data) {
                  console.log('Save video attempt success: ', data);
                  
                  if (data.success == '1') {
                      // Swal.fire({
                      //     icon: 'success',
                      //     title: 'Success',
                      //     text: 'Video saved successfully!',
                      //     customClass: {
                      //         confirmButton: "btn btn-success",
                      //     }
                      // });
                      overlayblockUI.release();
                  } else {
                      Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Something went wrong, Please try again',
                          customClass: {
                              confirmButton: "btn btn-danger",
                          }
                      }).then(() => {
                          window.location.reload();
                      });
                  }
              },
              error: function(xhr, status, error) {
                  console.error('Error saving video attempt: ', error);
                  Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Something went wrong, Please try again',
                      customClass: {
                          confirmButton: "btn btn-danger",
                      }
                  }).then(() => {
                      window.location.reload();
                  });
              }
          });
        }

    //   async function sendChunkToServer(chunk) {
    //     const formData = new FormData();
    //     formData.append('blob', chunk.data);
    //     formData.append('start', chunk.start);
    //     formData.append('filename', chunk.filename);
    //     formData.append('stepconstid', chunk.stepconstid);
    //     formData.append('api_token', $('#auth_token_' + stepconstid).val());
    //     formData.append('cid', $('#cid_' + stepconstid).val());
    //     formData.append('qid', $('#qid_' + stepconstid).val());

    //     try {
    //         const response = await fetch('/api/savevideo', { // Update with your server endpoint
    //             method: 'POST',
    //             headers: {
    //               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // Add CSRF token here
    //           },
    //             body: formData
    //         });
    //         const data = await response.json();
    //         if (data.status === true) {
    //             console.log('Chunk uploaded successfully:', data);
    //             pendingChunks.delete(chunk.start);
    //             recordedBlobs.push(chunk.data); // Keep track of uploaded chunks
    //         } else {
    //             console.error('Chunk upload failed:', data.message);
    //             // Retry uploading the chunk if it failed
    //             setTimeout(() => sendChunkToServer(chunk), 1000);
    //         }
    //     } catch (error) {
    //         console.error('Error uploading chunk:', error);
    //         // Retry uploading the chunk in case of error
    //         setTimeout(() => sendChunkToServer(chunk), 1000);
    //     }
    // }

    // async function confirmAllChunksUploaded() {
    //     while (pendingChunks.size > 0) {
    //         await new Promise(resolve => setTimeout(resolve, 1000)); // Wait for 1 second
    //         console.log('Waiting for all chunks to be uploaded...');
    //     }
    //     console.log('All chunks have been uploaded successfully.');
    //     saveFileNameToDatabase(filename, stepconstid);
    // }

    // function saveFileNameToDatabase(filename, stepconstid) {
    //   $.ajax({
    //       url: "/api/savevideoattempt",
    //       method: "post",
    //       headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // Add CSRF token here
    //     },
    //       data: {
    //           "recorded_sec": $('#recorded_sec_' + stepconstid).val(),
    //           "cid": $('#cid_' + stepconstid).val(),
    //           "qid": $('#qid_' + stepconstid).val(),
    //           "file_name": filename,
    //           "api_token": $('#auth_token_' + stepconstid).val()
    //       },
    //       success: function(data) {
    //           console.log('Save video attempt success: ', data);
    //           if (data.success == '1') {
    //               Swal.fire({
    //                   icon: 'success',
    //                   title: 'Success',
    //                   text: 'Video saved successfully!',
    //                   customClass: {
    //                       confirmButton: "btn btn-success",
    //                   }
    //               });
    //           } else {
    //               Swal.fire({
    //                   icon: 'error',
    //                   title: 'Oops...',
    //                   text: 'Something went wrong, Please try again',
    //                   customClass: {
    //                       confirmButton: "btn btn-danger",
    //                   }
    //               }).then(() => {
    //                   window.location.reload();
    //               });
    //           }
    //       },
    //       error: function(xhr, status, error) {
    //           console.error('Error saving video attempt: ', error);
    //           Swal.fire({
    //               icon: 'error',
    //               title: 'Oops...',
    //               text: 'Something went wrong, Please try again',
    //               customClass: {
    //                   confirmButton: "btn btn-danger",
    //               }
    //           }).then(() => {
    //               window.location.reload();
    //           });
    //       }
    //   });
    // }

  };

  var stopRecording = function stopRecording() {
    mediaRecorder.stop();

    overlayblockUI.block();

    stream.getVideoTracks()[0].stop();
    stream.getAudioTracks()[0].stop();

    $('.timecount_' + stepid).css('display', 'none');
    $('.startfunction').css('display', 'none');

    var attempt = $('.attempt_' + stepid).attr('data-attempt');
    if (attempt >= 1) {
      attempt = attempt - 1;
    } else {
      attempt = 0;
    }

    $('.attempt_' + stepid).html(attempt);
    $('.attempt_' + stepid).attr('data-attempt', attempt);

    clearInterval(timerInterval);
  };

  var startCountdown = function startCountdown() {
    $('.startrecord').prop('disabled', true);
    IntrcountDwn = setInterval(function () { recordCountDown() }, 1000);
  };

  var mincount = function mincount() {
    var interval;
    $(document).on("click", ".startrecord", function (e) {
      $('.notrecording_' + stepid).hide();
      startCountdown();
    });

    $(document).on("click", ".stoprecord", function (e) {
      stopRecording();
    });

    $(document).on("click", ".backto_overview_" + stepid, function(e) {
      $.ajax({
        url: "/removesession",
        method: "post",
      }).then(function(response3) {
        window.location.replace('/overview');
      });
    });

    $(document).on("click", ".retakerecord", function(e) {
      reTake = '1';
      savecandidatelog('question_' + stepid + '_retake');
      $('#playblock_' + stepid).hide();
      $('#streamBlock_' + stepid).show();
      $('#streamBlock_' + stepid).addClass('overlay-block');
      $('.completefunction').hide();
      $('.startfunction').show();
      $('.stoprecord').prop('disabled', true);
      $('.stoprecord').removeClass('btn-danger');
      $('.stoprecord').addClass('btn-dark');
      clearInterval(timerInterval);
      streamVideo();
      countdown = 3;
      startCountdown();
    });
  };

  function recordplay() {
    $('#streamBlock_' + stepid).hide();
    $('#playblock_' + stepid).removeClass('d-none');
    $('#playblock_' + stepid).show();
    const superBuffer = new Blob(recordedBlobs, { type: mimeType  });
    playvideo_source = document.getElementById('playvideo_' + stepid);
    playvideo_source.setAttribute('src', window.URL.createObjectURL(superBuffer));

    var attmptleft_cnt = $('.attempt_' + stepid).attr('data-attempt');
    if (attmptleft_cnt <= 0) {
      $('.startfunction').hide();
      $('.submitrecord, .completerecord').removeClass('w-75');
      $('.submitrecord, .completerecord').addClass('w-100');
      $('.mid_div').removeClass('w-25px');
      $('.retakerecord').hide();
    } else {
      $('.submitrecord, .completerecord').removeClass('w-100');
      $('.submitrecord, .completerecord').addClass('w-75');
      $('.mid_div').addClass('w-25px');
      $('.retakerecord').show();
    }
    $('.current').addClass('curntcomplete');
    $('.completefunction').css('display', 'block');

    $(document).on("click", ".videodiv_" + stepid, function(e) {
      $('#playvideo_' + stepid).trigger('play');
      $('#videoplay_' + stepid).css('display', 'none');
      $('#custom-opacity_' + stepid).css('opacity', '0');

      var videoended = document.getElementById("playvideo_" + stepid);
      videoended.onended = function() {
        $('#videoplay_' + stepid).css('display', 'block');
        $('#custom-opacity_' + stepid).css('opacity', '1');
      };
    });
  }

  var completeAllQuestion = function() {
    $(document).on("click", "#submitrecord", function(e) {
      var candidate_id = $('#candid_id').val();
      $('#submitrecord').html('Please wait...');
      $('#submitrecord').css('pointer-events', 'none');
      $('#submitrecord').css('display', 'none');
      $('.completefunction').hide();

      $.ajax({
        url: "/updatecompleteqstn",
        method: "post",
        data: { "candidate_id": candidate_id },
        success: function(data) {
          savecandidatelog('allquestion_completed');
          $('#submitrecord').html('Submit');
          if (data.success == '1') {
            window.location.replace('/thankyou');
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong, Please try again',
              customClass: {
                confirmButton: "btn btn-danger",
              }
            })
          }
        }
      });
    });
  }

  var setQuestionIndex = function() {
    $(document).on("click", ".qstndetail", function(e) {
      var qstn_index = $(this).attr('data-indexid');
      var qstn_url = $(this).attr('data-url');
      $.ajax({
        url: "setqstnsessionindex",
        method: "post",
        data: { qstn_index: qstn_index }
      }).then(function(response3) {
        window.location.replace(qstn_url);
      });
    });

    $(document).on("click", ".backto_overview", function(e) {
      $.ajax({
        url: "/removesession",
        method: "post",
      }).then(function(response3) {
        window.location.replace('/overview');
      });
    });
  }

  var showLoader = function showLoader(elem) {
    StrblockUI = new KTBlockUI(elem);
    StrblockUI.block();
  }

  var hideLoader = function hideLoader(elem) {
    StrblockUI.release();
  }

  var streamVideo = async function streamVideo() {
    try {
      const constraints = {
        audio: { echoCancellation: { exact: 1 } },
        video: {
          width: { ideal: 640 },
          height: { ideal: 480 },
          frameRate: { ideal: 15, max: 15 }
        }
      };

      const stream = await navigator.mediaDevices.getUserMedia(constraints);
      handleSuccess(stream);
    } catch (e) {
      Swal.fire({
        text: "We're having trouble connecting to your hardwares, Please try again or switch to a different device.",
        icon: "warning",
        buttonsStyling: true,
        confirmButtonText: "Ok",
        customClass: {
          confirmButton: "btn btn-danger"
        }
      }).then((willDelete) => {
        $.ajax({
          url: "/runtestsession",
          method: "post",
          data: { runtest: '' }
        }).then(function(data) {
          window.location = "/overview";
        });
      });
    }

    $(document).on("click", "#send", function (e) {
      uploadtest();
    });
  };

  var handleDataAvailable = function handleDataAvailable(event) {
    newmimeType = event.data.type;
    if (event.data && event.data.size > 0) {
      recordedBlobs.push(event.data);
      uploadtest();
      recordplay();
    }
  }

  var savevideo = function savevideo() {
    const blobfile = new Blob(recordedBlobs, { type: 'video/webm' });
    var formData = new FormData();
    formData.append('video-blob', blobfile);
    formData.append('cid', $('#cid_' + stepid).val());
    formData.append('api_token', $('#auth_token_' + stepid).val());
    formData.append('qid', $('#qid_' + stepid).val());
    $.ajax({
      type: 'POST',
      url: '/api/savevideo',
      enctype: 'multipart/form-data',
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: function() {
        // toastr.success("Downloading Video");
      },
    }).done(function(data) {
      $('.attempt_' + stepid).html(data.attempt_left)
      overlayblockUI.release();

      if (data.attempt_left <= 0) {
        $('.startfunction').hide();
        $('.submitrecord, .completerecord').removeClass('w-75');
        $('.submitrecord, .completerecord').addClass('w-100');
        $('.mid_div').removeClass('w-25px');
        $('.retakerecord').hide();
      } else {
        $('.submitrecord, .completerecord').removeClass('w-100');
        $('.submitrecord, .completerecord').addClass('w-75');
        $('.mid_div').addClass('w-25px');
        $('.retakerecord').show();
      }
      $('.completefunction').css('display', 'block');
    });
  };

  var handleSuccess = function handleSuccess(stream) {
    window.stream = stream;
    const strvid = document.querySelector('video#streamVideo_' + stepid);
    strvid.srcObject = stream;
    $('.notrecording_' + stepid).hide();
    if (reTake == '0') {
      $('.notrecording_' + stepid).show();
    }
  }

  var uploadtest = function() {
    var result = [];
    var resultCount = 0;
    var today = new Date();
    const year = today.getFullYear();
    const month = (today.getMonth() + 1);
    const d = today.getDate();
    const hour = today.getHours();
    const mins = today.getMinutes();
    const sec = today.getSeconds();
    let randvalue = Math.floor((Math.random() * 100000) + 1);
    var filname = year + '' + month + '' + d + '' + hour + '' + mins + '' + sec + '' + randvalue;
    const file = new File(recordedBlobs, filname + ".mp4", { type: newmimeType });
    var stepidconst = document.querySelector(".current").getAttribute("data-stepid");

    var max = Math.ceil(file.size / block_size);
    maxloop = max;
    for (var i = 0; i < max; i++) {
      logs[i] = false;
    }

    for (var i = 0; i < max; i++) {
      stack.push({ file, index: i, retry: 0 });
    }

    intervalId = setInterval(function() { loopAjax(stepidconst); }, 10);
  };

  var sendAjax = function(file, index, retry) {
    curr_threads++;
    if (retry > max_retry) {
      console.log('failed index ' + index);
      return;
    }

    var blob = file.slice(block_size * index, block_size * (index + 1));
    var fd = new FormData();
    fd.append('filename', file.name);
    fd.append('start', block_size * index);
    fd.append('size', file.size);
    fd.append('block', index);
    fd.append('blob', blob);
    fd.append('retry', retry);
    fd.append('cid', $('#cid_' + stepid).val());
    fd.append('api_token', $('#auth_token_' + stepid).val());
    fd.append('qid', $('#qid_' + stepid).val());
    fd.append('maxloop', maxloop);

    $.ajax({
      type: 'post',
      data: fd,
      processData: false,
      contentType: false,
      dataType: 'json',
      url: '/api/savevideo',
      success: function(data) {
        curr_threads--;
        if (!data.status) {
          pushAjax(file, index, retry + 1);
        } else {
          logs[data.block] = true;
          ajaxData['data'] = data;
          check();
        }
      },
      error: function() {
        curr_threads--;
        pushAjax(file, index, retry + 1);
      }
    });
  };

  var loopAjax = function(stepidconst) {
    console.log('loopajax run');
    console.log("stepidconst ", stepidconst);
    if (curr_threads < max_threads) {
      var task = stack.shift();
      if (task) {
        curr_threads++;
        task.block_size = block_size;
        task.max_retry = max_retry;
        task.api_data = {
          cid: $('#cid_' + stepidconst).val(),
          api_token: $('#auth_token_' + stepid).val(),
          qid: $('#qid_' + stepidconst).val(),
          maxloop: maxloop,
          stepid: stepidconst
        };
        uploadWorker.postMessage(task);
      }
    }
  };

  var check = function() {
    var dataajax = ajaxData['data'];
    var status = true;
    console.log(logs);
    $.each(logs, function(index, value) {
      if (!value) {
        status = false;
        return false;
      }
    });

    if (status) {
      clearInterval(intervalId);
      $.ajax({
        url: "/api/savevideoattempt",
        method: "post",
        data: {
          "recorded_sec": $('#recorded_sec_' + dataajax.stepconstid).val(),
          "cid": $('#cid_' + dataajax.stepconstid).val(),
          "qid": $('#qid_' + dataajax.stepconstid).val(),
          "file_name": dataajax.file_name,
          "api_token": $('#auth_token_' + stepid).val()
        },
        success: function(data) {
          console.log('success check function ');
          console.log(data);
          if (data.success == '1') {
            if (totalstep == stepid) {
              // overlayblockUI.release();
            }
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong, Please try again',
              customClass: {
                confirmButton: "btn btn-danger",
              }
            }).then((willDelete) => {
              window.location.reload();
            });
          }
        }
      });
    }
  };

  return {
    init: function () {
      mincount();
      streamVideo();
      completeAllQuestion();
    }
  }
}();

KTUtil.onDOMContentLoaded(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": true,
    "progressBar": false,
    "positionClass": "toastr-top-center",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "300",
    "timeOut": "1000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  };

  RecordVideo.init();
});

function savecandidatelog(action) {
  var width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
  var height = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
  var screenresolution = width + ' x ' + height;
  var currentURL = window.location.href;
  var candidate_id = $('#candid_id').val();
  fetch('https://api.ipify.org/?format=json')
    .then(response => response.json())
    .then(data => {
      var clientIP = data.ip;
      console.log("Client IP Address: " + clientIP);
      $.ajax({
        url: "/savecandidatelog",
        method: "post",
        data: { "screenresolution": screenresolution, action, currentURL, candidate_id, clientIP },
        success: function(data) {
          if (data.success == '1') {
            console.log('saved');
          } else {
            console.log('not saved');
          }
        }
      });
    });
}

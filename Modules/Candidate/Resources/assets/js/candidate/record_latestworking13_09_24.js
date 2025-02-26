"use strict";
// Class definition
var RecordVideo = function () {

  var max_retry = 10;
var block_size = 194304;
var max_threads = 4;
var maxloop = 0;

var curr_threads = 0;
var logs = [];
var stack = [];
var ajaxData = [];
var intervalId = null;
var formSubmitButton;

var stepperform;


  var loadcurstep_id = document.querySelector(".current").getAttribute("data-stepid");
  
    var stepid =loadcurstep_id;
    savecandidatelog('question_'+stepid);
    console.log(stepid);
    var countdown  =  3;

      $('#stremdiv_'+stepid).html('<video id="streamVideo_'+stepid+'" playsinline autoplay muted width="100%" height="auto" class="no-mirror"> </video>');
      $('#viddiv_'+stepid).html('<video id="playvideo_'+stepid+'"  width="100%" height="auto"> </video>');
      // Stepper lement
      var stepper = document.querySelector("#kt_stepper_example_basic1");

      // Initialize Stepper
      var stepperobj = new KTStepper(stepper);
      var totalstep = stepperobj.totalStepsNumber;
      console.log('total step '+totalstep);
    
      stepperobj.goTo(stepid);
      if(totalstep==stepperobj.getCurrentStepIndex()){
        $('#submitrecord').css('display','block');
        $('#submitrecord').css('pointer-events','auto');
      }else{
        $('#submitrecord').css('display','none');
        $('#submitrecord').css('pointer-events','none');
        
      }
    
      // Handle next step
      stepperobj.on("kt.stepper.next", function (stepper) {
        console.log('total next '+stepperobj.getCurrentStepIndex());
        stepperobj.goNext(); // go next step
        streamVideo();
        // completeAllQuestion();
        
        
      });
 
    stepperobj.on("kt.stepper.change", function() {
      console.log('total change '+stepperobj.getCurrentStepIndex());
      var curntstep = stepperobj.getCurrentStepIndex();
      stepid = stepperobj.getCurrentStepIndex()+1;

      savecandidatelog('question_'+stepid);

      $('#viddiv_'+curntstep).html('');
      $('#stremdiv_'+curntstep).html('');

      $('#viddiv_'+stepid).html('<video id="playvideo_'+stepid+'"  width="100%" height="auto"> </video>');
      $('#stremdiv_'+stepid).html('<video id="streamVideo_'+stepid+'" playsinline autoplay muted width="100%" height="auto" class="no-mirror"> </video>');
     
      $('.stoprecord').prop('disabled', true); 
      $('.stoprecord').css('display', 'none');// Stop Button
      $('.stoprecord').removeClass('btn-danger');
      $('.stoprecord').addClass('btn-dark');

      $('.startrecord').prop('disabled', false);
      $('.startrecord').css('display', '');// Start Button Block
      
      $('.startfunction').show();// Start and stop Block
      $('.completefunction').hide(); // Retake and Submit or Continue Block
      countdown = 3;
      
      if(totalstep==stepid){
        $('#submitrecord').css('display','block');
        $('#submitrecord').css('pointer-events','auto');
      }

    });
  
    // Handle previous step
    stepperobj.on("kt.stepper.previous", function (stepper) {
      stepperobj.goPrevious(); // go previous step
    });

    // Shared variables
    var streamBlock = document.querySelector("#streamBlock_"+stepid)
    var playBlock = document.querySelector("#playvideo_"+stepid)
    var StrblockUI;
    const recordButton = document.querySelector('button#record_'+stepid);
    var IntrcountDwn;
    var timerInterval;
    // const mimeType = 'video/webm;codecs=h264,opus';
    let mimeType;
    // const mimeType = 'video/webm;codecs=vp8,opus';
    var newmimeType;
    let mediaRecorder;
    let recordedBlobs;

    var fineshedTime;
    var reTake = 0;
    var playvideo_source;
    var overlaytarget = document.querySelector("#kt_content_container");
    var overlayblockUI = new KTBlockUI(overlaytarget, {
        message: '<div class="blockui-message"><span class="spinner-border text-primary"></span><span class="process_content">Processing Video</span></div>',
    });

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


      var timemin = $('.countdown_'+stepid).attr('data-timecount');
      var minsec = $('.countdown_'+stepid).attr('data-minsec');
      

      var timer2 = timemin + ":01";
      var secondsinc_count = 0;
      timerInterval = setInterval(function () {
        var timer = timer2.split(':'); //by parsing integer, I avoid all extra string processing

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
        } //minutes = (minutes < 10) ?  minutes : minutes;

        $('#recorded_sec_'+stepid).val(secondsinc_count);
        $('.countdown_'+stepid).html(' ' + minutes + 'M ' + seconds + 'S');
        //if (minutes < 0) clearInterval(timerInterval); //check if both minutes and seconds are 0

        if (seconds <= 0 && minutes <= 0) { clearInterval(timerInterval); stopRecording() }
        timer2 = minutes + ':' + seconds;
      }, 1000);


    }


    var recordCountDown =   function recordCountDown() {
      $('#counter_'+stepid).show(); 



      if(countdown == 0) {
       clearInterval(IntrcountDwn);


       startRecording();


     } else {
      document.getElementById("counter_"+stepid).innerHTML = countdown;
    }


    countdown = countdown - 1;


  }


  var startRecording = function startRecording() {
   
    recordedBlobs = [];


    //const options = {mimeType};
    $('#msg').hide();

    try {
      mediaRecorder = new MediaRecorder(window.stream,{mimeType: mimeType,
        videoBitsPerSecond: 1500000, // Lower bitrate for compatibility
        audioBitsPerSecond: 96000 // Standard bitrate for AAC
      });
    } catch (e) {
      //alert('Exception while creating MediaRecorder:', e)
      console.error('Exception while creating MediaRecorder:', e);
      //errorMsgElement.innerHTML = `Exception while creating MediaRecorder: ${JSON.stringify(e)}`;
      return;
    }



    mediaRecorder.start();
    //console.log('Created MediaRecorder', mediaRecorder, 'with options', options);
    mediaRecorder.onstop = (event) => {
      console.log('Recorder stopped: ', event);
      console.log('Recorded Blobs: ', recordedBlobs);
    };

  mediaRecorder.onstart = (event) => {
    var timedisplay = $('.countdown_'+stepid).attr('data-timedisplay');
    $('#counter_'+stepid).hide(); 
    $('.startrecord').hide(); 
    $('#streamBlock_'+stepid).removeClass('overlay-block');
    $('.countdown_'+stepid).html(timedisplay);
    $('.timecount_'+stepid).css('display', 'block');
    $('.stoprecord').css('display', '');//stop record block
    startTimer();

  };

  mediaRecorder.ondataavailable = handleDataAvailable;
  
}


var stopRecording = function stopRecording() {
  
  mediaRecorder.stop();
  overlayblockUI.block();
  stream.getVideoTracks()[0].stop();
  stream.getAudioTracks()[0].stop();


  $('.timecount_'+stepid).css('display', 'none');
  $('.startfunction').css('display', 'none');
  
  var attempt = $('.attempt_'+stepid).attr('data-attempt');

  if (attempt >= 1) {
    attempt = attempt - 1;
  } else {
    attempt = 0;

  }

  $('.attempt_'+stepid).html(attempt);
  $('.attempt_'+stepid).attr('data-attempt', attempt);
  //toastr.success("Video Processing started");

  clearInterval(timerInterval);
}

  var startCountdown = function startCountdown() {

    $('.startrecord').prop('disabled', true);

    IntrcountDwn =   setInterval(function() { recordCountDown()}, 1000);
  }

    var mincount = function mincount() {
      var interval;
      $(document).on("click", ".startrecord", function (e) {

        $('.notrecording_'+stepid).hide(); 
        startCountdown();
            //startTimer(); 
      });

      $(document).on("click", ".stoprecord", function (e) {



        stopRecording();



      });

      $(document).on("click", ".backto_overview_"+stepid, function(e) {

        //ajax call 
        $.ajax({
          url: "/removesession",
          method:"post",
        }).then(function(response3) {
          window.location.replace('/overview');
        });  
        
      });
      
      $(document).on("click", ".retakerecord", function(e) {

        reTake = '1';
        savecandidatelog('question_'+stepid+'_retake');
        $('#playblock_'+stepid).hide();
        $('#streamBlock_'+stepid).show();
        $('#streamBlock_'+stepid).addClass('overlay-block');
        $('.completefunction').hide();
        $('.startfunction').show();

        $('.stoprecord').prop('disabled', true);
        $('.stoprecord').removeClass('btn-danger');
        $('.stoprecord').addClass('btn-dark');

        clearInterval(timerInterval);
        streamVideo();
        countdown = 3
        startCountdown();

      });
    };

  function recordplay() {

    $('#streamBlock_'+stepid).hide();
    $('#playblock_'+stepid).removeClass('d-none')  ;
    $('#playblock_'+stepid).show();
    //const mimeType = mimeType.split(';', 1)[0];
    const superBuffer = new Blob(recordedBlobs,{type: newmimeType});
    playvideo_source = document.getElementById('playvideo_'+stepid);
    playvideo_source.setAttribute('src', window.URL.createObjectURL(superBuffer));
    //console.log(superBuffer);
    // playvideo.src = null;
    // playvideo.srcObject = null;
    // playvideo.src = window.URL.createObjectURL(superBuffer);
    // playvideo.controls = true;
    //playvideo.play();

    $(document).on("click", ".videodiv_"+stepid, function(e) {

      $('#playvideo_'+stepid).trigger('play');
      $('#videoplay_'+stepid).css('display','none');
      $('#custom-opacity_'+stepid).css('opacity', '0');
      
      
      var videoended = document.getElementById("playvideo_"+stepid);
      videoended.onended = function() {
        $('#videoplay_'+stepid).css('display','block');
        $('#custom-opacity_'+stepid).css('opacity', '1');
      };
      
    });

  }

  var completeAllQuestion = function(){


      $(document).on("click", "#submitrecord", function(e) {

        
          // $(this).setAttribute('data-kt-indicator', 'on');
          // $(this).prop("disabled", true);
          var candidate_id = $('#candid_id').val();

          // $('.submitrecord').attr('data-kt-indicator', 'on');
          // $('.submitrecord').attr('disabled', 'true');
          $('#submitrecord').html('Please wait...');
          $('#submitrecord').css('pointer-events','none');
          $('#submitrecord').css('display','none');
          $('.completefunction').hide();
          
            $.ajax({
              url:"/updatecompleteqstn",
              method:"post",
              data: { "candidate_id": candidate_id},
              success:function(data)
              {
                savecandidatelog('allquestion_completed');
                $('#submitrecord').html('Submit');
                
                  if(data.success == '1'){
                      window.location.replace('/thankyou');
                  }else{

                      Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Something went wrong, Please try agin',
                          customClass: {
                              confirmButton: "btn btn-danger",
                          }
                        })
                  }
              }
          });

      });
    
}

var setQuestionIndex = function(){
  $(document).on("click", ".qstndetail", function(e) {

    var qstn_index =  $(this).attr('data-indexid');
    var qstn_url =  $(this).attr('data-url');
            //ajax call 
            $.ajax({
              url: "setqstnsessionindex",
              method:"post",
              data: { qstn_index: qstn_index }
            }).then(function(response3) {
              window.location.replace(qstn_url);

            });  
            
          });

  $(document).on("click", ".backto_overview", function(e) {

            //ajax call 
            $.ajax({
              url: "/removesession",
              method:"post",
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

 //showLoader(streamBlock);

//  navigator.permissions.query({name: 'camera'}).then(function (result) {
//   if (result.state == 'granted') {
//     console.log('granted');
//   } else if (result.state == 'prompt') {
//     console.log('promt');
//   } else if (result.state == 'denied') {
//     console.log('denied');
//   }
//   result.onchange = function () {};
// });


 try {
  // const constraints = {
  //   audio: {
  //     echoCancellation: {exact: 1}
  //   },
  //   video: { "width":  "320", "height":  "240"}
  
  // };

  // const constraints = {
  //   audio: { echoCancellation: { exact: 1 } },
  //   video: {
  //     width: { ideal: 640 },
  //     height: { ideal: 480 },
  //     frameRate: { ideal: 15, max: 15 }
  //   }
  // };

  const constraints = {
    audio: { echoCancellation: true },  // Simplified audio constraint
    video: {
      width: { ideal: 320, max: 480 },  // Lower the resolution to 320x240 (or 480p max)
      height: { ideal: 240, max: 360 }, // This will significantly reduce the video file size
      frameRate: { ideal: 10, max: 12 } // Lower the frame rate to 10-12fps for smaller size
    }
  };

  const stream = await navigator.mediaDevices.getUserMedia(constraints);
  handleSuccess(stream);
} catch (e) {

  Swal.fire({
    text: "We're having trouble connecting to your hardwares, Please try again or switch to different device.",
    icon: "warning",
    buttonsStyling: true,
    confirmButtonText: "Ok",
    customClass: {
      confirmButton: "btn btn-danger"
    }
  }).then((willDelete) => {

    $.ajax({
      url: "/runtestsession",
      method:"post",
      data:{runtest:''}
    }).then(function(data) {
      window.location = "/overview";
    });
   
  });
        //console.error('navigator.getUserMedia error:', e);
    //errorMsgElement.innerHTML = `navigator.getUserMedia error:${e.toString()}`;
  }

  $(document).on("click", "#send", function (e) {

  
    uploadtest();
        //startTimer(); 
  });

};  


var handleDataAvailable = function handleDataAvailable(event) {
    //console.log('handleDataAvailable', event);
    newmimeType = event.data.type;
    // newmimeType ='video/webm;codecs=vp8,opus';
    if (event.data && event.data.size > 0) {
      recordedBlobs.push(event.data);
          //savevideo();
          uploadtest();
          recordplay();
    }
}

var savevideo = function savevideo() {
 
  const blobfile = new Blob(recordedBlobs,{type: 'video/webm'});
  var filevideo = window.URL.createObjectURL(blobfile);
  var formData = new FormData();
  formData.append('video-blob', blobfile);
  formData.append('cid', $('#cid_'+stepid).val());
  formData.append('api_token', $('#auth_token_'+stepid).val());
  formData.append('qid', $('#qid_'+stepid).val());
  $.ajax({
    type: 'POST',
    url: '/api/savevideo',
    enctype: 'multipart/form-data',
    data: formData,
    processData: false,
    contentType: false,
    beforeSend: function() {
      // setting a timeout
      // toastr.success("Downloading Video");
  },
  }).done(function(data) {
   $('.attempt_'+stepid).html(data.attempt_left)
   overlayblockUI.release();

   if(data.attempt_left <= 0) {
      $('.startfunction').hide();

      $('.submitrecord, .completerecord').removeClass('w-75');
      $('.submitrecord, .completerecord').addClass('w-100');
      $('.mid_div').removeClass('w-25px');
      $('.retakerecord').hide();
    }else{

      $('.submitrecord, .completerecord').removeClass('w-100');
      $('.submitrecord, .completerecord').addClass('w-75');
      $('.mid_div').addClass('w-25px');

      $('.retakerecord').show();
    }
  $('.completefunction').css('display', 'block');
 
});



} 

var handleSuccess = function handleSuccess(stream) {

  //console.log('getUserMedia() got stream:', stream);
  window.stream = stream;


    const strvid = document.querySelector('video#streamVideo_'+stepid);
    strvid.srcObject = stream;
    $('.notrecording_'+stepid).hide();
    if(reTake == '0') {
      $('.notrecording_'+stepid).show();
    } 
    //hideLoader();
  
}

var uploadtest = function(){
  var result = [];
  var resultCount = 0;
   //const blobfile = new Blob(recordedBlobs,{type: 'video/webm'});

   //const file = new File(blobfile, "test.mp4", {type: 'video/webm'});
  
   var today = new Date();

   const year = today.getFullYear();
   const month = (today.getMonth()+1);
   const d = today.getDate();
   const hour = today.getHours();
   const mins = today.getMinutes();
   const sec = today.getSeconds();
   let randvalue = Math.floor((Math.random() * 100000) + 1);
   var filname = year+''+month+''+d +''+ hour+''+mins+''+sec+''+randvalue;

   const file = new File(recordedBlobs, filname+extension, {type: newmimeType});
  //  const file = new File(recordedBlobs, "test.MOV",{type: 'video/MOV;codecs=vp8,opus'});
  //  var file = $('#file')[0].files[0];

  /*var filevideo = blobfile;
  var file = filevideo;*/

  var max = Math.ceil(file.size / block_size);
  maxloop = max;
  //must twice
  for(var i = 0; i < max; i++) {
    logs[i] = false;
  }

  for(var i = 0; i < max; i++ ) {
    pushAjax(file, i, 0);
  }
  intervalId = setInterval(loopAjax, 10);
}

var sendAjax = function(file, index, retry) {
  curr_threads++;
  if(retry > max_retry) {
    //alert('failed');
    console.log('failed index '+index);
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
  fd.append('cid', $('#cid_'+stepid).val());
  fd.append('api_token', $('#auth_token_'+stepid).val());
  fd.append('qid', $('#qid_'+stepid).val());
  fd.append('maxloop',maxloop);


  $.ajax({
    type: 'post',
    data: fd,
    processData: false,
    contentType: false,
    dataType: 'json',
    url:'/api/savevideo',
    success: function(data) {
      curr_threads--;
      if(!data.status) {
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
  })
}

var pushAjax = function(file, index, retry) {
  stack.push([file, index, retry]);
}

var loopAjax = function() {

  if(curr_threads < max_threads) {
    var arr = stack.shift();
    if(typeof arr != 'undefined') {
      sendAjax(arr[0], arr[1], arr[2]);
    }
  }
}

var check = function() {

  var dataajax = ajaxData['data'];
  
  var status = true;
  $.each(logs, function(index, value) {
    if(!value) {
      status = false;
      return false;
    }
  })
  if(status) {
    clearInterval(intervalId);
    
      $.ajax({
        url:"/api/savevideoattempt",
        method:"post",
        data: { "recorded_sec": $('#recorded_sec_'+stepid).val(),"cid": $('#cid_'+stepid).val(),"qid": $('#qid_'+stepid).val(),"file_name": dataajax.file_name,"api_token":$('#auth_token_'+stepid).val()},
        success:function(data)
        {
            if(data.success == '1'){
                
              $('.attempt_'+stepid).html(data.attempt_left)
              overlayblockUI.release();
          
              if(data.attempt_left <= 0) {
                  $('.startfunction').hide();
          
                  $('.submitrecord, .completerecord').removeClass('w-75');
                  $('.submitrecord, .completerecord').addClass('w-100');
                  $('.mid_div').removeClass('w-25px');
                  $('.retakerecord').hide();
                }else{
          
                  $('.submitrecord, .completerecord').removeClass('w-100');
                  $('.submitrecord, .completerecord').addClass('w-75');
                  $('.mid_div').addClass('w-25px');
          
                  $('.retakerecord').show();
                }
                $('.current').addClass('curntcomplete');
                $('.completefunction').css('display', 'block');

            }else{

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went worng, Please try agin',
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
}


    // Public methods
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

  function savecandidatelog(action){
    var width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
    var height = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
    var screenresolution = width+' x '+height;
    var currentURL = window.location.href;
    var candidate_id = $('#candid_id').val();
    fetch('https://api.ipify.org/?format=json')
    .then(response => response.json())
    .then(data => {
      var clientIP = data.ip;
      console.log("Client IP Address: " + clientIP);
      $.ajax({
        url:"/savecandidatelog",
        method:"post",
        data: { "screenresolution": screenresolution,action,currentURL,candidate_id,clientIP},
        success:function(data)
        {
            if(data.success == '1'){
                console.log('saved');
            }else{
                console.log('not saved');
            }
        }
    });
    });
        
  }
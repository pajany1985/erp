/*
*  Copyright (c) 2015 The WebRTC project authors. All Rights Reserved.
*
*  Use of this source code is governed by a BSD-style license
*  that can be found in the LICENSE file in the root of the source
*  tree.
*/

'use strict';

var DeviceTestFunction = function () {

const videoElement = document.querySelector('video#test_video');
var camera = 0;
var mic = 0;

//const audioInputSelect = document.querySelector('select#audioSource');
//const audioOutputSelect = document.querySelector('select#audioOutput');
//const videoSelect = document.querySelector('select#videoSource');
//const selectors = [audioInputSelect, audioOutputSelect, videoSelect];

//audioOutputSelect.disabled = !('sinkId' in HTMLMediaElement.prototype);

function gotDevices(deviceInfos) {
  //console.log(deviceInfos);
  
  // Handles being called several times to update labels. Preserve values.
  /*const values = selectors.map(select => select.value);
  selectors.forEach(select => {
    while (select.firstChild) {
      select.removeChild(select.firstChild);
    }
  });*/

  //console.log(deviceInfos.length);

 
  var audio = 0;
  for (let i = 0; i !== deviceInfos.length; ++i) {
    const deviceInfo = deviceInfos[i];
    
    if (deviceInfo.kind === 'audioinput') {
      console.log("Audio++++++");
      console.log(`${deviceInfo.kind}: ${deviceInfo.label} id = ${deviceInfo.deviceId}`);
      // alert(deviceInfo.label);
      const string = (deviceInfo.label).toLowerCase();
      const substring = "microphone";
      const mobilesubstring = "headset";
     if(string.indexOf(substring) !== -1){
      mic = 1;
     }else if(string.indexOf(mobilesubstring) !== -1){
      mic = 1;
     }
     //mic = 1;
     
    } else if (deviceInfo.kind === 'audiooutput') {
       audio = 1
    } else if (deviceInfo.kind === 'videoinput') {
      console.log("Video++++++");
      console.log(`${deviceInfo.kind}: ${deviceInfo.label} id = ${deviceInfo.deviceId}`);
      const string = (deviceInfo.label).toLowerCase();
      const substring = "webcam";
      const mobilesubstring = "camera";
      if(string.indexOf(substring) !== -1){
        camera = 1;
       }else if(string.indexOf(mobilesubstring) !== -1){
        camera = 1;
       }
       camera = 1;
    } 
  }

  updatedeviceInfo(mic,audio);
  
}

function updatedeviceInfo(mic,audio) {
     
      $('.spinner-border').remove();
      if(mic == '1')
        $('#elem_mic').html('<i class="fa fa-check text-success"></i>');
      else 
        $('#elem_mic').html('<i class="bi bi-x-lg text-danger"></i>');


      if(camera == '1') {
        $('#elem_camera').html('<i class="fa fa-check text-success"></i>');
      }
      else  {
        $('#elem_camera').html('<i class="bi bi-x-lg text-danger"></i>');
        $('#elem_strvideo').html('<div class="border-gray-100 border  py-16 bg-dark bg-opacity-25 d-none d-lg-block"><span class="text-dark fw-bolder d-block text-center">                                                    Camera Not Found</span><span class="text-dark fw-bolder mb-1 fs-3"></span></div>');
      }

      if(mic == '1' && camera == '1') {

        $('.successblock').removeClass('d-none');
        $('.failedblock').addClass('d-none');

      } else {
          $('.quiz-footer').hide();
          $('.failedblock').removeClass('d-none');
          $('.successblock').addClass('d-none');

      }

}



// Attach audio output device to video element using device/sink ID.
function attachSinkId(element, sinkId) {
  if (typeof element.sinkId !== 'undefined') {
    element.setSinkId(sinkId)
        .then(() => {
          console.log(`Success, audio output device attached: ${sinkId}`);
        })
        .catch(error => {
          let errorMessage = error;
          if (error.name === 'SecurityError') {
            errorMessage = `You need to use HTTPS for selecting audio output device: ${error}`;
          }
          console.error(errorMessage);
          // Jump back to first output device in the list as it's the default.
          audioOutputSelect.selectedIndex = 0;
        });
  } else {
    console.warn('Browser does not support output device selection.');
  }
}

function changeAudioDestination() {
  const audioDestination = audioOutputSelect.value;
  attachSinkId(videoElement, audioDestination);
}

function gotStream(stream) {
  window.stream = stream; // make stream available to console
  videoElement.srcObject = stream;
  // Refresh button list in case labels have become available
  return navigator.mediaDevices.enumerateDevices();
}

function handleError(error) {
  camera = 0;
  mic=0;
  //alert(error);
  //console.log('navigator.MediaDevices.getUserMedia error: ', error.message, error.name);
}

var deveice_test_start = function(){

  savecandidatelog('devicetest');

  // navigator.mediaDevices
  // .enumerateDevices()
  // .then((devices) => {
  //   devices.forEach((device) => {
  //     console.log(`${device.kind}: ${device.label} id = ${device.deviceId}`);
  //   });
  // })
  // .catch((err) => {
  //   console.error(`${err.name}: ${err.message}`);
  // });

  navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);
  if (window.stream) {
    window.stream.getTracks().forEach(track => {
      track.stop();
    });
  }
 
  const constraints = {
    audio: {
      echoCancellation: {exact: 1}
    },
    video: true
  };

  navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError);

}

function loadpopup(){

  $('#mdldevice_test').on('show.bs.modal', function (event) {
 
    deveice_test_start();
  })
  
  $('#mdldevice_test').on('hide.bs.modal', function (event) {
   
    
    var runtest='';
      if (window.stream) {
        runtest='ok';
      window.stream.getTracks().forEach(track => {
         track.stop();
       });
      //$('#blkdevicetest').remove();
    }
  
   $.ajax({
      url: "/runtestsession",
      method:"post",
      data:{runtest:runtest}
    }).then(function(data) {
      
      window.location.reload();
    });
   
     
    
   
  })

  $(document).on("click", "#retry", function (e) {
    // deveice_test_start(); 
    var submitButton_media = document.querySelector('#retry');
    submitButton_media.setAttribute('data-kt-indicator', 'on');
    submitButton_media.disabled = true;

    window.location.reload(); 
  });

    
  $(document).on("click", ".tocontinuemedia", function (e) {
    var submitButton_media = document.querySelector('.tocontinuemedia');
    submitButton_media.setAttribute('data-kt-indicator', 'on');
    submitButton_media.disabled = true;
    console.log(window.stream);
    var runtest='';
      if (window.stream) {
        runtest='ok';
        window.stream.getTracks().forEach(track => {
          track.stop();
          console.log(track);
        });

        window.stream.getVideoTracks()[0].stop();
        window.stream.getAudioTracks()[0].stop();
    }
  
   $.ajax({
      url: "/runtestsession",
      method:"post",
      data:{runtest:runtest}
    }).then(function(data) {
      // if (window.stream) {
      //     window.stream.getTracks().forEach(track => {
      //     track.stop();
      //   });
        
      // }
      window.location.replace('/overview');
      
    });
    
  });
}

return {
  init: function () {      
      deveice_test_start();
      loadpopup();
  }
}

}();






KTUtil.onDOMContentLoaded(function () {
  $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
  DeviceTestFunction.init();
  $.validator.messages.required = '';  

  
 

});

function savecandidatelog(action){
  var width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
  var height = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
  var screenresolution = width+' x '+height;
  var currentURL = window.location.href;
  var candidate_id = $('#candidate_id').val();

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
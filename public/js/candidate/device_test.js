/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!******************************************************!*\
  !*** ./Resources/assets/js/candidate/device_test.js ***!
  \******************************************************/
/*
 *  Copyright (c) 2015 The WebRTC project authors. All Rights Reserved.
 *
 *  Use of this source code is governed by a BSD-style license
 *  that can be found in the LICENSE file in the root of the source
 *  tree.
 */


var DeviceTestFunction = function () {
  var videoElement = document.querySelector("video#test_video");
  var camera = 0;
  var mic = 0;
  var audio = 0;

  function gotDevices(deviceInfos) {
    for (var i = 0; i !== deviceInfos.length; ++i) {
      var deviceInfo = deviceInfos[i];

      if (deviceInfo.kind === "audioinput") {
        console.log("Audio++++++");
        console.log("".concat(deviceInfo.kind, ": ").concat(deviceInfo.label, " id = ").concat(deviceInfo.deviceId)); // alert(deviceInfo.label);

        var string = deviceInfo.label.toLowerCase();
        var substring = "microphone";
        var mobilesubstring = "headset";

        if (string.indexOf(substring) !== -1) {
          mic = 1;
        } else if (string.indexOf(mobilesubstring) !== -1) {
          mic = 1;
        }
      } else if (deviceInfo.kind === "audiooutput") {
        audio = 1;
      } else if (deviceInfo.kind === "videoinput") {
        console.log("Video++++++");
        console.log("".concat(deviceInfo.kind, ": ").concat(deviceInfo.label, " id = ").concat(deviceInfo.deviceId));

        var _string = deviceInfo.label.toLowerCase();

        var _substring = "webcam";
        var _mobilesubstring = "camera";

        if (_string.indexOf(_substring) !== -1) {
          camera = 1;
        } else if (_string.indexOf(_mobilesubstring) !== -1) {
          camera = 1;
        }

        camera = 1;
      }
    }

    updatedeviceInfo(mic, audio);
  }

  function updatedeviceInfo(mic, audio) {
    $(".spinner-border").remove();
    if (mic == "1") $("#elem_mic").html('<i class="fa fa-check text-success"></i>');else $("#elem_mic").html('<i class="bi bi-x-lg text-danger"></i>');

    if (camera == "1") {
      $("#elem_camera").html('<i class="fa fa-check text-success"></i>');
    } else {
      $("#elem_camera").html('<i class="bi bi-x-lg text-danger"></i>');
      $("#elem_strvideo").html('<div class="border-gray-100 border  py-16 bg-dark bg-opacity-25 d-none d-lg-block"><span class="text-dark fw-bolder d-block text-center">                                                    Camera Not Found</span><span class="text-dark fw-bolder mb-1 fs-3"></span></div>');
    }

    if (mic == "1" && camera == "1") {
      $(".successblock").removeClass("d-none");
      $(".failedblock").addClass("d-none");
    } else {
      $(".quiz-footer").hide();
      $(".failedblock").removeClass("d-none");
      $(".successblock").addClass("d-none");
    }
  } // Attach audio output device to video element using device/sink ID.


  function attachSinkId(element, sinkId) {
    if (typeof element.sinkId !== "undefined") {
      element.setSinkId(sinkId).then(function () {
        console.log("Success, audio output device attached: ".concat(sinkId));
      })["catch"](function (error) {
        var errorMessage = error;

        if (error.name === "SecurityError") {
          errorMessage = "You need to use HTTPS for selecting audio output device: ".concat(error);
        }

        console.error(errorMessage); // Jump back to first output device in the list as it's the default.

        audioOutputSelect.selectedIndex = 0;
      });
    } else {
      console.warn("Browser does not support output device selection.");
    }
  }

  function changeAudioDestination() {
    var audioDestination = audioOutputSelect.value;
    attachSinkId(videoElement, audioDestination);
  }

  function gotStream(stream) {
    window.stream = stream; // make stream available to console

    videoElement.srcObject = stream; // Refresh button list in case labels have become available
    // return navigator.mediaDevices.enumerateDevices();
    // alert(navigator.mediaDevices.enumerateDevices);

    if (navigator.mediaDevices.enumerateDevices) {
      navigator.mediaDevices.enumerateDevices().then(gotDevices)["catch"](handleError);
    } else {
      // Handle the lack of support for enumerateDevices
      console.error("enumerateDevices not supported in this browser.");
      camera = 0;
      mic = 0;
      updatedeviceInfo(mic, audio); // Update device info with default values
    }
  }

  function handleError(error) {
    camera = 0;
    mic = 0;
    updatedeviceInfo(mic, audio); // console.log('navigator.MediaDevices.getUserMedia error: ', error.message, error.name);
  }

  var deveice_test_start = function deveice_test_start() {
    savecandidatelog("devicetest");
    navigator.mediaDevices.enumerateDevices().then(gotDevices)["catch"](handleError);

    if (window.stream) {
      window.stream.getTracks().forEach(function (track) {
        track.stop();
      });
    }

    var constraints = {
      audio: {
        echoCancellation: {
          exact: 1
        }
      },
      video: true
    }; // navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError);

    if (navigator.mediaDevices.getUserMedia) {
      navigator.mediaDevices.getUserMedia(constraints).then(gotStream)["catch"](handleError);
    } else {
      // Handle the lack of support for getUserMedia
      console.error("getUserMedia not supported in this browser.");
      camera = 0;
      mic = 0;
      updatedeviceInfo(mic, audio); // Update device info with default values
    }
  };

  function loadpopup() {
    $("#mdldevice_test").on("show.bs.modal", function (event) {
      deveice_test_start();
    });
    $("#mdldevice_test").on("hide.bs.modal", function (event) {
      var runtest = "";

      if (window.stream) {
        runtest = "ok";
        window.stream.getTracks().forEach(function (track) {
          track.stop();
        }); //$('#blkdevicetest').remove();
      }

      $.ajax({
        url: "/runtestsession",
        method: "post",
        data: {
          runtest: runtest
        }
      }).then(function (data) {
        window.location.reload();
      });
    });
    $(document).on("click", "#retry", function (e) {
      // deveice_test_start();
      var submitButton_media = document.querySelector("#retry");
      submitButton_media.setAttribute("data-kt-indicator", "on");
      submitButton_media.disabled = true;
      window.location.reload();
    });
    $(document).on("click", ".tocontinuemedia", function (e) {
      var submitButton_media = document.querySelector(".tocontinuemedia");
      submitButton_media.setAttribute("data-kt-indicator", "on");
      submitButton_media.disabled = true;
      console.log(window.stream);
      var runtest = "";

      if (window.stream) {
        runtest = "ok";
        window.stream.getTracks().forEach(function (track) {
          track.stop();
          console.log(track);
        });
        window.stream.getVideoTracks()[0].stop();
        window.stream.getAudioTracks()[0].stop();
      }

      $.ajax({
        url: "/runtestsession",
        method: "post",
        data: {
          runtest: runtest
        }
      }).then(function (data) {
        // if (window.stream) {
        //     window.stream.getTracks().forEach(track => {
        //     track.stop();
        //   });
        // }
        window.location.replace("/overview");
      });
    });
  }

  return {
    init: function init() {
      deveice_test_start();
      loadpopup();
    }
  };
}();

KTUtil.onDOMContentLoaded(function () {
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
  });
  DeviceTestFunction.init();
  $.validator.messages.required = "";
});

function savecandidatelog(action) {
  var width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
  var height = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
  var screenresolution = width + " x " + height;
  var currentURL = window.location.href;
  var candidate_id = $("#candidate_id").val();
  fetch("https://api.ipify.org/?format=json").then(function (response) {
    return response.json();
  }).then(function (data) {
    var clientIP = data.ip;
    console.log("Client IP Address: " + clientIP);
    $.ajax({
      url: "/savecandidatelog",
      method: "post",
      data: {
        screenresolution: screenresolution,
        action: action,
        currentURL: currentURL,
        candidate_id: candidate_id,
        clientIP: clientIP
      },
      success: function success(data) {
        if (data.success == "1") {
          console.log("saved");
        } else {
          console.log("not saved");
        }
      }
    });
  });
}
/******/ })()
;
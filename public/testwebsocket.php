<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>WebRTC Background Video Recording</title>
</head>
<body>
<h1>WebRTC Background Video Recording</h1>
<video id="video" width="640" height="480" autoplay></video>
<video id="blob-video" controls></video> <!-- Added controls for the recorded video -->
<button id="startButton">Start Recording</button>
<button id="stopButton">Stop Recording</button>
<script>
let videoStream; // Declaring videoStream variable
let recorder; // Declaring recorder variable
let connection; // Declaring connection variable

navigator.mediaDevices.getUserMedia({
    audio: true,
    video: true
})
.then(function (stream) {
    videoStream = stream;
    document.getElementById('video').srcObject = stream; // Updated to set srcObject
})
.catch(function (error) {
    console.error('getUserMedia error: ', error);
});

document.getElementById('startButton').addEventListener('click', function() {
    if (!videoStream) {
        console.error('No video stream available');
        return;
    }
    
    recorder = new MediaRecorder(videoStream, {
        mimeType: 'video/webm'
    });

    recorder.ondataavailable = videoDataHandler;
    recorder.start();
    console.log('Recording started');
});

document.getElementById('stopButton').addEventListener('click', function() {
    if (recorder && recorder.state !== 'inactive') {
        recorder.stop();
        console.log('Recording stopped');
    } else {
        console.error('Recorder is not active');
    }
});

function videoDataHandler(event) {
    const blob = event.data;
    const videoElement = document.getElementById('blob-video');
    videoElement.src = window.URL.createObjectURL(blob);
    videoElement.controls = true; // Added controls for the recorded video

    // Send the recorded blob data via WebSocket
    if (connection && connection.readyState === WebSocket.OPEN) {
        connection.send(blob);
    }
}

// WebSocket setup
const websocketEndpoint = 'ws://localhost:7000';
connection = new WebSocket(websocketEndpoint);
connection.binaryType = 'arraybuffer';

connection.onopen = function(event) {
    console.log('WebSocket connection established');
};

connection.onclose = function(event) {
    console.log('WebSocket connection closed');
};

connection.onerror = function(error) {
    console.error('WebSocket error: ', error);
};

</script>
</body>
</html>
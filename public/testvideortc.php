<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>WebRTC Background Video Recording</title>
</head>
<body>
<h1>WebRTC Background Video Recording</h1>
<video id="videoElement" width="640" height="480" autoplay></video>
<button id="startButton">Start Recording</button>
<button id="stopButton">Stop Recording</button>
<script>

let mediaRecorder;
const chunks = [];
let startTime;

// Function to start video recording
function startRecording(stream) {
    startTime = Date.now();
    console.log("Recording started at:", new Date(startTime).toLocaleString());

    mediaRecorder = new MediaRecorder(stream);

    mediaRecorder.ondataavailable = function(event) {
        chunks.push(event.data);
    }

    mediaRecorder.onstop = function() {
        const blob = new Blob(chunks, { 'type' : 'video/mp4' });
        saveVideo(blob);
    }

    mediaRecorder.start();
}

// Function to stop video recording
function stopRecording() {
    mediaRecorder.stop();
    console.log("Recording stopped. Duration:", (Date.now() - startTime) / 1000, "seconds");
}


// Function to save video to server
function saveVideo(blob) {
    const formData = new FormData();
    formData.append('video', blob, 'recording.mp4');

    fetch('upload.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to save video');
        }
        console.log('Video saved successfully');
    })
    .catch(error => {
        console.error('Error saving video:', error);
    });
}

// Get access to the camera
navigator.mediaDevices.getUserMedia({ video: true })
    .then(stream => {
        const videoElement = document.getElementById('videoElement');
        videoElement.srcObject = stream;

        // Start recording when the start button is clicked
        document.getElementById('startButton').addEventListener('click', () => {
            startRecording(stream);
        });

        // Stop recording when the stop button is clicked
        document.getElementById('stopButton').addEventListener('click', () => {
            stopRecording();
        });
    })
    .catch(error => {
        console.error('Error accessing media devices: ', error);
    });

</script>
</body>
</html>
 navigator.mediaDevices.getUserMedia({ video: true })
            .then(function (stream) {
                var videoElement = document.getElementById('videoElement');
                videoElement.srcObject = stream;

                var socket = io('https://idealvideo:6001'); // Replace with your Laravel server address
                var mediaRecorder = new MediaRecorder(stream);

                mediaRecorder.ondataavailable = function (event) {
                    if (event.data && event.data.size > 0) {
                        socket.emit('streamData', { videoData: event.data });
                    }
                };

                mediaRecorder.start(1000); // Record video every 1 second
            })
            .catch(function (error) {
                console.error('Error accessing media devices:', error);
            });
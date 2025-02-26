<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Video Compression</title>
<script src="https://cdn.jsdelivr.net/npm/@ffmpeg/ffmpeg/dist/ffmpeg.min.js"></script>
</head>
<body>
<input type="file" id="fileInput" accept="video/*">
<button id="compressButton">Compress</button>
<progress id="progressBar" max="100" value="0"></progress>
<script>
const { createFFmpeg, fetchFile } = FFmpeg;
const ffmpeg = createFFmpeg({ log: true });

const fileInput = document.getElementById('fileInput');
const compressButton = document.getElementById('compressButton');
const progressBar = document.getElementById('progressBar');

compressButton.addEventListener('click', async () => {
  const videoFile = fileInput.files[0];
  if (!videoFile) {
    alert('Please select a video file.');
    return;
  }

  try {
    await ffmpeg.load();
    await ffmpeg.FS('writeFile', 'input.mp4', await fetchFile(videoFile));

    const args = [
      '-i', 'input.mp4',
      '-vf', 'scale=-2:720',
      '-c:v', 'libx264',
      '-crf', '23',
      '-preset', 'medium',
      '-c:a', 'aac',
      '-b:a', '128k',
      'output.mp4'
    ];

    await ffmpeg.run(...args);

    const data = ffmpeg.FS('readFile', 'output.mp4');
    const compressedVideoBlob = new Blob([data.buffer], { type: 'video/mp4' });
    const compressedVideoUrl = URL.createObjectURL(compressedVideoBlob);

    const a = document.createElement('a');
    a.href = compressedVideoUrl;
    a.download = 'compressed_video.mp4';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);

    URL.revokeObjectURL(compressedVideoUrl);
  } catch (error) {
    console.error('An error occurred during compression:', error);
    alert('An error occurred during compression. Please try again.');
  }
});
</script>
</body>
</html>
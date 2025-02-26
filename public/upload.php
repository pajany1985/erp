<?php
// Check if the file was sent
if ($_FILES['video']['error'] === UPLOAD_ERR_OK) {
    $tempFile = $_FILES['video']['tmp_name'];
    $targetPath = 'testvideos/';

    // Create uploads directory if it doesn't exist
    if (!file_exists($targetPath)) {
        mkdir($targetPath, 0777, true);
    }

    // Generate a unique filename
    $fileName = uniqid() . '.mp4';

    // Move the uploaded file to the uploads directory
    $targetFile = $targetPath . $fileName;
    if (move_uploaded_file($tempFile, $targetFile)) {
        echo 'Video uploaded successfully.';
    } else {
        echo 'Failed to move the uploaded file.';
    }
} else {
    echo 'Error uploading file.';
}
?>

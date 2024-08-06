<?php
if (isset($_POST['submit'])) {
    $file = $_FILES['image'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
    $allowed = array('jpg', 'jpeg', 'png', 'gif');
    if (in_array($fileExt, $allowed)) {
        if ($fileError === 0) {
            $fileNameNew = uniqid('', true) . "." . $fileExt;
            $fileDestination = 'uploads/' . $fileNameNew;
            move_uploaded_file($fileTmpName, $fileDestination);
            echo "Upload successful!";
        } else {
            echo "Error uploading file!";
        }
    } else {
        echo "Invalid file type!";
    }
}
?>
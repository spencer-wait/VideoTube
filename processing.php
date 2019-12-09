<?php

/* USED TO PROCESS VIDEO FILES UPLOADED TO CHANNEL */

require_once("includes/header.php");
require_once("includes/classes/VideoUploadData.php");
require_once("includes/classes/VideoProcessor.php");

// check if error in uploading file
if(!isset($_POST["uploadButton"])) {
    echo "No file sent to page.";
    exit();
}

// create file upload data
$videoUpoadData = new VideoUploadData(
                            $_FILES["fileInput"], 
                            $_POST["titleInput"],
                            $_POST["descriptionInput"],
                            $_POST["privacyInput"],
                            $_POST["categoryInput"],
                            $userLoggedInObj->getUsername()   
                        );

// process video data (upload)
$videoProcessor = new VideoProcessor($con);
$wasSuccessful = $videoProcessor->upload($videoUpoadData);

// check if upload was successful
if($wasSuccessful) {
    echo "Upload successful";
}
?>
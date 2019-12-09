<?php

/* USED TO VERIFY VIDEO UPLOAD FILE, CONVERT FILE, UPLOAD FILE, AND INSERT INFO TO DATABASE */

class VideoProcessor {

    private $con;   // variable used to connect to database
    private $sizeLimit = 500000000; // allows for larger file size to be uploaded
    private $allowedTypes = array("mp4", "flv", "webm", "mkv", "vob", "ogv", "ogg", "avi", "wmv", "mov", "mpeg", "mpg");    // all the file types allowed to be uploaded
    
    private $ffmpegPath;    // path initialized in constructor below
    private $ffprobePath;   // path initialized in constructor below
    
    public function __construct($con) {
        $this->con = $con;

        // ffmpeg used to convert video files to mpeg format
        $this->ffmpegPath = realpath("ffmpeg/bin/ffmpeg.exe");
        $this->ffprobePath = realpath("ffmpeg/bin/ffprobe.exe");
    }

    // upload video file to website
    public function upload($videoUploadData) {

        $targetDir = "uploads/videos/"; // save uploaded videos in this directory
        $videoData = $videoUploadData->videoDataArray;

        $tempFilePath = $targetDir . uniqid() . basename($videoData["name"]);   // create unique id for video file name
        $tempFilePath = str_replace(" ", "_", $tempFilePath);   // remove spaces from name - replace by underscores

        $isValidData = $this->processData($videoData, $tempFilePath);

        if(!$isValidData) { // make sure upload data is correct format
            return false;
        }

        if(move_uploaded_file($videoData["tmp_name"], $tempFilePath)) { // move video data to filepath
            $finalFilePath = $targetDir . uniqid() . ".mp4";

            if(!$this->insertVideoData($videoUploadData, $finalFilePath)) { // call query to insert video data and error check
                echo "Insert query failed\n";
                return false;
            }

            if(!$this->convertVideoToMp4($tempFilePath, $finalFilePath)) { // call to convert video format using ffmpeg and error check
                echo "Upload failed\n";
                return false;
            }

            if(!$this->deleteFile($tempFilePath)) { // call to delete original video file after conversion and error check
                echo "Upload failed\n";
                return false;
            }

            if(!$this->generateThumbnails($finalFilePath)) {    // call to generate 3 thumbnails for uploaded video file and error check
                echo "Upload failed - could not generate thumbnails\n";
                return false;
            }

            return true;    // return true if all functions execute properly

        }
    }

    // function to process uploaded video data and error check
    private function processData($videoData, $filePath) {
        $videoType = pathInfo($filePath, PATHINFO_EXTENSION);
        
        if(!$this->isValidSize($videoData)) {
            echo "File too large. Can't be more than " . $this->sizeLimit . " bytes";
            return false;
        }
        else if(!$this->isValidType($videoType)) {
            echo "Invalid file type";
            return false;
        }
        else if($this->hasError($videoData)) {
            echo "Error code: " . $videoData["error"];
            return false;
        }

        return true;
    }

    /* ERROR CHECKING FUNCTIONS */

    private function isValidSize($data) {
        return $data["size"] <= $this->sizeLimit;
    }
    private function isValidType($type) {
        $lowercased = strtolower($type);
        return in_array($lowercased, $this->allowedTypes);
    }
    private function hasError($data) {
        return $data["error"] != 0;
    }


    // querys to insert video upload data into database table
    private function insertVideoData($uploadData, $filePath) {
        $query = $this->con->prepare("INSERT INTO videos(title, uploadedBy, description, privacy, category, filePath)
                                        VALUES(:title, :uploadedBy, :description, :privacy, :category, :filePath)");

        $query->bindParam(":title", $uploadData->title);
        $query->bindParam(":uploadedBy", $uploadData->uploadedBy);
        $query->bindParam(":description", $uploadData->description);
        $query->bindParam(":privacy", $uploadData->privacy);
        $query->bindParam(":category", $uploadData->category);
        $query->bindParam(":filePath", $filePath);

        return $query->execute();
    }

    // function to use ffmpeg to convert upload video to universal mp4 format
    public function convertVideoToMp4($tempFilePath, $finalFilePath) {
        $cmd = "$this->ffmpegPath -i $tempFilePath $finalFilePath 2>&1";

        $outputLog = array();
        exec($cmd, $outputLog, $returnCode);
        
        if($returnCode != 0) {  // command failed
            foreach($outputLog as $line) {
                echo $line . "<br>";
            }
            return false;
        }

        return true;
    }

    // function to delete old file that is not mp4
    private function deleteFile($filePath) {
        if(!unlink($filePath)) {
            echo "Could not delete file\n";
            return false;
        }

        return true;
    }

    // function to generate 3 thumbnails from uploaded video and insert into database
    public function generateThumbnails($filePath) {

        $thumbnailSize = "210x118";
        $numThumbnails = 3;
        $pathToThumbnail = "uploads/videos/thumbnails";
        
        $duration = $this->getVideoDuration($filePath);

        $videoId = $this->con->lastInsertId();
        $this->updateDuration($duration, $videoId);

        for($num = 1; $num <= $numThumbnails; $num++) {
            $imageName = uniqid() . ".jpg";
            $interval = ($duration * 0.8) / $numThumbnails * $num;
            $fullThumbnailPath = "$pathToThumbnail/$videoId-$imageName";

            $cmd = "$this->ffmpegPath -i $filePath -ss $interval -s $thumbnailSize -vframes 1 $fullThumbnailPath 2>&1";

            $outputLog = array();
            exec($cmd, $outputLog, $returnCode);
            
            if($returnCode != 0) {  // command failed
                foreach($outputLog as $line) {
                    echo $line . "<br>";
                }
            }

            // insert thumbnails into database table
            $query = $this->con->prepare("INSERT INTO thumbnails(videoId, filePath, selected)
                                        VALUES(:videoId, :filePath, :selected)");
            $query->bindParam(":videoId", $videoId);
            $query->bindParam(":filePath", $fullThumbnailPath);
            $query->bindParam(":selected", $selected);

            $selected = $num == 1 ? 1 : 0;

            $success = $query->execute();

            if(!$success) {
                echo "Error inserting thumbail\n";
                return false;
            }
        }

        return true;
    }

    // function to determine the length of uploaded video file
    private function getVideoDuration($filePath) {
        return (int)shell_exec("$this->ffprobePath -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 $filePath");
    }

    // change how video duration is displayed and insert into database table
    private function updateDuration($duration, $videoId) {
        
        $hours = floor($duration / 3600);
        $mins = floor(($duration - ($hours*3600)) / 60);
        $secs = floor($duration % 60);
        
        $hours = ($hours < 1) ? "" : $hours . ":";
        $mins = ($mins < 10) ? "0" . $mins . ":" : $mins . ":";
        $secs = ($secs < 10) ? "0" . $secs : $secs;

        $duration = $hours.$mins.$secs;

        $query = $this->con->prepare("UPDATE videos SET duration=:duration WHERE id=:videoId");
        $query->bindParam(":duration", $duration);
        $query->bindParam(":videoId", $videoId);
        $query->execute();
    }
}
?>
<?php

/* CREATES VIDEO PLAYER ON PAGE AND SETS VIDEOS TO AUTO PLAY WHEN USER LOADS PAGE */

class VideoPlayer {

    private $video;

    public function __construct($video) {
        $this->video = $video;
    }

    // set video to auto play when page loads
    public function create($autoPlay) {
        if($autoPlay) {
            $autoPlay = "autoplay";
        }
        else {
            $autoPlay = "";
        }

        // create video player on page
        $filePath = $this->video->getFilePath();
        return "<video class='videoPlayer' controls $autoPlay>
                    <source src='$filePath' type='video/mp4'>
                    Your browser does not support the video tag
                </video>";
    }

}
?>
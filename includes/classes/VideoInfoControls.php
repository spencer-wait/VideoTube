<?php

/* USED TO CREATE THE LIKE AND DISLIKE BUTTONS FOR VIDEO PAGE */

require_once("includes/classes/ButtonProvider.php"); 

class VideoInfoControls {

    private $video, $userLoggedInObj;

    public function __construct($video, $userLoggedInObj) {
        $this->video = $video;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    // creates like and dislike buttons on page
    public function create() {

        $likeButton = $this->createLikeButton();
        $dislikeButton = $this->createDislikeButton();
        
        return "<div class='controls'>
                    $likeButton
                    $dislikeButton
                </div>";
    }

    // function to create the like button
    private function createLikeButton() {
        $text = $this->video->getLikes();
        $videoId = $this->video->getId();
        $action = "likeVideo(this, $videoId)";
        $class = "likeButton";

        $imageSrc = "assets/images/icons/thumb-up.png"; // set default thumbs up icon for like button when user has not previously liked the video

        if($this->video->wasLikedBy()) {    // set active thumbs up icon if user has liked the video
            $imageSrc = "assets/images/icons/thumb-up-active.png";
        }

        return ButtonProvider::createButton($text, $imageSrc, $action, $class);
    }

    // function to create the dislike button
    private function createDislikeButton() {
        $text = $this->video->getDislikes();
        $videoId = $this->video->getId();
        $action = "dislikeVideo(this, $videoId)";
        $class = "dislikeButton";

        $imageSrc = "assets/images/icons/thumb-down.png";   // set default thumbs down icon for dislike button when user has not previously disliked the video

        if($this->video->wasDislikedBy()) { // set active thumbs down icon if user has disliked the video
            $imageSrc = "assets/images/icons/thumb-down-active.png";
        }

        return ButtonProvider::createButton($text, $imageSrc, $action, $class);
    }
}
?>
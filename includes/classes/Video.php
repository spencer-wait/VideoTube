<?php

/* USED TO GET VIDEO INFORMATION AND TO MANAGE LIKES/DISLIKES ON VIDEOS */

class Video {

    private $con, $sqlData, $userLoggedInObj;

    public function __construct($con, $input, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;

        if(is_array($input)) {
            $this->sqlData = $input;
        }
        else {  // serach database for video data if not already retrieved
            $query = $this->con->prepare("SELECT * FROM videos WHERE id = :id");
            $query->bindParam(":id", $input);
            $query->execute();

            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
        }
    }
    

    /* FUNCTIONS TO GET VIDEO INFORMATION FROM DATABASE VARIABLE */
    public function getId() { return $this->sqlData["id"]; }
    public function getUploadedBy() { return $this->sqlData["uploadedBy"]; }
    public function getTitle() { return $this->sqlData["title"]; }
    public function getDescription() { return $this->sqlData["description"]; }
    public function getPrivacy() { return $this->sqlData["privacy"]; }
    public function getFilePath() { return $this->sqlData["filePath"]; }
    public function getCategory() { return $this->sqlData["category"]; }
    public function getUploadDate() {
        $date = $this->sqlData["uploadDate"];
        return date("M j, Y", strtotime($date));    // set date to a clean, universal format
    }
    public function getViews() { return $this->sqlData["views"]; }
    public function getDuration() { return $this->sqlData["duration"]; }

    // increment view count on video page when page is visited
    public function incrementViews() {
        $query = $this->con->prepare("UPDATE videos SET views=views+1 WHERE id=:id");
        $query->bindParam(":id", $videoId);

        $videoId = $this->getId();
        $query->execute();

        $this->sqlData["views"] = $this->sqlData["views"] + 1;
    }

    // used to get amount of likes for a video
    public function getLikes() {
        $query = $this->con->prepare("SELECT count(*) as 'count' FROM likes WHERE videoId = :videoId");
        $query->bindParam(":videoId", $videoId);
        $videoId = $this->getId();
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);
        return $data["count"];
    }

    // used to get amount of dislikes for a video
    public function getDislikes() {
        $query = $this->con->prepare("SELECT count(*) as 'count' FROM dislikes WHERE videoId = :videoId");
        $query->bindParam(":videoId", $videoId);
        $videoId = $this->getId();
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);
        return $data["count"];
    }

    // function to add a like to a video
    public function like() {
        $id = $this->getId();
        $username = $this->userLoggedInObj->getUsername();

        if($this->wasLikedBy()) {   // if user presses the like button again after already having liked it
            $query = $this->con->prepare("DELETE FROM likes WHERE username=:username AND videoId=:videoId");    // delete like from table
            $query->bindParam(":username", $username);
            $query->bindParam(":videoId", $id);
            $query->execute();

            // remove the like from the likes array
            $result = array(
                "likes" => -1,
                "dislikes" => 0
            );
            return json_encode($result);
        }
        else {  // if the user likes the video after having previously disliked it
            $query = $this->con->prepare("DELETE FROM dislikes WHERE username=:username AND videoId=:videoId"); // delete dislike from table
            $query->bindParam(":username", $username);
            $query->bindParam(":videoId", $id);
            $query->execute();
            $count = $query->rowCount();

            $query = $this->con->prepare("INSERT INTO likes(username, videoId) VALUES(:username, :videoId)");   // insert like into table
            $query->bindParam(":username", $username);
            $query->bindParam(":videoId", $id);
            $query->execute();

            // add like and remove dislike from likes array
            $result = array(
                "likes" => 1,
                "dislikes" => 0 - $count
            );
            return json_encode($result);
        }
    }

    // function to add a dislike to a video
    public function dislike() {
        $id = $this->getId();
        $username = $this->userLoggedInObj->getUsername();

        if($this->wasDislikedBy()) {    // if the user dislikes the video again after having already disliked it 
            $query = $this->con->prepare("DELETE FROM dislikes WHERE username=:username AND videoId=:videoId"); // delete dislike from table
            $query->bindParam(":username", $username);
            $query->bindParam(":videoId", $id);
            $query->execute();

            // remove dislike from likes array
            $result = array(
                "likes" => 0,
                "dislikes" => -1
            );
            return json_encode($result);
        }
        else {  // if the user dislikes the video after having already liked it
            $query = $this->con->prepare("DELETE FROM likes WHERE username=:username AND videoId=:videoId");    // delete like from table
            $query->bindParam(":username", $username);
            $query->bindParam(":videoId", $id);
            $query->execute();
            $count = $query->rowCount();

            $query = $this->con->prepare("INSERT INTO dislikes(username, videoId) VALUES(:username, :videoId)");    // insert dislike into table
            $query->bindParam(":username", $username);
            $query->bindParam(":videoId", $id);
            $query->execute();

            // remove like and add dislike to likes array
            $result = array(
                "likes" => 0 - $count,
                "dislikes" => 1
            );
            return json_encode($result);
        }
    }

    // check if user has liked a video in the database
    public function wasLikedBy() {
        $query = $this->con->prepare("SELECT * FROM likes WHERE username=:username AND videoId=:videoId");
        $query->bindParam(":username", $username);
        $query->bindParam(":videoId", $id);

        $id = $this->getId();

        $username = $this->userLoggedInObj->getUsername();
        $query->execute();

        return $query->rowCount() > 0;
    }

    // check i fuser has disliked a video in the database
    public function wasDislikedBy() {
        $query = $this->con->prepare("SELECT * FROM dislikes WHERE username=:username AND videoId=:videoId");
        $query->bindParam(":username", $username);
        $query->bindParam(":videoId", $id);

        $id = $this->getId();

        $username = $this->userLoggedInObj->getUsername();
        $query->execute();

        return $query->rowCount() > 0;
    }

}
?>
<?php
class VideoUploadData {

    public $videoDataArray, $title, $description, $privacy, $category, $uploadedBy;

    public function __construct($videoDataArray, $title, $description, $privacy, $category, $uploadedBy) {
        $this->videoDataArray = $videoDataArray;
        $this->title = $title;
        $this->privacy = $privacy;
        $this->description = $description;
        $this->category = $category;
        $this->uploadedBy = $uploadedBy;
    }
}
?>
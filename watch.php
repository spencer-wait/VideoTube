<?php 
require_once("includes/header.php");
require_once("includes/classes/VideoPlayer.php");

if(!isset($_GET["id"])) {
    echo "No URL passed into page.";
    exit(); // prevents any other code from loading on the page
}

$video = new Video($con, $_GET["id"], $userLoggedInObj);
$video->incrementViews();
?>

<div class="watchLeftColumn">
<?php
    $videoPlayer = new VideoPlayer($video);
    echo $videoPlayer->create(true);
?>
</div>

<div class="suggestions">

</div>


<?php require_once("includes/footer.php"); ?>
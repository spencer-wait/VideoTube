<?php 
require_once("includes/header.php"); 
require_once("includes/classes/VideoDetailsFormProvider.php");
?>

<div class="column">

<?php
$formProvider = new VideoDetailsFormProvider($con);
echo $formProvider->createUploadForm();
?>

</div>

<?php require_once("includes/footer.php"); ?>
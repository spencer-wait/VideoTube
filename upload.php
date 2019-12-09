<?php 

/* USED TO CREATE UPLOAD VIDEO FORM AND TO UPLOAD THE VIDEO DATA */

require_once("includes/header.php");
require_once("includes/classes/VideoDetailsFormProvider.php");
?>


<div class="column">

    <?php
    $formProvider = new VideoDetailsFormProvider($con); // retrieve data to create form
    echo $formProvider->createUploadForm(); // create for to upload video data to website
    ?>


</div>

<script>
$("form").submit(function() { // submit video data
    $("#loadingModal").modal("show"); // show spinning loading symbol when processing video upload - style below
});
</script>


<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      
      <div class="modal-body">
        Please wait. This might take a while.
        <img src="assets/images/icons/loading-spinner.gif">
      </div>

    </div>
  </div>
</div>

<?php require_once("includes/footer.php"); ?>
                
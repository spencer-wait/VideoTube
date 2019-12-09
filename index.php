<?php 

/* HOME PAGE FOR WEBSITE */

require_once("includes/header.php"); 
?>

<?php
// print out when and which user is logged in
if(isset($_SESSION["userLoggedIn"])) {
    echo "User is logged in as " . $userLoggedInObj->getName() . ".";
}
else {  // print out when not logged in
    echo "You are not logged in.";
}
?>

<?php require_once("includes/footer.php"); ?>
                
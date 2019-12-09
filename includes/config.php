<?php

/* BASIC CONFIGURATIONS FOR WEBSITE AND DATABASE CONNECTION */

ob_start();         // turns on output buffering 
session_start();    // allows for user log in sessions on website

date_default_timezone_set("America/New_York");  // sets timezone

// connect to database
try {
    $con = new PDO("mysql:dbname=VideoTube;host=localhost", "root", "");    // database connection info
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
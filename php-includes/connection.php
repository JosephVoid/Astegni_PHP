<?php
    $dbServername = $_SERVER['SERVER_NAME'];
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "astegni";
    
    $conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
    $GLOBALS['link'] = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
?>
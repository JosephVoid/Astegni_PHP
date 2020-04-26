<?php
    include 'connection.php';
    /*
    1 lying
    2 bad behaviour
    3 unqualified
    4 imposter
    */
    if (isset($_POST['report']) && !empty($_POST['report'])){
        $the_report = $_POST['report'];
        $reporter = $_POST['reporter'];
        $reported_on = $_POST['reported-on'];
        $reporter_type = $_POST['reporter-type'];
        
        mysqli_query($conn,"INSERT INTO `report` VALUES('','".$reported_on."','".$reporter."','".$the_report."','".$reporter_type."')");
        echo mysqli_error($conn);
    
        
    }
    else
        echo "report not set";
?>
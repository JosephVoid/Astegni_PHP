<?php
    include 'connection.php';
    if (isset($_POST['rate'])){
        $rate = $_POST['rate'];
        $rater = $_POST['rater'];
        $tutors = $_POST['tutor'];
        $type = $_POST['type'];
        
        if ( mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `rating` WHERE `user_id` = '".$rater."' AND `tutor_id` = '".$tutors."' AND `type` = '".$type."'")) < 1 ){
            mysqli_query($conn,"INSERT INTO `rating` VALUES('','".$rater."','".$tutors."','".$rate."','".$type."')");
            $r = mysqli_query($conn,"SELECT * FROM `rating` WHERE `tutor_id` = '". $tutors ."'");
            
            $sum = 0;$i = 0;
            while($row = mysqli_fetch_assoc($r)){
                $sum = $sum + $row['rate'];
                $i++;
            }
            $avg = $sum/$i;

            mysqli_query($conn,"UPDATE `tutors` SET `rating` = '". $avg ."' WHERE `id` = '". $tutors ."'");
        }
            echo mysqli_error($conn);
    }
?>
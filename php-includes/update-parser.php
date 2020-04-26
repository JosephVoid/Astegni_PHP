<?php
    include 'connection.php';
    include 'functions.php';
    //Photo
    if (isset($_FILES['photo']['name'])){
        $pic_name = $_FILES['photo']['name'];
        $pic_size = $_FILES['photo']['size'];
        $pic_temp_name = $_FILES['photo']['tmp_name'];
        echo $pic_name."--".$pic_size."--".$pic_temp_name;
        # Delete previous pic
        $row = get($_COOKIE['id'],'tutor');
        if ( !empty($pic_name) && !empty($pic_size) && !empty($pic_temp_name))
            unlink("../".$row['photo']);
        
        if ( Upload($pic_name,$pic_size,$pic_temp_name) ){
            mysqli_query($conn,"UPDATE `tutors` SET `photo` = 'Uploads/".$pic_name."' WHERE `id` = ".$_COOKIE['id']."");
        }
    
    }
    //Name
    if(isset($_POST['name']) && !empty($_POST['name'])){
        if(preg_match('/\s/',$_POST['name'])){
            if(strlen($_POST['name']) < 28){
                mysqli_query($conn,"UPDATE `tutors` SET `name` = '".$_POST['name']."' WHERE `id` = ".$_COOKIE['id']."");
            }
            else
                echo "Name too long.*";
        }
        else
            echo "Enter first and last name.*";
    }
    
    //About

    if ( isset($_POST['about']) && !empty($_POST['about'])){
        if ( strlen($_POST['about']) <  330)
            mysqli_query($conn,"UPDATE `tutors` SET `about` = '".$_POST['about']."' WHERE `id` = ".$_COOKIE['id']."");
    }
    //Email

    if ( isset($_POST['email']) && !empty($_POST['email'])){
        mysqli_query($conn,"UPDATE `tutors` SET `email` = '".$_POST['email']."' WHERE `id` = ".$_COOKIE['id']."");
    }

    //Old new password
    if ( isset($_POST['old-pswd']) && !empty($_POST['old-pswd']) && isset($_POST['new-pswd']) && !empty($_POST['new-pswd'])){
        $tutor = mysqli_fetch_assoc(mysqli_query($conn,"SELECT `password` FROM `tutors` WHERE `id` = ".$_COOKIE['id'].""));
        
        if ( md5($_POST['old-pswd']) == $tutor['password'] ){
            mysqli_query($conn,"UPDATE `tutors` SET `password` = '".$_POST['new-pswd']."' WHERE `id` = ".$_COOKIE['id']."");
        }
        else
            echo "Incorrect password!*";
    }
    
    //Phone

    if ( isset($_POST['phone-num']) && !empty($_POST['phone-num'])){
        mysqli_query($conn,"UPDATE `tutors` SET `phone` = '".$_POST['phone-num']."' WHERE `id` = ".$_COOKIE['id']."");
    }

    //Price

    if ( isset($_POST['price']) && !empty($_POST['price'])){
        mysqli_query($conn,"UPDATE `tutors` SET `price` = '".$_POST['price']."' WHERE `id` = ".$_COOKIE['id']."");
    }

    //Telegram

    if ( isset($_POST['telegram']) && !empty($_POST['telegram'])){
        mysqli_query($conn,"UPDATE `tutors` SET `telegram` = ".$_POST['telegram']." WHERE `id` = ".$_COOKIE['id']."");
    }

    //Topics
    if ( isset($_POST['topic'][0]) && !empty($_POST['topic'][0])){
        # Inserting new Subjects
        for ($i=0; $i < count($_POST['topic']); $i++) { 
            if ( !subjExists($_POST['topic'][$i],$_COOKIE['id']) ){
                mysqli_query($conn,"INSERT INTO `subjects` VALUES('','".$_COOKIE['id']."','".$_POST['topic'][$i]."')");
            }
            else
                continue;
        }

        # Removing Subjects
        $r = mysqli_query($conn,"SELECT * FROM `subjects` WHERE `tutor_id` = ".$_COOKIE['id']." ");
        while ($row = mysqli_fetch_assoc($r)) {
            if ( !in_array($row['subject'],$_POST['topic'])){
                mysqli_query($conn,"DELETE FROM `subjects` WHERE `sub_id` = '".$row['sub_id']."'");
            }
        }

    }

?>
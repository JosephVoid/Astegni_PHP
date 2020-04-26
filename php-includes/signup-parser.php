<?php
    include 'connection.php';
    include 'functions.php';
    session_start();
    # Unloading the data
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);
    $hashed_pwd = md5($password);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $phone = mysqli_real_escape_string($conn,$_POST['phone']);
    $gender = mysqli_real_escape_string($conn,$_POST['gender']);

    if ($gender == "male"){
        $gender = 1;
    }
    else{
        $gender = 0;
    }
    
    $_POST['age'] = frag($_POST['age'])[0]; // storing only the year
    $age = mysqli_real_escape_string($conn,$_POST['age']);
    $telegram = mysqli_real_escape_string($conn,$_POST['telegram']);
    $price = mysqli_real_escape_string($conn,$_POST['price']);

    if ( isset ( $_POST['other-qualification'] ) && !empty ( $_POST['other-qualification'] ) ) {
        $qualification = mysqli_real_escape_string($conn,$_POST['other-qualification']);
    }
    else{
        $qualification = $_POST['qualification'];
    }

    $about = mysqli_real_escape_string($conn,$_POST['about']);

    # Unpacking the image
    $pic_name = $_FILES['photo']['name'];
    $pic_size = $_FILES['photo']['size'];
    $pic_temp_name = $_FILES['photo']['tmp_name'];
    if ( !thereExists($username,'tutors','username') ){
        
        if ( Upload($pic_name,$pic_size,$pic_temp_name) ){
            mysqli_query($conn,"ALTER TABLE `tutors` AUTO_INCREMENT = 1");
            $q = "INSERT INTO `tutors` VALUES ('','".$name."','".$username."','".$hashed_pwd."','"."Uploads/".$pic_name."','".$email."','".$phone."','".$gender."','".$age."','".$telegram."','".$price."','','".$qualification."','".$about."','','','','')";

            if (mysqli_query($conn,$q)){
                echo "clear";
            }
            else echo mysqli_error($conn);    
            
            # Obtaining id to put in subjects
            $fetcher = null;
            $row = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `tutors` WHERE `username` = '".$username."' "));
               $fetcher = $row['id'];
            
            # Putting the topics in subjects
            for ( $i = 0 ; $i < count( $_POST['topic'] ) ; $i++ ){
                mysqli_query($conn,"INSERT INTO `subjects` VALUES('','".$fetcher."','".$_POST['topic'][$i]."')");
            }

            # Set session
            $_SESSION['id'] = $fetcher;
            $_SESSION['name'] = $row['name'];

        }
    }
    else
        echo "Username exists!";

?>
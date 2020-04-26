<?php
    include 'connection.php';
    include 'functions.php';
    session_start();
    
    if ( !empty($_POST['login_username']) && !empty($_POST['login_password'])){
        $usn = $_POST['login_username'];
        $pas = md5($_POST['login_password']);
        
       

        if ( thereExists($usn,'tutors','username') ){
            $usr = mysqli_fetch_assoc(mysqli_query($conn,"SELECT `id`,`name`,`username`,`password` FROM `tutors` WHERE `username` = '".$usn."' "));
            if ( $pas == $usr['password']){
                echo "clear";
                $_SESSION['id'] = $usr['id'];
                $_SESSION['name'] = $usr['name'];
                $_SESSION['type'] = 1;
                # If cookies should be set or not.
                if ( isset($_POST['login_remember']) )
                    $_SESSION['cookie_enable'] = true;
            }
            else
                echo "wrong";
        }
        elseif( thereExists($usn,'users','username') ){
            $usr = mysqli_fetch_assoc(mysqli_query($conn,"SELECT `id`,`name`,`username`,`password` FROM `users` WHERE `username` = '".$usn."' "));
            if ( $pas == $usr['password']){
                echo "clear-user";
                $_SESSION['id'] = $usr['id'];
                $_SESSION['name'] = $usr['name'];
                $_SESSION['type'] = 0;

                # If cookies should be set or not.
                if ( isset($_POST['login_remember']) )
                    $_SESSION['cookie_enable'] = true;
            }
            else
                echo "wrong";
        }
        else
            echo "wrong";
    }
    else
        echo "empty";
?>
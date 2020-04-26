<?php
    include 'connection.php';
    include 'functions.php';
    session_start();
    
    if ( !empty($_POST['name_signup']) && !empty($_POST['username_signup']) && !empty($_POST['password_signup']) ){
        $name = $_POST['name_signup'];
        $username = $_POST['username_signup'];
        $password = md5($_POST['password_signup']);

        if ( isset($_POST['signup_remember']) )
            $rem = $_POST['signup_remember'];
        
        if ( !thereExists($username,'users','username')){
                        
            mysqli_query($conn,"INSERT INTO `users` VALUES ('','{$name}','{$username}','{$password}')");
            echo mysqli_error($conn);
            $user = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `users` WHERE `username` = '".$username."'"));
            
            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['type'] = 0;
            echo "clear";
        }
        else
            echo "username exists!";
    }

?>
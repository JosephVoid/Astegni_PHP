<?php
    include 'connection.php';
    include 'functions.php';
    
    if(isset($_POST['comment']) && !empty($_POST['comment'])){
        $commenter = $_POST['commenter_id'];
        $cmtd_on = $_POST['commented_on_id'];
        $cmntr_type = $_POST['commenter_type'];
        $comment = $_POST['comment'];
        
        if ($cmntr_type == 0){
            echo '<div class="col-md-10 bubble">
                        <p class="bubble-name">'.get($commenter,'user')['name'].'</p>
                        <p class="bubble-comment">'.$comment.'</p>
                    </div>';
        
        }
        elseif ($cmntr_type == 1){
            echo '<div class="col-md-10 bubble">
                        <p class="bubble-name">'.get($commenter,'tutor')['name'].'</p>
                        <p class="bubble-comment">'.$comment.'</p>
                    </div>';
        }
        $comment = mysqli_real_escape_string($conn,$comment);
        mysqli_query($conn,"INSERT INTO `comments` VALUES('','".$commenter."','".$cmtd_on."','".$comment."','".$cmntr_type."')");
        echo mysqli_error($conn);
    }
?>
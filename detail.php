<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        include 'php-includes/connection.php';
        include 'php-includes/functions.php';
        session_start();

        if ( isset( $_COOKIE['id'] )){
            if ( $_COOKIE['type'] == 1 ){
                $userProfile = mysqli_fetch_assoc(mysqli_query($conn,"SELECT `name` FROM `tutors` WHERE `id` = '". $_COOKIE['id'] ."'"));
                $_SESSION['id'] = $_COOKIE['id'];
                $_SESSION['name'] = $userProfile['name'];
                $_SESSION['type'] = 1;
            }
            elseif ( $_COOKIE['type'] == 0 ){
                $userProfile = mysqli_fetch_assoc(mysqli_query($conn,"SELECT `name` FROM `users` WHERE `id` = '". $_COOKIE['id'] ."'"));
                $_SESSION['id'] = $_COOKIE['id'];
                $_SESSION['name'] = $userProfile['name'];
                $_SESSION['type'] = 0;
            }
        }
        
        $userip = getUserIpAddr();
        if ( mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `ip_addr` WHERE `viewed` = '". $_GET['id']."' AND `ip` = '". $userip ."' ")) == 0){
            mysqli_query($conn,"INSERT INTO `ip_addr` VALUES ('','". $userip ."','".$_GET['id']."')");
            mysqli_query($conn,"UPDATE `tutors` SET `views` = `views` + 1");
        }
        
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo get($_GET['id'],'tutor')['name'];?>'s detail</title>
    <script  src="https://code.jquery.com/jquery-3.4.1.min.js"  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="  crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/x-icon" href="images/logo2.png" />
    <link rel="stylesheet" href="Styles/detail.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/1d04695a02.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    
<body>
<!-- The profile floater -->
<?php
    
    if (isset($_SESSION['id'])){
        echo '  <nav class="profile-nav">
                    <div style="float:left"><i class="fas fa-user-check"></i> : '.$_SESSION['name'].'</div><div style="float:right"><i class="fas fa-sign-out-alt"></i> <a style="color:white" id="ll" href="php-includes/logout.php" class="logout-link">Logout</a></div>
                </nav>';    
        }

?>          
        <!-- The navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a style="margin-right:1rem;" href="#">
                <img height="50px" src="images/benner.png" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                  <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Be a user
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <form style="margin: 0;padding: 0 !important;">
                                <div style="padding: 1rem" id="usersignup">
                                    <p id="signup-feedback" class="invalid-feedback" style="margin:0"></p>
                                    <div class="form-group">
                                        <input type="text" name="name_signup" class="form-control fontAwesome" id="name_signup" placeholder=" Name">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="username_signup" class="form-control fontAwesome" id="username_signup" placeholder=" Username">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" required="" name="password_signup" class="form-control fontAwesome" id="passwors_signup" placeholder=" Password">
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input type="checkbox" name="signup_remember" id="signup_rem" class="form-check-input">
                                            <label class="form-check-label" for="dropdownCheck">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" id="signup-but" class="btn btn-outline-success">Sign up</button>
                                    <div id="signup-loader" class="loader" style="display:none"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="signup.php">
                        Be a tutor
                    </a>
                </li>
                
                    <?php if ( !isset($_SESSION['id'])){
                        echo '<li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Login
                                </a>
                                <div class="dropdown-menu">
                                <form id="login_form" class="px-4 py-3">
                                    <p id="feedback" class="invalid-feedback" style="margin:0">Wrong username/password</p>    
                                    <div class="form-group">
                                        <input type="text" name="login_username" class="form-control fontAwesome" id="login_username" placeholder="&#xf007 Username">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="login_password" required class="form-control fontAwesome" id="login_password" placeholder="&#xf084 Password">
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input type="checkbox" name="login_remember" class="form-check-input" id="login_rem">
                                            <label class="form-check-label" for="login_rem">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>
                                    <input id="login_but" type="submit" class="btn btn-outline-success" value="Sign in" />
                                    <div class="loader" style="display:none"></div>
                                </form>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Forgot password?</a>
                                </div>
                            </li>';}
                    ?>
                    
                    
                    
                <?php
                    if ( isset ( $_SESSION['id'] ) ){
                    echo '  <li class="nav-item">
                                <a class="nav-link" href="account.php">Account</a>
                            </li>';
                    }
                ?>    
            
              
              </ul>
              
              <form class="form-inline my-2 my-lg-0" action="index.php" method = "GET">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" name="name_search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
              </form>
            </div>
</nav>
<div class="container-fluid">
    <div class="col-md-12" >
        <?php
            $tutor = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `tutors` WHERE `id` = '".$_GET['id']."'"));
        ?>
        <div class="row justify-content-center" style="margin:3rem 0">
            <div class="col-md-3 detail-img-cont cont">
                <?php
                    if (isset($_SESSION['id'])){
                        if ( mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `report` WHERE `reported_id` = '".$_GET['id']."' AND `reporter` = '".$_SESSION['id']."' AND `type` = ".$_SESSION['type']." ")) < 1 ){
                            echo '<span id="report-icon" class="fas fa-flag" data-toggle = "modal" data-target = "#reportmodal"></span>';
                        }
                    }
                ?>
                <img style="max-height: 341px;" src="<?php echo $tutor['photo']; ?>" alt="" width="100%">
                
                <center><h2><?php echo $tutor['name']; ?></h2></center>
                
                <p style="text-indent: 10px;padding: 10px;">
                    <?php echo $tutor['about']; ?>
                </p>
                <?php
                    $stars = null;$thanks = 'style = "display:none;text-align: center;"';
                    if (isset($_SESSION['id'])){
                    
                        $r = mysqli_query($conn,"SELECT * FROM `rating` WHERE `user_id` = '".$_SESSION['id']."' AND `tutor_id` = '".$_GET['id']."' ");
                        if (mysqli_num_rows($r) > 0){
                            $stars = 'style = "display:none"';
                            $thanks = 'style = "text-align: center;"';
                        }
                        else{
                            $stars = 'style = ""';
                            $thanks = 'style = "display:none;text-align: center;"';
                        }
                    }
                ?>
                <div <?php echo $thanks; ?> id ="thanks"><h3>Thank you for rating!</h3><h6>It really helps us achieve quality</h6></div>
                
                <div id="the-stars" <?php echo $stars; ?> class="row justify-content-center">
                    <?php if (!isset($_SESSION['id'])) echo '<div class="r-lock"><p><span class="fas fa-lock"></span> Login to rate</p></div>';?>
                    
                    <div class="col-md-9">
                       <form <?php if (isset($_SESSION['id'])) echo 'id="rating-form"'; ?> style="margin-left: 0.9rem;">
                            <span class="rating-star">
                            <input type="radio" name="rating" value="5"><span class="star"></span>
 
                            <input type="radio" name="rating" value="4"><span class="star"></span>
                        
                            <input type="radio" name="rating" value="3"><span class="star"></span>
                        
                            <input type="radio" name="rating" value="2"><span class="star"></span>
                        
                            <input type="radio" name="rating" value="1"><span class="star"></span>
                        </span>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 info-cont">
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Name</div>
                    </div>
                    <input type="text" disabled value="<?php echo $tutor['name'];?>" class="form-control" id="inlineFormInputGroup">
                </div>
                
                <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <?php
                                    if ( $tutor['gender']) 
                                        echo "<span class = 'fas fa-male'></span>";
                                    else
                                        echo "<span class = 'fas fa-female'></span>";   
                                ?>
                            </div>
                        </div>
                        <div class="input-group-append" class="q-append">
                            <div class="input-group-text">
                                <?php
                                    if ( $tutor['gender']) 
                                        echo "Male";
                                    else
                                        echo "Female";   
                                ?>
                            </div>
                        </div>
                    </div>
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Email</div>
                    </div>
                    <input type="text" disabled value="<?php echo $tutor['email'];?>" class="form-control" id="inlineFormInputGroup">
                </div>

                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Rating</div>
                    </div>
                    <input type="text" disabled value="<?php echo $tutor['rating'];?>" class="form-control" id="inlineFormInputGroup">
                </div>

                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Phone</div>
                    </div>
                    <input type="text" disabled value="<?php echo $tutor['phone'];?>" class="form-control" id="inlineFormInputGroup">
                </div>

                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Telegram</div>
                    </div>
                    <input type="text" disabled value="<?php echo $tutor['telegram'];?>" class="form-control" id="inlineFormInputGroup">
                </div>

                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Age</div>
                    </div>
                    <input type="text" disabled value="<?php echo ageCalc(frag($tutor['age'])[0])?>" class="form-control" id="inlineFormInputGroup">
                </div>
                
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Qualification</div>
                    </div>
                    <input type="text" disabled value="<?php echo $tutor['qualification'];?>" class="form-control" id="inlineFormInputGroup">
                </div>
                
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">
                    <?php 
                        if ( $tutor['verified'] )
                            echo '<i class="fas fa-check-circle"></i>';
                        else
                            echo '<i style="color:red;" class="fas fa-times-circle"></i>';    
                    ?>    
                    
                    </label>
                    <div class="col-sm-8" style="padding: 0.4rem;">
                    
                    <?php
                        if ( $tutor['verified'] )
                            echo 'Verified';
                        else
                            echo 'Not verified';  
                    ?>
                    </div>
                </div>
                
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Price/hour</div>
                    </div>
                    <input type="text" disabled value="<?php echo $tutor['price'];?>" class="form-control" id="inlineFormInputGroup">
                </div>
                
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Teaches</div>
                    </div>
                    <?php
                        $count = 0;
                        $r = mysqli_query($conn,"SELECT * FROM `subjects` WHERE `tutor_id` = '".$_GET['id']."'");
                        while( $subjects = mysqli_fetch_assoc($r)){
                            if ($count == 0){
                                echo '<div class="row" style="width: 70%;margin-left:0;"> <input type="text" disabled value="'.$subjects['subject'].'" class="form-control" ></div>';
                                $count++;
                            }
                            else
                                echo '<div class="row" style="margin-left:0;width: 100%;"> <input type="text" disabled value="'.$subjects['subject'].'" class="form-control" ></div>';
                            
                        }    
                    ?>
                </div>
            </div>
            <div class="col-md-3 comment-cont cont">
                <?php 
                    $comment_count = mysqli_num_rows(mysqli_query($conn,"SELECT `id` FROM `comments` WHERE `commented_on_id` = '".$_GET['id'] ."'"));
                    if ( $comment_count < 1)
                        $disp = 'style="display:none" ';
                    
                    else
                        $disp = "";
                
                ?>       
                <div id="cmnt-bx" <?php echo $disp;?> class="col-md-12 comment-box">
                <h5 style="text-decoration-line: underline;"><center>Reviews</center></h5>
                <?php
                    $r = mysqli_query($conn,"SELECT * FROM `comments` WHERE `commented_on_id`= '".$_GET['id']."'");
                    while($comments = mysqli_fetch_assoc($r)){
                        
                        if ($comments['type'] == 0){
                            echo    '<div class="col-md-10 bubble">
                                        <p class="bubble-name">'.get($comments['commentor_id'],'user')['name'].'</p>
                                        <p class="bubble-comment">'.$comments['comment'].'</p>
                                    </div>';
                        }
                        elseif ($comments['type'] == 1) {
                            if ( get($comments['commentor_id'],'tutor')['verified'] == 1){
                                echo    '<div class="col-md-10 bubble">
                                            <p class="bubble-name">'.get($comments['commentor_id'],'tutor')['name'].' <span style="color: green;" class="fas fa-check-circle"></span></p>
                                            <p class="bubble-comment">'.$comments['comment'].'</p>
                                        </div>';
                            }
                            else{
                                echo    '<div class="col-md-10 bubble">
                                            <p class="bubble-name">'.get($comments['commentor_id'],'tutor')['name'].'</p>
                                            <p class="bubble-comment">'.$comments['comment'].'</p>
                                        </div>';
                                }
                        }
                    }
                ?>
                    
                </div>
                <?php if ( isset($_SESSION['id'])){
                        echo '<div style="text-align: center;padding: 0;" class="col-md-12">
                                <textarea class="form-control" name="" id="comment-text" cols="30" rows="5"></textarea>
                                <button onclick="commenter()" style="margin:0;margin-top:1rem;margin-bottom:1rem" class="btn btn-outline-success">Comment</button>
                            </div>';
                    }
                    else{
                        echo '  <div style="text-align: center;padding: 0;margin-bottom: 1rem;" class="col-md-12">
                                    <div class="d-comment">
                                        <div style="margin: 3rem;"><span class="fas fa-lock" style="font-size: 3rem;"></span>
                                        <p>Login to comment</p></div>
                                    </div>
                                    <textarea class="form-control" name="" cols="30" rows="5"></textarea>
                                    <button style="margin:0;margin-top:1rem;margin-bottom:1rem" class="btn btn-outline-success">Comment</button>
                                </div>';
                    }
                ?>
                
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="diver">
                    <center class="related"><h2>Related</h2></center>
                    <hr style="border-top: 1px solid black;">
                </div>
            </div>
        </div>        
        <div class="row justify-content-center" style="margin-bottom: 10rem;margin-top: 2rem;">    
            <div class="col-md-10" style="background-color: background-color: #f5f5f563;">
                <div class="row justify-content-around">
                    <?php
                        $rows = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `tutors`"));
                        $a = 0;
                        $prev = null;
                        while ($a < 3) {
                            $rand_ids = rand(1,$rows);
                            while(1){
                                if (!thereExists($rand_ids,"tutors","id")){
                                    $rand_ids = rand(1,$rows);
                                    continue;
                                }
                                else
                                    break;
                            }
                            
                            while(1){
                                if ($rand_ids == $prev){
                                    $rand_ids = rand(1,$rows);
                                    continue;
                                }
                                else
                                    break;
                            }

                            displayCard_by_id($rand_ids);                        
                            $a++;
                            $prev = $rand_ids;
                        }
                    ?>
                </div>
                </div>
            </div>
        </div>
       
    </div>
</div>
<input id="w" style="display:none" value="<?php echo $_GET['id']?>" />
<input id="c" style="display:none" value="<?php echo $_SESSION['id']?>"/>
<input id="t" style="display:none" value="<?php echo $_SESSION['type']?>"/>
<footer>
    <div class="row">
        <div class="col-md-4">
            <center><h2>About</h2></center>
            <p>
            Astegni© is a platform where tutors and tutee can meet thus simplifying the process of finding tutors. By using a user rating and review system tutee’s can easily find there tutors with a desired price, quality or even specific subjects.
            </p>
        </div>
        <div class="col-md-4 pl-md-5">
            <img style="width:100%" src="images/benner-dark.png" alt="">
        </div>
        <div class="col-md-4 pl-md-5" >
            <center><h2>Contact</h2></center>
            <ul class="list-group list-group-flush">
                    <li class="list-group-item"><span class="fas fa-phone"></span> +251920642556</li>
                    <li class="list-group-item"><span class="fas fa-envelope"></span> <a href="http://yosephten@gmail.com">yosephten@gmail.com (<span class="fas fa-wrench"></span>)</a></li>
                    <li class="list-group-item"><span class="fas fa-envelope"></span> <a href="http://astegniservice@gmail.com"> astegniservice@gmail.com </a></li>
                    <li class="list-group-item"><span style="color: #0163f5;" class="fas fa-paper-plane"></span> <a href="t.me/VoidMane">@VoidMane (<span class="fas fa-wrench"></span>)</a></li>
                    <li class="list-group-item"><span style="color: #0163f5;" class="fas fa-paper-plane"></span> <a href="t.me/astegni">Astegni telegram FAQ's</a></li>
                </ul>
        </div>
    </div>
    
</footer>

<!-- MODALS AND SUCH -->
<div class="modal fade" id="reportmodal" tabindex="-1" role="dialog" aria-labelledby="reportmodalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reportmodalTitle">Report a tutor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="list-group">
            <button type="button" class="list-group-item list-group-item-action" id="btn-ly">Lying on profile</button>
            <button type="button" class="list-group-item list-group-item-action" id="btn-bd">Bad behaviour</button>
            <button type="button" class="list-group-item list-group-item-action" id="btn-un">Being unqualified</button>
            <button type="button" class="list-group-item list-group-item-action" id="btn-im">Impostering</button>
            <button type="button" class="list-group-item list-group-item-action" id="btn-oth" data-toggle="collapse" data-target="#othercollapse">Other</button>
            <!-- collapse -->
            <div class="collapse" id="othercollapse">
                <div class="card card-body">
                    <input class="form-control" type="text" id="other-report" placeholder="The report">
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="report-but" style="display:none" class="btn btn-danger">Report</button>
      </div>
    </div>
  </div>
</div>

</body>
<script src="js-includes/comment.js"></script>
<script src="js-includes/login.js"></script>
<script>
    // Profile floater js
    $("#pf").click(function(){
        
        if ($("#ll").hasClass("show-link")){
            $("#pf").removeClass("show-pf");
            $("#pf").addClass("hide-pf");
            $("#ll").removeClass("show-link");
            $("#ll").addClass("hide");
        }
        else{
            if ( $("#ll").hasClass("hide-link") ){
                $("#ll").removeClass("hide-link");
                $("#pf").removeClass("hide-pf");
            }
            
            $("#ll").addClass("show-link");
            $("#pf").addClass("show-pf");
        }
    })
</script>

<script>
    <?php if (isset($_SESSION['id'])){?>
        
        $('#rating-form').on('change','[name="rating"]',function(){
            $.post('php-includes/rate-parser.php',{'rater':<?php echo $_SESSION['id'];?>,'tutor':<?php echo $_GET['id'];?>,'type':<?php echo $_SESSION['type'];?>,'rate':$('[name="rating"]:checked').val()},function(data){
                $("#the-stars").attr("style","display:none");
                $("#thanks").attr("style","display:block;text-align: center;");
                console.log(data)
            });
        });

    <?php } ?>
</script>

<script>
    <?php if (isset($_SESSION['id'])) {?>
        $("#btn-ly").click(function(){
            $.post('php-includes/report-parser.php',{'report':1,'reporter':<?php echo $_SESSION['id']?>,'reported-on':<?php echo $_GET['id']?>,'reporter-type':<?php echo $_SESSION['type']?>},function(data) {
                $("#reportmodal").modal('hide');
                $("#report-icon").attr('style',"display:none");
                console.log(data);    
            })
        });

        $("#btn-bd").click(function(){
            $.post('php-includes/report-parser.php',{'report':2,'reporter':<?php echo $_SESSION['id']?>,'reported-on':<?php echo $_GET['id']?>,'reporter-type':<?php echo $_SESSION['type']?>},function(data) {
                $("#reportmodal").modal('hide');
                $("#report-icon").attr('style',"display:none");
                console.log(data);    
            })
        });

        $("#btn-un").click(function(){
            $.post('php-includes/report-parser.php',{'report':3,'reporter':<?php echo $_SESSION['id']?>,'reported-on':<?php echo $_GET['id']?>,'reporter-type':<?php echo $_SESSION['type']?>},function(data) {
                $("#reportmodal").modal('hide');
                $("#report-icon").attr('style',"display:none");
                console.log(data);    
            })
        });
        
        $("#btn-im").click(function(){
            $.post('php-includes/report-parser.php',{'report':4,'reporter':<?php echo $_SESSION['id']?>,'reported-on':<?php echo $_GET['id']?>,'reporter-type':<?php echo $_SESSION['type']?>},function(data) {
                $("#reportmodal").modal('hide');
                $("#report-icon").attr('style',"display:none");
                console.log(data);    
            })
        });

        setInterval(function(){
            
            if ( $("#other-report").val() != "" ){
                $("#report-but").attr("style","display:block");
            }
            else
                $("#report-but").attr("style","display:none");
        
        }, 500);
        
        $("#report-but").click(function(){
            $.post('php-includes/report-parser.php',{'report':$("#other-report").val(),'reporter':<?php echo $_SESSION['id']?>,'reported-on':<?php echo $_GET['id']?>,'reporter-type':<?php echo $_SESSION['type']?>},function(data) {
                $("#reportmodal").modal('hide');
                $("#report-icon").attr('style',"display:none");
                console.log(data);    
            })
        });
    <?php } ?>
</script>

</html>
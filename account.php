
<html lang="en">
<head>
    <?php
        include 'php-includes/connection.php';
        include 'php-includes/functions.php';
        session_start();
        
        if (!isset($_SESSION['id'])){
            die("<h1>404</h1>");
        }

        if ( isset($_SESSION['cookie_enable']) && $_SESSION['cookie_enable'] == true ){
            if ( !isset($_COOKIE['id']) ){
                setcookie('id',$_SESSION['id'],time() + 60);
                setcookie('type',$_SESSION['type'],time() + 60);
            }    
        }
        
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Account</title>
    <script  src="https://code.jquery.com/jquery-3.4.1.min.js"  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="  crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/x-icon" href="images/logo2.png" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="Styles/account.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/1d04695a02.js"></script>
</head>
<body>

<?php
        if (isset($_SESSION['id'])){
        
            echo '  <nav class="profile-nav">
                    <div style="float:left"><i class="fas fa-user-check"></i> : '.$_SESSION['name'].'</div><div style="float:right"><i class="fas fa-sign-out-alt"></i> <a style="color:white" id="ll" href="php-includes/logout.php" class="logout-link">Logout</a></div>
                </nav>';    
        }
?>      
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a style="margin-right:1rem;" href="#">
            <img height="50px" src="images/benner.png" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home</a>
            </li>
            
            <li class="nav-item active">
                <a class="nav-link" href="#">Account <span class="sr-only">(current)</span></a>
            </li>
          </ul>
          
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>
    </nav>
    <div class="container-fluid">
        <?php
        $profile = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `tutors` WHERE `id` = '".$_SESSION['id']."'"));
        $priceRankresult = mysqli_query($conn,"SELECT id,price, RANK() OVER ( ORDER BY price DESC) price_rank FROM tutors ");
        $rateRankresult = mysqli_query($conn,"SELECT rating,id, RANK() OVER ( ORDER BY rating DESC ) rate_rank FROM tutors ");
        #echo mysqli_error($conn);
        while($priceRank = mysqli_fetch_assoc($priceRankresult)){
            if ($priceRank['id'] == $_SESSION['id']){
                $the_price_rank = add_suffix($priceRank['price_rank']);
            }
        }
        
        while($rateRank = mysqli_fetch_assoc($rateRankresult)){
            if ($rateRank['id'] == $_SESSION['id']){
                $the_rate_rank = add_suffix($rateRank['rate_rank']);
            }
        }
        ?>
        <?php
            if (isset($_GET['new'])){
                echo '
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <p class="new-comer">
                        Welcome to astegni Name, this is your account page. You can edit any of your information here.
                        If you have any problems navigating through this site or you have any questions, you can visit our support telegram group or contact the Devs. Good luck tutoring.
                                
                        </p>
                        
                    </div>
                </div>
                ';
            }
        ?>
        <div class="row justify-content-center" style="margin:3rem 0">
        <div class="col-md-3 detail-img-cont">
                    <label>
                        <span class="fas fa-pencil-alt" id="edit-button"></span>
                        <img id="disp-img" style="max-height: 341px;" src="<?php echo $profile['photo'];?>" alt="" width="100%">
                        <span id="dispimgname" style="display:none;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;"></span>
                        <input onchange="setdispimg()" style="display:none;" type="file" name="photo" id="profile-photo">
                    </label>
                    <center><h2><?php echo $profile['name'];?> , <?php echo ageCalc(frag($profile['age'])[0])?></h2></center>
                    <textarea maxlength="330" class="form-control" name="about" id="about-text" cols="30" rows="8"><?php echo $profile['about'];?>.</textarea>
                    <div class="row justify-content-center prof-info">
                        <div class="col-md-12"><i class="fas fa-eye"></i><?php echo $profile['viewed'];?> times your profile was seen</div>
                        <div class="col-md-12"><i class="fas fa-dollar-sign"></i><?php echo $the_price_rank; ?> most expensive</div>
                        <div class="col-md-12"><i class="fas fa-star"></i><?php echo $the_rate_rank; ?> rated</div>
                    </div>
        </div>
                
            
        <div class="col-md-3 info-cont">
            <form id="second-form" action="">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Name</div>
                        </div>
                        <input maxlength="27" id="name-text" name="name" type="text" value="<?php echo $profile['name'];?>" class="form-control">
                    </div>

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Email</div>
                        </div>
                        <input id="email-text" name="email" type="text" value="<?php echo $profile['email'];?>" class="form-control">
                    </div>
                
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Old Password</div>
                        </div>
                        <input id="opswd" name="old-pswd" type="password" class="form-control">
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <div class="input-group-text">New Password</div>
                        </div>
                        <input id="npswd" name="new-pswd" type="password" class="form-control">
                    </div>
                
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Phone</div>
                        </div>
                        <input type="number" maxlength="12" id="phone-num" name="phone-num" value="<?php echo $profile['phone'];?>" class="form-control" >
                    </div>
                
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Telegram</div>
                        </div>
                        <input name="telegram" id="telegram" type="text" value="<?php echo $profile['telegram'];?>" class="form-control">
                    </div>
                
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Qualification</div>
                        </div>
                        <div class="input-group-append" class="q-append">
                            <div class="input-group-text"><?php echo $profile['qualification']; ?></div>
                        </div>
                        <span style="padding: 0.5rem;position: absolute;right: 0;background-color: #eaeaea;" data-toggle="modal" data-target ="#update-qu" class=" fas fa-pencil-alt"></span>
                    </div>
                
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-4 col-form-label">
                        <?php
                            if ($profile['verified']){
                                echo '<i class="fas fa-check-circle"></i>';
                            }
                            else
                                echo '<i style="color:#940101" class="fas fa-times-circle"></i>';
                        ?>
                        
                        </label>
                        <div class="col-sm-8">
                        <?php
                        if ($profile['verified']){
                            echo '<input type="text" readonly class="form-control-plaintext" id="staticEmail" value="Verified">';
                        }
                        else
                            echo '<input type="text" readonly class="form-control-plaintext" id="staticEmail" value="Not verified">
                                <div data-toggle="modal" data-target ="#get-verified" class="get-v">Get <span class="fas fa-check-circle"></span></div>';
                        ?>
                        
                        </div>
                    </div>
                
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Price/Hour</div>
                        </div>
                        <input max="500" min="0" type="number" id="price" name="price" value="<?php echo $profile['price'];?>" class="form-control">
                    </div>
                    
                    <div class="form-group row">
                        <div class="topic-selection" id="topic-list">
                           
                            What can you teach
                            <?php 
                                $count = 0;
                                $r = mysqli_query($conn,"SELECT * FROM `subjects` WHERE `tutor_id` = '".$_SESSION['id']."'");
                                while ($row = mysqli_fetch_assoc($r)){
                                    if ($count == 0){
                                        echo '<input maxlength="25" required id="input-topic" class="form-control fontAwesome" type="text" name="topic[]" value="'.$row['subject'].'" id="" placeholder="Subject"><span id="add" class="fas fa-plus-square"></span>';
                                        $count ++;
                                    }
                                    else{
                                        echo '<input maxlength="25" id="input-topic'.$count.'" class="form-control fontAwesome" type="text" name="topic[]" value="'.$row['subject'].'" placeholder="Subject"/><span id="'.$count.'" class="fas fa-window-close red-x"></span>';
                                        $count ++;
                                        }
                                }
                                echo '<span style="display:none" value="'.$count.'" id="storage"></span>';
                            ?>
                            
                            
                        </div>
                    </div>
                    </form>
                    <div style="text-align:center">
                        <button id="submit-btn" type="submit" class="btn btn-outline-success">Update</button>
                    </div>
                </div>
        </div>
    </div>
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
<!-- Modals -->
    
    <div class="modal fade" id="get-verified" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Getting verified</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Welcome to Astegni,the place for any kind of tutors you may need.</h5>
                <p>
                    Getting verified will greatly affect your profile to the better. You'll be more trusted leading to being hired.
                    <h5>Steps to get verified online</h5>
                    <ol type = "1">
                        <li>
                            Send your all your information i.e
                            <ul>
                                <li>A photo of you</li>
                                <li>A copy of your Kebele ID (A scan is preferred but a photo will do) </li>
                                <li>Your Astegni username</li>
                                <li>Your certificates or any proof of qualification (Photo or scan)</li>
                            </ul>
                        </li>
                        <li>
                            You will recieve a confirmation email stating you are eligible.
                        </li>
                        <li>
                            After recieving the email you can pay 200br to <strong>Account number : 1000196349468</strong> and get confirmed
                        </li>
                    </ol>
                    <h5>Get verified in person</h5>
                    <p>Just call or text +251920642556 and we'll tell you what to do.</p>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Got it</button>
            </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="update-qu" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Update Qualifications</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>We at Astegni value our tutors quality and we believe that's what makes us unique</h6>
                To update your qualifications <strong>online</strong> you just need to send us your Astegni username, your full name, to what you want to update your qualifications
                and your ceftificates or any proof of your expertise to astegni.addis@gmail.com . After recieving the confirmation email you can pay 50br to <strong>Account number : 1000196349468</strong>.<br><hr><br>
                To update your qualifications <strong>in person</strong> just call +251920642556 we'll do the rest.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
<!-- END -->    
</body>
<script src="js-includes/update.js"></script>
<script>
    // For adding and remove input fields
    var i = 1;
    i = $("#storage").val();
    $("#add").click(function(){
        i++;
        $("#topic-list").append('<input id="input-topic'+i+'" class="form-control fontAwesome" type="text" name="topic[]" placeholder="Subject"/><span id="'+i+'" class="fas fa-window-close red-x"></span>');
    });
    $(document).on('click','.red-x',function(){
        var but_id = $(this).attr("id");
        $("#"+but_id+"").remove();
        $("#input-topic"+but_id+"").remove();
    });

    var prev_pic = $("#profile-photo").val();
    function setdispimg() {
        var currentimg = $("#profile-photo").val().replace('C:\\fakepath\\', " ");
        if (currentimg == "")
            $("#disp-img").attr("scr",prev_pic)
        $("#disp-img").attr("style","display:none")
        $("#dispimgname").attr("style","display:block")
        $("#dispimgname").text(currentimg)
    }
</script>
<script>
// Profile floater js
$("#pf").click(function(){
    
    if ($("#ll").hasClass("show-link")){
        $("#pf").removeClass("show-pf");
        $("#pf").addClass("hide-pf");
        $("#ll").removeClass("show-link");
        $("#ll").addClass("hide-link");
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
</html>
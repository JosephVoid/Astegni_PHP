<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        include 'php-includes/connection.php';
        include 'php-includes/functions.php';
        session_start();

    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign up</title>
    <script  src="https://code.jquery.com/jquery-3.4.1.js"  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="  crossorigin="anonymous"></script>
    <link rel="stylesheet" href="Styles/signup.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/1d04695a02.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    
</head>
<body>

<!-- The profile floater -->
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
            <li class="nav-item dropdown">
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
            </li>
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
        <div class="row justify-content-center" style="animation:SlideAni 600ms ease">
            <div class="col-md-5">
                <div class="jumbotron signup-cont">
                    <form id="signup-form">
                        <div class="row">
                            <div class="col-md-12">
                                <center><h2 style="margin:1rem 0">Sign up</h2></center>
                                <hr>
                                <input required maxlength = "27" autocomplete = "off" class="form-control fontAwesome" type="text" name="name" id="name_field" placeholder="&#xf031 Name">
                                <input required autocomplete = "off" class="form-control fontAwesome " type="text" name="username" id="usernameid" placeholder="&#xf007 Username">
                                <div id="username-feedback" class="invalid-feedback"></div>
                                
                                <input required class="form-control fontAwesome" type="password" minlength = "8" name="password" id="password_input" placeholder="&#xf084 Password">
                                <span id="pass-sec" class="fas fa-eye show-hide-pass"></span>
                                
                                <div class="input-group mb-3">
                                    <div class="custom-file" style="text-overflow: ellipsis;overflow: hidden;white-space: nowrap;">
                                        <input onchange = "nameset()" type="file" name="photo" class="custom-file-input" id="inputGroupFile02" >
                                        <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02"><span style="opacity: 0.8;" class="fas fa-camera"></span> A photo of you</label>
                                    </div>
                                    
                                </div>
                                <div id="photo-feedback" class="invalid-feedback"></div>     
                                <input required class="form-control fontAwesome" type="email" name="email" id="" placeholder="&#xf0e0 Email">
                                <input required class="form-control fontAwesome" type="number" name="phone" id="" placeholder="&#xf095 Phone">
                                <div style="margin-bottom: 1rem;" class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="customRadioInline1" name="gender" value="male" class="custom-control-input">
                                  <label class="custom-control-label" for="customRadioInline1">Male</label>
                                </div>
                                <div style="margin-bottom: 1rem;" class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="customRadioInline2" name="gender" value="female" class="custom-control-input" checked>
                                  <label class="custom-control-label" for="customRadioInline2">Female</label>
                                </div>
                                <input required class="form-control fontAwesome" type="date" name="age" id="age_id" max="2010-01-01" min = "1960-01-01" placeholder="&#xf1ae Date of birth">
                                
                                <input required class="form-control fontAwesome" type="text" name="telegram" id="" placeholder="&#xf3fe Telegram Username">
                                <input required class="form-control fontAwesome" type="number" name="price" id="" min="20" placeholder="&#xf0d6 Br/hour">
                                
                                Qualification
                                <select style="margin-top:1rem" id="qualif" name="qualification" class="form-control">
                                    <option value="Experiance" >Learned by experiance</option>
                                    <option value="High-school">I'm currently a High schooler</option>
                                    <option value="Collage-student" >I'm a college student</option>
                                    <option value="Degree-graduate">I'm a Degree graduate</option>
                                    <option value="Masters-graduate">I'm a Masters graduate</option>
                                    <option value="other">Other</option>
                                </select>
                                
                                <div id="other" style="display:none">
                                    <input class="form-control fontAwesome" maxlength="23" type="text" name="other-qualification" id="" placeholder="Other qualifications">
                                </div>
                                
                                <textarea class="form-control fontAwesome" maxlength="330" name="about" id="" cols="30" rows="5" placeholder="&#xf129 Write something about you"></textarea>
                                
                                <div class="topic-selection" id="topic-list">
                                    What can you teach
                                    <input required id="input-topic" maxlength = "25" class="form-control fontAwesome" type="text" name="topic[]" id="" placeholder="Subject"><span id="add" class="fas fa-plus-square"></span>
                                </div>
                                
                                <div style="text-align:center;min-height: 60px">
                                    <button id="subut" disabled = "disabled" class="btn btn-success btn-lg btn-block" type="submit">Done</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="verify-but">
                  <button data-toggle="modal" data-target="#get-v-account">Get a verified account instead</button>
                </div>
            </div>
        </div>
    </div>
    <!-- MODALS -->
    <div class="modal fade" id="get-v-account" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Verified account</h5>
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
</body>
<script src="js-includes/signup.js"></script>
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
    $("#pass-sec").click(function() {
        $(this).toggleClass("fa-eye-slash");
        var input = $("#password_input");
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        }
        else {
            input.attr("type", "password");
        }
    });
</script>
</html>
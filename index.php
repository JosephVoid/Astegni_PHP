
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

        if ( isset($_SESSION['cookie_enable']) && $_SESSION['cookie_enable'] == true ){
            if ( !isset($_COOKIE['id']) ){
                setcookie('id',$_SESSION['id'],time() + 120);
                setcookie('type',$_SESSION['type'],time() + 120);
            }
            unset( $_SESSION['cookie_enable'] );
        }

        $tutor_page = "";
        $search_page_on = "display:none";
        if(isset($_GET['price'])){
            
            $search_page_on = "";
            $tutor_page = "display:none";
            
            if (isset($_GET['name']) && $_GET['name'] != ""){
                $search_name = "`name` LIKE '% ".$_GET['name']." %' ";
            }
            else{
                $search_name = "1";
            }

            if (isset($_GET['price'])){
                $p = $_GET['price'] * 5;
                $search_price = " AND `price` <= '".$p ."' ";
            }
            else{
                $search_price = "1";
            }
            
            if (isset($_GET['verified'])){
                $search_verified = "AND `verified` = '1' ";
            }
            else{
                $search_verified = " AND 1 ";
            }

            if (isset($_GET['gender']) && $_GET['gender'] == "male"){
                $search_gender = "AND `gender` = 1 ";
            }
            elseif (isset($_GET['gender']) && $_GET['gender'] == "female"){
                $search_gender = "AND `gender` = 0 ";
            }
            else{
                $search_gender = " AND 1 ";
            }

            if (isset($_GET['min-age']) && $_GET['min-age'] != ""){
                
                $search_min_age = " AND `age` <= ' ". AgetoDate($_GET['min-age']) ." ' ";
            }
            else{
                $search_min_age = " AND 1 ";
            }

            if (isset($_GET['max-age']) && $_GET['max-age'] != ""){
                $search_max_age = " AND `age` >= ' ". AgetoDate($_GET['max-age']) ." ' ";

            }
            else{
                $search_max_age = " AND 1 ";
            }
            
            if (isset($_GET['education']) && !empty($_GET['education'])){
                $search_education = "AND `qualification` = '".$_GET['education']."' ";
            }
            else{
                $search_education = " AND 1 ";
            }
            
            if (isset($_GET['rating'])){
                $search_rating = "AND `rating` >= '".$_GET['rating']."' ";
            }
            else{
                $search_rating = " ";
            }

            if (isset( $_GET['topics'] ) && !empty( $_GET['topics'] )){
                $search_topic = "AND `subject` LIKE '%".$_GET['topics']."%' ";
            }
            else{
                $search_topic = " AND 1 ";
            }

        }
        
        # If searched by the name bar
        elseif ( isset($_GET['name_search'] ) ) {
            $search_page_on = "";
            $tutor_page = "display:none";

        }
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Astegni&copy; An Ethiopian Tutor Site</title>
    <script  src="https://code.jquery.com/jquery-3.4.1.min.js"  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="  crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/x-icon" href="images/logo2.png" />
    <link rel="stylesheet" href="Styles/index.css">
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

<!-- The navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a style="margin-right:1rem;" href="#">
                <img class="big-banner" height="50px" src="images/benner.png" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                  <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
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
                            </li>';
                    
                    
                    
                    }
                    elseif ( isset ( $_SESSION['id'] ) ){
                        echo '  <li class="nav-item">
                                    <a class="nav-link" href="account.php">Account</a>
                                </li>';
                        }
                    ?>
                
              </ul>
              
              <form class="form-inline my-2 my-lg-0" action = "index.php" method = "GET" >
                <input name="name_search" class="form-control mr-sm-2 fontAwesome" type="search" placeholder="&#xf002 Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
              </form>
            </div>
</nav>
   
<div class="container-fluid" style="display: flex;overflow-x: hidden;">
    <div class="row" style="min-height: 890px;">
        <!-- The Advanced search part   -->
            <div class="col-md-3 adv-search" style="order: 2">
                <div class="search-form">
                        <center><h3>Advanced Search</h3></center>
                        <form action="index.php" method = "GET">
                            <div class="row no-gutters">
                                <div class="input-group mb-4">
                                    
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Name</div>
                                    </div>
                                    
                                    <input type="text" name = "name" class="form-control" id="inlineFormInputGroup">
                                </div>
                                <!-- Price slider -->
                                
                                <div class="input-group mb-4">
                                    
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Price</div>
                                        </div>
                                
                                        <!-- <input onchange="setValue()" id="slider" type="range" class="custom-range" min="0" max="50" value="25" step="1"> -->
                                        <input name="price" onchange="setValue()" id="slider" type="range"  min="0" max="50" value="20" step="1" class="form-control-range custom-range-rating">
                                        <div class="input-group-prepend pv">
                                            <div id="slider-value" class="input-group-text">&lt;100</div>
                                        </div>
                                </div>
                                <!-- Radio Inputs -->
                                <div class="input-group mb-4">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="customRadioInline1" name="gender" value = "male" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadioInline1">Male</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="customRadioInline2" name="gender" value = "female" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadioInline2">Female</label>
                                    </div>
                                </div>
                                <!-- Checkbox Input -->
                                <div class="input-group mb-4">
                                    <div class="custom-control custom-checkbox">
                                        <input name="verified" type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1">Verified</label>
                                    </div>
                                </div>
                                <!-- Age gap input -->
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Age</div>
                                    </div>
                                    <input name = "min-age" class="form-control form-inline age-input" type="number" min= "0" max = "65" name="" id="">
                                    <i class="fas fa-minus" style="margin: 11px 20px;"></i>
                                    <input name = "max-age" class="form-control form-inline age-input" type="number" min= "0" max = "65" name="" id="">
                                </div>
                                <!-- Education input -->
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Education</div>
                                    </div>
                                    <select id="edu" name="education" class="form-control">
                                        <option></option>
                                        <option value="Experiance">Experiance</option>
                                        <option value="High schooler">High schooler</option>
                                        <option value="College student">College student</option>
                                        <option value="Degree graduate">Degree graduate</option>
                                        <option value="Masters graduate">Masters graduate</option>
                                        <?php
                                            $r = mysqli_query($conn,"SELECT DISTINCT `qualification` FROM `tutors` WHERE NOT( `qualification` = 'Experiance' OR 
                                            `qualification` = 'High schooler' OR `qualification` = 'College student' OR `qualification` = 'Degree graduate' OR `qualification` = 'Masters graduate' )");
                                            while ( $qual = mysqli_fetch_row( $r ) ){
                                                echo '<option value="'.$qual[0].'">'.$qual[0].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <!-- Rating input -->
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" style="padding:0.25rem">Rating</div>
                                    </div>
                                
                                    <input name="rating" onchange="setRatingValue()" id="rating-slider" type="range"  min="0" max="5" value="3" step="0.05" class="form-control-range custom-range-rating">
                                    <div class="input-group-prepend pv">
                                        <div id="rating-slider-value" class="input-group-text">>3</div>
                                    </div>
                                </div>
                                <!-- Topics about -->
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Topic you want</div>
                                    </div>
                                    <input name = "topics" type="text" class="form-control" id="inlineFormInputGroup">
                                </div>
                                <div style="text-align:center;width: 100%">
                                    <button type="submit" class="btn btn-outline-success">Search</button>
                                </div>
                            </div>
                        </form>
                </div>
                <div class="col-md-12" style="margin: 3rem 0 0 0;text-align: center;">
                    <h4>Sign up as user</h4>
                    <hr>
                    <form id="user-signup-form" style="margin: 0;padding: 0 !important;">
                        <!-- user signup collapse   -->
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
                <div class="col-md-12">
                    <div class="promo" style="text-align: center">
                        <p>Sign up now, become a tutor and make easy money.</p>
                        <button class="btn btn-md btn-success" style="margin: 0">Sign up</button>
                    </div>
                </div>
                    
            </div>
        <!-- The main tutor list -->
            <div class="col-md-9 top-tuts" style="<?php echo $tutor_page?>">
                <a style="color: #363532;" data-toggle="collapse" data-target="#adv" aria-expanded="false" aria-controls="adv" href="#"><center><h3 >Advanced search</h3></center></a>
                <!-- Advanced search for phones -->
                <div class="col-md-3 adv-search-phone collapse" id="adv">
                    <form action="index.php" method = "GET">
                            <div class="row no-gutters">
                                <div class="input-group mb-4">
                                    
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Name</div>
                                    </div>
                                    
                                    <input type="text" name = "name" class="form-control" id="inlineFormInputGroup">
                                </div>
                                <!-- Price slider -->
                                
                                <div class="input-group mb-4">
                                    
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Price</div>
                                        </div>
                                
                                        <!-- <input onchange="setValue()" id="slider" type="range" class="custom-range" min="0" max="50" value="25" step="1"> -->
                                        <input name="price" onchange="setValue()" id="slider" type="range"  min="0" max="50" value="20" step="1" class="form-control-range custom-range-rating">
                                        <div class="input-group-prepend pv">
                                            <div id="slider-value" class="input-group-text">&lt;100</div>
                                        </div>
                                </div>
                                <!-- Radio Inputs -->
                                <div class="input-group mb-4">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="customRadioInline1" name="gender" value = "male" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadioInline1">Male</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="customRadioInline2" name="gender" value = "female" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadioInline2">Female</label>
                                    </div>
                                </div>
                                <!-- Checkbox Input -->
                                <div class="input-group mb-4">
                                    <div class="custom-control custom-checkbox">
                                        <input name="verified" type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1">Verified</label>
                                    </div>
                                </div>
                                <!-- Age gap input -->
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Age</div>
                                    </div>
                                    <input name = "min-age" class="form-control form-inline age-input" type="number" min= "0" max = "65" name="" id="">
                                    <i class="fas fa-minus" style="margin: 11px 20px;"></i>
                                    <input name = "max-age" class="form-control form-inline age-input" type="number" min= "0" max = "65" name="" id="">
                                </div>
                                <!-- Education input -->
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Education</div>
                                    </div>
                                    <select id="edu" name="education" class="form-control">
                                        <option></option>
                                        <option value="Experiance">Experiance</option>
                                        <option value="High schooler">High schooler</option>
                                        <option value="College student">College student</option>
                                        <option value="Degree graduate">Degree graduate</option>
                                        <option value="Masters graduate">Masters graduate</option>
                                        <?php
                                            $r = mysqli_query($conn,"SELECT DISTINCT `qualification` FROM `tutors` WHERE NOT( `qualification` = 'Experiance' OR 
                                            `qualification` = 'High schooler' OR `qualification` = 'College student' OR `qualification` = 'Degree graduate' OR `qualification` = 'Masters graduate' )");
                                            while ( $qual = mysqli_fetch_row( $r ) ){
                                                echo '<option value="'.$qual[0].'">'.$qual[0].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <!-- Rating input -->
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" style="padding:0.25rem">Rating</div>
                                    </div>
                                
                                    <input name="rating" onchange="setRatingValue()" id="rating-slider" type="range"  min="0" max="5" value="3" step="0.05" class="form-control-range custom-range-rating">
                                    <div class="input-group-prepend pv">
                                        <div id="rating-slider-value" class="input-group-text">>3</div>
                                    </div>
                                </div>
                                <!-- Topics about -->
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Topic you want</div>
                                    </div>
                                    <input name = "topics" type="text" class="form-control" id="inlineFormInputGroup">
                                </div>
                                <div style="text-align:center;width: 100%">
                                    <button type="submit" class="btn btn-outline-success">Search</button>
                                </div>
                            </div>
                    </form>
                </div>
                <center><h3>Top Tutors</h3></center>
                <div class="row">
                        <?php
                            ########### Pagination stuff
                            $per_page = 6;
                            
                            if( isset($_GET['page']))
                                $page = $_GET['page'];
                            else
                                $page = 1;
                            
                            $start = ($page - 1) * $per_page;
                            
                            $page_query = "SELECT * FROM tutors ORDER BY `rating` DESC ";
                            $no_of_rows = mysqli_num_rows(mysqli_query($conn,$page_query));
                            $pages = ceil($no_of_rows/$per_page);
                            
                            ###########
                            
                            $q = "SELECT * FROM tutors ORDER BY `rating` DESC LIMIT $start,$per_page";
                            $r = mysqli_query($conn,$q);
                            
                            while($row = mysqli_fetch_assoc($r)){
                                
                                if ( $row['gender'] ) { $row['gender'] = "Male"; }
                                else { $row['gender'] = "Female"; }
                                
                                displayCard($row['id'],$row['name'],$row['photo'],$row['gender'],$row['price'],$row['rating'],mashedSubject($row['id']),$row['verified']);
                            }    
                        ?>
                    <div style="text-align:center;width:100%">
                        <nav aria-label="Page navigation example" class="page-scroll">
                            <ul class="pagination justify-content-center">
                                
                                
                                <?php
                                    if ($page - 1 < 1){
                                        echo '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a></li>';
                                    }
                                    else{
                                        echo '<li class="page-item"><a class="page-link" href="index.php?page='. ($page - 1) .'" tabindex="-1" aria-disabled="true">Previous</a></li>';
                                    }
                                    
                                    for ($i=1; $i <= $pages ; $i++) { 
                                        echo '<li class="page-item"><a class="page-link" href="index.php?page='.$i.'">'.$i.'</a></li>';
                                        
                                    }
                                    
                                    if ($page + 1 > $pages){
                                        echo '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
                                    }
                                    else{
                                        echo '<li class="page-item"><a class="page-link" href="index.php?page='. ($page + 1) .'">Next</a></li>';
                                    }
                                ?>
                                
                                
                            </ul>
                        </nav>
                    </div>            
                </div>
                        
            </div>
        <!-- The search-->
        <div class="col-md-9 search-result" style="padding:1rem;<?php echo $search_page_on;?>">
                <a id="advsearch-result" style="color: #363532;" data-toggle="collapse" data-target="#adv" aria-expanded="false" aria-controls="adv" href="#"><center><h3 >Advanced search</h3></center></a>
                    <!-- Advanced search for phones -->
                    <div class="col-md-3 adv-search-phone collapse" id="adv">
                            
                            <form action="">
                                <div class="row no-gutters">
                                    <div class="input-group mb-4">
                                        
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Name</div>
                                        </div>
                                        
                                        <input type="text" class="form-control" id="inlineFormInputGroup">
                                    </div>
                                    <!-- Price slider -->
                                    
                                    <div class="input-group mb-4">
                                        
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Price</div>
                                            </div>
                                    
                                            <!-- <input onchange="setValue()" id="slider" type="range" class="custom-range" min="0" max="50" value="25" step="1"> -->
                                            <input onchange="setValue()" id="slider" type="range"  min="0" max="50" value="20" step="1" class="form-control-range custom-range">
                                            <div class="input-group-prepend pv">
                                                <div id="slider-value" class="input-group-text">&lt;100</div>
                                            </div>
                                    </div>
                                    <!-- Radio Inputs -->
                                    <div class="input-group mb-4">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadioInline1">Male</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadioInline2">Female</label>
                                        </div>
                                    </div>
                                    <!-- Checkbox Input -->
                                    <div class="input-group mb-4">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">Verified</label>
                                        </div>
                                    </div>
                                    <!-- Age gap input -->
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Age</div>
                                        </div>
                                        <input class="form-control form-inline age-input" type="number" min= "0" max = "65" name="" id="">
                                        <i class="fas fa-minus" style="margin: 11px 20px;"></i>
                                        <input class="form-control form-inline age-input" type="number" min= "0" max = "65" name="" id="">
                                    </div>
                                    <!-- Education input -->
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Education</div>
                                        </div>
                                        <select class="form-control">
                                            <option>Experiance</option>
                                            <option>High schooler</option>
                                            <option>College student</option>
                                            <option>Degree graduate</option>
                                            <option>Masters graduate</option>
                                        </select>
                                    </div>
                                    <!-- Rating input -->
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text" style="padding:0.25rem">Rating</div>
                                        </div>
                                    
                                        <input onchange="setRatingValue()" id="rating-slider" type="range"  min="0" max="5" value="3" step="0.05" class="form-control-range custom-range-rating">
                                        <div class="input-group-prepend pv">
                                            <div id="rating-slider-value" class="input-group-text">>3</div>
                                        </div>
                                    </div>
                                    <!-- Topics about -->
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Topic you want</div>
                                        </div>
                                        <input type="text" class="form-control" id="inlineFormInputGroup">
                                    </div>
                                    <div style="text-align:center;width: 100%">
                                        <button type="submit" class="btn btn-outline-success">Search</button>
                                    </div>
                                </div>
                            </form>
                
                        </div>
                    <!-- Tutor search-result list          -->
                    <div class = "row justify-content-between" style="margin-bottom:3rem">
                        <div class="col-md">
                            <h4 style="text-align:center">
                                <?php
                                    if ( isset($_GET['name_search'] ) ){
                                        echo "Search results for '".$_GET['name_search']."'";
                                    }
                                    else{
                                        echo "Search results";
                                    }

                                ?>
                            </h4>
                        </div>
                        <div class="col-md">
                            <t style="float:right">
                                <?php 
                                    if ( !isset( $_GET['name_search'] ))
                                        echo "<i>\"Rated greater than ".@$_GET['rating']." and price cheaper than ".@$_GET['price'] * 5 ."\"</i>"; ?>
                            </t>
                        </div>            
                    </div>
                    <div class="row" style="min-height: 890px;">
                        <?php
                            $per_page = 6;
                            
                            if ( isset($_GET['name_search'] ) ) {
                                ########### Pagination stuff
                                
                                
                                if( isset($_GET['page']))
                                    $page = $_GET['page'];
                                else
                                    $page = 1;
                                
                                $start = ($page - 1) * $per_page;
                                
                                $page_query = " SELECT * FROM tutors WHERE `name` LIKE '%".$_GET['name_search']."%'";
                                $no_of_rows = mysqli_num_rows(mysqli_query($conn,$page_query));
                                $pages = ceil($no_of_rows/$per_page);
                                
                                ###########
                                
                                # The search query for name search
                                $qry = " SELECT * FROM tutors WHERE `name` LIKE '%".$_GET['name_search']."%' LIMIT $start,$per_page";
                            }
                            elseif ( isset($_GET['price'])) {
                                ########### Pagination stuff
                                
                                
                                if( isset($_GET['page']))
                                    $page = $_GET['page'];
                                else
                                    $page = 1;
                                
                                $start = ($page - 1) * $per_page;
                                
                                $page_query = "SELECT * FROM tutors JOIN subjects ON tutors.id = subjects.tutor_id 
                                WHERE ".$search_name.$search_price.$search_verified.$search_gender.$search_min_age.$search_max_age.$search_education.$search_rating.$search_topic."";
                                $no_of_rows = mysqli_num_rows(mysqli_query($conn,$page_query));
                                $pages = ceil($no_of_rows/$per_page);
                                
                                ###########
                                
                                # The search query for advanced search
                                $qry ="SELECT * FROM tutors JOIN subjects ON tutors.id = subjects.tutor_id 
                                WHERE ".$search_name.$search_price.$search_verified.$search_gender.$search_min_age.$search_max_age.$search_education.$search_rating.$search_topic."GROUP by tutors.id LIMIT $start,$per_page";
                                
                            }
                           
                            # The executor
                            $r = mysqli_query($conn,$qry);
                            
                            #For refining
                            $displayed = array();
                            
                            if (mysqli_num_rows($r) < 1){
                                echo "<h4 style='margin-left: 2rem;'>No results found...</h4>";
                            }
                            
                            while($row = mysqli_fetch_assoc($r)){
                                #To display gender
                                if ( $row['gender'] ) { $row['gender'] = "Male"; }
                                else { $row['gender'] = "Female"; }

                                if ( ! in_array($row['id'],$displayed ) ) {
                                    array_push( $displayed , $row['id'] );  
                                    displayCard($row['id'],$row['name'],$row['photo'],$row['gender'],$row['price'],$row['rating'],mashedSubject($row['id']),$row['verified']);
                                }    
                            }
                        ?>
                        <div style="text-align:center;width:100%;height: fit-content;">
                            <nav aria-label="Page navigation example" class="page-scroll">
                                <ul class="pagination justify-content-center">
                                    
                                    
                                    <?php
                                        if ( isset($_GET['price'])){
                                            if ($page - 1 < 1){
                                                echo '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a></li>';
                                            }
                                            else{
                                                echo '<li class="page-item"><a class="page-link" href="index.php?'.CleanQuery($_SERVER['QUERY_STRING']).'&page='. ($page - 1) .'" tabindex="-1" aria-disabled="true">Previous</a></li>';
                                            }
                                            
                                            for ($i=1; $i <= $pages ; $i++) { 
                                                echo '<li class="page-item"><a class="page-link" href="index.php?'.CleanQuery($_SERVER['QUERY_STRING']).'&page='.$i.'">'.$i.'</a></li>';
                                                
                                            }
                                            
                                            if ($page + 1 > $pages){
                                                echo '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
                                            }
                                            else{
                                                echo '<li class="page-item"><a class="page-link" href="index.php?'.CleanQuery($_SERVER['QUERY_STRING']).'&page='. ($page - 1) .'">Next</a></li>';
                                            }
                                        }
                                        elseif ( isset($_GET['name_search'] )){
                                            
                                            if ($page - 1 < 1){
                                                echo '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a></li>';
                                            }
                                            else{
                                                echo '<li class="page-item"><a class="page-link" href="index.php?'.CleanQuery($_SERVER['QUERY_STRING']).'&page='. ($page - 1) .'" tabindex="-1" aria-disabled="true">Previous</a></li>';
                                            }
                                            
                                            for ($i=1; $i <= $pages ; $i++) { 
                                                echo '<li class="page-item"><a class="page-link" href="index.php?'.CleanQuery($_SERVER['QUERY_STRING']).'&page='.$i.'">'.$i.'</a></li>';
                                                
                                            }
                                            
                                            if ($page + 1 > $pages){
                                                echo '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
                                            }
                                            else{
                                                echo '<li class="page-item"><a class="page-link" href="index.php?'.CleanQuery($_SERVER['QUERY_STRING']).'&page='. ($page + 1) .'">Next</a></li>';
                                            }
                                        }
                                    ?>
                                    
                                    
                                </ul>
                            </nav>
                        </div>
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
<script src="js-includes/login.js"></script>
<script>
    function setValue(){
        var slider = document.getElementById("slider")
        var ValDisp = document.getElementById("slider-value")
        ValDisp.innerHTML = "<"+slider.value * 5
    }
    function setRatingValue(){
        var Rslider = document.getElementById("rating-slider")
        var RValDisp = document.getElementById("rating-slider-value")
        RValDisp.innerHTML = ">"+Rslider.value
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
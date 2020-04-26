<?php
    include 'connection.php';
    # Checks if a value exists in a column
    function thereExists($to_be_checked,$table,$col){
        
        $query = "SELECT ".$col." FROM ".$table."";
        $run = mysqli_query($GLOBALS['link'],$query);
        
        for($i = 0 ; $row = mysqli_fetch_assoc($run) ; $i++){
            
            if ( $to_be_checked == $row[$col] ) {
                return 1;
            }
            else
                continue;
        }
        return 0;
    }
    #Retirver
    function get($id,$what){
        switch ($what) {
            case 'tutor':
                
                $r = mysqli_query($GLOBALS['link'],"SELECT * FROM `tutors` WHERE `id` = '".$id."'");
                if (mysqli_num_rows($r) < 1)
                    return -1;
                else
                    return mysqli_fetch_assoc($r);
                
                break;
            case 'comment':
                  
                $r = mysqli_query($GLOBALS['link'],"SELECT * FROM `comments` WHERE `id` = '".$id."'");
                if (mysqli_num_rows($r) < 1)
                    return -1;
                else
                    return mysqli_fetch_assoc($r);
                
                break;
            
            case 'user':
                $q = "SELECT * FROM `users` WHERE `id` = '".$id."'";
                $r = mysqli_query($GLOBALS['link'],$q);
                if (mysqli_num_rows($r) < 1)
                    return -1;
                else
                    return mysqli_fetch_assoc($r);
                break;
            case 'report':
   
                $r = mysqli_query($GLOBALS['link'],"SELECT * FROM `report` WHERE `id` = '".$id."'");
                if (mysqli_num_rows($r) < 1)
                    return -1;
                else
                    return mysqli_fetch_assoc($r);
                
                break;
            
            default:
                return -1;
                break;
        }
    }
    # Displays the tutor card
    function displayCard($id,$name,$image,$gender,$price,$rating,$subs,$is_verified){
        if ($is_verified){
            echo '
            <div class="col-md-3 tut-card">
                <a href="detail.php?id='.$id.'" class="tut-link">
                    <div class="row no-gutters" style="padding: 1rem 0;">
                        <div class="img-cont">
                            <figure>
                                <img style="height:200px;width:100%" src="'.$image.'" alt="">
                                <figcaption><center>'.$name.'</center></figcaption>
                            </figure>
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="col-md-12" style="outline: 1px solid #80808069;outline-offset: 5px;">
                            <div class="row justify-content-around gender-field no-gutters info-row">
                                <div class="col-6">
                                    Gender
                                </div>
                                <div class="col-6">
                                    '.$gender.'
                                </div>
                            </div>
                            <div class="row justify-content-around price-field no-gutters info-row">
                                <div class="col-6">
                                    Price
                                </div>
                                <div class="col-6">
                                    '.$price.'
                                </div>
                            </div>
                            <div class="row justify-content-around rating-field no-gutters info-row">
                                <div class="col-6">
                                    Rating
                                </div>
                                <div class="col-6">
                                    '.$rating.'
                                </div>
                            </div>
                            <div class="row justify-content-around topic-field no-gutters ">
                                <div class="col-4">
                                    Tutors
                                </div>
                                <div class="col-8" style="text-overflow: ellipsis;overflow: hidden;white-space: nowrap;">
                                    '.$subs.'
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>';}
            else{
                echo '
                <div class="col-md-3 tut-card">
                    <a href="detail.php?id='.$id.'" class="tut-link">
                        <div class="row no-gutters" style="padding: 1rem 0;">
                            <div class="img-cont">
                                <figure>
                                    <img style="height:200px;width:100%" src="'.$image.'" alt="">
                                    <figcaption><center>'.$name.'</center></figcaption>
                                </figure>
                            </div>
                            <div class="col-md-12" style="outline: 1px solid #80808069;outline-offset: 5px;">
                                <div class="row justify-content-around gender-field no-gutters info-row">
                                    <div class="col-6">
                                        Gender
                                    </div>
                                    <div class="col-6">
                                        '.$gender.'
                                    </div>
                                </div>
                                <div class="row justify-content-around price-field no-gutters info-row">
                                    <div class="col-6">
                                        Price
                                    </div>
                                    <div class="col-6">
                                        '.$price.'
                                    </div>
                                </div>
                                <div class="row justify-content-around rating-field no-gutters info-row">
                                    <div class="col-6">
                                        Rating
                                    </div>
                                    <div class="col-6">
                                        '.$rating.'
                                    </div>
                                </div>
                                <div class="row justify-content-around topic-field no-gutters ">
                                    <div class="col-4">
                                        Tutors
                                    </div>
                                    <div class="col-8" style="text-overflow: ellipsis;overflow: hidden;white-space: nowrap;">
                                        '.$subs.'
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>';  
            }

    }
    # Display the tutor card by id
    function displayCard_by_id($id){
        $tutor = mysqli_fetch_assoc(mysqli_query($GLOBALS['link'],"SELECT * FROM `tutors` WHERE `id` = '".$id."'"));
        
        if ( $tutor['gender'] ) { $tutor['gender'] = "Male"; }
        else { $tutor['gender'] = "Female"; }
        
        displayCard($tutor['id'],$tutor['name'],$tutor['photo'],$tutor['gender'],$tutor['price'],$tutor['rating'],mashedSubject($tutor['id']),$tutor['verified']);
    }
    # Mashes the subjects into one string
    function mashedSubject($id) {
        
        $stringed = "";
        $r = mysqli_query($GLOBALS['link'],"SELECT * FROM subjects WHERE tutor_id = {$id}");
        
        while($row = mysqli_fetch_assoc($r)){
            $stringed = $stringed.$row['subject']."^";
        }

        return str_replace("^"," ,",ucwords($stringed));
    }
    # Checks if any cookies are set
    function is_a_cookie_set(){
        if (count($_COOKIE) > 0){
            return true;
        }
        else{
            return false;
        }
    }
    # Uploader
    function Upload($name,$size,$temp){
        $Target_dir = "../Uploads/";
        $target_file = $Target_dir . $name;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if ( $size < 2000000 && $size != 0 ) {
            if ( getimagesize($temp) ) {
            
                if ($imageFileType == "png" || $imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "ico"){
                    if(move_uploaded_file($temp,$target_file)){
                        $uploadok = true;
                    }
                }
                else{
                    echo 'Unsupported file type.';
                }
            }
            
        }
        else{
            echo 'Size too large..'.$size / 100000 .'MB';
        }

        if ($uploadok){
            return true;
        }
    }
    # Suffixer
    function add_suffix($num) {
        if (!in_array(($num % 100),array(11,12,13))){
          switch ($num % 10) {
            // Handle 1st, 2nd, 3rd
            case 1:  return $num.'st';
            case 2:  return $num.'nd';
            case 3:  return $num.'rd';
          }
        }
        return $num.'th';
    }
    # Checks if subject exists
    function subjExists($sub,$id){
        $r = mysqli_query($GLOBALS['link'],"SELECT * FROM `subjects` WHERE `tutor_id` = '".$id."' ");
        while($row = mysqli_fetch_assoc($r)){
            if ( $row['subject'] == $sub) {
                return true;
            }
            else
                continue;
        }
        return false;
    }
    # Calculates the age
    function ageCalc($y){
        $m = '01'; $d = '01';
        $bday_string = $y.'-'.$m.'-'.$d;
        $bday = new Datetime(date(''.$bday_string));
        $today = new Datetime(date('y-m-d'));
        $diff = date_diff($today,$bday);
        return $diff->y;
    }
    # Breaks strings up
    function frag($str){
        $arr = explode("-",$str);
        return $arr;
    }
    # Remove all cookies
    function KillCookies(){
        if (isset($_SERVER['HTTP_COOKIE'])) {
                $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
                foreach($cookies as $cookie) {
                    $parts = explode('=', $cookie);
                    $name = trim($parts[0]);
                    setcookie($name, '', time()-1000);
                    setcookie($name, '', time()-1000, '/');
                }
            }
    }
    # Cleans the url
    function CleanQuery($str){
        $arr = explode('&',$str);
        unset($arr[ count($arr) - 1]);
        return implode('&',$arr);
        
    }
    # Trabslates age to date
    function AgetoDate($age){
        $today = new Datetime(date('Y'));
        $today_int = intval($today->format('Y'));
        return $today_int - $age;
    }
    # Getting ip addresses
    function getUserIpAddr(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }


?>
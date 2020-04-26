//Login
$("#login_form").submit(function (e) {
    e.preventDefault();
    var formdata = new FormData(this);
    // Display the key/value pairs
    for (var pair of formdata.entries()) {
        console.log(pair[0]+ ', ' + pair[1]); 
    }

    $.ajax({
        url:'php-includes/login_parser.php',
        method: "POST",
        data: formdata,
        contentType: false, 
        processData: false,
        success:function(data){
            $("#login_but").attr("disabled","disabled");
            $(".loader").attr("style","display:block");
            if ( data == "wrong"){
                $("#login_but").removeAttr("disabled");
                $(".loader").attr("style","display:none");
                $("#feedback").attr("style","display:block");
            }

            else if ( data == "clear"){
                location.href = "account.php";
            }
            else if ( data == "clear-user"){
                location.href = "index.php";
            }
            else
                console.log(data);
        }
    })
});

//Sign up
$("#user-signup-form").submit(function(e) {
    e.preventDefault();
    var formdatasn = new FormData(this);

    $.ajax({
        url:'php-includes/user-signup-parser.php',
        method: "POST",
        data: formdatasn,
        contentType: false, 
        processData: false,
        success:function(data){
            $("#signup-but").attr("disabled","disabled");
            $("#signup-loader").attr("style","display:block");
            if ( data == "username exists!"){
                $("#signup-but").removeAttr("disabled");
                $("#signup-loader").attr("style","display:none");
                $("#signup-feedback").attr("style","display:block");
                $("#signup-feedback").text("Username exists!");
                $("#username_signup").addClass("is-invalid");
            }

            else if ( data == "clear"){
                
                location.href = "index.php";
            }
            
            else
                console.log(data);
        }
    })
});

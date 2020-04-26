


function gotoBottom(id){
    var element = document.getElementById(id);
    element.scrollTop = element.scrollHeight;
 }
 setInterval(gotoBottom("cmnt-bx"),1000);

 //Comment sender
function commenter() {
    
    $.post("php-includes/comment.php",{commenter_id:$("#c").val() , commented_on_id:$("#w").val(), commenter_type:$("#t").val() ,comment:$("#comment-text").val() },
       function(response){
            $("#comment-text").val("");
            $("#cmnt-bx").attr("style","display:block");
            $("#cmnt-bx").append(response);
            gotoBottom("cmnt-bx")
       }
    );

}



var name = $("#name_field")
var username = $("#usernameid")

//Validifier gate
setInterval(function(){
    
    if ( name.value != "" && username.val() != ""){
        $("#subut").removeAttr("disabled")
    }
    else
        $("#subut").attr("disabled","disabled")
},1000);

// Sending form data to the server side
$("#signup-form").submit(function(e){
    e.preventDefault();
    var theForm = new FormData(this);
    
    $.ajax({
        url: "php-includes/signup-parser.php",
        method: "POST",
        data: theForm,
        contentType: false, 
        processData: false,
        success:function(data){
            console.log(data);
            
            if ( data.includes('Username') ){
                $("#usernameid").addClass("is-invalid")
                $("#username-feedback").text(data)
            }
            else if (data.includes('Unsupported')){
                $("#photo-feedback").text(data)
                $("#inputGroupFile02").addClass("is-invalid")
            }
            else if (data.includes('Size')){
                $("#photo-feedback").text(data)
                $("#inputGroupFile02").addClass("is-invalid")
            }
            else if(data == "clear"){
                // Redirecting
                location.href = "account.php";
            }
        }
    })
    return false;
});


// For diplaying other qualification input field.
$('#qualif').on('change',function(){
    var optionText = $("#qualif option:selected").text();
    if (optionText == "Other"){
        $("#other").attr("style","display:block");
    }
    else{
        $("#other").attr("style","display:none");
    }
}); 

// For adding and remove input fields
var i = 1;

$("#add").click(function(){
    i++;
    $("#topic-list").append('<input id="input-topic'+i+'" class="form-control fontAwesome" type="text" name="topic[]" placeholder="Subject"/><span id="'+i+'" class="fas fa-window-close red-x"></span>');
});
$(document).on('click','.red-x',function(){
    var but_id = $(this).attr("id");
    $("#"+but_id+"").remove();
    $("#input-topic"+but_id+"").remove();
});

// Setting the name
function nameset(){
    //get the file name
    var fileName = $('#inputGroupFile02').val().replace('C:\\fakepath\\', " ");
    //replace the "Choose a file" label
    $('#inputGroupFile02').next('.custom-file-label').html(fileName);
}
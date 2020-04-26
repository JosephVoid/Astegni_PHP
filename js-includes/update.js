

$("#submit-btn").click(function(){
    
    var theformdata = new FormData(document.getElementById("second-form"));
    theformdata.append("about",$("#about-text").val());
    var file = document.getElementById("profile-photo").files[0];
    theformdata.append("photo",file.size);
    
    // // Display the key/value pairs
    // for (var pair of theformdata.entries()) {
    //     console.log(pair[0]+ ', ' + pair[1]); 
    // }
    
    $.ajax({
        url: "php-includes/update-parser.php",
        method: "POST",
        data: theformdata,
        contentType: false, 
        processData: false,
        success:function(data){
            console.log(data);
        }
    })
})
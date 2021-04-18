$("#forgotpasswordform").submit(function(event){ 
    
    event.preventDefault();
    
    var datatopost = $(this).serializeArray();

    $.ajax({
        url: "forgot-password.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#forgotpasswordmessage").html(data);
            }
        },
        error: function(){
            $("#forgotpasswordmessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");
            
        }
    
    });

});


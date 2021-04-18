<?php

session_start();
include('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>New Email activation</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <style>
            h1{
                color:purple;   
            }
            .contactForm{
                border:1px solid #7c73f6;
                margin-top: 50px;
                border-radius: 15px;
            }
        </style> 

    </head>
        <body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10 contactForm">
            <h1>Email Activation</h1>
<?php

if(!isset($_GET['email']) || !isset($_GET['newemail']) || !isset($_GET['key'])){
    echo '<div class="alert alert-danger">There was an error. Please click on the link you received by email.</div>'; exit;
}

$email = $_GET['email'];
$newemail = $_GET['newemail'];
$key = $_GET['key'];
    
$email = mysqli_real_escape_string($link, $email);
$newemail = mysqli_real_escape_string($link, $newemail);
$key = mysqli_real_escape_string($link, $key);
    
$sql = "UPDATE users SET email='$newemail' AND activation2='0' WHERE (email='$email' AND activation2='$key') LIMIT 1";
$result = mysqli_query($link, $sql);
    
if(mysqli_affected_rows($link) == 1){
    session_destroy();
    setcookie("rememeberme", "", time()-3600);
    echo '<div class="alert alert-success">Your email has been updated.</div>';
    echo '<a href="index.php" type="button" class="btn-lg btn-sucess">Log in<a/>';
    
}else{
    
    echo '<div class="alert alert-danger">Your email could not be updated. Please try again later.</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    
}
?>
            
        </div>
    </div>
</div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        </body>
</html>
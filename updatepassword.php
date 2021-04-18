<?php

session_start();
include ('connection.php');


$missingCurrentPassword = '<p><strong>Please enter your Current Password!</strong></p>';
$incorrectCurrentPassword = '<p><strong>The password entered is incorrect!</strong></p>';
$missingPassword = '<p><strong>Please enter a new Password!</strong></p>';
$invalidPassword = '<p><strong>Your password should be at least 6 characters long and inlcude one capital letter and one number!</strong></p>';
$differentPassword = '<p><strong>Passwords don\'t match!</strong></p>';
$missingPassword2 = '<p><strong>Please confirm your password</strong></p>';


if(empty($_POST["currentpassword"])){
    $errors .= $missingCurrentPassword;
}else{
    $currentPassword = $_POST["currentpassword"];
    $currentPassword = filter_var($currentPassword, FILTER_SANITIZE_STRING);
    $currentPassword = mysqli_real_escape_string ($link, $currentPassword);
    $currentPassword = hash('sha256', $currentPassword);
    
    $user_id = $_SESSION["user_id"];
    $sql = "SELECT password FROM users WHERE user_id='$user_id'";
    $result = mysqli_query($link, $sql);
    
    $count = mysqli_num_rows($result);
    if($count !== 1){
        echo '<div class="alert alert-danger">There was a problem running the query</div>';
    }else{
        $row = mysqli_fetch_array($result, MYSQL_ASSOC);
        if($currentPassword != $row['password']){
            $errors .= $incorrectCurrentPassword;
        }
    }
    
}

if(empty($_POST["password"])){
    $errors .= $missingPassword; 
}elseif(!(strlen($_POST["password"])>6
         and preg_match('/[A-Z]/',$_POST["password"])
         and preg_match('/[0-9]/',$_POST["password"])
        )
       ){
    $errors .= $invalidPassword; 
}else{
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING); 
    if(empty($_POST["password2"])){
        $errors .= $missingPassword2;
    }else{
        $password2 = filter_var($_POST["password2"], FILTER_SANITIZE_STRING);
        if($password !== $password2){
            $errors .= $differentPassword;
        }
    }
}


if($errors){
    $resultMessage = "<div class='alert alert-danger'>$errors</div>";
    echo $resultMessage;   
}else{
    $password = mysqli_real_escape_string($link, $password);
    $password = hash('sha256', $password);
    
    $sql = "UPDATE users SET password='$password' WHERE user_id='$user_id'";
    $result = mysqli_query($link, $sql);
    if(!$result){
        echo "<div class='alert alert-danger'>The password could not be reset. Please try again later.</div>";
    }else{
        echo "<div class='alert alert-success'>Your password has been updated successfully.</div>";
    }
    
}


?>
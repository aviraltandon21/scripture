<?php
$link = mysqli_connect("localhost", "aviralho_admin", "8PgSOTaS", "aviralho_onlinenotes");
if(mysqli_connect_error()){
    die('ERROR: Unable to connect:' . mysqli_connect_error()); 
    echo "<script>window.alert('Hi!')</script>";
}
    ?>
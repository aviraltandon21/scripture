<?php
session_start();
include('connection.php');


$note_id = $_POST['id'];

$sql = "DELETE FROM notes WHERE id = $note_id";
$result = mysqli_query($link, $sql);
if(!$result){
    echo 'error';   
}

?>
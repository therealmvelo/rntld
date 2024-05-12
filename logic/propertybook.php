<?php
include 'include/config.php';
$db = new DbConnect;
$conn = $db->connect();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $checkInDate = $_POST['checkInDate'];
    $checkOutDate = $_POST['checkOutDate'];
    

}

?>
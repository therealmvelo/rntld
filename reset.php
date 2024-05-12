<?php
session_start();
error_reporting(0);
include 'include/config.php';
$db = new DbConnect;
$conn = $db->connect();

$token = $_GET["token"];
$email = $_GET["email"];

$token_hash = hash("sha256", $token);

// Check if the token exists in the landlord table
$checkLandlordQuery = "SELECT * FROM landlord WHERE reset_token_hash = ?";
$checkLandlordStmt = $conn->prepare($checkLandlordQuery);
$checkLandlordStmt->bind_param("s", $token_hash);
$checkLandlordStmt->execute();
$landlordResult = $checkLandlordStmt->get_result();

// Check if the token exists in the student table
$checkStudentQuery = "SELECT * FROM student WHERE reset_token_hash = ?";
$checkStudentStmt = $conn->prepare($checkStudentQuery);
$checkStudentStmt->bind_param("s", $token_hash);
$checkStudentStmt->execute();
$studentResult = $checkStudentStmt->get_result();

if ($landlordResult->num_rows > 0) {
    // Token found in landlord table, handle operations for landlord
    $landlord = $landlordResult->fetch_assoc();
   header("Location: lnd.reset.php?email=$email");
    exit;
} elseif ($studentResult->num_rows > 0) {
    // Token found in student table, handle operations for student
    $student = $studentResult->fetch_assoc();
    header("std.rest.php");
    exit;
} else {
    // Token not found in either table
    die("Invalid token.");
}

?>
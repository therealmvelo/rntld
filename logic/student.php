<?php
session_start();
error_reporting(0);

if (isset($_SESSION['userID']) && isset($_SESSION['userName'])) {
    $studentID = $_SESSION['userID'];
    $stdName = $_SESSION['userName'];
} else {
    // Redirect the user to the login page or display an error message
    header("Location: login.php");
    exit();
}

//view booked properties
$fetchBookedPropertiesQuery = "
    SELECT p.*,l.lndName,l.lndEmail,lndProfileImage,lndPhone,isVerified
    FROM property p
    INNER JOIN booking_request b ON p.PropertyID = b.FK_PropertyID
    INNER JOIN landlord l ON p.FK_LandlordID = l.LandlordID
    WHERE b.FK_StudentID = ? AND Status = 'accept'
";

$fetchBookedPropertiesStmt = $conn->prepare($fetchBookedPropertiesQuery);
$fetchBookedPropertiesStmt->bind_param("i", $studentID);
$fetchBookedPropertiesStmt->execute();
$bookedPropertiesResult = $fetchBookedPropertiesStmt->get_result();

// Close the statement
$fetchBookedPropertiesStmt->close();

$fetchPendingPropertiesQuery = "
    SELECT p.*,l.lndName,l.lndEmail,lndProfileImage,lndPhone,isVerified
    FROM property p
    INNER JOIN booking_request b ON p.PropertyID = b.FK_PropertyID
    INNER JOIN landlord l ON p.FK_LandlordID = l.LandlordID
    WHERE b.FK_StudentID = ? AND Status = 'Pending'
";

$fetchPendingPropertiesStmt = $conn->prepare($fetchPendingPropertiesQuery);
$fetchPendingPropertiesStmt->bind_param("i", $studentID);
$fetchPendingPropertiesStmt->execute();
$PendingPropertiesResult = $fetchPendingPropertiesStmt->get_result();


?>
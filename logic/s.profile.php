<?php

session_start();
error_reporting(0);
include 'include/config.php';
$db = new DbConnect;
$conn = $db->connect();

$StudentID = $_GET["StudentID"];

// Query for student profile
$StudentProfileSQL = "SELECT
        s.stdName AS Name,
        s.stdSurname AS Surname,
        s.stdEmail AS Email,
        s.stdPhone AS PhoneNumber,
        s.stdProfileImage AS ProfileImage
        FROM
        student s
        WHERE
        s.StudentID = ?
";

$StudentProfileStmt = $conn->prepare($StudentProfileSQL);

if (!$StudentProfileStmt) {
    header("Location: student.dashboard.php");
}

$StudentProfileStmt->bind_param("i", $StudentID);
$StudentProfileStmt->execute();
$StudentProfileResults = $StudentProfileStmt->get_result();

// Query for suggested properties
$SuggestedPropertiesSQL = "SELECT
        p.PropertyID,
        p.PropertyTitle,
        p.PropertyDescription,
        p.NumberofRooms,
        p.Price,
        p.imgFrontView,
        l.lndName,
        l.lndSurname AS LandlordSurname,
        l.lndProfileImage,
        l.isVerified
        FROM
        property p
        JOIN
        landlord l ON p.FK_LandlordID = l.LandlordID
        ORDER BY
        RAND()
        LIMIT 5
";

$SuggestedPropertiesStmt = $conn->prepare($SuggestedPropertiesSQL);

if (!$SuggestedPropertiesStmt) {
    die('<script>alert("Error occured"</script>'); // Print the error message
}

$SuggestedPropertiesStmt->execute();
$SuggestedPropertiesResults = $SuggestedPropertiesStmt->get_result();

// Close statements and database connection
$StudentProfileStmt->close();
$SuggestedPropertiesStmt->close();
$conn->close();

?>
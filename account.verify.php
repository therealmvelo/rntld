<?php
include 'include/config.php';

$db = new DbConnect;
$conn = $db->connect();

try {
    $email = $_GET["email"];
    $token = $_GET["vtoken"];
    $isVerified = "yes";

    // Check if the token exists in the landlord table
    $checkLandlordQuery = "SELECT * FROM landlord WHERE vtoken_hash = ?";
    $checkLandlordStmt = $conn->prepare($checkLandlordQuery);
    $checkLandlordStmt->bind_param("s", $token);
    $checkLandlordStmt->execute();
    $landlordResult = $checkLandlordStmt->get_result();

    // Check if the token exists in the student table
    $checkStudentQuery = "SELECT * FROM student WHERE vtoken_hash = ?";
    $checkStudentStmt = $conn->prepare($checkStudentQuery);
    $checkStudentStmt->bind_param("s", $token);
    $checkStudentStmt->execute();
    $studentResult = $checkStudentStmt->get_result();

    if ($landlordResult->num_rows > 0) {
        // Token found in landlord table, handle operations for landlord
        $updateLandlordQuery = "UPDATE landlord SET isVerified = ? WHERE vtoken_hash = ?";
        $updateLandlordStmt = $conn->prepare($updateLandlordQuery);
        $updateLandlordStmt->bind_param("ss", $isVerified, $token);
        $updateLandlordStmt->execute();

        // Redirect or perform other actions as needed
        header("Location: verification_success.php");
        exit;
    } elseif ($studentResult->num_rows > 0) {
        // Token found in student table, handle operations for student
        $updateStudentQuery = "UPDATE student SET isVerified = ? WHERE vtoken_hash = ?";
        $updateStudentStmt = $conn->prepare($updateStudentQuery);
        $updateStudentStmt->bind_param("ss", $isVerified, $token);
        $updateStudentStmt->execute();

        // Redirect or perform other actions as needed
        header("Location: verification_success.php");
        exit;
    } else {
        // Token not found in either table
        die("Invalid token.");
    }
} catch (mysqli_sql_exception $e) {
    // Handle database-related errors
    echo "Database error: " . $e->getMessage();
} catch (Exception $e) {
    // Handle other unexpected errors
    echo "An unexpected error occurred: " . $e->getMessage();
}


?>
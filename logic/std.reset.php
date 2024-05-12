<?php

include 'include/config.php';
error_reporting(0);

$db = new DbConnect;
$conn = $db->connect();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $Password = $_POST["txtPassword"];
    $ConfirmPassword = $_POST["txtConfirmPassword"];

    if ($Password === $ConfirmPassword) {
        $email = $_GET["email"]; // Assuming you pass the email as a parameter in the URL

        $sql = "SELECT * FROM landlord WHERE stdEmail = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email); // Use "s" for string parameter
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $landlordID = $row['LandlordID'];

            // Update password in the database
            $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);
            $updatePasswordQuery = "UPDATE landlord SET lndPassword = ? WHERE stdEmail = ?";
            $updatePasswordStmt = $conn->prepare($updatePasswordQuery);
            $updatePasswordStmt->bind_param("ss", $hashedPassword, $email);

            if ($updatePasswordStmt->execute()) {
                $updatePasswordStmt->close();

                // Redirect to the login page
                header("Location: login.php");
                exit;
            } else {
                echo "<script> alert('Error updating password'); window.location.href='index.php';</script>";
            }
        } else {
            echo "<script> alert('Landlord not found'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script> alert('Passwords do not match'); window.location.href='index.php';</script>";
    }
}
?>
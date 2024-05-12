<?php
error_reporting(0);
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["txtEmail"];
    $token = bin2hex(random_bytes(16));
    $token_hash = hash("sha256", $token);
    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    // Check if the email exists in the landlord table
    $checkLandlordQuery = "SELECT * FROM landlord WHERE lndEmail = ?";
    $checkLandlordStmt = $conn->prepare($checkLandlordQuery);
    $checkLandlordStmt->bind_param("s", $email);
    $checkLandlordStmt->execute();
    $landlordResult = $checkLandlordStmt->get_result();

    // Check if the email exists in the student table
    $checkStudentQuery = "SELECT * FROM student WHERE stdEmail = ?";
    $checkStudentStmt = $conn->prepare($checkStudentQuery);
    $checkStudentStmt->bind_param("s", $email);
    $checkStudentStmt->execute();
    $studentResult = $checkStudentStmt->get_result();

    if ($landlordResult->num_rows > 0) {
        // Landlord email found, update landlord table
        $updateTokenQuery = "UPDATE landlord SET reset_token_hash = ?, reset_token_expires_at = ? WHERE lndEmail = ?";
        $updateTokenStmt = $conn->prepare($updateTokenQuery);
        $updateTokenStmt->bind_param("sss", $token_hash, $expiry, $email);
        $updateTokenStmt->execute();
    } elseif ($studentResult->num_rows > 0) {
        // Student email found, update student table
        $updateTokenQuery = "UPDATE student SET reset_token_hash = ?, reset_token_expires_at = ? WHERE stdEmail = ?";
        $updateTokenStmt = $conn->prepare($updateTokenQuery);
        $updateTokenStmt->bind_param("sss", $token_hash, $expiry, $email);
        $updateTokenStmt->execute();
    } else {
        // Email not found in either table
        echo "Email not found. Please check your email address.";
        exit;
    }

    if ($conn->affected_rows) {
        // Sending email logic remains the same
   
        $mail->setFrom("accounts@rentlad.co.za");
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = "Password Reset";
        $mail->Body = " Click <a href='reset.php?token=$token&email=$email'>here</a> 
        to reset your password.";

        try {
            $mail->send();
            echo "<script> alert('Message sent, please check your inbox.');</script>";
        } catch (Exception $e) {
            echo "Message could not be sent.";
        }
    } else {
        echo "Error updating reset token.";
    }
}
?>
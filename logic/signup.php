<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'include/config.php';
$db = new DbConnect;
$conn = $db->connect();

include 'mailer.php';

global $emailCheck;
global $passwordCheck;
global $signupErr;
global $phoneCheck;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $name = htmlspecialchars($_POST["txtName"]);
    $surname = htmlspecialchars($_POST["txtSurname"]);
    $email = htmlspecialchars($_POST["txtEmail"]);
    $phoneNumber = htmlspecialchars($_POST["txtPhoneNumber"]);
    $password = htmlspecialchars($_POST["txtPassword"]);
    $confirmPassword = htmlspecialchars($_POST["txtConfirmPassword"]);
    $userType = $_POST["UserType"];
    $userImage = $_FILES['userImage']['name'];
    $temp_img = $_FILES['userImage']['tmp_name'];

    // Validate password match
    if ($password !== $confirmPassword) {
        $passwordCheck = "<p class='bg-danger rounded mb-3 text-center'>Passwords do not match.</p>";
        //echo "Error: Passwords do not match.";
    }

    // Hash the password before storing it in the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Check for duplicate email addresses
    $duplicateCheckStmt = $conn->prepare("SELECT 1 FROM Student WHERE stdEmail = ? UNION SELECT 1 FROM Landlord WHERE lndEmail = ?");
    $duplicateCheckStmt->bind_param("ss", $email, $email);
    $duplicateCheckStmt->execute();

    if ($duplicateCheckStmt->fetch()) {
        $emailCheck = "<p class='bg-danger rounded mb-3 text-center'>Email address is already registered.</p>";
        //echo "Error: Email address is already registered.";
    } else {
        // Check for duplicate phone numbers
        $duplicatePhoneStmt = $conn->prepare("SELECT 1 FROM Student WHERE stdPhone = ? UNION SELECT 1 FROM Landlord WHERE lndPhone = ?");
        $duplicatePhoneStmt->bind_param("ss", $phoneNumber, $phoneNumber);
        $duplicatePhoneStmt->execute();

        if ($duplicatePhoneStmt->fetch()) {
            $phoneCheck = "<p class='bg-danger rounded mb-3 text-center'>Phone number is already registered.</p>";
        }else{
        if ($userType === "Student") {
            $sql = "INSERT INTO Student (stdName, stdSurname, stdEmail, stdPhone, stdPassword, stdProfileImage) 
                    VALUES (?, ?, ?, ?, ?, ?)";
        } elseif ($userType === "Landlord") {
            $sql = "INSERT INTO Landlord (lndName, lndSurname, lndEmail, lndPhone, lndPassword, lndProfileImage) 
                    VALUES (?, ?, ?, ?, ?, ?)";
        } else {
            $signupErr = "Invalid user type.";
            //echo "Error: Invalid user type.";
        }

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            $signupErr = "Error in preparing statement: " . $conn->error;
            //echo "Error in preparing statement: " . $conn->error;
        } else {
            $stmt->bind_param("ssssss", $name, $surname, $email, $phoneNumber, $hashedPassword, $userImage);

            if (!$stmt->execute()) {
                $signupErr = "Error in executing statement: " . $stmt->error;
                //echo "Error in executing statement: " . $stmt->error;
            } else {
                $UserID = $stmt->insert_id;
                $_SESSION['userID'] = $UserID;
                $_SESSION['userName'] = $name;

                // Move the uploaded image to the destination directory
                $uploadDir = 'admin/users/images/';
                $uploadFile = $uploadDir . basename($userImage);
                if (!move_uploaded_file($temp_img, $uploadFile)) {
                    $signupErr = "Error in moving uploaded file.";
                    //echo "Error in moving uploaded file.";
                } else {
                    // Redirect based on user type
                    if ($userType === "Student") {
                        $_SESSION['userType'] = 'student';
                        header("Location: student.dashboard.php");
                        exit();
                    } elseif ($userType === "Landlord") {
                        $_SESSION['userType'] = 'landlord';
                        header("Location: landlord.dashboard.php");
                        exit();
                    } else {
                        $signupErr = "Redirect failed.";
                        //echo "Error: Redirect failed.";
                    }
                }
            }
        }
    }
}

    $duplicateCheckStmt->close();
}

$conn->close();
?>

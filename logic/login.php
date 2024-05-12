<?php
session_start();

include 'include/config.php';
$redirectURL;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    function authenticateUser($email, $password) {
        $db = new DbConnect;
        $conn = $db->connect();
    
        try {
            // Check in Landlord table
            $stmt = $conn->prepare("SELECT LandlordID, lndPassword, lndName FROM landlord WHERE lndEmail=?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($landlordID, $lndPassword, $lndName);
            $stmt->fetch();
            $stmt->close();
    
            // Check in Student table
            $stmt = $conn->prepare("SELECT StudentID, stdPassword, stdName FROM student WHERE stdEmail=?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($studentID, $stdPassword, $stdName);
            $stmt->fetch();
            $stmt->close();


            if ($landlordID && password_verify($password, $lndPassword)) {
                echo "Landlord authentication successful!";
                $_SESSION['userID'] = $landlordID;
                $_SESSION['userName'] = $lndName;
                $_SESSION['userType'] = 'landlord';
                if(isset($_SESSION['redirect_url'])){
                    $redirectURL = $_SESSION['redirect_url'];
                    unset($_SESSION['redirect_url']);
                    header("Location: $redirectURL");
                    exit();
                }
                $redirectURL = 'landlord.dashboard.php';
             
                header("Location: $redirectURL");
                exit();
                return ['userID' => $landlordID, 'userName' => $lndName, 'userType' => 'landlord'];
            }
    
            if ($studentID && password_verify($password, $stdPassword)) {
                $_SESSION['userID'] = $studentID;
                $_SESSION['userName'] = $stdName;
                $_SESSION['userType'] = 'student';
                $redirectURL = 'student.dashboard.php';
                if(isset($_SESSION['redirect_url'])){
                    $redirectURL = $_SESSION['redirect_url'];
                    unset($_SESSION['redirect_url']);
                    header("Location: $redirectURL");
                    exit();
                }
                header("Location: $redirectURL");
                exit();
                return ['userID' => $studentID, 'userName' => $stdName, 'userType' => 'student'];
            }
        } catch (\Throwable $th) {
            echo "Error occurred: " . $th->getMessage();
        } finally {
            $conn->close();
        }
    }    

    function loginUser($email, $password) {
        $userData = authenticateUser($email, $password);

        if ($userData && isset($userData['userID'])) {
            echo "Login successful!";
            $_SESSION['userID'] = $userData['userID'];
            $_SESSION['userName'] = $userData['userName'];
            $_SESSION['userType'] = $userData['userType'];

            $redirectURL = ($_SESSION['userType'] == 'student') ? 'student.dashboard.php' : 'landlord.dashboard.php';
            header("Location: $redirectURL");
            exit();
        } else {
            $strError = "Invalid credentials";
        }

        return $strError;
    }

    $strError = loginUser($_POST['txtEmail'], $_POST['txtPassword']);
}
?>
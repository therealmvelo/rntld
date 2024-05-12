<?php
session_start();
error_reporting(0);
include 'include/config.php';
include 'mailer.php';

$db = new DbConnect;
$conn = $db->connect();

$mail->setFrom('updates@rentlad.co.za');
$mail->isHTML(true);

if (!isset($_SESSION['userID'], $_SESSION['userName'], $_SESSION['userType'])) {
    // Redirect the user to the login page or any other appropriate destination
    header("Location: login.php");
    exit(); // Ensure that the script stops execution after the redirection
}

if (isset($_SESSION['userID'], $_SESSION['userName'], $_SESSION['userType'])) {
    $userName = $_SESSION['userName'];
    $userType = $_SESSION['userType'];
    $landlordID = $_SESSION['userID'];

    // Query to fetch property details for a specific landlord
    $fetchPropertiesQuery = "SELECT PropertyID, PropertyTitle, imgFrontView, Price, datePosted
    FROM property
    WHERE FK_LandlordID = ?";
    $fetchPropertiesStmt = $conn->prepare($fetchPropertiesQuery);
    $fetchPropertiesStmt->bind_param("i", $landlordID);
    $fetchPropertiesStmt->execute();
    $fetchPropertiesResult = $fetchPropertiesStmt->get_result();

    ////////////////property deletion logic//////////
    if (isset($_POST['PropertyDelete'])) {
        // Retrieve the PropertyID from the form submission
        $propertyIDToDelete = $_POST['PropertyID'];
        $deleteQuery = "DELETE FROM property WHERE PropertyID = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $propertyIDToDelete);

            // Execute the prepared statement
            if ($deleteStmt->execute()) {
                // Property deleted successfully
                echo "<script>alert('Property deleted successfully');</script>";

                // Redirect to a page after deletion (replace 'property_list.php' with your desired destination)
                header("Location: index.php");
                exit();
            } else {
                // Error handling if deletion fails
                echo "Error deleting property: ";
            }
            header("Location: landlord.dashboard.php");
            exit();
    }

        // Fetch all the tenants the landlord accepted
        $fetchTenantsQuery = "SELECT b.RequestID, b.FK_PropertyID, s.stdName, s.stdSurname, s.stdEmail, s.stdProfileImage
                            FROM booking_request b
                            INNER JOIN student s ON b.FK_StudentID = s.StudentID
                            INNER JOIN property p ON b.FK_PropertyID = p.PropertyID
                            WHERE p.FK_LandlordID = ? AND b.Status = 'accept'";
        $fetchTenantsStmt = $conn->prepare($fetchTenantsQuery);
        $fetchTenantsStmt->bind_param("i", $landlordID);
        $fetchTenantsStmt->execute();
        $fetchTenantsResult = $fetchTenantsStmt->get_result();


        // Check if the 'accept' or 'reject' button is clicked
        if (isset($_POST['action'], $_POST['requestID'])) {
            $action = $_POST['action'];
            $requestID = $_POST['requestID'];

            // Retrieve information from the booking request
            $requestInfoQuery = "SELECT br.RequestID, br.FK_StudentID, br.FK_PropertyID, s.stdName, s.stdSurname, s.stdEmail, s.stdProfileImage FROM booking_request br
                                INNER JOIN student s ON br.FK_StudentID = s.StudentID
                                INNER JOIN property p ON br.FK_PropertyID = p.PropertyID
                                WHERE br.RequestID = ? AND p.FK_LandlordID = ?";
            $requestInfoStmt = $conn->prepare($requestInfoQuery);
            $requestInfoStmt->bind_param("ii", $requestID, $landlordID);
            $requestInfoStmt->execute();
            $requestInfoResult = $requestInfoStmt->get_result();

        if ($requestInfoResult->num_rows > 0) {
            $row = $requestInfoResult->fetch_assoc();
            $studentID = $row['FK_StudentID'];
            $propertyID = $row['FK_PropertyID'];
            $studentName = $row['stdName'];
            $studentSurname = $row['stdSurname'];
            $studentEmail = $row['stdEmail'];
            $studentProfileImage = $row['stdProfileImage'];

            // Update the booking request status based on the landlord's action
            $updateStatusQuery = "UPDATE booking_request SET Status = ? WHERE RequestID = ?";
            $updateStatusStmt = $conn->prepare($updateStatusQuery);

                if ($action === 'accept') {
                    // Update status to 'Accepted'
                    $updateStatusStmt->bind_param("si", $action, $requestID);

                    //decrement number of rooms
                    $updateNumberofRoomsQuery = "UPDATE property SET NumberofRooms = NumberofRooms - 1 WHERE PropertyID = (SELECT FK_PropertyID FROM booking_request WHERE FK_StudentID = ? AND Status = 'accept')";
                    $updateRooms = $conn->prepare($updateNumberofRoomsQuery);
                    $updateNumberofRoomsStmt = $conn->prepare($updateNumberofRoomsQuery);
                    $updateNumberofRoomsStmt->bind_param("i", $studentID);

                    $mail->addAddress($studentEmail);
                    $mail->Subject = "Property Booking";
                    $mail->Body = "Congragulations! your booking request has been accepted by the landlord. simply log in to view the property details of your new home";
                    
                    // Transaction: Update status
                    $conn->begin_transaction();
                    $mail->Send();
                    try {
                        $updateStatusStmt->execute();
                        $updateNumberofRoomsStmt->execute();
                        $conn->commit();
                        $bookingRequest = "<div class='alert alert-dismissible border border-secondary col-12 text-center align-content-center ' role='alert'>
                        <p class='text-success'></i>Booking request accepted successfully!</p>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                        
                    } catch (Exception $e) {
                        $conn->rollback();
                        echo "<script>alert('unknown error occured');</script>";
                    }

            // Close the statements
            $updateStatusStmt->close();

            // Delete other pending requests for the same student across all properties of the landlord
            $deletePendingRequestsQuery = "DELETE FROM booking_request WHERE FK_StudentID = ? AND Status = 'Pending' AND RequestID != ? AND FK_PropertyID IN (SELECT PropertyID FROM property WHERE FK_LandlordID = ?)";
            $deletePendingRequestsStmt = $conn->prepare($deletePendingRequestsQuery);
            $deletePendingRequestsStmt->bind_param("iii", $studentID, $requestID, $landlordID);
            $deletePendingRequestsStmt->execute();
            $deletePendingRequestsStmt->close();

        } elseif ($action === 'reject') {
            // Update status to 'Rejected'
            $updateStatusStmt->bind_param("si", $action, $requestID);
            $updateStatusStmt->execute();

            $msgReject = "<div class='alert alert-dismissible border border-secondary col-12 text-center align-content-center ' role='alert'>
                 <p class='text-success'></i> Tenant Rejected Successfully</p>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";

            // Close the statement
            $updateStatusStmt->close();
        }
    } else {
        echo "<script>alert('Error: Unable to retrieve information for the booking request');</script>";
    }

    // Close the statement
    $requestInfoStmt->close();
}

    // Fetch and display pending booking requests for the landlord's properties
    $fetchRequestsQuery = "SELECT br.RequestID, br.FK_StudentID, br.FK_PropertyID, s.stdName, s.stdSurname, s.stdEmail, s.stdProfileImage FROM booking_request br
                        INNER JOIN student s ON br.FK_StudentID = s.StudentID
                        INNER JOIN property p ON br.FK_PropertyID = p.PropertyID
                        WHERE br.Status = 'Pending' AND p.FK_LandlordID = ?";
    $fetchRequestsStmt = $conn->prepare($fetchRequestsQuery);
    $fetchRequestsStmt->bind_param("i", $landlordID);
    $fetchRequestsStmt->execute();
    $fetchRequestsResult = $fetchRequestsStmt->get_result();

    // Check if the form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tenant']) && $_POST['tenant'] === 'removeTenant') {
        // Retrieve RequestID from the form submission
        $RequestID = $_POST['RequestID'];

        // Use the RequestID to fetch the associated propertyID and studentID
        $getRequestPropertyIDQuery = "SELECT br.FK_PropertyID, br.FK_StudentID, s.stdEmail
        FROM booking_request br
        JOIN student s ON br.FK_StudentID = s.StudentID
        WHERE br.RequestID = ?";
        $getRequestPropertyIDStmt = $conn->prepare($getRequestPropertyIDQuery);
        $getRequestPropertyIDStmt->bind_param("i", $RequestID);
        $getRequestPropertyIDStmt->execute();

        $getRequestPropertyIDResult = $getRequestPropertyIDStmt->get_result();

            if ($getRequestPropertyIDResult->num_rows > 0) {
                $row = $getRequestPropertyIDResult->fetch_assoc();
                $propertyID = $row['FK_PropertyID'];
                $studentID = $row['FK_StudentID'];
                $studentEmail = $row['stdEmail'];

                // Increment the number of rooms for the property
                $updateNumberofRoomsQuery = "UPDATE property SET NumberofRooms = NumberofRooms + 1 WHERE PropertyID = ?";
                $updateRooms = $conn->prepare($updateNumberofRoomsQuery);
                $updateRooms->bind_param("i", $propertyID);
                $updateRooms->execute();
                $updateRooms->close();

                // Remove the tenant from the booking_request table
                $removeTenantQuery = "DELETE FROM booking_request WHERE RequestID = ?";
                $removeTenantStmt = $conn->prepare($removeTenantQuery);
                $removeTenantStmt->bind_param("i", $RequestID);
                $removeTenantStmt->execute();

                $mail->addAddress($studentEmail);
                $mail->Subject = "Property Booking Update";
                $mail->Body = "We regret to inform you that you have been removed from your rental property by your landlord";

                $mail->send();
                $removeTenantStmt->close();

                // Additional logic if needed, such as updating the property status, etc.
                $msgRemoval = "<div class='alert alert-dismissible border border-secondary col-12 text-center align-content-center ' role='alert'>
                <p class='text-success'></i> Tenant Removed Successfully</p>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
            } else {
                // Handle the case where RequestID is not found
                echo "<script>alert('Error: RequestID not found');</script>";
            }

        $getRequestPropertyIDStmt->close();
}

    /////////////////////////////////end

    // Close the statement
    $fetchRequestsStmt->close();

    // End of the script

    //end
    //analytics
    ///////////////////////////////////////////////////////////////////////////////////

    // Fetch all properties from the database
    $sql = "SELECT * FROM property WHERE FK_LandlordID = $landlordID";
    $result = $conn->query($sql);

    // Create arrays to store data for the chart
    $propertyData = array();
    $averagePriceData = array();
    $suggestedPriceData = array();

        // Process the fetched data
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Store data in arrays
                $propertyData[] = $row['PropertyTitle'];
                $averagePriceData[] = array($row['NumberofRooms'], $row['Price']);
                
                // Suggested price logic (customize as needed)
                $suggestedPrice =  ($row['Price']  + 1) + $row['NumberofRooms'] * 1.5;#$row['ViewCount'] 
                $suggestedPriceData[] = array($row['NumberofRooms'], $suggestedPrice);
            }
        }

    ///////property deletion


    // Close the result set
    $result->close();
    // Close the database connection
    $conn->close();
}

?>

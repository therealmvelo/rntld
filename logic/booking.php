<?php
session_start();

include 'include/config.php';

$db = new DbConnect;
$conn = $db->connect();

global $bookingSent;
$landlordID;
// Check if a student or landlord is logged in
if (isset($_SESSION['userID'], $_SESSION['userName'], $_SESSION['userType'])) {
    $userID = $_SESSION['userID'];
    $userName = $_SESSION['userName'];
    $userType = $_SESSION['userType'];

    if (isset($_GET['PropertyID'])) {
        $propertyID = $_GET['PropertyID'];

//update viewcount of a property everytime it's viewd -- [and when a page is refreshed]
        $updateViewCountQuery = "UPDATE property SET ViewCount = ViewCount + 1 WHERE PropertyID = ?";
        $updateViewCountStmt = $conn->prepare($updateViewCountQuery);
        $updateViewCountStmt->bind_param("i", $propertyID);
        $updateViewCountStmt->execute();
        $updateViewCountStmt->close();
        }
    } else {
// Redirect users who are not logged in to the login page
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

    header("Location: login.php");
    exit(); // Ensure that script execution stops after redirection
}
//ALL RELEVANT DETAILS//NOT DONE//----------------------------------------------//
$propertyQuery = "SELECT *
FROM Property
JOIN Landlord ON Property.FK_LandlordID = Landlord.LandlordID
LEFT JOIN Amenities ON Property.PropertyID = Amenities.FK_PropertyID
LEFT JOIN campuses ON Property.FK_CampusID = campuses.CampusID
WHERE Property.PropertyID = $propertyID";

        #$stmt = $conn->prepare($propertyQuery);
        #$stmt->bind_param('i', $propertyID);
        #$stmt->execute();
        #$result = $stmt->get_result();
    
        #$propertyDetails = $result->fetch_assoc();
    
$propertyResults = mysqli_query($conn,$propertyQuery);
    if($propertyResults){
        while($propertyDetails = mysqli_fetch_assoc($propertyResults)){
            //landlord details
            $landlordID = $propertyDetails['LandlordID'];
            $landlordName = $propertyDetails['lndName'];
            $landlordSurname = $propertyDetails['lndSurname'];
            $landlordNumber = $propertyDetails['lndPhone'];
            $landlordEmail = $propertyDetails['lndEmail'];
            $landlordProfileImg = $propertyDetails['lndProfileImage'];

            $Suburb = $propertyDetails['Suburb'];
            $Title = $propertyDetails['PropertyTitle'];
            $Street = $propertyDetails['Street'];
            $Price = $propertyDetails['Price'];
            
            //$PropertyID = $propertyDetails['PropertyID'];
            $Description = $propertyDetails['PropertyDescription'];
            $Rules = $propertyDetails['PropertyRules'];
            $imgFront = $propertyDetails['imgFrontView'];
            $imgSide = $propertyDetails['imgSideView'];
            $imgInside1 = $propertyDetails['imgInside1'];
            $imgInside2 = $propertyDetails['imgInside2'];
            $imgFence = $propertyDetails['imgFence'];
            $imgAdditional = $propertyDetails['imgAdditional'];

            $NumberOfRooms = $propertyDetails['NumberofRooms'];
            $latitude = $propertyDetails['Latitude'];
            $longitude = $propertyDetails['Longitude'];

            $clatitude = $propertyDetails['CLatitude'];
            $clongitude = $propertyDetails['CLongitude'];
            $cimage = $propertyDetails['CampusImage'];
            $cname = $propertyDetails['CampusName'];

            $amenities = '';
            if ($propertyDetails['WiFi']) {
                $amenities .= '<li class="fas fa-wifi rounded border border-dark p-1 text-decoration-none m-1"> wifi</li> ';
            }
            if ($propertyDetails['Bed']) {
                $amenities .= '<li class="fas fa-bed rounded border border-dark p-1 text-decoration-none m-1"> bed</li>';
            }
            if ($propertyDetails['TV']) {
                $amenities .= '<li class="fas fa-tv rounded border border-dark p-1 text-decoration-none m-1"> television</li>';
            }
            if ($propertyDetails['Electricity']) {
                $amenities .= '<li class="fas fa-plug rounded  border border-dark p-1 text-decoration-none m-1"> electricity</li>';
            }

          }
    }

// below is the logic that deals with property booking
if (isset($_SESSION['userID'], $_SESSION['userName'], $_SESSION['userType'])) {
    $userID = $_SESSION['userID'];
    $userName = $_SESSION['userName'];
    $userType = $_SESSION['userType'];

    if (isset($_POST['submit'])) {
       /* y $propertyID = our propertyID */
        $checkInDate = $_POST['checkInDate'];
        $checkOutDate = $_POST['checkOutDate'];
        // Check if the user has already booked the same property
        $checkBookingQuery = "SELECT * FROM booking_request WHERE FK_StudentID = ? AND FK_PropertyID = ? AND Status = ?";
        $status = "Pending";
        $checkBookingStmt = $conn->prepare($checkBookingQuery);
        $checkBookingStmt->bind_param("iis", $userID, $propertyID,$status);
        $checkBookingStmt->execute();
        $result = $checkBookingStmt->get_result();

        if ($result->num_rows > 0) {
            $bookingSent = "<div class='alert alert-dismissible border border-danger col-12' role='alert'>
                      booking request already sent
                      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        } else {
            // Proceed with the booking
            $insertBookingQuery = "INSERT INTO booking_request (FK_StudentID, FK_PropertyID,checkInDate,checkOutDate) VALUES (?, ?, ?, ?)";
            $insertBookingStmt = $conn->prepare($insertBookingQuery);
            $insertBookingStmt->bind_param("iiss", $userID, $propertyID,$checkInDate,$checkOutDate);
            $insertBookingResult = $insertBookingStmt->execute();

            if ($insertBookingResult) {
              $bookingSent = "<div class='alert alert-dismissible border border-success text-success' role='alert'>
                                  Booking request sent successfully
                                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                              </div> ";                           
                      } else {
                           echo "an Error occured while sending request: " . $insertBookingStmt->error;
                        }
            // Close the statements
            $insertBookingStmt->close();
            $checkBookingStmt->close();
        }
    }
}
//basic landlord details card
$propertyCountQuery = "SELECT COUNT(*) AS propertyCount
                        FROM Property
                        WHERE FK_LandlordID = $landlordID";
$landlordCard = $conn->query($propertyCountQuery);
$getDetails = $landlordCard->fetch_assoc();
?>
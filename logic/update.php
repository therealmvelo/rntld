<?php
error_reporting(0);
// Check if propertyID is set in the URL
if (isset($_REQUEST['PropertyID'])) {
    // Get the propertyID from the URL
    $propertyID = $_GET['PropertyID'];

    // Query to fetch details for a specific property
    $fetchPropertyDetailsQuery = "
        SELECT p.*, c.CityName
        FROM property p
        JOIN city c ON p.FK_CityID = c.CityID
        WHERE p.PropertyID = ?
    ";
    $fetchPropertyDetailsStmt = $conn->prepare($fetchPropertyDetailsQuery);
    $fetchPropertyDetailsStmt->bind_param("i", $propertyID);
    $fetchPropertyDetailsStmt->execute();
    $fetchPropertyDetailsResult = $fetchPropertyDetailsStmt->get_result();

    // Check if the property is found
    if ($fetchPropertyDetailsResult->num_rows > 0) {
        $propertyDetails = $fetchPropertyDetailsResult->fetch_assoc();
        $PropertyID = $propertyDetails['PropertyID'];
        $propertyTitle = $propertyDetails['PropertyTitle'];
        $PropertyDescription = $propertyDetails['PropertyDescription'];
        $PropertyRules = $propertyDetails['PropertyRules'];
        $NumberOfRooms = $propertyDetails['NumberofRooms'];
        $Price = $propertyDetails['Price'];
        $Suburb = $propertyDetails['Suburb'];
        $Street = $propertyDetails['Street'];
        $HouseNumber = $propertyDetails['HouseNumber'];
        $NearestCampus = $propertyDetails['NearestCampus'];

        $imgFrontView = $propertyDetails['imgFrontView'];
        $imgSideView = $propertyDetails['imgSideView'];
        $imgInside1 = $propertyDetails['imgInside1'];
        $imgInside2 = $propertyDetails['imgInside2'];
        $imgFence = $propertyDetails['imgFence'];
        $imgAddtional = $propertyDetails['imgAdditional'];

        $CityName = $propertyDetails['CityName'];
    } else {
        echo "<script>alert('Property not found');</script>";
        header("Location: landloard.dashboard.php");
        exit();

    }

    // Close the statement
    $fetchPropertyDetailsStmt->close();
} else {
    echo "<script>alert('Property ID not provided in the URL.');</script>";
}

// Handle property update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['propertyupdate'])) {
    $propertyTitle = filter_input(INPUT_POST, "txtTitle", FILTER_SANITIZE_STRING);
    $propertyDescription = filter_input(INPUT_POST, "txtDescription", FILTER_SANITIZE_STRING);
    $propertyRules = filter_input(INPUT_POST, "txtRules", FILTER_SANITIZE_STRING);
    $numberOfRooms = filter_input(INPUT_POST, "txtNumberofRooms", FILTER_SANITIZE_NUMBER_INT);
    $price = filter_input(INPUT_POST, "txtPrice", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $Suburb = filter_input(INPUT_POST, "txtSuburb", FILTER_SANITIZE_STRING);
    $street = filter_input(INPUT_POST, "txtStreetName", FILTER_SANITIZE_STRING);
    $houseNumber = filter_input(INPUT_POST, "txtHouseNumber", FILTER_SANITIZE_STRING);
    $nearestCampus = filter_input(INPUT_POST, "txtNearestCampus", FILTER_SANITIZE_STRING);
    
    $chkWiFi = isset($_POST["chkWiFi"]) ? 1 : 0;
    $chkBed = isset($_POST["chkBed"]) ? 1 : 0;
    $chkTV = isset($_POST["chkTV"]) ? 1 : 0;
    $chkElectricity = isset($_POST["chkElectricity"]) ? 1 : 0;

    $imgFront = filter_var($_FILES["imgFrontView"]['name'], FILTER_SANITIZE_STRING);
    $imgSide = filter_var($_FILES["imgSideView"]['name'], FILTER_SANITIZE_STRING);
    $imgInside1 = filter_var($_FILES["imgInside1"]['name'], FILTER_SANITIZE_STRING);
    $imgInside2 = filter_var($_FILES["imgInside2"]['name'], FILTER_SANITIZE_STRING);
    $imgFence = filter_var($_FILES["imgFence"]['name'], FILTER_SANITIZE_STRING);
    $imgAdditional = filter_var($_FILES["imgAdditional"]['name'], FILTER_SANITIZE_STRING);

    // Use the details to update the property in the database
    $updatePropertyQuery = "
    UPDATE property p
    JOIN city c ON p.FK_CityID = c.CityID
    JOIN suburb s ON p.
    SET
    p.PropertyTitle = ?,
    p.PropertyDescription = ?,
    p.PropertyRules = ?,
    p.NumberofRooms = ?,
    p.Price = ?,
    p.Suburb = ?,
    p.Street = ?,
    p.HouseNumber = ?,
    p.NearestCampus = ?,
    p.imgFrontView = ?,
    p.imgSideView = ?,
    p.imgInside1 = ?,
    p.imgInside2 = ?,
    p.imgFence = ?,
    p.imgAdditional = ?,
    p.datePosted = NOW(),
    c.CityName = ?
    WHERE p.PropertyID = ?
";

    $updatePropertyStmt = $conn->prepare($updatePropertyQuery);
    $updatePropertyStmt->bind_param(
        "sssiisssssssssssi",
        $propertyTitle,
        $PropertyDescription,
        $PropertyRules,
        $NumberOfRooms,
        $Price,
        $Suburb,
        $Street,
        $HouseNumber,
        $NearestCampus,
        $imgFront,
        $imgSide,
        $imgInside1,
        $imgInside2,
        $imgFence,
        $imgAdditional,
        $cityName,
        $PropertyID
    );

    if (!isValidImageExtension($imgFront) || !isValidImageExtension($imgSide) ||
    !isValidImageExtension($imgInside1) || !isValidImageExtension($imgInside2) ||
    !isValidImageExtension($imgFence) || !isValidImageExtension($imgAdditional)) {
    die("<script>alert('Error: Invalid file type. Only JPEG and PNG files are allowed.');</script>");
    }

    $cityName = $_POST["txtCity"];
    $suburbName = $_POST["txtSuburb"];

    // Check if the city exists, insert if not
    $cityID = getCityID($conn, $cityName);

    // Check if the suburb exists in the specified city, insert if not
    $suburbID = getSuburbID($conn, $suburbName, $cityID);


    
    echo "<div class='alert alert-dismissible  text-success  border border-success' role='alert'>
    Property details updated successfully!</div>";
    $updatePropertyStmt->execute();
    header("Location: landlord.dashboard.php");
    
    $updatePropertyStmt->close();

    // Update amenities information using prepared statement
    $chkWiFi = isset($_POST["chkWiFi"]) ? 1 : 0;
    $chkBed = isset($_POST["chkBed"]) ? 1 : 0;
    $chkTV = isset($_POST["chkTV"]) ? 1 : 0;
    $chkElectricity = isset($_POST["chkElectricity"]) ? 1 : 0;

    $updateAmenitiesQuery = "UPDATE amenities SET 
                             WiFi = ?, 
                             Bed = ?, 
                             TV = ?, 
                             Electricity = ? 
                             WHERE FK_PropertyID = ?";

    $updateAmenitiesStmt = mysqli_prepare($conn, $updateAmenitiesQuery);
    mysqli_stmt_bind_param($updateAmenitiesStmt, "iiiii", $chkWiFi, $chkBed, $chkTV, $chkElectricity, $propertyID);
    mysqli_stmt_execute($updateAmenitiesStmt);

    if (!$updateAmenitiesStmt) {
        die("<script>alert('Error updating amenities');</script>");
    }
}
//extension validation for images
    function isValidImageExtension($filename) {
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return in_array($extension, $allowedExtensions);
    }
// Helper function to get CityID
function getCityID($conn, $cityName)
{
    // Use prepared statements
    $sqlCityCheck = "SELECT CityID FROM city WHERE CityName = ?";
    $stmtCityCheck = mysqli_prepare($conn, $sqlCityCheck);
    mysqli_stmt_bind_param($stmtCityCheck, "s", $cityName);
    mysqli_stmt_execute($stmtCityCheck);

    $resultCityCheck = mysqli_stmt_get_result($stmtCityCheck);

    if (!$resultCityCheck) {
        // Handle the error (e.g., throw an exception or log it)
        // ...
    }

    if (mysqli_num_rows($resultCityCheck) == 0) {
        // City does not exist, insert a new city
        $sqlInsertCity = "INSERT INTO city (CityName) VALUES (?)";
        $stmtInsertCity = mysqli_prepare($conn, $sqlInsertCity);
        mysqli_stmt_bind_param($stmtInsertCity, "s", $cityName);
        mysqli_stmt_execute($stmtInsertCity);

        if (!$stmtInsertCity) {
            // Handle the error (e.g., throw an exception or log it)
            // ...
        }

        // Retrieve the newly inserted city's ID
        $cityID = mysqli_insert_id($conn);
    } else {
        // City already exists, fetch its ID
        $rowCity = mysqli_fetch_assoc($resultCityCheck);
        $cityID = $rowCity['CityID'];
    }

    // Close the statements
    mysqli_stmt_close($stmtCityCheck);
    if (isset($stmtInsertCity)) {
        mysqli_stmt_close($stmtInsertCity);
    }

    return $cityID;
}


// Helper function to get SuburbID
function getSuburbID($conn, $suburbName, $cityID)
{
    $sqlSuburbCheck = "SELECT SuburbID FROM suburb WHERE SuburbName = '$suburbName' AND CityID = $cityID";
    $resultSuburbCheck = mysqli_query($conn, $sqlSuburbCheck);

    if (!$resultSuburbCheck) {
        die("<script>alert('Error checking suburb');</script>");
    }

    if (mysqli_num_rows($resultSuburbCheck) == 0) {
        // Suburb does not exist in the specified city, insert a new suburb
        $sqlInsertSuburb = "INSERT INTO suburb (SuburbName, CityID) VALUES ('$suburbName', $cityID)";
        $resultInsertSuburb = mysqli_query($conn, $sqlInsertSuburb);

        if (!$resultInsertSuburb) {
            die("<script>alert('Error inserting suburb');</script>");
        }

        // Get the SuburbID (existing or newly inserted)
        $rowSuburb = mysqli_fetch_assoc($resultSuburbCheck);
        return $rowSuburb['SuburbID'];
    } else {
        // Suburb exists, fetch its ID
        $rowSuburb = mysqli_fetch_assoc($resultSuburbCheck);
        return $rowSuburb['SuburbID'];
    }
}
?>
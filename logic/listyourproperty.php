<?php
session_start();

// Connect to the database
include 'include/config.php';
$db = new DbConnect;
$conn = $db->connect();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['userID']) && isset($_SESSION['userName'])) {
    $userID = $_SESSION['userID'];
    $Username = $_SESSION['userName'];

    } else {
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        header("Location: login.php");
        exit(); // Ensure script stops execution after redirect
    }

/*function resizeImage($imagePath, $width = 200, $height = 200) {
    // Load the image
    $imageData = file_get_contents($imagePath);

    // Determine the image type
    $imageType = exif_imagetype($imagePath);
    $allowedTypes = [IMAGETYPE_JPEG, IMAGETYPE_PNG];

    if (!in_array($imageType, $allowedTypes)) {
        // Unsupported image type
        return 'URL_TO_DEFAULT_IMAGE';
    }

    $originalImage = imagecreatefromstring($imageData);

    // Create a new image with the desired dimensions
    $resizedImage = imagecreatetruecolor($width, $height);

    // Resize the image
    imagecopyresampled($resizedImage, $originalImage, 0, 0, 0, 0, $width, $height, imagesx($originalImage), imagesy($originalImage));

    // Output the resized image
    ob_start();

    // Output the image based on its type
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            imagejpeg($resizedImage, null, 100);
            break;
        case IMAGETYPE_PNG:
            imagepng($resizedImage, null, 9); // Change compression level as needed
            break;
        default:
            imagedestroy($originalImage);
            imagedestroy($resizedImage);
            return 'URL_TO_DEFAULT_IMAGE';
    }

    $resizedImageData = ob_get_clean();

    // Clean up resources
    imagedestroy($originalImage);
    imagedestroy($resizedImage);

    // Determine the image MIME type
    $mimeType = image_type_to_mime_type($imageType);

    // Return the resized image data with appropriate data URI
    return 'data:' . $mimeType . ';base64,' . base64_encode($resizedImageData);
   
}
 */

if (isset($_POST['propertysubmit']))  {
    // Sanitize form data
    $propertyTitle = htmlspecialchars($_POST["txtTitle"]);
    $propertyDescription = htmlspecialchars($_POST["txtDescription"]);
    $propertyRules = htmlspecialchars($_POST["txtRules"]);
    $numberOfRooms = intval($_POST["txtNumberofRooms"]); // Assuming it's an integer
    $price = floatval($_POST["txtPrice"]); // Assuming it's a float
    $street = htmlspecialchars($_POST["txtStreetName"]);
    $houseNumber = htmlspecialchars($_POST["txtHouseNumber"]);
    $nearestCampus = htmlspecialchars($_POST["txtNearestCampus"]);
    $chkWiFi = isset($_POST["chkWiFi"]) ? 1 : 0;
    $chkBed = isset($_POST["chkBed"]) ? 1 : 0;
    $chkTV = isset($_POST["chkTV"]) ? 1 : 0;
    $chkElectricity = isset($_POST["chkElectricity"]) ? 1 : 0;

    // Sanitize latitude and longitude values
    $Latitude = $_POST['latitude'];
    $Longitude = $_POST['longitude'];

     // Retrieve campus ID directly since all campuses are prepopulated
     $campusID = getCampusID($conn, $nearestCampus);

    // Extension validation for images
    function isValidImageExtension($filename) {
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return in_array($extension, $allowedExtensions);
    }

    $imgFront = htmlspecialchars($_FILES["imgFrontView"]['name']);
    $imgSide = htmlspecialchars($_FILES["imgSideView"]['name']);
    $imgInside1 = htmlspecialchars($_FILES["imgInside1"]['name']);
    $imgInside2 = htmlspecialchars($_FILES["imgInside2"]['name']);
    $imgFence = htmlspecialchars($_FILES["imgFence"]['name']);
    $imgAdditional = htmlspecialchars($_FILES["imgAdditional"]['name']);

    $temp_img1 = $_FILES['imgFrontView']['tmp_name'];
    $temp_img2 = $_FILES['imgSideView']['tmp_name'];
    $temp_img3 = $_FILES['imgInside1']['tmp_name'];
    $temp_img4 = $_FILES['imgInside2']['tmp_name'];
    $temp_img5 = $_FILES['imgFence']['tmp_name'];
    $temp_img6 = $_FILES['imgAdditional']['tmp_name'];

    // Resize and move the uploaded images
    $targetDir = "admin/property/images/";

    // Move the uploaded images without resizing
    $uniqueNameFront = generateUniqueName($imgFront);
    $uniqueNameSide = generateUniqueName($imgSide);
    $uniqueNameInside1 = generateUniqueName($imgInside1);
    $uniqueNameInside2 = generateUniqueName($imgInside2);
    $uniqueNameFence = generateUniqueName($imgFence);
    $uniqueNameAdditional = generateUniqueName($imgAdditional);

    // Check file types
    if (!isValidImageExtension($imgFront) || !isValidImageExtension($imgSide) ||
    !isValidImageExtension($imgInside1) || !isValidImageExtension($imgInside2) ||
    !isValidImageExtension($imgFence) || !isValidImageExtension($imgAdditional)) {
    die("<script>alert('Error: Invalid file type. Only JPEG and PNG files are allowed');</script>");
    }

    // Move the uploaded images with unique names
    move_uploaded_file($temp_img1, $targetDir . $imgFront);
    move_uploaded_file($temp_img2, $targetDir . $imgSide);
    move_uploaded_file($temp_img3, $targetDir .$imgInside1);
    move_uploaded_file($temp_img4, $targetDir . $imgInside2);
    move_uploaded_file($temp_img5, $targetDir . $imgFence);
    move_uploaded_file($temp_img6, $targetDir . $imgAdditional);


    $cityName = htmlspecialchars($_POST["txtCity"]);
    $suburbName = htmlspecialchars($_POST["txtSuburb"]);

    // Check if the city exists, insert if not
    $cityID = getCityID($conn, $cityName);

    // Check if the suburb exists in the specified city, insert if not
    $suburbID = getSuburbID($conn, $suburbName, $cityID);

     // Prepare the property query
     $propertyQuery = "INSERT INTO property (FK_LandlordID, FK_CityID, PropertyTitle, PropertyDescription, PropertyRules, NumberofRooms, Price, Suburb, Street, HouseNumber, NearestCampus, imgFrontView, imgSideView, imgInside1, imgInside2, imgFence, imgAdditional, Latitude, Longitude, FK_CampusID)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $propertyStmt = mysqli_prepare($conn, $propertyQuery);

    // Bind parameters
    mysqli_stmt_bind_param($propertyStmt, "iissssidsssssssssddi", $userID, $cityID, $propertyTitle, $propertyDescription, $propertyRules, $numberOfRooms, $price, $suburbID, $street, $houseNumber, $nearestCampus, $imgFront, $imgSide, $imgInside1, $imgInside2, $imgFence, $imgAdditional, $Latitude, $Longitude, $campusID);


    // Execute the statement
    $resultPropertyStmt = mysqli_stmt_execute($propertyStmt);

    if (!$resultPropertyStmt) {
        die("<script>alert('Error inserting property');</script>");
        echo $cityID;
    }

    $propertyID = mysqli_insert_id($conn);

    // Prepare the amenities query
    $sqlInsertAmenities = "INSERT INTO amenities (FK_PropertyID, WiFi, Bed, TV, Electricity) VALUES (?, ?, ?, ?, ?)";
    $amenitiesStmt = mysqli_prepare($conn, $sqlInsertAmenities);

    // Bind parameters
    mysqli_stmt_bind_param($amenitiesStmt, "iiiii", $propertyID, $chkWiFi, $chkBed, $chkTV, $chkElectricity);

    // Execute the statement
    $resultAmenitiesStmt = mysqli_stmt_execute($amenitiesStmt);

    if (!$resultAmenitiesStmt) {
        die("<script>alert('Error inserting amenities);</script>");
    }

    #header("Location: landlord.dashboard.php");
   # exit();
}

mysqli_close($conn);

function getCampusID($conn, $nearestCampus) {
    $sql = "SELECT CampusID FROM campuses WHERE CampusName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nearestCampus);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $campusID = $row['CampusID'];        
        return $row['CampusID'];
    } else {
        // If the campus name is not found, handle the error accordingly
        die("<script>alert('Error: Campus name not found in the database');</script>");
    }
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
        echo "<script>alert('error retrieving city');</script>";
    }

    if (mysqli_num_rows($resultCityCheck) == 0) {
        // City does not exist, insert a new city
        $sqlInsertCity = "INSERT INTO city (CityName) VALUES (?)";
        $stmtInsertCity = mysqli_prepare($conn, $sqlInsertCity);
        mysqli_stmt_bind_param($stmtInsertCity, "s", $cityName);
        mysqli_stmt_execute($stmtInsertCity);

        if (!$stmtInsertCity) {
            echo "<script>alert('error inserting city');</script>";
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
    // Prepare the suburb check query
    $sqlSuburbCheck = "SELECT SuburbID FROM suburb WHERE SuburbName = ? AND CityID = ?";
    $stmtSuburbCheck = mysqli_prepare($conn, $sqlSuburbCheck);

    // Bind parameters
    mysqli_stmt_bind_param($stmtSuburbCheck, "si", $suburbName, $cityID);

    // Execute the statement
    $resultSuburbCheck = mysqli_stmt_execute($stmtSuburbCheck);

    if (!$resultSuburbCheck) {
        die("<script>alert('Error checking suburb, enter a valid suburb');</script>");
    }

    // Get the SuburbID (existing or newly inserted)
    $resultSuburbCheck = mysqli_stmt_get_result($stmtSuburbCheck);

    if (mysqli_num_rows($resultSuburbCheck) == 0) {
        // Suburb does not exist in the specified city, insert a new suburb
        // Prepare the insert suburb query
        $sqlInsertSuburb = "INSERT INTO suburb (SuburbName, CityID) VALUES (?, ?)";
        $stmtInsertSuburb = mysqli_prepare($conn, $sqlInsertSuburb);

        // Bind parameters
        mysqli_stmt_bind_param($stmtInsertSuburb, "si", $suburbName, $cityID);

        // Execute the statement
        $resultInsertSuburb = mysqli_stmt_execute($stmtInsertSuburb);

        if (!$resultInsertSuburb) {
            die("<script>alert('Error inserting suburb, please retry');</script>");
        }

        // Get the SuburbID (existing or newly inserted)
        return mysqli_insert_id($conn);
    } else {
        // Suburb exists, fetch its ID
        $rowSuburb = mysqli_fetch_assoc($resultSuburbCheck);
        return $rowSuburb['SuburbID'];
    }
}

function generateUniqueName($originalName)
{
    $extension = pathinfo($originalName, PATHINFO_EXTENSION);
    $uniqueName = time() . '_' . uniqid('', true) . '.' . $extension;
    return $uniqueName;
}

?>

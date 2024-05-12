<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Roomlinkcopy";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $propertyTitle = $_POST["propertyTitle"];
    $propertyDescription = $_POST["propertyDescription"];
    $propertyRules = $_POST["propertyRules"];
    $numberOfRooms = $_POST["numberOfRooms"];
    $price = $_POST["price"];
    $cityName = $_POST["city"];
    $suburbName = $_POST["suburb"];
    $street = $_POST["street"];
    $houseNumber = $_POST["houseNumber"];
    $nearestCampus = $_POST["nearestCampus"];
    $isFeatured = isset($_POST["isFeatured"]) ? 'Yes' : 'No';

    // Insert data into City table
    $sqlCity = "INSERT INTO City (CityName, Country) VALUES (?, ?)";
    $stmtCity = $conn->prepare($sqlCity);
    $stmtCity->bind_param("ss", $cityName, $country); // Assuming you have a way to determine the country
    $stmtCity->execute();
    $cityID = $conn->insert_id;

    // Insert data into Suburb table
    $sqlSuburb = "INSERT INTO Property (Suburb, CityID) VALUES (?, ?)";
    $stmtSuburb = $conn->prepare($sqlSuburb);
    $stmtSuburb->bind_param("si", $suburbName, $cityID);
    $stmtSuburb->execute();
    $suburbID = $conn->insert_id;

    // Prepare and execute SQL query to insert into Property table
    $sqlProperty = "INSERT INTO Property (PropertyTitle, PropertyDescription, PropertyRules, NumberofRooms, Price, Suburb, Street, HouseNumber, NearestCampus, isFeatured, CityID)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtProperty = $conn->prepare($sqlProperty);
    $stmtProperty->bind_param("sssiisssiss", $propertyTitle, $propertyDescription, $propertyRules, $numberOfRooms, $price, $suburbName, $street, $houseNumber, $nearestCampus, $isFeatured, $cityID);
    
    if ($stmtProperty->execute()) {
        // Retrieve the last inserted PropertyID
        $propertyID = $conn->insert_id;

        // Insert Amenities (assuming you have a way to determine selected amenities)
        $amenities = $_POST["amenities"]; // Replace with actual input name
        if (!empty($amenities)) {
            foreach ($amenities as $amenity) {
                $sqlAmenities = "INSERT INTO Amenities (PropertyID, Amenity) VALUES (?, ?)";
                $stmtAmenities = $conn->prepare($sqlAmenities);
                $stmtAmenities->bind_param("is", $propertyID, $amenity);
                $stmtAmenities->execute();
                $stmtAmenities->close();
            }
        }

        echo "Property added successfully!";
    } else {
        echo "Error: " . $stmtProperty->error;
    }

    // Close statements and connection
    $stmtCity->close();
    $stmtSuburb->close();
    $stmtProperty->close();
    $conn->close();
}
?>

<?php
// Check if the CityID is set in the URL
if (isset($_GET['cid']) && isset($_GET['name'])){
    $cityID = $_GET['cid'];
    $cityName = $_GET['name'];
    // Set the number of properties to display per page
    $propertiesPerPage = 9; // Adjust this value as needed

    // Calculate the current page number
    $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    // Calculate the offset for the query
    $offset = ($current_page - 1) * $propertiesPerPage;

    // Fetch data based on the selected CityID
    $query = "SELECT
    Property.PropertyID,
    Property.PropertyTitle,
    Property.PropertyDescription,
    Property.PropertyRules,
    Property.NumberofRooms,
    Property.Price,
    Property.Street,
    Property.HouseNumber,
    Property.NearestCampus,
    Property.imgFrontView,
    Property.imgSideView,
    Property.imgInside1,
    Property.imgInside2,
    Property.imgFence,
    Property.imgAdditional,
    Amenities.WiFi,
    Amenities.Bed,
    Amenities.TV,
    Amenities.Electricity,
    City.CityName,
    Landlord.lndName,
    Landlord.isVerified,
    Landlord.lndProfileImage,
    Landlord.LandlordID,
    City.CityName
  FROM
    Property
  JOIN
    City ON Property.FK_CityID = City.CityID
  JOIN
    Landlord ON Property.FK_LandlordID = Landlord.LandlordID
  LEFT JOIN
    Amenities ON Property.PropertyID = Amenities.FK_PropertyID
  WHERE
    City.CityID = ?
  GROUP BY
    Property.PropertyID
  LIMIT ?, ?";
  
    $stmt = $conn->prepare($query);
  
    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
        exit;
      }
    $sqlcity = "select CityName from City where CityID = ?";
  
// Bind parameters and execute the query
$stmt->bind_param("iii", $cityID, $offset, $propertiesPerPage);
$stmt->execute();
$result = $stmt->get_result();
    
    #while ($ow = $result->fetch_assoc()) {
      #$cityName = $ow['CityName'];
    #}
  }

?>
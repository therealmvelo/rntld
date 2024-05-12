<?php
// Define pagination parameters
$resultsPerPage = 10; // Number of results per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page, default to 1 if not set
$offset = ($page - 1) * $resultsPerPage; // Calculate offset

// Sanitize search term
$searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Modify the query to include pagination and search term
$propertiesQuery = "SELECT
    p.PropertyID,
    p.PropertyTitle,
    p.PropertyDescription,
    p.PropertyRules,
    p.Suburb,
    p.Price,
    p.imgFrontView AS imgFront,
    p.imgInside1 AS imgInside1,
    p.imgInside2 AS imgInside2,
    p.imgSideView As imgSide,
    p.imgFence As imgFence,
    p.imgAdditional As imgAdditional,
    l.LandlordID,
    l.lndName AS LandlordName,
    l.lndSurname AS LandlordSurname,
    l.lndEmail AS LandlordEmail,
    l.lndPhone AS LandlordPhone,
    l.isVerified AS isVerified,
    l.lndProfileImage AS imgProfile,
    c.CityID,
    a.WiFi,
    a.Bed,
    a.TV,
    a.Electricity
FROM
    property p
JOIN
    landlord l ON p.FK_LandlordID = l.LandlordID
JOIN
    city c ON p.FK_CityID = c.CityID
LEFT JOIN
    amenities a ON p.PropertyID = a.FK_PropertyID
WHERE
    p.Suburb LIKE '%$searchTerm%'
    OR c.CityName LIKE '%$searchTerm%'
    OR p.Street LIKE '%$searchTerm%'
    OR p.PropertyTitle LIKE '%$searchTerm%'
LIMIT $offset, $resultsPerPage";

// Execute the query to fetch the current page of results
$results = mysqli_query($conn, $propertiesQuery);

// Calculate total number of results
$totalQuery = "SELECT COUNT(*) AS total FROM property p JOIN city c ON p.FK_CityID = c.CityID WHERE p.Suburb LIKE '%$searchTerm%' OR c.CityName LIKE '%$searchTerm%' OR p.Street LIKE '%$searchTerm%' OR p.PropertyTitle LIKE '%$searchTerm%'";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRows = mysqli_fetch_assoc($totalResult)['total'];

// Calculate total number of pages
$totalPages = ceil($totalRows / $resultsPerPage);

?>
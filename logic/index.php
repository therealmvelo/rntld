<?php

$db = new DbConnect;
$conn = $db->connect();

$sql = "SELECT CityName, MIN(CityID) AS MinCityID, COUNT(*) AS NumDuplicates
        FROM city
        GROUP BY CityName
        HAVING NumDuplicates > 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Update the duplicate city names to the one with the minimum CityID (oldest)
        $updateCitySql = "UPDATE city
                          SET CityName = ?
                          WHERE CityID != ?
                          AND CityName = ?";

        $updateCityStmt = $conn->prepare($updateCitySql);
        $newCityName = $row['CityName'];
        $updateCityStmt->bind_param('sis', $newCityName, $row['MinCityID'], $row['CityName']);
        $updateCityStmt->execute();

        // Update foreign key references in the Property table
        $updatePropertySql = "UPDATE property
                              SET FK_CityID = ?
                              WHERE FK_CityID = ?";

        $updatePropertyStmt = $conn->prepare($updatePropertySql);
        $updatePropertyStmt->bind_param('ii', $row['MinCityID'], $row['CityID']);
        $updatePropertyStmt->execute();
    }

}
 

//if ($_SERVER["REQUEST_METHOD"] == "POST") {
//    loginUser($_POST['txtEmail'], $_POST['txtPassword']);
//}
 // Check if a student or landlord is logged in
if (isset($_SESSION['userID'], $_SESSION['userName'], $_SESSION['userType'], $_SESSION['loginTime'])) {
    $userID = $_SESSION['userID'];
    $userName = $_SESSION['userName'];
    $userType = $_SESSION['userType'];
    $loginTime = $_SESSION['loginTime'];

    // Set the session expiration time (e.g., 8 hours)
    $expirationTime = 8 * 60 * 60; // 8 hours in seconds

    // Check if the session has expired
    if (time() - $loginTime > $expirationTime) {
        // Session has expired, destroy the session and redirect to the login page
        include 'logout.php';
        header("Location: login.php");
        exit();
    }

    // Update the login time to keep the session alive
    $_SESSION['loginTime'] = time();

    // You can now use these variables on the index page
} else {
    $userType = 'Guest';
}

/* Fetch data from the Property table along with the number of landlords for each suburb
$sql = "SELECT City.CityID, City.CityName, COUNT(Landlord.LandlordID) AS NumLandlords
        FROM City
        LEFT JOIN Landlord ON City.CityID = Landlord.CityID
        GROUP BY City.CityID";
$result = $conn->query($sql);
*/
?>

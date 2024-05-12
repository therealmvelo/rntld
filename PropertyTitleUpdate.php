<?php
include 'include/config.php';

$db = new DbConnect;
$conn = $db->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['PropertyTitleUpdate'])) {
    $propertyTitle = filter_input(INPUT_POST, "txtTitle", FILTER_SANITIZE_STRING);
    $propertyID = filter_input(INPUT_POST, "propertyID", FILTER_SANITIZE_NUMBER_INT);

    // Prepare and execute the SQL query to update the property title
    $updatePropertyTitleQuery = "UPDATE property SET PropertyTitle = ? WHERE PropertyID = ?";
    $updatePropertyTitleStmt = $conn->prepare($updatePropertyTitleQuery);
    $updatePropertyTitleStmt->bind_param("si", $propertyTitle, $propertyID);

    if ($updatePropertyTitleStmt->execute()) {
        echo "Property title updated successfully";
    } else {
        echo "Error updating property title";
    }

    $updatePropertyTitleStmt->close();
}
?>

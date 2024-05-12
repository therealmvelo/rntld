<?php
class DbConnect{

    private $servername = 'localhost';
    private $dbname = 'roomlinkcopy2'; 
    private $username = 'root'; 
    private $password = ''; 
    public function connect( ){
        try {
            $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            return $conn;
        } catch (mysqli_sql_exception $e){
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
              }
        }
        }
    }

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
        echo "<p class='text-success text-center'>Property title updated successfully</p>";
    } else {
        echo "Error updating property title";
    }

    $updatePropertyTitleStmt->close();
}
?>

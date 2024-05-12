
<?php
class DbConnect{ //Update this to your database details.

private $servername = 'localhost';
private $dbname = 'roomlinkcopy2'; //database name
private $username = 'root'; // database username
private $password = ''; // database password, leave it empty if you are using xampp
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

//number formatter
function formatNumber($num) {
    if ($num >= 1000 && $num < 1000000) {
        return round($num / 1000, 1) . 'k';
    } else if ($num >= 1000000 && $num < 1000000000) {
    return round($num / 1000000, 1) . 'M';
    } else if ($num >= 1000000000) {
return round($num / 1000000000, 1) . 'B';
} else {
return $num;
}
}



?>

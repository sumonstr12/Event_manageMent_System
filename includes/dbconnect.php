
<?php   

// Database connection
 
// Database connection settings
$host = "localhost";
$user = "root";
$password = "";
$dbname = "test_modell";

// Create a new connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

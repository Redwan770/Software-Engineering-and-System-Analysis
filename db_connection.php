<?php
$host = "localhost";  // Database host
$username = "root";   // Database username
$password = "";       // Database password
$database = "DistribuTrack";  // Your database name

try {
    // Create a PDO instance to connect to MySQL
    $conn = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    // Set the PDO error mode to exception for easier debugging
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle any database connection errors
    die("Connection failed: " . $e->getMessage());
}
?>

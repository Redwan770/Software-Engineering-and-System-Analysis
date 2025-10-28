<?php
require 'db_connection.php'; // Include the database connection

try {
    // Query to fetch products
    $sql = "SELECT * FROM inventory WHERE quantity > 0 ORDER BY product_name ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch products as associative array
} catch (PDOException $e) {
    die("Error fetching products: " . $e->getMessage());
}
?>

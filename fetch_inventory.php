<?php
require 'db_connection.php';  // Include the database connection
session_start();  // Start the session

// Ensure distributor is logged in
if (!isset($_SESSION['distributor_id'])) {
    die("Unauthorized access. Please log in.");
}

$distributor_id = $_SESSION['distributor_id'];

try {
    // Fetch products for the logged-in distributor
    $sql = "SELECT * FROM inventory WHERE distributor_id = :distributor_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':distributor_id' => $distributor_id]);

    // Fetch all inventory products
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Loop through and add the correct image path (absolute URL)
    foreach ($products as &$product) {
        // Ensure the image path is absolute
        $product['image_path'] = 'http://' . $_SERVER['HTTP_HOST'] . '/uploads/' . basename($product['image_path']);
    }

    // Output products as JSON
    echo json_encode($products);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

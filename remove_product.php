<?php
require 'db_connection.php';
session_start();

// Ensure distributor is logged in
if (!isset($_SESSION['distributor_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$distributor_id = $_SESSION['distributor_id'];

// Get the product ID from the request (via POST)
$data = json_decode(file_get_contents("php://input"), true);
$product_id = $data['id'];

try {
    // Delete the product from the database
    $sql = "DELETE FROM inventory WHERE id = :product_id AND distributor_id = :distributor_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':product_id' => $product_id,
        ':distributor_id' => $distributor_id
    ]);

    // Return success message
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>

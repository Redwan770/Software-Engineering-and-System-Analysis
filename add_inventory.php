<?php
session_start();  // Start the session

// Ensure distributor is logged in
if (!isset($_SESSION['distributor_id'])) {
    die("Unauthorized access. Please log in.");
}

require 'db_connection.php';  // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $distributor_id = $_SESSION['distributor_id'];  // Get distributor's ID from session
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $description = $_POST['description'] ?? '';  // Optional description field
    $image_path = '';

    // Handle file upload (image)
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $upload_dir = 'uploads/';  // Folder where images will be stored
        $image_name = time() . '_' . basename($_FILES['product_image']['name']);
        $image_path = $upload_dir . $image_name;

        // Move uploaded file to the 'uploads' folder
        if (!move_uploaded_file($_FILES['product_image']['tmp_name'], $image_path)) {
            echo "<script>alert('Error uploading image.');</script>";
        }
    }

    // Insert product details into the database
    try {
        $sql = "INSERT INTO inventory (distributor_id, product_name, description, price, quantity, image_path)
                VALUES (:distributor_id, :product_name, :description, :price, :quantity, :image_path)";
        
        $stmt = $conn->prepare($sql);

        if ($stmt->execute([
            ':distributor_id' => $distributor_id,
            ':product_name' => $product_name,
            ':description' => $description,
            ':price' => $price,
            ':quantity' => $quantity,
            ':image_path' => $image_path
        ])) {
            echo "<script>alert('Product added successfully!');</script>";
            header("Location: inventory-management.html?success=1");
        } else {
            echo "<script>alert('Error adding product to inventory.');</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<?php
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $nid = $_POST['nid'];
    $phone = $_POST['phone'];
    $shop_name = $_POST['shop_name'];
    $shop_address = $_POST['shop_address'];

    // Validate password match
    if ($password !== $confirm_password) {
        die("Error: Passwords do not match.");
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        $sql = "INSERT INTO shopkeeper (first_name, last_name, email, password, nid, phone, shop_name, shop_address) 
                VALUES (:firstname, :lastname, :email, :password, :nid, :phone, :shop_name, :shop_address)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':email' => $email,
            ':password' => $hashed_password,
            ':nid' => $nid,
            ':phone' => $phone,
            ':shop_name' => $shop_name,
            ':shop_address' => $shop_address,
        ]);

        // Redirect to the dashboard
        header("Location: shopkeeper-dashboard.html");
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "Error: Email or NID already exists.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<?php
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $company_name = $_POST['company_name'];
    $business_license = $_POST['business_license'];
    $nid = $_POST['nid'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Validate password match
    if ($password !== $confirm_password) {
        die("Error: Passwords do not match.");
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        $sql = "INSERT INTO distributor (first_name, last_name, email, password, company_name, business_license, nid, phone, address) 
                VALUES (:firstname, :lastname, :email, :password, :company_name, :business_license, :nid, :phone, :address)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':email' => $email,
            ':password' => $hashed_password,
            ':company_name' => $company_name,
            ':business_license' => $business_license,
            ':nid' => $nid,
            ':phone' => $phone,
            ':address' => $address,
        ]);

        // Redirect to the dashboard
        header("Location: distributor-dashboard.html");
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "Error: Email, Business License, or NID already exists.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

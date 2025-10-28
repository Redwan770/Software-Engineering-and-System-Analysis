<?php
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $sql = "SELECT * FROM shopkeeper WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':email' => $email]);

        $shopkeeper = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($shopkeeper && password_verify($password, $shopkeeper['password'])) {
            // Redirect to the dashboard
            header("Location: shopkeeper-dashboard.html");
            exit;
        } else {
            echo "Invalid email or password.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

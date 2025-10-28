<?php
require 'db_connection.php';
session_start();  // Start the session to store session variables

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Prepare the SQL query to find the distributor by email
        $sql = "SELECT * FROM distributor WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':email' => $email]);

        // Fetch distributor data
        $distributor = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify if the distributor exists and if the password is correct
        if ($distributor && password_verify($password, $distributor['password'])) {
            // Set session variable upon successful login
            $_SESSION['distributor_id'] = $distributor['id'];  // Set distributor ID in session
            header("Location: distributor-dashboard.html");  // Redirect to dashboard
            exit;
        } else {
            echo "Invalid email or password.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate input
    $errors = [];

    if (empty($full_name)) {
        $errors[] = "Full Name is required";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long";
    }

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $errors[] = "Email already exists";
    }

    if (empty($errors)) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user
        $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
        
        try {
            $stmt->execute([$full_name, $email, $hashed_password]);
            header("Location: login.html?registration=success");
            exit();
        } catch(PDOException $e) {
            echo "Registration failed: " . $e->getMessage();
        }
    } else {
        // Display errors
        foreach($errors as $error) {
            echo $error . "<br>";
        }
    }
}
?>
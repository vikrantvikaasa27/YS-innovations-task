<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['full_name']; ?>!</h2>
        <p>You have successfully logged in.</p>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>
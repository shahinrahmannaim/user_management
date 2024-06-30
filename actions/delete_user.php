<?php
require_once '../classes/User.php';
require_once '../config/config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You need to be logged in to delete your account.";
    exit;
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Establish database connection
    $database = new Database();
    $db = $database->getConnection();

    // Create a User object
    $user = new User($db);
    $user->id = $_SESSION['user_id'];

    // Attempt to delete the user
    if ($user->delete()) {
        // Destroy session on successful deletion
        session_unset();
        session_destroy();

        // Redirect to a confirmation page or home page
        header("Location: ../views/deletion_success.php");
        exit();
    } else {
        echo "Unable to delete account. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Account</title>
</head>
<body>
    <h2>Delete Account</h2>
    <p>Are you sure you want to delete your account? This action cannot be undone.</p>
    <form method="POST" action="">
        <button type="submit">Delete My Account</button>
    </form>
</body>
</html>

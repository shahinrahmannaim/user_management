<?php
require_once '../classes/User.php';
require_once '../config/config.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login_form.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);

    // Set user properties from the form submission
    $user->id = $_SESSION['user_id'];  // Use the logged-in user's ID
    $user->username = $_POST['username'];
    $user->email = $_POST['email'];
    $user->gender = $_POST['gender'];
    $user->date_of_birth = $_POST['date_of_birth'];

    if ($user->update()) {
        echo "Profile updated successfully.";
        // Redirect to profile page after update
        header("Location: ../views/profile.php");
        exit;
    } else {
        echo "Unable to update profile.";
    }
}
?>

<?php
require_once '../classes/User.php';
require_once '../config/config.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if user is already logged in
    if (isset($_SESSION['user_id'])) {
        echo "You are already logged in.";
        exit;
    }

    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);

    $user->username = $_POST['username'];
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];
    $user->gender = $_POST['gender'];
    $user->date_of_birth = $_POST['date_of_birth'];

    if ($user->create()) {
        // Redirect to login page after successful signup
        header("Location: ../views/login_form.php");
        exit;
    } else {
        echo "Unable to create user.";
    }
}
?>

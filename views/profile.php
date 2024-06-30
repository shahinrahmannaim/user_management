<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit;
}

require_once '../classes/User.php';
require_once '../config/config.php';

// Get user details from the database
$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$user->id = $_SESSION['user_id'];  // Use the logged-in user's ID
$stmt = $user->readSingleById();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $username = $row['username'];
    $email = $row['email'];
    $gender = $row['gender'];
    $date_of_birth = $row['date_of_birth'];
} else {
    echo "User not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
</head>
<body>
    <h2>Your Profile</h2>
    <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
    <p><strong>Gender:</strong> <?php echo htmlspecialchars($gender); ?></p>
    <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($date_of_birth); ?></p>
    <a href="edit_profile.php">Edit Profile</a>
    <a href="../actions/logout.php">Logout</a>
</body>
</html>

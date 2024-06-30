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
    <title>Edit Profile</title>
</head>
<body>
    <h2>Edit Profile</h2>
    <form method="POST" action="../actions/edit_user.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user->id); ?>">
        <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" placeholder="Username" required>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Email" required>
        <select name="gender" required>
            <option value="Male" <?php echo $gender == 'Male' ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo $gender == 'Female' ? 'selected' : ''; ?>>Female</option>
            <option value="Other" <?php echo $gender == 'Other' ? 'selected' : ''; ?>>Other</option>
        </select>
        <input type="date" name="date_of_birth" value="<?php echo htmlspecialchars($date_of_birth); ?>" required>
        <button type="submit">Update Profile</button>
    </form>
</body>
</html>

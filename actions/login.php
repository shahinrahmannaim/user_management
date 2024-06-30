<?php
require_once '../classes/User.php';
require_once '../config/config.php';
session_start();


// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login_form.php ");
    exit();
}






if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $user->email = $_POST['email'];

    $stmt = $user->readSingleByEmail();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($_POST['password'], $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        echo "Login successful. Welcome " . $row['username'];
        echo "<br>";
        
    } else {
        echo "Login failed. Incorrect email or password.";
    }
    $isLoggedIn = isset($_SESSION['user_id']);
}
?>


<body>
    <?php if ($isLoggedIn): ?>
        <!-- Show profile link if logged in -->

        <a href="../views/profile.php">Mon Perfil</a>
        <a href="../views/userlists.php">Tous les utilisateurs</a>
    <?php else: ?>
        <!-- Show login link if not logged in -->
        <a href="../views/login_form.php">Login</a>
      
    <?php  endif   ; ?>
</body>


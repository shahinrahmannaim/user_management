<?php
require_once '../classes/User.php';
require_once '../config/config.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$stmt = $user->readAll();

echo "<h2>Users List</h2>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Gender</th><th>Date of Birth</th><th>Action</th></tr>";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['username'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['gender'] . "</td>";
    echo "<td>" . $row['date_of_birth'] . "</td>";
    echo "<td><a href='../views/edit_profile.php?id=" . $row['id'] . "'>Edit</a> | 
              <a href='../actions/delete_user.php?id=" . $row['id'] . "'>Delete</a></td>";
    echo "</tr>";
}
echo "</table>";
?>

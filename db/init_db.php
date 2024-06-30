<?php
require_once '../config/config.php';

class InitDB {
    public function createDatabaseAndTable() {
        $database = new Database();
        $db = $database->getConnection();
        echo "Database and table setup completed.";
    }
}

$initDB = new InitDB();
$initDB->createDatabaseAndTable();
?>

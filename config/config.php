<?php
class Database {
    private $host = "localhost";
    private $db_name = "user_management";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Check if database exists and create if not
            $query = "CREATE DATABASE IF NOT EXISTS " . $this->db_name;
            $this->conn->exec($query);

            // Use the newly created database
            $this->conn->exec("USE " . $this->db_name);

            // Check if table exists and create if not
            $table_query = "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) NOT NULL,
                email VARCHAR(100) NOT NULL,
                password VARCHAR(255) NOT NULL,
                gender ENUM('Male', 'Female', 'Other') NOT NULL,
                date_of_birth DATE NOT NULL
            )";
            $this->conn->exec($table_query);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>

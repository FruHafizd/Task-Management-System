<?php
class Connection {
    public function connectionDatabase() {
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "sistemManajemenTugas";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit; // Stop further execution if connection fails
        }
    }
}

// Create an instance of Connection and get the PDO object
$connection = new Connection();
$pdo = $connection->connectionDatabase();


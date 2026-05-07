<?php

// Basic database connection settings used to connect PHP to MySQL
$host = "localhost";
$user = "root";          // Default XAMPP MySQL username
$pass = "";              // Default XAMPP MySQL password (empty)
$dbname = "src_database"; // Name of the database your system uses

try {
    // Create a new PDO connection using the provided credentials.
    // PDO supports prepared statements, which help prevent SQL injection.
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

    // Enable exception mode so PDO throws errors that can be caught and handled.
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    // If the connection fails, stop the script and display an error message.
    die("Database connection failed: " . $e->getMessage());
}

?>
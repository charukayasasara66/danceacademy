<?php
// Database Configuration Template
// RENAME THIS FILE TO db_connect.php AND FILL IN YOUR DETAILS

$servername = "localhost"; // Usually localhost for cPanel
$username   = "YOUR_DATABASE_USERNAME";
$password   = "YOUR_DATABASE_PASSWORD";
$dbname     = "YOUR_DATABASE_NAME";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // In a real app, don't show the specific error to the public
    error_log("Connection failed: " . $conn->connect_error);
    die("Database connection failed. Please check your configuration.");
}

// Set charset to utf8mb4 for Sinhala/special character support
$conn->set_charset("utf8mb4");
?>
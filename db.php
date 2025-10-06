<?php
$host = "localhost";   // Change if not localhost
$user = "root";        // MySQL username
$pass = "";            // MySQL password
$dbname = "spotifydb"; // Database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}
?>

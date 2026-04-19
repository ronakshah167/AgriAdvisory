<?php
// Database connection configuration
// Using 127.0.0.1 for high compatibility on macOS XAMPP
// Database name is agriadvisory_v2 as identified in phpMyAdmin
$conn = new mysqli("127.0.0.1", "root", "", "agriadvisory_v2");

// Check connection
if ($conn->connect_error) {
    // We show the real MySQL error for debugging as requested
    die("Connection failed: " . $conn->connect_error);
}
?>
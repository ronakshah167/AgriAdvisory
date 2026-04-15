<?php
require_once "db_connect.php";

// Set header for plain text response
header("Content-Type: text/plain");

// Read POST data with defaults
$fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$address = isset($_POST['address']) ? trim($_POST['address']) : '';
$land = isset($_POST['land']) ? trim($_POST['land']) : '';
$service = isset($_POST['service']) ? trim($_POST['service']) : '';

// Basic validation
if (empty($fullname) || empty($email) || empty($password)) {
    echo "Error: Missing required fields";
    exit;
}

// Prepare statement for security
$stmt = $conn->prepare("INSERT INTO farmers (fullname, email, phone, password, address, land_area, service) VALUES (?, ?, ?, ?, ?, ?, ?)");

if ($stmt) {
    // Note: In production, password should be hashed with password_hash()
    $stmt->bind_param("sssssss", $fullname, $email, $phone, $password, $address, $land, $service);

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error: Database preparation failed";
}

$conn->close();
?>
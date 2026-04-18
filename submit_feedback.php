<?php
header('Content-Type: application/json');
include 'db_connect.php';

// Simple session check if user is logged in (optional based on existing app logic)
session_start();
$farmer_id = isset($_SESSION['farmer_id']) ? $_SESSION['farmer_id'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $rating = (int) $_POST['rating'];
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO feedback (farmer_id, name, email, rating, message) 
            VALUES (" . ($farmer_id ? $farmer_id : "NULL") . ", '$name', '$email', $rating, '$message')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Thank you for your feedback!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

$conn->close();
?>
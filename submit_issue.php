<?php
header('Content-Type: application/json');
include 'db_connect.php';

session_start();
$farmer_id = isset($_SESSION['farmer_id']) ? $_SESSION['farmer_id'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $issue_type = mysqli_real_escape_string($conn, $_POST['issue_type']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $sql = "INSERT INTO issues (farmer_id, name, email, issue_type, description) 
            VALUES (" . ($farmer_id ? $farmer_id : "NULL") . ", '$name', '$email', '$issue_type', '$description')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Issue report submitted. We will look into it shortly.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

$conn->close();
?>
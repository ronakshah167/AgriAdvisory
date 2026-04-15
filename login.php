<?php
session_start();
require_once "db_connect.php";

// Set header for plain text response
header("Content-Type: application/json");

// Read POST data
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if (empty($email) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Please fill in all fields"]);
    exit;
}

// Prepare statement to fetch user
$stmt = $conn->prepare("SELECT id, fullname, password FROM farmers WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verify password
    if (password_verify($password, $user['password'])) {
        // Password correct, start session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['fullname'];

        echo json_encode([
            "status" => "success",
            "message" => "Login successful",
            "name" => $user['fullname']
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid email or password"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Account not found"]);
}

$stmt->close();
$conn->close();
?>
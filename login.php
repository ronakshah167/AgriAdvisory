<?php
/**
 * login.php
 * Handles farmer login. Returns JSON with status, name, and farmer_id.
 * Logs login activity to site_activity_log.
 */
session_start();
require_once "db_connect.php";
header("Content-Type: application/json");

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if (empty($email) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Please fill in all fields"]);
    exit;
}

$stmt = $conn->prepare(
    "SELECT id, fullname, password FROM farmers WHERE email = ? AND is_active = 1"
);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['fullname'];

        // Log login
        $farmer_id = $user['id'];
        $action = 'login';
        $meta = json_encode(["email" => $email]);
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $log = $conn->prepare("INSERT INTO site_activity_log (farmer_id, action, meta, ip_address, user_agent) VALUES (?, ?, ?, ?, ?)");
        if ($log) {
            $log->bind_param("issss", $farmer_id, $action, $meta, $ip, $ua);
            $log->execute();
            $log->close();
        }

        echo json_encode([
            "status" => "success",
            "message" => "Login successful",
            "name" => $user['fullname'],
            "farmer_id" => $user['id']
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
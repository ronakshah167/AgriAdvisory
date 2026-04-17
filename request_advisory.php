<?php
require_once "db_connect.php";
header("Content-Type: application/json");

$farmer_id = isset($_POST['farmer_id']) ? intval($_POST['farmer_id']) : null;
$farmer_name = isset($_POST['farmer_name']) ? trim($_POST['farmer_name']) : '';
$farmer_phone = isset($_POST['farmer_phone']) ? trim($_POST['farmer_phone']) : '';
$farmer_email = isset($_POST['farmer_email']) ? trim($_POST['farmer_email']) : '';
$crop_type = isset($_POST['crop_type']) ? trim($_POST['crop_type']) : '';
$issue_desc = isset($_POST['issue_desc']) ? trim($_POST['issue_desc']) : '';
$preferred_date = isset($_POST['preferred_date']) ? trim($_POST['preferred_date']) : null;

if (empty($farmer_name) || empty($issue_desc)) {
    echo json_encode(["status" => "error", "message" => "Name and issue description are required."]);
    exit;
}

// preferred_date: set to NULL if empty
$preferred_date = $preferred_date ?: null;

$stmt = $conn->prepare(
    "INSERT INTO advisory_requests (farmer_id, farmer_name, farmer_phone, farmer_email, crop_type, issue_desc, preferred_date)
     VALUES (?, ?, ?, ?, ?, ?, ?)"
);

if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "DB Error: " . $conn->error]);
    exit;
}

$stmt->bind_param("issssss", $farmer_id, $farmer_name, $farmer_phone, $farmer_email, $crop_type, $issue_desc, $preferred_date);

if ($stmt->execute()) {
    $req_id = $stmt->insert_id;

    // Log activity
    $action = 'advisory_request';
    $meta = json_encode(["request_id" => $req_id, "crop" => $crop_type]);
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $log = $conn->prepare("INSERT INTO site_activity_log (farmer_id, action, meta, ip_address, user_agent) VALUES (?, ?, ?, ?, ?)");
    if ($log) {
        $log->bind_param("issss", $farmer_id, $action, $meta, $ip, $ua);
        $log->execute();
        $log->close();
    }

    echo json_encode(["status" => "success", "request_id" => $req_id, "message" => "Consultation request submitted."]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
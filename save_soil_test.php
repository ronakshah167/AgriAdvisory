<?php
/**
 * save_soil_test.php
 * Saves a soil test result to the soil_tests table.
 * Called from soil.html via fetch POST.
 */
require_once "db_connect.php";
header("Content-Type: application/json");

$farmer_id = isset($_POST['farmer_id']) ? intval($_POST['farmer_id']) : null;
$soil_type = isset($_POST['soil_type']) ? trim($_POST['soil_type']) : '';
$ph_value = isset($_POST['ph_value']) ? floatval($_POST['ph_value']) : null;
$nitrogen_mg_kg = isset($_POST['nitrogen_mg_kg']) ? floatval($_POST['nitrogen_mg_kg']) : null;
$moisture_percent = isset($_POST['moisture_percent']) ? floatval($_POST['moisture_percent']) : null;
$recommended_crop = isset($_POST['recommended_crop']) ? trim($_POST['recommended_crop']) : '';
$recommendation_note = isset($_POST['recommendation_note']) ? trim($_POST['recommendation_note']) : '';
$farm_location = isset($_POST['farm_location']) ? trim($_POST['farm_location']) : '';

if (empty($soil_type)) {
    echo json_encode(["status" => "error", "message" => "Soil type is required."]);
    exit;
}

$stmt = $conn->prepare(
    "INSERT INTO soil_tests (farmer_id, soil_type, ph_value, nitrogen_mg_kg, moisture_percent, recommended_crop, recommendation_note, farm_location)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
);

if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "DB Error: " . $conn->error]);
    exit;
}

$stmt->bind_param("isdddsss", $farmer_id, $soil_type, $ph_value, $nitrogen_mg_kg, $moisture_percent, $recommended_crop, $recommendation_note, $farm_location);

if ($stmt->execute()) {
    $test_id = $stmt->insert_id;

    // Log activity
    $action = 'soil_test';
    $meta = json_encode(["test_id" => $test_id, "soil_type" => $soil_type, "crop" => $recommended_crop]);
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $log = $conn->prepare("INSERT INTO site_activity_log (farmer_id, action, meta, ip_address, user_agent) VALUES (?, ?, ?, ?, ?)");
    if ($log) {
        $log->bind_param("issss", $farmer_id, $action, $meta, $ip, $ua);
        $log->execute();
        $log->close();
    }

    echo json_encode(["status" => "success", "test_id" => $test_id]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
<?php
/**
 * save_privacy.php
 * Saves a farmer's privacy settings to `farmer_privacy_settings`.
 * Called from privacy.php via fetch POST.
 */
require_once "db_connect.php";
header("Content-Type: application/json");

$farmer_id = isset($_POST['farmer_id']) ? intval($_POST['farmer_id']) : 0;
$share_soil_data = isset($_POST['share_soil']) ? 1 : 0;
$weather_sms = isset($_POST['weather_sms']) ? 1 : 0;
$store_cookies = isset($_POST['store_cookies']) ? 1 : 0;

if (!$farmer_id) {
    echo json_encode(["status" => "error", "message" => "Not logged in. Settings saved locally only."]);
    exit;
}

// Upsert — insert or update if farmer already has a row
$stmt = $conn->prepare(
    "INSERT INTO farmer_privacy_settings (farmer_id, share_soil_data, weather_sms, store_cookies)
     VALUES (?, ?, ?, ?)
     ON DUPLICATE KEY UPDATE
       share_soil_data = VALUES(share_soil_data),
       weather_sms     = VALUES(weather_sms),
       store_cookies   = VALUES(store_cookies)"
);

if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "DB Error: " . $conn->error]);
    exit;
}

$stmt->bind_param("iiii", $farmer_id, $share_soil_data, $weather_sms, $store_cookies);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Privacy settings saved."]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
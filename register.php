<?php
/**
 * register.php
 * Handles farmer registration. Saves to `farmers` table, creates default privacy settings,
 * and logs the activity to `site_activity_log`.
 */
require_once "db_connect.php";
header("Content-Type: text/plain");

$fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$address = isset($_POST['address']) ? trim($_POST['address']) : '';
$land = isset($_POST['land']) ? floatval($_POST['land']) : 0;
$service = isset($_POST['service']) ? trim($_POST['service']) : '';

// Basic validation
if (empty($fullname) || empty($email) || empty($password)) {
    echo "Error: Missing required fields";
    exit;
}

// Check duplicate email
$checkUser = $conn->prepare("SELECT id FROM farmers WHERE email = ?");
$checkUser->bind_param("s", $email);
$checkUser->execute();
$checkUser->store_result();
if ($checkUser->num_rows > 0) {
    echo "Error: Email already registered";
    $checkUser->close();
    exit;
}
$checkUser->close();

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert farmer
$stmt = $conn->prepare(
    "INSERT INTO farmers (fullname, email, phone, password, address, land_area, service)
     VALUES (?, ?, ?, ?, ?, ?, ?)"
);

if ($stmt) {
    $stmt->bind_param("ssssdss", $fullname, $email, $phone, $hashed_password, $address, $land, $service);

    if ($stmt->execute()) {
        $farmer_id = $stmt->insert_id;
        $stmt->close();

        // --- Create default privacy settings row ---
        $priv = $conn->prepare(
            "INSERT IGNORE INTO farmer_privacy_settings (farmer_id, share_soil_data, weather_sms, store_cookies)
             VALUES (?, 1, 1, 1)"
        );
        if ($priv) {
            $priv->bind_param("i", $farmer_id);
            $priv->execute();
            $priv->close();
        }

        // --- Log registration ---
        $action = 'register';
        $meta = json_encode(["farmer_id" => $farmer_id, "service" => $service]);
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $log = $conn->prepare("INSERT INTO site_activity_log (farmer_id, action, meta, ip_address, user_agent) VALUES (?, ?, ?, ?, ?)");
        if ($log) {
            $log->bind_param("issss", $farmer_id, $action, $meta, $ip, $ua);
            $log->execute();
            $log->close();
        }

        echo "Success";
    } else {
        echo "Error: " . $stmt->error;
        $stmt->close();
    }
} else {
    echo "Error: Database preparation failed";
}

$conn->close();
?>
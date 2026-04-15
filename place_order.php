<?php
require_once "db_connect.php";

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Read POST fields
$customer_name = isset($_POST['customer_name']) ? trim($_POST['customer_name']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$address = isset($_POST['address']) ? trim($_POST['address']) : '';
$items = isset($_POST['items']) ? $_POST['items'] : '';
$total = isset($_POST['total']) ? floatval($_POST['total']) : 0;
$payment_mode = isset($_POST['payment_mode']) ? trim($_POST['payment_mode']) : 'Cash on Delivery';
$farmer_id = isset($_POST['farmer_id']) ? intval($_POST['farmer_id']) : null;

// Validation
if (empty($customer_name) || empty($phone) || empty($address) || empty($items) || $total <= 0) {
    echo json_encode(["status" => "error", "message" => "All fields are required."]);
    exit;
}

// Insert order
$stmt = $conn->prepare(
    "INSERT INTO orders (farmer_id, customer_name, phone, address, items, total, payment_mode)
     VALUES (?, ?, ?, ?, ?, ?, ?)"
);

if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
    exit;
}

$stmt->bind_param("issssds", $farmer_id, $customer_name, $phone, $address, $items, $total, $payment_mode);

if ($stmt->execute()) {
    $order_id = $stmt->insert_id;

    // --- Reduce stock for each ordered product (best-effort) ---
    $decoded = json_decode($items, true);
    if (is_array($decoded)) {
        foreach ($decoded as $item) {
            $pname = isset($item['name']) ? $item['name'] : '';
            if ($pname) {
                $upd = $conn->prepare("UPDATE products SET stock_qty = GREATEST(0, stock_qty - 1) WHERE name = ?");
                if ($upd) {
                    $upd->bind_param("s", $pname);
                    $upd->execute();
                    $upd->close();
                }
            }
        }
    }

    // --- Log the activity ---
    $action = 'order_placed';
    $meta = json_encode(["order_id" => $order_id, "total" => $total]);
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
        "message" => "Order placed successfully.",
        "order_id" => $order_id
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to save order: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>

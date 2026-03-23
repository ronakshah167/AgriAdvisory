<?php
require_once "db_connect.php";

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Read POST fields
$customer_name = isset($_POST['customer_name']) ? trim($_POST['customer_name']) : '';
$phone         = isset($_POST['phone'])         ? trim($_POST['phone'])         : '';
$address       = isset($_POST['address'])       ? trim($_POST['address'])       : '';
$items         = isset($_POST['items'])         ? $_POST['items']               : '';
$total         = isset($_POST['total'])         ? floatval($_POST['total'])     : 0;

// Basic validation
if (empty($customer_name) || empty($phone) || empty($address) || empty($items) || $total <= 0) {
    echo json_encode(["status" => "error", "message" => "All fields are required."]);
    exit;
}

// Create orders table if it doesn't exist (safe for first run)
$conn->query("
    CREATE TABLE IF NOT EXISTS orders (
        id            INT AUTO_INCREMENT PRIMARY KEY,
        customer_name VARCHAR(255),
        phone         VARCHAR(20),
        address       TEXT,
        items         TEXT,
        total         DECIMAL(10,2),
        status        VARCHAR(50) DEFAULT 'pending',
        created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

$stmt = $conn->prepare(
    "INSERT INTO orders (customer_name, phone, address, items, total) VALUES (?, ?, ?, ?, ?)"
);

if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
    exit;
}

$stmt->bind_param("ssssd", $customer_name, $phone, $address, $items, $total);

if ($stmt->execute()) {
    $order_id = $stmt->insert_id;
    echo json_encode([
        "status"   => "success",
        "message"  => "Order placed successfully.",
        "order_id" => $order_id
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to save order."]);
}

$stmt->close();
$conn->close();
?>

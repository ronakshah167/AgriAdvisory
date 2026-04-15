<?php
require_once "db_connect.php";

header("Content-Type: application/json");

// Fetch products
$sql = "SELECT id, name, description, price, image FROM products ORDER BY id ASC";
$result = $conn->query($sql);

$data = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        // Cast price to float for JSON compatibility
        $row['id'] = (int) $row['id'];
        $row['price'] = (float) $row['price'];
        $data[] = $row;
    }
}

// Return as JSON
echo json_encode($data);

$conn->close();
?>
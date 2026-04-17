<?php
require_once "db_connect.php";
header("Content-Type: application/json");

$sql = "SELECT id, name, specialisation, qualification, experience_yrs, state_coverage, contact_email
           FROM advisory_experts
           WHERE is_available = 1
           ORDER BY experience_yrs DESC";
$result = $conn->query($sql);

$experts = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $row['experience_yrs'] = (int) $row['experience_yrs'];
        $experts[] = $row;
    }
}

echo json_encode($experts);
$conn->close();
?>
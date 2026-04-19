<?php
/**
 * AgriAdvisory Hub — Database Setup Runner
 * Reads and executes agriadvisory_clean.sql to create all tables and seed data.
 * Visit: http://localhost/agriadvisoryhub/setup_db.php
 */

$host = "127.0.0.1";
$user = "root";
$pass = "";
$dbname = "agriadvisory_v2";

// Connect and create DB if it doesn't exist
$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
  die("<b style='color:red'>Connection failed:</b> " . $conn->connect_error);
}

$conn->query("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$conn->select_db($dbname);
$conn->set_charset("utf8mb4");

// Read the clean SQL file
$sqlFile = __DIR__ . "/agriadvisory_clean.sql";

if (!file_exists($sqlFile)) {
  die("<b style='color:red'>Error:</b> agriadvisory_clean.sql not found in project directory.");
}

$sql = file_get_contents($sqlFile);

// Split on semicolons to run statement by statement
$statements = array_filter(
  array_map('trim', explode(';', $sql)),
  fn($s) => strlen($s) > 0 && !preg_match('/^--/', $s)
);

$ok = 0;
$errors = [];

foreach ($statements as $stmt) {
  if ($conn->query($stmt) === TRUE) {
    $ok++;
  } else {
    // Ignore "already exists" non-critical warnings
    if (strpos($conn->error, 'already exists') === false) {
      $errors[] = htmlspecialchars($stmt) . "<br><em style='color:#e9a82f'>" . $conn->error . "</em>";
    }
  }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Database Setup — AgriAdvisory Hub</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      max-width: 760px;
      margin: 60px auto;
      padding: 0 24px;
      background: #0e1a0e;
      color: #d4edda;
    }

    h1 {
      color: #52c07f;
    }

    .ok {
      background: #1a3a22;
      border: 1px solid #52c07f;
      border-radius: 8px;
      padding: 20px;
      margin: 20px 0;
    }

    .err {
      background: #3a1a1a;
      border: 1px solid #ef4444;
      border-radius: 8px;
      padding: 20px;
      margin: 20px 0;
    }

    a {
      color: #52c07f;
    }

    pre {
      font-size: 0.8rem;
      overflow: auto;
    }
  </style>
</head>

<body>
  <h1>🌾 AgriAdvisory Hub — Database Setup (v2)</h1>

  <?php if (empty($errors)): ?>
    <div class="ok">
      <strong>✅ Setup Complete!</strong><br>
      All <?= $ok ?> SQL statements executed successfully in <code>agriadvisory_v2</code>.<br><br>
      <strong>Tables created:</strong>
      <ul>
        <li>farmers</li>
        <li>farmer_privacy_settings</li>
        <li>products — seeded with 6 products</li>
        <li>orders</li>
        <li>order_items</li>
        <li>soil_tests</li>
        <li>weather_logs</li>
        <li>advisory_experts — seeded with 5 experts</li>
        <li>advisory_requests</li>
        <li>cart_sessions</li>
        <li>site_activity_log</li>
        <li>feedback</li>
        <li>issues</li>
      </ul>
    </div>
    <p>
      <a href="http://localhost/phpmyadmin/index.php?db=agriadvisory_v2">→ View in phpMyAdmin</a><br>
      <a href="index.php">→ Go to Homepage</a>
    </p>
  <?php else: ?>
    <div class="ok">
      <?= $ok ?> statements ran successfully.
    </div>
    <div class="err">
      <strong>⚠️ Some statements had errors:</strong>
      <pre><?= implode("<br><br>", $errors) ?></pre>
    </div>
    <p><a href="index.php">→ Go to Homepage</a></p>
  <?php endif; ?>
</body>

</html>
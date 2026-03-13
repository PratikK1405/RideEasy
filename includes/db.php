<?php
// Database configuration - edit these or use db_config.php
if (file_exists(__DIR__ . '/db_config.php')) {
    $db_config = require __DIR__ . '/db_config.php';
    define('DB_HOST', $db_config['host'] ?? 'localhost');
    define('DB_USER', $db_config['user'] ?? 'root');
    define('DB_PASS', $db_config['pass'] ?? '');
    define('DB_NAME', $db_config['name'] ?? 'rideeasy_db');
} else {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '14052005');  // Change this to your MySQL password
    define('DB_NAME', 'rideeasy_db');
}

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to UTF-8
mysqli_set_charset($conn, "utf8mb4");

// Function to sanitize input
function clean_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($conn, $data);
}

// Function to check if user is logged in (admin)
function is_admin_logged_in() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}
?>
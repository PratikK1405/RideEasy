<?php
// ============================================================
// Database Configuration
// Railway provides MySQL credentials as environment variables
// Fallback values are for local development only
// ============================================================

define('DB_HOST', getenv('MYSQLHOST')     ?: 'localhost');
define('DB_PORT', getenv('MYSQLPORT')     ?: '3306');
define('DB_USER', getenv('MYSQLUSER')     ?: 'root');
define('DB_PASS', getenv('MYSQLPASSWORD') ?: '14052005');
define('DB_NAME', getenv('MYSQLDATABASE') ?: 'rideeasy_db');

// Create connection (mysqli supports custom port)
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, (int)DB_PORT);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to UTF-8
mysqli_set_charset($conn, "utf8mb4");

// Sanitize user input
function clean_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($conn, $data);
}

// Check if admin is logged in
function is_admin_logged_in() {
    return isset($_SESSION['admin_logged_in']) 
           && $_SESSION['admin_logged_in'] === true;
}
?>

<?php
/**
 * Run database migrations
 * Access: http://localhost/RideEasy/database/run_migration.php
 * DELETE THIS FILE after running for security!
 */
include '../includes/db.php';

$results = [];

// 1. Add reset_token column
$sql = "SHOW COLUMNS FROM admin LIKE 'reset_token'";
$r = mysqli_query($conn, $sql);
if (mysqli_num_rows($r) == 0) {
    if (mysqli_query($conn, "ALTER TABLE admin ADD COLUMN reset_token VARCHAR(255) NULL")) {
        $results[] = "✅ Added reset_token column";
    } else {
        $results[] = "❌ Failed: " . mysqli_error($conn);
    }
} else {
    $results[] = "⏭️ reset_token already exists";
}

// 2. Add reset_token_expires column
$sql = "SHOW COLUMNS FROM admin LIKE 'reset_token_expires'";
$r = mysqli_query($conn, $sql);
if (mysqli_num_rows($r) == 0) {
    if (mysqli_query($conn, "ALTER TABLE admin ADD COLUMN reset_token_expires DATETIME NULL")) {
        $results[] = "✅ Added reset_token_expires column";
    } else {
        $results[] = "❌ Failed: " . mysqli_error($conn);
    }
} else {
    $results[] = "⏭️ reset_token_expires already exists";
}

// 3. Fix bikes size column
if (mysqli_query($conn, "ALTER TABLE bikes MODIFY COLUMN size VARCHAR(20)")) {
    $results[] = "✅ Updated bikes.size column for engine capacity";
} else {
    $results[] = "⏭️ bikes.size: " . mysqli_error($conn);
}

?>
<!DOCTYPE html>
<html>
<head><title>Migration Complete</title></head>
<body style="font-family: sans-serif; padding: 20px;">
<h2>Database Migration Results</h2>
<ul><?php foreach ($results as $r) echo "<li>$r</li>"; ?></ul>
<hr>
<p><a href="../create_admin.php">Create/Reset Admin Account</a></p>
<p><a href="../admin/">Admin Login</a></p>
<p style="color:red;"><strong>⚠️ Delete this file (database/run_migration.php) after use!</strong></p>
</body>
</html>

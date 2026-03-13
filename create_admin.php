<?php
/**
 * CREATE / RESET ADMIN ACCOUNT
 * Access: http://localhost/RideEasy/create_admin.php
 * DELETE THIS FILE after use for security!
 */
$msg = '';
$msg_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'includes/db.php';
    
    $new_username = trim($_POST['username'] ?? '');
    $new_password = $_POST['password'] ?? '';
    $new_email = trim($_POST['email'] ?? '');
    
    if (strlen($new_username) < 3) {
        $msg = "Username must be at least 3 characters.";
        $msg_type = 'error';
    } elseif (strlen($new_password) < 6) {
        $msg = "Password must be at least 6 characters.";
        $msg_type = 'error';
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $check_sql = "SELECT * FROM admin WHERE username = ?";
        $check_stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "s", $new_username);
        mysqli_stmt_execute($check_stmt);
        $result = mysqli_stmt_get_result($check_stmt);
        
        if (mysqli_num_rows($result) > 0) {
            $update_sql = "UPDATE admin SET password = ?, email = ? WHERE username = ?";
            $update_stmt = mysqli_prepare($conn, $update_sql);
            mysqli_stmt_bind_param($update_stmt, "sss", $hashed_password, $new_email, $new_username);
            if (mysqli_stmt_execute($update_stmt)) {
                $msg = "Password reset successfully for user: $new_username";
                $msg_type = 'success';
            } else {
                $msg = "Failed: " . mysqli_error($conn);
                $msg_type = 'error';
            }
        } else {
            $insert_sql = "INSERT INTO admin (username, password, email) VALUES (?, ?, ?)";
            $insert_stmt = mysqli_prepare($conn, $insert_sql);
            mysqli_stmt_bind_param($insert_stmt, "sss", $new_username, $hashed_password, $new_email);
            if (mysqli_stmt_execute($insert_stmt)) {
                $msg = "Admin account created successfully!";
                $msg_type = 'success';
            } else {
                $msg = "Failed: " . mysqli_error($conn) . " - Make sure database and admin table exist.";
                $msg_type = 'error';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create/Reset Admin - RideEasy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { font-family: sans-serif; max-width: 500px; margin: 50px auto; padding: 20px; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.3rem; font-weight: 600; }
        .form-group input { width: 100%; padding: 10px; font-size: 1rem; }
        .btn { padding: 12px 24px; background: #e63946; color: white; border: none; cursor: pointer; font-size: 1rem; border-radius: 6px; }
        .btn:hover { background: #c1121f; }
        .alert { padding: 12px; border-radius: 6px; margin-bottom: 1rem; }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        .links { margin-top: 2rem; }
        .links a { margin-right: 1rem; color: #e63946; }
    </style>
</head>
<body>
    <h1><i class="fas fa-user-shield"></i> Create / Reset Admin</h1>
    
    <?php if ($msg): ?>
        <div class="alert alert-<?php echo $msg_type; ?>"><?php echo htmlspecialchars($msg); ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <label>Username *</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? 'admin'); ?>" required minlength="3">
        </div>
        <div class="form-group">
            <label>Password *</label>
            <input type="password" name="password" required minlength="6" placeholder="Min 6 characters">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? 'admin@rideeasy.com'); ?>">
        </div>
        <button type="submit" class="btn"><i class="fas fa-save"></i> Create / Reset Admin</button>
    </form>
    
    <div class="links">
        <a href="admin/">Admin Login</a>
        <a href="database/run_migration.php">Run Database Migration</a>
    </div>
    
    <p style="color: red; margin-top: 2rem;"><strong>⚠️ Delete create_admin.php after use!</strong></p>
</body>
</html>
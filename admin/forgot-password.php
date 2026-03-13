<?php
session_start();
include '../includes/db.php';

// Redirect if already logged in
if (is_admin_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $username = trim($_POST['username'] ?? '');
    
    if (empty($email) && empty($username)) {
        $error = "Please enter your username or email.";
    } else {
        // Check if reset columns exist
        $col_check = mysqli_query($conn, "SHOW COLUMNS FROM admin LIKE 'reset_token'");
        if (mysqli_num_rows($col_check) == 0) {
            $error = "Password reset not set up. Please run <a href='../database/run_migration.php'>database migration</a> first.";
        } else {
        // Find admin by username or email
        $sql = "SELECT id, username, email FROM admin WHERE username = ? OR email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        $search = !empty($username) ? $username : $email;
        mysqli_stmt_bind_param($stmt, "ss", $search, $search);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($admin = mysqli_fetch_assoc($result)) {
            // Generate reset token (valid 1 hour)
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            // Update admin with token (handle if columns don't exist yet)
            $update_sql = "UPDATE admin SET reset_token = ?, reset_token_expires = ? WHERE id = ?";
            $update_stmt = mysqli_prepare($conn, $update_sql);
            
            if ($update_stmt) {
                mysqli_stmt_bind_param($update_stmt, "ssi", $token, $expires, $admin['id']);
                
                if (mysqli_stmt_execute($update_stmt)) {
                    $reset_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') 
                        . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) 
                        . '/reset-password.php?token=' . $token;
                    $success = "Reset link generated! Use this link within 1 hour:";
                    $_SESSION['reset_link'] = $reset_url;
                    $_SESSION['reset_username'] = $admin['username'];
                } else {
                    $error = "Database error. Please run the migration: <a href='../database/run_migration.php'>Run Migration</a>";
                }
            } else {
                $error = "Database update failed. Please run the migration: <a href='../database/run_migration.php'>Run Migration</a>";
            }
        } else {
            $error = "No admin account found with that username or email.";
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
    <title>Forgot Password - RideEasy Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body class="admin-login-body">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <i class="fas fa-key"></i>
                <h1>Forgot Password</h1>
                <p>Enter your username or email to reset</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo $success; ?>
                    <div style="margin-top: 15px; padding: 15px; background: #f0f0f0; border-radius: 8px; word-break: break-all;">
                        <a href="<?php echo htmlspecialchars($_SESSION['reset_link']); ?>" id="reset-link">
                            <?php echo htmlspecialchars($_SESSION['reset_link']); ?>
                        </a>
                    </div>
                    <p style="margin-top: 10px; font-size: 0.9rem;">
                        <a href="<?php echo htmlspecialchars($_SESSION['reset_link']); ?>" class="btn btn-primary btn-sm">Open Reset Page</a>
                    </p>
                </div>
            <?php else: ?>
            <form method="POST" action="" class="login-form">
                <div class="form-group">
                    <label for="username"><i class="fas fa-user"></i> Username or Email</label>
                    <input type="text" id="username" name="username" placeholder="Enter username or email" 
                           value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" autofocus>
                </div>
                <input type="hidden" name="email" id="email" value="">
                
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-paper-plane"></i> Send Reset Link
                </button>
            </form>
            <?php endif; ?>
            
            <div class="login-footer">
                <a href="index.php"><i class="fas fa-arrow-left"></i> Back to Login</a>
            </div>
        </div>
    </div>
    <script>
        // Copy username to email field for search
        document.querySelector('input[name="username"]').addEventListener('input', function() {
            document.getElementById('email').value = this.value;
        });
    </script>
</body>
</html>

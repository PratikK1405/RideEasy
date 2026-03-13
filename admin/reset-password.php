<?php
session_start();
include '../includes/db.php';

// Redirect if already logged in
if (is_admin_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$success = '';
$valid_token = false;
$token = $_GET['token'] ?? '';

if (empty($token)) {
    $error = "Invalid or expired reset link.";
} else {
    // Check if token columns exist
    $col_check = mysqli_query($conn, "SHOW COLUMNS FROM admin LIKE 'reset_token'");
    if (mysqli_num_rows($col_check) == 0) {
        $error = "Password reset not configured. Please run <a href='../database/run_migration.php'>database migration</a> first.";
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id, username FROM admin WHERE reset_token = ? AND reset_token_expires > NOW()");
        mysqli_stmt_bind_param($stmt, "s", $token);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $admin = mysqli_fetch_assoc($result);
        
        if ($admin) {
            $valid_token = true;
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $password = $_POST['password'] ?? '';
                $confirm = $_POST['confirm_password'] ?? '';
                
                if (strlen($password) < 6) {
                    $error = "Password must be at least 6 characters.";
                } elseif ($password !== $confirm) {
                    $error = "Passwords do not match.";
                } else {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $null = null;
                    $update = mysqli_prepare($conn, "UPDATE admin SET password = ?, reset_token = ?, reset_token_expires = ? WHERE id = ?");
                    mysqli_stmt_bind_param($update, "sssi", $hash, $null, $null, $admin['id']);
                    
                    if (mysqli_stmt_execute($update)) {
                        $success = "Password updated successfully! Redirecting to login...";
                        header("Refresh: 2; url=index.php");
                    } else {
                        $error = "Failed to update password.";
                    }
                }
            }
        } else {
            $error = "Invalid or expired reset link. Please request a new one.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - RideEasy Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <style>
        .password-wrapper { position: relative; }
        .password-wrapper input { padding-right: 45px; }
        .password-toggle { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #666; cursor: pointer; }
    </style>
</head>
<body class="admin-login-body">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <i class="fas fa-lock"></i>
                <h1>Reset Password</h1>
                <p>Enter your new password</p>
            </div>
            
            <?php if ($error && !$valid_token): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
                <div class="login-footer">
                    <a href="forgot-password.php">Request new reset link</a> | 
                    <a href="index.php">Back to Login</a>
                </div>
            <?php elseif ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo $success; ?>
                </div>
            <?php elseif ($valid_token): ?>
                <?php if ($error): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="" class="login-form">
                    <div class="form-group">
                        <label for="password"><i class="fas fa-lock"></i> New Password *</label>
                        <div class="password-wrapper">
                            <input type="password" id="password" name="password" required minlength="6" placeholder="Min 6 characters">
                            <button type="button" class="password-toggle" onclick="togglePass('password')">
                                <i class="fas fa-eye" id="icon-password"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password"><i class="fas fa-lock"></i> Confirm Password *</label>
                        <div class="password-wrapper">
                            <input type="password" id="confirm_password" name="confirm_password" required minlength="6">
                            <button type="button" class="password-toggle" onclick="togglePass('confirm_password')">
                                <i class="fas fa-eye" id="icon-confirm_password"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save"></i> Update Password
                    </button>
                </form>
                <div class="login-footer">
                    <a href="index.php"><i class="fas fa-arrow-left"></i> Back to Login</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script>
        function togglePass(id) {
            const el = document.getElementById(id);
            const icon = document.getElementById('icon-' + id);
            if (el.type === 'password') {
                el.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                el.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }
    </script>
</body>
</html>

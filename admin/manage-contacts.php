<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!is_admin_logged_in()) {
    header('Location: index.php');
    exit;
}

$page_title = "Contact Messages";

// Handle delete
if (isset($_GET['delete'])) {
    $contact_id = (int)$_GET['delete'];
    $sql = "DELETE FROM contact WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $contact_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Message deleted successfully!";
    }
    
    header('Location: manage-contacts.php');
    exit;
}

// Get all contacts
$sql = "SELECT * FROM contact ORDER BY submitted_at DESC";
$result = mysqli_query($conn, $sql);
$contacts = mysqli_fetch_all($result, MYSQLI_ASSOC);

include 'includes/admin-header.php';
?>

<div class="admin-content">
    <div class="content-header">
        <h1><i class="fas fa-envelope"></i> Contact Messages</h1>
    </div>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    
    <div class="card">
        <div class="card-body">
            <?php if (count($contacts) > 0): ?>
                <div class="contacts-list">
                    <?php foreach ($contacts as $contact): ?>
                        <div class="contact-item">
                            <div class="contact-header">
                                <div>
                                    <h3><?php echo htmlspecialchars($contact['name']); ?></h3>
                                    <p class="contact-meta">
                                        <i class="fas fa-envelope"></i> <?php echo htmlspecialchars($contact['email']); ?> 
                                        <span class="separator">•</span>
                                        <i class="fas fa-clock"></i> <?php echo time_ago($contact['submitted_at']); ?>
                                    </p>
                                </div>
                                <a href="?delete=<?php echo $contact['id']; ?>" class="btn-action btn-delete delete-btn">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                            <div class="contact-body">
                                <strong>Subject: <?php echo htmlspecialchars($contact['subject']); ?></strong>
                                <p><?php echo nl2br(htmlspecialchars($contact['message'])); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="no-data">No contact messages yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
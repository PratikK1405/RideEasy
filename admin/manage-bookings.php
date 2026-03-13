<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!is_admin_logged_in()) {
    header('Location: index.php');
    exit;
}

$page_title = "Manage Bookings";

// Handle status update
if (isset($_GET['action']) && isset($_GET['id'])) {
    $booking_id = (int)$_GET['id'];
    $action = clean_input($_GET['action']);
    
    if ($action === 'delete') {
        $sql = "DELETE FROM bookings WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $booking_id);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "Booking deleted successfully!";
        }
    } else {
        $sql = "UPDATE bookings SET status = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $action, $booking_id);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "Booking status updated!";
        }
    }
    
    header('Location: manage-bookings.php');
    exit;
}

// Get all bookings
$sql = "SELECT b.*, bk.name as bike_name, bk.type as bike_type 
        FROM bookings b 
        LEFT JOIN bikes bk ON b.bike_id = bk.id 
        ORDER BY b.booking_date DESC";
$result = mysqli_query($conn, $sql);
$bookings = mysqli_fetch_all($result, MYSQLI_ASSOC);

include 'includes/admin-header.php';
?>

<div class="admin-content">
    <div class="content-header">
        <h1><i class="fas fa-calendar-check"></i> Manage Bookings</h1>
    </div>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    
    <div class="card">
        <div class="card-body">
            <?php if (count($bookings) > 0): ?>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Bike</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Days</th>
                                <th>Amount</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td>#<?php echo $booking['id']; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($booking['bike_name']); ?></strong><br>
                                        <small class="text-muted"><?php echo htmlspecialchars($booking['bike_type']); ?></small>
                                    </td>
                                    <td><?php echo htmlspecialchars($booking['user_name']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['user_email']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['user_phone']); ?></td>
                                    <td><?php echo $booking['days']; ?></td>
                                    <td><?php echo format_currency($booking['total_amount']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['payment_method']); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo $booking['status']; ?>">
                                            <?php echo ucfirst($booking['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('M d, Y', strtotime($booking['booking_date'])); ?></td>
                                    <td class="actions">
                                        <?php if ($booking['status'] === 'pending'): ?>
                                            <a href="?action=confirmed&id=<?php echo $booking['id']; ?>" class="btn-action btn-success" title="Confirm">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($booking['status'] === 'confirmed'): ?>
                                            <a href="?action=completed&id=<?php echo $booking['id']; ?>" class="btn-action btn-info" title="Complete">
                                                <i class="fas fa-check-double"></i>
                                            </a>
                                        <?php endif; ?>
                                        <a href="?action=cancelled&id=<?php echo $booking['id']; ?>" class="btn-action btn-warning" title="Cancel">
                                            <i class="fas fa-ban"></i>
                                        </a>
                                        <a href="?action=delete&id=<?php echo $booking['id']; ?>" class="btn-action btn-delete delete-btn" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="no-data">No bookings found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
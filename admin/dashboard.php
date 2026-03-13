<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!is_admin_logged_in()) {
    header('Location: index.php');
    exit;
}

$page_title = "Dashboard";
include 'includes/admin-header.php';

// Get statistics
$total_bikes = get_count('bikes');
$total_bookings = get_count('bookings');
$total_contacts = get_count('contact');
$total_revenue = get_total_revenue();
$recent_bookings = get_recent_bookings(5);

// Get bikes by status
$available_bikes = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM bikes WHERE status='available'"))['count'];
$rented_bikes = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM bikes WHERE status='rented'"))['count'];
?>

<div class="admin-content">
    <div class="content-header">
        <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
        <p>Welcome back, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</p>
    </div>
    
    <!-- Stats Cards -->
    <div class="stats-cards">
        <div class="stat-card-admin">
            <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <i class="fas fa-bicycle"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo $total_bikes; ?></h3>
                <p>Total Bikes</p>
                <small><?php echo $available_bikes; ?> available, <?php echo $rented_bikes; ?> rented</small>
            </div>
        </div>
        
        <div class="stat-card-admin">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo $total_bookings; ?></h3>
                <p>Total Bookings</p>
                <small>All time bookings</small>
            </div>
        </div>
        
        <div class="stat-card-admin">
            <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo format_currency($total_revenue); ?></h3>
                <p>Total Revenue</p>
                <small>From all bookings</small>
            </div>
        </div>
        
        <div class="stat-card-admin">
            <div class="stat-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo $total_contacts; ?></h3>
                <p>Contact Messages</p>
                <small>Total inquiries</small>
            </div>
        </div>
    </div>
    
    <!-- Recent Bookings -->
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-list"></i> Recent Bookings</h2>
            <a href="manage-bookings.php" class="btn btn-primary btn-sm">View All</a>
        </div>
        <div class="card-body">
            <?php if (count($recent_bookings) > 0): ?>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Bike</th>
                                <th>Customer</th>
                                <th>Days</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_bookings as $booking): ?>
                                <tr>
                                    <td>#<?php echo $booking['id']; ?></td>
                                    <td><?php echo htmlspecialchars($booking['bike_name']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['user_name']); ?></td>
                                    <td><?php echo $booking['days']; ?> days</td>
                                    <td><?php echo format_currency($booking['total_amount']); ?></td>
                                    <td><span class="badge badge-<?php echo $booking['status']; ?>"><?php echo ucfirst($booking['status']); ?></span></td>
                                    <td><?php echo time_ago($booking['booking_date']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="no-data">No bookings yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
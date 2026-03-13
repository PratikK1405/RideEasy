<?php 
session_start();

// Include required files
include 'includes/db.php';
include 'includes/functions.php';

$page_title = "Booking Successful";

if (!isset($_SESSION['success'])) {
    header('Location: index.php');
    exit;
}

$booking = $_SESSION['booking_details'] ?? [];

include 'includes/header.php';
?>

<section class="success-page">
    <div class="container">
        <div class="success-card">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>Booking Confirmed!</h1>
            <p class="success-message"><?php echo $_SESSION['success']; ?></p>
            
            <?php if (!empty($booking)): ?>
            <div class="booking-summary">
                <h3>Booking Details</h3>
                <div class="summary-row">
                    <span>Booking ID:</span>
                    <strong>#<?php echo $booking['booking_id']; ?></strong>
                </div>
                <div class="summary-row">
                    <span>Vehicle:</span>
                    <strong><?php echo htmlspecialchars($booking['bike_name']); ?></strong>
                </div>
                <div class="summary-row">
                    <span>Duration:</span>
                    <strong><?php echo $booking['days']; ?> day(s)</strong>
                </div>
                <div class="summary-row">
                    <span>Total Amount:</span>
                    <strong class="total-price"><?php echo format_currency($booking['total']); ?></strong>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="success-actions">
                <a href="bikes.php" class="btn btn-primary">
                    <i class="fas fa-motorcycle"></i> Browse More Vehicles
                </a>
                <a href="index.php" class="btn btn-outline">
                    <i class="fas fa-home"></i> Back to Home
                </a>
            </div>
        </div>
    </div>
</section>

<?php 
unset($_SESSION['success']);
unset($_SESSION['booking_details']);
include 'includes/footer.php'; 
?>
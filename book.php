<?php
session_start();
include 'includes/db.php';
include 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $bike_id = (int)$_POST['bike_id'];
    $user_name = clean_input($_POST['user_name']);
    $user_email = clean_input($_POST['user_email']);
    $user_phone = clean_input($_POST['user_phone']);
    $days = (int)$_POST['days'];
    $payment_method = clean_input($_POST['payment_method']);
    
    // Get bike details
    $bike = get_bike_by_id($bike_id);
    
    if (!$bike) {
        $_SESSION['error'] = "Invalid vehicle selected.";
        header('Location: bikes.php');
        exit;
    }
    
    if ($bike['status'] !== 'available') {
        $_SESSION['error'] = "Sorry, this vehicle is not available for rent.";
        header('Location: bikes.php');
        exit;
    }
    
    // Calculate total amount
    $total_amount = $bike['price_per_day'] * $days;
    
    // Insert booking
    $sql = "INSERT INTO bookings (bike_id, user_name, user_email, user_phone, days, total_amount, payment_method, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 'confirmed')";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isssiis", $bike_id, $user_name, $user_email, $user_phone, $days, $total_amount, $payment_method);
    
    if (mysqli_stmt_execute($stmt)) {
        // Update bike status
        $update_sql = "UPDATE bikes SET status = 'rented' WHERE id = ?";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "i", $bike_id);
        mysqli_stmt_execute($update_stmt);
        
        $_SESSION['success'] = "Booking confirmed! We'll contact you shortly at $user_email.";
        $_SESSION['booking_details'] = [
            'bike_name' => $bike['name'],
            'days' => $days,
            'total' => $total_amount,
            'booking_id' => mysqli_insert_id($conn)
        ];
        
        header('Location: booking-success.php');
    } else {
        $_SESSION['error'] = "Booking failed. Please try again.";
        header('Location: bikes.php');
    }
    
    mysqli_stmt_close($stmt);
    exit;
} else {
    header('Location: bikes.php');
    exit;
}
?>
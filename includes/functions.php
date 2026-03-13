<?php
// Currency Configuration
define('CURRENCY_SYMBOL', '₹');
define('CURRENCY_CODE', 'INR');

// Get all bikes or filter by type
function get_bikes($type = null, $status = 'available') {
    global $conn;
    
    $sql = "SELECT * FROM bikes WHERE 1=1";
    
    if ($type && $type !== 'all') {
        $type = clean_input($type);
        $sql .= " AND type = '$type'";
    }
    
    if ($status) {
        $sql .= " AND status = '$status'";
    }
    
    $sql .= " ORDER BY created_at DESC";
    
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Get single bike by ID
function get_bike_by_id($id) {
    global $conn;
    $id = (int)$id;
    $sql = "SELECT * FROM bikes WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

// Get total count
function get_count($table) {
    global $conn;
    $sql = "SELECT COUNT(*) as count FROM $table";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

// Get total revenue
function get_total_revenue() {
    global $conn;
    $sql = "SELECT SUM(total_amount) as revenue FROM bookings WHERE status != 'cancelled'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['revenue'] ?? 0;
}

// Get recent bookings
function get_recent_bookings($limit = 10) {
    global $conn;
    $sql = "SELECT b.*, bk.name as bike_name 
            FROM bookings b 
            LEFT JOIN bikes bk ON b.bike_id = bk.id 
            ORDER BY b.booking_date DESC 
            LIMIT $limit";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Format currency
function format_currency($amount) {
    return CURRENCY_SYMBOL . ' ' . number_format($amount, 2);
}

// Time ago function
function time_ago($timestamp) {
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;
    
    $minutes = round($seconds / 60);
    $hours = round($seconds / 3600);
    $days = round($seconds / 86400);
    $weeks = round($seconds / 604800);
    $months = round($seconds / 2629440);
    $years = round($seconds / 31553280);
    
    if ($seconds <= 60) {
        return "Just now";
    } else if ($minutes <= 60) {
        return "$minutes minutes ago";
    } else if ($hours <= 24) {
        return "$hours hours ago";
    } else if ($days <= 7) {
        return "$days days ago";
    } else if ($weeks <= 4.3) {
        return "$weeks weeks ago";
    } else if ($months <= 12) {
        return "$months months ago";
    } else {
        return "$years years ago";
    }
}
?>
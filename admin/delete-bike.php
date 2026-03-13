<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!is_admin_logged_in()) {
    header('Location: index.php');
    exit;
}

$bike_id = (int)$_GET['id'];
$bike = get_bike_by_id($bike_id);

if ($bike) {
    // Delete bike image if not default
    if ($bike['image'] !== 'default-bike.jpg' && file_exists('../assets/images/bikes/' . $bike['image'])) {
        unlink('../assets/images/bikes/' . $bike['image']);
    }
    
    // Delete bike
    $sql = "DELETE FROM bikes WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $bike_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Bike deleted successfully!";
    } else {
        $_SESSION['error'] = "Failed to delete bike.";
    }
} else {
    $_SESSION['error'] = "Bike not found.";
}

header('Location: manage-bikes.php');
exit;
?>
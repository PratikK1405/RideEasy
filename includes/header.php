<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - RideEasy' : 'RideEasy - Scooter & Motorcycle Rental'; ?></title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <div class="logo">
                    <i class="fas fa-motorcycle"></i>
                    <span>RideEasy</span>
                </div>
                
                <ul class="nav-menu" id="nav-menu">
                    <li><a href="index.php" class="nav-link">Home</a></li>
                    <li><a href="bikes.php" class="nav-link">Scooters & Motorcycles</a></li>
                    <li><a href="how-it-works.php" class="nav-link">How It Works</a></li>
                    <li><a href="contact.php" class="nav-link">Contact</a></li>
                    <!-- <li><a href="admin/index.php" class="nav-link admin-link"><i class="fas fa-user-shield"></i> Admin</a></li> -->
                </ul>
                
                <div class="hamburger" id="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </nav>
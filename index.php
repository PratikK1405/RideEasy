<?php 
$page_title = "Home";
include 'includes/db.php';
include 'includes/functions.php';
include 'includes/header.php';

// Get featured bikes (limit 6)
$featured_bikes = get_bikes(null, 'available');
$featured_bikes = array_slice($featured_bikes, 0, 6);
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="hero-title animate-fade-in">Ride Your Way</h1>
        <p class="hero-subtitle animate-fade-in-delay">Rent premium scooters & motorcycles. Affordable daily rates. Freedom on two wheels.</p>
        <div class="hero-buttons animate-fade-in-delay-2">
            <a href="bikes.php" class="btn btn-primary btn-lg">
                <i class="fas fa-motorcycle"></i> Browse Fleet
            </a>
            <a href="how-it-works.php" class="btn btn-outline-white btn-lg">
                <i class="fas fa-play-circle"></i> How It Works
            </a>
        </div>
    </div>
    <div class="scroll-indicator">
        <i class="fas fa-chevron-down"></i>
    </div>
</section>

<!-- Features Section -->
<section class="features">
    <div class="container">
        <div class="section-header">
            <h2>Why Choose RideEasy?</h2>
            <p>The best scooter & motorcycle rental experience in the city</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-motorcycle"></i>
                </div>
                <h3>Wide Fleet</h3>
                <p>Scooters, motorcycles, electric scooters & sport bikes. Find the perfect ride for your trip.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <h3>Affordable Rates</h3>
                <p>Competitive daily rates. Special discounts for weekly and monthly rentals.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>Quick Booking</h3>
                <p>Reserve your scooter or motorcycle online in minutes. Instant confirmation.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Safe & Serviced</h3>
                <p>All vehicles are regularly serviced, insured and ready for the road.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>24/7 Support</h3>
                <p>Our team is always ready to assist. Helpline available round the clock.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-helmet-safety"></i>
                </div>
                <h3>Helmets Included</h3>
                <p>Safety first. Quality helmets provided with every rental at no extra cost.</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Bikes Section -->
<section class="featured-bikes">
    <div class="container">
        <div class="section-header">
            <h2>Featured Fleet</h2>
            <p>Our most popular scooters & motorcycles</p>
        </div>
        
        <div class="bikes-grid">
            <?php if (count($featured_bikes) > 0): ?>
                <?php foreach ($featured_bikes as $bike): ?>
                    <div class="bike-card">
                        <div class="bike-image">
                            <img src="assets/images/bikes/<?php echo htmlspecialchars($bike['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($bike['name']); ?>"
                                 onerror="this.src='assets/images/bikes/default-bike.jpg'">
                            <div class="bike-badge"><?php echo htmlspecialchars($bike['type']); ?></div>
                        </div>
                        <div class="bike-content">
                            <h3><?php echo htmlspecialchars($bike['name']); ?></h3>
                            <p><?php echo htmlspecialchars(substr($bike['description'], 0, 100)); ?>...</p>
                            <div class="bike-specs">
                                <?php if ($bike['gears'] > 0): ?>
                                    <span><i class="fas fa-cog"></i> <?php echo $bike['gears']; ?> Gears</span>
                                <?php else: ?>
                                    <span><i class="fas fa-bolt"></i> Automatic</span>
                                <?php endif; ?>
                                <span><i class="fas fa-tachometer-alt"></i> <?php echo htmlspecialchars($bike['size']); ?></span>
                            </div>
                            <div class="bike-footer">
                                <div class="bike-price">
                                    <?php echo format_currency($bike['price_per_day']); ?><span>/day</span>
                                </div>
                                <a href="bikes.php?bike_id=<?php echo $bike['id']; ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-calendar-check"></i> Rent Now
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-data">No vehicles available at the moment.</p>
            <?php endif; ?>
        </div>
        
        <div class="text-center" style="margin-top: 2rem;">
            <a href="bikes.php" class="btn btn-primary">View All Vehicles</a>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-motorcycle"></i>
                </div>
                <div class="stat-number"><?php echo get_count('bikes'); ?>+</div>
                <div class="stat-label">Vehicles Available</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number"><?php echo get_count('bookings'); ?>+</div>
                <div class="stat-label">Happy Customers</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-city"></i>
                </div>
                <div class="stat-number">5+</div>
                <div class="stat-label">City Locations</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-number">4.9</div>
                <div class="stat-label">Average Rating</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta">
    <div class="container">
        <div class="cta-content">
            <h2>Ready to Ride?</h2>
            <p>Book your scooter or motorcycle today. Hit the road in minutes!</p>
            <a href="bikes.php" class="btn btn-white btn-lg">
                <i class="fas fa-motorcycle"></i> Get Started Now
            </a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
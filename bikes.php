<?php 
$page_title = "Browse Bikes";
include 'includes/db.php';
include 'includes/functions.php';
include 'includes/header.php';

// Get filter type
$filter_type = isset($_GET['type']) ? clean_input($_GET['type']) : 'all';
$bikes = get_bikes($filter_type === 'all' ? null : $filter_type);
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1><i class="fas fa-motorcycle"></i> Scooters & Motorcycles</h1>
        <p>Find the perfect ride for your trip</p>
    </div>
</section>

<!-- Bikes Section -->
<section class="bikes-section">
    <div class="container">
        <!-- Search and Filter -->
        <div class="bikes-controls">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="search-input" placeholder="Search by name...">
            </div>
            
            <div class="filter-buttons">
                <button class="filter-btn <?php echo $filter_type === 'all' ? 'active' : ''; ?>" 
                        onclick="filterBikes('all')">
                    All
                </button>
                <button class="filter-btn <?php echo $filter_type === 'Scooter' ? 'active' : ''; ?>" 
                        onclick="filterBikes('Scooter')">
                    <i class="fas fa-motorcycle"></i> Scooter
                </button>
                <button class="filter-btn <?php echo $filter_type === 'Motorcycle' ? 'active' : ''; ?>" 
                        onclick="filterBikes('Motorcycle')">
                    <i class="fas fa-motorcycle"></i> Motorcycle
                </button>
                <button class="filter-btn <?php echo $filter_type === 'Electric Scooter' ? 'active' : ''; ?>" 
                        onclick="filterBikes('Electric Scooter')">
                    <i class="fas fa-bolt"></i> Electric Scooter
                </button>
                <button class="filter-btn <?php echo $filter_type === 'Sport Bike' ? 'active' : ''; ?>" 
                        onclick="filterBikes('Sport Bike')">
                    <i class="fas fa-tachometer-alt"></i> Sport Bike
                </button>
            </div>
        </div>
        
        <!-- Bikes Grid -->
        <div class="bikes-grid" id="bikes-grid">
            <?php if (count($bikes) > 0): ?>
                <?php foreach ($bikes as $bike): ?>
                    <div class="bike-card" data-bike-name="<?php echo strtolower($bike['name']); ?>">
                        <div class="bike-image">
                            <img src="assets/images/bikes/<?php echo htmlspecialchars($bike['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($bike['name']); ?>"
                                 onerror="this.src='assets/images/bikes/default-bike.jpg'">
                            <div class="bike-badge"><?php echo htmlspecialchars($bike['type']); ?></div>
                            <div class="bike-status <?php echo $bike['status']; ?>">
                                <?php echo ucfirst($bike['status']); ?>
                            </div>
                        </div>
                        <div class="bike-content">
                            <h3><?php echo htmlspecialchars($bike['name']); ?></h3>
                            <p><?php echo htmlspecialchars($bike['description']); ?></p>
                            <div class="bike-specs">
                                <?php if ($bike['gears'] > 0): ?>
                                    <span><i class="fas fa-cog"></i> <?php echo $bike['gears']; ?> Gears</span>
                                <?php else: ?>
                                    <span><i class="fas fa-bolt"></i> Auto</span>
                                <?php endif; ?>
                                <span><i class="fas fa-tachometer-alt"></i> <?php echo htmlspecialchars($bike['size']); ?></span>
                            </div>
                            <div class="bike-footer">
                                <div class="bike-price">
                                    <?php echo format_currency($bike['price_per_day']); ?><span>/day</span>
                                </div>
                                <?php if ($bike['status'] === 'available'): ?>
                                    <button class="btn btn-primary btn-sm" onclick="openBookingModal(<?php echo $bike['id']; ?>)">
                                        <i class="fas fa-calendar-check"></i> Rent Now
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        <i class="fas fa-ban"></i> Not Available
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-data-message">
                    <i class="fas fa-motorcycle"></i>
                    <h3>No vehicles found</h3>
                    <p>Try adjusting your filters or search criteria</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Booking Modal -->
<div id="booking-modal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeBookingModal()">&times;</span>
        <h2><i class="fas fa-calendar-check"></i> Book Your Ride</h2>
        <form id="booking-form" method="POST" action="book.php">
            <input type="hidden" name="bike_id" id="modal-bike-id">
            
            <div class="form-group">
                <label>Selected Vehicle</label>
                <input type="text" id="modal-bike-name" readonly class="form-control-plaintext">
            </div>
            
            <div class="form-group">
                <label>Price Per Day</label>
                <input type="text" id="modal-bike-price" readonly class="form-control-plaintext">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="user_name">Full Name *</label>
                    <input type="text" id="user_name" name="user_name" required>
                </div>
                
                <div class="form-group">
                    <label for="user_email">Email Address *</label>
                    <input type="email" id="user_email" name="user_email" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="user_phone">Phone Number *</label>
                    <input type="tel" id="user_phone" name="user_phone" required>
                </div>
                
                <div class="form-group">
                    <label for="days">Number of Days *</label>
                    <input type="number" id="days" name="days" min="1" value="1" required onchange="calculateTotal()">
                </div>
            </div>
            
            <div class="form-group">
                <label for="payment_method">Payment Method *</label>
                <select id="payment_method" name="payment_method" required>
                    <option value="">Select Payment Method</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="Debit Card">Debit Card</option>
                    <option value="PayPal">PayPal</option>
                    <option value="Cash">Cash on Pickup</option>
                </select>
            </div>
            
            <div class="total-amount">
                <h3>Total Amount: <span id="total-amount">$0.00</span></h3>
            </div>
            
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeBookingModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-check"></i> Confirm Booking
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Store bikes data for modal
const bikesData = <?php echo json_encode($bikes); ?>;

function filterBikes(type) {
    window.location.href = `bikes.php?type=${type}`;
}

function openBookingModal(bikeId) {
    const bike = bikesData.find(b => b.id == bikeId);
    if (!bike) return;
    
    document.getElementById('modal-bike-id').value = bike.id;
    document.getElementById('modal-bike-name').value = bike.name;
    document.getElementById('modal-bike-price').value = '₹' + parseFloat(bike.price_per_day).toFixed(2);
    document.getElementById('modal-bike-price').dataset.price = bike.price_per_day;
    
    calculateTotal();
    document.getElementById('booking-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeBookingModal() {
    document.getElementById('booking-modal').style.display = 'none';
    document.body.style.overflow = 'auto';
    document.getElementById('booking-form').reset();
}

function calculateTotal() {
    const pricePerDay = parseFloat(document.getElementById('modal-bike-price').dataset.price) || 0;
    const days = parseInt(document.getElementById('days').value) || 1;
    const total = pricePerDay * days;
    document.getElementById('total-amount').textContent = '₹' + total.toFixed(2);
}

// Search functionality
document.getElementById('search-input').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const bikeCards = document.querySelectorAll('.bike-card');
    
    bikeCards.forEach(card => {
        const bikeName = card.dataset.bikeName;
        if (bikeName.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('booking-modal');
    if (event.target === modal) {
        closeBookingModal();
    }
}
</script>

<?php include 'includes/footer.php'; ?>
<?php 
$page_title = "How It Works";
include 'includes/header.php';
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1><i class="fas fa-info-circle"></i> How It Works</h1>
        <p>Renting a scooter or motorcycle has never been easier</p>
    </div>
</section>

<!-- Steps Section -->
<section class="how-it-works">
    <div class="container">
        <div class="steps-container">
            <div class="step-card">
                <div class="step-number">1</div>
                <div class="step-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3>Choose Your Ride</h3>
                <p>Browse our fleet of scooters and motorcycles. Filter by type, engine size, or price to find the perfect ride.</p>
            </div>
            
            <div class="step-arrow">
                <i class="fas fa-arrow-right"></i>
            </div>
            
            <div class="step-card">
                <div class="step-number">2</div>
                <div class="step-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h3>Book Online</h3>
                <p>Select your rental duration, fill in your details, and choose your preferred payment method. Get instant confirmation.</p>
            </div>
            
            <div class="step-arrow">
                <i class="fas fa-arrow-right"></i>
            </div>
            
            <div class="step-card">
                <div class="step-number">3</div>
                <div class="step-icon">
                    <i class="fas fa-motorcycle"></i>
                </div>
                <h3>Start Riding</h3>
                <p>Pick up your scooter or motorcycle from our location. Helmet included. Hit the road and explore!</p>
            </div>
        </div>
        
        <!-- Additional Info -->
        <div class="info-section">
            <h2>Rental Guidelines</h2>
            <div class="info-grid">
                <div class="info-card">
                    <i class="fas fa-id-card"></i>
                    <h4>Requirements</h4>
                    <ul>
                        <li>Valid driving license (2-wheeler)</li>
                        <li>Age 18 or above</li>
                        <li>Contact number</li>
                        <li>Email address</li>
                    </ul>
                </div>
                
                <div class="info-card">
                    <i class="fas fa-clock"></i>
                    <h4>Rental Period</h4>
                    <ul>
                        <li>Minimum 1 day rental</li>
                        <li>Flexible duration</li>
                        <li>Daily or weekly rates</li>
                        <li>Easy extensions</li>
                    </ul>
                </div>
                
                <div class="info-card">
                    <i class="fas fa-shield-alt"></i>
                    <h4>Safety & Insurance</h4>
                    <ul>
                        <li>All vehicles insured</li>
                        <li>Regular servicing</li>
                        <li>Helmets included</li>
                        <li>24/7 roadside assistance</li>
                    </ul>
                </div>
                
                <div class="info-card">
                    <i class="fas fa-undo"></i>
                    <h4>Return Policy</h4>
                    <ul>
                        <li>Easy return process</li>
                        <li>Multiple drop-off points</li>
                        <li>Late fees applicable</li>
                        <li>Damage assessment</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="container">
        <h2>Frequently Asked Questions</h2>
        <div class="faq-container">
            <div class="faq-item">
                <div class="faq-question">
                    <h4>What documents do I need to rent a scooter/motorcycle?</h4>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>You need a valid 2-wheeler driving license, government-issued ID, and contact details. For premium motorcycles, a security deposit may be required.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h4>How do I make a payment?</h4>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>We accept credit/debit cards, PayPal, and cash payments. Online payments are secure and processed through encrypted channels.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h4>Can I extend my rental period?</h4>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes! You can extend your rental by contacting us at least 24 hours before your return date. Extensions are subject to bike availability.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h4>What if the vehicle gets damaged?</h4>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>All rentals include basic insurance. Minor damages are covered. For major damages, repair costs will be assessed. Additional coverage available for premium motorcycles.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h4>Do you offer delivery?</h4>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes, we offer scooter/motorcycle delivery and pickup within the city for an additional fee. Contact us for delivery rates and areas covered.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// FAQ Accordion
document.querySelectorAll('.faq-question').forEach(question => {
    question.addEventListener('click', () => {
        const faqItem = question.parentElement;
        const isActive = faqItem.classList.contains('active');
        
        // Close all FAQ items
        document.querySelectorAll('.faq-item').forEach(item => {
            item.classList.remove('active');
        });
        
        // Open clicked item if it wasn't active
        if (!isActive) {
            faqItem.classList.add('active');
        }
    });
});
</script>

<?php include 'includes/footer.php'; ?>
<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!is_admin_logged_in()) {
    header('Location: index.php');
    exit;
}

$page_title = "Add New Vehicle";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean_input($_POST['name']);
    $type = clean_input($_POST['type']);
    $description = clean_input($_POST['description']);
    $gears = (int)$_POST['gears'];
    $size = clean_input($_POST['size']);
    $price_per_day = (float)$_POST['price_per_day'];
    $status = clean_input($_POST['status']);
    
    // Handle image upload
    $image = 'default-bike.jpg';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['image']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        
        if (in_array(strtolower($filetype), $allowed)) {
            $new_filename = uniqid() . '_' . $filename;
            $upload_path = '../assets/images/bikes/' . $new_filename;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                $image = $new_filename;
            }
        }
    }
    
    $sql = "INSERT INTO bikes (name, type, description, gears, size, price_per_day, image, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssissss", $name, $type, $description, $gears, $size, $price_per_day, $image, $status);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Vehicle added successfully!";
        header('Location: manage-bikes.php');
        exit;
    } else {
        $error = "Failed to add vehicle. Please try again.";
    }
}

include 'includes/admin-header.php';
?>

<div class="admin-content">
    <div class="content-header">
        <h1><i class="fas fa-plus"></i> Add New Vehicle</h1>
        <a href="manage-bikes.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Fleet
        </a>
    </div>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    
    <div class="card">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" class="admin-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Vehicle Name *</label>
                        <input type="text" id="name" name="name" placeholder="e.g. Activa 6G, Royal Enfield Classic" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="type">Type *</label>
                        <select id="type" name="type" required>
                            <option value="">Select Type</option>
                            <option value="Scooter">Scooter</option>
                            <option value="Motorcycle">Motorcycle</option>
                            <option value="Electric Scooter">Electric Scooter</option>
                            <option value="Sport Bike">Sport Bike</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea id="description" name="description" rows="4" required></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="gears">Gears *</label>
                        <input type="number" id="gears" name="gears" min="0" max="6" value="0" title="0 = Automatic/CVT (scooters), 4-6 = Manual (motorcycles)">
                        <small>0 for automatic/CVT, 4-6 for manual</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="size">Engine / Capacity *</label>
                        <select id="size" name="size" required>
                            <option value="">Select Engine</option>
                            <option value="50cc">50cc</option>
                            <option value="110cc">110cc</option>
                            <option value="125cc">125cc</option>
                            <option value="150cc">150cc</option>
                            <option value="250cc">250cc</option>
                            <option value="350cc">350cc</option>
                            <option value="500cc+">500cc+</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="price_per_day">Price Per Day (₹) *</label>
                        <input type="number" id="price_per_day" name="price_per_day" step="0.01" min="0" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="image">Vehicle Image</label>
                        <input type="file" id="image" name="image" accept="image/*">
                        <small>Accepted formats: JPG, JPEG, PNG, GIF</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="status">Status *</label>
                        <select id="status" name="status" required>
                            <option value="available">Available</option>
                            <option value="rented">Rented</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-actions">
                    <a href="manage-bikes.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Add Vehicle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
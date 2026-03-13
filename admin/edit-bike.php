<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!is_admin_logged_in()) {
    header('Location: index.php');
    exit;
}

$page_title = "Edit Vehicle";
$bike_id = (int)$_GET['id'];
$bike = get_bike_by_id($bike_id);

if (!$bike) {
    $_SESSION['error'] = "Bike not found.";
    header('Location: manage-bikes.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean_input($_POST['name']);
    $type = clean_input($_POST['type']);
    $description = clean_input($_POST['description']);
    $gears = (int)$_POST['gears'];
    $size = clean_input($_POST['size']);
    $price_per_day = (float)$_POST['price_per_day'];
    $status = clean_input($_POST['status']);
    
    // Handle image upload
    $image = $bike['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['image']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        
        if (in_array(strtolower($filetype), $allowed)) {
            $new_filename = uniqid() . '_' . $filename;
            $upload_path = '../assets/images/bikes/' . $new_filename;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                // Delete old image if not default
                if ($bike['image'] !== 'default-bike.jpg' && file_exists('../assets/images/bikes/' . $bike['image'])) {
                    unlink('../assets/images/bikes/' . $bike['image']);
                }
                $image = $new_filename;
            }
        }
    }
    
    $sql = "UPDATE bikes SET name=?, type=?, description=?, gears=?, size=?, price_per_day=?, image=?, status=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssissssi", $name, $type, $description, $gears, $size, $price_per_day, $image, $status, $bike_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Vehicle updated successfully!";
        header('Location: manage-bikes.php');
        exit;
    } else {
        $error = "Failed to update vehicle. Please try again.";
    }
}

include 'includes/admin-header.php';
?>

<div class="admin-content">
    <div class="content-header">
        <h1><i class="fas fa-edit"></i> Edit Vehicle</h1>
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
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($bike['name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="type">Type *</label>
                        <select id="type" name="type" required>
                            <option value="Scooter" <?php echo $bike['type'] === 'Scooter' ? 'selected' : ''; ?>>Scooter</option>
                            <option value="Motorcycle" <?php echo $bike['type'] === 'Motorcycle' ? 'selected' : ''; ?>>Motorcycle</option>
                            <option value="Electric Scooter" <?php echo $bike['type'] === 'Electric Scooter' ? 'selected' : ''; ?>>Electric Scooter</option>
                            <option value="Sport Bike" <?php echo $bike['type'] === 'Sport Bike' ? 'selected' : ''; ?>>Sport Bike</option>
                            <?php if (!in_array($bike['type'], ['Scooter', 'Motorcycle', 'Electric Scooter', 'Sport Bike'])): ?>
                            <option value="<?php echo htmlspecialchars($bike['type']); ?>" selected><?php echo htmlspecialchars($bike['type']); ?></option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($bike['description']); ?></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="gears">Gears *</label>
                        <input type="number" id="gears" name="gears" value="<?php echo (int)$bike['gears']; ?>" min="0" max="6" required>
                        <small>0 for automatic, 4-6 for manual</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="size">Engine / Capacity *</label>
                        <select id="size" name="size" required>
                            <option value="50cc" <?php echo $bike['size'] === '50cc' ? 'selected' : ''; ?>>50cc</option>
                            <option value="110cc" <?php echo $bike['size'] === '110cc' ? 'selected' : ''; ?>>110cc</option>
                            <option value="125cc" <?php echo $bike['size'] === '125cc' ? 'selected' : ''; ?>>125cc</option>
                            <option value="150cc" <?php echo $bike['size'] === '150cc' ? 'selected' : ''; ?>>150cc</option>
                            <option value="250cc" <?php echo $bike['size'] === '250cc' ? 'selected' : ''; ?>>250cc</option>
                            <option value="350cc" <?php echo $bike['size'] === '350cc' ? 'selected' : ''; ?>>350cc</option>
                            <option value="500cc+" <?php echo $bike['size'] === '500cc+' ? 'selected' : ''; ?>>500cc+</option>
                            <?php if (!in_array($bike['size'], ['50cc', '110cc', '125cc', '150cc', '250cc', '350cc', '500cc+'])): ?>
                            <option value="<?php echo htmlspecialchars($bike['size']); ?>" selected><?php echo htmlspecialchars($bike['size']); ?></option>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="price_per_day">Price Per Day (₹) *</label>
                        <input type="number" id="price_per_day" name="price_per_day" value="<?php echo $bike['price_per_day']; ?>" step="0.01" min="0" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="image">Vehicle Image</label>
                        <input type="file" id="image" name="image" accept="image/*">
                        <small>Current: <?php echo htmlspecialchars($bike['image']); ?></small>
                        <?php if ($bike['image']): ?>
                            <br>
                            <img src="../assets/images/bikes/<?php echo htmlspecialchars($bike['image']); ?>" 
                                 alt="Current bike image" 
                                 style="max-width: 200px; margin-top: 10px; border-radius: 8px;"
                                 onerror="this.src='../assets/images/bikes/default-bike.jpg'">
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="status">Status *</label>
                        <select id="status" name="status" required>
                            <option value="available" <?php echo $bike['status'] === 'available' ? 'selected' : ''; ?>>Available</option>
                            <option value="rented" <?php echo $bike['status'] === 'rented' ? 'selected' : ''; ?>>Rented</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-actions">
                    <a href="manage-bikes.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Vehicle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
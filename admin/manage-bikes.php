<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!is_admin_logged_in()) {
    header('Location: index.php');
    exit;
}

$page_title = "Manage Bikes";

// Get all bikes
$bikes = get_bikes(null, null);

include 'includes/admin-header.php';
?>

<div class="admin-content">
    <div class="content-header">
        <h1><i class="fas fa-bicycle"></i> Manage Bikes</h1>
        <a href="add-bike.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Bike
        </a>
    </div>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    
    <div class="card">
        <div class="card-body">
            <?php if (count($bikes) > 0): ?>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Gears</th>
                                <th>Size</th>
                                <th>Price/Day</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bikes as $bike): ?>
                                <tr>
                                    <td>#<?php echo $bike['id']; ?></td>
                                    <td>
                                        <img src="../assets/images/bikes/<?php echo htmlspecialchars($bike['image']); ?>" 
                                             alt="<?php echo htmlspecialchars($bike['name']); ?>" 
                                             class="table-img"
                                             onerror="this.src='../assets/images/bikes/default-bike.jpg'">
                                    </td>
                                    <td><?php echo htmlspecialchars($bike['name']); ?></td>
                                    <td><span class="badge badge-info"><?php echo htmlspecialchars($bike['type']); ?></span></td>
                                    <td><?php echo $bike['gears']; ?></td>
                                    <td><?php echo htmlspecialchars($bike['size']); ?></td>
                                    <td><?php echo format_currency($bike['price_per_day']); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo $bike['status']; ?>">
                                            <?php echo ucfirst($bike['status']); ?>
                                        </span>
                                    </td>
                                    <td class="actions">
                                        <a href="edit-bike.php?id=<?php echo $bike['id']; ?>" class="btn-action btn-edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete-bike.php?id=<?php echo $bike['id']; ?>" class="btn-action btn-delete delete-btn" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="no-data">No bikes found. <a href="add-bike.php">Add your first bike</a></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
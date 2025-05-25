<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';
require_once '../includes/db.php';

// Check if user is logged in and has admin access
// checkAdminAccess();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_slider'])) {
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $buttonText = $_POST['button_text'] ?? 'Read More';
        $buttonLink = $_POST['button_link'] ?? '#';
        $displayOrder = $_POST['display_order'] ?? 0;
        
        // Handle file upload
        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $targetDir = SLIDER_UPLOAD_PATH;
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetFile = $targetDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $imagePath = 'uploads/sliders/' . $fileName;
            }
        }
        
        // Insert into database
        $db->query(
            "INSERT INTO sliders (image_path, title, description, button_text, button_link, display_order) VALUES (?, ?, ?, ?, ?, ?)",
            [$imagePath, $title, $description, $buttonText, $buttonLink, $displayOrder]
        );
        
        $_SESSION['message'] = 'Slider added successfully!';
        header('Location: sliders.php');
        exit;
    } elseif (isset($_POST['update_slider'])) {
        $id = $_POST['id'] ?? 0;
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $buttonText = $_POST['button_text'] ?? 'Read More';
        $buttonLink = $_POST['button_link'] ?? '#';
        $displayOrder = $_POST['display_order'] ?? 0;
        
        // Get current slider data
        $slider = $db->fetchOne("SELECT * FROM sliders WHERE id = ?", [$id]);
        
        // Handle file upload
        $imagePath = $slider['image_path'];
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $targetDir = SLIDER_UPLOAD_PATH;
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetFile = $targetDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                // Delete old image if exists
                if ($imagePath && file_exists("../$imagePath")) {
                    unlink("../$imagePath");
                }
                $imagePath = 'uploads/sliders/' . $fileName;
            }
        }
        
        // Update database
        $db->query(
            "UPDATE sliders SET image_path = ?, title = ?, description = ?, button_text = ?, button_link = ?, display_order = ? WHERE id = ?",
            [$imagePath, $title, $description, $buttonText, $buttonLink, $displayOrder, $id]
        );
        
        $_SESSION['message'] = 'Slider updated successfully!';
        header('Location: sliders.php');
        exit;
    }
}

// Handle delete action
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    // Get slider data first to delete the image
    $slider = $db->fetchOne("SELECT * FROM sliders WHERE id = ?", [$id]);
    
    if ($slider) {
        // Delete image file if exists
        if ($slider['image_path'] && file_exists("../{$slider['image_path']}")) {
            unlink("../{$slider['image_path']}");
        }
        
        // Delete from database
        $db->query("DELETE FROM sliders WHERE id = ?", [$id]);
        
        $_SESSION['message'] = 'Slider deleted successfully!';
        header('Location: sliders.php');
        exit;
    }
}

// Handle toggle status action
if (isset($_GET['toggle_status'])) {
    $id = $_GET['toggle_status'];
    $slider = $db->fetchOne("SELECT * FROM sliders WHERE id = ?", [$id]);
    
    if ($slider) {
        $newStatus = $slider['is_active'] ? 0 : 1;
        $db->query("UPDATE sliders SET is_active = ? WHERE id = ?", [$newStatus, $id]);
        
        $_SESSION['message'] = 'Slider status updated!';
        header('Location: sliders.php');
        exit;
    }
}

// Get all sliders
$sliders = $db->fetchAll("SELECT * FROM sliders ORDER BY display_order");

// Get slider to edit if edit_id is set
$editSlider = null;
if (isset($_GET['edit_id'])) {
    $editId = $_GET['edit_id'];
    $editSlider = $db->fetchOne("SELECT * FROM sliders WHERE id = ?", [$editId]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sliders - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <!-- <?php include '../includes/header.php'; ?> -->
    
    <div class="container-fluid">
        <div class="row">
            <?php include '../includes/sidebar.php'; ?>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Manage Sliders</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="sliders.php?action=add" class="btn btn-success">
                            <i class="bi bi-plus-lg"></i> Add Slider
                        </a>
                    </div>
                </div>
                
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-info"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
                <?php endif; ?>
                
                <?php if ((isset($_GET['action']) && $_GET['action'] === 'add') || $editSlider): ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5><?php echo $editSlider ? 'Edit Slider' : 'Add New Slider'; ?></h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <?php if ($editSlider): ?>
                                    <input type="hidden" name="id" value="<?php echo $editSlider['id']; ?>">
                                <?php endif; ?>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Slider Image</label>
                                    <input type="file" class="form-control" id="image" name="image" <?php echo !$editSlider ? 'required' : ''; ?>>
                                    <?php if ($editSlider && $editSlider['image_path']): ?>
                                        <div class="mt-2">
                                            <img src="../<?php echo htmlspecialchars($editSlider['image_path']); ?>" style="max-height: 100px;">
                                            <p class="small text-muted mt-1">Current image</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title (Optional)</label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                        value="<?php echo $editSlider ? htmlspecialchars($editSlider['title']) : ''; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" required><?php 
                                        echo $editSlider ? htmlspecialchars($editSlider['description']) : ''; 
                                    ?></textarea>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="button_text" class="form-label">Button Text</label>
                                        <input type="text" class="form-control" id="button_text" name="button_text" 
                                            value="<?php echo $editSlider ? htmlspecialchars($editSlider['button_text']) : 'Read More'; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="button_link" class="form-label">Button Link</label>
                                        <input type="text" class="form-control" id="button_link" name="button_link" 
                                            value="<?php echo $editSlider ? htmlspecialchars($editSlider['button_link']) : '#'; ?>">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="display_order" class="form-label">Display Order</label>
                                    <input type="number" class="form-control" id="display_order" name="display_order" 
                                        value="<?php echo $editSlider ? htmlspecialchars($editSlider['display_order']) : '0'; ?>">
                                </div>
                                <button type="submit" name="<?php echo $editSlider ? 'update_slider' : 'add_slider'; ?>" class="btn btn-primary">
                                    <?php echo $editSlider ? 'Update Slider' : 'Add Slider'; ?>
                                </button>
                                <a href="sliders.php" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="card">
                    <div class="card-header">
                        <h5>Existing Sliders</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Description</th>
                                        <th>Button</th>
                                        <th>Order</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($sliders as $slider): ?>
                                    <tr>
                                        <td><img src="../<?php echo htmlspecialchars($slider['image_path']); ?>" style="max-width: 100px;"></td>
                                        <td><?php echo htmlspecialchars($slider['description']); ?></td>
                                        <td><?php echo htmlspecialchars($slider['button_text']); ?></td>
                                        <td><?php echo htmlspecialchars($slider['display_order']); ?></td>
                                        <td>
                                            <a href="sliders.php?toggle_status=<?php echo $slider['id']; ?>" class="btn btn-sm btn-<?php echo $slider['is_active'] ? 'success' : 'secondary'; ?>">
                                                <?php echo $slider['is_active'] ? 'Active' : 'Inactive'; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="sliders.php?edit_id=<?php echo $slider['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="sliders.php?delete=<?php echo $slider['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this slider?')">Delete</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
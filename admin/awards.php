<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';
require_once '../includes/db.php';

// checkAdminAccess();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_award'])) {
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        
        // Handle file upload
        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $targetDir = AWARD_UPLOAD_PATH;
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetFile = $targetDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $imagePath = 'uploads/awards/' . $fileName;
            }
        }
        
        // Insert into database
        $db->query(
            "INSERT INTO awards (name, image_path, description) VALUES (?, ?, ?)",
            [$name, $imagePath, $description]
        );
        
        $_SESSION['message'] = 'Award added successfully!';
        header('Location: awards.php');
        exit;
    } elseif (isset($_POST['update_award'])) {
        $id = $_POST['id'] ?? 0;
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $currentImage = $_POST['current_image'] ?? '';
        
        $imagePath = $currentImage;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $targetDir = AWARD_UPLOAD_PATH;
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetFile = $targetDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $imagePath = 'uploads/awards/' . $fileName;
                // Delete old image if it exists
                if (!empty($currentImage)) {
                    @unlink('../' . $currentImage);
                }
            }
        }
        
        $db->query(
            "UPDATE awards SET name = ?, image_path = ?, description = ? WHERE id = ?",
            [$name, $imagePath, $description, $id]
        );
        
        $_SESSION['message'] = 'Award updated successfully!';
        header('Location: awards.php');
        exit;
    }
}

// Handle delete action
if (isset($_GET['delete'])) {
    $id = $_GET['id'] ?? 0;
    
    // Get award data to delete image
    $award = $db->fetchOne("SELECT * FROM awards WHERE id = ?", [$id]);
    if ($award && !empty($award['image_path'])) {
        @unlink('../' . $award['image_path']);
    }
    
    $db->query("DELETE FROM awards WHERE id = ?", [$id]);
    
    $_SESSION['message'] = 'Award deleted successfully!';
    header('Location: awards.php');
    exit;
}

// Get all awards
$awards = $db->fetchAll("SELECT * FROM awards ORDER BY name");

// Get award for editing if edit_id is set
$editAward = null;
if (isset($_GET['edit_id'])) {
    $editAward = $db->fetchOne("SELECT * FROM awards WHERE id = ?", [$_GET['edit_id']]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Awards - Admin Panel</title>
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
                    <h1 class="h2">Manage Awards</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="awards.php" class="btn btn-success">
                            <i class="bi bi-plus-lg"></i> Add Award
                        </a>
                    </div>
                </div>
                
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-info"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
                <?php endif; ?>
                
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><?php echo isset($editAward) ? 'Edit Award' : 'Add New Award'; ?></h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <?php if (isset($editAward)): ?>
                                <input type="hidden" name="id" value="<?php echo $editAward['id']; ?>">
                                <input type="hidden" name="current_image" value="<?php echo $editAward['image_path']; ?>">
                            <?php endif; ?>
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Award Name</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                    value="<?php echo isset($editAward) ? htmlspecialchars($editAward['name']) : ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Award Image</label>
                                <input type="file" class="form-control" id="image" name="image" <?php echo !isset($editAward) ? 'required' : ''; ?>>
                                <?php if (isset($editAward) && !empty($editAward['image_path'])): ?>
                                    <div class="mt-2">
                                        <img src="../<?php echo htmlspecialchars($editAward['image_path']); ?>" style="max-height: 100px;">
                                        <p class="small text-muted mt-1">Current image</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"><?php echo isset($editAward) ? htmlspecialchars($editAward['description']) : ''; ?></textarea>
                            </div>
                            <?php if (isset($editAward)): ?>
                                <button type="submit" name="update_award" class="btn btn-primary">Update Award</button>
                                <a href="awards.php" class="btn btn-secondary">Cancel</a>
                            <?php else: ?>
                                <button type="submit" name="add_award" class="btn btn-primary">Add Award</button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h5>Existing Awards</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($awards as $award): ?>
                            <div class="col-md-3 mb-4">
                                <div class="card h-100">
                                    <img src="../<?php echo htmlspecialchars($award['image_path']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($award['name']); ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($award['name']); ?></h5>
                                        <p class="card-text"><?php echo htmlspecialchars(substr($award['description'], 0, 100)); ?>...</p>
                                    </div>
                                    <div class="card-footer bg-transparent">
                                        <a href="awards.php?edit_id=<?php echo $award['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="awards.php?delete=1&id=<?php echo $award['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this award?')">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
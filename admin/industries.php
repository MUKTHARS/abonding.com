<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';
require_once '../includes/db.php';

// checkAdminAccess();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_industry'])) {
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        
        // Handle file upload
        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $targetDir = INDUSTRY_UPLOAD_PATH;
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetFile = $targetDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $imagePath = 'uploads/industries/' . $fileName;
            }
        }
        
        // Insert into database
        $db->query(
            "INSERT INTO industries (name, image_path, description) VALUES (?, ?, ?)",
            [$name, $imagePath, $description]
        );
        
        $_SESSION['message'] = 'Industry added successfully!';
        header('Location: industries.php');
        exit;
    } elseif (isset($_POST['update_industry'])) {
        $id = $_POST['id'] ?? 0;
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $currentImage = $_POST['current_image'] ?? '';
        
        $imagePath = $currentImage;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $targetDir = INDUSTRY_UPLOAD_PATH;
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetFile = $targetDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $imagePath = 'uploads/industries/' . $fileName;
                // Delete old image if it exists
                if (!empty($currentImage)) {
                    @unlink('../' . $currentImage);
                }
            }
        }
        
        $db->query(
            "UPDATE industries SET name = ?, image_path = ?, description = ? WHERE id = ?",
            [$name, $imagePath, $description, $id]
        );
        
        $_SESSION['message'] = 'Industry updated successfully!';
        header('Location: industries.php');
        exit;
    }
}

// Handle delete action
if (isset($_GET['delete'])) {
    $id = $_GET['id'] ?? 0;
    
    // Get industry data to delete image
    $industry = $db->fetchOne("SELECT * FROM industries WHERE id = ?", [$id]);
    if ($industry && !empty($industry['image_path'])) {
        @unlink('../' . $industry['image_path']);
    }
    
    $db->query("DELETE FROM industries WHERE id = ?", [$id]);
    
    $_SESSION['message'] = 'Industry deleted successfully!';
    header('Location: industries.php');
    exit;
}

// Get all industries
$industries = $db->fetchAll("SELECT * FROM industries ORDER BY name");

// Get industry for editing if edit_id is set
$editIndustry = null;
if (isset($_GET['edit_id'])) {
    $editIndustry = $db->fetchOne("SELECT * FROM industries WHERE id = ?", [$_GET['edit_id']]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Industries - Admin Panel</title>
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
                    <h1 class="h2">Manage Industries</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="industries.php" class="btn btn-success">
                            <i class="bi bi-plus-lg"></i> Add Industry
                        </a>
                    </div>
                </div>
                
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-info"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
                <?php endif; ?>
                
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><?php echo isset($editIndustry) ? 'Edit Industry' : 'Add New Industry'; ?></h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <?php if (isset($editIndustry)): ?>
                                <input type="hidden" name="id" value="<?php echo $editIndustry['id']; ?>">
                                <input type="hidden" name="current_image" value="<?php echo $editIndustry['image_path']; ?>">
                            <?php endif; ?>
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Industry Name</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                    value="<?php echo isset($editIndustry) ? htmlspecialchars($editIndustry['name']) : ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Industry Image</label>
                                <input type="file" class="form-control" id="image" name="image">
                                <?php if (isset($editIndustry) && !empty($editIndustry['image_path'])): ?>
                                    <div class="mt-2">
                                        <img src="../<?php echo htmlspecialchars($editIndustry['image_path']); ?>" style="max-height: 100px;">
                                        <p class="small text-muted mt-1">Current image</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"><?php echo isset($editIndustry) ? htmlspecialchars($editIndustry['description']) : ''; ?></textarea>
                            </div>
                            <?php if (isset($editIndustry)): ?>
                                <button type="submit" name="update_industry" class="btn btn-primary">Update Industry</button>
                                <a href="industries.php" class="btn btn-secondary">Cancel</a>
                            <?php else: ?>
                                <button type="submit" name="add_industry" class="btn btn-primary">Add Industry</button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h5>Existing Industries</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($industries as $industry): ?>
                                    <tr>
                                        <td>
                                            <?php if ($industry['image_path']): ?>
                                                <img src="../<?php echo htmlspecialchars($industry['image_path']); ?>" style="max-width: 80px;">
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($industry['name']); ?></td>
                                        <td><?php echo htmlspecialchars(substr($industry['description'], 0, 50)); ?>...</td>
                                        <td>
                                            <a href="industries.php?edit_id=<?php echo $industry['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="industries.php?delete=1&id=<?php echo $industry['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this industry?')">Delete</a>
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
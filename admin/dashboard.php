<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';
require_once '../includes/db.php';

// checkAdminAccess();
// Get counts for dashboard
$sliderCount = $db->fetchOne("SELECT COUNT(*) as count FROM sliders")['count'];
$productCount = $db->fetchOne("SELECT COUNT(*) as count FROM products")['count'];
$industryCount = $db->fetchOne("SELECT COUNT(*) as count FROM industries")['count'];
$awardCount = $db->fetchOne("SELECT COUNT(*) as count FROM awards")['count'];
$contactCount = $db->fetchOne("SELECT COUNT(*) as count FROM contacts")['count'];
$unreadContactCount = $db->fetchOne("SELECT COUNT(*) as count FROM contacts WHERE is_read = 0")['count'];

// Get all product categories
$productCategories = $db->fetchAll("SELECT * FROM product_categories ORDER BY name");

// Get recent contact submissions
$recentContacts = $db->fetchAll("SELECT * FROM contacts ORDER BY created_at DESC LIMIT 5");
// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add new category
    if (isset($_POST['add_category'])) {
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        
        // Handle file upload
        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $targetDir = '../uploads/product_categories/';
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetFile = $targetDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $imagePath = 'uploads/product_categories/' . $fileName;
            }
        }
        
        // Insert into database
        $db->query(
            "INSERT INTO product_categories (name, image_path, description, is_active) VALUES (?, ?, ?, 1)",
            [$name, $imagePath, $description]
        );
        
        $_SESSION['message'] = 'Product category added successfully!';
        header('Location: dashboard.php');
        exit;
    }
    
    // Update existing category
    if (isset($_POST['update_category'])) {
        $id = $_POST['id'] ?? 0;
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        
        // Handle file upload if new image provided
  $updateFields = [
    'name' => $_POST['name'] ?? '',
    'description' => $_POST['description'] ?? '',
    'applications' => $_POST['applications'] ?? '',
    'benefits' => $_POST['benefits'] ?? '',
    'manufacturer' => $_POST['manufacturer'] ?? ''
];
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $targetDir = '../uploads/product_categories/';
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetFile = $targetDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $updateFields['image_path'] = 'uploads/product_categories/' . $fileName;
                
                // Delete old image if exists
                $oldImage = $db->fetchOne("SELECT image_path FROM product_categories WHERE id = ?", [$id]);
                if ($oldImage && $oldImage['image_path'] && file_exists('../' . $oldImage['image_path'])) {
                    unlink('../' . $oldImage['image_path']);
                }
            }
        }
        
        // Build update query
        $setParts = [];
        $params = [];
        foreach ($updateFields as $field => $value) {
            $setParts[] = "$field = ?";
            $params[] = $value;
        }
        $params[] = $id;
        
        $setClause = implode(', ', $setParts);
        $db->query("UPDATE product_categories SET $setClause WHERE id = ?", $params);
        
        $_SESSION['message'] = 'Product category updated successfully!';
        header('Location: dashboard.php');
        exit;
    }
    
    // Delete category
    if (isset($_POST['delete_category'])) {
        $id = $_POST['id'] ?? 0;
        
        // Get image path before deleting
        $category = $db->fetchOne("SELECT image_path FROM product_categories WHERE id = ?", [$id]);
        
        // Delete from database
        $db->query("DELETE FROM product_categories WHERE id = ?", [$id]);
        
        // Delete image file if exists
        if ($category && $category['image_path'] && file_exists('../' . $category['image_path'])) {
            unlink('../' . $category['image_path']);
        }
        
        $_SESSION['message'] = 'Product category deleted successfully!';
        header('Location: dashboard.php');
        exit;
    }
}
// $applications = $_POST['applications'] ?? '';
// $benefits = $_POST['benefits'] ?? '';
// $manufacturer = $_POST['manufacturer'] ?? '';

// $db->query(
//     "INSERT INTO product_categories (name, image_path, description, applications, benefits, manufacturer, is_active) 
//     VALUES (?, ?, ?, ?, ?, ?, 1)",
//     [$name, $imagePath, $description, $_POST['applications'] ?? '', $_POST['benefits'] ?? '', $_POST['manufacturer'] ?? '']
// );

// // In the update_category section
// $updateFields = [
//     'name' => $_POST['name'] ?? '',
//     'description' => $_POST['description'] ?? '',
//     'applications' => $_POST['applications'] ?? '',
//     'benefits' => $_POST['benefits'] ?? '',
//     'manufacturer' => $_POST['manufacturer'] ?? ''
// ];


// Get counts for dashboard
$sliderCount = $db->fetchOne("SELECT COUNT(*) as count FROM sliders")['count'];
$productCount = $db->fetchOne("SELECT COUNT(*) as count FROM products")['count'];
$industryCount = $db->fetchOne("SELECT COUNT(*) as count FROM industries")['count'];
$awardCount = $db->fetchOne("SELECT COUNT(*) as count FROM awards")['count'];

// Get all product categories
$productCategories = $db->fetchAll("SELECT * FROM product_categories ORDER BY name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        .edit-form {
            display: none;
            margin-top: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .category-card {
            position: relative;
            transition: all 0.3s ease;
        }
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- <?php include '../includes/header.php'; ?> -->
    
    <div class="container-fluid">
        <div class="row">
            <?php include '../includes/sidebar.php'; ?>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <h1 class="h2 mb-4">Dashboard</h1>
                
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-info"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
                <?php endif; ?>
                
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Sliders</h5>
                                <h2><?php echo $sliderCount; ?></h2>
                                <a href="sliders.php" class="text-white">Manage <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">Products</h5>
                                <h2><?php echo $productCount; ?></h2>
                                <a href="products.php" class="text-white">Manage <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title">Industries</h5>
                                <h2><?php echo $industryCount; ?></h2>
                                <a href="industries.php" class="text-white">Manage <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-dark">
                            <div class="card-body">
                                <h5 class="card-title">Awards</h5>
                                <h2><?php echo $awardCount; ?></h2>
                                <a href="awards.php" class="text-dark">Manage <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
    <div class="card bg-danger text-white">
        <div class="card-body">
            <h5 class="card-title">Contacts</h5>
            <h2><?php echo $contactCount; ?></h2>
            <small><?php echo $unreadContactCount; ?> unread</small>
            <a href="contacts.php" class="text-white">Manage <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</div>
                </div>
                
                <!-- Add Product Category Form -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Add Product Category</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="name" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Category Image</label>
                                <input type="file" class="form-control" id="image" name="image" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
    <label for="applications" class="form-label">Applications</label>
    <textarea class="form-control" id="applications" name="applications" rows="3"></textarea>
</div>
<div class="mb-3">
    <label for="benefits" class="form-label">Benefits</label>
    <textarea class="form-control" id="benefits" name="benefits" rows="3"></textarea>
</div>
<div class="mb-3">
    <label for="manufacturer" class="form-label">Manufacturer</label>
    <input type="text" class="form-control" id="manufacturer" name="manufacturer">
</div>
                            
                            <button type="submit" name="add_category" class="btn btn-primary">Add Category</button>
                        </form>
                    </div>
                </div>
                
                <!-- Existing Product Categories -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Existing Product Categories</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($productCategories as $category): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card category-card h-100" id="category-<?php echo $category['id']; ?>">
                                    <img src="../<?php echo htmlspecialchars($category['image_path']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($category['name']); ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($category['name']); ?></h5>
                                        <p class="card-text"><?php echo htmlspecialchars(substr($category['description'], 0, 100)); ?>...</p>
                                        
                                        <div class="d-flex justify-content-between">
                                            <button class="btn btn-sm btn-warning edit-toggle" data-id="<?php echo $category['id']; ?>">Edit</button>
                                            <button class="btn btn-sm btn-danger delete-btn" data-id="<?php echo $category['id']; ?>">Delete</button>
                                        </div>
                                        
                                        <!-- Edit Form (hidden by default) -->
                                        <div class="edit-form" id="edit-form-<?php echo $category['id']; ?>">
                                            <form method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                                                <div class="mb-2">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" class="form-control form-control-sm" name="name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Image</label>
                                                    <input type="file" class="form-control form-control-sm" name="image">
                                                    <small class="text-muted">Current: <?php echo basename($category['image_path']); ?></small>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Description</label>
                                                    <textarea class="form-control form-control-sm" name="description" rows="3" required><?php echo htmlspecialchars($category['description']); ?></textarea>
                                                </div>
                                                <div class="mb-2">
    <label class="form-label">Applications</label>
    <textarea class="form-control form-control-sm" name="applications" rows="3"><?php echo htmlspecialchars($category['applications'] ?? ''); ?></textarea>
</div>
<div class="mb-2">
    <label class="form-label">Benefits</label>
    <textarea class="form-control form-control-sm" name="benefits" rows="3"><?php echo htmlspecialchars($category['benefits'] ?? ''); ?></textarea>
</div>
<div class="mb-2">
    <label class="form-label">Manufacturer</label>
    <input type="text" class="form-control form-control-sm" name="manufacturer" value="<?php echo htmlspecialchars($category['manufacturer'] ?? ''); ?>">
</div>
                                                <div class="d-flex justify-content-between">
                                                    <button type="submit" name="update_category" class="btn btn-sm btn-success">Update</button>
                                                    <button type="button" class="btn btn-sm btn-secondary cancel-edit" data-id="<?php echo $category['id']; ?>">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
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
    <script>
        // Toggle edit forms
        document.querySelectorAll('.edit-toggle').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById(`edit-form-${id}`).style.display = 'block';
                this.style.display = 'none';
            });
        });
        
        // Cancel edit
        document.querySelectorAll('.cancel-edit').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById(`edit-form-${id}`).style.display = 'none';
                document.querySelector(`#category-${id} .edit-toggle`).style.display = 'block';
            });
        });
        
        // Delete confirmation
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Are you sure you want to delete this category?')) {
                    const id = this.getAttribute('data-id');
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '';
                    
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'id';
                    input.value = id;
                    
                    const deleteInput = document.createElement('input');
                    deleteInput.type = 'hidden';
                    deleteInput.name = 'delete_category';
                    deleteInput.value = '1';
                    
                    form.appendChild(input);
                    form.appendChild(deleteInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    </script>
</body>
</html>
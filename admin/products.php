<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';
require_once '../includes/db.php';

// checkAdminAccess();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        $categoryId = $_POST['category_id'] ?? null;
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $link = $_POST['link'] ?? '';
        
        // Handle file upload
        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            require_once '../includes/upload_handler.php';
            $uploadResult = handleUpload($_FILES['image'], 'product');
            
            if ($uploadResult['success']) {
                $imagePath = $uploadResult['file_path'];
            } else {
                $_SESSION['error'] = $uploadResult['error'];
                header('Location: products.php?action=add');
                exit;
            }
        }
        
        // Insert into database
        $db->query(
            "INSERT INTO products (category_id, name, image_path, description, link) VALUES (?, ?, ?, ?, ?)",
            [$categoryId, $name, $imagePath, $description, $link]
        );
        
        $_SESSION['message'] = 'Product added successfully!';
        header('Location: products.php');
        exit;
    } elseif (isset($_POST['update_product'])) {
        $id = $_POST['id'] ?? 0;
        $categoryId = $_POST['category_id'] ?? null;
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $link = $_POST['link'] ?? '';
        
        // Get current product data
        $product = $db->fetchOne("SELECT * FROM products WHERE id = ?", [$id]);
        
        // Handle file upload
        $imagePath = $product['image_path'];
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            require_once '../includes/upload_handler.php';
            $uploadResult = handleUpload($_FILES['image'], 'product');
            
            if ($uploadResult['success']) {
                // Delete old image if exists
                if ($imagePath && file_exists("../$imagePath")) {
                    unlink("../$imagePath");
                }
                $imagePath = $uploadResult['file_path'];
            } else {
                $_SESSION['error'] = $uploadResult['error'];
                header('Location: products.php?edit_id=' . $id);
                exit;
            }
        }
        
        // Update database
        $db->query(
            "UPDATE products SET category_id = ?, name = ?, image_path = ?, description = ?, link = ? WHERE id = ?",
            [$categoryId, $name, $imagePath, $description, $link, $id]
        );
        
        $_SESSION['message'] = 'Product updated successfully!';
        header('Location: products.php');
        exit;
    }
}

// Handle delete action
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    // Get product data first to delete the image
    $product = $db->fetchOne("SELECT * FROM products WHERE id = ?", [$id]);
    
    if ($product) {
        // Delete image file if exists
        if ($product['image_path'] && file_exists("../{$product['image_path']}")) {
            unlink("../{$product['image_path']}");
        }
        
        // Delete from database
        $db->query("DELETE FROM products WHERE id = ?", [$id]);
        
        $_SESSION['message'] = 'Product deleted successfully!';
        header('Location: products.php');
        exit;
    }
}

// Get all products with category names
$products = $db->fetchAll("
    SELECT p.*, c.name as category_name 
    FROM products p
    LEFT JOIN product_categories c ON p.category_id = c.id
    ORDER BY p.name
");

// Get all categories for dropdown
$categories = $db->fetchAll("SELECT * FROM product_categories ORDER BY name");

// Get product to edit if edit_id is set
$editProduct = null;
if (isset($_GET['edit_id'])) {
    $editId = $_GET['edit_id'];
    $editProduct = $db->fetchOne("SELECT * FROM products WHERE id = ?", [$editId]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Admin Panel</title>
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
                    <h1 class="h2">Manage Products</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="products.php?action=add" class="btn btn-success">
                            <i class="bi bi-plus-lg"></i> Add Product
                        </a>
                    </div>
                </div>
                
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-info"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>
                
                <?php if ((isset($_GET['action']) && $_GET['action'] === 'add') || $editProduct): ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5><?php echo $editProduct ? 'Edit Product' : 'Add New Product'; ?></h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <?php if ($editProduct): ?>
                                    <input type="hidden" name="id" value="<?php echo $editProduct['id']; ?>">
                                <?php endif; ?>
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select class="form-select" id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo $category['id']; ?>" <?php 
                                                echo ($editProduct && $editProduct['category_id'] == $category['id']) ? 'selected' : ''; 
                                            ?>>
                                                <?php echo htmlspecialchars($category['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                        value="<?php echo $editProduct ? htmlspecialchars($editProduct['name']) : ''; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Product Image</label>
                                    <input type="file" class="form-control" id="image" name="image" <?php echo !$editProduct ? 'required' : ''; ?>>
                                    <?php if ($editProduct && $editProduct['image_path']): ?>
                                        <div class="mt-2">
                                            <img src="../<?php echo htmlspecialchars($editProduct['image_path']); ?>" style="max-height: 100px;">
                                            <p class="small text-muted mt-1">Current image</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" required><?php 
                                        echo $editProduct ? htmlspecialchars($editProduct['description']) : ''; 
                                    ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="link" class="form-label">Link</label>
                                    <input type="text" class="form-control" id="link" name="link" 
                                        value="<?php echo $editProduct ? htmlspecialchars($editProduct['link']) : ''; ?>">
                                </div>
                                <button type="submit" name="<?php echo $editProduct ? 'update_product' : 'add_product'; ?>" class="btn btn-primary">
                                    <?php echo $editProduct ? 'Update Product' : 'Add Product'; ?>
                                </button>
                                <a href="products.php" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="card">
                    <div class="card-header">
                        <h5>Existing Products</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td>
                                            <?php if ($product['image_path']): ?>
                                                <img src="../<?php echo htmlspecialchars($product['image_path']); ?>" style="max-width: 80px;">
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                                        <td><?php echo htmlspecialchars($product['category_name'] ?? 'Uncategorized'); ?></td>
                                        <td><?php echo htmlspecialchars(substr($product['description'], 0, 50)); ?>...</td>
                                        <td>
                                            <a href="products.php?edit_id=<?php echo $product['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="products.php?delete=<?php echo $product['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
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
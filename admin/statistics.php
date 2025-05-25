<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';
require_once '../includes/db.php';

// checkAdminAccess();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_statistic'])) {
        $name = $_POST['name'] ?? '';
        $value = $_POST['value'] ?? '';
        $description = $_POST['description'] ?? '';
        
        // Insert into database
        $db->query(
            "INSERT INTO statistics (name, value, description) VALUES (?, ?, ?)",
            [$name, $value, $description]
        );
        
        $_SESSION['message'] = 'Statistic added successfully!';
        header('Location: statistics.php');
        exit;
    }
}

// Get all statistics
$statistics = $db->fetchAll("SELECT * FROM statistics ORDER BY id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Statistics - Admin Panel</title>
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
                    <h1 class="h2">Manage Statistics</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="statistics.php?action=add" class="btn btn-success">
                            <i class="bi bi-plus-lg"></i> Add Statistic
                        </a>
                    </div>
                </div>
                
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-info"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
                <?php endif; ?>
                
                <?php if (isset($_GET['action']) && $_GET['action'] === 'add'): ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Add New Statistic</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Statistic Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="value" class="form-label">Value</label>
                                    <input type="text" class="form-control" id="value" name="value" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <input type="text" class="form-control" id="description" name="description">
                                </div>
                                <button type="submit" name="add_statistic" class="btn btn-primary">Add Statistic</button>
                                <a href="statistics.php" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="card">
                    <div class="card-header">
                        <h5>Existing Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Value</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($statistics as $stat): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($stat['name']); ?></td>
                                        <td><?php echo htmlspecialchars($stat['value']); ?></td>
                                        <td><?php echo htmlspecialchars($stat['description']); ?></td>
                                        <td>
                                            <a href="edit-statistic.php?id=<?php echo $stat['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="delete-statistic.php?id=<?php echo $stat['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
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
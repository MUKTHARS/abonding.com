<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';
require_once '../includes/db.php';

// checkAdminAccess();

// Get current settings
$settings = $db->fetchOne("SELECT * FROM site_settings LIMIT 1");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $siteName = $_POST['site_name'] ?? '';
    $copyright = $_POST['copyright'] ?? '';
    $whatsapp = $_POST['contact_whatsapp'] ?? '';
    $phone = $_POST['contact_phone'] ?? '';
    $industriesDesc = $_POST['industries_description'] ?? '';
    
    // Handle logo upload
    $logoPath = $settings['logo_path'] ?? '';
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $targetDir = UPLOAD_PATH;
        $fileName = uniqid() . '_' . basename($_FILES['logo']['name']);
        $targetFile = $targetDir . $fileName;
        
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $targetFile)) {
            $logoPath = 'uploads/' . $fileName;
            
            // Delete old logo if it exists
            if (!empty($settings['logo_path'])) {
                @unlink('../' . $settings['logo_path']);
            }
        }
    }
    
    if ($settings) {
        // Update existing settings
        $db->query(
            "UPDATE site_settings SET 
                site_name = ?, 
                logo_path = ?, 
                footer_copyright = ?, 
                contact_whatsapp = ?, 
                contact_phone = ?,
                industries_description = ? 
            WHERE id = ?",
            [$siteName, $logoPath, $copyright, $whatsapp, $phone, $industriesDesc, $settings['id']]
        );
    } else {
        // Insert new settings
        $db->query(
            "INSERT INTO site_settings 
                (site_name, logo_path, footer_copyright, contact_whatsapp, contact_phone, industries_description) 
            VALUES (?, ?, ?, ?, ?, ?)",
            [$siteName, $logoPath, $copyright, $whatsapp, $phone, $industriesDesc]
        );
    }
    
    $_SESSION['message'] = 'Settings updated successfully!';
    header('Location: settings.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Settings - Admin Panel</title>
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
                    <h1 class="h2">Site Settings</h1>
                </div>
                
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-info"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
                <?php endif; ?>
                
                <div class="card">
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="site_name" class="form-label">Site Name</label>
                                <input type="text" class="form-control" id="site_name" name="site_name" 
                                    value="<?php echo htmlspecialchars($settings['site_name'] ?? 'Abonding'); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="logo" class="form-label">Logo</label>
                                <input type="file" class="form-control" id="logo" name="logo">
                                <?php if (!empty($settings['logo_path'])): ?>
                                    <div class="mt-2">
                                        <img src="../<?php echo htmlspecialchars($settings['logo_path']); ?>" style="max-height: 50px;">
                                        <p class="small text-muted mt-1">Current logo</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-3">
                                <label for="copyright" class="form-label">Copyright Text</label>
                                <input type="text" class="form-control" id="copyright" name="copyright" 
                                    value="<?php echo htmlspecialchars($settings['footer_copyright'] ?? 'Copyright 2024'); ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="contact_whatsapp" class="form-label">WhatsApp Number</label>
                                <input type="text" class="form-control" id="contact_whatsapp" name="contact_whatsapp" 
                                    value="<?php echo htmlspecialchars($settings['contact_whatsapp'] ?? '+919442576397'); ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="contact_phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="contact_phone" name="contact_phone" 
                                    value="<?php echo htmlspecialchars($settings['contact_phone'] ?? '+919442576397'); ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="industries_description" class="form-label">Industries Description</label>
                                <textarea class="form-control" id="industries_description" name="industries_description" rows="5"><?php echo htmlspecialchars($settings['industries_description'] ?? 'Default industries description'); ?></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
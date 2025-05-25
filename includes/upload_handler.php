<?php
require_once 'config.php';
require_once 'functions.php';

function handleUpload($file, $uploadType) {
    // Define allowed file types
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $maxSize = 5 * 1024 * 1024; // 5MB
    
    // Validate file
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'File upload error: ' . $file['error']];
    }
    
    // Check file size
    if ($file['size'] > $maxSize) {
        return ['success' => false, 'error' => 'File size exceeds 5MB limit'];
    }
    
    // Get file extension
    $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    // Validate file type
    if (!in_array($fileExt, $allowedTypes)) {
        return ['success' => false, 'error' => 'Invalid file type. Allowed: ' . implode(', ', $allowedTypes)];
    }
    
    // Determine upload directory based on type
    $uploadDirs = [
        'slider' => SLIDER_UPLOAD_PATH,
        'product' => PRODUCT_UPLOAD_PATH,
        'award' => AWARD_UPLOAD_PATH,
        'industry' => INDUSTRY_UPLOAD_PATH,
        'team' => TEAM_UPLOAD_PATH,
        'about' => ABOUT_UPLOAD_PATH
    ];
    
    if (!array_key_exists($uploadType, $uploadDirs)) {
        return ['success' => false, 'error' => 'Invalid upload type'];
    }
    
    $uploadDir = $uploadDirs[$uploadType];
    
    // Create directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    // Generate unique filename
    $fileName = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9\.\-]/', '_', $file['name']);
    $targetPath = $uploadDir . $fileName;
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        // Return relative path from site root
        $relativePath = 'uploads/' . $uploadType . 's/' . $fileName;
        
        // Remove the optimizeImage() call since it's not defined
        // optimizeImage($targetPath);
        
        return ['success' => true, 'file_path' => $relativePath];
    }
    
    return ['success' => false, 'error' => 'Failed to move uploaded file'];
}

// Basic image optimization function (commented out since you asked not to modify other parts)
/*
function optimizeImage($filePath) {
    // Basic implementation would go here if needed
    // This is just a placeholder since you asked not to modify other code
    return true;
}
*/
?>
<?php
// Function to sanitize input data
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Function to redirect with message
function redirectWithMessage($url, $message) {
    $_SESSION['message'] = $message;
    header("Location: $url");
    exit;
}

// Function to handle file uploads
function handleFileUpload($file, $targetDir, $allowedTypes = ['jpg', 'jpeg', 'png', 'gif']) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'File upload error'];
    }
    
    $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($fileExt, $allowedTypes)) {
        return ['success' => false, 'error' => 'Invalid file type'];
    }
    
    $fileName = uniqid() . '_' . basename($file['name']);
    $targetFile = $targetDir . $fileName;
    
    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        return ['success' => true, 'file_path' => $fileName];
    }
    
    return ['success' => false, 'error' => 'Failed to move uploaded file'];
}

// Function to generate pagination
function generatePagination($totalItems, $itemsPerPage, $currentPage, $url) {
    $totalPages = ceil($totalItems / $itemsPerPage);
    $pagination = '<ul class="pagination">';
    
    if ($currentPage > 1) {
        $pagination .= '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . ($currentPage - 1) . '">Previous</a></li>';
    }
    
    for ($i = 1; $i <= $totalPages; $i++) {
        $active = ($i == $currentPage) ? ' active' : '';
        $pagination .= '<li class="page-item' . $active . '"><a class="page-link" href="' . $url . '?page=' . $i . '">' . $i . '</a></li>';
    }
    
    if ($currentPage < $totalPages) {
        $pagination .= '<li class="page-item"><a class="page-link" href="' . $url . '?page=' . ($currentPage + 1) . '">Next</a></li>';
    }
    
    $pagination .= '</ul>';
    return $pagination;
}
function deleteUploadedFile($filePath) {
    if (file_exists('../' . $filePath)) {
        return unlink('../' . $filePath);
    }
    return false;
}
?>
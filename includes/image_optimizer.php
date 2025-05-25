<?php
function optimizeImage($filePath, $maxWidth = 1200, $quality = 80) {
    $fileExt = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    
    try {
        switch ($fileExt) {
            case 'jpg':
            case 'jpeg':
                $image = imagecreatefromjpeg($filePath);
                break;
            case 'png':
                $image = imagecreatefrompng($filePath);
                break;
            case 'gif':
                $image = imagecreatefromgif($filePath);
                break;
            case 'webp':
                $image = imagecreatefromwebp($filePath);
                break;
            default:
                return false;
        }
        
        // Get current dimensions
        $width = imagesx($image);
        $height = imagesy($image);
        
        // Calculate new dimensions if needed
        if ($width > $maxWidth) {
            $newHeight = (int) ($height * ($maxWidth / $width));
            $newImage = imagecreatetruecolor($maxWidth, $newHeight);
            
            // Preserve transparency for PNG and GIF
            if ($fileExt === 'png' || $fileExt === 'gif') {
                imagecolortransparent($newImage, imagecolorallocatealpha($newImage, 0, 0, 0, 127));
                imagealphablending($newImage, false);
                imagesavealpha($newImage, true);
            }
            
            imagecopyresampled($newImage, $image, 0, 0, 0, 0, $maxWidth, $newHeight, $width, $height);
            
            // Save optimized image
            switch ($fileExt) {
                case 'jpg':
                case 'jpeg':
                    imagejpeg($newImage, $filePath, $quality);
                    break;
                case 'png':
                    imagepng($newImage, $filePath, 9 - round($quality / 10));
                    break;
                case 'gif':
                    imagegif($newImage, $filePath);
                    break;
                case 'webp':
                    imagewebp($newImage, $filePath, $quality);
                    break;
            }
            
            imagedestroy($newImage);
        } else {
            // Just re-save with quality settings if no resizing needed
            switch ($fileExt) {
                case 'jpg':
                case 'jpeg':
                    imagejpeg($image, $filePath, $quality);
                    break;
                case 'png':
                    imagepng($image, $filePath, 9 - round($quality / 10));
                    break;
                case 'gif':
                    imagegif($image, $filePath);
                    break;
                case 'webp':
                    imagewebp($image, $filePath, $quality);
                    break;
            }
        }
        
        imagedestroy($image);
        return true;
    } catch (Exception $e) {
        error_log("Image optimization failed: " . $e->getMessage());
        return false;
    }
}
?>
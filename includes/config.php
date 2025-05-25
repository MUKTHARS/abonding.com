<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'abonding');

// Site configuration
define('SITE_NAME', 'Abonding');
define('BASE_URL', 'http://localhost/abonding.com');

// File upload paths
define('UPLOAD_PATH', __DIR__ . '/../uploads/');
define('SLIDER_UPLOAD_PATH', __DIR__ . '/../uploads/sliders/');
define('PRODUCT_UPLOAD_PATH', UPLOAD_PATH . 'products/');
define('AWARD_UPLOAD_PATH', UPLOAD_PATH . 'awards/');
define('INDUSTRY_UPLOAD_PATH', UPLOAD_PATH . 'industries/');
define('TEAM_UPLOAD_PATH', UPLOAD_PATH . 'team/');
define('ABOUT_UPLOAD_PATH', UPLOAD_PATH . 'about/');
define('TEMP_UPLOAD_PATH', UPLOAD_PATH . 'temp/');

// Start session
session_start();

// Error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
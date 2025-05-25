<?php
require_once 'includes/config.php';
require_once 'includes/db.php';
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/abonding.com'); // Adjust if your base URL is different
}

// Load settings if not already loaded
if (!isset($settings)) {
    require_once 'includes/config.php';
    require_once 'includes/db.php';
    $db = new Database();
    $settings = $db->fetchOne("SELECT * FROM site_settings LIMIT 1") ?: [];
}
// Get all product categories
$categories = $db->fetchAll("SELECT * FROM product_categories WHERE is_active = 1 ORDER BY name");

// Get products for each category
foreach ($categories as &$category) {
    $category['products'] = $db->fetchAll("
        SELECT * FROM products 
        WHERE category_id = ? AND is_active = 1 
        ORDER BY name
    ", [$category['id']]);
}
unset($category); // Break the reference
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.7/css/swiper.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Range - <?php echo htmlspecialchars($settings['site_name'] ?? 'Abonding'); ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/header.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/footer.css">
    <style>
       /* Header Styles */
.header {
    background-color: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 1000;
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 0;
}

.nav__links {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav__links li {
    margin: 0 15px;
}

.nav__links a {
    color: #333;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s;
}

.nav__links a:hover, 
.nav__links a.active {
    color: #019626;
}

.search-box {
    display: flex;
    align-items: center;
}

.search-input {
    padding: 8px 15px;
    border: 1px solid #ddd;
    border-radius: 4px 0 0 4px;
    outline: none;
}

.search-button {
    background-color: #019626;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 0 4px 4px 0;
    cursor: pointer;
}

.mobile-menu-toggle {
    display: none;
    font-size: 24px;
    cursor: pointer;
}

@media (max-width: 992px) {
    .nav__links {
        display: none;
    }
    
    .search-box {
        display: none;
    }
    
    .mobile-menu-toggle {
        display: block;
    }
}

/* Enhanced Product Range Page Styles */
body {
    font-family: 'Roboto', sans-serif;
    line-height: 1.6;
    color: #333;
}

/* Product Range Section */
.product-range-section {
    padding: 120px 0 80px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    position: relative;
    overflow: hidden;
}

.product-range-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="rgba(1,150,38,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
    opacity: 0.5;
}

.container {
    position: relative;
    z-index: 2;
}

/* Section Title */
.section-title {
    font-size: 3rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 20px;
    position: relative;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.section-title span {
    color: #019626;
    position: relative;
}

.section-title span::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, #019626, #00b32d);
    border-radius: 2px;
    animation: slideIn 1s ease-out;
}

@keyframes slideIn {
    from {
        width: 0;
    }
    to {
        width: 100%;
    }
}

/* View All Button */
.btn-custom {
    background: linear-gradient(135deg, #019626 0%, #00b32d 100%);
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow: 0 8px 25px rgba(1, 150, 38, 0.3);
    position: relative;
    overflow: hidden;
}

.btn-custom::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-custom:hover::before {
    left: 100%;
}

.btn-custom:hover {
    background: linear-gradient(135deg, #017a1f 0%, #019626 100%);
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(1, 150, 38, 0.4);
}

.btn-custom:active {
    transform: translateY(-1px);
}

/* Product Cards */
.cardproducts {
    background: white;
    border: none;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    height: 100%;
    margin-bottom: 30px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    position: relative;
    border: 1px solid rgba(1, 150, 38, 0.1);
}

.cardproducts::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, #019626, #00b32d);
    transition: left 0.5s ease;
    z-index: 3;
}

.cardproducts:hover::before {
    left: 0;
}

.cardproducts:hover {
    transform: translateY(-15px) scale(1.02);
    box-shadow: 0 25px 60px rgba(1, 150, 38, 0.2);
    border-color: rgba(1, 150, 38, 0.3);
}

/* Card Image */
.cardproducts img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: all 0.4s ease;
    position: relative;
}

.cardproducts:hover img {
    transform: scale(1.1);
}

/* Card Body */
.card-body {
    padding: 30px 25px;
    position: relative;
    background: white;
}

.card-body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 25px;
    right: 25px;
    height: 1px;
    background: linear-gradient(90deg, transparent, #019626, transparent);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.cardproducts:hover .card-body::before {
    opacity: 1;
}

/* Card Title */
.card-title {
    font-size: 1.4rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 15px;
    transition: color 0.3s ease;
    position: relative;
}

.cardproducts:hover .card-title {
    color: #019626;
}

/* Card Text */
.card-text {
    color: #6c757d;
    font-size: 0.95rem;
    line-height: 1.7;
    margin-bottom: 20px;
    transition: color 0.3s ease;
}

.cardproducts:hover .card-text {
    color: #5a6c7d;
}

/* Learn More Link */
.learn-more {
    color: #019626;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
    position: relative;
    padding: 8px 0;
}

.learn-more::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, #019626, #00b32d);
    transition: width 0.3s ease;
}

.learn-more:hover::after {
    width: 100%;
}

.learn-more i {
    margin-left: 8px;
    transition: transform 0.3s ease;
    font-size: 1.1rem;
}

.learn-more:hover {
    color: #00b32d;
    text-decoration: none;
}

.learn-more:hover i {
    transform: translateX(3px);
}

/* Grid Enhancements */
.row {
    margin: 0;
}

.col-md-3 {
    padding: 15px;
}

/* Loading Animations */
.cardproducts {
    animation: fadeInUp 0.6s ease forwards;
    opacity: 0;
    transform: translateY(30px);
}

.cardproducts:nth-child(1) { animation-delay: 0.1s; }
.cardproducts:nth-child(2) { animation-delay: 0.2s; }
.cardproducts:nth-child(3) { animation-delay: 0.3s; }
.cardproducts:nth-child(4) { animation-delay: 0.4s; }
.cardproducts:nth-child(5) { animation-delay: 0.5s; }
.cardproducts:nth-child(6) { animation-delay: 0.6s; }
.cardproducts:nth-child(7) { animation-delay: 0.7s; }
.cardproducts:nth-child(8) { animation-delay: 0.8s; }

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Header Row Enhancement */
.justify-content-between {
    align-items: center;
}

.mb-5 {
    margin-bottom: 4rem !important;
    padding-bottom: 2rem;
    border-bottom: 1px solid rgba(1, 150, 38, 0.1);
    position: relative;
}

.mb-5::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100px;
    height: 2px;
    background: linear-gradient(90deg, #019626, #00b32d);
    animation: expandLine 1.5s ease-out;
}

@keyframes expandLine {
    from {
        width: 0;
    }
    to {
        width: 100px;
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .product-range-section {
        padding: 100px 0 60px;
    }

    .section-title {
        font-size: 2.2rem;
        text-align: center;
        margin-bottom: 30px;
    }

    .btn-custom {
        padding: 12px 25px;
        font-size: 0.9rem;
        width: 100%;
        margin-top: 20px;
    }

    .col-md-3 {
        padding: 10px;
        margin-bottom: 20px;
    }

    .cardproducts {
        margin-bottom: 25px;
    }

    .card-body {
        padding: 25px 20px;
    }

    .mb-5 {
        text-align: center;
        flex-direction: column;
    }

    .col-md-6, .col-md-3 {
        width: 100%;
        max-width: 100%;
    }
}

@media (max-width: 576px) {
    .section-title {
        font-size: 1.8rem;
    }

    .cardproducts img {
        height: 200px;
    }

    .card-title {
        font-size: 1.2rem;
    }

    .card-text {
        font-size: 0.9rem;
    }
}

/* Hover Effects for Mobile */
@media (hover: none) {
    .cardproducts:hover {
        transform: none;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    .cardproducts:hover img {
        transform: none;
    }
}

/* Additional Professional Touches */
.container.py-5 {
    padding-top: 0 !important;
    padding-bottom: 0 !important;
}

/* Scroll Reveal Animation */
.scroll-reveal {
    opacity: 0;
    transform: translateY(50px);
    transition: all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1);
}

.scroll-reveal.revealed {
    opacity: 1;
    transform: translateY(0);
}
</style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <section class="product-range-section">
        <div class="container py-5">
            <div class="row mb-5 justify-content-between">
                <div class="col-md-6 col-12">
                    <h2 class="section-title">Our <span>Product Range</span></h2>
                </div>
                <!-- <div class="col-md-3 col-6">
                   <a href="<?php echo BASE_URL; ?>/productrange.php" class="btn-custom btn">View All</a>
                </div> -->
            </div>
            
            <div class="row">
                <?php foreach ($categories as $category): ?>
                <div class="col-md-3 px-3">
                    <div class="cardproducts">
                        <?php if ($category['image_path']): ?>
                        <img src="<?php echo htmlspecialchars($category['image_path']); ?>" alt="<?php echo htmlspecialchars($category['name']); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($category['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($category['description']); ?></p>
                            <a href="<?php echo BASE_URL; ?>/productdetails.php?id=<?php echo $category['id']; ?>" class="learn-more">
                                LEARN MORE <i class="bi bi-link-45deg"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <?php include 'includes/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize any necessary JavaScript here
        $(document).ready(function() {
            // Counter animation
            $('.counter').counterUp({
                delay: 10,
                time: 1000
            });
        });
    </script>
</body>
</html>
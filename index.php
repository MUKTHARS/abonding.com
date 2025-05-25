<?php
require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';

// Get site settings
$settings = $db->fetchOne("SELECT * FROM site_settings LIMIT 1");

// Get active sliders
$sliders = $db->fetchAll("SELECT * FROM sliders WHERE is_active = 1 ORDER BY display_order");

// Get product categories (limit to 4 for homepage)
$productCategories = $db->fetchAll("SELECT * FROM product_categories WHERE is_active = 1 LIMIT 4");

// Get industries served
$industries = $db->fetchAll("SELECT * FROM industries WHERE is_active = 1");

// Get awards
$awards = $db->fetchAll("SELECT * FROM awards WHERE is_active = 1 LIMIT 4");

// Get statistics
$statistics = $db->fetchAll("SELECT * FROM statistics WHERE is_active = 1");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.7/css/swiper.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css" integrity="sha512-pVCM5+SN2+qwj36KonHToF2p1oIvoU3bsqxphdOIWMYmgr4ZqD3t5DjKvvetKhXGc/ZG5REYTT6ltKfExEei/Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
   <title><?php echo htmlspecialchars($settings['site_name'] ?? 'Abonding'); ?> - Home</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/header.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/footer.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/home.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        :root {
            --primary-color: #019626;
            --primary-dark: #017a1f;
            --primary-light: #20c73f;
            --secondary-color: #f8f9fa;
            --accent-color: #ffc107;
            --text-dark: #2c3e50;
            --text-light: #6c757d;
            --white: #ffffff;
            --shadow-light: 0 2px 15px rgba(0,0,0,0.08);
            --shadow-medium: 0 8px 30px rgba(0,0,0,0.12);
            --shadow-dark: 0 15px 35px rgba(0,0,0,0.1);
            --gradient-primary: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            --border-radius: 12px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.7;
            color: var(--text-dark);
            background-color: #fafbfc;
        }

        /* Enhanced Header Styles */
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: var(--transition);
        }
        
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            max-width: 1200px;
            margin: 0 auto;
            padding-left: 20px;
            padding-right: 20px;
        }
        
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 24px;
            color: var(--primary-color) !important;
            text-decoration: none !important;
            transition: var(--transition);
        }

        .brand:hover {
            transform: translateY(-1px);
        }

        .brand img {
            height: 45px;
            transition: var(--transition);
        }
        
        .nav__links {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 35px;
        }
        
        .nav__links a {
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            position: relative;
            padding: 8px 0;
            transition: var(--transition);
        }

        .nav__links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gradient-primary);
            transition: var(--transition);
        }
        
        .nav__links a:hover::after,
        .nav__links a.active::after {
            width: 100%;
        }
        
        .nav__links a:hover, 
        .nav__links a.active {
            color: var(--primary-color);
        }
        
        .search-box {
            display: flex;
            align-items: center;
            background: var(--white);
            border-radius: 25px;
            box-shadow: var(--shadow-light);
            overflow: hidden;
            transition: var(--transition);
        }

        .search-box:hover {
            box-shadow: var(--shadow-medium);
        }
        
        .search-input {
            padding: 12px 20px;
            border: none;
            outline: none;
            font-size: 14px;
            background: transparent;
            width: 200px;
        }
        
        .search-button {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 12px 16px;
            cursor: pointer;
            transition: var(--transition);
        }

        .search-button:hover {
            background: var(--primary-dark);
        }
        
        .mobile-menu-toggle {
            display: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--primary-color);
        }

        /* Enhanced Hero Slider */
        .hero-slider {
            width: 100%;
            height: 500px;
            position: relative;
            margin-top: 75px;
            overflow: hidden;
        }

        .hero-slider .swiper-container {
            width: 100%;
            height: 100%;
             overflow: visible;
        }
.hero-slider .swiper-wrapper {
    transition-timing-function: cubic-bezier(0.65, 0, 0.35, 1); /* Smoother easing */
}
        .hero-slider .swiper-slide {
            position: relative;
             backface-visibility: hidden; /* Prevents flickering */
    transform: translateZ(0);
        }

        .hero-slider .slide-inner {
            width: 100%;
            height: 100%;
            position: relative;
            background-size: cover;
            background-position: center;
        }

        .hero-slider .slide-inner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /* background: linear-gradient(135deg, rgba(1, 150, 38, 0.7) 0%, rgba(0, 0, 0, 0.4) 100%); */
            z-index: 1;
        }

        .hero-slider .container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0 20px;
            z-index: 2;
            max-width: 1200px;
            margin: 0 auto;
        }

        .hero-slider .slide-text {
    max-width: 600px;
    margin-left: 5%;
    padding: 0; /* Adjust padding as needed */
    color: white;
    animation: fadeInUp 1s ease-out;
    text-shadow: 0 2px 4px rgba(0,0,0,0.5); /* Optional: adds text shadow for better readability */
}

        .hero-slider .slide-text p {
            font-size: 18px;
            line-height: 1.6;
            margin: 0;
            font-weight: 400;
        }
.theme-btn-s2 {
    display: inline-block;
    padding: 15px 35px;
    background: var(--gradient-primary);
    color: white; /* This should already be white */
    text-decoration: none;
    border-radius: 50px;
    font-weight: 600;
    font-size: 16px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: var(--transition);
    box-shadow: var(--shadow-medium);
    border: 2px solid transparent;
}

.theme-btn-s2:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-dark);
    background: white;
    color: var(--primary-color); /* This changes to green on hover */
    border-color: var(--primary-color);
}

.theme-btn-s2 {
    color: white !important; /* Force white text */
}

.theme-btn-s2:hover {
    color: var(--primary-color) !important; /* Keep green text on hover */
}
        .hero-slider .slide-btns {
            margin-left: 5%;
            margin-top: 25px;
            color: white;
        }

        .theme-btn-s2 {
            display: inline-block;
            padding: 15px 35px;
            background: var(--gradient-primary);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: var(--transition);
            box-shadow: var(--shadow-medium);
            border: 2px solid transparent;
        }

        .theme-btn-s2:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-dark);
            background: white;
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Navigation Arrows */
        .hero-slider .swiper-button-next,
        .hero-slider .swiper-button-prev {
            color: white;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: var(--transition);
        }

        .hero-slider .swiper-button-next:hover,
        .hero-slider .swiper-button-prev:hover {
            background: var(--primary-color);
            transform: scale(1.1);
        }

        /* Pagination Bullets */
        .hero-slider .swiper-pagination-bullet {
            background: white;
            opacity: 0.5;
            width: 12px;
            height: 12px;
            transition: var(--transition);
        }

        .hero-slider .swiper-pagination-bullet-active {
            /* background: var(--primary-color); */
            opacity: 1;
            transform: scale(1.2);
        }

        /* Enhanced Sections */
        .section {
            padding: 80px 0;
            position: relative;
        }

        .section-title {
            font-family: 'Poppins', sans-serif;
            font-size: 42px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 20px;
            position: relative;
        }

        .section-title span {
            color: var(--primary-color);
            position: relative;
        }

        .section-title span::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--gradient-primary);
            border-radius: 2px;
        }

        /* Enhanced Product Cards */
        .products-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }

        .cardproducts {
            background: var(--white);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-light);
            transition: var(--transition);
            height: 100%;
            border: 1px solid rgba(1, 150, 38, 0.1);
        }

        .cardproducts:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-dark);
            border-color: var(--primary-color);
        }

        .cardproducts img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: var(--transition);
        }

        .cardproducts:hover img {
            transform: scale(1.05);
        }

        .cardproducts .card-body {
            padding: 25px;
        }

        .cardproducts .card-title {
            font-family: 'Poppins', sans-serif;
            font-size: 20px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 15px;
        }

        .cardproducts .card-text {
            color: var(--text-light);
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .learn-more {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .learn-more:hover {
            color: var(--primary-dark);
            transform: translateX(5px);
        }

        .btn-custom {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: var(--transition);
            box-shadow: var(--shadow-light);
        }

        .btn-custom:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
            color: white;
        }

        /* Enhanced Industries Section */
        .industries-section {
            background: linear-gradient(135deg, rgba(1, 150, 38, 0.95) 0%, rgba(1, 122, 31, 0.95) 100%), url('4.jpg') no-repeat center center/cover;
            color: white;
            padding: 80px 0;
            position: relative;
        }

        .industries-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(1, 150, 38, 0.1);
            backdrop-filter: blur(2px);
        }

        .content-box {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 2;
            padding: 40px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            /* border: 1px solid rgba(255, 255, 255, 0.2); */
        }

        .content-box h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .content-box h2 span {
            color: var(--accent-color);
        }

        .content-box p {
            font-size: 18px;
            line-height: 1.7;
            margin-bottom: 30px;
            opacity: 0.95;
        }

        .industry-list {
            list-style: none;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-top: 30px;
        }

        .industry-list li {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px 20px;
            border-radius: 25px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-weight: 500;
            transition: var(--transition);
        }

        .industry-list li:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        /* Enhanced Awards Section */
        .awards-section {
            background: var(--white);
        }

        .cardindustries {
            background: var(--white);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-light);
            transition: var(--transition);
            height: 100%;
            border: 1px solid rgba(1, 150, 38, 0.1);
        }

        .cardindustries:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-dark);
            border-color: var(--primary-color);
        }

        .cardindustries img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            transition: var(--transition);
        }

        .cardindustries:hover img {
            transform: scale(1.05);
        }

        .cardindustries .card-body {
            padding: 25px;
        }

        .cardindustries .card-title {
            font-family: 'Poppins', sans-serif;
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 15px;
        }

        .cardindustries .card-text {
            color: var(--text-light);
            font-size: 14px;
            line-height: 1.6;
        }

        /* Enhanced Statistics Section */
        .statistics-section {
            background: var(--gradient-primary);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .statistics-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" patternUnits="userSpaceOnUse" width="100" height="100"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grain)"/></svg>');
        }

        .statistics-section .container {
            position: relative;
            z-index: 2;
        }

        .statistics-section h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 50px;
        }

        .statistics-section h1 span {
            color: var(--accent-color);
        }

        .stat-item {
            text-align: center;
            padding: 30px 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: var(--transition);
            height: 100%;
        }

        .stat-item:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15);
        }

        .stat-item h1 {
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 15px;
            color: var(--accent-color);
        }

        .stat-item p {
            font-size: 16px;
            font-weight: 500;
            opacity: 0.95;
            margin: 0;
        }

        /* Enhanced Floating Buttons */
        .bodydiv {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .btn-group {
            display: flex;
            border-radius: 50px;
            overflow: hidden;
            box-shadow: var(--shadow-dark);
            transition: var(--transition);
        }

        .btn-group:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .btn-group .btn-success {
            background: var(--gradient-primary);
            border: none;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-group .btn-light {
            background: var(--white);
            color: var(--text-dark);
            border: none;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: var(--transition);
        }

        .btn-group .btn-light:hover {
            background: var(--secondary-color);
            color: var(--primary-color);
        }

        .my {
            font-size: 18px;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .nav__links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(20px);
                flex-direction: column;
                padding: 20px;
                box-shadow: var(--shadow-medium);
                border-radius: 0 0 15px 15px;
            }
            
            .search-box {
                display: none;
            }
            
            .mobile-menu-toggle {
                display: block;
            }

            .section-title {
                font-size: 32px;
            }

            

            .hero-slider .slide-btns {
                margin-left: 0;
            }
        }

        @media (max-width: 768px) {
            .hero-slider {
                height: 400px;
                margin-top: 65px;
            }
            
           
            
            .hero-slider .swiper-button-next,
            .hero-slider .swiper-button-prev {
                display: none;
            }

            .section {
                padding: 60px 0;
            }

            .section-title {
                font-size: 28px;
            }

            .statistics-section h1 {
                font-size: 32px;
            }

            .stat-item h1 {
                font-size: 36px;
            }

            .bodydiv {
                bottom: 15px;
                right: 15px;
            }

            .btn-group .btn-light {
                font-size: 12px;
                padding: 10px 15px;
            }
        }

        /* Animation Classes */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }

        .animate-on-scroll.animate {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>
   
    <?php include 'includes/header.php'; ?>

    <section class="hero-slider hero-style">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php foreach ($sliders as $slider): ?>
                <div class="swiper-slide">
                    <div class="slide-inner slide-bg-image" style="background-image: url('<?php echo BASE_URL . '/' . htmlspecialchars($slider['image_path']); ?>')">
                        <div class="container">
                            <div data-swiper-parallax="400" class="slide-text">
                                <p class="whitefont"><?php echo htmlspecialchars($slider['description']); ?></p>
                            </div>
                            <div class="clearfix"></div>
                            <div data-swiper-parallax="500" class="slide-btns">
    <a href="<?php echo BASE_URL; ?>/productrange.php" class="theme-btn-s2"><?php echo htmlspecialchars($slider['button_text'] ?? 'Read More'); ?></a>
</div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>

    <section class="section products-section">
        <div class="container">
            <div class="row mb-5 justify-content-between align-items-center">
                <div class="col-md-8">
                    <h2 class="section-title animate-on-scroll">Trending <span>Products</span></h2>
                    <p class="text-muted fs-5">Discover our latest and most innovative product solutions</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="<?php echo BASE_URL; ?>/productrange.php" class="btn-custom btn">View All Products</a>
                </div>
            </div>
            <div class="row g-4">
                <?php foreach ($productCategories as $index => $category): ?>
                <div class="col-lg-3 col-md-6 animate-on-scroll" style="animation-delay: <?php echo $index * 0.1; ?>s;">
                    <div class="cardproducts">
                        <div class="position-relative overflow-hidden">
                            <img src="<?php echo BASE_URL . '/' . htmlspecialchars($category['image_path']); ?>" alt="<?php echo htmlspecialchars($category['name']); ?>">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($category['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($category['description']); ?></p>
                            <a href="<?php echo BASE_URL; ?>/productrange.php" class="learn-more">
                                Learn More <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Industries Section -->
    <section class="industries-section">
        <div class="container-fluid">
            <div class="content-box animate-on-scroll">
                <h2>Industries <span>Served</span></h2>
                <p><?php echo htmlspecialchars($settings['industries_description'] ?? 'We serve diverse industries with our comprehensive range of products and solutions, delivering excellence across multiple sectors.'); ?></p>
                <ul class="industry-list">
                    <?php foreach ($industries as $industry): ?>
                    <li><i class="bi bi-check-circle me-2"></i><?php echo htmlspecialchars($industry['name']); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>

    <!-- Awards Section -->
    <section class="section awards-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title animate-on-scroll">Our <span>Awards</span></h2>
                <p class="text-muted fs-5 animate-on-scroll">Recognition of our commitment to excellence and innovation</p>
            </div>
            <div class="row g-4">
                <?php foreach ($awards as $index => $award): ?>
                <div class="col-lg-3 col-md-6 animate-on-scroll" style="animation-delay: <?php echo $index * 0.1; ?>s;">
                    <div class="cardindustries">
                        <div class="position-relative overflow-hidden">
                            <img src="<?php echo BASE_URL . '/' . htmlspecialchars($award['image_path']); ?>" alt="<?php echo htmlspecialchars($award['name']); ?>">
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo htmlspecialchars($award['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($award['description']); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="section statistics-section">
        <div class="container">
            <div class="text-center mb-5">
                <h1 class="animate-on-scroll">Our <span>Achievements</span></h1>
                <p class="fs-5 animate-on-scroll" style="opacity: 0.9;">Numbers that speak for our success and growth</p>
            </div>
            <div class="row g-4">
                <?php foreach ($statistics as $index => $stat): ?>
                <div class="col-lg-4 col-md-6 animate-on-scroll" style="animation-delay: <?php echo $index * 0.2; ?>s;">
                    <div class="stat-item">
                        <h1><span class="counter"><?php echo htmlspecialchars($stat['value']); ?></span><?php echo strpos($stat['value'], 'Cr') !== false ? '' : '+'; ?></h1>
                        <p><?php echo htmlspecialchars($stat['description']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Floating contact buttons -->
    <div class="bodydiv">
        <div class="btn-group mb-3" role="group">
            <button type="button" class="btn btn-success">
                <i class="bi bi-whatsapp my"></i>
            </button>
            <a href="https://wa.me/<?php echo htmlspecialchars($settings['contact_whatsapp'] ?? '919442576397'); ?>" target="_blank" class="btn btn-light">
                WhatsApp<br><?php echo htmlspecialchars($settings['contact_whatsapp'] ?? '+91 94425 76397'); ?>
            </a>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-success">
                <i class="bi bi-telephone-fill my"></i>
            </button>
            <a href="tel:<?php echo htmlspecialchars($settings['contact_phone'] ?? '+919442576397'); ?>" class="btn btn-light">
                Call Now<br><?php echo htmlspecialchars($settings['contact_phone'] ?? '+91 94425 76397'); ?>
            </a>
        </div>
    </div>

   <script>
        // Mobile menu toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.querySelector('.mobile-menu-toggle');
            const navLinks = document.querySelector('.nav__links');
            
            toggle.addEventListener('click', function() {
                navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
            });
            
            // Close menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.navbar') && window.innerWidth <= 992) {
                    navLinks.style.display = 'none';
                }
            });

            // Initialize Swiper
            var swiper = new Swiper('.swiper-container', {
    loop: true,
    speed: 1000,
    parallax: true,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    // Remove fade effect and use default slide
    effect: 'slide',
    grabCursor: true,
    preventClicks: false,
    preventClicksPropagation: false,
    // Smooth transitions
    on: {
        init: function() {
            this.slides.css('opacity', '1');
        }
    }
});

            // Counter animation
            $('.counter').counterUp({
                delay: 10,
                time: 2000
            });

            // Scroll animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate');
                    }
                });
            }, observerOptions);

            // Observe all elements with animate-on-scroll class
            document.querySelectorAll('.animate-on-scroll').forEach(el => {
                observer.observe(el);
            });

            // Header scroll effect
            window.addEventListener('scroll', function() {
                const header = document.querySelector('.header');
                if (window.scrollY > 100) {
                    header.style.background = 'rgba(255, 255, 255, 0.98)';
                    header.style.backdropFilter = 'blur(20px)';
                } else {
                    header.style.background = 'rgba(255, 255, 255, 0.95)';
                    header.style.backdropFilter = 'blur(20px)';
                }
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>

    <?php include 'includes/footer.php'; ?>
</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const toggle = document.querySelector('.mobile-menu-toggle');
    const navLinks = document.querySelector('.nav__links');
    
    if (toggle && navLinks) {
        toggle.addEventListener('click', function() {
            navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.navbar') && window.innerWidth <= 992) {
                navLinks.style.display = 'none';
            }
        });
    }

    // Initialize Swiper
    if (document.querySelector('.swiper-container')) {
        var swiper = new Swiper('.swiper-container', {
            loop: true,
            speed: 1000,
            parallax: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            effect: 'slide',
            grabCursor: true
        });
    }

    // Counter animation
    if (typeof $.fn.counterUp !== 'undefined') {
        $('.counter').counterUp({
            delay: 10,
            time: 2000
        });
    }

    // Scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
    });

    // Header scroll effect
    const header = document.querySelector('.header');
    if (header) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 100) {
                header.style.background = 'rgba(255, 255, 255, 0.98)';
                header.style.backdropFilter = 'blur(20px)';
            } else {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
                header.style.backdropFilter = 'blur(20px)';
            }
        });
    }

    // Smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>
</html>
<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

// Get all active industries
$industries = $db->fetchAll("SELECT * FROM industries WHERE is_active = 1 ORDER BY name");

// Get site settings for industries description
$settings = $db->fetchOne("SELECT industries_description FROM site_settings LIMIT 1");
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
      <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.7/css/swiper.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css" integrity="sha512-pVCM5+SN2+qwj36KonHToF2p1oIvoU3bsqxphdOIWMYmgr4ZqD3t5DjKvvetKhXGc/ZG5REYTT6ltKfExEei/Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Industries We Serve - <?php echo htmlspecialchars($settings['site_name'] ?? 'Abonding'); ?></title>
    <!-- Include all your CSS and JS files from the original design -->
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

    /* Enhanced Industries Page Styles */
    body {
        font-family: 'Roboto', sans-serif;
        line-height: 1.6;
        color: #333;
    }

    /* Hero Section */
    .industries-hero {
        background: linear-gradient(135deg, #019626 0%, #00b32d 100%);
        padding: 150px 0 100px;
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .industries-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/><circle cx="10" cy="60" r="0.5" fill="rgba(255,255,255,0.05)"/><circle cx="90" cy="40" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }

    .industries-hero h1 {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        position: relative;
        z-index: 2;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .industries-hero p {
        font-size: 1.3rem;
        margin-bottom: 0;
        position: relative;
        z-index: 2;
        opacity: 0.95;
        max-width: 600px;
        margin: 0 auto;
    }

    /* Industries Section */
    .industries-section {
        padding: 80px 0;
        background: #f8f9fa;
        position: relative;
    }

    .content-box {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .content-box h2 {
        font-size: 2.8rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 20px;
        color: #2c3e50;
    }

    .content-box h2 span {
        color: #019626;
        position: relative;
    }

    .content-box h2 span::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, #019626, #00b32d);
        border-radius: 2px;
    }

    .content-box > p {
        text-align: center;
        font-size: 1.2rem;
        color: #6c757d;
        max-width: 700px;
        margin: 0 auto 60px;
        line-height: 1.8;
    }

    /* Industry Cards */
    .industry-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        position: relative;
        border: 1px solid rgba(1, 150, 38, 0.1);
    }

    .industry-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #019626, #00b32d);
        transition: left 0.5s ease;
    }

    .industry-card:hover::before {
        left: 0;
    }

    .industry-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(1, 150, 38, 0.2);
    }

    .industry-card img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .industry-card:hover img {
        transform: scale(1.05);
    }

    .industry-content {
        padding: 30px 25px;
        position: relative;
    }

    .industry-content::before {
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

    .industry-card:hover .industry-content::before {
        opacity: 1;
    }

    .industry-content h3 {
        font-size: 1.4rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 15px;
        position: relative;
    }

    .industry-content p {
        color: #6c757d;
        font-size: 0.95rem;
        line-height: 1.7;
        margin: 0;
    }

    /* Grid Enhancements */
    .row {
        margin: 0;
    }

    .col-md-4 {
        padding: 15px;
    }

    /* Animation Classes */
    .fade-in-up {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease;
    }

    .fade-in-up.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .industries-hero {
            padding: 120px 0 80px;
        }

        .industries-hero h1 {
            font-size: 2.5rem;
        }

        .industries-hero p {
            font-size: 1.1rem;
        }

        .content-box h2 {
            font-size: 2.2rem;
        }

        .content-box > p {
            font-size: 1.1rem;
        }

        .industries-section {
            padding: 60px 0;
        }

        .col-md-4 {
            padding: 10px;
            margin-bottom: 20px;
        }

        .industry-card {
            margin-bottom: 20px;
        }
    }

    @media (max-width: 576px) {
        .industries-hero h1 {
            font-size: 2rem;
        }

        .content-box h2 {
            font-size: 1.8rem;
        }

        .industry-content {
            padding: 25px 20px;
        }
    }

    /* Loading Animation */
    .industry-card {
        animation: slideInUp 0.6s ease forwards;
        opacity: 0;
        transform: translateY(30px);
    }

    .industry-card:nth-child(1) { animation-delay: 0.1s; }
    .industry-card:nth-child(2) { animation-delay: 0.2s; }
    .industry-card:nth-child(3) { animation-delay: 0.3s; }
    .industry-card:nth-child(4) { animation-delay: 0.4s; }
    .industry-card:nth-child(5) { animation-delay: 0.5s; }
    .industry-card:nth-child(6) { animation-delay: 0.6s; }

    @keyframes slideInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Scroll-triggered animations */
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
    
    <section class="industries-hero">
        <div class="container">
            <h1 class="animate__animated animate__fadeInDown">Industries We Serve</h1>
            <p class="animate__animated animate__fadeInUp animate__delay-1s">Providing solutions across multiple sectors with our specialized products</p>
        </div>
    </section>

    <div class="container-fluid industries-section">
        <div class="content-box">
            <h2 class="scroll-reveal">Industries <span>Served</span></h2>
            <p class="scroll-reveal"><?php echo htmlspecialchars($settings['industries_description'] ?? 'Each year, hundreds of clients across the country rely on our expertise.'); ?></p>
            
            <div class="row mt-5">
                <?php foreach ($industries as $industry): ?>
                <div class="col-md-4 mb-4">
                    <div class="industry-card">
                        <?php if ($industry['image_path']): ?>
                        <img src="<?php echo BASE_URL . '/' . htmlspecialchars($industry['image_path']); ?>" alt="<?php echo htmlspecialchars($industry['name']); ?>">
                        <?php endif; ?>
                        <div class="industry-content">
                            <h3><?php echo htmlspecialchars($industry['name']); ?></h3>
                            <p><?php echo htmlspecialchars($industry['description']); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    
    <!-- Include all your JS files -->
    <script src="assets/js/main.js"></script>
    
    <script>
        // Scroll reveal animation
        function revealOnScroll() {
            const reveals = document.querySelectorAll('.scroll-reveal');
            
            reveals.forEach(reveal => {
                const windowHeight = window.innerHeight;
                const elementTop = reveal.getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < windowHeight - elementVisible) {
                    reveal.classList.add('revealed');
                }
            });
        }
        
        window.addEventListener('scroll', revealOnScroll);
        
        // Trigger on page load
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(revealOnScroll, 100);
        });
    </script>
</body>
</html>
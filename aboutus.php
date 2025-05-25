<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

// Get about us content from database (you would need an about_us table)
$aboutContent = $db->fetchOne("SELECT * FROM about_us LIMIT 1");

// If no content exists, use default values
if (!$aboutContent) {
    $aboutContent = [
        'title' => 'About Abonding',
        'company_description' => 'We are a leading provider of quality solutions for various industries...',
        'vision' => 'To be the most trusted partner in our industry',
        'mission' => 'To deliver innovative solutions with exceptional service',
        'process' => 'Our rigorous process ensures quality at every step',
        'strengths' => 'Experienced team, quality products, customer focus'
    ];
}

// Get team members (you would need a team_members table)
$teamMembers = $db->fetchAll("SELECT * FROM team_members WHERE is_active = 1 ORDER BY display_order");
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
    <title><?php echo htmlspecialchars($aboutContent['title']); ?></title>
    <!-- Include all your CSS and JS files from the original design -->
   <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/header.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/footer.css">
<style>
    :root {
    --primary-green: #019626;
    --light-green: #e8f5e8;
    --dark-green: #017a1f;
    --gradient-green: linear-gradient(135deg, #019626 0%, #028a22 100%);
    --text-dark: #1a1a1a;
    --text-gray: #6b7280;
    --border-light: #e5e7eb;
    --shadow-soft: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-medium: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --shadow-large: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

* {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

body {
    background: linear-gradient(135deg, #f8fffe 0%, #f1f8f1 100%);
    color: var(--text-dark);
    line-height: 1.6;
    margin: 0;
    padding: 0;
}

/* About Hero Section */
.about-hero {
    background: var(--gradient-green);
    padding: 150px 0 100px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.about-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
    opacity: 0.3;
}

.about-hero h1 {
    color: white;
    font-size: 4rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    position: relative;
    z-index: 2;
}

.about-hero::after {
    content: '';
    position: absolute;
    bottom: -50px;
    left: 0;
    right: 0;
    height: 100px;
    background: white;
    border-radius: 50% 50% 0 0;
    transform: scaleX(1.5);
}

/* About Content Section */
.about-content {
    padding: 80px 0;
    position: relative;
}

.about-content .container {
    position: relative;
    z-index: 2;
}

.about-content h2 {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary-green);
    margin-bottom: 30px;
    position: relative;
    padding-bottom: 15px;
}

.about-content h2::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 4px;
    background: var(--gradient-green);
    border-radius: 2px;
}

.about-content p {
    font-size: 1.1rem;
    line-height: 1.8;
    color: var(--text-dark);
    margin-bottom: 25px;
}

/* Company Section */
.about-content .row:first-child {
    background: white;
    border-radius: 20px;
    padding: 50px;
    margin-bottom: 50px;
    box-shadow: var(--shadow-medium);
    border: 1px solid var(--border-light);
    position: relative;
    overflow: hidden;
}

.about-content .row:first-child::before {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 200px;
    height: 200px;
    background: var(--gradient-green);
    opacity: 0.05;
    border-radius: 50%;
}

.about-content .row:first-child img {
    border-radius: 16px;
    box-shadow: var(--shadow-soft);
    transition: transform 0.3s ease;
}

.about-content .row:first-child img:hover {
    transform: scale(1.02);
}

/* Vision and Mission Cards */
.vision-card, .mission-card {
    background: white;
    border: none;
    border-radius: 20px;
    box-shadow: var(--shadow-medium);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    position: relative;
    overflow: hidden;
    border-top: 4px solid transparent;
}

.vision-card {
    border-top-color: var(--primary-green);
}

.mission-card {
    border-top-color: var(--dark-green);
}

.vision-card::before,
.mission-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 100px;
    height: 100px;
    background: var(--gradient-green);
    opacity: 0.05;
    border-radius: 0 0 0 100px;
}

.vision-card:hover, .mission-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-large);
}

.vision-card .card-body, .mission-card .card-body {
    padding: 40px;
}

.vision-card h3, .mission-card h3 {
    font-size: 1.8rem;
    font-weight: 600;
    color: var(--primary-green);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
}

.vision-card h3 i, .mission-card h3 i {
    font-size: 1.5rem;
    margin-right: 12px;
    color: var(--primary-green);
}

.vision-card p, .mission-card p {
    font-size: 1.05rem;
    line-height: 1.7;
    color: var(--text-dark);
    margin: 0;
}

/* Process Section */
.about-content .row:nth-child(3) {
    background: white;
    border-radius: 20px;
    padding: 50px;
    margin-bottom: 50px;
    box-shadow: var(--shadow-medium);
    border: 1px solid var(--border-light);
    position: relative;
}

.about-content .row:nth-child(3)::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 6px;
    background: var(--gradient-green);
    border-radius: 20px 20px 0 0;
}

/* Team Section */
.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.team-member {
    background: white;
    border-radius: 20px;
    padding: 40px 30px;
    text-align: center;
    box-shadow: var(--shadow-medium);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid var(--border-light);
    position: relative;
    overflow: hidden;
}

.team-member::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-green);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s ease;
}

.team-member:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-large);
}

.team-member:hover::before {
    transform: scaleX(1);
}

.team-member img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 20px;
    border: 4px solid var(--light-green);
    transition: all 0.3s ease;
}

.team-member:hover img {
    border-color: var(--primary-green);
    transform: scale(1.05);
}

.team-member h4 {
    font-size: 1.4rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 8px;
}

.team-member .position {
    color: var(--primary-green);
    font-weight: 500;
    font-size: 1rem;
    margin-bottom: 20px;
}

.social-links {
    display: flex;
    justify-content: center;
    gap: 15px;
}

.social-links a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: var(--light-green);
    color: var(--primary-green);
    border-radius: 50%;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 1.1rem;
}

.social-links a:hover {
    background: var(--primary-green);
    color: white;
    transform: translateY(-2px);
}

/* Strengths Section */
.about-content .row:last-child {
    background: white;
    border-radius: 20px;
    padding: 50px;
    box-shadow: var(--shadow-medium);
    border: 1px solid var(--border-light);
    position: relative;
}

.about-content .row:last-child::after {
    content: '';
    position: absolute;
    bottom: 0;
    right: 0;
    width: 150px;
    height: 150px;
    background: var(--gradient-green);
    opacity: 0.05;
    border-radius: 50%;
    transform: translate(50px, 50px);
}

.strengths-list {
    list-style: none;
    padding: 0;
    margin-top: 30px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.strengths-list li {
    background: var(--light-green);
    padding: 20px 25px;
    border-radius: 12px;
    border-left: 4px solid var(--primary-green);
    font-size: 1.05rem;
    font-weight: 500;
    color: var(--text-dark);
    transition: all 0.3s ease;
    position: relative;
    padding-left:10;
}

.strengths-list li::before {
    content: '✓';
    position: absolute;
    left: -2px;
    top: 50%;
    transform: translateY(-50%);
    width: 24px;
    height: 24px;
    background: var(--primary-green);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    font-weight: bold;
    padding-left:10;
}

.strengths-list li:hover {
    background: white;
    box-shadow: var(--shadow-soft);
    transform: translateX(5px);
    padding-left:10;
}

/* Responsive Design */
@media (max-width: 992px) {
    .about-hero h1 {
        font-size: 3rem;
    }
    
    .about-content h2 {
        font-size: 2rem;
    }
    
    .about-content .row:first-child,
    .about-content .row:nth-child(3),
    .about-content .row:last-child {
        padding: 30px 25px;
    }
    
    .vision-card .card-body,
    .mission-card .card-body {
        padding: 30px;
    }
    
    .team-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }
    
    .strengths-list {
        grid-template-columns: 1fr;
        gap: 15px;
    }
}

@media (max-width: 768px) {
    .about-hero {
        padding: 120px 0 80px;
    }
    
    .about-hero h1 {
        font-size: 2.5rem;
    }
    
    .about-content {
        padding: 60px 0;
    }
    
    .about-content h2 {
        font-size: 1.8rem;
    }
    
    .vision-card h3, .mission-card h3 {
        font-size: 1.5rem;
    }
    
    .team-member {
        padding: 30px 20px;
    }
    
    .team-member img {
        width: 100px;
        height: 100px;
    }
}

@media (max-width: 576px) {
    .about-hero h1 {
        font-size: 2rem;
    }
    
    .about-content .row:first-child,
    .about-content .row:nth-child(3),
    .about-content .row:last-child {
        padding: 20px;
    }
    
    .vision-card .card-body,
    .mission-card .card-body {
        padding: 25px;
    }
    
    .team-grid {
        grid-template-columns: 1fr;
    }
}

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
</style>
</head>

<body>
    
    <?php include 'includes/header.php'; ?>
    
    <section class="about-hero">
        <div class="container">
            <h1><?php echo htmlspecialchars($aboutContent['title']); ?></h1>
        </div>
    </section>

    <section class="about-content">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-6">
                    <h2>Our Company</h2>
                    <p><?php echo htmlspecialchars($aboutContent['company_description']); ?></p>
                </div>
                <div class="col-lg-6">
                    <img src="<?php echo BASE_URL; ?>/assets/img/logo.png" alt="Our Company" class="img-fluid rounded">
                </div>
            </div>
            
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="card vision-card">
                        <div class="card-body">
                            <h3><i class="bi bi-eye"></i> Our Vision</h3>
                            <p><?php echo htmlspecialchars($aboutContent['vision']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mission-card">
                        <div class="card-body">
                            <h3><i class="bi bi-bullseye"></i> Our Mission</h3>
                            <p><?php echo htmlspecialchars($aboutContent['mission']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-5">
                <div class="col-12">
                    <h2>Our Process</h2>
                    <p><?php echo htmlspecialchars($aboutContent['process']); ?></p>
                </div>
            </div>
            
            <?php if (!empty($teamMembers)): ?>
            <div class="row mt-5">
                <div class="col-12">
                    <h2>Our Team</h2>
                    <div class="team-grid">
                        <?php foreach ($teamMembers as $member): ?>
                        <div class="team-member">
                            <img src="<?php echo BASE_URL . '/' . htmlspecialchars($member['image_path']); ?>" alt="<?php echo htmlspecialchars($member['name']); ?>">
                            <h4><?php echo htmlspecialchars($member['name']); ?></h4>
                            <p class="position"><?php echo htmlspecialchars($member['position']); ?></p>
                            <div class="social-links">
                                <?php if ($member['linkedin']): ?>
                                <a href="<?php echo htmlspecialchars($member['linkedin']); ?>" target="_blank"><i class="bi bi-linkedin"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="row mt-5">
                <div class="col-12">
                    <h2>Our Strengths</h2>
                    <ul class="strengths-list">
                        <?php 
                        $strengths = explode(',', $aboutContent['strengths']);
                        foreach ($strengths as $strength): 
                        ?>
                        <li><?php echo htmlspecialchars(trim($strength)); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    
    <!-- Include all your JS files -->
    <script src="assets/js/main.js"></script>
</body>
</html>
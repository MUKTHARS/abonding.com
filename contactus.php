<?php
require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';

// Handle contact form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $subject = sanitizeInput($_POST['subject']);
    $message = sanitizeInput($_POST['message']);
    
    // Basic validation
    $errors = [];
    if (empty($name)) $errors[] = 'Name is required';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';
    if (empty($message)) $errors[] = 'Message is required';
    
    if (empty($errors)) {
        // Save to database (you would need a contacts table)
        $db->query(
            "INSERT INTO contacts (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)",
            [$name, $email, $phone, $subject, $message]
        );
        
        // Send email (configure your mail server)
        $to = 'info@abonding.com';
        $headers = "From: $email\r\nReply-To: $email";
        $emailSubject = "Contact Form Submission: $subject";
        $emailBody = "Name: $name\nEmail: $email\nPhone: $phone\n\nMessage:\n$message";
        
        mail($to, $emailSubject, $emailBody, $headers);
        
        $_SESSION['message'] = 'Thank you for your message! We will get back to you soon.';
        header('Location: contactus.php');
        exit;
    }
}

// Get site settings for contact info
$settings = $db->fetchOne("SELECT * FROM site_settings LIMIT 1");
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
    <title>Contact Us - <?php echo htmlspecialchars($settings['site_name'] ?? 'Abonding'); ?></title>
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

    /* Contact Page Specific Styles - Abonding Design */
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f8f9fa;
    }

    .contact-hero {
        background: linear-gradient(135deg, #019626 0%, #0d7b3d 100%);
        color: white;
        padding: 120px 0 80px;
        margin-top: 80px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .contact-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20"><defs><pattern id="grain" width="100" height="20" patternUnits="userSpaceOnUse"><circle cx="1" cy="1" r="1" fill="white" fill-opacity="0.05"/></pattern></defs><rect width="100" height="20" fill="url(%23grain)"/></svg>');
        pointer-events: none;
    }

    .contact-hero h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .contact-hero p {
        font-size: 1.2rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }

    .contact-main {
        padding: 80px 0;
        background: white;
    }

    .contact-form-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        padding: 40px;
        margin-bottom: 30px;
        border-top: 5px solid #019626;
    }

    .contact-info-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        padding: 40px;
        height: 100%;
        border-top: 5px solid #019626;
    }

    .form-title {
        color: #019626;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-title i {
        background: linear-gradient(135deg, #019626, #0d7b3d);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: #fafafa;
    }

    .form-control:focus {
        border-color: #019626;
        background-color: white;
        box-shadow: 0 0 0 0.2rem rgba(1, 150, 38, 0.15);
    }

    .btn-contact {
        background: linear-gradient(135deg, #019626 0%, #0d7b3d 100%);
        border: none;
        color: white;
        padding: 12px 30px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 25px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(1, 150, 38, 0.3);
    }

    .btn-contact:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(1, 150, 38, 0.4);
        color: white;
    }

    .contact-info-item {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .contact-info-item:hover {
        background: linear-gradient(135deg, #019626, #0d7b3d);
        color: white;
        transform: translateX(5px);
    }

    .contact-info-item i {
        font-size: 1.5rem;
        margin-right: 15px;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #019626, #0d7b3d);
        color: white;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .contact-info-item:hover i {
        background: white;
        color: #019626;
    }

    .contact-info-item strong {
        display: block;
        font-weight: 600;
    }

    .contact-info-item span {
        color: #666;
        font-size: 0.95rem;
    }

    .contact-info-item:hover span {
        color: rgba(255,255,255,0.9);
    }

    .map-container {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-top: 30px;
    }

    .map-container iframe {
        width: 100%;
        height: 350px;
        border: none;
    }

    .alert {
        border-radius: 10px;
        border: none;
        padding: 15px 20px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da, #f1aeb5);
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    .quick-contact {
        background: linear-gradient(135deg, #019626 0%, #0d7b3d 100%);
        padding: 60px 0;
        color: white;
        text-align: center;
    }

    .quick-contact h3 {
        font-size: 2rem;
        margin-bottom: 1rem;
        font-weight: 700;
    }

    .quick-contact-buttons {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-top: 30px;
    }

    .quick-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: rgba(255,255,255,0.2);
        color: white;
        padding: 15px 25px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255,255,255,0.3);
    }

    .quick-btn:hover {
        background: white;
        color: #019626;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    @media (max-width: 768px) {
        .contact-hero h1 {
            font-size: 2rem;
        }
        
        .contact-form-card,
        .contact-info-card {
            padding: 25px;
            margin-bottom: 20px;
        }
        
        .form-title {
            font-size: 1.5rem;
        }
        
        .quick-contact-buttons {
            flex-direction: column;
            align-items: center;
        }
        
        .quick-btn {
            width: 80%;
            justify-content: center;
        }
    }
</style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <!-- Hero Section -->
    <section class="contact-hero">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="animate__animated animate__fadeInUp">Get In Touch</h1>
                    <p class="animate__animated animate__fadeInUp animate__delay-1s">
                        We'd love to hear from you. Send us a message and we'll respond as soon as possible.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Contact Section -->
    <section class="contact-main">
        <div class="container">
            <div class="row">
                <!-- Contact Form -->
                <div class="col-lg-8">
                    <div class="contact-form-card animate__animated animate__fadeInLeft">
                        <h2 class="form-title">
                            <i class="fas fa-paper-plane"></i>
                            Send us a Message
                        </h2>
                        
                        <?php if (isset($_SESSION['message'])): ?>
                            <div class="alert alert-success animate__animated animate__fadeIn">
                                <i class="fas fa-check-circle me-2"></i>
                                <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger animate__animated animate__fadeIn">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <ul class="mb-0">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?php echo $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">
                                            <i class="fas fa-user me-1"></i> Full Name *
                                        </label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">
                                            <i class="fas fa-envelope me-1"></i> Email Address *
                                        </label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">
                                            <i class="fas fa-phone me-1"></i> Phone Number
                                        </label>
                                        <input type="tel" class="form-control" id="phone" name="phone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="subject" class="form-label">
                                            <i class="fas fa-tag me-1"></i> Subject
                                        </label>
                                        <input type="text" class="form-control" id="subject" name="subject">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="message" class="form-label">
                                    <i class="fas fa-comment-dots me-1"></i> Your Message *
                                </label>
                                <textarea class="form-control" id="message" name="message" rows="6" required placeholder="Tell us how we can help you..."></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-contact">
                                <i class="fas fa-paper-plane me-2"></i>
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Contact Information -->
                <div class="col-lg-4">
                    <div class="contact-info-card animate__animated animate__fadeInRight">
                        <h2 class="form-title">
                            <i class="fas fa-info-circle"></i>
                            Contact Information
                        </h2>
                        
                        <div class="contact-info-item">
                            <i class="fas fa-phone-alt"></i>
                            <div>
                                <strong>Phone</strong>
                                <span><?php echo htmlspecialchars($settings['contact_phone'] ?? '+91 83778 88997  '); ?></span>
                            </div>
                        </div>
                        
                        <div class="contact-info-item">
                            <i class="fab fa-whatsapp"></i>
                            <div>
                                <strong>WhatsApp</strong>
                                <span><?php echo htmlspecialchars($settings['contact_whatsapp'] ?? '+91 94425 76397'); ?></span>
                            </div>
                        </div>
                        
                        <div class="contact-info-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <strong>Email</strong>
                                <span>abonding22@gmail.com / info@abonding.com / Sales@abonding.com</span>
                            </div>
                        </div>
                        
                        <div class="contact-info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <strong>Address</strong>
                                <span>1A, Ram Nagar, Thimmampalayam, Karamadai, Coimbatore-641104</span>
                            </div>
                        </div>
                        
                        <div class="contact-info-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <strong>Business Hours</strong>
                                <span>Mon - Fri: 9:00 AM - 6:00 PM</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Contact Section -->
    <section class="quick-contact">
        <div class="container">
            <h3>Need Immediate Assistance?</h3>
            <p>Choose your preferred way to reach us</p>
            <div class="quick-contact-buttons">
                <a href="tel:+919442576397" class="quick-btn">
                    <i class="fas fa-phone"></i>
                    Call Now
                </a>
                <a href="https://wa.me/919442576397" class="quick-btn" target="_blank">
                    <i class="fab fa-whatsapp"></i>
                    WhatsApp
                </a>
                <a href="mailto:info@abonding.com" class="quick-btn">
                    <i class="fas fa-envelope"></i>
                    Email Us
                </a>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="container">
            <div class="map-container animate__animated animate__fadeInUp">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3916.3344676657995!2d76.9558321748867!3d11.016844254480498!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba859af2f971cb5%3A0x2fc1c81e183ed282!2sCoimbatore%2C%20Tamil%20Nadu!5e0!3m2!1sen!2sin!4v1699123456789!5m2!1sen!2sin" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>
    
    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form validation and animations
        document.addEventListener('DOMContentLoaded', function() {
            // Add animation classes on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate__fadeInUp');
                    }
                });
            }, observerOptions);

            // Observe elements for animation
            document.querySelectorAll('.contact-info-item').forEach(item => {
                observer.observe(item);
            });

            // Form input focus effects
            document.querySelectorAll('.form-control').forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentNode.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    if (!this.value) {
                        this.parentNode.classList.remove('focused');
                    }
                });
            });

            // Smooth scroll for quick contact buttons
            document.querySelectorAll('.quick-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    if (this.getAttribute('href').startsWith('#')) {
                        e.preventDefault();
                        const target = document.querySelector(this.getAttribute('href'));
                        if (target) {
                            target.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
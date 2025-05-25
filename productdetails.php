<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

// Get product category ID from URL
$categoryId = $_GET['id'] ?? 0;

// Get product category details
$category = $db->fetchOne("SELECT * FROM product_categories WHERE id = ?", [$categoryId]);

if (!$category) {
    header('Location: productrange.php');
    exit;
}

// Get products in this category
$products = $db->fetchAll("SELECT * FROM products WHERE category_id = ? AND is_active = 1 ORDER BY name", [$categoryId]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($category['name']); ?> - <?php echo htmlspecialchars($settings['site_name'] ?? 'Abonding'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        }
        
        .product-detail-section {
            padding: 100px 0 80px;
            position: relative;
        }

        .product-detail-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 200px;
            background: var(--gradient-green);
            opacity: 0.05;
            z-index: -1;
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            color: var(--primary-green);
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 30px;
            padding: 12px 20px;
            background: white;
            border-radius: 50px;
            box-shadow: var(--shadow-soft);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--border-light);
        }
        
        .back-link:hover {
            color: var(--dark-green);
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
            background: var(--light-green);
        }
        
        .back-link i {
            margin-right: 8px;
            font-size: 1.1rem;
        }

        .product-header {
            background: white;
            border-radius: 20px;
            padding: 50px;
            margin-bottom: 40px;
            box-shadow: var(--shadow-medium);
            border: 1px solid var(--border-light);
            position: relative;
            overflow: hidden;
        }

        .product-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: var(--gradient-green);
            opacity: 0.05;
            border-radius: 50%;
            transform: translate(50px, -50px);
        }
        
        .product-image {
            width: 100%;
            max-height: 400px;
            object-fit: contain;
            border-radius: 16px;
            box-shadow: var(--shadow-soft);
            background: white;
            padding: 20px;
            border: 1px solid var(--border-light);
        }
        
        .product-title {
            font-size: 3rem;
            font-weight: 700;
            background: var(--gradient-green);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .product-manufacturer {
            font-size: 1.1rem;
            color: var(--text-gray);
            margin-bottom: 25px;
            padding: 8px 16px;
            background: var(--light-green);
            border-radius: 50px;
            display: inline-block;
            font-weight: 500;
        }
        
        .product-description {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--text-dark);
            margin-bottom: 30px;
        }
        
        .section-card {
            background: white;
            border-radius: 16px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: var(--shadow-soft);
            border: 1px solid var(--border-light);
            transition: all 0.3s ease;
        }

        .section-card:hover {
            box-shadow: var(--shadow-medium);
            transform: translateY(-2px);
        }
        
        .section-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 25px;
            position: relative;
            padding-left: 20px;
        }

        .section-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 30px;
            background: var(--gradient-green);
            border-radius: 2px;
        }
        
        .section-content {
            font-size: 1.05rem;
            line-height: 1.7;
            color: var(--text-dark);
        }
        
        .products-grid {
            background: white;
            border-radius: 20px;
            padding: 50px;
            box-shadow: var(--shadow-medium);
            border: 1px solid var(--border-light);
        }

        .products-grid .section-title {
            text-align: center;
            font-size: 2.2rem;
            margin-bottom: 50px;
            padding-left: 0;
        }

        .products-grid .section-title::before {
            display: none;
        }

        .products-grid .section-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: var(--gradient-green);
            margin: 15px auto 0;
            border-radius: 2px;
        }
        
        .product-card {
            background: white;
            border: 1px solid var(--border-light);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .product-card::before {
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
        
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-large);
            border-color: var(--primary-green);
        }

        .product-card:hover::before {
            transform: scaleX(1);
        }
        
        .product-card img {
            width: 100%;
            height: 220px;
            object-fit: contain;
            margin-bottom: 20px;
            border-radius: 12px;
            background: #fafafa;
            padding: 15px;
        }
        
        .product-card h4 {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 15px;
            line-height: 1.3;
        }
        
        .product-card p {
            color: var(--text-gray);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 25px;
        }
        
        .btn-success {
            background: var(--gradient-green);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-soft);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn-success:hover {
            background: var(--dark-green);
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature-item {
            background: white;
            padding: 30px;
            border-radius: 12px;
            border-left: 4px solid var(--primary-green);
            box-shadow: var(--shadow-soft);
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            transform: translateX(5px);
            box-shadow: var(--shadow-medium);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .product-header {
                padding: 30px 25px;
            }
            
            .product-title {
                font-size: 2.2rem;
            }
            
            .section-card {
                padding: 25px;
            }
            
            .products-grid {
                padding: 30px 20px;
            }
            
            .product-card {
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .product-detail-section {
                padding: 80px 0 60px;
            }
            
            .product-title {
                font-size: 1.8rem;
            }
            
            .section-title {
                font-size: 1.5rem;
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
    
    <section class="product-detail-section">
        <div class="container">
            <a href="<?php echo BASE_URL; ?>/productrange.php" class="back-link">
                <i class="bi bi-arrow-left"></i> Back to Product Range
            </a>
            
            <div class="product-header">
                <div class="row align-items-center">
                    <div class="col-lg-5 mb-4 mb-lg-0">
                        <?php if ($category['image_path']): ?>
                        <img src="<?php echo BASE_URL . '/' . htmlspecialchars($category['image_path']); ?>" alt="<?php echo htmlspecialchars($category['name']); ?>" class="product-image">
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-7">
                        <h1 class="product-title"><?php echo htmlspecialchars($category['name']); ?></h1>
                        <?php if (!empty($category['manufacturer'])): ?>
                        <p class="product-manufacturer">
                            <i class="bi bi-building me-2"></i>
                            <?php echo htmlspecialchars($category['manufacturer']); ?>
                        </p>
                        <?php endif; ?>
                        <div class="product-description">
                            <?php echo nl2br(htmlspecialchars($category['description'])); ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if (!empty($category['applications'])): ?>
            <div class="section-card">
                <h3 class="section-title">
                    <i class="bi bi-gear-fill me-2"></i>
                    Applications
                </h3>
                <div class="section-content">
                    <?php echo nl2br(htmlspecialchars($category['applications'])); ?>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($category['benefits'])): ?>
            <div class="section-card">
                <h3 class="section-title">
                    <i class="bi bi-star-fill me-2"></i>
                    Benefits
                </h3>
                <div class="section-content">
                    <?php echo nl2br(htmlspecialchars($category['benefits'])); ?>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($products)): ?>
            <div class="products-grid">
                <h3 class="section-title">Products in this Category</h3>
                <div class="row">
                    <?php foreach ($products as $product): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="product-card">
                            <?php if ($product['image_path']): ?>
                            <img src="<?php echo BASE_URL . '/' . htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <?php endif; ?>
                            <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                            <p><?php echo htmlspecialchars(substr($product['description'], 0, 100)); ?>...</p>
                            <a href="#" class="btn btn-success">
                                <i class="bi bi-eye me-2"></i>
                                View Details
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>
    
    <?php include 'includes/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
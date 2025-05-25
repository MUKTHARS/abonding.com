<?php
// Ensure BASE_URL is defined
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/abonding.com');
}

// Load settings if not already loaded
if (!isset($settings)) {
    require_once __DIR__ . '/config.php';
    require_once __DIR__ . '/db.php';
    $db = new Database();
    $settings = $db->fetchOne("SELECT * FROM site_settings LIMIT 1") ?: [];
}
?>
<header class="header" id="header">
    <nav class="navbar container">
        <section class="navbar__left">
            <a href="<?php echo BASE_URL; ?>" class="brand" style="text-decoration: none;color:#019626;font-weight:700;font-size: 20px;">
                <img src="<?php echo BASE_URL . '/' . htmlspecialchars($settings['logo_path'] ?? 'assets/img/logo.png'); ?>" style="height:45px"/>
                <?php echo htmlspecialchars($settings['site_name'] ?? 'Abonding'); ?>
            </a>
        </section>
        
        <section class="navbar__center">
            <ul class="nav__links">
                <li><a href="<?php echo BASE_URL; ?>" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Home</a></li>
                <li><a href="<?php echo BASE_URL; ?>/aboutus.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'aboutus.php' ? 'active' : ''; ?>">About Us</a></li>
                <li><a href="<?php echo BASE_URL; ?>/productrange.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'productrange.php' ? 'active' : ''; ?>">Product Range</a></li>
                <li><a href="<?php echo BASE_URL; ?>/industries.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'industries.php' ? 'active' : ''; ?>">Industries</a></li>
                <li><a href="<?php echo BASE_URL; ?>/contactus.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'contactus.php' ? 'active' : ''; ?>">Contact Us</a></li>
            </ul>
        </section>
        
        <section class="navbar__right">
            <div class="search-box">
                <form action="<?php echo BASE_URL; ?>/search.php" method="get">
                    <input type="text" name="q" placeholder="Search..." class="search-input">
                    <button type="submit" class="search-button">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </section>
        
        <div class="mobile-menu-toggle">
            <i class="bi bi-list"></i>
        </div>
    </nav>
</header>
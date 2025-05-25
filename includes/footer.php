<footer>
    <div class="up-section">
        <a href="<?php echo BASE_URL; ?>" class="f-logo">
            <?php echo htmlspecialchars($settings['site_name'] ?? 'Abonding'); ?>
        </a>

        <ul>
            <h1>Quick links</h1>
            <li><a href="<?php echo BASE_URL; ?>" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Home</a></li>
                <li><a href="<?php echo BASE_URL; ?>/aboutus.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'aboutus.php' ? 'active' : ''; ?>">About Us</a></li>
                <li><a href="<?php echo BASE_URL; ?>/productrange.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'productrange.php' ? 'active' : ''; ?>">Product Range</a></li>
                <li><a href="<?php echo BASE_URL; ?>/industries.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'industries.php' ? 'active' : ''; ?>">Industries</a></li>
                <li><a href="<?php echo BASE_URL; ?>/contactus.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'contactus.php' ? 'active' : ''; ?>">Contact Us</a></li>
           
        </ul>

        <ul>
            <h1>About</h1>
            <li><a href="<?php echo BASE_URL; ?>/aboutus#company">Company</a></li>
            <li><a href="<?php echo BASE_URL; ?>/contactus#location">Location</a></li>
            <li><a href="<?php echo BASE_URL; ?>/aboutus">About</a></li>
            <li><a href="<?php echo BASE_URL; ?>/productrange.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'productrange.php' ? 'active' : ''; ?>">Our Products</a></li>
               
        </ul>
        
        <div class="social">
            <h1>Social</h1>
            <div class="social-icons">
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-youtube"></i></a>
            </div>
        </div>
    </div>
    <p class="copyright">
        <span class="f-logo"><?php echo htmlspecialchars($settings['site_name'] ?? 'Abonding'); ?></span>
        <?php echo htmlspecialchars($settings['footer_copyright'] ?? 'Copyright ' . date('Y')); ?>
    </p>
</footer>   

<div class="bodydiv">
    <div class="btn-group my mb-3" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-success"><i class="bi my bi-whatsapp"></i></button>
        <a href="https://wa.me/<?php echo htmlspecialchars($settings['contact_whatsapp'] ?? '919442576397'); ?>" target="_blank" type="button" class="btn btn-light">Whatsapp:<br><?php echo htmlspecialchars($settings['contact_whatsapp'] ?? '+91 94425 76397'); ?></a>
    </div>
    <div class="btn-group my" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-success"><i class="bi my bi-telephone-fill"></i></button>
        <a href="tel:<?php echo htmlspecialchars($settings['contact_phone'] ?? '+919442576397'); ?>" type="button" class="btn btn-light">Call:<br><?php echo htmlspecialchars($settings['contact_phone'] ?? '+91 94425 76397'); ?></a>
    </div>
</div>

<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Search Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="searchForm">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search products..." autocomplete="off">
                        <button type="submit" class="btn btn-success">Search</button>
                    </div>
                </form>
                <div id="searchResults" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>

<!-- Include all your JS files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>
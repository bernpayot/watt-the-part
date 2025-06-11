<?php
// Only include main.js if we're not on the build page
if (basename($_SERVER['PHP_SELF']) !== 'build.php') {
    echo '<script src="main.js" defer></script>';
}
?>
    <footer class="footer">
        <div class="footer-container">
          <div class="footer-about">
            <img src="assets/logo pink no bg.png" alt="Logo" class="footer-logo" />
            <h3>WattThePart</h3>
            <p>
              We're a team of tech enthusiasts, builders, and gamers passionate about making PC building easier for everyone.
              Whether you're assembling your first rig or upgrading for peak performance, our platform gives you the tools to
              explore, compare, and create the perfect setup—without the stress.
            </p>
          </div>

          <div class="footer-explore">
            <h4>Explore More</h4>
            <ul>
              <li><a href="#">About Us</a></li>
              <li><a href="#">Feature</a></li>
              <li><a href="#">FAQS</a></li>
              <li><a href="#">Build</a></li>
              <li><a href="#">Parts</a></li>
            </ul>
          </div>

          <div class="footer-contact">
            <h4>Contact Us</h4>
            <ul>
              <li><i class="fas fa-location-dot"></i> Jl. Medan Merdeka No. 35<br>Jakarta Selatan</li>
              <li><i class="fas fa-phone"></i> (021) 234567</li>
              <li><i class="fas fa-mobile-alt"></i> +62 812 9188 72</li>
            </ul>
          </div>
        </div>

        <div class="footer-bottom">
          <p>WattThePart 2025 © All rights reserved</p>
          <a href="#">Terms & Conditions</a>
        </div>
    </footer>
</body>
</html>
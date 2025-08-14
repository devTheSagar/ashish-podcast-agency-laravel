
 <!-- footer start -->
  <footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <!-- Column 1 -->
      <div class="footer-col">
        <h3>About Us</h3>
        <ul>
          <li><a href="#">About Company</a></li>
          <li><a href="#">Team</a></li>
          <li><a href="#">Testimonials</a></li>
        </ul>
      </div>

      <!-- Column 2 -->
      <div class="footer-col">
        <h3>What We Offer</h3>
        <ul>
          <li><a href="#">Pricing</a></li>
          <li><a href="#">Blog</a></li>
          <li><a href="#">FAQ</a></li>
        </ul>
      </div>

      <!-- Column 3 -->
      <div class="footer-col">
        <h3>Support</h3>
        <ul>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Get the App</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </div>

      <!-- Column 4 (Social links you already had) -->
      <div class="footer-col">
        <h3>Follow Us</h3>
        <div class="social-links">
          <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
          <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
    </div>
  </div>
</footer>
  <!-- footer end -->
</div>
<!-- page wrapper end -->


<!-- style switcher start  -->
<div class="style-switcher js-style-switcher">
  <button type="button" class="style-switcher-toggler js-style-switcher-toggler">
    <i class="fas fa-cog"></i>
  </button>
  <div class="style-switcher-main">
    <h2>style switcher</h2>
    <div class="style-switcher-item">
      <p>Theme Color</p>
      <div class="theme-color">
        <input type="range" min="0" max="360" class="hue-slider js-hue-slider">
        <div class="hue">Hue: <span class="js-hue"></span></div>
      </div>
    </div>
    <div class="style-switcher-item">
      <label class="form-switch">
        <span>Dark Mode</span>
        <input type="checkbox" class="js-dark-mode">
        <div class="box"></div>
      </label>
    </div>
  </div>
</div>
<!-- style switcher end  -->

<script src="{{ asset('') }}frontend/assets/js/aos.js"></script>
<script src="{{ asset('') }}frontend/assets/js/main.js"></script>
<script src="{{ asset('') }}frontend/assets/js/style-switcher.js"></script>
</body>
</html>
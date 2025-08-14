<!-- footer start -->
  <footer class="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">
          <div class="col-sm-6 col-lg-3">
            <div class="footer-item">
              <h3 class="footer-logo"><span>podcast</span>rank</h3>
              <ul>
                <li><a href="{{ route('user.about-us') }}">about us</a></li>
                {{-- <li><a href="#">what we offer</a></li> --}}
                <li><a href="#">team</a></li>
                <li><a href="{{ route('user.privacy-policy') }}">privacy policy</a></li>
                <li><a href="#">blog</a></li>
              </ul>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="footer-item">
              {{-- <h3>learning</h3> --}}
              <ul class="mt-5">
                {{-- <li><a href="#">get the app</a></li> --}}
                <li><a href="{{ route('user.testimonials') }}">testimonials</a></li>
                <li><a href="{{ route('user.pricing') }}">pricing</a></li>
                <li><a href="{{ route('user.faqs') }}">faq</a></li>
              </ul>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="footer-item">
              <h3>more</h3>
              <ul>
                <li><a href="#">affiliates</a></li>
                <li><a href="#">become a member</a></li>
                <li><a href="#">training webinars</a></li>
                <li><a href="#">free personality test</a></li>
                <li><a href="{{ route('user.message') }}">help and support</a></li>
              </ul>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="footer-item">
              <h3>get in touch</h3>
              <ul>
                @if(!empty($socialLinks?->facebookLink))
                  <li><a href="{{ $socialLinks->facebookLink }}" target="_blank"><i class="fab fa-facebook social-icon"></i> facebook</a></li>
                @endif

                @if(!empty($socialLinks?->twitterLink))
                  <li><a href="{{ $socialLinks->twitterLink }}" target="_blank"><i class="fab fa-twitter social-icon"></i> twitter</a></li>
                @endif

                @if(!empty($socialLinks?->instagramLink))
                  <li><a href="{{ $socialLinks->instagramLink }}" target="_blank"><i class="fab fa-instagram social-icon"></i> instagram</a></li>
                @endif

                @if(!empty($socialLinks?->youtubeLink))
                  <li><a href="{{ $socialLinks->youtubeLink }}" target="_blank"><i class="fab fa-youtube social-icon"></i> youtube</a></li>
                @endif

                @if(!empty($socialLinks?->linkedinLink))
                  <li><a href="{{ $socialLinks->linkedinLink }}" target="_blank"><i class="fab fa-linkedin social-icon"></i> linkedin</a></li>
                @endif
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <div class="container">
        <p class="m-0 py-4 text-center">Copyright &copy;2025 Podcast Rank | Developed by <a href="https://devsagar.online" target="_blank">Avijit Sagar</a></p>
      </div>
    </div>
  </footer>
  <!-- footer end -->

</div>
<!-- main wrapper end -->

<!-- style switcher start -->
<div class="style-switcher js-style-switcher">
   <div class="style-switcher-toggler js-style-switcher-toggler">
     <i class="fas fa-cog"></i>
   </div>
   <h3>Style Switcher</h3>
   <div class="style-switcher-item">
     <p class="mb-2">Theme Colors</p>
     <!-- theme colors -->
     <div class="theme-colors js-theme-colors">
       <button type="button" data-js-theme-color="color-1" class="js-theme-color-item color-1"></button>
       <button type="button" data-js-theme-color="color-2" class="js-theme-color-item color-2"></button>
       <button type="button" data-js-theme-color="color-3" class="js-theme-color-item color-3"></button>
       <button type="button" data-js-theme-color="color-4" class="js-theme-color-item color-4"></button>
       <button type="button" data-js-theme-color="color-5" class="js-theme-color-item color-5"></button>
     </div>
   </div>
   <div class="style-switcher-item">
    <div class="form-check form-switch">
      <input class="form-check-input js-dark-mode" type="checkbox" role="switch" id="dark-mode">
      <label class="form-check-label" for="dark-mode">Dark Mode</label>
    </div>
   </div>
   <div class="style-switcher-item">
    <div class="form-check form-switch">
      <input class="form-check-input js-glass-effect" type="checkbox" role="switch" id="glass-effect">
      <label class="form-check-label" for="glass-effect">Glass Effect</label>
    </div>
   </div>
</div>
<!-- style switcher end -->


<script src="{{ asset('') }}frontend/assets/js/bootstrap.bundle.min.js"></script>  
<script src="{{ asset('') }}frontend/assets/js/main.js"></script>
</body>
</html>
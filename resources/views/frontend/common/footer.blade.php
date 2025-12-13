
 <!-- footer start -->
  <footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <!-- Column 1 -->
      <div class="footer-col">
        <h3>About Us</h3>
        <ul>
          <li><a href="{{ route('user.about-us') }}">About Company</a></li>
          <li><a href="#">Team</a></li>
          <li><a href="{{ route('user.testimonials') }}">Testimonials</a></li>
        </ul>
      </div>

      <!-- Column 2 -->
      <div class="footer-col">
        <h3>What We Offer</h3>
        <ul>
          <li><a href="{{ route('user.pricing') }}">Pricing</a></li>
          <li><a href="#">Blog</a></li>
          <li><a href="{{ route('user.faqs') }}">FAQ</a></li>
        </ul>
      </div>

      <!-- Column 3 -->
      <div class="footer-col">
        <h3>Support</h3>
        <ul>
          <li><a href="{{ route('user.privacy-policy') }}">Privacy Policy</a></li>
          <li><a href="#">Get the App</a></li>
          <li><a href="{{ route('user.message') }}">Contact</a></li>
        </ul>
      </div>

      <!-- Column 4 (Social links you already had) -->
      <div class="footer-col">
        <h3>Follow Us</h3>
        <div class="social-links">
          @if(!empty($socialLinks?->facebookLink))
            <a href="{{ $socialLinks->facebookLink }}" target="_blank" rel="noopener" title="Facebook" aria-label="Facebook">
              <i class="fab fa-facebook-f"></i>
            </a>
          @endif

          @if(!empty($socialLinks?->twitterLink))
            <a href="{{ $socialLinks->twitterLink }}" target="_blank" rel="noopener" title="Twitter" aria-label="Twitter">
              <i class="fab fa-twitter"></i>
            </a>
          @endif

          @if(!empty($socialLinks?->instagramLink))
            <a href="{{ $socialLinks->instagramLink }}" target="_blank" rel="noopener" title="Instagram" aria-label="Instagram">
              <i class="fab fa-instagram"></i>
            </a>
          @endif

          @if(!empty($socialLinks?->youtubeLink))
            <a href="{{ $socialLinks->youtubeLink }}" target="_blank" rel="noopener" title="YouTube" aria-label="YouTube">
              <i class="fab fa-youtube"></i>
            </a>
          @endif

          @if(!empty($socialLinks?->linkedinLink))
            <a href="{{ $socialLinks->linkedinLink }}" target="_blank" rel="noopener" title="LinkedIn" aria-label="LinkedIn">
              <i class="fab fa-linkedin"></i>
            </a>
          @endif
        </div>

      </div>
    </div>
    <!-- Copyright -->
    
  </div>
</footer>
<div class="footer-bottom" style="margin-top: 2vh; margin-bottom: 0px; text-align: center;">
  <p>&copy; {{ date('Y') }} PodcastGrowth.agency All Rights Reserved</p>
</div>
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


{{-- script for service details tabs  --}}
<script>
  (function(){
    const tabs = document.querySelectorAll('.service-tabs .tab-btn');
    const panes = document.querySelectorAll('.tab-panes .tab-pane');
    tabs.forEach(btn=>{
      btn.addEventListener('click', ()=>{
        const id = btn.dataset.tab;
        tabs.forEach(b=>b.classList.remove('active'));
        panes.forEach(p=>p.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('tab-'+id).classList.add('active');
      });
    });
  })();
</script>




<script>
  (function () {
    const listEl  = document.getElementById('reviewsList');
    const moreBtn = document.getElementById('loadMoreReviews');
    const filterEl = document.getElementById('reviewFilter'); // optional (if you kept the filter)
    const emptyMsg = document.getElementById('noReviewsMsg');

    if (!listEl || !moreBtn) return;
    if (listEl.dataset.moreInit === '1') return; // guard against double init
    listEl.dataset.moreInit = '1';

    const PAGE_SIZE = 3;

    // Capture original review nodes once
    const allItems = Array.from(listEl.querySelectorAll('.review'));
    // Clear container so we control rendering
    listEl.innerHTML = '';

    let filtered = allItems.slice(); // start with all reviews
    let nextIndex = 0;

    function clearList() {
      while (listEl.firstChild) listEl.removeChild(listEl.firstChild);
    }

    function renderReset() {
      clearList();
      nextIndex = 0;
      renderMore();
    }

    function renderMore() {
      // Handle empty state
      if (filtered.length === 0) {
        if (emptyMsg) emptyMsg.style.display = 'block';
        moreBtn.style.display = 'none';
        return;
      } else {
        if (emptyMsg) emptyMsg.style.display = 'none';
      }

      const end = Math.min(nextIndex + PAGE_SIZE, filtered.length);
      for (let i = nextIndex; i < end; i++) {
        filtered[i].style.display = 'flex'; // your .review rows are flex
        listEl.appendChild(filtered[i]);     // move original node, no clones
      }
      nextIndex = end;

      // Toggle "More" button visibility
      moreBtn.style.display = (nextIndex >= filtered.length) ? 'none' : 'inline-block';
    }

    // Optional: hook up star filter if present
    function applyFilter() {
      if (!filterEl) { renderReset(); return; }
      const val = filterEl.value.trim(); // "", "5", "4", ...
      filtered = allItems.filter(item => {
        const r = (item.dataset.rating || '').toString();
        return !val || r === val;
      });
      renderReset();
    }

    // Events
    moreBtn.addEventListener('click', renderMore);
    if (filterEl) filterEl.addEventListener('change', applyFilter);

    // Initial paint
    applyFilter(); // (calls renderReset internally)
  })();
</script>

</body>
</html>
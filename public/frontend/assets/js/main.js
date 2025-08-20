
window.addEventListener("load", () => {
  const preloader = document.querySelector(".js-preloader");
  preloader.classList.add("fade-out");

  setTimeout(() => {
    preloader.style.display = "none";
    /* animate on scroll */  
   AOS.init();
  }, 600);
});

/* header bg reveal */ 

const headerBg = () => {
  const header = document.querySelector(".js-header");
  
  window.addEventListener("scroll", function() {
   if(this.scrollY > 0){
     header.classList.add("bg-reveal");
   }
   else{
    header.classList.remove("bg-reveal");
   }
  });
}
headerBg();


/* nav */ 

/* nav */
(function navigation(){
  const navToggler = document.querySelector(".js-nav-toggler");
  const nav = document.querySelector(".js-nav");
  if (!nav || !navToggler) return;

  const isMobile = () => window.innerWidth <= 767;

  const openNav = () => {
    nav.classList.add("open");
    navToggler.classList.add("active");
  };
  const closeNav = () => {
    nav.classList.remove("open");
    navToggler.classList.remove("active");
    // collapse any open mobile dropdowns
    nav.querySelectorAll(".dropdown.open").forEach(li => li.classList.remove("open"));
  };
  const toggleNav = () => (nav.classList.contains("open") ? closeNav() : openNav());

  // burger button
  navToggler.addEventListener("click", (e) => {
    e.stopPropagation();
    toggleNav();
  });

  // delegate taps inside the nav
  nav.addEventListener("click", (e) => {
    const link = e.target.closest("a");
    if (!link) return;

    const li = link.closest("li");
    const isDropdownParent = li?.classList.contains("dropdown") && link.parentElement === li;
    const inSubmenu = !!link.closest(".dropdown-menu");

    // MOBILE: tapping dropdown label toggles submenu (do NOT close drawer)
    if (isMobile() && isDropdownParent) {
      e.preventDefault();           // don’t navigate on the label
      e.stopPropagation();

      // (optional) close other open dropdowns
      li.parentElement.querySelectorAll(".dropdown.open").forEach(el => {
        if (el !== li) el.classList.remove("open");
      });

      li.classList.toggle("open");  // second tap closes it
      return;
    }

    // MOBILE: tapping a submenu item closes the drawer (allow navigation)
    if (isMobile() && inSubmenu) {
      closeNav();
      return;
    }

    // MOBILE: tapping a regular top-level link closes the drawer
    if (isMobile() && !isDropdownParent) {
      closeNav();
    }
  });

  // click outside closes drawer (mobile)
  document.addEventListener("click", (e) => {
    if (!isMobile()) return;
    if (!nav.contains(e.target) && !navToggler.contains(e.target)) closeNav();
  });

  // on resize, reset mobile states when going desktop
  window.addEventListener("resize", () => {
    if (!isMobile()) closeNav();
  });
})();



(function(){
    const pw = document.getElementById('password');
    const btn = document.querySelector('.pw-toggle');
    if (pw && btn){
      btn.addEventListener('click', ()=>{
        const isHidden = pw.getAttribute('type') === 'password';
        pw.setAttribute('type', isHidden ? 'text' : 'password');
        btn.textContent = isHidden ? 'Hide' : 'Show';
        btn.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
      });
    }
  })();


  (function(){
    // Toggle password visibility
    document.querySelectorAll('.pw-toggle').forEach(btn=>{
      btn.addEventListener('click', ()=>{
        const id = btn.getAttribute('data-target');
        const input = document.getElementById(id);
        if(!input) return;
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        btn.textContent = isHidden ? 'Hide' : 'Show';
        btn.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
      });
    });

    // Very simple strength checker
    const pw = document.getElementById('su-password');
    const bars = Array.from(document.querySelectorAll('#pwStrength .bar'));
    const label = document.querySelector('#pwStrength .label');
    const conf = document.getElementById('su-confirm');
    const hint = document.getElementById('matchHint');

    function scorePassword(val){
      let score = 0;
      if(!val) return 0;
      if(val.length >= 6) score++;
      if(/[A-Z]/.test(val)) score++;
      if(/[0-9]/.test(val)) score++;
      if(/[^A-Za-z0-9]/.test(val)) score++;
      return Math.min(score, 4);
    }

    function updateStrength(){
      const s = scorePassword(pw.value);
      bars.forEach((b,i)=> b.classList.toggle('on', i < s));
      const text = ['Very weak','Weak','Good','Strong','Strong'][s] || '—';
      label.textContent = 'Strength: ' + text;
    }

    function checkMatch(){
      if(!conf.value) { hint.textContent = ''; return; }
      if(pw.value === conf.value){
        hint.style.color = 'green';
        hint.textContent = 'Passwords match';
      }else{
        hint.style.color = 'crimson';
        hint.textContent = 'Passwords do not match';
      }
    }

    if(pw){ pw.addEventListener('input', ()=>{ updateStrength(); checkMatch(); }); }
    if(conf){ conf.addEventListener('input', checkMatch); }

    // basic submit guard
    const form = document.getElementById('signupForm');
    if(form){
      form.addEventListener('submit', (e)=>{
        if(pw.value !== conf.value){
          e.preventDefault();
          conf.focus();
          hint.style.color = 'crimson';
          hint.textContent = 'Passwords do not match';
        }
      });
    }

    updateStrength();
  })();

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
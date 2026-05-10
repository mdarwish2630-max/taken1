<!-- ============================== -->
<!-- Nove Theme Scripts             -->
<!-- ============================== -->

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ----------------------------------
       1. Fade-up on Scroll (IntersectionObserver)
    ---------------------------------- */
    const fadeElements = document.querySelectorAll('.fade-up');

    if ('IntersectionObserver' in window) {
        const fadeObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    fadeObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.15,
            rootMargin: '0px 0px -40px 0px'
        });

        fadeElements.forEach(function (el) {
            fadeObserver.observe(el);
        });
    } else {
        fadeElements.forEach(function (el) {
            el.classList.add('visible');
        });
    }

    /* ----------------------------------
       2. Navbar Scroll Behavior
    ---------------------------------- */
    var navbar = document.getElementById('noveNavbar');
    var scrollThreshold = 100;

    function handleNavbarScroll() {
        if (!navbar) return;
        if (window.scrollY > scrollThreshold) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    }

    window.addEventListener('scroll', handleNavbarScroll, { passive: true });
    handleNavbarScroll();

    /* ----------------------------------
       3. Mobile Menu Toggle
    ---------------------------------- */
    var mobileToggle = document.getElementById('noveMobileToggle');
    var mobileMenu = document.getElementById('noveMobileMenu');

    if (mobileToggle && mobileMenu) {
        mobileToggle.addEventListener('click', function () {
            var isHidden = mobileMenu.classList.contains('hidden');

            if (isHidden) {
                mobileMenu.classList.remove('hidden');
                mobileToggle.innerHTML = '<i class="fas fa-xmark"></i>';
            } else {
                mobileMenu.classList.add('hidden');
                mobileToggle.innerHTML = '<i class="fas fa-bars"></i>';
            }
        });

        var mobileLinks = mobileMenu.querySelectorAll('.mobile-nav-link');
        mobileLinks.forEach(function (link) {
            link.addEventListener('click', function () {
                mobileMenu.classList.add('hidden');
                mobileToggle.innerHTML = '<i class="fas fa-bars"></i>';
            });
        });
    }

    /* ----------------------------------
       4. Smooth Scroll for Anchor Links
    ---------------------------------- */
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            var href = this.getAttribute('href');
            if (!href || href === '#') return;

            var target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                var offsetTop = target.getBoundingClientRect().top + window.scrollY - 140;
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });

    /* ----------------------------------
       5. Remove overflow-hidden on body
    ---------------------------------- */
    setTimeout(function () {
        document.body.classList.remove('overflow-hidden');
    }, 100);

});
</script>

<!-- Navbar scroll styles -->
<style>
    #noveNavbar.navbar-scrolled {
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.15);
    }
</style>

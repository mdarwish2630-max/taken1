<!-- Rakaz Theme Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* 1. Fade-up on Scroll */
    const fadeElements = document.querySelectorAll('.fade-up');
    if ('IntersectionObserver' in window) {
        const fadeObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    fadeObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
        fadeElements.forEach(function (el) { fadeObserver.observe(el); });
    } else {
        fadeElements.forEach(function (el) { el.classList.add('visible'); });
    }

    /* 2. Navbar Scroll */
    var navbar = document.getElementById('rakazNavbar');
    function handleScroll() {
        if (!navbar) return;
        if (window.scrollY > 80) {
            navbar.classList.add('shadow-xl');
            navbar.classList.remove('shadow-lg');
        } else {
            navbar.classList.remove('shadow-xl');
            navbar.classList.add('shadow-lg');
        }
    }
    window.addEventListener('scroll', handleScroll, { passive: true });

    /* 3. Mobile Menu Toggle */
    var mobileToggle = document.getElementById('rakazMobileToggle');
    var mobileMenu = document.getElementById('rakazMobileMenu');
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
        mobileMenu.querySelectorAll('.mobile-nav-link').forEach(function (link) {
            link.addEventListener('click', function () {
                mobileMenu.classList.add('hidden');
                mobileToggle.innerHTML = '<i class="fas fa-bars"></i>';
            });
        });
    }

    /* 4. Smooth Scroll for Anchors */
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            var href = this.getAttribute('href');
            if (!href || href === '#') return;
            var target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                window.scrollTo({ top: target.getBoundingClientRect().top + window.scrollY - 120, behavior: 'smooth' });
            }
        });
    });

    /* 5. Remove overflow-hidden */
    setTimeout(function () { document.body.classList.remove('overflow-hidden'); }, 100);
});
</script>

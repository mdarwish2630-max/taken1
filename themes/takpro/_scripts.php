<?php
/**
 * TakPro Theme — Scripts & Floating Elements Partial
 */
$whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
$waNumber = preg_replace('/[^0-9+]/', '', $whatsapp);
?>
<!-- ═══════ WHATSAPP FLOAT ═══════ -->
<?php if ($waNumber): ?>
<a href="https://wa.me/<?= $waNumber ?>" target="_blank"
   class="fixed bottom-6 <?= ($dir ?? 'rtl') === 'rtl' ? 'left-6' : 'right-6' ?> z-[1000] w-14 h-14 bg-[#25D366] rounded-full flex items-center justify-center text-white text-2xl shadow-lg shadow-[#25D366]/40 hover:scale-110 transition-transform pulse-glow">
    <i class="fab fa-whatsapp"></i>
</a>
<?php endif; ?>

<!-- ═══════ BACK TO TOP ═══════ -->
<button id="takproBackTop" class="fixed bottom-24 <?= ($dir ?? 'rtl') === 'rtl' ? 'left-6' : 'right-6' ?> z-[999] w-11 h-11 bg-brand rounded-full flex items-center justify-center text-white shadow-lg shadow-brand/30 opacity-0 invisible translate-y-4 transition-all duration-300 hover:bg-brand-dark">
    <i class="fas fa-chevron-up"></i>
</button>

<!-- ═══════ JAVASCRIPT ═══════ -->
<script>
(() => {
    const $ = s => document.querySelector(s);
    const $$ = s => document.querySelectorAll(s);

    /* Navbar scroll effect */
    const navbar = $('#takproNavbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            const inner = navbar.querySelector('.max-w-7xl > div');
            if (inner) {
                if (window.scrollY > 60) {
                    inner.classList.add('sticky', 'top-0', 'shadow-2xl');
                    inner.style.position = 'sticky';
                    inner.style.top = '0';
                    inner.style.zIndex = '1050';
                } else {
                    inner.classList.remove('sticky', 'top-0', 'shadow-2xl');
                    inner.style.position = '';
                    inner.style.top = '';
                    inner.style.zIndex = '';
                }
            }
        });
    }

    /* Mobile menu toggle */
    const mobileToggle = $('#takproMobileToggle');
    const mobileMenu = $('#takproMobileMenu');
    const menuIcon = $('#takproMenuIcon');
    if (mobileToggle && mobileMenu) {
        mobileToggle.addEventListener('click', () => {
            const isOpen = !mobileMenu.classList.contains('hidden');
            mobileMenu.classList.toggle('hidden');
            menuIcon.className = isOpen ? 'fas fa-bars text-lg' : 'fas fa-times text-lg';
        });
    }

    /* Back to top */
    const backTop = $('#takproBackTop');
    if (backTop) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 400) {
                backTop.classList.remove('opacity-0', 'invisible', 'translate-y-4');
            } else {
                backTop.classList.add('opacity-0', 'invisible', 'translate-y-4');
            }
        });
        backTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    }

    /* Scroll animations */
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

    $$('.fade-up').forEach(el => observer.observe(el));

    /* Counter animation for stats */
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = parseInt(entry.target.getAttribute('data-count'));
                const suffix = entry.target.getAttribute('data-suffix') || '';
                let current = 0;
                const increment = Math.ceil(target / 60);
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    entry.target.textContent = current.toLocaleString() + suffix;
                }, 30);
                counterObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    $$('[data-count]').forEach(el => counterObserver.observe(el));
})();
</script>

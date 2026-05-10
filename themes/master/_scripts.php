<?php
/**
 * Master Theme — Scripts & Floating Elements Partial
 */
$whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
$waNumber = preg_replace('/[^0-9+]/', '', $whatsapp);
?>
<!-- ═══════ WHATSAPP FLOAT ═══════ -->
<?php if ($waNumber): ?>
<a href="https://wa.me/<?= $waNumber ?>" target="_blank"
   class="fixed bottom-6 <?= ($dir ?? 'rtl') === 'rtl' ? 'left-6' : 'right-6' ?> z-[1000] w-14 h-14 bg-[#25D366] rounded-full flex items-center justify-center text-white text-2xl shadow-lg shadow-[#25D366]/40 hover:scale-110 transition-transform">
    <i class="fab fa-whatsapp"></i>
</a>
<?php endif; ?>

<!-- ═══════ BACK TO TOP ═══════ -->
<button id="masterBackTop" class="fixed bottom-24 <?= ($dir ?? 'rtl') === 'rtl' ? 'left-6' : 'right-6' ?> z-[999] w-11 h-11 bg-cyan-500 rounded-full flex items-center justify-center text-white shadow-lg shadow-cyan-500/30 opacity-0 invisible translate-y-4 transition-all duration-300 hover:bg-cyan-400">
    <i class="fas fa-chevron-up"></i>
</button>

<!-- ═══════ JAVASCRIPT ═══════ -->
<script>
(() => {
    const $ = s => document.querySelector(s);
    const $$ = s => document.querySelectorAll(s);

    /* Navbar scroll effect */
    const navbar = $('#masterNavbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('border-white/10', window.scrollY > 60);
        navbar.classList.toggle('bg-[#0f172a]/90', window.scrollY > 60);
        navbar.classList.toggle('shadow-lg', window.scrollY > 60);
    });

    /* Mobile menu toggle */
    const mobileToggle = $('#masterMobileToggle');
    const mobileMenu = $('#masterMobileMenu');
    const menuIcon = $('#masterMenuIcon');
    if (mobileToggle && mobileMenu) {
        mobileToggle.addEventListener('click', () => {
            const isOpen = !mobileMenu.classList.contains('hidden');
            mobileMenu.classList.toggle('hidden');
            menuIcon.className = isOpen ? 'fas fa-bars text-lg' : 'fas fa-times text-lg';
        });
    }

    /* Back to top */
    const backTop = $('#masterBackTop');
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
})();
</script>

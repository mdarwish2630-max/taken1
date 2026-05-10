<?php
/**
 * Tek Pro Theme — Scripts & Floating Elements Partial
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
<button id="tekProBackTop" class="fixed bottom-24 <?= ($dir ?? 'rtl') === 'rtl' ? 'left-6' : 'right-6' ?> z-[999] w-11 h-11 bg-[#ff7a00] rounded-full flex items-center justify-center text-white shadow-lg shadow-[#ff7a00]/30 opacity-0 invisible translate-y-4 transition-all duration-300 hover:bg-[#e86e00]">
    <i class="fas fa-chevron-up"></i>
</button>

<!-- ═══════ JAVASCRIPT ═══════ -->
<script>
(() => {
    const $ = s => document.querySelector(s);
    const $$ = s => document.querySelectorAll(s);

    /* Navbar scroll effect */
    const navbar = $('#tekProNavbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 60) {
                navbar.classList.add('shadow-2xl');
            } else {
                navbar.classList.remove('shadow-2xl');
            }
        });
    }

    /* Mobile menu toggle */
    const mobileToggle = $('#tekProMobileToggle');
    const mobileMenu = $('#tekProMobileMenu');
    const menuIcon = $('#tekProMenuIcon');
    if (mobileToggle && mobileMenu) {
        mobileToggle.addEventListener('click', () => {
            const isOpen = !mobileMenu.classList.contains('hidden');
            mobileMenu.classList.toggle('hidden');
            menuIcon.className = isOpen ? 'fas fa-bars text-lg' : 'fas fa-times text-lg';
        });
    }

    /* Back to top */
    const backTop = $('#tekProBackTop');
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

    /* FAQ accordion (if exists on page) */
    $$('.faq-toggle').forEach(btn => {
        btn.addEventListener('click', () => {
            const item = btn.closest('.faq-item');
            const answer = item.querySelector('.faq-answer');
            const icon = item.querySelector('.faq-icon i');
            const isOpen = btn.getAttribute('aria-expanded') === 'true';

            // Close all others
            $$('.faq-item').forEach(other => {
                if (other !== item) {
                    other.querySelector('.faq-answer').style.maxHeight = '0';
                    other.querySelector('.faq-toggle').setAttribute('aria-expanded', 'false');
                    other.querySelector('.faq-icon i').className = 'fas fa-plus';
                }
            });

            if (isOpen) {
                answer.style.maxHeight = '0';
                btn.setAttribute('aria-expanded', 'false');
                icon.className = 'fas fa-plus';
            } else {
                answer.style.maxHeight = answer.scrollHeight + 'px';
                btn.setAttribute('aria-expanded', 'true');
                icon.className = 'fas fa-minus';
            }
        });
    });

    /* FAQ search (if exists) */
    const faqSearch = $('#faqSearch');
    if (faqSearch) {
        faqSearch.addEventListener('input', () => {
            const query = faqSearch.value.toLowerCase().trim();
            $$('.faq-item').forEach(item => {
                const q = (item.dataset.faqQuestion || '').toLowerCase();
                const a = (item.dataset.faqAnswer || '').toLowerCase();
                item.style.display = (!query || q.includes(query) || a.includes(query)) ? '' : 'none';
            });
            const noResults = $('#faqNoResults');
            if (noResults) {
                const anyVisible = [...$$('.faq-item')].some(i => i.style.display !== 'none');
                noResults.classList.toggle('hidden', anyVisible);
            }
        });
    }

    /* Gallery filter (if exists) */
    $$('.gallery-filter-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            $$('.gallery-filter-btn').forEach(b => {
                b.classList.remove('active-filter', 'bg-[#ff7a00]/20', 'border-[#ff7a00]/40', 'text-[#ff7a00]');
                b.classList.add('text-gray-500');
            });
            btn.classList.add('active-filter', 'bg-[#ff7a00]/20', 'border-[#ff7a00]/40', 'text-[#ff7a00]');
            btn.classList.remove('text-gray-500');

            const filter = btn.dataset.galleryFilter;
            $$('.gallery-item').forEach(item => {
                item.style.display = (filter === 'all' || item.dataset.category === filter) ? '' : 'none';
            });
        });
    });
})();
</script>

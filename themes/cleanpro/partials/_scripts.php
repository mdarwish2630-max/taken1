<?php
/**
 * CleanPro Theme — Scripts & Floating Elements Partial
 */
$whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
$waNumber = preg_replace('/[^0-9+]/', '', $whatsapp);
?>
<!-- WhatsApp Float -->
<?php if ($waNumber): ?>
<a href="https://wa.me/<?= $waNumber ?>" target="_blank"
   class="cpro-wa-float" style="position:fixed;bottom:24px;<?= ($dir ?? 'rtl') === 'rtl' ? 'left' : 'right' ?>:24px;z-index:1000;width:56px;height:56px;background:#25D366;border-radius:50%;display:grid;place-items:center;color:#fff;font-size:26px;box-shadow:0 6px 20px rgba(37,211,102,.4);transition:.3s;text-decoration:none"
   onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
    <i class="fab fa-whatsapp"></i>
</a>
<?php endif; ?>

<!-- Back to Top -->
<button id="cproBackTop" style="position:fixed;bottom:90px;<?= ($dir ?? 'rtl') === 'rtl' ? 'left' : 'right' ?>:24px;z-index:999;width:44px;height:44px;background:var(--blue);border:0;border-radius:50%;color:#fff;font-size:18px;cursor:pointer;box-shadow:0 6px 20px rgba(11,127,243,.3);opacity:0;visibility:hidden;transform:translateY(10px);transition:.3s">
    <i class="fas fa-chevron-up"></i>
</button>

<script>
(function() {
    const $ = s => document.querySelector(s);
    const $$ = s => document.querySelectorAll(s);

    // Mobile menu toggle
    const mobileToggle = $('#cproMobileToggle');
    const mobileMenu = $('#cproMobileMenu');
    const menuIcon = $('#cproMenuIcon');
    if (mobileToggle && mobileMenu) {
        mobileToggle.addEventListener('click', () => {
            const isOpen = mobileMenu.classList.contains('open');
            mobileMenu.classList.toggle('open');
            menuIcon.className = isOpen ? 'fas fa-bars' : 'fas fa-times';
        });
    }

    // Back to top
    const backTop = $('#cproBackTop');
    if (backTop) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 400) {
                backTop.style.opacity = '1';
                backTop.style.visibility = 'visible';
                backTop.style.transform = 'translateY(0)';
            } else {
                backTop.style.opacity = '0';
                backTop.style.visibility = 'hidden';
                backTop.style.transform = 'translateY(10px)';
            }
        });
        backTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    }

    // FAQ accordion
    $$('.cpro-faq-q').forEach(btn => {
        btn.addEventListener('click', () => {
            const item = btn.closest('.cpro-faq-item');
            const answer = item.querySelector('.cpro-faq-a');
            const icon = btn.querySelector('i');
            const isOpen = answer.classList.contains('open');

            $$('.cpro-faq-a').forEach(a => a.classList.remove('open'));
            $$('.cpro-faq-q i').forEach(i => { i.className = 'fas fa-plus'; i.style.transform = 'rotate(0)'; });

            if (!isOpen) {
                answer.classList.add('open');
                icon.className = 'fas fa-minus';
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });
})();
</script>

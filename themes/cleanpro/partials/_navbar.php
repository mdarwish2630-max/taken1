<?php
/**
 * CleanPro Theme — Navbar Partial
 * Top bar + Sticky header navigation
 */
$siteBase = $siteBase ?? (BASE_PATH . '/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';
$whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
$waNumber = preg_replace('/[^0-9+]/', '', $whatsapp);
$phone    = !empty($tenant->contact_phone) ? $tenant->contact_phone : '';
$email    = !empty($tenant->contact_email) ? $tenant->contact_email : '';
$siteName = htmlspecialchars($tenant->site_name ?? 'كلين برو');
$logoUrl  = !empty($tenant->logo) ? (function_exists('upload') ? upload($tenant->logo) : $tenant->logo) : '';
$address  = $tenant->address ?? '';
?>
<!-- Top Bar -->
<div class="cpro-topbar">
    <div class="cpro-container">
        <div>
            <?php if ($phone): ?>
                <i class="fas fa-phone-alt" style="margin-inline-end:6px"></i><?= htmlspecialchars($phone) ?>
            <?php endif; ?>
            <?php if ($email): ?>
                &nbsp;&nbsp;<i class="fas fa-envelope" style="margin-inline-end:6px"></i><?= htmlspecialchars($email) ?>
            <?php endif; ?>
        </div>
        <div class="cpro-topbar-social">
            <?php if ($address): ?><span><?= htmlspecialchars($address) ?></span><?php endif; ?>
        </div>
    </div>
</div>

<!-- Header -->
<header class="cpro-header" id="cproHeader">
    <div class="cpro-container cpro-nav">
        <a class="cpro-logo" href="<?= url($siteBase) ?>">
            <?php if ($logoUrl): ?>
                <img src="<?= htmlspecialchars($logoUrl) ?>" alt="<?= $siteName ?>">
            <?php else: ?>
                <span><?= mb_substr($tenant->site_name ?? 'كلين برو', 0, 2) ?></span>
            <?php endif; ?>
        </a>

        <nav class="cpro-menu" id="cproMenu">
            <?php if (!empty($menu)): foreach ($menu as $item): ?>
                <?php
                    // التوافق مع المنو الجديد (array) والقديم (object)
                    $navHref = $item['url'] ?? '';
                    $navLabel = ($lang === 'en' && !empty($item['label_en'])) ? $item['label_en'] : ($item['label'] ?? ($item->title ?? ''));
                    $isHome = $item['is_home'] ?? ($item->is_home ?? 0);
                    $newTab = ($item['open_in_new_tab'] ?? 0) ? ' target="_blank" rel="noopener"' : '';
                    $isActive = false;
                    if ($isHome && (!isset($page->slug) || empty($page->slug))) $isActive = true;
                    if (!$isHome && isset($page->slug)) {
                        $currentSlug = $item['section_key'] ?? '';
                        if (empty($currentSlug)) $currentSlug = basename($navHref);
                        if (strtolower($page->slug) === strtolower($currentSlug)) $isActive = true;
                    }
                ?>
                <a href="<?= htmlspecialchars($navHref) ?>"<?= $newTab ?> class="<?= $isActive ? 'active' : '' ?>"><?= htmlspecialchars($navLabel) ?></a>
            <?php endforeach; endif; ?>
        </nav>

        <a class="cpro-btn cpro-nav-cta" href="<?= url($siteBase . '/contact') ?>">
            <?= $lang === 'en' ? 'Get a Quote' : 'اطلب عرض سعر' ?>
        </a>

        <button class="cpro-mobile-toggle" id="cproMobileToggle">
            <i class="fas fa-bars" id="cproMenuIcon"></i>
        </button>
    </div>

    <div class="cpro-mobile-menu" id="cproMobileMenu">
        <?php if (!empty($menu)): foreach ($menu as $item): ?>
            <?php
                // التوافق مع المنو الجديد (array) والقديم (object)
                $navHref = $item['url'] ?? '';
                $navLabel = ($lang === 'en' && !empty($item['label_en'])) ? $item['label_en'] : ($item['label'] ?? ($item->title ?? ''));
                $isHome = $item['is_home'] ?? ($item->is_home ?? 0);
                $newTab = ($item['open_in_new_tab'] ?? 0) ? ' target="_blank" rel="noopener"' : '';
                $isActive = false;
                if ($isHome && (!isset($page->slug) || empty($page->slug))) $isActive = true;
                if (!$isHome && isset($page->slug)) {
                    $currentSlug = $item['section_key'] ?? '';
                    if (empty($currentSlug)) $currentSlug = basename($navHref);
                    if (strtolower($page->slug) === strtolower($currentSlug)) $isActive = true;
                }
            ?>
            <a href="<?= htmlspecialchars($navHref) ?>"<?= $newTab ?> class="<?= $isActive ? 'active' : '' ?>"><?= htmlspecialchars($navLabel) ?></a>
        <?php endforeach; endif; ?>
        <a href="<?= url($siteBase . '/booking') ?>" style="color:var(--blue);font-weight:900"><?= $lang === 'en' ? 'Book Now' : 'احجز الآن' ?></a>
    </div>
</header>

<?php
/**
 * CleanPro Theme — Navbar Partial
 * Top bar + Sticky header navigation
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
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
            <?php if (!empty($menu)): foreach ($menu as $item):
                $navHref = $siteBase;
                $slug = strtolower($item->slug ?? '');
                if ($item->is_home == 1 || empty($slug)) { $navHref = $siteBase; }
                else { $navHref = $siteBase . '/' . $slug; }
                $navLabel = $lang === 'en' && !empty($item->title_en) ? $item->title_en : ($item->title ?? '');
                $isActive = (isset($page->slug) && strtolower($page->slug) === $slug) || (empty($page->slug ?? null) && ($item->is_home ?? 0) == 1);
            ?>
                <a href="<?= url($navHref) ?>" class="<?= $isActive ? 'active' : '' ?>"><?= htmlspecialchars($navLabel) ?></a>
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
        <?php if (!empty($menu)): foreach ($menu as $item):
            $navHref = $siteBase;
            $slug = strtolower($item->slug ?? '');
            if ($item->is_home == 1 || empty($slug)) { $navHref = $siteBase; }
            else { $navHref = $siteBase . '/' . $slug; }
            $navLabel = $lang === 'en' && !empty($item->title_en) ? $item->title_en : ($item->title ?? '');
            $isActive = (isset($page->slug) && strtolower($page->slug) === $slug) || (empty($page->slug ?? null) && ($item->is_home ?? 0) == 1);
        ?>
            <a href="<?= url($navHref) ?>" class="<?= $isActive ? 'active' : '' ?>"><?= htmlspecialchars($navLabel) ?></a>
        <?php endforeach; endif; ?>
        <a href="<?= url($siteBase . '/booking') ?>" style="color:var(--blue);font-weight:900"><?= $lang === 'en' ? 'Book Now' : 'احجز الآن' ?></a>
    </div>
</header>

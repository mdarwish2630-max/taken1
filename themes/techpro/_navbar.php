<?php
/**
 * Tek Pro Theme — Navbar Partial
 * White bar with dark left logo panel + orange accents
 */
$siteBase = $siteBase ?? (BASE_PATH . '/site/' . $tenant->slug);
$whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '#';
$siteName = htmlspecialchars($tenant->site_name ?? 'تك برو');
$logoLetter = mb_substr($tenant->site_name ?? 'T', 0, 1);
$waNumber = preg_replace('/[^0-9+]/', '', $whatsapp);
?>
<!-- ═══════ TINY TOP BAR ═══════ -->
<div class="h-7 bg-white text-[11px] text-gray-500 px-5 lg:px-16 flex items-center justify-between border-b">
    <span><?= $siteName ?></span>
    <a href="https://wa.me/<?= $waNumber ?>" target="_blank"
       class="bg-[#ff7a00] text-white px-3 py-1 font-bold hover:bg-[#e86e00] transition">
        <?= ($lang ?? 'ar') === 'en' ? 'Get a Quote' : 'احصل على عرض سعر' ?>
    </a>
</div>

<!-- ═══════ NAVBAR ═══════ -->
<header id="tekProNavbar" class="sticky top-0 z-[1050] bg-white shadow-xl">
    <div class="max-w-7xl mx-auto h-[74px] flex items-center justify-between overflow-hidden px-4 lg:px-16">
        <!-- Logo -->
        <a href="<?= url($siteBase) ?>" class="h-full bg-[#1d2736] text-white px-7 flex items-center gap-3 min-w-[210px]">
            <?php if (!empty($tenant->logo)): ?>
                <img src="<?= upload($tenant->logo) ?>" alt="<?= $siteName ?>" class="w-10 h-10 rounded-xl object-cover">
            <?php else: ?>
                <span class="text-3xl">&#10024;</span>
            <?php endif; ?>
            <div>
                <h1 class="text-2xl font-black leading-none"><?= $siteName ?></h1>
                <p class="text-[11px] text-gray-300 mt-1"><?= ($lang ?? 'ar') === 'en' ? 'Professional Services' : 'الخدمات التقنية' ?></p>
            </div>
        </a>

        <!-- Desktop Nav -->
        <nav class="hidden lg:flex items-center h-full text-sm font-extrabold text-[#202020]">
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
                <a href="<?= htmlspecialchars($navHref) ?>"<?= $newTab ?>
                   class="h-full px-4 flex items-center border-b-4 transition <?= $isActive ? 'border-[#ff7a00] text-[#ff7a00]' : 'border-transparent hover:border-[#ff7a00] hover:text-[#ff7a00]' ?>">
                    <?= htmlspecialchars($navLabel) ?>
                </a>
            <?php endforeach; endif; ?>
        </nav>

        <!-- CTA + Mobile Toggle -->
        <div class="flex items-center gap-3">
            <a href="<?= url($siteBase . '/booking') ?>"
               class="hidden md:flex h-full items-center bg-[#ff7a00] text-[#171717] px-7 font-black text-sm hover:bg-[#e86e00] transition">
                <?= ($lang ?? 'ar') === 'en' ? 'Book Now' : 'احجز الآن' ?>
            </a>
            <button id="tekProMobileToggle" class="lg:hidden w-10 h-10 rounded-lg bg-[#f3f3f3] flex items-center justify-center text-gray-600 hover:text-[#ff7a00] transition">
                <i class="fas fa-bars text-lg" id="tekProMenuIcon"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="tekProMobileMenu" class="hidden lg:hidden bg-white border-t border-gray-100 shadow-lg">
        <nav class="flex flex-col gap-1 p-4">
            <?php if (!empty($menu)): foreach ($menu as $item): ?>
                <?php
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
                <a href="<?= htmlspecialchars($navHref) ?>"<?= $newTab ?>
                   class="px-4 py-3 rounded-lg font-bold transition <?= $isActive ? 'bg-[#ff7a00]/10 text-[#ff7a00]' : 'text-gray-700 hover:bg-gray-50 hover:text-[#ff7a00]' ?>">
                    <?= htmlspecialchars($navLabel) ?>
                </a>
            <?php endforeach; endif; ?>
            <a href="<?= url($siteBase . '/booking') ?>"
               class="mt-2 text-center bg-[#ff7a00] hover:bg-[#e86e00] transition px-5 py-3 rounded-lg font-black text-sm text-[#171717]">
                <?= ($lang ?? 'ar') === 'en' ? 'Book Now' : 'احجز الآن' ?>
            </a>
        </nav>
    </div>
</header>

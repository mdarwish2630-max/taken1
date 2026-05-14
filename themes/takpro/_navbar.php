<?php
/**
 * TakPro Theme — Navbar Partial
 * Top bar + Header with dark logo area and navigation
 */
$siteBase = $siteBase ?? (BASE_PATH . '/site/' . $tenant->slug);
$whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '#';
$siteName = htmlspecialchars($tenant->site_name ?? 'تك برو');
$siteNameEn = htmlspecialchars($tenant->site_name_en ?? 'TakPro');
$siteDesc = mb_substr(htmlspecialchars($tenant->meta_description ?? 'الخدمات التقنية'), 0, 50);
$logoLetter = mb_substr($tenant->site_name ?? 'ت', 0, 1);
$displaySiteName = ($lang ?? 'ar') === 'en' ? $siteNameEn : $siteName;
?>
<!-- ═══════ TOP BAR ═══════ -->
<div class="h-7 bg-white text-[11px] text-gray-500 px-5 lg:px-16 flex items-center justify-between border-b">
    <span><?= $displaySiteName ?></span>
    <a href="<?= url($siteBase . '/contact') ?>" class="bg-brand text-white px-3 py-1 font-bold hover:bg-brand-dark transition">
        <?= ($lang ?? 'ar') === 'en' ? 'Get a Quote' : 'احصل على عرض سعر' ?>
    </a>
</div>

<!-- ═══════ HEADER + NAVBAR ═══════ -->
<header id="takproNavbar" class="relative z-[1050] transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 lg:px-16 pt-3">
        <div class="h-[74px] bg-white shadow-xl flex items-center justify-between overflow-hidden">
            <!-- Logo Area -->
            <a href="<?= url($siteBase) ?>" class="h-full bg-dark-light text-white px-7 flex items-center gap-3 min-w-[210px] group">
                <?php if (!empty($tenant->logo)): ?>
                    <img src="<?= function_exists('upload') ? upload($tenant->logo) : $tenant->logo ?>" alt="<?= $displaySiteName ?>" class="w-10 h-10 rounded-xl object-cover group-hover:scale-105 transition">
                <?php else: ?>
                    <span class="text-3xl">&#10024;</span>
                <?php endif; ?>
                <div>
                    <h1 class="text-2xl font-black leading-none"><?= $displaySiteName ?></h1>
                    <p class="text-[11px] text-gray-300 mt-1">
                        <?= ($lang ?? 'ar') === 'en' ? 'Professional Services' : 'الخدمات التقنية' ?>
                    </p>
                </div>
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden lg:flex items-center h-full text-sm font-extrabold text-dark">
                <?php
                    $navItems = [];
                    if (!empty($menu)) {
                        foreach ($menu as $item) {
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
                            $navItems[] = ['href' => $navHref, 'label' => $navLabel, 'active' => $isActive, 'newTab' => $newTab];
                        }
                    }
                ?>
                <?php foreach ($navItems as $ni => $navItem): ?>
                    <a href="<?= htmlspecialchars($navItem['href']) ?>"<?= $navItem['newTab'] ?? '' ?>
                       class="h-full px-4 flex items-center border-b-4 <?= $navItem['active'] ? 'border-brand text-brand' : 'border-transparent hover:border-brand hover:text-brand' ?> transition">
                        <?= htmlspecialchars($navItem['label']) ?>
                    </a>
                <?php endforeach; ?>
            </nav>

            <!-- CTA + Mobile Toggle -->
            <div class="flex items-center gap-3">
                <a href="https://wa.me/<?= preg_replace('/[^0-9+]/', '', $whatsapp) ?>" target="_blank"
                   class="hidden md:flex h-[74px] items-center bg-brand text-dark px-7 font-black text-sm hover:bg-brand-dark transition">
                    <?= ($lang ?? 'ar') === 'en' ? 'Book Now' : 'احجز الآن' ?>
                </a>
                <button id="takproMobileToggle" class="lg:hidden w-10 h-10 flex items-center justify-center text-dark hover:text-brand transition">
                    <i class="fas fa-bars text-lg" id="takproMenuIcon"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="takproMobileMenu" class="hidden lg:hidden bg-white shadow-xl border-t">
        <nav class="flex flex-col gap-1 p-4">
            <?php foreach ($navItems as $navItem): ?>
                <a href="<?= htmlspecialchars($navItem['href']) ?>"<?= $navItem['newTab'] ?? '' ?>
                   class="px-4 py-3 rounded-xl text-dark hover:text-brand hover:bg-orange-50 transition font-bold <?= $navItem['active'] ? 'text-brand bg-orange-50' : '' ?>">
                    <?= htmlspecialchars($navItem['label']) ?>
                </a>
            <?php endforeach; ?>
            <a href="https://wa.me/<?= preg_replace('/[^0-9+]/', '', $whatsapp) ?>" target="_blank"
               class="mt-2 text-center bg-brand hover:bg-brand-dark transition px-5 py-3 rounded-xl font-black text-sm text-dark">
                <?= ($lang ?? 'ar') === 'en' ? 'Book Now' : 'احجز الآن' ?>
            </a>
        </nav>
    </div>
</header>

<!-- Navbar -->
<nav id="rakazNavbar" class="sticky top-0 z-[1050] bg-white/95 backdrop-blur-xl shadow-lg transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 lg:px-16 flex items-center justify-between min-h-[80px]">

        <!-- Logo -->
        <a href="<?= url($siteBase ?? BASE_PATH) ?>" class="flex items-center gap-3">
            <div class="w-12 h-12 bg-copper text-white flex items-center justify-center text-2xl font-black rounded-rakaz shrink-0">
                <i class="fas fa-wrench"></i>
            </div>
            <div>
                <span class="text-xl lg:text-2xl font-black text-warm-dark leading-none block">
                    <?= htmlspecialchars($tenant->site_name ?? 'ركاز') ?>
                </span>
            </div>
        </a>

        <!-- Desktop Navigation -->
        <div class="hidden lg:flex items-center font-bold text-warm-text">
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
                   class="px-4 py-7 border-b-3 border-transparent hover:border-copper hover:text-copper transition-all duration-300 text-sm tracking-wide <?= $isActive ? 'border-copper text-copper' : '' ?>">
                    <?= e($navLabel) ?>
                </a>
            <?php endforeach; endif; ?>
        </div>

        <!-- CTA Button (Desktop) -->
        <div class="hidden md:flex items-center gap-3">
            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '966000000000') ?>"
               target="_blank" rel="noopener"
               class="w-10 h-10 bg-green-500 hover:bg-green-600 text-white flex items-center justify-center rounded-full transition-all duration-300">
                <i class="fab fa-whatsapp text-lg"></i>
            </a>
            <a href="<?= url(($siteBase ?? BASE_PATH) . '/booking') ?>"
               class="btn-copper px-7 py-2.5 font-bold text-sm">
                طلب صيانة
            </a>
        </div>

        <!-- Mobile Hamburger -->
        <button id="rakazMobileToggle"
                class="lg:hidden text-warm-text text-2xl focus:outline-none focus:ring-2 focus:ring-copper rounded-lg p-2"
                aria-label="القائمة">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="rakazMobileMenu" class="hidden lg:hidden bg-warm-bg/98 backdrop-blur-xl border-t border-copper/10">
        <div class="max-w-7xl mx-auto px-6 py-6 space-y-3">
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
                   class="block text-warm-text hover:text-copper font-bold transition-colors duration-300 py-2 text-base
                          border-b border-copper/5 last:border-0 mobile-nav-link <?= $isActive ? 'text-copper' : '' ?>">
                    <?= e($navLabel) ?>
                </a>
            <?php endforeach; endif; ?>
            <a href="<?= url(($siteBase ?? BASE_PATH) . '/booking') ?>"
               class="block text-center btn-copper px-6 py-3 font-bold text-base mt-4">
                طلب صيانة
            </a>
        </div>
    </div>
</nav>

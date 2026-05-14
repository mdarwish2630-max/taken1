<!-- Top Info Bar -->
<div class="bg-[#ff7a00] text-white px-6 lg:px-20 py-3 text-sm font-bold z-[1060] relative">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-2">
        <p dir="ltr">
            <i class="fas fa-phone ml-2"></i>
            <?php echo htmlspecialchars($tenant->contact_phone ?? '+90 555 000 000'); ?>
            <?php if (!empty($tenant->working_hours)): ?>
            &nbsp;|&nbsp;
            <span><?php echo htmlspecialchars($tenant->working_hours); ?></span>
            <?php else: ?>
            &nbsp;|&nbsp;
            <span><?php echo $lang === 'en' ? 'Professional service around the clock' : 'خدمة تنظيف احترافية على مدار الساعة'; ?></span>
            <?php endif; ?>
        </p>
        <?php if (!empty($tenant->address)): ?>
        <p><?php echo htmlspecialchars($tenant->address); ?></p>
        <?php else: ?>
        <p><?php echo $lang === 'en' ? 'Available 24/7' : 'خدمة تنظيف متواصلة 24/7'; ?></p>
        <?php endif; ?>
    </div>
</div>

<!-- Navbar -->
<nav id="noveNavbar" class="relative z-[1050] bg-white shadow-2xl sticky top-0 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 lg:px-20 flex items-center justify-between min-h-[86px]">

        <!-- Logo & Brand -->
        <a href="<?= url('/') ?>" class="flex items-center gap-4 px-4 py-3">
            <?php if (!empty($tenant->logo)): ?>
            <img src="<?php echo htmlspecialchars($tenant->logo); ?>" alt="<?php echo htmlspecialchars($tenant->site_name ?? ''); ?>"
                 class="w-14 h-14 object-contain shrink-0">
            <?php else: ?>
            <div class="w-14 h-14 bg-[#ff7a00] text-white flex items-center justify-center text-3xl font-black rounded-sm shrink-0">
                <i class="fas fa-sparkles"></i>
            </div>
            <?php endif; ?>
            <div>
                <span class="text-2xl lg:text-3xl font-black text-[#1f2a3b] leading-none block">
                    <?= htmlspecialchars($tenant->site_name ?? ($lang === 'en' ? 'Nove Clean' : 'لمعة كلين')) ?>
                </span>
                <span class="text-sm font-bold text-[#ff7a00] mt-0.5 block"><?php echo $lang === 'en' ? 'Nove Clean' : 'نوف كلين'; ?></span>
            </div>
        </a>

        <!-- Desktop Navigation -->
        <div class="hidden lg:flex items-center h-full font-black text-[#282828]">
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
                   class="px-5 py-8 border-b-4 border-transparent hover:border-[#ff7a00] hover:text-[#ff7a00] transition-all duration-300 text-sm tracking-wide <?= $isActive ? 'border-[#ff7a00] text-[#ff7a00]' : '' ?>">
                    <?= htmlspecialchars($navLabel) ?>
                </a>
            <?php endforeach; endif; ?>
        </div>

        <!-- CTA Button (Desktop) -->
        <div class="hidden md:flex self-stretch items-center">
            <a href="<?= url('/booking') ?>"
               class="block bg-[#ff7a00] hover:bg-[#e56d00] self-stretch px-8 text-white font-black transition-colors duration-300 flex items-center">
                <span><?php echo $lang === 'en' ? 'Get a Quote' : 'احصل على عرض سعر'; ?></span>
            </a>
        </div>

        <!-- Mobile Hamburger -->
        <button id="noveMobileToggle"
                class="lg:hidden text-[#282828] text-2xl focus:outline-none focus:ring-2 focus:ring-[#ff7a00] rounded-lg p-2"
                aria-label="<?php echo $lang === 'en' ? 'Menu' : 'القائمة'; ?>">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="noveMobileMenu"
         class="hidden lg:hidden bg-[#151515]/95 backdrop-blur-xl border-t border-white/10">
        <div class="max-w-7xl mx-auto px-6 py-6 space-y-4">
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
                   class="block text-white hover:text-[#ff7a00] font-bold transition-colors duration-300 py-2 text-lg
                          border-b border-white/5 last:border-0 mobile-nav-link <?= $isActive ? 'text-[#ff7a00]' : '' ?>">
                    <?= htmlspecialchars($navLabel) ?>
                </a>
            <?php endforeach; endif; ?>

            <a href="<?= url('/booking') ?>"
               class="block text-center bg-[#ff7a00] hover:bg-[#e56d00] text-white font-black px-6 py-3 transition-all duration-300 text-lg mt-4">
                <?php echo $lang === 'en' ? 'Get a Quote' : 'احصل على عرض سعر'; ?>
            </a>
        </div>
    </div>
</nav>

<?php
/**
 * Master Theme — Navbar Partial
 */
$siteBase = $siteBase ?? (BASE_PATH . '/site/' . $tenant->slug);
$whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '#';
$siteName = htmlspecialchars($tenant->site_name ?? 'تكوين');
$siteDesc = mb_substr(htmlspecialchars($tenant->meta_description ?? ''), 0, 50);
$logoLetter = mb_substr($tenant->site_name ?? 'M', 0, 1);
?>
<!-- ═══════ NAVBAR ═══════ -->
<header id="masterNavbar" class="fixed top-0 inset-x-0 z-[1050] transition-all duration-300 border-b border-transparent">
    <div class="flex items-center justify-between px-6 lg:px-20 py-4 backdrop-blur-xl bg-[#0f172a]/70">
        <!-- Logo -->
        <a href="<?= url($siteBase) ?>" class="flex items-center gap-3 group">
            <?php if (!empty($tenant->logo)): ?>
                <img src="<?= function_exists('upload') ? upload($tenant->logo) : $tenant->logo ?>" alt="<?= $siteName ?>" class="w-11 h-11 rounded-2xl object-cover shadow-lg shadow-cyan-500/20 group-hover:shadow-cyan-500/40 transition">
            <?php else: ?>
                <div class="w-11 h-11 rounded-2xl bg-cyan-500 flex items-center justify-center font-black text-xl text-black shadow-lg shadow-cyan-500/40 group-hover:scale-105 transition"><?= $logoLetter ?></div>
            <?php endif; ?>
            <div>
                <span class="font-bold text-lg block leading-tight"><?= $siteName ?></span>
                <span class="text-[11px] text-gray-400 leading-tight"><?= $siteDesc ?></span>
            </div>
        </a>

        <!-- Desktop Nav -->
        <nav class="hidden lg:flex items-center gap-8 text-sm text-gray-300">
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
                <a href="<?= htmlspecialchars($navHref) ?>"<?= $newTab ?> class="hover:text-cyan-400 transition <?= $isActive ? 'text-cyan-400 font-bold' : '' ?>"><?= htmlspecialchars($navLabel) ?></a>
            <?php endforeach; endif; ?>
        </nav>

        <!-- CTA + Mobile Toggle -->
        <div class="flex items-center gap-3">
            <a href="https://wa.me/<?= preg_replace('/[^0-9+]/', '', $whatsapp) ?>" target="_blank"
               class="hidden sm:inline-flex bg-cyan-500 hover:bg-cyan-400 transition px-5 py-2.5 rounded-xl font-semibold text-sm shadow-lg shadow-cyan-500/30">
                <?= ($lang ?? 'ar') === 'en' ? 'Get Started' : 'ابدأ الآن' ?>
            </a>
            <button id="masterMobileToggle" class="lg:hidden w-10 h-10 rounded-xl glass flex items-center justify-center text-gray-300 hover:text-white transition">
                <i class="fas fa-bars text-lg" id="masterMenuIcon"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="masterMobileMenu" class="hidden lg:hidden bg-[#0f172a]/95 backdrop-blur-xl border-t border-white/10">
        <nav class="flex flex-col gap-1 p-4">
            <?php if (!empty($menu)): foreach ($menu as $item): ?>
                <?php
                    // التوافق مع المنو الجديد (array) والقديم (object)
                    $navHref = $item['url'] ?? '';
                    $navLabel = ($lang === 'en' && !empty($item['label_en'])) ? $item['label_en'] : ($item['label'] ?? ($item->title ?? ''));
                    $newTab = ($item['open_in_new_tab'] ?? 0) ? ' target="_blank" rel="noopener"' : '';
                ?>
                <a href="<?= htmlspecialchars($navHref) ?>"<?= $newTab ?> class="px-4 py-3 rounded-xl text-gray-300 hover:text-cyan-400 hover:bg-white/5 transition"><?= htmlspecialchars($navLabel) ?></a>
            <?php endforeach; endif; ?>
            <a href="https://wa.me/<?= preg_replace('/[^0-9+]/', '', $whatsapp) ?>" target="_blank"
               class="mt-2 text-center bg-cyan-500 hover:bg-cyan-400 transition px-5 py-3 rounded-xl font-semibold text-sm">
                <?= ($lang ?? 'ar') === 'en' ? 'Get Started' : 'ابدأ الآن' ?>
            </a>
        </nav>
    </div>
</header>

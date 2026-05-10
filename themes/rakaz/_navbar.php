<!-- Navbar -->
<nav id="rakazNavbar" class="sticky top-0 z-[1050] bg-white/95 backdrop-blur-xl shadow-lg transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 lg:px-16 flex items-center justify-between min-h-[80px]">

        <!-- Logo -->
        <a href="<?= url('/') ?>" class="flex items-center gap-3">
            <div class="w-12 h-12 bg-copper text-white flex items-center justify-center text-2xl font-black rounded-rakaz shrink-0">
                <i class="fas fa-wrench"></i>
            </div>
            <div>
                <span class="text-xl lg:text-2xl font-black text-warm-dark leading-none block">
                    <?= $tenant->site_name ?? 'ركاز' ?>
                </span>
                <span class="text-xs font-bold text-copper">للصيانة العامة</span>
            </div>
        </a>

        <!-- Desktop Navigation -->
        <div class="hidden lg:flex items-center font-bold text-warm-text">
            <?php foreach ($menu ?? [] as $item): ?>
                <a href="<?= url($item->is_home ? '/' : $item->slug) ?>"
                   class="px-4 py-7 border-b-3 border-transparent hover:border-copper hover:text-copper transition-all duration-300 text-sm tracking-wide">
                    <?= $item->title ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- CTA Button (Desktop) -->
        <div class="hidden md:flex items-center gap-3">
            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '966000000000') ?>"
               target="_blank" rel="noopener"
               class="w-10 h-10 bg-green-500 hover:bg-green-600 text-white flex items-center justify-center rounded-full transition-all duration-300">
                <i class="fab fa-whatsapp text-lg"></i>
            </a>
            <a href="<?= url('/booking') ?>"
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
            <?php foreach ($menu ?? [] as $item): ?>
                <a href="<?= url($item->is_home ? '/' : $item->slug) ?>"
                   class="block text-warm-text hover:text-copper font-bold transition-colors duration-300 py-2 text-base
                          border-b border-copper/5 last:border-0 mobile-nav-link">
                    <?= $item->title ?>
                </a>
            <?php endforeach; ?>
            <a href="<?= url('/booking') ?>"
               class="block text-center btn-copper px-6 py-3 font-bold text-base mt-4">
                طلب صيانة
            </a>
        </div>
    </div>
</nav>

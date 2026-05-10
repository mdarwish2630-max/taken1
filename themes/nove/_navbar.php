<!-- Top Info Bar -->
<div class="bg-[#ff7a00] text-white px-6 lg:px-20 py-3 text-sm font-bold z-[1060] relative">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-2">
        <p dir="ltr">
            <i class="fas fa-phone ml-2"></i>
            <?php echo htmlspecialchars($tenant->contact_phone ?? '+90 555 000 000'); ?>
            &nbsp;|&nbsp;
            <span>خدمة تنظيف احترافية على مدار الساعة</span>
        </p>
        <p>خدمة تنظيف متواصلة 24/7 | إسطنبول - تركيا</p>
    </div>
</div>

<!-- Navbar -->
<nav id="noveNavbar" class="relative z-[1050] bg-white shadow-2xl sticky top-0 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 lg:px-20 flex items-center justify-between min-h-[86px]">

        <!-- Logo & Brand -->
        <a href="<?= url('/') ?>" class="flex items-center gap-4 px-4 py-3">
            <div class="w-14 h-14 bg-[#ff7a00] text-white flex items-center justify-center text-3xl font-black rounded-sm shrink-0">
                <i class="fas fa-sparkles"></i>
            </div>
            <div>
                <span class="text-2xl lg:text-3xl font-black text-[#1f2a3b] leading-none block">
                    <?= $tenant->site_name ?? 'لمعة كلين' ?>
                </span>
                <span class="text-sm font-bold text-[#ff7a00] mt-0.5 block">Nove Clean</span>
            </div>
        </a>

        <!-- Desktop Navigation -->
        <div class="hidden lg:flex items-center h-full font-black text-[#282828]">
            <?php foreach ($menu ?? [] as $item): ?>
                <a href="<?= url($item->is_home ? '/' : $item->slug) ?>"
                   class="px-5 py-8 border-b-4 border-transparent hover:border-[#ff7a00] hover:text-[#ff7a00] transition-all duration-300 text-sm tracking-wide">
                    <?= $item->title ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- CTA Button (Desktop) -->
        <div class="hidden md:flex self-stretch items-center">
            <a href="<?= url('/booking') ?>"
               class="block bg-[#ff7a00] hover:bg-[#e56d00] self-stretch px-8 text-white font-black transition-colors duration-300 flex items-center">
                <span>احصل على عرض سعر</span>
            </a>
        </div>

        <!-- Mobile Hamburger -->
        <button id="noveMobileToggle"
                class="lg:hidden text-[#282828] text-2xl focus:outline-none focus:ring-2 focus:ring-[#ff7a00] rounded-lg p-2"
                aria-label="القائمة">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="noveMobileMenu"
         class="hidden lg:hidden bg-[#151515]/95 backdrop-blur-xl border-t border-white/10">
        <div class="max-w-7xl mx-auto px-6 py-6 space-y-4">
            <?php foreach ($menu ?? [] as $item): ?>
                <a href="<?= url($item->is_home ? '/' : $item->slug) ?>"
                   class="block text-white hover:text-[#ff7a00] font-bold transition-colors duration-300 py-2 text-lg
                          border-b border-white/5 last:border-0 mobile-nav-link">
                    <?= $item->title ?>
                </a>
            <?php endforeach; ?>

            <a href="<?= url('/booking') ?>"
               class="block text-center bg-[#ff7a00] hover:bg-[#e56d00] text-white font-black px-6 py-3 transition-all duration-300 text-lg mt-4">
                احصل على عرض سعر
            </a>
        </div>
    </div>
</nav>

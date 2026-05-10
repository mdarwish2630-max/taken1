<!-- Rakaz Theme - Navbar -->
<nav class="bg-white/90 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-warm-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <a href="<?php echo url($siteBase ?? '/'); ?>" class="flex items-center gap-3">
                <?php if (!empty($site_logo)): ?>
                    <img src="<?php echo htmlspecialchars($site_logo); ?>" alt="<?php echo htmlspecialchars($site_name ?? 'ركاز'); ?>" class="h-12 w-auto">
                <?php else: ?>
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary to-accent flex items-center justify-center">
                        <i class="fas fa-tools text-white text-xl"></i>
                    </div>
                <?php endif; ?>
                <span class="text-2xl font-bold text-secondary">
                    <?php echo htmlspecialchars($site_name ?? 'ركاز'); ?>
                </span>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center gap-1">
                <?php
                // Build navigation from menu data (menu items are objects, not arrays)
                $navItems = [];
                if (!empty($menu)) {
                    foreach ($menu as $menuItem) {
                        $slug = $menuItem->slug ?? '';
                        $title = $menuItem->title ?? ($menuItem->heading ?? '');
                        if ($slug) {
                            $navItems[$slug] = $title;
                        }
                    }
                }

                // Default navigation items (always available as fallback)
                $defaultNav = [
                    'home' => 'الرئيسية',
                    'services' => 'خدماتنا',
                    'about' => 'من نحن',
                    'gallery' => 'أعمالنا',
                    'faq' => 'الأسئلة الشائعة',
                    'contact' => 'اتصل بنا',
                ];

                // Merge: use menu data if available, else defaults
                $finalNav = [];
                foreach ($defaultNav as $key => $label) {
                    $finalNav[$key] = isset($navItems[$key]) ? $navItems[$key] : $label;
                }

                foreach ($finalNav as $pageKey => $pageTitle):
                    // Generate correct URL based on page type
                    if ($pageKey === 'home') {
                        $navUrl = $siteBase ?? '/';
                    } else {
                        $navUrl = ($siteBase ?? '/') . '/' . $pageKey;
                    }

                    // Highlight active page (page is an object, not array)
                    $isActive = (isset($page) && isset($page->slug) && $page->slug === $pageKey) ? true : false;
                ?>
                    <a href="<?php echo url($navUrl); ?>"
                       class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300
                              <?php echo $isActive
                                  ? 'bg-primary text-white shadow-md'
                                  : 'text-secondary hover:text-primary hover:bg-warm-100'; ?>">
                        <?php echo htmlspecialchars($pageTitle); ?>
                    </a>
                <?php endforeach; ?>

                <!-- CTA Button -->
                <a href="<?php echo url(($siteBase ?? '/') . '/booking'); ?>"
                   class="btn-primary text-white px-6 py-2.5 rounded-full text-sm font-semibold mr-2">
                    احجز موعد
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobileMenuBtn" class="lg:hidden p-2 rounded-xl hover:bg-warm-100 transition-colors">
                <i class="fas fa-bars text-xl text-secondary"></i>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobileMenu" class="hidden lg:hidden pb-4 border-t border-warm-200 mt-2 pt-4">
            <div class="flex flex-col gap-1">
                <?php foreach ($finalNav as $pageKey => $pageTitle):
                    if ($pageKey === 'home') {
                        $navUrl = $siteBase ?? '/';
                    } else {
                        $navUrl = ($siteBase ?? '/') . '/' . $pageKey;
                    }
                    $isActive = (isset($page) && isset($page->slug) && $page->slug === $pageKey) ? true : false;
                ?>
                    <a href="<?php echo url($navUrl); ?>"
                       class="px-4 py-3 rounded-2xl text-sm font-medium transition-all duration-300
                              <?php echo $isActive
                                  ? 'bg-primary text-white'
                                  : 'text-secondary hover:bg-warm-100 hover:text-primary'; ?>">
                        <?php echo htmlspecialchars($pageTitle); ?>
                    </a>
                <?php endforeach; ?>
                <a href="<?php echo url(($siteBase ?? '/') . '/booking'); ?>"
                   class="btn-primary text-white px-6 py-3 rounded-2xl text-sm font-semibold text-center mt-2">
                    احجز موعد
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
document.getElementById('mobileMenuBtn').addEventListener('click', function() {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('hidden');
    const icon = this.querySelector('i');
    if (menu.classList.contains('hidden')) {
        icon.className = 'fas fa-bars text-xl text-secondary';
    } else {
        icon.className = 'fas fa-times text-xl text-secondary';
    }
});
</script>

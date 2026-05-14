<!-- Footer -->
<footer class="bg-warm-dark text-white px-6 lg:px-16 pt-20">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 pb-16">

        <!-- Column 1: Brand -->
        <div class="fade-up">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-11 h-11 bg-copper text-white flex items-center justify-center text-xl font-black rounded-rakaz">
                    <i class="fas fa-wrench"></i>
                </div>
                <div>
                    <span class="text-xl font-black block"><?= htmlspecialchars($tenant->site_name ?? 'ركاز') ?></span>
                </div>
            </div>
            <p class="text-gray-400 leading-loose text-sm mb-6">
                <?= htmlspecialchars($tenant->meta_description ?? 'شركة متخصصة في تقديم خدمات الصيانة العامة والتنظيف والتشطيبات بأعلى معايير الجودة مع فريق مدرب وضمان على جميع الأعمال.') ?>
            </p>
            <div class="flex gap-3">
                <?php if (!empty($tenant->contact_whatsapp)): ?>
                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp) ?>"
                   target="_blank" rel="noopener"
                   class="w-10 h-10 bg-white/10 text-white flex items-center justify-center hover:bg-copper transition-all duration-300 rounded-full">
                    <i class="fab fa-whatsapp text-lg"></i>
                </a>
                <?php endif; ?>
                <?php if (!empty($tenant->instagram)): ?>
                <a href="<?= htmlspecialchars($tenant->instagram) ?>" target="_blank" rel="noopener" class="w-10 h-10 bg-white/10 text-white flex items-center justify-center hover:bg-copper transition-all duration-300 rounded-full">
                    <i class="fab fa-instagram text-lg"></i>
                </a>
                <?php endif; ?>
                <?php if (!empty($tenant->twitter)): ?>
                <a href="<?= htmlspecialchars($tenant->twitter) ?>" target="_blank" rel="noopener" class="w-10 h-10 bg-white/10 text-white flex items-center justify-center hover:bg-copper transition-all duration-300 rounded-full">
                    <i class="fab fa-twitter text-lg"></i>
                </a>
                <?php endif; ?>
                <?php if (!empty($tenant->linkedin)): ?>
                <a href="<?= htmlspecialchars($tenant->linkedin) ?>" target="_blank" rel="noopener" class="w-10 h-10 bg-white/10 text-white flex items-center justify-center hover:bg-copper transition-all duration-300 rounded-full">
                    <i class="fab fa-linkedin text-lg"></i>
                </a>
                <?php endif; ?>
                <?php if (!empty($tenant->facebook)): ?>
                <a href="<?= htmlspecialchars($tenant->facebook) ?>" target="_blank" rel="noopener" class="w-10 h-10 bg-white/10 text-white flex items-center justify-center hover:bg-copper transition-all duration-300 rounded-full">
                    <i class="fab fa-facebook text-lg"></i>
                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Column 2: Services -->
        <div class="fade-up">
            <h4 class="text-lg font-black mb-6 relative inline-block">
                <?= ($lang ?? 'ar') === 'en' ? 'Our Services' : 'خدماتنا' ?>
                <span class="absolute -bottom-2 right-0 w-8 h-1 bg-copper rounded-full"></span>
            </h4>
            <ul class="space-y-3 text-gray-400">
                <?php if (!empty($services)): ?>
                    <?php foreach (array_slice($services, 0, 5) as $svc): ?>
                        <li><a href="<?= url(($siteBase ?? BASE_PATH) . '/service/' . ($svc->slug ?? '')) ?>" class="hover:text-copper transition-colors text-sm"><?= htmlspecialchars(($lang ?? 'ar') === 'en' ? ($svc->title_en ?? $svc->title ?? '') : ($svc->title ?? '')) ?></a></li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Column 3: Quick Links -->
        <div class="fade-up">
            <h4 class="text-lg font-black mb-6 relative inline-block">
                <?= ($lang ?? 'ar') === 'en' ? 'Quick Links' : 'روابط سريعة' ?>
                <span class="absolute -bottom-2 right-0 w-8 h-1 bg-copper rounded-full"></span>
            </h4>
            <ul class="space-y-3 text-gray-400">
                <?php foreach ($menu ?? [] as $item): ?>
                <?php
                $navHref = $siteBase ?? BASE_PATH;
                $slug = strtolower($item->slug ?? '');
                if ($item->is_home == 1 || empty($slug)) { $navHref = $siteBase ?? BASE_PATH; }
                else { $navHref = ($siteBase ?? BASE_PATH) . '/' . $slug; }
                ?>
                <li>
                    <a href="<?= url($navHref) ?>"
                       class="hover:text-copper transition-colors text-sm">
                        <?= htmlspecialchars($item->title) ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Column 4: Contact -->
        <div class="fade-up">
            <h4 class="text-lg font-black mb-6 relative inline-block">
                <?= ($lang ?? 'ar') === 'en' ? 'Contact Us' : 'تواصل معنا' ?>
                <span class="absolute -bottom-2 right-0 w-8 h-1 bg-copper rounded-full"></span>
            </h4>
            <ul class="space-y-3 text-gray-400">
                <?php if (!empty($tenant->contact_phone)): ?>
                <li class="flex items-center gap-3 text-sm">
                    <i class="fas fa-phone text-copper"></i>
                    <a href="tel:<?= preg_replace('/[^0-9+]/', '', $tenant->contact_phone) ?>" class="hover:text-white transition-colors" dir="ltr">
                        <?= htmlspecialchars($tenant->contact_phone) ?>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (!empty($tenant->contact_email)): ?>
                <li class="flex items-center gap-3 text-sm">
                    <i class="fas fa-envelope text-copper"></i>
                    <a href="mailto:<?= htmlspecialchars($tenant->contact_email) ?>" class="hover:text-white transition-colors">
                        <?= htmlspecialchars($tenant->contact_email) ?>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (!empty($tenant->address)): ?>
                <li class="flex items-center gap-3 text-sm">
                    <i class="fas fa-location-dot text-copper"></i>
                    <span><?= htmlspecialchars($tenant->address) ?></span>
                </li>
                <?php endif; ?>
                <?php if (!empty($tenant->working_hours)): ?>
                <li class="flex items-center gap-3 text-sm">
                    <i class="fas fa-clock text-copper"></i>
                    <span><?= htmlspecialchars($tenant->working_hours) ?></span>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <!-- Copyright -->
    <div class="bg-copper text-white text-center py-4 font-bold text-sm rounded-t-rakaz">
        &copy; <?= date('Y') ?> <?= htmlspecialchars($tenant->site_name ?? 'ركاز') ?> — <?= ($lang ?? 'ar') === 'en' ? 'All Rights Reserved' : 'جميع الحقوق محفوظة' ?>
    </div>
</footer>

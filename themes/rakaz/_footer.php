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
                    <span class="text-xl font-black block"><?= $tenant->site_name ?? 'ركاز' ?></span>
                    <span class="text-xs text-copper font-bold">للصيانة العامة</span>
                </div>
            </div>
            <p class="text-gray-400 leading-loose text-sm mb-6">
                شركة متخصصة في تقديم خدمات الصيانة العامة والتنظيف والتشطيبات بأعلى معايير الجودة مع فريق مدرب وضمان على جميع الأعمال.
            </p>
            <div class="flex gap-3">
                <?php if (!empty($tenant->contact_whatsapp)): ?>
                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp) ?>"
                   target="_blank" rel="noopener"
                   class="w-10 h-10 bg-white/10 text-white flex items-center justify-center hover:bg-copper transition-all duration-300 rounded-full">
                    <i class="fab fa-whatsapp text-lg"></i>
                </a>
                <?php endif; ?>
                <a href="#" class="w-10 h-10 bg-white/10 text-white flex items-center justify-center hover:bg-copper transition-all duration-300 rounded-full">
                    <i class="fab fa-instagram text-lg"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-white/10 text-white flex items-center justify-center hover:bg-copper transition-all duration-300 rounded-full">
                    <i class="fab fa-twitter text-lg"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-white/10 text-white flex items-center justify-center hover:bg-copper transition-all duration-300 rounded-full">
                    <i class="fab fa-linkedin text-lg"></i>
                </a>
            </div>
        </div>

        <!-- Column 2: Services -->
        <div class="fade-up">
            <h4 class="text-lg font-black mb-6 relative inline-block">
                خدماتنا
                <span class="absolute -bottom-2 right-0 w-8 h-1 bg-copper rounded-full"></span>
            </h4>
            <ul class="space-y-3 text-gray-400">
                <li><a href="#" class="hover:text-copper transition-colors text-sm">صيانة التكييف</a></li>
                <li><a href="#" class="hover:text-copper transition-colors text-sm">كهرباء المنازل</a></li>
                <li><a href="#" class="hover:text-copper transition-colors text-sm">سباكة وتركيبات</a></li>
                <li><a href="#" class="hover:text-copper transition-colors text-sm">تنظيف عام</a></li>
                <li><a href="#" class="hover:text-copper transition-colors text-sm">دهانات وديكور</a></li>
            </ul>
        </div>

        <!-- Column 3: Quick Links -->
        <div class="fade-up">
            <h4 class="text-lg font-black mb-6 relative inline-block">
                روابط سريعة
                <span class="absolute -bottom-2 right-0 w-8 h-1 bg-copper rounded-full"></span>
            </h4>
            <ul class="space-y-3 text-gray-400">
                <?php foreach ($menu ?? [] as $item): ?>
                <?php
                $navHref = $siteBase ?? '/';
                $slug = strtolower($item->slug ?? '');
                if ($item->is_home == 1 || empty($slug)) { $navHref = $siteBase ?? '/'; }
                else { $navHref = ($siteBase ?? '/') . '/' . $slug; }
                ?>
                <li>
                    <a href="<?= url($navHref) ?>"
                       class="hover:text-copper transition-colors text-sm">
                        <?= $item->title ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Column 4: Contact -->
        <div class="fade-up">
            <h4 class="text-lg font-black mb-6 relative inline-block">
                تواصل معنا
                <span class="absolute -bottom-2 right-0 w-8 h-1 bg-copper rounded-full"></span>
            </h4>
            <ul class="space-y-3 text-gray-400">
                <?php if (!empty($tenant->contact_phone)): ?>
                <li class="flex items-center gap-3 text-sm">
                    <i class="fas fa-phone text-copper"></i>
                    <a href="tel:<?= preg_replace('/[^0-9+]/', '', $tenant->contact_phone) ?>" class="hover:text-white transition-colors" dir="ltr">
                        <?= $tenant->contact_phone ?>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (!empty($tenant->contact_email)): ?>
                <li class="flex items-center gap-3 text-sm">
                    <i class="fas fa-envelope text-copper"></i>
                    <a href="mailto:<?= htmlspecialchars($tenant->contact_email) ?>" class="hover:text-white transition-colors">
                        <?= $tenant->contact_email ?>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (!empty($tenant->address)): ?>
                <li class="flex items-center gap-3 text-sm">
                    <i class="fas fa-location-dot text-copper"></i>
                    <span><?= $tenant->address ?></span>
                </li>
                <?php endif; ?>
                <?php if (!empty($tenant->working_hours)): ?>
                <li class="flex items-center gap-3 text-sm">
                    <i class="fas fa-clock text-copper"></i>
                    <span><?= $tenant->working_hours ?></span>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <!-- Copyright -->
    <div class="bg-copper text-white text-center py-4 font-bold text-sm rounded-t-rakaz">
        &copy; <?= date('Y') ?> <?= $tenant->site_name ?? 'ركاز للصيانة' ?> — جميع الحقوق محفوظة
    </div>
</footer>

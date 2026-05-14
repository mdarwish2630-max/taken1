<?php
/**
 * Master Theme — Footer Partial
 */
$siteBase  = $siteBase ?? (BASE_PATH . '/site/' . $tenant->slug);
$siteName  = htmlspecialchars($tenant->site_name ?? 'تكوين');
$phone     = $tenant->contact_phone ?? '';
$email     = $tenant->contact_email ?? '';
$whatsapp  = $tenant->contact_whatsapp ?? '';
$address   = $tenant->address ?? '';
$logoLetter = mb_substr($tenant->site_name ?? 'M', 0, 1);
$year = date('Y');
?>
<!-- ═══════ FOOTER ═══════ -->
<footer class="relative z-10 border-t border-white/10 bg-black/20 backdrop-blur-xl">
    <div class="px-6 lg:px-20 py-16 grid sm:grid-cols-2 lg:grid-cols-4 gap-10">
        <!-- Brand -->
        <div>
            <div class="flex items-center gap-3 mb-5">
                <?php if (!empty($tenant->logo)): ?>
                    <img src="<?= function_exists('upload') ? upload($tenant->logo) : $tenant->logo ?>" alt="<?= $siteName ?>" class="w-12 h-12 rounded-2xl object-cover">
                <?php else: ?>
                    <div class="w-12 h-12 rounded-2xl bg-cyan-500 flex items-center justify-center font-black text-black text-xl"><?= $logoLetter ?></div>
                <?php endif; ?>
                <div>
                    <h3 class="text-xl font-black"><?= $siteName ?></h3>
                    <p class="text-gray-400 text-xs"><?= ($lang ?? 'ar') === 'en' ? 'Professional Services' : 'خدمات احترافية عالية الجودة' ?></p>
                </div>
            </div>
            <p class="text-gray-400 leading-relaxed text-sm">
                <?= htmlspecialchars($tenant->meta_description) ?: (($lang ?? 'ar') === 'en'
                    ? 'We provide integrated and professional services with the highest quality standards for our individual and corporate clients.'
                    : 'نقدم خدمات متكاملة واحترافية بأعلى معايير الجودة لعملائنا من الأفراد والشركات.') ?>
            </p>
        </div>

        <!-- Services Links -->
        <div>
            <h4 class="text-lg font-bold mb-5"><?= ($lang ?? 'ar') === 'en' ? 'Services' : 'الخدمات' ?></h4>
            <ul class="space-y-3 text-gray-400 text-sm">
                <?php if (!empty($services)): ?>
                    <?php foreach (array_slice($services, 0, 5) as $svc): ?>
                        <?php $svcTitle = $lang === 'en' && !empty($svc->title_en) ? $svc->title_en : ($svc->title ?? ''); ?>
                        <li><a href="<?= url($siteBase . '/services') ?>" class="hover:text-cyan-400 transition"><?= htmlspecialchars($svcTitle) ?></a></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li><a href="#" class="hover:text-cyan-400 transition"><?= ($lang ?? 'ar') === 'en' ? 'Our Services' : 'خدماتنا' ?></a></li>
                    <li><a href="#" class="hover:text-cyan-400 transition"><?= ($lang ?? 'ar') === 'en' ? 'Custom Solutions' : 'حلول مخصصة' ?></a></li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Quick Links -->
        <div>
            <h4 class="text-lg font-bold mb-5"><?= ($lang ?? 'ar') === 'en' ? 'Quick Links' : 'روابط سريعة' ?></h4>
            <ul class="space-y-3 text-gray-400 text-sm">
                <?php if (!empty($menu)): foreach (array_slice($menu, 0, 5) as $item): ?>
                    <?php
                        $navHref = $siteBase;
                        $slug = strtolower($item->slug ?? '');
                        if ($item->is_home != 1 && !empty($slug)) { $navHref = $siteBase . '/' . $slug; }
                        $navLabel = $lang === 'en' && !empty($item->title_en) ? $item->title_en : ($item->title ?? '');
                    ?>
                    <li><a href="<?= url($navHref) ?>" class="hover:text-cyan-400 transition"><?= htmlspecialchars($navLabel) ?></a></li>
                <?php endforeach; endif; ?>
            </ul>
        </div>

        <!-- Contact Info -->
        <div>
            <h4 class="text-lg font-bold mb-5"><?= ($lang ?? 'ar') === 'en' ? 'Contact Info' : 'معلومات التواصل' ?></h4>
            <ul class="space-y-4 text-gray-400 text-sm">
                <?php if ($phone): ?><li class="flex items-center gap-2"><i class="fas fa-phone text-cyan-400"></i> <?= htmlspecialchars($phone) ?></li><?php endif; ?>
                <?php if ($email): ?><li class="flex items-center gap-2"><i class="fas fa-envelope text-cyan-400"></i> <?= htmlspecialchars($email) ?></li><?php endif; ?>
                <?php if ($address): ?><li class="flex items-center gap-2"><i class="fas fa-location-dot text-cyan-400"></i> <?= htmlspecialchars($address) ?></li><?php endif; ?>
            </ul>
            <?php if (!empty($tenant->facebook) || !empty($tenant->instagram) || !empty($tenant->twitter) || !empty($tenant->youtube) || !empty($tenant->linkedin)): ?>
            <div class="flex items-center gap-3 mt-5">
                <?php if (!empty($tenant->facebook)): ?><a href="<?= htmlspecialchars($tenant->facebook) ?>" target="_blank" class="w-9 h-9 rounded-xl bg-white/5 hover:bg-cyan-500 transition flex items-center justify-center text-gray-400 hover:text-black"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
                <?php if (!empty($tenant->instagram)): ?><a href="<?= htmlspecialchars($tenant->instagram) ?>" target="_blank" class="w-9 h-9 rounded-xl bg-white/5 hover:bg-cyan-500 transition flex items-center justify-center text-gray-400 hover:text-black"><i class="fab fa-instagram"></i></a><?php endif; ?>
                <?php if (!empty($tenant->twitter)): ?><a href="<?= htmlspecialchars($tenant->twitter) ?>" target="_blank" class="w-9 h-9 rounded-xl bg-white/5 hover:bg-cyan-500 transition flex items-center justify-center text-gray-400 hover:text-black"><i class="fab fa-x-twitter"></i></a><?php endif; ?>
                <?php if (!empty($tenant->youtube)): ?><a href="<?= htmlspecialchars($tenant->youtube) ?>" target="_blank" class="w-9 h-9 rounded-xl bg-white/5 hover:bg-cyan-500 transition flex items-center justify-center text-gray-400 hover:text-black"><i class="fab fa-youtube"></i></a><?php endif; ?>
                <?php if (!empty($tenant->linkedin)): ?><a href="<?= htmlspecialchars($tenant->linkedin) ?>" target="_blank" class="w-9 h-9 rounded-xl bg-white/5 hover:bg-cyan-500 transition flex items-center justify-center text-gray-400 hover:text-black"><i class="fab fa-linkedin-in"></i></a><?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Copyright -->
    <div class="border-t border-white/10 py-6 text-center text-gray-500 text-sm">
        &copy; <?= $year ?> <?= ($lang ?? 'ar') === 'en' ? 'All Rights Reserved' : 'جميع الحقوق محفوظة' ?> — <?= $siteName ?>
    </div>
</footer>

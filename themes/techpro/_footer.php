<?php
/**
 * Tek Pro Theme — Footer Partial
 * Dark footer with orange accents
 */
$siteBase  = $siteBase ?? (BASE_PATH . '/site/' . $tenant->slug);
$siteName  = htmlspecialchars($tenant->site_name ?? 'تك برو');
$phone     = $tenant->contact_phone ?? '';
$email     = $tenant->contact_email ?? '';
$address   = $tenant->address ?? '';
$logoLetter = mb_substr($tenant->site_name ?? 'T', 0, 1);
$year = date('Y');
?>
<!-- ═══════ CONTACT STRIP ═══════ -->
<section class="bg-[#ff7a00] px-6 lg:px-16 py-10 text-[#151515]">
    <div class="max-w-7xl mx-auto grid md:grid-cols-4 gap-6 text-center font-black text-sm">
        <?php if ($address): ?><div>&#128205; <?= htmlspecialchars($address) ?></div><?php endif; ?>
        <?php if ($phone): ?><div>&#128222; <?= htmlspecialchars($phone) ?></div><?php endif; ?>
        <div>&#9201; 24/7 <?= ($lang ?? 'ar') === 'en' ? 'All Week' : 'طوال الأسبوع' ?></div>
        <div>&#127760; <?= ($lang ?? 'ar') === 'en' ? 'All Areas' : 'خدمة في كل المناطق' ?></div>
    </div>
</section>

<!-- ═══════ FOOTER ═══════ -->
<footer class="bg-[#151515] text-white px-6 lg:px-16 pt-16">
    <div class="max-w-7xl mx-auto grid md:grid-cols-4 gap-10 pb-14">
        <!-- Brand -->
        <div>
            <div class="flex items-center gap-3 mb-5">
                <?php if (!empty($tenant->logo)): ?>
                    <img src="<?= upload($tenant->logo) ?>" alt="<?= $siteName ?>" class="w-12 h-12 rounded-xl object-cover">
                <?php else: ?>
                    <div class="w-12 h-12 rounded-xl bg-[#ff7a00] flex items-center justify-center font-black text-white text-xl"><?= $logoLetter ?></div>
                <?php endif; ?>
                <div>
                    <h3 class="text-3xl font-black"><?= $siteName ?></h3>
                </div>
            </div>
            <p class="text-gray-400 leading-loose text-sm">
                <?= htmlspecialchars($tenant->meta_description) ?: (($lang ?? 'ar') === 'en'
                    ? 'A modern tech company providing professional services and innovative solutions with the highest quality.'
                    : 'شركة تقنية حديثة تقدم خدمات احترافية وحلول عصرية بأعلى جودة.') ?>
            </p>
            <?php if (!empty($tenant->facebook) || !empty($tenant->instagram) || !empty($tenant->twitter) || !empty($tenant->youtube) || !empty($tenant->linkedin) || !empty($tenant->tiktok)): ?>
            <div class="flex items-center gap-3 mt-5">
                <?php if (!empty($tenant->facebook)): ?><a href="<?= htmlspecialchars($tenant->facebook) ?>" target="_blank" class="w-9 h-9 rounded-lg bg-white/10 hover:bg-[#ff7a00] transition flex items-center justify-center text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
                <?php if (!empty($tenant->instagram)): ?><a href="<?= htmlspecialchars($tenant->instagram) ?>" target="_blank" class="w-9 h-9 rounded-lg bg-white/10 hover:bg-[#ff7a00] transition flex items-center justify-center text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a><?php endif; ?>
                <?php if (!empty($tenant->twitter)): ?><a href="<?= htmlspecialchars($tenant->twitter) ?>" target="_blank" class="w-9 h-9 rounded-lg bg-white/10 hover:bg-[#ff7a00] transition flex items-center justify-center text-gray-400 hover:text-white"><i class="fab fa-x-twitter"></i></a><?php endif; ?>
                <?php if (!empty($tenant->youtube)): ?><a href="<?= htmlspecialchars($tenant->youtube) ?>" target="_blank" class="w-9 h-9 rounded-lg bg-white/10 hover:bg-[#ff7a00] transition flex items-center justify-center text-gray-400 hover:text-white"><i class="fab fa-youtube"></i></a><?php endif; ?>
                <?php if (!empty($tenant->linkedin)): ?><a href="<?= htmlspecialchars($tenant->linkedin) ?>" target="_blank" class="w-9 h-9 rounded-lg bg-white/10 hover:bg-[#ff7a00] transition flex items-center justify-center text-gray-400 hover:text-white"><i class="fab fa-linkedin-in"></i></a><?php endif; ?>
                <?php if (!empty($tenant->tiktok)): ?><a href="<?= htmlspecialchars($tenant->tiktok) ?>" target="_blank" class="w-9 h-9 rounded-lg bg-white/10 hover:bg-[#ff7a00] transition flex items-center justify-center text-gray-400 hover:text-white"><i class="fab fa-tiktok"></i></a><?php endif; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Quick Links -->
        <div>
            <h4 class="font-black text-xl mb-5"><?= ($lang ?? 'ar') === 'en' ? 'Links' : 'روابط' ?></h4>
            <ul class="space-y-3 text-gray-400">
                <?php if (!empty($menu)): foreach (array_slice($menu, 0, 5) as $item): ?>
                    <?php
                        $navHref = $siteBase;
                        $slug = strtolower($item->slug ?? '');
                        if ($item->is_home != 1 && !empty($slug)) { $navHref = $siteBase . '/' . $slug; }
                        $navLabel = $lang === 'en' && !empty($item->title_en) ? $item->title_en : ($item->title ?? '');
                    ?>
                    <li><a href="<?= url($navHref) ?>" class="hover:text-[#ff7a00] transition"><?= htmlspecialchars($navLabel) ?></a></li>
                <?php endforeach; endif; ?>
            </ul>
        </div>

        <!-- Services Links -->
        <div>
            <h4 class="font-black text-xl mb-5"><?= ($lang ?? 'ar') === 'en' ? 'Services' : 'الخدمات' ?></h4>
            <ul class="space-y-3 text-gray-400">
                <?php if (!empty($services)): ?>
                    <?php foreach (array_slice($services, 0, 5) as $svc): ?>
                        <?php $svcTitle = $lang === 'en' && !empty($svc->title_en) ? $svc->title_en : ($svc->title ?? ''); ?>
                        <li><a href="<?= url($siteBase . '/service/' . ($svc->slug ?? '')) ?>" class="hover:text-[#ff7a00] transition"><?= htmlspecialchars($svcTitle) ?></a></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li><a href="#" class="hover:text-[#ff7a00] transition"><?= ($lang ?? 'ar') === 'en' ? 'Our Services' : 'خدماتنا' ?></a></li>
                    <li><a href="#" class="hover:text-[#ff7a00] transition"><?= ($lang ?? 'ar') === 'en' ? 'Custom Solutions' : 'حلول مخصصة' ?></a></li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Newsletter -->
        <div>
            <h4 class="font-black text-xl mb-5"><?= ($lang ?? 'ar') === 'en' ? 'Newsletter' : 'النشرة البريدية' ?></h4>
            <form class="space-y-3" onsubmit="event.preventDefault();">
                <input type="email" placeholder="<?= ($lang ?? 'ar') === 'en' ? 'Email Address' : 'البريد الإلكتروني' ?>"
                       class="w-full p-4 bg-white/10 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-[#ff7a00] outline-none transition text-sm" dir="ltr">
                <button type="submit" class="w-full bg-[#ff7a00] text-white p-4 font-black rounded-lg hover:bg-[#e86e00] transition text-sm">
                    <?= ($lang ?? 'ar') === 'en' ? 'Subscribe' : 'اشترك' ?>
                </button>
            </form>
        </div>
    </div>

    <!-- Copyright -->
    <div class="border-t border-white/10 text-center py-6 text-gray-500 text-sm">
        &copy; <?= $year ?> <?= $siteName ?> — <?= ($lang ?? 'ar') === 'en' ? 'All Rights Reserved' : 'جميع الحقوق محفوظة' ?>
    </div>
</footer>

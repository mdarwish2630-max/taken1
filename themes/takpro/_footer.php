<?php
/**
 * TakPro Theme — Footer Partial
 */
$siteBase  = $siteBase ?? ('/site/' . $tenant->slug);
$siteName  = htmlspecialchars($tenant->site_name ?? 'تك برو');
$siteNameEn = htmlspecialchars($tenant->site_name_en ?? 'TakPro');
$displaySiteName = ($lang ?? 'ar') === 'en' ? $siteNameEn : $siteName;
$phone     = $tenant->contact_phone ?? '';
$email     = $tenant->contact_email ?? '';
$whatsapp  = $tenant->contact_whatsapp ?? '';
$address   = $tenant->address ?? '';
$workingHours = $tenant->working_hours ?? '';
$logoLetter = mb_substr($tenant->site_name ?? 'ت', 0, 1);
$year = date('Y');
?>
<!-- ═══════ CONTACT STRIP ═══════ -->
<section class="bg-brand px-6 lg:px-16 py-10 text-dark">
    <div class="max-w-7xl mx-auto grid md:grid-cols-4 gap-6 text-center font-black">
        <?php if ($address): ?>
            <div><i class="fas fa-location-dot ml-2"></i><?= htmlspecialchars($address) ?></div>
        <?php else: ?>
            <div><i class="fas fa-location-dot ml-2"></i><?= ($lang ?? 'ar') === 'en' ? 'Istanbul - Turkey' : 'إسطنبول - تركيا' ?></div>
        <?php endif; ?>
        <?php if ($phone): ?>
            <div><i class="fas fa-phone ml-2"></i><?= htmlspecialchars($phone) ?></div>
        <?php endif; ?>
        <div><i class="fas fa-clock ml-2"></i><?= $workingHours ?: (($lang ?? 'ar') === 'en' ? '24/7 All Week' : '24/7 طوال الأسبوع') ?></div>
        <div><i class="fas fa-globe ml-2"></i><?= ($lang ?? 'ar') === 'en' ? 'Service in All Areas' : 'خدمة في كل المناطق' ?></div>
    </div>
</section>

<!-- ═══════ FOOTER ═══════ -->
<footer class="bg-dark-bg text-white px-6 lg:px-16 pt-16">
    <div class="max-w-7xl mx-auto grid md:grid-cols-4 gap-10 pb-14">
        <!-- Brand -->
        <div>
            <h3 class="text-3xl font-black mb-4"><?= $displaySiteName ?></h3>
            <p class="text-gray-400 leading-loose">
                <?= ($lang ?? 'ar') === 'en'
                    ? 'A modern tech company offering professional services and innovative solutions with the highest quality.'
                    : 'شركة تقنية حديثة تقدم خدمات احترافية وحلول عصرية بأعلى جودة.' ?>
            </p>
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
                    <li><a href="<?= url($navHref) ?>" class="hover:text-brand transition"><?= htmlspecialchars($navLabel) ?></a></li>
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
                        <li><a href="<?= url($siteBase . '/services') ?>" class="hover:text-brand transition"><?= htmlspecialchars($svcTitle) ?></a></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li><a href="#" class="hover:text-brand transition"><?= ($lang ?? 'ar') === 'en' ? 'Technical Support' : 'الدعم التقني' ?></a></li>
                    <li><a href="#" class="hover:text-brand transition"><?= ($lang ?? 'ar') === 'en' ? 'Network Solutions' : 'حلول الشبكات' ?></a></li>
                    <li><a href="#" class="hover:text-brand transition"><?= ($lang ?? 'ar') === 'en' ? 'System Maintenance' : 'صيانة الأنظمة' ?></a></li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Newsletter -->
        <div>
            <h4 class="font-black text-xl mb-5"><?= ($lang ?? 'ar') === 'en' ? 'Newsletter' : 'النشرة البريدية' ?></h4>
            <?php if ($email): ?>
                <p class="text-gray-400 mb-3"><?= htmlspecialchars($email) ?></p>
            <?php endif; ?>
            <form class="mt-3" onsubmit="event.preventDefault();">
                <input type="email" placeholder="<?= ($lang ?? 'ar') === 'en' ? 'Email Address' : 'البريد الإلكتروني' ?>"
                       class="w-full p-4 mb-3 text-black rounded-lg">
                <button type="submit" class="w-full bg-brand hover:bg-brand-dark text-white p-4 font-black rounded-lg transition">
                    <?= ($lang ?? 'ar') === 'en' ? 'Subscribe' : 'اشترك' ?>
                </button>
            </form>
        </div>
    </div>

    <!-- Social Links -->
    <?php if (!empty($tenant->facebook) || !empty($tenant->instagram) || !empty($tenant->twitter) || !empty($tenant->youtube)): ?>
    <div class="max-w-7xl mx-auto border-t border-white/10 pt-8 pb-6">
        <div class="flex items-center gap-4 justify-center">
            <?php if (!empty($tenant->facebook)): ?>
                <a href="<?= htmlspecialchars($tenant->facebook) ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 hover:bg-brand transition flex items-center justify-center text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
            <?php endif; ?>
            <?php if (!empty($tenant->instagram)): ?>
                <a href="<?= htmlspecialchars($tenant->instagram) ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 hover:bg-brand transition flex items-center justify-center text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
            <?php endif; ?>
            <?php if (!empty($tenant->twitter)): ?>
                <a href="<?= htmlspecialchars($tenant->twitter) ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 hover:bg-brand transition flex items-center justify-center text-gray-400 hover:text-white"><i class="fab fa-x-twitter"></i></a>
            <?php endif; ?>
            <?php if (!empty($tenant->youtube)): ?>
                <a href="<?= htmlspecialchars($tenant->youtube) ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 hover:bg-brand transition flex items-center justify-center text-gray-400 hover:text-white"><i class="fab fa-youtube"></i></a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Copyright -->
    <div class="border-t border-white/10 text-center py-6 text-gray-500 text-sm">
        &copy; <?= $year ?> <?= $displaySiteName ?> - <?= ($lang ?? 'ar') === 'en' ? 'All Rights Reserved' : 'جميع الحقوق محفوظة' ?>
    </div>
</footer>

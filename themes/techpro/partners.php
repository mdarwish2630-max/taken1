<?php
/**
 * Tek Pro Theme — Partners Page
 * Light theme + Orange accents
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';
$whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
$waNumber = preg_replace('/[^0-9+]/', '', $whatsapp);

$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'Our Partners' : 'شركاؤنا'));
$pageContent = $lang === 'en' && !empty($page->content_en) ? $page->content_en : ($page->content ?? '');

if (empty($partnerItems)) {
    $partnerItems = [
        (object)['id' => 0, 'name' => 'شركة التقنية المتقدمة', 'name_en' => 'Advanced Tech Co.', 'logo' => '', 'website' => '#', 'status' => 'active'],
        (object)['id' => 0, 'name' => 'مؤسسة الطاقة الذكية', 'name_en' => 'Smart Energy Corp.', 'logo' => '', 'website' => '#', 'status' => 'active'],
        (object)['id' => 0, 'name' => 'شركة الديكور الملكي', 'name_en' => 'Royal Decor Co.', 'logo' => '', 'website' => '#', 'status' => 'active'],
        (object)['id' => 0, 'name' => 'مجموعة الأمن والحماية', 'name_en' => 'Security Group', 'logo' => '', 'website' => '#', 'status' => 'active'],
        (object)['id' => 0, 'name' => 'شركة الأنظمة الأولى', 'name_en' => 'First Systems Co.', 'logo' => '', 'website' => '#', 'status' => 'active'],
        (object)['id' => 0, 'name' => 'مؤسسة التطوير المتطور', 'name_en' => 'Advanced Dev Corp.', 'logo' => '', 'website' => '#', 'status' => 'active'],
    ];
}

// Benefits — now sourced from $siteFeatures (CMS-managed)

require_once __DIR__ . '/_head.php';
require_once __DIR__ . '/_navbar.php';
?>

<!-- ═══════ PAGE HEADER ═══════ -->
<section class="bg-[#f3f3f3] px-6 lg:px-16 py-16">
    <div class="max-w-4xl mx-auto fade-up">
        <p class="text-[#ff7a00] font-black mb-3"><?= $lang === 'en' ? 'Our Partners' : 'شركاؤنا' ?></p>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight mb-6"><?= htmlspecialchars($pageTitle) ?></h1>
        <?php if (!empty($pageContent)): ?>
            <p class="text-gray-600 text-lg leading-relaxed max-w-3xl"><?= $pageContent ?></p>
        <?php else: ?>
            <p class="text-gray-600 text-lg leading-relaxed max-w-3xl">
                <?= $lang === 'en' ? 'Proud to work with trusted partners who share our commitment to excellence.' : 'نفخر بالعمل مع شبكة من الشركاء الموثوقين الذين يشاركوننا التزامنا بالتميز.' ?>
            </p>
        <?php endif; ?>
    </div>
</section>

<!-- ═══════ BENEFITS ═══════ -->
<?php if (!empty($siteFeatures)): ?>
<section class="px-6 lg:px-16 py-12">
    <div class="max-w-7xl mx-auto grid sm:grid-cols-3 gap-6">
        <?php foreach ($siteFeatures as $i => $feat): ?>
            <div class="bg-[#f5f5f5] rounded-lg p-7 tekpro-card fade-up" style="transition-delay:<?= $i * 0.1 ?>s">
                <?php if (!empty($feat->icon)): ?>
                <div class="w-14 h-14 rounded-lg bg-[#ff7a00] flex items-center justify-center text-2xl mb-5 text-white">
                    <i class="<?= htmlspecialchars($feat->icon) ?>"></i>
                </div>
                <?php endif; ?>
                <h3 class="text-lg font-black mb-3"><?= htmlspecialchars($lang === 'en' && !empty($feat->title_en) ? $feat->title_en : $feat->title) ?></h3>
                <p class="text-gray-500 leading-relaxed text-sm"><?= htmlspecialchars($lang === 'en' && !empty($feat->description_en) ? $feat->description_en : $feat->description) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ═══════ PARTNERS GRID ═══════ -->
<section class="px-6 lg:px-16 py-16 pb-20">
    <?php if (!empty($partnerItems)): ?>
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12 fade-up">
                <h2 class="text-3xl sm:text-4xl font-black mb-4"><?= $lang === 'en' ? 'Trusted By' : 'موثوق من قبل' ?></h2>
                <p class="text-gray-500 max-w-2xl mx-auto"><?= $lang === 'en' ? 'Companies that trust us and we proudly partner with.' : 'شركات تثق بنا ونفخر بالشراكة معها.' ?></p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                <?php foreach ($partnerItems as $i => $partner):
                    $partnerName = $lang === 'en' && !empty($partner->name_en) ? $partner->name_en : ($partner->name ?? '');
                    $partnerLogo = !empty($partner->logo) ? (function_exists('upload') ? upload($partner->logo) : $partner->logo) : '';
                    $partnerSite = $partner->website ?? '';
                    $letter = mb_substr($partnerName, 0, 1);
                ?>
                    <div class="group fade-up" style="transition-delay:<?= (0.05 * ($i % 10)) ?>s">
                        <?php if (!empty($partnerSite) && $partnerSite !== '#'): ?>
                            <a href="<?= htmlspecialchars($partnerSite) ?>" target="_blank" rel="noopener noreferrer"
                               class="block bg-[#f5f5f5] rounded-lg p-8 flex flex-col items-center justify-center gap-4 tekpro-card min-h-[180px]">
                        <?php else: ?>
                            <div class="bg-[#f5f5f5] rounded-lg p-8 flex flex-col items-center justify-center gap-4 tekpro-card min-h-[180px]">
                        <?php endif; ?>
                            <?php if ($partnerLogo): ?>
                                <img src="<?= htmlspecialchars($partnerLogo) ?>" alt="<?= htmlspecialchars($partnerName) ?>" class="max-h-16 w-auto object-contain grayscale group-hover:grayscale-0 transition-all duration-300" loading="lazy">
                            <?php else: ?>
                                <div class="w-16 h-16 rounded-lg bg-[#ff7a00]/10 flex items-center justify-center text-2xl font-black text-[#ff7a00] group-hover:scale-110 transition-transform duration-300"><?= $letter ?></div>
                            <?php endif; ?>
                            <span class="text-gray-600 text-sm font-bold text-center group-hover:text-[#ff7a00] transition"><?= htmlspecialchars($partnerName) ?></span>
                        <?php if (!empty($partnerSite) && $partnerSite !== '#'): ?></a><?php else: ?></div><?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</section>

<!-- ═══════ CTA ═══════ -->
<section class="bg-[#ff7a00] px-6 lg:px-16 py-16 fade-up">
    <div class="max-w-4xl mx-auto text-center">
        <div class="w-16 h-16 rounded-lg bg-white/20 flex items-center justify-center text-3xl mx-auto mb-6 text-white"><i class="fas fa-handshake-angle"></i></div>
        <h2 class="text-3xl sm:text-4xl font-black text-white mb-6"><?= $lang === 'en' ? 'Become a Partner' : 'كن شريكاً لنا' ?></h2>
        <p class="text-lg text-white/90 max-w-2xl mx-auto leading-relaxed mb-8"><?= $lang === 'en' ? 'Interested in partnering with us? We are always looking for new collaborations.' : 'مهتم بالشراكة معنا؟ نبحث دائماً عن تعاونات جديدة.' ?></p>
        <div class="flex flex-wrap justify-center gap-4">
            <?php if ($waNumber): ?>
                <a href="https://wa.me/<?= $waNumber ?>" target="_blank"
                   class="inline-flex items-center gap-2 bg-white text-[#ff7a00] hover:scale-105 transition px-8 py-4 rounded-lg font-black shadow-xl">
                    <i class="fab fa-whatsapp text-lg"></i> <?= $lang === 'en' ? 'Discuss Partnership' : 'ناقش الشراكة' ?>
                </a>
            <?php endif; ?>
            <a href="<?= url($siteBase . '/contact') ?>"
               class="inline-flex items-center gap-2 bg-white/20 hover:bg-white/30 transition px-8 py-4 rounded-lg font-bold text-white border border-white/30">
                <i class="fas fa-envelope"></i> <?= $lang === 'en' ? 'Contact Us' : 'اتصل بنا' ?>
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

<?php
/**
 * Master Theme — Partners Page
 * Benefits section + partners logo grid
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';
$whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
$waNumber = preg_replace('/[^0-9+]/', '', $whatsapp);

// Page title
$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'Our Partners' : 'شركاؤنا'));
$pageContent = $lang === 'en' && !empty($page->content_en) ? $page->content_en : ($page->content ?? '');

// ── Fallback partner data (always show content even if DB is empty) ──
if (empty($partnerItems)) {
    $partnerItems = [
        (object)['id' => 0, 'name' => 'شركة الأبنية المتقدمة', 'name_en' => 'Advanced Buildings Co.', 'logo' => '', 'website' => 'https://advanced-buildings.com', 'status' => 'active'],
        (object)['id' => 0, 'name' => 'مؤسسة الطاقة الذكية', 'name_en' => 'Smart Energy Corp.', 'logo' => '', 'website' => 'https://smart-energy.com', 'status' => 'active'],
        (object)['id' => 0, 'name' => 'شركة الديكور الملكي', 'name_en' => 'Royal Decor Co.', 'logo' => '', 'website' => 'https://royal-decor.com', 'status' => 'active'],
        (object)['id' => 0, 'name' => 'مجموعة الأمن والحماية', 'name_en' => 'Security Group', 'logo' => '', 'website' => 'https://security-group.com', 'status' => 'active'],
        (object)['id' => 0, 'name' => 'شركة الأنابيب الأولى', 'name_en' => 'First Pipes Co.', 'logo' => '', 'website' => 'https://first-pipes.com', 'status' => 'active'],
        (object)['id' => 0, 'name' => 'مؤسسة التبريد المتطور', 'name_en' => 'Advanced Cooling Corp.', 'logo' => '', 'website' => 'https://advanced-cooling.com', 'status' => 'active'],
    ];
}

// Benefits — now sourced from $siteFeatures (CMS-managed)

require_once __DIR__ . '/_head.php';
require_once __DIR__ . '/_navbar.php';
?>

<!-- Background Effects -->
<div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
    <div class="absolute -top-20 -right-20 w-[500px] h-[500px] bg-cyan-500/15 blur-[120px] rounded-full"></div>
    <div class="absolute -bottom-20 -left-20 w-[500px] h-[500px] bg-blue-500/15 blur-[120px] rounded-full"></div>
</div>

<!-- ═══════ PAGE HEADER ═══════ -->
<section class="relative z-10 px-6 lg:px-20 pt-32 pb-8">
    <div class="max-w-4xl fade-up">
        <div class="inline-flex items-center gap-2 glass rounded-full px-4 py-2 text-sm text-cyan-300 mb-6">
            <i class="fas fa-handshake text-xs"></i>
            <span><?= $lang === 'en' ? 'Our Partners' : 'شركاؤنا' ?></span>
        </div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight mb-6">
            <?= htmlspecialchars($pageTitle) ?>
        </h1>
        <?php if (!empty($pageContent)): ?>
            <p class="text-gray-300 text-lg leading-relaxed max-w-3xl"><?= $pageContent ?></p>
        <?php else: ?>
            <p class="text-gray-300 text-lg leading-relaxed max-w-3xl">
                <?= $lang === 'en'
                    ? 'We are proud to work with a network of trusted partners who share our commitment to excellence.'
                    : 'نفخر بالعمل مع شبكة من الشركاء الموثوقين الذين يشاركوننا التزامنا بالتميز.' ?>
            </p>
        <?php endif; ?>
        <div class="w-24 h-1.5 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full mt-6"></div>
    </div>
</section>

<!-- ═══════ BENEFITS SECTION ═══════ -->
<?php if (!empty($siteFeatures)): ?>
<section class="relative z-10 px-6 lg:px-20 py-12">
    <div class="grid sm:grid-cols-3 gap-6">
        <?php foreach ($siteFeatures as $i => $feat): ?>
            <div class="glass rounded-2xl p-7 glow-border transition-all duration-300 hover:-translate-y-1 fade-up" style="transition-delay:<?= $i * 0.1 ?>s">
                <?php if (!empty($feat->icon)): ?>
                <div class="w-14 h-14 rounded-2xl bg-cyan-500/20 border border-cyan-400/20 flex items-center justify-center text-2xl mb-5">
                    <i class="<?= htmlspecialchars($feat->icon) ?> text-cyan-400"></i>
                </div>
                <?php endif; ?>
                <h3 class="text-lg font-bold mb-3"><?= htmlspecialchars($lang === 'en' && !empty($feat->title_en) ? $feat->title_en : $feat->title) ?></h3>
                <p class="text-gray-400 leading-relaxed text-sm"><?= htmlspecialchars($lang === 'en' && !empty($feat->description_en) ? $feat->description_en : $feat->description) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ═══════ PARTNERS GRID ═══════ -->
<section class="relative z-10 px-6 lg:px-20 py-16 pb-20">
    <?php if (!empty($partnerItems)): ?>
        <div class="text-center mb-12 fade-up">
            <h2 class="text-3xl sm:text-4xl font-black mb-4">
                <?= $lang === 'en' ? 'Trusted By' : 'موثوق من قبل' ?>
            </h2>
            <p class="text-gray-400 max-w-2xl mx-auto">
                <?= $lang === 'en'
                    ? 'Companies and brands that trust us and we proudly partner with.'
                    : 'شركات وعلامات تجارية تثق بنا ونفخر بالشراكة معها.' ?>
            </p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            <?php foreach ($partnerItems as $i => $partner):
                $partnerName = $lang === 'en' && !empty($partner->name_en) ? $partner->name_en : ($partner->name ?? '');
                $partnerLogo = !empty($partner->logo) ? function_exists('upload') ? upload($partner->logo) : $partner->logo : '';
                $partnerSite = $partner->website ?? '';
                $letter = mb_substr($partnerName, 0, 1);
            ?>
                <div class="group fade-up" style="transition-delay:<?= (0.05 * ($i % 10)) ?>s">
                    <?php if (!empty($partnerSite)): ?>
                        <a href="<?= htmlspecialchars($partnerSite) ?>" target="_blank" rel="noopener noreferrer"
                           class="block glass rounded-2xl p-8 flex flex-col items-center justify-center gap-4 glow-border transition-all duration-300 hover:-translate-y-2 hover:bg-white/[.06] min-h-[180px]">
                    <?php else: ?>
                        <div class="glass rounded-2xl p-8 flex flex-col items-center justify-center gap-4 glow-border transition-all duration-300 hover:-translate-y-2 hover:bg-white/[.06] min-h-[180px]">
                    <?php endif; ?>

                        <?php if ($partnerLogo): ?>
                            <img src="<?= htmlspecialchars($partnerLogo) ?>"
                                 alt="<?= htmlspecialchars($partnerName) ?>"
                                 class="max-h-16 w-auto object-contain grayscale group-hover:grayscale-0 transition-all duration-300"
                                 loading="lazy">
                        <?php else: ?>
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-cyan-500/20 to-blue-500/20 border border-cyan-400/20 flex items-center justify-center text-2xl font-black text-cyan-400 group-hover:scale-110 transition-transform duration-300">
                                <?= $letter ?>
                            </div>
                        <?php endif; ?>

                        <span class="text-gray-300 text-sm font-semibold text-center group-hover:text-cyan-400 transition"><?= htmlspecialchars($partnerName) ?></span>

                    <?php if (!empty($partnerSite)): ?>
                        </a>
                    <?php else: ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

    <?php else: ?>
        <!-- Empty State -->
        <div class="text-center py-20 fade-up">
            <div class="w-24 h-24 rounded-full bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-4xl mx-auto mb-6">
                <i class="fas fa-building text-cyan-400/50"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-300 mb-3">
                <?= $lang === 'en' ? 'Partners Coming Soon' : 'شركاؤنا قريباً' ?>
            </h3>
            <p class="text-gray-500 mb-8">
                <?= $lang === 'en'
                    ? 'Our partner network is growing. Check back soon for updates.'
                    : 'شبكة شركائنا تتزايد. ترقبوا التحديثات قريباً.' ?>
            </p>
        </div>
    <?php endif; ?>
</section>

<!-- ═══════ PARTNERSHIP CTA ═══════ -->
<section class="relative z-10 px-6 lg:px-20 pb-20 fade-up">
    <div class="bg-gradient-to-r from-cyan-500 to-blue-700 rounded-[40px] p-10 lg:p-16 text-center shadow-2xl shadow-cyan-500/20 relative overflow-hidden">
        <div class="absolute -top-20 -right-20 w-60 h-60 bg-white/10 rounded-full blur-[60px]"></div>
        <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-white/10 rounded-full blur-[60px]"></div>

        <div class="relative">
            <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center text-3xl mx-auto mb-6">
                <i class="fas fa-handshake-angle"></i>
            </div>
            <h2 class="text-3xl sm:text-4xl font-black leading-tight mb-6">
                <?= $lang === 'en' ? 'Become a Partner' : 'كن شريكاً لنا' ?>
            </h2>
            <p class="text-lg opacity-90 max-w-2xl mx-auto leading-relaxed mb-10">
                <?= $lang === 'en'
                    ? 'Interested in partnering with us? We are always looking for new collaborations that add value.'
                    : 'مهتم بالشراكة معنا؟ نبحث دائماً عن تعاونات جديدة تضيف قيمة.' ?>
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <?php if ($waNumber): ?>
                    <a href="https://wa.me/<?= $waNumber ?>" target="_blank"
                       class="inline-flex items-center gap-2 bg-white text-[#0f172a] hover:scale-105 transition px-8 py-4 rounded-2xl font-black text-base shadow-xl">
                        <i class="fab fa-whatsapp text-lg"></i>
                        <?= $lang === 'en' ? 'Discuss Partnership' : 'ناقش الشراكة' ?>
                    </a>
                <?php endif; ?>
                <a href="<?= url($siteBase . '/contact') ?>"
                   class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 transition px-8 py-4 rounded-2xl font-bold text-base border border-white/20">
                    <i class="fas fa-envelope"></i>
                    <?= $lang === 'en' ? 'Contact Us' : 'اتصل بنا' ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

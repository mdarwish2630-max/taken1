<?php
/**
 * Tek Pro Theme — About Page
 * Light theme + Orange accents
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';
$whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
$waNumber = preg_replace('/[^0-9+]/', '', $whatsapp);

$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'About Us' : 'من نحن'));
$pageContent = $lang === 'en' && !empty($page->content_en) ? $page->content_en : ($page->content ?? '');

$stats = !empty($siteStats) ? $siteStats : [];
if (empty($stats)) {
    $stats = [
        (object)['value' => '10+', 'label' => 'سنوات خبرة', 'label_en' => 'Years Exp.', 'icon' => 'fas fa-clock'],
        (object)['value' => '8K+', 'label' => 'عميل سعيد', 'label_en' => 'Happy Clients', 'icon' => 'fas fa-users'],
        (object)['value' => '24/7', 'label' => 'دعم متواصل', 'label_en' => '24/7 Support', 'icon' => 'fas fa-headset'],
        (object)['value' => '98%', 'label' => 'نسبة الرضا', 'label_en' => 'Satisfaction', 'icon' => 'fas fa-chart-line'],
    ];
}

$features = !empty($siteFeatures) ? $siteFeatures : [];
if (empty($features)) {
    $features = [
        (object)['title' => 'استجابة سريعة', 'title_en' => 'Fast Response', 'description' => 'نصل إليكم بسرعة مع فريق مجهز وجاهز', 'description_en' => 'Quick arrival with equipped team', 'icon' => 'fas fa-bolt'],
        (object)['title' => 'فنيون محترفون', 'title_en' => 'Expert Technicians', 'description' => 'فريق معتمد بخبرة عملية واسعة', 'description_en' => 'Certified team with wide experience', 'icon' => 'fas fa-id-badge'],
        (object)['title' => 'أسعار منافسة', 'title_en' => 'Competitive Prices', 'description' => 'جودة عالية بأسعار مناسبة للجميع', 'description_en' => 'High quality at affordable prices', 'icon' => 'fas fa-tags'],
        (object)['title' => 'معدات حديثة', 'title_en' => 'Modern Equipment', 'description' => 'نستخدم أحدث الأدوات والتقنيات', 'description_en' => 'Latest tools and technology', 'icon' => 'fas fa-tools'],
    ];
}

require_once __DIR__ . '/_head.php';
require_once __DIR__ . '/_navbar.php';
?>

<!-- ═══════ PAGE HEADER ═══════ -->
<section class="bg-[#f3f3f3] px-6 lg:px-16 py-16">
    <div class="max-w-4xl mx-auto fade-up">
        <p class="text-[#ff7a00] font-black mb-3"><?= $lang === 'en' ? 'About Us' : 'من نحن' ?></p>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight mb-6"><?= htmlspecialchars($pageTitle) ?></h1>
    </div>
</section>

<!-- ═══════ MAIN CONTENT ═══════ -->
<section class="px-6 lg:px-16 py-12">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-12 lg:gap-20 items-start">

        <!-- Left Column -->
        <div class="space-y-10">
            <div class="fade-up">
                <?php if (!empty($pageContent)): ?>
                    <div class="text-gray-600 text-lg leading-loose space-y-4"><?= $pageContent ?></div>
                <?php else: ?>
                    <p class="text-gray-600 text-lg leading-loose">
                        <?= $lang === 'en'
                            ? 'We are a professional team dedicated to providing top-quality services. With years of experience and a passion for excellence, we deliver innovative solutions tailored to your needs.'
                            : 'نحن فريق محترف متخصص في تقديم أعلى مستويات الخدمة. بخبرة طويلة وشغف بالتميز، نقدم حلولاً مبتكرة مصممة خصيصاً لاحتياجاتكم.' ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Mission & Vision -->
            <div class="grid sm:grid-cols-2 gap-6 fade-up" style="transition-delay:.1s">
                <div class="bg-[#f5f5f5] rounded-lg p-7 tekpro-card">
                    <div class="w-14 h-14 rounded-lg bg-[#ff7a00] flex items-center justify-center text-2xl mb-5 text-white">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3 class="text-xl font-black mb-3"><?= $lang === 'en' ? 'Our Mission' : 'رسالتنا' ?></h3>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        <?= $lang === 'en'
                            ? 'To deliver exceptional services that exceed expectations and build lasting relationships with our clients.'
                            : 'تقديم خدمات استثنائية تفوق التوقعات وبناء علاقات دائمة ومثمرة مع عملائنا.' ?>
                    </p>
                </div>
                <div class="bg-[#f5f5f5] rounded-lg p-7 tekpro-card">
                    <div class="w-14 h-14 rounded-lg bg-[#171717] flex items-center justify-center text-2xl mb-5 text-white">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3 class="text-xl font-black mb-3"><?= $lang === 'en' ? 'Our Vision' : 'رؤيتنا' ?></h3>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        <?= $lang === 'en'
                            ? 'To be the leading provider recognized for innovation, reliability, and customer satisfaction.'
                            : 'أن نكون الخيار الأول المعترف بنا بالابتكار والموثوقية ورضا العملاء.' ?>
                    </p>
                </div>
            </div>

            <!-- Values -->
            <div class="fade-up" style="transition-delay:.2s">
                <div class="flex flex-wrap gap-3">
                    <?php
                    $values = $lang === 'en' ? ['Excellence', 'Integrity', 'Innovation', 'Teamwork'] : ['التميز', 'الأمانة', 'الابتكار', 'العمل الجماعي'];
                    $valueIcons = ['fas fa-gem', 'fas fa-shield-halved', 'fas fa-lightbulb', 'fas fa-people-group'];
                    foreach ($values as $vi => $value): ?>
                        <div class="bg-[#f5f5f5] rounded-lg px-5 py-3 flex items-center gap-3 hover:bg-[#ff7a00]/10 transition">
                            <i class="<?= $valueIcons[$vi] ?> text-[#ff7a00] text-sm"></i>
                            <span class="font-bold text-sm"><?= $value ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Right Column: Stats + Features -->
        <div class="space-y-10">
            <!-- Stats -->
            <div class="fade-up" style="transition-delay:.15s">
                <div class="bg-[#171717] rounded-lg p-8">
                    <h3 class="text-2xl font-black text-white mb-6"><?= $lang === 'en' ? 'Our Numbers' : 'إنجازاتنا بالأرقام' ?></h3>
                    <div class="grid grid-cols-2 gap-5">
                        <?php foreach ($stats as $stat):
                            $statLabel = $lang === 'en' && !empty($stat->label_en) ? $stat->label_en : ($stat->label ?? '');
                            $statIcon = $stat->icon ?? 'fas fa-chart-bar';
                        ?>
                            <div class="bg-white/10 rounded-lg p-5 text-center">
                                <div class="w-12 h-12 rounded-lg bg-[#ff7a00]/20 flex items-center justify-center text-xl mx-auto mb-3">
                                    <i class="<?= htmlspecialchars($statIcon) ?> text-[#ff7a00]"></i>
                                </div>
                                <h4 class="text-2xl sm:text-3xl font-black text-[#ff7a00]"><?= $stat->value ?></h4>
                                <p class="text-gray-400 mt-1 text-sm"><?= htmlspecialchars($statLabel) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="fade-up" style="transition-delay:.25s">
                <h3 class="text-2xl font-black mb-6"><?= $lang === 'en' ? 'Why Choose Us' : 'لماذا تختارنا' ?></h3>
                <div class="space-y-4">
                    <?php foreach ($features as $feat):
                        $featTitle = $lang === 'en' && !empty($feat->title_en) ? $feat->title_en : ($feat->title ?? '');
                        $featDesc  = $lang === 'en' && !empty($feat->description_en) ? $feat->description_en : ($feat->description ?? '');
                        $featIcon  = $feat->icon ?? 'fas fa-check';
                    ?>
                        <div class="bg-[#f5f5f5] rounded-lg p-5 flex items-start gap-4 tekpro-card">
                            <div class="w-11 h-11 min-w-[44px] rounded-lg bg-[#ff7a00] flex items-center justify-center text-white font-black flex-shrink-0">
                                <i class="<?= htmlspecialchars($featIcon) ?>"></i>
                            </div>
                            <div>
                                <p class="font-black text-gray-800"><?= htmlspecialchars($featTitle) ?></p>
                                <p class="text-gray-500 text-sm mt-1"><?= htmlspecialchars($featDesc) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════ CTA ═══════ -->
<section class="bg-[#ff7a00] px-6 lg:px-16 py-16 fade-up">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl sm:text-4xl font-black text-white mb-6"><?= $lang === 'en' ? 'Ready to Get Started?' : 'هل أنت مستعد للبدء؟' ?></h2>
        <p class="text-lg text-white/90 max-w-2xl mx-auto leading-relaxed mb-8">
            <?= $lang === 'en' ? 'Contact our team now and discover how we can help you.' : 'تواصل مع فريقنا الآن واكتشف كيف يمكننا مساعدتك.' ?>
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="https://wa.me/<?= $waNumber ?>" target="_blank"
               class="inline-flex items-center gap-2 bg-white text-[#ff7a00] hover:scale-105 transition px-8 py-4 rounded-lg font-black shadow-xl">
                <i class="fab fa-whatsapp text-lg"></i> <?= $lang === 'en' ? 'WhatsApp' : 'تواصل عبر واتساب' ?>
            </a>
            <a href="<?= url($siteBase . '/contact') ?>"
               class="inline-flex items-center gap-2 bg-white/20 hover:bg-white/30 transition px-8 py-4 rounded-lg font-bold text-white border border-white/30">
                <i class="fas fa-envelope"></i> <?= $lang === 'en' ? 'Send a Message' : 'أرسل رسالة' ?>
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

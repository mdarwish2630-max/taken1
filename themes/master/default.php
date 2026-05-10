<?php
/**
 * Master Theme — Default (Landing Page)
 * Converted from React component: MaintenanceLandingPage
 * Dark bg (#0f172a) + Cyan-500 accents + Tailwind CDN + Dynamic CMS content
 *
 * Sections: Navbar → Hero (with service panel) → Services → Why Us → CTA → Footer
 *
 * Available vars (from extract in controller):
 *   $tenant, $page, $menu, $banners, $services, $gallery,
 *   $testimonials, $faqItems, $siteStats, $siteFeatures,
 *   $partnerItems, $sectionsConfig, $title
 */

/* ── Safe defaults ── */
$siteBase  = $siteBase ?? ('/site/' . ($tenant->slug ?? 'demo'));
$dir       = $dir ?? 'rtl';
$lang      = $lang ?? 'ar';
$isRtl     = ($dir === 'rtl');

$whatsapp  = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
$waNumber  = preg_replace('/[^0-9+]/', '', $whatsapp);
$siteName  = htmlspecialchars($tenant->site_name ?? 'ماستر فيكس');
$logoLetter = mb_substr($tenant->site_name ?? 'M', 0, 1);

/* ── Banner / Hero ── */
$heroBanner = (!empty($banners) && isset($banners[0])) ? $banners[0] : null;
$heroTitle  = $heroBanner->title ?? '';
$heroSub    = $heroBanner->subtitle ?? '';
$heroDesc   = $heroBanner->description ?? '';
$heroBtn    = $heroBanner->button_text ?? 'احجز خدمة';
if ($lang === 'en') {
    $heroTitle = $heroBanner->title_en ?? $heroTitle;
    $heroSub   = $heroBanner->subtitle_en ?? $heroSub;
    $heroDesc  = $heroBanner->description ?? $heroDesc;
    $heroBtn   = $heroBanner->button_text_en ?? $heroBtn;
}

/* ── Stats ── */
$stats = [];
if (!empty($siteStats)) {
    foreach ($siteStats as $s) {
        $stats[] = $s;
    }
}
if (count($stats) < 3) {
    $stats = [
        (object)['value' => '10+', 'label' => 'سنوات خبرة', 'label_en' => 'Years Exp.', 'icon' => 'fas fa-clock'],
        (object)['value' => '24/7', 'label' => 'دعم طوارئ', 'label_en' => 'Emergency', 'icon' => 'fas fa-headset'],
        (object)['value' => '5K+',  'label' => 'عميل سعيد', 'label_en' => 'Happy Clients', 'icon' => 'fas fa-users'],
    ];
}

/* ── Features (Why Us) ── */
$features = [];
if (!empty($siteFeatures)) {
    foreach ($siteFeatures as $f) {
        $features[] = $f;
    }
}
if (empty($features)) {
    $features = [
        (object)['title' => 'استجابة سريعة ودعم طوارئ', 'title_en' => 'Fast Response & Emergency', 'description' => 'نصل إليكم بسرعة مع فريق مجهز وجاهز للعمل', 'description_en' => 'Quick arrival with equipped and ready team', 'icon' => 'fas fa-bolt'],
        (object)['title' => 'فنيون محترفون ومعتمدون', 'title_en' => 'Certified Expert Technicians', 'description' => 'فريق معتمد بخبرة عملية واسعة ومستمرة', 'description_en' => 'Certified team with extensive hands-on experience', 'icon' => 'fas fa-id-badge'],
        (object)['title' => 'أسعار مناسبة وجودة عالية', 'title_en' => 'Competitive Prices & High Quality', 'description' => 'جودة عالية بأسعار مناسبة للجميع', 'description_en' => 'Top quality at affordable prices for everyone', 'icon' => 'fas fa-tags'],
        (object)['title' => 'معدات حديثة وفحص ذكي', 'title_en' => 'Modern Equipment & Smart Inspection', 'description' => 'نستخدم أحدث الأدوات والتقنيات المتطورة', 'description_en' => 'We use the latest tools and cutting-edge technology', 'icon' => 'fas fa-tools'],
    ];
}

/* ── Services ── */
$allServices = [];
if (!empty($services)) {
    foreach ($services as $svc) {
        $allServices[] = $svc;
    }
}
if (empty($allServices)) {
    $allServices = [
        (object)['title' => 'الكهرباء', 'title_en' => 'Electricity', 'description' => 'تمديدات كهربائية، صيانة، تركيب وفحص كامل.', 'description_en' => 'Electrical wiring, maintenance, installation and full inspection.', 'icon' => 'fas fa-bolt', 'image' => ''],
        (object)['title' => 'السباكة', 'title_en' => 'Plumbing', 'description' => 'إصلاح التسريبات وصيانة وتركيب الأنابيب.', 'description_en' => 'Leak repair and pipe maintenance and installation.', 'icon' => 'fas fa-faucet-drip', 'image' => ''],
        (object)['title' => 'أنظمة التبريد', 'title_en' => 'Cooling Systems', 'description' => 'صيانة التكييف وحلول تبريد ذكية.', 'description_en' => 'AC maintenance and smart cooling solutions.', 'icon' => 'fas fa-snowflake', 'image' => ''],
        (object)['title' => 'إصلاح المنازل', 'title_en' => 'Home Repair', 'description' => 'خدمات احترافية لمعالجة جميع أعطال المنزل.', 'description_en' => 'Professional services to fix all home issues.', 'icon' => 'fas fa-house-chimney', 'image' => ''],
    ];
}

/* Service images (fallback) */
$serviceImages = [
    'https://images.unsplash.com/photo-1621905252507-b35492cc74b4?q=80&w=600&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1585704032915-c3400ca199e7?q=80&w=600&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1621905251918-48416bd8575a?q=80&w=600&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=600&auto=format&fit=crop',
];

/* Hero panel services (3 small cards) */
$panelServices = [];
if (!empty($services)) {
    $panelServices = array_slice($services, 0, 3);
}
if (empty($panelServices)) {
    $panelServices = [
        (object)['title' => 'صيانة الكهرباء', 'title_en' => 'Electrical Maintenance', 'description' => 'حلول سريعة واحترافية', 'description_en' => 'Fast & professional solutions', 'icon' => 'fas fa-bolt'],
        (object)['title' => 'خدمات السباكة', 'title_en' => 'Plumbing Services', 'description' => 'دعم طوارئ 24/7', 'description_en' => '24/7 emergency support', 'icon' => 'fas fa-faucet-drip'],
        (object)['title' => 'التكييف والتبريد', 'title_en' => 'AC & Cooling', 'description' => 'تركيب وصيانة احترافية', 'description_en' => 'Professional installation & maintenance', 'icon' => 'fas fa-snowflake'],
    ];
}

require_once __DIR__ . '/_head.php';
require_once __DIR__ . '/_navbar.php';
?>

<!-- Background Effects -->
<div class="absolute top-0 left-0 w-96 h-96 bg-cyan-500/20 blur-3xl rounded-full pointer-events-none"></div>
<div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-500/20 blur-3xl rounded-full pointer-events-none"></div>

<!-- ══════════════════════════════════════════════════════
     HERO SECTION
     ══════════════════════════════════════════════════════ -->
<section class="relative z-10 px-6 lg:px-20 pt-20 pb-24 grid lg:grid-cols-2 gap-14 items-center">
    <!-- Text Side -->
    <div class="fade-up">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 bg-white/5 border border-white/10 px-4 py-2 rounded-full text-sm text-cyan-300 mb-6">
            <span>&#11088;</span>
            <span><?= $heroSub ?: ($lang === 'en' ? 'Trusted by thousands' : 'أكثر من 5000 عميل يثق بنا') ?></span>
        </div>

        <!-- Title -->
        <h2 class="text-4xl sm:text-5xl lg:text-7xl font-black leading-tight mb-6">
            <?php if ($heroTitle): ?>
                <?= $heroTitle ?>
            <?php else: ?>
                <?= $lang === 'en' ? 'Professional <span class="text-cyan-400">Services</span> with Excellence' : 'خدمات <span class="text-cyan-400">الصيانة</span> الحديثة باحترافية عالية' ?>
            <?php endif; ?>
        </h2>

        <!-- Description -->
        <p class="text-lg text-gray-300 leading-relaxed mb-8 max-w-xl">
            <?= $heroDesc ?: ($lang === 'en'
                ? 'We deliver integrated maintenance solutions for homes and companies with the latest technologies, fast response, and a specialized team to ensure the best results.'
                : 'نقدم حلول صيانة متكاملة للمنازل والشركات بأحدث التقنيات، سرعة استجابة، وفريق متخصص لضمان أفضل النتائج.'
            ) ?>
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-wrap gap-4">
            <a href="https://wa.me/<?= $waNumber ?>" target="_blank"
               class="bg-cyan-500 hover:bg-cyan-400 transition px-7 py-4 rounded-2xl font-bold text-lg shadow-xl shadow-cyan-500/30">
                <?= $heroBtn ?: 'احجز خدمة' ?>
            </a>
            <a href="#services"
               class="border border-white/20 hover:border-cyan-400 hover:text-cyan-300 transition px-7 py-4 rounded-2xl font-bold text-lg backdrop-blur-md bg-white/5">
                <?= $lang === 'en' ? 'Learn More' : 'اعرف المزيد' ?>
            </a>
        </div>

        <!-- Mini Stats -->
        <div class="grid grid-cols-3 gap-5 mt-14">
            <?php foreach (array_slice($stats, 0, 3) as $i => $stat): ?>
                <div class="bg-white/5 border border-white/10 p-5 rounded-3xl backdrop-blur-md">
                    <h3 class="text-2xl sm:text-3xl font-black text-cyan-400"><?= htmlspecialchars($stat->value) ?></h3>
                    <p class="text-gray-400 mt-1 text-sm"><?= $lang === 'en' && !empty($stat->label_en) ? $stat->label_en : ($stat->label ?? '') ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- ═══════ Hero Graphic (Service Panel) ═══════ -->
    <div class="relative flex items-center justify-center fade-up" style="transition-delay:.15s">
        <div class="absolute w-[550px] h-[550px] bg-cyan-500/20 rounded-full blur-3xl"></div>

        <div class="relative w-full max-w-[550px] aspect-square rounded-[40px] bg-gradient-to-br from-cyan-500 to-blue-700 p-[2px] shadow-2xl shadow-cyan-500/20">
            <div class="w-full h-full rounded-[38px] bg-[#111827] p-8 flex flex-col justify-between overflow-hidden">

                <!-- Panel Header -->
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-400 text-sm"><?= $lang === 'en' ? 'Service Status' : 'حالة الخدمة' ?></p>
                        <h3 class="text-2xl font-bold mt-1"><?= $lang === 'en' ? 'System Active' : 'النظام يعمل' ?></h3>
                    </div>
                    <div class="w-16 h-16 rounded-2xl bg-cyan-500/20 border border-cyan-400/20 flex items-center justify-center text-3xl">
                        <span>&#128295;</span>
                    </div>
                </div>

                <!-- Service Cards (3) -->
                <div class="space-y-5 mt-8">
                    <?php foreach ($panelServices as $pi => $psvc): ?>
                        <div class="bg-white/5 border border-white/10 p-5 rounded-3xl flex justify-between items-center hover:border-cyan-400/30 transition">
                            <div class="flex-1 min-w-0 me-3">
                                <h4 class="font-bold text-lg truncate">
                                    <?= $lang === 'en' && !empty($psvc->title_en) ? $psvc->title_en : ($psvc->title ?? '') ?>
                                </h4>
                                <p class="text-gray-400 text-sm truncate">
                                    <?= $lang === 'en' && !empty($psvc->description_en) ? $psvc->description_en : ($psvc->description ?? '') ?>
                                </p>
                            </div>
                            <?php
                                $panelEmojis = ['&#9889;', '&#128706;', '&#10052;&#65039;'];
                                $panelIcons  = ['fas fa-bolt', 'fas fa-faucet-drip', 'fas fa-snowflake'];
                                $emoji = $panelEmojis[$pi % 3];
                                $icon  = !empty($psvc->icon) ? $psvc->icon : $panelIcons[$pi % 3];
                            ?>
                            <span class="text-cyan-400 text-2xl flex-shrink-0"><?= $emoji ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Quick Call CTA -->
                <div class="mt-8 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-3xl p-6">
                    <div class="flex justify-between items-center flex-wrap gap-3">
                        <div>
                            <p class="text-sm opacity-80"><?= $lang === 'en' ? 'Quick Call' : 'اتصال سريع' ?></p>
                            <h4 class="text-2xl font-black mt-1">
                                <?= htmlspecialchars($tenant->contact_phone ?: ($waNumber ?: '+90 555 000 000')) ?>
                            </h4>
                        </div>
                        <a href="https://wa.me/<?= $waNumber ?: '' ?>" target="_blank"
                           class="bg-white text-black px-5 py-3 rounded-2xl font-bold hover:scale-105 transition">
                            <?= $lang === 'en' ? 'Contact' : 'تواصل' ?>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════
     SERVICES SECTION
     ══════════════════════════════════════════════════════ -->
<section id="services" class="relative z-10 px-6 lg:px-20 py-24 bg-white/5 border-y border-white/10">
    <div class="text-center max-w-3xl mx-auto mb-16 fade-up">
        <p class="text-cyan-400 font-semibold uppercase tracking-[4px] mb-4">
            <?= $lang === 'en' ? 'Our Services' : 'خدماتنا' ?>
        </p>
        <h2 class="text-4xl lg:text-5xl font-black mb-6">
            <?= $lang === 'en' ? 'Integrated Maintenance Solutions' : 'حلول صيانة متكاملة' ?>
        </h2>
        <p class="text-gray-400 text-lg leading-relaxed">
            <?= $lang === 'en'
                ? 'Trusted services delivered by certified professionals using the latest technologies and modern tools.'
                : 'خدمات موثوقة يقدمها فنيون محترفون باستخدام أحدث التقنيات والأدوات الحديثة.'
            ?>
        </p>
    </div>

    <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-8">
        <?php foreach ($allServices as $i => $svc): ?>
            <?php
                $svcTitle = $lang === 'en' && !empty($svc->title_en) ? $svc->title_en : ($svc->title ?? '');
                $svcDesc  = $lang === 'en' && !empty($svc->description_en) ? $svc->description_en : ($svc->description ?? '');
                $svcImg   = !empty($svc->image) ? $svc->image : ($serviceImages[$i % count($serviceImages)] ?? '');
                $svcIcon  = $svc->icon ?? 'fas fa-star';
                $svcEmojis = ['&#9889;', '&#128706;', '&#10052;&#65039;', '&#127968;'];
                $svcEmoji  = $svcEmojis[$i % 4];
            ?>
            <div class="group bg-[#111827] border border-white/10 rounded-[30px] overflow-hidden hover:border-cyan-400/40 hover:-translate-y-2 transition duration-300 shadow-xl fade-up">
                <!-- Image -->
                <div class="relative h-56 overflow-hidden">
                    <?php if ($svcImg): ?>
                        <img src="<?= htmlspecialchars($svcImg) ?>"
                             alt="<?= htmlspecialchars($svcTitle) ?>"
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <?php else: ?>
                        <div class="w-full h-full bg-gradient-to-br from-cyan-900/40 to-blue-900/40 flex items-center justify-center">
                            <i class="<?= htmlspecialchars($svcIcon) ?> text-5xl text-cyan-400/40"></i>
                        </div>
                    <?php endif; ?>

                    <div class="absolute inset-0 bg-gradient-to-t from-[#111827] via-black/30 to-transparent"></div>

                    <div class="absolute top-5 <?= $isRtl ? 'right-5' : 'left-5' ?> w-16 h-16 rounded-2xl bg-cyan-500/20 backdrop-blur-md border border-cyan-400/20 flex items-center justify-center text-3xl shadow-lg shadow-cyan-500/20">
                        <?= $svcEmoji ?>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-8">
                    <h3 class="text-2xl font-bold mb-4 group-hover:text-cyan-400 transition">
                        <?= htmlspecialchars($svcTitle) ?>
                    </h3>
                    <p class="text-gray-400 leading-relaxed mb-6">
                        <?= htmlspecialchars($svcDesc) ?>
                    </p>
                    <a href="<?= url($siteBase . '/service/' . ($svc->slug ?? 'service-' . ($i + 1))) ?>"
                       class="block w-full text-center bg-white/5 border border-white/10 hover:bg-cyan-500 hover:border-cyan-500 transition rounded-2xl py-4 font-semibold">
                        <?= $lang === 'en' ? 'View Details' : 'عرض التفاصيل' ?>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════
     WHY US / FEATURES SECTION
     ══════════════════════════════════════════════════════ -->
<section id="features" class="relative z-10 px-6 lg:px-20 py-24">
    <div class="grid lg:grid-cols-2 gap-16 items-center">
        <!-- Text Side -->
        <div class="fade-up">
            <p class="text-cyan-400 font-semibold uppercase tracking-[4px] mb-4">
                <?= $lang === 'en' ? 'Why Us' : 'لماذا نحن' ?>
            </p>

            <h2 class="text-4xl lg:text-5xl font-black leading-tight mb-8">
                <?= $lang === 'en' ? 'Smart Maintenance with Modern Technology' : 'صيانة ذكية بتقنيات حديثة' ?>
            </h2>

            <div class="space-y-6">
                <?php foreach ($features as $feat): ?>
                    <?php
                        $featTitle = $lang === 'en' && !empty($feat->title_en) ? $feat->title_en : ($feat->title ?? '');
                        $featDesc  = $lang === 'en' && !empty($feat->description_en) ? $feat->description_en : ($feat->description ?? '');
                    ?>
                    <div class="flex items-center gap-5 bg-white/5 border border-white/10 rounded-2xl p-5 hover:border-cyan-400/30 transition">
                        <div class="w-12 h-12 rounded-xl bg-cyan-500 flex items-center justify-center font-black text-xl text-black flex-shrink-0">
                            &#10003;
                        </div>
                        <div>
                            <p class="text-lg text-gray-200 font-bold"><?= htmlspecialchars($featTitle) ?></p>
                            <?php if ($featDesc): ?>
                                <p class="text-gray-400 text-sm mt-1"><?= htmlspecialchars($featDesc) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Stats Card -->
        <div class="relative fade-up" style="transition-delay:.15s">
            <div class="absolute inset-0 bg-cyan-500/10 blur-3xl rounded-full"></div>

            <div class="relative bg-gradient-to-br from-cyan-500 to-blue-700 p-[2px] rounded-[40px]">
                <div class="bg-[#111827] rounded-[38px] p-10 space-y-8">
                    <!-- Header -->
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-400"><?= $lang === 'en' ? 'Project Completion' : 'إنجاز المشاريع' ?></p>
                            <h3 class="text-4xl font-black mt-2 text-cyan-400">98%</h3>
                        </div>
                        <div class="text-5xl"><span>&#128202;</span></div>
                    </div>

                    <!-- Progress Bars -->
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between mb-2 text-sm">
                                <span><?= $lang === 'en' ? 'Client Satisfaction' : 'رضا العملاء' ?></span>
                                <span class="text-cyan-400">95%</span>
                            </div>
                            <div class="h-3 bg-white/10 rounded-full overflow-hidden">
                                <div class="h-full w-[95%] bg-cyan-500 rounded-full"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-2 text-sm">
                                <span><?= $lang === 'en' ? 'Response Speed' : 'سرعة الاستجابة' ?></span>
                                <span class="text-blue-400">90%</span>
                            </div>
                            <div class="h-3 bg-white/10 rounded-full overflow-hidden">
                                <div class="h-full w-[90%] bg-blue-500 rounded-full"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-2 gap-5">
                        <div class="bg-white/5 rounded-2xl p-6 border border-white/10">
                            <h4 class="text-3xl font-black text-cyan-400">500+</h4>
                            <p class="text-gray-400 mt-2"><?= $lang === 'en' ? 'Completed Projects' : 'مشروع منجز' ?></p>
                        </div>
                        <div class="bg-white/5 rounded-2xl p-6 border border-white/10">
                            <h4 class="text-3xl font-black text-cyan-400">24/7</h4>
                            <p class="text-gray-400 mt-2"><?= $lang === 'en' ? 'Support Team' : 'فريق دعم' ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════
     CTA SECTION
     ══════════════════════════════════════════════════════ -->
<section class="relative z-10 px-6 lg:px-20 pb-24 fade-up">
    <div class="bg-gradient-to-r from-cyan-500 to-blue-700 rounded-[40px] p-12 lg:p-16 text-center shadow-2xl shadow-cyan-500/20">
        <h2 class="text-4xl lg:text-6xl font-black leading-tight mb-6">
            <?= $lang === 'en' ? 'Need Professional Maintenance?' : 'تحتاج إلى صيانة احترافية؟' ?>
        </h2>

        <p class="text-lg lg:text-xl opacity-90 max-w-3xl mx-auto leading-relaxed mb-10">
            <?= $lang === 'en'
                ? 'Contact our team now and get fast, professional maintenance services with the highest quality for your home or company.'
                : 'تواصل مع فريقنا الآن واحصل على خدمات صيانة سريعة واحترافية بأعلى جودة لمنزلك أو شركتك.'
            ?>
        </p>

        <a href="https://wa.me/<?= $waNumber ?>" target="_blank"
           class="inline-block bg-white text-black hover:scale-105 transition px-10 py-5 rounded-2xl font-black text-lg shadow-xl">
            <?= $lang === 'en' ? 'Request Service Now' : 'اطلب الخدمة الآن' ?>
        </a>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

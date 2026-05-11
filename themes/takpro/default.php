<?php
/**
 * TakPro Theme — Default (Landing Page)
 * Converted from React: CleaningLandingPage component
 * Light theme + Orange (#ff7a00) accent + Cairo font + Dynamic CMS content
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
$siteName  = htmlspecialchars($tenant->site_name ?? 'تك برو');
$siteNameEn = htmlspecialchars($tenant->site_name_en ?? 'TakPro');
$displaySiteName = ($lang ?? 'ar') === 'en' ? $siteNameEn : $siteName;

/* ── Banner / Hero ── */
$heroBanner = (!empty($banners) && isset($banners[0])) ? $banners[0] : null;
$heroTitle  = $heroBanner->title ?? '';
$heroSub    = $heroBanner->subtitle ?? '';
$heroDesc   = $heroBanner->description ?? '';
$heroBtn    = $heroBanner->button_text ?? 'ابدأ الآن';
$heroImage  = $heroBanner->image ?? '';
if ($lang === 'en') {
    $heroTitle = $heroBanner->title_en ?? $heroTitle;
    $heroSub   = $heroBanner->subtitle_en ?? $heroSub;
    $heroDesc  = $heroBanner->description_en ?? $heroDesc;
    $heroBtn   = $heroBanner->button_text_en ?? $heroBtn;
}

/* ── Services ── */
$allServices = [];
if (!empty($services)) {
    foreach ($services as $svc) { $allServices[] = $svc; }
}
if (empty($allServices)) {
    $allServices = [
        (object)['title' => 'الدعم التقني', 'title_en' => 'Technical Support', 'description' => 'حلول تقنية متكاملة وفورية', 'description_en' => 'Integrated and instant tech solutions', 'icon' => 'fas fa-headset', 'image' => '', 'slug' => 'tech-support'],
        (object)['title' => 'حلول الشبكات', 'title_en' => 'Network Solutions', 'description' => 'تصميم وإدارة شبكات احترافية', 'description_en' => 'Professional network design & management', 'icon' => 'fas fa-network-wired', 'image' => '', 'slug' => 'network'],
        (object)['title' => 'صيانة الأنظمة', 'title_en' => 'System Maintenance', 'description' => 'صيانة دورية وطارئة', 'description_en' => 'Regular & emergency maintenance', 'icon' => 'fas fa-tools', 'image' => '', 'slug' => 'maintenance'],
        (object)['title' => 'تعقيم كامل', 'title_en' => 'Full Sanitization', 'description' => 'تعقيم شامل بمواد آمنة', 'description_en' => 'Comprehensive sanitization with safe materials', 'icon' => 'fas fa-shield-virus', 'image' => '', 'slug' => 'sanitization'],
        (object)['title' => 'تنظيف الزجاج', 'title_en' => 'Glass Cleaning', 'description' => 'تنظيف ولمعان الزجاج', 'description_en' => 'Glass cleaning & polishing', 'icon' => 'fas fa-spray-can-sparkles', 'image' => '', 'slug' => 'glass-cleaning'],
        (object)['title' => 'تنظيف بعد البناء', 'title_en' => 'Post-Construction', 'description' => 'تنظيف شامل بعد أعمال البناء', 'description_en' => 'Comprehensive cleaning after construction', 'icon' => 'fas fa-hard-hat', 'image' => '', 'slug' => 'post-construction'],
    ];
}

/* Service images (fallback) */
$serviceImages = [
    'https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1585421514284-efb74c2b69ba?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1528744598421-b7b93e12df54?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=900&auto=format&fit=crop',
];

/* ── Features (Why Us) ── */
$features = [];
if (!empty($siteFeatures)) {
    foreach ($siteFeatures as $f) { $features[] = $f; }
}
if (empty($features)) {
    $features = [
        (object)['title' => 'أسعار مناسبة', 'title_en' => 'Affordable Prices', 'description' => 'أسعار تنافسية تناسب الجميع', 'description_en' => 'Competitive prices for everyone', 'icon' => 'fas fa-tags'],
        (object)['title' => 'خدمة في نفس اليوم', 'title_en' => 'Same-Day Service', 'description' => 'استجابة سريعة خلال ساعات', 'description_en' => 'Fast response within hours', 'icon' => 'fas fa-clock'],
        (object)['title' => 'مواد آمنة', 'title_en' => 'Safe Materials', 'description' => 'منتجات صديقة للبيئة', 'description_en' => 'Eco-friendly products', 'icon' => 'fas fa-leaf'],
        (object)['title' => 'فريق محترف', 'title_en' => 'Expert Team', 'description' => 'فنيون معتمدون ومدربون', 'description_en' => 'Certified & trained technicians', 'icon' => 'fas fa-user-check'],
        (object)['title' => 'نتائج مضمونة', 'title_en' => 'Guaranteed Results', 'description' => 'جودة عالية مع ضمان الخدمة', 'description_en' => 'High quality with service guarantee', 'icon' => 'fas fa-award'],
    ];
}

/* ── Stats ── */
$stats = [];
if (!empty($siteStats)) {
    foreach ($siteStats as $s) { $stats[] = $s; }
}
if (count($stats) < 3) {
    $stats = [
        (object)['value' => '8000', 'label' => 'عميل سعيد', 'label_en' => 'Happy Clients', 'icon' => 'fas fa-smile', 'suffix' => '+'],
        (object)['value' => '5000', 'label' => 'مشروع منجز', 'label_en' => 'Projects Done', 'icon' => 'fas fa-check-circle', 'suffix' => '+'],
        (object)['value' => '98', 'label' => 'نسبة الرضا', 'label_en' => 'Satisfaction Rate', 'icon' => 'fas fa-chart-line', 'suffix' => '%'],
    ];
}

/* ── Testimonials ── */
$allTestimonials = [];
if (!empty($testimonials)) {
    foreach ($testimonials as $t) { $allTestimonials[] = $t; }
}
if (empty($allTestimonials)) {
    $allTestimonials = [
        (object)['name' => 'أحمد محمد', 'name_en' => 'Ahmed Mohammed', 'content' => 'خدمة ممتازة وسريعة، الفريق محترم والنتيجة كانت رائعة. أنصح بالتعامل معهم.', 'content_en' => 'Excellent and fast service, the team is professional and the result was amazing. I recommend dealing with them.', 'rating' => 5],
        (object)['name' => 'سارة علي', 'name_en' => 'Sara Ali', 'content' => 'تعاملت معهم أكثر من مرة وكل مرة أكون راضي تماماً عن النتيجة. خدمة موثوقة فعلاً.', 'content_en' => 'I dealt with them more than once and every time I am fully satisfied with the result. Truly reliable service.', 'rating' => 5],
    ];
}

require_once __DIR__ . '/_head.php';
require_once __DIR__ . '/_navbar.php';
?>

<!-- ══════════════════════════════════════════════════════
     HERO SECTION
     ══════════════════════════════════════════════════════ -->
<section class="relative min-h-[690px] bg-dark-section">
    <!-- Background Image -->
    <?php if ($heroImage): ?>
        <img src="<?= upload($heroImage) ?>" class="absolute inset-0 w-full h-full object-cover" alt="<?= htmlspecialchars($displaySiteName) ?>">
    <?php else: ?>
        <img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=1800&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover" alt="hero">
    <?php endif; ?>
    <div class="absolute inset-0 bg-black/55"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-16 pt-24">
        <div class="max-w-[500px] text-white fade-up">
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-black leading-[1.05] mb-5">
                <?php if ($heroTitle): ?>
                    <?= $heroTitle ?>
                <?php else: ?>
                    <?= $lang === 'en'
                        ? 'Make Your<br>Home Shine<br>Every Day'
                        : 'خلّي بيتك<br>يلمع<br>كل يوم' ?>
                <?php endif; ?>
            </h2>
            <p class="text-lg text-gray-100 leading-relaxed mb-7">
                <?= $heroDesc ?: ($lang === 'en'
                    ? 'Fast and reliable cleaning services for homes and companies with the highest quality and reasonable prices.'
                    : 'خدمات تنظيف سريعة وموثوقة للمنازل والشركات بأعلى جودة وأسعار مناسبة.') ?>
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="https://wa.me/<?= $waNumber ?>" target="_blank"
                   class="bg-white text-dark px-8 py-3 font-black hover:bg-brand hover:text-white transition">
                    <?= $heroBtn ?>
                </a>
                <a href="#services"
                   class="border border-white/30 text-white px-8 py-3 font-black hover:bg-white/10 transition">
                    <?= $lang === 'en' ? 'Our Services' : 'خدماتنا' ?>
                </a>
            </div>
        </div>
    </div>

    <!-- Floating Phone Bar -->
    <?php if ($waNumber || !empty($tenant->contact_phone)): ?>
    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 z-20 w-[360px] max-w-[90%] bg-brand text-white px-8 py-5 flex items-center justify-center gap-4 shadow-2xl">
        <span class="w-12 h-12 bg-white text-brand rounded-full flex items-center justify-center text-xl">
            <i class="fas fa-phone-volume"></i>
        </span>
        <div>
            <p class="text-xs font-bold opacity-90"><?= $lang === 'en' ? 'Call Us Now' : 'اتصل بنا الآن' ?></p>
            <h3 class="text-2xl font-black"><?= htmlspecialchars($tenant->contact_phone ?? $waNumber) ?></h3>
        </div>
    </div>
    <?php endif; ?>
</section>

<!-- ══════════════════════════════════════════════════════
     INTRO / ABOUT SECTION
     ══════════════════════════════════════════════════════ -->
<section class="bg-[#f3f3f3] px-6 lg:px-16 py-20">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-14 items-center">
        <!-- Images Grid -->
        <div class="grid grid-cols-2 gap-4 max-w-[430px] mx-auto lg:mx-0 fade-up">
            <!-- Stats Card -->
            <div class="bg-dark-card text-white p-6 min-h-[120px] flex flex-col justify-center">
                <?php if (!empty($stats[0])): ?>
                    <div class="flex -space-x-3 space-x-reverse mb-3">
                        <?php for ($ci = 0; $ci < 4; $ci++): ?>
                            <span class="w-10 h-10 rounded-full bg-white border-2 border-brand flex items-center justify-center text-sm text-dark">
                                <i class="fas fa-user"></i>
                            </span>
                        <?php endfor; ?>
                    </div>
                    <p class="font-black">
                        <span data-count="<?= preg_replace('/[^0-9]/', '', $stats[0]->value) ?>" data-suffix="<?= $stats[0]->suffix ?? '+' ?>">0</span>
                        <?= $lang === 'en' && !empty($stats[0]->label_en) ? $stats[0]->label_en : ($stats[0]->label ?? '') ?>
                    </p>
                <?php endif; ?>
            </div>
            <img src="https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?q=80&w=700&auto=format&fit=crop" class="w-full h-[210px] object-cover rounded-lg" alt="">
            <img src="https://images.unsplash.com/photo-1585421514284-efb74c2b69ba?q=80&w=700&auto=format&fit=crop" class="w-full h-[210px] object-cover rounded-lg" alt="">
            <div class="bg-brand p-7 flex items-center justify-center text-white text-5xl rounded-lg">
                <i class="fas fa-broom"></i>
            </div>
        </div>

        <!-- Text Content -->
        <div class="fade-up" style="transition-delay:.1s">
            <p class="text-brand font-black mb-3">
                <?= $lang === 'en' ? 'Welcome to ' . $displaySiteName : 'مرحباً بكم في ' . $displaySiteName ?>
            </p>
            <h2 class="text-4xl lg:text-5xl font-black leading-tight mb-6">
                <?= $lang === 'en'
                    ? 'Professional Services We Provide to Our Clients'
                    : 'خدمات احترافية نقدمها لعملائنا' ?>
            </h2>
            <p class="text-gray-600 leading-loose mb-7">
                <?= $lang === 'en'
                    ? 'We provide integrated cleaning solutions for homes, offices, carpets, and commercial facilities. Our team is trained, our materials are safe, and our service is fast and available throughout the week.'
                    : 'نقدم حلول تنظيف متكاملة للمنازل والمكاتب والسجاد والمرافق التجارية. فريقنا مدرب، موادنا آمنة، وخدمتنا سريعة ومتاحة على مدار الأسبوع.' ?>
            </p>
            <ul class="space-y-3 font-bold text-dark mb-8">
                <?php foreach (array_slice($features, 0, 3) as $feat): ?>
                    <?php
                        $featTitle = $lang === 'en' && !empty($feat->title_en) ? $feat->title_en : ($feat->title ?? '');
                    ?>
                    <li><i class="fas fa-check-circle text-brand ml-2"></i><?= htmlspecialchars($featTitle) ?></li>
                <?php endforeach; ?>
            </ul>
            <a href="<?= url($siteBase . '/about') ?>" class="inline-block bg-dark-card text-white px-7 py-3 rounded-full font-black hover:bg-brand transition">
                <?= $lang === 'en' ? 'Learn More' : 'اعرف المزيد' ?>
            </a>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════
     TRUSTED / WHY US SECTION
     ══════════════════════════════════════════════════════ -->
<section class="px-6 lg:px-16 py-20 bg-white">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-14 items-center">
        <div class="fade-up">
            <h2 class="text-5xl font-black mb-2"><?= $lang === 'en' ? 'Trusted' : 'موثوقون' ?></h2>
            <p class="font-black mb-6"><?= $lang === 'en' ? 'Highly Reliable Service' : 'خدمة باعتمادية عالية' ?></p>
            <div class="space-y-3 max-w-sm">
                <?php foreach ($features as $feat): ?>
                    <?php
                        $featTitle = $lang === 'en' && !empty($feat->title_en) ? $feat->title_en : ($feat->title ?? '');
                    ?>
                    <div class="bg-brand text-white px-6 py-3 font-black text-center rounded-sm"><?= htmlspecialchars($featTitle) ?></div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="relative max-w-[430px] mx-auto fade-up" style="transition-delay:.1s">
            <img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=900&auto=format&fit=crop"
                 class="w-full h-[470px] object-cover rounded-lg shadow-xl" alt="">
            <div class="absolute inset-0 flex items-center justify-center">
                <a href="https://wa.me/<?= $waNumber ?>" target="_blank"
                   class="w-16 h-16 rounded-full bg-white text-brand flex items-center justify-center text-2xl shadow-xl hover:scale-110 transition">
                    <i class="fas fa-play"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════
     SERVICES PANEL SECTION
     ══════════════════════════════════════════════════════ -->
<section id="services" class="bg-brand py-20 px-6 lg:px-16">
    <div class="max-w-4xl mx-auto bg-white rounded-xl p-8 lg:p-10 shadow-2xl text-center fade-up">
        <h2 class="text-4xl font-black leading-tight mb-7">
            <?= $lang === 'en'
                ? 'Reliable Cleaning Solutions<br>with High Care'
                : 'حلول تنظيف موثوقة<br>بعناية عالية' ?>
        </h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($allServices as $i => $svc): ?>
                <?php
                    $svcTitle = $lang === 'en' && !empty($svc->title_en) ? $svc->title_en : ($svc->title ?? '');
                    $svcImg   = !empty($svc->image) ? upload($svc->image) : ($serviceImages[$i % count($serviceImages)] ?? '');
                ?>
                <a href="<?= url($siteBase . '/service/' . ($svc->slug ?? 'service-' . ($i + 1))) ?>"
                   class="relative rounded-lg overflow-hidden h-28 group block">
                    <img src="<?= htmlspecialchars($svcImg) ?>"
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-700" alt="<?= htmlspecialchars($svcTitle) ?>">
                    <div class="absolute inset-0 bg-black/45"></div>
                    <h3 class="absolute inset-x-2 bottom-3 text-white font-black text-sm"><?= htmlspecialchars($svcTitle) ?></h3>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════
     BIG GRAPHIC SECTION
     ══════════════════════════════════════════════════════ -->
<section class="relative bg-[#f4f4f4] px-6 lg:px-16 pt-12 pb-0 overflow-hidden">
    <h2 class="absolute inset-x-0 top-6 text-center text-[110px] lg:text-[180px] font-black text-black/5 leading-none">
        <?= $lang === 'en' ? 'Service' : 'خدمة' ?>
    </h2>
    <div class="relative max-w-5xl mx-auto flex justify-center pt-20 fade-up">
        <img src="https://images.unsplash.com/photo-1585421514284-efb74c2b69ba?q=80&w=1200&auto=format&fit=crop"
             class="w-[760px] h-[260px] object-cover rounded-t-2xl shadow-2xl" alt="">
    </div>
    <div class="h-10 bg-dark mt-0"></div>
</section>

<!-- ══════════════════════════════════════════════════════
     STATS SECTION
     ══════════════════════════════════════════════════════ -->
<section class="px-6 lg:px-16 py-20 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-14 fade-up">
            <h2 class="text-5xl font-black mb-2"><?= $lang === 'en' ? 'Our Numbers Speak' : 'أرقامنا تتحدث' ?></h2>
            <p class="font-black"><?= $lang === 'en' ? 'We take pride in our achievements' : 'نفخر بإنجازاتنا' ?></p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($stats as $i => $stat): ?>
                <?php
                    $statLabel = $lang === 'en' && !empty($stat->label_en) ? $stat->label_en : ($stat->label ?? '');
                    $statIcon  = $stat->icon ?? 'fas fa-chart-bar';
                    $statValue = preg_replace('/[^0-9]/', '', $stat->value);
                    $statSuffix = $stat->suffix ?? '+';
                ?>
                <div class="bg-[#f5f5f5] rounded-xl p-8 text-center fade-up" style="transition-delay:<?= ($i * 0.1) ?>s">
                    <div class="w-16 h-16 bg-brand rounded-full mx-auto mb-5 flex items-center justify-center text-white text-2xl">
                        <i class="<?= htmlspecialchars($statIcon) ?>"></i>
                    </div>
                    <h3 class="text-4xl font-black text-dark mb-2">
                        <span data-count="<?= $statValue ?>" data-suffix="<?= $statSuffix ?>">0</span>
                    </h3>
                    <p class="text-gray-600 font-bold"><?= htmlspecialchars($statLabel) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════
     QUICK ORDER SECTION
     ══════════════════════════════════════════════════════ -->
<section class="bg-[#f1f1f1] px-6 lg:px-16 py-20">
    <div class="max-w-5xl mx-auto">
        <div class="grid lg:grid-cols-[.55fr_1fr] gap-6 items-start">
            <div class="fade-up">
                <h2 class="text-5xl font-black leading-tight">
                    <?= $lang === 'en' ? 'Quick<br>Order' : 'للطلب<br>السريع' ?>
                </h2>
                <p class="font-bold mt-3">
                    <?= $lang === 'en' ? 'Professional service on time' : 'خدمة احترافية في الوقت المناسب' ?>
                </p>
            </div>
            <div class="relative fade-up" style="transition-delay:.1s">
                <img src="https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?q=80&w=1200&auto=format&fit=crop"
                     class="w-full h-[390px] object-cover rounded-lg shadow-xl" alt="">
                <div class="absolute inset-0 flex items-center justify-center">
                    <a href="https://wa.me/<?= $waNumber ?>" target="_blank"
                       class="w-16 h-16 bg-white rounded-full text-brand flex items-center justify-center text-2xl shadow-xl hover:scale-110 transition">
                        <i class="fas fa-play"></i>
                    </a>
                </div>
                <div class="absolute -bottom-8 left-8 right-8 bg-brand text-white rounded-md grid grid-cols-2 md:grid-cols-4 gap-3 p-5 text-center font-black text-sm shadow-xl">
                    <?php foreach (array_slice($features, 0, 4) as $feat): ?>
                        <?php
                            $featTitle = $lang === 'en' && !empty($feat->title_en) ? $feat->title_en : ($feat->title ?? '');
                        ?>
                        <span><?= htmlspecialchars($featTitle) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════
     TESTIMONIALS SECTION
     ══════════════════════════════════════════════════════ -->
<section class="bg-white px-6 lg:px-16 py-20">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-14 items-center mb-10">
        <!-- Avatars Grid -->
        <div class="relative h-[360px] bg-[#f7f7f7] rounded-xl fade-up">
            <?php for ($ai = 0; $ai < 7; $ai++): ?>
                <span class="absolute w-14 h-14 rounded-full bg-white shadow-xl flex items-center justify-center text-gray-400"
                      style="<?= $isRtl ? 'right' : 'left' ?>: <?= 15 + ($ai * 11) % 60 ?>%; top: <?= 20 + ($ai * 17) % 60 ?>%;">
                    <i class="fas fa-user"></i>
                </span>
            <?php endfor; ?>
        </div>

        <!-- Testimonial Card -->
        <div class="fade-up" style="transition-delay:.1s">
            <h2 class="text-5xl font-black mb-3"><?= $lang === 'en' ? 'Client Reviews' : 'آراء العملاء' ?></h2>
            <p class="font-black mb-6"><?= $lang === 'en' ? 'What Our Clients Say' : 'ماذا يقول عملاؤنا' ?></p>

            <div class="bg-[#f5f5f5] p-8 max-w-md rounded-xl" id="takproTestimonialCard">
                <?php if (!empty($allTestimonials[0])): ?>
                    <?php
                        $tName = $lang === 'en' && !empty($allTestimonials[0]->name_en) ? $allTestimonials[0]->name_en : ($allTestimonials[0]->name ?? '');
                        $tContent = $lang === 'en' && !empty($allTestimonials[0]->content_en) ? $allTestimonials[0]->content_en : ($allTestimonials[0]->content ?? '');
                        $tRating = $allTestimonials[0]->rating ?? 5;
                    ?>
                    <div class="flex items-center gap-1 mb-4">
                        <?php for ($st = 0; $st < 5; $st++): ?>
                            <i class="fas fa-star <?= $st < $tRating ? 'text-brand' : 'text-gray-300' ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="text-gray-600 leading-loose mb-6" id="takproTestimonialText"><?= htmlspecialchars($tContent) ?></p>
                    <div class="flex items-center gap-3">
                        <span class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-brand"><i class="fas fa-user"></i></span>
                        <b id="takproTestimonialName"><?= htmlspecialchars($tName) ?></b>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Navigation Dots -->
            <?php if (count($allTestimonials) > 1): ?>
            <div class="flex items-center gap-2 mt-6">
                <?php foreach ($allTestimonials as $ti => $t): ?>
                    <button onclick="switchTestimonial(<?= $ti ?>)"
                            class="takpro-testimonial-dot w-3 h-3 rounded-full <?= $ti === 0 ? 'bg-brand' : 'bg-gray-300' ?> transition hover:bg-brand"
                            data-index="<?= $ti ?>"></button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════
     TRANSPARENT PRICING SECTION
     ══════════════════════════════════════════════════════ -->
<section class="relative px-6 lg:px-16 py-20 bg-dark-section text-white overflow-hidden">
    <img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=1600&auto=format&fit=crop"
         class="absolute inset-0 w-full h-full object-cover opacity-25" alt="">
    <div class="relative max-w-7xl mx-auto grid lg:grid-cols-2 gap-10 items-center">
        <div class="fade-up">
            <h2 class="text-5xl font-black mb-4"><?= $lang === 'en' ? 'Transparent Prices' : 'أسعار واضحة' ?></h2>
            <p class="text-xl font-bold mb-6"><?= $lang === 'en' ? 'No surprises or hidden fees' : 'بدون مفاجآت أو رسوم مخفية' ?></p>
            <p class="text-gray-300 leading-loose mb-7">
                <?= $lang === 'en'
                    ? 'We set the price clearly based on service type and area, and we are committed to quality and the agreed time.'
                    : 'نحدد السعر بوضوح حسب نوع الخدمة والمساحة، ونلتزم بالجودة والوقت المتفق عليه.' ?>
            </p>
            <a href="https://wa.me/<?= $waNumber ?>" target="_blank"
               class="inline-block bg-brand text-white px-7 py-3 font-black hover:bg-brand-dark transition">
                <?= $lang === 'en' ? 'Get Price' : 'اعرف السعر' ?>
            </a>
        </div>
        <div class="bg-brand p-8 max-w-sm mx-auto text-dark rounded-xl fade-up" style="transition-delay:.1s">
            <ul class="space-y-4 font-black mb-6">
                <li><i class="fas fa-check-circle text-dark ml-2"></i><?= $lang === 'en' ? 'Clear Pricing' : 'سعر واضح' ?></li>
                <li><i class="fas fa-check-circle text-dark ml-2"></i><?= $lang === 'en' ? 'Guaranteed Service' : 'خدمة مضمونة' ?></li>
                <li><i class="fas fa-check-circle text-dark ml-2"></i><?= $lang === 'en' ? 'Trained Team' : 'فريق مدرب' ?></li>
                <li><i class="fas fa-check-circle text-dark ml-2"></i><?= $lang === 'en' ? 'Safe Materials' : 'مواد آمنة' ?></li>
            </ul>
            <img src="https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?q=80&w=600&auto=format&fit=crop"
                 class="w-full h-32 object-cover rounded-lg" alt="">
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════
     CTA SECTION
     ══════════════════════════════════════════════════════ -->
<section class="px-6 lg:px-16 py-20 bg-white fade-up">
    <div class="max-w-4xl mx-auto bg-dark-card rounded-2xl p-12 lg:p-16 text-center shadow-2xl">
        <h2 class="text-4xl lg:text-5xl font-black text-white leading-tight mb-6">
            <?= $lang === 'en'
                ? 'Need Professional Service?'
                : 'تحتاج خدمة احترافية؟' ?>
        </h2>
        <p class="text-lg text-gray-300 max-w-3xl mx-auto leading-relaxed mb-10">
            <?= $lang === 'en'
                ? 'Contact our team now and get fast, professional service with the highest quality for your home or company.'
                : 'تواصل مع فريقنا الآن واحصل على خدمات سريعة واحترافية بأعلى جودة لمنزلك أو شركتك.' ?>
        </p>
        <a href="https://wa.me/<?= $waNumber ?>" target="_blank"
           class="inline-block bg-brand text-white hover:bg-brand-dark transition px-10 py-5 rounded-xl font-black text-lg shadow-xl hover:scale-105 transition-transform">
            <?= $lang === 'en' ? 'Request Service Now' : 'اطلب الخدمة الآن' ?>
        </a>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; ?>

<!-- ═══════ TESTIMONIAL SWITCHER SCRIPT ═══════ -->
<?php if (count($allTestimonials) > 1): ?>
<script>
const testimonials = <?= json_encode(array_map(function($t) use ($lang) {
    return [
        'name' => $lang === 'en' && !empty($t->name_en) ? $t->name_en : ($t->name ?? ''),
        'content' => $lang === 'en' && !empty($t->content_en) ? $t->content_en : ($t->content ?? ''),
        'rating' => $t->rating ?? 5,
    ];
}, $allTestimonials)) ?>;

function switchTestimonial(index) {
    const t = testimonials[index];
    if (!t) return;
    document.getElementById('takproTestimonialText').textContent = t.content;
    document.getElementById('takproTestimonialName').textContent = t.name;
    document.querySelectorAll('.takpro-testimonial-dot').forEach((dot, i) => {
        dot.classList.toggle('bg-brand', i === index);
        dot.classList.toggle('bg-gray-300', i !== index);
    });
}
</script>
<?php endif; ?>

<?php require_once __DIR__ . '/_scripts.php'; ?>

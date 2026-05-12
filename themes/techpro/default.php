<?php
/**
 * Tek Pro Theme — Default (Landing Page)
 * Light bg + Orange #ff7a00 accents + White theme
 * Design matches: cleaning/tech landing with hero, intro, trusted, services, map, team, rates, feedback, news
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
$logoLetter = mb_substr($tenant->site_name ?? 'T', 0, 1);

/* ── Banner / Hero ── */
$heroBanner = (!empty($banners) && isset($banners[0])) ? $banners[0] : null;
$heroTitle  = $heroBanner->title ?? '';
$heroSub    = $heroBanner->subtitle ?? '';
$heroDesc   = $heroBanner->description ?? '';
$heroBtn    = $heroBanner->button_text ?? 'ابدأ الآن';
$heroImg    = $heroBanner->image ?? '';
if ($lang === 'en') {
    $heroTitle = $heroBanner->title_en ?? $heroTitle;
    $heroSub   = $heroBanner->subtitle_en ?? $heroSub;
    $heroDesc  = $heroBanner->description_en ?? $heroDesc;
    $heroBtn   = $heroBanner->button_text_en ?? $heroBtn;
}

/* ── Stats ── */
$stats = [];
if (!empty($siteStats)) {
    foreach ($siteStats as $s) { $stats[] = $s; }
}
if (count($stats) < 3) {
    $stats = [
        (object)['value' => '8K+', 'label' => 'عميل سعيد', 'label_en' => 'Happy Clients'],
        (object)['value' => '10+', 'label' => 'سنوات خبرة', 'label_en' => 'Years Exp.'],
        (object)['value' => '98%', 'label' => 'نسبة الرضا', 'label_en' => 'Satisfaction'],
    ];
}

/* ── Features (Why Us / Trusted) ── */
$features = [];
if (!empty($siteFeatures)) {
    foreach ($siteFeatures as $f) { $features[] = $f; }
}
if (empty($features)) {
    $features = [
        (object)['title' => 'أسعار مناسبة', 'title_en' => 'Affordable Prices', 'description' => 'أسعار تنافسية تناسب الجميع مع الحفاظ على أعلى جودة', 'description_en' => 'Competitive prices for everyone while maintaining the highest quality', 'icon' => 'fas fa-tags'],
        (object)['title' => 'خدمة في نفس اليوم', 'title_en' => 'Same Day Service', 'description' => 'استجابة سريعة وخدمة فورية في نفس يوم الطلب', 'description_en' => 'Fast response and immediate service on the same day', 'icon' => 'fas fa-bolt'],
        (object)['title' => 'مواد آمنة', 'title_en' => 'Safe Materials', 'description' => 'نستخدم مواد آمنة وصديقة للبيئة معتمدة عالمياً', 'description_en' => 'We use globally certified eco-friendly safe materials', 'icon' => 'fas fa-leaf'],
        (object)['title' => 'فريق محترف', 'title_en' => 'Expert Team', 'description' => 'فريق مدرب ومعتمد بخبرة عملية واسعة ومستمرة', 'description_en' => 'Trained and certified team with extensive hands-on experience', 'icon' => 'fas fa-users'],
        (object)['title' => 'نتائج مضمونة', 'title_en' => 'Guaranteed Results', 'description' => 'ضمان كامل على جميع أعمالنا مع متابعة ما بعد الخدمة', 'description_en' => 'Full warranty on all our work with post-service follow-up', 'icon' => 'fas fa-shield-halved'],
    ];
}

/* ── Services ── */
$allServices = [];
if (!empty($services)) {
    foreach ($services as $svc) { $allServices[] = $svc; }
}
if (empty($allServices)) {
    $allServices = [
        (object)['title' => 'الدعم التقني', 'title_en' => 'Tech Support', 'description' => 'دعم فني شامل وحلول تقنية متكاملة', 'description_en' => 'Comprehensive tech support and integrated solutions', 'icon' => 'fas fa-headset', 'image' => '', 'slug' => 'tech-support'],
        (object)['title' => 'حلول الشبكات', 'title_en' => 'Network Solutions', 'description' => 'تصميم وإدارة وصيانة شبكات متقدمة', 'description_en' => 'Design, management and maintenance of advanced networks', 'icon' => 'fas fa-network-wired', 'image' => '', 'slug' => 'network-solutions'],
        (object)['title' => 'صيانة الأنظمة', 'title_en' => 'System Maintenance', 'description' => 'صيانة دورية وتحديثات مستمرة للأنظمة', 'description_en' => 'Regular maintenance and continuous system updates', 'icon' => 'fas fa-tools', 'image' => '', 'slug' => 'system-maintenance'],
        (object)['title' => 'الحماية والأمان', 'title_en' => 'Security', 'description' => 'حلول أمنية متقدمة لحماية بياناتك', 'description_en' => 'Advanced security solutions to protect your data', 'icon' => 'fas fa-shield-halved', 'image' => '', 'slug' => 'security'],
        (object)['title' => 'استشارات تقنية', 'title_en' => 'Tech Consulting', 'description' => 'استشارات متخصصة لتحسين البنية التحتية', 'description_en' => 'Specialized consulting to improve infrastructure', 'icon' => 'fas fa-lightbulb', 'image' => '', 'slug' => 'consulting'],
        (object)['title' => 'التطوير والبرمجة', 'title_en' => 'Development', 'description' => 'تطوير مواقع وتطبيقات بأحدث التقنيات', 'description_en' => 'Website and app development with latest technologies', 'icon' => 'fas fa-code', 'image' => '', 'slug' => 'development'],
    ];
}

/* Service images */
$serviceImages = [
    'https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1585421514284-efb74c2b69ba?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1528744598421-b7b93e12df54?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=900&auto=format&fit=crop',
];

/* ── Testimonials ── */
$allTestimonials = [];
if (!empty($testimonials)) {
    foreach ($testimonials as $t) {
        $t->client_name = $t->client_name ?? $t->name ?? '';
        $t->client_name_display = ($lang === 'en' && !empty($t->client_name_en)) ? $t->client_name_en : $t->client_name;
        $allTestimonials[] = $t;
    }
}
if (empty($allTestimonials)) {
    $allTestimonials = [
        (object)['client_name' => 'أحمد محمد', 'client_name_en' => 'Ahmed Mohammed', 'content' => 'خدمة ممتازة وسريعة، الفريق محترف والنتيجة كانت رائعة. أنصح بالتعامل معهم.', 'content_en' => 'Excellent and fast service, professional team and amazing results. Highly recommended.', 'rating' => 5],
        (object)['client_name' => 'سارة العلي', 'client_name_en' => 'Sara Ali', 'content' => 'تعامل راقي وخدمة عالية الجودة. سأعود بالتأكيد وأطلب المزيد من الخدمات.', 'content_en' => 'Elegant treatment and high-quality service. Will definitely come back for more.', 'rating' => 5],
        (object)['client_name' => 'خالد يوسف', 'client_name_en' => 'Khaled Yousef', 'content' => 'احترافية عالية في العمل والتزام بالمواعيد. أنصح الجميع بالتجربة.', 'content_en' => 'High professionalism and commitment to deadlines. I recommend everyone to try.', 'rating' => 5],
    ];
}

require_once __DIR__ . '/_head.php';
require_once __DIR__ . '/_navbar.php';
?>

<!-- ══════════════════════════════════════════════════════
     HERO SECTION
     ══════════════════════════════════════════════════════ -->
<section class="relative min-h-[690px] bg-[#111]">
    <?php
        $heroImgUrl = !empty($heroImg) ? (function_exists('upload') ? upload($heroImg) : $heroImg) : 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=1800&auto=format&fit=crop';
    ?>
    <img src="<?= htmlspecialchars($heroImgUrl) ?>" class="absolute inset-0 w-full h-full object-cover" alt="hero">
    <div class="absolute inset-0 bg-black/55"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-16 pt-24">
        <div class="max-w-[500px] text-white fade-up">
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-black leading-[1.05] mb-5">
                <?php if ($heroTitle): ?>
                    <?= htmlspecialchars($heroTitle) ?>
                <?php else: ?>
                    <?= $lang === 'en' ? 'Professional<br/>Services<br/>Excellence' : 'خدمات<br/>احترافية<br/>بتميز' ?>
                <?php endif; ?>
            </h2>
            <p class="text-lg text-gray-100 leading-relaxed mb-7">
                <?= $heroDesc ?: ($lang === 'en'
                    ? 'Professional and reliable services for homes and companies with the highest quality and competitive prices.'
                    : 'خدمات احترافية وموثوقة للمنازل والشركات بأعلى جودة وأسعار مناسبة.'
                ) ?>
            </p>
            <a href="<?= url($siteBase . '/booking') ?>"
               class="inline-block bg-white text-[#171717] px-8 py-3 font-black hover:bg-[#ff7a00] hover:text-white transition">
                <?= $heroBtn ?>
            </a>
        </div>
    </div>

    <!-- Floating Phone Bar -->
    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 z-20 w-[360px] max-w-[90%] bg-[#ff7a00] text-white px-8 py-5 flex items-center justify-center gap-4 shadow-2xl">
        <span class="w-12 h-12 bg-white text-[#ff7a00] rounded-full flex items-center justify-center text-xl">&#9742;</span>
        <div>
            <p class="text-xs font-bold opacity-90"><?= $lang === 'en' ? 'Call us now' : 'اتصل بنا الآن' ?></p>
            <h3 class="text-2xl font-black"><?= htmlspecialchars($tenant->contact_phone ?: ($waNumber ?: '+90 555 000 000')) ?></h3>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════
     INTRO SECTION
     ══════════════════════════════════════════════════════ -->
<section class="bg-[#f3f3f3] px-6 lg:px-16 py-20">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-14 items-center">
        <!-- Images Grid -->
        <div class="grid grid-cols-2 gap-4 max-w-[430px] mx-auto lg:mx-0 fade-up">
            <div class="bg-[#171717] text-white p-6 min-h-[120px] flex flex-col justify-center">
                <div class="flex -space-x-3 space-x-reverse mb-3">
                    <?php for ($p = 0; $p < 4; $p++): ?>
                        <span class="w-10 h-10 rounded-full bg-white border-2 border-[#ff7a00] flex items-center justify-center text-sm">&#128100;</span>
                    <?php endfor; ?>
                </div>
                <p class="font-black"><?= htmlspecialchars($stats[0]->value ?? '8K+') ?> <?= $lang === 'en' && !empty($stats[0]->label_en) ? $stats[0]->label_en : ($stats[0]->label ?? '') ?></p>
            </div>
            <img src="https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?q=80&w=700&auto=format&fit=crop" class="w-full h-[210px] object-cover" loading="lazy">
            <img src="https://images.unsplash.com/photo-1585421514284-efb74c2b69ba?q=80&w=700&auto=format&fit=crop" class="w-full h-[210px] object-cover" loading="lazy">
            <div class="bg-[#ff7a00] p-7 flex items-center justify-center text-white text-5xl">&#129528;</div>
        </div>

        <!-- Text -->
        <div class="fade-up" style="transition-delay:.1s">
            <p class="text-[#ff7a00] font-black mb-3"><?= $lang === 'en' ? 'Welcome to' : 'مرحباً بكم في' ?> <?= $siteName ?></p>
            <h2 class="text-4xl lg:text-5xl font-black leading-tight mb-6">
                <?= $lang === 'en' ? 'Professional Services We Deliver with Excellence' : 'خدمات احترافية نقدمها لعملائنا باحترافية' ?>
            </h2>
            <p class="text-gray-600 leading-loose mb-7">
                <?= $lang === 'en'
                    ? 'We deliver integrated solutions for homes, offices, and commercial facilities. Our team is trained, our materials are safe, and our service is fast and available throughout the week.'
                    : 'نقدم حلولاً متكاملة للمنازل والمكاتب والمرافق التجارية. فريقنا مدرب، موادنا آمنة، وخدمتنا سريعة ومتاحة على مدار الأسبوع.'
                ?>
            </p>
            <ul class="space-y-3 font-bold text-[#222] mb-8">
                <?php for ($fi = 0; $fi < min(3, count($features)); $fi++):
                    $feat = $features[$fi];
                    $featTitle = $lang === 'en' && !empty($feat->title_en) ? $feat->title_en : ($feat->title ?? '');
                ?>
                    <li>&#10003; <?= htmlspecialchars($featTitle) ?></li>
                <?php endfor; ?>
            </ul>
            <a href="<?= url($siteBase . '/about') ?>"
               class="inline-block bg-[#171717] text-white px-7 py-3 rounded-full font-black hover:bg-[#ff7a00] transition">
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
        <!-- Text + Badges -->
        <div class="fade-up">
            <h2 class="text-5xl font-black mb-2"><?= $lang === 'en' ? 'Trusted' : 'موثوقون' ?></h2>
            <p class="font-black mb-6"><?= $lang === 'en' ? 'Highly Reliable Service' : 'خدمة باعتمادية عالية' ?></p>
            <div class="space-y-3 max-w-sm">
                <?php foreach ($features as $feat):
                    $featTitle = $lang === 'en' && !empty($feat->title_en) ? $feat->title_en : ($feat->title ?? '');
                ?>
                    <div class="bg-[#ff7a00] text-white px-6 py-3 font-black text-center rounded-sm"><?= htmlspecialchars($featTitle) ?></div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Image -->
        <div class="relative max-w-[430px] mx-auto fade-up" style="transition-delay:.1s">
            <img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=900&auto=format&fit=crop" class="w-full h-[470px] object-cover rounded-lg" loading="lazy">
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="w-16 h-16 rounded-full bg-white text-[#ff7a00] flex items-center justify-center text-2xl shadow-xl cursor-pointer hover:scale-110 transition">&#9654;</span>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════
     SERVICES PANEL SECTION
     ══════════════════════════════════════════════════════ -->
<section id="services" class="bg-[#ff7a00] py-20 px-6 lg:px-16">
    <div class="max-w-4xl mx-auto bg-white rounded-xl p-8 lg:p-10 shadow-2xl text-center fade-up">
        <h2 class="text-4xl font-black leading-tight mb-7">
            <?= $lang === 'en' ? 'Reliable Solutions<br/>With Great Care' : 'حلول موثوقة<br/>بعناية عالية' ?>
        </h2>
        <div class="grid sm:grid-cols-3 gap-4">
            <?php foreach ($allServices as $i => $svc):
                $svcTitle = $lang === 'en' && !empty($svc->title_en) ? $svc->title_en : ($svc->title ?? '');
                $svcImg   = !empty($svc->image) ? (function_exists('upload') ? upload($svc->image) : $svc->image) : ($serviceImages[$i % count($serviceImages)] ?? '');
            ?>
                <a href="<?= url($siteBase . '/service/' . ($svc->slug ?? 'service-' . ($i + 1))) ?>" class="relative rounded-lg overflow-hidden h-28 group block">
                    <?php if ($svcImg): ?>
                        <img src="<?= htmlspecialchars($svcImg) ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" loading="lazy">
                    <?php else: ?>
                        <div class="w-full h-full bg-gray-800 flex items-center justify-center">
                            <i class="<?= htmlspecialchars($svc->icon ?? 'fas fa-star') ?> text-3xl text-white/30"></i>
                        </div>
                    <?php endif; ?>
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
    <h2 class="absolute inset-x-0 top-6 text-center text-[110px] lg:text-[180px] font-black text-black/5 leading-none select-none">
        <?= $lang === 'en' ? 'Service' : 'خدمات' ?>
    </h2>
    <div class="relative max-w-5xl mx-auto flex justify-center pt-20 fade-up">
        <img src="https://images.unsplash.com/photo-1585421514284-efb74c2b69ba?q=80&w=1200&auto=format&fit=crop" class="w-[760px] max-w-full h-[260px] object-cover rounded-t-2xl shadow-2xl" loading="lazy">
    </div>
    <div class="h-10 bg-[#222] mt-0"></div>
</section>

<!-- ══════════════════════════════════════════════════════
     TESTIMONIALS + CLIENT FEEDBACK
     ══════════════════════════════════════════════════════ -->
<section class="px-6 lg:px-16 py-20 bg-white">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-14 items-center mb-24">
        <!-- Avatars -->
        <div class="relative h-[360px] bg-[#f7f7f7] rounded-xl fade-up">
            <?php for ($ai = 0; $ai < 7; $ai++): ?>
                <span class="absolute w-14 h-14 rounded-full bg-white shadow-xl flex items-center justify-center"
                      style="right: <?= 15 + ($ai * 11) % 60 ?>%; top: <?= 20 + ($ai * 17) % 60 ?>%">&#128100;</span>
            <?php endfor; ?>
        </div>

        <!-- Review -->
        <div class="fade-up" style="transition-delay:.1s">
            <h2 class="text-5xl font-black mb-3"><?= $lang === 'en' ? 'Client Reviews' : 'آراء العملاء' ?></h2>
            <p class="font-black mb-6"><?= $lang === 'en' ? 'What Our Clients Say' : 'ماذا يقول عملاؤنا' ?></p>
            <?php if (!empty($allTestimonials)): ?>
                <?php $firstTest = $allTestimonials[0]; ?>
                <?php
                    $testContent = $lang === 'en' && !empty($firstTest->content_en) ? $firstTest->content_en : ($firstTest->content ?? '');
                    $testName    = $firstTest->client_name_display ?? ($firstTest->client_name ?? ($firstTest->name ?? ''));
                ?>
                <div class="bg-[#f5f5f5] p-8 max-w-md">
                    <p class="text-gray-600 leading-loose mb-6"><?= htmlspecialchars($testContent) ?></p>
                    <div class="flex items-center gap-3">
                        <span class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm">&#128100;</span>
                        <b><?= htmlspecialchars($testName) ?></b>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ═══════ BLOG / NEWS SECTION ═══════ -->
    <div class="text-center mb-10 fade-up">
        <h2 class="text-5xl font-black"><?= $lang === 'en' ? 'Latest Articles' : 'آخر المقالات' ?></h2>
        <p class="font-black"><?= $lang === 'en' ? 'News & Updates' : 'أخبار ومقالات تقنية' ?></p>
    </div>
    <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-8 fade-up">
        <?php for ($ni = 0; $ni < 2; $ni++): ?>
            <div class="bg-white shadow-xl tekpro-card">
                <img src="<?= $ni === 0
                    ? 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=900&auto=format&fit=crop'
                    : 'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?q=80&w=900&auto=format&fit=crop'
                ?>" class="w-full h-64 object-cover" loading="lazy">
                <div class="p-7 text-right border-r-4 border-[#ff7a00]">
                    <p class="text-[#ff7a00] text-sm font-black mb-2"><?= $lang === 'en' ? 'June 2026' : 'يونيو 2026' ?></p>
                    <h3 class="text-2xl font-black mb-3">
                        <?= $lang === 'en' ? 'Tips for Maintaining Your Home' : 'نصائح للحفاظ على نظافة المنزل' ?>
                    </h3>
                    <p class="text-gray-500 leading-loose">
                        <?= $lang === 'en'
                            ? 'Simple steps to help you maintain a clean and healthy place all the time.'
                            : 'خطوات بسيطة تساعدك على الحفاظ على مكان صحي ونظيف طوال الوقت.'
                        ?>
                    </p>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

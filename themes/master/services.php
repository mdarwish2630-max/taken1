<?php
/**
 * Master Theme — Services Page
 * Service cards grid with image, icon, title, description, price, and booking button
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';
$whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
$waNumber = preg_replace('/[^0-9+]/', '', $whatsapp);

// Page title
$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'Our Services' : 'خدماتنا'));
$pageContent = $lang === 'en' && !empty($page->content_en) ? $page->content_en : ($page->content ?? '');

// Fallback images
$serviceImages = [
    'https://images.unsplash.com/photo-1621905252507-b35492cc74b4?q=80&w=600&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1585704032915-c3400ca199e7?q=80&w=600&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1621905251918-48416bd8575a?q=80&w=600&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=600&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?q=80&w=600&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=600&auto=format&fit=crop',
];

// ── Fallback services (always show content even if DB is empty) ──
if (empty($services)) {
    $services = [
        (object)['id' => 0, 'slug' => 'service-1',
            'title' => 'صيانة الكهرباء', 'title_en' => 'Electrical Services',
            'description' => 'تمديدات كهربائية، صيانة، تركيب وفحص كامل للمنازل والمكاتب. فريق معتمد بخبرة تتجاوز 10 سنوات في جميع أنواع الأعمال الكهربائية.',
            'description_en' => 'Electrical wiring, maintenance, installation and full inspection for homes and offices. Certified team with 10+ years of experience.',
            'icon' => 'fas fa-bolt', 'image' => '', 'price' => '150 ₺', 'price_text' => '150 ₺', 'show_on_home' => 1, 'status' => 'active'],
        (object)['id' => 0, 'slug' => 'service-2',
            'title' => 'خدمات السباكة', 'title_en' => 'Plumbing Services',
            'description' => 'إصلاح التسريبات وصيانة وتركيب الأنابيب بأحدث التقنيات. نقدم خدمات طوارئ على مدار الساعة مع ضمان على جميع أعمالنا.',
            'description_en' => 'Leak repair, pipe maintenance and installation with latest technology. 24/7 emergency service with warranty on all work.',
            'icon' => 'fas fa-faucet-drip', 'image' => '', 'price' => '100 ₺', 'price_text' => '100 ₺', 'show_on_home' => 1, 'status' => 'active'],
        (object)['id' => 0, 'slug' => 'service-3',
            'title' => 'التكييف والتبريد', 'title_en' => 'AC & Cooling',
            'description' => 'صيانة التكييف وحلول تبريد ذكية. تشمل الخدمة التنظيف، تعبئة الغاز، فحص الضغط، وتركيب الأجهزة الجديدة.',
            'description_en' => 'AC maintenance and smart cooling solutions. Services include cleaning, gas refill, pressure testing, and new unit installation.',
            'icon' => 'fas fa-snowflake', 'image' => '', 'price' => '200 ₺', 'price_text' => '200 ₺', 'show_on_home' => 1, 'status' => 'active'],
        (object)['id' => 0, 'slug' => 'service-4',
            'title' => 'إصلاح المنازل', 'title_en' => 'Home Repair',
            'description' => 'خدمات احترافية لمعالجة جميع أعطال المنزل من دهان ونجارة وبلاط وأعمال سباكة خفيفة. فريق شامل تحت سقف واحد.',
            'description_en' => 'Professional services for all home repairs including painting, carpentry, tiling, and light plumbing. Complete team under one roof.',
            'icon' => 'fas fa-house-chimney', 'image' => '', 'price' => '80 ₺', 'price_text' => '80 ₺', 'show_on_home' => 1, 'status' => 'active'],
        (object)['id' => 0, 'slug' => 'service-5',
            'title' => 'الدهانات والديكور', 'title_en' => 'Painting & Decor',
            'description' => 'دهانات داخلية وخارجية بأفضل أنواع الطلاء. تشمل الخدمة التحضير والتنظيف والتشطيب مع ضمان نظافة المكان.',
            'description_en' => 'Interior and exterior painting with premium materials. Includes surface preparation, cleaning, and finishing with site cleanliness guarantee.',
            'icon' => 'fas fa-paint-roller', 'image' => '', 'price' => '120 ₺', 'price_text' => '120 ₺', 'show_on_home' => 1, 'status' => 'active'],
        (object)['id' => 0, 'slug' => 'service-6',
            'title' => 'أقفال وأبواب', 'title_en' => 'Locks & Doors',
            'description' => 'تركيب وإصلاح الأقفال والأبواب بكل أنواعها. نتعامل مع جميع الماركات العالمية ونوفر قطع الغيار الأصلية.',
            'description_en' => 'Installation and repair of all lock and door types. We work with all major brands and provide genuine spare parts.',
            'icon' => 'fas fa-lock', 'image' => '', 'price' => '90 ₺', 'price_text' => '90 ₺', 'show_on_home' => 1, 'status' => 'active'],
    ];
}

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
            <i class="fas fa-concierge-bell text-xs"></i>
            <span><?= $lang === 'en' ? 'Our Services' : 'خدماتنا' ?></span>
        </div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight mb-6">
            <?= htmlspecialchars($pageTitle) ?>
        </h1>
        <?php if (!empty($pageContent)): ?>
            <p class="text-gray-300 text-lg leading-relaxed max-w-3xl"><?= sanitizeHTML($pageContent) ?></p>
        <?php else: ?>
            <p class="text-gray-300 text-lg leading-relaxed max-w-3xl">
                <?= $lang === 'en'
                    ? 'Discover our wide range of professional services designed to meet your needs with the highest quality standards.'
                    : 'اكتشف مجموعتنا الواسعة من الخدمات الاحترافية المصممة لتلبية احتياجاتك بأعلى معايير الجودة.' ?>
            </p>
        <?php endif; ?>
        <div class="w-24 h-1.5 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full mt-6"></div>
    </div>
</section>

<!-- ═══════ SERVICES GRID ═══════ -->
<section class="relative z-10 px-6 lg:px-20 py-16">
    <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-8">
        <?php foreach ($services as $i => $svc):
                $svcTitle = $lang === 'en' && !empty($svc->title_en) ? $svc->title_en : ($svc->title ?? '');
                $svcDesc  = $lang === 'en' && !empty($svc->description_en) ? $svc->description_en : ($svc->description ?? '');
                $svcImg   = !empty($svc->image) ? function_exists('upload') ? upload($svc->image) : $svc->image : ($serviceImages[$i % count($serviceImages)] ?? '');
                $svcIcon  = $svc->icon ?? 'fas fa-star';
                $svcPrice = !empty($svc->price) ? $svc->price : '';
            ?>
                <div class="service-card group bg-[#111827] border border-white/10 rounded-[30px] overflow-hidden glow-border hover:-translate-y-2 transition-all duration-300 shadow-xl fade-up">
                    <!-- Image Area -->
                    <div class="relative h-56 overflow-hidden">
                        <?php if ($svcImg): ?>
                            <img src="<?= htmlspecialchars($svcImg) ?>" alt="<?= htmlspecialchars($svcTitle) ?>"
                                 class="service-img w-full h-full object-cover transition-transform duration-700" loading="lazy">
                        <?php else: ?>
                            <div class="w-full h-full bg-gradient-to-br from-cyan-900/40 to-blue-900/40 flex items-center justify-center">
                                <i class="<?= htmlspecialchars($svcIcon) ?> text-6xl text-cyan-400/30"></i>
                            </div>
                        <?php endif; ?>
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-[#111827] via-black/20 to-transparent"></div>
                        <!-- Icon Badge -->
                        <div class="absolute top-5 <?= $isRtl ? 'right-5' : 'left-5' ?> w-14 h-14 rounded-2xl bg-cyan-500/20 backdrop-blur-md border border-cyan-400/20 flex items-center justify-center text-2xl shadow-lg shadow-cyan-500/20">
                            <i class="<?= htmlspecialchars($svcIcon) ?> text-cyan-400"></i>
                        </div>
                        <?php if (!empty($svcPrice)): ?>
                            <div class="absolute top-5 <?= $isRtl ? 'left-5' : 'right-5' ?> glass rounded-xl px-4 py-2 font-bold text-cyan-300 text-sm">
                                <?= htmlspecialchars($svcPrice) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Content -->
                    <div class="p-7">
                        <h3 class="text-xl font-bold mb-3 group-hover:text-cyan-400 transition"><?= htmlspecialchars($svcTitle) ?></h3>
                        <p class="text-gray-400 leading-relaxed mb-6 text-sm line-clamp-3"><?= htmlspecialchars($svcDesc) ?></p>

                        <!-- Actions -->
                        <div class="flex gap-3">
                            <a href="<?= url($siteBase . '/service/' . ($svc->slug ?? 'service-' . ($i + 1))) ?>"
                               class="flex-1 text-center glass hover:border-cyan-400/40 hover:text-cyan-400 transition rounded-xl py-3 font-bold text-sm">
                                <i class="fas fa-arrow-left <?= $isRtl ? '' : 'rotate-180' ?> <?= $isRtl ? 'ms-2' : 'mr-2' ?>"></i>
                                <?= $lang === 'en' ? 'Details' : 'التفاصيل' ?>
                            </a>
                            <a href="<?= url($siteBase . '/booking') ?>"
                               class="flex-1 text-center bg-cyan-500 hover:bg-cyan-400 transition rounded-xl py-3 font-bold text-sm shadow-lg shadow-cyan-500/30">
                                <i class="fas fa-calendar-check <?= $isRtl ? 'ms-2' : 'mr-2' ?>"></i>
                                <?= $lang === 'en' ? 'Book Now' : 'احجز الآن' ?>
                            </a>
                            <a href="https://wa.me/<?= $waNumber ?>?text=<?= urlencode($svcTitle) ?>" target="_blank"
                               class="w-12 h-12 flex items-center justify-center glass rounded-xl hover:border-green-400/40 hover:text-green-400 transition flex-shrink-0">
                                <i class="fab fa-whatsapp text-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ═══════ CTA SECTION ═══════ -->
<section class="relative z-10 px-6 lg:px-20 py-20 fade-up">
    <div class="bg-gradient-to-r from-cyan-500 to-blue-700 rounded-[40px] p-10 lg:p-16 text-center shadow-2xl shadow-cyan-500/20 relative overflow-hidden">
        <div class="absolute -top-20 -right-20 w-60 h-60 bg-white/10 rounded-full blur-[60px]"></div>
        <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-white/10 rounded-full blur-[60px]"></div>

        <h2 class="relative text-3xl sm:text-4xl font-black leading-tight mb-6">
            <?= $lang === 'en' ? 'Need a Custom Service?' : 'تحتاج خدمة مخصصة؟' ?>
        </h2>
        <p class="relative text-lg opacity-90 max-w-2xl mx-auto leading-relaxed mb-10">
            <?= $lang === 'en'
                ? 'Contact us and we will tailor a solution that perfectly fits your requirements.'
                : 'تواصل معنا وسنصمم لك حلاً يتناسب تماماً مع متطلباتك.' ?>
        </p>
        <div class="relative flex flex-wrap justify-center gap-4">
            <a href="https://wa.me/<?= $waNumber ?>" target="_blank"
               class="inline-flex items-center gap-2 bg-white text-[#0f172a] hover:scale-105 transition px-8 py-4 rounded-2xl font-black text-base shadow-xl">
                <i class="fab fa-whatsapp text-lg"></i>
                <?= $lang === 'en' ? 'Request Service' : 'اطلب الخدمة الآن' ?>
            </a>
            <a href="<?= url($siteBase . '/booking') ?>"
               class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 transition px-8 py-4 rounded-2xl font-bold text-base border border-white/20">
                <i class="fas fa-calendar-check"></i>
                <?= $lang === 'en' ? 'Book Appointment' : 'احجز موعد' ?>
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

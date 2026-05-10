<?php
/**
 * Master Theme — Single Service Detail Page
 * Shows full service info with booking CTA and related services
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';
$whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
$waNumber = preg_replace('/[^0-9+]/', '', $whatsapp);
$waUrl    = $waNumber ? 'https://wa.me/' . $waNumber : '#';

// Service data
$svc = $service ?? null;

// Fallback if no service passed
if (!$svc || empty($svc->title)) {
    $svc = (object)[
        'id' => 0,
        'title' => 'صيانة احترافية', 'title_en' => 'Professional Service',
        'description' => 'نقدم خدمات صيانة احترافية متكاملة بأحدث التقنيات وأعلى معايير الجودة. فريقنا المتخصص جاهز لخدمتكم على مدار الساعة.',
        'description_en' => 'We provide comprehensive professional maintenance services with the latest technology and highest quality standards. Our specialized team is ready to serve you 24/7.',
        'icon' => 'fas fa-tools',
        'image' => '',
        'price' => '', 'price_text' => '',
        'slug' => 'service-detail',
    ];
}

$svcTitle = $lang === 'en' && !empty($svc->title_en) ? $svc->title_en : ($svc->title ?? '');
$svcDesc  = $lang === 'en' && !empty($svc->description_en) ? $svc->description_en : ($svc->description ?? '');
$svcIcon  = $svc->icon ?? 'fas fa-tools';
$svcImg   = !empty($svc->image) ? (function_exists('upload') ? upload($svc->image) : $svc->image) : '';
$svcPrice = !empty($svc->price) ? $svc->price : '';

// Features for this service
$svcFeatures = $lang === 'en' ? [
    'Certified & experienced technicians',
    'Fast response and flexible scheduling',
    'Free initial inspection and estimate',
    '6-month warranty on all work',
    'Transparent pricing with no hidden fees',
    '24/7 emergency support available',
] : [
    'فنيون معتمدون وذوو خبرة',
    'استجابة سريعة وجدولة مرنة',
    'فحص وتقدير مجاني في البداية',
    'ضمان 6 أشهر على جميع الأعمال',
    'تسعير شفاف بدون رسوم مخفية',
    'دعم طوارئ متاح على مدار الساعة',
];

// Steps
$steps = $lang === 'en' ? [
    (object)['num' => '01', 'title' => 'Book Your Service', 'desc' => 'Choose a service and book an appointment at your preferred time.'],
    (object)['num' => '02', 'title' => 'Inspection', 'desc' => 'Our certified technician arrives on time and inspects the issue.'],
    (object)['num' => '03', 'title' => 'Professional Work', 'desc' => 'We complete the work with high quality and clean up after finishing.'],
    (object)['num' => '04', 'title' => 'Warranty & Follow-up', 'desc' => 'Enjoy your warranty and our team follows up to ensure satisfaction.'],
] : [
    (object)['num' => '01', 'title' => 'احجز الخدمة', 'desc' => 'اختر الخدمة واحجز موعدك في الوقت المناسب لك.'],
    (object)['num' => '02', 'title' => 'الفحص', 'desc' => 'يصل فنيّنا المعتمد في الوقت المحدد ويقوم بفحص المشكلة.'],
    (object)['num' => '03', 'title' => 'العمل الاحترافي', 'desc' => 'ننتهي من العمل بأعلى جودة مع تنظيف المكان بعد الانتهاء.'],
    (object)['num' => '04', 'title' => 'الضمان والمتابعة', 'desc' => 'استمتع بضمان الخدمة ويتابع فريقنا لضمان رضاكم التام.'],
];

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
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-sm text-gray-400 mb-6">
            <a href="<?= url($siteBase) ?>" class="hover:text-cyan-400 transition"><?= $lang === 'en' ? 'Home' : 'الرئيسية' ?></a>
            <i class="fas fa-chevron-left text-[10px] <?= $lang === 'en' ? 'rotate-180' : '' ?>"></i>
            <a href="<?= url($siteBase . '/services') ?>" class="hover:text-cyan-400 transition"><?= $lang === 'en' ? 'Services' : 'خدماتنا' ?></a>
            <i class="fas fa-chevron-left text-[10px] <?= $lang === 'en' ? 'rotate-180' : '' ?>"></i>
            <span class="text-cyan-400"><?= htmlspecialchars($svcTitle) ?></span>
        </div>

        <div class="flex items-center gap-4 mb-6">
            <div class="w-16 h-16 rounded-2xl bg-cyan-500/20 border border-cyan-400/20 flex items-center justify-center text-3xl shadow-lg shadow-cyan-500/20">
                <i class="<?= htmlspecialchars($svcIcon) ?> text-cyan-400"></i>
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight">
                <?= htmlspecialchars($svcTitle) ?>
            </h1>
        </div>
        <div class="w-24 h-1.5 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full"></div>
    </div>
</section>

<!-- ═══════ SERVICE DETAIL ═══════ -->
<section class="relative z-10 px-6 lg:px-20 py-12">
    <div class="grid lg:grid-cols-3 gap-10">

        <!-- Main Content (2/3) -->
        <div class="lg:col-span-2 space-y-10">

            <!-- Hero Image -->
            <?php if ($svcImg): ?>
                <div class="rounded-[30px] overflow-hidden shadow-2xl fade-up">
                    <img src="<?= htmlspecialchars($svcImg) ?>" alt="<?= htmlspecialchars($svcTitle) ?>"
                         class="w-full h-72 sm:h-96 object-cover">
                </div>
            <?php else: ?>
                <div class="rounded-[30px] overflow-hidden shadow-2xl fade-up h-72 sm:h-96 bg-gradient-to-br from-cyan-900/40 to-blue-900/40 flex items-center justify-center">
                    <i class="<?= htmlspecialchars($svcIcon) ?> text-8xl text-cyan-400/20"></i>
                </div>
            <?php endif; ?>

            <!-- Description -->
            <div class="fade-up" style="transition-delay:.1s">
                <h2 class="text-2xl font-bold mb-6">
                    <?= $lang === 'en' ? 'About This Service' : 'عن هذه الخدمة' ?>
                </h2>
                <div class="text-gray-300 text-lg leading-relaxed space-y-4">
                    <p><?= htmlspecialchars($svcDesc) ?></p>
                </div>
            </div>

            <!-- Features List -->
            <div class="fade-up" style="transition-delay:.15s">
                <h2 class="text-2xl font-bold mb-6">
                    <?= $lang === 'en' ? 'What You Get' : 'ما تحصل عليه' ?>
                </h2>
                <div class="grid sm:grid-cols-2 gap-4">
                    <?php foreach ($svcFeatures as $i => $feat): ?>
                        <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-2xl p-4 hover:border-cyan-400/30 transition">
                            <div class="w-9 h-9 min-w-[36px] rounded-xl bg-cyan-500 flex items-center justify-center text-black font-black text-sm flex-shrink-0">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="text-gray-300 text-sm"><?= htmlspecialchars($feat) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- How It Works -->
            <div class="fade-up" style="transition-delay:.2s">
                <h2 class="text-2xl font-bold mb-6">
                    <?= $lang === 'en' ? 'How It Works' : 'كيف تعمل الخدمة' ?>
                </h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php foreach ($steps as $i => $step): ?>
                        <div class="relative glass rounded-2xl p-6 glow-border hover:-translate-y-1 transition-all duration-300">
                            <span class="text-4xl font-black text-cyan-500/30"><?= $step->num ?></span>
                            <h3 class="text-lg font-bold mt-2 mb-2"><?= htmlspecialchars($step->title) ?></h3>
                            <p class="text-gray-400 text-sm leading-relaxed"><?= htmlspecialchars($step->desc) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar (1/3) -->
        <div class="space-y-6">

            <!-- Price Card -->
            <?php if ($svcPrice): ?>
                <div class="glass-strong rounded-[30px] p-8 text-center fade-up sticky top-28">
                    <p class="text-gray-400 text-sm mb-2"><?= $lang === 'en' ? 'Starting from' : 'يبدأ من' ?></p>
                    <h3 class="text-4xl font-black text-cyan-400 mb-6"><?= htmlspecialchars($svcPrice) ?></h3>

                    <a href="<?= url($siteBase . '/booking') ?>"
                       class="w-full flex items-center justify-center gap-2 bg-cyan-500 hover:bg-cyan-400 transition rounded-2xl py-4 font-bold text-lg shadow-lg shadow-cyan-500/30 mb-3">
                        <i class="fas fa-calendar-check"></i>
                        <?= $lang === 'en' ? 'Book Now' : 'احجز الآن' ?>
                    </a>
                    <a href="<?= $waUrl ?>?text=<?= urlencode($svcTitle) ?>" target="_blank"
                       class="w-full flex items-center justify-center gap-2 bg-[#25D366] hover:bg-[#20bd5a] transition rounded-2xl py-4 font-bold text-lg shadow-lg shadow-green-500/30 text-white">
                        <i class="fab fa-whatsapp text-xl"></i>
                        WhatsApp
                    </a>
                </div>
            <?php else: ?>
                <div class="glass-strong rounded-[30px] p-8 text-center fade-up sticky top-28">
                    <a href="<?= url($siteBase . '/booking') ?>"
                       class="w-full flex items-center justify-center gap-2 bg-cyan-500 hover:bg-cyan-400 transition rounded-2xl py-4 font-bold text-lg shadow-lg shadow-cyan-500/30 mb-3">
                        <i class="fas fa-calendar-check"></i>
                        <?= $lang === 'en' ? 'Book Now' : 'احجز الآن' ?>
                    </a>
                    <a href="<?= $waUrl ?>?text=<?= urlencode($svcTitle) ?>" target="_blank"
                       class="w-full flex items-center justify-center gap-2 bg-[#25D366] hover:bg-[#20bd5a] transition rounded-2xl py-4 font-bold text-lg shadow-lg shadow-green-500/30 text-white">
                        <i class="fab fa-whatsapp text-xl"></i>
                        WhatsApp
                    </a>
                </div>
            <?php endif; ?>

            <!-- Quick Contact -->
            <div class="glass rounded-2xl p-6 fade-up" style="transition-delay:.1s">
                <h3 class="font-bold mb-4 flex items-center gap-2">
                    <i class="fas fa-phone-volume text-cyan-400"></i>
                    <?= $lang === 'en' ? 'Quick Contact' : 'تواصل سريع' ?>
                </h3>
                <?php if (!empty($tenant->contact_phone)): ?>
                    <div class="flex items-center gap-3 mb-3">
                        <i class="fas fa-phone text-cyan-400 text-sm"></i>
                        <a href="tel:<?= htmlspecialchars($tenant->contact_phone) ?>" class="text-gray-300 hover:text-cyan-400 transition" dir="ltr"><?= htmlspecialchars($tenant->contact_phone) ?></a>
                    </div>
                <?php endif; ?>
                <?php if (!empty($tenant->contact_email)): ?>
                    <div class="flex items-center gap-3 mb-3">
                        <i class="fas fa-envelope text-blue-400 text-sm"></i>
                        <a href="mailto:<?= htmlspecialchars($tenant->contact_email) ?>" class="text-gray-300 hover:text-cyan-400 transition text-sm break-all" dir="ltr"><?= htmlspecialchars($tenant->contact_email) ?></a>
                    </div>
                <?php endif; ?>
                <?php if (!empty($tenant->working_hours)): ?>
                    <div class="flex items-start gap-3 pt-3 border-t border-white/10">
                        <i class="fas fa-clock text-amber-400 text-sm mt-1"></i>
                        <p class="text-gray-400 text-sm whitespace-pre-line"><?= htmlspecialchars($tenant->working_hours) ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Warranty Badge -->
            <div class="glass rounded-2xl p-6 fade-up" style="transition-delay:.15s">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-cyan-500/20 border border-cyan-400/20 flex items-center justify-center text-2xl flex-shrink-0">
                        <i class="fas fa-shield-halved text-cyan-400"></i>
                    </div>
                    <div>
                        <h4 class="font-bold"><?= $lang === 'en' ? 'Service Warranty' : 'ضمان الخدمة' ?></h4>
                        <p class="text-gray-400 text-sm"><?= $lang === 'en' ? 'Up to 6 months warranty on all work' : 'ضمان يصل إلى 6 أشهر على جميع الأعمال' ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════ CTA SECTION ═══════ -->
<section class="relative z-10 px-6 lg:px-20 py-20 fade-up">
    <div class="bg-gradient-to-r from-cyan-500 to-blue-700 rounded-[40px] p-10 lg:p-16 text-center shadow-2xl shadow-cyan-500/20 relative overflow-hidden">
        <div class="absolute -top-20 -right-20 w-60 h-60 bg-white/10 rounded-full blur-[60px]"></div>
        <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-white/10 rounded-full blur-[60px]"></div>

        <h2 class="relative text-3xl sm:text-4xl font-black leading-tight mb-6">
            <?= $lang === 'en' ? 'Need a Different Service?' : 'تحتاج خدمة أخرى؟' ?>
        </h2>
        <p class="relative text-lg opacity-90 max-w-2xl mx-auto leading-relaxed mb-10">
            <?= $lang === 'en'
                ? 'Browse all our services or contact us for a custom solution tailored to your needs.'
                : 'تصفح جميع خدماتنا أو تواصل معنا لحل مخصص يتناسب مع احتياجاتك.' ?>
        </p>
        <div class="relative flex flex-wrap justify-center gap-4">
            <a href="<?= url($siteBase . '/services') ?>"
               class="inline-flex items-center gap-2 bg-white text-[#0f172a] hover:scale-105 transition px-8 py-4 rounded-2xl font-black text-base shadow-xl">
                <i class="fas fa-th-large"></i>
                <?= $lang === 'en' ? 'All Services' : 'جميع الخدمات' ?>
            </a>
            <a href="https://wa.me/<?= $waNumber ?>" target="_blank"
               class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 transition px-8 py-4 rounded-2xl font-bold text-base border border-white/20">
                <i class="fab fa-whatsapp text-lg"></i>
                <?= $lang === 'en' ? 'Contact Us' : 'تواصل معنا' ?>
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

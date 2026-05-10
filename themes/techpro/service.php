<?php
/**
 * Tek Pro Theme — Single Service Detail Page
 * Light theme + Orange accents
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';
$whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
$waNumber = preg_replace('/[^0-9+]/', '', $whatsapp);
$waUrl    = $waNumber ? 'https://wa.me/' . $waNumber : '#';

$svc = $service ?? null;
if (!$svc || empty($svc->title)) {
    $svc = (object)[
        'id' => 0, 'title' => 'خدمة احترافية', 'title_en' => 'Professional Service',
        'description' => 'نقدم خدمات احترافية متكاملة بأحدث التقنيات وأعلى معايير الجودة. فريقنا المتخصص جاهز لخدمتكم على مدار الساعة.',
        'description_en' => 'We provide comprehensive professional services with the latest technology and highest quality standards. Our team is ready to serve you 24/7.',
        'icon' => 'fas fa-tools', 'image' => '', 'price' => '', 'price_text' => '', 'slug' => 'service-detail',
    ];
}

$svcTitle = $lang === 'en' && !empty($svc->title_en) ? $svc->title_en : ($svc->title ?? '');
$svcDesc  = $lang === 'en' && !empty($svc->description_en) ? $svc->description_en : ($svc->description ?? '');
$svcIcon  = $svc->icon ?? 'fas fa-tools';
$svcImg   = !empty($svc->image) ? (function_exists('upload') ? upload($svc->image) : $svc->image) : '';
$svcPrice = !empty($svc->price) ? $svc->price : '';

$svcFeatures = $lang === 'en' ? [
    'Certified & experienced technicians', 'Fast response and flexible scheduling',
    'Free initial inspection', 'Warranty on all work', 'Transparent pricing',
    '24/7 emergency support',
] : [
    'فنيون معتمدون وذوو خبرة', 'استجابة سريعة وجدولة مرنة',
    'فحص مجاني في البداية', 'ضمان على جميع الأعمال', 'تسعير شفاف بدون رسوم مخفية',
    'دعم طوارئ على مدار الساعة',
];

$steps = $lang === 'en' ? [
    (object)['num' => '01', 'title' => 'Book', 'desc' => 'Choose a service and book your appointment.'],
    (object)['num' => '02', 'title' => 'Inspection', 'desc' => 'Our technician arrives and inspects the issue.'],
    (object)['num' => '03', 'title' => 'Work', 'desc' => 'Professional work with high quality standards.'],
    (object)['num' => '04', 'title' => 'Warranty', 'desc' => 'Enjoy your warranty and our follow-up.'],
] : [
    (object)['num' => '01', 'title' => 'احجز', 'desc' => 'اختر الخدمة واحجز موعدك في الوقت المناسب.'],
    (object)['num' => '02', 'title' => 'الفحص', 'desc' => 'يصل فنيّنا المعتمد ويقوم بفحص المشكلة.'],
    (object)['num' => '03', 'title' => 'العمل', 'desc' => 'ننتهي من العمل بأعلى جودة ومعايير احترافية.'],
    (object)['num' => '04', 'title' => 'الضمان', 'desc' => 'استمتع بضمان الخدمة ومتابعة فريقنا لكم.'],
];

require_once __DIR__ . '/_head.php';
require_once __DIR__ . '/_navbar.php';
?>

<!-- ═══════ BREADCRUMB ═══════ -->
<section class="bg-[#f3f3f3] px-6 lg:px-16 py-8">
    <div class="max-w-7xl mx-auto flex items-center gap-2 text-sm text-gray-500 fade-up">
        <a href="<?= url($siteBase) ?>" class="hover:text-[#ff7a00] transition"><?= $lang === 'en' ? 'Home' : 'الرئيسية' ?></a>
        <i class="fas fa-chevron-left text-[10px] <?= $lang === 'en' ? 'rotate-180' : '' ?>"></i>
        <a href="<?= url($siteBase . '/services') ?>" class="hover:text-[#ff7a00] transition"><?= $lang === 'en' ? 'Services' : 'خدماتنا' ?></a>
        <i class="fas fa-chevron-left text-[10px] <?= $lang === 'en' ? 'rotate-180' : '' ?>"></i>
        <span class="text-[#ff7a00] font-bold"><?= htmlspecialchars($svcTitle) ?></span>
    </div>
</section>

<!-- ═══════ SERVICE DETAIL ═══════ -->
<section class="px-6 lg:px-16 py-12">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-3 gap-10">

        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-10">
            <!-- Header -->
            <div class="flex items-center gap-4 fade-up">
                <div class="w-16 h-16 rounded-lg bg-[#ff7a00] flex items-center justify-center text-2xl text-white shadow-lg">
                    <i class="<?= htmlspecialchars($svcIcon) ?>"></i>
                </div>
                <h1 class="text-4xl sm:text-5xl font-black leading-tight"><?= htmlspecialchars($svcTitle) ?></h1>
            </div>

            <!-- Image -->
            <?php if ($svcImg): ?>
                <div class="rounded-lg overflow-hidden shadow-2xl fade-up">
                    <img src="<?= htmlspecialchars($svcImg) ?>" alt="<?= htmlspecialchars($svcTitle) ?>" class="w-full h-72 sm:h-96 object-cover">
                </div>
            <?php endif; ?>

            <!-- Description -->
            <div class="fade-up" style="transition-delay:.1s">
                <h2 class="text-2xl font-black mb-4"><?= $lang === 'en' ? 'About This Service' : 'عن هذه الخدمة' ?></h2>
                <p class="text-gray-600 text-lg leading-loose"><?= htmlspecialchars($svcDesc) ?></p>
            </div>

            <!-- Features -->
            <div class="fade-up" style="transition-delay:.15s">
                <h2 class="text-2xl font-black mb-6"><?= $lang === 'en' ? 'What You Get' : 'ما تحصل عليه' ?></h2>
                <div class="grid sm:grid-cols-2 gap-4">
                    <?php foreach ($svcFeatures as $feat): ?>
                        <div class="flex items-center gap-3 bg-[#f5f5f5] rounded-lg p-4 hover:bg-[#ff7a00]/10 transition">
                            <div class="w-9 h-9 min-w-[36px] rounded-lg bg-[#ff7a00] flex items-center justify-center text-white font-black text-sm">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="text-gray-700 text-sm font-semibold"><?= htmlspecialchars($feat) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- How It Works -->
            <div class="fade-up" style="transition-delay:.2s">
                <h2 class="text-2xl font-black mb-6"><?= $lang === 'en' ? 'How It Works' : 'كيف تعمل الخدمة' ?></h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php foreach ($steps as $step): ?>
                        <div class="bg-[#f5f5f5] rounded-lg p-6 hover-glow transition-all duration-300 text-center">
                            <span class="text-4xl font-black text-[#ff7a00]/30"><?= $step->num ?></span>
                            <h3 class="text-lg font-black mt-2 mb-2"><?= htmlspecialchars($step->title) ?></h3>
                            <p class="text-gray-500 text-sm"><?= htmlspecialchars($step->desc) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Price Card -->
            <div class="bg-white shadow-xl rounded-lg p-8 text-center fade-up sticky top-28">
                <?php if ($svcPrice): ?>
                    <p class="text-gray-500 text-sm mb-2"><?= $lang === 'en' ? 'Starting from' : 'يبدأ من' ?></p>
                    <h3 class="text-4xl font-black text-[#ff7a00] mb-6"><?= htmlspecialchars($svcPrice) ?></h3>
                <?php endif; ?>
                <a href="<?= url($siteBase . '/booking') ?>"
                   class="w-full flex items-center justify-center gap-2 bg-[#ff7a00] hover:bg-[#e86e00] transition rounded-lg py-4 font-black text-lg text-white mb-3">
                    <i class="fas fa-calendar-check"></i> <?= $lang === 'en' ? 'Book Now' : 'احجز الآن' ?>
                </a>
                <a href="<?= $waUrl ?>?text=<?= urlencode($svcTitle) ?>" target="_blank"
                   class="w-full flex items-center justify-center gap-2 bg-[#25D366] hover:bg-[#20bd5a] transition rounded-lg py-4 font-black text-lg text-white">
                    <i class="fab fa-whatsapp text-xl"></i> WhatsApp
                </a>
            </div>

            <!-- Quick Contact -->
            <div class="bg-[#f5f5f5] rounded-lg p-6 fade-up" style="transition-delay:.1s">
                <h3 class="font-black mb-4 flex items-center gap-2">
                    <i class="fas fa-phone-volume text-[#ff7a00]"></i>
                    <?= $lang === 'en' ? 'Quick Contact' : 'تواصل سريع' ?>
                </h3>
                <?php if (!empty($tenant->contact_phone)): ?>
                    <div class="flex items-center gap-3 mb-3">
                        <i class="fas fa-phone text-[#ff7a00] text-sm"></i>
                        <a href="tel:<?= htmlspecialchars($tenant->contact_phone) ?>" class="text-gray-700 hover:text-[#ff7a00] transition" dir="ltr"><?= htmlspecialchars($tenant->contact_phone) ?></a>
                    </div>
                <?php endif; ?>
                <?php if (!empty($tenant->contact_email)): ?>
                    <div class="flex items-center gap-3 mb-3">
                        <i class="fas fa-envelope text-[#ff7a00] text-sm"></i>
                        <a href="mailto:<?= htmlspecialchars($tenant->contact_email) ?>" class="text-gray-700 hover:text-[#ff7a00] transition text-sm break-all" dir="ltr"><?= htmlspecialchars($tenant->contact_email) ?></a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Warranty Badge -->
            <div class="bg-[#f5f5f5] rounded-lg p-6 fade-up" style="transition-delay:.15s">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-lg bg-[#ff7a00]/10 flex items-center justify-center text-2xl flex-shrink-0">
                        <i class="fas fa-shield-halved text-[#ff7a00]"></i>
                    </div>
                    <div>
                        <h4 class="font-black"><?= $lang === 'en' ? 'Service Warranty' : 'ضمان الخدمة' ?></h4>
                        <p class="text-gray-500 text-sm"><?= $lang === 'en' ? 'Up to 6 months warranty on all work' : 'ضمان يصل إلى 6 أشهر على جميع الأعمال' ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

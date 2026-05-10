<?php
/**
 * CleanPro Theme — Single Service Detail Page
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
        'description' => 'نقدم خدمات تنظيف احترافية متكاملة بأحدث التقنيات وأعلى معايير الجودة. فريقنا المتخصص جاهز لخدمتكم على مدار الساعة.',
        'description_en' => 'We provide comprehensive professional cleaning services with the latest technology and highest quality standards. Our team is ready to serve you 24/7.',
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
    ['num' => '01', 'title' => 'Book', 'desc' => 'Choose a service and book your appointment.'],
    ['num' => '02', 'title' => 'Inspection', 'desc' => 'Our technician arrives and inspects the issue.'],
    ['num' => '03', 'title' => 'Work', 'desc' => 'Professional work with high quality standards.'],
    ['num' => '04', 'title' => 'Warranty', 'desc' => 'Enjoy your warranty and our follow-up.'],
] : [
    ['num' => '01', 'title' => 'احجز', 'desc' => 'اختر الخدمة واحجز موعدك في الوقت المناسب.'],
    ['num' => '02', 'title' => 'الفحص', 'desc' => 'يصل فنيّنا المعتمد ويقوم بفحص المشكلة.'],
    ['num' => '03', 'title' => 'العمل', 'desc' => 'ننتهي من العمل بأعلى جودة ومعايير احترافية.'],
    ['num' => '04', 'title' => 'الضمان', 'desc' => 'استمتع بضمان الخدمة ومتابعة فريقنا لكم.'],
];

require_once __DIR__ . '/partials/_head.php';
require_once __DIR__ . '/partials/_navbar.php';
?>

<!-- ═══════ BREADCRUMB ═══════ -->
<div class="cpro-breadcrumb">
    <div class="cpro-container" style="display:flex;align-items:center;gap:4px;flex-wrap:wrap">
        <a href="<?= url($siteBase) ?>"><?= $lang === 'en' ? 'Home' : 'الرئيسية' ?></a>
        <i class="fas fa-chevron-<?= $isRtl ? 'left' : 'right' ?>"></i>
        <a href="<?= url($siteBase . '/services') ?>"><?= $lang === 'en' ? 'Services' : 'خدماتنا' ?></a>
        <i class="fas fa-chevron-<?= $isRtl ? 'left' : 'right' ?>"></i>
        <span class="current"><?= htmlspecialchars($svcTitle) ?></span>
    </div>
</div>

<!-- ═══════ SERVICE DETAIL ═══════ -->
<section class="cpro-section">
    <div class="cpro-container" style="display:grid;grid-template-columns:1.5fr 1fr;gap:50px;align-items:start">

        <!-- Main Content -->
        <div>
            <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px">
                <div style="width:64px;height:64px;background:var(--blue);color:#fff;border-radius:12px;display:grid;place-items:center;font-size:26px;box-shadow:0 8px 20px rgba(11,127,243,.25)">
                    <i class="<?= htmlspecialchars($svcIcon) ?>"></i>
                </div>
                <h1 class="cpro-title" style="margin:0"><?= htmlspecialchars($svcTitle) ?></h1>
            </div>

            <?php if ($svcImg): ?>
                <div style="border-radius:12px;overflow:hidden;box-shadow:var(--shadow);margin-bottom:28px">
                    <img src="<?= htmlspecialchars($svcImg) ?>" alt="<?= htmlspecialchars($svcTitle) ?>" style="width:100%;height:380px;object-fit:cover">
                </div>
            <?php endif; ?>

            <h2 style="font-size:22px;font-weight:900;margin-bottom:12px"><?= $lang === 'en' ? 'About This Service' : 'عن هذه الخدمة' ?></h2>
            <p style="color:var(--muted);font-size:17px;line-height:1.9;margin-bottom:36px"><?= htmlspecialchars($svcDesc) ?></p>

            <h2 style="font-size:22px;font-weight:900;margin-bottom:18px"><?= $lang === 'en' ? 'What You Get' : 'ما تحصل عليه' ?></h2>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:36px">
                <?php foreach ($svcFeatures as $feat): ?>
                    <div style="display:flex;align-items:center;gap:12px;background:var(--light);border-radius:10px;padding:14px 16px">
                        <div style="width:36px;height:36px;min-width:36px;background:var(--blue);color:#fff;border-radius:8px;display:grid;place-items:center;font-size:14px"><i class="fas fa-check"></i></div>
                        <span style="font-weight:700;font-size:14px"><?= htmlspecialchars($feat) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <h2 style="font-size:22px;font-weight:900;margin-bottom:18px"><?= $lang === 'en' ? 'How It Works' : 'كيف تعمل الخدمة' ?></h2>
            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px">
                <?php foreach ($steps as $step): ?>
                    <div class="cpro-step">
                        <span style="font-size:28px;color:var(--blue);opacity:.4;font-weight:900"><?= $step['num'] ?></span>
                        <h4><?= htmlspecialchars($step['title']) ?></h4>
                        <p style="color:var(--muted);font-size:13px;margin-top:6px"><?= htmlspecialchars($step['desc']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Price Card -->
            <div style="background:#fff;box-shadow:var(--shadow);border-radius:12px;padding:32px;text-align:center;position:sticky;top:100px">
                <?php if ($svcPrice): ?>
                    <p style="color:var(--muted);font-size:13px;margin-bottom:4px"><?= $lang === 'en' ? 'Starting from' : 'يبدأ من' ?></p>
                    <h3 style="font-size:38px;font-weight:900;color:var(--blue);margin-bottom:24px"><?= htmlspecialchars($svcPrice) ?></h3>
                <?php endif; ?>
                <a href="<?= url($siteBase . '/booking') ?>" class="cpro-btn" style="width:100%;margin-bottom:12px">
                    <i class="fas fa-calendar-check"></i> <?= $lang === 'en' ? 'Book Now' : 'احجز الآن' ?>
                </a>
                <a href="<?= $waUrl ?>?text=<?= urlencode($svcTitle) ?>" target="_blank" class="cpro-btn" style="width:100%;background:#25D366;box-shadow:0 12px 24px rgba(37,211,102,.25)">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
            </div>

            <!-- Quick Contact -->
            <?php if (!empty($tenant->contact_phone) || !empty($tenant->contact_email)): ?>
            <div style="background:var(--light);border-radius:12px;padding:24px;margin-top:20px">
                <h4 style="font-weight:900;margin-bottom:14px"><i class="fas fa-phone-volume" style="color:var(--blue);margin-inline-end:8px"></i><?= $lang === 'en' ? 'Quick Contact' : 'تواصل سريع' ?></h4>
                <?php if (!empty($tenant->contact_phone)): ?>
                    <p style="margin-bottom:10px"><i class="fas fa-phone" style="color:var(--blue);margin-inline-end:8px;font-size:13px"></i><a href="tel:<?= htmlspecialchars($tenant->contact_phone) ?>" style="font-weight:600" dir="ltr"><?= htmlspecialchars($tenant->contact_phone) ?></a></p>
                <?php endif; ?>
                <?php if (!empty($tenant->contact_email)): ?>
                    <p><i class="fas fa-envelope" style="color:var(--blue);margin-inline-end:8px;font-size:13px"></i><a href="mailto:<?= htmlspecialchars($tenant->contact_email) ?>" style="font-weight:600;font-size:14px"><?= htmlspecialchars($tenant->contact_email) ?></a></p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Warranty Badge -->
            <div style="background:var(--light);border-radius:12px;padding:24px;margin-top:20px">
                <div style="display:flex;align-items:center;gap:16px">
                    <div style="width:54px;height:54px;min-width:54px;background:rgba(11,127,243,.1);border-radius:12px;display:grid;place-items:center;font-size:24px;color:var(--blue)">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <div>
                        <h4 style="font-weight:900"><?= $lang === 'en' ? 'Service Warranty' : 'ضمان الخدمة' ?></h4>
                        <p style="color:var(--muted);font-size:13px"><?= $lang === 'en' ? 'Up to 6 months warranty on all work' : 'ضمان يصل إلى 6 أشهر على جميع الأعمال' ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════ CTA ═══════ -->
<section class="cpro-dark-band">
    <div class="cpro-container cpro-center" style="color:#fff">
        <h2 class="cpro-title" style="color:#fff"><?= $lang === 'en' ? 'Need a Different Service?' : 'تحتاج خدمة أخرى؟' ?></h2>
        <p class="cpro-subtitle" style="color:#cbd5e1;margin:16px auto 28px"><?= $lang === 'en'
            ? 'Browse all our services or contact us for a custom solution.'
            : 'تصفح جميع خدماتنا أو تواصل معنا لحل مخصص.' ?></p>
        <a href="<?= url($siteBase . '/services') ?>" class="cpro-btn cpro-btn-white"><?= $lang === 'en' ? 'All Services' : 'جميع الخدمات' ?></a>
    </div>
</section>

<?php require_once __DIR__ . '/partials/_footer.php'; ?>
<?php require_once __DIR__ . '/partials/_scripts.php'; ?>

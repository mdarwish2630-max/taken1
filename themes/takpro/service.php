<?php
/**
 * TakPro Theme — Single Service Detail Page
 */
$siteBase  = $siteBase ?? ('/site/' . ($tenant->slug ?? 'demo'));
$dir       = $dir ?? 'rtl';
$lang      = $lang ?? 'ar';
$isRtl     = ($dir === 'rtl');

$whatsapp  = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
$waNumber  = preg_replace('/[^0-9+]/', '', $whatsapp);

/* ── Current Service ── */
$svcTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'Service Details' : 'تفاصيل الخدمة'));
$svcContent = $lang === 'en' && !empty($page->content_en) ? $page->content_en : ($page->content ?? '');
$svcImage = '';

/* Try to find matching service from $services */
$currentService = null;
if (!empty($services)) {
    foreach ($services as $svc) {
        if (strtolower($svc->slug ?? '') === strtolower($page->slug ?? '')) {
            $currentService = $svc;
            break;
        }
    }
}
if ($currentService) {
    $svcTitle = $lang === 'en' && !empty($currentService->title_en) ? $currentService->title_en : ($currentService->title ?? $svcTitle);
    $svcDesc  = $lang === 'en' && !empty($currentService->description_en) ? $currentService->description_en : ($currentService->description ?? '');
    $svcImage = !empty($currentService->image) ? upload($currentService->image) : '';
    $svcPrice = !empty($currentService->price) ? $currentService->price : '';
    $svcIcon  = $currentService->icon ?? 'fas fa-star';
}

/* Fallback image */
if (empty($svcImage)) {
    $svcImage = 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=1200&auto=format&fit=crop';
}

/* Features for this service */
$svcFeatures = [
    (object)['title' => $lang === 'en' ? 'Fast Response' : 'استجابة سريعة', 'desc' => $lang === 'en' ? 'We arrive within hours of your call' : 'نصل خلال ساعات من اتصالك'],
    (object)['title' => $lang === 'en' ? 'Professional Team' : 'فريق محترف', 'desc' => $lang === 'en' ? 'Certified and trained technicians' : 'فنيون معتمدون ومدربون'],
    (object)['title' => $lang === 'en' ? 'Guaranteed Quality' : 'جودة مضمونة', 'desc' => $lang === 'en' ? 'High quality with service guarantee' : 'جودة عالية مع ضمان الخدمة'],
    (object)['title' => $lang === 'en' ? 'Fair Pricing' : 'أسعار عادلة', 'desc' => $lang === 'en' ? 'Transparent prices with no hidden fees' : 'أسعار شفافة بدون رسوم مخفية'],
];

require_once __DIR__ . '/_head.php';
require_once __DIR__ . '/_navbar.php';
?>

<!-- ══════════════════════════════════════════════════════
     SERVICE HERO
     ══════════════════════════════════════════════════════ -->
<section class="relative min-h-[400px] bg-dark-section">
    <img src="<?= htmlspecialchars($svcImage) ?>" class="absolute inset-0 w-full h-full object-cover opacity-40" alt="<?= htmlspecialchars($svcTitle) ?>">
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-16 pt-32 pb-16 text-white fade-up">
        <nav class="flex items-center gap-2 text-sm text-gray-300 mb-6">
            <a href="<?= url($siteBase) ?>" class="hover:text-brand transition"><?= $lang === 'en' ? 'Home' : 'الرئيسية' ?></a>
            <i class="fas fa-chevron-<?= $isRtl ? 'left' : 'right' ?> text-xs"></i>
            <a href="<?= url($siteBase . '/services') ?>" class="hover:text-brand transition"><?= $lang === 'en' ? 'Services' : 'الخدمات' ?></a>
            <i class="fas fa-chevron-<?= $isRtl ? 'left' : 'right' ?> text-xs"></i>
            <span class="text-brand"><?= htmlspecialchars($svcTitle) ?></span>
        </nav>
        <?php if (!empty($svcIcon)): ?>
            <div class="w-16 h-16 bg-brand rounded-xl flex items-center justify-center text-white text-2xl mb-5">
                <i class="<?= htmlspecialchars($svcIcon) ?>"></i>
            </div>
        <?php endif; ?>
        <h1 class="text-4xl lg:text-6xl font-black mb-4"><?= htmlspecialchars($svcTitle) ?></h1>
        <?php if (!empty($svcDesc)): ?>
            <p class="text-lg text-gray-200 max-w-2xl"><?= htmlspecialchars($svcDesc) ?></p>
        <?php endif; ?>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════
     SERVICE CONTENT
     ══════════════════════════════════════════════════════ -->
<section class="px-6 lg:px-16 py-20 bg-white">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-3 gap-14">
        <!-- Main Content -->
        <div class="lg:col-span-2 fade-up">
            <?php if ($svcContent): ?>
                <div class="prose prose-lg max-w-none text-gray-600 leading-loose mb-10"><?= $svcContent ?></div>
            <?php else: ?>
                <p class="text-gray-600 leading-loose mb-10">
                    <?= $lang === 'en'
                        ? 'We provide this service with the highest standards of quality and professionalism. Our team is trained and equipped with the latest tools and materials to ensure outstanding results every time. Contact us now to learn more or to schedule a service.'
                        : 'نقدم هذه الخدمة بأعلى معايير الجودة والاحترافية. فريقنا مدرب ومجهز بأحدث الأدوات والمواد لضمان نتائج مبهرة في كل مرة. تواصل معنا الآن لمعرفة المزيد أو لحجز خدمة.' ?>
                </p>
            <?php endif; ?>

            <!-- Service Features -->
            <h2 class="text-3xl font-black mb-8"><?= $lang === 'en' ? 'What Makes This Service Special' : 'ما يميز هذه الخدمة' ?></h2>
            <div class="grid sm:grid-cols-2 gap-5 mb-10">
                <?php foreach ($svcFeatures as $feat): ?>
                    <div class="bg-[#f5f5f5] p-6 rounded-xl">
                        <h3 class="font-black text-lg mb-2"><?= htmlspecialchars($feat->title) ?></h3>
                        <p class="text-gray-600 text-sm"><?= htmlspecialchars($feat->desc) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="fade-up" style="transition-delay:.1s">
            <div class="bg-dark-card text-white rounded-xl p-8 sticky top-32">
                <h3 class="text-2xl font-black mb-6"><?= $lang === 'en' ? 'Book This Service' : 'احجز هذه الخدمة' ?></h3>
                <?php if (!empty($svcPrice)): ?>
                    <div class="text-center mb-6">
                        <span class="text-4xl font-black text-brand"><?= htmlspecialchars($svcPrice) ?></span>
                    </div>
                <?php endif; ?>
                <a href="https://wa.me/<?= $waNumber ?>" target="_blank"
                   class="block w-full bg-brand text-dark text-center px-6 py-4 rounded-xl font-black text-lg hover:bg-brand-dark transition mb-4">
                    <i class="fab fa-whatsapp ml-2"></i>
                    <?= $lang === 'en' ? 'Book via WhatsApp' : 'احجز عبر واتساب' ?>
                </a>
                <?php if ($phone): ?>
                    <a href="tel:<?= htmlspecialchars($phone) ?>"
                       class="block w-full bg-white/10 text-white text-center px-6 py-4 rounded-xl font-black hover:bg-white/20 transition mb-6">
                        <i class="fas fa-phone ml-2"></i>
                        <?= htmlspecialchars($phone) ?>
                    </a>
                <?php endif; ?>
                <div class="border-t border-white/10 pt-6 space-y-3 text-sm text-gray-300">
                    <p><i class="fas fa-check-circle text-brand ml-2"></i><?= $lang === 'en' ? 'Free consultation' : 'استشارة مجانية' ?></p>
                    <p><i class="fas fa-check-circle text-brand ml-2"></i><?= $lang === 'en' ? 'Quick response time' : 'وقت استجابة سريع' ?></p>
                    <p><i class="fas fa-check-circle text-brand ml-2"></i><?= $lang === 'en' ? 'Service guarantee' : 'ضمان على الخدمة' ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

<?php
/**
 * TakPro Theme — Services Page
 */
$siteBase  = $siteBase ?? ('/site/' . ($tenant->slug ?? 'demo'));
$dir       = $dir ?? 'rtl';
$lang      = $lang ?? 'ar';
$isRtl     = ($dir === 'rtl');

/* ── Services ── */
$allServices = [];
if (!empty($services)) { foreach ($services as $svc) { $allServices[] = $svc; } }
if (empty($allServices)) {
    $allServices = [
        (object)['title' => 'الدعم التقني', 'title_en' => 'Technical Support', 'description' => 'حلول تقنية متكاملة وفورية لجميع احتياجاتكم.', 'description_en' => 'Integrated and instant tech solutions for all your needs.', 'icon' => 'fas fa-headset', 'image' => '', 'slug' => 'tech-support', 'price' => ''],
        (object)['title' => 'حلول الشبكات', 'title_en' => 'Network Solutions', 'description' => 'تصميم وإدارة شبكات احترافية للمنازل والشركات.', 'description_en' => 'Professional network design & management for homes and businesses.', 'icon' => 'fas fa-network-wired', 'image' => '', 'slug' => 'network', 'price' => ''],
        (object)['title' => 'صيانة الأنظمة', 'title_en' => 'System Maintenance', 'description' => 'صيانة دورية وطارئة لجميع الأنظمة.', 'description_en' => 'Regular and emergency maintenance for all systems.', 'icon' => 'fas fa-tools', 'image' => '', 'slug' => 'maintenance', 'price' => ''],
        (object)['title' => 'تعقيم كامل', 'title_en' => 'Full Sanitization', 'description' => 'تعقيم شامل بمواد آمنة ومعتمدة.', 'description_en' => 'Comprehensive sanitization with safe, approved materials.', 'icon' => 'fas fa-shield-virus', 'image' => '', 'slug' => 'sanitization', 'price' => ''],
        (object)['title' => 'تنظيف الزجاج', 'title_en' => 'Glass Cleaning', 'description' => 'تنظيف ولمعان الزجاج والواجهات.', 'description_en' => 'Glass and facade cleaning & polishing.', 'icon' => 'fas fa-spray-can-sparkles', 'image' => '', 'slug' => 'glass-cleaning', 'price' => ''],
        (object)['title' => 'تنظيف بعد البناء', 'title_en' => 'Post-Construction', 'description' => 'تنظيف شامل بعد أعمال البناء والتشطيبات.', 'description_en' => 'Comprehensive cleaning after construction and finishing work.', 'icon' => 'fas fa-hard-hat', 'image' => '', 'slug' => 'post-construction', 'price' => ''],
    ];
}

$serviceImages = [
    'https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1585421514284-efb74c2b69ba?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1528744598421-b7b93e12df54?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=900&auto=format&fit=crop',
];

$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'Our Services' : 'خدماتنا'));

require_once __DIR__ . '/_head.php';
require_once __DIR__ . '/_navbar.php';
?>

<!-- ══════════════════════════════════════════════════════
     PAGE HEADER
     ══════════════════════════════════════════════════════ -->
<section class="relative bg-dark-section py-24 px-6 lg:px-16">
    <img src="https://images.unsplash.com/photo-1585421514284-efb74c2b69ba?q=80&w=1800&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-20" alt="">
    <div class="relative z-10 max-w-7xl mx-auto text-center text-white fade-up">
        <h1 class="text-5xl lg:text-6xl font-black mb-4"><?= htmlspecialchars($pageTitle) ?></h1>
        <p class="text-lg text-gray-300 max-w-2xl mx-auto">
            <?= $lang === 'en'
                ? 'Discover our comprehensive range of professional services designed to meet all your needs.'
                : 'اكتشف مجموعتنا الشاملة من الخدمات الاحترافية المصممة لتلبية جميع احتياجاتكم.' ?>
        </p>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════
     SERVICES GRID
     ══════════════════════════════════════════════════════ -->
<section class="px-6 lg:px-16 py-20 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($allServices as $i => $svc): ?>
                <?php
                    $svcTitle = $lang === 'en' && !empty($svc->title_en) ? $svc->title_en : ($svc->title ?? '');
                    $svcDesc  = $lang === 'en' && !empty($svc->description_en) ? $svc->description_en : ($svc->description ?? '');
                    $svcImg   = !empty($svc->image) ? function_exists('upload') ? upload($svc->image) : $svc->image : ($serviceImages[$i % count($serviceImages)] ?? '');
                    $svcIcon  = $svc->icon ?? 'fas fa-star';
                    $svcPrice = !empty($svc->price) ? $svc->price : '';
                ?>
                <div class="group bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition duration-300 fade-up service-card" style="transition-delay:<?= ($i * 0.08) ?>s">
                    <!-- Image -->
                    <div class="relative h-56 overflow-hidden">
                        <img src="<?= htmlspecialchars($svcImg) ?>" alt="<?= htmlspecialchars($svcTitle) ?>"
                             class="w-full h-full object-cover service-img transition duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        <div class="absolute top-4 <?= $isRtl ? 'right-4' : 'left-4' ?> w-12 h-12 rounded-xl bg-brand flex items-center justify-center text-white text-lg shadow-lg">
                            <i class="<?= htmlspecialchars($svcIcon) ?>"></i>
                        </div>
                        <?php if ($svcPrice): ?>
                            <div class="absolute bottom-4 <?= $isRtl ? 'left-4' : 'right-4' ?> bg-white text-dark px-4 py-1 rounded-full font-black text-sm">
                                <?= htmlspecialchars($svcPrice) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- Content -->
                    <div class="p-7">
                        <h3 class="text-2xl font-black mb-3 group-hover:text-brand transition"><?= htmlspecialchars($svcTitle) ?></h3>
                        <p class="text-gray-600 leading-relaxed mb-5"><?= htmlspecialchars($svcDesc) ?></p>
                        <a href="<?= url($siteBase . '/service/' . ($svc->slug ?? 'service-' . ($i + 1))) ?>"
                           class="inline-flex items-center gap-2 bg-brand text-white px-6 py-3 rounded-lg font-black hover:bg-brand-dark transition">
                            <?= $lang === 'en' ? 'View Details' : 'عرض التفاصيل' ?>
                            <i class="fas fa-arrow-<?= $isRtl ? 'left' : 'right' ?>"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════
     CTA
     ══════════════════════════════════════════════════════ -->
<section class="bg-brand px-6 lg:px-16 py-16 text-center fade-up">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-4xl lg:text-5xl font-black text-dark mb-6">
            <?= $lang === 'en' ? 'Need a Custom Service?' : 'تحتاج خدمة مخصصة؟' ?>
        </h2>
        <p class="text-lg text-dark/80 max-w-2xl mx-auto mb-8">
            <?= $lang === 'en'
                ? 'Contact us now and we will provide you with a tailored solution that meets your exact needs.'
                : 'تواصل معنا الآن وسنقدم لك حلاً مخصصاً يلبي احتياجاتك بالضبط.' ?>
        </p>
        <?php $waNumber = preg_replace('/[^0-9+]/', '', $tenant->contact_whatsapp ?? $tenant->contact_phone ?? ''); ?>
        <a href="https://wa.me/<?= $waNumber ?>" target="_blank"
           class="inline-block bg-dark-card text-white px-10 py-4 rounded-xl font-black text-lg hover:bg-dark transition shadow-xl">
            <?= $lang === 'en' ? 'Contact Us Now' : 'تواصل معنا الآن' ?>
        </a>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

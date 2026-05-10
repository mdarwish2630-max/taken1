<?php
/**
 * Tek Pro Theme — Services Page
 * Service cards grid with image, title, description, price, booking button
 * Light theme + Orange accents
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';
$whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
$waNumber = preg_replace('/[^0-9+]/', '', $whatsapp);

$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'Our Services' : 'خدماتنا'));
$pageContent = $lang === 'en' && !empty($page->content_en) ? $page->content_en : ($page->content ?? '');

$serviceImages = [
    'https://images.unsplash.com/photo-1621905252507-b35492cc74b4?q=80&w=600&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1585704032915-c3400ca199e7?q=80&w=600&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1621905251918-48416bd8575a?q=80&w=600&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=600&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?q=80&w=600&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=600&auto=format&fit=crop',
];

if (empty($services)) {
    $services = [
        (object)['id' => 0, 'slug' => 'service-1', 'title' => 'الدعم التقني', 'title_en' => 'Tech Support', 'description' => 'دعم فني شامل وحلول تقنية متكاملة لجميع احتياجاتكم.', 'description_en' => 'Comprehensive tech support and integrated solutions for all your needs.', 'icon' => 'fas fa-headset', 'image' => '', 'price' => '150 ₺', 'price_text' => '150 ₺'],
        (object)['id' => 0, 'slug' => 'service-2', 'title' => 'حلول الشبكات', 'title_en' => 'Network Solutions', 'description' => 'تصميم وإدارة وصيانة شبكات متقدمة بأحدث التقنيات.', 'description_en' => 'Design, management and maintenance of advanced networks with latest tech.', 'icon' => 'fas fa-network-wired', 'image' => '', 'price' => '200 ₺', 'price_text' => '200 ₺'],
        (object)['id' => 0, 'slug' => 'service-3', 'title' => 'صيانة الأنظمة', 'title_en' => 'System Maintenance', 'description' => 'صيانة دورية وتحديثات مستمرة لضمان أداء الأنظمة.', 'description_en' => 'Regular maintenance and continuous updates to ensure system performance.', 'icon' => 'fas fa-tools', 'image' => '', 'price' => '100 ₺', 'price_text' => '100 ₺'],
        (object)['id' => 0, 'slug' => 'service-4', 'title' => 'الحماية والأمان', 'title_en' => 'Security', 'description' => 'حلول أمنية متقدمة لحماية بياناتك وممتلكاتك الرقمية.', 'description_en' => 'Advanced security solutions to protect your data and digital assets.', 'icon' => 'fas fa-shield-halved', 'image' => '', 'price' => '180 ₺', 'price_text' => '180 ₺'],
        (object)['id' => 0, 'slug' => 'service-5', 'title' => 'استشارات تقنية', 'title_en' => 'Tech Consulting', 'description' => 'استشارات متخصصة لتحسين البنية التحتية التقنية.', 'description_en' => 'Specialized consulting to improve your technical infrastructure.', 'icon' => 'fas fa-lightbulb', 'image' => '', 'price' => '120 ₺', 'price_text' => '120 ₺'],
        (object)['id' => 0, 'slug' => 'service-6', 'title' => 'التطوير والبرمجة', 'title_en' => 'Development', 'description' => 'تطوير مواقع وتطبيقات بأحدث التقنيات والمعايير.', 'description_en' => 'Website and app development with latest technologies and standards.', 'icon' => 'fas fa-code', 'image' => '', 'price' => '250 ₺', 'price_text' => '250 ₺'],
    ];
}

require_once __DIR__ . '/_head.php';
require_once __DIR__ . '/_navbar.php';
?>

<!-- ═══════ PAGE HEADER ═══════ -->
<section class="bg-[#f3f3f3] px-6 lg:px-16 py-16">
    <div class="max-w-4xl mx-auto fade-up">
        <p class="text-[#ff7a00] font-black mb-3"><?= $lang === 'en' ? 'Our Services' : 'خدماتنا' ?></p>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight mb-6"><?= htmlspecialchars($pageTitle) ?></h1>
        <?php if (!empty($pageContent)): ?>
            <p class="text-gray-600 text-lg leading-relaxed max-w-3xl"><?= $pageContent ?></p>
        <?php else: ?>
            <p class="text-gray-600 text-lg leading-relaxed max-w-3xl">
                <?= $lang === 'en'
                    ? 'Discover our wide range of professional services designed to meet your needs with the highest quality standards.'
                    : 'اكتشف مجموعتنا الواسعة من الخدمات الاحترافية المصممة لتلبية احتياجاتكم بأعلى معايير الجودة.' ?>
            </p>
        <?php endif; ?>
    </div>
</section>

<!-- ═══════ SERVICES GRID ═══════ -->
<section class="px-6 lg:px-16 py-16">
    <div class="max-w-7xl mx-auto grid sm:grid-cols-2 xl:grid-cols-3 gap-8">
        <?php foreach ($services as $i => $svc):
            $svcTitle = $lang === 'en' && !empty($svc->title_en) ? $svc->title_en : ($svc->title ?? '');
            $svcDesc  = $lang === 'en' && !empty($svc->description_en) ? $svc->description_en : ($svc->description ?? '');
            $svcImg   = !empty($svc->image) ? (function_exists('upload') ? upload($svc->image) : $svc->image) : ($serviceImages[$i % count($serviceImages)] ?? '');
            $svcIcon  = $svc->icon ?? 'fas fa-star';
            $svcPrice = !empty($svc->price) ? $svc->price : '';
        ?>
            <div class="group bg-white shadow-lg rounded-lg overflow-hidden tekpro-card fade-up">
                <!-- Image -->
                <div class="relative h-56 overflow-hidden">
                    <?php if ($svcImg): ?>
                        <img src="<?= htmlspecialchars($svcImg) ?>" alt="<?= htmlspecialchars($svcTitle) ?>"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                    <?php else: ?>
                        <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                            <i class="<?= htmlspecialchars($svcIcon) ?> text-5xl text-gray-400"></i>
                        </div>
                    <?php endif; ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    <?php if (!empty($svcPrice)): ?>
                        <div class="absolute top-4 <?= $isRtl ? 'left-4' : 'right-4' ?> bg-[#ff7a00] text-white rounded-md px-4 py-1.5 font-black text-sm"><?= htmlspecialchars($svcPrice) ?></div>
                    <?php endif; ?>
                </div>

                <!-- Content -->
                <div class="p-7">
                    <h3 class="text-xl font-black mb-3 group-hover:text-[#ff7a00] transition"><?= htmlspecialchars($svcTitle) ?></h3>
                    <p class="text-gray-500 leading-relaxed mb-6 text-sm line-clamp-2"><?= htmlspecialchars($svcDesc) ?></p>
                    <div class="flex gap-3">
                        <a href="<?= url($siteBase . '/service/' . ($svc->slug ?? 'service-' . ($i + 1))) ?>"
                           class="flex-1 text-center bg-[#ff7a00] hover:bg-[#e86e00] transition rounded-lg py-3 font-black text-sm text-white">
                            <?= $lang === 'en' ? 'Details' : 'التفاصيل' ?>
                        </a>
                        <a href="<?= url($siteBase . '/booking') ?>"
                           class="flex-1 text-center bg-[#171717] hover:bg-[#333] transition rounded-lg py-3 font-black text-sm text-white">
                            <?= $lang === 'en' ? 'Book Now' : 'احجز الآن' ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ═══════ CTA SECTION ═══════ -->
<section class="bg-[#ff7a00] px-6 lg:px-16 py-16 fade-up">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-4xl font-black text-white mb-6"><?= $lang === 'en' ? 'Need a Custom Service?' : 'تحتاج خدمة مخصصة؟' ?></h2>
        <p class="text-lg text-white/90 max-w-2xl mx-auto leading-relaxed mb-8">
            <?= $lang === 'en' ? 'Contact us and we will tailor a solution that fits your requirements.' : 'تواصل معنا وسنصمم لك حلاً يتناسب مع متطلباتك.' ?>
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="https://wa.me/<?= $waNumber ?>" target="_blank"
               class="inline-flex items-center gap-2 bg-white text-[#ff7a00] hover:scale-105 transition px-8 py-4 rounded-lg font-black shadow-xl">
                <i class="fab fa-whatsapp text-lg"></i>
                <?= $lang === 'en' ? 'Contact via WhatsApp' : 'تواصل عبر واتساب' ?>
            </a>
            <a href="<?= url($siteBase . '/booking') ?>"
               class="inline-flex items-center gap-2 bg-white/20 hover:bg-white/30 transition px-8 py-4 rounded-lg font-bold text-white border border-white/30">
                <i class="fas fa-calendar-check"></i>
                <?= $lang === 'en' ? 'Book Appointment' : 'احجز موعد' ?>
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

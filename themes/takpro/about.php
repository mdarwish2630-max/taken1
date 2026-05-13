<?php
/**
 * TakPro Theme — About Page
 */
$siteBase  = $siteBase ?? ('/site/' . ($tenant->slug ?? 'demo'));
$dir       = $dir ?? 'rtl';
$lang      = $lang ?? 'ar';
$isRtl     = ($dir === 'rtl');

$siteName  = htmlspecialchars($tenant->site_name ?? 'تك برو');
$siteNameEn = htmlspecialchars($tenant->site_name_en ?? 'TakPro');
$displaySiteName = ($lang ?? 'ar') === 'en' ? $siteNameEn : $siteName;

/* ── Features ── */
$features = [];
if (!empty($siteFeatures)) { foreach ($siteFeatures as $f) { $features[] = $f; } }
if (empty($features)) {
    $features = [
        (object)['title' => 'أسعار مناسبة', 'title_en' => 'Affordable Prices', 'description' => 'أسعار تنافسية تناسب الجميع', 'description_en' => 'Competitive prices for everyone', 'icon' => 'fas fa-tags'],
        (object)['title' => 'خدمة في نفس اليوم', 'title_en' => 'Same-Day Service', 'description' => 'استجابة سريعة خلال ساعات', 'description_en' => 'Fast response within hours', 'icon' => 'fas fa-clock'],
        (object)['title' => 'مواد آمنة', 'title_en' => 'Safe Materials', 'description' => 'منتجات صديقة للبيئة', 'description_en' => 'Eco-friendly products', 'icon' => 'fas fa-leaf'],
        (object)['title' => 'فريق محترف', 'title_en' => 'Expert Team', 'description' => 'فنيون معتمدون ومدربون', 'description_en' => 'Certified & trained technicians', 'icon' => 'fas fa-user-check'],
        (object)['title' => 'نتائج مضمونة', 'title_en' => 'Guaranteed Results', 'description' => 'جودة عالية مع ضمان الخدمة', 'description_en' => 'High quality with service guarantee', 'icon' => 'fas fa-award'],
        (object)['title' => 'دعم متواصل', 'title_en' => 'Continuous Support', 'description' => 'فريق دعم متاح على مدار الساعة', 'description_en' => 'Support team available around the clock', 'icon' => 'fas fa-headset'],
    ];
}

/* ── Stats ── */
$stats = [];
if (!empty($siteStats)) { foreach ($siteStats as $s) { $stats[] = $s; } }
if (count($stats) < 3) {
    $stats = [
        (object)['value' => '8000', 'label' => 'عميل سعيد', 'label_en' => 'Happy Clients', 'icon' => 'fas fa-smile', 'suffix' => '+'],
        (object)['value' => '5000', 'label' => 'مشروع منجز', 'label_en' => 'Projects Done', 'icon' => 'fas fa-check-circle', 'suffix' => '+'],
        (object)['value' => '98', 'label' => 'نسبة الرضا', 'label_en' => 'Satisfaction Rate', 'icon' => 'fas fa-chart-line', 'suffix' => '%'],
        (object)['value' => '50', 'label' => 'فني متخصص', 'label_en' => 'Specialized Technicians', 'icon' => 'fas fa-users', 'suffix' => '+'],
    ];
}

$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'About Us' : 'من نحن'));
$pageContent = $lang === 'en' && !empty($page->content_en) ? $page->content_en : ($page->content ?? '');

require_once __DIR__ . '/_head.php';
require_once __DIR__ . '/_navbar.php';
?>

<!-- ══════════════════════════════════════════════════════
     PAGE HEADER
     ══════════════════════════════════════════════════════ -->
<section class="relative bg-dark-section py-24 px-6 lg:px-16">
    <img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=1800&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-20" alt="">
    <div class="relative z-10 max-w-7xl mx-auto text-center text-white fade-up">
        <h1 class="text-5xl lg:text-6xl font-black mb-4"><?= htmlspecialchars($pageTitle) ?></h1>
        <p class="text-lg text-gray-300 max-w-2xl mx-auto">
            <?= $lang === 'en'
                ? 'Learn more about our company, our values, and our commitment to providing the best services.'
                : 'تعرّف أكثر على شركتنا، قيمنا، والتزامنا بتقديم أفضل الخدمات.' ?>
        </p>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════
     ABOUT CONTENT
     ══════════════════════════════════════════════════════ -->
<section class="px-6 lg:px-16 py-20 bg-white">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-14 items-center">
        <div class="fade-up">
            <p class="text-brand font-black mb-3"><?= $lang === 'en' ? 'Our Story' : 'قصتنا' ?></p>
            <h2 class="text-4xl lg:text-5xl font-black leading-tight mb-6">
                <?= $lang === 'en' ? 'We Deliver Excellence in Every Service' : 'نقدم التميز في كل خدمة' ?>
            </h2>
            <?php if ($pageContent): ?>
                <div class="text-gray-600 leading-loose mb-7"><?= sanitizeHTML($pageContent) ?></div>
            <?php else: ?>
                <p class="text-gray-600 leading-loose mb-7">
                    <?= $lang === 'en'
                        ? 'We are a professional company specialized in providing high-quality services for homes and businesses. With years of experience, a trained team, and safe materials, we ensure the best results every time.'
                        : 'نحن شركة متخصصة في تقديم خدمات عالية الجودة للمنازل والشركات. بخبرة سنوات طويلة، فريق مدرب، ومواد آمنة، نضمن أفضل النتائج في كل مرة.' ?>
                </p>
            <?php endif; ?>
            <ul class="space-y-3 font-bold text-dark">
                <?php foreach (array_slice($features, 0, 4) as $feat): ?>
                    <?php $featTitle = $lang === 'en' && !empty($feat->title_en) ? $feat->title_en : ($feat->title ?? ''); ?>
                    <li><i class="fas fa-check-circle text-brand ml-2"></i><?= htmlspecialchars($featTitle) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="grid grid-cols-2 gap-4 max-w-[430px] mx-auto lg:mx-0 fade-up" style="transition-delay:.1s">
            <img src="https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?q=80&w=700&auto=format&fit=crop" class="w-full h-[210px] object-cover rounded-lg" alt="">
            <img src="https://images.unsplash.com/photo-1585421514284-efb74c2b69ba?q=80&w=700&auto=format&fit=crop" class="w-full h-[210px] object-cover rounded-lg mt-8" alt="">
            <div class="bg-brand p-7 flex items-center justify-center text-white text-4xl rounded-lg">
                <i class="fas fa-award"></i>
            </div>
            <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=700&auto=format&fit=crop" class="w-full h-[210px] object-cover rounded-lg" alt="">
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════
     FEATURES GRID
     ══════════════════════════════════════════════════════ -->
<section class="bg-[#f3f3f3] px-6 lg:px-16 py-20">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-14 fade-up">
            <h2 class="text-5xl font-black mb-2"><?= $lang === 'en' ? 'Why Choose Us' : 'لماذا تختارنا' ?></h2>
            <p class="font-black"><?= $lang === 'en' ? 'Features that distinguish us' : 'مميزات تميزنا عن غيرنا' ?></p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($features as $i => $feat): ?>
                <?php
                    $featTitle = $lang === 'en' && !empty($feat->title_en) ? $feat->title_en : ($feat->title ?? '');
                    $featDesc  = $lang === 'en' && !empty($feat->description_en) ? $feat->description_en : ($feat->description ?? '');
                    $featIcon  = $feat->icon ?? 'fas fa-star';
                ?>
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition duration-300 fade-up" style="transition-delay:<?= ($i * 0.08) ?>s">
                    <div class="w-14 h-14 bg-brand rounded-xl mb-5 flex items-center justify-center text-white text-xl">
                        <i class="<?= htmlspecialchars($featIcon) ?>"></i>
                    </div>
                    <h3 class="text-xl font-black mb-3"><?= htmlspecialchars($featTitle) ?></h3>
                    <p class="text-gray-600 leading-relaxed"><?= htmlspecialchars($featDesc) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════
     STATS
     ══════════════════════════════════════════════════════ -->
<section class="bg-brand px-6 lg:px-16 py-16">
    <div class="max-w-7xl mx-auto grid grid-cols-2 lg:grid-cols-4 gap-8 text-center text-dark">
        <?php foreach ($stats as $stat): ?>
            <?php
                $statLabel = $lang === 'en' && !empty($stat->label_en) ? $stat->label_en : ($stat->label ?? '');
                $statValue = preg_replace('/[^0-9]/', '', $stat->value);
                $statSuffix = $stat->suffix ?? '+';
            ?>
            <div class="fade-up">
                <h3 class="text-4xl lg:text-5xl font-black"><span data-count="<?= $statValue ?>" data-suffix="<?= $statSuffix ?>">0</span></h3>
                <p class="font-bold mt-2"><?= htmlspecialchars($statLabel) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

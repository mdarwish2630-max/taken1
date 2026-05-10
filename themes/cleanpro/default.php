<?php
/**
 * CleanPro Theme — Home Page (default.php)
 * Hero + About + Services + Features + Stats + Testimonials + Steps + CTA
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';
$whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
$waNumber = preg_replace('/[^0-9+]/', '', $whatsapp);
$phone    = $tenant->contact_phone ?? '';

$heroImg = 'https://images.unsplash.com/photo-1558317374-067fb5f30001?q=80&w=1800&auto=format&fit=crop';
if (!empty($banners)) {
    $firstBanner = is_array($banners) ? $banners[0] : $banners;
    if (!empty($firstBanner->image)) {
        $heroImg = function_exists('upload') ? upload($firstBanner->image) : $firstBanner->image;
    }
}

$heroTitle = $lang === 'en'
    ? 'Professional Carpet Cleaning Services'
    : 'خدمات تنظيف السجاد الاحترافية';
$heroDesc = $lang === 'en'
    ? 'We provide advanced carpet and upholstery cleaning using modern equipment and safe products for long-lasting results.'
    : 'نقدم حلول تنظيف متقدمة للسجاد والمفروشات باستخدام معدات حديثة ومواد آمنة لنتائج نظيفة تدوم طويلاً.';

if (!empty($banners) && !empty($firstBanner->title)) {
    $heroTitle = $lang === 'en' && !empty($firstBanner->title_en) ? $firstBanner->title_en : $firstBanner->title;
    $heroDesc = $lang === 'en' && !empty($firstBanner->description) ? $firstBanner->description : ($firstBanner->description ?? $heroDesc);
}

$aboutImg1 = 'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?q=80&w=900&auto=format&fit=crop';
$aboutImg2 = 'https://images.unsplash.com/photo-1603712725038-e9334ae8f39f?q=80&w=700&auto=format&fit=crop';

$serviceImages = [
    'https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1621905252507-b35492cc74b4?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1585704032915-c3400ca199e7?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=900&auto=format&fit=crop',
];

$svcIcons = ['fas fa-wind', 'fas fa-spray-can', 'fas fa-broom', 'fas fa-soap', 'fas fa-fan', 'fas fa-hand-sparkles'];

require_once __DIR__ . '/partials/_head.php';
require_once __DIR__ . '/partials/_navbar.php';
?>

<!-- ═══════ HERO ═══════ -->
<section class="cpro-hero">
    <img class="cpro-hero-bg" src="<?= htmlspecialchars($heroImg) ?>" alt="hero">
    <div class="cpro-container">
        <div class="cpro-hero-content">
            <h1><?= htmlspecialchars($heroTitle) ?></h1>
            <p><?= htmlspecialchars($heroDesc) ?></p>
            <a href="<?= url($siteBase . '/contact') ?>" class="cpro-btn cpro-btn-white">
                <?= $lang === 'en' ? 'Get a Quote' : 'احصل على عرض سعر' ?>
            </a>
            <div class="cpro-slider-dots"><span class="active"></span><span></span><span></span></div>
        </div>
    </div>
    <?php if ($phone): ?>
    <div class="cpro-call-card">
        <div class="icon"><i class="fas fa-phone-alt"></i></div>
        <div>
            <small><?= $lang === 'en' ? 'Call Us Now' : 'تواصل معنا الآن' ?></small>
            <b><?= htmlspecialchars($phone) ?></b>
        </div>
    </div>
    <?php endif; ?>
</section>

<!-- ═══════ ABOUT ═══════ -->
<section class="cpro-section" style="padding-top:112px">
    <div class="cpro-container cpro-split">
        <div class="cpro-image-stack">
            <img class="main-img" src="<?= htmlspecialchars($aboutImg1) ?>" alt="about">
            <img class="small-img" src="<?= htmlspecialchars($aboutImg2) ?>" alt="equipment">
        </div>
        <div>
            <p class="cpro-eyebrow"><?= $lang === 'en' ? 'Welcome to Our Company' : 'مرحباً بكم في شركتنا' ?></p>
            <h2 class="cpro-title"><?= $lang === 'en'
                ? 'We Are the Global Leaders in Carpet Cleaning Service'
                : 'نحن رواد خدمات تنظيف السجاد في المملكة' ?></h2>
            <?php if (!empty($page->content)): ?>
                <p class="cpro-subtitle" style="margin:0"><?= htmlspecialchars($page->content) ?></p>
            <?php else: ?>
                <p class="cpro-subtitle" style="margin:0"><?= $lang === 'en'
                    ? 'We provide high-quality carpet cleaning services using advanced technology and eco-friendly solutions to protect your carpet and family.'
                    : 'نقدم خدمات تنظيف السجاد باحترافية عالية مع استخدام تقنيات حديثة ومواد صديقة للبيئة للحفاظ على جودة السجاد وصحة العائلة.' ?></p>
            <?php endif; ?>
            <ul class="cpro-check-list">
                <li><i class="fas fa-check-circle"></i><?= $lang === 'en' ? 'Advanced cleaning equipment' : 'معدات تنظيف حديثة ومتطورة' ?></li>
                <li><i class="fas fa-check-circle"></i><?= $lang === 'en' ? 'Eco-friendly cleaning solutions' : 'حلول آمنة وصديقة للبيئة' ?></li>
                <li><i class="fas fa-check-circle"></i><?= $lang === 'en' ? 'Professional and trained team' : 'فريق محترف ومدرب' ?></li>
                <li><i class="fas fa-check-circle"></i><?= $lang === 'en' ? '100% customer satisfaction' : 'رضا العملاء مضمون' ?></li>
            </ul>
            <?php if (!empty($siteStats) && count($siteStats) > 0): ?>
            <div class="cpro-stats-row">
                <?php foreach (array_slice($siteStats, 0, 1) as $stat): ?>
                    <div class="cpro-circle-stat"><?= htmlspecialchars($stat->value ?? '12+') ?></div>
                    <strong><?= htmlspecialchars(($lang === 'en' && !empty($stat->label_en)) ? $stat->label_en : ($stat->label ?? '')) ?></strong>
                <?php endforeach; ?>
                <a class="cpro-btn" href="<?= url($siteBase . '/about') ?>"><?= $lang === 'en' ? 'Learn More' : 'اقرأ المزيد' ?></a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ═══════ SERVICES ═══════ -->
<section class="cpro-section" style="background:var(--light)">
    <div class="cpro-container cpro-center">
        <p class="cpro-eyebrow"><?= $lang === 'en' ? 'Our Services' : 'خدماتنا' ?></p>
        <h2 class="cpro-title"><?= $lang === 'en'
            ? 'Offering High Quality Carpet Cleaning Services'
            : 'نقدم خدمات تنظيف سجاد عالية الجودة' ?></h2>
        <?php if (empty($services)): ?>
            <?php for ($i = 0; $i < 3; $i++):
                $titles = [
                    ['ar' => 'تنظيف بالبخار', 'en' => 'Steam Cleaning'],
                    ['ar' => 'تنظيف جاف', 'en' => 'Dry Cleaning'],
                    ['ar' => 'إزالة البقع', 'en' => 'Stain Removal'],
                ];
                $descs = [
                    ['ar' => 'إزالة عميقة للأتربة والبقع مع تعقيم فعال.', 'en' => 'Deep removal of dirt and stains with effective sanitizing.'],
                    ['ar' => 'حل مثالي للسجاد الحساس وسريع الجفاف.', 'en' => 'Ideal for delicate carpets with fast drying results.'],
                    ['ar' => 'معالجة احترافية للبقع الصعبة والروائح.', 'en' => 'Professional treatment for tough stains and odors.'],
                ];
                $t = $titles[$i]; $d = $descs[$i];
            ?>
                <div class="cpro-service-card">
                    <img src="<?= $serviceImages[$i] ?>" alt="<?= htmlspecialchars($lang === 'en' ? $t['en'] : $t['ar']) ?>" loading="lazy">
                    <div class="sicon"><i class="<?= $svcIcons[$i] ?>"></i></div>
                    <h3><?= htmlspecialchars($lang === 'en' ? $t['en'] : $t['ar']) ?></h3>
                    <p><?= htmlspecialchars($lang === 'en' ? $d['en'] : $d['ar']) ?></p>
                </div>
            <?php endfor; ?>
        <?php else: ?>
            <div class="cpro-cards">
                <?php foreach ($services as $i => $svc):
                    $svcTitle = $lang === 'en' && !empty($svc->title_en) ? $svc->title_en : ($svc->title ?? '');
                    $svcDesc  = $lang === 'en' && !empty($svc->description_en) ? $svc->description_en : ($svc->description ?? '');
                    $svcImg   = !empty($svc->image) ? (function_exists('upload') ? upload($svc->image) : $svc->image) : ($serviceImages[$i % count($serviceImages)] ?? '');
                    $svcIcon  = $svc->icon ?? $svcIcons[$i % count($svcIcons)];
                    $svcPrice = !empty($svc->price) ? $svc->price : '';
                ?>
                    <div class="cpro-service-card">
                        <?php if ($svcImg): ?>
                            <img src="<?= htmlspecialchars($svcImg) ?>" alt="<?= htmlspecialchars($svcTitle) ?>" loading="lazy">
                        <?php endif; ?>
                        <div class="sicon"><i class="<?= htmlspecialchars($svcIcon) ?>"></i></div>
                        <h3><?= htmlspecialchars($svcTitle) ?></h3>
                        <p><?= htmlspecialchars($svcDesc) ?></p>
                        <div class="card-actions">
                            <a href="<?= url($siteBase . '/service/' . ($svc->slug ?? 'service-' . ($i + 1))) ?>" class="cpro-btn" style="padding:10px 20px;font-size:13px">
                                <?= $lang === 'en' ? 'Details' : 'التفاصيل' ?>
                            </a>
                            <a href="https://wa.me/<?= $waNumber ?>?text=<?= urlencode($svcTitle) ?>" target="_blank" class="cpro-btn" style="padding:10px 20px;font-size:13px;background:#25D366">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- ═══════ WHY CHOOSE US ═══════ -->
<?php if (!empty($siteFeatures) && count($siteFeatures) > 0): ?>
<section class="cpro-section">
    <div class="cpro-container cpro-center">
        <p class="cpro-eyebrow"><?= $lang === 'en' ? 'Our Features' : 'مميزاتنا' ?></p>
        <h2 class="cpro-title"><?= $lang === 'en'
            ? 'We Are the Global Leaders in Carpet Cleaning Service'
            : 'نحن رواد خدمات تنظيف السجاد عالمياً' ?></h2>
        <div class="cpro-why-cards">
            <?php foreach (array_slice($siteFeatures, 0, 4) as $feat):
                $featTitle = $lang === 'en' && !empty($feat->title_en) ? $feat->title_en : ($feat->title ?? '');
                $featDesc  = $lang === 'en' && !empty($feat->description_en) ? $feat->description_en : ($feat->description ?? '');
                $featIcon  = $feat->icon ?? 'fas fa-star';
            ?>
                <div class="cpro-why-card">
                    <span><i class="<?= htmlspecialchars($featIcon) ?>"></i></span>
                    <h3><?= htmlspecialchars($featTitle) ?></h3>
                    <p><?= htmlspecialchars($featDesc) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ═══════ STATS BAND ═══════ -->
<?php if (!empty($siteStats) && count($siteStats) > 0): ?>
<section class="cpro-dark-band">
    <div class="cpro-container cpro-band-grid">
        <div>
            <h2 class="cpro-title" style="color:#fff"><?= $lang === 'en'
                ? 'Professional Carpet Cleaning Services'
                : 'خدمات تنظيف سجاد احترافية' ?></h2>
            <a href="<?= url($siteBase . '/booking') ?>" class="cpro-btn cpro-btn-white" style="margin-top:20px"><?= $lang === 'en' ? 'Book Now' : 'احجز الآن' ?></a>
        </div>
        <div>
            <div class="cpro-stat-cards">
                <?php foreach (array_slice($siteStats, 0, 4) as $stat):
                    $statLabel = $lang === 'en' && !empty($stat->label_en) ? $stat->label_en : ($stat->label ?? '');
                ?>
                    <div class="cpro-stat-card">
                        <b><?= htmlspecialchars($stat->value ?? '0') ?></b>
                        <p><?= htmlspecialchars($statLabel) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="cpro-blue-cta">
                <strong><?= $lang === 'en'
                    ? 'A leading carpet cleaning company bringing professionalism to everything we do'
                    : 'شركة تنظيف سجاد رائدة تجمع الاحترافية والجودة' ?></strong>
                <a href="<?= url($siteBase . '/contact') ?>" class="cpro-btn cpro-btn-white"><?= $lang === 'en' ? 'Book Now' : 'احجز الآن' ?></a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ═══════ TESTIMONIALS ═══════ -->
<?php if (!empty($testimonials) && count($testimonials) > 0): ?>
<section class="cpro-section" style="background:#f8fafc">
    <div class="cpro-container cpro-center">
        <p class="cpro-eyebrow"><?= $lang === 'en' ? 'Customer Feedback' : 'آراء العملاء' ?></p>
        <h2 class="cpro-title"><?= $lang === 'en'
            ? 'We Have Lots of Experience With Our Clients & Their Ratings'
            : 'لدينا الكثير من الخبرة مع عملائنا وتقييماتهم' ?></h2>
        <div class="cpro-testimonial-grid">
            <?php foreach (array_slice($testimonials, 0, 4) as $tst):
                $tstContent = $lang === 'en' && !empty($tst->content_en) ? $tst->content_en : ($tst->content ?? '');
                $tstName = $tst->client_name ?? '';
                $tstTitle = $lang === 'en' && !empty($tst->client_title_en) ? $tst->client_title_en : ($tst->client_title ?? '');
                $tstImg = !empty($tst->client_image) ? (function_exists('upload') ? upload($tst->client_image) : $tst->client_image) : '';
                $rating = !empty($tst->rating) ? intval($tst->rating) : 5;
                $stars = str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);
            ?>
                <div class="cpro-testimonial">
                    <div class="cpro-stars"><?= $stars ?></div>
                    <p><?= htmlspecialchars($tstContent) ?></p>
                    <div class="cpro-user">
                        <?php if ($tstImg): ?>
                            <img class="cpro-avatar" src="<?= htmlspecialchars($tstImg) ?>" alt="<?= htmlspecialchars($tstName) ?>">
                        <?php else: ?>
                            <div class="cpro-avatar" style="background:var(--blue);color:#fff;display:grid;place-items:center;border-radius:50%;font-weight:900"><?= mb_substr($tstName, 0, 1) ?></div>
                        <?php endif; ?>
                        <div>
                            <b><?= htmlspecialchars($tstName) ?></b>
                            <?php if ($tstTitle): ?><span style="color:var(--muted);font-size:13px;display:block;margin-inline-start:12px"><?= htmlspecialchars($tstTitle) ?></span><?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ═══════ GALLERY ═══════ -->
<?php if (!empty($gallery) && count($gallery) > 0): ?>
<section class="cpro-section">
    <div class="cpro-container cpro-center">
        <p class="cpro-eyebrow"><?= $lang === 'en' ? 'Our Work' : 'أعمالنا' ?></p>
        <h2 class="cpro-title"><?= $lang === 'en'
            ? 'Check Now Our Successful Professional Work'
            : 'شاهد أعمالنا الاحترافية الناجحة' ?></h2>
        <div class="cpro-gallery-grid">
            <?php foreach (array_slice($gallery, 0, 6) as $img):
                $galTitle = $lang === 'en' && !empty($img->title_en) ? $img->title_en : ($img->title ?? '');
                $galImg = !empty($img->image) ? (function_exists('upload') ? upload($img->image) : $img->image) : '';
            ?>
                <div class="cpro-gallery-item">
                    <?php if ($galImg): ?>
                        <img src="<?= htmlspecialchars($galImg) ?>" alt="<?= htmlspecialchars($galTitle) ?>" loading="lazy">
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="<?= url($siteBase . '/gallery') ?>" class="cpro-btn" style="margin-top:30px"><?= $lang === 'en' ? 'View More' : 'مشاهدة المزيد' ?></a>
    </div>
</section>
<?php endif; ?>

<!-- ═══════ STEPS ═══════ -->
<section class="cpro-section" style="padding-top:40px">
    <div class="cpro-container cpro-center">
        <p class="cpro-eyebrow"><?= $lang === 'en' ? 'Easy Steps' : 'خطوات سهلة' ?></p>
        <h2 class="cpro-title"><?= $lang === 'en' ? 'Follow 4 Easy Steps' : 'اتبع 4 خطوات بسيطة' ?></h2>
        <div class="cpro-step-grid">
            <?php
            $steps = $lang === 'en' ? [
                ['icon' => 'fas fa-comments', 'title' => 'Contact Us', 'desc' => 'Get in touch with us'],
                ['icon' => 'fas fa-calendar-check', 'title' => 'Choose Date', 'desc' => 'Pick your preferred time'],
                ['icon' => 'fas fa-broom', 'title' => 'We Clean', 'desc' => 'Professional cleaning'],
                ['icon' => 'fas fa-thumbs-up', 'title' => 'Enjoy Result', 'desc' => 'Clean and fresh result'],
            ] : [
                ['icon' => 'fas fa-comments', 'title' => 'تواصل معنا', 'desc' => 'تواصل وسنرد عليك فوراً'],
                ['icon' => 'fas fa-calendar-check', 'title' => 'حدد موعدك', 'desc' => 'اختر الوقت المناسب لك'],
                ['icon' => 'fas fa-broom', 'title' => 'ننفذ الخدمة', 'desc' => 'فريق محترف ينفذ العمل'],
                ['icon' => 'fas fa-thumbs-up', 'title' => 'استمتع بالنتيجة', 'desc' => 'استمتع بنتيجة نظيفة'],
            ];
            foreach ($steps as $step): ?>
                <div class="cpro-step">
                    <span><i class="<?= $step['icon'] ?>"></i></span>
                    <h4><?= htmlspecialchars($step['title']) ?></h4>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════ FINAL CTA ═══════ -->
<section class="cpro-section cpro-center">
    <h2 class="cpro-title"><?= $lang === 'en'
        ? 'Get Professional & Affordable Carpet Cleaning Today'
        : 'احصل على تنظيف سجاد احترافي وبسعر مناسب اليوم' ?></h2>
    <div style="display:flex;justify-content:center;gap:14px;margin-top:24px;flex-wrap:wrap">
        <a href="<?= url($siteBase . '/booking') ?>" class="cpro-btn"><?= $lang === 'en' ? 'Book Now' : 'احجز الآن' ?></a>
        <?php if ($waNumber): ?>
        <a href="https://wa.me/<?= $waNumber ?>" target="_blank" class="cpro-btn" style="background:#25D366">
            <i class="fab fa-whatsapp"></i> WhatsApp
        </a>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/partials/_footer.php'; ?>
<?php require_once __DIR__ . '/partials/_scripts.php'; ?>

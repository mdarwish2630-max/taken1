<?php
/**
 * CleanPro Theme — About Page
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';

$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'About Us' : 'من نحن'));
$pageContent = $lang === 'en' && !empty($page->content_en) ? $page->content_en : ($page->content ?? '');

$aboutImg1 = 'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?q=80&w=900&auto=format&fit=crop';
$aboutImg2 = 'https://images.unsplash.com/photo-1603712725038-e9334ae8f39f?q=80&w=700&auto=format&fit=crop';

require_once __DIR__ . '/partials/_head.php';
require_once __DIR__ . '/partials/_navbar.php';
?>

<!-- Breadcrumb -->
<div class="cpro-breadcrumb">
    <div class="cpro-container" style="display:flex;align-items:center;gap:4px">
        <a href="<?= url($siteBase) ?>"><?= $lang === 'en' ? 'Home' : 'الرئيسية' ?></a>
        <i class="fas fa-chevron-<?= $isRtl ? 'left' : 'right' ?>"></i>
        <span class="current"><?= htmlspecialchars($pageTitle) ?></span>
    </div>
</div>

<!-- About -->
<section class="cpro-section" style="padding-top:60px">
    <div class="cpro-container cpro-split">
        <div class="cpro-image-stack">
            <img class="main-img" src="<?= htmlspecialchars($aboutImg1) ?>" alt="about">
            <img class="small-img" src="<?= htmlspecialchars($aboutImg2) ?>" alt="team">
        </div>
        <div>
            <p class="cpro-eyebrow"><?= $lang === 'en' ? 'Who We Are' : 'من نحن' ?></p>
            <h1 class="cpro-title"><?= htmlspecialchars($pageTitle) ?></h1>
            <?php if ($pageContent): ?>
                <p class="cpro-subtitle" style="margin:0 0 24px"><?= htmlspecialchars($pageContent) ?></p>
            <?php else: ?>
                <p class="cpro-subtitle" style="margin:0 0 24px"><?= $lang === 'en'
                    ? 'We are a professional carpet cleaning company with over 12 years of experience serving homes and businesses across the region.'
                    : 'نحن شركة تنظيف سجاد احترافية بخبرة تزيد عن 12 عاماً في خدمة المنازل والشركات في المنطقة.' ?></p>
            <?php endif; ?>
            <ul class="cpro-check-list">
                <li><i class="fas fa-check-circle"></i><?= $lang === 'en' ? 'Advanced cleaning equipment' : 'معدات تنظيف حديثة ومتطورة' ?></li>
                <li><i class="fas fa-check-circle"></i><?= $lang === 'en' ? 'Eco-friendly cleaning solutions' : 'حلول آمنة وصديقة للبيئة' ?></li>
                <li><i class="fas fa-check-circle"></i><?= $lang === 'en' ? 'Professional and trained team' : 'فريق محترف ومدرب' ?></li>
                <li><i class="fas fa-check-circle"></i><?= $lang === 'en' ? '100% customer satisfaction' : 'رضا العملاء مضمون' ?></li>
                <li><i class="fas fa-check-circle"></i><?= $lang === 'en' ? 'Affordable pricing' : 'أسعار تنافسية' ?></li>
                <li><i class="fas fa-check-circle"></i><?= $lang === 'en' ? 'Fast and reliable service' : 'خدمة سريعة وموثوقة' ?></li>
            </ul>
            <?php if (!empty($siteStats) && count($siteStats) > 0): ?>
            <div class="cpro-stats-row">
                <?php foreach (array_slice($siteStats, 0, 3) as $stat):
                    $statLabel = $lang === 'en' && !empty($stat->label_en) ? $stat->label_en : ($stat->label ?? '');
                ?>
                    <div class="cpro-circle-stat"><?= htmlspecialchars($stat->value ?? '0') ?></div>
                    <strong style="font-size:13px"><?= htmlspecialchars($statLabel) ?></strong>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Features -->
<?php if (!empty($siteFeatures) && count($siteFeatures) > 0): ?>
<section class="cpro-section" style="background:var(--light)">
    <div class="cpro-container cpro-center">
        <p class="cpro-eyebrow"><?= $lang === 'en' ? 'Why Choose Us' : 'لماذا تختارنا' ?></p>
        <h2 class="cpro-title"><?= $lang === 'en' ? 'Our Key Advantages' : 'مميزاتنا الرئيسية' ?></h2>
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

<!-- Testimonials -->
<?php if (!empty($testimonials) && count($testimonials) > 0): ?>
<section class="cpro-section" style="background:#f8fafc">
    <div class="cpro-container cpro-center">
        <p class="cpro-eyebrow"><?= $lang === 'en' ? 'Testimonials' : 'آراء العملاء' ?></p>
        <h2 class="cpro-title"><?= $lang === 'en' ? 'What Our Clients Say' : 'ماذا يقول عملاؤنا' ?></h2>
        <div class="cpro-testimonial-grid">
            <?php foreach (array_slice($testimonials, 0, 4) as $tst):
                $tstContent = $lang === 'en' && !empty($tst->content_en) ? $tst->content_en : ($tst->content ?? '');
                $tstName = $tst->client_name ?? '';
                $tstImg = !empty($tst->client_image) ? (function_exists('upload') ? upload($tst->client_image) : $tst->client_image) : '';
                $rating = !empty($tst->rating) ? intval($tst->rating) : 5;
                $stars = str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);
            ?>
                <div class="cpro-testimonial">
                    <div class="cpro-stars"><?= $stars ?></div>
                    <p><?= htmlspecialchars($tstContent) ?></p>
                    <div class="cpro-user">
                        <?php if ($tstImg): ?>
                            <img class="cpro-avatar" src="<?= htmlspecialchars($tstImg) ?>" alt="">
                        <?php else: ?>
                            <div class="cpro-avatar" style="background:var(--blue);color:#fff;display:grid;place-items:center;border-radius:50%;font-weight:900"><?= mb_substr($tstName, 0, 1) ?></div>
                        <?php endif; ?>
                        <b><?= htmlspecialchars($tstName) ?></b>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php require_once __DIR__ . '/partials/_footer.php'; ?>
<?php require_once __DIR__ . '/partials/_scripts.php'; ?>

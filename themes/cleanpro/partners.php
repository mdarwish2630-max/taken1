<?php
/**
 * CleanPro Theme — Partners Page
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';

$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'Our Partners' : 'شركاؤنا'));

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

<section class="cpro-section">
    <div class="cpro-container cpro-center">
        <p class="cpro-eyebrow"><?= $lang === 'en' ? 'Trusted By' : 'يثقون بنا' ?></p>
        <h1 class="cpro-title"><?= htmlspecialchars($pageTitle) ?></h1>
        <p class="cpro-subtitle"><?= $lang === 'en'
            ? 'We are proud to work with leading companies and organizations across the region.'
            : 'نفخر بالعمل مع شركات ومؤسسات رائدة في المنطقة.' ?></p>

        <?php if (!empty($partnerItems) && count($partnerItems) > 0): ?>
        <div class="cpro-partners-grid">
            <?php foreach ($partnerItems as $partner):
                $pName = $lang === 'en' && !empty($partner->name_en) ? $partner->name_en : ($partner->name ?? '');
                $pLogo = !empty($partner->logo) ? (function_exists('upload') ? upload($partner->logo) : $partner->logo) : '';
            ?>
                <div class="cpro-partner-card">
                    <?php if ($pLogo): ?>
                        <img src="<?= htmlspecialchars($pLogo) ?>" alt="<?= htmlspecialchars($pName) ?>">
                    <?php else: ?>
                        <span style="font-weight:900;color:var(--blue);font-size:14px"><?= htmlspecialchars($pName) ?></span>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <!-- Fallback partners -->
        <div class="cpro-partners-grid">
            <?php for ($i = 1; $i <= 8; $i++): ?>
                <div class="cpro-partner-card">
                    <span style="font-weight:900;color:var(--blue);font-size:14px">Partner <?= $i ?></span>
                </div>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Stats -->
<?php if (!empty($siteStats) && count($siteStats) > 0): ?>
<section class="cpro-dark-band">
    <div class="cpro-container">
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
    </div>
</section>
<?php endif; ?>

<?php require_once __DIR__ . '/partials/_footer.php'; ?>
<?php require_once __DIR__ . '/partials/_scripts.php'; ?>

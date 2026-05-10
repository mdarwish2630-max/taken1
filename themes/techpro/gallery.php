<?php
/**
 * Tek Pro Theme — Gallery Page
 * Light theme + Orange accents
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';

$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'Gallery' : 'معرض الصور'));
$pageContent = $lang === 'en' && !empty($page->content_en) ? $page->content_en : ($page->content ?? '');

$galleryCategories = [];
if (!empty($gallery)) {
    foreach ($gallery as $g) {
        $cat = $g->category ?? '';
        $catEn = $g->category_en ?? '';
        if (!empty($cat) || !empty($catEn)) {
            $key = $cat ?: $catEn;
            if (!isset($galleryCategories[$key])) {
                $galleryCategories[$key] = (object)['label' => $cat, 'label_en' => $catEn];
            }
        }
    }
}

if (empty($gallery)) {
    $fallbackCats = ['تقني', 'شبكات', 'صيانة', 'تطوير'];
    $fallbackCatsEn = ['Technical', 'Networks', 'Maintenance', 'Development'];
    $fallbackTitles = [
        ['مشروع صيانة شامل', 'Full maintenance project'],
        ['تركيب شبكات متقدمة', 'Advanced network installation'],
        ['صيانة أجهزة', 'Device maintenance'],
        ['تطوير نظام جديد', 'New system development'],
        ['تصميم داخلي', 'Interior design'],
        ['تركيب كاميرات مراقبة', 'Security cameras installation'],
        ['صيانة خوادم', 'Server maintenance'],
        ['مشروع تطوير ويب', 'Web development project'],
    ];
    $gallery = [];
    foreach ($fallbackTitles as $i => $ft) {
        $ci = $i % 4;
        $gallery[] = (object)['id' => 0, 'image' => '', 'title' => $ft[0], 'title_en' => $ft[1], 'category' => $fallbackCats[$ci], 'category_en' => $fallbackCatsEn[$ci]];
    }
    foreach ($fallbackCats as $ci => $cat) {
        $galleryCategories[$cat] = (object)['label' => $cat, 'label_en' => $fallbackCatsEn[$ci]];
    }
}

require_once __DIR__ . '/_head.php';
require_once __DIR__ . '/_navbar.php';
?>

<!-- ═══════ PAGE HEADER ═══════ -->
<section class="bg-[#f3f3f3] px-6 lg:px-16 py-16">
    <div class="max-w-4xl mx-auto fade-up">
        <p class="text-[#ff7a00] font-black mb-3"><?= $lang === 'en' ? 'Gallery' : 'معرض الصور' ?></p>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight mb-6"><?= htmlspecialchars($pageTitle) ?></h1>
        <?php if (!empty($pageContent)): ?>
            <p class="text-gray-600 text-lg leading-relaxed max-w-3xl"><?= $pageContent ?></p>
        <?php else: ?>
            <p class="text-gray-600 text-lg leading-relaxed max-w-3xl">
                <?= $lang === 'en' ? 'Browse our gallery of completed projects.' : 'تصفح معرض صور أعمالنا المنجزة.' ?>
            </p>
        <?php endif; ?>
    </div>
</section>

<!-- ═══════ FILTER TABS ═══════ -->
<?php if (!empty($galleryCategories) && count($galleryCategories) > 1): ?>
<section class="px-6 lg:px-16 pb-8 fade-up">
    <div class="max-w-7xl mx-auto flex flex-wrap gap-3 justify-center">
        <button data-gallery-filter="all"
                class="gallery-filter-btn rounded-full px-5 py-2.5 text-sm font-bold transition bg-[#ff7a00]/10 border border-[#ff7a00]/30 text-[#ff7a00] active-filter">
            <?= $lang === 'en' ? 'All' : 'الكل' ?>
        </button>
        <?php foreach ($galleryCategories as $catKey => $cat): ?>
            <?php $catLabel = $lang === 'en' && !empty($cat->label_en) ? $cat->label_en : ($cat->label ?? ''); ?>
            <button data-gallery-filter="<?= htmlspecialchars($catKey) ?>"
                    class="gallery-filter-btn rounded-full px-5 py-2.5 text-sm font-bold text-gray-500 transition bg-[#f5f5f5] border border-transparent hover:border-[#ff7a00]/30 hover:text-[#ff7a00]">
                <?= htmlspecialchars($catLabel) ?>
            </button>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ═══════ GALLERY GRID ═══════ -->
<section class="px-6 lg:px-16 py-8 pb-20">
    <?php if (!empty($gallery)): ?>
        <div id="galleryGrid" class="max-w-7xl mx-auto columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-6 space-y-6">
            <?php foreach ($gallery as $i => $item):
                $imgTitle = $lang === 'en' && !empty($item->title_en) ? $item->title_en : ($item->title ?? '');
                $imgSrc   = !empty($item->image) ? (function_exists('upload') ? upload($item->image) : $item->image) : '';
                $imgCat   = $item->category ?? '';
                $heights = ['h-56', 'h-72', 'h-64', 'h-80', 'h-60', 'h-48'];
                $imgH    = $heights[$i % count($heights)];
            ?>
                <div class="gallery-item break-inside-avoid group relative rounded-lg overflow-hidden shadow-lg transition-all duration-300 hover:-translate-y-1 fade-up"
                     data-category="<?= htmlspecialchars($imgCat) ?>">
                    <?php if ($imgSrc): ?>
                        <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($imgTitle) ?>"
                             class="w-full <?= $imgH ?> object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy">
                    <?php else: ?>
                        <div class="w-full <?= $imgH ?> bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                            <i class="fas fa-image text-4xl text-gray-400"></i>
                        </div>
                    <?php endif; ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
                        <?php if (!empty($imgTitle)): ?>
                            <h3 class="text-lg font-bold text-white mb-1"><?= htmlspecialchars($imgTitle) ?></h3>
                        <?php endif; ?>
                        <?php if (!empty($imgCat)): ?>
                            <span class="text-[#ff7a00] text-sm font-bold"><?= htmlspecialchars($imgCat) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-20 fade-up">
            <div class="w-24 h-24 rounded-full bg-[#f5f5f5] flex items-center justify-center text-4xl mx-auto mb-6">
                <i class="fas fa-camera text-gray-400"></i>
            </div>
            <h3 class="text-2xl font-black text-gray-400 mb-3"><?= $lang === 'en' ? 'No Images Yet' : 'لا توجد صور حالياً' ?></h3>
        </div>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

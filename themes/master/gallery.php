<?php
/**
 * Master Theme — Gallery Page
 * Masonry-like grid of images with hover overlays
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';

// Page title
$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'Gallery' : 'معرض الصور'));
$pageContent = $lang === 'en' && !empty($page->content_en) ? $page->content_en : ($page->content ?? '');

// Extract unique categories from gallery items
$galleryCategories = [];
if (!empty($gallery)) {
    foreach ($gallery as $g) {
        $cat = $g->category ?? '';
        $catEn = $g->category_en ?? '';
        if (!empty($cat) || !empty($catEn)) {
            $key = $cat ?: $catEn;
            if (!isset($galleryCategories[$key])) {
                $galleryCategories[$key] = (object)[
                    'label' => $cat,
                    'label_en' => $catEn,
                ];
            }
        }
    }
}

// ── Fallback gallery data (always show content even if DB is empty) ──
if (empty($gallery)) {
    $fallbackCats = ['كهرباء', 'سباكة', 'تبريد', 'ديكور'];
    $fallbackCatsEn = ['Electrical', 'Plumbing', 'Cooling', 'Decor'];
    $fallbackTitles = [
        ['مشروع صيانة كهرباء شامل', 'Full electrical maintenance project'],
        ['تمديدات كهربائية حديثة', 'Modern electrical wiring'],
        ['إصلاح تسريب مياه', 'Water leak repair'],
        ['صيانة مكيف مركزي', 'Central AC maintenance'],
        ['تشطيب داخلي فاخر', 'Luxury interior finishing'],
        ['دهان واجهات خارجية', 'Exterior painting'],
        ['تركيب أقفال ذكية', 'Smart lock installation'],
        ['مشروع سباكة كامل', 'Complete plumbing project'],
    ];
    $gallery = [];
    foreach ($fallbackTitles as $i => $ft) {
        $ci = $i % 4;
        $gallery[] = (object)[
            'id' => 0,
            'image' => '',
            'title' => $ft[0], 'title_en' => $ft[1],
            'category' => $fallbackCats[$ci], 'category_en' => $fallbackCatsEn[$ci],
        ];
    }
    foreach ($fallbackCats as $ci => $cat) {
        $galleryCategories[$cat] = (object)['label' => $cat, 'label_en' => $fallbackCatsEn[$ci]];
    }
}

require_once __DIR__ . '/_head.php';
require_once __DIR__ . '/_navbar.php';
?>

<!-- Background Effects -->
<div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
    <div class="absolute -top-20 -right-20 w-[500px] h-[500px] bg-cyan-500/15 blur-[120px] rounded-full"></div>
    <div class="absolute -bottom-20 -left-20 w-[500px] h-[500px] bg-blue-500/15 blur-[120px] rounded-full"></div>
</div>

<!-- ═══════ PAGE HEADER ═══════ -->
<section class="relative z-10 px-6 lg:px-20 pt-32 pb-8">
    <div class="max-w-4xl fade-up">
        <div class="inline-flex items-center gap-2 glass rounded-full px-4 py-2 text-sm text-cyan-300 mb-6">
            <i class="fas fa-images text-xs"></i>
            <span><?= $lang === 'en' ? 'Gallery' : 'معرض الصور' ?></span>
        </div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight mb-6">
            <?= htmlspecialchars($pageTitle) ?>
        </h1>
        <?php if (!empty($pageContent)): ?>
            <p class="text-gray-300 text-lg leading-relaxed max-w-3xl"><?= sanitizeHTML($pageContent) ?></p>
        <?php else: ?>
            <p class="text-gray-300 text-lg leading-relaxed max-w-3xl">
                <?= $lang === 'en'
                    ? 'Browse our gallery of completed projects and showcase our quality of work.'
                    : 'تصفح معرض صور أعمالنا المنجزة وشاهد جودة خدماتنا.' ?>
            </p>
        <?php endif; ?>
        <div class="w-24 h-1.5 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full mt-6"></div>
    </div>
</section>

<!-- ═══════ FILTER TABS ═══════ -->
<?php if (!empty($galleryCategories) && count($galleryCategories) > 1): ?>
<section class="relative z-10 px-6 lg:px-20 pb-8 fade-up">
    <div class="flex flex-wrap gap-3 justify-center">
        <button data-gallery-filter="all"
                class="gallery-filter-btn glass rounded-full px-5 py-2.5 text-sm font-semibold transition hover:border-cyan-400/40 active-filter bg-cyan-500/20 border-cyan-400/40 text-cyan-300">
            <?= $lang === 'en' ? 'All' : 'الكل' ?>
        </button>
        <?php foreach ($galleryCategories as $catKey => $cat): ?>
            <?php $catLabel = $lang === 'en' && !empty($cat->label_en) ? $cat->label_en : ($cat->label ?? ''); ?>
            <button data-gallery-filter="<?= htmlspecialchars($catKey) ?>"
                    class="gallery-filter-btn glass rounded-full px-5 py-2.5 text-sm font-semibold text-gray-300 transition hover:border-cyan-400/40 hover:text-cyan-300">
                <?= htmlspecialchars($catLabel) ?>
            </button>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ═══════ GALLERY GRID ═══════ -->
<section class="relative z-10 px-6 lg:px-20 py-8 pb-20">
    <?php if (!empty($gallery)): ?>
        <div id="galleryGrid" class="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-6 space-y-6">
            <?php foreach ($gallery as $i => $item):
                $imgTitle = $lang === 'en' && !empty($item->title_en) ? $item->title_en : ($item->title ?? '');
                $imgSrc   = !empty($item->image) ? function_exists('upload') ? upload($item->image) : $item->image : '';
                $imgCat   = $item->category ?? '';
                // Vary heights for masonry effect
                $heights = ['h-56', 'h-72', 'h-64', 'h-80', 'h-60', 'h-48'];
                $imgH    = $heights[$i % count($heights)];
                // Fallback gradient based on index
                $gradients = [
                    'from-cyan-900/50 to-blue-900/50',
                    'from-purple-900/50 to-indigo-900/50',
                    'from-teal-900/50 to-cyan-900/50',
                    'from-blue-900/50 to-slate-900/50',
                    'from-indigo-900/50 to-purple-900/50',
                ];
                $gradient = $gradients[$i % count($gradients)];
            ?>
                <div class="gallery-item break-inside-avoid group relative rounded-2xl overflow-hidden glow-border transition-all duration-300 hover:-translate-y-1 fade-up"
                     data-category="<?= htmlspecialchars($imgCat) ?>">
                    <?php if ($imgSrc): ?>
                        <img src="<?= htmlspecialchars($imgSrc) ?>"
                             alt="<?= htmlspecialchars($imgTitle) ?>"
                             class="w-full <?= $imgH ?> object-cover transition-transform duration-700 group-hover:scale-110"
                             loading="lazy">
                    <?php else: ?>
                        <div class="w-full <?= $imgH ?> bg-gradient-to-br <?= $gradient ?> flex items-center justify-center">
                            <i class="fas fa-image text-4xl text-white/20"></i>
                        </div>
                    <?php endif; ?>

                    <!-- Hover Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
                        <?php if (!empty($imgTitle)): ?>
                            <h3 class="text-lg font-bold text-white mb-2"><?= htmlspecialchars($imgTitle) ?></h3>
                        <?php endif; ?>
                        <?php if (!empty($imgCat)): ?>
                            <span class="inline-flex items-center gap-1.5 text-cyan-300 text-sm">
                                <i class="fas fa-tag text-xs"></i>
                                <?= htmlspecialchars($imgCat) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (count($gallery) > 12): ?>
            <div class="text-center mt-12 fade-up">
                <button id="galleryLoadMore"
                        class="inline-flex items-center gap-2 glass hover:bg-cyan-500 hover:border-cyan-500 transition rounded-2xl px-8 py-4 font-bold shadow-lg shadow-cyan-500/30">
                    <i class="fas fa-plus"></i>
                    <?= $lang === 'en' ? 'Load More' : 'عرض المزيد' ?>
                </button>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <!-- Empty State -->
        <div class="text-center py-20 fade-up">
            <div class="w-24 h-24 rounded-full bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-4xl mx-auto mb-6">
                <i class="fas fa-camera text-cyan-400/50"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-300 mb-3">
                <?= $lang === 'en' ? 'No Images Yet' : 'لا توجد صور حالياً' ?>
            </h3>
            <p class="text-gray-500 mb-8">
                <?= $lang === 'en' ? 'Gallery images will appear here once they are added.' : 'ستظهر صور المعرض هنا بمجرد إضافتها.' ?>
            </p>
        </div>
    <?php endif; ?>
</section>

<!-- Gallery Filter Script -->
<script>
(() => {
    const filterBtns = document.querySelectorAll('.gallery-filter-btn');
    const items = document.querySelectorAll('.gallery-item');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Update active state
            filterBtns.forEach(b => {
                b.classList.remove('active-filter', 'bg-cyan-500/20', 'border-cyan-400/40', 'text-cyan-300');
                b.classList.add('text-gray-300');
            });
            btn.classList.add('active-filter', 'bg-cyan-500/20', 'border-cyan-400/40', 'text-cyan-300');
            btn.classList.remove('text-gray-300');

            const filter = btn.dataset.galleryFilter;

            items.forEach(item => {
                if (filter === 'all' || item.dataset.category === filter) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
})();
</script>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

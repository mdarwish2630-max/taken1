<?php
/**
 * TakPro Theme — Gallery Page
 */
$siteBase  = $siteBase ?? ('/site/' . ($tenant->slug ?? 'demo'));
$dir       = $dir ?? 'rtl';
$lang      = $lang ?? 'ar';
$isRtl     = ($dir === 'rtl');

/* ── Gallery ── */
$allGallery = [];
if (!empty($gallery)) { foreach ($gallery as $g) { $allGallery[] = $g; } }

/* Fallback images */
$defaultImages = [
    ['src' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=800&auto=format&fit=crop', 'title' => 'خدمة احترافية', 'title_en' => 'Professional Service', 'category' => 'منازل'],
    ['src' => 'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?q=80&w=800&auto=format&fit=crop', 'title' => 'تنظيف منازل', 'title_en' => 'Home Cleaning', 'category' => 'منازل'],
    ['src' => 'https://images.unsplash.com/photo-1585421514284-efb74c2b69ba?q=80&w=800&auto=format&fit=crop', 'title' => 'تعقيم شامل', 'title_en' => 'Full Sanitization', 'category' => 'تعقيم'],
    ['src' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=800&auto=format&fit=crop', 'title' => 'بعد البناء', 'title_en' => 'Post-Construction', 'category' => 'بناء'],
    ['src' => 'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?q=80&w=800&auto=format&fit=crop', 'title' => 'صيانة', 'title_en' => 'Maintenance', 'category' => 'صيانة'],
    ['src' => 'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?q=80&w=800&auto=format&fit=crop', 'title' => 'تنظيف مكاتب', 'title_en' => 'Office Cleaning', 'category' => 'مكاتب'],
    ['src' => 'https://images.unsplash.com/photo-1528744598421-b7b93e12df54?q=80&w=800&auto=format&fit=crop', 'title' => 'زجاج وواجهات', 'title_en' => 'Glass & Facades', 'category' => 'زجاج'],
    ['src' => 'https://images.unsplash.com/photo-1621905252507-b35492cc74b4?q=80&w=800&auto=format&fit=crop', 'title' => 'خدمات متخصصة', 'title_en' => 'Specialized Services', 'category' => 'أخرى'],
];

$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'Gallery' : 'معرض الأعمال'));

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
                ? 'Browse our previous work and see the quality we deliver.'
                : 'تصفح أعمالنا السابقة وشاهد الجودة التي نقدمها.' ?>
        </p>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════
     GALLERY GRID
     ══════════════════════════════════════════════════════ -->
<section class="px-6 lg:px-16 py-20 bg-white">
    <div class="max-w-7xl mx-auto">
        <?php if (!empty($allGallery)): ?>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <?php foreach ($allGallery as $i => $item): ?>
                    <?php
                        $imgTitle = $lang === 'en' && !empty($item->title_en) ? $item->title_en : ($item->title ?? '');
                        $imgSrc = !empty($item->image) ? function_exists('upload') ? upload($item->image) : $item->image : ($defaultImages[$i % count($defaultImages)]['src'] ?? '');
                    ?>
                    <div class="group relative rounded-xl overflow-hidden h-64 fade-up" style="transition-delay:<?= ($i * 0.05) ?>s">
                        <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($imgTitle) ?>"
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-5">
                            <h3 class="text-white font-black"><?= htmlspecialchars($imgTitle) ?></h3>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Default Gallery -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <?php foreach ($defaultImages as $i => $img): ?>
                    <?php $imgTitle = $lang === 'en' ? $img['title_en'] : $img['title']; ?>
                    <div class="group relative rounded-xl overflow-hidden h-64 fade-up" style="transition-delay:<?= ($i * 0.05) ?>s">
                        <img src="<?= htmlspecialchars($img['src']) ?>" alt="<?= htmlspecialchars($imgTitle) ?>"
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-5">
                            <div>
                                <h3 class="text-white font-black"><?= htmlspecialchars($imgTitle) ?></h3>
                                <span class="text-brand text-sm font-bold"><?= htmlspecialchars($img['category']) ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

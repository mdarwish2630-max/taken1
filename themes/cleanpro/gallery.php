<?php
/**
 * CleanPro Theme — Gallery Page
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';

$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'Gallery' : 'المعرض'));

if (empty($gallery)) {
    $gallery = [
        (object)['id'=>0,'image'=>'','title'=>'تنظيف سجاد منزلي','title_en'=>'Home Carpet Cleaning','category'=>'منازل','category_en'=>'Homes'],
        (object)['id'=>0,'image'=>'','title'=>'تنظيف سجاد مكاتب','title_en'=>'Office Carpet Cleaning','category'=>'مكاتب','category_en'=>'Offices'],
        (object)['id'=>0,'image'=>'','title'=>'تنظيف كنب','title_en'=>'Sofa Cleaning','category'=>'كنب','category_en'=>'Upholstery'],
        (object)['id'=>0,'image'=>'','title'=>'تنظيف ستائر','title_en'=>'Curtain Cleaning','category'=>'ستائر','category_en'=>'Curtains'],
        (object)['id'=>0,'image'=>'','title'=>'إزالة بقع','title_en'=>'Stain Removal','category'=>'بقع','category_en'=>'Stains'],
        (object)['id'=>0,'image'=>'','title'=>'تنظيف بالبخار','title_en'=>'Steam Cleaning','category'=>'بخار','category_en'=>'Steam'],
    ];
}

$galleryImages = [
    'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?q=80&w=800&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=800&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?q=80&w=800&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1621905252507-b35492cc74b4?q=80&w=800&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1585421514284-efb74c2b69ba?q=80&w=800&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?q=80&w=800&auto=format&fit=crop',
];

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
        <p class="cpro-eyebrow"><?= $lang === 'en' ? 'Our Work' : 'أعمالنا' ?></p>
        <h1 class="cpro-title"><?= htmlspecialchars($pageTitle) ?></h1>
        <p class="cpro-subtitle"><?= $lang === 'en'
            ? 'Browse our portfolio of completed carpet cleaning projects.'
            : 'تصفح معرض أعمالنا المنجزة في تنظيف السجاد.' ?></p>

        <div class="cpro-gallery-grid">
            <?php foreach ($gallery as $i => $img):
                $galTitle = $lang === 'en' && !empty($img->title_en) ? $img->title_en : ($img->title ?? '');
                $galImg = !empty($img->image) ? (function_exists('upload') ? upload($img->image) : $img->image) : ($galleryImages[$i % count($galleryImages)] ?? '');
                $galCat = $lang === 'en' && !empty($img->category_en) ? $img->category_en : ($img->category ?? '');
            ?>
                <div class="cpro-gallery-item">
                    <img src="<?= htmlspecialchars($galImg) ?>" alt="<?= htmlspecialchars($galTitle) ?>" loading="lazy">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/partials/_footer.php'; ?>
<?php require_once __DIR__ . '/partials/_scripts.php'; ?>

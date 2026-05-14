<?php
/**
 * TakPro Theme — Blog Listing Page
 */
$siteBase = $siteBase ?? (BASE_PATH . '/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';
$posts    = $posts ?? [];
$categories = $categories ?? [];
$current_category = $current_category ?? '';

require_once __DIR__ . '/_head.php';
require_once __DIR__ . '/_navbar.php';
?>

<!-- ═══════ BLOG HERO ═══════ -->
<section class="relative bg-gradient-to-br from-[#ff7a00] to-[#e06e00] px-6 lg:px-16 py-20 text-white overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 right-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 left-10 w-96 h-96 bg-white rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-4xl mx-auto relative z-10 fade-up">
        <h1 class="text-4xl sm:text-5xl font-black mb-4"><?= $lang === 'en' ? 'Our Blog' : 'المدونة' ?></h1>
        <p class="text-lg text-white/90 max-w-xl"><?= $lang === 'en' ? 'Discover our latest articles, tips, and news' : 'اكتشف أحدث المقالات والنصائح والأخبار' ?></p>
    </div>
</section>

<?php if (!empty($categories)): ?>
<!-- ═══════ CATEGORIES ═══════ -->
<section class="px-6 lg:px-16 py-6 border-b">
    <div class="max-w-7xl mx-auto flex flex-wrap gap-3">
        <a href="<?= url($siteBase . '/blog') ?>"
           class="px-5 py-2 rounded-full text-sm font-bold transition <?= empty($current_category) ? 'bg-brand text-white shadow-lg shadow-brand/30' : 'bg-gray-100 text-gray-600 hover:bg-brand/10 hover:text-brand' ?>">
            <?= $lang === 'en' ? 'All' : 'الكل' ?>
        </a>
        <?php foreach ($categories as $cat): ?>
        <a href="<?= url($siteBase . '/blog?category=' . urlencode($cat)) ?>"
           class="px-5 py-2 rounded-full text-sm font-bold transition <?= ($current_category === $cat) ? 'bg-brand text-white shadow-lg shadow-brand/30' : 'bg-gray-100 text-gray-600 hover:bg-brand/10 hover:text-brand' ?>">
            <?= htmlspecialchars($cat) ?>
        </a>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ═══════ BLOG GRID ═══════ -->
<section class="px-6 lg:px-16 py-14">
    <div class="max-w-7xl mx-auto">
        <?php if (!empty($posts)): ?>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($posts as $post): ?>
            <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-400 hover:-translate-y-2 fade-up group">
                <a href="<?= url($siteBase . '/blog/' . ($post->slug ?? $post->id)) ?>" class="block overflow-hidden">
                    <div class="h-52 bg-gray-100">
                        <?php if (!empty($post->image)): ?>
                        <img src="<?= upload($post->image) ?>" alt="<?= e($post->title) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-gray-300 text-5xl"><i class="fas fa-newspaper"></i></div>
                        <?php endif; ?>
                    </div>
                </a>
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-3 text-xs text-gray-400">
                        <?php if (!empty($post->category)): ?>
                        <span class="bg-brand/10 text-brand px-3 py-1 rounded-full font-bold"><?= htmlspecialchars($post->category) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($post->created_at)): ?>
                        <span><i class="fas fa-calendar mr-1"></i><?= date('Y/m/d', strtotime($post->created_at)) ?></span>
                        <?php endif; ?>
                    </div>
                    <h3 class="text-lg font-black text-dark mb-3 line-clamp-2">
                        <a href="<?= url($siteBase . '/blog/' . ($post->slug ?? $post->id)) ?>" class="hover:text-brand transition"><?= htmlspecialchars($post->title) ?></a>
                    </h3>
                    <?php if (!empty($post->excerpt)): ?>
                    <p class="text-gray-500 text-sm line-clamp-2"><?= htmlspecialchars(truncate($post->excerpt, 120)) ?></p>
                    <?php elseif (!empty($post->content)): ?>
                    <p class="text-gray-500 text-sm line-clamp-2"><?= htmlspecialchars(truncate(strip_tags($post->content), 120)) ?></p>
                    <?php endif; ?>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-20 fade-up">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6"><i class="fas fa-newspaper text-4xl text-gray-300"></i></div>
            <h3 class="text-2xl font-black text-gray-400 mb-2"><?= $lang === 'en' ? 'No Posts Yet' : 'لا توجد مقالات بعد' ?></h3>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

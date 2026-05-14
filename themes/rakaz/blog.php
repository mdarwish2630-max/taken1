<?php
/**
 * Rakaz Theme — Blog Listing Page
 * Warm brown/gold colors + Cairo font + AOS animations
 */
$siteBase = $siteBase ?? (BASE_PATH . '/site/' . $tenant->slug);
$lang     = $lang ?? 'ar';
$dir      = $dir ?? 'rtl';
$posts    = $posts ?? [];
$categories = $categories ?? [];
$current_category = $current_category ?? '';

require_once __DIR__ . '/partials/_head.php';
require_once __DIR__ . '/partials/_navbar.php';
?>

<!-- ═══════ BLOG HERO ═══════ -->
<section class="hero-gradient px-6 lg:px-16 py-20 text-white">
    <div class="max-w-4xl mx-auto" data-aos="fade-up">
        <div class="section-divider mb-6"></div>
        <h1 class="text-4xl sm:text-5xl font-black mb-4"><?= $lang === 'en' ? 'Our Blog' : 'المدونة' ?></h1>
        <p class="text-lg text-white/80 max-w-xl"><?= $lang === 'en' ? 'Discover our latest articles and news' : 'اكتشف أحدث المقالات والأخبار' ?></p>
    </div>
</section>

<?php if (!empty($categories)): ?>
<!-- ═══════ CATEGORIES ═══════ -->
<div class="px-6 lg:px-16 py-5 bg-white border-b">
    <div class="max-w-7xl mx-auto flex flex-wrap gap-3">
        <a href="<?= url($siteBase . '/blog') ?>"
           class="px-5 py-2 rounded-full text-sm font-bold transition <?= empty($current_category) ? 'bg-primary text-white shadow-lg' : 'bg-gray-100 text-gray-600 hover:bg-primary/10 hover:text-primary' ?>">
            <?= $lang === 'en' ? 'All' : 'الكل' ?>
        </a>
        <?php foreach ($categories as $cat): ?>
        <a href="<?= url($siteBase . '/blog?category=' . urlencode($cat)) ?>"
           class="px-5 py-2 rounded-full text-sm font-bold transition <?= ($current_category === $cat) ? 'bg-primary text-white shadow-lg' : 'bg-gray-100 text-gray-600 hover:bg-primary/10 hover:text-primary' ?>">
            <?= htmlspecialchars($cat) ?>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- ═══════ BLOG GRID ═══════ -->
<section class="px-6 lg:px-16 py-14 bg-white">
    <div class="max-w-7xl mx-auto">
        <?php if (!empty($posts)): ?>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($posts as $post): ?>
            <article class="bg-white rounded-card overflow-hidden card-hover group" data-aos="fade-up">
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
                    <?php if (!empty($post->category)): ?>
                    <span class="inline-block bg-primary/10 text-primary text-xs font-bold px-3 py-1 rounded-full mb-3"><?= htmlspecialchars($post->category) ?></span>
                    <?php endif; ?>
                    <h3 class="text-lg font-black text-secondary mb-2 line-clamp-2">
                        <a href="<?= url($siteBase . '/blog/' . ($post->slug ?? $post->id)) ?>" class="hover:text-primary transition"><?= htmlspecialchars($post->title) ?></a>
                    </h3>
                    <?php if (!empty($post->excerpt)): ?>
                    <p class="text-gray-500 text-sm line-clamp-2"><?= htmlspecialchars(truncate($post->excerpt, 120)) ?></p>
                    <?php elseif (!empty($post->content)): ?>
                    <p class="text-gray-500 text-sm line-clamp-2"><?= htmlspecialchars(truncate(strip_tags($post->content), 120)) ?></p>
                    <?php endif; ?>
                    <div class="flex items-center gap-4 mt-4 pt-4 border-t border-gray-100 text-xs text-gray-400">
                        <?php if (!empty($post->author_name)): ?>
                        <span><i class="fas fa-user mr-1"></i><?= htmlspecialchars($post->author_name) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($post->created_at)): ?>
                        <span><i class="fas fa-calendar mr-1"></i><?= date('Y/m/d', strtotime($post->created_at)) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-20" data-aos="fade-up">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6"><i class="fas fa-newspaper text-4xl text-gray-300"></i></div>
            <h3 class="text-2xl font-black text-gray-400 mb-2"><?= $lang === 'en' ? 'No Posts Yet' : 'لا توجد مقالات بعد' ?></h3>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/partials/_footer.php'; ?>
<?php require_once __DIR__ . '/partials/_scripts.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

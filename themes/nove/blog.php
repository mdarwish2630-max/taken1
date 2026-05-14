<?php
/**
 * Nove Theme — Blog Listing Page
 * Orange accents + dark elements
 */
$lang  = $lang ?? 'ar';
$dir   = $dir ?? 'rtl';
$posts = $posts ?? [];
$categories = $categories ?? [];
$current_category = $current_category ?? '';
$siteBase = $siteBase ?? (BASE_PATH . '/site/' . $tenant->slug);

require_once __DIR__ . '/_head.php';
require_once __DIR__ . '/_navbar.php';
?>

<!-- ═══════ BLOG HERO ═══════ -->
<section class="bg-[#151515] px-6 lg:px-16 py-20">
    <div class="max-w-4xl mx-auto fade-up">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-1 h-8 bg-[#ff7a00] rounded-full"></div>
            <p class="text-[#ff7a00] font-black text-sm tracking-wide"><?= $lang === 'en' ? 'OUR BLOG' : 'المدونة' ?></p>
        </div>
        <h1 class="text-4xl sm:text-5xl font-black text-white leading-tight mb-4"><?= $lang === 'en' ? 'Latest Articles & News' : 'أحدث المقالات والأخبار' ?></h1>
        <p class="text-gray-400 text-lg"><?= $lang === 'en' ? 'Stay updated with our latest content' : 'تابع أحدث المقالات والأخبار' ?></p>
    </div>
</section>

<?php if (!empty($categories)): ?>
<!-- ═══════ CATEGORIES ═══════ -->
<div class="px-6 lg:px-16 py-5 bg-[#1a1a1a] border-b border-white/5">
    <div class="max-w-7xl mx-auto flex flex-wrap gap-3">
        <a href="<?= htmlspecialchars($siteBase) ?>/blog"
           class="px-5 py-2 rounded-full text-sm font-bold transition <?= empty($current_category) ? 'bg-[#ff7a00] text-white' : 'bg-white/5 text-gray-400 hover:bg-[#ff7a00]/10 hover:text-[#ff7a00]' ?>">
            <?= $lang === 'en' ? 'All' : 'الكل' ?>
        </a>
        <?php foreach ($categories as $cat): ?>
        <a href="<?= htmlspecialchars($siteBase) ?>/blog?category=<?= urlencode($cat) ?>"
           class="px-5 py-2 rounded-full text-sm font-bold transition <?= ($current_category === $cat) ? 'bg-[#ff7a00] text-white' : 'bg-white/5 text-gray-400 hover:bg-[#ff7a00]/10 hover:text-[#ff7a00]' ?>">
            <?= htmlspecialchars($cat) ?>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- ═══════ BLOG GRID ═══════ -->
<section class="bg-[#1a1a1a] px-6 lg:px-16 py-14 min-h-[60vh]">
    <div class="max-w-7xl mx-auto">
        <?php if (!empty($posts)): ?>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($posts as $post): ?>
            <article class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 fade-up group">
                <a href="<?= htmlspecialchars($siteBase) ?>/blog/<?= $post->slug ?? $post->id ?>" class="block overflow-hidden">
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
                    <span class="inline-block bg-[#ff7a00]/10 text-[#ff7a00] text-xs font-bold px-3 py-1 rounded-full mb-3"><?= htmlspecialchars($post->category) ?></span>
                    <?php endif; ?>
                    <h3 class="text-lg font-black text-[#282828] mb-2 line-clamp-2">
                        <a href="<?= htmlspecialchars($siteBase) ?>/blog/<?= $post->slug ?? $post->id ?>" class="hover:text-[#ff7a00] transition"><?= htmlspecialchars($post->title) ?></a>
                    </h3>
                    <?php if (!empty($post->excerpt)): ?>
                    <p class="text-gray-500 text-sm line-clamp-2"><?= htmlspecialchars(truncate($post->excerpt, 120)) ?></p>
                    <?php elseif (!empty($post->content)): ?>
                    <p class="text-gray-500 text-sm line-clamp-2"><?= htmlspecialchars(truncate(strip_tags($post->content), 120)) ?></p>
                    <?php endif; ?>
                    <div class="flex items-center gap-4 mt-4 pt-4 border-t border-gray-100 text-xs text-gray-400">
                        <?php if (!empty($post->created_at)): ?>
                        <span><i class="fas fa-calendar mr-1"></i><?= date('Y/m/d', strtotime($post->created_at)) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-20 fade-up">
            <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6"><i class="fas fa-newspaper text-4xl text-gray-600"></i></div>
            <h3 class="text-2xl font-black text-gray-500 mb-2"><?= $lang === 'en' ? 'No Posts Yet' : 'لا توجد مقالات بعد' ?></h3>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

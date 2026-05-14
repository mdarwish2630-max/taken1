<?php
/**
 * Master Theme — Blog Listing Page
 * Dark theme + Cyan accents
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

<!-- ═══════ PAGE HEADER ═══════ -->
<section class="px-6 lg:px-16 py-20 border-b border-white/10">
    <div class="max-w-4xl mx-auto fade-up">
        <p class="text-cyan-400 font-black mb-3 text-sm tracking-widest uppercase"><?= $lang === 'en' ? 'Our Blog' : 'المدونة' ?></p>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight mb-4"><?= $lang === 'en' ? 'Latest Articles & News' : 'أحدث المقالات والأخبار' ?></h1>
        <p class="text-gray-400 text-lg"><?= $lang === 'en' ? 'Stay updated with our latest content and insights' : 'تابع أحدث المحتوى والرؤى' ?></p>
    </div>
</section>

<?php if (!empty($categories)): ?>
<!-- ═══════ CATEGORIES ═══════ -->
<section class="px-6 lg:px-16 py-5">
    <div class="max-w-7xl mx-auto flex flex-wrap gap-3 fade-up">
        <a href="<?= url($siteBase . '/blog') ?>"
           class="px-5 py-2 rounded-full text-sm font-bold transition <?= empty($current_category) ? 'bg-cyan-500 text-white' : 'bg-white/5 text-gray-400 border border-white/10 hover:border-cyan-500/50 hover:text-cyan-400' ?>">
            <?= $lang === 'en' ? 'All' : 'الكل' ?>
        </a>
        <?php foreach ($categories as $cat): ?>
        <a href="<?= url($siteBase . '/blog?category=' . urlencode($cat)) ?>"
           class="px-5 py-2 rounded-full text-sm font-bold transition <?= ($current_category === $cat) ? 'bg-cyan-500 text-white' : 'bg-white/5 text-gray-400 border border-white/10 hover:border-cyan-500/50 hover:text-cyan-400' ?>">
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
            <article class="glass rounded-xl overflow-hidden hover:glow-cyan transition-all duration-300 hover:-translate-y-1 fade-up group">
                <a href="<?= url($siteBase . '/blog/' . ($post->slug ?? $post->id)) ?>" class="block overflow-hidden">
                    <div class="h-52 bg-white/5">
                        <?php if (!empty($post->image)): ?>
                        <img src="<?= upload($post->image) ?>" alt="<?= e($post->title) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-80 group-hover:opacity-100">
                        <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-gray-600 text-5xl"><i class="fas fa-newspaper"></i></div>
                        <?php endif; ?>
                    </div>
                </a>
                <div class="p-6">
                    <?php if (!empty($post->category)): ?>
                    <span class="inline-block bg-cyan-500/10 text-cyan-400 text-xs font-bold px-3 py-1 rounded-full mb-3"><?= htmlspecialchars($post->category) ?></span>
                    <?php endif; ?>
                    <h3 class="text-lg font-black text-white mb-2 line-clamp-2">
                        <a href="<?= url($siteBase . '/blog/' . ($post->slug ?? $post->id)) ?>" class="hover:text-cyan-400 transition"><?= htmlspecialchars($post->title) ?></a>
                    </h3>
                    <?php if (!empty($post->excerpt)): ?>
                    <p class="text-gray-400 text-sm line-clamp-2"><?= htmlspecialchars(truncate($post->excerpt, 120)) ?></p>
                    <?php elseif (!empty($post->content)): ?>
                    <p class="text-gray-400 text-sm line-clamp-2"><?= htmlspecialchars(truncate(strip_tags($post->content), 120)) ?></p>
                    <?php endif; ?>
                    <div class="flex items-center gap-4 mt-4 pt-4 border-t border-white/5 text-xs text-gray-500">
                        <?php if (!empty($post->created_at)): ?>
                        <span><i class="fas fa-calendar mr-1"></i><?= date('Y/m/d', strtotime($post->created_at)) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($post->views)): ?>
                        <span><i class="fas fa-eye mr-1"></i><?= number_format($post->views) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-20 fade-up">
            <div class="w-24 h-24 glass rounded-full flex items-center justify-center mx-auto mb-6"><i class="fas fa-newspaper text-4xl text-gray-600"></i></div>
            <h3 class="text-2xl font-black text-gray-500 mb-2"><?= $lang === 'en' ? 'No Posts Yet' : 'لا توجد مقالات بعد' ?></h3>
            <p class="text-gray-600"><?= $lang === 'en' ? 'Check back later for new content' : 'تابعنا لاحقاً لمحتوى جديد' ?></p>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

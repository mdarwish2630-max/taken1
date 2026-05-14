<?php
/**
 * Tek Pro Theme — Blog Post Page
 */
$siteBase = $siteBase ?? (BASE_PATH . '/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';
$post     = $post ?? null;
$related  = $related_posts ?? [];

require_once __DIR__ . '/_head.php';
require_once __DIR__ . '/_navbar.php';
?>

<?php if ($post): ?>
<!-- ═══════ POST HEADER ═══════ -->
<section class="bg-[#f3f3f3] px-6 lg:px-16 py-16">
    <div class="max-w-4xl mx-auto fade-up">
        <a href="<?= url($siteBase . '/blog') ?>" class="inline-flex items-center gap-2 text-[#ff7a00] font-bold mb-6 hover:gap-3 transition-all">
            <i class="fas fa-arrow-<?= $isRtl ? 'right' : 'left' ?>"></i>
            <?= $lang === 'en' ? 'Back to Blog' : 'العودة للمدونة' ?>
        </a>
        <?php if (!empty($post->category)): ?>
        <span class="inline-block bg-[#ff7a00]/10 text-[#ff7a00] text-xs font-bold px-3 py-1 rounded-full mb-4"><?= htmlspecialchars($post->category) ?></span>
        <?php endif; ?>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black leading-tight mb-6"><?= htmlspecialchars($post->title) ?></h1>
        <div class="flex flex-wrap items-center gap-4 text-gray-500 text-sm">
            <?php if (!empty($post->author_name)): ?>
            <span class="flex items-center gap-2"><div class="w-8 h-8 rounded-full bg-[#ff7a00] flex items-center justify-center text-white text-xs font-bold"><?= mb_substr($post->author_name, 0, 1) ?></div><?= htmlspecialchars($post->author_name) ?></span>
            <?php endif; ?>
            <?php if (!empty($post->created_at)): ?>
            <span><i class="fas fa-calendar mr-1"></i><?= date('Y/m/d', strtotime($post->created_at)) ?></span>
            <?php endif; ?>
            <?php if (!empty($post->views)): ?>
            <span><i class="fas fa-eye mr-1"></i><?= number_format($post->views) ?> <?= $lang === 'en' ? 'views' : 'مشاهدة' ?></span>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ═══════ POST CONTENT ═══════ -->
<section class="px-6 lg:px-16 py-12">
    <div class="max-w-4xl mx-auto">
        <?php if (!empty($post->image)): ?>
        <div class="rounded-xl overflow-hidden mb-10 fade-up shadow-lg">
            <img src="<?= upload($post->image) ?>" alt="<?= htmlspecialchars($post->title) ?>" class="w-full h-auto object-cover">
        </div>
        <?php endif; ?>

        <div class="prose prose-lg max-w-none fade-up">
            <div class="text-gray-600 text-lg leading-loose space-y-4">
                <?= $post->content ?? '' ?>
            </div>
        </div>
    </div>
</section>

<!-- ═══════ RELATED POSTS ═══════ -->
<?php if (!empty($related)): ?>
<section class="bg-[#f3f3f3] px-6 lg:px-16 py-16">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-black mb-10 fade-up"><?= $lang === 'en' ? 'Related Articles' : 'مقالات ذات صلة' ?></h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($related as $rp): ?>
            <article class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 tekpro-card fade-up">
                <a href="<?= url($siteBase . '/blog/' . ($rp->slug ?? $rp->id)) ?>" class="block">
                    <div class="h-44 bg-gray-100 overflow-hidden">
                        <?php if (!empty($rp->image)): ?>
                        <img src="<?= upload($rp->image) ?>" alt="<?= e($rp->title) ?>" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-gray-300 text-4xl"><i class="fas fa-newspaper"></i></div>
                        <?php endif; ?>
                    </div>
                </a>
                <div class="p-5">
                    <h3 class="font-black text-gray-800 mb-2 line-clamp-2">
                        <a href="<?= url($siteBase . '/blog/' . ($rp->slug ?? $rp->id)) ?>" class="hover:text-[#ff7a00] transition"><?= htmlspecialchars($rp->title) ?></a>
                    </h3>
                    <?php if (!empty($rp->created_at)): ?>
                    <span class="text-xs text-gray-400"><i class="fas fa-calendar mr-1"></i><?= date('Y/m/d', strtotime($rp->created_at)) ?></span>
                    <?php endif; ?>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php else: ?>
<!-- Post Not Found -->
<section class="px-6 lg:px-16 py-32 text-center">
    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6"><i class="fas fa-exclamation-triangle text-4xl text-gray-300"></i></div>
    <h2 class="text-2xl font-black text-gray-400"><?= $lang === 'en' ? 'Post Not Found' : 'المقال غير موجود' ?></h2>
    <a href="<?= url($siteBase) ?>" class="inline-block mt-4 text-[#ff7a00] font-bold hover:underline"><?= $lang === 'en' ? 'Go Home' : 'العودة للرئيسية' ?></a>
</section>
<?php endif; ?>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

<?php
/**
 * TakPro Theme — Blog Post Page
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
<!-- ═══════ BREADCRUMB ═══════ -->
<div class="bg-gray-50 px-6 lg:px-16 py-4">
    <div class="max-w-4xl mx-auto flex items-center gap-2 text-sm text-gray-400">
        <a href="<?= url($siteBase) ?>" class="hover:text-brand transition"><?= $lang === 'en' ? 'Home' : 'الرئيسية' ?></a>
        <i class="fas fa-chevron-<?= $isRtl ? 'left' : 'right' ?> text-[10px]"></i>
        <a href="<?= url($siteBase . '/blog') ?>" class="hover:text-brand transition"><?= $lang === 'en' ? 'Blog' : 'المدونة' ?></a>
        <i class="fas fa-chevron-<?= $isRtl ? 'left' : 'right' ?> text-[10px]"></i>
        <span class="text-brand font-bold line-clamp-1"><?= htmlspecialchars($post->title) ?></span>
    </div>
</div>

<!-- ═══════ POST HERO ═══════ -->
<section class="px-6 lg:px-16 pt-10 pb-6">
    <div class="max-w-4xl mx-auto fade-up">
        <?php if (!empty($post->category)): ?>
        <span class="inline-block bg-brand/10 text-brand text-xs font-bold px-3 py-1 rounded-full mb-4"><?= htmlspecialchars($post->category) ?></span>
        <?php endif; ?>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black leading-tight text-dark mb-6"><?= htmlspecialchars($post->title) ?></h1>
        <div class="flex flex-wrap items-center gap-4 text-gray-500 text-sm pb-8 border-b">
            <?php if (!empty($post->author_name)): ?>
            <span class="flex items-center gap-2"><div class="w-8 h-8 rounded-full bg-brand flex items-center justify-center text-white text-xs font-bold"><?= mb_substr($post->author_name, 0, 1) ?></div><?= htmlspecialchars($post->author_name) ?></span>
            <?php endif; ?>
            <?php if (!empty($post->created_at)): ?>
            <span><i class="fas fa-calendar mr-1"></i><?= date('Y/m/d', strtotime($post->created_at)) ?></span>
            <?php endif; ?>
            <?php if (!empty($post->views)): ?>
            <span><i class="fas fa-eye mr-1"></i><?= number_format($post->views) ?></span>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ═══════ POST IMAGE ═══════ -->
<?php if (!empty($post->image)): ?>
<section class="px-6 lg:px-16 pb-10">
    <div class="max-w-4xl mx-auto rounded-2xl overflow-hidden shadow-xl fade-up">
        <img src="<?= upload($post->image) ?>" alt="<?= htmlspecialchars($post->title) ?>" class="w-full h-auto object-cover">
    </div>
</section>
<?php endif; ?>

<!-- ═══════ POST CONTENT ═══════ -->
<section class="px-6 lg:px-16 pb-16">
    <div class="max-w-4xl mx-auto fade-up">
        <div class="text-gray-600 text-lg leading-loose space-y-4">
            <?= $post->content ?? '' ?>
        </div>
    </div>
</section>

<!-- ═══════ RELATED ═══════ -->
<?php if (!empty($related)): ?>
<section class="bg-gray-50 px-6 lg:px-16 py-16">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-black mb-10"><?= $lang === 'en' ? 'Related Articles' : 'مقالات ذات صلة' ?></h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($related as $rp): ?>
            <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 fade-up">
                <a href="<?= url($siteBase . '/blog/' . ($rp->slug ?? $rp->id)) ?>" class="block overflow-hidden">
                    <div class="h-40 bg-gray-100">
                        <?php if (!empty($rp->image)): ?>
                        <img src="<?= upload($rp->image) ?>" alt="<?= e($rp->title) ?>" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-gray-300 text-3xl"><i class="fas fa-newspaper"></i></div>
                        <?php endif; ?>
                    </div>
                </a>
                <div class="p-5">
                    <h3 class="font-black text-dark mb-2 line-clamp-2">
                        <a href="<?= url($siteBase . '/blog/' . ($rp->slug ?? $rp->id)) ?>" class="hover:text-brand transition"><?= htmlspecialchars($rp->title) ?></a>
                    </h3>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php else: ?>
<section class="px-6 lg:px-16 py-32 text-center">
    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6"><i class="fas fa-exclamation-triangle text-4xl text-gray-300"></i></div>
    <h2 class="text-2xl font-black text-gray-400"><?= $lang === 'en' ? 'Post Not Found' : 'المقال غير موجود' ?></h2>
    <a href="<?= url($siteBase) ?>" class="inline-block mt-4 text-brand font-bold hover:underline"><?= $lang === 'en' ? 'Go Home' : 'العودة للرئيسية' ?></a>
</section>
<?php endif; ?>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

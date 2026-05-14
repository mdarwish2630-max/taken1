<?php
/**
 * Nove Theme — Blog Post Page
 */
$lang     = $lang ?? 'ar';
$dir      = $dir ?? 'rtl';
$post     = $post ?? null;
$related  = $related_posts ?? [];
$siteBase = $siteBase ?? (BASE_PATH . '/site/' . $tenant->slug);

require_once __DIR__ . '/_head.php';
require_once __DIR__ . '/_navbar.php';
?>

<?php if ($post): ?>
<!-- ═══════ BREADCRUMB ═══════ -->
<div class="bg-[#151515] px-6 lg:px-16 py-4">
    <div class="max-w-4xl mx-auto flex items-center gap-2 text-sm text-gray-500">
        <a href="<?= htmlspecialchars($siteBase) ?>" class="hover:text-[#ff7a00] transition"><?= $lang === 'en' ? 'Home' : 'الرئيسية' ?></a>
        <i class="fas fa-chevron-<?= $dir === 'rtl' ? 'left' : 'right' ?> text-[10px]"></i>
        <a href="<?= htmlspecialchars($siteBase) ?>/blog" class="hover:text-[#ff7a00] transition"><?= $lang === 'en' ? 'Blog' : 'المدونة' ?></a>
        <i class="fas fa-chevron-<?= $dir === 'rtl' ? 'left' : 'right' ?> text-[10px]"></i>
        <span class="text-[#ff7a00] font-bold line-clamp-1"><?= htmlspecialchars($post->title) ?></span>
    </div>
</div>

<!-- ═══════ POST HEADER ═══════ -->
<section class="bg-[#151515] px-6 lg:px-16 pt-12 pb-8">
    <div class="max-w-4xl mx-auto fade-up">
        <?php if (!empty($post->category)): ?>
        <span class="inline-block bg-[#ff7a00]/10 text-[#ff7a00] text-xs font-bold px-3 py-1 rounded-full mb-4"><?= htmlspecialchars($post->category) ?></span>
        <?php endif; ?>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight mb-6"><?= htmlspecialchars($post->title) ?></h1>
        <div class="flex flex-wrap items-center gap-5 text-gray-400 text-sm pb-8 border-b border-white/10">
            <?php if (!empty($post->author_name)): ?>
            <span class="flex items-center gap-2"><div class="w-8 h-8 rounded-full bg-[#ff7a00] flex items-center justify-center text-white text-xs font-bold"><?= mb_substr($post->author_name, 0, 1) ?></div><?= htmlspecialchars($post->author_name) ?></span>
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
    <div class="max-w-5xl mx-auto rounded-2xl overflow-hidden shadow-2xl fade-up">
        <img src="<?= upload($post->image) ?>" alt="<?= htmlspecialchars($post->title) ?>" class="w-full h-auto object-cover">
    </div>
</section>
<?php endif; ?>

<!-- ═══════ POST CONTENT ═══════ -->
<section class="px-6 lg:px-16 pb-16">
    <div class="max-w-4xl mx-auto fade-up">
        <div class="text-gray-300 text-lg leading-loose space-y-4 bg-[#1a1a1a] rounded-2xl p-8 lg:p-12">
            <?= $post->content ?? '' ?>
        </div>
    </div>
</section>

<!-- ═══════ RELATED ═══════ -->
<?php if (!empty($related)): ?>
<section class="bg-[#151515] px-6 lg:px-16 py-16 border-t border-white/5">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-black text-white mb-10 fade-up"><?= $lang === 'en' ? 'Related Articles' : 'مقالات ذات صلة' ?></h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($related as $rp): ?>
            <article class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 fade-up">
                <a href="<?= htmlspecialchars($siteBase) ?>/blog/<?= $rp->slug ?? $rp->id ?>" class="block overflow-hidden">
                    <div class="h-40 bg-gray-100">
                        <?php if (!empty($rp->image)): ?>
                        <img src="<?= upload($rp->image) ?>" alt="<?= e($rp->title) ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-gray-300 text-3xl"><i class="fas fa-newspaper"></i></div>
                        <?php endif; ?>
                    </div>
                </a>
                <div class="p-5">
                    <h3 class="font-black text-[#282828] mb-2 line-clamp-2">
                        <a href="<?= htmlspecialchars($siteBase) ?>/blog/<?= $rp->slug ?? $rp->id ?>" class="hover:text-[#ff7a00] transition"><?= htmlspecialchars($rp->title) ?></a>
                    </h3>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php else: ?>
<section class="px-6 lg:px-16 py-32 text-center bg-[#1a1a1a]">
    <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6"><i class="fas fa-exclamation-triangle text-4xl text-gray-600"></i></div>
    <h2 class="text-2xl font-black text-gray-500"><?= $lang === 'en' ? 'Post Not Found' : 'المقال غير موجود' ?></h2>
    <a href="<?= htmlspecialchars($siteBase) ?>" class="inline-block mt-4 text-[#ff7a00] font-bold hover:underline"><?= $lang === 'en' ? 'Go Home' : 'العودة للرئيسية' ?></a>
</section>
<?php endif; ?>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

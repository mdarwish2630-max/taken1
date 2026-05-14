<?php
/**
 * Rakaz Theme — Blog Post Page
 * Warm brown/gold colors + Cairo font + AOS animations
 */
$siteBase = $siteBase ?? (BASE_PATH . '/site/' . $tenant->slug);
$lang     = $lang ?? 'ar';
$dir      = $dir ?? 'rtl';
$post     = $post ?? null;
$related  = $related_posts ?? [];

require_once __DIR__ . '/partials/_head.php';
require_once __DIR__ . '/partials/_navbar.php';
?>

<?php if ($post): ?>
<!-- ═══════ BREADCRUMB ═══════ -->
<div class="bg-white px-6 lg:px-16 py-4 border-b">
    <div class="max-w-4xl mx-auto flex items-center gap-2 text-sm text-gray-400">
        <a href="<?= url($siteBase) ?>" class="hover:text-primary transition"><?= $lang === 'en' ? 'Home' : 'الرئيسية' ?></a>
        <i class="fas fa-chevron-<?= $dir === 'rtl' ? 'left' : 'right' ?> text-[10px]"></i>
        <a href="<?= url($siteBase . '/blog') ?>" class="hover:text-primary transition"><?= $lang === 'en' ? 'Blog' : 'المدونة' ?></a>
        <i class="fas fa-chevron-<?= $dir === 'rtl' ? 'left' : 'right' ?> text-[10px]"></i>
        <span class="text-primary font-bold line-clamp-1"><?= htmlspecialchars($post->title) ?></span>
    </div>
</div>

<!-- ═══════ POST HEADER ═══════ -->
<section class="hero-gradient px-6 lg:px-16 pt-14 pb-10 text-white">
    <div class="max-w-4xl mx-auto" data-aos="fade-up">
        <?php if (!empty($post->category)): ?>
        <span class="inline-block bg-white/15 text-white text-xs font-bold px-3 py-1 rounded-full mb-4"><?= htmlspecialchars($post->category) ?></span>
        <?php endif; ?>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black leading-tight mb-6"><?= htmlspecialchars($post->title) ?></h1>
        <div class="flex flex-wrap items-center gap-5 text-white/70 text-sm">
            <?php if (!empty($post->author_name)): ?>
            <span class="flex items-center gap-2"><div class="w-8 h-8 rounded-full bg-accent flex items-center justify-center text-secondary text-xs font-bold"><?= mb_substr($post->author_name, 0, 1) ?></div><?= htmlspecialchars($post->author_name) ?></span>
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
<section class="px-6 lg:px-16 -mt-1">
    <div class="max-w-5xl mx-auto rounded-card overflow-hidden shadow-xl" data-aos="fade-up">
        <img src="<?= upload($post->image) ?>" alt="<?= htmlspecialchars($post->title) ?>" class="w-full h-auto object-cover">
    </div>
</section>
<?php endif; ?>

<!-- ═══════ POST CONTENT ═══════ -->
<section class="px-6 lg:px-16 py-14 bg-white">
    <div class="max-w-4xl mx-auto" data-aos="fade-up">
        <div class="text-gray-600 text-lg leading-loose space-y-4">
            <?= $post->content ?? '' ?>
        </div>
    </div>
</section>

<!-- ═══════ RELATED ═══════ -->
<?php if (!empty($related)): ?>
<section class="bg-gray-50 px-6 lg:px-16 py-16">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-black text-secondary mb-3" data-aos="fade-up"><?= $lang === 'en' ? 'Related Articles' : 'مقالات ذات صلة' ?></h2>
        <div class="section-divider mb-10" data-aos="fade-up"></div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($related as $rp): ?>
            <article class="bg-white rounded-card overflow-hidden card-hover" data-aos="fade-up">
                <a href="<?= url($siteBase . '/blog/' . ($rp->slug ?? $rp->id)) ?>" class="block overflow-hidden">
                    <div class="h-40 bg-gray-100">
                        <?php if (!empty($rp->image)): ?>
                        <img src="<?= upload($rp->image) ?>" alt="<?= e($rp->title) ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-gray-300 text-3xl"><i class="fas fa-newspaper"></i></div>
                        <?php endif; ?>
                    </div>
                </a>
                <div class="p-5">
                    <h3 class="font-black text-secondary mb-2 line-clamp-2">
                        <a href="<?= url($siteBase . '/blog/' . ($rp->slug ?? $rp->id)) ?>" class="hover:text-primary transition"><?= htmlspecialchars($rp->title) ?></a>
                    </h3>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php else: ?>
<section class="px-6 lg:px-16 py-32 text-center bg-white">
    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6"><i class="fas fa-exclamation-triangle text-4xl text-gray-300"></i></div>
    <h2 class="text-2xl font-black text-gray-400"><?= $lang === 'en' ? 'Post Not Found' : 'المقال غير موجود' ?></h2>
    <a href="<?= url($siteBase) ?>" class="inline-block mt-4 text-primary font-bold hover:underline"><?= $lang === 'en' ? 'Go Home' : 'العودة للرئيسية' ?></a>
</section>
<?php endif; ?>

<?php require_once __DIR__ . '/partials/_footer.php'; ?>
<?php require_once __DIR__ . '/partials/_scripts.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

<?php
/**
 * CleanPro Theme — Blog Post Page
 * Professional blue theme — Pure CSS (no Tailwind)
 */
$siteBase = $siteBase ?? (BASE_PATH . '/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';
$post     = $post ?? null;
$related  = $related_posts ?? [];

require_once __DIR__ . '/partials/_head.php';
require_once __DIR__ . '/partials/_navbar.php';
?>

<?php if ($post): ?>
<!-- ═══════ BREADCRUMB ═══════ -->
<div class="cpro-breadcrumb">
    <div class="cpro-container" style="display:flex;align-items:center;gap:8px;flex-wrap:wrap">
        <a href="<?= url($siteBase) ?>"><?= $lang === 'en' ? 'Home' : 'الرئيسية' ?></a>
        <i class="fas fa-chevron-<?= $isRtl ? 'left' : 'right' ?>"></i>
        <a href="<?= url($siteBase . '/blog') ?>"><?= $lang === 'en' ? 'Blog' : 'المدونة' ?></a>
        <i class="fas fa-chevron-<?= $isRtl ? 'left' : 'right' ?>"></i>
        <span class="current" style="max-width:300px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap"><?= htmlspecialchars($post->title) ?></span>
    </div>
</div>

<!-- ═══════ POST HEADER ═══════ -->
<section class="cpro-section" style="padding:60px 0 30px;background:#fff">
    <div class="cpro-container" style="max-width:800px">
        <?php if (!empty($post->category)): ?>
        <span style="display:inline-block;background:rgba(11,127,243,.08);color:var(--blue);font-size:13px;font-weight:700;padding:5px 14px;border-radius:50px;margin-bottom:16px"><?= htmlspecialchars($post->category) ?></span>
        <?php endif; ?>
        <h1 style="font-size:clamp(1.8rem,4vw,2.5rem);font-weight:900;line-height:1.25;color:var(--dark);margin-bottom:20px"><?= htmlspecialchars($post->title) ?></h1>
        <div style="display:flex;flex-wrap:wrap;align-items:center;gap:16px;color:var(--muted);font-size:14px;padding-bottom:24px;border-bottom:1px solid var(--gray-200)">
            <?php if (!empty($post->author_name)): ?>
            <span style="display:flex;align-items:center;gap:8px"><div style="width:32px;height:32px;border-radius:50%;background:var(--blue);display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;font-weight:700"><?= mb_substr($post->author_name, 0, 1) ?></div><?= htmlspecialchars($post->author_name) ?></span>
            <?php endif; ?>
            <?php if (!empty($post->created_at)): ?>
            <span><i class="fas fa-calendar" style="margin-inline-end:5px"></i><?= date('Y/m/d', strtotime($post->created_at)) ?></span>
            <?php endif; ?>
            <?php if (!empty($post->views)): ?>
            <span><i class="fas fa-eye" style="margin-inline-end:5px"></i><?= number_format($post->views) ?></span>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ═══════ POST IMAGE ═══════ -->
<?php if (!empty($post->image)): ?>
<section style="padding:0 0 40px;background:#fff">
    <div class="cpro-container" style="max-width:900px">
        <div style="border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow)">
            <img src="<?= upload($post->image) ?>" alt="<?= htmlspecialchars($post->title) ?>" style="width:100%;display:block;object-fit:cover">
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ═══════ POST CONTENT ═══════ -->
<section class="cpro-section" style="padding:20px 0 60px;background:#fff">
    <div class="cpro-container" style="max-width:800px">
        <div style="color:var(--text);font-size:17px;line-height:1.9">
            <?= $post->content ?? '' ?>
        </div>
    </div>
</section>

<!-- ═══════ RELATED ═══════ -->
<?php if (!empty($related)): ?>
<section style="background:var(--light);padding:60px 0;border-top:1px solid var(--gray-200)">
    <div class="cpro-container">
        <h2 class="cpro-title" style="margin-bottom:40px"><?= $lang === 'en' ? 'Related Articles' : 'مقالات ذات صلة' ?></h2>
        <div class="cpro-cards" style="grid-template-columns:repeat(auto-fill,minmax(300px,1fr));margin-top:0">
            <?php foreach ($related as $rp): ?>
            <article class="cpro-service-card" style="border-radius:var(--radius)">
                <a href="<?= url($siteBase . '/blog/' . ($rp->slug ?? $rp->id)) ?>" style="display:block;overflow:hidden;height:180px">
                    <?php if (!empty($rp->image)): ?>
                    <img src="<?= upload($rp->image) ?>" alt="<?= e($rp->title) ?>" style="width:100%;height:100%;object-fit:cover">
                    <?php else: ?>
                    <div style="width:100%;height:100%;background:var(--gray-200);display:flex;align-items:center;justify-content:center;color:var(--gray-400);font-size:2.5rem"><i class="fas fa-newspaper"></i></div>
                    <?php endif; ?>
                </a>
                <div style="padding:20px">
                    <h3 style="font-size:16px;font-weight:900;color:var(--text);margin-bottom:8px">
                        <a href="<?= url($siteBase . '/blog/' . ($rp->slug ?? $rp->id)) ?>" style="color:inherit"><?= htmlspecialchars($rp->title) ?></a>
                    </h3>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php else: ?>
<section class="cpro-section" style="min-height:60vh;display:flex;align-items:center;justify-content:center">
    <div style="text-align:center">
        <div style="width:80px;height:80px;background:var(--gray-200);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px"><i class="fas fa-exclamation-triangle" style="font-size:2rem;color:var(--gray-400)"></i></div>
        <h2 style="font-size:22px;font-weight:900;color:var(--gray-400);margin-bottom:16px"><?= $lang === 'en' ? 'Post Not Found' : 'المقال غير موجود' ?></h2>
        <a href="<?= url($siteBase) ?>" style="color:var(--blue);font-weight:700"><?= $lang === 'en' ? 'Go Home' : 'العودة للرئيسية' ?></a>
    </div>
</section>
<?php endif; ?>

<?php require_once __DIR__ . '/partials/_footer.php'; ?>
<?php require_once __DIR__ . '/partials/_scripts.php'; ?>

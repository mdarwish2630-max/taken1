<?php
/**
 * CleanPro Theme — Blog Listing Page
 * Professional blue theme — Pure CSS (no Tailwind)
 */
$siteBase = $siteBase ?? (BASE_PATH . '/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';
$posts    = $posts ?? [];
$categories = $categories ?? [];
$current_category = $current_category ?? '';

require_once __DIR__ . '/partials/_head.php';
require_once __DIR__ . '/partials/_navbar.php';
?>

<!-- ═══════ BLOG HERO ═══════ -->
<section class="cpro-hero" style="min-height:360px">
    <div class="cpro-hero-content" style="padding-top:60px;padding-bottom:40px">
        <p class="cpro-eyebrow"><?= $lang === 'en' ? 'Our Blog' : 'المدونة' ?></p>
        <h1 class="cpro-title" style="color:#fff"><?= $lang === 'en' ? 'Latest Articles & News' : 'أحدث المقالات والأخبار' ?></h1>
        <p class="cpro-subtitle" style="color:rgba(255,255,255,.85)"><?= $lang === 'en' ? 'Stay updated with our latest content' : 'تابع أحدث المقالات والأخبار' ?></p>
    </div>
</section>

<?php if (!empty($categories)): ?>
<!-- ═══════ CATEGORIES ═══════ -->
<div class="cpro-section" style="padding:20px 0;background:#fff;border-bottom:1px solid var(--gray-200)">
    <div class="cpro-container" style="display:flex;flex-wrap:wrap;gap:10px">
        <a href="<?= url($siteBase . '/blog') ?>"
           class="cpro-btn" style="<?= empty($current_category) ? '' : 'background:transparent;color:var(--blue);box-shadow:none;border:1px solid var(--blue);padding:10px 22px;font-size:13px;' ?>padding:10px 22px;font-size:13px;border-radius:50px">
            <?= $lang === 'en' ? 'All' : 'الكل' ?>
        </a>
        <?php foreach ($categories as $cat): ?>
        <a href="<?= url($siteBase . '/blog?category=' . urlencode($cat)) ?>"
           class="cpro-btn" style="<?= ($current_category === $cat) ? '' : 'background:transparent;color:var(--blue);box-shadow:none;border:1px solid var(--blue);padding:10px 22px;font-size:13px;' ?>padding:10px 22px;font-size:13px;border-radius:50px">
            <?= htmlspecialchars($cat) ?>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- ═══════ BLOG GRID ═══════ -->
<section class="cpro-section" style="background:var(--light)">
    <div class="cpro-container">
        <?php if (!empty($posts)): ?>
        <div class="cpro-cards" style="grid-template-columns:repeat(auto-fill,minmax(340px,1fr));margin-top:0">
            <?php foreach ($posts as $idx => $post): ?>
            <article class="cpro-service-card" style="border-radius:var(--radius)">
                <a href="<?= url($siteBase . '/blog/' . ($post->slug ?? $post->id)) ?>" style="display:block;overflow:hidden;height:200px">
                    <?php if (!empty($post->image)): ?>
                    <img src="<?= upload($post->image) ?>" alt="<?= e($post->title) ?>" style="width:100%;height:100%;object-fit:cover;transition:transform .5s" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
                    <?php else: ?>
                    <div style="width:100%;height:100%;background:var(--gray-200);display:flex;align-items:center;justify-content:center;color:var(--gray-400);font-size:3rem"><i class="fas fa-newspaper"></i></div>
                    <?php endif; ?>
                </a>
                <div style="padding:22px">
                    <?php if (!empty($post->category)): ?>
                    <span style="display:inline-block;background:rgba(11,127,243,.08);color:var(--blue);font-size:12px;font-weight:700;padding:4px 12px;border-radius:50px;margin-bottom:12px"><?= htmlspecialchars($post->category) ?></span>
                    <?php endif; ?>
                    <h3 style="font-size:17px;font-weight:900;margin-bottom:8px;color:var(--text)">
                        <a href="<?= url($siteBase . '/blog/' . ($post->slug ?? $post->id)) ?>" style="color:inherit"><?= htmlspecialchars($post->title) ?></a>
                    </h3>
                    <?php if (!empty($post->excerpt)): ?>
                    <p style="color:var(--muted);font-size:14px;line-height:1.7;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden"><?= htmlspecialchars(truncate($post->excerpt, 120)) ?></p>
                    <?php elseif (!empty($post->content)): ?>
                    <p style="color:var(--muted);font-size:14px;line-height:1.7;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden"><?= htmlspecialchars(truncate(strip_tags($post->content), 120)) ?></p>
                    <?php endif; ?>
                    <div style="display:flex;align-items:center;gap:14px;margin-top:14px;padding-top:14px;border-top:1px solid var(--gray-200);font-size:12px;color:var(--gray-400)">
                        <?php if (!empty($post->created_at)): ?>
                        <span><i class="fas fa-calendar" style="margin-inline-end:4px"></i><?= date('Y/m/d', strtotime($post->created_at)) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div style="text-align:center;padding:80px 20px;color:var(--muted)">
            <div style="width:80px;height:80px;background:var(--gray-200);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px"><i class="fas fa-newspaper" style="font-size:2rem;color:var(--gray-400)"></i></div>
            <h3 style="font-size:22px;font-weight:900;color:var(--gray-400);margin-bottom:8px"><?= $lang === 'en' ? 'No Posts Yet' : 'لا توجد مقالات بعد' ?></h3>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/partials/_footer.php'; ?>
<?php require_once __DIR__ . '/partials/_scripts.php'; ?>

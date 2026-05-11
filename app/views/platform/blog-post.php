<?php
/**
 * Platform Blog - Single Post View (SEO-Optimized)
 * عرض مقال واحد في مدونة المنصة - متوافق مع جوجل SEO
 */

$lang = $lang ?? Language::current();
$dir = Language::direction();
$post = $post ?? null;
$siteUrl = $siteUrl ?? '';
$siteName = defined('SITE_NAME') ? SITE_NAME : 'TakweenWeb';
$metaDesc = $metaDesc ?? '';
$postUrl = $siteUrl . '/blog/' . ($post->slug ?? '');
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? '') ?></title>
    <meta name="description" content="<?= htmlspecialchars($metaDesc) ?>">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="theme-color" content="#6366f1">
    <meta name="author" content="<?= htmlspecialchars($siteName) ?>">
    <link rel="canonical" href="<?= htmlspecialchars($postUrl) ?>">
    <link rel="icon" href="<?= $siteUrl ?>/favicon.ico">

    <!-- Hreflang -->
    <link rel="alternate" hreflang="ar" href="<?= $siteUrl ?>/lang/ar">
    <link rel="alternate" hreflang="en" href="<?= $siteUrl ?>/lang/en">
    <link rel="alternate" hreflang="x-default" href="<?= $siteUrl ?>">

    <!-- Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <!-- Open Graph Article -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="<?= htmlspecialchars($post->title ?? '') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($metaDesc) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($postUrl) ?>">
    <meta property="og:site_name" content="<?= htmlspecialchars($siteName) ?>">
    <?php if (!empty($post->featured_image)): ?>
    <meta property="og:image" content="<?= htmlspecialchars($post->featured_image) ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <?php endif; ?>
    <meta property="og:locale" content="<?= $lang === 'ar' ? 'ar_SA' : 'en_US' ?>">
    <meta property="article:published_time" content="<?= $post->published_at ?? $post->created_at ?? '' ?>">
    <?php if (!empty($post->updated_at)): ?>
    <meta property="article:modified_time" content="<?= $post->updated_at ?>">
    <?php endif; ?>
    <?php if (!empty($post->category)): ?>
    <meta property="article:section" content="<?= htmlspecialchars($post->category) ?>">
    <?php endif; ?>
    <?php if (!empty($post->tags)): ?>
    <?php $tagsArr = explode(',', $post->tags); foreach ($tagsArr as $tag): $tag = trim($tag); if (!empty($tag)): ?>
    <meta property="article:tag" content="<?= htmlspecialchars($tag) ?>">
    <?php endif; endforeach; ?>
    <?php endif; ?>
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($post->title ?? '') ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($metaDesc) ?>">
    <?php if (!empty($post->featured_image)): ?>
    <meta name="twitter:image" content="<?= htmlspecialchars($post->featured_image) ?>">
    <?php endif; ?>

    <!-- JSON-LD: Article + BreadcrumbList -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@graph": [
            {
                "@type": "Article",
                "@id": <?= json_encode($postUrl . '#article') ?>,
                "headline": <?= json_encode($post->title ?? '') ?>,
                "description": <?= json_encode($metaDesc) ?>,
                "datePublished": <?= json_encode($post->published_at ?? $post->created_at ?? '') ?>,
                <?php if (!empty($post->updated_at)): ?>
                "dateModified": <?= json_encode($post->updated_at) ?>,
                <?php endif; ?>
                "author": {
                    "@type": "Organization",
                    "name": <?= json_encode($siteName) ?>,
                    "url": <?= json_encode($siteUrl) ?>
                },
                "publisher": {
                    "@type": "Organization",
                    "name": <?= json_encode($siteName) ?>,
                    "url": <?= json_encode($siteUrl) ?>
                },
                "mainEntityOfPage": {
                    "@type": "WebPage",
                    "@id": <?= json_encode($postUrl) ?>
                },
                "inLanguage": <?= json_encode($lang === 'ar' ? 'ar-SA' : 'en-US') ?>
                <?php if (!empty($post->featured_image)): ?>
                ,"image": {
                    "@type": "ImageObject",
                    "url": <?= json_encode($post->featured_image) ?>
                }
                <?php endif; ?>
            },
            {
                "@type": "BreadcrumbList",
                "itemListElement": [
                    {
                        "@type": "ListItem",
                        "position": 1,
                        "name": <?= json_encode($lang === 'en' ? 'Home' : 'الرئيسية') ?>,
                        "item": <?= json_encode($siteUrl) ?>
                    },
                    {
                        "@type": "ListItem",
                        "position": 2,
                        "name": <?= json_encode($lang === 'en' ? 'Blog' : 'المدونة') ?>,
                        "item": <?= json_encode($siteUrl . '/blog') ?>
                    },
                    {
                        "@type": "ListItem",
                        "position": 3,
                        "name": <?= json_encode($post->title ?? '') ?>
                    }
                ]
            }
        ]
    }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        :root {
            --primary: #6366f1; --primary-dark: #4f46e5; --primary-light: #818cf8;
            --accent: #06b6d4; --accent-dark: #0891b2;
            --success: #10b981; --warning: #f59e0b; --danger: #ef4444;
            --dark: #0f172a; --dark-700: #1e293b; --dark-600: #334155;
            --gray-50: #f8fafc; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-300: #cbd5e1;
            --gray-400: #94a3b8; --gray-500: #64748b; --white: #ffffff;
            --radius: 12px; --radius-lg: 20px; --radius-xl: 28px;
            --shadow: 0 4px 24px rgba(0,0,0,0.06); --shadow-lg: 0 12px 40px rgba(0,0,0,0.1); --shadow-xl: 0 20px 60px rgba(0,0,0,0.15);
            --transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            --font: 'Readex Pro', sans-serif;
        }
        body { font-family: var(--font); background: var(--gray-50); color: var(--dark); line-height: 1.7; overflow-x: hidden; }
        a { text-decoration: none; color: inherit; }
        img { max-width: 100%; height: auto; }
        .container { max-width: 800px; margin: 0 auto; padding: 0 24px; }

        /* Navbar */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            padding: 14px 0;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 1px 20px rgba(0,0,0,0.06);
        }
        .navbar .nav-inner { display: flex; justify-content: space-between; align-items: center; }
        .navbar .logo-link { display: flex; align-items: center; gap: 10px; font-size: 1.3rem; font-weight: 700; color: var(--primary-dark); }
        .navbar .logo-link i { font-size: 1.4rem; }
        .navbar .logo-link img { height: 34px; width: auto; }
        .nav-menu { display: flex; align-items: center; gap: 6px; }
        .nav-menu .nav-link { padding: 8px 16px; border-radius: 8px; font-weight: 500; font-size: 0.9rem; color: var(--dark-600); transition: var(--transition); }
        .nav-menu .nav-link:hover { background: rgba(99,102,241,0.08); color: var(--primary); }

        /* Article Header */
        .article-header {
            background: linear-gradient(160deg, #0f0c29 0%, #1a1145 30%, #302b63 60%, #24243e 100%);
            padding: 140px 0 60px; text-align: center; position: relative; overflow: hidden;
        }
        .article-header::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(ellipse at 30% 40%, rgba(99,102,241,0.25) 0%, transparent 55%),
                        radial-gradient(ellipse at 70% 60%, rgba(6,182,212,0.2) 0%, transparent 55%);
        }
        .article-header-content { position: relative; z-index: 1; }
        .article-cat {
            display: inline-block; padding: 5px 16px; border-radius: 50px;
            font-size: 0.78rem; font-weight: 600; margin-bottom: 16px;
            background: rgba(255,255,255,0.12); color: rgba(255,255,255,0.9);
            border: 1px solid rgba(255,255,255,0.15);
        }
        .article-title {
            font-size: 2.2rem; font-weight: 700; color: var(--white); line-height: 1.35;
            margin-bottom: 16px; max-width: 700px; margin-left: auto; margin-right: auto;
        }
        .article-meta {
            display: flex; justify-content: center; align-items: center; gap: 20px;
            font-size: 0.85rem; color: rgba(255,255,255,0.6);
        }
        .article-meta i { margin-<?= $dir === 'rtl' ? 'left' : 'right' ?>: 6px; }

        /* Featured Image */
        .featured-image-wrap { margin: -30px auto 0; max-width: 800px; padding: 0 24px; position: relative; z-index: 2; }
        .featured-image {
            width: 100%; max-height: 450px; object-fit: cover; border-radius: var(--radius-xl);
            box-shadow: var(--shadow-xl);
        }

        /* Article Content */
        .article-content { padding: 40px 0 60px; }
        .article-body {
            background: var(--white); border-radius: var(--radius-lg); padding: 40px;
            box-shadow: var(--shadow); line-height: 1.9; font-size: 1.02rem; color: var(--dark-700);
        }
        .article-body h2 { font-size: 1.5rem; font-weight: 700; color: var(--dark); margin: 32px 0 12px; }
        .article-body h3 { font-size: 1.2rem; font-weight: 700; color: var(--dark); margin: 24px 0 8px; }
        .article-body p { margin-bottom: 16px; }
        .article-body img { border-radius: var(--radius); margin: 16px 0; }
        .article-body ul, .article-body ol { margin-bottom: 16px; padding-<?= $dir === 'rtl' ? 'right' : 'left' ?>: 24px; }
        .article-body li { margin-bottom: 8px; }
        .article-body a { color: var(--primary); text-decoration: underline; }
        .article-body blockquote {
            border-<?= $dir === 'rtl' ? 'right' : 'left' ?>: 4px solid var(--primary);
            padding: 16px 24px; margin: 24px 0;
            background: var(--gray-50); border-radius: 0 var(--radius) var(--radius) 0;
            color: var(--gray-600); font-style: italic;
        }

        /* Back Link */
        .back-link {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 24px; border-radius: 50px; font-weight: 600; font-size: 0.9rem;
            font-family: var(--font); border: 2px solid var(--gray-200); color: var(--dark-600);
            transition: var(--transition); margin-bottom: 30px;
        }
        .back-link:hover { border-color: var(--primary); color: var(--primary); background: rgba(99,102,241,0.04); }

        /* Tags */
        .article-tags { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 24px; padding-top: 24px; border-top: 1px solid var(--gray-200); }
        .article-tag {
            padding: 4px 12px; border-radius: 50px; font-size: 0.78rem; font-weight: 500;
            background: var(--gray-100); color: var(--gray-600);
        }

        /* Related Posts */
        .related-section { padding: 0 0 80px; }
        .related-title { font-size: 1.4rem; font-weight: 700; color: var(--dark); margin-bottom: 24px; text-align: center; }
        .related-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; max-width: 1000px; margin: 0 auto; }
        .related-card {
            background: var(--white); border: 1px solid var(--gray-200); border-radius: var(--radius-lg);
            overflow: hidden; transition: var(--transition);
        }
        .related-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: transparent; }
        .related-card-img { width: 100%; height: 160px; object-fit: cover; background: var(--gray-100); }
        .related-card-body { padding: 18px; }
        .related-card-cat {
            display: inline-block; padding: 3px 10px; border-radius: 50px;
            font-size: 0.7rem; font-weight: 600; margin-bottom: 8px;
            background: linear-gradient(135deg, rgba(99,102,241,0.08), rgba(6,182,212,0.08)); color: var(--primary);
        }
        .related-card-title {
            font-size: 0.95rem; font-weight: 700; color: var(--dark); line-height: 1.5; margin-bottom: 6px;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .related-card-title a:hover { color: var(--primary); }
        .related-card-meta { font-size: 0.78rem; color: var(--gray-400); }

        @media (max-width: 768px) {
            .article-title { font-size: 1.6rem; }
            .article-body { padding: 24px; }
            .related-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <header>
    <nav class="navbar" role="navigation" aria-label="Main navigation">
        <div class="container" style="max-width:800px;">
            <div class="nav-inner">
                <a href="<?= $siteUrl ?>" class="logo-link" aria-label="<?= htmlspecialchars($siteName) ?> - <?= $lang === 'en' ? 'Home' : 'الرئيسية' ?>">
                    <i class="fas fa-cube" aria-hidden="true"></i>
                    <span><?= htmlspecialchars($siteName) ?></span>
                </a>
                <div class="nav-menu" role="menubar">
                    <a href="<?= $siteUrl ?>" class="nav-link" role="menuitem"><?= $lang === 'en' ? 'Home' : 'الرئيسية' ?></a>
                    <a href="<?= $siteUrl ?>/blog" class="nav-link" role="menuitem"><?= $lang === 'en' ? 'Blog' : 'المدونة' ?></a>
                </div>
            </div>
        </div>
    </nav>
    </header>

    <main id="main-content">

    <!-- Article Header -->
    <section class="article-header" role="region" aria-label="<?= $lang === 'en' ? 'Article header' : 'رأس المقال' ?>">
        <div class="article-header-content">
            <?php if (!empty($post->category)): ?>
            <div class="article-cat"><?= htmlspecialchars($post->category) ?></div>
            <?php endif; ?>
            <h1 class="article-title"><?= htmlspecialchars($post->title) ?></h1>
            <div class="article-meta">
                <time datetime="<?= date('c', strtotime($post->published_at ?? $post->created_at)) ?>"><i class="far fa-calendar-alt" aria-hidden="true"></i> <?= date('Y/m/d', strtotime($post->published_at ?? $post->created_at)) ?></time>
                <?php if (!empty($post->updated_at) && $post->updated_at !== $post->created_at): ?>
                <span><i class="far fa-edit" aria-hidden="true"></i> <?= $lang === 'en' ? 'Updated' : 'محدث' ?>: <time datetime="<?= date('c', strtotime($post->updated_at)) ?>"><?= date('Y/m/d', strtotime($post->updated_at)) ?></time></span>
                <?php endif; ?>
                <span><i class="far fa-eye" aria-hidden="true"></i> <?= number_format($post->views ?? 0) ?> <?= $lang === 'en' ? 'views' : 'مشاهدة' ?></span>
            </div>
        </div>
    </section>

    <!-- Featured Image -->
    <?php if (!empty($post->featured_image)): ?>
    <div class="featured-image-wrap">
        <img src="<?= htmlspecialchars($post->featured_image) ?>" alt="<?= htmlspecialchars($post->title) ?>" class="featured-image" loading="eager" width="800" height="450">
    </div>
    <?php endif; ?>

    <!-- Article Content -->
    <section class="article-content" aria-label="<?= $lang === 'en' ? 'Article content' : 'محتوى المقال' ?>">
        <div class="container" style="max-width:800px;">
            <nav aria-label="<?= $lang === 'en' ? 'Breadcrumb' : 'مسار التنقل' ?>" style="margin-bottom:30px;">
                <a href="<?= $siteUrl ?>/blog" class="back-link">
                    <i class="fas fa-arrow-<?= $dir === 'rtl' ? 'right' : 'left' ?>" aria-hidden="true"></i>
                    <?= $lang === 'en' ? 'Back to Blog' : 'العودة للمدونة' ?>
                </a>
            </nav>

            <article class="article-body" itemscope itemtype="https://schema.org/Article">
                <meta itemprop="headline" content="<?= htmlspecialchars($post->title ?? '') ?>">
                <meta itemprop="datePublished" content="<?= $post->published_at ?? $post->created_at ?? '' ?>">
                <?php if (!empty($post->updated_at)): ?>
                <meta itemprop="dateModified" content="<?= $post->updated_at ?>">
                <?php endif; ?>
                <meta itemprop="author" content="<?= htmlspecialchars($siteName) ?>">
                <meta itemprop="image" content="<?= htmlspecialchars($post->featured_image ?? '') ?>">
                <div itemprop="articleBody">
                    <?= $post->content ?>
                </div>
            </article>

            <?php if (!empty($post->tags)): ?>
            <div class="article-tags">
                <?php $tags = explode(',', $post->tags); foreach ($tags as $tag): ?>
                    <?php $tag = trim($tag); if (!empty($tag)): ?>
                    <span class="article-tag"><?= htmlspecialchars($tag) ?></span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <?php if (!empty($related)): ?>
    <!-- Related Posts -->
    <section class="related-section" aria-labelledby="related-heading">
        <div class="container" style="max-width:1000px;">
            <h3 class="related-title" id="related-heading"><?= $lang === 'en' ? 'Related Articles' : 'مقالات ذات صلة' ?></h3>
            <div class="related-grid">
                <?php foreach ($related as $rp): ?>
                <article class="related-card">
                    <?php if (!empty($rp->featured_image)): ?>
                        <img src="<?= htmlspecialchars($rp->featured_image) ?>" alt="<?= htmlspecialchars($rp->title) ?>" class="related-card-img" loading="lazy" width="320" height="160">
                    <?php else: ?>
                        <div class="related-card-img" style="display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,var(--primary),var(--accent));color:#fff;font-size:1.5rem;" role="img" aria-label="<?= $lang === 'en' ? 'Related article' : 'مقال ذو صلة' ?>"><i class="fas fa-newspaper" aria-hidden="true"></i></div>
                    <?php endif; ?>
                    <div class="related-card-body">
                        <?php if (!empty($rp->category)): ?>
                        <span class="related-card-cat"><?= htmlspecialchars($rp->category) ?></span>
                        <?php endif; ?>
                        <h4 class="related-card-title"><a href="<?= url('/blog/' . $rp->slug) ?>"><?= htmlspecialchars($rp->title) ?></a></h4>
                        <div class="related-card-meta"><time datetime="<?= date('c', strtotime($rp->published_at ?? $rp->created_at)) ?>"><i class="far fa-calendar-alt" aria-hidden="true"></i> <?= date('Y/m/d', strtotime($rp->published_at ?? $rp->created_at)) ?></time></div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    </main>
</body>
</html>
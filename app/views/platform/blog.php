<?php
/**
 * Platform Blog - Blog Listing (SEO-Optimized)
 * قائمة مقالات مدونة المنصة - متوافقة مع جوجل SEO
 */

$lang = $lang ?? Language::current();
$dir = Language::direction();
$siteName = defined('SITE_NAME') ? SITE_NAME : 'TakweenWeb';
$siteUrl = defined('BASE_URL') ? BASE_URL : (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
$pageTitle = $title ?? ($lang === 'en' ? 'Blog' : 'المدونة');
$metaDesc = $lang === 'en' ? 'Read the latest articles, tutorials, and news from TakweenWeb - Professional website builder tips and guides.' : 'اقرأ أحدث المقالات والدروس والأخبار من تكوين ويب - نصائح وإرشادات لإنشاء مواقع احترافية.';
$canonicalUrl = $siteUrl . '/blog' . (!empty($page) && $page > 1 ? '?page=' . $page : '');
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($metaDesc) ?>">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">
    <meta name="theme-color" content="#6366f1">
    <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl) ?>">
    <link rel="icon" href="<?= $siteUrl ?>/favicon.ico">

    <!-- Hreflang -->
    <link rel="alternate" hreflang="ar" href="<?= $siteUrl ?>/lang/ar">
    <link rel="alternate" hreflang="en" href="<?= $siteUrl ?>/lang/en">
    <link rel="alternate" hreflang="x-default" href="<?= $siteUrl ?>">

    <!-- Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($metaDesc) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonicalUrl) ?>">
    <meta property="og:site_name" content="<?= htmlspecialchars($siteName) ?>">
    <meta property="og:locale" content="<?= $lang === 'ar' ? 'ar_SA' : 'en_US' ?>">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($metaDesc) ?>">

    <!-- JSON-LD: BreadcrumbList + CollectionPage -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@graph": [
            {
                "@type": "CollectionPage",
                "@id": <?= json_encode($canonicalUrl) ?>,
                "name": <?= json_encode($pageTitle) ?>,
                "description": <?= json_encode($metaDesc) ?>,
                "url": <?= json_encode($canonicalUrl) ?>,
                "isPartOf": { "@id": <?= json_encode($siteUrl . '/#website') ?> },
                "inLanguage": <?= json_encode($lang === 'ar' ? 'ar-SA' : 'en-US') ?>
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
                        "item": <?= json_encode($canonicalUrl) ?>
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
        .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }

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

        /* Page Header */
        .page-header {
            background: linear-gradient(160deg, #0f0c29 0%, #1a1145 30%, #302b63 60%, #24243e 100%);
            padding: 140px 0 80px; text-align: center; position: relative; overflow: hidden;
        }
        .page-header::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(ellipse at 30% 40%, rgba(99,102,241,0.25) 0%, transparent 55%),
                        radial-gradient(ellipse at 70% 60%, rgba(6,182,212,0.2) 0%, transparent 55%);
        }
        .page-header h1 { font-size: 2.6rem; font-weight: 700; color: var(--white); margin-bottom: 12px; position: relative; z-index: 1; }
        .page-header p { font-size: 1.05rem; color: rgba(255,255,255,0.7); max-width: 500px; margin: 0 auto; position: relative; z-index: 1; }

        /* Blog Grid */
        .blog-section { padding: 60px 0 80px; }
        .blog-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; }
        .blog-card {
            background: var(--white); border: 1px solid var(--gray-200); border-radius: var(--radius-lg);
            overflow: hidden; transition: var(--transition);
        }
        .blog-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-xl); border-color: transparent; }
        .blog-card-img { width: 100%; height: 200px; object-fit: cover; background: var(--gray-100); }
        .blog-card-body { padding: 24px; }
        .blog-card-cat {
            display: inline-block; padding: 4px 12px; border-radius: 50px;
            font-size: 0.72rem; font-weight: 600; margin-bottom: 12px;
            background: linear-gradient(135deg, rgba(99,102,241,0.08), rgba(6,182,212,0.08));
            color: var(--primary);
        }
        .blog-card-title {
            font-size: 1.1rem; font-weight: 700; color: var(--dark); margin-bottom: 8px; line-height: 1.5;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .blog-card-title a:hover { color: var(--primary); }
        .blog-card-excerpt {
            font-size: 0.88rem; color: var(--gray-500); line-height: 1.7; margin-bottom: 16px;
            display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
        }
        .blog-card-meta { display: flex; justify-content: space-between; align-items: center; font-size: 0.8rem; color: var(--gray-400); }
        .blog-card-link { color: var(--primary); font-weight: 600; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 6px; }
        .blog-card-link:hover { gap: 10px; }

        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 24px; border-radius: 50px; font-weight: 600; font-size: 0.9rem; font-family: var(--font); border: none; cursor: pointer; transition: var(--transition); }
        .btn-outline { background: transparent; border: 2px solid var(--gray-200); color: var(--dark-600); }
        .btn-outline:hover { border-color: var(--primary); color: var(--primary); background: rgba(99,102,241,0.04); }

        /* Pagination */
        .pagination { display: flex; justify-content: center; gap: 8px; margin-top: 40px; }
        .pagination a, .pagination span {
            display: inline-flex; align-items: center; justify-content: center;
            width: 40px; height: 40px; border-radius: 10px; font-size: 0.9rem; font-weight: 600;
            border: 1px solid var(--gray-200); background: var(--white); color: var(--dark-600);
            transition: var(--transition);
        }
        .pagination a:hover { border-color: var(--primary); color: var(--primary); background: rgba(99,102,241,0.04); }
        .pagination .active { background: var(--primary); color: var(--white); border-color: var(--primary); }
        .pagination .disabled { opacity: 0.4; pointer-events: none; }

        .empty-state { text-align: center; padding: 80px 20px; color: var(--gray-400); }
        .empty-state i { font-size: 3rem; margin-bottom: 16px; display: block; }
        .empty-state p { font-size: 1.1rem; }

        @media (max-width: 1024px) { .blog-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) {
            .blog-grid { grid-template-columns: 1fr; }
            .page-header h1 { font-size: 2rem; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <header>
    <nav class="navbar" role="navigation" aria-label="Main navigation">
        <div class="container">
            <div class="nav-inner">
                <a href="<?= $siteUrl ?>" class="logo-link" aria-label="<?= htmlspecialchars($siteName) ?> - <?= $lang === 'en' ? 'Home' : 'الرئيسية' ?>">
                    <i class="fas fa-cube" aria-hidden="true"></i>
                    <span><?= htmlspecialchars($siteName) ?></span>
                </a>
                <div class="nav-menu" role="menubar">
                    <a href="<?= $siteUrl ?>" class="nav-link" role="menuitem"><?= $lang === 'en' ? 'Home' : 'الرئيسية' ?></a>
                    <a href="<?= $siteUrl ?>/blog" class="nav-link" role="menuitem" style="color:var(--primary)"><?= $lang === 'en' ? 'Blog' : 'المدونة' ?></a>
                </div>
            </div>
        </div>
    </nav>
    </header>

    <main id="main-content">

    <!-- Page Header -->
    <section class="page-header" role="region" aria-label="<?= $lang === 'en' ? 'Blog page header' : 'رأس صفحة المدونة' ?>">
        <h1><?= $lang === 'en' ? 'Blog' : 'المدونة' ?></h1>
        <p><?= $lang === 'en' ? 'Tips, tutorials, and updates to help you build better websites' : 'نصائح ودروس وتحديثات تساعدك في بناء موقع أفضل' ?></p>
    </section>

    <!-- Blog Listing -->
    <section class="blog-section" aria-label="<?= $lang === 'en' ? 'Blog articles' : 'مقالات المدونة' ?>">
        <div class="container">
            <?php if (!empty($posts)): ?>
            <div class="blog-grid">
                <?php foreach ($posts as $post): ?>
                <article class="blog-card">
                    <?php if (!empty($post->featured_image)): ?>
                        <img src="<?= htmlspecialchars($post->featured_image) ?>" alt="<?= htmlspecialchars($post->title) ?>" class="blog-card-img" loading="lazy" width="400" height="200">
                    <?php else: ?>
                        <div class="blog-card-img" style="display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,var(--primary),var(--accent));color:#fff;font-size:2rem;" role="img" aria-label="<?= $lang === 'en' ? 'Blog article' : 'مقال مدونة' ?>"><i class="fas fa-newspaper" aria-hidden="true"></i></div>
                    <?php endif; ?>
                    <div class="blog-card-body">
                        <?php if (!empty($post->category)): ?>
                        <span class="blog-card-cat"><?= htmlspecialchars($post->category) ?></span>
                        <?php endif; ?>
                        <h2 class="blog-card-title">
                            <a href="<?= url('/blog/' . $post->slug) ?>"><?= htmlspecialchars($post->title) ?></a>
                        </h2>
                        <p class="blog-card-excerpt"><?= htmlspecialchars($post->excerpt ?? mb_substr(strip_tags($post->content), 0, 150) . '...') ?></p>
                        <div class="blog-card-meta">
                            <time datetime="<?= date('c', strtotime($post->published_at ?? $post->created_at)) ?>"><i class="far fa-calendar-alt" aria-hidden="true"></i> <?= date('Y/m/d', strtotime($post->published_at ?? $post->created_at)) ?></time>
                            <a href="<?= url('/blog/' . $post->slug) ?>" class="blog-card-link"><?= $lang === 'en' ? 'Read More' : 'اقرأ المزيد' ?> <i class="fas fa-arrow-left" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>

            <?php if (!empty($totalPages) && $totalPages > 1): ?>
            <nav class="pagination" aria-label="<?= $lang === 'en' ? 'Blog pagination' : 'تنقل صفحات المدونة' ?>">
                <?php if ($page > 1): ?>
                    <a href="<?= url('/blog?page=' . ($page - 1)) ?>" aria-label="<?= $lang === 'en' ? 'Previous page' : 'الصفحة السابقة' ?>"><i class="fas fa-chevron-<?= $dir === 'rtl' ? 'right' : 'left' ?>" aria-hidden="true"></i></a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php if ($i === $page): ?>
                        <span class="active" aria-current="page"><?= $i ?></span>
                    <?php else: ?>
                        <a href="<?= url('/blog?page=' . $i) ?>"><?= $i ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="<?= url('/blog?page=' . ($page + 1)) ?>" aria-label="<?= $lang === 'en' ? 'Next page' : 'الصفحة التالية' ?>"><i class="fas fa-chevron-<?= $dir === 'rtl' ? 'left' : 'right' ?>" aria-hidden="true"></i></a>
                <?php endif; ?>
            </nav>
            <?php endif; ?>

            <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-newspaper" aria-hidden="true"></i>
                <p><?= $lang === 'en' ? 'No articles yet. Stay tuned!' : 'لا توجد مقالات بعد. ترقبوا الجديد!' ?></p>
            </div>
            <?php endif; ?>
        </div>
    </section>

    </main>
</body>
</html>
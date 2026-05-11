<?php
/**
 * TakweenWeb - Professional Landing Page (SEO-Optimized)
 * صفحة الهبوط الاحترافية - متوافقة مع جوجل SEO
 * 
 * المتغيرات المطلوبة من الكنترولر:
 * $settings  - إعدادات الموقع (site_settings)
 * $testimonials - شهادات العملاء (site_testimonials)
 * $features  - مميزات المنصة (site_features)
 * $blogPosts - آخر 3 مقالات مدونة المنصة (platform_blog_posts)
 */

$lang = Language::current();
$dir  = Language::direction();
$year = date('Y');

$siteUrl = defined('BASE_URL') ? BASE_URL : (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
$siteName = defined('SITE_NAME') ? SITE_NAME : 'TakweenWeb';
$fullTitle = (!empty($settings->meta_title) ? htmlspecialchars($settings->meta_title) : htmlspecialchars($siteName)) . ' - ' . ($lang === 'en' ? 'Professional Website Builder' : 'إنشاء مواقع احترافية');
$metaDesc = !empty($settings->meta_description) ? htmlspecialchars($settings->meta_description) : ($lang === 'en' ? 'Create your professional website easily with TakweenWeb. Choose templates, customize, and publish in minutes.' : 'أنشئ موقعك الاحترافي بسهولة مع تكوين ويب. اختر قالبك، خصصه، وانشر موقعك خلال دقائق.');
$metaKeywords = !empty($settings->meta_keywords) ? htmlspecialchars($settings->meta_keywords) : ($lang === 'en' ? 'website builder, create website, professional templates, Arabic website, CMS' : 'إنشاء موقع, منصة مواقع, قوالب احترافية, موقع عربي, تكوين ويب');
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $fullTitle ?></title>
    <meta name="description" content="<?= $metaDesc ?>">
    <meta name="keywords" content="<?= $metaKeywords ?>">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="author" content="<?= htmlspecialchars($siteName) ?>">
    <meta name="theme-color" content="#6366f1">

    <?php if (!empty($settings->favicon)): ?>
    <link rel="icon" type="image/png" href="<?= htmlspecialchars($settings->favicon) ?>">
    <?php endif; ?>

    <!-- Canonical URL -->
    <link rel="canonical" href="<?= $siteUrl ?>">

    <!-- Hreflang for multilingual SEO -->
    <link rel="alternate" hreflang="ar" href="<?= $siteUrl ?>/lang/ar">
    <link rel="alternate" hreflang="en" href="<?= $siteUrl ?>/lang/en">
    <link rel="alternate" hreflang="x-default" href="<?= $siteUrl ?>">

    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= $fullTitle ?>">
    <meta property="og:description" content="<?= $metaDesc ?>">
    <meta property="og:url" content="<?= $siteUrl ?>">
    <meta property="og:site_name" content="<?= htmlspecialchars($siteName) ?>">
    <?php if (!empty($settings->logo)): ?>
    <meta property="og:image" content="<?= htmlspecialchars($settings->logo) ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <?php endif; ?>
    <meta property="og:locale" content="<?= $lang === 'ar' ? 'ar_SA' : 'en_US' ?>">
    <meta property="og:locale:alternate" content="<?= $lang === 'ar' ? 'en_US' : 'ar_SA' ?>">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $fullTitle ?>">
    <meta name="twitter:description" content="<?= $metaDesc ?>">
    <?php if (!empty($settings->logo)): ?>
    <meta name="twitter:image" content="<?= htmlspecialchars($settings->logo) ?>">
    <?php endif; ?>

    <!-- JSON-LD: WebSite + Organization + BreadcrumbList -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@graph": [
            {
                "@type": "WebSite",
                "@id": <?= json_encode($siteUrl . '/#website') ?>,
                "name": <?= json_encode($siteName) ?>,
                "url": <?= json_encode($siteUrl) ?>,
                "description": <?= json_encode($metaDesc) ?>,
                "inLanguage": ["ar-SA", "en-US"],
                "potentialAction": {
                    "@type": "SearchAction",
                    "target": <?= json_encode($siteUrl . '/blog?q={search_term_string}') ?>,
                    "query-input": "required name=search_term_string"
                }
            },
            {
                "@type": "Organization",
                "@id": <?= json_encode($siteUrl . '/#organization') ?>,
                "name": <?= json_encode($siteName) ?>,
                "url": <?= json_encode($siteUrl) ?>,
                "logo": {
                    "@type": "ImageObject",
                    "url": <?= json_encode(!empty($settings->logo) ? $settings->logo : '') ?>
                },
                "sameAs": [
                    <?php if (!empty($settings->twitter)): ?><?= json_encode($settings->twitter) ?><?php endif; ?>,
                    <?php if (!empty($settings->facebook)): ?><?= json_encode($settings->facebook) ?><?php endif; ?>,
                    <?php if (!empty($settings->instagram)): ?><?= json_encode($settings->instagram) ?><?php endif; ?>,
                    <?php if (!empty($settings->linkedin)): ?><?= json_encode($settings->linkedin) ?><?php endif; ?>
                ]
            },
            {
                "@type": "WebPage",
                "@id": <?= json_encode($siteUrl . '/#webpage') ?>,
                "url": <?= json_encode($siteUrl) ?>,
                "name": <?= json_encode($fullTitle) ?>,
                "isPartOf": { "@id": <?= json_encode($siteUrl . '/#website') ?> },
                "about": { "@id": <?= json_encode($siteUrl . '/#organization') ?> },
                "inLanguage": <?= json_encode($lang === 'ar' ? 'ar-SA' : 'en-US') ?>,
                "breadcrumb": { "@id": <?= json_encode($siteUrl . '/#breadcrumb') ?> }
            },
            {
                "@type": "BreadcrumbList",
                "@id": <?= json_encode($siteUrl . '/#breadcrumb') ?>,
                "itemListElement": [
                    {
                        "@type": "ListItem",
                        "position": 1,
                        "name": <?= json_encode($lang === 'en' ? 'Home' : 'الرئيسية') ?>,
                        "item": <?= json_encode($siteUrl) ?>
                    }
                ]
            }
        ]
    }
    </script>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #818cf8;
            --accent: #06b6d4;
            --accent-dark: #0891b2;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #0f172a;
            --dark-700: #1e293b;
            --dark-600: #334155;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --white: #ffffff;
            --radius: 12px;
            --radius-lg: 20px;
            --radius-xl: 28px;
            --shadow: 0 4px 24px rgba(0,0,0,0.06);
            --shadow-lg: 0 12px 40px rgba(0,0,0,0.1);
            --shadow-xl: 0 20px 60px rgba(0,0,0,0.15);
            --transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            --font: 'Readex Pro', sans-serif;
        }

        body {
            font-family: var(--font);
            background: var(--white);
            color: var(--dark);
            line-height: 1.7;
            overflow-x: hidden;
        }

        a { text-decoration: none; color: inherit; }
        img { max-width: 100%; height: auto; }
        ul { list-style: none; }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }

        /* ==================== NAVBAR ==================== */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            padding: 16px 0;
            transition: var(--transition);
            background: transparent;
        }
        .navbar.scrolled {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 1px 20px rgba(0,0,0,0.06);
            padding: 10px 0;
        }
        .navbar .nav-inner {
            display: flex; justify-content: space-between; align-items: center;
        }
        .navbar .logo-link {
            display: flex; align-items: center; gap: 10px;
            font-size: 1.4rem; font-weight: 700; color: var(--white);
            transition: var(--transition);
        }
        .navbar.scrolled .logo-link { color: var(--primary-dark); }
        .navbar .logo-link i { font-size: 1.5rem; }
        .navbar .logo-link img { height: 36px; width: auto; }

        .nav-menu { display: flex; align-items: center; gap: 6px; }
        .nav-menu .nav-link {
            padding: 8px 16px; border-radius: 8px; font-weight: 500;
            font-size: 0.92rem; color: rgba(255,255,255,0.85);
            transition: var(--transition);
        }
        .navbar.scrolled .nav-menu .nav-link { color: var(--dark-600); }
        .nav-menu .nav-link:hover { background: rgba(255,255,255,0.12); color: #fff; }
        .navbar.scrolled .nav-menu .nav-link:hover { background: rgba(99,102,241,0.08); color: var(--primary); }

        .lang-switch {
            display: flex; gap: 2px; padding: 3px;
            background: rgba(255,255,255,0.12); border-radius: 50px;
        }
        .navbar.scrolled .lang-switch { background: var(--gray-100); }
        .lang-btn {
            padding: 5px 14px; border-radius: 50px; font-size: 0.78rem;
            font-weight: 600; border: none; cursor: pointer;
            color: rgba(255,255,255,0.7); background: transparent;
            transition: var(--transition); font-family: var(--font);
        }
        .navbar.scrolled .lang-btn { color: var(--gray-500); }
        .lang-btn.active { background: var(--white); color: var(--primary); box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .navbar.scrolled .lang-btn.active { background: var(--primary); color: var(--white); }

        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 24px; border-radius: 50px; font-weight: 600;
            font-size: 0.9rem; font-family: var(--font); border: none;
            cursor: pointer; transition: var(--transition); line-height: 1.4;
        }
        .btn:hover { transform: translateY(-2px); }
        .btn-primary { background: var(--primary); color: var(--white); box-shadow: 0 4px 16px rgba(99,102,241,0.35); }
        .btn-primary:hover { background: var(--primary-dark); box-shadow: 0 8px 24px rgba(99,102,241,0.45); }
        .btn-white { background: var(--white); color: var(--primary-dark); box-shadow: var(--shadow); }
        .btn-white:hover { box-shadow: var(--shadow-lg); }
        .btn-outline-w {
            background: transparent; border: 2px solid rgba(255,255,255,0.5); color: var(--white);
        }
        .btn-outline-w:hover { background: var(--white); color: var(--primary-dark); border-color: var(--white); }
        .btn-outline { background: transparent; border: 2px solid var(--gray-200); color: var(--dark-600); }
        .btn-outline:hover { border-color: var(--primary); color: var(--primary); background: rgba(99,102,241,0.04); }
        .btn-lg { padding: 14px 32px; font-size: 1rem; }

        .mobile-toggle {
            display: none; background: none; border: none; font-size: 1.4rem;
            color: var(--white); cursor: pointer; padding: 8px;
        }
        .navbar.scrolled .mobile-toggle { color: var(--dark); }

        /* ==================== HERO ==================== */
        .hero {
            min-height: 100vh; display: flex; align-items: center;
            justify-content: center; text-align: center;
            padding: 120px 24px 80px; position: relative; overflow: hidden;
            background: linear-gradient(160deg, #0f0c29 0%, #1a1145 30%, #302b63 60%, #24243e 100%);
        }
        .hero::before {
            content: ''; position: absolute; inset: 0;
            background:
                radial-gradient(ellipse at 25% 40%, rgba(99,102,241,0.25) 0%, transparent 55%),
                radial-gradient(ellipse at 75% 60%, rgba(6,182,212,0.2) 0%, transparent 55%),
                radial-gradient(ellipse at 50% 90%, rgba(139,92,246,0.15) 0%, transparent 50%);
        }
        .hero::after {
            content: ''; position: absolute; inset: 0; opacity: 0.04;
            background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23ffffff'%3E%3Ccircle cx='40' cy='40' r='1.5'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .hero-content { position: relative; z-index: 2; max-width: 820px; }

        .hero-chip {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);
            padding: 8px 20px; border-radius: 50px; font-size: 0.88rem;
            color: rgba(255,255,255,0.9); margin-bottom: 24px;
            backdrop-filter: blur(10px);
            animation: fadeUp 0.7s ease-out;
        }
        .hero-chip i { color: var(--warning); }

        .hero h1 {
            font-size: 3.6rem; font-weight: 700; color: var(--white);
            margin-bottom: 20px; line-height: 1.25;
            animation: fadeUp 0.7s ease-out 0.1s both;
        }
        .hero h1 .grad {
            background: linear-gradient(135deg, #818cf8, #06b6d4, #a78bfa);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero .hero-desc {
            font-size: 1.15rem; color: rgba(255,255,255,0.7);
            max-width: 600px; margin: 0 auto 36px; line-height: 1.85;
            animation: fadeUp 0.7s ease-out 0.2s both;
        }
        .hero-actions {
            display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;
            animation: fadeUp 0.7s ease-out 0.3s both;
        }

        .hero-orbs { position: absolute; inset: 0; z-index: 1; pointer-events: none; overflow: hidden; }
        .orb {
            position: absolute; border-radius: 50%;
            filter: blur(80px); opacity: 0.3;
            animation: orbFloat 20s ease-in-out infinite;
        }
        .orb:nth-child(1) { width: 400px; height: 400px; top: -10%; right: -5%; background: #6366f1; animation-delay: 0s; }
        .orb:nth-child(2) { width: 300px; height: 300px; bottom: -5%; left: -3%; background: #06b6d4; animation-delay: 7s; }
        .orb:nth-child(3) { width: 250px; height: 250px; top: 40%; left: 15%; background: #8b5cf6; animation-delay: 14s; }

        @keyframes orbFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.05); }
            66% { transform: translate(-20px, 20px) scale(0.95); }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ==================== SECTIONS COMMON ==================== */
        .section { padding: 100px 0; }
        .section-head { text-align: center; margin-bottom: 56px; }
        .section-chip {
            display: inline-flex; align-items: center; gap: 6px;
            background: linear-gradient(135deg, rgba(99,102,241,0.08), rgba(6,182,212,0.08));
            color: var(--primary); padding: 6px 18px; border-radius: 50px;
            font-size: 0.82rem; font-weight: 600; margin-bottom: 14px;
        }
        .section-title {
            font-size: 2.3rem; font-weight: 700; color: var(--dark);
            margin-bottom: 12px; line-height: 1.3;
        }
        .section-sub {
            font-size: 1.05rem; color: var(--gray-500); max-width: 520px; margin: 0 auto;
        }

        /* ==================== FEATURES ==================== */
        .features-section { background: var(--white); }
        .features-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;
        }
        .feat-card {
            background: var(--white); border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg); padding: 36px 28px;
            text-align: center; transition: var(--transition);
            position: relative; overflow: hidden;
        }
        .feat-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            transform: scaleX(0); transition: transform 0.35s ease;
        }
        .feat-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-xl); border-color: transparent; }
        .feat-card:hover::before { transform: scaleX(1); }
        .feat-icon {
            width: 68px; height: 68px; border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px; font-size: 1.6rem; transition: var(--transition);
        }
        .feat-icon.i1 { background: linear-gradient(135deg, rgba(99,102,241,0.1), rgba(129,140,248,0.1)); color: var(--primary); }
        .feat-icon.i2 { background: linear-gradient(135deg, rgba(6,182,212,0.1), rgba(34,211,238,0.1)); color: var(--accent); }
        .feat-icon.i3 { background: linear-gradient(135deg, rgba(16,185,129,0.1), rgba(52,211,153,0.1)); color: var(--success); }
        .feat-card:hover .feat-icon { transform: scale(1.1); }
        .feat-card h3 { font-size: 1.1rem; font-weight: 700; color: var(--dark); margin-bottom: 8px; }
        .feat-card p { color: var(--gray-500); font-size: 0.9rem; line-height: 1.7; }

        /* ==================== HOW IT WORKS ==================== */
        .how-section { background: var(--gray-50); }
        .steps-grid {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 28px;
            position: relative;
        }
        .steps-grid::before {
            content: ''; position: absolute; top: 44px; left: 12%; right: 12%;
            height: 2px; background: linear-gradient(90deg, var(--primary), var(--accent));
            border-radius: 2px; z-index: 0;
        }
        .step { text-align: center; position: relative; z-index: 1; }
        .step-num {
            width: 56px; height: 56px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: var(--white); font-size: 1.3rem; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px; box-shadow: 0 6px 20px rgba(99,102,241,0.3);
        }
        .step h3 { font-size: 1.02rem; font-weight: 700; color: var(--dark); margin-bottom: 6px; }
        .step p { color: var(--gray-500); font-size: 0.85rem; line-height: 1.6; max-width: 200px; margin: 0 auto; }

        /* ==================== BLOG ==================== */
        .blog-section { background: var(--white); }
        .blog-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px;
        }
        .blog-card {
            background: var(--white); border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg); overflow: hidden;
            transition: var(--transition);
        }
        .blog-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-xl); border-color: transparent; }
        .blog-card-img {
            width: 100%; height: 200px; object-fit: cover;
            background: var(--gray-100);
        }
        .blog-card-body { padding: 24px; }
        .blog-card-cat {
            display: inline-block; padding: 4px 12px; border-radius: 50px;
            font-size: 0.72rem; font-weight: 600; margin-bottom: 12px;
            background: linear-gradient(135deg, rgba(99,102,241,0.08), rgba(6,182,212,0.08));
            color: var(--primary);
        }
        .blog-card-title {
            font-size: 1.1rem; font-weight: 700; color: var(--dark);
            margin-bottom: 8px; line-height: 1.5;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .blog-card-title a:hover { color: var(--primary); }
        .blog-card-excerpt {
            font-size: 0.88rem; color: var(--gray-500); line-height: 1.7;
            margin-bottom: 16px;
            display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
        }
        .blog-card-meta {
            display: flex; justify-content: space-between; align-items: center;
            font-size: 0.8rem; color: var(--gray-400);
        }
        .blog-card-link {
            color: var(--primary); font-weight: 600; font-size: 0.85rem;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .blog-card-link:hover { gap: 10px; }

        /* ==================== TESTIMONIALS ==================== */
        .testimonials-section { background: var(--gray-50); }
        .testimonials-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;
        }
        .testi-card {
            background: var(--white); border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg); padding: 32px;
            transition: var(--transition); position: relative;
        }
        .testi-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: transparent; }
        .testi-card::before {
            content: '\201C'; position: absolute; top: 12px; <?= $dir === 'rtl' ? 'right' : 'left' ?>: 18px;
            font-size: 3.5rem; color: var(--primary); opacity: 0.1;
            font-family: Georgia, serif; line-height: 1;
        }
        .testi-stars { display: flex; gap: 3px; margin-bottom: 14px; color: var(--warning); font-size: 0.85rem; }
        .testi-text { font-size: 0.93rem; color: var(--gray-600); line-height: 1.85; margin-bottom: 20px; position: relative; z-index: 1; }
        .testi-author { display: flex; align-items: center; gap: 12px; }
        .testi-avatar {
            width: 44px; height: 44px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex; align-items: center; justify-content: center;
            color: var(--white); font-weight: 700; font-size: 1rem; flex-shrink: 0;
        }
        .testi-avatar img { width: 100%; height: 100%; border-radius: 50%; object-fit: cover; }
        .testi-name { font-weight: 700; color: var(--dark); font-size: 0.92rem; }
        .testi-role { font-size: 0.8rem; color: var(--gray-500); }

        /* ==================== STATS ==================== */
        .stats-section {
            padding: 60px 0; position: relative; overflow: hidden;
            background: linear-gradient(135deg, var(--dark) 0%, #1a1145 100%);
        }
        .stats-section::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(ellipse at 30% 50%, rgba(99,102,241,0.18) 0%, transparent 60%),
                        radial-gradient(ellipse at 70% 50%, rgba(6,182,212,0.12) 0%, transparent 60%);
        }
        .stats-grid {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 28px;
            position: relative; z-index: 2; max-width: 960px; margin: 0 auto;
        }
        .stat { text-align: center; }
        .stat-val {
            font-size: 2.6rem; font-weight: 700; color: var(--white); line-height: 1.2;
        }
        .stat-val span {
            background: linear-gradient(135deg, #818cf8, #06b6d4);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .stat-lbl { color: var(--gray-400); font-size: 0.88rem; margin-top: 4px; }

        /* ==================== CTA ==================== */
        .cta-section {
            padding: 90px 0; text-align: center; position: relative; overflow: hidden;
            background: linear-gradient(135deg, var(--primary) 0%, #7c3aed 50%, var(--accent-dark) 100%);
        }
        .cta-section::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(ellipse at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%),
                        radial-gradient(ellipse at 80% 50%, rgba(255,255,255,0.06) 0%, transparent 50%);
        }
        .cta-inner { position: relative; z-index: 2; max-width: 560px; margin: 0 auto; }
        .cta-inner h2 { font-size: 2.2rem; font-weight: 700; color: var(--white); margin-bottom: 14px; }
        .cta-inner p { color: rgba(255,255,255,0.85); font-size: 1.08rem; margin-bottom: 32px; line-height: 1.85; }

        /* ==================== FOOTER ==================== */
        .footer {
            background: var(--dark); color: var(--gray-400); padding: 56px 0 24px;
        }
        .footer-top {
            display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 40px;
            margin-bottom: 36px; padding-bottom: 32px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .footer-brand .f-logo {
            display: flex; align-items: center; gap: 10px;
            font-size: 1.3rem; font-weight: 700; color: var(--white); margin-bottom: 12px;
        }
        .footer-brand .f-logo img { height: 30px; width: auto; }
        .footer-brand p { font-size: 0.88rem; line-height: 1.75; max-width: 300px; }
        .footer-col h4 { color: var(--white); font-size: 0.95rem; font-weight: 600; margin-bottom: 14px; }
        .footer-col li { margin-bottom: 8px; }
        .footer-col a { color: var(--gray-400); font-size: 0.88rem; transition: var(--transition); }
        .footer-col a:hover { color: var(--primary-light); }
        .footer-bottom {
            display: flex; justify-content: space-between; align-items: center;
            font-size: 0.82rem;
        }
        .footer-socials { display: flex; gap: 10px; }
        .footer-socials a {
            width: 36px; height: 36px; border-radius: 50%;
            background: rgba(255,255,255,0.05); display: flex;
            align-items: center; justify-content: center;
            color: var(--gray-400); transition: var(--transition);
        }
        .footer-socials a:hover { background: var(--primary); color: var(--white); transform: translateY(-3px); }

        /* ==================== ANIMATIONS ==================== */
        .reveal { opacity: 0; transform: translateY(28px); transition: opacity 0.65s ease, transform 0.65s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal:nth-child(2) { transition-delay: 0.08s; }
        .reveal:nth-child(3) { transition-delay: 0.16s; }
        .reveal:nth-child(4) { transition-delay: 0.24s; }
        .reveal:nth-child(5) { transition-delay: 0.32s; }
        .reveal:nth-child(6) { transition-delay: 0.4s; }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 1024px) {
            .features-grid, .testimonials-grid { grid-template-columns: repeat(2, 1fr); }
            .blog-grid { grid-template-columns: repeat(2, 1fr); }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .footer-top { grid-template-columns: 1fr 1fr; }
            .steps-grid { grid-template-columns: repeat(2, 1fr); gap: 32px; }
            .steps-grid::before { display: none; }
        }
        @media (max-width: 768px) {
            .mobile-toggle { display: block; }
            .nav-menu {
                display: none; position: absolute; top: 100%;
                left: 0; right: 0; background: var(--white);
                flex-direction: column; padding: 12px;
                box-shadow: var(--shadow-lg); gap: 4px;
            }
            .nav-menu.active { display: flex; }
            .nav-menu .nav-link {
                color: var(--dark-600); padding: 10px 16px; width: 100%; text-align: center;
                border-radius: 8px;
            }
            .nav-menu .nav-link:hover { color: var(--primary); background: var(--gray-50); }
            .hero h1 { font-size: 2.2rem; }
            .hero .hero-desc { font-size: 1rem; }
            .features-grid, .testimonials-grid, .blog-grid { grid-template-columns: 1fr; }
            .steps-grid { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 20px; }
            .stat-val { font-size: 2rem; }
            .cta-inner h2 { font-size: 1.7rem; }
            .footer-top { grid-template-columns: 1fr; gap: 28px; }
            .footer-bottom { flex-direction: column; gap: 12px; text-align: center; }
            .section-title { font-size: 1.75rem; }
            .section { padding: 70px 0; }
        }
        @media (max-width: 480px) {
            .hero { padding: 100px 16px 60px; }
            .hero h1 { font-size: 1.8rem; }
            .hero-actions { flex-direction: column; align-items: center; }
            .hero-actions .btn { width: 100%; max-width: 280px; justify-content: center; }
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <header>
    <nav class="navbar" id="navbar" role="navigation" aria-label="Main navigation">
        <div class="container">
            <div class="nav-inner">
                <a href="<?= defined('BASE_URL') ? BASE_URL : '/' ?>" class="logo-link" aria-label="<?= htmlspecialchars($siteName) ?> - <?= $lang === 'en' ? 'Home' : 'الرئيسية' ?>">
                    <?php if (!empty($settings->logo)): ?>
                        <img src="<?= htmlspecialchars($settings->logo) ?>" alt="<?= htmlspecialchars($siteName) ?>" width="36" height="36">
                    <?php else: ?>
                        <i class="fas fa-cube" aria-hidden="true"></i>
                    <?php endif; ?>
                    <span><?= htmlspecialchars($siteName) ?></span>
                </a>

                <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle menu" aria-expanded="false" aria-controls="navMenu"><i class="fas fa-bars" aria-hidden="true"></i></button>

                <div class="nav-menu" id="navMenu" role="menubar">
                    <div class="lang-switch" role="group" aria-label="<?= $lang === 'en' ? 'Language selection' : 'اختيار اللغة' ?>">
                        <a href="<?= url('/lang/ar') ?>" class="lang-btn <?= $lang === 'ar' ? 'active' : '' ?>" lang="ar" hreflang="ar">عربي</a>
                        <a href="<?= url('/lang/en') ?>" class="lang-btn <?= $lang === 'en' ? 'active' : '' ?>" lang="en" hreflang="en">EN</a>
                    </div>
                    <a href="#features" class="nav-link" role="menuitem"><?= $lang === 'en' ? 'Features' : 'المميزات' ?></a>
                    <a href="#how" class="nav-link" role="menuitem"><?= $lang === 'en' ? 'How It Works' : 'كيف يعمل' ?></a>
                    <a href="<?= url('/blog') ?>" class="nav-link" role="menuitem"><?= $lang === 'en' ? 'Blog' : 'المدونة' ?></a>
                    <a href="#testimonials" class="nav-link" role="menuitem"><?= $lang === 'en' ? 'Testimonials' : 'آراء العملاء' ?></a>
                    <?php if (function_exists('auth') && auth()): ?>
                        <a href="<?= url('/dashboard') ?>" class="nav-link" role="menuitem"><?= $lang === 'en' ? 'Dashboard' : 'لوحة التحكم' ?></a>
                        <a href="<?= url('/logout') ?>" class="btn btn-outline" role="menuitem"><?= $lang === 'en' ? 'Logout' : 'تسجيل الخروج' ?></a>
                    <?php else: ?>
                        <a href="<?= url('/login') ?>" class="nav-link" role="menuitem"><?= $lang === 'en' ? 'Login' : 'تسجيل الدخول' ?></a>
                        <a href="<?= url('/register') ?>" class="btn btn-primary" role="menuitem"><?= $lang === 'en' ? 'Start Free' : 'ابدأ مجاناً' ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    </header>

    <main id="main-content">

    <!-- HERO -->
    <section class="hero" aria-label="<?= $lang === 'en' ? 'Welcome section' : 'قسم الترحيب' ?>">
        <div class="hero-orbs" aria-hidden="true">
            <div class="orb"></div><div class="orb"></div><div class="orb"></div>
        </div>
        <div class="hero-content">
            <div class="hero-chip">
                <i class="fas fa-star" aria-hidden="true"></i>
                <span><?= !empty($settings->hero_title) ? htmlspecialchars($lang === 'en' ? 'Professional Website Builder Platform' : 'منصة إنشاء مواقع احترافية') : ($lang === 'en' ? 'Professional Website Builder Platform' : 'منصة إنشاء مواقع احترافية') ?></span>
            </div>
            <h1>
                <?= !empty($settings->hero_title) ? htmlspecialchars($settings->hero_title) : ($lang === 'en' ? 'Create Your <span class="grad">Professional</span> Website Today' : 'أنشئ موقعك <span class="grad">الاحترافي</span> اليوم') ?>
            </h1>
            <p class="hero-desc">
                <?= !empty($settings->hero_subtitle) ? htmlspecialchars($settings->hero_subtitle) : ($lang === 'en' ? 'An easy and flexible platform for creating professional websites without technical skills. Choose a template, customize it, and publish your site in minutes.' : 'منصة سهلة ومرنة لإنشاء مواقع احترافية بدون حاجة لخبرة تقنية. اختر قالبك، خصصه، وانشر موقعك خلال دقائق.') ?>
            </p>
            <div class="hero-actions">
                <?php if (function_exists('auth') && auth()): ?>
                    <a href="<?= url('/dashboard') ?>" class="btn btn-white btn-lg"><i class="fas fa-tachometer-alt" aria-hidden="true"></i> <?= $lang === 'en' ? 'Dashboard' : 'لوحة التحكم' ?></a>
                <?php else: ?>
                    <a href="<?= url('/register') ?>" class="btn btn-white btn-lg"><i class="fas fa-rocket" aria-hidden="true"></i> <?= $lang === 'en' ? 'Start Free' : 'ابدأ مجاناً' ?></a>
                    <a href="#how" class="btn btn-outline-w btn-lg"><i class="fas fa-play-circle" aria-hidden="true"></i> <?= $lang === 'en' ? 'How It Works' : 'كيف يعمل' ?></a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <?php if (!empty($settings->show_features) || !isset($settings->show_features)): ?>
    <section class="section features-section" id="features" role="region" aria-labelledby="features-heading">
        <div class="container">
            <div class="section-head">
                <div class="section-chip"><i class="fas fa-star" aria-hidden="true"></i> <?= !empty($settings->features_title) ? htmlspecialchars($settings->features_title) : ($lang === 'en' ? 'Why Choose Us?' : 'لماذا تختارنا؟') ?></div>
                <h2 class="section-title" id="features-heading"><?= $lang === 'en' ? 'Everything You Need in One Place' : 'كل ما تحتاجه في مكان واحد' ?></h2>
                <p class="section-sub"><?= $lang === 'en' ? 'Integrated tools to build your website with ease and professionalism' : 'أدوات متكاملة لبناء موقعك الإلكتروني بكل سهولة واحترافية' ?></p>
            </div>
            <div class="features-grid">
                <?php if (!empty($features)): ?>
                    <?php
                        $colors = ['i1','i2','i3','i1','i2','i3'];
                        $ci = 0;
                        foreach ($features as $f):
                    ?>
                        <article class="feat-card reveal">
                            <div class="feat-icon <?= $colors[$ci % 3] ?>">
                                <i class="<?= htmlspecialchars($f->display_title ?? ($f->icon ?? 'fas fa-star')) ?>" aria-hidden="true"></i>
                            </div>
                            <h3><?= htmlspecialchars($f->title ?? '') ?></h3>
                            <p><?= htmlspecialchars($f->display_description ?? ($f->description ?? '')) ?></p>
                        </article>
                        <?php $ci++; endforeach; ?>
                <?php else: ?>
                    <article class="feat-card reveal">
                        <div class="feat-icon i1"><i class="fas fa-palette" aria-hidden="true"></i></div>
                        <h3><?= $lang === 'en' ? 'Professional Templates' : 'قوالب احترافية' ?></h3>
                        <p><?= $lang === 'en' ? 'Choose from a wide range of diverse, professionally designed templates' : 'اختر من بين مجموعة واسعة من القوالب المتنوعة المصممة لكل مجال' ?></p>
                    </article>
                    <article class="feat-card reveal">
                        <div class="feat-icon i2"><i class="fas fa-mobile-alt" aria-hidden="true"></i></div>
                        <h3><?= $lang === 'en' ? 'Responsive Design' : 'تصميم متجاوب' ?></h3>
                        <p><?= $lang === 'en' ? 'Websites that automatically adapt to all devices and screens' : 'مواقع متوافقة مع جميع الأجهزة والشاشات بشكل تلقائي' ?></p>
                    </article>
                    <article class="feat-card reveal">
                        <div class="feat-icon i3"><i class="fas fa-globe" aria-hidden="true"></i></div>
                        <h3><?= $lang === 'en' ? 'Custom Domain' : 'نطاق مخصص' ?></h3>
                        <p><?= $lang === 'en' ? 'Get a unique domain for your website that reflects your brand' : 'احصل على نطاق خاص بموقعك يعكس هوية عملك' ?></p>
                    </article>
                    <article class="feat-card reveal">
                        <div class="feat-icon i2"><i class="fas fa-paint-brush" aria-hidden="true"></i></div>
                        <h3><?= $lang === 'en' ? 'Custom Colors' : 'ألوان مخصصة' ?></h3>
                        <p><?= $lang === 'en' ? 'Customize your site colors to match your brand identity' : 'خصص ألوان موقعك لتناسب هوية علامتك التجارية' ?></p>
                    </article>
                    <article class="feat-card reveal">
                        <div class="feat-icon i1"><i class="fas fa-language" aria-hidden="true"></i></div>
                        <h3><?= $lang === 'en' ? 'Bilingual' : 'ثنائي اللغة' ?></h3>
                        <p><?= $lang === 'en' ? 'Full Arabic and English support with easy switching' : 'دعم كامل للعربية والإنجليزية مع تبديل سهل' ?></p>
                    </article>
                    <article class="feat-card reveal">
                        <div class="feat-icon i3"><i class="fas fa-headset" aria-hidden="true"></i></div>
                        <h3><?= $lang === 'en' ? 'Continuous Support' : 'دعم فني متواصل' ?></h3>
                        <p><?= $lang === 'en' ? 'A specialized support team ready to help you around the clock' : 'فريق دعم متخصص جاهز لمساعدتك على مدار الساعة' ?></p>
                    </article>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- HOW IT WORKS -->
    <section class="section how-section" id="how" role="region" aria-labelledby="how-heading">
        <div class="container">
            <div class="section-head">
                <div class="section-chip"><i class="fas fa-route" aria-hidden="true"></i> <?= $lang === 'en' ? 'How It Works' : 'كيف يعمل؟' ?></div>
                <h2 class="section-title" id="how-heading"><?= $lang === 'en' ? 'Get Started in 4 Simple Steps' : 'ابدأ في أربع خطوات بسيطة' ?></h2>
            </div>
            <div class="steps-grid">
                <div class="step reveal">
                    <div class="step-num" aria-hidden="true">1</div>
                    <h3><?= $lang === 'en' ? 'Create Account' : 'سجّل حسابك' ?></h3>
                    <p><?= $lang === 'en' ? 'Create your free account in under a minute' : 'أنشئ حسابك المجاني في أقل من دقيقة' ?></p>
                </div>
                <div class="step reveal">
                    <div class="step-num" aria-hidden="true">2</div>
                    <h3><?= $lang === 'en' ? 'Choose Template' : 'اختر قالبك' ?></h3>
                    <p><?= $lang === 'en' ? 'Choose from professionally designed templates for various fields' : 'اختر من بين قوالب احترافية متعددة المجالات' ?></p>
                </div>
                <div class="step reveal">
                    <div class="step-num" aria-hidden="true">3</div>
                    <h3><?= $lang === 'en' ? 'Customize' : 'خصّص موقعك' ?></h3>
                    <p><?= $lang === 'en' ? 'Add your content and customize colors, text, and images' : 'أضف محتواك وخصّص الألوان والنصوص والصور' ?></p>
                </div>
                <div class="step reveal">
                    <div class="step-num" aria-hidden="true">4</div>
                    <h3><?= $lang === 'en' ? 'Publish' : 'انشر موقعك' ?></h3>
                    <p><?= $lang === 'en' ? 'Publish your site and start attracting customers' : 'انشر موقعك وابدأ بجذب العملاء فوراً' ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- BLOG -->
    <section class="section blog-section" id="blog" role="region" aria-labelledby="blog-heading">
        <div class="container">
            <div class="section-head">
                <div class="section-chip"><i class="fas fa-newspaper" aria-hidden="true"></i> <?= $lang === 'en' ? 'Blog' : 'المدونة' ?></div>
                <h2 class="section-title" id="blog-heading"><?= $lang === 'en' ? 'Latest Articles & News' : 'أحدث المقالات والأخبار' ?></h2>
                <p class="section-sub"><?= $lang === 'en' ? 'Tips, tutorials, and updates to help you build better websites' : 'نصائح ودروس وتحديثات تساعدك في بناء موقع أفضل' ?></p>
            </div>
            <?php if (!empty($blogPosts)): ?>
            <div class="blog-grid">
                <?php foreach ($blogPosts as $post): ?>
                <article class="blog-card reveal">
                    <?php if (!empty($post->featured_image)): ?>
                    <img src="<?= htmlspecialchars($post->featured_image) ?>" alt="<?= htmlspecialchars($post->title) ?>" class="blog-card-img" loading="lazy" width="400" height="200">
                    <?php else: ?>
                    <div class="blog-card-img" style="display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,var(--primary),var(--accent));color:#fff;font-size:2rem;" role="img" aria-label="<?= $lang === 'en' ? 'Blog article' : 'مقال مدونة' ?>"><i class="fas fa-newspaper" aria-hidden="true"></i></div>
                    <?php endif; ?>
                    <div class="blog-card-body">
                        <?php if (!empty($post->category)): ?>
                        <span class="blog-card-cat"><?= htmlspecialchars($post->category) ?></span>
                        <?php endif; ?>
                        <h3 class="blog-card-title">
                            <a href="<?= url('/blog/' . $post->slug) ?>"><?= htmlspecialchars($post->title) ?></a>
                        </h3>
                        <p class="blog-card-excerpt"><?= htmlspecialchars($post->excerpt ?? mb_substr(strip_tags($post->content), 0, 120) . '...') ?></p>
                        <div class="blog-card-meta">
                            <time datetime="<?= date('c', strtotime($post->published_at ?? $post->created_at)) ?>"><i class="far fa-calendar-alt" aria-hidden="true"></i> <?= date('Y/m/d', strtotime($post->published_at ?? $post->created_at)) ?></time>
                            <a href="<?= url('/blog/' . $post->slug) ?>" class="blog-card-link"><?= $lang === 'en' ? 'Read More' : 'اقرأ المزيد' ?> <i class="fas fa-arrow-left" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
            <div style="text-align:center;margin-top:40px;">
                <a href="<?= url('/blog') ?>" class="btn btn-outline"><?= $lang === 'en' ? 'View All Articles' : 'عرض جميع المقالات' ?> <i class="fas fa-arrow-left" aria-hidden="true"></i></a>
            </div>
            <?php else: ?>
            <p style="text-align:center;color:var(--gray-400);"><?= $lang === 'en' ? 'No articles yet. Stay tuned!' : 'لا توجد مقالات بعد. ترقبوا الجديد!' ?></p>
            <?php endif; ?>
        </div>
    </section>

    <!-- TESTIMONIALS -->
    <?php if (!empty($settings->show_testimonials) || !isset($settings->show_testimonials)): ?>
    <section class="section testimonials-section" id="testimonials" role="region" aria-labelledby="testimonials-heading">
        <div class="container">
            <div class="section-head">
                <div class="section-chip"><i class="fas fa-quote-right" aria-hidden="true"></i> <?= !empty($settings->testimonials_title) ? htmlspecialchars($settings->testimonials_title) : ($lang === 'en' ? 'Testimonials' : 'آراء العملاء') ?></div>
                <h2 class="section-title" id="testimonials-heading"><?= $lang === 'en' ? 'What Our Clients Say About Us' : 'ماذا يقول عملاؤنا عنّا' ?></h2>
            </div>
            <div class="testimonials-grid">
                <?php if (!empty($testimonials)): ?>
                    <?php foreach ($testimonials as $t): ?>
                        <article class="testi-card reveal" itemscope itemtype="https://schema.org/Review">
                            <div class="testi-stars" aria-label="<?= $t->rating ?? 5 ?>/5 <?= $lang === 'en' ? 'stars' : 'نجوم' ?>">
                                <meta itemprop="reviewRating" content="<?= $t->rating ?? 5 ?>">
                                <?php for ($i = 0; $i < ($t->rating ?? 5); $i++): ?><i class="fas fa-star" aria-hidden="true"></i><?php endfor; ?>
                                <?php if (($t->rating ?? 5) < 5): ?><i class="fas fa-star-half-alt" aria-hidden="true"></i><?php endif; ?>
                            </div>
                            <p class="testi-text" itemprop="reviewBody"><?= htmlspecialchars($t->content ?? '') ?></p>
                            <div class="testi-author">
                                <?php if (!empty($t->client_image)): ?>
                                    <div class="testi-avatar"><img src="<?= htmlspecialchars($t->client_image) ?>" alt="<?= htmlspecialchars($t->client_name ?? '') ?>" width="44" height="44" itemprop="image"></div>
                                <?php else: ?>
                                    <div class="testi-avatar" aria-hidden="true"><?= mb_substr($t->client_name ?? '?', 0, 1) ?></div>
                                <?php endif; ?>
                                <div>
                                    <div class="testi-name" itemprop="author"><?= htmlspecialchars($t->client_name ?? '') ?></div>
                                    <div class="testi-role"><?= htmlspecialchars($t->client_title ?? ($t->client_company ?? '')) ?></div>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <article class="testi-card reveal" itemscope itemtype="https://schema.org/Review">
                        <div class="testi-stars" aria-label="5/5 <?= $lang === 'en' ? 'stars' : 'نجوم' ?>">
                            <meta itemprop="reviewRating" content="5">
                            <i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i>
                        </div>
                        <p class="testi-text" itemprop="reviewBody"><?= $lang === 'en' ? 'An amazing and easy-to-use platform. I was able to create my website in just hours. The templates are professional and customization is fun.' : 'منصة رائعة وسهلة الاستخدام، استطعت إنشاء موقعي خلال ساعات فقط. القوالب احترافية والتخصيص ممتع جداً.' ?></p>
                        <div class="testi-author">
                            <div class="testi-avatar" aria-hidden="true"><?= $lang === 'en' ? 'A' : 'أ' ?></div>
                            <div><div class="testi-name" itemprop="author"><?= $lang === 'en' ? 'Ahmed Mohammed' : 'أحمد محمد' ?></div><div class="testi-role"><?= $lang === 'en' ? 'Construction Company Owner' : 'صاحب شركة مقاولات' ?></div></div>
                        </div>
                    </article>
                    <article class="testi-card reveal" itemscope itemtype="https://schema.org/Review">
                        <div class="testi-stars" aria-label="5/5 <?= $lang === 'en' ? 'stars' : 'نجوم' ?>">
                            <meta itemprop="reviewRating" content="5">
                            <i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star-half-alt" aria-hidden="true"></i>
                        </div>
                        <p class="testi-text" itemprop="reviewBody"><?= $lang === 'en' ? 'Excellent technical support and fast response. I recommend this platform for anyone who wants a professional website at reasonable prices.' : 'الدعم الفني ممتاز والاستجابة سريعة. أنصح بهذه المنصة لكل من يريد موقعاً احترافياً بأسعار معقولة.' ?></p>
                        <div class="testi-author">
                            <div class="testi-avatar" aria-hidden="true"><?= $lang === 'en' ? 'S' : 'س' ?></div>
                            <div><div class="testi-name" itemprop="author"><?= $lang === 'en' ? 'Sarah Al-Otaibi' : 'سارة العتيبي' ?></div><div class="testi-role"><?= $lang === 'en' ? 'Interior Designer' : 'مصممة ديكور' ?></div></div>
                        </div>
                    </article>
                    <article class="testi-card reveal" itemscope itemtype="https://schema.org/Review">
                        <div class="testi-stars" aria-label="5/5 <?= $lang === 'en' ? 'stars' : 'نجوم' ?>">
                            <meta itemprop="reviewRating" content="5">
                            <i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star-half-alt" aria-hidden="true"></i>
                        </div>
                        <p class="testi-text" itemprop="reviewBody"><?= $lang === 'en' ? 'The best Arabic platform for creating websites. Easy interface and diverse templates suitable for all fields.' : 'أفضل منصة عربية لإنشاء المواقع. واجهة سهلة وقوالب متنوعة تناسب جميع المجالات.' ?></p>
                        <div class="testi-author">
                            <div class="testi-avatar" aria-hidden="true"><?= $lang === 'en' ? 'K' : 'خ' ?></div>
                            <div><div class="testi-name" itemprop="author"><?= $lang === 'en' ? 'Khaled Al-Shamri' : 'خالد الشمري' ?></div><div class="testi-role"><?= $lang === 'en' ? 'Electrical Services' : 'مقدم خدمات كهربائية' ?></div></div>
                        </div>
                    </article>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- STATS -->
    <section class="stats-section" aria-label="<?= $lang === 'en' ? 'Platform statistics' : 'إحصائيات المنصة' ?>">
        <div class="container">
            <div class="stats-grid">
                <div class="stat">
                    <div class="stat-val"><span>500+</span></div>
                    <div class="stat-lbl"><?= $lang === 'en' ? 'Websites Created' : 'موقع تم إنشاؤه' ?></div>
                </div>
                <div class="stat">
                    <div class="stat-val"><span>6</span></div>
                    <div class="stat-lbl"><?= $lang === 'en' ? 'Professional Templates' : 'قوالب احترافية' ?></div>
                </div>
                <div class="stat">
                    <div class="stat-val"><span>99.9%</span></div>
                    <div class="stat-lbl"><?= $lang === 'en' ? 'Uptime' : 'وقت التشغيل' ?></div>
                </div>
                <div class="stat">
                    <div class="stat-val"><span>24/7</span></div>
                    <div class="stat-lbl"><?= $lang === 'en' ? 'Support' : 'دعم فني' ?></div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section" aria-label="<?= $lang === 'en' ? 'Call to action' : 'دعوة للتسجيل' ?>">
        <div class="cta-inner">
            <h2><?= $lang === 'en' ? 'Ready to Start Your Digital Journey?' : 'جاهز تبدأ رحلتك الرقمية؟' ?></h2>
            <p><?= $lang === 'en' ? 'Join over 500 users who benefited from our platform to create their professional websites' : 'انضم لأكثر من 500 مستخدم استفادوا من منصتنا لإنشاء مواقعهم الاحترافية' ?></p>
            <a href="<?= url('/register') ?>" class="btn btn-white btn-lg"><i class="fas fa-rocket" aria-hidden="true"></i> <?= $lang === 'en' ? 'Start Now Free' : 'ابدأ الآن مجاناً' ?></a>
        </div>
    </section>

    </main>

    <!-- FOOTER -->
    <footer class="footer" role="contentinfo">
        <div class="container">
            <div class="footer-top">
                <div class="footer-brand">
                    <div class="f-logo">
                        <?php if (!empty($settings->logo)): ?>
                            <img src="<?= htmlspecialchars($settings->logo) ?>" alt="<?= htmlspecialchars($siteName) ?>" width="30" height="30">
                        <?php else: ?>
                            <i class="fas fa-cube" aria-hidden="true"></i>
                        <?php endif; ?>
                        <?= htmlspecialchars($siteName) ?>
                    </div>
                    <p><?= !empty($settings->footer_text) ? htmlspecialchars($settings->footer_text) : ($lang === 'en' ? 'A professional platform for creating complete websites easily and quickly.' : 'منصة احترافية لإنشاء مواقع إلكترونية متكاملة بسهولة وسرعة.') ?></p>
                </div>
                <nav class="footer-col" aria-label="<?= $lang === 'en' ? 'Quick links' : 'روابط سريعة' ?>">
                    <h4><?= $lang === 'en' ? 'Quick Links' : 'روابط سريعة' ?></h4>
                    <ul>
                        <li><a href="<?= url('/') ?>"><?= $lang === 'en' ? 'Home' : 'الرئيسية' ?></a></li>
                        <li><a href="#features"><?= $lang === 'en' ? 'Features' : 'المميزات' ?></a></li>
                        <li><a href="#how"><?= $lang === 'en' ? 'How It Works' : 'كيف يعمل' ?></a></li>
                        <li><a href="<?= url('/blog') ?>"><?= $lang === 'en' ? 'Blog' : 'المدونة' ?></a></li>
                        <li><a href="#testimonials"><?= $lang === 'en' ? 'Testimonials' : 'آراء العملاء' ?></a></li>
                    </ul>
                </nav>
                <nav class="footer-col" aria-label="<?= $lang === 'en' ? 'Help & Legal' : 'المساعدة والقانونية' ?>">
                    <h4><?= $lang === 'en' ? 'Help' : 'المساعدة' ?></h4>
                    <ul>
                        <?php if (!empty($settings->contact_email)): ?>
                        <li><a href="mailto:<?= htmlspecialchars($settings->contact_email) ?>"><?= $lang === 'en' ? 'Contact Us' : 'اتصل بنا' ?></a></li>
                        <?php else: ?>
                        <li><a href="#"> <?= $lang === 'en' ? 'Contact Us' : 'اتصل بنا' ?></a></li>
                        <?php endif; ?>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#"><?= $lang === 'en' ? 'Terms' : 'الشروط والأحكام' ?></a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </nav>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?= $year ?> <?= htmlspecialchars($siteName) ?> - <?= !empty($settings->copyright_text) ? htmlspecialchars($settings->copyright_text) : ($lang === 'en' ? 'All rights reserved' : 'جميع الحقوق محفوظة') ?></p>
                <div class="footer-socials" aria-label="<?= $lang === 'en' ? 'Social media links' : 'روابط التواصل الاجتماعي' ?>">
                    <?php if (!empty($settings->twitter)): ?><a href="<?= htmlspecialchars($settings->twitter) ?>" target="_blank" rel="noopener noreferrer" aria-label="Twitter"><i class="fab fa-x-twitter" aria-hidden="true"></i></a><?php endif; ?>
                    <?php if (!empty($settings->facebook)): ?><a href="<?= htmlspecialchars($settings->facebook) ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a><?php endif; ?>
                    <?php if (!empty($settings->instagram)): ?><a href="<?= htmlspecialchars($settings->instagram) ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a><?php endif; ?>
                    <?php if (!empty($settings->contact_whatsapp)): ?><a href="https://wa.me/<?= preg_replace('/[^0-9+]/', '', $settings->contact_whatsapp) ?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><i class="fab fa-whatsapp" aria-hidden="true"></i></a><?php endif; ?>
                    <?php if (!empty($settings->linkedin)): ?><a href="<?= htmlspecialchars($settings->linkedin) ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a><?php endif; ?>
                    <?php if (!empty($settings->youtube)): ?><a href="<?= htmlspecialchars($settings->youtube) ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="fab fa-youtube" aria-hidden="true"></i></a><?php endif; ?>
                </div>
            </div>
        </div>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Navbar scroll
        var nav = document.getElementById('navbar');
        window.addEventListener('scroll', function() {
            nav.classList.toggle('scrolled', window.scrollY > 60);
        });

        // Mobile menu
        var toggle = document.getElementById('mobileToggle');
        var menu = document.getElementById('navMenu');
        if (toggle && menu) {
            toggle.addEventListener('click', function() {
                var isOpen = menu.classList.toggle('active');
                toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });
            menu.querySelectorAll('a').forEach(function(a) {
                a.addEventListener('click', function() {
                    menu.classList.remove('active');
                    toggle.setAttribute('aria-expanded', 'false');
                });
            });
        }

        // Scroll reveal with IntersectionObserver
        if ('IntersectionObserver' in window) {
            var obs = new IntersectionObserver(function(entries) {
                entries.forEach(function(e) {
                    if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
            document.querySelectorAll('.reveal').forEach(function(el) { obs.observe(el); });
        } else {
            document.querySelectorAll('.reveal').forEach(function(el) { el.classList.add('visible'); });
        }
    });
    </script>
</body>
</html>
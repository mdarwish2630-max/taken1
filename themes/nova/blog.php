<?php
/**
 * Nova Theme — Blog Listing Page
 * TakweenWeb Multi-Tenant CMS
 *
 * Data: $tenant, $menu, $banners, $title, $posts
 * Helpers: Language::current(), Language::direction(), Language::opposite(),
 *          lang('key'), localized($obj, 'field'), url('/path'), upload('path')
 */

$lang       = Language::current();
$dir        = Language::direction();
$opp        = Language::opposite();
$tenantName = localized($tenant, 'name');
$logo       = $tenant->logo ?? '';
$whatsapp   = $tenant->whatsapp ?? '';
$primary    = $tenant->colors['primary']   ?? '#6366f1';
$secondary  = $tenant->colors['secondary'] ?? '#4338ca';
$accent     = $tenant->colors['accent']    ?? '#f59e0b';
$favicon    = $tenant->favicon ?? '';
$siteUrl    = url('/site/' . $tenant->slug);

// Derive lighter tints for gradient overlays
$primaryLight = $primary . '22';
$accentLight  = $accent . '33';

// ---- Page Title ----
$pageTitle = lang('blog') ?: ($lang === 'ar' ? 'المدونة' : 'Blog');
$fullTitle = "$pageTitle — $tenantName";

// ---- Breadcrumb ----
$breadcrumb = [
    ['label' => lang('home') ?: ($lang === 'ar' ? 'الرئيسية' : 'Home'), 'url' => url('/site/' . $tenant->slug)],
    ['label' => $pageTitle, 'url' => null],
];
?>
<!DOCTYPE html>
<html lang="<?= e($lang) ?>" dir="<?= e($dir) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($fullTitle) ?></title>

    <?php if ($favicon): ?>
        <link rel="icon" href="<?= e(upload($favicon)) ?>">
    <?php endif; ?>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

    <!-- Font Awesome 6.5 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        /* ===== CSS Variables ===== */
        :root {
            --primary:    <?= $primary ?>;
            --secondary:  <?= $secondary ?>;
            --accent:     <?= $accent ?>;
            --primary-rgb: 99,102,241;
            --secondary-rgb: 67,56,202;
            --accent-rgb: 245,158,11;
            --body-bg:    #f8f9fc;
            --card-bg:    #ffffff;
            --text-dark:  #1e1b4b;
            --text-muted: #6b7280;
            --border:     #e5e7eb;
            --radius:     16px;
            --shadow:     0 4px 24px rgba(99,102,241,.08);
            --shadow-lg:  0 12px 48px rgba(99,102,241,.12);
        }

        /* ===== Base ===== */
        * { box-sizing: border-box; }

        body {
            font-family: 'Tajawal', 'Plus Jakarta Sans', sans-serif;
            background: var(--body-bg);
            color: var(--text-dark);
            margin: 0;
            overflow-x: hidden;
            line-height: 1.7;
        }

        [dir="ltr"] body,
        [dir="ltr"] * { font-family: 'Plus Jakarta Sans', 'Tajawal', sans-serif; }

        a { color: var(--primary); text-decoration: none; transition: .25s; }
        a:hover { color: var(--secondary); }

        img { max-width: 100%; height: auto; }

        /* ===== Navbar (Glassmorphism) ===== */
        .nova-navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            padding: .75rem 0;
            transition: all .35s cubic-bezier(.4,0,.2,1);
            background: rgba(255,255,255,.55);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(255,255,255,.18);
        }

        .nova-navbar.scrolled {
            background: rgba(255,255,255,.88);
            box-shadow: 0 2px 32px rgba(var(--primary-rgb),.10);
        }

        .nova-navbar .navbar-brand img {
            height: 42px;
            transition: height .3s;
        }

        .nova-navbar.scrolled .navbar-brand img { height: 36px; }

        .nova-navbar .nav-link {
            font-weight: 600;
            color: var(--text-dark);
            padding: .5rem 1rem !important;
            border-radius: 10px;
            transition: all .25s;
            font-size: .95rem;
        }

        .nova-navbar .nav-link:hover,
        .nova-navbar .nav-link.active {
            color: var(--primary);
            background: rgba(var(--primary-rgb),.08);
        }

        .nova-navbar .navbar-toggler {
            border: none;
            font-size: 1.25rem;
            color: var(--primary);
            padding: .4rem .6rem;
        }

        /* ===== Hero Section ===== */
        .nova-hero {
            position: relative;
            min-height: 380px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 140px 1rem 80px;
            overflow: hidden;
        }

        .nova-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 40%, rgba(var(--primary-rgb),.35), transparent),
                radial-gradient(ellipse 60% 50% at 80% 30%, rgba(var(--secondary-rgb),.28), transparent),
                radial-gradient(ellipse 50% 50% at 60% 80%, rgba(var(--accent-rgb),.18), transparent);
            z-index: 0;
        }

        .nova-hero::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 120px;
            background: linear-gradient(to top, var(--body-bg), transparent);
            z-index: 1;
        }

        /* Animated mesh blobs */
        .hero-mesh {
            position: absolute;
            inset: 0;
            z-index: 0;
            overflow: hidden;
        }

        .hero-mesh span {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: .45;
            animation: meshFloat 8s ease-in-out infinite alternate;
        }

        .hero-mesh span:nth-child(1) {
            width: 400px; height: 400px;
            background: var(--primary);
            top: -10%; left: -5%;
            animation-duration: 10s;
        }

        .hero-mesh span:nth-child(2) {
            width: 300px; height: 300px;
            background: var(--accent);
            top: 30%; right: -8%;
            animation-duration: 12s;
            animation-delay: -3s;
        }

        .hero-mesh span:nth-child(3) {
            width: 250px; height: 250px;
            background: var(--secondary);
            bottom: -5%; left: 40%;
            animation-duration: 9s;
            animation-delay: -6s;
        }

        @keyframes meshFloat {
            0%   { transform: translate(0,0) scale(1); }
            50%  { transform: translate(30px,-20px) scale(1.08); }
            100% { transform: translate(-20px,15px) scale(.95); }
        }

        .nova-hero .hero-content {
            position: relative;
            z-index: 2;
        }

        .nova-hero h1 {
            font-size: clamp(2rem, 5vw, 3.2rem);
            font-weight: 800;
            color: #fff;
            margin-bottom: .75rem;
            text-shadow: 0 2px 16px rgba(0,0,0,.18);
        }

        .nova-hero p {
            font-size: 1.15rem;
            color: rgba(255,255,255,.88);
            max-width: 540px;
            margin: 0 auto;
        }

        /* ===== Breadcrumb ===== */
        .nova-breadcrumb {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            margin-top: 1.25rem;
            flex-wrap: wrap;
        }

        .nova-breadcrumb a,
        .nova-breadcrumb span {
            color: rgba(255,255,255,.8);
            font-size: .9rem;
            font-weight: 500;
        }

        .nova-breadcrumb a:hover { color: #fff; }

        .nova-breadcrumb .separator { opacity: .5; }

        .nova-breadcrumb .current { color: var(--accent); font-weight: 600; }

        /* ===== Blog Stats ===== */
        .blog-stats {
            display: flex;
            justify-content: center;
            gap: 2.5rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .blog-stats .stat-item {
            text-align: center;
            color: #fff;
        }

        .blog-stats .stat-num {
            font-size: 1.75rem;
            font-weight: 800;
            display: block;
        }

        .blog-stats .stat-label {
            font-size: .85rem;
            opacity: .8;
        }

        /* ===== Blog Cards Grid ===== */
        .blog-section {
            padding: 3rem 0 4rem;
        }

        .section-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 2rem;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            <?= $dir === 'rtl' ? 'right' : 'left' ?>: 0;
            width: 60px;
            height: 4px;
            border-radius: 4px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
        }

        /* Post Card */
        .nova-post-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all .4s cubic-bezier(.4,0,.2,1);
            border: 1px solid rgba(var(--primary-rgb),.06);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .nova-post-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(var(--primary-rgb),.15);
        }

        .nova-post-card .card-img-wrapper {
            position: relative;
            overflow: hidden;
            height: 220px;
        }

        .nova-post-card .card-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .5s cubic-bezier(.4,0,.2,1);
        }

        .nova-post-card:hover .card-img-wrapper img {
            transform: scale(1.06);
        }

        .nova-post-card .card-img-wrapper .date-badge {
            position: absolute;
            top: 14px;
            <?= $dir === 'rtl' ? 'left' : 'right' ?>: 14px;
            background: rgba(255,255,255,.92);
            backdrop-filter: blur(8px);
            border-radius: 10px;
            padding: .35rem .75rem;
            font-size: .8rem;
            font-weight: 600;
            color: var(--primary);
            box-shadow: 0 2px 12px rgba(0,0,0,.08);
        }

        .nova-post-card .card-img-wrapper .date-badge i {
            margin-<?= $dir === 'rtl' ? 'left' : 'right' ?>: .35rem;
            color: var(--accent);
        }

        .nova-post-card .card-body {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .nova-post-card .card-title {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: .75rem;
            line-height: 1.5;
            color: var(--text-dark);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .nova-post-card .card-title a {
            color: inherit;
        }

        .nova-post-card .card-title a:hover {
            color: var(--primary);
        }

        .nova-post-card .card-excerpt {
            font-size: .92rem;
            color: var(--text-muted);
            line-height: 1.7;
            margin-bottom: 1.25rem;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .nova-post-card .card-footer-custom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 1rem;
            border-top: 1px solid var(--border);
        }

        .nova-post-card .author-info {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: .85rem;
            color: var(--text-muted);
        }

        .nova-post-card .author-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: .75rem;
            font-weight: 700;
        }

        .nova-post-card .read-more-btn {
            font-size: .88rem;
            font-weight: 600;
            color: var(--primary);
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            transition: all .3s;
        }

        .nova-post-card .read-more-btn:hover {
            color: var(--secondary);
            gap: .65rem;
        }

        .nova-post-card .read-more-btn i {
            font-size: .75rem;
            transition: transform .3s;
        }

        .nova-post-card:hover .read-more-btn i {
            transform: translateX(<?= $dir === 'rtl' ? '3px' : '-3px' ?>);
        }

        /* ===== Pagination ===== */
        .nova-pagination .page-link {
            border: none;
            color: var(--text-dark);
            font-weight: 600;
            padding: .6rem 1rem;
            border-radius: 12px !important;
            margin: 0 .2rem;
            transition: all .3s;
        }

        .nova-pagination .page-link:hover {
            background: rgba(var(--primary-rgb),.1);
            color: var(--primary);
        }

        .nova-pagination .page-item.active .page-link {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 4px 14px rgba(var(--primary-rgb),.35);
        }

        /* ===== Newsletter Section ===== */
        .nova-newsletter {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            padding: 4rem 0;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .nova-newsletter::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,.08);
            border-radius: 50%;
            top: -100px;
            <?= $dir === 'rtl' ? 'left' : 'right' ?>: -80px;
        }

        .nova-newsletter h3 {
            font-size: 1.75rem;
            font-weight: 800;
            margin-bottom: .75rem;
        }

        .nova-newsletter p {
            opacity: .9;
            max-width: 500px;
            margin: 0 auto 1.5rem;
        }

        .nova-newsletter .form-control {
            border: none;
            border-radius: 12px;
            padding: .85rem 1.25rem;
            font-size: .95rem;
            box-shadow: 0 4px 20px rgba(0,0,0,.1);
        }

        .nova-newsletter .btn-accent {
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: .85rem 2rem;
            font-weight: 700;
            font-size: .95rem;
            transition: all .3s;
        }

        .nova-newsletter .btn-accent:hover {
            background: #d97706;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(var(--accent-rgb),.4);
        }

        /* ===== Footer ===== */
        .nova-footer {
            background: #0f0d2e;
            color: rgba(255,255,255,.75);
            padding: 3.5rem 0 1.5rem;
        }

        .nova-footer h5 {
            color: #fff;
            font-weight: 700;
            margin-bottom: 1.25rem;
            font-size: 1.1rem;
        }

        .nova-footer a {
            color: rgba(255,255,255,.7);
            transition: .25s;
        }

        .nova-footer a:hover { color: var(--accent); }

        .nova-footer .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nova-footer .footer-links li {
            margin-bottom: .6rem;
        }

        .nova-footer .footer-links li a {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
        }

        .nova-footer .footer-links li a i {
            font-size: .7rem;
            color: var(--accent);
        }

        .nova-footer .social-links {
            display: flex;
            gap: .75rem;
            margin-top: 1rem;
        }

        .nova-footer .social-links a {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(255,255,255,.08);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,.75);
            font-size: 1rem;
            transition: all .3s;
        }

        .nova-footer .social-links a:hover {
            background: var(--primary);
            color: #fff;
            transform: translateY(-3px);
        }

        .nova-footer .footer-bottom {
            border-top: 1px solid rgba(255,255,255,.08);
            padding-top: 1.5rem;
            margin-top: 2.5rem;
            text-align: center;
            font-size: .88rem;
        }

        /* ===== WhatsApp Float ===== */
        .whatsapp-float {
            position: fixed;
            bottom: 90px;
            <?= $dir === 'rtl' ? 'left' : 'right' ?>: 24px;
            z-index: 1040;
            width: 56px;
            height: 56px;
            background: #25d366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.6rem;
            box-shadow: 0 4px 20px rgba(37,211,102,.4);
            transition: all .3s;
            animation: waFloat 2.5s ease-in-out infinite;
        }

        .whatsapp-float:hover {
            transform: scale(1.12);
            box-shadow: 0 6px 28px rgba(37,211,102,.5);
            color: #fff;
        }

        @keyframes waFloat {
            0%, 100% { transform: translateY(0); }
            50%      { transform: translateY(-8px); }
        }

        /* ===== Back to Top ===== */
        .back-to-top {
            position: fixed;
            bottom: 24px;
            <?= $dir === 'rtl' ? 'left' : 'right' ?>: 24px;
            z-index: 1040;
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 4px 16px rgba(var(--primary-rgb),.35);
            transition: all .35s;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
        }

        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .back-to-top:hover {
            background: var(--secondary);
            color: #fff;
            transform: translateY(-3px);
        }

        /* ===== Scroll Animations ===== */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity .6s cubic-bezier(.4,0,.2,1), transform .6s cubic-bezier(.4,0,.2,1);
        }

        .animate-on-scroll.animated {
            opacity: 1;
            transform: translateY(0);
        }

        /* Staggered animation delay for cards */
        .animate-on-scroll[data-delay="1"] { transition-delay: .1s; }
        .animate-on-scroll[data-delay="2"] { transition-delay: .2s; }
        .animate-on-scroll[data-delay="3"] { transition-delay: .3s; }
        .animate-on-scroll[data-delay="4"] { transition-delay: .35s; }
        .animate-on-scroll[data-delay="5"] { transition-delay: .4s; }
        .animate-on-scroll[data-delay="6"] { transition-delay: .45s; }

        /* ===== Search Bar ===== */
        .blog-search-bar {
            max-width: 480px;
            margin: 0 auto 2.5rem;
            position: relative;
        }

        .blog-search-bar .form-control {
            border: 2px solid var(--border);
            border-radius: 14px;
            padding: .85rem 1.25rem;
            padding-<?= $dir === 'rtl' ? 'left' : 'right' ?>: 3.2rem;
            font-size: .95rem;
            background: var(--card-bg);
            transition: all .3s;
        }

        .blog-search-bar .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(var(--primary-rgb),.12);
        }

        .blog-search-bar .search-icon {
            position: absolute;
            top: 50%;
            <?= $dir === 'rtl' ? 'left' : 'right' ?>: 1rem;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: .95rem;
        }

        /* ===== Empty State ===== */
        .empty-state {
            text-align: center;
            padding: 4rem 1rem;
        }

        .empty-state i {
            font-size: 3.5rem;
            color: var(--border);
            margin-bottom: 1rem;
        }

        .empty-state h4 {
            color: var(--text-muted);
            font-weight: 600;
        }

        /* ===== Custom Scrollbar ===== */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--body-bg); }
        ::-webkit-scrollbar-thumb {
            background: rgba(var(--primary-rgb),.25);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(var(--primary-rgb),.4);
        }

        /* ===== Loading Skeleton ===== */
        .skeleton {
            background: linear-gradient(90deg, #e5e7eb 25%, #f3f4f6 50%, #e5e7eb 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: 8px;
        }

        @keyframes shimmer {
            0%   { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* ===== Responsive ===== */
        @media (max-width: 767.98px) {
            .nova-hero { min-height: 300px; padding: 120px 1rem 60px; }
            .blog-stats { gap: 1.5rem; }
            .blog-stats .stat-num { font-size: 1.4rem; }
            .nova-post-card .card-img-wrapper { height: 180px; }
        }

        @media (max-width: 575.98px) {
            .nova-footer { text-align: center; }
            .nova-footer .social-links { justify-content: center; }
        }
    </style>
</head>
<body>

    <!-- ==================== NAVBAR ==================== -->
    <nav class="nova-navbar" id="mainNav">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?= e(url('/site/' . $tenant->slug)) ?>">
                <?php if ($logo): ?>
                    <img src="<?= e(upload($logo)) ?>" alt="<?= e($tenantName) ?>">
                <?php else: ?>
                    <span style="font-weight:800;font-size:1.35rem;color:var(--primary);"><?= e($tenantName) ?></span>
                <?php endif; ?>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <i class="fas fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav ms-auto">
                    <?php if (!empty($menu)): ?>
                        <?php foreach ($menu as $item): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= e(url('/site/' . $tenant->slug . ($item['url'] ?? ''))) ?>">
                                    <?= e(localized($item, 'label')) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ==================== HERO ==================== -->
    <section class="nova-hero">
        <div class="hero-mesh">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <div class="hero-content">
            <h1 class="animate-on-scroll">
                <i class="fas fa-newspaper" style="color:var(--accent);margin-inline-end:.5rem;"></i>
                <?= e($pageTitle) ?>
            </h1>
            <p class="animate-on-scroll" data-delay="1">
                <?= e(lang('blog_subtitle') ?: ($lang === 'ar' ? 'تصفح أحدث المقالات والأخبار والإلهام' : 'Browse the latest articles, news and inspiration')) ?>
            </p>

            <!-- Breadcrumb -->
            <nav class="nova-breadcrumb animate-on-scroll" data-delay="2">
                <?php foreach ($breadcrumb as $i => $crumb): ?>
                    <?php if ($i > 0): ?>
                        <span class="separator"><i class="fas fa-chevron-left"></i></span>
                    <?php endif; ?>

                    <?php if ($crumb['url']): ?>
                        <a href="<?= e($crumb['url']) ?>"><?= e($crumb['label']) ?></a>
                    <?php else: ?>
                        <span class="current"><?= e($crumb['label']) ?></span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </nav>

            <!-- Stats -->
            <?php if (!empty($posts)): ?>
                <div class="blog-stats animate-on-scroll" data-delay="3">
                    <div class="stat-item">
                        <span class="stat-num"><?= e(count($posts)) ?></span>
                        <span class="stat-label"><?= e(lang('articles') ?: ($lang === 'ar' ? 'مقال' : 'Articles')) ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-num"><?= e(count(array_unique(array_column($posts, 'author')))) ?></span>
                        <span class="stat-label"><?= e(lang('authors') ?: ($lang === 'ar' ? 'كاتب' : 'Authors')) ?></span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- ==================== BLOG SECTION ==================== -->
    <main class="blog-section">
        <div class="container">

            <!-- Search Bar -->
            <div class="blog-search-bar animate-on-scroll">
                <i class="fas fa-search search-icon"></i>
                <input
                    type="text"
                    class="form-control"
                    placeholder="<?= e(lang('search_articles') ?: ($lang === 'ar' ? 'ابحث في المقالات...' : 'Search articles...')) ?>"
                >
            </div>

            <?php if (!empty($posts)): ?>
                <!-- Posts Grid -->
                <div class="row g-4">
                    <?php foreach ($posts as $index => $post): ?>
                        <?php
                            $postTitle  = localized($post, 'title');
                            $postExcerpt = localized($post, 'excerpt');
                            $postSlug   = $post->slug;
                            $postImage  = $post->image ? upload($post->image) : null;
                            $postDate   = $post->created_at;
                            $postAuthor = $post->author ?? ($lang === 'ar' ? 'فريق التحرير' : 'Editorial Team');
                            $authorInitial = mb_strtoupper(mb_substr($postAuthor, 0, 1));
                            $formattedDate = is_object($postDate)
                                ? $postDate->format('M d, Y')
                                : date('M d, Y', strtotime($postDate));
                        ?>
                        <div class="col-md-6 col-lg-4">
                            <article class="nova-post-card animate-on-scroll" data-delay="<?= ($index % 6) + 1 ?>">
                                <!-- Image -->
                                <div class="card-img-wrapper">
                                    <?php if ($postImage): ?>
                                        <img src="<?= e($postImage) ?>" alt="<?= e($postTitle) ?>" loading="lazy">
                                    <?php else: ?>
                                        <div style="width:100%;height:100%;background:linear-gradient(135deg,var(--primary),var(--secondary));display:flex;align-items:center;justify-content:center;">
                                            <i class="fas fa-image" style="font-size:2.5rem;color:rgba(255,255,255,.3);"></i>
                                        </div>
                                    <?php endif; ?>

                                    <div class="date-badge">
                                        <i class="fas fa-calendar-alt"></i>
                                        <?= e($formattedDate) ?>
                                    </div>
                                </div>

                                <!-- Body -->
                                <div class="card-body">
                                    <h3 class="card-title">
                                        <a href="<?= e(url('/site/' . $tenant->slug . '/blog/' . $postSlug)) ?>">
                                            <?= e($postTitle) ?>
                                        </a>
                                    </h3>

                                    <p class="card-excerpt">
                                        <?= e($postExcerpt) ?>
                                    </p>

                                    <div class="card-footer-custom">
                                        <div class="author-info">
                                            <div class="author-avatar"><?= e($authorInitial) ?></div>
                                            <span><?= e($postAuthor) ?></span>
                                        </div>

                                        <a href="<?= e(url('/site/' . $tenant->slug . '/blog/' . $postSlug)) ?>" class="read-more-btn">
                                            <?= e(lang('read_more') ?: ($lang === 'ar' ? 'اقرأ المزيد' : 'Read More')) ?>
                                            <i class="fas fa-arrow-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination (placeholder structure) -->
                <?php if (count($posts) > 9): ?>
                    <nav class="mt-5 d-flex justify-content-center">
                        <ul class="pagination nova-pagination">
                            <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-<?= $dir === 'rtl' ? 'right' : 'left' ?>"></i></a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i></a></li>
                        </ul>
                    </nav>
                <?php endif; ?>

            <?php else: ?>
                <!-- Empty State -->
                <div class="empty-state animate-on-scroll">
                    <i class="fas fa-inbox"></i>
                    <h4><?= e(lang('no_posts') ?: ($lang === 'ar' ? 'لا توجد مقالات بعد' : 'No articles yet')) ?></h4>
                    <p class="text-muted"><?= e(lang('check_back') ?: ($lang === 'ar' ? 'تابعنا لمعرفة الجديد' : 'Check back later for new content')) ?></p>
                </div>
            <?php endif; ?>

        </div>
    </main>

    <!-- ==================== NEWSLETTER ==================== -->
    <section class="nova-newsletter animate-on-scroll">
        <div class="container text-center position-relative" style="z-index:2;">
            <h3>
                <i class="fas fa-envelope-open-text" style="color:var(--accent);margin-inline-end:.5rem;"></i>
                <?= e(lang('newsletter_title') ?: ($lang === 'ar' ? 'اشترك في نشرتنا البريدية' : 'Subscribe to Our Newsletter')) ?>
            </h3>
            <p><?= e(lang('newsletter_desc') ?: ($lang === 'ar' ? 'احصل على أحدث المقالات مباشرة في بريدك' : 'Get the latest articles delivered to your inbox')) ?></p>
            <form class="row g-2 justify-content-center" style="max-width:500px;margin:0 auto;">
                <div class="col-sm-7">
                    <input type="email" class="form-control" placeholder="<?= e(lang('email_placeholder') ?: ($lang === 'ar' ? 'بريدك الإلكتروني' : 'Your email address')) ?>" required>
                </div>
                <div class="col-sm-auto">
                    <button type="submit" class="btn btn-accent">
                        <?= e(lang('subscribe') ?: ($lang === 'ar' ? 'اشترك' : 'Subscribe')) ?>
                        <i class="fas fa-paper-plane" style="margin-inline-start:.35rem;"></i>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- ==================== FOOTER ==================== -->
    <footer class="nova-footer">
        <div class="container">
            <div class="row g-4">
                <!-- About -->
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <?php if ($logo): ?>
                            <img src="<?= e(upload($logo)) ?>" alt="<?= e($tenantName) ?>" style="height:38px;">
                        <?php else: ?>
                            <span style="font-weight:800;font-size:1.2rem;color:var(--accent);"><?= e($tenantName) ?></span>
                        <?php endif; ?>
                    </div>
                    <p style="font-size:.92rem;line-height:1.8;">
                        <?= e(localized($tenant, 'description') ?: ($lang === 'ar' ? 'منصة إبداعية توفر أفضل المحتوى والخدمات الرقمية.' : 'A creative platform providing the best digital content and services.')) ?>
                    </p>
                    <div class="social-links">
                        <?php if (!empty($tenant->facebook)): ?>
                            <a href="<?= e($tenant->facebook) ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($tenant->twitter)): ?>
                            <a href="<?= e($tenant->twitter) ?>" target="_blank"><i class="fab fa-x-twitter"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($tenant->instagram)): ?>
                            <a href="<?= e($tenant->instagram) ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($tenant->linkedin)): ?>
                            <a href="<?= e($tenant->linkedin) ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-6 col-lg-2">
                    <h5><?= e(lang('quick_links') ?: ($lang === 'ar' ? 'روابط سريعة' : 'Quick Links')) ?></h5>
                    <ul class="footer-links">
                        <?php if (!empty($menu)): ?>
                            <?php foreach (array_slice($menu, 0, 5) as $item): ?>
                                <li><a href="<?= e(url('/site/' . $tenant->slug . ($item['url'] ?? ''))) ?>"><i class="fas fa-chevron-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i> <?= e(localized($item, 'label')) ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-6 col-lg-3">
                    <h5><?= e(lang('contact_us') ?: ($lang === 'ar' ? 'تواصل معنا' : 'Contact Us')) ?></h5>
                    <ul class="footer-links">
                        <?php if (!empty($tenant->email)): ?>
                            <li><a href="mailto:<?= e($tenant->email) ?>"><i class="fas fa-envelope"></i> <?= e($tenant->email) ?></a></li>
                        <?php endif; ?>
                        <?php if (!empty($tenant->phone)): ?>
                            <li><a href="tel:<?= e($tenant->phone) ?>"><i class="fas fa-phone"></i> <?= e($tenant->phone) ?></a></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Working Hours -->
                <div class="col-lg-3">
                    <h5><?= e(lang('working_hours') ?: ($lang === 'ar' ? 'ساعات العمل' : 'Working Hours')) ?></h5>
                    <ul class="footer-links">
                        <li><i class="fas fa-clock" style="color:var(--accent);"></i> <?= e($lang === 'ar' ? 'السبت - الخميس' : 'Sat - Thu') ?></li>
                        <li style="color:rgba(255,255,255,.55);">9:00 AM - 6:00 PM</li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                &copy; <?= date('Y') ?> <?= e($tenantName) ?>.
                <?= e(lang('rights') ?: ($lang === 'ar' ? 'جميع الحقوق محفوظة' : 'All rights reserved')) ?>.
            </div>
        </div>
    </footer>

    <!-- ==================== WHATSAPP FLOAT ==================== -->
    <?php if ($whatsapp): ?>
        <a href="https://wa.me/<?= preg_replace('/[^0-9+]/', '', $whatsapp) ?>" class="whatsapp-float" target="_blank" rel="noopener" aria-label="WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
    <?php endif; ?>

    <!-- ==================== BACK TO TOP ==================== -->
    <button class="back-to-top" id="backToTop" aria-label="<?= e($lang === 'ar' ? 'العودة للأعلى' : 'Back to top') ?>">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- ==================== SCRIPTS ==================== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    (function () {
        'use strict';

        // ─── Navbar Scroll Effect ───
        var nav = document.getElementById('mainNav');
        var scrollThreshold = 50;

        function handleNavScroll() {
            if (window.scrollY > scrollThreshold) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        }

        window.addEventListener('scroll', handleNavScroll, { passive: true });
        handleNavScroll();

        // ─── Back to Top ───
        var backBtn = document.getElementById('backToTop');

        function handleBackToTop() {
            if (window.scrollY > 400) {
                backBtn.classList.add('visible');
            } else {
                backBtn.classList.remove('visible');
            }
        }

        window.addEventListener('scroll', handleBackToTop, { passive: true });
        handleBackToTop();

        backBtn.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // ─── Scroll Animations (IntersectionObserver) ───
        var animatedElements = document.querySelectorAll('.animate-on-scroll');

        if ('IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animated');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -40px 0px'
            });

            animatedElements.forEach(function (el) {
                observer.observe(el);
            });
        } else {
            // Fallback: show all
            animatedElements.forEach(function (el) {
                el.classList.add('animated');
            });
        }

        // ─── Search Filter (client-side, optional enhancement) ───
        var searchInput = document.querySelector('.blog-search-bar input');
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                var query = this.value.trim().toLowerCase();
                var cards = document.querySelectorAll('.nova-post-card');

                cards.forEach(function (card) {
                    var title = card.querySelector('.card-title').textContent.toLowerCase();
                    var excerpt = card.querySelector('.card-excerpt').textContent.toLowerCase();

                    if (!query || title.indexOf(query) !== -1 || excerpt.indexOf(query) !== -1) {
                        card.closest('.col-md-6').style.display = '';
                    } else {
                        card.closest('.col-md-6').style.display = 'none';
                    }
                });
            });
        }

        // ─── Active Nav Link Highlighting ───
        var navLinks = document.querySelectorAll('.nova-navbar .nav-link');
        navLinks.forEach(function (link) {
            if (link.getAttribute('href') === window.location.pathname) {
                link.classList.add('active');
            }
        });

    })();
    </script>

</body>
</html>

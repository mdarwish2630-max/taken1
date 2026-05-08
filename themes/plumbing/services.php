<?php
/**
 * Theme: General - Services Listing Page (Professional)
 * القالب: عام - صفحة الخدمات
 */

$lang = Language::current();
$dir = Language::direction();
$isRtl = $dir === 'rtl';

$themePrimary = $tenant->primary_color ?? '#4f46e5';
$themeSecondary = $tenant->secondary_color ?? '#1e40af';
$themeAccent = $tenant->accent_color ?? '#f59e0b';

$servicesBanner = !empty($banners) ? ($banners[1] ?? $banners[0] ?? null) : null;
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? lang('services') . ' - ' . localized($tenant, 'site_name') ?></title>
    <meta name="description" content="<?= $tenant->meta_description ?>">
    <?php if (!empty($tenant->meta_keywords)): ?>
    <meta name="keywords" content="<?= $tenant->meta_keywords ?>">
    <?php endif; ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap<?= $isRtl ? '.rtl' : '' ?>.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=<?= $isRtl ? 'Cairo:wght@300;400;500;600;700;800;900' : 'Inter:wght@300;400;500;600;700;800;900' ?>&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <style>
        :root {
            --primary: <?= $themePrimary ?>;
            --primary-dark: <?= $themeSecondary ?>;
            --primary-light: color-mix(in srgb, var(--primary) 85%, white);
            --primary-50: color-mix(in srgb, var(--primary) 8%, white);
            --primary-100: color-mix(in srgb, var(--primary) 15%, white);
            --accent: <?= $themeAccent ?>;
            --accent-light: color-mix(in srgb, var(--accent) 80%, white);
            --gradient: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            --gradient-light: linear-gradient(135deg, var(--primary-50) 0%, white 100%);
            --gradient-accent: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.04);
            --shadow: 0 4px 24px rgba(0,0,0,0.06);
            --shadow-md: 0 8px 32px rgba(0,0,0,0.08);
            --shadow-lg: 0 16px 48px rgba(0,0,0,0.1);
            --shadow-primary: 0 8px 32px color-mix(in srgb, var(--primary) 30%, transparent);
            --radius: 12px;
            --radius-lg: 20px;
            --radius-xl: 28px;
            --text: #1a1a2e;
            --text-secondary: #555770;
            --text-light: #8b8ca7;
            --bg: #ffffff;
            --bg-alt: #f7f8fc;
            --bg-warm: #faf8f5;
            --border: #eef0f6;
            --font: '<?= $isRtl ? 'Cairo' : 'Inter' ?>', system-ui, sans-serif;
            --transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font);
            color: var(--text);
            background: var(--bg);
            line-height: 1.7;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        img { max-width: 100%; height: auto; }
        a { text-decoration: none; color: inherit; }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }

        /* ─── Navbar ─── */
        .navbar {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border-bottom: 1px solid transparent;
            position: fixed; width: 100%; top: 0; z-index: 1050;
            transition: var(--transition);
        }
        .navbar.scrolled { border-bottom-color: var(--border); box-shadow: 0 4px 30px rgba(0,0,0,0.04); }
        .navbar .container { display: flex; align-items: center; justify-content: space-between; height: 72px; }
        .nav-brand { display: flex; align-items: center; gap: 0.6rem; font-weight: 700; font-size: 1.2rem; color: var(--primary); transition: var(--transition); }
        .nav-brand:hover { opacity: 0.8; }
        .nav-brand img { height: 44px; width: auto; border-radius: 8px; }
        .nav-brand .brand-icon { width: 40px; height: 40px; background: var(--gradient); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.1rem; }
        .nav-links { display: flex; align-items: center; gap: 0.15rem; list-style: none; }
        .nav-links a { padding: 0.5rem 0.9rem; border-radius: 8px; font-weight: 500; font-size: 0.92rem; color: var(--text-secondary); transition: var(--transition); position: relative; }
        .nav-links a:hover { color: var(--primary); background: var(--primary-50); }
        .nav-links a.active { color: var(--primary); background: var(--primary-50); font-weight: 600; }
        .nav-cta { background: var(--primary) !important; color: #fff !important; font-weight: 600 !important; padding: 0.55rem 1.4rem !important; border-radius: 10px !important; box-shadow: var(--shadow-sm); transition: var(--transition); }
        .nav-cta:hover { transform: translateY(-1px); box-shadow: var(--shadow-primary); background: var(--primary) !important; }
        .lang-switch { display: inline-flex; align-items: center; gap: 0.3rem; padding: 0.45rem 0.9rem !important; border: 1.5px solid var(--border) !important; border-radius: 8px !important; font-size: 0.82rem !important; font-weight: 600 !important; color: var(--text-secondary) !important; transition: var(--transition); }
        .lang-switch:hover { border-color: var(--primary) !important; color: var(--primary) !important; background: var(--primary-50) !important; }
        .mobile-btn { display: none; background: none; border: none; font-size: 1.4rem; cursor: pointer; color: var(--text); padding: 0.5rem; border-radius: 8px; transition: var(--transition); }
        .mobile-btn:hover { background: var(--bg-alt); }
        @media (max-width: 992px) {
            .mobile-btn { display: flex; }
            .nav-links { display: none; position: absolute; top: 100%; left: 0; right: 0; background: #fff; flex-direction: column; padding: 1rem; box-shadow: var(--shadow-lg); border-radius: 0 0 var(--radius) var(--radius); gap: 0.1rem; }
            .nav-links.open { display: flex; }
            .nav-links a { padding: 0.8rem 1rem; border-radius: 8px; }
        }

        /* ─── Page Hero ─── */
        .page-hero {
            position: relative;
            min-height: 380px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            padding: 7rem 1.5rem 3.5rem;
            text-align: center;
        }
        <?php if ($servicesBanner && $servicesBanner->image): ?>
        .page-hero-bg { position: absolute; inset: 0; background: url('<?= upload($servicesBanner->image) ?>') center/cover no-repeat; }
        .page-hero-overlay { position: absolute; inset: 0; background: linear-gradient(135deg, rgba(26,26,46,0.88) 0%, rgba(<?= implode(',', sscanf($themePrimary, '#%2x%2x%2x')); ?>,0.82) 100%); }
        <?php else: ?>
        .page-hero-bg { position: absolute; inset: 0; background: var(--gradient); }
        .page-hero-pattern {
            position: absolute; inset: 0;
            background-image: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.06) 0%, transparent 50%),
                              radial-gradient(circle at 80% 20%, rgba(255,255,255,0.04) 0%, transparent 40%),
                              radial-gradient(circle at 60% 80%, rgba(255,255,255,0.05) 0%, transparent 45%);
        }
        <?php endif; ?>
        .page-hero-content { position: relative; z-index: 2; max-width: 700px; }
        .page-hero .hero-badge {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: rgba(255,255,255,0.12); backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.15);
            padding: 0.4rem 1.2rem; border-radius: 50px;
            font-size: 0.82rem; color: rgba(255,255,255,0.9); font-weight: 500;
            margin-bottom: 1.25rem;
        }
        .page-hero .hero-badge i { color: var(--accent); font-size: 0.7rem; }
        .page-hero h1 { font-size: clamp(2rem, 4vw, 2.8rem); font-weight: 800; color: #fff; line-height: 1.3; margin-bottom: 1rem; letter-spacing: -0.01em; }
        .page-hero p { font-size: 1.1rem; color: rgba(255,255,255,0.82); line-height: 1.8; max-width: 540px; margin: 0 auto; }
        .breadcrumb-nav { display: flex; align-items: center; justify-content: center; gap: 0.5rem; margin-top: 1.5rem; font-size: 0.85rem; }
        .breadcrumb-nav a { color: rgba(255,255,255,0.65); transition: color 0.3s; }
        .breadcrumb-nav a:hover { color: #fff; }
        .breadcrumb-nav .separator { color: rgba(255,255,255,0.35); font-size: 0.7rem; }
        .breadcrumb-nav .current { color: rgba(255,255,255,0.95); font-weight: 600; }

        /* ─── Sections ─── */
        .section { padding: 5rem 1.5rem; }
        .section-alt { background: var(--bg-alt); }

        /* ─── Service Cards Grid ─── */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 2rem;
        }
        @media (max-width: 576px) { .services-grid { grid-template-columns: 1fr; } }

        .service-card {
            background: #fff;
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: 1px solid var(--border);
            transition: var(--transition);
            position: relative;
            display: flex;
            flex-direction: column;
        }
        .service-card::after {
            content: '';
            position: absolute; bottom: 0; left: 0; right: 0;
            height: 3px; background: var(--gradient);
            transform: scaleX(0);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .service-card:hover::after { transform: scaleX(1); }
        .service-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-md);
            border-color: transparent;
        }

        .service-card-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }
        .service-card-image img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .service-card:hover .service-card-image img { transform: scale(1.08); }

        .service-card-icon-placeholder {
            height: 200px;
            background: var(--gradient-light);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .service-card-icon-placeholder::before {
            content: '';
            position: absolute;
            width: 200px; height: 200px;
            background: var(--primary-50);
            border-radius: 50%;
            top: -60px; <?= $isRtl ? 'right' : 'left' ?>: -60px;
            opacity: 0.5;
        }
        .service-card-icon-placeholder::after {
            content: '';
            position: absolute;
            width: 120px; height: 120px;
            background: var(--primary-100);
            border-radius: 50%;
            bottom: -30px; <?= $isRtl ? 'left' : 'right' ?>: -30px;
            opacity: 0.4;
        }
        .service-card-icon-placeholder .icon-inner {
            position: relative; z-index: 1;
            width: 80px; height: 80px;
            background: var(--gradient);
            border-radius: 22px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 2rem;
            box-shadow: var(--shadow-primary);
            transition: var(--transition);
        }
        .service-card:hover .service-card-icon-placeholder .icon-inner { transform: scale(1.08) rotate(-3deg); }

        .service-card-badge {
            position: absolute;
            top: 1rem; <?= $isRtl ? 'left' : 'right' ?>: 1rem;
            padding: 0.25rem 0.75rem;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(8px);
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--primary);
            z-index: 2;
        }

        .service-card-body {
            padding: 1.75rem 1.75rem 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .service-card-body h3 {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 0.6rem;
            color: var(--text);
            line-height: 1.4;
        }
        .service-card-body .service-desc {
            color: var(--text-secondary);
            font-size: 0.92rem;
            line-height: 1.75;
            margin-bottom: 1.25rem;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .service-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 1rem;
            border-top: 1px solid var(--border);
        }
        .service-price-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.3rem 1rem;
            background: var(--primary-50);
            color: var(--primary);
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.88rem;
        }
        .service-price-tag i { font-size: 0.7rem; }
        .service-link-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.88rem;
            transition: var(--transition);
        }
        .service-link-btn:hover { gap: 0.7rem; }

        /* ─── CTA ─── */
        .cta-section { background: var(--gradient); position: relative; overflow: hidden; }
        .cta-section::before { content: ''; position: absolute; inset: 0; background: radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%); }
        .cta-inner { position: relative; z-index: 1; text-align: center; padding: 4rem 2rem; }
        .cta-inner h2 { font-size: clamp(1.5rem, 3vw, 2rem); color: #fff; font-weight: 800; margin-bottom: 0.75rem; }
        .cta-inner p { color: rgba(255,255,255,0.85); font-size: 1.05rem; margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto; }
        .btn-cta { display: inline-flex; align-items: center; gap: 0.6rem; padding: 1rem 2.5rem; background: #fff; color: var(--primary); border-radius: 14px; font-weight: 700; font-size: 1.05rem; font-family: var(--font); border: none; cursor: pointer; transition: var(--transition); box-shadow: 0 8px 30px rgba(0,0,0,0.15); }
        .btn-cta:hover { transform: translateY(-2px); box-shadow: 0 12px 40px rgba(0,0,0,0.2); }

        /* ─── Footer ─── */
        .footer { background: #0f172a; color: #fff; padding: 4rem 1.5rem 0; }
        .footer-grid { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 1.5fr 1fr 1fr 1fr; gap: 2.5rem; }
        @media (max-width: 992px) { .footer-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 576px) { .footer-grid { grid-template-columns: 1fr; } }
        .footer h4 { font-size: 1rem; margin-bottom: 1.25rem; font-weight: 700; }
        .footer-brand p { color: rgba(255,255,255,0.55); font-size: 0.88rem; line-height: 1.8; margin-bottom: 1.25rem; }
        .footer a { color: rgba(255,255,255,0.55); font-size: 0.88rem; display: block; margin-bottom: 0.6rem; transition: color 0.3s; }
        .footer a:hover { color: #fff; }
        .social-links { display: flex; gap: 0.6rem; }
        .social-links a { width: 38px; height: 38px; background: rgba(255,255,255,0.06); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1rem; transition: var(--transition); margin-bottom: 0; }
        .social-links a:hover { background: var(--primary); color: #fff; transform: translateY(-2px); }
        .footer-bottom { max-width: 1200px; margin: 2.5rem auto 0; padding: 1.25rem 0; border-top: 1px solid rgba(255,255,255,0.06); text-align: center; font-size: 0.82rem; color: rgba(255,255,255,0.4); }
        .footer-bottom a { color: var(--accent); display: inline; }

        /* ─── WhatsApp Float ─── */
        .whatsapp-float { position: fixed; bottom: 2rem; <?= $isRtl ? 'left' : 'right' ?>: 2rem; width: 56px; height: 56px; background: #25d366; border-radius: 16px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.6rem; z-index: 999; box-shadow: 0 4px 20px rgba(37,211,102,0.35); transition: var(--transition); }
        .whatsapp-float:hover { transform: scale(1.08); box-shadow: 0 6px 28px rgba(37,211,102,0.45); }

        /* ─── Back to Top ─── */
        .back-to-top { position: fixed; bottom: 2rem; <?= $isRtl ? 'right' : 'left' ?>: 2rem; width: 44px; height: 44px; background: #fff; border-radius: 12px; display: none; align-items: center; justify-content: center; color: var(--primary); font-size: 1rem; z-index: 998; box-shadow: var(--shadow); border: 1px solid var(--border); transition: var(--transition); }
        .back-to-top.visible { display: flex; }
        .back-to-top:hover { background: var(--primary); color: #fff; transform: translateY(-2px); }

        /* ─── Animations ─── */
        .fade-up { opacity: 0; transform: translateY(28px); transition: opacity 0.7s cubic-bezier(0.4,0,0.2,1), transform 0.7s cubic-bezier(0.4,0,0.2,1); }
        .fade-up.visible { opacity: 1; transform: translateY(0); }
        .fade-up.delay-1 { transition-delay: 0.1s; }
        .fade-up.delay-2 { transition-delay: 0.2s; }
        .fade-up.delay-3 { transition-delay: 0.3s; }
        .scale-in { opacity: 0; transform: scale(0.92); transition: opacity 0.6s ease, transform 0.6s ease; }
        .scale-in.visible { opacity: 1; transform: scale(1); }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="<?= url('/site/' . $tenant->slug) ?>" class="nav-brand">
                <?php if ($tenant->logo): ?>
                    <img src="<?= upload($tenant->logo) ?>" alt="<?= htmlspecialchars($tenant->site_name) ?>">
                <?php else: ?>
                    <div class="brand-icon"><i class="fas fa-cube"></i></div>
                <?php endif; ?>
                <span><?= localized($tenant, 'site_name') ?></span>
            </a>
            <button class="mobile-btn" onclick="document.querySelector('.nav-links').classList.toggle('open')">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="nav-links" id="navLinks">
                <?php foreach ($menu as $item): ?>
                <li><a href="<?= url('/site/' . $tenant->slug . '/' . $item->slug) ?>" class=""><?= localized($item, 'title') ?></a></li>
                <?php endforeach; ?>
                <li><a href="<?= url('/site/' . $tenant->slug . '/contact') ?>" class="nav-cta"><?= lang('contact_us') ?></a></li>
                <li>
                    <a href="<?= url('/site/' . $tenant->slug . '?lang=' . Language::opposite()) ?>" class="lang-switch">
                        <i class="fas fa-globe"></i> <?= Language::opposite() === 'en' ? 'EN' : 'عربي' ?>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <main>
        <!-- ══════ Page Hero ══════ -->
        <section class="page-hero">
            <?php if ($servicesBanner && $servicesBanner->image): ?>
            <div class="page-hero-bg"></div>
            <div class="page-hero-overlay"></div>
            <?php else: ?>
            <div class="page-hero-bg"></div>
            <div class="page-hero-pattern"></div>
            <?php endif; ?>
            <div class="page-hero-content fade-up">
                <div class="hero-badge"><i class="fas fa-th-large"></i> <?= lang('our_services') ?></div>
                <h1><?= lang('our_services') ?></h1>
                <p><?= lang('services_page_subtitle') ?></p>
                <div class="breadcrumb-nav">
                    <a href="<?= url('/site/' . $tenant->slug) ?>"><?= lang('home') ?></a>
                    <span class="separator"><i class="fas fa-chevron-<?= $isRtl ? 'left' : 'right' ?>"></i></span>
                    <span class="current"><?= lang('services') ?></span>
                </div>
            </div>
        </section>

        <!-- ══════ Services Grid ══════ -->
        <section class="section">
            <div class="container">
                <?php if (!empty($services)): ?>
                <div class="services-grid">
                    <?php foreach ($services as $i => $service): ?>
                    <a href="<?= url('/site/' . $tenant->slug . '/service/' . $service->slug) ?>" class="service-card fade-up delay-<?= ($i % 4) ?>">
                        <?php if ($service->image): ?>
                        <div class="service-card-image">
                            <img src="<?= upload($service->image) ?>" alt="<?= htmlspecialchars(localized($service, 'title')) ?>">
                            <?php if ($service->price): ?>
                            <div class="service-card-badge"><?= $service->price_text ?: $service->price . ' ' . lang('currency') ?></div>
                            <?php endif; ?>
                        </div>
                        <?php else: ?>
                        <div class="service-card-icon-placeholder">
                            <div class="icon-inner">
                                <i class="<?= $service->icon ?: 'fas fa-cog' ?>"></i>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="service-card-body">
                            <h3><?= localized($service, 'title') ?></h3>
                            <p class="service-desc"><?= localized($service, 'description') ?></p>
                            <div class="service-card-footer">
                                <?php if ($service->price): ?>
                                <span class="service-price-tag"><i class="fas fa-tag"></i> <?= $service->price_text ?: $service->price . ' ' . lang('currency') ?></span>
                                <?php else: ?>
                                <span></span>
                                <?php endif; ?>
                                <span class="service-link-btn">
                                    <?= lang('read_more') ?> <i class="fas fa-arrow-<?= $isRtl ? 'left' : 'right' ?>"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div style="text-align:center; padding: 4rem 1rem;">
                    <div style="width:80px;height:80px;background:var(--primary-50);border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;font-size:2rem;color:var(--primary);">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <h3 style="font-size:1.2rem;font-weight:700;margin-bottom:0.5rem;"><?= lang('no_services') ?></h3>
                    <p style="color:var(--text-secondary);"><?= lang('no_services_desc') ?></p>
                </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- ══════ CTA ══════ -->
        <section class="cta-section">
            <div class="cta-inner fade-up">
                <h2><?= lang('need_custom_service') ?></h2>
                <p><?= lang('cta_services_text') ?></p>
                <a href="<?= url('/site/' . $tenant->slug . '/contact') ?>" class="btn-cta">
                    <i class="fas fa-<?= $isRtl ? 'arrow-left' : 'arrow-right' ?>"></i> <?= lang('contact_us') ?>
                </a>
            </div>
        </section>
    </main>

    <?php if ($tenant->contact_whatsapp): ?>
    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp) ?>" class="whatsapp-float" target="_blank" rel="noopener">
        <i class="fab fa-whatsapp"></i>
    </a>
    <?php endif; ?>

    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-chevron-up"></i>
    </a>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-brand">
                <h4><?= localized($tenant, 'site_name') ?></h4>
                <p><?= localized($tenant, 'meta_description') ?></p>
                <div class="social-links">
                    <?php if ($tenant->facebook): ?><a href="<?= $tenant->facebook ?>" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
                    <?php if ($tenant->instagram): ?><a href="<?= $tenant->instagram ?>" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a><?php endif; ?>
                    <?php if ($tenant->twitter): ?><a href="<?= $tenant->twitter ?>" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a><?php endif; ?>
                    <?php if ($tenant->youtube): ?><a href="<?= $tenant->youtube ?>" target="_blank" rel="noopener"><i class="fab fa-youtube"></i></a><?php endif; ?>
                    <?php if ($tenant->contact_whatsapp): ?><a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp) ?>" target="_blank" rel="noopener"><i class="fab fa-whatsapp"></i></a><?php endif; ?>
                    <?php if ($tenant->tiktok): ?><a href="<?= $tenant->tiktok ?>" target="_blank" rel="noopener"><i class="fab fa-tiktok"></i></a><?php endif; ?>
                </div>
            </div>
            <div>
                <h4><?= lang('services') ?></h4>
                <?php foreach (array_slice($services ?? [], 0, 5) as $service): ?>
                <a href="<?= url('/site/' . $tenant->slug . '/service/' . $service->slug) ?>"><?= localized($service, 'title') ?></a>
                <?php endforeach; ?>
            </div>
            <div>
                <h4><?= lang('quick_links') ?></h4>
                <?php foreach ($menu as $item): ?>
                <a href="<?= url('/site/' . $tenant->slug . '/' . $item->slug) ?>"><?= localized($item, 'title') ?></a>
                <?php endforeach; ?>
            </div>
            <div>
                <h4><?= lang('contact') ?></h4>
                <?php if ($tenant->contact_phone): ?><a href="tel:<?= $tenant->contact_phone ?>"><i class="fas fa-phone" style="margin-inline-end:0.5rem;font-size:0.8rem;"></i><?= $tenant->contact_phone ?></a><?php endif; ?>
                <?php if ($tenant->contact_email): ?><a href="mailto:<?= $tenant->contact_email ?>"><i class="fas fa-envelope" style="margin-inline-end:0.5rem;font-size:0.8rem;"></i><?= $tenant->contact_email ?></a><?php endif; ?>
                <?php if ($tenant->address): ?><a href="#"><i class="fas fa-map-marker-alt" style="margin-inline-end:0.5rem;font-size:0.8rem;"></i><?= $tenant->address ?></a><?php endif; ?>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> <?= localized($tenant, 'site_name') ?>. <?= lang('all_rights_reserved') ?></p>
            <p style="margin-top:0.35rem;"><?= lang('powered_by') ?> <a href="<?= defined('SITE_URL') ? SITE_URL : '#' ?>"><?= lang('site_name') ?></a></p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    (() => {
        const $ = s => document.querySelector(s);
        const $$ = s => document.querySelectorAll(s);

        window.addEventListener('scroll', () => {
            const scrollY = window.scrollY;
            $('#navbar').classList.toggle('scrolled', scrollY > 60);
            $('#backToTop').classList.toggle('visible', scrollY > 400);
        });

        $$('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                const href = a.getAttribute('href');
                if (href === '#') return;
                e.preventDefault();
                const target = $(href);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    $$('.nav-links').forEach(n => n.classList.remove('open'));
                }
            });
        });

        $$('.nav-links a').forEach(a => {
            a.addEventListener('click', () => {
                $$('.nav-links').forEach(n => n.classList.remove('open'));
            });
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

        $$('.fade-up, .scale-in').forEach(el => observer.observe(el));

        $('#backToTop').addEventListener('click', e => {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    })();
    </script>
</body>
</html>

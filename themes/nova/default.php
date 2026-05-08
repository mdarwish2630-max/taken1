<?php
/**
 * Theme: Nova - General Services - Homepage
 * القالب: نوفا - خدمات عامة - الصفحة الرئيسية
 *
 * Sections: Navbar, Hero, Stats, Services, Why Choose Us, Gallery,
 *           Testimonials, FAQ, Partners, CTA, Contact, Footer
 */

$lang = Language::current();
$dir = Language::direction();
$isRtl = $dir === 'rtl';

$showHero = !isset($sectionsConfig['hero']) || $sectionsConfig['hero'] === true;
$showServices = !isset($sectionsConfig['services']) || $sectionsConfig['services'] === true;
$showGallery = !isset($sectionsConfig['gallery']) || $sectionsConfig['gallery'] === true;
$showTestimonials = !isset($sectionsConfig['testimonials']) || $sectionsConfig['testimonials'] === true;
$showContact = !isset($sectionsConfig['contact']) || $sectionsConfig['contact'] === true;
$showWhyUs = !isset($sectionsConfig['why_us']) || $sectionsConfig['why_us'] === true;
$showFaq = !isset($sectionsConfig['faq']) || $sectionsConfig['faq'] === true;
$showPartners = !isset($sectionsConfig['partners']) || $sectionsConfig['partners'] === true;

$themePrimary = $tenant->primary_color ?? '#6366f1';
$themeSecondary = $tenant->secondary_color ?? '#4f46e5';
$themeAccent = $tenant->accent_color ?? '#f59e0b';

$heroBanner = !empty($banners) ? $banners[0] : null;

// Gallery categories
$galleryCategories = [];
if (!empty($gallery)) {
    foreach ($gallery as $g) {
        $cat = $g->category ?? 'general';
        if (!in_array($cat, $galleryCategories)) {
            $galleryCategories[] = $cat;
        }
    }
}

/**
 * ✅ CORRECT LINK PATTERN:
 * All internal links MUST use fixed English route paths that match routes.php
 * Available routes: /services, /about, /gallery, /contact, /faq, /partners, /booking, /blog
 * NEVER use Arabic slugs from $item->slug for navigation
 */
$siteBase = '/site/' . $tenant->slug;
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? $tenant->site_name ?></title>
    <meta name="description" content="<?= $meta_description ?? $tenant->meta_description ?>">
    <?php if (!empty($tenant->meta_keywords)): ?>
    <meta name="keywords" content="<?= $tenant->meta_keywords ?>">
    <?php endif; ?>
    <meta property="og:title" content="<?= $title ?? $tenant->site_name ?>">
    <meta property="og:description" content="<?= $meta_description ?? $tenant->meta_description ?>">
    <meta property="og:type" content="website">
    <?php if ($heroBanner && $heroBanner->image): ?>
    <meta property="og:image" content="<?= upload($heroBanner->image) ?>">
    <?php endif; ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap<?= $isRtl ? '.rtl' : '' ?>.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=<?= $isRtl ? 'Cairo:wght@300;400;500;600;700;800;900' : 'Poppins:wght@300;400;500;600;700;800;900' ?>&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <style>
        :root {
            --primary: <?= $themePrimary ?>;
            --primary-dark: <?= $themeSecondary ?>;
            --primary-light: color-mix(in srgb, var(--primary) 80%, white);
            --primary-50: color-mix(in srgb, var(--primary) 6%, white);
            --primary-100: color-mix(in srgb, var(--primary) 12%, white);
            --primary-200: color-mix(in srgb, var(--primary) 20%, white);
            --accent: <?= $themeAccent ?>;
            --accent-light: color-mix(in srgb, var(--accent) 80%, white);
            --gradient: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            --gradient-light: linear-gradient(135deg, var(--primary-50) 0%, white 100%);
            --gradient-accent: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.05);
            --shadow: 0 4px 20px rgba(0,0,0,0.07);
            --shadow-md: 0 8px 32px rgba(0,0,0,0.09);
            --shadow-lg: 0 16px 48px rgba(0,0,0,0.12);
            --shadow-primary: 0 8px 32px color-mix(in srgb, var(--primary) 25%, transparent);
            --radius-sm: 8px;
            --radius: 12px;
            --radius-lg: 20px;
            --radius-xl: 28px;
            --radius-full: 9999px;
            --text: #1a1a2e;
            --text-secondary: #4a4a6a;
            --text-light: #8b8ca7;
            --bg: #ffffff;
            --bg-alt: #f8f9fc;
            --bg-warm: #fdf9f5;
            --bg-subtle: #f1f4f9;
            --border: #e8eaf2;
            --border-light: #f0f1f7;
            --glass: rgba(255,255,255,0.78);
            --font: '<?= $isRtl ? 'Cairo' : 'Poppins' ?>', system-ui, -apple-system, sans-serif;
            --transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; scroll-padding-top: 80px; }
        body {
            font-family: var(--font);
            color: var(--text);
            background: var(--bg);
            line-height: 1.7;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }
        img { max-width: 100%; height: auto; display: block; }
        a { text-decoration: none; color: inherit; transition: var(--transition); }
        ul, ol { list-style: none; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }

        /* ═══════════ NAVBAR ═══════════ */
        .nova-navbar {
            background: var(--glass);
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            position: fixed; width: 100%; top: 0; z-index: 1050;
            border-bottom: 1px solid transparent;
            transition: var(--transition);
        }
        .nova-navbar.scrolled {
            background: rgba(255,255,255,0.96);
            border-bottom-color: var(--border);
            box-shadow: 0 1px 24px rgba(0,0,0,0.06);
        }
        .nova-navbar .container {
            display: flex; align-items: center; justify-content: space-between; height: 76px;
        }
        .nav-brand {
            display: flex; align-items: center; gap: 0.65rem;
            font-weight: 800; font-size: 1.2rem; color: var(--primary);
            transition: var(--transition); flex-shrink: 0;
        }
        .nav-brand:hover { opacity: 0.85; }
        .nav-brand img { height: 44px; width: auto; border-radius: var(--radius-sm); }
        .nav-brand .brand-icon {
            width: 42px; height: 42px;
            background: var(--gradient); border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.15rem; box-shadow: var(--shadow-primary);
        }
        .nav-links { display: flex; align-items: center; gap: 0.1rem; }
        .nav-links > li > a {
            padding: 0.5rem 0.85rem; border-radius: var(--radius-sm);
            font-weight: 500; font-size: 0.9rem; color: var(--text-secondary);
            transition: var(--transition); position: relative; white-space: nowrap;
        }
        .nav-links > li > a:hover, .nav-links > li > a.active {
            color: var(--primary); background: var(--primary-50);
        }
        .nav-links > li > a.active { font-weight: 600; }
        .nav-cta {
            background: var(--primary) !important; color: #fff !important;
            font-weight: 600 !important; padding: 0.55rem 1.4rem !important;
            border-radius: var(--radius) !important;
            box-shadow: 0 2px 12px color-mix(in srgb, var(--primary) 30%, transparent);
        }
        .nav-cta:hover { transform: translateY(-1px); box-shadow: var(--shadow-primary) !important; }
        .lang-switch {
            display: inline-flex; align-items: center; gap: 0.35rem;
            padding: 0.45rem 0.85rem !important; border: 1.5px solid var(--border) !important;
            border-radius: var(--radius-sm) !important; font-size: 0.8rem !important;
            font-weight: 600 !important; color: var(--text-secondary) !important;
        }
        .lang-switch:hover {
            border-color: var(--primary) !important; color: var(--primary) !important;
            background: var(--primary-50) !important;
        }
        .mobile-btn {
            display: none; background: none; border: none; font-size: 1.35rem;
            cursor: pointer; color: var(--text); padding: 0.5rem;
            border-radius: var(--radius-sm); align-items: center; justify-content: center;
            width: 42px; height: 42px;
        }
        .mobile-btn:hover { background: var(--bg-alt); }
        @media (max-width: 992px) {
            .mobile-btn { display: flex; }
            .nav-links {
                display: none; position: absolute; top: 100%; left: 0; right: 0;
                background: #fff; flex-direction: column; padding: 0.75rem;
                box-shadow: var(--shadow-lg); border-radius: 0 0 var(--radius-lg) var(--radius-lg);
                gap: 0.1rem; border-top: 1px solid var(--border);
            }
            .nav-links.open { display: flex; }
            .nav-links > li > a { padding: 0.75rem 1rem; font-size: 0.95rem; }
        }

        /* ═══════════ HERO ═══════════ */
        .nova-hero {
            position: relative; min-height: 100vh; display: flex;
            align-items: center; overflow: hidden; padding: 7rem 1.5rem 5rem;
        }
        <?php if ($heroBanner && $heroBanner->image): ?>
        .nova-hero-bg {
            position: absolute; inset: 0;
            background: url('<?= upload($heroBanner->image) ?>') center/cover no-repeat;
            transform: scale(1.08); animation: heroZoom 25s ease-in-out infinite alternate;
        }
        @keyframes heroZoom { 0% { transform: scale(1.08); } 100% { transform: scale(1.18); } }
        .nova-hero-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(160deg, rgba(10,10,30,0.82) 0%, rgba(0,0,0,0.5) 60%, rgba(0,0,0,0.4) 100%);
        }
        <?php else: ?>
        .nova-hero-bg {
            position: absolute; inset: 0;
            background: linear-gradient(135deg, #312e81 0%, #4f46e5 35%, #6366f1 65%, #818cf8 100%);
        }
        .nova-hero-bg::before {
            content: ''; position: absolute; inset: 0;
            background:
                radial-gradient(ellipse at 20% 50%, rgba(255,255,255,0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(255,255,255,0.05) 0%, transparent 40%);
        }
        <?php endif; ?>

        .hero-particles { position: absolute; inset: 0; pointer-events: none; overflow: hidden; }
        .hero-particles span {
            position: absolute; background: rgba(255,255,255,0.12); border-radius: 50%;
            animation: floatParticle linear infinite;
        }
        .hero-particles span:nth-child(1) { width:5px;height:5px;left:8%;top:25%;animation-duration:14s; }
        .hero-particles span:nth-child(2) { width:8px;height:8px;left:22%;top:65%;animation-duration:18s;animation-delay:2s; }
        .hero-particles span:nth-child(3) { width:4px;height:4px;left:45%;top:20%;animation-duration:11s;animation-delay:4s; }
        .hero-particles span:nth-child(4) { width:7px;height:7px;left:68%;top:75%;animation-duration:20s;animation-delay:1s; }
        .hero-particles span:nth-child(5) { width:6px;height:6px;left:85%;top:15%;animation-duration:16s;animation-delay:3s; }
        .hero-particles span:nth-child(6) { width:5px;height:5px;left:55%;top:85%;animation-duration:13s;animation-delay:5s; }
        @keyframes floatParticle {
            0% { transform: translateY(0) translateX(0) scale(1); opacity: 0; }
            8% { opacity: 1; }
            50% { transform: translateY(-50vh) translateX(30px) scale(0.8); }
            92% { opacity: 0.6; }
            100% { transform: translateY(-105vh) translateX(-20px) scale(0.4); opacity: 0; }
        }

        .hero-content {
            position: relative; z-index: 2; max-width: 1200px; margin: 0 auto; width: 100%;
            display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 4rem; align-items: center;
        }
        @media (max-width: 992px) {
            .hero-content { grid-template-columns: 1fr; text-align: center; gap: 2.5rem; }
            .nova-hero { min-height: auto; padding-top: 7rem; padding-bottom: 3.5rem; }
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: rgba(255,255,255,0.1); backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.18); padding: 0.4rem 1.2rem;
            border-radius: var(--radius-full); font-size: 0.82rem;
            color: rgba(255,255,255,0.92); font-weight: 500; margin-bottom: 1.5rem;
        }
        .hero-badge i { color: var(--accent); font-size: 0.7rem; }
        .hero-text h1 {
            font-size: clamp(2.2rem, 4.5vw, 3.6rem); font-weight: 900;
            color: #fff; line-height: 1.22; margin-bottom: 1.25rem; letter-spacing: -0.02em;
        }
        .hero-text h1 .highlight {
            background: linear-gradient(135deg, var(--accent) 0%, #fbbf24 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .hero-text .hero-subtitle {
            font-size: 1.1rem; color: rgba(255,255,255,0.78);
            margin-bottom: 2.25rem; line-height: 1.85; max-width: 520px;
        }
        .hero-btns { display: flex; gap: 0.85rem; flex-wrap: wrap; }
        @media (max-width: 992px) { .hero-btns { justify-content: center; } }
        .btn-hero-primary {
            display: inline-flex; align-items: center; gap: 0.6rem;
            padding: 1rem 2.1rem; background: #fff; color: var(--primary-dark);
            border-radius: var(--radius); font-weight: 700; font-size: 1rem;
            font-family: var(--font); transition: var(--transition);
            box-shadow: 0 4px 24px rgba(0,0,0,0.15); border: none; cursor: pointer;
        }
        .btn-hero-primary:hover { transform: translateY(-3px); box-shadow: 0 12px 40px rgba(0,0,0,0.22); }
        .btn-hero-outline {
            display: inline-flex; align-items: center; gap: 0.6rem;
            padding: 1rem 2.1rem; background: transparent; color: #fff;
            border-radius: var(--radius); font-weight: 600; font-size: 1rem;
            font-family: var(--font); border: 1.5px solid rgba(255,255,255,0.3);
            transition: var(--transition); cursor: pointer; backdrop-filter: blur(8px);
        }
        .btn-hero-outline:hover {
            background: rgba(255,255,255,0.12); border-color: rgba(255,255,255,0.55);
            transform: translateY(-2px);
        }

        .hero-visual { display: flex; justify-content: center; align-items: center; }
        .hero-image-wrapper { position: relative; max-width: 500px; width: 100%; }
        <?php if ($heroBanner && $heroBanner->image): ?>
        .hero-image-wrapper::before {
            content: ''; position: absolute; inset: -16px;
            background: rgba(255,255,255,0.04); border-radius: var(--radius-xl);
            transform: rotate(3deg); border: 1px solid rgba(255,255,255,0.08);
        }
        .hero-side-image {
            width: 100%; aspect-ratio: 4/3; object-fit: cover;
            border-radius: var(--radius-lg); box-shadow: 0 32px 80px rgba(0,0,0,0.35);
            position: relative; z-index: 1;
        }
        <?php else: ?>
        .hero-visual-card {
            background: rgba(255,255,255,0.06); backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.12); border-radius: var(--radius-xl);
            padding: 3.5rem 2.5rem; text-align: center; color: #fff;
            width: 100%; position: relative; overflow: hidden;
        }
        .hero-visual-card .card-icon {
            width: 88px; height: 88px; background: rgba(255,255,255,0.1);
            border-radius: 22px; display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.75rem; font-size: 2.2rem; border: 1px solid rgba(255,255,255,0.1);
        }
        .hero-visual-card h3 { font-size: 1.35rem; font-weight: 700; margin-bottom: 0.5rem; }
        .hero-visual-card p { font-size: 0.92rem; opacity: 0.7; }
        <?php endif; ?>

        /* ═══════════ SECTIONS ═══════════ */
        .section { padding: 5.5rem 1.5rem; }
        .section-alt { background: var(--bg-alt); }
        .section-warm { background: var(--bg-warm); }
        .section-subtle { background: var(--bg-subtle); }
        .section-gradient { background: var(--gradient-light); }
        .section-header { text-align: center; margin-bottom: 3.5rem; max-width: 660px; margin-left: auto; margin-right: auto; }
        .section-header h2 {
            font-size: clamp(1.65rem, 3vw, 2.3rem); font-weight: 800;
            color: var(--text); margin-bottom: 0.75rem; letter-spacing: -0.02em; line-height: 1.3;
        }
        .section-header p { color: var(--text-secondary); font-size: 1.05rem; line-height: 1.75; }
        .section-badge {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: var(--primary-50); color: var(--primary);
            padding: 0.35rem 1.15rem; border-radius: var(--radius-full);
            font-size: 0.82rem; font-weight: 600; margin-bottom: 0.85rem;
        }
        .section-badge i { font-size: 0.55rem; }

        /* ═══════════ STATS BAR ═══════════ */
        .stats-bar-wrapper { position: relative; z-index: 10; margin-top: -3.5rem; padding: 0 1.5rem; }
        .stats-bar {
            background: #fff; border-radius: var(--radius-xl); box-shadow: var(--shadow-lg);
            padding: 2.5rem 2rem; display: grid; grid-template-columns: repeat(4, 1fr);
            gap: 1rem; border: 1px solid var(--border-light);
        }
        @media (max-width: 768px) { .stats-bar { grid-template-columns: repeat(2, 1fr); padding: 2rem 1.5rem; } }
        .stat-item { text-align: center; padding: 0.75rem 0.5rem; position: relative; }
        .stat-item + .stat-item::before {
            content: ''; position: absolute; top: 20%; bottom: 20%;
            <?= $isRtl ? 'right' : 'left' ?>: 0; width: 1px; background: var(--border);
        }
        @media (max-width: 768px) { .stat-item + .stat-item::before { display: none; } }
        .stat-icon {
            width: 48px; height: 48px; background: var(--primary-50); border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 0.75rem; font-size: 1.15rem; color: var(--primary);
        }
        .stat-number {
            font-size: 2rem; font-weight: 900; background: var(--gradient);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .stat-label { color: var(--text-secondary); font-size: 0.85rem; font-weight: 500; margin-top: 0.15rem; }

        /* ═══════════ SERVICES ═══════════ */
        .services-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.75rem; }
        .service-card {
            background: #fff; border-radius: var(--radius-lg); padding: 2.25rem 1.75rem;
            text-align: center; border: 1px solid var(--border-light);
            transition: var(--transition); position: relative; overflow: hidden;
        }
        .service-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px;
            background: var(--gradient); transform: scaleX(0); transform-origin: center;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .service-card:hover::before { transform: scaleX(1); }
        .service-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-lg); border-color: transparent; }
        .service-icon-wrap {
            width: 76px; height: 76px; background: var(--primary-50); border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.25rem; font-size: 1.7rem; color: var(--primary);
            transition: var(--transition);
        }
        .service-card:hover .service-icon-wrap {
            background: var(--gradient); color: #fff; transform: scale(1.08) rotate(-3deg);
            box-shadow: var(--shadow-primary);
        }
        .service-card h3 { font-size: 1.08rem; font-weight: 700; margin-bottom: 0.6rem; color: var(--text); }
        .service-card .service-desc {
            color: var(--text-secondary); font-size: 0.9rem; line-height: 1.7;
            display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
        }
        .service-link-btn {
            display: inline-flex; align-items: center; gap: 0.4rem; margin-top: 1rem;
            color: var(--primary); font-weight: 600; font-size: 0.88rem; transition: var(--transition);
        }
        .service-link-btn:hover { gap: 0.7rem; }

        /* ═══════════ WHY CHOOSE US ═══════════ */
        .why-us-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 1.5rem; }
        .why-us-card {
            display: flex; align-items: flex-start; gap: 1.25rem; padding: 1.75rem;
            background: #fff; border-radius: var(--radius-lg);
            border: 1px solid var(--border-light); transition: var(--transition);
        }
        .why-us-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-md); border-color: transparent; }
        .why-us-icon {
            width: 60px; height: 60px; min-width: 60px; border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.35rem; color: #fff; box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }
        .why-us-card:hover .why-us-icon { transform: rotate(-5deg) scale(1.08); }
        .why-us-icon.icon-1 { background: linear-gradient(135deg, #6366f1, #4f46e5); }
        .why-us-icon.icon-2 { background: linear-gradient(135deg, #2563eb, #1d4ed8); }
        .why-us-icon.icon-3 { background: linear-gradient(135deg, #059669, #047857); }
        .why-us-icon.icon-4 { background: linear-gradient(135deg, #d97706, #b45309); }
        .why-us-icon.icon-5 { background: linear-gradient(135deg, #dc2626, #b91c1c); }
        .why-us-icon.icon-6 { background: linear-gradient(135deg, #7c3aed, #6d28d9); }
        .why-us-content h4 { font-size: 1rem; font-weight: 700; margin-bottom: 0.35rem; color: var(--text); }
        .why-us-content p { font-size: 0.88rem; color: var(--text-secondary); line-height: 1.7; }

        /* ═══════════ GALLERY ═══════════ */
        .gallery-filters { display: flex; justify-content: center; gap: 0.5rem; margin-bottom: 2.5rem; flex-wrap: wrap; }
        .gallery-filter-btn {
            padding: 0.5rem 1.25rem; border-radius: var(--radius-full);
            border: 1.5px solid var(--border); background: #fff;
            color: var(--text-secondary); font-size: 0.85rem; font-weight: 600;
            font-family: var(--font); cursor: pointer; transition: var(--transition);
        }
        .gallery-filter-btn:hover { border-color: var(--primary); color: var(--primary); background: var(--primary-50); }
        .gallery-filter-btn.active { background: var(--primary); color: #fff; border-color: var(--primary); }
        .gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.25rem; }
        .gallery-item {
            position: relative; overflow: hidden; border-radius: var(--radius);
            aspect-ratio: 4/3; cursor: pointer; box-shadow: var(--shadow-sm); transition: var(--transition);
        }
        .gallery-item.hidden-item { display: none; }
        .gallery-item:hover { transform: translateY(-5px); box-shadow: var(--shadow-lg); }
        .gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
        .gallery-item:hover img { transform: scale(1.12); }
        .gallery-hover {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.72) 0%, rgba(0,0,0,0.1) 40%, transparent 100%);
            opacity: 0; transition: opacity 0.35s ease; display: flex; align-items: flex-end; padding: 1.5rem;
        }
        .gallery-item:hover .gallery-hover { opacity: 1; }
        .gallery-hover-info span { color: #fff; font-size: 0.92rem; font-weight: 600; }
        .gallery-zoom {
            position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) scale(0.7);
            width: 48px; height: 48px; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.05rem; transition: transform 0.35s ease;
        }
        .gallery-item:hover .gallery-zoom { transform: translate(-50%, -50%) scale(1); }

        /* ═══════════ TESTIMONIALS ═══════════ */
        .testimonials-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 1.75rem; }
        .testimonial-card {
            background: #fff; border-radius: var(--radius-lg); padding: 2rem;
            border: 1px solid var(--border-light); transition: var(--transition); position: relative;
        }
        .testimonial-card:hover { box-shadow: var(--shadow-md); transform: translateY(-4px); border-color: transparent; }
        .testimonial-card .quote-icon {
            position: absolute; top: 1.25rem; <?= $isRtl ? 'right' : 'left' ?>: 1.5rem;
            font-size: 2.8rem; color: var(--primary-50); line-height: 1;
        }
        .testimonial-stars { color: #f59e0b; margin-bottom: 0.85rem; font-size: 0.85rem; display: flex; gap: 0.2rem; }
        .testimonial-text { font-size: 0.94rem; color: var(--text-secondary); margin-bottom: 1.5rem; line-height: 1.8; }
        .testimonial-footer { display: flex; align-items: center; gap: 0.85rem; padding-top: 1rem; border-top: 1px solid var(--border-light); }
        .testimonial-avatar {
            width: 48px; height: 48px; border-radius: 50%; background: var(--gradient);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: 1.05rem; flex-shrink: 0;
        }
        .testimonial-name { font-weight: 700; font-size: 0.92rem; color: var(--text); }
        .testimonial-role { font-size: 0.8rem; color: var(--text-light); }

        /* ═══════════ FAQ ═══════════ */
        .faq-grid { max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: 0.75rem; }
        .faq-item {
            background: #fff; border-radius: var(--radius); border: 1px solid var(--border-light);
            overflow: hidden; transition: var(--transition);
        }
        .faq-item.active { border-color: var(--primary); box-shadow: 0 2px 16px color-mix(in srgb, var(--primary) 10%, transparent); }
        .faq-question {
            display: flex; align-items: center; justify-content: space-between; gap: 1rem;
            padding: 1.15rem 1.5rem; cursor: pointer; font-weight: 600;
            font-size: 0.95rem; color: var(--text); user-select: none;
        }
        .faq-question:hover { color: var(--primary); }
        .faq-item.active .faq-question { color: var(--primary); }
        .faq-toggle {
            width: 32px; height: 32px; min-width: 32px; border-radius: 50%;
            background: var(--primary-50); display: flex; align-items: center; justify-content: center;
            color: var(--primary); font-size: 0.85rem; transition: transform 0.35s ease, background 0.3s ease;
        }
        .faq-item.active .faq-toggle { transform: rotate(180deg); background: var(--primary); color: #fff; }
        .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .faq-item.active .faq-answer { max-height: 300px; }
        .faq-answer-inner { padding: 0 1.5rem 1.25rem; color: var(--text-secondary); font-size: 0.9rem; line-height: 1.8; }

        /* ═══════════ PARTNERS ═══════════ */
        .partners-grid { display: flex; align-items: center; justify-content: center; flex-wrap: wrap; gap: 2rem; }
        .partner-logo {
            width: 140px; height: 80px; background: #fff; border-radius: var(--radius);
            border: 1px solid var(--border-light); display: flex; align-items: center;
            justify-content: center; padding: 1rem; transition: var(--transition);
        }
        .partner-logo:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); border-color: var(--primary); }
        .partner-logo img { max-width: 100%; max-height: 100%; object-fit: contain; filter: grayscale(100%); opacity: 0.6; transition: var(--transition); }
        .partner-logo:hover img { filter: grayscale(0%); opacity: 1; }

        /* ═══════════ CTA ═══════════ */
        .cta-section {
            background: var(--gradient); padding: 5rem 1.5rem; position: relative; overflow: hidden;
        }
        .cta-section::before {
            content: ''; position: absolute; top: -60px; <?= $isRtl ? 'left' : 'right' ?>: -60px;
            width: 200px; height: 200px; background: rgba(255,255,255,0.05); border-radius: 50%;
        }
        .cta-content { text-align: center; position: relative; z-index: 1; max-width: 640px; margin: 0 auto; }
        .cta-content h2 { font-size: clamp(1.8rem, 3.5vw, 2.5rem); font-weight: 800; color: #fff; margin-bottom: 1rem; }
        .cta-content p { color: rgba(255,255,255,0.85); font-size: 1.1rem; margin-bottom: 2rem; line-height: 1.8; }
        .btn-cta {
            display: inline-flex; align-items: center; gap: 0.6rem; padding: 1rem 2.5rem;
            background: #fff; color: var(--primary-dark); border-radius: var(--radius);
            font-weight: 700; font-size: 1rem; font-family: var(--font);
            transition: var(--transition); border: none; cursor: pointer;
            box-shadow: 0 4px 24px rgba(0,0,0,0.15);
        }
        .btn-cta:hover { transform: translateY(-3px); box-shadow: 0 12px 40px rgba(0,0,0,0.25); }

        /* ═══════════ CONTACT ═══════════ */
        .contact-grid { display: grid; grid-template-columns: 1fr 1.2fr; gap: 3rem; align-items: start; }
        @media (max-width: 768px) { .contact-grid { grid-template-columns: 1fr; } }
        .contact-info { display: flex; flex-direction: column; gap: 1.5rem; }
        .contact-info-item {
            display: flex; align-items: flex-start; gap: 1rem; padding: 1.25rem;
            background: var(--bg-alt); border-radius: var(--radius); transition: var(--transition);
        }
        .contact-info-item:hover { background: var(--primary-50); }
        .contact-info-icon {
            width: 48px; height: 48px; min-width: 48px; background: var(--gradient);
            border-radius: var(--radius-sm); display: flex; align-items: center;
            justify-content: center; color: #fff; font-size: 1rem;
        }
        .contact-info-text h4 { font-size: 0.92rem; font-weight: 700; color: var(--text); margin-bottom: 0.2rem; }
        .contact-info-text p, .contact-info-text a { font-size: 0.88rem; color: var(--text-secondary); }
        .contact-form-card {
            background: #fff; border-radius: var(--radius-lg); padding: 2.5rem;
            box-shadow: var(--shadow); border: 1px solid var(--border-light);
        }
        .contact-form-card h3 { font-size: 1.3rem; font-weight: 700; margin-bottom: 1.75rem; }
        .form-group { margin-bottom: 1.25rem; }
        .form-group label { display: block; font-weight: 600; font-size: 0.88rem; color: var(--text); margin-bottom: 0.4rem; }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%; padding: 0.8rem 1rem; border: 1.5px solid var(--border);
            border-radius: var(--radius-sm); font-family: var(--font); font-size: 0.92rem;
            color: var(--text); transition: var(--transition); background: var(--bg);
        }
        .form-group input:focus, .form-group textarea:focus, .form-group select:focus {
            outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-50);
        }
        .form-group textarea { resize: vertical; min-height: 120px; }
        .btn-submit {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.85rem 2rem; background: var(--gradient); color: #fff;
            border: none; border-radius: var(--radius); font-weight: 700;
            font-size: 0.95rem; font-family: var(--font); cursor: pointer;
            transition: var(--transition); box-shadow: var(--shadow-primary);
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 32px color-mix(in srgb, var(--primary) 30%, transparent); }

        /* ═══════════ FOOTER ═══════════ */
        .nova-footer {
            background: #0f172a; color: rgba(255,255,255,0.7); padding: 4rem 1.5rem 1.5rem;
        }
        .footer-grid { display: grid; grid-template-columns: 1.5fr 1fr 1fr 1fr; gap: 2.5rem; margin-bottom: 3rem; }
        @media (max-width: 768px) { .footer-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 480px) { .footer-grid { grid-template-columns: 1fr; } }
        .footer-brand { display: flex; align-items: center; gap: 0.65rem; margin-bottom: 1rem; }
        .footer-brand img { height: 40px; }
        .footer-brand .brand-icon {
            width: 38px; height: 38px; background: var(--gradient); border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1rem;
        }
        .footer-brand span { font-weight: 700; color: #fff; font-size: 1.1rem; }
        .footer-desc { font-size: 0.88rem; line-height: 1.8; margin-bottom: 1.5rem; }
        .footer-social { display: flex; gap: 0.65rem; }
        .footer-social a {
            width: 38px; height: 38px; background: rgba(255,255,255,0.08); border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.7);
            transition: var(--transition); font-size: 0.9rem;
        }
        .footer-social a:hover { background: var(--primary); color: #fff; transform: translateY(-2px); }
        .footer-col h4 { color: #fff; font-weight: 700; font-size: 1rem; margin-bottom: 1.25rem; }
        .footer-col ul li { margin-bottom: 0.65rem; }
        .footer-col ul li a { font-size: 0.88rem; color: rgba(255,255,255,0.6); transition: var(--transition); }
        .footer-col ul li a:hover { color: #fff; padding-<?= $isRtl ? 'right' : 'left' ?>: 5px; }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.08); padding-top: 1.5rem;
            text-align: center; font-size: 0.82rem;
        }

        /* ═══════════ WHATSAPP FLOAT ═══════════ */
        .whatsapp-float {
            position: fixed; bottom: 24px; <?= $isRtl ? 'left' : 'right' ?>: 24px; z-index: 1000;
            width: 56px; height: 56px; background: #25d366; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.6rem; box-shadow: 0 4px 24px rgba(37,211,102,0.4);
            transition: var(--transition);
        }
        .whatsapp-float:hover { transform: scale(1.1); box-shadow: 0 6px 32px rgba(37,211,102,0.5); }

        /* ═══════════ BACK TO TOP ═══════════ */
        .back-to-top {
            position: fixed; bottom: 90px; <?= $isRtl ? 'left' : 'right' ?>: 24px; z-index: 999;
            width: 44px; height: 44px; background: var(--primary); border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1rem; box-shadow: var(--shadow-primary);
            transition: var(--transition); opacity: 0; pointer-events: none;
        }
        .back-to-top.visible { opacity: 1; pointer-events: auto; }
        .back-to-top:hover { transform: translateY(-3px); }

        /* ═══════════ ANIMATIONS ═══════════ */
        .fade-up { opacity: 0; transform: translateY(30px); transition: opacity 0.6s ease, transform 0.6s ease; }
        .fade-up.visible { opacity: 1; transform: translateY(0); }
        @media (max-width: 768px) {
            .contact-grid { grid-template-columns: 1fr; }
            .contact-form-card { padding: 1.5rem; }
            .footer-grid { grid-template-columns: 1fr; text-align: center; }
            .footer-desc { text-align: center; }
            .footer-social { justify-content: center; }
        }
        @media (max-width: 576px) {
            .form-row { grid-template-columns: 1fr !important; }
            .services-grid { grid-template-columns: 1fr; }
            .why-us-grid { grid-template-columns: 1fr; }
            .gallery-grid { grid-template-columns: repeat(2, 1fr); gap: 0.75rem; }
            .testimonials-grid { grid-template-columns: 1fr; }
            .faq-grid { padding: 0 0.5rem; }
            .partners-grid { gap: 1.5rem; }
        }
    </style>
</head>
<body>

<!-- ════════════════════════════════════════════════════════
     NAVBAR
     ════════════════════════════════════════════════════════ -->
<nav class="nova-navbar" id="mainNav">
    <div class="container">
        <a href="<?= url($siteBase) ?>" class="nav-brand">
            <?php if (!empty($tenant->logo)): ?>
                <img src="<?= upload($tenant->logo) ?>" alt="<?= htmlspecialchars($tenant->site_name) ?>">
            <?php else: ?>
                <div class="brand-icon"><i class="fas fa-gem"></i></div>
            <?php endif; ?>
            <span><?= htmlspecialchars($tenant->site_name) ?></span>
        </a>

        <ul class="nav-links" id="navLinks">
            <?php if (!empty($menu)): ?>
                <?php foreach ($menu as $item): ?>
                    <?php
                        // ✅ Map menu item slugs to correct route paths
                        $navHref = $siteBase;
                        $itemSlugLower = strtolower($item->slug ?? '');
                        if ($item->is_home == 1 || empty($item->slug)) {
                            $navHref = $siteBase;
                        } elseif (strpos($itemSlugLower, 'about') !== false) {
                            $navHref = $siteBase . '/about';
                        } elseif (strpos($itemSlugLower, 'service') !== false) {
                            $navHref = $siteBase . '/services';
                        } elseif (strpos($itemSlugLower, 'gallery') !== false || strpos($itemSlugLower, 'معرض') !== false) {
                            $navHref = $siteBase . '/gallery';
                        } elseif (strpos($itemSlugLower, 'contact') !== false || strpos($itemSlugLower, 'اتصل') !== false) {
                            $navHref = $siteBase . '/contact';
                        } elseif (strpos($itemSlugLower, 'faq') !== false || strpos($itemSlugLower, 'سؤال') !== false) {
                            $navHref = $siteBase . '/faq';
                        } elseif (strpos($itemSlugLower, 'partner') !== false || strpos($itemSlugLower, 'شريك') !== false) {
                            $navHref = $siteBase . '/partners';
                        } elseif (strpos($itemSlugLower, 'book') !== false || strpos($itemSlugLower, 'حجز') !== false) {
                            $navHref = $siteBase . '/booking';
                        } elseif (strpos($itemSlugLower, 'blog') !== false || strpos($itemSlugLower, 'مدونة') !== false) {
                            $navHref = $siteBase . '/blog';
                        } else {
                            // Fallback: try the slug as-is (for custom pages via show() route)
                            $navHref = $siteBase . '/' . $item->slug;
                        }
                    ?>
                    <li><a href="<?= url($navHref) ?>" class="<?= ($page->slug ?? '') === ($item->slug ?? '') ? 'active' : '' ?>"><?= htmlspecialchars(localized($item, 'title') ?: $item->title ?? '') ?></a></li>
                <?php endforeach; ?>
            <?php else: ?>
                <li><a href="<?= url($siteBase) ?>" class="active"><?= lang('home') ?></a></li>
                <li><a href="<?= url($siteBase . '/about') ?>"><?= lang('about_us') ?></a></li>
                <li><a href="<?= url($siteBase . '/services') ?>"><?= lang('our_services') ?></a></li>
                <li><a href="<?= url($siteBase . '/gallery') ?>"><?= lang('gallery') ?></a></li>
                <li><a href="<?= url($siteBase . '/faq') ?>"><?= lang('faq') ?></a></li>
                <li><a href="#contact" class="nav-cta"><?= lang('contact_us') ?></a></li>
            <?php endif; ?>
        </ul>

        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <a href="<?= url($siteBase . '?lang=' . Language::opposite()) ?>" class="lang-switch">
                <i class="fas fa-globe"></i>
                <?= Language::opposite() === 'en' ? 'EN' : 'عربي' ?>
            </a>
            <button class="mobile-btn" id="mobileBtn" aria-label="Menu">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</nav>

<!-- ════════════════════════════════════════════════════════
     HERO SECTION
     ════════════════════════════════════════════════════════ -->
<?php if ($showHero): ?>
<section class="nova-hero">
    <div class="nova-hero-bg"></div>
    <div class="nova-hero-overlay"></div>
    <div class="hero-particles">
        <span></span><span></span><span></span><span></span><span></span><span></span>
    </div>
    <div class="hero-content">
        <div class="hero-text">
            <div class="hero-badge">
                <i class="fas fa-star"></i>
                <?= localized($heroBanner, 'subtitle') ?: ($heroBanner->subtitle ?? lang('welcome_to') . ' ' . $tenant->site_name) ?>
            </div>
            <h1><?= localized($heroBanner, 'title') ?: ($heroBanner->title ?? $tenant->site_name) ?></h1>
            <p class="hero-subtitle"><?= localized($heroBanner, 'description') ?: ($heroBanner->description ?? $tenant->meta_description) ?></p>
            <div class="hero-btns">
                <?php if (!empty($heroBanner->link)): ?>
                    <a href="<?= htmlspecialchars($heroBanner->link) ?>" class="btn-hero-primary">
                        <i class="fas fa-arrow-<?= $isRtl ? 'left' : 'right' ?>"></i>
                        <?= localized($heroBanner, 'button_text') ?: ($heroBanner->button_text ?? lang('contact_us')) ?>
                    </a>
                <?php else: ?>
                    <a href="<?= url($siteBase . '/services') ?>" class="btn-hero-primary">
                        <i class="fas fa-arrow-<?= $isRtl ? 'left' : 'right' ?>"></i>
                        <?= lang('our_services') ?>
                    </a>
                <?php endif; ?>
                <a href="<?= url($siteBase . '/contact') ?>" class="btn-hero-outline">
                    <i class="fas fa-envelope"></i>
                    <?= lang('contact_us') ?>
                </a>
            </div>
        </div>
        <div class="hero-visual">
            <?php if ($heroBanner && $heroBanner->image): ?>
                <div class="hero-image-wrapper">
                    <img src="<?= upload($heroBanner->image) ?>" alt="<?= htmlspecialchars(localized($heroBanner, 'title') ?: ($heroBanner->title ?? '')) ?>" class="hero-side-image">
                </div>
            <?php else: ?>
                <div class="hero-visual-card">
                    <div class="card-icon"><i class="fas fa-rocket"></i></div>
                    <h3><?= lang('our_services') ?></h3>
                    <p><?= lang('discover_our_services') ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ════════════════════════════════════════════════════════
     STATS BAR
     ════════════════════════════════════════════════════════ -->
<?php if (!empty($siteStats)): ?>
<div class="stats-bar-wrapper">
    <div class="container">
        <div class="stats-bar">
            <?php foreach (array_slice($siteStats, 0, 4) as $stat): ?>
            <div class="stat-item">
                <div class="stat-icon"><i class="fas <?= $stat->icon ?? 'fa-chart-line' ?>"></i></div>
                <div class="stat-number" data-target="<?= $stat->value ?? 0 ?>">0</div>
                <div class="stat-label"><?= lang($stat->label ?? '') ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- ════════════════════════════════════════════════════════
     SERVICES SECTION
     ════════════════════════════════════════════════════════ -->
<?php if ($showServices && !empty($services)): ?>
<section class="section section-alt" id="services">
    <div class="container">
        <div class="section-header fade-up">
            <div class="section-badge"><i class="fas fa-circle"></i> <?= lang('our_services') ?></div>
            <h2><?= lang('what_we_offer') ?></h2>
            <p><?= lang('services_subtitle') ?></p>
        </div>
        <div class="services-grid">
            <?php foreach ($services as $service): ?>
            <div class="service-card fade-up">
                <?php if (!empty($service->image)): ?>
                    <div class="service-icon-wrap" style="padding:0;overflow:hidden;border-radius:20px;">
                        <img src="<?= upload($service->image) ?>" alt="<?= htmlspecialchars(localized($service, 'title') ?: $service->title) ?>" style="width:100%;height:100%;object-fit:cover;">
                    </div>
                <?php else: ?>
                    <div class="service-icon-wrap">
                        <i class="<?= $service->icon ?? 'fas fa-star' ?>"></i>
                    </div>
                <?php endif; ?>
                <h3><?= htmlspecialchars(localized($service, 'title') ?: $service->title) ?></h3>
                <p class="service-desc"><?= htmlspecialchars(localized($service, 'description') ?: $service->description ?? '') ?></p>
                <?php if (!empty($service->slug)): ?>
                <a href="<?= url($siteBase . '/service/' . $service->slug) ?>" class="service-link-btn">
                    <?= lang('read_more') ?> <i class="fas fa-arrow-<?= $isRtl ? 'left' : 'right' ?>"></i>
                </a>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php if (count($services) > 6): ?>
        <div style="text-align: center; margin-top: 2.5rem;">
            <a href="<?= url($siteBase . '/services') ?>" class="btn-hero-primary" style="background: var(--primary); color: #fff;">
                <?= lang('view_all_services') ?> <i class="fas fa-arrow-<?= $isRtl ? 'left' : 'right' ?>"></i>
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<!-- ════════════════════════════════════════════════════════
     WHY CHOOSE US
     ════════════════════════════════════════════════════════ -->
<?php if ($showWhyUs && !empty($siteFeatures)): ?>
<section class="section" id="why-us">
    <div class="container">
        <div class="section-header fade-up">
            <div class="section-badge"><i class="fas fa-circle"></i> <?= lang('why_us') ?></div>
            <h2><?= lang('why_choose_us') ?></h2>
            <p><?= lang('why_us_subtitle') ?></p>
        </div>
        <div class="why-us-grid">
            <?php $iconIdx = 1; foreach ($siteFeatures as $feature): ?>
            <div class="why-us-card fade-up">
                <div class="why-us-icon icon-<?= ($iconIdx % 6) + 1 ?>">
                    <i class="<?= $feature->icon ?? 'fas fa-check' ?>"></i>
                </div>
                <div class="why-us-content">
                    <h4><?= htmlspecialchars(localized($feature, 'title') ?: $feature->title ?? '') ?></h4>
                    <p><?= htmlspecialchars(localized($feature, 'description') ?: $feature->description ?? '') ?></p>
                </div>
            </div>
            <?php $iconIdx++; endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ════════════════════════════════════════════════════════
     GALLERY SECTION
     ════════════════════════════════════════════════════════ -->
<?php if ($showGallery && !empty($gallery)): ?>
<section class="section section-alt" id="gallery">
    <div class="container">
        <div class="section-header fade-up">
            <div class="section-badge"><i class="fas fa-circle"></i> <?= lang('our_gallery') ?></div>
            <h2><?= lang('gallery_title') ?></h2>
            <p><?= lang('gallery_subtitle') ?></p>
        </div>
        <?php if (count($galleryCategories) > 1): ?>
        <div class="gallery-filters">
            <button class="gallery-filter-btn active" data-filter="all"><?= lang('all') ?></button>
            <?php foreach ($galleryCategories as $cat): ?>
            <button class="gallery-filter-btn" data-filter="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <div class="gallery-grid">
            <?php foreach ($gallery as $g): ?>
            <div class="gallery-item fade-up" data-category="<?= htmlspecialchars($g->category ?? 'general') ?>">
                <img src="<?= upload($g->image) ?>" alt="<?= htmlspecialchars(localized($g, 'title') ?: $g->title ?? '') ?>" loading="lazy">
                <div class="gallery-hover">
                    <div class="gallery-zoom"><i class="fas fa-search-plus"></i></div>
                    <div class="gallery-hover-info">
                        <span><?= htmlspecialchars(localized($g, 'title') ?: $g->title ?? '') ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div style="text-align: center; margin-top: 2.5rem;">
            <a href="<?= url($siteBase . '/gallery') ?>" class="btn-hero-primary" style="background: var(--primary); color: #fff;">
                <?= lang('view_all_gallery') ?> <i class="fas fa-arrow-<?= $isRtl ? 'left' : 'right' ?>"></i>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ════════════════════════════════════════════════════════
     TESTIMONIALS SECTION
     ════════════════════════════════════════════════════════ -->
<?php if ($showTestimonials && !empty($testimonials)): ?>
<section class="section" id="testimonials">
    <div class="container">
        <div class="section-header fade-up">
            <div class="section-badge"><i class="fas fa-circle"></i> <?= lang('testimonials') ?></div>
            <h2><?= lang('clients_reviews') ?></h2>
            <p><?= lang('testimonials_subtitle') ?></p>
        </div>
        <div class="testimonials-grid">
            <?php foreach ($testimonials as $t): ?>
            <div class="testimonial-card fade-up">
                <div class="quote-icon"><i class="fas fa-quote-right"></i></div>
                <div class="testimonial-stars">
                    <?php for ($i = 0; $i < ($t->rating ?? 5); $i++): ?>
                    <i class="fas fa-star"></i>
                    <?php endfor; ?>
                </div>
                <p class="testimonial-text"><?= htmlspecialchars(localized($t, 'content') ?: $t->content ?? '') ?></p>
                <div class="testimonial-footer">
                    <div class="testimonial-avatar">
                        <?php if (!empty($t->client_image)): ?>
                            <img src="<?= upload($t->client_image) ?>" alt="">
                        <?php else: ?>
                            <?= mb_substr($t->client_name ?? 'U', 0, 1) ?>
                        <?php endif; ?>
                    </div>
                    <div>
                        <div class="testimonial-name"><?= htmlspecialchars($t->client_name ?? '') ?></div>
                        <div class="testimonial-role"><?= htmlspecialchars(localized($t, 'client_title') ?: $t->client_title ?? '') ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ════════════════════════════════════════════════════════
     FAQ SECTION
     ════════════════════════════════════════════════════════ -->
<?php if ($showFaq && !empty($faqItems)): ?>
<section class="section section-alt" id="faq">
    <div class="container">
        <div class="section-header fade-up">
            <div class="section-badge"><i class="fas fa-circle"></i> <?= lang('faq') ?></div>
            <h2><?= lang('common_questions') ?></h2>
            <p><?= lang('faq_subtitle') ?></p>
        </div>
        <div class="faq-grid">
            <?php foreach (array_slice($faqItems, 0, 8) as $faq): ?>
            <div class="faq-item fade-up">
                <div class="faq-question" onclick="this.parentElement.classList.toggle('active')">
                    <span><?= htmlspecialchars(localized($faq, 'question') ?: $faq->question ?? '') ?></span>
                    <div class="faq-toggle"><i class="fas fa-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-inner"><?= htmlspecialchars(localized($faq, 'answer') ?: $faq->answer ?? '') ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ════════════════════════════════════════════════════════
     PARTNERS SECTION
     ════════════════════════════════════════════════════════ -->
<?php if ($showPartners && !empty($partnerItems)): ?>
<section class="section" id="partners">
    <div class="container">
        <div class="section-header fade-up">
            <div class="section-badge"><i class="fas fa-circle"></i> <?= lang('partners') ?></div>
            <h2><?= lang('our_partners') ?></h2>
            <p><?= lang('partners_subtitle') ?></p>
        </div>
        <div class="partners-grid">
            <?php foreach ($partnerItems as $p): ?>
            <div class="partner-logo fade-up">
                <?php if (!empty($p->logo)): ?>
                    <?php if (!empty($p->link)): ?>
                        <a href="<?= htmlspecialchars($p->link) ?>" target="_blank" rel="noopener">
                            <img src="<?= upload($p->logo) ?>" alt="<?= htmlspecialchars(localized($p, 'name') ?: $p->name ?? '') ?>">
                        </a>
                    <?php else: ?>
                        <img src="<?= upload($p->logo) ?>" alt="<?= htmlspecialchars(localized($p, 'name') ?: $p->name ?? '') ?>">
                    <?php endif; ?>
                <?php else: ?>
                    <span style="font-weight:700;color:var(--text);"><?= htmlspecialchars(localized($p, 'name') ?: $p->name ?? '') ?></span>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ════════════════════════════════════════════════════════
     CTA SECTION
     ════════════════════════════════════════════════════════ -->
<section class="cta-section">
    <div class="cta-content fade-up">
        <h2><?= lang('cta_title') ?></h2>
        <p><?= lang('cta_subtitle') ?></p>
        <a href="<?= url($siteBase . '/contact') ?>" class="btn-cta">
            <i class="fas fa-paper-plane"></i>
            <?= lang('contact_us_now') ?>
        </a>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════
     CONTACT SECTION
     ════════════════════════════════════════════════════════ -->
<?php if ($showContact): ?>
<section class="section section-alt" id="contact">
    <div class="container">
        <div class="section-header fade-up">
            <div class="section-badge"><i class="fas fa-circle"></i> <?= lang('contact_us') ?></div>
            <h2><?= lang('get_in_touch') ?></h2>
            <p><?= lang('contact_subtitle') ?></p>
        </div>
        <div class="contact-grid">
            <div class="contact-info fade-up">
                <?php if (!empty($tenant->contact_phone)): ?>
                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="fas fa-phone"></i></div>
                    <div class="contact-info-text">
                        <h4><?= lang('phone') ?></h4>
                        <a href="tel:<?= $tenant->contact_phone ?>" dir="ltr"><?= $tenant->contact_phone ?></a>
                    </div>
                </div>
                <?php endif; ?>
                <?php if (!empty($tenant->contact_email)): ?>
                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="fas fa-envelope"></i></div>
                    <div class="contact-info-text">
                        <h4><?= lang('email') ?></h4>
                        <a href="mailto:<?= $tenant->contact_email ?>"><?= $tenant->contact_email ?></a>
                    </div>
                </div>
                <?php endif; ?>
                <?php if (!empty($tenant->address)): ?>
                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="contact-info-text">
                        <h4><?= lang('address') ?></h4>
                        <p><?= htmlspecialchars($tenant->address) ?></p>
                    </div>
                </div>
                <?php endif; ?>
                <?php if (!empty($tenant->working_hours)): ?>
                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="fas fa-clock"></i></div>
                    <div class="contact-info-text">
                        <h4><?= lang('working_hours') ?></h4>
                        <p><?= htmlspecialchars($tenant->working_hours) ?></p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="contact-form-card fade-up">
                <h3><?= lang('send_message') ?></h3>
                <form class="contact-form" method="POST" action="<?= url($siteBase . '/contact') ?>">
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;" class="form-row">
                        <div class="form-group">
                            <label><?= lang('name') ?></label>
                            <input type="text" name="name" required placeholder="<?= lang('your_name') ?>">
                        </div>
                        <div class="form-group">
                            <label><?= lang('phone') ?></label>
                            <input type="tel" name="phone" placeholder="<?= lang('your_phone') ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?= lang('email') ?></label>
                        <input type="email" name="email" required placeholder="<?= lang('your_email') ?>">
                    </div>
                    <div class="form-group">
                        <label><?= lang('subject') ?></label>
                        <input type="text" name="subject" placeholder="<?= lang('subject') ?>">
                    </div>
                    <div class="form-group">
                        <label><?= lang('message') ?></label>
                        <textarea name="message" required placeholder="<?= lang('your_message') ?>" rows="5"></textarea>
                    </div>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i>
                        <?= lang('send') ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ════════════════════════════════════════════════════════
     FOOTER
     ════════════════════════════════════════════════════════ -->
<footer class="nova-footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">
                    <?php if (!empty($tenant->logo)): ?>
                        <img src="<?= upload($tenant->logo) ?>" alt="">
                    <?php else: ?>
                        <div class="brand-icon"><i class="fas fa-gem"></i></div>
                    <?php endif; ?>
                    <span><?= htmlspecialchars($tenant->site_name) ?></span>
                </div>
                <p class="footer-desc"><?= htmlspecialchars($tenant->meta_description) ?></p>
                <div class="footer-social">
                    <?php if (!empty($tenant->facebook)): ?>
                    <a href="<?= $tenant->facebook ?>" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($tenant->instagram)): ?>
                    <a href="<?= $tenant->instagram ?>" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($tenant->twitter)): ?>
                    <a href="<?= $tenant->twitter ?>" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($tenant->youtube)): ?>
                    <a href="<?= $tenant->youtube ?>" target="_blank" rel="noopener"><i class="fab fa-youtube"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($tenant->contact_whatsapp)): ?>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp) ?>" target="_blank" rel="noopener"><i class="fab fa-whatsapp"></i></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="footer-col">
                <h4><?= lang('quick_links') ?></h4>
                <ul>
                    <li><a href="<?= url($siteBase) ?>"><?= lang('home') ?></a></li>
                    <li><a href="<?= url($siteBase . '/about') ?>"><?= lang('about_us') ?></a></li>
                    <li><a href="<?= url($siteBase . '/services') ?>"><?= lang('our_services') ?></a></li>
                    <li><a href="<?= url($siteBase . '/gallery') ?>"><?= lang('gallery') ?></a></li>
                    <li><a href="<?= url($siteBase . '/contact') ?>"><?= lang('contact_us') ?></a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4><?= lang('more_pages') ?></h4>
                <ul>
                    <li><a href="<?= url($siteBase . '/faq') ?>"><?= lang('faq') ?></a></li>
                    <li><a href="<?= url($siteBase . '/partners') ?>"><?= lang('partners') ?></a></li>
                    <li><a href="<?= url($siteBase . '/booking') ?>"><?= lang('booking') ?></a></li>
                    <li><a href="<?= url($siteBase . '/blog') ?>"><?= lang('blog') ?></a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4><?= lang('contact_info') ?></h4>
                <ul>
                    <?php if (!empty($tenant->contact_phone)): ?>
                    <li><a href="tel:<?= $tenant->contact_phone ?>" dir="ltr"><i class="fas fa-phone" style="margin-inline-end:0.4rem;"></i> <?= $tenant->contact_phone ?></a></li>
                    <?php endif; ?>
                    <?php if (!empty($tenant->contact_email)): ?>
                    <li><a href="mailto:<?= $tenant->contact_email ?>"><i class="fas fa-envelope" style="margin-inline-end:0.4rem;"></i> <?= $tenant->contact_email ?></a></li>
                    <?php endif; ?>
                    <?php if (!empty($tenant->address)): ?>
                    <li><span><i class="fas fa-map-marker-alt" style="margin-inline-end:0.4rem;"></i> <?= htmlspecialchars($tenant->address) ?></span></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($tenant->site_name) ?>. <?= lang('all_rights_reserved') ?></p>
        </div>
    </div>
</footer>

<!-- WhatsApp Float -->
<?php if (!empty($tenant->contact_whatsapp)): ?>
<a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp) ?>" class="whatsapp-float" target="_blank" rel="noopener" aria-label="WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>
<?php endif; ?>

<!-- Back to Top -->
<a href="#" class="back-to-top" id="backToTop" aria-label="Back to top">
    <i class="fas fa-chevron-up"></i>
</a>

<!-- ════════════════════════════════════════════════════════
     JAVASCRIPT
     ════════════════════════════════════════════════════════ -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Navbar scroll
    const nav = document.getElementById('mainNav');
    window.addEventListener('scroll', function() {
        nav.classList.toggle('scrolled', window.scrollY > 50);
    });

    // Mobile menu
    document.getElementById('mobileBtn').addEventListener('click', function() {
        document.getElementById('navLinks').classList.toggle('open');
        this.querySelector('i').classList.toggle('fa-bars');
        this.querySelector('i').classList.toggle('fa-times');
    });

    // Back to top
    const btt = document.getElementById('backToTop');
    window.addEventListener('scroll', function() {
        btt.classList.toggle('visible', window.scrollY > 400);
    });

    // Stats counter animation
    document.querySelectorAll('.stat-number[data-target]').forEach(function(el) {
        const target = parseInt(el.dataset.target);
        const suffix = el.dataset.target.replace(/[0-9]/g, '');
        let current = 0;
        const step = Math.ceil(target / 60);
        const timer = setInterval(function() {
            current += step;
            if (current >= target) { current = target; clearInterval(timer); }
            el.textContent = current.toLocaleString() + suffix;
        }, 30);
    });

    // Gallery filter
    document.querySelectorAll('.gallery-filter-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.gallery-filter-btn').forEach(function(b) { b.classList.remove('active'); });
            this.classList.add('active');
            const filter = this.dataset.filter;
            document.querySelectorAll('.gallery-item').forEach(function(item) {
                if (filter === 'all' || item.dataset.category === filter) {
                    item.classList.remove('hidden-item');
                } else {
                    item.classList.add('hidden-item');
                }
            });
        });
    });

    // Scroll reveal (fade-up)
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.fade-up').forEach(function(el) { observer.observe(el); });

    // Contact form AJAX
    document.querySelector('.contact-form').addEventListener('submit', function(e) {
        e.preventDefault();
        var form = this;
        var btn = form.querySelector('.btn-submit');
        var originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <?= lang('sending') ?>';
        btn.disabled = true;

        $.ajax({
            url: form.action,
            method: 'POST',
            data: $(form).serialize(),
            success: function(res) {
                btn.innerHTML = '<i class="fas fa-check"></i> <?= lang('sent_successfully') ?>';
                btn.style.background = 'linear-gradient(135deg, #059669, #047857)';
                form.reset();
                setTimeout(function() {
                    btn.innerHTML = originalText;
                    btn.style.background = '';
                    btn.disabled = false;
                }, 3000);
            },
            error: function() {
                btn.innerHTML = originalText;
                btn.disabled = false;
                alert('<?= lang('error_sending') ?>');
            }
        });
    });
});
</script>
</body>
</html>

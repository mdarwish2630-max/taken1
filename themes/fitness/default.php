<?php
/**
 * Theme: General Services - Enhanced Home Page (Premium)
 * القالب: خدمات عامة - الصفحة الرئيسية المتقدمة
 * 
 * Sections: Navbar, Hero, Stats, Services, Why Choose Us, Gallery (filtered),
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

$themePrimary = $tenant->primary_color ?? '#0e7490';
$themeSecondary = $tenant->secondary_color ?? '#0c4a6e';
$themeAccent = $tenant->accent_color ?? '#f59e0b';

$heroBanner = !empty($banners) ? $banners[0] : null;

// Extract gallery categories for filters
$galleryCategories = [];
if (!empty($gallery)) {
    foreach ($gallery as $g) {
        $cat = $g->category ?? 'general';
        if (!in_array($cat, $galleryCategories)) {
            $galleryCategories[] = $cat;
        }
    }
}
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
    <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <style>
        /* ════════════════════════════════════════════
           CSS CUSTOM PROPERTIES
           ════════════════════════════════════════════ */
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
            --gradient-hero: linear-gradient(160deg, rgba(0,0,0,0.72) 0%, rgba(12,74,110,0.65) 50%, rgba(14,116,144,0.55) 100%);
            --shadow-xs: 0 1px 3px rgba(0,0,0,0.04);
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.05);
            --shadow: 0 4px 20px rgba(0,0,0,0.07);
            --shadow-md: 0 8px 32px rgba(0,0,0,0.09);
            --shadow-lg: 0 16px 48px rgba(0,0,0,0.12);
            --shadow-xl: 0 24px 64px rgba(0,0,0,0.15);
            --shadow-primary: 0 8px 32px color-mix(in srgb, var(--primary) 25%, transparent);
            --shadow-glow: 0 0 40px color-mix(in srgb, var(--primary) 15%, transparent);
            --radius-sm: 8px;
            --radius: 12px;
            --radius-lg: 20px;
            --radius-xl: 28px;
            --radius-full: 9999px;
            --text: #1a1a2e;
            --text-secondary: #4a4a6a;
            --text-light: #8b8ca7;
            --text-muted: #a8a9be;
            --bg: #ffffff;
            --bg-alt: #f8f9fc;
            --bg-warm: #fdf9f5;
            --bg-subtle: #f1f4f9;
            --border: #e8eaf2;
            --border-light: #f0f1f7;
            --glass: rgba(255,255,255,0.75);
            --glass-border: rgba(255,255,255,0.3);
            --font: 'Readex Pro', system-ui, -apple-system, sans-serif;
            --transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ════════════════════════════════════════════
           BASE RESET & TYPOGRAPHY
           ════════════════════════════════════════════ */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; scroll-padding-top: 80px; }

        body {
            font-family: var(--font);
            color: var(--text);
            background: var(--bg);
            line-height: 1.7;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        img { max-width: 100%; height: auto; display: block; }
        a { text-decoration: none; color: inherit; transition: var(--transition); }
        ul, ol { list-style: none; }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }
        .container-wide { max-width: 1320px; margin: 0 auto; padding: 0 1.5rem; }

        /* ════════════════════════════════════════════
           NAVBAR
           ════════════════════════════════════════════ */
        .navbar {
            background: var(--glass);
            backdrop-filter: blur(28px) saturate(200%);
            -webkit-backdrop-filter: blur(28px) saturate(200%);
            border-bottom: 1px solid transparent;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1050;
            transition: var(--transition);
        }
        .navbar.scrolled {
            background: rgba(255,255,255,0.95);
            border-bottom-color: var(--border);
            box-shadow: 0 1px 24px rgba(0,0,0,0.06);
        }
        .navbar .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 76px;
        }
        .nav-brand {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            font-weight: 800;
            font-size: 1.2rem;
            color: var(--primary);
            transition: var(--transition);
            flex-shrink: 0;
        }
        .nav-brand:hover { opacity: 0.85; }
        .nav-brand img { height: 46px; width: auto; border-radius: var(--radius-sm); }
        .nav-brand .brand-icon {
            width: 42px; height: 42px;
            background: var(--gradient);
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.15rem;
            box-shadow: var(--shadow-primary);
        }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.1rem;
        }
        .nav-links > li > a {
            padding: 0.5rem 0.85rem;
            border-radius: var(--radius-sm);
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--text-secondary);
            transition: var(--transition);
            position: relative;
            white-space: nowrap;
        }
        .nav-links > li > a:hover {
            color: var(--primary);
            background: var(--primary-50);
        }
        .nav-links > li > a.active {
            color: var(--primary);
            background: var(--primary-50);
            font-weight: 600;
        }
        .nav-cta {
            background: var(--primary) !important;
            color: #fff !important;
            font-weight: 600 !important;
            padding: 0.55rem 1.4rem !important;
            border-radius: var(--radius) !important;
            box-shadow: 0 2px 12px color-mix(in srgb, var(--primary) 30%, transparent);
            transition: var(--transition);
        }
        .nav-cta:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-primary) !important;
        }
        .lang-switch {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.45rem 0.85rem !important;
            border: 1.5px solid var(--border) !important;
            border-radius: var(--radius-sm) !important;
            font-size: 0.8rem !important;
            font-weight: 600 !important;
            color: var(--text-secondary) !important;
            transition: var(--transition);
        }
        .lang-switch:hover {
            border-color: var(--primary) !important;
            color: var(--primary) !important;
            background: var(--primary-50) !important;
        }
        .mobile-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.35rem;
            cursor: pointer;
            color: var(--text);
            padding: 0.5rem;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            align-items: center;
            justify-content: center;
            width: 42px; height: 42px;
        }
        .mobile-btn:hover { background: var(--bg-alt); }

        @media (max-width: 992px) {
            .mobile-btn { display: flex; }
            .nav-links {
                display: none;
                position: absolute;
                top: 100%; left: 0; right: 0;
                background: #fff;
                flex-direction: column;
                padding: 0.75rem;
                box-shadow: var(--shadow-lg);
                border-radius: 0 0 var(--radius-lg) var(--radius-lg);
                gap: 0.1rem;
                border-top: 1px solid var(--border);
            }
            .nav-links.open { display: flex; }
            .nav-links > li > a { padding: 0.75rem 1rem; border-radius: var(--radius-sm); font-size: 0.95rem; }
        }

        /* ════════════════════════════════════════════
           HERO SECTION
           ════════════════════════════════════════════ */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            overflow: hidden;
            padding: 7rem 1.5rem 5rem;
        }

        <?php if ($heroBanner && $heroBanner->image): ?>
        .hero-bg {
            position: absolute; inset: 0;
            background: url('<?= upload($heroBanner->image) ?>') center/cover no-repeat;
            transform: scale(1.08);
            animation: heroZoom 25s ease-in-out infinite alternate;
        }
        @keyframes heroZoom {
            0% { transform: scale(1.08); }
            100% { transform: scale(1.18); }
        }
        .hero-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(
                160deg,
                rgba(10,10,30,0.82) 0%,
                rgba(<?= implode(',', sscanf($themePrimary, '#%2x%2x%2x')); ?>,0.7) 60%,
                rgba(<?= implode(',', sscanf($themeSecondary, '#%2x%2x%2x')); ?>,0.75) 100%
            );
        }
        <?php else: ?>
        .hero-bg {
            position: absolute; inset: 0;
            background: linear-gradient(135deg, #0c4a6e 0%, #0e7490 35%, #0891b2 65%, #06b6d4 100%);
        }
        .hero-bg::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse at 20% 50%, rgba(255,255,255,0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(255,255,255,0.05) 0%, transparent 40%);
        }
        <?php endif; ?>

        /* Floating Particles */
        .hero-particles {
            position: absolute; inset: 0; pointer-events: none; overflow: hidden;
        }
        .hero-particles span {
            position: absolute;
            background: rgba(255,255,255,0.12);
            border-radius: 50%;
            animation: floatParticle linear infinite;
        }
        .hero-particles span:nth-child(1) { width: 5px; height: 5px; left: 8%; top: 25%; animation-duration: 14s; animation-delay: 0s; }
        .hero-particles span:nth-child(2) { width: 8px; height: 8px; left: 22%; top: 65%; animation-duration: 18s; animation-delay: 2s; }
        .hero-particles span:nth-child(3) { width: 4px; height: 4px; left: 45%; top: 20%; animation-duration: 11s; animation-delay: 4s; }
        .hero-particles span:nth-child(4) { width: 7px; height: 7px; left: 68%; top: 75%; animation-duration: 20s; animation-delay: 1s; }
        .hero-particles span:nth-child(5) { width: 6px; height: 6px; left: 85%; top: 15%; animation-duration: 16s; animation-delay: 3s; }
        .hero-particles span:nth-child(6) { width: 5px; height: 5px; left: 55%; top: 85%; animation-duration: 13s; animation-delay: 5s; }
        .hero-particles span:nth-child(7) { width: 9px; height: 9px; left: 35%; top: 45%; animation-duration: 22s; animation-delay: 6s; }
        .hero-particles span:nth-child(8) { width: 4px; height: 4px; left: 92%; top: 55%; animation-duration: 15s; animation-delay: 7s; }

        @keyframes floatParticle {
            0% { transform: translateY(0) translateX(0) scale(1); opacity: 0; }
            8% { opacity: 1; }
            50% { transform: translateY(-50vh) translateX(30px) scale(0.8); }
            92% { opacity: 0.6; }
            100% { transform: translateY(-105vh) translateX(-20px) scale(0.4); opacity: 0; }
        }

        /* Hero Content Layout */
        .hero-content {
            position: relative; z-index: 2;
            max-width: 1200px; margin: 0 auto; width: 100%;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 4rem;
            align-items: center;
        }
        @media (max-width: 992px) {
            .hero-content { grid-template-columns: 1fr; text-align: center; gap: 2.5rem; }
            .hero { min-height: auto; padding-top: 7rem; padding-bottom: 3.5rem; }
        }

        .hero-badge {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.18);
            padding: 0.4rem 1.2rem;
            border-radius: var(--radius-full);
            font-size: 0.82rem;
            color: rgba(255,255,255,0.92);
            font-weight: 500;
            margin-bottom: 1.5rem;
            animation: badgePulse 3s ease-in-out infinite;
        }
        @keyframes badgePulse {
            0%, 100% { border-color: rgba(255,255,255,0.18); }
            50% { border-color: rgba(255,255,255,0.35); }
        }
        .hero-badge i { color: var(--accent); font-size: 0.7rem; }

        .hero-text h1 {
            font-size: clamp(2.2rem, 4.5vw, 3.6rem);
            font-weight: 900;
            color: #fff;
            line-height: 1.22;
            margin-bottom: 1.25rem;
            letter-spacing: -0.02em;
        }
        .hero-text h1 .highlight {
            background: linear-gradient(135deg, var(--accent) 0%, #fbbf24 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-text .hero-subtitle {
            font-size: 1.1rem;
            color: rgba(255,255,255,0.78);
            margin-bottom: 2.25rem;
            line-height: 1.85;
            max-width: 520px;
        }
        <?php if ($isRtl): ?>
        @media (min-width: 993px) { .hero-text .hero-subtitle { margin-inline-start: 0; margin-inline-end: auto; } }
        <?php endif; ?>

        .hero-btns { display: flex; gap: 0.85rem; flex-wrap: wrap; }
        @media (max-width: 992px) { .hero-btns { justify-content: center; } }

        .btn-hero-primary {
            display: inline-flex; align-items: center; gap: 0.6rem;
            padding: 1rem 2.1rem;
            background: #fff;
            color: var(--primary-dark);
            border-radius: var(--radius);
            font-weight: 700;
            font-size: 1rem;
            font-family: var(--font);
            transition: var(--transition);
            box-shadow: 0 4px 24px rgba(0,0,0,0.15);
            border: none; cursor: pointer;
        }
        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.22);
        }
        .btn-hero-outline {
            display: inline-flex; align-items: center; gap: 0.6rem;
            padding: 1rem 2.1rem;
            background: transparent;
            color: #fff;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 1rem;
            font-family: var(--font);
            border: 1.5px solid rgba(255,255,255,0.3);
            transition: var(--transition);
            cursor: pointer;
            backdrop-filter: blur(8px);
        }
        .btn-hero-outline:hover {
            background: rgba(255,255,255,0.12);
            border-color: rgba(255,255,255,0.55);
            transform: translateY(-2px);
        }

        /* Hero Visual */
        .hero-visual { display: flex; justify-content: center; align-items: center; }
        .hero-image-wrapper { position: relative; max-width: 500px; width: 100%; }

        <?php if ($heroBanner && $heroBanner->image): ?>
        .hero-image-wrapper::before {
            content: '';
            position: absolute;
            inset: -16px;
            background: rgba(255,255,255,0.04);
            border-radius: var(--radius-xl);
            transform: rotate(3deg);
            border: 1px solid rgba(255,255,255,0.08);
        }
        .hero-image-wrapper::after {
            content: '';
            position: absolute;
            inset: -30px;
            background: rgba(255,255,255,0.02);
            border-radius: 32px;
            transform: rotate(-2deg);
        }
        .hero-side-image {
            width: 100%;
            aspect-ratio: 4/3;
            object-fit: cover;
            border-radius: var(--radius-lg);
            box-shadow: 0 32px 80px rgba(0,0,0,0.35);
            position: relative; z-index: 1;
        }
        @media (max-width: 992px) { .hero-image-wrapper { max-width: 380px; } }
        <?php else: ?>
        .hero-visual-card {
            background: rgba(255,255,255,0.06);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: var(--radius-xl);
            padding: 3.5rem 2.5rem;
            text-align: center;
            color: #fff;
            width: 100%;
            position: relative;
            overflow: hidden;
        }
        .hero-visual-card::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 140px; height: 140px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
        }
        .hero-visual-card .card-icon {
            width: 88px; height: 88px;
            background: rgba(255,255,255,0.1);
            border-radius: 22px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.75rem;
            font-size: 2.2rem;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .hero-visual-card h3 { font-size: 1.35rem; font-weight: 700; margin-bottom: 0.5rem; }
        .hero-visual-card p { font-size: 0.92rem; opacity: 0.7; }
        <?php endif; ?>

        /* ════════════════════════════════════════════
           SECTION UTILITIES
           ════════════════════════════════════════════ */
        .section { padding: 5.5rem 1.5rem; }
        .section-alt { background: var(--bg-alt); }
        .section-warm { background: var(--bg-warm); }
        .section-subtle { background: var(--bg-subtle); }
        .section-gradient { background: var(--gradient-light); }

        .section-header {
            text-align: center;
            margin-bottom: 3.5rem;
            max-width: 660px;
            margin-left: auto;
            margin-right: auto;
        }
        .section-header h2 {
            font-size: clamp(1.65rem, 3vw, 2.3rem);
            font-weight: 800;
            color: var(--text);
            margin-bottom: 0.75rem;
            letter-spacing: -0.02em;
            line-height: 1.3;
        }
        .section-header p {
            color: var(--text-secondary);
            font-size: 1.05rem;
            line-height: 1.75;
        }
        .section-badge {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: var(--primary-50);
            color: var(--primary);
            padding: 0.35rem 1.15rem;
            border-radius: var(--radius-full);
            font-size: 0.82rem;
            font-weight: 600;
            margin-bottom: 0.85rem;
            letter-spacing: 0.01em;
        }
        .section-badge i { font-size: 0.55rem; }

        /* ════════════════════════════════════════════
           STATS BAR
           ════════════════════════════════════════════ */
        .stats-bar-wrapper {
            position: relative;
            z-index: 10;
            margin-top: -3.5rem;
            padding: 0 1.5rem;
        }
        .stats-bar {
            background: #fff;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            padding: 2.5rem 2rem;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            border: 1px solid var(--border-light);
        }
        @media (max-width: 768px) {
            .stats-bar { grid-template-columns: repeat(2, 1fr); padding: 2rem 1.5rem; }
        }
        .stat-item {
            text-align: center;
            padding: 0.75rem 0.5rem;
            position: relative;
        }
        .stat-item + .stat-item::before {
            content: '';
            position: absolute;
            top: 20%; bottom: 20%;
            <?= $isRtl ? 'right' : 'left' ?>: 0;
            width: 1px;
            background: var(--border);
        }
        @media (max-width: 768px) {
            .stat-item + .stat-item::before { display: none; }
        }
        .stat-icon {
            width: 48px; height: 48px;
            background: var(--primary-50);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 0.75rem;
            font-size: 1.15rem;
            color: var(--primary);
            transition: var(--transition);
        }
        .stats-bar:hover .stat-icon { transform: translateY(-2px); }
        .stat-number {
            font-size: 2rem;
            font-weight: 900;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
        }
        .stat-label {
            color: var(--text-secondary);
            font-size: 0.85rem;
            font-weight: 500;
            margin-top: 0.15rem;
        }

        /* ════════════════════════════════════════════
           SERVICE CARDS
           ════════════════════════════════════════════ */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.75rem;
        }
        .service-card {
            background: #fff;
            border-radius: var(--radius-lg);
            padding: 2.25rem 1.75rem;
            text-align: center;
            border: 1px solid var(--border-light);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }
        .service-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: var(--gradient);
            transform: scaleX(0);
            transform-origin: center;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .service-card::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 3px;
            background: var(--gradient-accent);
            transform: scaleX(0);
            transform-origin: center;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1) 0.05s;
        }
        .service-card:hover::before,
        .service-card:hover::after { transform: scaleX(1); }
        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: transparent;
        }
        .service-icon-wrap {
            width: 76px; height: 76px;
            background: var(--primary-50);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.25rem;
            font-size: 1.7rem;
            color: var(--primary);
            transition: var(--transition);
            position: relative;
        }
        .service-card:hover .service-icon-wrap {
            background: var(--gradient);
            color: #fff;
            transform: scale(1.08) rotate(-3deg);
            box-shadow: var(--shadow-primary);
        }
        .service-card h3 {
            font-size: 1.08rem;
            font-weight: 700;
            margin-bottom: 0.6rem;
            color: var(--text);
        }
        .service-card .service-desc {
            color: var(--text-secondary);
            font-size: 0.9rem;
            line-height: 1.7;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .service-card .service-price-tag {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.3rem 1rem;
            background: var(--primary-50);
            color: var(--primary);
            border-radius: var(--radius-sm);
            font-weight: 700;
            font-size: 0.88rem;
        }
        .service-link-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            margin-top: 1rem;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.88rem;
            transition: var(--transition);
        }
        .service-link-btn i { transition: transform 0.3s ease; }
        .service-link-btn:hover { gap: 0.7rem; }
        .service-link-btn:hover i { transform: translateX(<?= $isRtl ? '4px' : '-4px' ?>); }

        /* ════════════════════════════════════════════
           WHY CHOOSE US
           ════════════════════════════════════════════ */
        .why-us-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 1.5rem;
        }
        .why-us-card {
            display: flex;
            align-items: flex-start;
            gap: 1.25rem;
            padding: 1.75rem;
            background: #fff;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-light);
            transition: var(--transition);
        }
        .why-us-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
            border-color: transparent;
        }
        .why-us-icon {
            width: 60px; height: 60px;
            min-width: 60px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.35rem;
            color: #fff;
            transition: var(--transition);
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }
        .why-us-card:hover .why-us-icon {
            transform: rotate(-5deg) scale(1.08);
        }
        .why-us-icon.icon-1 { background: linear-gradient(135deg, #0891b2, #0e7490); }
        .why-us-icon.icon-2 { background: linear-gradient(135deg, #2563eb, #1d4ed8); }
        .why-us-icon.icon-3 { background: linear-gradient(135deg, #059669, #047857); }
        .why-us-icon.icon-4 { background: linear-gradient(135deg, #d97706, #b45309); }
        .why-us-icon.icon-5 { background: linear-gradient(135deg, #dc2626, #b91c1c); }
        .why-us-icon.icon-6 { background: linear-gradient(135deg, #7c3aed, #6d28d9); }

        .why-us-content h4 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.35rem;
            color: var(--text);
        }
        .why-us-content p {
            font-size: 0.88rem;
            color: var(--text-secondary);
            line-height: 1.7;
        }

        /* ════════════════════════════════════════════
           GALLERY
           ════════════════════════════════════════════ */
        .gallery-filters {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 2.5rem;
            flex-wrap: wrap;
        }
        .gallery-filter-btn {
            padding: 0.5rem 1.25rem;
            border-radius: var(--radius-full);
            border: 1.5px solid var(--border);
            background: #fff;
            color: var(--text-secondary);
            font-size: 0.85rem;
            font-weight: 600;
            font-family: var(--font);
            cursor: pointer;
            transition: var(--transition);
        }
        .gallery-filter-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-50);
        }
        .gallery-filter-btn.active {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
            box-shadow: var(--shadow-primary);
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1.25rem;
        }
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: var(--radius);
            aspect-ratio: 4/3;
            cursor: pointer;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }
        .gallery-item.hidden-item {
            display: none;
        }
        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }
        .gallery-item img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .gallery-item:hover img { transform: scale(1.12); }
        .gallery-hover {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.72) 0%, rgba(0,0,0,0.1) 40%, transparent 100%);
            opacity: 0;
            transition: opacity 0.35s ease;
            display: flex; align-items: flex-end;
            padding: 1.5rem;
        }
        .gallery-item:hover .gallery-hover { opacity: 1; }
        .gallery-hover-info { position: relative; z-index: 1; }
        .gallery-hover-info span {
            color: #fff;
            font-size: 0.92rem;
            font-weight: 600;
            display: block;
        }
        .gallery-hover-info small {
            color: rgba(255,255,255,0.65);
            font-size: 0.78rem;
        }
        .gallery-zoom {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%) scale(0.7);
            width: 48px; height: 48px;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: 1.05rem;
            transition: transform 0.35s ease;
            border: 1px solid rgba(255,255,255,0.2);
        }
        .gallery-item:hover .gallery-zoom { transform: translate(-50%, -50%) scale(1); }

        /* ════════════════════════════════════════════
           TESTIMONIALS
           ════════════════════════════════════════════ */
        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 1.75rem;
        }
        .testimonial-card {
            background: #fff;
            border-radius: var(--radius-lg);
            padding: 2rem;
            border: 1px solid var(--border-light);
            transition: var(--transition);
            position: relative;
        }
        .testimonial-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-4px);
            border-color: transparent;
        }
        .testimonial-card .quote-icon {
            position: absolute;
            top: 1.25rem;
            <?= $isRtl ? 'right' : 'left' ?>: 1.5rem;
            font-size: 2.8rem;
            color: var(--primary-50);
            line-height: 1;
        }
        .testimonial-stars {
            color: #f59e0b;
            margin-bottom: 0.85rem;
            font-size: 0.85rem;
            display: flex;
            gap: 0.2rem;
            padding-<?= $isRtl ? 'right' : 'left' ?>: 0.5rem;
        }
        .testimonial-text {
            font-size: 0.94rem;
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
            line-height: 1.8;
        }
        .testimonial-footer {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-light);
        }
        .testimonial-avatar {
            width: 48px; height: 48px;
            border-radius: 50%;
            background: var(--gradient);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: 1.05rem;
            flex-shrink: 0;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        .testimonial-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .testimonial-name { font-weight: 700; font-size: 0.92rem; color: var(--text); }
        .testimonial-role { font-size: 0.8rem; color: var(--text-light); }

        /* ════════════════════════════════════════════
           FAQ ACCORDION
           ════════════════════════════════════════════ */
        .faq-grid {
            max-width: 800px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        .faq-item {
            background: #fff;
            border-radius: var(--radius);
            border: 1px solid var(--border-light);
            overflow: hidden;
            transition: var(--transition);
        }
        .faq-item:hover {
            border-color: var(--border);
        }
        .faq-item.active {
            border-color: var(--primary);
            box-shadow: 0 2px 16px color-mix(in srgb, var(--primary) 10%, transparent);
        }
        .faq-question {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.15rem 1.5rem;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--text);
            transition: var(--transition);
            user-select: none;
        }
        .faq-question:hover { color: var(--primary); }
        .faq-item.active .faq-question { color: var(--primary); }
        .faq-question .faq-toggle {
            width: 32px; height: 32px;
            min-width: 32px;
            border-radius: 50%;
            background: var(--primary-50);
            display: flex; align-items: center; justify-content: center;
            color: var(--primary);
            font-size: 0.85rem;
            transition: transform 0.35s ease, background 0.3s ease;
        }
        .faq-item.active .faq-toggle {
            transform: rotate(180deg);
            background: var(--primary);
            color: #fff;
        }
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), padding 0.3s ease;
        }
        .faq-item.active .faq-answer {
            max-height: 300px;
        }
        .faq-answer-inner {
            padding: 0 1.5rem 1.25rem;
            color: var(--text-secondary);
            font-size: 0.9rem;
            line-height: 1.8;
        }

        /* ════════════════════════════════════════════
           PARTNERS
           ════════════════════════════════════════════ */
        .partners-grid {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 2rem;
        }
        .partner-logo {
            width: 140px; height: 80px;
            background: #fff;
            border-radius: var(--radius);
            border: 1px solid var(--border-light);
            display: flex; align-items: center; justify-content: center;
            padding: 1rem;
            transition: var(--transition);
        }
        .partner-logo:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            border-color: var(--primary);
        }
        .partner-logo img {
            max-width: 100%; max-height: 100%;
            object-fit: contain;
            filter: grayscale(100%) opacity(0.6);
            transition: filter 0.35s ease;
        }
        .partner-logo:hover img {
            filter: grayscale(0%) opacity(1);
        }
        .partner-logo .partner-placeholder {
            width: 56px; height: 56px;
            background: var(--primary-50);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            color: var(--primary);
            font-size: 1.5rem;
            opacity: 0.5;
            transition: var(--transition);
        }
        .partner-logo:hover .partner-placeholder {
            opacity: 0.85;
            transform: scale(1.05);
        }

        /* ════════════════════════════════════════════
           CTA SECTION
           ════════════════════════════════════════════ */
        .cta-section {
            background: var(--gradient);
            position: relative;
            overflow: hidden;
        }
        .cta-section::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(circle at 85% 15%, rgba(255,255,255,0.1) 0%, transparent 45%),
                radial-gradient(circle at 15% 85%, rgba(255,255,255,0.06) 0%, transparent 35%);
        }
        .cta-section::after {
            content: '';
            position: absolute;
            top: -50%; <?= $isRtl ? 'right' : 'left' ?>: -20%;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }
        .cta-inner {
            position: relative; z-index: 1;
            text-align: center;
            padding: 4.5rem 2rem;
        }
        .cta-inner h2 {
            font-size: clamp(1.6rem, 3vw, 2.1rem);
            color: #fff;
            font-weight: 800;
            margin-bottom: 0.75rem;
        }
        .cta-inner p {
            color: rgba(255,255,255,0.82);
            font-size: 1.05rem;
            margin-bottom: 2rem;
            max-width: 520px;
            margin-left: auto; margin-right: auto;
        }
        .btn-cta {
            display: inline-flex; align-items: center; gap: 0.6rem;
            padding: 1rem 2.5rem;
            background: #fff;
            color: var(--primary-dark);
            border-radius: var(--radius);
            font-weight: 700;
            font-size: 1.05rem;
            font-family: var(--font);
            border: none;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
        }
        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 44px rgba(0,0,0,0.24);
        }

        /* ════════════════════════════════════════════
           CONTACT SECTION
           ════════════════════════════════════════════ */
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1.4fr;
            gap: 2.5rem;
            align-items: start;
        }
        @media (max-width: 992px) { .contact-grid { grid-template-columns: 1fr; } }

        .contact-info-card {
            background: var(--gradient);
            border-radius: var(--radius-lg);
            padding: 2.25rem;
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        .contact-info-card::before {
            content: '';
            position: absolute;
            top: -50px; <?= $isRtl ? 'right' : 'left' ?>: -50px;
            width: 140px; height: 140px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
        }
        .contact-info-card::after {
            content: '';
            position: absolute;
            bottom: -30px; <?= $isRtl ? 'left' : 'right' ?>: -30px;
            width: 100px; height: 100px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }
        .contact-info-card h3 {
            font-size: 1.3rem;
            margin-bottom: 1.75rem;
            font-weight: 700;
            position: relative;
        }
        .contact-info-item {
            display: flex; align-items: center; gap: 0.85rem;
            margin-bottom: 1.15rem;
            position: relative;
        }
        .contact-info-item .ci-icon {
            width: 44px; height: 44px;
            background: rgba(255,255,255,0.12);
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; flex-shrink: 0;
            transition: var(--transition);
        }
        .contact-info-item:hover .ci-icon { background: rgba(255,255,255,0.2); }
        .contact-info-item strong {
            display: block;
            font-size: 0.75rem;
            opacity: 0.65;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        .contact-info-item span { font-size: 0.92rem; font-weight: 500; }
        .contact-info-item a { color: #fff; }
        .contact-info-item a:hover { text-decoration: underline; }

        .contact-form-card {
            background: #fff;
            border-radius: var(--radius-lg);
            padding: 2.25rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-light);
        }
        .contact-form-card h3 {
            font-size: 1.3rem;
            margin-bottom: 1.75rem;
            font-weight: 700;
            color: var(--primary);
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.85rem;
            margin-bottom: 0.85rem;
        }
        @media (max-width: 576px) { .form-row { grid-template-columns: 1fr; } }
        .contact-form-card input,
        .contact-form-card textarea,
        .contact-form-card select {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: var(--font);
            font-size: 0.92rem;
            transition: var(--transition);
            background: var(--bg-alt);
        }
        .contact-form-card input::placeholder,
        .contact-form-card textarea::placeholder {
            color: var(--text-muted);
        }
        .contact-form-card input:focus,
        .contact-form-card textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-50);
            background: #fff;
        }
        .contact-form-card textarea { resize: vertical; min-height: 110px; }
        .contact-form-card .full-width { margin-bottom: 0.85rem; }
        .btn-submit {
            width: 100%;
            padding: 0.95rem;
            background: var(--gradient);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            font-family: var(--font);
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-primary);
        }

        /* ════════════════════════════════════════════
           FOOTER
           ════════════════════════════════════════════ */
        .footer {
            background: #0f172a;
            color: #fff;
            padding: 4.5rem 1.5rem 0;
            position: relative;
        }
        .footer::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, var(--primary) 50%, transparent 100%);
            opacity: 0.3;
        }
        .footer-grid {
            max-width: 1200px; margin: 0 auto;
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 2.5rem;
        }
        @media (max-width: 992px) { .footer-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 576px) { .footer-grid { grid-template-columns: 1fr; } }
        .footer h4 {
            font-size: 1rem;
            margin-bottom: 1.25rem;
            font-weight: 700;
            position: relative;
            padding-bottom: 0.75rem;
        }
        .footer h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            <?= $isRtl ? 'right' : 'left' ?>: 0;
            width: 32px; height: 2px;
            background: var(--primary);
            border-radius: 2px;
        }
        .footer-brand p {
            color: rgba(255,255,255,0.5);
            font-size: 0.88rem;
            line-height: 1.8;
            margin-bottom: 1.25rem;
        }
        .footer a {
            color: rgba(255,255,255,0.5);
            font-size: 0.88rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            margin-bottom: 0.6rem;
            transition: color 0.3s, padding-inline-start 0.3s;
        }
        .footer a:hover {
            color: #fff;
            padding-inline-start: 4px;
        }
        .social-links { display: flex; gap: 0.6rem; margin-top: 0.5rem; }
        .social-links a {
            width: 40px; height: 40px;
            background: rgba(255,255,255,0.06);
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            transition: var(--transition);
            margin-bottom: 0;
            padding: 0;
        }
        .social-links a:hover {
            background: var(--primary);
            color: #fff;
            transform: translateY(-3px);
            padding-inline-start: 0;
        }
        .footer-bottom {
            max-width: 1200px; margin: 2.5rem auto 0;
            padding: 1.25rem 0;
            border-top: 1px solid rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.82rem;
            color: rgba(255,255,255,0.4);
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        @media (max-width: 576px) { .footer-bottom { flex-direction: column; text-align: center; } }
        .footer-bottom a { color: var(--accent); display: inline; padding: 0; }
        .footer-bottom a:hover { padding: 0; color: #fff; }

        /* ════════════════════════════════════════════
           WHATSAPP FLOAT
           ════════════════════════════════════════════ */
        .whatsapp-float {
            position: fixed;
            bottom: 2rem;
            <?= $isRtl ? 'left' : 'right' ?>: 2rem;
            width: 58px; height: 58px;
            background: #25d366;
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.65rem;
            text-decoration: none;
            z-index: 999;
            box-shadow: 0 6px 24px rgba(37,211,102,0.35);
            transition: var(--transition);
            animation: whatsappPulse 3s ease-in-out infinite;
        }
        .whatsapp-float:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 32px rgba(37,211,102,0.5);
        }
        @keyframes whatsappPulse {
            0%, 100% { box-shadow: 0 6px 24px rgba(37,211,102,0.35); }
            50% { box-shadow: 0 6px 32px rgba(37,211,102,0.5), 0 0 0 8px rgba(37,211,102,0.1); }
        }

        /* ════════════════════════════════════════════
           BACK TO TOP
           ════════════════════════════════════════════ */
        .back-to-top {
            position: fixed;
            bottom: 2rem;
            <?= $isRtl ? 'right' : 'left' ?>: 2rem;
            width: 46px; height: 46px;
            background: #fff;
            border-radius: var(--radius-sm);
            display: none; align-items: center; justify-content: center;
            color: var(--primary); font-size: 1rem;
            text-decoration: none;
            z-index: 998;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            transition: var(--transition);
        }
        .back-to-top.visible { display: flex; }
        .back-to-top:hover {
            background: var(--primary);
            color: #fff;
            transform: translateY(-3px);
            box-shadow: var(--shadow-primary);
        }

        /* ════════════════════════════════════════════
           SCROLL ANIMATIONS
           ════════════════════════════════════════════ */
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.7s cubic-bezier(0.4,0,0.2,1), transform 0.7s cubic-bezier(0.4,0,0.2,1);
        }
        .fade-up.visible { opacity: 1; transform: translateY(0); }
        .fade-up.delay-1 { transition-delay: 0.08s; }
        .fade-up.delay-2 { transition-delay: 0.16s; }
        .fade-up.delay-3 { transition-delay: 0.24s; }
        .fade-up.delay-4 { transition-delay: 0.32s; }
        .fade-up.delay-5 { transition-delay: 0.4s; }

        .scale-in {
            opacity: 0;
            transform: scale(0.92);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .scale-in.visible { opacity: 1; transform: scale(1); }

        .slide-<?= $isRtl ? 'right' : 'left' ?> {
            opacity: 0;
            transform: translateX(-40px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .slide-<?= $isRtl ? 'right' : 'left' ?>.visible { opacity: 1; transform: translateX(0); }

        .slide-<?= $isRtl ? 'left' : 'right' ?> {
            opacity: 0;
            transform: translateX(40px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .slide-<?= $isRtl ? 'left' : 'right' ?>.visible { opacity: 1; transform: translateX(0); }

        /* ════════════════════════════════════════════
           NON-HOME CONTENT PAGE
           ════════════════════════════════════════════ */
        .page-content {
            padding: 8rem 1.5rem 4rem;
            min-height: 60vh;
        }
        .page-content .container {
            max-width: 860px;
        }
        .page-content h1 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            color: var(--text);
        }
        .page-content .content-body {
            max-width: 100%;
            margin: 0 auto;
            line-height: 1.9;
            color: var(--text-secondary);
            font-size: 1.02rem;
        }
        .page-content .content-body p { margin-bottom: 1rem; }
        .page-content .content-body img { border-radius: var(--radius); margin: 1.5rem 0; }
    </style>
</head>
<body>

    <!-- ════════════════════════════════════════════
         NAVBAR
         ════════════════════════════════════════════ -->
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

            <button class="mobile-btn" id="mobileToggle" aria-label="<?= $isRtl ? 'فتح القائمة' : 'Open menu' ?>">
                <i class="fas fa-bars" id="mobileIcon"></i>
            </button>

            <ul class="nav-links" id="navLinks">
                <?php foreach ($menu as $item): ?>
                <li>
                    <a href="<?= url('/site/' . $tenant->slug . '/' . $item->slug) ?>"
                       class="<?= (isset($page) && $page->slug === $item->slug) ? 'active' : '' ?>">
                        <?= localized($item, 'title') ?>
                    </a>
                </li>
                <?php endforeach; ?>
                <li><a href="#contact" class="nav-cta"><?= lang('contact_us') ?></a></li>
                <li>
                    <a href="<?= url('/site/' . $tenant->slug . '?lang=' . Language::opposite()) ?>" class="lang-switch">
                        <i class="fas fa-globe"></i>
                        <?= Language::opposite() === 'en' ? 'EN' : 'عربي' ?>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <main>
        <?php if ($page->is_home): ?>

        <!-- ════════════════════════════════════════
             HERO SECTION
             ════════════════════════════════════════ -->
        <?php if ($showHero): ?>
        <section class="hero" id="hero">
            <?php if ($heroBanner && $heroBanner->image): ?>
            <div class="hero-bg"></div>
            <div class="hero-overlay"></div>
            <?php else: ?>
            <div class="hero-bg"></div>
            <?php endif; ?>

            <div class="hero-particles">
                <span></span><span></span><span></span><span></span>
                <span></span><span></span><span></span><span></span>
            </div>

            <div class="hero-content">
                <div class="hero-text">
                    <div class="hero-badge">
                        <i class="fas fa-star"></i>
                        <?= lang('professional_service') ?>
                    </div>
                    <h1>
                        <?= localized($heroBanner, 'title') ?: localized($tenant, 'site_name') ?>
                    </h1>
                    <p class="hero-subtitle">
                        <?= localized($heroBanner, 'subtitle') ?: localized($tenant, 'meta_description') ?: lang('quality_guaranteed') ?>
                    </p>
                    <div class="hero-btns">
                        <?php if ($heroBanner && $heroBanner->link): ?>
                        <a href="<?= $heroBanner->link ?>" class="btn-hero-primary">
                            <i class="fas fa-<?= $isRtl ? 'arrow-left' : 'arrow-right' ?>"></i>
                            <?= localized($heroBanner, 'button_text') ?: lang('our_services') ?>
                        </a>
                        <?php else: ?>
                        <a href="#services" class="btn-hero-primary">
                            <i class="fas fa-th-large"></i>
                            <?= lang('our_services') ?>
                        </a>
                        <?php endif; ?>
                        <a href="#contact" class="btn-hero-outline">
                            <i class="fas fa-phone-alt"></i>
                            <?= lang('contact_us_today') ?>
                        </a>
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="hero-image-wrapper">
                        <?php if ($heroBanner && $heroBanner->image): ?>
                        <img src="<?= upload($heroBanner->image) ?>"
                             alt="<?= htmlspecialchars(localized($heroBanner, 'title')) ?>"
                             class="hero-side-image">
                        <?php else: ?>
                        <div class="hero-visual-card">
                            <div class="card-icon"><i class="fas fa-rocket"></i></div>
                            <h3><?= lang('quality_guaranteed') ?></h3>
                            <p><?= lang('why_us') ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- ════════════════════════════════════════
             STATS BAR
             ════════════════════════════════════════ -->
<?php $showStats = !isset($sectionsConfig['stats']) || $sectionsConfig['stats'] === true; ?>
<?php if ($showStats): ?>
<?php if (!empty($siteStats)): ?>
        <div class="stats-bar-wrapper">
            <div class="container">
                <div class="stats-bar fade-up">
                    <?php foreach ($siteStats as $stat): ?>
                    <div class="stat-item">
                        <div class="stat-icon"><i class="<?= $stat->icon ?>"></i></div>
                        <div class="stat-number"><?= $stat->value ?><?= $stat->suffix ?></div>
                        <div class="stat-label"><?= Language::current() === 'en' && $stat->label_en ? $stat->label_en : $stat->label ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
<?php else: ?>
        <div class="stats-bar-wrapper">
            <div class="container">
                <div class="stats-bar fade-up">
                    <div class="stat-item">
                        <div class="stat-icon"><i class="fas fa-cogs"></i></div>
                        <div class="stat-number"><?= count($services ?? []) ?>+</div>
                        <div class="stat-label"><?= lang('services_count') ?></div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon"><i class="fas fa-users"></i></div>
                        <div class="stat-number"><?= count($testimonials ?? []) ?>+</div>
                        <div class="stat-label"><?= lang('clients_count') ?></div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon"><i class="fas fa-project-diagram"></i></div>
                        <div class="stat-number"><?= count($gallery ?? []) ?>+</div>
                        <div class="stat-label"><?= lang('projects_count') ?></div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon"><i class="fas fa-headset"></i></div>
                        <div class="stat-number">24/7</div>
                        <div class="stat-label"><?= lang('support_available') ?></div>
                    </div>
                </div>
            </div>
        </div>
<?php endif; ?>
<?php endif; ?>

        <!-- ════════════════════════════════════════
             SERVICES SECTION
             ════════════════════════════════════════ -->
        <?php if ($showServices && !empty($services)): ?>
        <section class="section" id="services" style="padding-top: 5rem;">
            <div class="container">
                <div class="section-header fade-up">
                    <span class="section-badge">
                        <i class="fas fa-circle"></i>
                        <?= lang('our_services') ?>
                    </span>
                    <h2><?= lang('what_we_offer') ?></h2>
                    <p><?= lang('services_subtitle') ?></p>
                </div>
                <div class="services-grid">
                    <?php foreach ($services as $i => $service): ?>
                    <div class="service-card fade-up delay-<?= ($i % 6) ?>">
                        <div class="service-icon-wrap">
                            <i class="<?= $service->icon ?: 'fas fa-check-circle' ?>"></i>
                        </div>
                        <h3><?= localized($service, 'title') ?></h3>
                        <p class="service-desc"><?= localized($service, 'description') ?></p>
                        <?php if ($service->price): ?>
                        <span class="service-price-tag">
                            <?= $service->price_text ?: $service->price . ' ' . lang('currency') ?>
                        </span>
                        <?php endif; ?>
                        <?php if ($service->slug): ?>
                        <a href="<?= url('/site/' . $tenant->slug . '/service/' . $service->slug) ?>" class="service-link-btn">
                            <?= lang('read_more') ?>
                            <i class="fas fa-arrow-<?= $isRtl ? 'left' : 'right' ?>"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- ════════════════════════════════════════
             WHY CHOOSE US (Database-driven)
             ════════════════════════════════════════ -->
        <?php if ($showWhyUs): ?>
        <?php
        $whyUsItems = !empty($siteFeatures) ? $siteFeatures : [];
        $iconColors = ['icon-1','icon-2','icon-3','icon-4','icon-5','icon-6'];
        // بيانات افتراضية إذا لم يكن هناك بيانات من قاعدة البيانات
        $defaultWhyUs = [
            ['icon' => 'fas fa-award', 'title' => lang('experience_title'), 'desc' => lang('experience_desc')],
            ['icon' => 'fas fa-users-cog', 'title' => lang('professional_team_title'), 'desc' => lang('professional_team_desc')],
            ['icon' => 'fas fa-tags', 'title' => lang('competitive_prices_title'), 'desc' => lang('competitive_prices_desc')],
            ['icon' => 'fas fa-bolt', 'title' => lang('fast_service_title'), 'desc' => lang('fast_service_desc')],
            ['icon' => 'fas fa-shield-alt', 'title' => lang('guarantee_title'), 'desc' => lang('guarantee_desc')],
            ['icon' => 'fas fa-tools', 'title' => lang('modern_tools_title'), 'desc' => lang('modern_tools_desc')],
        ];
        $items = !empty($whyUsItems) ? $whyUsItems : $defaultWhyUs;
        ?>
        <section class="section section-alt" id="why-us">
            <div class="container">
                <div class="section-header fade-up">
                    <span class="section-badge">
                        <i class="fas fa-circle"></i>
                        <?= lang('why_choose_us') ?>
                    </span>
                    <h2><?= lang('our_advantages') ?></h2>
                    <p><?= lang('why_us') ?></p>
                </div>
                <div class="why-us-grid">
                    <?php foreach ($items as $index => $item):
                        $iconClass = $iconColors[$index % count($iconColors)];
                        $icon = $item->icon ?? $item['icon'];
                        $title = isset($item->display_title) ? $item->display_title : ($item->title ?? $item['title']);
                        $desc = isset($item->display_description) ? $item->display_description : ($item->description ?? $item['desc']);
                        $delay = ($index % 6) + 1;
                    ?>
                    <div class="why-us-card fade-up delay-<?= $delay ?>">
                        <div class="why-us-icon <?= $iconClass ?>"><i class="<?= htmlspecialchars($icon) ?>"></i></div>
                        <div class="why-us-content">
                            <h4><?= htmlspecialchars($title) ?></h4>
                            <p><?= htmlspecialchars($desc) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- ════════════════════════════════════════
             GALLERY SECTION
             ════════════════════════════════════════ -->
        <?php if ($showGallery && !empty($gallery)): ?>
        <section class="section" id="gallery">
            <div class="container">
                <div class="section-header fade-up">
                    <span class="section-badge">
                        <i class="fas fa-circle"></i>
                        <?= lang('our_gallery') ?>
                    </span>
                    <h2><?= lang('latest_works') ?></h2>
                    <p><?= lang('gallery_subtitle') ?></p>
                </div>

                <?php if (count($galleryCategories) > 1): ?>
                <div class="gallery-filters fade-up" id="galleryFilters">
                    <button class="gallery-filter-btn active" data-filter="all">
                        <?= lang('all') ?>
                    </button>
                    <?php foreach ($galleryCategories as $cat): ?>
                    <button class="gallery-filter-btn" data-filter="<?= htmlspecialchars($cat) ?>">
                        <?= htmlspecialchars($cat) ?>
                    </button>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <div class="gallery-grid" id="galleryGrid">
                    <?php foreach ($gallery as $image): ?>
                    <div class="gallery-item scale-in"
                         data-category="<?= htmlspecialchars($image->category ?? 'general') ?>">
                        <img src="<?= upload($image->image) ?>"
                             alt="<?= htmlspecialchars(localized($image, 'title')) ?>"
                             loading="lazy">
                        <div class="gallery-hover">
                            <div class="gallery-hover-info">
                                <span><?= localized($image, 'title') ?></span>
                                <?php if ($image->category): ?>
                                <small><?= htmlspecialchars($image->category) ?></small>
                                <?php endif; ?>
                            </div>
                            <div class="gallery-zoom">
                                <i class="fas fa-search-plus"></i>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- ════════════════════════════════════════
             TESTIMONIALS SECTION
             ════════════════════════════════════════ -->
        <?php if ($showTestimonials && !empty($testimonials)): ?>
        <section class="section section-alt" id="testimonials">
            <div class="container">
                <div class="section-header fade-up">
                    <span class="section-badge">
                        <i class="fas fa-circle"></i>
                        <?= lang('what_clients_say') ?>
                    </span>
                    <h2><?= lang('trusted_by') ?></h2>
                    <p><?= lang('testimonials_subtitle') ?></p>
                </div>
                <div class="testimonials-grid">
                    <?php foreach ($testimonials as $testimonial): ?>
                    <div class="testimonial-card fade-up">
                        <i class="fas fa-quote-right quote-icon"></i>
                        <div class="testimonial-stars">
                            <?php for ($si = 0; $si < 5; $si++): ?>
                            <i class="fas fa-star"></i>
                            <?php endfor; ?>
                        </div>
                        <p class="testimonial-text"><?= localized($testimonial, 'content') ?></p>
                        <div class="testimonial-footer">
                            <?php if ($testimonial->client_image): ?>
                            <div class="testimonial-avatar">
                                <img src="<?= upload($testimonial->client_image) ?>" alt="">
                            </div>
                            <?php else: ?>
                            <div class="testimonial-avatar"><?= mb_substr($testimonial->client_name, 0, 1) ?></div>
                            <?php endif; ?>
                            <div>
                                <div class="testimonial-name"><?= htmlspecialchars($testimonial->client_name) ?></div>
                                <div class="testimonial-role"><?= localized($testimonial, 'client_title') ?></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- ════════════════════════════════════════
             FAQ SECTION
             ════════════════════════════════════════ -->
        <?php if ($showFaq): ?>
        <section class="section" id="faq">
            <div class="container">
                <div class="section-header fade-up">
                    <span class="section-badge">
                        <i class="fas fa-circle"></i>
                        <?= lang('faq_general') ?>
                    </span>
                    <h2><?= lang('faq_subtitle') ?></h2>
                    <p><?= lang('faq_service') ?></p>
                </div>
<?php if (!empty($faqItems)): ?>
                <div class="faq-grid">
                    <?php foreach ($faqItems as $index => $faqItem): ?>
                    <div class="faq-item fade-up delay-<?= ($index % 5) + 1 ?>">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span><?= Language::current() === 'en' && $faqItem->question_en ? $faqItem->question_en : $faqItem->question ?></span>
                            <div class="faq-toggle"><i class="fas fa-chevron-down"></i></div>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-inner"><?= Language::current() === 'en' && $faqItem->answer_en ? $faqItem->answer_en : $faqItem->answer ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
<?php else: ?>
                <div class="faq-grid">
                    <div class="faq-item fade-up delay-1">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span><?= lang('faq_general') ?></span>
                            <div class="faq-toggle"><i class="fas fa-chevron-down"></i></div>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-inner"><?= lang('faq_service') ?></div>
                        </div>
                    </div>
                    <div class="faq-item fade-up delay-2">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span><?= lang('faq_pricing') ?></span>
                            <div class="faq-toggle"><i class="fas fa-chevron-down"></i></div>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-inner"><?= lang('competitive_prices_desc') ?></div>
                        </div>
                    </div>
                    <div class="faq-item fade-up delay-3">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span><?= lang('experience_title') ?></span>
                            <div class="faq-toggle"><i class="fas fa-chevron-down"></i></div>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-inner"><?= lang('experience_desc') ?></div>
                        </div>
                    </div>
                    <div class="faq-item fade-up delay-4">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span><?= lang('guarantee_title') ?></span>
                            <div class="faq-toggle"><i class="fas fa-chevron-down"></i></div>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-inner"><?= lang('guarantee_desc') ?></div>
                        </div>
                    </div>
                    <div class="faq-item fade-up delay-5">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span><?= lang('fast_service_title') ?></span>
                            <div class="faq-toggle"><i class="fas fa-chevron-down"></i></div>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-inner"><?= lang('fast_service_desc') ?></div>
                        </div>
                    </div>
                    <div class="faq-item fade-up delay-1">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span><?= lang('modern_tools_title') ?></span>
                            <div class="faq-toggle"><i class="fas fa-chevron-down"></i></div>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-inner"><?= lang('modern_tools_desc') ?></div>
                        </div>
                    </div>
                </div>
<?php endif; ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- ════════════════════════════════════════
             PARTNERS SECTION (Database-driven)
             ════════════════════════════════════════ -->
        <?php if ($showPartners && !empty($partnerItems)): ?>
        <section class="section section-subtle" id="partners">
            <div class="container">
                <div class="section-header fade-up">
                    <span class="section-badge">
                        <i class="fas fa-circle"></i>
                        <?= lang('our_partners') ?>
                    </span>
                    <h2><?= lang('partners') ?></h2>
                    <p><?= lang('partners_subtitle') ?></p>
                </div>
                <div class="partners-grid fade-up">
                    <?php foreach ($partnerItems as $p): ?>
                    <div class="partner-logo">
                        <?php if ($p->logo): ?>
                        <?php if ($p->link && $p->link !== '#'): ?>
                        <a href="<?= htmlspecialchars($p->link) ?>" target="_blank" rel="noopener">
                            <img src="<?= upload($p->logo) ?>" alt="<?= htmlspecialchars($lang === 'en' && $p->name_en ? $p->name_en : $p->name) ?>" loading="lazy">
                        </a>
                        <?php else: ?>
                        <img src="<?= upload($p->logo) ?>" alt="<?= htmlspecialchars($lang === 'en' && $p->name_en ? $p->name_en : $p->name) ?>" loading="lazy">
                        <?php endif; ?>
                        <?php else: ?>
                        <div class="partner-placeholder">
                            <i class="fas fa-building"></i>
                            <small class="d-block mt-1"><?= htmlspecialchars($lang === 'en' && $p->name_en ? $p->name_en : $p->name) ?></small>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php elseif ($showPartners): ?>
        <section class="section section-subtle" id="partners">
            <div class="container">
                <div class="section-header fade-up">
                    <span class="section-badge">
                        <i class="fas fa-circle"></i>
                        <?= lang('our_partners') ?>
                    </span>
                    <h2><?= lang('partners') ?></h2>
                    <p><?= lang('partners_subtitle') ?></p>
                </div>
                <div class="partners-grid fade-up">
                    <?php
                    $partnerIcons = ['building','industry','landmark','store','chart-line','handshake'];
                    for ($pi = 0; $pi < 6; $pi++):
                    ?>
                    <div class="partner-logo">
                        <div class="partner-placeholder">
                            <i class="fas fa-<?= $partnerIcons[$pi] ?>"></i>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- ════════════════════════════════════════
             CTA SECTION (Database-driven with fallback)
             ════════════════════════════════════════ -->
        <?php $showCta = !isset($tenant->cta_is_active) || $tenant->cta_is_active; ?>
        <?php if ($showCta): ?>
        <section class="cta-section">
            <div class="cta-inner">
                <h2><?= $tenant->cta_title ? htmlspecialchars($lang === 'en' && $tenant->cta_title_en ? $tenant->cta_title_en : $tenant->cta_title) : lang('request_service') ?></h2>
                <p><?= $tenant->cta_text ? htmlspecialchars($lang === 'en' && $tenant->cta_text_en ? $tenant->cta_text_en : $tenant->cta_text) : lang('contact_subtitle') ?></p>
                <a href="<?= $tenant->cta_button_link ?: '#contact' ?>" class="btn-cta">
                    <i class="fas fa-paper-plane"></i>
                    <?= $tenant->cta_button_text ? htmlspecialchars($lang === 'en' && $tenant->cta_button_text_en ? $tenant->cta_button_text_en : $tenant->cta_button_text) : lang('contact_us_today') ?>
                </a>
            </div>
        </section>
        <?php endif; ?>

        <!-- ════════════════════════════════════════
             CONTACT SECTION
             ════════════════════════════════════════ -->
        <?php if ($showContact): ?>
        <section class="section" id="contact">
            <div class="container">
                <div class="section-header fade-up">
                    <span class="section-badge">
                        <i class="fas fa-circle"></i>
                        <?= lang('contact_us') ?>
                    </span>
                    <h2><?= lang('get_in_touch') ?></h2>
                    <p><?= lang('contact_subtitle') ?></p>
                </div>
                <div class="contact-grid">
                    <div class="contact-info-card fade-up">
                        <h3><?= lang('contact_info') ?></h3>

                        <?php if ($tenant->contact_phone): ?>
                        <div class="contact-info-item">
                            <div class="ci-icon"><i class="fas fa-phone-alt"></i></div>
                            <div>
                                <strong><?= lang('phone') ?></strong>
                                <span><a href="tel:<?= $tenant->contact_phone ?>" dir="ltr"><?= $tenant->contact_phone ?></a></span>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($tenant->contact_email): ?>
                        <div class="contact-info-item">
                            <div class="ci-icon"><i class="fas fa-envelope"></i></div>
                            <div>
                                <strong><?= lang('email') ?></strong>
                                <span><a href="mailto:<?= $tenant->contact_email ?>"><?= $tenant->contact_email ?></a></span>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($tenant->contact_whatsapp): ?>
                        <div class="contact-info-item">
                            <div class="ci-icon" style="background:rgba(37,211,102,0.2);">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div>
                                <strong>WhatsApp</strong>
                                <span>
                                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp) ?>" target="_blank" rel="noopener">
                                        <?= lang('contact_whatsapp') ?>
                                    </a>
                                </span>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($tenant->address): ?>
                        <div class="contact-info-item">
                            <div class="ci-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div>
                                <strong><?= lang('address') ?></strong>
                                <span><?= $tenant->address ?></span>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($tenant->working_hours): ?>
                        <div class="contact-info-item">
                            <div class="ci-icon"><i class="fas fa-clock"></i></div>
                            <div>
                                <strong><?= lang('working_hours') ?></strong>
                                <span><?= $tenant->working_hours ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="contact-form-card fade-up">
                        <h3><?= lang('send_message') ?></h3>
                        <form class="contact-form" method="POST" action="<?= url('/site/' . $tenant->slug . '/contact') ?>">
                            <?= csrf_field() ?>
                            <div class="form-row">
                                <input type="text" name="name" placeholder="<?= lang('your_name') ?>" required>
                                <input type="email" name="email" placeholder="<?= lang('your_email') ?>" required>
                            </div>
                            <div class="form-row">
                                <input type="tel" name="phone" placeholder="<?= lang('your_phone') ?>">
                                <input type="text" name="subject" placeholder="<?= lang('subject') ?>" required>
                            </div>
                            <div class="full-width">
                                <textarea name="message" rows="5" placeholder="<?= lang('your_message') ?>" required></textarea>
                            </div>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-paper-plane"></i>
                                <?= lang('send_message') ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <?php else: ?>
        <!-- ════════════════════════════════════════
             NON-HOME PAGE CONTENT
             ════════════════════════════════════════ -->
        <section class="page-content">
            <div class="container">
                <h1><?= localized($page, 'title') ?></h1>
                <div class="content-body"><?= localized($page, 'content') ?></div>
            </div>
        </section>
        <?php endif; ?>
    </main>

    <!-- ════════════════════════════════════════════
         WHATSAPP FLOAT BUTTON
         ════════════════════════════════════════════ -->
    <?php if ($tenant->contact_whatsapp): ?>
    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp) ?>"
       class="whatsapp-float" target="_blank" rel="noopener" aria-label="WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
    <?php endif; ?>

    <!-- ════════════════════════════════════════════
         BACK TO TOP BUTTON
         ════════════════════════════════════════════ -->
    <a href="#" class="back-to-top" id="backToTop" aria-label="<?= $isRtl ? 'العودة للأعلى' : 'Back to top' ?>">
        <i class="fas fa-chevron-up"></i>
    </a>

    <!-- ════════════════════════════════════════════
         FOOTER
         ════════════════════════════════════════════ -->
    <footer class="footer">
        <div class="footer-grid">
            <!-- Brand Column -->
            <div class="footer-brand">
                <a href="<?= url('/site/' . $tenant->slug) ?>" class="nav-brand" style="margin-bottom: 0.75rem;">
                    <?php if ($tenant->logo): ?>
                        <img src="<?= upload($tenant->logo) ?>" alt="<?= htmlspecialchars($tenant->site_name) ?>" style="height:38px;">
                    <?php else: ?>
                        <div class="brand-icon" style="width:36px;height:36px;font-size:1rem;">
                            <i class="fas fa-cube"></i>
                        </div>
                    <?php endif; ?>
                    <span><?= localized($tenant, 'site_name') ?></span>
                </a>
                <p><?= localized($tenant, 'meta_description') ?></p>
                <div class="social-links">
                    <?php if ($tenant->facebook): ?>
                    <a href="<?= $tenant->facebook ?>" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <?php endif; ?>
                    <?php if ($tenant->instagram): ?>
                    <a href="<?= $tenant->instagram ?>" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <?php endif; ?>
                    <?php if ($tenant->twitter): ?>
                    <a href="<?= $tenant->twitter ?>" target="_blank" rel="noopener" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <?php endif; ?>
                    <?php if ($tenant->youtube): ?>
                    <a href="<?= $tenant->youtube ?>" target="_blank" rel="noopener" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <?php endif; ?>
                    <?php if ($tenant->contact_whatsapp): ?>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp) ?>" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    <?php endif; ?>
                    <?php if ($tenant->tiktok): ?>
                    <a href="<?= $tenant->tiktok ?>" target="_blank" rel="noopener" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4><?= lang('quick_links') ?></h4>
                <?php foreach ($menu as $item): ?>
                <a href="<?= url('/site/' . $tenant->slug . '/' . $item->slug) ?>">
                    <i class="fas fa-chevron-<?= $isRtl ? 'left' : 'right' ?>" style="font-size:0.6rem;opacity:0.4;"></i>
                    <?= localized($item, 'title') ?>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- Services -->
            <div>
                <h4><?= lang('our_services') ?></h4>
                <?php foreach (array_slice($services ?? [], 0, 5) as $service): ?>
                <a href="<?= url('/site/' . $tenant->slug . '/service/' . $service->slug) ?>">
                    <i class="fas fa-chevron-<?= $isRtl ? 'left' : 'right' ?>" style="font-size:0.6rem;opacity:0.4;"></i>
                    <?= localized($service, 'title') ?>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- Contact Info -->
            <div>
                <h4><?= lang('contact_us') ?></h4>
                <?php if ($tenant->contact_phone): ?>
                <a href="tel:<?= $tenant->contact_phone ?>">
                    <i class="fas fa-phone" style="font-size:0.78rem;opacity:0.5;min-width:14px;"></i>
                    <?= $tenant->contact_phone ?>
                </a>
                <?php endif; ?>
                <?php if ($tenant->contact_email): ?>
                <a href="mailto:<?= $tenant->contact_email ?>">
                    <i class="fas fa-envelope" style="font-size:0.78rem;opacity:0.5;min-width:14px;"></i>
                    <?= $tenant->contact_email ?>
                </a>
                <?php endif; ?>
                <?php if ($tenant->address): ?>
                <a href="#">
                    <i class="fas fa-map-marker-alt" style="font-size:0.78rem;opacity:0.5;min-width:14px;"></i>
                    <?= $tenant->address ?>
                </a>
                <?php endif; ?>
                <?php if ($tenant->working_hours): ?>
                <a href="#">
                    <i class="fas fa-clock" style="font-size:0.78rem;opacity:0.5;min-width:14px;"></i>
                    <?= $tenant->working_hours ?>
                </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> <?= localized($tenant, 'site_name') ?>. <?= lang('all_rights_reserved') ?></p>
            <p><?= lang('powered_by') ?> <a href="<?= defined('SITE_URL') ? SITE_URL : '#' ?>"><?= defined('SITE_NAME') ? SITE_NAME : 'TakweenWeb' ?></a></p>
        </div>
    </footer>

    <!-- ════════════════════════════════════════════
         SCRIPTS
         ════════════════════════════════════════════ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    (() => {
        'use strict';

        const $ = (sel, ctx = document) => ctx.querySelector(sel);
        const $$ = (sel, ctx = document) => [...ctx.querySelectorAll(sel)];

        /* ─── Navbar Scroll Effect ─── */
        let ticking = false;
        window.addEventListener('scroll', () => {
            if (!ticking) {
                requestAnimationFrame(() => {
                    const scrollY = window.scrollY;
                    $('#navbar').classList.toggle('scrolled', scrollY > 50);
                    $('#backToTop').classList.toggle('visible', scrollY > 400);
                    ticking = false;
                });
                ticking = true;
            }
        });

        /* ─── Mobile Navigation Toggle ─── */
        const mobileToggle = $('#mobileToggle');
        const navLinks = $('#navLinks');
        const mobileIcon = $('#mobileIcon');

        if (mobileToggle && navLinks) {
            mobileToggle.addEventListener('click', () => {
                const isOpen = navLinks.classList.toggle('open');
                if (mobileIcon) {
                    mobileIcon.className = isOpen ? 'fas fa-times' : 'fas fa-bars';
                }
            });

            $$('.nav-links a', navLinks).forEach(link => {
                link.addEventListener('click', () => {
                    navLinks.classList.remove('open');
                    if (mobileIcon) mobileIcon.className = 'fas fa-bars';
                });
            });
        }

        /* ─── Smooth Scroll for Anchor Links ─── */
        $$('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                const href = anchor.getAttribute('href');
                if (!href || href === '#') return;

                const target = $(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    if (navLinks) navLinks.classList.remove('open');
                    if (mobileIcon) mobileIcon.className = 'fas fa-bars';
                }
            });
        });

        /* ─── Intersection Observer for Scroll Animations ─── */
        const animObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    animObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.06, rootMargin: '0px 0px -30px 0px' });

        $$('.fade-up, .scale-in, .slide-left, .slide-right').forEach(el => {
            animObserver.observe(el);
        });

        /* ─── Gallery Filter ─── */
        const filterContainer = $('#galleryFilters');
        const galleryGrid = $('#galleryGrid');

        if (filterContainer && galleryGrid) {
            $$('.gallery-filter-btn', filterContainer).forEach(btn => {
                btn.addEventListener('click', () => {
                    // Update active button
                    $$('.gallery-filter-btn', filterContainer).forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');

                    const filter = btn.getAttribute('data-filter');
                    const items = $$('.gallery-item', galleryGrid);

                    items.forEach(item => {
                        if (filter === 'all' || item.getAttribute('data-category') === filter) {
                            item.classList.remove('hidden-item');
                            item.style.display = '';
                        } else {
                            item.classList.add('hidden-item');
                            item.style.display = 'none';
                        }
                    });
                });
            });
        }

        /* ─── Back to Top ─── */
        const backToTop = $('#backToTop');
        if (backToTop) {
            backToTop.addEventListener('click', (e) => {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        /* ─── Counter Animation for Stats ─── */
        const statNumbers = $$('.stat-number');
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const text = el.textContent.trim();
                    const numMatch = text.match(/^(\d+)/);

                    if (numMatch) {
                        const target = parseInt(numMatch[1]);
                        const suffix = text.replace(numMatch[1], '');
                        let current = 0;
                        const duration = 1500;
                        const increment = Math.max(1, Math.ceil(target / (duration / 16)));

                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= target) {
                                current = target;
                                clearInterval(timer);
                            }
                            el.textContent = current + suffix;
                        }, 16);
                    }
                    counterObserver.unobserve(el);
                }
            });
        }, { threshold: 0.5 });

        statNumbers.forEach(el => counterObserver.observe(el));

    })();

    /* ─── FAQ Accordion ─── */
    function toggleFaq(questionEl) {
        const faqItem = questionEl.closest('.faq-item');
        const wasActive = faqItem.classList.contains('active');

        // Close all FAQ items
        document.querySelectorAll('.faq-item.active').forEach(item => {
            item.classList.remove('active');
        });

        // Toggle the clicked one
        if (!wasActive) {
            faqItem.classList.add('active');
        }
    }
    </script>
</body>
</html>

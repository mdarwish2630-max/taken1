<?php
/**
 * TakweenWeb - Professional Landing Page
 * صفحة الهبوط الاحترافية - متصلة بقواعد البيانات
 * 
 * المتغيرات المطلوبة من الكنترولر:
 * $settings  - إعدادات الموقع (site_settings)
 * $plans     - خطط الاشتراك النشطة (subscription_plans)
 * $testimonials - شهادات العملاء (site_testimonials)
 * $features  - مميزات المنصة (site_features)
 */

$lang = Language::current();
$dir  = Language::direction();
$year = date('Y');
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= defined('SITE_NAME') ? SITE_NAME : 'منصة المواقع' ?> - إنشاء مواقع احترافية</title>
    <?php if (!empty($settings->meta_description)): ?>
    <meta name="description" content="<?= htmlspecialchars($settings->meta_description) ?>">
    <?php endif; ?>
    <?php if (!empty($settings->favicon)): ?>
    <link rel="icon" href="<?= htmlspecialchars($settings->favicon) ?>">
    <?php endif; ?>

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
        img { max-width: 100%; }
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
        .navbar .logo-link img { height: 36px; }

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

        /* ==================== PRICING ==================== */
        .pricing-section { background: var(--white); }
        .pricing-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;
            align-items: center;
        }
        .plan-card {
            background: var(--white); border: 2px solid var(--gray-200);
            border-radius: var(--radius-xl); padding: 40px 28px;
            text-align: center; transition: var(--transition);
            position: relative; overflow: hidden;
        }
        .plan-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-xl); }
        .plan-card.popular {
            border-color: transparent;
            background: linear-gradient(160deg, var(--primary-dark), #7c3aed);
            color: var(--white); transform: scale(1.04);
            box-shadow: 0 20px 50px rgba(99,102,241,0.3);
        }
        .plan-card.popular:hover { transform: scale(1.04) translateY(-6px); }

        .popular-tag {
            position: absolute; top: 18px; left: 50%; transform: translateX(-50%);
            background: var(--warning); color: var(--dark);
            padding: 4px 16px; border-radius: 50px;
            font-size: 0.72rem; font-weight: 700;
        }
        .plan-label {
            display: inline-block; padding: 5px 16px; border-radius: 50px;
            font-size: 0.78rem; font-weight: 600; margin-bottom: 14px;
            background: linear-gradient(135deg, rgba(99,102,241,0.08), rgba(6,182,212,0.08));
            color: var(--primary);
        }
        .plan-card.popular .plan-label { background: rgba(255,255,255,0.15); color: rgba(255,255,255,0.9); }
        .plan-name { font-size: 1.45rem; font-weight: 700; color: var(--dark); margin-bottom: 8px; }
        .plan-card.popular .plan-name { color: var(--white); }
        .plan-price { font-size: 2.6rem; font-weight: 700; color: var(--dark); line-height: 1; margin-bottom: 6px; }
        .plan-card.popular .plan-price { color: var(--white); }
        .plan-price small { font-size: 0.88rem; font-weight: 400; color: var(--gray-400); }
        .plan-card.popular .plan-price small { color: rgba(255,255,255,0.6); }
        .plan-desc { color: var(--gray-500); font-size: 0.85rem; margin-bottom: 24px; }
        .plan-card.popular .plan-desc { color: rgba(255,255,255,0.75); }

        .plan-features { text-align: <?= $dir === 'rtl' ? 'right' : 'left' ?>; margin-bottom: 28px; }
        .plan-features li {
            padding: 7px 0; font-size: 0.88rem; color: var(--gray-600);
            display: flex; align-items: center; gap: 10px;
        }
        .plan-card.popular .plan-features li { color: rgba(255,255,255,0.88); }
        .plan-features li i { color: var(--success); font-size: 0.82rem; width: 18px; text-align: center; }
        .plan-card.popular .plan-features li i { color: #34d399; }
        .plan-card .btn { width: 100%; justify-content: center; }
        .plan-card.popular .btn { background: var(--white); color: var(--primary-dark); box-shadow: var(--shadow); }

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
        .footer-brand .f-logo img { height: 30px; }
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
            .features-grid, .testimonials-grid, .pricing-grid { grid-template-columns: 1fr; }
            .plan-card.popular { transform: none; }
            .plan-card.popular:hover { transform: translateY(-6px); }
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
    <nav class="navbar" id="navbar">
        <div class="container">
            <div class="nav-inner">
                <a href="<?= defined('BASE_URL') ? BASE_URL : '/' ?>" class="logo-link">
                    <?php if (!empty($settings->logo)): ?>
                        <img src="<?= htmlspecialchars($settings->logo) ?>" alt="Logo">
                    <?php else: ?>
                        <i class="fas fa-cube"></i>
                    <?php endif; ?>
                    <?= defined('SITE_NAME') ? SITE_NAME : 'منصة المواقع' ?>
                </a>

                <button class="mobile-toggle" id="mobileToggle"><i class="fas fa-bars"></i></button>

                <div class="nav-menu" id="navMenu">
                    <div class="lang-switch">
                        <a href="<?= url('/lang/ar') ?>" class="lang-btn <?= $lang === 'ar' ? 'active' : '' ?>">عربي</a>
                        <a href="<?= url('/lang/en') ?>" class="lang-btn <?= $lang === 'en' ? 'active' : '' ?>">EN</a>
                    </div>
                    <a href="#features" class="nav-link">المميزات</a>
                    <a href="#pricing" class="nav-link">الأسعار</a>
                    <a href="#testimonials" class="nav-link">آراء العملاء</a>
                    <?php if (function_exists('auth') && auth()): ?>
                        <a href="<?= url('/dashboard') ?>" class="nav-link">لوحة التحكم</a>
                        <a href="<?= url('/logout') ?>" class="btn btn-outline">تسجيل الخروج</a>
                    <?php else: ?>
                        <a href="<?= url('/login') ?>" class="nav-link">تسجيل الدخول</a>
                        <a href="<?= url('/register') ?>" class="btn btn-primary">ابدأ مجاناً</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-orbs">
            <div class="orb"></div><div class="orb"></div><div class="orb"></div>
        </div>
        <div class="hero-content">
            <div class="hero-chip">
                <i class="fas fa-star"></i>
                <?= !empty($settings->hero_title) ? '' : 'منصة إنشاء مواقع احترافية' ?>
            </div>
            <h1>
                <?= !empty($settings->hero_title) ? htmlspecialchars($settings->hero_title) : 'أنشئ موقعك <span class="grad">الاحترافي</span> اليوم' ?>
            </h1>
            <p class="hero-desc">
                <?= !empty($settings->hero_subtitle) ? htmlspecialchars($settings->hero_subtitle) : 'منصة سهلة ومرنة لإنشاء مواقع احترافية بدون حاجة لخبرة تقنية. اختر قالبك، خصصه، وانشر موقعك خلال دقائق.' ?>
            </p>
            <div class="hero-actions">
                <?php if (function_exists('auth') && auth()): ?>
                    <a href="<?= url('/dashboard') ?>" class="btn btn-white btn-lg"><i class="fas fa-tachometer-alt"></i> لوحة التحكم</a>
                <?php else: ?>
                    <a href="<?= url('/register') ?>" class="btn btn-white btn-lg"><i class="fas fa-rocket"></i> ابدأ مجاناً</a>
                    <a href="<?= url('/login') ?>" class="btn btn-outline-w btn-lg"><i class="fas fa-play-circle"></i> شاهد العرض</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <?php if (!empty($settings->show_features) || !isset($settings->show_features)): ?>
    <section class="section features-section" id="features">
        <div class="container">
            <div class="section-head">
                <div class="section-chip"><i class="fas fa-star"></i> <?= !empty($settings->features_title) ? htmlspecialchars($settings->features_title) : 'لماذا تختارنا؟' ?></div>
                <h2 class="section-title">كل ما تحتاجه في مكان واحد</h2>
                <p class="section-sub">أدوات متكاملة لبناء موقعك الإلكتروني بكل سهولة واحترافية</p>
            </div>
            <div class="features-grid">
                <?php if (!empty($features)): ?>
                    <?php
                        $colors = ['i1','i2','i3','i1','i2','i3'];
                        $ci = 0;
                        foreach ($features as $f):
                    ?>
                        <div class="feat-card reveal">
                            <div class="feat-icon <?= $colors[$ci % 3] ?>">
                                <i class="<?= htmlspecialchars($f->display_title ?? ($f->icon ?? 'fas fa-star')) ?>"></i>
                            </div>
                            <h3><?= htmlspecialchars($f->title ?? '') ?></h3>
                            <p><?= htmlspecialchars($f->display_description ?? ($f->description ?? '')) ?></p>
                        </div>
                        <?php $ci++; endforeach; ?>
                <?php else: ?>
                    <div class="feat-card reveal">
                        <div class="feat-icon i1"><i class="fas fa-palette"></i></div>
                        <h3>قوالب احترافية</h3>
                        <p>اختر من بين مجموعة واسعة من القوالب المتنوعة المصممة لكل مجال</p>
                    </div>
                    <div class="feat-card reveal">
                        <div class="feat-icon i2"><i class="fas fa-mobile-alt"></i></div>
                        <h3>تصميم متجاوب</h3>
                        <p>مواقع متوافقة مع جميع الأجهزة والشاشات بشكل تلقائي</p>
                    </div>
                    <div class="feat-card reveal">
                        <div class="feat-icon i3"><i class="fas fa-globe"></i></div>
                        <h3>نطاق مخصص</h3>
                        <p>احصل على نطاق خاص بموقعك يعكس هوية عملك</p>
                    </div>
                    <div class="feat-card reveal">
                        <div class="feat-icon i2"><i class="fas fa-paint-brush"></i></div>
                        <h3>ألوان مخصصة</h3>
                        <p>خصص ألوان موقعك لتناسب هوية علامتك التجارية</p>
                    </div>
                    <div class="feat-card reveal">
                        <div class="feat-icon i1"><i class="fas fa-language"></i></div>
                        <h3>ثنائي اللغة</h3>
                        <p>دعم كامل للعربية والإنجليزية مع تبديل سهل</p>
                    </div>
                    <div class="feat-card reveal">
                        <div class="feat-icon i3"><i class="fas fa-headset"></i></div>
                        <h3>دعم فني متواصل</h3>
                        <p>فريق دعم متخصص جاهز لمساعدتك على مدار الساعة</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- HOW IT WORKS -->
    <section class="section how-section" id="how">
        <div class="container">
            <div class="section-head">
                <div class="section-chip"><i class="fas fa-route"></i> كيف يعمل؟</div>
                <h2 class="section-title">ابدأ في أربع خطوات بسيطة</h2>
            </div>
            <div class="steps-grid">
                <div class="step reveal">
                    <div class="step-num">1</div>
                    <h3>سجّل حسابك</h3>
                    <p>أنشئ حسابك المجاني في أقل من دقيقة</p>
                </div>
                <div class="step reveal">
                    <div class="step-num">2</div>
                    <h3>اختر قالبك</h3>
                    <p>اختر من بين قوالب احترافية متعددة المجالات</p>
                </div>
                <div class="step reveal">
                    <div class="step-num">3</div>
                    <h3>خصّص موقعك</h3>
                    <p>أضف محتواك وخصّص الألوان والنصوص والصور</p>
                </div>
                <div class="step reveal">
                    <div class="step-num">4</div>
                    <h3>انشر موقعك</h3>
                    <p>انشر موقعك وابدأ بجذب العملاء فوراً</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PRICING -->
    <?php if (!empty($settings->show_pricing_section) || !isset($settings->show_pricing_section)): ?>
    <section class="section pricing-section" id="pricing">
        <div class="container">
            <div class="section-head">
                <div class="section-chip"><i class="fas fa-tags"></i> <?= !empty($settings->pricing_title) ? htmlspecialchars($settings->pricing_title) : 'خطط الأسعار' ?></div>
                <h2 class="section-title"><?= !empty($settings->pricing_subtitle) ? htmlspecialchars($settings->pricing_subtitle) : 'اختر الخطة المناسبة لاحتياجاتك' ?></h2>
                <p class="section-sub">خطط مرنة تناسب جميع الاحتياجات مع إمكانية الترقية في أي وقت</p>
            </div>
            <div class="pricing-grid">
                <?php if (!empty($plans)): ?>
                    <?php foreach ($plans as $plan):
                        $isPop = !empty($plan->is_popular);
                        $isFree = !empty($plan->is_free);
                        $feats = !empty($plan->features) ? json_decode($plan->features, true) : [];
                        $cur = defined('CURRENCY') ? CURRENCY : 'SAR';
                    ?>
                        <div class="plan-card <?= $isPop ? 'popular' : '' ?> reveal">
                            <?php if ($isPop): ?><div class="popular-tag">الأكثر شعبية</div><?php endif; ?>

                            <div class="plan-label"><?= $isFree ? 'تجريبي' : ($plan->slug === 'enterprise' ? 'مؤسسات' : 'احترافي') ?></div>
                            <h3 class="plan-name"><?= htmlspecialchars($plan->name) ?></h3>

                            <?php if ($isFree): ?>
                                <div class="plan-price">مجاني</div>
                            <?php else: ?>
                                <div class="plan-price"><?= htmlspecialchars($plan->price_monthly ?? 0) ?> <small><?= $cur ?> / شهرياً</small></div>
                            <?php endif; ?>

                            <p class="plan-desc"><?= htmlspecialchars($plan->description ?? '') ?></p>

                            <ul class="plan-features">
                                <?php if (!empty($feats) && is_array($feats)): ?>
                                    <?php foreach ($feats as $f): ?>
                                        <?php if (!empty(trim($f))): ?>
                                        <li><i class="fas fa-check-circle"></i> <?= htmlspecialchars($f) ?></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li><i class="fas fa-check-circle"></i> <?= (int)($plan->max_services ?? 3) ?> خدمات</li>
                                    <?php if (!empty($plan->custom_domain)): ?><li><i class="fas fa-check-circle"></i> نطاق مخصص</li><?php endif; ?>
                                    <?php if (!empty($plan->priority_support)): ?><li><i class="fas fa-check-circle"></i> دعم مميز</li><?php endif; ?>
                                    <?php if (!empty($plan->analytics_access)): ?><li><i class="fas fa-check-circle"></i> إحصائيات متقدمة</li><?php endif; ?>
                                    <?php if (!empty($plan->remove_branding)): ?><li><i class="fas fa-check-circle"></i> إزالة العلامة التجارية</li><?php endif; ?>
                                <?php endif; ?>
                            </ul>

                            <?php if ($isFree): ?>
                                <a href="<?= url('/register') ?>" class="btn btn-outline">ابدأ التجربة</a>
                            <?php else: ?>
                                <a href="<?= url('/register') ?>" class="btn <?= $isPop ? 'btn-lg' : 'btn-outline' ?>">اشترك الآن</a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="plan-card reveal">
                        <div class="plan-label">تجريبي</div>
                        <h3 class="plan-name">فترة تجريبية</h3>
                        <div class="plan-price">مجاني</div>
                        <p class="plan-desc">جرب المنصة مجاناً لمدة محدودة</p>
                        <ul class="plan-features">
                            <li><i class="fas fa-check-circle"></i> قالب واحد</li>
                            <li><i class="fas fa-check-circle"></i> مساحة تخزين محدودة</li>
                            <li><i class="fas fa-check-circle"></i> دعم بالبريد الإلكتروني</li>
                        </ul>
                        <a href="<?= url('/register') ?>" class="btn btn-outline">ابدأ التجربة</a>
                    </div>
                    <div class="plan-card popular reveal">
                        <div class="popular-tag">الأكثر شعبية</div>
                        <div class="plan-label" style="background:rgba(255,255,255,0.15);color:rgba(255,255,255,0.9)">احترافي</div>
                        <h3 class="plan-name">الخطة الاحترافية</h3>
                        <div class="plan-price">99 <small>ريال / شهرياً</small></div>
                        <p class="plan-desc">كل ما تحتاجه لموقعك الاحترافي</p>
                        <ul class="plan-features">
                            <li><i class="fas fa-check-circle"></i> جميع القوالب</li>
                            <li><i class="fas fa-check-circle"></i> مساحة تخزين غير محدودة</li>
                            <li><i class="fas fa-check-circle"></i> دعم فني على مدار الساعة</li>
                            <li><i class="fas fa-check-circle"></i> نطاق خاص مجاني</li>
                            <li><i class="fas fa-check-circle"></i> تقارير وإحصائيات متقدمة</li>
                        </ul>
                        <a href="<?= url('/register') ?>" class="btn btn-lg">اشترك الآن</a>
                    </div>
                    <div class="plan-card reveal">
                        <div class="plan-label">مؤسسات</div>
                        <h3 class="plan-name">خطة المؤسسات</h3>
                        <div class="plan-price">199 <small>ريال / شهرياً</small></div>
                        <p class="plan-desc">حلول متقدمة للشركات والمؤسسات</p>
                        <ul class="plan-features">
                            <li><i class="fas fa-check-circle"></i> كل مميزات الخطة الاحترافية</li>
                            <li><i class="fas fa-check-circle"></i> قوالب مخصصة حسب الطلب</li>
                            <li><i class="fas fa-check-circle"></i> مدير حساب مخصص</li>
                            <li><i class="fas fa-check-circle"></i> SLA مضمون 99.9%</li>
                            <li><i class="fas fa-check-circle"></i> API متقدم للربط</li>
                        </ul>
                        <a href="<?= url('/register') ?>" class="btn btn-outline">تواصل مع المبيعات</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- TESTIMONIALS -->
    <?php if (!empty($settings->show_testimonials) || !isset($settings->show_testimonials)): ?>
    <section class="section testimonials-section" id="testimonials">
        <div class="container">
            <div class="section-head">
                <div class="section-chip"><i class="fas fa-quote-right"></i> <?= !empty($settings->testimonials_title) ? htmlspecialchars($settings->testimonials_title) : 'آراء العملاء' ?></div>
                <h2 class="section-title">ماذا يقول عملاؤنا عنّا</h2>
            </div>
            <div class="testimonials-grid">
                <?php if (!empty($testimonials)): ?>
                    <?php foreach ($testimonials as $t): ?>
                        <div class="testi-card reveal">
                            <div class="testi-stars">
                                <?php for ($i = 0; $i < ($t->rating ?? 5); $i++): ?><i class="fas fa-star"></i><?php endfor; ?>
                                <?php if (($t->rating ?? 5) < 5): ?><i class="fas fa-star-half-alt"></i><?php endif; ?>
                            </div>
                            <p class="testi-text"><?= htmlspecialchars($t->content ?? '') ?></p>
                            <div class="testi-author">
                                <?php if (!empty($t->client_image)): ?>
                                    <div class="testi-avatar"><img src="<?= htmlspecialchars($t->client_image) ?>" alt=""></div>
                                <?php else: ?>
                                    <div class="testi-avatar"><?= mb_substr($t->client_name ?? '?', 0, 1) ?></div>
                                <?php endif; ?>
                                <div>
                                    <div class="testi-name"><?= htmlspecialchars($t->client_name ?? '') ?></div>
                                    <div class="testi-role"><?= htmlspecialchars($t->client_title ?? ($t->client_company ?? '')) ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="testi-card reveal">
                        <div class="testi-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p class="testi-text">منصة رائعة وسهلة الاستخدام، استطعت إنشاء موقعي خلال ساعات فقط. القوالب احترافية والتخصيص ممتع جداً.</p>
                        <div class="testi-author">
                            <div class="testi-avatar">أ</div>
                            <div><div class="testi-name">أحمد محمد</div><div class="testi-role">صاحب شركة مقاولات</div></div>
                        </div>
                    </div>
                    <div class="testi-card reveal">
                        <div class="testi-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p class="testi-text">الدعم الفني ممتاز والاستجابة سريعة. أنصح بهذه المنصة لكل من يريد موقعاً احترافياً بأسعار معقولة.</p>
                        <div class="testi-author">
                            <div class="testi-avatar">س</div>
                            <div><div class="testi-name">سارة العتيبي</div><div class="testi-role">مصممة ديكور</div></div>
                        </div>
                    </div>
                    <div class="testi-card reveal">
                        <div class="testi-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></div>
                        <p class="testi-text">أفضل منصة عربية لإنشاء المواقع. واجهة سهلة وقوالب متنوعة تناسب جميع المجالات.</p>
                        <div class="testi-author">
                            <div class="testi-avatar">خ</div>
                            <div><div class="testi-name">خالد الشمري</div><div class="testi-role">مقدم خدمات كهربائية</div></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- STATS -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat">
                    <div class="stat-val"><span>500+</span></div>
                    <div class="stat-lbl">موقع تم إنشاؤه</div>
                </div>
                <div class="stat">
                    <div class="stat-val"><span>6</span></div>
                    <div class="stat-lbl">قوالب احترافية</div>
                </div>
                <div class="stat">
                    <div class="stat-val"><span>99.9%</span></div>
                    <div class="stat-lbl">وقت التشغيل</div>
                </div>
                <div class="stat">
                    <div class="stat-val"><span>24/7</span></div>
                    <div class="stat-lbl">دعم فني</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
        <div class="cta-inner">
            <h2>جاهز تبدأ رحلتك الرقمية؟</h2>
            <p>انضم لأكثر من 500 مستخدم استفادوا من منصتنا لإنشاء مواقعهم الاحترافية</p>
            <a href="<?= url('/register') ?>" class="btn btn-white btn-lg"><i class="fas fa-rocket"></i> ابدأ الآن مجاناً</a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <div class="footer-top">
                <div class="footer-brand">
                    <div class="f-logo">
                        <?php if (!empty($settings->logo)): ?>
                            <img src="<?= htmlspecialchars($settings->logo) ?>" alt="Logo">
                        <?php else: ?>
                            <i class="fas fa-cube"></i>
                        <?php endif; ?>
                        <?= defined('SITE_NAME') ? SITE_NAME : 'منصة المواقع' ?>
                    </div>
                    <p><?= !empty($settings->footer_text) ? htmlspecialchars($settings->footer_text) : 'منصة احترافية لإنشاء مواقع إلكترونية متكاملة بسهولة وسرعة.' ?></p>
                </div>
                <div class="footer-col">
                    <h4>روابط سريعة</h4>
                    <ul>
                        <li><a href="<?= url('/') ?>">الرئيسية</a></li>
                        <li><a href="#features">المميزات</a></li>
                        <li><a href="#pricing">الأسعار</a></li>
                        <li><a href="#testimonials">آراء العملاء</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>المساعدة</h4>
                    <ul>
                        <?php if (!empty($settings->contact_email)): ?>
                            <li><a href="mailto:<?= htmlspecialchars($settings->contact_email) ?>">اتصل بنا</a></li>
                        <?php else: ?>
                            <li><a href="#">اتصل بنا</a></li>
                        <?php endif; ?>
                        <li><a href="#">الأسئلة الشائعة</a></li>
                        <li><a href="#">الشروط والأحكام</a></li>
                        <li><a href="#">سياسة الخصوصية</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?= $year ?> <?= defined('SITE_NAME') ? SITE_NAME : 'منصة المواقع' ?> - <?= !empty($settings->copyright_text) ? htmlspecialchars($settings->copyright_text) : 'جميع الحقوق محفوظة' ?></p>
                <div class="footer-socials">
                    <?php if (!empty($settings->twitter)): ?><a href="<?= htmlspecialchars($settings->twitter) ?>" target="_blank"><i class="fab fa-x-twitter"></i></a><?php endif; ?>
                    <?php if (!empty($settings->facebook)): ?><a href="<?= htmlspecialchars($settings->facebook) ?>" target="_blank"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
                    <?php if (!empty($settings->instagram)): ?><a href="<?= htmlspecialchars($settings->instagram) ?>" target="_blank"><i class="fab fa-instagram"></i></a><?php endif; ?>
                    <?php if (!empty($settings->contact_whatsapp)): ?><a href="https://wa.me/<?= preg_replace('/[^0-9+]/', '', $settings->contact_whatsapp) ?>" target="_blank"><i class="fab fa-whatsapp"></i></a><?php endif; ?>
                    <?php if (!empty($settings->linkedin)): ?><a href="<?= htmlspecialchars($settings->linkedin) ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a><?php endif; ?>
                    <?php if (!empty($settings->youtube)): ?><a href="<?= htmlspecialchars($settings->youtube) ?>" target="_blank"><i class="fab fa-youtube"></i></a><?php endif; ?>
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
            toggle.addEventListener('click', function() { menu.classList.toggle('active'); });
            menu.querySelectorAll('a').forEach(function(a) {
                a.addEventListener('click', function() { menu.classList.remove('active'); });
            });
        }

        // Scroll reveal
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

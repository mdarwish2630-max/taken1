<?php
/**
 * CleanPro Theme — Head Partial
 * Professional carpet cleaning design — Blue + Dark Navy
 */
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';
$siteName = htmlspecialchars($tenant->site_name ?? 'كلين برو');
$title    = $title ?? $siteName . ' - خدمات تنظيف السجاد';
$metaDesc = $meta_description ?? ($tenant->meta_description ?? '');
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $isRtl ? 'rtl' : 'ltr' ?>">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($title) ?></title>
    <?php if (!empty($metaDesc)): ?>
        <meta name="description" content="<?= htmlspecialchars($metaDesc) ?>" />
    <?php endif; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        :root {
            --blue: #0b7ff3;
            --dark: #06233d;
            --deep: #031b30;
            --text: #111827;
            --muted: #6b7280;
            --light: #f5f8fc;
            --white: #ffffff;
            --shadow: 0 18px 45px rgba(2,28,55,.12);
            --radius: 14px;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Tajawal', sans-serif;
            color: var(--text);
            background: #fff;
            line-height: 1.7;
            overflow-x: hidden;
        }
        body.ltr {
            direction: ltr;
            font-family: 'Poppins', sans-serif;
        }
        img { max-width: 100%; display: block; }
        a { text-decoration: none; color: inherit; }
        .cpro-container { width: min(1180px, 92%); margin: auto; }

        /* Buttons */
        .cpro-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            background: var(--blue); color: #fff; border: 0; border-radius: 6px;
            padding: 13px 26px; font-weight: 800; cursor: pointer; transition: .3s;
            box-shadow: 0 12px 24px rgba(11,127,243,.25); font-family: inherit; font-size: 14px;
        }
        .cpro-btn:hover { transform: translateY(-3px); background: #066bd0; }
        .cpro-btn-white { background: #fff; color: #111; box-shadow: none; }
        .cpro-btn-white:hover { background: #f0f0f0; }
        .cpro-btn-outline { background: transparent; border: 1px solid rgba(255,255,255,.5); box-shadow: none; }

        /* Section */
        .cpro-section { padding: 82px 0; }
        .cpro-center { text-align: center; }
        .cpro-eyebrow { color: var(--blue); font-weight: 900; font-size: 14px; margin-bottom: 6px; }
        .cpro-title { font-size: 38px; line-height: 1.18; font-weight: 900; margin-bottom: 14px; }
        .cpro-subtitle { color: var(--muted); max-width: 680px; margin: 0 auto; font-size: 16px; }

        /* Top Bar */
        .cpro-topbar { height: 36px; background: var(--blue); color: #fff; font-size: 13px; }
        .cpro-topbar .cpro-container { height: 100%; display: flex; align-items: center; justify-content: space-between; gap: 15px; }
        .cpro-topbar-social { display: flex; gap: 12px; align-items: center; }

        /* Header */
        .cpro-header { background: #fff; box-shadow: 0 8px 28px rgba(0,0,0,.07); position: sticky; top: 0; z-index: 1050; }
        .cpro-nav { height: 76px; display: flex; align-items: center; justify-content: space-between; gap: 25px; }
        .cpro-logo { font-size: 28px; font-weight: 900; color: var(--dark); display: flex; align-items: center; gap: 10px; }
        .cpro-logo span { color: var(--blue); }
        .cpro-logo img { width: 40px; height: 40px; border-radius: 8px; object-fit: cover; }
        .cpro-menu { display: flex; align-items: center; gap: 30px; font-weight: 700; font-size: 14px; color: #334155; }
        .cpro-menu a.active, .cpro-menu a:hover { color: var(--blue); }
        .cpro-nav-cta { padding: 12px 22px; }

        /* Mobile */
        .cpro-mobile-toggle { display: none; width: 42px; height: 42px; background: var(--light); border: 0; border-radius: 8px; font-size: 20px; cursor: pointer; color: var(--dark); }
        .cpro-mobile-menu { display: none; background: #fff; border-top: 1px solid #e5e7eb; padding: 16px; }
        .cpro-mobile-menu a { display: block; padding: 12px 16px; font-weight: 700; color: #334155; border-radius: 8px; }
        .cpro-mobile-menu a:hover, .cpro-mobile-menu a.active { background: var(--light); color: var(--blue); }

        /* Hero */
        .cpro-hero { position: relative; min-height: 520px; display: flex; align-items: center; overflow:hidden; }
        .cpro-hero-bg { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
        .cpro-hero:after { content: ""; position: absolute; inset: 0; background: linear-gradient(90deg, rgba(0,0,0,.15), rgba(0,0,0,.67)); }
        body.ltr .cpro-hero:after { background: linear-gradient(90deg, rgba(0,0,0,.67), rgba(0,0,0,.15)); }
        .cpro-hero-content { position: relative; z-index: 2; color: #fff; max-width: 620px; padding: 80px 0; }
        .cpro-hero h1 { font-size: 52px; font-weight: 900; line-height: 1.1; margin-bottom: 18px; }
        .cpro-hero p { font-size: 18px; color: #eef4ff; margin-bottom: 28px; max-width: 520px; }
        .cpro-slider-dots { display: flex; gap: 7px; margin-top: 28px; }
        .cpro-slider-dots span { width: 9px; height: 9px; background: #fff; border-radius: 50%; opacity: .75; }
        .cpro-slider-dots span.active { background: var(--blue); opacity: 1; }
        .cpro-call-card {
            position: absolute; z-index: 4; bottom: -38px; left: 18%; background: var(--blue); color: #fff;
            padding: 22px 34px; display: flex; align-items: center; gap: 15px; border-radius: 8px 8px 0 0; box-shadow: var(--shadow);
        }
        body.ltr .cpro-call-card { left: auto; right: 18%; }
        .cpro-call-card .icon { width: 54px; height: 54px; background: #fff; color: var(--blue); border-radius: 50%; display: grid; place-items: center; font-size: 24px; }
        .cpro-call-card small { display: block; opacity: .9; font-weight: 700; }
        .cpro-call-card b { font-size: 24px; }

        /* Split / About */
        .cpro-split { display: grid; grid-template-columns: 1fr 1fr; gap: 70px; align-items: center; }
        .cpro-image-stack { position: relative; min-height: 430px; }
        .cpro-image-stack .main-img { width: 78%; height: 390px; object-fit: cover; border-radius: 10px; box-shadow: var(--shadow); }
        .cpro-image-stack .small-img { position: absolute; bottom: 0; left: 5%; width: 48%; height: 235px; object-fit: cover; border-radius: 10px; box-shadow: var(--shadow); border: 8px solid #fff; }
        body.ltr .cpro-image-stack .small-img { left: auto; right: 5%; }
        .cpro-check-list { display: grid; gap: 12px; margin: 24px 0; list-style: none; }
        .cpro-check-list li { color: #374151; font-weight: 700; }
        .cpro-check-list li i { color: var(--blue); margin-inline-end: 10px; }
        .cpro-stats-row { display: flex; gap: 22px; align-items: center; margin-top: 22px; }
        .cpro-circle-stat { width: 70px; height: 70px; background: var(--blue); color: #fff; border-radius: 50%; display: grid; place-items: center; font-weight: 900; font-size: 20px; }

        /* Service Cards */
        .cpro-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 26px; margin-top: 42px; }
        .cpro-service-card { background: #fff; border-radius: 12px; box-shadow: var(--shadow); overflow: hidden; text-align: center; transition: .3s; }
        .cpro-service-card:hover { transform: translateY(-8px); }
        .cpro-service-card img { height: 170px; width: 100%; object-fit: cover; }
        .cpro-service-card .sicon { width: 54px; height: 54px; background: var(--blue); color: #fff; border-radius: 10px; display: grid; place-items: center; margin: -27px auto 14px; position: relative; font-size: 22px; border: 5px solid #fff; }
        .cpro-service-card h3 { font-size: 21px; font-weight: 900; margin-bottom: 6px; }
        .cpro-service-card p { color: var(--muted); font-size: 14px; padding: 0 24px 28px; }
        .cpro-service-card .card-actions { display: flex; gap: 8px; padding: 0 20px 24px; justify-content: center; }

        /* Feature Grid */
        .cpro-feature-grid { display: grid; grid-template-columns: .85fr 1.45fr; gap: 45px; align-items: center; }
        .cpro-feature-photo { position: relative; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow); }
        .cpro-feature-photo img { height: 460px; width: 100%; object-fit: cover; }
        .cpro-float-panel { position: absolute; top: 70px; right: 40px; background: #fff; border-radius: 12px; box-shadow: var(--shadow); padding: 22px; width: 310px; display: grid; gap: 16px; }
        body.ltr .cpro-float-panel { right: auto; left: 40px; }
        .cpro-mini-feature { display: flex; gap: 14px; align-items: flex-start; }
        .cpro-mini-feature span { width: 44px; height: 44px; background: var(--blue); color: #fff; border-radius: 8px; display: grid; place-items: center; flex: 0 0 auto; }
        .cpro-mini-feature h4 { font-weight: 900; font-size: 16px; }
        .cpro-mini-feature p { font-size: 13px; color: var(--muted); }

        /* Why Cards */
        .cpro-why-cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 22px; margin-top: 38px; }
        .cpro-why-card { background: #fff; box-shadow: var(--shadow); border-radius: 12px; padding: 30px 22px; text-align: center; }
        .cpro-why-card span { font-size: 34px; color: var(--blue); display: block; margin-bottom: 4px; }
        .cpro-why-card h3 { font-size: 18px; margin-bottom: 6px; font-weight: 900; }
        .cpro-why-card p { color: var(--muted); font-size: 14px; }

        /* Dark Stats Band */
        .cpro-dark-band {
            background: linear-gradient(90deg, rgba(3,27,48,.96), rgba(3,27,48,.82)), url('https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?q=80&w=1600&auto=format&fit=crop') center/cover;
            padding: 70px 0; color: #fff;
        }
        .cpro-band-grid { display: grid; grid-template-columns: .9fr 1.4fr; gap: 40px; align-items: center; }
        .cpro-stat-cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; }
        .cpro-stat-card { background: #fff; color: var(--dark); border-radius: 12px; padding: 26px; text-align: center; }
        .cpro-stat-card b { font-size: 25px; display: block; margin-bottom: 4px; }
        .cpro-stat-card p { color: var(--muted); font-size: 13px; }
        .cpro-blue-cta { margin-top: 28px; background: var(--blue); padding: 22px; border-radius: 8px; display: flex; align-items: center; justify-content: space-between; gap: 15px; }

        /* Testimonials */
        .cpro-testimonial-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 28px; margin-top: 38px; }
        .cpro-testimonial { background: #fff; border-radius: 12px; box-shadow: var(--shadow); padding: 34px; }
        .cpro-stars { color: #f59e0b; margin-bottom: 12px; font-size: 18px; }
        .cpro-user { display: flex; align-items: center; gap: 12px; margin-top: 20px; }
        .cpro-avatar { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; }

        /* Steps */
        .cpro-step-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; margin-top: 28px; }
        .cpro-step { background: #fff; border-radius: 12px; box-shadow: var(--shadow); padding: 26px; text-align: center; }
        .cpro-step span { color: var(--blue); font-size: 32px; display: block; margin-bottom: 8px; }
        .cpro-step h4 { font-weight: 900; }

        /* Gallery Grid */
        .cpro-gallery-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px; margin-top: 38px; }
        .cpro-gallery-item { border-radius: 12px; overflow: hidden; box-shadow: var(--shadow); }
        .cpro-gallery-item img { height: 240px; width: 100%; object-fit: cover; transition: transform .5s; }
        .cpro-gallery-item:hover img { transform: scale(1.08); }

        /* Contact Form */
        .cpro-contact-card { background: #fff; color: var(--text); box-shadow: var(--shadow); border-radius: 12px; display: grid; grid-template-columns: 1.3fr .7fr; overflow: hidden; max-width: 900px; margin: 0 auto; }
        .cpro-form { padding: 35px; display: grid; gap: 14px; }
        .cpro-form h3 { font-size: 22px; font-weight: 900; }
        .cpro-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .cpro-form input, .cpro-form textarea, .cpro-form select { width: 100%; border: 1px solid #e5e7eb; background: #f9fafb; padding: 13px; border-radius: 6px; font-family: inherit; font-size: 14px; }
        .cpro-form textarea { height: 110px; resize: none; }
        .cpro-contact-side { background: var(--blue); color: #fff; padding: 22px; display: flex; flex-direction: column; justify-content: space-between; }
        .cpro-contact-side img { height: 260px; width: 100%; object-fit: cover; border-radius: 8px; }

        /* FAQ */
        .cpro-faq-list { max-width: 800px; margin: 38px auto 0; display: grid; gap: 12px; }
        .cpro-faq-item { background: #fff; border-radius: 12px; box-shadow: var(--shadow); overflow: hidden; }
        .cpro-faq-q { padding: 20px 24px; font-weight: 800; cursor: pointer; display: flex; justify-content: space-between; align-items: center; }
        .cpro-faq-q i { transition: .3s; color: var(--blue); }
        .cpro-faq-a { max-height: 0; overflow: hidden; transition: max-height .3s ease; padding: 0 24px; color: var(--muted); line-height: 1.8; }
        .cpro-faq-a.open { max-height: 300px; padding-bottom: 20px; }

        /* Partners */
        .cpro-partners-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 30px; margin-top: 38px; }
        .cpro-partner-card { width: 160px; height: 80px; background: #fff; border-radius: 12px; box-shadow: var(--shadow); display: grid; place-items: center; padding: 14px; }
        .cpro-partner-card img { max-height: 50px; object-fit: contain; }

        /* Booking */
        .cpro-booking-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: start; max-width: 960px; margin: 38px auto 0; }
        .cpro-booking-form { background: #fff; border-radius: 12px; box-shadow: var(--shadow); padding: 35px; display: grid; gap: 14px; }
        .cpro-booking-form h3 { font-size: 22px; font-weight: 900; margin-bottom: 8px; }
        .cpro-booking-info { display: grid; gap: 20px; }
        .cpro-booking-info-card { background: #fff; border-radius: 12px; box-shadow: var(--shadow); padding: 24px; }
        .cpro-booking-info-card h4 { font-weight: 900; margin-bottom: 8px; display: flex; align-items: center; gap: 8px; }
        .cpro-booking-info-card h4 i { color: var(--blue); }

        /* Footer */
        .cpro-footer { background: #06233d; color: #fff; padding: 60px 0 20px; }
        .cpro-footer-grid { display: grid; grid-template-columns: 1.2fr .8fr .8fr 1fr; gap: 35px; }
        .cpro-footer h3, .cpro-footer h4 { font-weight: 900; margin-bottom: 18px; }
        .cpro-footer p, .cpro-footer li { color: #cbd5e1; font-size: 14px; list-style: none; margin-bottom: 10px; }
        .cpro-footer a { color: #cbd5e1; transition: .2s; }
        .cpro-footer a:hover { color: var(--blue); }
        .cpro-newsletter { display: flex; gap: 8px; }
        .cpro-newsletter input { flex: 1; padding: 13px; border-radius: 6px; border: 0; }
        .cpro-copyright { text-align: center; border-top: 1px solid rgba(255,255,255,.1); margin-top: 40px; padding-top: 20px; color: #94a3b8; font-size: 13px; }

        /* Breadcrumb */
        .cpro-breadcrumb { padding: 18px 0; background: var(--light); }
        .cpro-breadcrumb a { color: var(--muted); font-size: 14px; font-weight: 600; transition: .2s; }
        .cpro-breadcrumb a:hover { color: var(--blue); }
        .cpro-breadcrumb span.current { color: var(--blue); font-weight: 800; }
        .cpro-breadcrumb i { font-size: 10px; color: var(--muted); margin: 0 8px; }

        /* Responsive */
        @media (max-width: 980px) {
            .cpro-menu { display: none; }
            .cpro-mobile-toggle { display: grid; place-items: center; }
            .cpro-mobile-menu.open { display: block; }
            .cpro-hero h1 { font-size: 40px; }
            .cpro-split, .cpro-feature-grid, .cpro-band-grid, .cpro-contact-card, .cpro-booking-grid { grid-template-columns: 1fr; }
            .cpro-cards, .cpro-why-cards, .cpro-stat-cards { grid-template-columns: repeat(2, 1fr); }
            .cpro-gallery-grid { grid-template-columns: repeat(2, 1fr); }
            .cpro-call-card { left: 50% !important; right: auto !important; transform: translateX(-50%); width: 90%; }
            .cpro-float-panel { position: relative; top: auto; right: auto !important; left: auto !important; margin: -70px auto 0; }
            .cpro-footer-grid { grid-template-columns: 1fr 1fr; }
            .cpro-hero { min-height: 500px; }
        }
        @media (max-width: 620px) {
            .cpro-topbar { height: auto; padding: 8px 0; }
            .cpro-topbar .cpro-container { flex-direction: column; }
            .cpro-cards, .cpro-why-cards, .cpro-stat-cards, .cpro-footer-grid, .cpro-gallery-grid { grid-template-columns: 1fr; }
            .cpro-form-row { grid-template-columns: 1fr; }
            .cpro-hero h1 { font-size: 34px; }
            .cpro-title { font-size: 30px; }
            .cpro-section { padding: 60px 0; }
            .cpro-nav { height: 66px; }
            .cpro-nav-cta { display: none; }
            .cpro-blue-cta { flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body class="<?= $isRtl ? 'rtl' : 'ltr' ?>">

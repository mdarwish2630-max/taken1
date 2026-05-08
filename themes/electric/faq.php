<?php
/**
 * Theme: General - FAQ Page (Professional)
 * القالب: عام - صفحة الأسئلة الشائعة
 */

$lang = Language::current();
$dir = Language::direction();
$isRtl = $dir === 'rtl';

$themePrimary = $tenant->primary_color ?? '#4f46e5';
$themeSecondary = $tenant->secondary_color ?? '#1e40af';
$themeAccent = $tenant->accent_color ?? '#f59e0b';

$faqBanner = !empty($banners) ? ($banners[1] ?? $banners[0] ?? null) : null;

// إذا كانت هناك أسئلة من قاعدة البيانات، نستخدمها
$categoryIcons = [
    'general' => 'fas fa-globe',
    'pricing' => 'fas fa-tags',
    'services' => 'fas fa-concierge-bell',
    'technical' => 'fas fa-cogs',
    'other' => 'fas fa-ellipsis-h'
];

$categoryTitles = [
    'general' => lang('general_questions') ?: 'General',
    'pricing' => lang('pricing_questions') ?: 'Pricing',
    'services' => lang('service_questions') ?: 'Services',
    'technical' => lang('technical_questions') ?: 'Technical',
    'other' => lang('other_questions') ?: 'Other'
];

if (!empty($faqCategories) && is_array($faqCategories) && !isset($faqCategories['general']['icon'])) {
    // البيانات من قاعدة البيانات (مجموعة حسب التصنيف)
    $faqCategoriesFormatted = [];
    foreach ($faqCategories as $catKey => $catFaqs) {
        $faqCategoriesFormatted[$catKey] = [
            'icon' => $categoryIcons[$catKey] ?? 'fas fa-circle',
            'title' => $categoryTitles[$catKey] ?? ucfirst($catKey),
            'items' => []
        ];
        foreach ($catFaqs as $faq) {
            $faqCategoriesFormatted[$catKey]['items'][] = [
                'q' => Language::current() === 'en' && $faq->question_en ? $faq->question_en : $faq->question,
                'a' => Language::current() === 'en' && $faq->answer_en ? $faq->answer_en : $faq->answer
            ];
        }
    }
    $faqCategories = $faqCategoriesFormatted;
} else {
    // البيانات الافتراضية (hardcoded)
    $faqCategories = [
        'general' => [
            'icon' => 'fas fa-globe',
            'title' => lang('general_questions') ?: 'General',
            'items' => [
                ['q' => lang('faq_general_1_q') ?: 'What services do you offer?', 'a' => lang('faq_general_1_a') ?: 'We offer a comprehensive range of professional services tailored to meet your specific needs and requirements.'],
                ['q' => lang('faq_general_2_q') ?: 'How can I contact you?', 'a' => lang('faq_general_2_a') ?: 'You can reach us through our contact form, by phone, or via email. We typically respond within 24 hours.'],
                ['q' => lang('faq_general_3_q') ?: 'What are your working hours?', 'a' => lang('faq_general_3_a') ?: 'We are available during standard business hours, Monday to Saturday. Emergency services are available 24/7.'],
                ['q' => lang('faq_general_4_q') ?: 'Do you provide consultations?', 'a' => lang('faq_general_4_a') ?: 'Yes, we offer free initial consultations to understand your needs and provide tailored recommendations.']
            ]
        ],
        'pricing' => [
            'icon' => 'fas fa-tags',
            'title' => lang('pricing_questions') ?: 'Pricing',
            'items' => [
                ['q' => lang('faq_price_1_q') ?: 'How are your prices determined?', 'a' => lang('faq_price_1_a') ?: 'Our prices are determined based on the scope and complexity of each project. We provide transparent quotes before starting any work.'],
                ['q' => lang('faq_price_2_q') ?: 'Do you offer free estimates?', 'a' => lang('faq_price_2_a') ?: 'Yes, we provide free estimates for all our services. Contact us to schedule an assessment.'],
                ['q' => lang('faq_price_3_q') ?: 'What payment methods do you accept?', 'a' => lang('faq_price_3_a') ?: 'We accept cash, bank transfers, and all major credit cards. Payment plans are available for larger projects.'],
                ['q' => lang('faq_price_4_q') ?: 'Are there any hidden fees?', 'a' => lang('faq_price_4_a') ?: 'No, we believe in complete transparency. The price we quote is the price you pay with no hidden charges.']
            ]
        ],
        'services' => [
            'icon' => 'fas fa-concierge-bell',
            'title' => lang('service_questions') ?: 'Services',
            'items' => [
                ['q' => lang('faq_service_1_q') ?: 'How long does a project take?', 'a' => lang('faq_service_1_a') ?: 'Project timelines vary depending on complexity. We provide estimated completion dates during the initial consultation.'],
                ['q' => lang('faq_service_2_q') ?: 'Can I request a custom service?', 'a' => lang('faq_service_2_a') ?: 'Absolutely! We specialize in customized solutions. Tell us what you need and we will tailor our services accordingly.'],
                ['q' => lang('faq_service_3_q') ?: 'Do you offer after-service support?', 'a' => lang('faq_service_3_a') ?: 'Yes, we provide comprehensive after-service support including warranties, maintenance, and follow-up consultations.'],
                ['q' => lang('faq_service_4_q') ?: 'What makes you different from competitors?', 'a' => lang('faq_service_4_a') ?: 'We combine quality, reliability, and competitive pricing with exceptional customer service. Our experienced team ensures outstanding results every time.']
            ]
        ]
    ];
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? lang('faq') . ' - ' . localized($tenant, 'site_name') ?></title>
    <meta name="description" content="<?= $tenant->meta_description ?>">
    <?php if (!empty($tenant->meta_keywords)): ?>
    <meta name="keywords" content="<?= $tenant->meta_keywords ?>">
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
            --radius-full: 9999px;
            --text: #1a1a2e;
            --text-secondary: #555770;
            --text-light: #8b8ca7;
            --bg: #ffffff;
            --bg-alt: #f7f8fc;
            --bg-warm: #faf8f5;
            --border: #eef0f6;
            --border-light: #f0f1f7;
            --font: 'Readex Pro', system-ui, sans-serif;
            --transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ════════════════════════════════════════════
           BASE RESET & TYPOGRAPHY
           ════════════════════════════════════════════ */
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
        ul, ol { list-style: none; }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }

        /* ════════════════════════════════════════════
           NAVBAR
           ════════════════════════════════════════════ */
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
        .nav-links { display: flex; align-items: center; gap: 0.15rem; }
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

        /* ════════════════════════════════════════════
           PAGE HERO
           ════════════════════════════════════════════ */
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
        <?php if ($faqBanner && $faqBanner->image): ?>
        .page-hero-bg { position: absolute; inset: 0; background: url('<?= upload($faqBanner->image) ?>') center/cover no-repeat; }
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

        /* Floating decorative elements */
        .page-hero-particles {
            position: absolute; inset: 0; pointer-events: none; overflow: hidden;
        }
        .page-hero-particles span {
            position: absolute;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            animation: heroFloat linear infinite;
        }
        .page-hero-particles span:nth-child(1) { width: 6px; height: 6px; left: 10%; top: 30%; animation-duration: 15s; animation-delay: 0s; }
        .page-hero-particles span:nth-child(2) { width: 8px; height: 8px; left: 25%; top: 70%; animation-duration: 18s; animation-delay: 2s; }
        .page-hero-particles span:nth-child(3) { width: 5px; height: 5px; left: 50%; top: 15%; animation-duration: 12s; animation-delay: 4s; }
        .page-hero-particles span:nth-child(4) { width: 7px; height: 7px; left: 75%; top: 60%; animation-duration: 20s; animation-delay: 1s; }
        .page-hero-particles span:nth-child(5) { width: 4px; height: 4px; left: 90%; top: 25%; animation-duration: 16s; animation-delay: 3s; }
        .page-hero-particles span:nth-child(6) { width: 6px; height: 6px; left: 60%; top: 80%; animation-duration: 14s; animation-delay: 5s; }

        @keyframes heroFloat {
            0% { transform: translateY(0) translateX(0) scale(1); opacity: 0; }
            10% { opacity: 0.8; }
            50% { transform: translateY(-40vh) translateX(25px) scale(0.8); }
            90% { opacity: 0.4; }
            100% { transform: translateY(-90vh) translateX(-15px) scale(0.5); opacity: 0; }
        }

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

        /* ════════════════════════════════════════════
           SECTIONS
           ════════════════════════════════════════════ */
        .section { padding: 5rem 1.5rem; }
        .section-alt { background: var(--bg-alt); }
        .section-header { text-align: center; margin-bottom: 3.5rem; max-width: 640px; margin-left: auto; margin-right: auto; }
        .section-header h2 { font-size: clamp(1.6rem, 3vw, 2.2rem); font-weight: 800; color: var(--text); margin-bottom: 0.75rem; letter-spacing: -0.01em; }
        .section-header p { color: var(--text-secondary); font-size: 1.05rem; line-height: 1.7; }
        .section-badge { display: inline-flex; align-items: center; gap: 0.4rem; background: var(--primary-50); color: var(--primary); padding: 0.35rem 1.1rem; border-radius: 50px; font-size: 0.82rem; font-weight: 600; margin-bottom: 0.75rem; }
        .section-badge i { font-size: 0.55rem; }

        /* ════════════════════════════════════════════
           FAQ CATEGORY TABS
           ════════════════════════════════════════════ */
        .faq-category-tabs {
            display: flex;
            justify-content: center;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-bottom: 3rem;
        }
        .faq-cat-tab {
            display: flex; align-items: center; gap: 0.55rem;
            padding: 0.65rem 1.4rem;
            border-radius: var(--radius);
            border: 1.5px solid var(--border);
            background: #fff;
            color: var(--text-secondary);
            font-size: 0.9rem;
            font-weight: 600;
            font-family: var(--font);
            cursor: pointer;
            transition: var(--transition);
        }
        .faq-cat-tab i { font-size: 0.95rem; }
        .faq-cat-tab:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-50);
        }
        .faq-cat-tab.active {
            background: var(--gradient);
            color: #fff;
            border-color: transparent;
            box-shadow: var(--shadow-primary);
        }
        .faq-cat-tab.active i { color: var(--accent-light); }

        @media (max-width: 576px) {
            .faq-category-tabs { gap: 0.5rem; }
            .faq-cat-tab { padding: 0.5rem 1rem; font-size: 0.82rem; }
        }

        /* ════════════════════════════════════════════
           FAQ ACCORDION
           ════════════════════════════════════════════ */
        .faq-group {
            display: none;
            max-width: 820px;
            margin: 0 auto;
            flex-direction: column;
            gap: 0.85rem;
        }
        .faq-group.active-group { display: flex; }

        .faq-item {
            background: #fff;
            border-radius: var(--radius);
            border: 1.5px solid var(--border-light);
            overflow: hidden;
            transition: var(--transition);
            position: relative;
        }
        .faq-item::before {
            content: '';
            position: absolute;
            top: 0; <?= $isRtl ? 'right' : 'left' ?>: 0;
            width: 3px; height: 100%;
            background: var(--gradient);
            transform: scaleY(0);
            transform-origin: center;
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 0 2px 2px 0;
        }
        .faq-item:hover {
            border-color: var(--border);
            box-shadow: var(--shadow-sm);
        }
        .faq-item.active {
            border-color: var(--primary);
            box-shadow: 0 2px 16px color-mix(in srgb, var(--primary) 10%, transparent);
        }
        .faq-item.active::before { transform: scaleY(1); }

        .faq-question {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.2rem 1.5rem;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--text);
            transition: var(--transition);
            user-select: none;
        }
        .faq-question:hover { color: var(--primary); }
        .faq-item.active .faq-question { color: var(--primary); }

        .faq-question .faq-num {
            width: 32px; height: 32px;
            min-width: 32px;
            border-radius: 8px;
            background: var(--primary-50);
            display: flex; align-items: center; justify-content: center;
            color: var(--primary);
            font-size: 0.78rem;
            font-weight: 700;
            transition: var(--transition);
        }
        .faq-item.active .faq-num {
            background: var(--gradient);
            color: #fff;
        }

        .faq-question .faq-toggle {
            width: 34px; height: 34px;
            min-width: 34px;
            border-radius: 50%;
            background: var(--primary-50);
            display: flex; align-items: center; justify-content: center;
            color: var(--primary);
            font-size: 0.82rem;
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
            transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .faq-item.active .faq-answer { max-height: 300px; }

        .faq-answer-inner {
            padding: 0 1.5rem 1.35rem;
            color: var(--text-secondary);
            font-size: 0.9rem;
            line-height: 1.85;
            padding-inline-start: 4.5rem;
        }

        /* ════════════════════════════════════════════
           FAQ SEARCH
           ════════════════════════════════════════════ */
        .faq-search-wrap {
            max-width: 600px;
            margin: 0 auto 3rem;
            position: relative;
        }
        .faq-search-wrap .search-icon {
            position: absolute;
            top: 50%; <?= $isRtl ? 'right' : 'left' ?>: 1.1rem;
            transform: translateY(-50%);
            color: var(--text-light);
            font-size: 1rem;
            pointer-events: none;
            transition: color 0.3s;
        }
        .faq-search-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            font-family: var(--font);
            font-size: 0.95rem;
            background: #fff;
            color: var(--text);
            transition: var(--transition);
        }
        <?php if ($isRtl): ?>
        .faq-search-input { padding: 1rem 3rem 1rem 1rem; }
        <?php endif; ?>
        .faq-search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-50);
        }
        .faq-search-input:focus + .search-icon { color: var(--primary); }
        .faq-search-input::placeholder { color: var(--text-light); }

        /* ════════════════════════════════════════════
           CTA SECTION
           ════════════════════════════════════════════ */
        .cta-section { background: var(--gradient); position: relative; overflow: hidden; }
        .cta-section::before { content: ''; position: absolute; inset: 0; background: radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%); }
        .cta-section::after {
            content: '';
            position: absolute;
            bottom: -40px; <?= $isRtl ? 'left' : 'right' ?>: -40px;
            width: 200px; height: 200px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }
        .cta-inner { position: relative; z-index: 1; text-align: center; padding: 4rem 2rem; }
        .cta-inner h2 { font-size: clamp(1.5rem, 3vw, 2rem); color: #fff; font-weight: 800; margin-bottom: 0.75rem; }
        .cta-inner p { color: rgba(255,255,255,0.85); font-size: 1.05rem; margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto; }
        .btn-cta {
            display: inline-flex; align-items: center; gap: 0.6rem;
            padding: 1rem 2.5rem;
            background: #fff; color: var(--primary);
            border-radius: 14px; font-weight: 700; font-size: 1.05rem;
            font-family: var(--font); border: none; cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        }
        .btn-cta:hover { transform: translateY(-2px); box-shadow: 0 12px 40px rgba(0,0,0,0.2); }

        /* ════════════════════════════════════════════
           FOOTER
           ════════════════════════════════════════════ */
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

        /* ════════════════════════════════════════════
           FLOATING ELEMENTS
           ════════════════════════════════════════════ */
        .whatsapp-float { position: fixed; bottom: 2rem; <?= $isRtl ? 'left' : 'right' ?>: 2rem; width: 56px; height: 56px; background: #25d366; border-radius: 16px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.6rem; z-index: 999; box-shadow: 0 4px 20px rgba(37,211,102,0.35); transition: var(--transition); }
        .whatsapp-float:hover { transform: scale(1.08); box-shadow: 0 6px 28px rgba(37,211,102,0.45); }

        .back-to-top { position: fixed; bottom: 2rem; <?= $isRtl ? 'right' : 'left' ?>: 2rem; width: 44px; height: 44px; background: #fff; border-radius: 12px; display: none; align-items: center; justify-content: center; color: var(--primary); font-size: 1rem; z-index: 998; box-shadow: var(--shadow); border: 1px solid var(--border); transition: var(--transition); }
        .back-to-top.visible { display: flex; }
        .back-to-top:hover { background: var(--primary); color: #fff; transform: translateY(-2px); }

        /* ════════════════════════════════════════════
           ANIMATIONS
           ════════════════════════════════════════════ */
        .fade-up { opacity: 0; transform: translateY(28px); transition: opacity 0.7s cubic-bezier(0.4,0,0.2,1), transform 0.7s cubic-bezier(0.4,0,0.2,1); }
        .fade-up.visible { opacity: 1; transform: translateY(0); }
        .fade-up.delay-1 { transition-delay: 0.1s; }
        .fade-up.delay-2 { transition-delay: 0.2s; }
        .fade-up.delay-3 { transition-delay: 0.3s; }
        .scale-in { opacity: 0; transform: scale(0.92); transition: opacity 0.6s ease, transform 0.6s ease; }
        .scale-in.visible { opacity: 1; transform: scale(1); }

        /* ════════════════════════════════════════════
           NO RESULTS
           ════════════════════════════════════════════ */
        .faq-no-results {
            display: none;
            text-align: center;
            padding: 3rem 1rem;
        }
        .faq-no-results.visible { display: block; }
        .faq-no-results-icon {
            width: 72px; height: 72px;
            background: var(--primary-50);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.25rem;
            font-size: 1.8rem;
            color: var(--primary);
        }
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
                <li><a href="<?= url('/site/' . $tenant->slug . '/' . $item->slug) ?>"><?= localized($item, 'title') ?></a></li>
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
            <?php if ($faqBanner && $faqBanner->image): ?>
            <div class="page-hero-bg"></div>
            <div class="page-hero-overlay"></div>
            <?php else: ?>
            <div class="page-hero-bg"></div>
            <div class="page-hero-pattern"></div>
            <?php endif; ?>
            <div class="page-hero-particles">
                <span></span><span></span><span></span><span></span><span></span><span></span>
            </div>
            <div class="page-hero-content fade-up">
                <div class="hero-badge"><i class="fas fa-question-circle"></i> <?= lang('faq') ?></div>
                <h1><?= lang('frequently_asked_questions') ?></h1>
                <p><?= lang('faq_subtitle') ?></p>
                <div class="breadcrumb-nav">
                    <a href="<?= url('/site/' . $tenant->slug) ?>"><?= lang('home') ?></a>
                    <span class="separator"><i class="fas fa-chevron-<?= $isRtl ? 'left' : 'right' ?>"></i></span>
                    <span class="current"><?= lang('faq') ?></span>
                </div>
            </div>
        </section>

        <!-- ══════ FAQ Section ══════ -->
        <section class="section">
            <div class="container">
                <div class="section-header fade-up">
                    <span class="section-badge"><i class="fas fa-circle"></i> <?= lang('faq') ?></span>
                    <h2><?= lang('find_your_answer') ?></h2>
                    <p><?= lang('faq_section_desc') ?></p>
                </div>

                <!-- Search -->
                <div class="faq-search-wrap fade-up">
                    <input type="text" class="faq-search-input" id="faqSearch" placeholder="<?= lang('search_faq') ?: 'Search questions...' ?>">
                    <i class="fas fa-search search-icon"></i>
                </div>

                <!-- Category Tabs -->
                <div class="faq-category-tabs fade-up">
                    <?php foreach ($faqCategories as $key => $cat): ?>
                    <button class="faq-cat-tab <?= ($key === 'general') ? 'active' : '' ?>" data-category="<?= $key ?>">
                        <i class="<?= $cat['icon'] ?>"></i>
                        <?= $cat['title'] ?>
                    </button>
                    <?php endforeach; ?>
                </div>

                <!-- FAQ Groups -->
                <?php foreach ($faqCategories as $key => $cat): ?>
                <div class="faq-group <?= ($key === 'general') ? 'active-group' : '' ?>" id="faqGroup-<?= $key ?>">
                    <?php foreach ($cat['items'] as $i => $item): ?>
                    <div class="faq-item fade-up" data-question="<?= htmlspecialchars($item['q']) ?>">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <div class="faq-num"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></div>
                            <span><?= $item['q'] ?></span>
                            <div class="faq-toggle"><i class="fas fa-chevron-down"></i></div>
                        </div>
                        <div class="faq-answer">
                            <div class="faq-answer-inner"><?= $item['a'] ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>

                <!-- No Results -->
                <div class="faq-no-results" id="faqNoResults">
                    <div class="faq-no-results-icon"><i class="fas fa-search"></i></div>
                    <h3 style="font-size:1.15rem;font-weight:700;margin-bottom:0.5rem;"><?= lang('no_results') ?></h3>
                    <p style="color:var(--text-secondary);font-size:0.92rem;"><?= lang('no_faq_results') ?></p>
                </div>
            </div>
        </section>

        <!-- ══════ CTA Section ══════ -->
        <section class="cta-section">
            <div class="cta-inner fade-up">
                <h2><?= lang('still_have_questions') ?></h2>
                <p><?= lang('cta_faq_text') ?></p>
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

        // ─── Navbar & Back to Top ───
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

        // ─── Animations ───
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

        // ─── FAQ Category Tabs ───
        $$('.faq-cat-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                $$('.faq-cat-tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                const category = tab.dataset.category;
                $$('.faq-group').forEach(g => g.classList.remove('active-group'));
                const target = $(`#faqGroup-${category}`);
                if (target) target.classList.add('active-group');

                // Reset search
                $('#faqSearch').value = '';
                $$('.faq-item').forEach(item => item.style.display = '');
                $('#faqNoResults').classList.remove('visible');

                // Re-observe newly visible items
                target.querySelectorAll('.fade-up').forEach(el => {
                    if (!el.classList.contains('visible')) observer.observe(el);
                });
            });
        });

        // ─── FAQ Accordion Toggle ───
        window.toggleFaq = function(el) {
            const item = el.closest('.faq-item');
            const wasActive = item.classList.contains('active');

            // Close all items in the same group
            const group = item.closest('.faq-group');
            group.querySelectorAll('.faq-item').forEach(i => i.classList.remove('active'));

            // Toggle clicked item
            if (!wasActive) {
                item.classList.add('active');
            }
        };

        // ─── FAQ Search ───
        const searchInput = $('#faqSearch');
        if (searchInput) {
            searchInput.addEventListener('input', () => {
                const query = searchInput.value.trim().toLowerCase();
                let totalVisible = 0;

                $$('.faq-group').forEach(g => {
                    let groupVisible = 0;
                    g.querySelectorAll('.faq-item').forEach(item => {
                        const question = (item.dataset.question || '').toLowerCase();
                        const answer = item.querySelector('.faq-answer-inner').textContent.toLowerCase();
                        const matches = !query || question.includes(query) || answer.includes(query);
                        item.style.display = matches ? '' : 'none';
                        if (matches) { groupVisible++; totalVisible++; }
                    });

                    // Show group if it has matching items
                    if (query) {
                        g.classList.toggle('active-group', groupVisible > 0);
                    }
                });

                // Show/hide category tabs based on matches
                if (query) {
                    $$('.faq-cat-tab').forEach(tab => {
                        const catGroup = $(`#faqGroup-${tab.dataset.category}`);
                        const hasItems = catGroup && catGroup.querySelectorAll('.faq-item[style=""], .faq-item:not([style])').length > 0;
                        tab.style.display = hasItems ? '' : 'none';
                    });
                } else {
                    $$('.faq-cat-tab').forEach(tab => tab.style.display = '');
                    // Restore active group based on active tab
                    const activeTab = $('.faq-cat-tab.active');
                    if (activeTab) {
                        $$('.faq-group').forEach(g => g.classList.remove('active-group'));
                        const target = $(`#faqGroup-${activeTab.dataset.category}`);
                        if (target) target.classList.add('active-group');
                    }
                }

                $('#faqNoResults').classList.toggle('visible', totalVisible === 0);
            });
        }
    })();
    </script>
</body>
</html>

<?php
/**
 * Theme: General - Booking Page (Professional)
 * القالب: عام - صفحة الحجز
 */

$lang = Language::current();
$dir = Language::direction();
$isRtl = $dir === 'rtl';

$themePrimary = $tenant->primary_color ?? '#4f46e5';
$themeSecondary = $tenant->secondary_color ?? '#1e40af';
$themeAccent = $tenant->accent_color ?? '#f59e0b';

$bookingBanner = !empty($banners) ? ($banners[1] ?? $banners[0] ?? null) : null;

// Generate time slots
$timeSlots = [];
for ($h = 8; $h <= 20; $h++) {
    $timeSlots[] = sprintf('%02d:00', $h);
    $timeSlots[] = sprintf('%02d:30', $h);
}

// Generate next 14 days for date picker
$availableDates = [];
for ($d = 0; $d < 14; $d++) {
    $date = new DateTime("+{$d} days");
    $availableDates[] = [
        'value' => $date->format('Y-m-d'),
        'day' => $date->format('d'),
        'month' => $date->format('M'),
        'weekday' => $date->format('D'),
        'isToday' => $d === 0,
    ];
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? lang('book_appointment') . ' - ' . localized($tenant, 'site_name') ?></title>
    <meta name="description" content="<?= $tenant->meta_description ?>">
    <?php if (!empty($tenant->meta_keywords)): ?>
    <meta name="keywords" content="<?= $tenant->meta_keywords ?>">
    <?php endif; ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap<?= $isRtl ? '.rtl' : '' ?>.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=<?= $isRtl ? 'Cairo:wght@300;400;500;600;700;800;900' : 'Inter:wght@300;400;500;600;700;800;900' ?>&display=swap" rel="stylesheet">
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
            --success: #10b981;
            --success-bg: #ecfdf5;
            --font: '<?= $isRtl ? 'Cairo' : 'Inter' ?>', system-ui, sans-serif;
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
        <?php if ($bookingBanner && $bookingBanner->image): ?>
        .page-hero-bg { position: absolute; inset: 0; background: url('<?= upload($bookingBanner->image) ?>') center/cover no-repeat; }
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

        .page-hero-particles {
            position: absolute; inset: 0; pointer-events: none; overflow: hidden;
        }
        .page-hero-particles span {
            position: absolute;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            animation: heroFloat linear infinite;
        }
        .page-hero-particles span:nth-child(1) { width: 5px; height: 5px; left: 15%; top: 25%; animation-duration: 14s; }
        .page-hero-particles span:nth-child(2) { width: 8px; height: 8px; left: 30%; top: 60%; animation-duration: 18s; animation-delay: 2s; }
        .page-hero-particles span:nth-child(3) { width: 4px; height: 4px; left: 50%; top: 20%; animation-duration: 12s; animation-delay: 4s; }
        .page-hero-particles span:nth-child(4) { width: 7px; height: 7px; left: 70%; top: 75%; animation-duration: 20s; animation-delay: 1s; }
        .page-hero-particles span:nth-child(5) { width: 6px; height: 6px; left: 85%; top: 35%; animation-duration: 16s; animation-delay: 3s; }

        @keyframes heroFloat {
            0% { transform: translateY(0) translateX(0); opacity: 0; }
            10% { opacity: 0.7; }
            50% { transform: translateY(-40vh) translateX(20px); }
            90% { opacity: 0.3; }
            100% { transform: translateY(-85vh) translateX(-10px); opacity: 0; }
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
        .page-hero h1 { font-size: clamp(2rem, 4vw, 2.8rem); font-weight: 800; color: #fff; line-height: 1.3; margin-bottom: 1rem; }
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

        /* ════════════════════════════════════════════
           BOOKING LAYOUT
           ════════════════════════════════════════════ */
        .booking-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 2.5rem;
            align-items: start;
        }
        @media (max-width: 992px) { .booking-grid { grid-template-columns: 1fr; } }

        /* ─── Booking Form Card ─── */
        .booking-form-card {
            background: #fff;
            border-radius: var(--radius-lg);
            padding: 2.5rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
        }
        @media (max-width: 576px) { .booking-form-card { padding: 1.75rem; } }

        .booking-form-card h2 {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0.35rem;
        }
        .booking-form-card .form-subtitle {
            color: var(--text-secondary);
            font-size: 0.92rem;
            margin-bottom: 2rem;
        }

        /* Step indicators */
        .step-indicators {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            margin-bottom: 2.5rem;
            padding: 0 1rem;
        }
        .step-item {
            display: flex; align-items: center; gap: 0.5rem;
            font-size: 0.82rem; font-weight: 600;
            color: var(--text-light);
            transition: var(--transition);
            white-space: nowrap;
        }
        .step-item.active { color: var(--primary); }
        .step-item.completed { color: var(--success); }
        .step-num {
            width: 30px; height: 30px;
            border-radius: 50%;
            border: 2px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem; font-weight: 700;
            transition: var(--transition);
            flex-shrink: 0;
        }
        .step-item.active .step-num {
            background: var(--gradient);
            color: #fff;
            border-color: transparent;
            box-shadow: var(--shadow-primary);
        }
        .step-item.completed .step-num {
            background: var(--success);
            color: #fff;
            border-color: transparent;
        }
        .step-line {
            flex: 1; height: 2px;
            background: var(--border);
            margin: 0 0.5rem;
            min-width: 20px;
            transition: var(--transition);
        }
        .step-line.active { background: var(--gradient); }

        /* Form elements */
        .form-group { margin-bottom: 1.25rem; }
        .form-group label {
            display: flex; align-items: center; gap: 0.4rem;
            font-size: 0.85rem; font-weight: 600;
            color: var(--text); margin-bottom: 0.45rem;
        }
        .form-group label i { font-size: 0.8rem; color: var(--primary); }
        .form-group label .required {
            color: #ef4444; font-size: 0.7rem; margin-inline-start: 0.15rem;
        }

        .form-control {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: var(--font);
            font-size: 0.92rem;
            transition: var(--transition);
            background: var(--bg-alt);
            color: var(--text);
            appearance: none;
            -webkit-appearance: none;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-50);
            background: #fff;
        }
        .form-control::placeholder { color: var(--text-light); }
        textarea.form-control { resize: vertical; min-height: 100px; }

        .form-select-wrap {
            position: relative;
        }
        .form-select-wrap::after {
            content: '\f107';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 50%; <?= $isRtl ? 'left' : 'right' ?>: 1rem;
            transform: translateY(-50%);
            color: var(--text-light);
            pointer-events: none;
            font-size: 0.85rem;
        }
        .form-select-wrap select {
            padding-<?= $isRtl ? 'left' : 'right' ?>: 2.5rem;
        }

        /* Date picker grid */
        .date-picker-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.5rem;
        }
        @media (max-width: 400px) { .date-picker-grid { gap: 0.25rem; } }

        .date-cell {
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 0.6rem 0.25rem;
            border-radius: 10px;
            border: 1.5px solid var(--border);
            background: #fff;
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
        }
        .date-cell:hover {
            border-color: var(--primary);
            background: var(--primary-50);
        }
        .date-cell.selected {
            background: var(--gradient);
            border-color: transparent;
            color: #fff;
            box-shadow: var(--shadow-primary);
        }
        .date-cell.selected .date-weekday,
        .date-cell.selected .date-month { color: rgba(255,255,255,0.8); }
        .date-cell.today { border-color: var(--accent); }
        .date-weekday {
            font-size: 0.65rem; font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        .date-cell.selected .date-weekday { color: rgba(255,255,255,0.75); }
        .date-day {
            font-size: 1.1rem; font-weight: 700;
            color: var(--text);
            line-height: 1.3;
        }
        .date-cell.selected .date-day { color: #fff; }
        .date-month {
            font-size: 0.6rem;
            color: var(--text-light);
            font-weight: 500;
        }

        /* Time slot grid */
        .time-slots-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 0.5rem;
        }
        .time-slot {
            padding: 0.65rem 0.5rem;
            border-radius: 8px;
            border: 1.5px solid var(--border);
            background: #fff;
            font-size: 0.88rem;
            font-weight: 600;
            font-family: var(--font);
            color: var(--text-secondary);
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }
        .time-slot:hover {
            border-color: var(--primary);
            background: var(--primary-50);
            color: var(--primary);
        }
        .time-slot.selected {
            background: var(--gradient);
            border-color: transparent;
            color: #fff;
            box-shadow: var(--shadow-sm);
        }
        .time-slot.disabled {
            opacity: 0.4;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Form row */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.85rem;
        }
        @media (max-width: 576px) { .form-row { grid-template-columns: 1fr; } }

        /* Submit button */
        .btn-book {
            width: 100%;
            padding: 1rem;
            background: var(--gradient);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            font-family: var(--font);
            cursor: pointer;
            transition: var(--transition);
            display: flex; align-items: center; justify-content: center; gap: 0.6rem;
            box-shadow: var(--shadow-primary);
            margin-top: 0.5rem;
        }
        .btn-book:hover { transform: translateY(-2px); box-shadow: 0 12px 40px color-mix(in srgb, var(--primary) 35%, transparent); }
        .btn-book:disabled { opacity: 0.6; cursor: not-allowed; transform: none; box-shadow: none; }

        /* ─── Info Sidebar ─── */
        .booking-sidebar {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            position: sticky;
            top: 88px;
        }

        .sidebar-card {
            background: #fff;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }
        .sidebar-card:hover { box-shadow: var(--shadow); }

        .sidebar-card-header {
            background: var(--gradient);
            padding: 1.5rem 1.5rem;
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        .sidebar-card-header::before {
            content: '';
            position: absolute;
            top: -30px; <?= $isRtl ? 'right' : 'left' ?>: -30px;
            width: 100px; height: 100px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
        }
        .sidebar-card-header h3 {
            font-size: 1.1rem;
            font-weight: 700;
            position: relative;
            display: flex; align-items: center; gap: 0.5rem;
        }
        .sidebar-card-header h3 i { font-size: 0.95rem; }

        .sidebar-card-body { padding: 1.5rem; }

        .info-item {
            display: flex; align-items: center; gap: 0.85rem;
            padding: 0.85rem 0;
            border-bottom: 1px solid var(--border-light);
        }
        .info-item:last-child { border-bottom: none; }
        .info-item-icon {
            width: 42px; height: 42px;
            min-width: 42px;
            border-radius: 12px;
            background: var(--primary-50);
            display: flex; align-items: center; justify-content: center;
            color: var(--primary);
            font-size: 1rem;
            transition: var(--transition);
        }
        .info-item:hover .info-item-icon {
            background: var(--gradient);
            color: #fff;
            transform: scale(1.05);
        }
        .info-item-label {
            font-size: 0.75rem;
            color: var(--text-light);
            font-weight: 500;
        }
        .info-item-value {
            font-size: 0.92rem;
            font-weight: 600;
            color: var(--text);
        }
        .info-item a {
            color: var(--text);
            transition: color 0.3s;
        }
        .info-item a:hover { color: var(--primary); }

        .sidebar-cta {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        .btn-sidebar-whatsapp {
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            padding: 0.85rem 1.25rem;
            border-radius: 12px;
            background: #25d366;
            color: #fff;
            font-weight: 700;
            font-size: 0.92rem;
            font-family: var(--font);
            cursor: pointer;
            transition: var(--transition);
            border: none;
            width: 100%;
            text-align: center;
        }
        .btn-sidebar-whatsapp:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(37,211,102,0.3); }
        .btn-sidebar-call {
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            padding: 0.85rem 1.25rem;
            border-radius: 12px;
            background: var(--bg-alt);
            color: var(--text);
            border: 1.5px solid var(--border);
            font-weight: 600;
            font-size: 0.92rem;
            font-family: var(--font);
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
            text-align: center;
        }
        .btn-sidebar-call:hover { border-color: var(--primary); color: var(--primary); background: var(--primary-50); }

        /* ─── Success State ─── */
        .booking-success {
            display: none;
            text-align: center;
            padding: 3rem 1.5rem;
        }
        .booking-success.visible { display: block; }

        .success-animation {
            width: 100px; height: 100px;
            background: var(--success-bg);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.5rem;
            color: var(--success);
            animation: successPop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
            position: relative;
        }
        .success-animation::after {
            content: '';
            position: absolute; inset: -8px;
            border: 2px solid var(--success);
            border-radius: 50%;
            opacity: 0;
            animation: successRing 0.6s ease-out 0.3s forwards;
        }
        @keyframes successPop {
            0% { transform: scale(0); opacity: 0; }
            50% { transform: scale(1.15); }
            100% { transform: scale(1); opacity: 1; }
        }
        @keyframes successRing {
            0% { transform: scale(0.8); opacity: 0.6; }
            100% { transform: scale(1.3); opacity: 0; }
        }

        .booking-success h3 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 0.5rem;
        }
        .booking-success p {
            color: var(--text-secondary);
            font-size: 0.95rem;
            max-width: 400px;
            margin: 0 auto 2rem;
            line-height: 1.7;
        }
        .success-details {
            background: var(--bg-alt);
            border-radius: var(--radius);
            padding: 1.25rem;
            margin-bottom: 2rem;
            display: flex;
            flex-direction: column;
            gap: 0.65rem;
            text-align: <?= $isRtl ? 'right' : 'left' ?>;
        }
        .success-detail-row {
            display: flex; justify-content: space-between;
            font-size: 0.88rem;
        }
        .success-detail-row .label { color: var(--text-light); }
        .success-detail-row .value { font-weight: 600; color: var(--text); }

        .btn-new-booking {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.85rem 2rem;
            background: var(--gradient);
            color: #fff;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.95rem;
            font-family: var(--font);
            border: none; cursor: pointer;
            transition: var(--transition);
        }
        .btn-new-booking:hover { transform: translateY(-2px); box-shadow: var(--shadow-primary); }

        /* ─── Confetti particles ─── */
        .confetti-container {
            position: fixed; inset: 0;
            pointer-events: none;
            z-index: 9999;
            overflow: hidden;
        }
        .confetti-piece {
            position: absolute;
            width: 10px; height: 10px;
            top: -10px;
            animation: confettiFall linear forwards;
        }
        @keyframes confettiFall {
            0% { transform: translateY(0) rotate(0deg); opacity: 1; }
            100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
        }

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
            <?php if ($bookingBanner && $bookingBanner->image): ?>
            <div class="page-hero-bg"></div>
            <div class="page-hero-overlay"></div>
            <?php else: ?>
            <div class="page-hero-bg"></div>
            <div class="page-hero-pattern"></div>
            <?php endif; ?>
            <div class="page-hero-particles">
                <span></span><span></span><span></span><span></span><span></span>
            </div>
            <div class="page-hero-content fade-up">
                <div class="hero-badge"><i class="fas fa-calendar-check"></i> <?= lang('booking') ?></div>
                <h1><?= lang('book_appointment') ?></h1>
                <p><?= lang('booking_subtitle') ?></p>
                <div class="breadcrumb-nav">
                    <a href="<?= url('/site/' . $tenant->slug) ?>"><?= lang('home') ?></a>
                    <span class="separator"><i class="fas fa-chevron-<?= $isRtl ? 'left' : 'right' ?>"></i></span>
                    <span class="current"><?= lang('booking') ?></span>
                </div>
            </div>
        </section>

        <!-- ══════ Booking Section ══════ -->
        <section class="section" style="padding-top: 3.5rem;">
            <div class="container">
                <div class="booking-grid">
                    <!-- Booking Form -->
                    <div class="booking-form-card fade-up" id="bookingFormWrap">
                        <h2><i class="fas fa-calendar-plus" style="color:var(--primary);margin-inline-end:0.5rem;font-size:1.1rem;"></i> <?= lang('schedule_appointment') ?></h2>
                        <p class="form-subtitle"><?= lang('booking_form_desc') ?></p>

                        <!-- Step Indicators -->
                        <div class="step-indicators">
                            <div class="step-item active" id="step1Indicator">
                                <div class="step-num">1</div>
                                <span><?= lang('select_service') ?></span>
                            </div>
                            <div class="step-line" id="stepLine1"></div>
                            <div class="step-item" id="step2Indicator">
                                <div class="step-num">2</div>
                                <span><?= lang('select_datetime') ?></span>
                            </div>
                            <div class="step-line" id="stepLine2"></div>
                            <div class="step-item" id="step3Indicator">
                                <div class="step-num">3</div>
                                <span><?= lang('your_info') ?></span>
                            </div>
                        </div>

                        <form id="bookingForm" action="<?= url('/site/' . $tenant->slug . '/booking') ?>" method="POST">
                            <?= csrf_field() ?? '' ?>
                            <input type="hidden" name="tenant_id" value="<?= $tenant->id ?? '' ?>">

                            <!-- Step 1: Select Service -->
                            <div id="step1">
                                <div class="form-group">
                                    <label for="service">
                                        <i class="fas fa-concierge-bell"></i>
                                        <?= lang('select_service') ?>
                                        <span class="required">*</span>
                                    </label>
                                    <div class="form-select-wrap">
                                        <select class="form-control" id="service" name="service_id" required>
                                            <option value=""><?= lang('choose_service') ?></option>
                                            <?php foreach ($services ?? [] as $service): ?>
                                            <option value="<?= $service->id ?>"><?= localized($service, 'title') ?><?php if ($service->price): ?> - <?= $service->price_text ?: $service->price . ' ' . lang('currency') ?><?php endif; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <button type="button" class="btn-book" onclick="goToStep(2)">
                                    <?= lang('next') ?> <i class="fas fa-arrow-<?= $isRtl ? 'left' : 'right' ?>"></i>
                                </button>
                            </div>

                            <!-- Step 2: Date & Time -->
                            <div id="step2" style="display:none;">
                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-calendar-alt"></i>
                                        <?= lang('select_date') ?>
                                        <span class="required">*</span>
                                    </label>
                                    <div class="date-picker-grid">
                                        <?php foreach ($availableDates as $date): ?>
                                        <div class="date-cell <?= $date['isToday'] ? 'today' : '' ?>" data-value="<?= $date['value'] ?>" onclick="selectDate(this)">
                                            <span class="date-weekday"><?= $date['weekday'] ?></span>
                                            <span class="date-day"><?= $date['day'] ?></span>
                                            <span class="date-month"><?= $date['month'] ?></span>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <input type="hidden" id="selectedDate" name="date" required>
                                </div>

                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-clock"></i>
                                        <?= lang('select_time') ?>
                                        <span class="required">*</span>
                                    </label>
                                    <div class="time-slots-grid">
                                        <?php foreach ($timeSlots as $slot): ?>
                                        <div class="time-slot" data-value="<?= $slot ?>" onclick="selectTime(this)"><?= $slot ?></div>
                                        <?php endforeach; ?>
                                    </div>
                                    <input type="hidden" id="selectedTime" name="time" required>
                                </div>

                                <div style="display:flex;gap:0.75rem;">
                                    <button type="button" class="btn-book" style="background:var(--bg-alt);color:var(--text);box-shadow:none;flex:0 0 auto;padding:1rem 1.5rem;" onclick="goToStep(1)">
                                        <i class="fas fa-arrow-<?= $isRtl ? 'right' : 'left' ?>"></i> <?= lang('back') ?>
                                    </button>
                                    <button type="button" class="btn-book" style="flex:1;" onclick="goToStep(3)">
                                        <?= lang('next') ?> <i class="fas fa-arrow-<?= $isRtl ? 'left' : 'right' ?>"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Step 3: Personal Info -->
                            <div id="step3" style="display:none;">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="name">
                                            <i class="fas fa-user"></i>
                                            <?= lang('full_name') ?>
                                            <span class="required">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="<?= lang('name_placeholder') ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">
                                            <i class="fas fa-phone"></i>
                                            <?= lang('phone') ?>
                                            <span class="required">*</span>
                                        </label>
                                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="<?= lang('phone_placeholder') ?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email">
                                        <i class="fas fa-envelope"></i>
                                        <?= lang('email') ?>
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="<?= lang('email_placeholder') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="notes">
                                        <i class="fas fa-sticky-note"></i>
                                        <?= lang('notes') ?>
                                    </label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="<?= lang('notes_placeholder') ?>"></textarea>
                                </div>

                                <div style="display:flex;gap:0.75rem;">
                                    <button type="button" class="btn-book" style="background:var(--bg-alt);color:var(--text);box-shadow:none;flex:0 0 auto;padding:1rem 1.5rem;" onclick="goToStep(2)">
                                        <i class="fas fa-arrow-<?= $isRtl ? 'right' : 'left' ?>"></i> <?= lang('back') ?>
                                    </button>
                                    <button type="submit" class="btn-book" style="flex:1;" id="submitBtn">
                                        <i class="fas fa-check-circle"></i> <?= lang('confirm_booking') ?>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Success State -->
                    <div class="booking-success" id="bookingSuccess">
                        <div class="success-animation">
                            <i class="fas fa-check"></i>
                        </div>
                        <h3><?= lang('booking_confirmed') ?></h3>
                        <p><?= lang('booking_success_text') ?></p>
                        <div class="success-details">
                            <div class="success-detail-row">
                                <span class="label"><?= lang('service') ?></span>
                                <span class="value" id="successService">-</span>
                            </div>
                            <div class="success-detail-row">
                                <span class="label"><?= lang('date') ?></span>
                                <span class="value" id="successDate">-</span>
                            </div>
                            <div class="success-detail-row">
                                <span class="label"><?= lang('time') ?></span>
                                <span class="value" id="successTime">-</span>
                            </div>
                            <div class="success-detail-row">
                                <span class="label"><?= lang('name') ?></span>
                                <span class="value" id="successName">-</span>
                            </div>
                        </div>
                        <button class="btn-new-booking" onclick="resetBooking()">
                            <i class="fas fa-plus"></i> <?= lang('new_booking') ?>
                        </button>
                    </div>

                    <!-- Sidebar -->
                    <aside class="booking-sidebar fade-up delay-1">
                        <!-- Quick Contact Card -->
                        <div class="sidebar-card">
                            <div class="sidebar-card-header">
                                <h3><i class="fas fa-headset"></i> <?= lang('need_help') ?></h3>
                            </div>
                            <div class="sidebar-card-body">
                                <?php if ($tenant->contact_phone): ?>
                                <div class="info-item">
                                    <div class="info-item-icon"><i class="fas fa-phone"></i></div>
                                    <div>
                                        <div class="info-item-label"><?= lang('phone') ?></div>
                                        <div class="info-item-value"><a href="tel:<?= $tenant->contact_phone ?>"><?= $tenant->contact_phone ?></a></div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php if ($tenant->contact_whatsapp): ?>
                                <div class="info-item">
                                    <div class="info-item-icon" style="background:#ecfdf5;color:#25d366;"><i class="fab fa-whatsapp"></i></div>
                                    <div>
                                        <div class="info-item-label">WhatsApp</div>
                                        <div class="info-item-value"><a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp) ?>" target="_blank"><?= $tenant->contact_whatsapp ?></a></div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php if ($tenant->working_hours): ?>
                                <div class="info-item">
                                    <div class="info-item-icon"><i class="fas fa-clock"></i></div>
                                    <div>
                                        <div class="info-item-label"><?= lang('working_hours') ?></div>
                                        <div class="info-item-value"><?= $tenant->working_hours ?></div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="sidebar-cta">
                                <?php if ($tenant->contact_whatsapp): ?>
                                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp) ?>" target="_blank" class="btn-sidebar-whatsapp">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </a>
                                <?php endif; ?>
                                <?php if ($tenant->contact_phone): ?>
                                <a href="tel:<?= $tenant->contact_phone ?>" class="btn-sidebar-call">
                                    <i class="fas fa-phone"></i> <?= lang('call_now') ?>
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Quick Info Card -->
                        <div class="sidebar-card">
                            <div class="sidebar-card-header" style="background: var(--gradient-accent);">
                                <h3><i class="fas fa-info-circle"></i> <?= lang('booking_info') ?></h3>
                            </div>
                            <div class="sidebar-card-body">
                                <ul style="font-size:0.85rem;color:var(--text-secondary);line-height:1.85;">
                                    <li style="display:flex;align-items:flex-start;gap:0.5rem;margin-bottom:0.5rem;">
                                        <i class="fas fa-check-circle" style="color:var(--success);margin-top:3px;flex-shrink:0;font-size:0.75rem;"></i>
                                        <span><?= lang('booking_tip_1') ?></span>
                                    </li>
                                    <li style="display:flex;align-items:flex-start;gap:0.5rem;margin-bottom:0.5rem;">
                                        <i class="fas fa-check-circle" style="color:var(--success);margin-top:3px;flex-shrink:0;font-size:0.75rem;"></i>
                                        <span><?= lang('booking_tip_2') ?></span>
                                    </li>
                                    <li style="display:flex;align-items:flex-start;gap:0.5rem;margin-bottom:0.5rem;">
                                        <i class="fas fa-check-circle" style="color:var(--success);margin-top:3px;flex-shrink:0;font-size:0.75rem;"></i>
                                        <span><?= lang('booking_tip_3') ?></span>
                                    </li>
                                    <li style="display:flex;align-items:flex-start;gap:0.5rem;">
                                        <i class="fas fa-check-circle" style="color:var(--success);margin-top:3px;flex-shrink:0;font-size:0.75rem;"></i>
                                        <span><?= lang('booking_tip_4') ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </aside>
                </div>
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

        // ─── Step Navigation ───
        let currentStep = 1;

        window.goToStep = function(step) {
            // Validation
            if (step === 2 && !$('#service').value) {
                $('#service').focus();
                $('#service').style.borderColor = '#ef4444';
                setTimeout(() => { $('#service').style.borderColor = ''; }, 2000);
                return;
            }
            if (step === 3) {
                if (!$('#selectedDate').value) {
                    alert('<?= lang('select_date_required') ?: "Please select a date" ?>');
                    return;
                }
                if (!$('#selectedTime').value) {
                    alert('<?= lang('select_time_required') ?: "Please select a time" ?>');
                    return;
                }
            }

            // Hide current, show target
            $(`#step${currentStep}`).style.display = 'none';
            $(`#step${step}`).style.display = 'block';

            // Update indicators
            for (let i = 1; i <= 3; i++) {
                const indicator = $(`#step${i}Indicator`);
                indicator.classList.remove('active', 'completed');
                if (i < step) indicator.classList.add('completed');
                if (i === step) indicator.classList.add('active');
            }
            for (let i = 1; i <= 2; i++) {
                const line = $(`#stepLine${i}`);
                line.classList.toggle('active', i < step);
            }

            currentStep = step;

            // Scroll to form top
            $('#bookingFormWrap').scrollIntoView({ behavior: 'smooth', block: 'start' });
        };

        // ─── Date Selection ───
        window.selectDate = function(el) {
            $$('.date-cell').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            $('#selectedDate').value = el.dataset.value;
        };

        // ─── Time Selection ───
        window.selectTime = function(el) {
            $$('.time-slot').forEach(s => s.classList.remove('selected'));
            el.classList.add('selected');
            $('#selectedTime').value = el.dataset.value;
        };

        // ─── Form Submit ───
        const form = $('#bookingForm');
        if (form) {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                const btn = $('#submitBtn');
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <?= lang('submitting') ?>';

                // Simulate submission delay
                setTimeout(() => {
                    showSuccess();
                }, 1500);
            });
        }

        // ─── Success State ───
        function showSuccess() {
            // Populate success details
            const serviceSelect = $('#service');
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
            $('#successService').textContent = selectedOption ? selectedOption.text : '-';
            $('#successDate').textContent = $('#selectedDate').value || '-';
            $('#successTime').textContent = $('#selectedTime').value || '-';
            $('#successName').textContent = $('#name').value || '-';

            // Show success, hide form
            $('#bookingFormWrap').style.display = 'none';
            const sidebar = $('.booking-sidebar');
            if (sidebar) sidebar.style.display = 'none';
            const successEl = $('#bookingSuccess');
            successEl.classList.add('visible');

            // Launch confetti
            launchConfetti();
        }

        window.resetBooking = function() {
            // Reset form
            form.reset();
            $$('.date-cell').forEach(c => c.classList.remove('selected'));
            $$('.time-slot').forEach(s => s.classList.remove('selected'));
            $('#selectedDate').value = '';
            $('#selectedTime').value = '';

            // Reset steps
            currentStep = 1;
            $('#step1').style.display = 'block';
            $('#step2').style.display = 'none';
            $('#step3').style.display = 'none';

            // Reset indicators
            for (let i = 1; i <= 3; i++) {
                const indicator = $(`#step${i}Indicator`);
                indicator.classList.remove('active', 'completed');
                if (i === 1) indicator.classList.add('active');
            }
            $('#stepLine1').classList.remove('active');
            $('#stepLine2').classList.remove('active');

            // Reset submit button
            const btn = $('#submitBtn');
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-check-circle"></i> <?= lang('confirm_booking') ?>';

            // Show/hide
            $('#bookingSuccess').classList.remove('visible');
            const sidebar = $('.booking-sidebar');
            if (sidebar) sidebar.style.display = 'flex';
            $('#bookingFormWrap').style.display = 'block';

            // Scroll to top
            $('#bookingFormWrap').scrollIntoView({ behavior: 'smooth', block: 'start' });
        };

        // ─── Confetti Animation ───
        function launchConfetti() {
            const container = document.createElement('div');
            container.className = 'confetti-container';
            document.body.appendChild(container);

            const colors = ['#10b981', '#f59e0b', '#3b82f6', '#ef4444', '#8b5cf6', '#ec4899'];
            for (let i = 0; i < 60; i++) {
                const piece = document.createElement('div');
                piece.className = 'confetti-piece';
                piece.style.left = Math.random() * 100 + '%';
                piece.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                piece.style.animationDuration = (Math.random() * 2 + 2) + 's';
                piece.style.animationDelay = Math.random() * 0.5 + 's';
                piece.style.width = (Math.random() * 8 + 5) + 'px';
                piece.style.height = (Math.random() * 8 + 5) + 'px';
                piece.style.borderRadius = Math.random() > 0.5 ? '50%' : '2px';
                container.appendChild(piece);
            }

            setTimeout(() => {
                container.remove();
            }, 4000);
        }
    })();
    </script>
</body>
</html>

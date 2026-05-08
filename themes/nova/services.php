<?php
/**
 * Theme: Nova - Services Page
 * القالب: نوفا - صفحة الخدمات
 */
$lang = Language::current();
$dir = Language::direction();
$isRtl = $dir === 'rtl';
$themePrimary = $tenant->primary_color ?? '#6366f1';
$themeSecondary = $tenant->secondary_color ?? '#4f46e5';
$siteBase = '/site/' . $tenant->slug;
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? lang('our_services') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap<?= $isRtl ? '.rtl' : '' ?>.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=<?= $isRtl ? 'Cairo:wght@300;400;500;600;700;800;900' : 'Poppins:wght@300;400;500;600;700;800;900' ?>&display=swap" rel="stylesheet">
    <style>
        :root { --primary: <?= $themePrimary ?>; --primary-dark: <?= $themeSecondary ?>; --gradient: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); --radius: 12px; --radius-lg: 20px; --text: #1a1a2e; --text-secondary: #4a4a6a; --bg-alt: #f8f9fc; --border-light: #f0f1f7; --shadow: 0 4px 20px rgba(0,0,0,0.07); --shadow-md: 0 8px 32px rgba(0,0,0,0.09); --shadow-lg: 0 16px 48px rgba(0,0,0,0.12); --shadow-primary: 0 8px 32px color-mix(in srgb, var(--primary) 25%, transparent); --primary-50: color-mix(in srgb, var(--primary) 6%, white); --font: '<?= $isRtl ? 'Cairo' : 'Poppins' ?>', system-ui, sans-serif; --transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1); }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body { font-family: var(--font); color: var(--text); background: #fff; line-height: 1.7; }
        a { text-decoration: none; color: inherit; transition: var(--transition); }
        img { max-width: 100%; height: auto; display: block; }
        ul { list-style: none; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }
        .nova-navbar { background: rgba(255,255,255,0.78); backdrop-filter: blur(24px); position: fixed; width: 100%; top: 0; z-index: 1050; border-bottom: 1px solid var(--border-light); }
        .nova-navbar .container { display: flex; align-items: center; justify-content: space-between; height: 76px; }
        .nav-brand { display: flex; align-items: center; gap: 0.65rem; font-weight: 800; font-size: 1.2rem; color: var(--primary); }
        .nav-brand img { height: 44px; border-radius: 8px; }
        .nav-brand .brand-icon { width: 42px; height: 42px; background: var(--gradient); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.15rem; }
        .nav-links { display: flex; align-items: center; gap: 0.1rem; }
        .nav-links > li > a { padding: 0.5rem 0.85rem; border-radius: 8px; font-weight: 500; font-size: 0.9rem; color: var(--text-secondary); }
        .nav-links > li > a:hover { color: var(--primary); background: var(--primary-50); }
        .nav-cta { background: var(--primary) !important; color: #fff !important; font-weight: 600 !important; padding: 0.55rem 1.4rem !important; border-radius: var(--radius) !important; }
        .lang-switch { display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.45rem 0.85rem !important; border: 1.5px solid var(--border-light) !important; border-radius: 8px !important; font-size: 0.8rem !important; font-weight: 600 !important; color: var(--text-secondary) !important; }
        .mobile-btn { display: none; background: none; border: none; font-size: 1.35rem; cursor: pointer; color: var(--text); width: 42px; height: 42px; }
        @media (max-width: 992px) { .mobile-btn { display: flex; align-items: center; justify-content: center; } .nav-links { display: none; position: absolute; top: 100%; left: 0; right: 0; background: #fff; flex-direction: column; padding: 0.75rem; box-shadow: var(--shadow-lg); } .nav-links.open { display: flex; } }
        .page-hero { background: var(--gradient); padding: 8rem 1.5rem 4rem; text-align: center; }
        .page-hero h1 { color: #fff; font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; margin-bottom: 0.75rem; }
        .page-hero p { color: rgba(255,255,255,0.8); font-size: 1.1rem; max-width: 600px; margin: 0 auto; }
        .breadcrumb { display: flex; justify-content: center; gap: 0.5rem; margin-top: 1.5rem; }
        .breadcrumb a { color: rgba(255,255,255,0.7); font-size: 0.88rem; }
        .breadcrumb span { color: rgba(255,255,255,0.5); font-size: 0.88rem; }
        .breadcrumb .current { color: #fff; font-weight: 600; font-size: 0.88rem; }
        .services-section { padding: 5rem 1.5rem; }
        .services-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 2rem; }
        .service-card { background: #fff; border-radius: var(--radius-lg); overflow: hidden; border: 1px solid var(--border-light); transition: var(--transition); }
        .service-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-lg); border-color: transparent; }
        .service-card-img { height: 220px; overflow: hidden; }
        .service-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
        .service-card:hover .service-card-img img { transform: scale(1.08); }
        .service-card-body { padding: 2rem; }
        .service-card-icon { width: 56px; height: 56px; background: var(--primary-50); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; color: var(--primary); margin-bottom: 1rem; }
        .service-card h3 { font-size: 1.15rem; font-weight: 700; margin-bottom: 0.6rem; }
        .service-card .desc { color: var(--text-secondary); font-size: 0.9rem; line-height: 1.7; margin-bottom: 1.25rem; }
        .service-card .link-btn { display: inline-flex; align-items: center; gap: 0.4rem; color: var(--primary); font-weight: 600; font-size: 0.9rem; }
        .service-card .link-btn:hover { gap: 0.7rem; }
        .service-card .price-tag { display: inline-block; padding: 0.25rem 0.75rem; background: var(--primary-50); color: var(--primary); border-radius: var(--radius); font-weight: 700; font-size: 0.85rem; margin-bottom: 1rem; }
        .nova-footer { background: #0f172a; color: rgba(255,255,255,0.7); padding: 3rem 1.5rem 1.5rem; }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.08); padding-top: 1.5rem; text-align: center; font-size: 0.82rem; }
        .footer-grid { display: grid; grid-template-columns: 1.5fr 1fr 1fr 1fr; gap: 2.5rem; margin-bottom: 3rem; }
        @media (max-width: 768px) { .footer-grid { grid-template-columns: 1fr 1fr; } }
        .footer-brand { display: flex; align-items: center; gap: 0.65rem; margin-bottom: 1rem; }
        .footer-brand img { height: 40px; }
        .footer-brand .brand-icon { width: 38px; height: 38px; background: var(--gradient); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1rem; }
        .footer-brand span { font-weight: 700; color: #fff; font-size: 1.1rem; }
        .footer-desc { font-size: 0.88rem; line-height: 1.8; margin-bottom: 1.5rem; }
        .footer-col h4 { color: #fff; font-weight: 700; font-size: 1rem; margin-bottom: 1.25rem; }
        .footer-col ul li { margin-bottom: 0.65rem; }
        .footer-col ul li a { font-size: 0.88rem; color: rgba(255,255,255,0.6); }
        .footer-col ul li a:hover { color: #fff; }
        .whatsapp-float { position: fixed; bottom: 24px; <?= $isRtl ? 'left' : 'right' ?>: 24px; z-index: 1000; width: 56px; height: 56px; background: #25d366; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.6rem; box-shadow: 0 4px 24px rgba(37,211,102,0.4); }
        @media (max-width: 768px) { .services-grid { grid-template-columns: 1fr; gap: 1.5rem; } .service-card-img { height: 180px; } .footer-grid { grid-template-columns: 1fr; text-align: center; } .footer-desc { text-align: center; } }
        @media (max-width: 480px) { .service-card-body { padding: 1.5rem; } }
    </style>
</head>
<body>
<nav class="nova-navbar">
    <div class="container">
        <a href="<?= url($siteBase) ?>" class="nav-brand">
            <?php if (!empty($tenant->logo)): ?><img src="<?= upload($tenant->logo) ?>" alt=""><?php else: ?>
            <div class="brand-icon"><i class="fas fa-gem"></i></div><?php endif; ?>
            <span><?= htmlspecialchars($tenant->site_name) ?></span>
        </a>
        <ul class="nav-links" id="navLinks">
            <?php if (!empty($menu)): foreach ($menu as $item): ?>
                <?php
                    $navHref = $siteBase; $s = strtolower($item->slug ?? ''); $slugRaw = $item->slug ?? '';
                    if ($item->is_home == 1) $navHref = $siteBase;
                    elseif (strpos($s, 'about') !== false || strpos($slugRaw, 'من نحن') !== false || strpos($slugRaw, 'حول') !== false || strpos($slugRaw, 'عن') !== false) $navHref = $siteBase . '/about';
                    elseif (strpos($s, 'service') !== false || strpos($slugRaw, 'خدمات') !== false) $navHref = $siteBase . '/services';
                    elseif (strpos($s, 'gallery') !== false || strpos($slugRaw, 'معرض') !== false) $navHref = $siteBase . '/gallery';
                    elseif (strpos($s, 'contact') !== false || strpos($slugRaw, 'اتصل') !== false) $navHref = $siteBase . '/contact';
                    elseif (strpos($s, 'faq') !== false || strpos($slugRaw, 'سؤال') !== false) $navHref = $siteBase . '/faq';
                    elseif (strpos($s, 'partner') !== false || strpos($slugRaw, 'شريك') !== false) $navHref = $siteBase . '/partners';
                    elseif (strpos($s, 'book') !== false || strpos($slugRaw, 'حجز') !== false) $navHref = $siteBase . '/booking';
                    elseif (strpos($s, 'blog') !== false || strpos($slugRaw, 'مدونة') !== false) $navHref = $siteBase . '/blog';
                    else $navHref = $siteBase . '/' . $item->slug;
                ?>
                <li><a href="<?= url($navHref) ?>"><?= htmlspecialchars(localized($item, 'title') ?: $item->title ?? '') ?></a></li>
            <?php endforeach; endif; ?>
        </ul>
        <div style="display:flex;align-items:center;gap:0.5rem;">
            <a href="<?= url($siteBase . '?lang=' . Language::opposite()) ?>" class="lang-switch"><i class="fas fa-globe"></i> <?= Language::opposite() === 'en' ? 'EN' : 'عربي' ?></a>
            <button class="mobile-btn" id="mobileBtn"><i class="fas fa-bars"></i></button>
        </div>
    </div>
</nav>

<div class="page-hero">
    <h1><?= lang('our_services') ?></h1>
    <p><?= lang('services_subtitle') ?></p>
    <div class="breadcrumb">
        <a href="<?= url($siteBase) ?>"><?= lang('home') ?></a>
        <span>/</span>
        <span class="current"><?= lang('our_services') ?></span>
    </div>
</div>

<div class="services-section">
    <div class="container">
        <?php if (!empty($services)): ?>
        <div class="services-grid">
            <?php foreach ($services as $service): ?>
            <div class="service-card">
                <?php if (!empty($service->image)): ?>
                <div class="service-card-img">
                    <img src="<?= upload($service->image) ?>" alt="<?= htmlspecialchars(localized($service, 'title') ?: $service->title) ?>" loading="lazy">
                </div>
                <?php endif; ?>
                <div class="service-card-body">
                    <?php if (empty($service->image)): ?>
                    <div class="service-card-icon"><i class="<?= $service->icon ?? 'fas fa-star' ?>"></i></div>
                    <?php endif; ?>
                    <h3><?= htmlspecialchars(localized($service, 'title') ?: $service->title) ?></h3>
                    <?php if (!empty($service->price) || !empty($service->price_text)): ?>
                    <span class="price-tag"><?= htmlspecialchars(localized($service, 'price_text') ?: $service->price_text ?? $service->price ?? '') ?></span>
                    <?php endif; ?>
                    <p class="desc"><?= htmlspecialchars(localized($service, 'description') ?: $service->description ?? '') ?></p>
                    <?php if (!empty($service->slug)): ?>
                    <a href="<?= url($siteBase . '/service/' . $service->slug) ?>" class="link-btn"><?= lang('read_more') ?> <i class="fas fa-arrow-<?= $isRtl ? 'left' : 'right' ?>"></i></a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div style="text-align:center;padding:4rem 0;color:var(--text-secondary);">
            <i class="fas fa-concierge-bell" style="font-size:3rem;margin-bottom:1rem;color:var(--primary-50);"></i>
            <p><?= lang('no_services') ?></p>
        </div>
        <?php endif; ?>
    </div>
</div>

<footer class="nova-footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div class="footer-brand"><?php if (!empty($tenant->logo)): ?><img src="<?= upload($tenant->logo) ?>" alt=""><?php else: ?><div class="brand-icon"><i class="fas fa-gem"></i></div><?php endif; ?><span><?= htmlspecialchars($tenant->site_name) ?></span></div>
                <p class="footer-desc"><?= htmlspecialchars($tenant->meta_description) ?></p>
            </div>
            <div class="footer-col"><h4><?= lang('quick_links') ?></h4><ul>
                <li><a href="<?= url($siteBase) ?>"><?= lang('home') ?></a></li>
                <li><a href="<?= url($siteBase . '/about') ?>"><?= lang('about_us') ?></a></li>
                <li><a href="<?= url($siteBase . '/services') ?>"><?= lang('our_services') ?></a></li>
            </ul></div>
            <div class="footer-col"><h4><?= lang('more_pages') ?></h4><ul>
                <li><a href="<?= url($siteBase . '/gallery') ?>"><?= lang('gallery') ?></a></li>
                <li><a href="<?= url($siteBase . '/faq') ?>"><?= lang('faq') ?></a></li>
                <li><a href="<?= url($siteBase . '/contact') ?>"><?= lang('contact_us') ?></a></li>
            </ul></div>
            <div class="footer-col"><h4><?= lang('contact_info') ?></h4><ul>
                <?php if (!empty($tenant->contact_phone)): ?><li><a href="tel:<?= $tenant->contact_phone ?>" dir="ltr"><?= $tenant->contact_phone ?></a></li><?php endif; ?>
                <?php if (!empty($tenant->contact_email)): ?><li><a href="mailto:<?= $tenant->contact_email ?>"><?= $tenant->contact_email ?></a></li><?php endif; ?>
            </ul></div>
        </div>
        <div class="footer-bottom"><p>&copy; <?= date('Y') ?> <?= htmlspecialchars($tenant->site_name) ?>. <?= lang('all_rights_reserved') ?></p></div>
    </div>
</footer>
<?php if (!empty($tenant->contact_whatsapp)): ?><a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp) ?>" class="whatsapp-float" target="_blank"><i class="fab fa-whatsapp"></i></a><?php endif; ?>
<script>document.getElementById('mobileBtn').addEventListener('click',function(){document.getElementById('navLinks').classList.toggle('open');this.querySelector('i').classList.toggle('fa-bars');this.querySelector('i').classList.toggle('fa-times');});</script>
</body>
</html>

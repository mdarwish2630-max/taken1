<?php
/**
 * TakPro Theme — Head Partial
 * Light theme + Orange (#ff7a00) accent + Tailwind CDN + Cairo font
 */
$isRtl = ($dir ?? 'rtl') === 'rtl';
$lang  = $lang ?? 'ar';
$title = $title ?? htmlspecialchars($tenant->site_name ?? 'تك برو');
$metaDesc  = $meta_description ?? $tenant->meta_description ?? '';
$metaKeys  = $tenant->meta_keywords ?? '';
$siteBase  = $siteBase ?? ('/site/' . $tenant->slug);
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $isRtl ? 'rtl' : 'ltr' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <meta name="description" content="<?= htmlspecialchars($metaDesc) ?>">
    <?php if (!empty($metaKeys)): ?>
    <meta name="keywords" content="<?= htmlspecialchars($metaKeys) ?>">
    <?php endif; ?>

    <?php $_safeFontUrl = safeFontUrl($themeFontsUrl ?? ''); if (!empty($_safeFontUrl)): ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="<?= $_safeFontUrl ?>" rel="stylesheet">
    <?php else: ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <?php endif; ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: { cairo: ['<?= !empty($themeSettings->primary_font) ? htmlspecialchars($themeSettings->primary_font) : 'Cairo' ?>', 'sans-serif'] },
                colors: {
                    brand: '#ff7a00',
                    'brand-dark': '#e06e00',
                    dark: '#161616',
                    'dark-light': '#1d2736',
                    'dark-bg': '#151515',
                    'dark-card': '#171717',
                    'dark-section': '#111111',
                }
            }
        }
    }
    </script>

    <style>
        * { font-family: <?= !empty($themeSettings->primary_font) ? "'" . htmlspecialchars($themeSettings->primary_font) . "'" : "'Cairo'" ?>, sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        ::selection { background: rgba(255,122,0,.25); color: #161616; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #ff7a00; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #e06e00; }

        .fade-up { opacity: 0; transform: translateY(30px); transition: opacity .6s ease, transform .6s ease; }
        .fade-up.visible { opacity: 1; transform: translateY(0); }

        @keyframes float { 0%,100%{ transform: translateY(0); } 50%{ transform: translateY(-10px); } }
        .animate-float { animation: float 4s ease-in-out infinite; }

        @keyframes pulse-glow { 0%,100%{ box-shadow: 0 0 20px rgba(255,122,0,.3); } 50%{ box-shadow: 0 0 40px rgba(255,122,0,.6); } }
        .pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }

        .service-card:hover .service-img { transform: scale(1.1); }

        /* Smooth scroll */
        html { scroll-behavior: smooth; }
        <?php if (!empty($themeCustomCSS)): ?>
/* Custom Theme Settings CSS */
<?= sanitizeCSS($themeCustomCSS) ?>
<?php endif; ?>
    </style>
</head>
<body class="min-h-screen bg-white text-dark overflow-x-hidden font-cairo">

<?php
/**
 * Tek Pro Theme — Head Partial
 * Light theme (bg-white) + Orange #ff7a00 accent + Tailwind CDN + Tajawal font
 */
$isRtl = ($dir ?? 'rtl') === 'rtl';
$lang  = $lang ?? 'ar';
$title = $title ?? htmlspecialchars($tenant->site_name ?? 'تك برو');
$metaDesc  = $meta_description ?? $tenant->meta_description ?? '';
$metaKeys  = $tenant->meta_keywords ?? '';
$siteBase  = $siteBase ?? (BASE_PATH . '/site/' . $tenant->slug);
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
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">
    <?php endif; ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: { tajawal: ['<?= !empty($themeSettings->primary_font) ? htmlspecialchars($themeSettings->primary_font) : 'Tajawal' ?>', 'sans-serif'] },
                colors: {
                    tekpro: '#ff7a00',
                    tekdark: '#151515',
                    tekbody: '#161616',
                }
            }
        }
    }
    </script>

    <style>
        * { font-family: <?= !empty($themeSettings->primary_font) ? "'" . htmlspecialchars($themeSettings->primary_font) . "'" : "'Tajawal'" ?>, sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        ::selection { background: rgba(255,122,0,.25); color: #151515; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f3f3f3; }
        ::-webkit-scrollbar-thumb { background: rgba(255,122,0,.35); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255,122,0,.6); }

        .fade-up { opacity: 0; transform: translateY(30px); transition: opacity .6s ease, transform .6s ease; }
        .fade-up.visible { opacity: 1; transform: translateY(0); }

        .glass-orange { background: rgba(255,122,0,.06); border: 1px solid rgba(255,122,0,.15); backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px); }
        .glass-dark { background: rgba(21,21,21,.85); border: 1px solid rgba(255,255,255,.08); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); }

        .glow-orange { box-shadow: 0 0 30px rgba(255,122,0,.12); }
        .hover-glow:hover { box-shadow: 0 0 20px rgba(255,122,0,.2); border-color: rgba(255,122,0,.5); }

        @keyframes float { 0%,100%{ transform: translateY(0); } 50%{ transform: translateY(-10px); } }
        .animate-float { animation: float 4s ease-in-out infinite; }

        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }

        .tekpro-card { transition: transform .3s ease, box-shadow .3s ease; }
        .tekpro-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0,0,0,.1); }
        <?php if (!empty($themeCustomCSS)): ?>
/* Custom Theme Settings CSS */
<?= sanitizeCSS($themeCustomCSS) ?>
<?php endif; ?>
    </style>
</head>
<body class="min-h-screen bg-white text-[#161616] overflow-x-hidden font-tajawal">

<?php
/**
 * Master Theme — Head Partial
 * Dark theme (bg-[#0f172a]) + Cyan-500 accent + Tailwind CDN + Tajawal font
 */
$isRtl = ($dir ?? 'rtl') === 'rtl';
$lang  = $lang ?? 'ar';
$title = $title ?? htmlspecialchars($tenant->site_name ?? 'تكوين');
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
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
    <?php endif; ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: { tajawal: ['<?= !empty($themeSettings->primary_font) ? htmlspecialchars($themeSettings->primary_font) : 'Tajawal' ?>', 'sans-serif'] },
            }
        }
    }
    </script>

    <style>
        * { font-family: <?= !empty($themeSettings->primary_font) ? "'" . htmlspecialchars($themeSettings->primary_font) . "'" : "'Tajawal'" ?>, sans-serif; }
        ::selection { background: rgba(6,182,212,.3); color: #fff; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: rgba(6,182,212,.3); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(6,182,212,.5); }

        .fade-up { opacity: 0; transform: translateY(30px); transition: opacity .6s ease, transform .6s ease; }
        .fade-up.visible { opacity: 1; transform: translateY(0); }

        .glass { background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.08); backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px); }
        .glass-strong { background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.12); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); }

        .glow-cyan { box-shadow: 0 0 40px rgba(6,182,212,.15), 0 0 80px rgba(6,182,212,.05); }
        .glow-border:hover { border-color: rgba(6,182,212,.4); box-shadow: 0 0 20px rgba(6,182,212,.1); }

        @keyframes float { 0%,100%{ transform: translateY(0); } 50%{ transform: translateY(-10px); } }
        .animate-float { animation: float 4s ease-in-out infinite; }

        .service-card:hover .service-img { transform: scale(1.1); }
        <?php if (!empty($themeCustomCSS)): ?>
/* Custom Theme Settings CSS */
<?= sanitizeCSS($themeCustomCSS) ?>
<?php endif; ?>
    </style>
</head>
<body class="min-h-screen bg-[#0f172a] text-white overflow-x-hidden font-tajawal">

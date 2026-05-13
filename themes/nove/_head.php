<!DOCTYPE html>
<html lang="<?= $lang ?? 'ar' ?>" dir="<?= $dir ?? 'rtl' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? ($page->title ?? $tenant->site_name ?? 'لمعة كلين') ?> | <?= $tenant->site_name ?? 'لمعة كلين' ?></title>
    <?php if (!empty($page->meta_title)): ?>
        <meta name="title" content="<?= htmlspecialchars($page->meta_title) ?>">
    <?php endif; ?>
    <?php if (!empty($tenant->meta_description)): ?>
        <meta name="description" content="<?= htmlspecialchars($tenant->meta_description) ?>">
    <?php endif; ?>

    <?php if (!empty($themeFontsUrl)): ?>
    <!-- Google Fonts (dynamic) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="<?= $themeFontsUrl ?>" rel="stylesheet">
    <?php else: ?>
    <!-- Google Fonts: Tajawal -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">
    <?php endif; ?>

    <!-- Font Awesome 6.5.1 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        tajawal: ['<?= !empty($themeSettings->primary_font) ? htmlspecialchars($themeSettings->primary_font) : 'Tajawal' ?>', 'sans-serif'],
                    },
                    colors: {
                        orange: '#ff7a00',
                        'orange-hover': '#e56d00',
                        dark: '#151515',
                        'dark-nav': '#111111',
                        'dark-text': '#282828',
                        'dark-title': '#1f2a3b',
                        'gray-bg': '#f4f4f4',
                    },
                },
            },
        }
    </script>

    <style>
        /* Global font */
        * {
            font-family: <?= !empty($themeSettings->primary_font) ? "'" . htmlspecialchars($themeSettings->primary_font) . "'" : "'Tajawal'" ?>, sans-serif;
        }

        /* Selection highlight */
        ::selection {
            background: rgba(255, 122, 0, 0.3);
            color: #fff;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f4f4f4;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 122, 0, 0.4);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 122, 0, 0.6);
        }

        /* Firefox scrollbar */
        * {
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 122, 0, 0.4) #f4f4f4;
        }

        /* Fade-up animation */
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Service card image zoom on hover */
        .service-card:hover .service-img {
            transform: scale(1.1);
        }

        /* Floating animation */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        /* Bold uppercase utility */
        .text-upper-bold {
            text-transform: uppercase;
            font-weight: 900;
        }

        /* Orange accent bar */
        .orange-bar {
            width: 5rem;
            height: 6px;
            background: #ff7a00;
            display: inline-block;
        }
        <?php if (!empty($themeCustomCSS)): ?>
/* Custom Theme Settings CSS */
<?= $themeCustomCSS ?>
<?php endif; ?>
    </style>
</head>
<body class="min-h-screen bg-white text-[#222] overflow-hidden font-tajawal">

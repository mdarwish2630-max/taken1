<!DOCTYPE html>
<html lang="<?= $lang ?? 'ar' ?>" dir="<?= $dir ?? 'rtl' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? ($page->title ?? $tenant->site_name ?? 'ركاز للصيانة') ?> | <?= $tenant->site_name ?? 'ركاز للصيانة' ?></title>
    <?php if (!empty($page->meta_title)): ?>
        <meta name="title" content="<?= htmlspecialchars($page->meta_title) ?>">
    <?php endif; ?>
    <?php if (!empty($tenant->meta_description)): ?>
        <meta name="description" content="<?= htmlspecialchars($tenant->meta_description) ?>">
    <?php endif; ?>

    <!-- Google Fonts: Tajawal -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome 6.5.1 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        tajawal: ['Tajawal', 'sans-serif'],
                    },
                    colors: {
                        copper: '#c97b47',
                        'copper-hover': '#b56d3b',
                        'copper-light': '#f0e0d0',
                        'warm-bg': '#f8f5f1',
                        'warm-card': '#ffffff',
                        'warm-dark': '#1c1917',
                        'warm-text': '#292524',
                        'warm-muted': '#78716c',
                    },
                    borderRadius: {
                        'rakaz': '35px',
                    },
                },
            },
        }
    </script>

    <style>
        * { font-family: 'Tajawal', sans-serif; }

        ::selection {
            background: rgba(201, 123, 71, 0.3);
            color: #fff;
        }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f8f5f1; }
        ::-webkit-scrollbar-thumb { background: rgba(201, 123, 71, 0.4); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(201, 123, 71, 0.6); }

        * { scrollbar-width: thin; scrollbar-color: rgba(201, 123, 71, 0.4) #f8f5f1; }

        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .card-rakaz {
            border-radius: 35px;
            overflow: hidden;
            transition: all 0.4s ease;
        }
        .card-rakaz:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 60px rgba(201, 123, 71, 0.15);
        }

        .card-rakaz-sm {
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s ease;
        }
        .card-rakaz-sm:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(201, 123, 71, 0.12);
        }

        .btn-copper {
            background: #c97b47;
            color: #fff;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        .btn-copper:hover {
            background: #b56d3b;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(201, 123, 71, 0.3);
        }

        .btn-copper-outline {
            border: 2px solid #c97b47;
            color: #c97b47;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        .btn-copper-outline:hover {
            background: #c97b47;
            color: #fff;
            transform: translateY(-2px);
        }

        .copper-bar {
            width: 5rem;
            height: 6px;
            background: #c97b47;
            display: inline-block;
            border-radius: 50px;
        }

        .img-cover { object-fit: cover; width: 100%; height: 100%; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-float { animation: float 4s ease-in-out infinite; }
    </style>
</head>
<body class="min-h-screen bg-warm-bg text-warm-text overflow-hidden font-tajawal">

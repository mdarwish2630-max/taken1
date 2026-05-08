<?php
/**
 * Blog Post View (Frontend)
 * عرض مقال المدونة - الواجهة الأمامية
 */

$tenant = $tenant ?? null;
$post = $post ?? null;
$lang = Language::current();
$dir = Language::direction();
$siteName = $tenant ? $tenant->site_name : SITE_NAME;

$this->noLayout();
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($post->title ?? lang('blog')) ?> - <?= e($siteName) ?></title>

    <?php if (!empty($post->meta_description)): ?>
    <meta name="description" content="<?= e($post->meta_description) ?>">
    <?php endif; ?>

    <!-- Google Fonts - Cairo -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: <?= $tenant->primary_color ?? '#4f46e5' ?>;
            --primary-dark: <?= $tenant->secondary_color ?? '#3730a3' ?>;
            --dark: #1e293b;
            --white: #ffffff;
            --light: #f8fafc;
            --gray-200: #e2e8f0;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gradient: linear-gradient(135deg, var(--primary), var(--primary-dark));
            --radius: 0.75rem;
            --transition: all 0.3s;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Cairo', sans-serif; background: var(--light); color: var(--dark); line-height: 1.8; }
        a { text-decoration: none; color: inherit; }

        .post-header {
            background: var(--gradient);
            padding: 3rem 2rem;
            text-align: center;
            color: var(--white);
        }
        .post-back {
            display: inline-flex; align-items: center; gap: 0.5rem;
            color: rgba(255,255,255,0.8); font-size: 0.9rem;
            margin-bottom: 1.5rem; transition: var(--transition);
        }
        .post-back:hover { color: var(--white); }

        .post-category {
            display: inline-block;
            background: rgba(255,255,255,0.15);
            padding: 0.25rem 1rem;
            border-radius: 50px;
            font-size: 0.8rem; font-weight: 600;
            margin-bottom: 1rem;
        }

        .post-title {
            font-size: 2rem; font-weight: 800;
            max-width: 800px; margin: 0 auto 1rem;
            line-height: 1.4;
        }

        .post-meta {
            display: flex; align-items: center; justify-content: center; gap: 1.5rem;
            font-size: 0.85rem; opacity: 0.85;
        }
        .post-meta i { margin-inline-end: 0.25rem; }

        .post-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        .post-card {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            overflow: hidden;
        }

        .post-image {
            width: 100%; max-height: 400px;
            object-fit: cover;
        }
        .post-no-image {
            height: 200px;
            background: var(--gray-200);
            display: flex; align-items: center; justify-content: center;
            color: var(--gray-400); font-size: 4rem;
        }

        .post-content {
            padding: 2.5rem;
            font-size: 1.05rem;
            line-height: 1.9;
        }
        .post-content p { margin-bottom: 1.25rem; }
        .post-content h2 { font-size: 1.5rem; font-weight: 700; margin: 2rem 0 1rem; color: var(--dark); }
        .post-content h3 { font-size: 1.25rem; font-weight: 700; margin: 1.5rem 0 0.75rem; color: var(--dark); }
        .post-content img { max-width: 100%; border-radius: var(--radius); margin: 1.5rem 0; }
        .post-content ul, .post-content ol { padding-inline-start: 2rem; margin-bottom: 1.25rem; }
        .post-content li { margin-bottom: 0.5rem; }
        .post-content a { color: var(--primary); }
        .post-content blockquote {
            border-inline-start: 4px solid var(--primary);
            padding: 1rem 1.5rem;
            background: var(--light);
            border-radius: 0 var(--radius) var(--radius) 0;
            margin: 1.5rem 0;
            font-style: italic;
        }

        .post-not-found {
            text-align: center;
            padding: 5rem 2rem;
            color: var(--gray-500);
        }
        .post-not-found i { font-size: 4rem; margin-bottom: 1rem; opacity: 0.3; display: block; }

        @media (max-width: 768px) {
            .post-header { padding: 2rem 1.5rem; }
            .post-title { font-size: 1.5rem; }
            .post-content { padding: 1.5rem; }
            .post-meta { flex-wrap: wrap; }
        }
    </style>
</head>
<body>
    <?php if ($post): ?>
    <div class="post-header">
        <a href="<?= url('/site/' . $tenant->slug . '/blog') ?>" class="post-back">
            <i class="fas fa-arrow-<?= $dir === 'rtl' ? 'right' : 'left' ?>"></i>
            <?= lang('back_to_blog') ?? 'العودة للمدونة' ?>
        </a>

        <?php if (!empty($post->category)): ?>
        <div class="post-category"><?= e($post->category) ?></div>
        <?php endif; ?>

        <h1 class="post-title"><?= e($post->title) ?></h1>

        <div class="post-meta">
            <?php if (!empty($post->author)): ?>
            <span><i class="fas fa-user"></i> <?= e($post->author) ?></span>
            <?php endif; ?>
            <?php if (!empty($post->created_at)): ?>
            <span><i class="fas fa-calendar"></i> <?= date('Y/m/d', strtotime($post->created_at)) ?></span>
            <?php endif; ?>
            <?php if (!empty($post->reading_time)): ?>
            <span><i class="fas fa-clock"></i> <?= e($post->reading_time) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="post-container">
        <div class="post-card">
            <?php if (!empty($post->image)): ?>
            <img class="post-image" src="<?= upload($post->image) ?>" alt="<?= e($post->title) ?>">
            <?php else: ?>
            <div class="post-no-image"><i class="fas fa-newspaper"></i></div>
            <?php endif; ?>

            <div class="post-content">
                <?= $post->content ?? '' ?>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="post-not-found">
        <i class="fas fa-exclamation-triangle"></i>
        <h2><?= lang('post_not_found') ?? 'المقال غير موجود' ?></h2>
        <a href="<?= url('/site/' . ($tenant->slug ?? '')) ?>" style="color: var(--primary); margin-top: 1rem; display: inline-block;">
            <?= lang('back_home') ?? 'العودة للرئيسية' ?>
        </a>
    </div>
    <?php endif; ?>
</body>
</html>

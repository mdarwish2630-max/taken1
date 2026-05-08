<?php
/**
 * Blog Listing View (Frontend)
 * عرض المدونة - الواجهة الأمامية
 */

$tenant = $tenant ?? null;
$posts = $posts ?? [];
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
    <title><?= lang('blog') ?? 'المدونة' ?> - <?= e($siteName) ?></title>

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
        body { font-family: 'Cairo', sans-serif; background: var(--light); color: var(--dark); line-height: 1.7; }
        a { text-decoration: none; color: inherit; }

        .blog-header {
            background: var(--gradient);
            padding: 4rem 2rem;
            text-align: center;
            color: var(--white);
        }
        .blog-header h1 { font-size: 2.25rem; font-weight: 800; margin-bottom: 0.5rem; }
        .blog-header p { opacity: 0.9; font-size: 1.1rem; }

        .blog-container {
            max-width: 1200px;
            margin: -2rem auto 3rem;
            padding: 0 1.5rem;
            position: relative;
            z-index: 1;
        }

        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 2rem;
        }

        .blog-card {
            background: var(--white);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            transition: var(--transition);
        }
        .blog-card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(0,0,0,0.1); }

        .blog-card-image {
            height: 200px;
            background: var(--gray-200);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-400);
            font-size: 3rem;
        }
        .blog-card-image img { width: 100%; height: 100%; object-fit: cover; }

        .blog-card-body { padding: 1.5rem; }
        .blog-card-meta {
            display: flex; align-items: center; gap: 1rem;
            font-size: 0.8rem; color: var(--gray-500); margin-bottom: 0.75rem;
        }
        .blog-card-meta i { margin-inline-end: 0.25rem; }
        .blog-card-title { font-size: 1.15rem; font-weight: 700; margin-bottom: 0.5rem; }
        .blog-card-title a:hover { color: var(--primary); }
        .blog-card-excerpt { color: var(--gray-500); font-size: 0.9rem; line-height: 1.7; }

        .blog-empty {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--gray-500);
        }
        .blog-empty i { font-size: 4rem; margin-bottom: 1rem; opacity: 0.3; display: block; }

        @media (max-width: 768px) {
            .blog-grid { grid-template-columns: 1fr; }
            .blog-header { padding: 3rem 1.5rem; }
            .blog-header h1 { font-size: 1.75rem; }
        }
    </style>
</head>
<body>
    <div class="blog-header">
        <h1><i class="fas fa-blog"></i> <?= lang('blog') ?? 'المدونة' ?></h1>
        <p><?= lang('blog_description') ?? 'آخر المقالات والأخبار' ?></p>
    </div>

    <div class="blog-container">
        <?php if (!empty($posts)): ?>
        <div class="blog-grid">
            <?php foreach ($posts as $post): ?>
            <div class="blog-card">
                <div class="blog-card-image">
                    <?php if (!empty($post->image)): ?>
                    <img src="<?= upload($post->image) ?>" alt="<?= e($post->title) ?>">
                    <?php else: ?>
                    <i class="fas fa-newspaper"></i>
                    <?php endif; ?>
                </div>
                <div class="blog-card-body">
                    <div class="blog-card-meta">
                        <?php if (!empty($post->category)): ?>
                        <span><i class="fas fa-folder"></i> <?= e($post->category) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($post->created_at)): ?>
                        <span><i class="fas fa-calendar"></i> <?= date('Y/m/d', strtotime($post->created_at)) ?></span>
                        <?php endif; ?>
                    </div>
                    <h3 class="blog-card-title">
                        <a href="<?= url('/site/' . $tenant->slug . '/blog/' . ($post->slug ?? $post->id)) ?>">
                            <?= e($post->title) ?>
                        </a>
                    </h3>
                    <?php if (!empty($post->excerpt)): ?>
                    <p class="blog-card-excerpt"><?= e(truncate($post->excerpt, 120)) ?></p>
                    <?php elseif (!empty($post->content)): ?>
                    <p class="blog-card-excerpt"><?= e(truncate(strip_tags($post->content), 120)) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="blog-empty">
            <i class="fas fa-newspaper"></i>
            <h3><?= lang('no_posts') ?? 'لا توجد مقالات بعد' ?></h3>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>

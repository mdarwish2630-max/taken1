<?php
/**
 * Site Maintenance Page
 * صفحة الصيانة
 */

$lang = Language::current();
$dir = Language::direction();
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tenant->site_name ?> - <?= lang('maintenance') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Tajawal', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
            color: #fff;
            text-align: center;
            padding: 2rem;
        }
        .container { max-width: 500px; }
        .logo { margin-bottom: 2rem; }
        .logo img { max-width: 120px; }
        h1 { font-size: 2.5rem; margin-bottom: 1rem; }
        p { font-size: 1.125rem; opacity: 0.8; margin-bottom: 2rem; }
        .icon { font-size: 5rem; margin-bottom: 2rem; color: #fbbf24; }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($tenant->logo): ?>
        <div class="logo">
            <img src="<?= upload($tenant->logo) ?>" alt="<?= $tenant->site_name ?>">
        </div>
        <?php endif; ?>
        
        <div class="icon">🔧</div>
        
        <h1><?= lang('site_under_maintenance') ?></h1>
        <p><?= lang('maintenance_message') ?></p>
        
        <?php if ($tenant->contact_phone): ?>
        <p style="margin-top: 2rem;">
            <strong><?= lang('contact_phone') ?>:</strong> 
            <a href="tel:<?= $tenant->contact_phone ?>" style="color: #fbbf24; text-decoration: none;">
                <?= $tenant->contact_phone ?>
            </a>
        </p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
/**
 * 404 Error Page
 * صفحة الخطأ 404
 */

$lang = Language::current();
$dir = Language::direction();
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - <?= lang('page_not_found') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Tajawal', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            text-align: center;
            padding: 2rem;
        }
        .error-container { max-width: 500px; }
        .error-code {
            font-size: 8rem;
            font-weight: 800;
            line-height: 1;
            text-shadow: 2px 2px 0 rgba(0,0,0,0.1);
        }
        .error-message {
            font-size: 1.5rem;
            margin: 1rem 0 2rem;
            opacity: 0.9;
        }
        .btn {
            display: inline-block;
            padding: 1rem 2rem;
            background: #fff;
            color: #667eea;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: transform 0.3s;
        }
        .btn:hover { transform: scale(1.05); }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">404</div>
        <h1><?= lang('page_not_found') ?></h1>
        <p class="error-message"><?= lang('page_not_found_message') ?></p>
        <a href="<?= url('/') ?>" class="btn">
            <i class="fas fa-home"></i> <?= lang('go_home') ?>
        </a>
    </div>
</body>
</html>

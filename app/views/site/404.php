<?php
$lang = Language::current();
$dir = Language::direction();
$isRtl = $dir === 'rtl';
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - <?= lang('page_not_found') ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: '<?= $isRtl ? 'Cairo' : 'Inter' ?>', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-container {
            text-align: center;
            background: white;
            padding: 60px 80px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 {
            font-size: 120px;
            color: #667eea;
            line-height: 1;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        p {
            color: #666;
            margin-bottom: 30px;
        }
        a {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 40px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        a:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        .lang-toggle {
            margin-top: 20px;
        }
        .lang-toggle a {
            background: transparent;
            border: 2px solid #667eea;
            color: #667eea;
            padding: 10px 25px;
            font-size: 14px;
        }
        .lang-toggle a:hover {
            background: #667eea;
            color: white;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>404</h1>
        <h2><?= lang('page_not_found') ?></h2>
        <p><?= lang('page_not_found_desc') ?></p>
        <a href="<?= isset($tenant) ? SITE_URL . '/' . $tenant->slug : SITE_URL ?>"><?= lang('go_home') ?></a>
        <div class="lang-toggle">
            <a href="<?= isset($tenant) ? SITE_URL . '/' . $tenant->slug . '?lang=' . Language::opposite() : SITE_URL . '/lang/' . Language::opposite() ?>">
                <i class="fas fa-globe"></i> <?= Language::opposite() === 'en' ? 'English' : 'العربية' ?>
            </a>
        </div>
    </div>
</body>
</html>

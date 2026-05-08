<?php
$lang = Language::current();
$dir = Language::direction();
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - <?= lang('error') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Cairo', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; color: #fff; }
        .error-container { text-align: center; padding: 2rem; }
        .error-code { font-size: 8rem; font-weight: 800; opacity: 0.3; line-height: 1; }
        .error-title { font-size: 2rem; font-weight: 700; margin-bottom: 1rem; }
        .error-message { font-size: 1.1rem; opacity: 0.8; margin-bottom: 2rem; max-width: 500px; }
        .error-btn { display: inline-block; padding: 0.75rem 2rem; background: rgba(255,255,255,0.2); color: #fff; text-decoration: none; border-radius: 50px; border: 2px solid rgba(255,255,255,0.3); font-weight: 600; transition: all 0.3s; }
        .error-btn:hover { background: rgba(255,255,255,0.3); transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">500</div>
        <h1 class="error-title"><?= lang('error_occurred') ?? 'حدث خطأ' ?></h1>
        <p class="error-message"><?= lang('server_error_message') ?? 'عذراً، حدث خطأ في الخادم. يرجى المحاولة مرة أخرى لاحقاً.' ?></p>
        <a href="<?= url('/') ?>" class="error-btn"><?= lang('go_home') ?? 'العودة للرئيسية' ?></a>
    </div>
</body>
</html>

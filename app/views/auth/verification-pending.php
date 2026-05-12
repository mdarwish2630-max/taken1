<?php
/**
 * Verification Pending View
 * صفحة انتظار تأكيد البريد الإلكتروني
 */

$lang = Language::current();
$dir = Language::direction();
$userEmail = $email ?? '';
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تأكيد البريد الإلكتروني - <?= SITE_NAME ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #4f46e5;
            --secondary: #7c3aed;
            --success: #059669;
            --dark: #1e293b;
            --white: #ffffff;
            --gray-200: #e2e8f0;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gradient: linear-gradient(135deg, #4f46e5, #7c3aed);
            --radius: 0.75rem;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Cairo', sans-serif;
            background: #f8fafc;
            color: var(--dark);
            min-height: 100vh;
        }
        a { text-decoration: none; }

        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 30%, #4338ca 60%, #6d28d9 100%);
            position: relative;
        }

        .auth-card {
            background: var(--white);
            border-radius: 1rem;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            overflow: hidden;
            width: 100%;
            max-width: 480px;
            position: relative;
            z-index: 1;
            animation: fadeInUp 0.5s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .auth-header {
            padding: 2.5rem 2rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid var(--gray-200);
        }

        .icon-circle {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(124, 58, 237, 0.1));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            position: relative;
        }

        .icon-circle i {
            font-size: 2.5rem;
            color: var(--primary);
        }

        .icon-circle::after {
            content: '';
            position: absolute;
            width: 110px;
            height: 110px;
            border: 2px dashed rgba(79, 70, 229, 0.2);
            border-radius: 50%;
            animation: spin 20s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .auth-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .auth-subtitle {
            color: var(--gray-500);
            font-size: 0.9rem;
            line-height: 1.7;
        }

        .email-highlight {
            display: inline-block;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.08), rgba(124, 58, 237, 0.08));
            padding: 0.4rem 1rem;
            border-radius: 0.5rem;
            font-weight: 700;
            color: var(--primary);
            direction: ltr;
            margin: 0.75rem 0;
        }

        .auth-body {
            padding: 2rem;
        }

        .steps-list {
            list-style: none;
            margin-bottom: 1.75rem;
        }

        .steps-list li {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.5rem 0;
            font-size: 0.9rem;
            color: #475569;
            line-height: 1.6;
        }

        .steps-list li .step-num {
            width: 28px;
            height: 28px;
            min-width: 28px;
            background: var(--gradient);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .resend-section {
            background: rgba(79, 70, 229, 0.04);
            border: 1px solid rgba(79, 70, 229, 0.1);
            border-radius: var(--radius);
            padding: 1.25rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .resend-section p {
            font-size: 0.85rem;
            color: var(--gray-500);
            margin-bottom: 0.75rem;
        }

        .btn-resend {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.5rem;
            background: var(--gradient);
            color: white;
            border: none;
            border-radius: var(--radius);
            font-weight: 700;
            font-size: 0.875rem;
            font-family: inherit;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }

        .btn-resend:hover {
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
            transform: translateY(-2px);
        }

        .btn-resend:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .auth-footer {
            padding: 1.5rem 2rem;
            text-align: center;
            font-size: 0.875rem;
            color: var(--gray-500);
            border-top: 1px solid var(--gray-200);
        }

        .auth-footer a {
            color: var(--primary);
            font-weight: 700;
            transition: var(--transition);
        }

        .auth-footer a:hover { color: var(--secondary); }

        .alert {
            padding: 0.875rem 1.25rem;
            border-radius: var(--radius);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .alert-success { background: rgba(5,150,105,0.08); color: #059669; border: 1px solid rgba(5,150,105,0.2); }
        .alert-danger { background: rgba(220,38,38,0.08); color: #dc2626; border: 1px solid rgba(220,38,38,0.2); }
        .alert-warning { background: rgba(245,158,11,0.08); color: #d97706; border: 1px solid rgba(245,158,11,0.2); }
        .alert-info { background: rgba(59,130,246,0.08); color: #2563eb; border: 1px solid rgba(59,130,246,0.2); }

        .lang-switch {
            position: absolute;
            top: 1.5rem;
            z-index: 10;
            <?= $dir === 'rtl' ? 'left: 1.5rem;' : 'right: 1.5rem;' ?>
        }
        .lang-switcher {
            display: flex; gap: 0.25rem;
            background: rgba(255,255,255,0.12);
            padding: 0.25rem; border-radius: 50px;
        }
        .lang-btn {
            padding: 0.4rem 0.8rem; border-radius: 50px;
            font-size: 0.8rem; font-weight: 600;
            color: rgba(255,255,255,0.7); border: none;
            background: transparent; cursor: pointer; font-family: inherit;
        }
        .lang-btn.active { background: var(--white); color: var(--primary); }

        @media (max-width: 480px) {
            .auth-card { max-width: 100%; }
            .auth-header { padding: 2rem 1.5rem 1.25rem; }
            .auth-body { padding: 1.5rem; }
            .auth-footer { padding: 1.25rem 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="lang-switch">
            <div class="lang-switcher">
                <a href="<?= url('/lang/ar') ?>" class="lang-btn <?= $lang === 'ar' ? 'active' : '' ?>">عربي</a>
                <a href="<?= url('/lang/en') ?>" class="lang-btn <?= $lang === 'en' ? 'active' : '' ?>">EN</a>
            </div>
        </div>

        <div class="auth-card">
            <div class="auth-header">
                <div class="icon-circle">
                    <i class="fas fa-envelope-open-text"></i>
                </div>
                <h1 class="auth-title">تحقق من بريدك الإلكتروني</h1>
                <p class="auth-subtitle">
                    لقد أرسلنا رابط تأكيد إلى بريدك الإلكتروني
                    <br>
                    <span class="email-highlight"><?= e($userEmail) ?></span>
                </p>
            </div>

            <div class="auth-body">
                <?= $this->messages() ?>

                <ul class="steps-list">
                    <li>
                        <span class="step-num">1</span>
                        <span>افتح صندوق البريد الوارد في بريدك الإلكتروني</span>
                    </li>
                    <li>
                        <span class="step-num">2</span>
                        <span>ابحث عن رسالة من <strong><?= SITE_NAME ?></strong> بعنوان "تأكيد البريد الإلكتروني"</span>
                    </li>
                    <li>
                        <span class="step-num">3</span>
                        <span>اضغط على زر "تأكيد البريد الإلكتروني" داخل الرسالة</span>
                    </li>
                </ul>

                <div class="resend-section">
                    <p>لم تصلك الرسالة؟ تحقق من مجلد البريد المزعج (Spam)</p>
                    <?php if (!empty($userEmail)): ?>
                    <form method="POST" action="<?= url('/resend-verification-public') ?>" id="resendForm">
                        <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
                        <input type="hidden" name="email" value="<?= e($userEmail) ?>">
                        <button type="submit" class="btn-resend" id="resendBtn">
                            <i class="fas fa-redo-alt"></i>
                            إعادة إرسال رابط التأكيد
                        </button>
                    </form>
                    <script>
                        document.getElementById('resendForm').addEventListener('submit', function(e) {
                            var btn = document.getElementById('resendBtn');
                            btn.disabled = true;
                            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الإرسال...';

                            var countdown = 60;
                            var originalText = btn.innerHTML;
                            var interval = setInterval(function() {
                                countdown--;
                                if (countdown <= 0) {
                                    clearInterval(interval);
                                    btn.disabled = false;
                                    btn.innerHTML = '<i class="fas fa-redo-alt"></i> إعادة إرسال رابط التأكيد';
                                } else {
                                    btn.innerHTML = '<i class="fas fa-clock"></i> انتظر ' + countdown + ' ثانية';
                                }
                            }, 1000);
                        });
                    </script>
                    <?php endif; ?>
                </div>
            </div>

            <div class="auth-footer">
                <a href="<?= url('/login') ?>">
                    <i class="fas fa-sign-in-alt"></i>
                    العودة لتسجيل الدخول
                </a>
            </div>
        </div>
    </div>
</body>
</html>

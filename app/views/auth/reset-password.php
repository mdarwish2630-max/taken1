<?php
/**
 * Reset Password View
 * صفحة إعادة تعيين كلمة المرور
 */

$lang = Language::current();
$dir = Language::direction();
$token = $token ?? '';
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= lang('reset_password') ?? 'إعادة تعيين كلمة المرور' ?> - <?= SITE_NAME ?></title>

    <!-- Google Fonts - Cairo -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --secondary: #7c3aed;
            --success: #059669;
            --danger: #dc2626;
            --dark: #1e293b;
            --white: #ffffff;
            --light: #f8fafc;
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
            background: var(--light);
            color: var(--dark);
            min-height: 100vh;
        }
        a { text-decoration: none; }

        .auth-container {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 2rem 1.5rem;
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 30%, #4338ca 60%, #6d28d9 100%);
            position: relative;
        }

        .auth-card {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            overflow: hidden;
            width: 100%; max-width: 440px;
            position: relative; z-index: 1;
        }

        .auth-header {
            padding: 2.5rem 2rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid var(--gray-200);
        }

        .auth-logo {
            width: 72px; height: 72px;
            background: var(--gradient);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.25rem;
            color: var(--white); font-size: 1.75rem;
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.35);
        }

        .auth-title { font-size: 1.5rem; font-weight: 800; color: var(--dark); margin-bottom: 0.5rem; }
        .auth-subtitle { color: var(--gray-500); font-size: 0.9rem; }

        .auth-body { padding: 2rem; }
        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem; }

        .form-control {
            width: 100%; padding: 0.8rem 1rem;
            border: 1.5px solid var(--gray-200);
            border-radius: var(--radius);
            font-size: 0.9rem; font-family: inherit;
            outline: none; background: var(--white); color: var(--dark);
        }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12); }

        .btn-primary-grad {
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            width: 100%; padding: 0.85rem 1.5rem;
            background: var(--gradient); color: var(--white);
            border: none; border-radius: var(--radius);
            font-weight: 700; font-size: 1rem; font-family: inherit;
            cursor: pointer; transition: var(--transition);
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.35);
        }
        .btn-primary-grad:hover { box-shadow: 0 8px 25px rgba(79, 70, 229, 0.45); transform: translateY(-2px); }

        .auth-footer {
            padding: 1.5rem 2rem; text-align: center;
            font-size: 0.875rem; color: var(--gray-500);
            border-top: 1px solid var(--gray-200);
        }
        .auth-footer a { color: var(--primary); font-weight: 700; }

        .alert {
            padding: 0.875rem 1.25rem; border-radius: var(--radius);
            margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.75rem;
            font-size: 0.875rem; font-weight: 500;
        }
        .alert-danger { background: rgba(220,38,38,0.08); color: #dc2626; border: 1px solid rgba(220,38,38,0.2); }
        .alert-success { background: rgba(5,150,105,0.08); color: #059669; border: 1px solid rgba(5,150,105,0.2); }

        .password-strength {
            height: 4px; border-radius: 2px; background: var(--gray-200);
            margin-top: 0.5rem; overflow: hidden;
        }
        .password-strength-bar { height: 100%; width: 0; transition: all 0.3s; border-radius: 2px; }

        .lang-switch {
            position: absolute; top: 1.5rem; z-index: 10;
            <?= $dir === 'rtl' ? 'left: 1.5rem;' : 'right: 1.5rem;' ?>
        }
        .lang-switcher { display: flex; gap: 0.25rem; background: rgba(255,255,255,0.12); padding: 0.25rem; border-radius: 50px; }
        .lang-btn { padding: 0.4rem 0.8rem; border-radius: 50px; font-size: 0.8rem; font-weight: 600; color: rgba(255,255,255,0.7); border: none; background: transparent; cursor: pointer; font-family: inherit; }
        .lang-btn.active { background: var(--white); color: var(--primary); }
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
                <div class="auth-logo">
                    <i class="fas fa-lock-open"></i>
                </div>
                <h1 class="auth-title"><?= lang('reset_password') ?? 'إعادة تعيين كلمة المرور' ?></h1>
                <p class="auth-subtitle"><?= lang('reset_password_desc') ?? 'أدخل كلمة المرور الجديدة' ?></p>
            </div>

            <div class="auth-body">
                <?= $this->messages() ?>

                <form method="POST" action="<?= url('/reset-password') ?>">
                    <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
                    <input type="hidden" name="token" value="<?= e($token) ?>">

                    <div class="form-group">
                        <label class="form-label"><?= lang('new_password') ?? 'كلمة المرور الجديدة' ?></label>
                        <input type="password" name="password" id="passwordInput" class="form-control" required
                               placeholder="<?= lang('new_password_placeholder') ?? 'أدخل كلمة المرور الجديدة'" minlength="6">
                        <div class="password-strength">
                            <div class="password-strength-bar" id="strengthBar"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><?= lang('confirm_password') ?? 'تأكيد كلمة المرور' ?></label>
                        <input type="password" name="confirm_password" class="form-control" required
                               placeholder="<?= lang('confirm_password_placeholder') ?? 'أعد إدخال كلمة المرور'" minlength="6">
                    </div>

                    <button type="submit" class="btn-primary-grad">
                        <i class="fas fa-check"></i>
                        <?= lang('update_password') ?? 'تحديث كلمة المرور' ?>
                    </button>
                </form>
            </div>

            <div class="auth-footer">
                <a href="<?= url('/login') ?>">
                    <i class="fas fa-arrow-<?= $dir === 'rtl' ? 'right' : 'left' ?>"></i>
                    <?= lang('back_to_login') ?? 'العودة لتسجيل الدخول' ?>
                </a>
            </div>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('passwordInput');
        const strengthBar = document.getElementById('strengthBar');

        if (passwordInput && strengthBar) {
            passwordInput.addEventListener('input', function() {
                const val = this.value;
                let strength = 0;
                if (val.length >= 6) strength++;
                if (val.length >= 10) strength++;
                if (/[A-Z]/.test(val)) strength++;
                if (/[0-9]/.test(val)) strength++;
                if (/[^A-Za-z0-9]/.test(val)) strength++;

                const percent = Math.min((strength / 5) * 100, 100);
                let color = '#dc2626';
                if (strength >= 4) color = '#059669';
                else if (strength >= 3) color = '#d97706';
                else if (strength >= 2) color = '#2563eb';

                strengthBar.style.width = percent + '%';
                strengthBar.style.background = color;
            });
        }
    </script>
</body>
</html>

<?php
/**
 * Forgot Password View
 * صفحة نسيت كلمة المرور
 */

$lang = Language::current();
$dir = Language::direction();
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= lang('forgot_password') ?> - <?= SITE_NAME ?></title>

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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 30%, #4338ca 60%, #6d28d9 100%);
            position: relative;
        }

        .auth-card {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            overflow: hidden;
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
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

        .back-link {
            display: inline-flex; align-items: center; gap: 0.5rem;
            color: var(--gray-500); font-size: 0.875rem; margin-bottom: 1.5rem;
            transition: var(--transition);
        }
        .back-link:hover { color: var(--primary); }

        /* CAPTCHA Styles */
        .captcha-group .form-label i { color: var(--primary); margin-inline-end: 0.35rem; }
        .captcha-box { display: flex; flex-direction: column; gap: 0.5rem; }
        .captcha-question {
            display: flex; align-items: center; justify-content: space-between;
            background: linear-gradient(135deg, #f0f0ff, #e8e8ff);
            border: 1.5px solid var(--gray-200); border-radius: var(--radius);
            padding: 0.75rem 1rem; gap: 0.75rem;
        }
        .captcha-text { font-size: 1.25rem; font-weight: 800; color: var(--dark); letter-spacing: 1px; direction: ltr; user-select: none; }
        .captcha-refresh {
            background: none; border: none; color: var(--primary); cursor: pointer; font-size: 1rem;
            padding: 0.3rem; border-radius: 50%; transition: var(--transition);
            display: flex; align-items: center; justify-content: center; min-width: 32px; min-height: 32px;
        }
        .captcha-refresh:hover { background: rgba(79, 70, 229, 0.1); color: var(--secondary); }
        .captcha-refresh.spinning i { animation: spin 0.5s ease; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .captcha-input { text-align: center; font-size: 1.1rem !important; font-weight: 700 !important; letter-spacing: 2px; }
        .captcha-input::-webkit-inner-spin-button, .captcha-input::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
        .captcha-input[type=number] { -moz-appearance: textfield; }

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
                    <i class="fas fa-key"></i>
                </div>
                <h1 class="auth-title"><?= lang('forgot_password') ?? 'نسيت كلمة المرور؟' ?></h1>
                <p class="auth-subtitle"><?= lang('forgot_password_desc') ?? 'أدخل بريدك الإلكتروني وسنرسل لك رابط الاستعادة' ?></p>
            </div>

            <div class="auth-body">
                <?= $this->messages() ?>

                <form method="POST" action="<?= url('/forgot-password') ?>">
                    <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">

                    <div class="form-group">
                        <label class="form-label"><?= lang('email') ?></label>
                        <input type="email" name="email" class="form-control" required
                               placeholder="<?= lang('email_placeholder') ?? 'أدخل بريدك الإلكتروني' ?>" autofocus>
                    </div>

                    <?php
                    $captchaData = $captcha ?? null;
                    if ($captchaData):
                    ?>
                    <div class="form-group captcha-group">
                        <label class="form-label"><i class="fas fa-shield-alt"></i> مسألة الأمان (لمنع الروبوتات)</label>
                        <div class="captcha-box">
                            <div class="captcha-question">
                                <span class="captcha-text"><?= e($captchaData['question']) ?></span>
                                <button type="button" class="captcha-refresh" id="refreshCaptcha" title="مسألة جديدة">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                            <input type="number" name="captcha_answer" class="form-control captcha-input" required
                                   placeholder="أدخل الإجابة" autocomplete="off" min="0" max="999">
                        </div>
                    </div>
                    <?php endif; ?>

                    <button type="submit" class="btn-primary-grad">
                        <i class="fas fa-paper-plane"></i>
                        <?= lang('send_reset_link') ?? 'إرسال رابط الاستعادة' ?>
                    </button>
                </form>
            </div>

            <div class="auth-footer">
                <a href="<?= url('/login') ?>" class="back-link" style="color: var(--primary);">
                    <i class="fas fa-arrow-<?= $dir === 'rtl' ? 'right' : 'left' ?>"></i>
                    <?= lang('back_to_login') ?? 'العودة لتسجيل الدخول' ?>
                </a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('refreshCaptcha').addEventListener('click', function() {
            var btn = this;
            btn.classList.add('spinning');
            setTimeout(function() { btn.classList.remove('spinning'); }, 500);
            fetch('<?= url("/captcha/refresh") ?>')
                .then(function(response) { return response.json(); })
                .then(function(data) {
                    if (data.question) {
                        document.querySelector('.captcha-text').textContent = data.question;
                        var input = document.querySelector('.captcha-input');
                        input.value = '';
                        input.focus();
                    }
                })
                .catch(function() {});
        });
    </script>
</body>
</html>

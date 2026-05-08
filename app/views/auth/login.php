<?php
/**
 * Login View
 * صفحة تسجيل الدخول
 */

$lang = Language::current();
$dir = Language::direction();
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= lang('login') ?> - <?= SITE_NAME ?></title>

    <!-- Google Fonts - Cairo -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* ==================== Variables ==================== */
        :root {
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --secondary: #7c3aed;
            --accent: #a78bfa;
            --success: #059669;
            --danger: #dc2626;
            --dark: #1e293b;
            --white: #ffffff;
            --light: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gradient: linear-gradient(135deg, #4f46e5, #7c3aed);
            --radius: 0.75rem;
            --radius-lg: 1rem;
            --shadow-lg: 0 20px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1);
            --shadow-xl: 0 25px 50px -12px rgba(0,0,0,0.25);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        *, *::before, *::after {
            margin: 0; padding: 0; box-sizing: border-box;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Cairo', sans-serif;
            background: var(--light);
            color: var(--dark);
            line-height: 1.7;
            min-height: 100vh;
        }

        a { text-decoration: none; }

        /* ==================== Auth Container ==================== */
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 30%, #4338ca 60%, #6d28d9 100%);
        }

        .auth-container::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background:
                radial-gradient(ellipse at 20% 80%, rgba(124, 58, 237, 0.3) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(79, 70, 229, 0.4) 0%, transparent 50%);
            pointer-events: none;
        }

        /* ==================== Auth Card ==================== */
        .auth-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
            animation: fadeInUp 0.5s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ==================== Header ==================== */
        .auth-header {
            padding: 2.5rem 2rem 1.5rem;
            text-align: center;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.04), rgba(124, 58, 237, 0.04));
            border-bottom: 1px solid var(--gray-200);
        }

        .auth-logo {
            width: 72px;
            height: 72px;
            background: var(--gradient);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            color: var(--white);
            font-size: 1.75rem;
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.35);
            transition: var(--transition);
        }

        .auth-logo:hover {
            transform: translateY(-3px) scale(1.05);
        }

        .auth-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }

        .auth-subtitle {
            color: var(--gray-500);
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* ==================== Body ==================== */
        .auth-body {
            padding: 2rem;
        }

        /* ==================== Form Styles ==================== */
        .form-group {
            margin-bottom: 1.25rem;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark);
            font-size: 0.875rem;
        }

        .input-icon-wrapper {
            position: relative;
        }

        .input-icon-wrapper .input-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            font-size: 0.95rem;
            pointer-events: none;
            transition: var(--transition);
        }

        [dir="rtl"] .input-icon-wrapper .input-icon {
            right: 1rem;
        }

        [dir="ltr"] .input-icon-wrapper .input-icon {
            left: 1rem;
        }

        .input-icon-wrapper .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1.5px solid var(--gray-200);
            border-radius: var(--radius);
            font-size: 0.9rem;
            transition: var(--transition);
            font-family: inherit;
            background: var(--white);
            color: var(--dark);
            outline: none;
        }

        [dir="rtl"] .input-icon-wrapper .form-control {
            padding-right: 2.75rem;
        }

        [dir="ltr"] .input-icon-wrapper .form-control {
            padding-left: 2.75rem;
        }

        .input-icon-wrapper .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        }

        .input-icon-wrapper .form-control:focus + .input-icon,
        .input-icon-wrapper .form-control:focus ~ .input-icon {
            color: var(--primary);
        }

        .input-icon-wrapper .form-control::placeholder {
            color: var(--gray-400);
        }

        /* Toggle password */
        .password-toggle {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray-400);
            cursor: pointer;
            font-size: 0.95rem;
            padding: 0.25rem;
            transition: var(--transition);
        }

        [dir="rtl"] .password-toggle {
            left: 1rem;
        }

        [dir="ltr"] .password-toggle {
            right: 1rem;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        /* Remember/Forgot Row */
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            font-size: 0.875rem;
            color: var(--gray-600);
            user-select: none;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .forgot-link {
            font-size: 0.875rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .forgot-link:hover {
            color: var(--secondary);
        }

        /* Submit Button */
        .btn-primary-grad {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.85rem 1.5rem;
            background: var(--gradient);
            color: var(--white);
            border: none;
            border-radius: var(--radius);
            font-weight: 700;
            font-size: 1rem;
            font-family: inherit;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.35);
        }

        .btn-primary-grad:hover {
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.45);
            transform: translateY(-2px);
        }

        .btn-primary-grad:active {
            transform: translateY(0);
        }

        /* ==================== Social Login Divider ==================== */
        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.75rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--gray-200);
        }

        .divider span {
            font-size: 0.8rem;
            color: var(--gray-500);
            font-weight: 500;
            white-space: nowrap;
        }

        /* Social Buttons */
        .social-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .btn-social {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.7rem 1rem;
            border: 1.5px solid var(--gray-200);
            border-radius: var(--radius);
            background: var(--white);
            font-size: 0.85rem;
            font-weight: 600;
            font-family: inherit;
            color: var(--dark);
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-social:hover {
            border-color: var(--gray-400);
            background: var(--gray-100);
            transform: translateY(-1px);
        }

        .btn-social i {
            font-size: 1.1rem;
        }

        .btn-social.google i { color: #ea4335; }
        .btn-social.apple i { color: #000; }
        .btn-social.twitter i { color: #1da1f2; }
        .btn-social.github i { color: #333; }

        /* ==================== Footer ==================== */
        .auth-footer {
            padding: 1.5rem 2rem;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.03), rgba(124, 58, 237, 0.03));
            text-align: center;
            font-size: 0.875rem;
            color: var(--gray-500);
            border-top: 1px solid var(--gray-200);
        }

        .auth-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
            transition: var(--transition);
        }

        .auth-footer a:hover {
            color: var(--secondary);
        }

        /* ==================== Language Switch ==================== */
        .lang-switch {
            position: absolute;
            top: 1.5rem;
            z-index: 10;
            <?= $dir === 'rtl' ? 'left: 1.5rem;' : 'right: 1.5rem;' ?>
        }

        .lang-switcher {
            display: flex;
            gap: 0.25rem;
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(10px);
            padding: 0.25rem;
            border-radius: 50px;
        }

        .lang-btn {
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            color: rgba(255,255,255,0.7);
            transition: var(--transition);
            cursor: pointer;
            border: none;
            background: transparent;
            font-family: inherit;
        }

        .lang-btn.active {
            background: var(--white);
            color: var(--primary);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* ==================== Alert Messages Override ==================== */
        .alert {
            padding: 0.875rem 1.25rem;
            border-radius: var(--radius);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
            animation: fadeInUp 0.3s ease-out;
        }

        .alert-success {
            background: rgba(5, 150, 105, 0.08);
            color: #059669;
            border: 1px solid rgba(5, 150, 105, 0.2);
        }

        .alert-danger {
            background: rgba(220, 38, 38, 0.08);
            color: #dc2626;
            border: 1px solid rgba(220, 38, 38, 0.2);
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.08);
            color: #d97706;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .alert-info {
            background: rgba(59, 130, 246, 0.08);
            color: #2563eb;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        /* ==================== Responsive ==================== */
        @media (max-width: 480px) {
            .auth-card { max-width: 100%; }
            .auth-header { padding: 2rem 1.5rem 1.25rem; }
            .auth-body { padding: 1.5rem; }
            .auth-footer { padding: 1.25rem 1.5rem; }
            .auth-logo { width: 64px; height: 64px; font-size: 1.5rem; }
            .auth-title { font-size: 1.3rem; }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <!-- Language Switcher -->
        <div class="lang-switch">
            <div class="lang-switcher">
                <a href="<?= url('/lang/ar') ?>" class="lang-btn <?= $lang === 'ar' ? 'active' : '' ?>">عربي</a>
                <a href="<?= url('/lang/en') ?>" class="lang-btn <?= $lang === 'en' ? 'active' : '' ?>">EN</a>
            </div>
        </div>

        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">
                    <i class="fas fa-cube"></i>
                </div>
                <h1 class="auth-title"><?= SITE_NAME ?></h1>
                <p class="auth-subtitle"><?= lang('login') ?></p>
            </div>

            <div class="auth-body">
                <?= $this->messages() ?>

                <form method="POST" action="<?= url('/login') ?>">
                    <?= $this->csrf() ?>

                    <div class="form-group">
                        <label class="form-label"><?= lang('email') ?></label>
                        <div class="input-icon-wrapper">
                            <input type="email" name="email" class="form-control" required
                                   placeholder="<?= lang('email') ?>" autofocus>
                            <i class="fas fa-envelope input-icon"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><?= lang('password') ?></label>
                        <div class="input-icon-wrapper">
                            <input type="password" name="password" id="passwordInput" class="form-control" required
                                   placeholder="<?= lang('password') ?>">
                            <i class="fas fa-lock input-icon"></i>
                            <button type="button" class="password-toggle" id="togglePassword" aria-label="Toggle password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="remember-forgot">
                        <label class="remember-me">
                            <input type="checkbox" name="remember">
                            <span><?= lang('remember_me') ?></span>
                        </label>
                        <a href="<?= url('/forgot-password') ?>" class="forgot-link">
                            <?= lang('forgot_password') ?>
                        </a>
                    </div>

                    <button type="submit" class="btn-primary-grad">
                        <i class="fas fa-sign-in-alt"></i>
                        <?= lang('login') ?>
                    </button>
                </form>

                <!-- Social Login -->
                <div class="divider">
                    <span><?= lang('or_login_with') ?? 'أو سجل الدخول بواسطة' ?></span>
                </div>

                <div class="social-buttons">
                    <button type="button" class="btn-social google" disabled>
                        <i class="fab fa-google"></i>
                        Google
                    </button>
                    <button type="button" class="btn-social apple" disabled>
                        <i class="fab fa-apple"></i>
                        Apple
                    </button>
                </div>
            </div>

            <div class="auth-footer">
                <?= lang('no_account') ?>
                <a href="<?= url('/register') ?>"><?= lang('register') ?></a>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const input = document.getElementById('passwordInput');
            const icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>

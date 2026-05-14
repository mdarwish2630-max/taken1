<?php
/**
 * Admin Dashboard Layout
 * قالب لوحة تحكم المدير
 */

$lang = Language::current();
$dir = Language::direction();
$user = Auth::user();
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= Security::generateCsrfToken() ?>">
    <title><?= $title ?? lang('admin_dashboard') ?> - <?= SITE_NAME ?></title>

    <!-- Google Fonts - Readex Pro -->
    <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap 5 RTL -->
    <?php if ($dir === 'rtl'): ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    <?php else: ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <?php endif; ?>

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">

    <style>
        /* ==================== Admin Dark Sidebar ==================== */
        .sidebar {
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            border-inline-end: none;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
        }

        [dir="rtl"] .sidebar {
            box-shadow: -4px 0 15px rgba(0,0,0,0.1);
        }

        /* Dark sidebar header */
        .sidebar-header {
            background: linear-gradient(135deg, #3730a3, #4f46e5);
            padding: 1.75rem 1.25rem;
            position: relative;
            overflow: hidden;
        }

        .sidebar-header::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: -5%;
            right: -5%;
            height: 30px;
            background: #1e293b;
            border-radius: 50% 50% 0 0;
        }

        .sidebar-header .sidebar-logo {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            color: #ffffff;
        }

        .sidebar-header .sidebar-title {
            color: #ffffff;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }

        /* Admin user card */
        .sidebar-user-card {
            margin: 0.5rem 0.75rem 0.75rem;
            padding: 1rem;
            background: rgba(255,255,255,0.05);
            border-radius: var(--radius);
            text-align: center;
            border: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0 auto 0.5rem;
            box-shadow: 0 4px 12px rgba(79,70,229,0.3);
        }

        .sidebar-user-name {
            font-weight: 700;
            font-size: 0.9rem;
            color: #ffffff;
            margin-bottom: 0.125rem;
        }

        .sidebar-user-role {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.5);
        }

        /* Dark nav sections */
        .nav-section-title {
            color: rgba(255,255,255,0.35);
            letter-spacing: 0.08em;
        }

        /* Dark nav items */
        .nav-item {
            color: rgba(255,255,255,0.65);
            border-radius: var(--radius);
            margin-bottom: 2px;
        }

        .nav-item i {
            color: rgba(255,255,255,0.4);
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.08);
            color: #ffffff;
        }

        .nav-item:hover i {
            color: #ffffff;
        }

        .nav-item.active {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(79,70,229,0.4);
        }

        .nav-item.active i {
            color: #ffffff !important;
        }

        .nav-item.active::before {
            display: none;
        }

        .nav-item.text-danger {
            color: rgba(248,113,113,0.8);
        }

        .nav-item.text-danger i {
            color: rgba(248,113,113,0.7);
        }

        .nav-item.text-danger:hover {
            background: rgba(239,68,68,0.12);
            color: #f87171;
        }

        /* Admin badge */
        .admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            background: rgba(245,158,11,0.15);
            color: #fbbf24;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        /* Top Header Enhancements */
        .top-header {
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .header-actions .notification-btn {
            position: relative;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--light);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark);
            cursor: pointer;
            transition: var(--transition);
            font-size: 1rem;
        }

        .header-actions .notification-btn:hover {
            background: rgba(79,70,229,0.08);
            color: var(--primary);
        }

        .header-actions .notification-badge {
            position: absolute;
            top: 6px;
            <?= $dir === 'rtl' ? 'left: 6px;' : 'right: 6px;' ?>
            width: 8px;
            height: 8px;
            background: var(--danger);
            border-radius: 50%;
            border: 2px solid var(--white);
        }

        /* User menu with dropdown */
        .user-menu-wrapper {
            position: relative;
        }

        .user-menu .user-avatar {
            background: var(--gradient);
        }

        .user-dropdown {
            position: absolute;
            top: calc(100% + 0.5rem);
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15);
            border: 1px solid var(--border);
            min-width: 200px;
            padding: 0.5rem;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: all 0.2s ease;
            z-index: 200;
            <?= $dir === 'rtl' ? 'left: 0;' : 'right: 0;' ?>
        }

        .user-dropdown.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .user-dropdown a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 0.75rem;
            color: var(--dark);
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: var(--transition);
            font-weight: 500;
        }

        .user-dropdown a:hover {
            background: var(--light);
            color: var(--primary);
        }

        .user-dropdown a.text-danger {
            color: var(--danger);
        }

        .user-dropdown a.text-danger:hover {
            background: rgba(220,38,38,0.06);
        }

        .user-dropdown hr {
            border: none;
            border-top: 1px solid var(--border);
            margin: 0.375rem 0;
        }

        /* Sidebar overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 90;
            backdrop-filter: blur(4px);
            transition: var(--transition);
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* Sidebar mobile toggle button */
        .sidebar-toggle-btn {
            display: none;
            width: 40px;
            height: 40px;
            border-radius: var(--radius);
            background: var(--light);
            border: 1px solid var(--border);
            align-items: center;
            justify-content: center;
            color: var(--dark);
            cursor: pointer;
            font-size: 1rem;
            transition: var(--transition);
        }

        .sidebar-toggle-btn:hover {
            background: rgba(79,70,229,0.08);
            color: var(--primary);
            border-color: var(--primary);
        }

        @media (max-width: 768px) {
            .sidebar-toggle-btn {
                display: flex;
            }
        }

        /* Content area */
        .content-area {
            background: var(--light);
            min-height: calc(100vh - 60px);
        }

        /* Sidebar scrollbar */
        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.1);
            border-radius: 4px;
        }

        @keyframes pulse-badge {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }
    </style>
</head>
<body>
    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <span class="sidebar-title"><?= lang('admin_panel') ?? 'لوحة تحكم المدير' ?></span>
            </div>

            <!-- User Card in Sidebar -->
            <div class="sidebar-user-card">
                <div class="sidebar-user-avatar">
                    <?= htmlspecialchars(mb_substr($user->full_name ?? 'م', 0, 1), ENT_QUOTES, 'UTF-8') ?>
                </div>
                <div class="admin-badge">
                    <i class="fas fa-crown"></i>
                    <?= lang('admin') ?? 'مدير النظام' ?>
                </div>
                <div class="sidebar-user-name"><?= htmlspecialchars($user->full_name ?? 'مدير النظام', ENT_QUOTES, 'UTF-8') ?></div>
                <div class="sidebar-user-role"><?= lang('super_admin') ?? 'مدير عام' ?></div>
            </div>

            <nav class="sidebar-nav">
                <!-- Main Section -->
                <div class="nav-section">
                    <span class="nav-section-title"><?= lang('dashboard') ?? 'لوحة التحكم' ?></span>
                </div>

                <a href="<?= url('/admin') ?>" class="nav-item <?= Router::is('/admin') && !Router::is('/admin/') ? 'active' : '' ?>">
                    <i class="fas fa-tachometer-alt"></i>
                    <span><?= lang('admin_dashboard') ?? 'لوحة تحكم المدير' ?></span>
                </a>

                <!-- Management Section -->
                <div class="nav-section" style="margin-top: 1rem;">
                    <span class="nav-section-title"><?= lang('management') ?? 'الإدارة' ?></span>
                </div>

                <a href="<?= url('/admin/users') ?>" class="nav-item <?= Router::is('/admin/users') ? 'active' : '' ?>">
                    <i class="fas fa-users"></i>
                    <span><?= lang('users') ?? 'المستخدمين' ?></span>
                </a>

                <a href="<?= url('/admin/sites') ?>" class="nav-item <?= Router::is('/admin/sites') ? 'active' : '' ?>">
                    <i class="fas fa-globe"></i>
                    <span><?= lang('sites') ?? 'المواقع' ?></span>
                </a>

                <a href="<?= url('/admin/blog') ?>" class="nav-item <?= Router::is('/admin/blog') ? 'active' : '' ?>">
                    <i class="fas fa-newspaper"></i>
                    <span>المدونة</span>
                </a>

                <a href="<?= url('/admin/subscriptions') ?>" class="nav-item <?= Router::is('/admin/subscriptions') ? 'active' : '' ?>">
                    <i class="fas fa-credit-card"></i>
                    <span><?= lang('subscriptions') ?? 'الاشتراكات' ?></span>
                </a>

                <?php
                $pendingSubRequestsCount = 0;
                try {
                    $pendingSubRequestsCount = Database::getInstance()->query(
                        "SELECT COUNT(*) as c FROM subscription_requests WHERE status = 'pending'"
                    )->first()->c ?? 0;
                } catch(\Exception $e) {}
                ?>
                <a href="<?= url('/admin/subscription-requests') ?>" class="nav-item <?= Router::is('/admin/subscription-requests') ? 'active' : '' ?>" style="position: relative;">
                    <i class="fas fa-paper-plane"></i>
                    <span><?= lang('subscription_requests') ?? 'طلبات الاشتراك' ?></span>
                    <?php if ($pendingSubRequestsCount > 0): ?>
                    <span style="position: absolute; <?= $dir === 'rtl' ? 'left: 8px;' : 'right: 8px;' ?> top: 50%; transform: translateY(-50%); background: var(--danger); color: white; font-size: 0.65rem; font-weight: 700; padding: 1px 6px; border-radius: 20px; min-width: 18px; text-align: center; line-height: 1.4; animation: pulse-badge 2s infinite;">
                        <?= $pendingSubRequestsCount ?>
                    </span>
                    <?php endif; ?>
                </a>

                <a href="<?= url('/admin/plans') ?>" class="nav-item <?= Router::is('/admin/plans') ? 'active' : '' ?>">
                    <i class="fas fa-tags"></i>
                    <span><?= lang('subscription_plans') ?? 'خطط الاشتراك' ?></span>
                </a>

                <a href="<?= url('/admin/themes') ?>" class="nav-item <?= Router::is('/admin/themes') ? 'active' : '' ?>">
                    <i class="fas fa-palette"></i>
                    <span><?= lang('themes') ?? 'القوالب' ?></span>
                </a>

                <?php
                $pendingThemeRequestsCount = 0;
                try {
                    require_once ROOT_PATH . '/app/models/ThemeRequest.php';
                    $themeRequestModel = new ThemeRequest();
                    $pendingThemeRequestsCount = $themeRequestModel->countByStatus('pending');
                } catch(\Exception $e) {}
                ?>
                <a href="<?= url('/admin/theme-requests') ?>" class="nav-item <?= Router::is('/admin/theme-requests') ? 'active' : '' ?>" style="position: relative;">
                    <i class="fas fa-crown"></i>
                    <span>طلبات الثيمات</span>
                    <?php if ($pendingThemeRequestsCount > 0): ?>
                    <span style="position: absolute; <?= $dir === 'rtl' ? 'left: 8px;' : 'right: 8px;' ?> top: 50%; transform: translateY(-50%); background: var(--danger); color: white; font-size: 0.65rem; font-weight: 700; padding: 1px 6px; border-radius: 20px; min-width: 18px; text-align: center; line-height: 1.4; animation: pulse-badge 2s infinite;">
                        <?= $pendingThemeRequestsCount ?>
                    </span>
                    <?php endif; ?>
                </a>

                <!-- Services Store Section -->
                <div class="nav-section" style="margin-top: 1rem;">
                    <span class="nav-section-title">متجر الخدمات</span>
                </div>

                <a href="<?= url('/admin/services-store') ?>" class="nav-item <?= Router::is('/admin/services-store') ? 'active' : '' ?>">
                    <i class="fas fa-store"></i>
                    <span>الخدمات المدفوعة</span>
                </a>

                <?php
                $pendingPurchasesCount = 0;
                try {
                    $purchaseModel = new \TenantPurchase();
                    $pendingPurchasesCount = $purchaseModel->countByStatus('pending');
                } catch(\Exception $e) {}
                ?>
                <a href="<?= url('/admin/purchases') ?>" class="nav-item <?= Router::is('/admin/purchases') ? 'active' : '' ?>" style="position: relative;">
                    <i class="fas fa-shopping-bag"></i>
                    <span>المشتريات</span>
                    <?php if ($pendingPurchasesCount > 0): ?>
                    <span style="position: absolute; <?= $dir === 'rtl' ? 'left: 8px;' : 'right: 8px;' ?> top: 50%; transform: translateY(-50%); background: var(--danger); color: white; font-size: 0.65rem; font-weight: 700; padding: 1px 6px; border-radius: 20px; min-width: 18px; text-align: center; line-height: 1.4;">
                        <?= $pendingPurchasesCount ?>
                    </span>
                    <?php endif; ?>
                </a>

                <!-- System Section -->
                <div class="nav-section" style="margin-top: 1rem;">
                    <span class="nav-section-title"><?= lang('system') ?? 'النظام' ?></span>
                </div>

                <a href="<?= url('/admin/email-settings') ?>" class="nav-item <?= Router::is('/admin/email-settings') ? 'active' : '' ?>">
                    <i class="fas fa-envelope"></i>
                    <span>إعدادات البريد (SMTP)</span>
                </a>

                <a href="<?= url('/admin/analytics') ?>" class="nav-item <?= Router::is('/admin/analytics') ? 'active' : '' ?>">
                    <i class="fas fa-chart-bar"></i>
                    <span><?= lang('analytics') ?? 'الإحصائيات' ?></span>
                </a>

                <a href="<?= url('/admin/site-settings') ?>" class="nav-item <?= Router::is('/admin/site-settings') ? 'active' : '' ?>">
                    <i class="fas fa-cog"></i>
                    <span><?= lang('site_settings') ?? 'إعدادات الموقع' ?></span>
                </a>

                <a href="<?= url('/admin/settings') ?>" class="nav-item <?= Router::is('/admin/settings') ? 'active' : '' ?>">
                    <i class="fas fa-sliders-h"></i>
                    <span><?= lang('system_settings') ?? 'إعدادات النظام' ?></span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Header -->
            <header class="top-header">
                <div class="d-flex align-center gap-3">
                    <button class="sidebar-toggle-btn" id="toggleSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="page-title"><?= $title ?? lang('admin_dashboard') ?></h1>
                </div>

                <div class="header-actions">
                    <!-- Language Switcher -->
                    <div class="lang-switcher">
                        <a href="<?= url('/lang/ar') ?>" class="lang-btn <?= $lang === 'ar' ? 'active' : '' ?>">عربي</a>
                        <a href="<?= url('/lang/en') ?>" class="lang-btn <?= $lang === 'en' ? 'active' : '' ?>">EN</a>
                    </div>

                    <!-- Notification Bell -->
                    <?php $totalPendingNotifications = $pendingPurchasesCount + $pendingThemeRequestsCount + $pendingSubRequestsCount; ?>
                    <?php if ($totalPendingNotifications > 0): ?>
                    <a href="<?= $pendingThemeRequestsCount > 0 ? url('/admin/theme-requests?status=pending') : url('/admin/purchases?status=pending') ?>" class="notification-btn" title="<?= $totalPendingNotifications ?> طلب جديد بانتظار المراجعة" style="position: relative; text-decoration: none;">
                        <i class="fas fa-bell"></i>
                        <span style="position: absolute; top: 4px; <?= $dir === 'rtl' ? 'left: 4px;' : 'right: 4px;' ?> background: var(--danger); color: white; font-size: 0.6rem; font-weight: 700; padding: 0 5px; border-radius: 20px; min-width: 16px; text-align: center; line-height: 1.5; border: 2px solid white; animation: pulse-badge 2s infinite;"><?= $totalPendingNotifications ?></span>
                    </a>
                    <?php else: ?>
                    <button class="notification-btn" title="<?= lang('notifications') ?? 'الإشعارات' ?>">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge" style="display: none;"></span>
                    </button>
                    <?php endif; ?>

                    <!-- User Menu -->
                    <div class="user-menu-wrapper">
                        <div class="user-menu" id="userMenu">
                            <div class="user-avatar">
                                <?= htmlspecialchars(mb_substr($user->full_name ?? 'م', 0, 1), ENT_QUOTES, 'UTF-8') ?>
                            </div>
                            <div class="user-info">
                                <div class="user-name"><?= htmlspecialchars($user->full_name ?? 'مدير النظام', ENT_QUOTES, 'UTF-8') ?></div>
                                <div class="user-role"><?= lang('admin') ?? 'مدير' ?></div>
                            </div>
                            <i class="fas fa-chevron-down" style="color: #94a3b8; font-size: 0.7rem;"></i>
                        </div>

                        <!-- Dropdown -->
                        <div class="user-dropdown" id="userDropdown">
                            <a href="<?= url('/admin/site-settings') ?>">
                                <i class="fas fa-cog" style="color: #64748b;"></i>
                                <?= lang('system_settings') ?? 'إعدادات النظام' ?>
                            </a>
                            <a href="<?= url('/logout') ?>" class="text-danger">
                                <i class="fas fa-sign-out-alt"></i>
                                <?= lang('logout') ?? 'تسجيل الخروج' ?>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                <!-- Flash Messages -->
                <?= $this->messages() ?>

                <!-- Page Content -->
                <?= $yieldContent ?? '' ?>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= asset('js/app.js') ?>"></script>

    <script>
        $(document).ready(function() {
            // Sidebar toggle (mobile)
            $('#toggleSidebar').on('click', function() {
                $('#sidebar').toggleClass('open');
                $('#sidebarOverlay').toggleClass('active');
            });

            // Close sidebar on overlay click
            $('#sidebarOverlay').on('click', function() {
                $('#sidebar').removeClass('open');
                $(this).removeClass('active');
            });

            // Close sidebar on nav link click (mobile)
            $('#sidebar .nav-item').on('click', function() {
                if ($(window).width() <= 768) {
                    $('#sidebar').removeClass('open');
                    $('#sidebarOverlay').removeClass('active');
                }
            });

            // User menu dropdown
            $('#userMenu').on('click', function(e) {
                e.stopPropagation();
                $('#userDropdown').toggleClass('active');
            });

            // Close dropdown on outside click
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.user-menu-wrapper').length) {
                    $('#userDropdown').removeClass('active');
                }
            });
        });
    </script>

    <!-- Page Scripts -->
    <?php if (isset($scripts)): ?>
        <?= $scripts ?>
    <?php endif; ?>
</body>
</html>

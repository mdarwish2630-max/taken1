<?php
/**
 * Dashboard Layout
 * قالب لوحة التحكم
 */

$tenant = Auth::tenant();
$lang = Language::current();
$dir = Language::direction();
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= Security::generateCsrfToken() ?>">
    <title><?= $title ?? lang('dashboard') ?> - <?= SITE_NAME ?></title>

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

    <?php if ($tenant): ?>
    <!-- Dynamic Colors -->
    <style>
        :root {
            --primary: <?= $tenant->primary_color ?: '#4f46e5' ?>;
            --primary-dark: <?= $tenant->secondary_color ?: '#3730a3' ?>;
            --gradient: linear-gradient(135deg, <?= $tenant->primary_color ?: '#4f46e5' ?>, <?= $tenant->secondary_color ?: '#7c3aed' ?>);
        }
    </style>
    <?php endif; ?>

    <style>
        /* ==================== Dashboard Layout Overrides ==================== */

        /* Sidebar gradient header curve */
        .sidebar-header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
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
            background: var(--white);
            border-radius: 50% 50% 0 0;
        }

        .sidebar-header .sidebar-logo {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
        }

        .sidebar-header .sidebar-title {
            color: #ffffff;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }

        /* Sidebar user card */
        .sidebar-user-card {
            margin: 0.5rem 0.75rem 0.75rem;
            padding: 1rem;
            background: linear-gradient(135deg, rgba(79,70,229,0.06), rgba(124,58,237,0.06));
            border-radius: var(--radius);
            text-align: center;
            border: 1px solid rgba(79,70,229,0.1);
        }

        .sidebar-user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0 auto 0.5rem;
            box-shadow: 0 4px 12px rgba(79,70,229,0.25);
        }

        .sidebar-user-name {
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--dark);
            margin-bottom: 0.125rem;
        }

        .sidebar-user-role {
            font-size: 0.75rem;
            color: #64748b;
        }

        /* Active nav item override */
        .nav-item.active {
            background: var(--gradient);
            color: var(--white) !important;
            box-shadow: 0 4px 12px rgba(79,70,229,0.3);
        }

        .nav-item.active i {
            color: var(--white) !important;
        }

        .nav-item.active::before {
            display: none;
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

        .user-menu.open + .user-dropdown,
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

        /* Content area subtle background */
        .content-area {
            background: var(--light);
            min-height: calc(100vh - 60px);
        }

        /* Scrollbar in sidebar */
        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 4px;
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
                    <?php if ($tenant && $tenant->logo): ?>
                        <img src="<?= upload($tenant->logo) ?>" alt="<?= $tenant->site_name ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: inherit;">
                    <?php else: ?>
                        <i class="fas fa-cube"></i>
                    <?php endif; ?>
                </div>
                <span class="sidebar-title"><?= $tenant ? $tenant->site_name : SITE_NAME ?></span>
            </div>

            <!-- User Card in Sidebar -->
            <div class="sidebar-user-card">
                <div class="sidebar-user-avatar">
                    <?= mb_substr(Auth::user()->full_name, 0, 1) ?>
                </div>
                <div class="sidebar-user-name"><?= Auth::user()->full_name ?></div>
                <div class="sidebar-user-role"><?= Auth::isAdmin() ? lang('admin_panel') : lang('dashboard') ?></div>
            </div>

            <nav class="sidebar-nav">
                <!-- Main Section -->
                <div class="nav-section">
                    <span class="nav-section-title"><?= lang('dashboard') ?></span>
                </div>

                <a href="<?= url('/dashboard') ?>" class="nav-item <?= Router::is('/dashboard') && !Router::is('/dashboard/') ? 'active' : '' ?>">
                    <i class="fas fa-home"></i>
                    <span><?= lang('home') ?></span>
                </a>

                <a href="<?= url('/dashboard/services') ?>" class="nav-item <?= Router::is('/dashboard/services') ? 'active' : '' ?>">
                    <i class="fas fa-concierge-bell"></i>
                    <span><?= lang('services') ?></span>
                </a>

                <a href="<?= url('/dashboard/banners') ?>" class="nav-item <?= Router::is('/dashboard/banners') ? 'active' : '' ?>">
                    <i class="fas fa-images"></i>
                    <span><?= lang('banners') ?></span>
                </a>

                <a href="<?= url('/dashboard/gallery') ?>" class="nav-item <?= Router::is('/dashboard/gallery') ? 'active' : '' ?>">
                    <i class="fas fa-photo-video"></i>
                    <span><?= lang('gallery') ?></span>
                </a>

                <a href="<?= url('/dashboard/testimonials') ?>" class="nav-item <?= Router::is('/dashboard/testimonials') ? 'active' : '' ?>">
                    <i class="fas fa-comment-dots"></i>
                    <span><?= lang('testimonials') ?></span>
                </a>

                <a href="<?= url('/dashboard/faq') ?>" class="nav-item <?= Router::is('/dashboard/faq') ? 'active' : '' ?>">
                    <i class="fas fa-question-circle"></i>
                    <span><?= lang('faq') ?? 'الأسئلة الشائعة' ?></span>
                </a>

                <a href="<?= url('/dashboard/stats') ?>" class="nav-item <?= Router::is('/dashboard/stats') ? 'active' : '' ?>">
                    <i class="fas fa-chart-bar"></i>
                    <span><?= lang('statistics') ?? 'الإحصائيات' ?></span>
                </a>

                <a href="<?= url('/dashboard/partners') ?>" class="nav-item <?= Router::is('/dashboard/partners') ? 'active' : '' ?>">
                    <i class="fas fa-handshake"></i>
                    <span><?= lang('partners') ?? 'الشركاء' ?></span>
                </a>

                <a href="<?= url('/dashboard/blog') ?>" class="nav-item <?= Router::is('/dashboard/blog') ? 'active' : '' ?>">
                    <i class="fas fa-blog"></i>
                    <span><?= lang('blog') ?? 'المدونة' ?></span>
                </a>

                <a href="<?= url('/dashboard/menu') ?>" class="nav-item <?= Router::is('/dashboard/menu') ? 'active' : '' ?>">
                    <i class="fas fa-bars"></i>
                    <span>إدارة المنو</span>
                </a>

                <a href="<?= url('/dashboard/pages') ?>" class="nav-item <?= Router::is('/dashboard/pages') ? 'active' : '' ?>">
                    <i class="fas fa-file-alt"></i>
                    <span><?= lang('pages') ?></span>
                </a>

                <a href="<?= url('/dashboard/messages') ?>" class="nav-item <?= Router::is('/dashboard/messages') ? 'active' : '' ?>">
                    <i class="fas fa-envelope"></i>
                    <span><?= lang('messages') ?></span>
                </a>

                <a href="<?= url('/dashboard/seo') ?>" class="nav-item <?= Router::is('/dashboard/seo') ? 'active' : '' ?>">
                    <i class="fas fa-search"></i>
                    <span><?= lang('seo') ?? 'تحسين محركات البحث' ?></span>
                </a>

                <a href="<?= url('/dashboard/analytics') ?>" class="nav-item <?= Router::is('/dashboard/analytics') ? 'active' : '' ?>">
                    <i class="fas fa-chart-line"></i>
                    <span><?= lang('analytics') ?? 'الإحصائيات والتحليلات' ?></span>
                </a>

                <a href="<?= url('/dashboard/domains') ?>" class="nav-item <?= Router::is('/dashboard/domains') ? 'active' : '' ?>">
                    <i class="fas fa-globe"></i>
                    <span><?= lang('domains') ?? 'النطاقات' ?></span>
                </a>

                <a href="<?= url('/dashboard/forms') ?>" class="nav-item <?= Router::is('/dashboard/forms') ? 'active' : '' ?>">
                    <i class="fas fa-wpforms"></i>
                    <span><?= lang('forms') ?? 'النماذج' ?></span>
                </a>

                <a href="<?= url('/dashboard/features') ?>" class="nav-item <?= Router::is('/dashboard/features') ? 'active' : '' ?>">
                    <i class="fas fa-star"></i>
                    <span><?= lang('site_features') ?? 'لماذا نحن' ?></span>
                </a>

                <!-- Settings Section -->
                <div class="nav-section" style="margin-top: 1rem;">
                    <span class="nav-section-title"><?= lang('settings') ?></span>
                </div>

                <a href="<?= url('/dashboard/settings') ?>" class="nav-item <?= Router::is('/dashboard/settings') ? 'active' : '' ?>">
                    <i class="fas fa-cog"></i>
                    <span><?= lang('site_settings') ?></span>
                </a>

                <a href="<?= url('/dashboard/themes') ?>" class="nav-item <?= Router::is('/dashboard/themes') ? 'active' : '' ?>">
                    <i class="fas fa-palette"></i>
                    <span><?= lang('themes') ?? 'القوالب' ?></span>
                </a>

                <a href="<?= url('/dashboard/subscription') ?>" class="nav-item <?= Router::is('/dashboard/subscription') ? 'active' : '' ?>">
                    <i class="fas fa-credit-card"></i>
                    <span><?= lang('subscription') ?? 'الاشتراك' ?></span>
                </a>

                <a href="<?= url('/dashboard/services-store') ?>" class="nav-item <?= Router::is('/dashboard/services-store') ? 'active' : '' ?>">
                    <i class="fas fa-store"></i>
                    <span><?= lang('services_store') ?? 'متجر الخدمات' ?></span>
                </a>

                <a href="<?= url('/dashboard/my-purchases') ?>" class="nav-item <?= Router::is('/dashboard/my-purchases') ? 'active' : '' ?>">
                    <i class="fas fa-shopping-bag"></i>
                    <span><?= lang('my_purchases') ?? 'مشترياتي' ?></span>
                </a>

                <!-- View Site -->
                <?php if ($tenant && $tenant->site_status === 'published'): ?>
                <div class="nav-section" style="margin-top: 1rem;">
                    <span class="nav-section-title"><?= lang('site') ?? 'الموقع' ?></span>
                </div>

                <a href="<?= url('/site/' . $tenant->slug) ?>" class="nav-item" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    <span><?= lang('view_site') ?></span>
                </a>
                <?php endif; ?>

                <!-- Logout -->
                <div class="nav-section" style="margin-top: 1rem;">
                    <span class="nav-section-title">&nbsp;</span>
                </div>

                <a href="<?= url('/logout') ?>" class="nav-item text-danger">
                    <i class="fas fa-sign-out-alt"></i>
                    <span><?= lang('logout') ?></span>
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
                    <h1 class="page-title"><?= $title ?? lang('dashboard') ?></h1>
                </div>

                <div class="header-actions">
                    <!-- Language Switcher -->
                    <div class="lang-switcher">
                        <a href="<?= url('/lang/ar') ?>" class="lang-btn <?= $lang === 'ar' ? 'active' : '' ?>">عربي</a>
                        <a href="<?= url('/lang/en') ?>" class="lang-btn <?= $lang === 'en' ? 'active' : '' ?>">EN</a>
                    </div>

                    <!-- Notification Bell -->
                    <button class="notification-btn" title="<?= lang('notifications') ?? 'الإشعارات' ?>">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge"></span>
                    </button>

                    <!-- User Menu -->
                    <div class="user-menu-wrapper">
                        <div class="user-menu" id="userMenu">
                            <div class="user-avatar">
                                <?= mb_substr(Auth::user()->full_name, 0, 1) ?>
                            </div>
                            <div class="user-info">
                                <div class="user-name"><?= Auth::user()->full_name ?></div>
                                <div class="user-role"><?= Auth::isAdmin() ? lang('admin_panel') : lang('dashboard') ?></div>
                            </div>
                            <i class="fas fa-chevron-down" style="color: #94a3b8; font-size: 0.7rem;"></i>
                        </div>

                        <!-- Dropdown -->
                        <div class="user-dropdown" id="userDropdown">
                            <a href="<?= url('/dashboard/settings') ?>">
                                <i class="fas fa-user-circle" style="color: #64748b;"></i>
                                <?= lang('my_profile') ?? 'الملف الشخصي' ?>
                            </a>
                            <a href="<?= url('/dashboard/settings') ?>">
                                <i class="fas fa-cog" style="color: #64748b;"></i>
                                <?= lang('site_settings') ?>
                            </a>
                            <hr>
                            <a href="<?= url('/logout') ?>" class="text-danger">
                                <i class="fas fa-sign-out-alt"></i>
                                <?= lang('logout') ?>
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

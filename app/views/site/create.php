<?php
/**
 * Create Site View
 * صفحة إنشاء الموقع الأول
 */

$lang = Language::current();
$dir = Language::direction();
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= lang('create_site') ?> - <?= lang('site_name') ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    
    <style>
        .create-container {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .create-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 900px;
            overflow: hidden;
        }
        
        .create-header {
            padding: 2rem;
            text-align: center;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #fff;
        }
        
        .create-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .create-header p {
            opacity: 0.9;
        }
        
        .create-body {
            padding: 2rem;
        }
        
        .create-footer {
            padding: 1.5rem 2rem;
            background: var(--light);
            text-align: center;
            font-size: 0.875rem;
            color: var(--secondary);
        }
        
        .theme-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .theme-select {
            border: 3px solid var(--border);
            border-radius: 1rem;
            padding: 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }
        
        .theme-select:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        }
        
        .theme-select.selected {
            border-color: var(--primary);
            background: rgba(37, 99, 235, 0.05);
        }
        
        .theme-select.selected::after {
            content: '✓';
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            width: 24px;
            height: 24px;
            background: var(--primary);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
        }
        
        [dir="rtl"] .theme-select.selected::after {
            right: auto;
            left: 0.5rem;
        }
        
        .theme-icon {
            width: 60px;
            height: 60px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
        }
        
        .theme-name {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        .theme-category {
            font-size: 0.75rem;
            color: var(--secondary);
        }
        
        .lang-switch {
            position: absolute;
            top: 1rem;
            <?= $dir === 'rtl' ? 'left: 1rem;' : 'right: 1rem;' ?>
        }
    </style>
</head>
<body>
    <div class="create-container">
        <!-- Language Switcher -->
        <div class="lang-switch">
            <div class="lang-switcher">
                <a href="<?= url('/lang/ar') ?>" class="lang-btn <?= $lang === 'ar' ? 'active' : '' ?>">عربي</a>
                <a href="<?= url('/lang/en') ?>" class="lang-btn <?= $lang === 'en' ? 'active' : '' ?>">EN</a>
            </div>
        </div>
        
        <div class="create-card">
            <div class="create-header">
                <h1><i class="fas fa-rocket"></i> <?= lang('first_site') ?></h1>
                <p><?= lang('choose_theme') ?></p>
            </div>
            
            <div class="create-body">
                <?= $this->messages() ?>
                
                <form method="POST" action="<?= url('/site/create') ?>">
                    <?= $this->csrf() ?>
                    
                    <div class="form-group">
                        <label class="form-label"><?= lang('site_name_label') ?></label>
                        <input type="text" name="site_name" class="form-control" 
                               placeholder="<?= lang('site_name') ?>" required
                               autofocus>
                        <span class="form-hint">مثال: شركة الفاتح للخدمات المنزلية</span>
                    </div>
                    
                    <h3 style="margin: 1.5rem 0 1rem; font-size: 1rem; color: var(--dark);">
                        <?= lang('choose_theme') ?>
                    </h3>
                    
                    <div class="theme-grid">
                        <?php foreach ($themes as $theme): ?>
                        <div class="theme-select <?= $theme->id === 1 ? 'selected' : '' ?>" 
                             data-theme-id="<?= $theme->id ?>"
                             onclick="selectTheme(<?= $theme->id ?>)">
                            <div class="theme-icon" style="background: linear-gradient(135deg, 
                                <?= $theme->slug === 'maintenance' ? '#f97316, #ea580c' : '' ?>
                                <?= $theme->slug === 'decor' ? '#b45309, #92400e' : '' ?>
                                <?= $theme->slug === 'electric' ? '#fbbf24, #d97706' : '' ?>
                                <?= $theme->slug === 'plumbing' ? '#0891b2, #0e7490' : '' ?>
                                <?= $theme->slug === 'cleaning' ? '#10b981, #047857' : '' ?>
                                <?= $theme->slug === 'general' ? '#2563eb, #1e40af' : '' ?>
                            ); color: #fff;">
                                <i class="fas fa-<?= 
                                    $theme->slug === 'maintenance' ? 'tools' : 
                                    ($theme->slug === 'decor' ? 'palette' : 
                                    ($theme->slug === 'electric' ? 'bolt' : 
                                    ($theme->slug === 'plumbing' ? 'faucet' : 
                                    ($theme->slug === 'cleaning' ? 'spray-can' : 'cube')))) ?>"></i>
                            </div>
                            <div class="theme-name"><?= $theme->name ?></div>
                            <div class="theme-category"><?= $theme->category ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <input type="hidden" name="theme_id" id="theme_id" value="1">
                    
                    <button type="submit" class="btn btn-primary btn-block btn-lg">
                        <i class="fas fa-magic"></i>
                        <?= lang('create_site') ?>
                    </button>
                </form>
            </div>
            
            <div class="create-footer">
                <?= lang('powered_by') ?> <?= lang('site_name') ?>
            </div>
        </div>
    </div>
    
    <script>
    function selectTheme(id) {
        // Remove selected from all
        document.querySelectorAll('.theme-select').forEach(el => {
            el.classList.remove('selected');
        });
        
        // Add selected to clicked
        event.currentTarget.classList.add('selected');
        
        // Update hidden input
        document.getElementById('theme_id').value = id;
    }
    </script>
</body>
</html>

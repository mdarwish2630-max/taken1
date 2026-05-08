<?php
/**
 * Welcome View for New Users
 * صفحة ترحيبية للمستخدمين الجدد
 */


$tenant = $tenant ?? Auth::tenant();
$user = $user ?? Auth::user();
$lang = Language::current();
$dir = Language::direction();
?>

<style>
.welcome-container {
    text-align: center;
    padding: 2rem;
    max-width: 800px;
    margin: 0 auto;
}

.welcome-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    font-size: 2.5rem;
    color: #fff;
}

.welcome-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: var(--dark);
}

.welcome-subtitle {
    font-size: 1.1rem;
    color: var(--secondary);
    margin-bottom: 2rem;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.feature-card {
    background: var(--light);
    border-radius: 1rem;
    padding: 1.5rem;
    text-align: center;
    transition: transform 0.3s;
}

.feature-card:hover {
    transform: translateY(-5px);
}

.feature-icon {
    width: 50px;
    height: 50px;
    background: var(--primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: #fff;
    font-size: 1.25rem;
}

.feature-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.feature-desc {
    font-size: 0.875rem;
    color: var(--secondary);
}

.cta-section {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border-radius: 1rem;
    padding: 2rem;
    color: #fff;
}

.cta-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.cta-desc {
    opacity: 0.9;
    margin-bottom: 1.5rem;
}

.btn-white {
    background: #fff;
    color: var(--primary);
    font-weight: 600;
    padding: 0.75rem 2rem;
    border-radius: 0.5rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    transition: transform 0.3s, box-shadow 0.3s;
}

.btn-white:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    color: var(--primary);
}
</style>

<div class="welcome-container">
    <div class="welcome-icon">
        <i class="fas fa-hand-sparkles"></i>
    </div>
    
    <h1 class="welcome-title">
        <?= sprintf(lang('welcome_user'), $user->full_name) ?>
    </h1>
    
    <p class="welcome-subtitle">
        <?= lang('welcome_message') ?>
    </p>
    
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-magic"></i>
            </div>
            <h3 class="feature-title"><?= lang('easy_setup') ?></h3>
            <p class="feature-desc"><?= lang('easy_setup_desc') ?></p>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-palette"></i>
            </div>
            <h3 class="feature-title"><?= lang('professional_themes') ?></h3>
            <p class="feature-desc"><?= lang('professional_themes_desc') ?></p>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-mobile-alt"></i>
            </div>
            <h3 class="feature-title"><?= lang('responsive_design') ?></h3>
            <p class="feature-desc"><?= lang('responsive_design_desc') ?></p>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <h3 class="feature-title"><?= lang('analytics_tracking') ?></h3>
            <p class="feature-desc"><?= lang('analytics_tracking_desc') ?></p>
        </div>
    </div>
    
    <div class="cta-section">
        <h2 class="cta-title">
            <i class="fas fa-rocket"></i>
            <?= lang('start_building') ?>
        </h2>
        <p class="cta-desc">
            <?= lang('start_building_desc') ?>
        </p>
        <a href="<?= url('/site/create') ?>" class="btn-white">
            <i class="fas fa-plus"></i>
            <?= lang('create_first_site') ?>
        </a>
    </div>
</div>

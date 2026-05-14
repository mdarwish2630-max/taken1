<?php
/**
 * Admin - Site Features View
 * مميزات الموقع الرئيسي
 */

?>

<div class="page-header">
    <h1 class="page-title"><?= lang('site_features') ?? 'مميزات الموقع' ?></h1>
</div>

<?php if (Session::has('success')): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    <?= Session::getSuccess() ?>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= lang('current_features') ?? 'المميزات الحالية' ?></h3>
    </div>
    <div class="card-body">
        <?php if (empty($features)): ?>
        <p style="color: #64748b; text-align: center; padding: 2rem;">
            <?= lang('no_features') ?? 'لا توجد مميزات. أضف ميزة جديدة.' ?>
        </p>
        <?php else: ?>
        <div class="features-grid">
            <?php foreach ($features as $feature): ?>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="<?= $feature->icon ?: 'fas fa-star' ?>"></i>
                </div>
                <h4><?= htmlspecialchars($feature->title) ?></h4>
                <p><?= htmlspecialchars($feature->description) ?></p>
                <div class="feature-actions">
                    <span class="badge <?= $feature->is_active ? 'badge-success' : 'badge-secondary' ?>">
                        <?= $feature->is_active ? (lang('active') ?? 'نشط') : (lang('inactive') ?? 'غير نشط') ?>
                    </span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Add Feature Form -->
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title"><?= lang('add_feature') ?? 'إضافة ميزة جديدة' ?></h3>
    </div>
    <div class="card-body">
        <form method="POST" action="<?= url('/admin/site-features') ?>">
            <?= $this->csrf() ?>
            
            <div class="form-group">
                <label class="form-label"><?= lang('icon') ?? 'الأيقونة' ?></label>
                <input type="text" name="icon" class="form-control" 
                       value="fas fa-star" placeholder="fas fa-check">
                <span class="form-hint">استخدم Font Awesome classes</span>
            </div>
            
            <div class="form-group">
                <label class="form-label"><?= lang('title') ?? 'العنوان' ?> *</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label class="form-label"><?= lang('description') ?? 'الوصف' ?></label>
                <textarea name="description" class="form-control" rows="2"></textarea>
            </div>
            
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_active" value="1" checked>
                    <span><?= lang('is_active') ?? 'نشط' ?></span>
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                <?= lang('add_feature') ?? 'إضافة ميزة' ?>
            </button>
        </form>
    </div>
</div>

<style>
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.feature-card {
    background: var(--light);
    border-radius: var(--radius);
    padding: 1.5rem;
    text-align: center;
}
.feature-card .feature-icon {
    width: 60px;
    height: 60px;
    background: var(--primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: #fff;
    font-size: 1.5rem;
}
.feature-card h4 {
    color: var(--text);
    margin: 0.5rem 0;
}
.feature-card p {
    color: #64748b;
    font-size: 0.875rem;
}
.feature-actions {
    margin-top: 1rem;
}
</style>

<?php
/**
 * Admin - System Settings
 * إعدادات النظام
 */

?>

<div class="page-header">
    <h1 class="page-title"><?= lang('system_settings') ?? 'إعدادات النظام' ?></h1>
</div>

<?php if (Session::has('success')): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    <?= Session::getSuccess() ?>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form method="POST" action="<?= url('/admin/settings') ?>">
            <?= $this->csrf() ?>
            <div class="row g-3">
                <?php foreach ($settings as $setting): ?>
                <div class="col-md-6">
                    <label class="form-label"><?= $this->e($setting->description ?? $setting->setting_key) ?></label>
                    <?php if (strpos($setting->setting_key, 'social_') === 0): ?>
                    <input type="url" name="<?= $setting->setting_key ?>" class="form-control" 
                           value="<?= $this->e($setting->setting_value ?? '') ?>">
                    <?php elseif ($setting->setting_type === 'textarea'): ?>
                    <textarea name="<?= $setting->setting_key ?>" class="form-control" rows="3"><?= $this->e($setting->setting_value ?? '') ?></textarea>
                    <?php else: ?>
                    <input type="text" name="<?= $setting->setting_key ?>" class="form-control" 
                           value="<?= $this->e($setting->setting_value ?? '') ?>">
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        <?= lang('save') ?? 'حفظ' ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

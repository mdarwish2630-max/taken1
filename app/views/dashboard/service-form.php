<?php
/**
 * Service Form View
 * نموذج إضافة/تعديل خدمة
 */

?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $service ? lang('edit_service') : lang('add_service') ?></h3>
        <a href="<?= url('/dashboard/services') ?>" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-<?= langDir() === 'rtl' ? 'left' : 'right' ?>"></i>
            <?= lang('back') ?>
        </a>
    </div>
    <div class="card-body">
        <form method="POST" action="<?= $service ? url('/dashboard/services/edit/' . $service->id) : url('/dashboard/services/add') ?>" 
              enctype="multipart/form-data">
            <?= $this->csrf() ?>
            
            <!-- Arabic Fields -->
            <div class="lang-section-header">
                <span class="lang-badge">🇸🇦 العربية</span>
            </div>
            
            <div class="form-group">
                <label class="form-label"><?= lang('service_title') ?> (العربية) *</label>
                <input type="text" name="title" class="form-control" dir="rtl"
                       value="<?= $this->e($service->title ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label class="form-label"><?= lang('service_description') ?> (العربية)</label>
                <textarea name="description" class="form-control" rows="2" dir="rtl"><?= $this->e($service->description ?? '') ?></textarea>
            </div>
            
            <div class="form-group">
                <label class="form-label"><?= lang('service_content') ?> (العربية)</label>
                <textarea name="content" class="form-control" rows="5" dir="rtl"><?= $this->e($service->content ?? '') ?></textarea>
            </div>

            <!-- English Fields -->
            <div class="lang-section-header" style="margin-top: 1.5rem;">
                <span class="lang-badge">🇬🇧 English</span>
                <span class="form-hint" style="margin-right: auto;">(اختياري / Optional)</span>
            </div>

            <div class="form-group">
                <label class="form-label">Service Title (English)</label>
                <input type="text" name="title_en" class="form-control" dir="ltr"
                       value="<?= $this->e($service->title_en ?? '') ?>"
                       placeholder="Service title in English">
            </div>

            <div class="form-group">
                <label class="form-label">Description (English)</label>
                <textarea name="description_en" class="form-control" rows="2" dir="ltr"><?= $this->e($service->description_en ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Content (English)</label>
                <textarea name="content_en" class="form-control" rows="5" dir="ltr"><?= $this->e($service->content_en ?? '') ?></textarea>
            </div>
            
            <div class="d-flex gap-3" style="flex-wrap: wrap;">
                <div class="form-group" style="flex: 1; min-width: 200px;">
                    <label class="form-label"><?= lang('service_image') ?></label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <?php if ($service && $service->image): ?>
                    <img src="<?= upload($service->image) ?>" alt="" 
                         style="width: 100px; margin-top: 0.5rem; border-radius: 8px;">
                    <?php endif; ?>
                </div>
                
                <div class="form-group" style="flex: 1; min-width: 200px;">
                    <label class="form-label"><?= lang('service_icon') ?></label>
                    <input type="text" name="icon" class="form-control" 
                           value="<?= $this->e($service->icon ?? '') ?>"
                           placeholder="fas fa-wrench">
                    <span class="form-hint">استخدم أيقونات Font Awesome</span>
                </div>
            </div>
            
            <div class="d-flex gap-3" style="flex-wrap: wrap;">
                <div class="form-group" style="flex: 1; min-width: 200px;">
                    <label class="form-label"><?= lang('service_price') ?></label>
                    <input type="number" name="price" class="form-control" 
                           value="<?= $service->price ?? '' ?>" step="0.01">
                </div>
                
                <div class="form-group" style="flex: 1; min-width: 200px;">
                    <label class="form-label"><?= lang('price_text') ?></label>
                    <input type="text" name="price_text" class="form-control" 
                           value="<?= $this->e($service->price_text ?? '') ?>"
                           placeholder="مثال: يبدأ من 100 ر.س">
                </div>
            </div>
            
            <div class="d-flex gap-3 align-center" style="flex-wrap: wrap;">
                <div class="form-group">
                    <label class="checkbox-group">
                        <input type="checkbox" name="show_on_home" value="1" 
                               <?= ($service && $service->show_on_home) ? 'checked' : '' ?>>
                        <span><?= lang('show_on_home') ?></span>
                    </label>
                </div>
                
                <div class="form-group">
                    <label class="form-label"><?= lang('status') ?></label>
                    <select name="status" class="form-control">
                        <option value="active" <?= ($service && $service->status === 'active') ? 'selected' : '' ?>>
                            <?= lang('subscription_active') ?>
                        </option>
                        <option value="inactive" <?= ($service && $service->status === 'inactive') ? 'selected' : '' ?>>
                            <?= lang('inactive') ?>
                        </option>
                    </select>
                </div>
            </div>
            
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    <?= lang('save') ?>
                </button>
                <a href="<?= url('/dashboard/services') ?>" class="btn btn-outline">
                    <?= lang('cancel') ?>
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.lang-section-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding-bottom: 0.5rem;
    margin-bottom: 0.75rem;
    border-bottom: 2px solid var(--border, #e2e8f0);
}
.lang-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: var(--primary, #4f46e5);
    color: #fff;
    padding: 0.35rem 1rem;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
}
</style>

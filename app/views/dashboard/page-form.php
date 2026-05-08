<?php
/**
 * Dashboard - Page Form
 * لوحة التحكم - نموذج الصفحة
 */

$dir = Language::direction();
$isEdit = !empty($page);
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title"><?= $isEdit ? lang('edit_page') : lang('add_page') ?></h2>
        <a href="<?= url('/dashboard/pages') ?>" class="btn btn-outline">
            <i class="fas fa-arrow-<?= $dir === 'rtl' ? 'left' : 'right' ?>"></i>
            <?= lang('back') ?>
        </a>
    </div>
    
    <div class="card-body">
        <form method="POST" action="<?= $isEdit ? url('/dashboard/pages/edit/' . $page->id) : url('/dashboard/pages/add') ?>">
            <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
            
            <!-- Arabic Fields -->
            <div class="lang-section-header">
                <span class="lang-badge">🇸🇦 العربية</span>
            </div>

            <div class="form-group">
                <label class="form-label"><?= lang('title') ?> (العربية) *</label>
                <input type="text" name="title" class="form-control" dir="rtl"
                       value="<?= $isEdit ? $page->title : '' ?>" required
                       placeholder="<?= lang('page_title_placeholder') ?>">
            </div>
            
            <div class="form-group">
                <label class="form-label"><?= lang('content') ?> (العربية)</label>
                <textarea name="content" class="form-control" rows="10" dir="rtl"
                          placeholder="<?= lang('page_content_placeholder') ?>"><?= $isEdit ? $page->content : '' ?></textarea>
            </div>

            <!-- English Fields -->
            <div class="lang-section-header" style="margin-top: 1.5rem;">
                <span class="lang-badge">🇬🇧 English</span>
                <span class="form-hint" style="margin-right: auto;">(اختياري / Optional)</span>
            </div>

            <div class="form-group">
                <label class="form-label">Page Title (English)</label>
                <input type="text" name="title_en" class="form-control" dir="ltr"
                       value="<?= $isEdit ? ($page->title_en ?? '') : '' ?>"
                       placeholder="Page title in English">
            </div>

            <div class="form-group">
                <label class="form-label">Content (English)</label>
                <textarea name="content_en" class="form-control" rows="10" dir="ltr"
                          placeholder="Page content in English"><?= $isEdit ? ($page->content_en ?? '') : '' ?></textarea>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label class="form-label"><?= lang('meta_title') ?></label>
                    <input type="text" name="meta_title" class="form-control" 
                           value="<?= $isEdit ? $page->meta_title : '' ?>"
                           placeholder="<?= lang('meta_title_placeholder') ?>">
                    <span class="form-hint"><?= lang('meta_title_hint') ?></span>
                </div>
                
                <div class="form-group">
                    <label class="form-label"><?= lang('template') ?></label>
                    <select name="template" class="form-control">
                        <option value="default" <?= ($isEdit && $page->template === 'default') ? 'selected' : '' ?>>
                            <?= lang('default_template') ?>
                        </option>
                        <option value="fullwidth" <?= ($isEdit && $page->template === 'fullwidth') ? 'selected' : '' ?>>
                            <?= lang('fullwidth_template') ?>
                        </option>
                        <option value="sidebar" <?= ($isEdit && $page->template === 'sidebar') ? 'selected' : '' ?>>
                            <?= lang('sidebar_template') ?>
                        </option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label"><?= lang('meta_description') ?></label>
                <textarea name="meta_description" class="form-control" rows="3" 
                          placeholder="<?= lang('meta_description_placeholder') ?>"><?= $isEdit ? $page->meta_description : '' ?></textarea>
                <span class="form-hint"><?= lang('meta_description_hint') ?></span>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label class="form-label"><?= lang('status') ?></label>
                    <select name="status" class="form-control">
                        <option value="published" <?= ($isEdit && $page->status === 'published') ? 'selected' : '' ?>>
                            <?= lang('published') ?>
                        </option>
                        <option value="draft" <?= ($isEdit && $page->status === 'draft') ? 'selected' : '' ?>>
                            <?= lang('draft') ?>
                        </option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label" style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;">
                        <input type="checkbox" name="show_in_menu" value="1" 
                               <?= ($isEdit && $page->show_in_menu) ? 'checked' : '' ?>
                               style="width: 18px; height: 18px;">
                        <?= lang('show_in_menu') ?>
                    </label>
                    <span class="form-hint"><?= lang('show_in_menu_hint') ?></span>
                </div>
            </div>
            
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    <?= lang('save') ?>
                </button>
                <a href="<?= url('/dashboard/pages') ?>" class="btn btn-outline">
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
@media (max-width: 768px) {
    .card-body [style*="grid-template-columns: 1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
}
</style>

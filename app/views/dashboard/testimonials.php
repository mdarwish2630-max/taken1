<?php
/**
 * Testimonials View
 * صفحة آراء العملاء
 */

?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= lang('testimonials') ?></h3>
    </div>
    <div class="card-body">
        <!-- Add Testimonial Form -->
        <form method="POST" action="<?= url('/dashboard/testimonials') ?>" enctype="multipart/form-data">
            <?= $this->csrf() ?>
            
            <div class="form-group">
                <label class="form-label"><?= lang('client_name') ?> *</label>
                <input type="text" name="client_name" class="form-control" required>
            </div>

            <!-- Arabic Fields -->
            <div class="lang-section-header">
                <span class="lang-badge">🇸🇦 العربية</span>
            </div>
            
            <div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label"><?= lang('client_title') ?> (العربية)</label>
                    <input type="text" name="client_title" class="form-control" dir="rtl" placeholder="مثال: مدير شركة ABC">
                </div>
                
                <div class="form-group">
                    <label class="form-label"><?= lang('rating') ?></label>
                    <select name="rating" class="form-control">
                        <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                        <option value="4">⭐⭐⭐⭐ (4)</option>
                        <option value="3">⭐⭐⭐ (3)</option>
                        <option value="2">⭐⭐ (2)</option>
                        <option value="1">⭐ (1)</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label"><?= lang('testimonial_content') ?> (العربية) *</label>
                <textarea name="content" class="form-control" rows="3" dir="rtl" required></textarea>
            </div>

            <!-- English Fields -->
            <div class="lang-section-header" style="margin-top: 1.5rem;">
                <span class="lang-badge">🇬🇧 English</span>
                <span class="form-hint" style="margin-right: auto;">(اختياري / Optional)</span>
            </div>

            <div class="form-group">
                <label class="form-label">Client Title (English)</label>
                <input type="text" name="client_title_en" class="form-control" dir="ltr" placeholder="e.g. CEO at ABC Company">
            </div>
            
            <div class="form-group">
                <label class="form-label">Testimonial Content (English)</label>
                <textarea name="content_en" class="form-control" rows="3" dir="ltr" placeholder="Client testimonial in English"></textarea>
            </div>
            
            <div class="form-group">
                <label class="form-label"><?= lang('client_image') ?></label>
                <input type="file" name="client_image" class="form-control" accept="image/*">
            </div>

            <div class="form-group">
                <label class="checkbox-group">
                    <input type="checkbox" name="show_on_home" value="1" checked>
                    <span><?= lang('show_on_home') ?></span>
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-plus"></i> <?= lang('add') ?>
            </button>
        </form>
        
        <?php if (!empty($testimonials)): ?>
        <hr style="margin: 2rem 0;">
        
        <div class="testimonials-list">
            <?php foreach ($testimonials as $testimonial): ?>
            <div class="testimonial-item" style="display: flex; gap: 1rem; padding: 1rem; background: var(--light); border-radius: 8px; margin-bottom: 1rem;">
                <div class="testimonial-avatar" style="width: 60px; height: 60px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 600; font-size: 1.25rem; flex-shrink: 0;">
                    <?php if ($testimonial->client_image): ?>
                    <img src="<?= upload($testimonial->client_image) ?>" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                    <?php else: ?>
                    <?= mb_substr($testimonial->client_name, 0, 1) ?>
                    <?php endif; ?>
                </div>
                
                <div style="flex: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <strong><?= $testimonial->client_name ?></strong>
                            <?php if ($testimonial->client_title): ?>
                            <br><small style="color: var(--secondary);"><?= $testimonial->client_title ?></small>
                            <?php endif; ?>
                            <?php if ($testimonial->client_title_en): ?>
                            <br><small style="color: var(--secondary);"><?= $testimonial->client_title_en ?></small>
                            <?php endif; ?>
                        </div>
                        <div style="color: var(--accent);">
                            <?php for($i=0; $i<$testimonial->rating; $i++) echo '⭐'; ?>
                        </div>
                    </div>
                    <p style="margin-top: 0.5rem; color: #666;"><?= $testimonial->content ?></p>
                    <?php if ($testimonial->content_en): ?>
                    <p style="margin-top: 0.25rem; color: #999; font-style: italic; font-size: 0.9rem;">EN: <?= $testimonial->content_en ?></p>
                    <?php endif; ?>
                </div>
                
                <button type="button" class="btn btn-danger btn-sm" 
                        data-delete="<?= url('/dashboard/testimonials/delete/' . $testimonial->id) ?>"
                        data-confirm="<?= lang('confirm_delete') ?>">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
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

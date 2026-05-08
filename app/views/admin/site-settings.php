<?php
/**
 * Admin - Site Settings View
 * إعدادات الموقع الرئيسي
 */

?>

<div class="page-header">
    <h1 class="page-title"><?= lang('site_settings') ?? 'إعدادات الموقع الرئيسي' ?></h1>
</div>

<?php if (Session::has('success')): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    <?= Session::getSuccess() ?>
</div>
<?php endif; ?>

<form method="POST" action="<?= url('/admin/site-settings') ?>" enctype="multipart/form-data">
    <?= $this->csrf() ?>
    
    <div class="d-flex gap-3" style="flex-wrap: wrap;">
        
        <!-- الشعار والأيقونة -->
        <div class="card" style="flex: 2; min-width: 400px;">
            <div class="card-header">
                <h3 class="card-title"><?= lang('logo_favicon') ?? 'الشعار والأيقونة' ?></h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label"><?= lang('site_logo') ?? 'شعار الموقع' ?></label>
                    <div class="d-flex gap-3 align-center">
                        <?php if ($settings->logo): ?>
                            <img src="<?= upload($settings->logo) ?>" alt="Logo" 
                                 style="width: 100px; height: auto; object-fit: contain; border: 1px solid var(--border); border-radius: 0.5rem; padding: 0.5rem;">
                        <?php endif; ?>
                        <div>
                            <input type="file" name="logo" class="form-control" accept="image/*">
                            <span class="form-hint">PNG, JPG, SVG - Max 2MB</span>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label"><?= lang('favicon') ?? 'أيقونة الموقع' ?></label>
                    <div class="d-flex gap-3 align-center">
                        <?php if ($settings->favicon): ?>
                            <img src="<?= upload($settings->favicon) ?>" alt="Favicon" 
                                 style="width: 48px; height: 48px; object-fit: contain; border: 1px solid var(--border); border-radius: 0.25rem;">
                        <?php endif; ?>
                        <div>
                            <input type="file" name="favicon" class="form-control" accept="image/*">
                            <span class="form-hint">32x32 أو 16x16 بكسل</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- الحالة السريعة -->
        <div class="card" style="flex: 1; min-width: 300px;">
            <div class="card-header">
                <h3 class="card-title"><?= lang('quick_status') ?? 'حالة سريعة' ?></h3>
            </div>
            <div class="card-body">
                <div class="feature-item">
                    <label class="checkbox-label">
                        <input type="checkbox" name="maintenance_mode" value="1" 
                               <?= ($settings->maintenance_mode ?? 0) ? 'checked' : '' ?>>
                        <span><?= lang('maintenance_mode') ?? 'وضع الصيانة' ?></span>
                    </label>
                </div>
                
                <div class="form-group mt-2">
                    <label class="form-label"><?= lang('maintenance_message') ?? 'رسالة الصيانة' ?></label>
                    <textarea name="maintenance_message" class="form-control" rows="2"><?= $this->e($settings->maintenance_message ?? '') ?></textarea>
                </div>
                
                <div class="feature-item mt-3">
                    <label class="checkbox-label">
                        <input type="checkbox" name="show_features" value="1" 
                               <?= ($settings->show_features ?? 1) ? 'checked' : '' ?>>
                        <span><?= lang('show_features_section') ?? 'عرض قسم المميزات' ?></span>
                    </label>
                </div>
                
                <div class="feature-item">
                    <label class="checkbox-label">
                        <input type="checkbox" name="show_themes_section" value="1" 
                               <?= ($settings->show_themes_section ?? 1) ? 'checked' : '' ?>>
                        <span><?= lang('show_themes_section') ?? 'عرض قسم القوالب' ?></span>
                    </label>
                </div>
                
                <div class="feature-item">
                    <label class="checkbox-label">
                        <input type="checkbox" name="show_pricing_section" value="1" 
                               <?= ($settings->show_pricing_section ?? 1) ? 'checked' : '' ?>>
                        <span><?= lang('show_pricing_section') ?? 'عرض قسم الأسعار' ?></span>
                    </label>
                </div>
                
                <div class="feature-item">
                    <label class="checkbox-label">
                        <input type="checkbox" name="show_testimonials" value="1" 
                               <?= ($settings->show_testimonials ?? 1) ? 'checked' : '' ?>>
                        <span><?= lang('show_testimonials_section') ?? 'عرض قسم الشهادات' ?></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    
    <!-- قسم البانر الرئيسي -->
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title"><?= lang('hero_section') ?? 'قسم البانر الرئيسي' ?></h3>
        </div>
        <div class="card-body">
            <div class="d-flex gap-3" style="flex-wrap: wrap;">
                <div style="flex: 2; min-width: 300px;">
                    <div class="form-group">
                        <label class="form-label"><?= lang('hero_title') ?? 'العنوان الرئيسي' ?></label>
                        <input type="text" name="hero_title" class="form-control" 
                               value="<?= $this->e($settings->hero_title ?? '') ?>">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label"><?= lang('hero_subtitle') ?? 'العنوان الفرعي' ?></label>
                        <textarea name="hero_subtitle" class="form-control" rows="3"><?= $this->e($settings->hero_subtitle ?? '') ?></textarea>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <div class="form-group" style="flex: 1;">
                            <label class="form-label"><?= lang('button_text') ?? 'نص الزر' ?></label>
                            <input type="text" name="hero_button_text" class="form-control" 
                                   value="<?= $this->e($settings->hero_button_text ?? '') ?>">
                        </div>
                        
                        <div class="form-group" style="flex: 1;">
                            <label class="form-label"><?= lang('button_link') ?? 'رابط الزر' ?></label>
                            <input type="text" name="hero_button_link" class="form-control" 
                                   value="<?= $this->e($settings->hero_button_link ?? '') ?>">
                        </div>
                    </div>
                </div>
                
                <div style="flex: 1; min-width: 250px;">
                    <label class="form-label"><?= lang('hero_image') ?? 'صورة الخلفية' ?></label>
                    <?php if ($settings->hero_image): ?>
                        <img src="<?= upload($settings->hero_image) ?>" alt="Hero" 
                             style="width: 100%; max-height: 200px; object-fit: cover; border-radius: 0.5rem; margin-bottom: 0.5rem;">
                    <?php endif; ?>
                    <input type="file" name="hero_image" class="form-control" accept="image/*">
                    <span class="form-hint">صورة بجودة عالية للبانر الرئيسي</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- معلومات التواصل -->
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title"><?= lang('contact_info') ?? 'معلومات التواصل' ?></h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                <div class="form-group">
                    <label class="form-label"><?= lang('contact_email') ?? 'البريد الإلكتروني' ?></label>
                    <input type="email" name="contact_email" class="form-control" 
                           value="<?= $this->e($settings->contact_email ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label class="form-label"><?= lang('contact_phone') ?? 'رقم الهاتف' ?></label>
                    <input type="tel" name="contact_phone" class="form-control" 
                           value="<?= $this->e($settings->contact_phone ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label class="form-label"><?= lang('whatsapp') ?? 'واتساب' ?></label>
                    <input type="tel" name="contact_whatsapp" class="form-control" 
                           value="<?= $this->e($settings->contact_whatsapp ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label class="form-label"><?= lang('address') ?? 'العنوان' ?></label>
                    <input type="text" name="contact_address" class="form-control" 
                           value="<?= $this->e($settings->contact_address ?? '') ?>">
                </div>
            </div>
        </div>
    </div>
    
    <!-- السوشال ميديا -->
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title"><?= lang('social_media') ?? 'السوشال ميديا' ?></h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <div class="form-group">
                    <label class="form-label"><i class="fab fa-facebook"></i> Facebook</label>
                    <input type="url" name="facebook" class="form-control" 
                           value="<?= $this->e($settings->facebook ?? '') ?>" placeholder="https://facebook.com/...">
                </div>
                
                <div class="form-group">
                    <label class="form-label"><i class="fab fa-twitter"></i> Twitter</label>
                    <input type="url" name="twitter" class="form-control" 
                           value="<?= $this->e($settings->twitter ?? '') ?>" placeholder="https://twitter.com/...">
                </div>
                
                <div class="form-group">
                    <label class="form-label"><i class="fab fa-instagram"></i> Instagram</label>
                    <input type="url" name="instagram" class="form-control" 
                           value="<?= $this->e($settings->instagram ?? '') ?>" placeholder="https://instagram.com/...">
                </div>
                
                <div class="form-group">
                    <label class="form-label"><i class="fab fa-linkedin"></i> LinkedIn</label>
                    <input type="url" name="linkedin" class="form-control" 
                           value="<?= $this->e($settings->linkedin ?? '') ?>" placeholder="https://linkedin.com/...">
                </div>
                
                <div class="form-group">
                    <label class="form-label"><i class="fab fa-youtube"></i> YouTube</label>
                    <input type="url" name="youtube" class="form-control" 
                           value="<?= $this->e($settings->youtube ?? '') ?>" placeholder="https://youtube.com/...">
                </div>
            </div>
        </div>
    </div>
    
    <!-- SEO -->
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title"><?= lang('seo_settings') ?? 'إعدادات SEO' ?></h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label class="form-label"><?= lang('meta_title') ?? 'عنوان الصفحة' ?></label>
                <input type="text" name="meta_title" class="form-control" 
                       value="<?= $this->e($settings->meta_title ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label class="form-label"><?= lang('meta_description') ?? 'وصف الصفحة' ?></label>
                <textarea name="meta_description" class="form-control" rows="2"><?= $this->e($settings->meta_description ?? '') ?></textarea>
            </div>
            
            <div class="form-group">
                <label class="form-label"><?= lang('meta_keywords') ?? 'الكلمات المفتاحية' ?></label>
                <input type="text" name="meta_keywords" class="form-control" 
                       value="<?= $this->e($settings->meta_keywords ?? '') ?>" placeholder="كلمة1، كلمة2، كلمة3">
            </div>
        </div>
    </div>
    
    <!-- الفوتر -->
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title"><?= lang('footer_settings') ?? 'إعدادات الفوتر' ?></h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label class="form-label"><?= lang('footer_text') ?? 'نص الفوتر' ?></label>
                <textarea name="footer_text" class="form-control" rows="2"><?= $this->e($settings->footer_text ?? '') ?></textarea>
            </div>
            
            <div class="form-group">
                <label class="form-label"><?= lang('copyright_text') ?? 'نص حقوق النشر' ?></label>
                <input type="text" name="copyright_text" class="form-control" 
                       value="<?= $this->e($settings->copyright_text ?? '') ?>">
            </div>
        </div>
    </div>
    
    <div class="mt-3">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i>
            <?= lang('save_changes') ?? 'حفظ التغييرات' ?>
        </button>
    </div>
</form>

<style>
.feature-item {
    padding: 0.5rem 0;
    border-bottom: 1px solid var(--border);
}

.feature-item:last-child {
    border-bottom: none;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
}

.checkbox-label input[type="checkbox"] {
    width: 18px;
    height: 18px;
}
</style>

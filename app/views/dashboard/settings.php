<?php
/**
 * Settings View
 * صفحة الإعدادات
 */

?>

<div class="d-flex gap-3" style="flex-wrap: wrap;">
    <!-- Site Info -->
    <div class="card" style="flex: 2; min-width: 400px;">
        <div class="card-header">
            <h3 class="card-title"><?= lang('site_settings') ?></h3>
        </div>
        <div class="card-body">
            <form method="POST" action="<?= url('/dashboard/settings') ?>" enctype="multipart/form-data">
                <?= $this->csrf() ?>
                
                <!-- Logo Upload -->
                <div class="form-group">
                    <label class="form-label"><?= lang('site_logo') ?></label>
                    <div class="d-flex gap-3 align-center">
                        <?php if ($tenant->logo): ?>
                            <img src="<?= upload($tenant->logo) ?>" alt="Logo" 
                                 style="width: 80px; height: 80px; object-fit: contain; border-radius: 0.5rem; border: 1px solid var(--border);">
                        <?php endif; ?>
                        <div>
                            <input type="file" name="logo" class="form-control" accept="image/*">
                            <span class="form-hint">PNG, JPG, SVG - Max 2MB</span>
                        </div>
                    </div>
                </div>
                
                <!-- Site Name -->
                <div class="form-group">
                    <label class="form-label"><?= lang('site_name_label') ?> (العربية) *</label>
                    <input type="text" name="site_name" class="form-control" dir="rtl"
                           value="<?= $this->e($tenant->site_name) ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Site Name (English)</label>
                    <input type="text" name="site_name_en" class="form-control" dir="ltr"
                           value="<?= $this->e($tenant->site_name_en ?? '') ?>"
                           placeholder="Site name in English">
                    <span class="form-hint">(اختياري / Optional)</span>
                </div>
                
                <!-- Language -->
                <div class="form-group">
                    <label class="form-label"><?= lang('default_language') ?></label>
                    <select name="default_language" class="form-control">
                        <option value="ar" <?= $tenant->default_language === 'ar' ? 'selected' : '' ?>>
                            <?= lang('arabic') ?>
                        </option>
                        <option value="en" <?= $tenant->default_language === 'en' ? 'selected' : '' ?>>
                            <?= lang('english') ?>
                        </option>
                    </select>
                    <span class="form-hint"><?= lang('change_language') ?></span>
                </div>
                
                <!-- Contact Info -->
                <h4 class="mt-4 mb-3" style="font-size: 1rem; font-weight: 600;"><?= lang('contact_info') ?></h4>
                
                <div class="form-group">
                    <label class="form-label"><?= lang('contact_email') ?></label>
                    <input type="email" name="contact_email" class="form-control"
                           value="<?= $this->e($tenant->contact_email) ?>">
                </div>
                
                <div class="d-flex gap-2">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label"><?= lang('contact_phone') ?></label>
                        <input type="tel" name="contact_phone" class="form-control"
                               value="<?= $this->e($tenant->contact_phone) ?>">
                    </div>
                    
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label"><?= lang('contact_phone2') ?></label>
                        <input type="tel" name="contact_phone2" class="form-control"
                               value="<?= $this->e($tenant->contact_phone2) ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label"><?= lang('whatsapp') ?></label>
                    <input type="tel" name="contact_whatsapp" class="form-control"
                           value="<?= $this->e($tenant->contact_whatsapp) ?>">
                </div>
                
                <div class="form-group">
                    <label class="form-label"><?= lang('address') ?></label>
                    <textarea name="address" class="form-control" rows="2"><?= $this->e($tenant->address) ?></textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label"><?= lang('working_hours') ?></label>
                    <input type="text" name="working_hours" class="form-control"
                           value="<?= $this->e($tenant->working_hours) ?>"
                           placeholder="مثال: السبت - الخميس: 9 صباحاً - 6 مساءً">
                </div>
                
                <!-- Social Media -->
                <h4 class="mt-4 mb-3" style="font-size: 1rem; font-weight: 600;"><?= lang('social_media') ?></h4>
                
                <div class="d-flex gap-2">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label"><i class="fab fa-facebook"></i> <?= lang('facebook') ?></label>
                        <input type="url" name="facebook" class="form-control"
                               value="<?= $this->e($tenant->facebook) ?>">
                    </div>
                    
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label"><i class="fab fa-twitter"></i> <?= lang('twitter') ?></label>
                        <input type="url" name="twitter" class="form-control"
                               value="<?= $this->e($tenant->twitter) ?>">
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label"><i class="fab fa-instagram"></i> <?= lang('instagram') ?></label>
                        <input type="url" name="instagram" class="form-control"
                               value="<?= $this->e($tenant->instagram) ?>">
                    </div>
                    
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label"><i class="fab fa-linkedin"></i> <?= lang('linkedin') ?></label>
                        <input type="url" name="linkedin" class="form-control"
                               value="<?= $this->e($tenant->linkedin) ?>">
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label"><i class="fab fa-youtube"></i> <?= lang('youtube') ?></label>
                        <input type="url" name="youtube" class="form-control"
                               value="<?= $this->e($tenant->youtube) ?>">
                    </div>
                    
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label"><i class="fab fa-tiktok"></i> <?= lang('tiktok') ?></label>
                        <input type="url" name="tiktok" class="form-control"
                               value="<?= $this->e($tenant->tiktok) ?>">
                    </div>
                </div>
                
                <!-- SEO -->
                <h4 class="mt-4 mb-3" style="font-size: 1rem; font-weight: 600;"><?= lang('seo_settings') ?></h4>
                
                <div class="form-group">
                    <label class="form-label"><?= lang('meta_title') ?></label>
                    <input type="text" name="meta_title" class="form-control"
                           value="<?= $this->e($tenant->meta_title) ?>">
                    <span class="form-hint">يظهر في نتائج البحث</span>
                </div>
                
                <div class="form-group">
                    <label class="form-label"><?= lang('meta_description') ?> (العربية)</label>
                    <textarea name="meta_description" class="form-control" rows="2" dir="rtl"><?= $this->e($tenant->meta_description) ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Meta Description (English)</label>
                    <textarea name="meta_description_en" class="form-control" rows="2" dir="ltr" placeholder="Meta description in English"><?= $this->e($tenant->meta_description_en ?? '') ?></textarea>
                    <span class="form-hint">(اختياري / Optional)</span>
                </div>
                
                <div class="form-group">
                    <label class="form-label"><?= lang('meta_keywords') ?></label>
                    <input type="text" name="meta_keywords" class="form-control"
                           value="<?= $this->e($tenant->meta_keywords) ?>"
                           placeholder="كلمة1، كلمة2، كلمة3">
                </div>
                
                <!-- CTA Section -->
                <h4 class="mt-4 mb-3" style="font-size: 1rem; font-weight: 600;">قسم الدعوة لاتخاذ إجراء (CTA)</h4>
                
                <div class="form-group">
                    <div class="d-flex align-center gap-2">
                        <label class="form-label" style="margin-bottom: 0;">تفعيل القسم</label>
                        <div class="toggle-switch">
                            <input type="checkbox" id="cta_is_active" name="cta_is_active" value="1" class="toggle-input" <?= !empty($tenant->cta_is_active) ? 'checked' : '' ?>>
                            <label for="cta_is_active" class="toggle-label">
                                <span class="toggle-inner"></span>
                                <span class="toggle-switch-btn"></span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">عنوان CTA (العربية)</label>
                        <input type="text" name="cta_title" class="form-control" dir="rtl"
                               value="<?= $this->e($tenant->cta_title ?? '') ?>"
                               placeholder="مثال: جاهز لبدء مشروعك؟">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">CTA Title (English)</label>
                        <input type="text" name="cta_title_en" class="form-control" dir="ltr"
                               value="<?= $this->e($tenant->cta_title_en ?? '') ?>"
                               placeholder="Ready to start?">
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">نص CTA (العربية)</label>
                        <textarea name="cta_text" class="form-control" rows="2" dir="rtl"
                                  placeholder="مثال: تواصل معنا اليوم واحصل على استشارة مجانية"><?= $this->e($tenant->cta_text ?? '') ?></textarea>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">CTA Text (English)</label>
                        <textarea name="cta_text_en" class="form-control" rows="2" dir="ltr"
                                  placeholder="Contact us today"><?= $this->e($tenant->cta_text_en ?? '') ?></textarea>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">نص الزر (العربية)</label>
                        <input type="text" name="cta_button_text" class="form-control" dir="rtl"
                               value="<?= $this->e($tenant->cta_button_text ?? '') ?>"
                               placeholder="مثال: تواصل معنا">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Button Text (English)</label>
                        <input type="text" name="cta_button_text_en" class="form-control" dir="ltr"
                               value="<?= $this->e($tenant->cta_button_text_en ?? '') ?>"
                               placeholder="Contact Us">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">رابط الزر</label>
                    <input type="text" name="cta_link" class="form-control" dir="ltr"
                           value="<?= $this->e($tenant->cta_link ?? '#contact') ?>"
                           placeholder="#contact أو رابط كامل">
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    <?= lang('save_changes') ?>
                </button>
            </form>
        </div>
    </div>
    
    <!-- Theme & Colors -->
    <div style="flex: 1; min-width: 300px;">
        <!-- Theme Selection -->
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title"><?= lang('theme') ?></h3>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= url('/dashboard/settings/theme') ?>">
                    <?= $this->csrf() ?>
                    
                    <div class="theme-grid">
                        <?php foreach ($themes as $theme): ?>
                        <div class="theme-card <?= $tenant->theme_id == $theme->id ? 'selected' : '' ?>" 
                             data-theme-id="<?= $theme->id ?>">
                            <div class="theme-preview">
                                <?php if ($theme->preview_image): ?>
                                    <img src="<?= upload('themes/' . $theme->preview_image) ?>" alt="<?= $theme->name ?>">
                                <?php else: ?>
                                    <i class="fas fa-palette" style="font-size: 3rem;"></i>
                                <?php endif; ?>
                            </div>
                            <div class="theme-info">
                                <div class="theme-name"><?= $theme->name ?></div>
                                <div class="theme-category"><?= $theme->category ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <input type="hidden" name="theme_id" value="<?= $tenant->theme_id ?>">
                    
                    <button type="submit" class="btn btn-primary btn-block mt-3">
                        <?= lang('save') ?>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Colors -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= lang('colors') ?></h3>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= url('/dashboard/settings/colors') ?>">
                    <?= $this->csrf() ?>
                    
                    <div class="color-picker-group">
                        <div class="color-picker-item">
                            <label class="form-label"><?= lang('primary_color') ?></label>
                            <div class="color-picker-wrapper">
                                <input type="color" name="primary_color" class="color-input"
                                       value="<?= $tenant->primary_color ?: '#2563eb' ?>">
                                <span class="color-hex"><?= $tenant->primary_color ?: '#2563eb' ?></span>
                            </div>
                        </div>
                        
                        <div class="color-picker-item">
                            <label class="form-label"><?= lang('secondary_color') ?></label>
                            <div class="color-picker-wrapper">
                                <input type="color" name="secondary_color" class="color-input"
                                       value="<?= $tenant->secondary_color ?: '#1e40af' ?>">
                                <span class="color-hex"><?= $tenant->secondary_color ?: '#1e40af' ?></span>
                            </div>
                        </div>
                        
                        <div class="color-picker-item">
                            <label class="form-label"><?= lang('accent_color') ?></label>
                            <div class="color-picker-wrapper">
                                <input type="color" name="accent_color" class="color-input"
                                       value="<?= $tenant->accent_color ?: '#f59e0b' ?>">
                                <span class="color-hex"><?= $tenant->accent_color ?: '#f59e0b' ?></span>
                            </div>
                        </div>
                        
                        <div class="color-picker-item">
                            <label class="form-label"><?= lang('text_color') ?></label>
                            <div class="color-picker-wrapper">
                                <input type="color" name="text_color" class="color-input"
                                       value="<?= $tenant->text_color ?: '#1f2937' ?>">
                                <span class="color-hex"><?= $tenant->text_color ?: '#1f2937' ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block mt-3">
                        <?= lang('save_changes') ?>
                    </button>
                </form>
            </div>
        </div>

        <!-- Sections Visibility -->
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title"><?= lang('sections_visibility') ?? 'ظهور الأقسام' ?></h3>
            </div>
            <div class="card-body">
                <p style="color: #64748b; margin-bottom: 1rem;">
                    <?= lang('sections_visibility_desc') ?? 'تحكم في ظهور الأقسام في الصفحة الرئيسية لموقعك. يمكنك إخفاء الأقسام التي لا تحتاجها.' ?>
                </p>
                <form method="POST" action="<?= url('/dashboard/settings/sections') ?>">
                    <?= $this->csrf() ?>
                    
                    <div class="sections-toggle-list">
                        <?php 
                        $availableSections = [
                            'hero' => lang('section_hero') ?? 'البانر الرئيسي',
                            'services' => lang('section_services') ?? 'الخدمات',
                            'gallery' => lang('section_gallery') ?? 'معرض الأعمال',
                            'testimonials' => lang('section_testimonials') ?? 'آراء العملاء',
                            'contact' => lang('section_contact') ?? 'نموذج التواصل'
                        ];
                        
                        foreach ($availableSections as $key => $label): 
                            $isChecked = isset($sectionsConfig[$key]) ? $sectionsConfig[$key] : true;
                        ?>
                        <div class="section-toggle-item">
                            <div class="toggle-switch">
                                <input type="checkbox" 
                                       id="section_<?= $key ?>" 
                                       name="sections[<?= $key ?>]" 
                                       value="1"
                                       class="toggle-input"
                                       <?= $isChecked ? 'checked' : '' ?>>
                                <label for="section_<?= $key ?>" class="toggle-label">
                                    <span class="toggle-inner"></span>
                                    <span class="toggle-switch-btn"></span>
                                </label>
                            </div>
                            <div class="section-info">
                                <span class="section-name"><?= $label ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block mt-3">
                        <i class="fas fa-save"></i>
                        <?= lang('save_changes') ?>
                    </button>
                </form>
            </div>
        </div>

        <!-- Demo Data Import -->
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title"><?= lang('demo_data') ?? 'بيانات تجريبية' ?></h3>
            </div>
            <div class="card-body">
                <p style="color: #64748b; margin-bottom: 1rem;">
                    <?= lang('demo_data_desc') ?? 'استيراد بيانات تجريبية (خدمات، آراء عملاء، بانرات) لمعاينة شكل موقعك. سيتم استبدال أي بيانات موجودة.' ?>
                </p>
                <form method="POST" action="<?= url('/dashboard/settings/import-demo') ?>" 
                      onsubmit="return confirm('<?= lang('demo_data_confirm') ?? 'هل أنت متأكد؟ سيتم استبدال البيانات الموجودة.' ?>');">
                    <?= $this->csrf() ?>
                    <button type="submit" class="btn btn-outline" style="width: 100%;">
                        <i class="fas fa-download"></i>
                        <?= lang('import_demo_data') ?? 'استيراد بيانات تجريبية' ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Theme selection
document.querySelectorAll('.theme-card').forEach(card => {
    card.addEventListener('click', function() {
        document.querySelectorAll('.theme-card').forEach(c => c.classList.remove('selected'));
        this.classList.add('selected');
        document.querySelector('input[name="theme_id"]').value = this.dataset.themeId;
    });
});

// Color picker hex display
document.querySelectorAll('input[type="color"]').forEach(input => {
    input.addEventListener('input', function() {
        this.nextElementSibling.textContent = this.value;
    });
});
</script>

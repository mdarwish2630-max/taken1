<?php
/**
 * Theme Customization View
 * صفحة تخصيص الثيم
 */


$tenant = $tenant ?? Auth::tenant();
?>

<div class="page-header">
    <h1 class="h3 mb-0">
        <i class="fas fa-paint-brush me-2"></i>
        <?= lang('theme_customization') ?>
    </h1>
</div>

<form method="POST" action="<?= url('/dashboard/theme') ?>" id="themeForm">
    <?= $this->csrf() ?>
    
    <div class="row">
        <!-- Settings -->
        <div class="col-lg-6">
            <!-- Typography -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-font me-2"></i>
                        <?= lang('fonts') ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><?= lang('primary_font') ?></label>
                                <select name="primary_font" class="form-select">
                                    <?php foreach ($fonts as $fontName => $fontLabel): ?>
                                        <option value="<?= $fontName ?>" 
                                                <?= ($settings->primary_font ?? 'Tajawal') === $fontName ? 'selected' : '' ?>>
                                            <?= $fontLabel ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><?= lang('secondary_font') ?></label>
                                <select name="secondary_font" class="form-select">
                                    <?php foreach ($fonts as $fontName => $fontLabel): ?>
                                        <option value="<?= $fontName ?>" 
                                                <?= ($settings->secondary_font ?? 'Tajawal') === $fontName ? 'selected' : '' ?>>
                                            <?= $fontLabel ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><?= lang('base_font_size') ?></label>
                                <input type="number" name="base_font_size" class="form-control" 
                                       value="<?= $settings->base_font_size ?? 16 ?>" min="12" max="24">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><?= lang('heading_font_weight') ?></label>
                                <select name="heading_font_weight" class="form-select">
                                    <option value="400" <?= ($settings->heading_font_weight ?? '700') === '400' ? 'selected' : '' ?>>Regular (400)</option>
                                    <option value="500" <?= ($settings->heading_font_weight ?? '') === '500' ? 'selected' : '' ?>>Medium (500)</option>
                                    <option value="600" <?= ($settings->heading_font_weight ?? '') === '600' ? 'selected' : '' ?>>Semi Bold (600)</option>
                                    <option value="700" <?= ($settings->heading_font_weight ?? '700') === '700' ? 'selected' : '' ?>>Bold (700)</option>
                                    <option value="800" <?= ($settings->heading_font_weight ?? '') === '800' ? 'selected' : '' ?>>Extra Bold (800)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Colors -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-palette me-2"></i>
                        <?= lang('colors') ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><?= lang('primary_color') ?></label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" 
                                           id="primaryColorPicker" value="<?= $settings->primary_color ?? '#2563eb' ?>">
                                    <input type="text" name="primary_color" class="form-control" 
                                           id="primaryColorInput" value="<?= $settings->primary_color ?? '#2563eb' ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><?= lang('secondary_color') ?></label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" 
                                           id="secondaryColorPicker" value="<?= $settings->secondary_color ?? '#1e40af' ?>">
                                    <input type="text" name="secondary_color" class="form-control" 
                                           id="secondaryColorInput" value="<?= $settings->secondary_color ?? '#1e40af' ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><?= lang('accent_color') ?></label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" 
                                           id="accentColorPicker" value="<?= $settings->accent_color ?? '#f59e0b' ?>">
                                    <input type="text" name="accent_color" class="form-control" 
                                           id="accentColorInput" value="<?= $settings->accent_color ?? '#f59e0b' ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><?= lang('text_color') ?></label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" 
                                           id="textColorPicker" value="<?= $settings->text_color ?? '#1f2937' ?>">
                                    <input type="text" name="text_color" class="form-control" 
                                           id="textColorInput" value="<?= $settings->text_color ?? '#1f2937' ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><?= lang('background_color') ?></label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" 
                                           id="bgColorPicker" value="<?= $settings->background_color ?? '#ffffff' ?>">
                                    <input type="text" name="background_color" class="form-control" 
                                           id="bgColorInput" value="<?= $settings->background_color ?? '#ffffff' ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><?= lang('card_background') ?></label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" 
                                           id="cardBgPicker" value="<?= $settings->card_background ?? '#ffffff' ?>">
                                    <input type="text" name="card_background" class="form-control" 
                                           id="cardBgInput" value="<?= $settings->card_background ?? '#ffffff' ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Color Presets -->
                    <div class="mt-3">
                        <label class="form-label"><?= lang('color_presets') ?></label>
                        <div class="d-flex gap-2 flex-wrap">
                            <button type="button" class="btn btn-sm border" onclick="applyPreset('#2563eb', '#1e40af', '#f59e0b')">
                                <span class="d-flex align-items-center gap-1">
                                    <span style="width:16px;height:16px;background:#2563eb;border-radius:4px;"></span>
                                    أزرق
                                </span>
                            </button>
                            <button type="button" class="btn btn-sm border" onclick="applyPreset('#059669', '#047857', '#f59e0b')">
                                <span class="d-flex align-items-center gap-1">
                                    <span style="width:16px;height:16px;background:#059669;border-radius:4px;"></span>
                                    أخضر
                                </span>
                            </button>
                            <button type="button" class="btn btn-sm border" onclick="applyPreset('#7c3aed', '#5b21b6', '#f59e0b')">
                                <span class="d-flex align-items-center gap-1">
                                    <span style="width:16px;height:16px;background:#7c3aed;border-radius:4px;"></span>
                                    بنفسجي
                                </span>
                            </button>
                            <button type="button" class="btn btn-sm border" onclick="applyPreset('#dc2626', '#b91c1c', '#f59e0b')">
                                <span class="d-flex align-items-center gap-1">
                                    <span style="width:16px;height:16px;background:#dc2626;border-radius:4px;"></span>
                                    أحمر
                                </span>
                            </button>
                            <button type="button" class="btn btn-sm border" onclick="applyPreset('#f97316', '#ea580c', '#fbbf24')">
                                <span class="d-flex align-items-center gap-1">
                                    <span style="width:16px;height:16px;background:#f97316;border-radius:4px;"></span>
                                    برتقالي
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Layout -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-th-large me-2"></i>
                        <?= lang('layout') ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><?= lang('border_radius') ?></label>
                                <input type="range" name="border_radius" class="form-range" 
                                       min="0" max="24" value="<?= $settings->border_radius ?? 8 ?>"
                                       oninput="this.nextElementSibling.textContent = this.value + 'px'">
                                <span class="text-muted small"><?= ($settings->border_radius ?? 8) ?>px</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><?= lang('container_width') ?></label>
                                <input type="number" name="container_width" class="form-control" 
                                       value="<?= $settings->container_width ?? 1200 ?>" min="960" max="1400" step="20">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><?= lang('header_style') ?></label>
                                <select name="header_style" class="form-select">
                                    <option value="default" <?= ($settings->header_style ?? 'default') === 'default' ? 'selected' : '' ?>>
                                        <?= lang('default') ?>
                                    </option>
                                    <option value="centered" <?= ($settings->header_style ?? '') === 'centered' ? 'selected' : '' ?>>
                                        <?= lang('centered') ?>
                                    </option>
                                    <option value="minimal" <?= ($settings->header_style ?? '') === 'minimal' ? 'selected' : '' ?>>
                                        <?= lang('minimal') ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><?= lang('footer_style') ?></label>
                                <select name="footer_style" class="form-select">
                                    <option value="default" <?= ($settings->footer_style ?? 'default') === 'default' ? 'selected' : '' ?>>
                                        <?= lang('default') ?>
                                    </option>
                                    <option value="minimal" <?= ($settings->footer_style ?? '') === 'minimal' ? 'selected' : '' ?>>
                                        <?= lang('minimal') ?>
                                    </option>
                                    <option value="expanded" <?= ($settings->footer_style ?? '') === 'expanded' ? 'selected' : '' ?>>
                                        <?= lang('expanded') ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="header_fixed" id="headerFixed" value="1"
                               <?= ($settings->header_fixed ?? 0) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="headerFixed">
                            <?= lang('fixed_header') ?>
                        </label>
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="enable_animations" id="enableAnimations" value="1"
                               <?= ($settings->enable_animations ?? 1) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="enableAnimations">
                            <?= lang('enable_animations') ?>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Preview & Custom CSS -->
        <div class="col-lg-6">
            <!-- Preview -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-eye me-2"></i>
                        <?= lang('preview') ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="theme-preview" id="themePreview" style="background: <?= $settings->background_color ?? '#fff' ?>; border-radius: <?= ($settings->border_radius ?? 8) ?>px; overflow: hidden;">
                        <!-- Header -->
                        <div class="preview-header" style="background: linear-gradient(135deg, <?= $settings->primary_color ?? '#2563eb' ?>, <?= $settings->secondary_color ?? '#1e40af' ?>); padding: 1.5rem;">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 style="color: #fff; margin: 0;">عنوان الموقع</h4>
                                <div class="d-flex gap-2">
                                    <span style="color: #fff; opacity: 0.8;">الرئيسية</span>
                                    <span style="color: #fff; opacity: 0.8;">خدماتنا</span>
                                    <span style="color: #fff; opacity: 0.8;">تواصل</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Hero -->
                        <div class="preview-hero" style="background: linear-gradient(135deg, <?= $settings->primary_color ?? '#2563eb' ?>80, <?= $settings->secondary_color ?? '#1e40af' ?>80); padding: 3rem 1.5rem; text-align: center;">
                            <h2 style="color: #fff; margin-bottom: 0.5rem;">مرحباً بكم في موقعنا</h2>
                            <p style="color: #fff; opacity: 0.9; margin-bottom: 1.5rem;">نقدم لكم أفضل الخدمات</p>
                            <button class="preview-btn" style="background: <?= $settings->accent_color ?? '#f59e0b' ?>; color: #fff; border: none; padding: 0.75rem 2rem; border-radius: <?= ($settings->border_radius ?? 8) ?>px; cursor: pointer;">
                                ابدأ الآن
                            </button>
                        </div>
                        
                        <!-- Services -->
                        <div class="preview-services" style="padding: 2rem 1.5rem;">
                            <h3 style="color: <?= $settings->text_color ?? '#1f2937' ?>; text-align: center; margin-bottom: 1.5rem;">خدماتنا</h3>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="preview-card" style="background: <?= $settings->card_background ?? '#fff' ?>; padding: 1.5rem; border-radius: <?= (($settings->card_radius ?? 12)) ?>px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center;">
                                        <div style="width: 50px; height: 50px; background: <?= $settings->primary_color ?? '#2563eb' ?>; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                                            <i class="fas fa-wrench" style="color: #fff;"></i>
                                        </div>
                                        <h5 style="color: <?= $settings->text_color ?? '#1f2937' ?>; margin-bottom: 0.5rem;">خدمة 1</h5>
                                        <p style="color: <?= $settings->text_muted_color ?? '#6b7280' ?>; font-size: 0.875rem; margin: 0;">وصف الخدمة</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="preview-card" style="background: <?= $settings->card_background ?? '#fff' ?>; padding: 1.5rem; border-radius: <?= (($settings->card_radius ?? 12)) ?>px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center;">
                                        <div style="width: 50px; height: 50px; background: <?= $settings->primary_color ?? '#2563eb' ?>; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                                            <i class="fas fa-tools" style="color: #fff;"></i>
                                        </div>
                                        <h5 style="color: <?= $settings->text_color ?? '#1f2937' ?>; margin-bottom: 0.5rem;">خدمة 2</h5>
                                        <p style="color: <?= $settings->text_muted_color ?? '#6b7280' ?>; font-size: 0.875rem; margin: 0;">وصف الخدمة</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="preview-card" style="background: <?= $settings->card_background ?? '#fff' ?>; padding: 1.5rem; border-radius: <?= (($settings->card_radius ?? 12)) ?>px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center;">
                                        <div style="width: 50px; height: 50px; background: <?= $settings->primary_color ?? '#2563eb' ?>; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                                            <i class="fas fa-cog" style="color: #fff;"></i>
                                        </div>
                                        <h5 style="color: <?= $settings->text_color ?? '#1f2937' ?>; margin-bottom: 0.5rem;">خدمة 3</h5>
                                        <p style="color: <?= $settings->text_muted_color ?? '#6b7280' ?>; font-size: 0.875rem; margin: 0;">وصف الخدمة</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Footer -->
                        <div class="preview-footer" style="background: <?= $settings->text_color ?? '#1f2937' ?>; padding: 1.5rem; text-align: center;">
                            <p style="color: #fff; opacity: 0.7; margin: 0; font-size: 0.875rem;">
                                جميع الحقوق محفوظة © 2024
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Custom CSS -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-code me-2"></i>
                        CSS <?= lang('custom') ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">CSS <?= lang('custom') ?></label>
                        <textarea name="custom_css" class="form-control font-monospace" rows="6" 
                                  placeholder="/* أضف CSS مخصص هنا */
.example {
    color: red;
}"><?= htmlspecialchars($settings->custom_css ?? '') ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">JavaScript <?= lang('custom') ?></label>
                        <textarea name="custom_js" class="form-control font-monospace" rows="4" 
                                  placeholder="// أضف JavaScript مخصص هنا"><?= htmlspecialchars($settings->custom_js ?? '') ?></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        <?= lang('save_changes') ?>
                    </button>
                    
                    <button type="button" class="btn btn-outline-danger ms-2" 
                            onclick="resetToDefault()">
                        <i class="fas fa-undo me-2"></i>
                        <?= lang('reset_to_default') ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
// Sync color pickers with text inputs
document.querySelectorAll('input[type="color"]').forEach(picker => {
    picker.addEventListener('input', function() {
        this.nextElementSibling.value = this.value;
        updatePreview();
    });
});

document.querySelectorAll('input[type="text"][name$="_color"]').forEach(input => {
    input.addEventListener('input', function() {
        this.previousElementSibling.value = this.value;
        updatePreview();
    });
});

function applyPreset(primary, secondary, accent) {
    document.getElementById('primaryColorPicker').value = primary;
    document.getElementById('primaryColorInput').value = primary;
    document.getElementById('secondaryColorPicker').value = secondary;
    document.getElementById('secondaryColorInput').value = secondary;
    document.getElementById('accentColorPicker').value = accent;
    document.getElementById('accentColorInput').value = accent;
    updatePreview();
}

function updatePreview() {
    const preview = document.getElementById('themePreview');
    const primary = document.getElementById('primaryColorInput').value;
    const secondary = document.getElementById('secondaryColorInput').value;
    const accent = document.getElementById('accentColorInput').value;
    const bg = document.getElementById('bgColorInput').value;
    const cardBg = document.getElementById('cardBgInput').value;
    const text = document.getElementById('textColorInput').value;
    
    // Update preview elements
    preview.style.background = bg;
    preview.querySelectorAll('.preview-header, .preview-hero').forEach(el => {
        el.style.background = `linear-gradient(135deg, ${primary}, ${secondary})`;
    });
    preview.querySelectorAll('.preview-card').forEach(el => {
        el.style.background = cardBg;
        el.style.borderRadius = document.querySelector('input[name="border_radius"]').value + 'px';
    });
    preview.querySelectorAll('h3, h5').forEach(el => {
        el.style.color = text;
    });
    preview.querySelectorAll('.preview-btn').forEach(el => {
        el.style.background = accent;
    });
}

function resetToDefault() {
    if (confirm('<?= lang('confirm_reset') ?>')) {
        fetch('<?= url('/dashboard/theme/reset') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error');
            }
        });
    }
}
</script>

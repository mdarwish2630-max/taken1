<?php
/**
 * Admin - Plan Form
 * نموذج إضافة/تعديل خطة
 * — مصحح: أسماء الحقول تتطابق مع الأعمدة الحقيقية في الجدول —
 */

// دالة مساعدة لاستخراج ميزة من JSON
function planHasFeature($plan, $feat) {
    if (!empty($plan->features)) {
        $arr = json_decode($plan->features, true);
        if (is_array($arr)) return in_array($feat, $arr);
    }
    return false;
}

$plan = $plan ?? null;
?>

<div class="page-header">
    <h1 class="page-title">
        <?= isset($plan) ? (lang('edit_plan') ?? 'تعديل الخطة') : (lang('add_plan') ?? 'إضافة خطة جديدة') ?>
    </h1>
</div>

<form method="POST" action="<?= isset($plan) ? url('/admin/plans/edit/' . $plan->id) : url('/admin/plans/add') ?>">
    <?= $this->csrf() ?>
    
    <div class="d-flex gap-3" style="flex-wrap: wrap;">
        <!-- معلومات أساسية -->
        <div class="card" style="flex: 2; min-width: 400px;">
            <div class="card-header">
                <h3 class="card-title"><?= lang('basic_info') ?? 'معلومات أساسية' ?></h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label"><?= lang('plan_name') ?? 'اسم الخطة' ?> *</label>
                    <input type="text" name="name" class="form-control" 
                           value="<?= $this->e($plan->name ?? '') ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label"><?= lang('slug') ?? 'المعرف' ?></label>
                    <input type="text" name="slug" class="form-control" 
                           value="<?= $this->e($plan->slug ?? '') ?>" 
                           placeholder="مثال: basic, professional, enterprise">
                    <span class="form-hint"><?= lang('slug_hint') ?? 'يستخدم في الروابط والتعريف الفريد' ?></span>
                </div>
                
                <div class="form-group">
                    <label class="form-label"><?= lang('description') ?? 'الوصف' ?></label>
                    <textarea name="description" class="form-control" rows="3"><?= $this->e($plan->description ?? '') ?></textarea>
                </div>
                
                <div class="d-flex gap-2">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label"><?= lang('price') ?? 'السعر الشهري' ?> *</label>
                        <input type="number" name="price_monthly" class="form-control" 
                               value="<?= $plan->price_monthly ?? 0 ?>" step="0.01" min="0" required>
                    </div>
                    
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">السعر السنوي</label>
                        <input type="number" name="price_yearly" class="form-control" 
                               value="<?= $plan->price_yearly ?? '' ?>" step="0.01" min="0"
                               placeholder="اتركه فارغاً">
                    </div>
                    
                    <div class="form-group" style="width: 100px;">
                        <label class="form-label"><?= lang('currency') ?? 'العملة' ?></label>
                        <select name="currency" class="form-control">
                            <option value="SAR" <?= ($plan->currency ?? 'SAR') === 'SAR' ? 'selected' : '' ?>>SAR</option>
                            <option value="USD" <?= ($plan->currency ?? '') === 'USD' ? 'selected' : '' ?>>USD</option>
                            <option value="AED" <?= ($plan->currency ?? '') === 'AED' ? 'selected' : '' ?>>AED</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">المميزات (ميزة واحدة في كل سطر)</label>
                    <textarea name="features" class="form-control" rows="4" placeholder="أدخل كل ميزة في سطر منفصل"><?php 
                        $featVal = '';
                        if (!empty($plan->features)) {
                            $decoded = json_decode($plan->features, true);
                            if (is_array($decoded)) {
                                $featVal = implode("\n", $decoded);
                            } else {
                                $featVal = $plan->features;
                            }
                        }
                        echo $this->e($featVal);
                    ?></textarea>
                </div>
            </div>
        </div>
        
        <!-- ميزات وحدود -->
        <div style="flex: 1; min-width: 300px;">
            <!-- ميزات -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?= lang('features') ?? 'الميزات' ?></h3>
                </div>
                <div class="card-body">
                    <div class="features-list">
                        <div class="feature-item">
                            <label class="checkbox-label">
                                <input type="checkbox" name="custom_domain" value="1" 
                                       <?= ($plan->custom_domain ?? 0) ? 'checked' : '' ?>>
                                <span><?= lang('custom_domain') ?? 'دومين مخصص' ?></span>
                            </label>
                        </div>
                        
                        <div class="feature-item">
                            <label class="checkbox-label">
                                <input type="checkbox" name="remove_branding" value="1" 
                                       <?= ($plan->remove_branding ?? 0) ? 'checked' : '' ?>>
                                <span>إزالة العلامة التجارية</span>
                            </label>
                        </div>
                        
                        <div class="feature-item">
                            <label class="checkbox-label">
                                <input type="checkbox" name="analytics_access" value="1" 
                                       <?= ($plan->analytics_access ?? 0) ? 'checked' : '' ?>>
                                <span><?= lang('analytics') ?? 'إحصائيات متقدمة' ?></span>
                            </label>
                        </div>
                        
                        <div class="feature-item">
                            <label class="checkbox-label">
                                <input type="checkbox" name="priority_support" value="1" 
                                       <?= ($plan->priority_support ?? 0) ? 'checked' : '' ?>>
                                <span>دعم ذو أولوية</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- الحالة -->
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title"><?= lang('status_settings') ?? 'إعدادات الحالة' ?></h3>
                </div>
                <div class="card-body">
                    <div class="feature-item">
                        <label class="checkbox-label">
                            <input type="checkbox" name="is_active" value="1" 
                                   <?= ($plan->is_active ?? 1) ? 'checked' : '' ?>>
                            <span><?= lang('active') ?? 'نشط' ?></span>
                        </label>
                    </div>
                    
                    <div class="feature-item">
                        <label class="checkbox-label">
                            <input type="checkbox" name="is_popular" value="1" 
                                   <?= ($plan->is_popular ?? 0) ? 'checked' : '' ?>>
                            <span><?= lang('popular') ?? 'الأكثر شعبية' ?></span>
                        </label>
                    </div>
                    
                    <div class="form-group mt-2">
                        <label class="form-label"><?= lang('sort_order') ?? 'ترتيب العرض' ?></label>
                        <input type="number" name="display_order" class="form-control" 
                               value="<?= $plan->display_order ?? 0 ?>" min="0">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- الحدود -->
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title"><?= lang('limits') ?? 'الحدود والقيود' ?></h3>
        </div>
        <div class="card-body">
            <p style="color: #64748b; margin-bottom: 1rem;">
                <?= lang('limits_hint') ?? 'استخدم -1 للقيمة غير المحدودة' ?>
            </p>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">
                <div class="form-group">
                    <label class="form-label"><?= lang('max_services') ?? 'الحد الأقصى للخدمات' ?></label>
                    <input type="number" name="max_services" class="form-control" 
                           value="<?= $plan->max_services ?? -1 ?>">
                </div>
                
                <div class="form-group">
                    <label class="form-label">الحد الأقصى لمعرض الصور</label>
                    <input type="number" name="max_gallery" class="form-control" 
                           value="<?= $plan->max_gallery ?? -1 ?>">
                </div>
                
                <div class="form-group">
                    <label class="form-label"><?= lang('max_banners') ?? 'الحد الأقصى للبانرات' ?></label>
                    <input type="number" name="max_banners" class="form-control" 
                           value="<?= $plan->max_banners ?? -1 ?>">
                </div>
                
                <div class="form-group">
                    <label class="form-label"><?= lang('max_pages') ?? 'الحد الأقصى للصفحات' ?></label>
                    <input type="number" name="max_pages" class="form-control" 
                           value="<?= $plan->max_pages ?? -1 ?>">
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-3">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i>
            <?= lang('save') ?? 'حفظ' ?>
        </button>
        <a href="<?= url('/admin/plans') ?>" class="btn btn-outline">
            <?= lang('cancel') ?? 'إلغاء' ?>
        </a>
    </div>
</form>

<style>
.features-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.feature-item {
    padding: 0.5rem;
    background: var(--light);
    border-radius: var(--radius);
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
    cursor: pointer;
}
</style>

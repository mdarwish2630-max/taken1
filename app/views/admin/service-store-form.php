<?php
/**
 * Admin - Service Store Form (Add / Edit)
 * نموذج إضافة/تعديل خدمة مدفوعة
 */

$isEdit    = isset($service) && $service !== null;
$formTitle = $isEdit ? 'تعديل الخدمة' : 'إضافة خدمة جديدة';
$formAction = $isEdit ? url('/admin/services-store/edit/' . $service->id) : url('/admin/services-store/add');
$formMethod = $isEdit ? 'POST' : 'POST';

$vals = [
    'title'             => $service->title ?? '',
    'slug'              => $service->slug ?? '',
    'description'       => $service->description ?? '',
    'price'             => $service->price ?? 0,
    'currency'          => $service->currency ?? 'SAR',
    'icon'              => $service->icon ?? '',
    'category'          => $service->category ?? '',
    'payment_link'      => $service->payment_link ?? '',
    'is_recurring'      => $service->is_recurring ?? 0,
    'recurring_period'  => $service->recurring_period ?? 'onetime',
    'is_active'         => $service->is_active ?? 1,
    'sort_order'        => $service->sort_order ?? 0,
    'max_quantity'      => $service->max_quantity ?? 1,
    'requires_approval' => $service->requires_approval ?? 0,
];

$recurringPeriods = [
    'onetime'  => 'لمرة واحدة',
    'monthly'  => 'شهري',
    'yearly'   => 'سنوي',
];

$currencies = [
    'SAR' => 'ريال سعودي (SAR)',
    'USD' => 'دولار أمريكي (USD)',
    'EUR' => 'يورو (EUR)',
];
?>

<div style="margin-bottom: 1.5rem;">
    <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--dark); margin: 0;">
        <i class="fas fa-store" style="color: var(--primary); margin-left: 0.5rem;"></i>
        <?= $formTitle ?>
    </h1>
    <p style="font-size: 0.875rem; color: #64748b; margin: 0.25rem 0 0 0;">
        <?= $isEdit ? 'قم بتعديل بيانات الخدمة المدفوعة' : 'أدخل بيانات الخدمة المدفوعة الجديدة' ?>
    </p>
</div>

<?php if (Session::has('error')): ?>
<div style="padding: 0.75rem 1rem; background: #fef2f2; border: 1px solid #fecaca; border-radius: var(--radius); color: #991b1b; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
    <i class="fas fa-exclamation-circle" style="color: var(--danger);"></i>
    <?= Session::getError() ?>
</div>
<?php endif; ?>

<form method="<?= $formMethod ?>" action="<?= $formAction ?>">
    <?= $this->csrf() ?>

    <div style="display: flex; gap: 1.5rem; flex-wrap: wrap;">

        <!-- ========== LEFT COLUMN: Basic Info ========== -->
        <div style="flex: 2; min-width: 400px; display: flex; flex-direction: column; gap: 1.5rem;">

            <!-- Basic Info Card -->
            <div style="background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden;">
                <div style="padding: 1rem 1.25rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 0.5rem;">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: linear-gradient(135deg, #6366f1, #8b5cf6); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-info-circle" style="color: #fff; font-size: 0.8rem;"></i>
                    </div>
                    <h3 style="font-size: 1rem; font-weight: 600; color: var(--dark); margin: 0;">المعلومات الأساسية</h3>
                </div>
                <div style="padding: 1.25rem;">

                    <!-- Title -->
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--dark); margin-bottom: 0.375rem;">
                            عنوان الخدمة <span style="color: var(--danger);">*</span>
                        </label>
                        <input type="text" name="title" id="serviceTitle" required
                               value="<?= $this->e($vals['title']) ?>"
                               placeholder="مثال: نطاق مخصص .com"
                               style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid var(--border); border-radius: var(--radius); font-size: 0.875rem; color: var(--dark); background: var(--white); transition: var(--transition); outline: none; font-family: inherit;"
                               onfocus="this.style.borderColor='var(--primary)';this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                               onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
                    </div>

                    <!-- Slug -->
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--dark); margin-bottom: 0.375rem;">
                            المعرف (Slug)
                        </label>
                        <input type="text" name="slug" id="serviceSlug"
                               value="<?= $this->e($vals['slug']) ?>"
                               placeholder="مثال: custom-domain-com"
                               style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid var(--border); border-radius: var(--radius); font-size: 0.875rem; color: var(--dark); background: var(--white); transition: var(--transition); outline: none; direction: ltr; text-align: left; font-family: inherit;"
                               onfocus="this.style.borderColor='var(--primary)';this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                               onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
                        <span style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.25rem; display: block;">
                            <i class="fas fa-circle-info" style="margin-left: 0.25rem;"></i>
                            يُولَّد تلقائياً من العنوان. يُستخدم في الروابط.
                        </span>
                    </div>

                    <!-- Description -->
                    <div style="margin-bottom: 0;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--dark); margin-bottom: 0.375rem;">
                            وصف الخدمة
                        </label>
                        <textarea name="description" rows="4"
                                  placeholder="اكتب وصفاً تفصيلياً للخدمة..."
                                  style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid var(--border); border-radius: var(--radius); font-size: 0.875rem; color: var(--dark); background: var(--white); transition: var(--transition); outline: none; resize: vertical; min-height: 100px; font-family: inherit;"
                                  onfocus="this.style.borderColor='var(--primary)';this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                                  onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'"><?= $this->e($vals['description']) ?></textarea>
                    </div>

                </div>
            </div>

            <!-- Pricing Card -->
            <div style="background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden;">
                <div style="padding: 1rem 1.25rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 0.5rem;">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-coins" style="color: #fff; font-size: 0.8rem;"></i>
                    </div>
                    <h3 style="font-size: 1rem; font-weight: 600; color: var(--dark); margin: 0;">التسعير والدفع</h3>
                </div>
                <div style="padding: 1.25rem;">

                    <!-- Price & Currency Row -->
                    <div style="display: flex; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;">
                        <div style="flex: 1; min-width: 150px;">
                            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--dark); margin-bottom: 0.375rem;">
                                السعر <span style="color: var(--danger);">*</span>
                            </label>
                            <input type="number" name="price" step="0.01" min="0" required
                                   value="<?= $vals['price'] ?>"
                                   placeholder="0.00"
                                   style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid var(--border); border-radius: var(--radius); font-size: 0.875rem; color: var(--dark); background: var(--white); transition: var(--transition); outline: none; direction: ltr; text-align: left; font-family: inherit;"
                                   onfocus="this.style.borderColor='var(--primary)';this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                                   onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
                        </div>
                        <div style="min-width: 180px;">
                            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--dark); margin-bottom: 0.375rem;">
                                العملة
                            </label>
                            <select name="currency"
                                    style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid var(--border); border-radius: var(--radius); font-size: 0.875rem; color: var(--dark); background: var(--white); transition: var(--transition); outline: none; cursor: pointer; font-family: inherit;"
                                    onfocus="this.style.borderColor='var(--primary)';this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                                    onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
                                <?php foreach ($currencies as $code => $label): ?>
                                <option value="<?= $code ?>" <?= $vals['currency'] === $code ? 'selected' : '' ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Payment Link -->
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--dark); margin-bottom: 0.375rem;">
                            رابط الدفع
                        </label>
                        <div style="position: relative;">
                            <span style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.8rem; pointer-events: none;">
                                <i class="fas fa-link"></i>
                            </span>
                            <input type="text" name="payment_link"
                                   value="<?= $this->e($vals['payment_link']) ?>"
                                   placeholder="https://pay.example.com/..."
                                   style="width: 100%; padding: 0.625rem 2.25rem 0.625rem 0.875rem; border: 1px solid var(--border); border-radius: var(--radius); font-size: 0.875rem; color: var(--dark); background: var(--white); transition: var(--transition); outline: none; direction: ltr; text-align: left; font-family: inherit;"
                                   onfocus="this.style.borderColor='var(--primary)';this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                                   onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
                        </div>
                    </div>

                    <!-- Recurring Row -->
                    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                        <div style="min-width: 160px;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.85rem; font-weight: 600; color: var(--dark); padding: 0.625rem 0.875rem; border: 1px solid var(--border); border-radius: var(--radius); background: var(--white); transition: var(--transition); height: 42px;"
                                   onmouseenter="this.style.borderColor='var(--primary)'"
                                   onmouseleave="this.style.borderColor='var(--border)'">
                                <input type="checkbox" name="is_recurring" value="1" id="isRecurring"
                                       <?= $vals['is_recurring'] ? 'checked' : '' ?>
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: var(--primary);">
                                <span>اشتراك متجدد</span>
                            </label>
                        </div>
                        <div style="flex: 1; min-width: 150px;" id="recurringPeriodWrap">
                            <select name="recurring_period" id="recurringPeriod"
                                    style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid var(--border); border-radius: var(--radius); font-size: 0.875rem; color: var(--dark); background: var(--white); transition: var(--transition); outline: none; cursor: pointer; font-family: inherit; height: 42px;"
                                    onfocus="this.style.borderColor='var(--primary)';this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                                    onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'"
                                    <?= !$vals['is_recurring'] ? 'disabled' : '' ?>>
                                <?php foreach ($recurringPeriods as $key => $label): ?>
                                <option value="<?= $key ?>" <?= $vals['recurring_period'] === $key ? 'selected' : '' ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- ========== RIGHT COLUMN: Settings ========== -->
        <div style="flex: 1; min-width: 300px; display: flex; flex-direction: column; gap: 1.5rem;">

            <!-- Appearance Card -->
            <div style="background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden;">
                <div style="padding: 1rem 1.25rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 0.5rem;">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: linear-gradient(135deg, #ec4899, #f43f5e); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-paint-brush" style="color: #fff; font-size: 0.8rem;"></i>
                    </div>
                    <h3 style="font-size: 1rem; font-weight: 600; color: var(--dark); margin: 0;">المظهر والعرض</h3>
                </div>
                <div style="padding: 1.25rem;">

                    <!-- Category -->
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--dark); margin-bottom: 0.375rem;">
                            الفئة <span style="color: var(--danger);">*</span>
                        </label>
                        <select name="category" required
                                style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid var(--border); border-radius: var(--radius); font-size: 0.875rem; color: var(--dark); background: var(--white); transition: var(--transition); outline: none; cursor: pointer; font-family: inherit;"
                                onfocus="this.style.borderColor='var(--primary)';this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                                onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
                            <option value="" disabled <?= empty($vals['category']) ? 'selected' : '' ?>>اختر الفئة...</option>
                            <?php foreach ($categories as $catKey => $catLabel): ?>
                            <option value="<?= $catKey ?>" <?= ($vals['category'] === $catKey) ? 'selected' : '' ?>>
                                <?= $catLabel ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Icon -->
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--dark); margin-bottom: 0.375rem;">
                            أيقونة الخدمة
                        </label>
                        <div style="position: relative;">
                            <span style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.8rem; pointer-events: none;">
                                <i class="fas fa-icons"></i>
                            </span>
                            <input type="text" name="icon" id="serviceIcon"
                                   value="<?= $this->e($vals['icon']) ?>"
                                   placeholder="مثال: fas fa-globe"
                                   style="width: 100%; padding: 0.625rem 2.25rem 0.625rem 0.875rem; border: 1px solid var(--border); border-radius: var(--radius); font-size: 0.875rem; color: var(--dark); background: var(--white); transition: var(--transition); outline: none; direction: ltr; text-align: left; font-family: inherit;"
                                   onfocus="this.style.borderColor='var(--primary)';this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                                   onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'"
                                   oninput="document.getElementById('iconPreview').className=this.value||'fas fa-cube'">
                        </div>
                        <div style="margin-top: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                            <span style="font-size: 0.75rem; color: #94a3b8;">معاينة:</span>
                            <div style="width: 36px; height: 36px; border-radius: 8px; background: var(--light); display: flex; align-items: center; justify-content: center;">
                                <i id="iconPreview" class="<?= $vals['icon'] ?: 'fas fa-cube' ?>" style="color: var(--primary); font-size: 1rem;"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--dark); margin-bottom: 0.375rem;">
                            ترتيب العرض
                        </label>
                        <input type="number" name="sort_order" min="0"
                               value="<?= $vals['sort_order'] ?>"
                               style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid var(--border); border-radius: var(--radius); font-size: 0.875rem; color: var(--dark); background: var(--white); transition: var(--transition); outline: none; direction: ltr; text-align: left; font-family: inherit;"
                               onfocus="this.style.borderColor='var(--primary)';this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                               onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
                        <span style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.25rem; display: block;">
                            <i class="fas fa-circle-info" style="margin-left: 0.25rem;"></i>
                            القيمة الأصغر تظهر أولاً
                        </span>
                    </div>

                </div>
            </div>

            <!-- Status & Limits Card -->
            <div style="background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden;">
                <div style="padding: 1rem 1.25rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 0.5rem;">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: linear-gradient(135deg, #f59e0b, #d97706); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-sliders" style="color: #fff; font-size: 0.8rem;"></i>
                    </div>
                    <h3 style="font-size: 1rem; font-weight: 600; color: var(--dark); margin: 0;">الحالة والقيود</h3>
                </div>
                <div style="padding: 1.25rem;">

                    <!-- is_active -->
                    <div style="padding: 0.75rem; background: var(--light); border-radius: var(--radius); margin-bottom: 0.75rem;">
                        <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;">
                            <input type="checkbox" name="is_active" value="1"
                                   <?= $vals['is_active'] ? 'checked' : '' ?>
                                   style="width: 18px; height: 18px; cursor: pointer; accent-color: var(--success);">
                            <div>
                                <span style="font-size: 0.85rem; font-weight: 600; color: var(--dark);">الخدمة نشطة</span>
                                <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.125rem;">
                                    <i class="fas fa-eye" style="margin-left: 0.25rem;"></i>
                                    ستظهر الخدمة في المتجر للمستخدمين
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- requires_approval -->
                    <div style="padding: 0.75rem; background: var(--light); border-radius: var(--radius); margin-bottom: 0.75rem;">
                        <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;">
                            <input type="checkbox" name="requires_approval" value="1"
                                   <?= $vals['requires_approval'] ? 'checked' : '' ?>
                                   style="width: 18px; height: 18px; cursor: pointer; accent-color: var(--warning);">
                            <div>
                                <span style="font-size: 0.85rem; font-weight: 600; color: var(--dark);">تتطلب موافقة</span>
                                <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.125rem;">
                                    <i class="fas fa-shield-check" style="margin-left: 0.25rem;"></i>
                                    يجب مراجعة الطلب قبل تفعيله
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- max_quantity -->
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--dark); margin-bottom: 0.375rem;">
                            الكمية القصوى لكل طلب
                        </label>
                        <input type="number" name="max_quantity" min="1"
                               value="<?= $vals['max_quantity'] ?>"
                               style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid var(--border); border-radius: var(--radius); font-size: 0.875rem; color: var(--dark); background: var(--white); transition: var(--transition); outline: none; direction: ltr; text-align: left; font-family: inherit;"
                               onfocus="this.style.borderColor='var(--primary)';this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                               onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- ========== Form Actions ========== -->
    <div style="margin-top: 1.5rem; display: flex; align-items: center; gap: 0.75rem; padding: 1.25rem; background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow);">
        <button type="submit"
                style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.625rem 1.5rem; background: var(--primary); color: var(--white); border: none; border-radius: var(--radius); font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: var(--transition); font-family: inherit;"
                onmouseenter="this.style.background='var(--primary-dark)'"
                onmouseleave="this.style.background='var(--primary)'">
            <i class="fas fa-save"></i>
            <?= $isEdit ? 'حفظ التعديلات' : 'إضافة الخدمة' ?>
        </button>
        <a href="<?= url('/admin/services-store') ?>"
           style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.625rem 1.25rem; background: var(--white); color: var(--secondary); border: 1px solid var(--border); border-radius: var(--radius); font-size: 0.875rem; font-weight: 500; cursor: pointer; text-decoration: none; transition: var(--transition); font-family: inherit;"
           onmouseenter="this.style.background='var(--light)'"
           onmouseleave="this.style.background='var(--white)'">
            <i class="fas fa-arrow-right"></i>
            إلغاء والعودة
        </a>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('serviceTitle');
    const slugInput  = document.getElementById('serviceSlug');
    const recurring  = document.getElementById('isRecurring');
    const period     = document.getElementById('recurringPeriod');

    // Auto-generate slug from title
    if (titleInput && slugInput) {
        titleInput.addEventListener('input', function() {
            if (!slugInput.dataset.manual) {
                let slug = this.value.trim()
                    .replace(/\s+/g, '-')
                    .replace(/[^\u0600-\u06FFa-zA-Z0-9\-]/g, '')
                    .toLowerCase();
                slugInput.value = slug;
            }
        });

        slugInput.addEventListener('input', function() {
            if (this.value.length > 0) {
                this.dataset.manual = '1';
            }
        });
    }

    // Toggle recurring period select
    if (recurring && period) {
        recurring.addEventListener('change', function() {
            period.disabled = !this.checked;
        });
    }
});
</script>

<?php
/**
 * Admin Themes View - إدارة القوالب مع التحكم الكامل
 * تفعيل/تعطيل، تصنيف مدفوع/مجاني، سعر، رابط دفع
 * تصميم احترافي مع صور بريفيو
 */

$dir = Language::direction();
$themeColors = [
    'maintenance' => ['primary' => '#ea580c', 'secondary' => '#1e3a5f'],
    'decor' => ['primary' => '#d4af37', 'secondary' => '#722F37'],
    'electric' => ['primary' => '#fbbf24', 'secondary' => '#d97706'],
    'plumbing' => ['primary' => '#0891b2', 'secondary' => '#0e7490'],
    'cleaning' => ['primary' => '#0ea5e9', 'secondary' => '#0284c7'],
    'general' => ['primary' => '#2563eb', 'secondary' => '#1e40af'],
    'medical' => ['primary' => '#059669', 'secondary' => '#064e3b'],
    'realestate' => ['primary' => '#7c3aed', 'secondary' => '#4c1d95'],
    'restaurant' => ['primary' => '#dc2626', 'secondary' => '#991b1b'],
    'education' => ['primary' => '#2563eb', 'secondary' => '#1e40af'],
    'fitness' => ['primary' => '#e11d48', 'secondary' => '#9f1239'],
    'legal' => ['primary' => '#1e40af', 'secondary' => '#1e3a5f'],
];
$themeIcons = [
    'maintenance' => 'fa-wrench',
    'decor' => 'fa-paint-brush',
    'electric' => 'fa-bolt',
    'plumbing' => 'fa-faucet',
    'cleaning' => 'fa-spray-can',
    'general' => 'fa-cube',
    'medical' => 'fa-heartbeat',
    'realestate' => 'fa-building',
    'restaurant' => 'fa-utensils',
    'education' => 'fa-graduation-cap',
    'fitness' => 'fa-dumbbell',
    'legal' => 'fa-balance-scale',
];
?>

<!-- Page Header -->
<div class="page-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
    <div>
        <h1 class="page-title">
            <i class="fas fa-palette"></i>
            إدارة القوالب
        </h1>
        <p style="color:var(--secondary, #64748b); margin:0.3rem 0 0; font-size:0.88rem;">
            إدارة وتخصيص القوالب المتاحة للمشتركين - تحكم كامل بالمحتوى والأسعار
        </p>
    </div>
    <div style="display:flex; gap:0.5rem; align-items:center; flex-wrap:wrap;">
        <span style="background:rgba(16,185,129,0.1); color:#059669; padding:0.4rem 1rem; border-radius:20px; font-size:0.82rem; font-weight:600; border:1px solid rgba(16,185,129,0.2);">
            <i class="fas fa-check-circle"></i>
            مجاني: <?= count(array_filter($themes, function($t){ return !$t->is_paid; })) ?>
        </span>
        <span style="background:rgba(245,158,11,0.1); color:#d97706; padding:0.4rem 1rem; border-radius:20px; font-size:0.82rem; font-weight:600; border:1px solid rgba(245,158,11,0.2);">
            <i class="fas fa-crown"></i>
            مدفوع: <?= count(array_filter($themes, function($t){ return $t->is_paid; })) ?>
        </span>
        <span style="background:rgba(79,70,229,0.1); color:#4f46e5; padding:0.4rem 1rem; border-radius:20px; font-size:0.82rem; font-weight:600; border:1px solid rgba(79,70,229,0.2);">
            <i class="fas fa-layer-group"></i>
            المجموع: <?= count($themes) ?>
        </span>
        <form method="POST" action="<?= url('/admin/themes/import-demo') ?>" style="display:inline;" id="importDemoForm">
            <?= csrf_field() ?>
            <button type="submit" id="btn-import-demo" onclick="if(!confirm('هل تريد استيراد جميع البيانات التجريبية لكل القوالب الـ 12؟\nسيتم إضافة محتوى نصي وصور لكل قالب.')) return false;" style="background:linear-gradient(135deg, #10b981, #059669); color:#fff; border:none; padding:0.5rem 1.2rem; border-radius:10px; font-size:0.85rem; font-weight:700; cursor:pointer; display:flex; align-items:center; gap:0.5rem; font-family:inherit; box-shadow:0 2px 8px rgba(16,185,129,0.3); transition:all 0.2s;">
                <i class="fas fa-file-import"></i>
                استيراد بيانات تجريبية
            </button>
        </form>
        <form method="POST" action="<?= url('/admin/themes/clear-demo') ?>" style="display:inline;" id="clearDemoForm">
            <?= csrf_field() ?>
            <button type="submit" onclick="if(!confirm('هل أنت متأكد من حذف جميع البيانات التجريبية؟\nلا يمكن التراجع عن هذا الإجراء.')) return false;" style="background:rgba(239,68,68,0.1); color:#dc2626; border:1.5px solid rgba(239,68,68,0.3); padding:0.5rem 1rem; border-radius:10px; font-size:0.82rem; font-weight:600; cursor:pointer; display:flex; align-items:center; gap:0.4rem; font-family:inherit; transition:all 0.2s;">
                <i class="fas fa-trash-alt"></i>
                حذف البيانات
            </button>
        </form>
    </div>
</div>

<!-- Info Banner -->
<div style="background:linear-gradient(135deg, #eff6ff 0%, #f0fdf4 100%); border:1px solid #bfdbfe; border-radius:14px; padding:1rem 1.5rem; margin-bottom:1.5rem; display:flex; align-items:center; gap:1rem;">
    <div style="width:42px; height:42px; background:linear-gradient(135deg, #3b82f6, #8b5cf6); border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
        <i class="fas fa-magic" style="color:#fff; font-size:1rem;"></i>
    </div>
    <div style="font-size:0.85rem; color:#1e40af; line-height:1.6;">
        <strong>تحكم كامل بالقوالب:</strong> يمكنك تفعيل أو تعطيل أي قالب، وتصنيفه كمجاني أو مدفوع مع تحديد السعر ورابط الدفع.
        المشتركون سيرون فقط القوالب المفعّلة. اضغط على <strong>"محتوى"</strong> لتخصيص محتوى كل قالب.
        <br><strong style="color:#059669;">💡 جديد:</strong> اضغط <strong>"استيراد بيانات تجريبية"</strong> لإضافة محتوى ديمو (نصوص + صور) لكل القوالب تلقائياً. بعد الاستيراد، اضغط <strong>"معاينة"</strong> لرؤية شكل القالب.
    </div>
</div>

<!-- Themes Grid -->
<div class="themes-admin-grid">
    <?php foreach ($themes as $theme):
        $colors = $themeColors[$theme->slug] ?? $themeColors['general'];
        $icon = $themeIcons[$theme->slug] ?? 'fa-cube';
        $hasPreview = !empty($theme->preview_image);
        $previewUrl = $hasPreview ? upload($theme->preview_image) : '';
    ?>
    <div class="theme-admin-card <?= !$theme->is_active ? 'theme-disabled' : '' ?>" id="theme-card-<?= $theme->id ?>">
        <!-- Header: Preview Image -->
        <div class="theme-admin-preview" id="preview-<?= $theme->id ?>">
            <?php if ($hasPreview): ?>
            <img src="<?= $previewUrl ?>" alt="<?= $this->e($theme->name) ?>" class="theme-preview-img" loading="lazy">
            <!-- Gradient overlay for text readability -->
            <div class="theme-preview-overlay"></div>
            <?php else: ?>
            <div style="background: linear-gradient(135deg, <?= $colors['primary'] ?> 0%, <?= $colors['secondary'] ?> 100%); width:100%; height:100%; display:flex; align-items:center; justify-content:center;">
                <i class="fas <?= $icon ?>" style="font-size:2.5rem; color:rgba(255,255,255,0.9);"></i>
            </div>
            <?php endif; ?>

            <!-- Status Badge -->
            <div class="theme-status-badge <?= $theme->is_active ? 'badge-active' : 'badge-inactive' ?>">
                <?php if ($theme->is_active): ?>
                    <i class="fas fa-check-circle"></i> مفعّل
                <?php else: ?>
                    <i class="fas fa-times-circle"></i> معطّل
                <?php endif; ?>
            </div>
            <!-- Paid Badge -->
            <?php if ($theme->is_paid): ?>
            <div class="theme-paid-badge">
                <i class="fas fa-crown"></i> مدفوع
            </div>
            <?php else: ?>
            <div class="theme-free-badge">
                <i class="fas fa-gift"></i> مجاني
            </div>
            <?php endif; ?>
            <!-- Theme icon (bottom-left) -->
            <div class="theme-icon-badge" style="background:linear-gradient(135deg, <?= $colors['primary'] ?>, <?= $colors['secondary'] ?>);">
                <i class="fas <?= $icon ?>"></i>
            </div>
        </div>

        <!-- Body: Info -->
        <div class="theme-admin-body">
            <div class="theme-admin-name-row">
                <h3><?= $this->e($theme->name) ?></h3>
                <span class="theme-slug-badge"><?= $theme->slug ?></span>
            </div>
            <?php if (!empty($theme->name_en)): ?>
            <p class="theme-name-en"><?= $this->e($theme->name_en) ?></p>
            <?php endif; ?>
            <p class="theme-desc"><?= $this->e($theme->description) ?></p>

            <?php if (!empty($theme->is_paid) && $theme->is_paid): ?>
            <div class="theme-price-tag">
                <i class="fas fa-tag"></i>
                <?= number_format($theme->price ?? 0, 2) ?> <?= $theme->currency ?? 'SAR' ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Actions -->
        <div class="theme-admin-actions" style="display:flex;">
            <a href="<?= url('/theme-preview/' . $theme->slug) ?>" target="_blank" class="btn-preview-theme" title="معاينة القالب بالديمو">
                <i class="fas fa-external-link-alt"></i> معاينة
            </a>
            <button class="btn-toggle-theme" onclick="toggleTheme(<?= $theme->id ?>, this)" data-active="<?= $theme->is_active ?>">
                <?php if ($theme->is_active): ?>
                    <i class="fas fa-eye-slash"></i> تعطيل
                <?php else: ?>
                    <i class="fas fa-eye"></i> تفعيل
                <?php endif; ?>
            </button>
            <button class="btn-content-theme" onclick="location.href='<?= url('/admin/themes/content/' . $theme->id) ?>'">
                <i class="fas fa-database"></i> محتوى
            </button>
            <button class="btn-edit-theme" onclick="openEditModal(<?= $theme->id ?>)">
                <i class="fas fa-cog"></i> إعدادات
            </button>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Edit Theme Modal -->
<div id="editThemeModal" class="modal-overlay" style="display:none;">
    <div class="modal-container" style="max-width:600px; max-height:90vh; overflow-y:auto;">
        <div class="modal-header">
            <h3><i class="fas fa-edit"></i> تعديل القالب</h3>
            <button class="modal-close" onclick="closeEditModal()">&times;</button>
        </div>
        <form id="editThemeForm" method="POST" action="<?= url('/admin/themes/update') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="theme_id" id="edit_theme_id">

            <div class="modal-body">
                <!-- تفعيل/تعطيل -->
                <div class="form-group" style="display:flex; align-items:center; gap:1rem; padding:1rem; background:var(--light); border-radius:10px; margin-bottom:1rem; border:1px solid #e5e7eb;">
                    <label style="display:flex; align-items:center; gap:0.75rem; cursor:pointer; font-weight:600; margin:0;">
                        <input type="checkbox" name="is_active" id="edit_is_active" value="1" style="width:20px; height:20px;">
                        <i class="fas fa-toggle-on" style="color:var(--success); font-size:1.2rem;"></i>
                        تفعيل القالب للمشتركين
                    </label>
                </div>

                <!-- مدفوع/مجاني -->
                <div class="form-group" style="display:flex; align-items:center; gap:1rem; padding:1rem; background:#fffbeb; border-radius:10px; margin-bottom:1rem; border:1px solid #fde68a;">
                    <label style="display:flex; align-items:center; gap:0.75rem; cursor:pointer; font-weight:600; margin:0;">
                        <input type="checkbox" name="is_paid" id="edit_is_paid" value="1" style="width:20px; height:20px;" onchange="togglePaidFields()">
                        <i class="fas fa-crown" style="color:#f59e0b; font-size:1.2rem;"></i>
                        قالب مدفوع (Premium)
                    </label>
                </div>

                <!-- اسم القالب (عربي) -->
                <div class="form-group">
                    <label for="edit_name">اسم القالب (عربي) <span class="required">*</span></label>
                    <input type="text" name="name" id="edit_name" required>
                </div>

                <!-- اسم القالب (إنجليزي) -->
                <div class="form-group">
                    <label for="edit_name_en">اسم القالب (إنجليزي)</label>
                    <input type="text" name="name_en" id="edit_name_en" placeholder="Theme name in English">
                </div>

                <!-- وصف القالب (عربي) -->
                <div class="form-group">
                    <label for="edit_description">وصف القالب (عربي)</label>
                    <textarea name="description" id="edit_description" rows="3"></textarea>
                </div>

                <!-- وصف القالب (إنجليزي) -->
                <div class="form-group">
                    <label for="edit_description_en">وصف القالب (إنجليزي)</label>
                    <textarea name="description_en" id="edit_description_en" rows="3" placeholder="Theme description in English"></textarea>
                </div>

                <!-- التصنيف -->
                <div class="form-group">
                    <label for="edit_category">التصنيف</label>
                    <select name="category" id="edit_category">
                        <option value="general">عام</option>
                        <option value="maintenance">صيانة</option>
                        <option value="decor">ديكور</option>
                        <option value="electric">كهرباء</option>
                        <option value="plumbing">سباكة</option>
                        <option value="cleaning">تنظيف</option>
                        <option value="medical">طبي</option>
                        <option value="realestate">عقارات</option>
                        <option value="restaurant">مطاعم</option>
                        <option value="education">تعليم</option>
                        <option value="fitness">رياضة ولياقة</option>
                        <option value="legal">محاماة وقانون</option>
                        <option value="other">أخرى</option>
                    </select>
                </div>

                <!-- ترتيب العرض -->
                <div class="form-group">
                    <label for="edit_sort_order">ترتيب العرض</label>
                    <input type="number" name="sort_order" id="edit_sort_order" min="0" value="0">
                </div>

                <!-- حقول القالب المدفوع -->
                <div id="paidFieldsSection" style="display:none; border:2px solid #f59e0b; border-radius:14px; padding:1.25rem; margin-top:1rem; background:linear-gradient(135deg, #fffbeb, #fef3c7);">
                    <h4 style="color:#92400e; margin-bottom:1rem; display:flex; align-items:center; gap:0.5rem;">
                        <i class="fas fa-crown"></i> إعدادات القالب المدفوع
                    </h4>

                    <div class="form-group">
                        <label for="edit_price">السعر <span class="required">*</span></label>
                        <div style="display:flex; gap:0.5rem;">
                            <input type="number" name="price" id="edit_price" step="0.01" min="0" placeholder="0.00" style="flex:1;">
                            <select name="currency" id="edit_currency" style="width:120px;">
                                <option value="SAR">ر.س SAR</option>
                                <option value="USD">$ USD</option>
                                <option value="EUR">EUR</option>
                                <option value="AED">د.إ AED</option>
                                <option value="KWD">د.ك KWD</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit_payment_link">رابط الدفع</label>
                        <input type="url" name="payment_link" id="edit_payment_link" placeholder="https://payment-gateway.com/pay/...">
                        <small style="color:#78716c; margin-top:0.25rem; display:block;">
                            <i class="fas fa-info-circle"></i>
                            رابط الدفع الذي سيُحوّل إليه المشترك عند طلب تفعيل هذا القالب
                        </small>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeEditModal()">
                    <i class="fas fa-times"></i> إلغاء
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> حفظ التعديلات
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Theme Data for JS -->
<script>
const themesData = <?= json_encode(array_combine(array_map(function($t){ return $t->id; }, $themes), array_values($themes)), JSON_UNESCAPED_UNICODE) ?>;
</script>

<style>
.themes-admin-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
    margin-top: 1rem;
}

.theme-admin-card {
    background: var(--bg-card, #fff);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    border: 2px solid var(--border, #e5e7eb);
    transition: all 0.3s ease;
}

.theme-admin-card.theme-disabled {
    opacity: 0.6;
    border-color: #fca5a5;
}

.theme-admin-card:hover {
    box-shadow: 0 12px 30px rgba(0,0,0,0.12);
    transform: translateY(-3px);
}

.theme-admin-preview {
    height: 200px;
    position: relative;
    overflow: hidden;
    background: #f1f5f9;
}

.theme-preview-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
    transition: transform 0.4s ease;
}

.theme-admin-card:hover .theme-preview-img {
    transform: scale(1.03);
}

.theme-preview-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 60px;
    background: linear-gradient(to top, rgba(0,0,0,0.4), transparent);
    pointer-events: none;
}

.theme-icon-badge {
    position: absolute;
    bottom: 10px;
    <?= $dir === 'rtl' ? 'right' : 'left' ?>: 10px;
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 0.85rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    border: 2px solid rgba(255,255,255,0.3);
}

.theme-status-badge {
    position: absolute;
    top: 10px;
    <?= $dir === 'rtl' ? 'right' : 'left' ?>: 10px;
    padding: 0.25rem 0.7rem;
    border-radius: 20px;
    font-size: 0.72rem;
    font-weight: 700;
    backdrop-filter: blur(12px);
}

.badge-active {
    background: rgba(255,255,255,0.25);
    color: #fff;
    border: 1px solid rgba(255,255,255,0.3);
}

.badge-inactive {
    background: rgba(254,202,202,0.85);
    color: #991b1b;
    border: 1px solid rgba(252,165,165,0.5);
}

.theme-paid-badge {
    position: absolute;
    top: 10px;
    <?= $dir === 'rtl' ? 'left' : 'right' ?>: 10px;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #fff;
    padding: 0.25rem 0.7rem;
    border-radius: 20px;
    font-size: 0.72rem;
    font-weight: 700;
    box-shadow: 0 2px 10px rgba(245,158,11,0.5);
}

.theme-free-badge {
    position: absolute;
    top: 10px;
    <?= $dir === 'rtl' ? 'left' : 'right' ?>: 10px;
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff;
    padding: 0.25rem 0.7rem;
    border-radius: 20px;
    font-size: 0.72rem;
    font-weight: 700;
    box-shadow: 0 2px 10px rgba(16,185,129,0.5);
}

.theme-admin-body {
    padding: 1rem 1.25rem;
}

.theme-admin-name-row {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.25rem;
}

.theme-admin-name-row h3 {
    font-size: 1.05rem;
    font-weight: 700;
    margin: 0;
    color: #1e293b;
}

.theme-slug-badge {
    font-size: 0.7rem;
    background: var(--light, #f1f5f9);
    color: #64748b;
    padding: 0.15rem 0.5rem;
    border-radius: 6px;
    font-weight: 600;
}

.theme-name-en {
    font-size: 0.8rem;
    color: #64748b;
    margin: 0 0 0.5rem;
}

.theme-desc {
    font-size: 0.82rem;
    color: #475569;
    line-height: 1.5;
    margin: 0 0 0.5rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.theme-price-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
    padding: 0.35rem 0.85rem;
    border-radius: 10px;
    font-size: 0.88rem;
    font-weight: 700;
    border: 1px solid #fcd34d;
}

.theme-admin-actions {
    display: flex;
    gap: 0;
    border-top: 1px solid var(--border, #e5e7eb);
}

.btn-toggle-theme, .btn-edit-theme, .btn-content-theme, .btn-preview-theme {
    flex: 1;
    padding: 0.75rem;
    border: none;
    cursor: pointer;
    font-size: 0.82rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    transition: all 0.2s;
    font-family: inherit;
}

.btn-toggle-theme {
    background: var(--light, #f8fafc);
    color: #334155;
}

.btn-toggle-theme:hover {
    background: #e2e8f0;
}

.btn-content-theme {
    background: #f0fdf4;
    color: #15803d;
    border-<?= $dir === 'rtl' ? 'right' : 'left' ?>: 1px solid var(--border);
}

.btn-content-theme:hover {
    background: #dcfce7;
}

.btn-edit-theme {
    background: #eff6ff;
    color: #1d4ed8;
    border-<?= $dir === 'rtl' ? 'right' : 'left' ?>: 1px solid var(--border);
}

.btn-edit-theme:hover {
    background: #dbeafe;
}

.btn-preview-theme {
    background: linear-gradient(135deg, #059669, #047857) !important;
    color: #fff !important;
    border-<?= $dir === 'rtl' ? 'right' : 'left' ?>: 1px solid var(--border);
}
.btn-preview-theme:hover {
    box-shadow: 0 4px 12px rgba(5,150,105,0.4);
}

/* Modal */
.modal-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(4px);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

.modal-container {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 25px 60px rgba(0,0,0,0.3);
    width: 100%;
    animation: modalIn 0.3s ease;
}

@keyframes modalIn {
    from { opacity: 0; transform: scale(0.95) translateY(10px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}

@keyframes toastIn {
    from { opacity: 0; transform: translateX(-50%) translateY(-20px); }
    to { opacity: 1; transform: translateX(-50%) translateY(0); }
}

@keyframes toastOut {
    from { opacity: 1; transform: translateX(-50%) translateY(0); }
    to { opacity: 0; transform: translateX(-50%) translateY(-20px); }
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    background: #f8fafc;
    border-radius: 16px 16px 0 0;
}

.modal-header h3 {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.modal-close {
    width: 32px;
    height: 32px;
    border: none;
    background: #e2e8f0;
    border-radius: 50%;
    cursor: pointer;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #475569;
    transition: all 0.2s;
}

.modal-close:hover {
    background: #fca5a5;
    color: #dc2626;
}

.modal-body { padding: 1.5rem; }

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    padding: 1rem 1.5rem;
    border-top: 1px solid #e5e7eb;
    background: #f8fafc;
    border-radius: 0 0 16px 16px;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    font-size: 0.85rem;
    font-weight: 600;
    color: #334155;
    margin-bottom: 0.4rem;
}

.form-group label .required {
    color: #dc2626;
}

.form-group input[type="text"],
.form-group input[type="number"],
.form-group input[type="url"],
.form-group textarea,
.form-group select {
    width: 100%;
    padding: 0.6rem 0.85rem;
    border: 1.5px solid #d1d5db;
    border-radius: 10px;
    font-size: 0.9rem;
    transition: all 0.2s;
    font-family: inherit;
    box-sizing: border-box;
    background: #fff;
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
}

.btn {
    padding: 0.6rem 1.2rem;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    transition: all 0.2s;
    font-family: inherit;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    color: #fff;
}

.btn-primary:hover {
    box-shadow: 0 4px 15px rgba(79,70,229,0.4);
    transform: translateY(-1px);
}

.btn-outline {
    background: transparent;
    color: #475569;
    border: 1.5px solid #d1d5db;
}

.btn-outline:hover {
    background: #f1f5f9;
}

@media (max-width: 768px) {
    .themes-admin-grid {
        grid-template-columns: 1fr;
    }
    .theme-admin-preview {
        height: 160px;
    }
}
</style>

<script>
function toggleTheme(themeId, btn) {
    if (!confirm('هل أنت متأكد من تغيير حالة هذا القالب؟')) return;

    const formData = new FormData();
    formData.append('theme_id', themeId);
    formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]')?.content || '');

    fetch('<?= url("/admin/themes/toggle") ?>', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'حدث خطأ');
        }
    })
    .catch(() => alert('حدث خطأ في الاتصال'));
}

function openEditModal(themeId) {
    const theme = themesData[themeId];
    if (!theme) return;

    document.getElementById('edit_theme_id').value = theme.id;
    document.getElementById('edit_name').value = theme.name || '';
    document.getElementById('edit_name_en').value = theme.name_en || '';
    document.getElementById('edit_description').value = theme.description || '';
    document.getElementById('edit_description_en').value = theme.description_en || '';
    document.getElementById('edit_category').value = theme.category || 'general';
    document.getElementById('edit_sort_order').value = theme.sort_order || 0;
    document.getElementById('edit_is_active').checked = theme.is_active == 1;
    document.getElementById('edit_is_paid').checked = theme.is_paid == 1;
    document.getElementById('edit_price').value = theme.price || 0;
    document.getElementById('edit_currency').value = theme.currency || 'SAR';
    document.getElementById('edit_payment_link').value = theme.payment_link || '';

    togglePaidFields();
    document.getElementById('editThemeModal').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editThemeModal').style.display = 'none';
}

function togglePaidFields() {
    const isPaid = document.getElementById('edit_is_paid').checked;
    document.getElementById('paidFieldsSection').style.display = isPaid ? 'block' : 'none';
}

// Close modal on outside click
document.getElementById('editThemeModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});

// Toast notification
function showToast(message, type) {
    const toast = document.createElement('div');
    toast.style.cssText = 'position:fixed;top:20px;left:50%;transform:translateX(-50%);padding:1rem 2rem;border-radius:12px;color:#fff;font-weight:600;font-size:0.9rem;z-index:99999;box-shadow:0 8px 30px rgba(0,0,0,0.2);animation:toastIn 0.3s ease;font-family:inherit;max-width:90%;text-align:center;';
    
    if (type === 'success') {
        toast.style.background = 'linear-gradient(135deg, #10b981, #059669)';
    } else {
        toast.style.background = 'linear-gradient(135deg, #ef4444, #dc2626)';
    }
    
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'toastOut 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}
</script>

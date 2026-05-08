<?php
/**
 * Stats Dashboard View
 * صفحة إدارة إحصائيات الموقع (العداد)
 */

$availableIcons = [
    'fas fa-cogs' => '⚙️ خدمات',
    'fas fa-users' => '👥 عملاء',
    'fas fa-project-diagram' => '📊 مشاريع',
    'fas fa-headset' => '🎧 دعم',
    'fas fa-star' => '⭐ تقييم',
    'fas fa-award' => '🏆 جوائز',
    'fas fa-check-circle' => '✅ إنجازات',
    'fas fa-briefcase' => '💼 مشاريع',
    'fas fa-clock' => '⏰ سنوات خبرة',
    'fas fa-smile' => '😊 عملاء سعداء',
    'fas fa-thumbs-up' => '👍 إعجاب',
    'fas fa-map-marker-alt' => '📍 فروع',
    'fas fa-certificate' => '📜 شهادات',
    'fas fa-tools' => '🔧 فنيين',
    'fas fa-handshake' => '🤝 شراكات',
    'fas fa-truck' => '🚛 توصيل',
    'fas fa-shield-alt' => '🛡️ ضمان',
];
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-chart-bar"></i>
            إحصائيات الموقع (العداد)
        </h3>
        <span class="badge bg-primary"><?= count($stats) ?> عنصر</span>
    </div>
    <div class="card-body">

        <!-- إضافة إحصائية جديدة -->
        <div style="background: var(--light); padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem;">
            <h5 style="font-weight: 700; margin-bottom: 1rem;">
                <i class="fas fa-plus-circle" style="color: var(--primary);"></i>
                إضافة إحصائية جديدة
            </h5>
            <form method="POST" action="<?= url('/dashboard/stats') ?>">
                <?= $this->csrf() ?>

                <div class="row" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">القيمة *</label>
                        <input type="text" name="value" class="form-control" placeholder="مثال: 500" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">اللاحقة</label>
                        <select name="suffix" class="form-control">
                            <option value="+">+</option>
                            <option value="%">%</option>
                            <option value="K">K</option>
                            <option value="M">M</option>
                            <option value="">بدون</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">الحالة</label>
                        <select name="is_active" class="form-control">
                            <option value="1" selected>مفعّل</option>
                            <option value="0">معطّل</option>
                        </select>
                    </div>
                </div>

                <!-- حقل الوصف بالعربية -->
                <div class="lang-section-header" style="margin-top: 0.5rem;">
                    <span class="lang-badge">🇸🇦 العربية</span>
                </div>

                <div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">الوصف بالعربية *</label>
                        <input type="text" name="label" class="form-control" dir="rtl" placeholder="مثال: عميل راضي" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">الأيقونة</label>
                        <select name="icon" class="form-control" id="iconSelect">
                            <?php foreach ($availableIcons as $iconClass => $iconLabel): ?>
                            <option value="<?= $iconClass ?>" <?= ($iconClass === 'fas fa-star') ? 'selected' : '' ?>><?= $iconLabel ?> (<?= $iconClass ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- حقل الوصف بالإنجليزية -->
                <div class="lang-section-header" style="margin-top: 1rem;">
                    <span class="lang-badge">🇬🇧 English</span>
                    <span class="form-hint" style="margin-right: auto;">(اختياري / Optional)</span>
                </div>

                <div class="form-group">
                    <label class="form-label">Label (English)</label>
                    <input type="text" name="label_en" class="form-control" dir="ltr" placeholder="e.g. Happy Clients">
                </div>

                <button type="submit" class="btn btn-primary" style="margin-top: 1rem;">
                    <i class="fas fa-plus"></i> إضافة الإحصائية
                </button>
            </form>
        </div>

        <!-- معاينة مباشرة -->
        <?php if (!empty($stats)): ?>
        <div class="stats-preview-section" style="margin-bottom: 2rem;">
            <h5 style="font-weight: 700; margin-bottom: 1rem;">
                <i class="fas fa-eye" style="color: var(--primary);"></i>
                معاينة الشريط في الموقع
            </h5>
            <div class="stats-bar" style="background: #fff; border-radius: var(--radius-xl, 16px); box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 2rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; border: 1px solid #e2e8f0;">
                <?php foreach ($stats as $stat): ?>
                <?php if ($stat->is_active): ?>
                <div style="text-align: center; padding: 0.75rem;">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(79,70,229,0.08); display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem;">
                        <i class="<?= $stat->icon ?>" style="font-size: 1.25rem; color: var(--primary);"></i>
                    </div>
                    <div style="font-size: 2rem; font-weight: 900; background: linear-gradient(135deg, #4f46e5, #7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?= $stat->value ?><?= $stat->suffix ?></div>
                    <div style="font-size: 0.85rem; color: #64748b; font-weight: 500;"><?= $stat->label ?></div>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- قائمة الإحصائيات -->
        <?php if (!empty($stats)): ?>
        <h5 style="font-weight: 700; margin-bottom: 1rem;">
            <i class="fas fa-list" style="color: var(--primary);"></i>
            الإحصائيات المضافة
        </h5>

        <div class="stats-list">
            <?php foreach ($stats as $i => $stat): ?>
            <div class="stat-manage-item" id="stat-item-<?= $stat->id ?>" style="display: flex; gap: 1rem; padding: 1rem; background: #fff; border: 1px solid var(--border); border-radius: 10px; margin-bottom: 0.75rem; align-items: center; transition: all 0.2s; <?= !$stat->is_active ? 'opacity: 0.5;' : '' ?>">
                <!-- معاينة الأيقونة والرقم -->
                <div style="text-align: center; min-width: 80px;">
                    <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(79,70,229,0.08); display: flex; align-items: center; justify-content: center; margin: 0 auto 0.5rem;">
                        <i class="<?= $stat->icon ?>" style="font-size: 1.1rem; color: var(--primary);"></i>
                    </div>
                    <div style="font-size: 1.25rem; font-weight: 800; color: var(--primary);"><?= $stat->value ?><?= $stat->suffix ?></div>
                </div>

                <!-- الوصف -->
                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <strong><?= htmlspecialchars($stat->label) ?></strong>
                        <?php if (!$stat->is_active): ?>
                        <span class="badge bg-secondary" style="font-size: 0.7rem;">معطّل</span>
                        <?php endif; ?>
                    </div>
                    <?php if ($stat->label_en): ?>
                    <div style="font-size: 0.85rem; color: #64748b;">EN: <?= htmlspecialchars($stat->label_en) ?></div>
                    <?php endif; ?>
                </div>

                <!-- أزرار التحكم -->
                <div style="display: flex; gap: 0.5rem; flex-shrink: 0;">
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="editStat(<?= $stat->id ?>)" title="تعديل">
                        <i class="fas fa-edit"></i>
                    </button>
                    <?php if ($i > 0): ?>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="moveStat(<?= $stat->id ?>, 'up')" title="تحريك لأعلى">
                        <i class="fas fa-arrow-up"></i>
                    </button>
                    <?php endif; ?>
                    <?php if ($i < count($stats) - 1): ?>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="moveStat(<?= $stat->id ?>, 'down')" title="تحريك لأسفل">
                        <i class="fas fa-arrow-down"></i>
                    </button>
                    <?php endif; ?>
                    <button type="button" class="btn btn-sm btn-outline-<?= $stat->is_active ? 'warning' : 'success' ?>"
                            onclick="toggleStatStatus(<?= $stat->id ?>)"
                            title="<?= $stat->is_active ? 'تعطيل' : 'تفعيل' ?>">
                        <i class="fas fa-<?= $stat->is_active ? 'eye-slash' : 'eye' ?>"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger"
                            onclick="deleteStatItem(<?= $stat->id ?>)"
                            title="حذف">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div style="text-align: center; padding: 3rem; color: #94a3b8;">
            <i class="fas fa-chart-bar" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
            <p>لا توجد إحصائيات بعد. أضف أول عنصر من النموذج أعلاه.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- مودال تعديل الإحصائية -->
<div class="modal fade" id="editStatModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit"></i> تعديل الإحصائية</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editStatForm">
                    <input type="hidden" name="stat_id" id="editStatId">

                    <div class="form-group">
                        <label class="form-label">القيمة *</label>
                        <input type="text" name="value" id="editStatValue" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">اللاحقة</label>
                        <select name="suffix" id="editStatSuffix" class="form-control">
                            <option value="+">+</option>
                            <option value="%">%</option>
                            <option value="K">K</option>
                            <option value="M">M</option>
                            <option value="">بدون</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">الأيقونة</label>
                        <select name="icon" id="editStatIcon" class="form-control">
                            <?php foreach ($availableIcons as $iconClass => $iconLabel): ?>
                            <option value="<?= $iconClass ?>"><?= $iconLabel ?> (<?= $iconClass ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="lang-section-header">
                        <span class="lang-badge">🇸🇦 العربية</span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">الوصف بالعربية *</label>
                        <input type="text" name="label" id="editStatLabel" class="form-control" dir="rtl" required>
                    </div>

                    <div class="lang-section-header" style="margin-top: 1rem;">
                        <span class="lang-badge">🇬🇧 English</span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Label (English)</label>
                        <input type="text" name="label_en" id="editStatLabelEn" class="form-control" dir="ltr">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" onclick="saveStatEdit()">
                    <i class="fas fa-save"></i> حفظ التعديلات
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.lang-section-header {
    display: flex; align-items: center; gap: 0.75rem;
    padding-bottom: 0.5rem; margin-bottom: 0.75rem;
    border-bottom: 2px solid var(--border, #e2e8f0);
}
.lang-badge {
    display: inline-flex; align-items: center; gap: 0.4rem;
    background: var(--primary, #4f46e5); color: #fff;
    padding: 0.35rem 1rem; border-radius: 50px;
    font-size: 0.85rem; font-weight: 600;
}
.form-hint { font-size: 0.8rem; color: #94a3b8; }
</style>

<script>
// تعديل الإحصائية
function editStat(id) {
    const item = document.getElementById('stat-item-' + id);
    if (!item) return;

    document.getElementById('editStatId').value = id;

    // جمع البيانات من DOM
    const labels = item.querySelectorAll('strong');
    const values = item.querySelectorAll('[style*="font-weight: 800"]');

    if (labels[0]) document.getElementById('editStatLabel').value = labels[0].textContent.trim();
    if (values[0]) {
        const valText = values[0].textContent;
        // فصل الرقم عن اللاحقة
        const numMatch = valText.match(/^(\d+)(.*)$/);
        if (numMatch) {
            document.getElementById('editStatValue').value = numMatch[1];
            document.getElementById('editStatSuffix').value = numMatch[2];
        }
    }

    // الوصف الإنجليزي
    const labelsEn = item.querySelectorAll('[style*="color: #64748b"]');
    if (labelsEn[0]) document.getElementById('editStatLabelEn').value = labelsEn[0].textContent.replace('EN: ', '').trim();

    new bootstrap.Modal(document.getElementById('editStatModal')).show();
}

// حفظ التعديل
function saveStatEdit() {
    const id = document.getElementById('editStatId').value;
    const form = document.getElementById('editStatForm');
    const formData = new FormData(form);

    formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]')?.content || '');

    fetch('<?= url("/dashboard/stats/edit/") ?>' + id, {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('editStatModal')).hide();
            location.reload();
        } else {
            alert(data.message || 'حدث خطأ');
        }
    })
    .catch(() => alert('حدث خطأ في الاتصال'));
}

// تبديل حالة التفعيل
function toggleStatStatus(id) {
    if (!confirm('هل تريد تغيير حالة هذه الإحصائية؟')) return;

    const formData = new FormData();
    formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]')?.content || '');

    fetch('<?= url("/dashboard/stats/toggle/") ?>' + id, {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) location.reload();
        else alert(data.message || 'حدث خطأ');
    })
    .catch(() => alert('حدث خطأ في الاتصال'));
}

// حذف الإحصائية
function deleteStatItem(id) {
    if (!confirm('هل أنت متأكد من حذف هذه الإحصائية؟')) return;

    const formData = new FormData();
    formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]')?.content || '');

    fetch('<?= url("/dashboard/stats/delete/") ?>' + id, {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const item = document.getElementById('stat-item-' + id);
            if (item) {
                item.style.transition = 'all 0.3s';
                item.style.opacity = '0';
                item.style.transform = 'translateX(20px)';
                setTimeout(() => item.remove(), 300);
            }
            setTimeout(() => location.reload(), 500);
        } else {
            alert(data.message || 'حدث خطأ');
        }
    })
    .catch(() => alert('حدث خطأ في الاتصال'));
}

// تحريك الترتيب (بسيط - يعمل عبر إعادة التحميل)
function moveStat(id, direction) {
    // سيعمل من خلال تحديث sort_order في قاعدة البيانات
    const formData = new FormData();
    formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]')?.content || '');
    formData.append('direction', direction);

    // استخدام AJAX لتحديث الترتيب
    fetch('<?= url("/dashboard/stats/edit/") ?>' + id, {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) location.reload();
    })
    .catch(() => location.reload());
}
</script>
<?php ?>

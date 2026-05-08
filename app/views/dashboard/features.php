<?php
/**
 * إدارة مميزات "لماذا نحن"
 */
?>

<div class="page-header">
    <div class="d-flex justify-between items-center flex-wrap gap-3">
        <div>
            <h1 class="page-title"><?= lang('site_features') ?? 'مميزات الموقع (لماذا نحن)' ?></h1>
            <p class="page-subtitle"><?= lang('features_desc') ?? 'إدارة بطاقات المميزات التي تظهر في قسم "لماذا نحن" في موقعك' ?></p>
        </div>
        <button type="button" class="btn btn-primary" onclick="openFeatureModal()">
            <i class="fas fa-plus"></i>
            <?= lang('add_feature') ?? 'إضافة ميزة' ?>
        </button>
    </div>
</div>

<!-- رسالة النجاح -->
<div id="featureAlert" class="alert" style="display: none;"></div>

<!-- بطاقات المميزات -->
<div class="features-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; margin-top: 1.5rem;">
    <?php if (!empty($features)): ?>
        <?php foreach ($features as $index => $feature): ?>
        <div class="card feature-card" id="feature-card-<?= $feature->id ?>" style="border-left: 4px solid <?= $tenant->primary_color ?? '#529286' ?>;">
            <div class="card-body">
                <div class="d-flex justify-between items-start mb-3">
                    <div class="feature-icon-preview" style="width: 50px; height: 50px; border-radius: 12px; background: linear-gradient(135deg, <?= $tenant->primary_color ?? '#529286' ?>22, <?= $tenant->secondary_color ?? '#1a2330' ?>22); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; color: <?= $tenant->primary_color ?? '#529286' ?>;">
                        <i class="<?= $feature->icon ?: 'fas fa-star' ?>"></i>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline" onclick="editFeature(<?= $feature->id ?>)" title="<?= lang('edit') ?? 'تعديل' ?>">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline text-danger" onclick="deleteFeature(<?= $feature->id ?>)" title="<?= lang('delete') ?? 'حذف' ?>">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <h3 class="card-title" style="font-size: 1rem; margin-bottom: 0.5rem;"><?= htmlspecialchars($feature->title ?? '') ?></h3>
                <?php if (!empty($feature->title_en)): ?>
                    <p style="color: #94a3b8; font-size: 0.8rem; margin-bottom: 0.5rem;"><?= htmlspecialchars($feature->title_en) ?></p>
                <?php endif; ?>
                <p style="color: #64748b; font-size: 0.9rem; margin: 0;"><?= htmlspecialchars($feature->description ?? '') ?></p>
                <?php if (!empty($feature->description_en)): ?>
                    <p style="color: #94a3b8; font-size: 0.8rem; margin-top: 0.3rem;"><?= htmlspecialchars($feature->description_en) ?></p>
                <?php endif; ?>
                <div class="d-flex justify-between items-center mt-3">
                    <span class="badge <?= ($feature->is_active ?? 0) ? 'badge-success' : 'badge-secondary' ?>">
                        <?= ($feature->is_active ?? 0) ? (lang('active') ?? 'نشط') : (lang('inactive') ?? 'معطل') ?>
                    </span>
                    <label class="toggle-switch" style="margin: 0;">
                        <input type="checkbox" class="toggle-input" <?= ($feature->is_active ?? 0) ? 'checked' : '' ?> onchange="toggleFeature(<?= $feature->id ?>)">
                        <span class="toggle-label">
                            <span class="toggle-inner"></span>
                            <span class="toggle-switch-btn"></span>
                        </span>
                    </label>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="card" style="grid-column: 1 / -1;">
            <div class="card-body text-center" style="padding: 3rem;">
                <i class="fas fa-star" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
                <h3 style="color: #64748b; margin-bottom: 0.5rem;"><?= lang('no_features') ?? 'لا توجد مميزات بعد' ?></h3>
                <p style="color: #94a3b8;"><?= lang('add_first_feature') ?? 'أضف مميزاتك الأولى لعرضها في قسم "لماذا نحن"' ?></p>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- مودال إضافة/تعديل -->
<div id="featureModal" class="modal" style="display: none;">
    <div class="modal-backdrop" onclick="closeFeatureModal()"></div>
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 id="featureModalTitle"><?= lang('add_feature') ?? 'إضافة ميزة' ?></h3>
            <button class="modal-close" onclick="closeFeatureModal()">&times;</button>
        </div>
        <form id="featureForm" onsubmit="saveFeature(event)">
            <div class="modal-body">
                <input type="hidden" id="feature_id" name="id" value="">
                <div class="form-group">
                    <label><?= lang('icon') ?? 'الأيقونة' ?></label>
                    <div class="input-group">
                        <input type="text" id="feature_icon" name="icon" class="form-control" placeholder="fas fa-star" required>
                        <button type="button" class="btn btn-outline" onclick="previewIcon()">معاينة</button>
                    </div>
                    <div id="iconPreview" style="margin-top: 0.5rem; font-size: 1.5rem; color: <?= $tenant->primary_color ?? '#529286' ?>;"></div>
                    <small style="color: #94a3b8;">استخدم أيقونات Font Awesome مثل: fas fa-award, fas fa-bolt, fas fa-shield-alt</small>
                </div>
                <div class="form-group">
                    <label><?= lang('title_ar') ?? 'العنوان (عربي)' ?> <span class="text-danger">*</span></label>
                    <input type="text" id="feature_title" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label><?= lang('title_en') ?? 'العنوان (إنجليزي)' ?></label>
                    <input type="text" id="feature_title_en" name="title_en" class="form-control">
                </div>
                <div class="form-group">
                    <label><?= lang('description_ar') ?? 'الوصف (عربي)' ?> <span class="text-danger">*</span></label>
                    <textarea id="feature_description" name="description" class="form-control" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label><?= lang('description_en') ?? 'الوصف (إنجليزي)' ?></label>
                    <textarea id="feature_description_en" name="description_en" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeFeatureModal()"><?= lang('cancel') ?? 'إلغاء' ?></button>
                <button type="submit" class="btn btn-primary" id="featureSaveBtn">
                    <i class="fas fa-save"></i>
                    <?= lang('save') ?? 'حفظ' ?>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openFeatureModal(id = null) {
    document.getElementById('featureForm').reset();
    document.getElementById('feature_id').value = '';
    document.getElementById('iconPreview').innerHTML = '';
    document.getElementById('featureModalTitle').textContent = '<?= lang('add_feature') ?? 'إضافة ميزة' ?>';

    if (id) {
        // تحميل بيانات الميزة للتعديل
        fetch(`<?= url('/dashboard/features/edit/') ?>${id}`)
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('feature_id').value = data.feature.id;
                    document.getElementById('feature_icon').value = data.feature.icon;
                    document.getElementById('feature_title').value = data.feature.title;
                    document.getElementById('feature_title_en').value = data.feature.title_en || '';
                    document.getElementById('feature_description').value = data.feature.description;
                    document.getElementById('feature_description_en').value = data.feature.description_en || '';
                    document.getElementById('iconPreview').innerHTML = `<i class="${data.feature.icon}"></i>`;
                    document.getElementById('featureModalTitle').textContent = '<?= lang('edit_feature') ?? 'تعديل ميزة' ?>';
                }
            });
    }

    document.getElementById('featureModal').style.display = 'flex';
}

function closeFeatureModal() {
    document.getElementById('featureModal').style.display = 'none';
}

function previewIcon() {
    const icon = document.getElementById('feature_icon').value;
    document.getElementById('iconPreview').innerHTML = `<i class="${icon}"></i>`;
}

function saveFeature(e) {
    e.preventDefault();
    const id = document.getElementById('feature_id').value;
    const formData = new FormData(document.getElementById('featureForm'));
    formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]')?.content || '');
    const url = id ? `<?= url('/dashboard/features/edit/') ?>${id}` : `<?= url('/dashboard/features') ?>`;

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message, 'success');
            closeFeatureModal();
            setTimeout(() => location.reload(), 800);
        } else {
            showAlert(data.message || '<?= lang('error_occurred') ?? 'حدث خطأ' ?>', 'error');
        }
    });
}

function editFeature(id) {
    openFeatureModal(id);
}

function deleteFeature(id) {
    if (!confirm('<?= lang('confirm_delete') ?? 'هل أنت متأكد من الحذف؟' ?>')) return;

    const formData = new FormData();
    formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]')?.content || '');

    fetch(`<?= url('/dashboard/features/delete/') ?>${id}`, {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message, 'success');
            setTimeout(() => location.reload(), 800);
        } else {
            showAlert(data.message || '<?= lang('error_occurred') ?? 'حدث خطأ' ?>', 'error');
        }
    });
}

function toggleFeature(id) {
    const formData = new FormData();
    formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]')?.content || '');

    fetch(`<?= url('/dashboard/features/toggle/') ?>${id}`, {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            setTimeout(() => location.reload(), 500);
        }
    });
}

function showAlert(message, type) {
    const alert = document.getElementById('featureAlert');
    alert.textContent = message;
    alert.className = `alert alert-${type === 'success' ? 'success' : 'danger'}`;
    alert.style.display = 'block';
    setTimeout(() => { alert.style.display = 'none'; }, 3000);
}
</script>

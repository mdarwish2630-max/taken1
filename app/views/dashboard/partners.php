<?php
/**
 * Dashboard - Partners Management
 * لوحة التحكم - إدارة الشركاء
 */
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1"><i class="fas fa-handshake me-2"></i><?= lang('partners') ?: 'الشركاء' ?></h3>
        <small class="text-muted">إدارة شعارات وأسماء الشركاء على موقعك</small>
    </div>
</div>

<!-- نموذج إضافة شريك -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <i class="fas fa-plus-circle me-2"></i>إضافة شريك جديد
    </div>
    <div class="card-body">
        <form id="addPartnerForm" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">اسم الشريك <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required placeholder="مثال: شركة التقنية">
                </div>
                <div class="col-md-4">
                    <label class="form-label">الاسم بالإنجليزية</label>
                    <input type="text" name="name_en" class="form-control" placeholder="Partner Name">
                </div>
                <div class="col-md-3">
                    <label class="form-label">رابط الموقع</label>
                    <input type="url" name="link" class="form-control" value="#" placeholder="https://">
                </div>
                <div class="col-md-4">
                    <label class="form-label">شعار الشريك</label>
                    <input type="file" name="logo" class="form-control" accept="image/*">
                    <small class="text-muted">PNG, JPG, SVG - يفضل خلفية شفافة</small>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-plus me-1"></i>إضافة شريك
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- قائمة الشركاء -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-list me-2"></i>قائمة الشركاء (<?= count($partners) ?>)</span>
        <?php if (count($partners) > 0): ?>
        <span class="badge bg-success"><?= count(array_filter($partners, fn($p) => $p->is_active)) ?> مفعل</span>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <?php if (empty($partners)): ?>
        <div class="text-center py-5 text-muted">
            <i class="fas fa-handshake fa-3x mb-3"></i>
            <p>لم تقم بإضافة أي شركاء بعد</p>
            <small>أضف شركاءك ليظهر قسم الشركاء على موقعك</small>
        </div>
        <?php else: ?>
        <div class="row g-3">
            <?php foreach ($partners as $partner): ?>
            <div class="col-md-3 col-sm-6 partner-card" id="partner-<?= $partner->id ?>">
                <div class="card text-center h-100 <?= !$partner->is_active ? 'opacity-50' : '' ?>">
                    <div class="card-body p-3">
                        <?php if ($partner->logo): ?>
                        <img src="<?= url($partner->logo) ?>" alt="<?= htmlspecialchars($partner->name) ?>" 
                             class="img-fluid mb-2" style="max-height:80px; object-fit:contain;">
                        <?php else: ?>
                        <div class="bg-light rounded p-3 mb-2">
                            <i class="fas fa-building fa-2x text-muted"></i>
                        </div>
                        <?php endif; ?>
                        <h6 class="mb-1"><?= htmlspecialchars($partner->name) ?></h6>
                        <?php if ($partner->name_en): ?>
                        <small class="text-muted d-block"><?= htmlspecialchars($partner->name_en) ?></small>
                        <?php endif; ?>
                        <?php if ($partner->link && $partner->link !== '#'): ?>
                        <a href="<?= htmlspecialchars($partner->link) ?>" target="_blank" class="text-muted small">
                            <i class="fas fa-external-link-alt"></i> زيارة
                        </a>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer bg-transparent p-2 d-flex justify-content-center gap-1">
                        <button onclick="editPartner(<?= $partner->id ?>)" class="btn btn-sm btn-outline-primary" title="تعديل">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="togglePartnerStatus(<?= $partner->id ?>)" class="btn btn-sm <?= $partner->is_active ? 'btn-outline-warning' : 'btn-outline-success' ?>" title="<?= $partner->is_active ? 'تعطيل' : 'تفعيل' ?>">
                            <i class="fas fa-<?= $partner->is_active ? 'eye-slash' : 'eye' ?>"></i>
                        </button>
                        <button onclick="deletePartnerConfirm(<?= $partner->id ?>)" class="btn btn-sm btn-outline-danger" title="حذف">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- مودال تعديل شريك -->
<div class="modal fade" id="editPartnerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>تعديل الشريك</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editPartnerForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" id="edit_partner_id">
                    <div class="mb-3">
                        <label class="form-label">اسم الشريك <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الاسم بالإنجليزية</label>
                        <input type="text" name="name_en" id="edit_name_en" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">رابط الموقع</label>
                        <input type="url" name="link" id="edit_link" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">شعار الشريك (اتركه فارغاً للإبقاء على الحالي)</label>
                        <input type="file" name="logo" id="edit_logo" class="form-control" accept="image/*">
                        <div id="edit_current_logo" class="mt-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>حفظ التعديلات</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// إضافة شريك
document.getElementById('addPartnerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('/dashboard/partners', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast(data.message || 'تم إضافة الشريك بنجاح', 'success');
            setTimeout(() => location.reload(), 800);
        } else {
            showToast(data.message || 'حدث خطأ', 'danger');
        }
    })
    .catch(() => showToast('حدث خطأ في الاتصال', 'danger'));
});

// تحميل بيانات الشريك للتعديل
function editPartner(id) {
    fetch(`/dashboard/partners/edit/${id}`, { headers: {'X-Requested-With': 'XMLHttpRequest'} })
    .then(r => r.json())
    .then(data => {
        if (data.success && data.partner) {
            const p = data.partner;
            document.getElementById('edit_partner_id').value = p.id;
            document.getElementById('edit_name').value = p.name || '';
            document.getElementById('edit_name_en').value = p.name_en || '';
            document.getElementById('edit_link').value = p.link || '#';
            document.getElementById('edit_current_logo').innerHTML = p.logo 
                ? `<img src="${p.logo}" class="img-fluid" style="max-height:60px;">` 
                : '<small class="text-muted">لا يوجد شعار</small>';
            new bootstrap.Modal(document.getElementById('editPartnerModal')).show();
        }
    });
}

// حفظ تعديل الشريك
document.getElementById('editPartnerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('edit_partner_id').value;
    const formData = new FormData(this);
    fetch(`/dashboard/partners/edit/${id}`, {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('editPartnerModal')).hide();
            showToast(data.message || 'تم التحديث بنجاح', 'success');
            setTimeout(() => location.reload(), 800);
        } else {
            showToast(data.message || 'حدث خطأ', 'danger');
        }
    })
    .catch(() => showToast('حدث خطأ في الاتصال', 'danger'));
});

// تفعيل/تعطيل شريك
function togglePartnerStatus(id) {
    fetch(`/dashboard/partners/toggle/${id}`, {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest'},
        body: JSON.stringify({'<?= CSRF_TOKEN_NAME ?>': '<?= Security::csrfToken() ?>'})
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast(data.message || 'تم تغيير الحالة', 'success');
            setTimeout(() => location.reload(), 800);
        }
    });
}

// حذف شريك
function deletePartnerConfirm(id) {
    if (!confirm('هل أنت متأكد من حذف هذا الشريك؟')) return;
    fetch(`/dashboard/partners/delete/${id}`, {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest'},
        body: JSON.stringify({'<?= CSRF_TOKEN_NAME ?>': '<?= Security::csrfToken() ?>'})
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const card = document.getElementById(`partner-${id}`);
            if (card) { card.style.transition = 'all 0.3s'; card.style.opacity = '0'; card.style.transform = 'scale(0.8)'; }
            showToast(data.message || 'تم الحذف بنجاح', 'success');
            setTimeout(() => location.reload(), 800);
        } else {
            showToast(data.message || 'حدث خطأ', 'danger');
        }
    });
}

function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} position-fixed top-0 end-0 m-3 z-index-9999`;
    toast.style.cssText = 'z-index:9999; animation: fadeIn 0.3s;';
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}
</script>

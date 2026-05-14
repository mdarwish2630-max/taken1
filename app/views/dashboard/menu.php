<?php
/**
 * Dashboard - Menu Management
 * لوحة التحكم - إدارة المنو
 */
$sections = $availableSections ?? [];
$items = $menuItems ?? [];
$missingSections = $missingSections ?? [];
$missingPages = $missingPages ?? [];
?>

<div class="card">
    <div class="card-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
        <h2 class="card-title"><i class="fas fa-bars" style="margin-inline-end:0.5rem;"></i> إدارة المنو</h2>
        <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
            <button type="button" class="btn btn-primary btn-sm" onclick="showAddSectionModal()" <?= empty($missingSections) ? 'disabled' : '' ?>>
                <i class="fas fa-plus"></i> إضافة قسم
            </button>
            <button type="button" class="btn btn-outline btn-sm" onclick="showAddPageModal()" <?= empty($missingPages) ? 'disabled' : '' ?>>
                <i class="fas fa-file-alt"></i> إضافة صفحة
            </button>
            <button type="button" class="btn btn-outline btn-sm" onclick="showAddExternalModal()">
                <i class="fas fa-external-link-alt"></i> رابط خارجي
            </button>
        </div>
    </div>

    <div class="card-body">
        <p style="color:var(--secondary); margin-bottom:1.5rem; font-size:0.9rem;">
            <i class="fas fa-info-circle"></i>
            اسحب وأفلت العناصر لتغيير الترتيب. استخدم زر التفعيل/الإخفاء للتحكم بالظهور في منو الموقع.
        </p>

        <?php if (empty($items)): ?>
        <div class="text-center" style="padding:3rem; color:var(--secondary);">
            <i class="fas fa-bars" style="font-size:3rem; margin-bottom:1rem; opacity:0.3;"></i>
            <p>المنو فارغ. أضف أقساماً أو صفحات للبدء.</p>
        </div>
        <?php else: ?>
        <div id="menuItemsList">
            <?php foreach ($items as $idx => $item):
                $typeLabel = '';
                $typeColor = '#6c757d';
                if ($item->item_type === 'section') {
                    $typeLabel = 'قسم';
                    $typeColor = '#4f46e5';
                } elseif ($item->item_type === 'page') {
                    $typeLabel = 'صفحة';
                    $typeColor = '#059669';
                } else {
                    $typeLabel = 'رابط';
                    $typeColor = '#dc2626';
                }
                $sectionInfo = ($item->item_type === 'section' && isset($sections[$item->section_key])) ? $sections[$item->section_key] : null;
            ?>
            <div class="menu-item-row" data-id="<?= (int)$item->id ?>" style="display:flex; align-items:center; gap:0.75rem; padding:0.85rem 1rem; border:1px solid var(--gray-200, #e2e8f0); border-radius:0.5rem; margin-bottom:0.5rem; background:<?= $item->is_active ? '#fff' : '#f8fafc' ?>; transition:all 0.2s;">
                <!-- Drag Handle -->
                <div style="cursor:grab; color:#94a3b8; font-size:1.1rem; padding:0.25rem;" title="اسحب للترتيب">
                    <i class="fas fa-grip-vertical"></i>
                </div>

                <!-- Order Number -->
                <span style="background:#f1f5f9; color:#64748b; width:28px; height:28px; display:flex; align-items:center; justify-content:center; border-radius:50%; font-size:0.8rem; font-weight:700; flex-shrink:0;">
                    <?= $idx + 1 ?>
                </span>

                <!-- Icon -->
                <div style="width:36px; height:36px; display:flex; align-items:center; justify-content:center; border-radius:8px; background:<?= $typeColor ?>15; color:<?= $typeColor ?>; font-size:1rem; flex-shrink:0;">
                    <i class="fas <?= $item->icon ?: 'fa-link' ?>"></i>
                </div>

                <!-- Info -->
                <div style="flex:1; min-width:0;">
                    <div style="font-weight:600; font-size:0.95rem; color:var(--dark, #1e293b);">
                        <?= htmlspecialchars($item->label) ?>
                        <?php if ($item->label_en): ?>
                        <span style="color:#94a3b8; font-weight:400; font-size:0.8rem; margin-inline-start:0.5rem;"><?= htmlspecialchars($item->label_en) ?></span>
                        <?php endif; ?>
                    </div>
                    <div style="font-size:0.78rem; color:#94a3b8; margin-top:2px;">
                        <span style="background:<?= $typeColor ?>15; color:<?= $typeColor ?>; padding:1px 8px; border-radius:10px; font-weight:600;"><?= $typeLabel ?></span>
                        <?php if ($item->item_type === 'section' && $sectionInfo): ?>
                            <span style="margin-inline-start:0.5rem;">section_key: <?= $item->section_key ?></span>
                        <?php elseif ($item->item_type === 'page'): ?>
                            <span style="margin-inline-start:0.5rem;">page_id: <?= (int)$item->page_id ?></span>
                        <?php elseif ($item->item_type === 'external'): ?>
                            <span style="margin-inline-start:0.5rem; direction:ltr; display:inline-block;"><?= htmlspecialchars($item->url ?? '') ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Actions -->
                <div style="display:flex; gap:0.35rem; flex-shrink:0;">
                    <!-- Edit Labels -->
                    <button type="button" class="btn btn-sm btn-outline" onclick="editItem(<?= (int)$item->id ?>, '<?= htmlspecialchars(addslashes($item->label)) ?>', '<?= htmlspecialchars(addslashes($item->label_en ?? '')) ?>')" title="تعديل التسمية">
                        <i class="fas fa-pen" style="font-size:0.75rem;"></i>
                    </button>
                    <!-- Toggle Active -->
                    <button type="button" class="btn btn-sm <?= $item->is_active ? 'btn-success' : 'btn-secondary' ?>" onclick="toggleItem(<?= (int)$item->id ?>)" title="<?= $item->is_active ? 'إخفاء من المنو' : 'إظهار في المنو' ?>">
                        <i class="fas <?= $item->is_active ? 'fa-eye' : 'fa-eye-slash' ?>" style="font-size:0.75rem;"></i>
                    </button>
                    <!-- Delete -->
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeItem(<?= (int)$item->id ?>)" title="حذف">
                        <i class="fas fa-trash" style="font-size:0.75rem;"></i>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- ==================== Add Section Modal ==================== -->
<div id="addSectionModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; display:none; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:0.75rem; padding:2rem; width:90%; max-width:480px; max-height:80vh; overflow-y:auto;">
        <h3 style="font-weight:700; margin-bottom:1rem;"><i class="fas fa-th-list" style="margin-inline-end:0.5rem; color:#4f46e5;"></i> إضافة قسم للمنو</h3>
        <div id="sectionList" style="display:flex; flex-direction:column; gap:0.5rem;">
            <?php foreach ($missingSections as $key => $sec): ?>
            <button type="button" class="btn btn-outline" style="text-align:start; padding:0.75rem 1rem;" onclick="addSection('<?= $key ?>')">
                <i class="fas <?= $sec['icon'] ?>" style="margin-inline-end:0.5rem; color:#4f46e5;"></i>
                <?= htmlspecialchars($sec['label']) ?>
                <?php if ($sec['label_en']): ?><span style="color:#94a3b8; font-size:0.85rem; margin-inline-start:0.5rem;"><?= $sec['label_en'] ?></span><?php endif; ?>
            </button>
            <?php endforeach; ?>
            <?php if (empty($missingSections)): ?>
            <p style="text-align:center; color:#94a3b8; padding:1rem;">جميع الأقسام مضافة بالفعل</p>
            <?php endif; ?>
        </div>
        <button type="button" class="btn btn-secondary" style="margin-top:1rem; width:100%;" onclick="closeAllModals()">إلغاء</button>
    </div>
</div>

<!-- ==================== Add Page Modal ==================== -->
<div id="addPageModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:0.75rem; padding:2rem; width:90%; max-width:480px; max-height:80vh; overflow-y:auto;">
        <h3 style="font-weight:700; margin-bottom:1rem;"><i class="fas fa-file-alt" style="margin-inline-end:0.5rem; color:#059669;"></i> إضافة صفحة للمنو</h3>
        <div id="pageList" style="display:flex; flex-direction:column; gap:0.5rem;">
            <?php foreach ($missingPages as $pg): ?>
            <button type="button" class="btn btn-outline" style="text-align:start; padding:0.75rem 1rem;" onclick="addPage(<?= (int)$pg->id ?>)">
                <i class="fas fa-file-alt" style="margin-inline-end:0.5rem; color:#059669;"></i>
                <?= htmlspecialchars($pg->title) ?>
                <?php if ($pg->title_en): ?><span style="color:#94a3b8; font-size:0.85rem; margin-inline-start:0.5rem;"><?= $pg->title_en ?></span><?php endif; ?>
            </button>
            <?php endforeach; ?>
            <?php if (empty($missingPages)): ?>
            <p style="text-align:center; color:#94a3b8; padding:1rem;">لا توجد صفحات متاحة (جميعها مضافة أو لا توجد صفحات منشورة)</p>
            <?php endif; ?>
        </div>
        <button type="button" class="btn btn-secondary" style="margin-top:1rem; width:100%;" onclick="closeAllModals()">إلغاء</button>
    </div>
</div>

<!-- ==================== Add External Link Modal ==================== -->
<div id="addExternalModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:0.75rem; padding:2rem; width:90%; max-width:480px;">
        <h3 style="font-weight:700; margin-bottom:1rem;"><i class="fas fa-external-link-alt" style="margin-inline-end:0.5rem; color:#dc2626;"></i> إضافة رابط خارجي</h3>
        <form id="externalForm" onsubmit="addExternal(event)">
            <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
            <div style="margin-bottom:1rem;">
                <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.875rem;">العنوان (عربي) *</label>
                <input type="text" name="label" required class="form-control" placeholder="مثال: متجرنا">
            </div>
            <div style="margin-bottom:1rem;">
                <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.875rem;">العنوان (إنجليزي)</label>
                <input type="text" name="label_en" class="form-control" placeholder="Our Store" dir="ltr">
            </div>
            <div style="margin-bottom:1rem;">
                <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.875rem;">الرابط (URL) *</label>
                <input type="url" name="url" required class="form-control" placeholder="https://example.com" dir="ltr">
            </div>
            <div style="margin-bottom:1rem;">
                <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer; font-size:0.875rem;">
                    <input type="checkbox" name="open_in_new_tab" value="1" checked> فتح في نافذة جديدة
                </label>
            </div>
            <div style="display:flex; gap:0.5rem;">
                <button type="submit" class="btn btn-primary" style="flex:1;"><i class="fas fa-plus"></i> إضافة</button>
                <button type="button" class="btn btn-secondary" style="flex:1;" onclick="closeAllModals()">إلغاء</button>
            </div>
        </form>
    </div>
</div>

<!-- ==================== Edit Labels Modal ==================== -->
<div id="editModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:0.75rem; padding:2rem; width:90%; max-width:480px;">
        <h3 style="font-weight:700; margin-bottom:1rem;"><i class="fas fa-pen" style="margin-inline-end:0.5rem; color:#4f46e5;"></i> تعديل التسمية</h3>
        <form id="editForm" onsubmit="saveLabels(event)">
            <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
            <input type="hidden" name="id" id="editId">
            <div style="margin-bottom:1rem;">
                <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.875rem;">العنوان (عربي) *</label>
                <input type="text" name="label" id="editLabel" required class="form-control">
            </div>
            <div style="margin-bottom:1rem;">
                <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.875rem;">العنوان (إنجليزي)</label>
                <input type="text" name="label_en" id="editLabelEn" class="form-control" dir="ltr">
            </div>
            <div style="display:flex; gap:0.5rem;">
                <button type="submit" class="btn btn-primary" style="flex:1;"><i class="fas fa-save"></i> حفظ</button>
                <button type="button" class="btn btn-secondary" style="flex:1;" onclick="closeAllModals()">إلغاء</button>
            </div>
        </form>
    </div>
</div>

<style>
.form-control {
    width: 100%; padding: 0.6rem 0.85rem;
    border: 1.5px solid #e2e8f0; border-radius: 0.5rem;
    font-size: 0.9rem; font-family: inherit; outline: none;
    background: #fff; color: #1e293b;
}
.form-control:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.12); }
.menu-item-row:hover { border-color: #4f46e5 !important; box-shadow: 0 2px 8px rgba(79,70,229,0.08); }
.btn { display:inline-flex; align-items:center; justify-content:center; gap:0.35rem; padding:0.5rem 1rem; border-radius:0.5rem; font-size:0.85rem; font-weight:600; font-family:inherit; cursor:pointer; border:1.5px solid transparent; transition:all 0.2s; text-decoration:none; }
.btn-primary { background:#4f46e5; color:#fff; border-color:#4f46e5; }
.btn-primary:hover { background:#3730a3; }
.btn-success { background:#059669; color:#fff; border-color:#059669; }
.btn-success:hover { background:#047857; }
.btn-danger { background:#dc2626; color:#fff; border-color:#dc2626; }
.btn-danger:hover { background:#b91c1c; }
.btn-secondary { background:#e2e8f0; color:#475569; border-color:#e2e8f0; }
.btn-outline { background:#fff; color:#475569; border-color:#e2e8f0; }
.btn-outline:hover { background:#f1f5f9; border-color:#cbd5e1; }
.btn-sm { padding:0.3rem 0.65rem; font-size:0.8rem; }
.btn:disabled { opacity:0.5; cursor:not-allowed; }
</style>

<script>
var csrfToken = '<?= Security::csrfToken() ?>';

function closeAllModals() {
    document.getElementById('addSectionModal').style.display = 'none';
    document.getElementById('addPageModal').style.display = 'none';
    document.getElementById('addExternalModal').style.display = 'none';
    document.getElementById('editModal').style.display = 'none';
}

function showAddSectionModal() {
    document.getElementById('addSectionModal').style.display = 'flex';
}
function showAddPageModal() {
    document.getElementById('addPageModal').style.display = 'flex';
}
function showAddExternalModal() {
    document.getElementById('addExternalModal').style.display = 'flex';
}

function apiCall(url, data, onSuccess) {
    fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': csrfToken },
        body: JSON.stringify(data)
    })
    .then(function(r) { return r.json(); })
    .then(function(res) {
        if (res.success) {
            csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || csrfToken;
            if (onSuccess) onSuccess(res);
        } else {
            alert(res.message || 'حدث خطأ');
        }
    })
    .catch(function() { alert('حدث خطأ في الاتصال'); });
}

function addSection(key) {
    apiCall('<?= url('/dashboard/menu/add-section') ?>', { section_key: key }, function() {
        location.reload();
    });
}

function addPage(pageId) {
    apiCall('<?= url('/dashboard/menu/add-page') ?>', { page_id: pageId }, function() {
        location.reload();
    });
}

function addExternal(e) {
    e.preventDefault();
    var form = e.target;
    var data = {
        label: form.label.value,
        label_en: form.label_en.value || '',
        url: form.url.value,
        open_in_new_tab: form.open_in_new_tab.checked ? 1 : 0
    };
    apiCall('<?= url('/dashboard/menu/add-external') ?>', data, function() {
        location.reload();
    });
}

function toggleItem(id) {
    apiCall('<?= url('/dashboard/menu/toggle') ?>', { id: id }, function() {
        location.reload();
    });
}

function removeItem(id) {
    if (!confirm('هل أنت متأكد من حذف هذا العنصر من المنو؟')) return;
    apiCall('<?= url('/dashboard/menu/remove') ?>', { id: id }, function() {
        location.reload();
    });
}

function editItem(id, label, labelEn) {
    document.getElementById('editId').value = id;
    document.getElementById('editLabel').value = label;
    document.getElementById('editLabelEn').value = labelEn || '';
    document.getElementById('editModal').style.display = 'flex';
}

function saveLabels(e) {
    e.preventDefault();
    var form = e.target;
    apiCall('<?= url('/dashboard/menu/update-labels') ?>', {
        id: form.id.value,
        label: form.label.value,
        label_en: form.label_en.value || ''
    }, function() {
        location.reload();
    });
}

// Drag and Drop for reordering
(function() {
    var list = document.getElementById('menuItemsList');
    if (!list) return;

    var dragSrc = null;

    list.querySelectorAll('.menu-item-row').forEach(function(row) {
        row.setAttribute('draggable', 'true');

        row.addEventListener('dragstart', function(e) {
            dragSrc = this;
            this.style.opacity = '0.4';
            e.dataTransfer.effectAllowed = 'move';
        });

        row.addEventListener('dragend', function() {
            this.style.opacity = '1';
            list.querySelectorAll('.menu-item-row').forEach(function(r) {
                r.style.borderTop = '';
            });
        });

        row.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            this.style.borderTop = '3px solid #4f46e5';
        });

        row.addEventListener('dragleave', function() {
            this.style.borderTop = '';
        });

        row.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.borderTop = '';
            if (dragSrc !== this) {
                list.insertBefore(dragSrc, this);
                saveOrder();
            }
        });
    });

    function saveOrder() {
        var orders = {};
        list.querySelectorAll('.menu-item-row').forEach(function(row, idx) {
            orders[row.getAttribute('data-id')] = idx + 1;
        });

        fetch('<?= url('/dashboard/menu/update-order') ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': csrfToken },
            body: JSON.stringify({ orders: orders })
        })
        .then(function(r) { return r.json(); })
        .catch(function() {});
    }
})();
</script>

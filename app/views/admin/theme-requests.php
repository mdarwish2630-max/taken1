<?php
/**
 * Admin Theme Requests View - طلبات تفعيل الثيمات المدفوعة
 */
$dir = Language::direction();

$statusLabels = [
    'pending' => ['text' => 'قيد المراجعة', 'icon' => 'fa-clock', 'bg' => '#fef3c7', 'color' => '#92400e', 'border' => '#fde68a'],
    'approved' => ['text' => 'موافق عليه', 'icon' => 'fa-check-circle', 'bg' => '#dcfce7', 'color' => '#166534', 'border' => '#bbf7d0'],
    'rejected' => ['text' => 'مرفوض', 'icon' => 'fa-times-circle', 'bg' => '#fecaca', 'color' => '#991b1b', 'border' => '#fca5a5'],
    'cancelled' => ['text' => 'ملغي', 'icon' => 'fa-ban', 'bg' => '#f1f5f9', 'color' => '#475569', 'border' => '#e2e8f0'],
];
?>

<div class="page-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
    <h1 class="page-title">
        <i class="fas fa-palette" style="color:#f59e0b;"></i>
        طلبات تفعيل القوالب المدفوعة
    </h1>
    <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
        <a href="<?= url('/admin/theme-requests') ?>" class="btn <?= empty($status_filter) ? 'btn-primary' : 'btn-outline' ?>">
            الكل
        </a>
        <a href="<?= url('/admin/theme-requests?status=pending') ?>" class="btn <?= ($status_filter === 'pending') ? 'btn-primary' : 'btn-outline' ?>">
            <i class="fas fa-clock"></i> قيد المراجعة
        </a>
        <a href="<?= url('/admin/theme-requests?status=approved') ?>" class="btn <?= ($status_filter === 'approved') ? 'btn-primary' : 'btn-outline' ?>">
            <i class="fas fa-check"></i> موافق عليه
        </a>
        <a href="<?= url('/admin/theme-requests?status=rejected') ?>" class="btn <?= ($status_filter === 'rejected') ? 'btn-primary' : 'btn-outline' ?>">
            <i class="fas fa-times"></i> مرفوض
        </a>
    </div>
</div>

<!-- Stats -->
<?php
$pendingCount = 0;
$approvedCount = 0;
$rejectedCount = 0;
if (!empty($requests)) {
    foreach ($requests as $r) {
        if ($r->status === 'pending') $pendingCount++;
        elseif ($r->status === 'approved') $approvedCount++;
        elseif ($r->status === 'rejected') $rejectedCount++;
    }
}
?>
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:1rem; margin-bottom:1.5rem;">
    <div style="background:#fffbeb; border:1px solid #fde68a; border-radius:12px; padding:1rem 1.25rem; display:flex; align-items:center; gap:1rem;">
        <div style="width:44px; height:44px; border-radius:12px; background:linear-gradient(135deg,#f59e0b,#d97706); display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.1rem;">
            <i class="fas fa-clock"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:800; color:#92400e;"><?= $pendingCount ?></div>
            <div style="font-size:0.78rem; color:#a16207; font-weight:600;">قيد المراجعة</div>
        </div>
    </div>
    <div style="background:#dcfce7; border:1px solid #bbf7d0; border-radius:12px; padding:1rem 1.25rem; display:flex; align-items:center; gap:1rem;">
        <div style="width:44px; height:44px; border-radius:12px; background:linear-gradient(135deg,#10b981,#059669); display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.1rem;">
            <i class="fas fa-check"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:800; color:#166534;"><?= $approvedCount ?></div>
            <div style="font-size:0.78rem; color:#15803d; font-weight:600;">موافق عليها</div>
        </div>
    </div>
    <div style="background:#fecaca; border:1px solid #fca5a5; border-radius:12px; padding:1rem 1.25rem; display:flex; align-items:center; gap:1rem;">
        <div style="width:44px; height:44px; border-radius:12px; background:linear-gradient(135deg,#ef4444,#dc2626); display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.1rem;">
            <i class="fas fa-times"></i>
        </div>
        <div>
            <div style="font-size:1.5rem; font-weight:800; color:#991b1b;"><?= $rejectedCount ?></div>
            <div style="font-size:0.78rem; color:#b91c1c; font-weight:600;">مرفوضة</div>
        </div>
    </div>
</div>

<?php if (empty($requests)): ?>
<div style="background:#f8fafc; border:2px dashed #e2e8f0; border-radius:16px; padding:3rem; text-align:center;">
    <i class="fas fa-inbox" style="font-size:3rem; color:#cbd5e1; margin-bottom:1rem; display:block;"></i>
    <h3 style="color:#64748b; margin-bottom:0.5rem;">لا توجد طلبات</h3>
    <p style="color:#94a3b8; font-size:0.9rem;">لم يتم تقديم أي طلبات تفعيل لقوالب مدفوعة بعد</p>
</div>
<?php else: ?>

<div style="display:flex; flex-direction:column; gap:1rem;">
    <?php foreach ($requests as $req):
        $s = $statusLabels[$req->status] ?? $statusLabels['pending'];
    ?>
    <div style="background:#fff; border-radius:14px; box-shadow:0 1px 4px rgba(0,0,0,0.06); border:1px solid #e5e7eb; overflow:hidden; transition:all 0.2s;" id="request-<?= $req->id ?>">
        <!-- Top Bar with Status -->
        <div style="background:<?= $s['bg'] ?>; border-bottom:1px solid <?= $s['border'] ?>; padding:0.6rem 1.25rem; display:flex; justify-content:space-between; align-items:center;">
            <div style="display:flex; align-items:center; gap:0.5rem; color:<?= $s['color'] ?>; font-weight:700; font-size:0.82rem;">
                <i class="fas <?= $s['icon'] ?>"></i>
                <?= $s['text'] ?>
            </div>
            <div style="font-size:0.75rem; color:#64748b;">
                <i class="fas fa-calendar-alt"></i>
                <?= date('Y/m/d H:i', strtotime($req->created_at)) ?>
            </div>
        </div>

        <!-- Request Content -->
        <div style="padding:1.25rem;">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.25rem; margin-bottom:1rem;">
                <!-- Customer Info -->
                <div>
                    <div style="font-size:0.72rem; color:#94a3b8; font-weight:600; text-transform:uppercase; margin-bottom:0.4rem;">
                        <i class="fas fa-user"></i> المشترك
                    </div>
                    <div style="font-weight:700; color:#1e293b; font-size:0.95rem;"><?= $this->e($req->customer_name) ?></div>
                    <div style="font-size:0.82rem; color:#64748b;"><?= $this->e($req->customer_email) ?></div>
                    <div style="font-size:0.82rem; color:#3b82f6; margin-top:0.15rem;">
                        <i class="fas fa-globe"></i> <?= $this->e($req->site_name) ?>
                    </div>
                </div>

                <!-- Theme Info -->
                <div>
                    <div style="font-size:0.72rem; color:#94a3b8; font-weight:600; text-transform:uppercase; margin-bottom:0.4rem;">
                        <i class="fas fa-palette"></i> القالب المطلوب
                    </div>
                    <div style="font-weight:700; color:#1e293b; font-size:0.95rem;">
                        <i class="fas fa-crown" style="color:#f59e0b;"></i>
                        <?= $this->e($req->theme_name) ?>
                    </div>
                    <div style="font-size:0.9rem; font-weight:700; color:#d97706; margin-top:0.25rem;">
                        <?= number_format($req->theme_price, 2) ?> <?= $req->currency ?? 'SAR' ?>
                    </div>
                </div>
            </div>

            <?php if (!empty($req->tenant_notes)): ?>
            <div style="background:#f8fafc; border-radius:8px; padding:0.75rem 1rem; margin-bottom:1rem; border:1px solid #e2e8f0;">
                <div style="font-size:0.72rem; color:#94a3b8; font-weight:600; margin-bottom:0.25rem;">
                    <i class="fas fa-comment"></i> ملاحظات المشترك:
                </div>
                <p style="margin:0; font-size:0.85rem; color:#475569;"><?= nl2br($this->e($req->tenant_notes)) ?></p>
            </div>
            <?php endif; ?>

            <?php if (!empty($req->admin_notes)): ?>
            <div style="background:<?= $req->status === 'approved' ? '#ecfdf5' : '#fef2f2' ?>; border-radius:8px; padding:0.75rem 1rem; margin-bottom:1rem; border:1px solid <?= $req->status === 'approved' ? '#a7f3d0' : '#fecaca' ?>;">
                <div style="font-size:0.72rem; color:<?= $req->status === 'approved' ? '#065f46' : '#991b1b' ?>; font-weight:600; margin-bottom:0.25rem;">
                    <i class="fas fa-user-shield"></i> ملاحظات الإدارة:
                </div>
                <p style="margin:0; font-size:0.85rem; color:<?= $req->status === 'approved' ? '#047857' : '#b91c1c' ?>;"><?= nl2br($this->e($req->admin_notes)) ?></p>
            </div>
            <?php endif; ?>

            <!-- Action Buttons for Pending -->
            <?php if ($req->status === 'pending'): ?>
            <div style="display:flex; gap:0.75rem; align-items:center; flex-wrap:wrap;">
                <div style="flex:1; min-width:200px;">
                    <textarea id="admin_notes_<?= $req->id ?>" rows="1" placeholder="أضف ملاحظة (اختياري)..." style="width:100%; padding:0.5rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.82rem; font-family:inherit; resize:none; box-sizing:border-box;"></textarea>
                </div>
                <form method="POST" action="<?= url('/admin/theme-requests/approve/' . $req->id) ?>" style="display:inline;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="admin_notes" id="approve_notes_<?= $req->id ?>" value="">
                    <button type="button" class="btn-approve-action" onclick="submitWithNotes(<?= $req->id ?>, 'approve')" style="padding:0.6rem 1.5rem; border:none; border-radius:8px; background:linear-gradient(135deg,#10b981,#059669); color:#fff; font-weight:700; font-size:0.85rem; cursor:pointer; display:inline-flex; align-items:center; gap:0.5rem; font-family:inherit;">
                        <i class="fas fa-check"></i> موافقة وتفعيل
                    </button>
                </form>
                <form method="POST" action="<?= url('/admin/theme-requests/reject/' . $req->id) ?>" style="display:inline;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="admin_notes" id="reject_notes_<?= $req->id ?>" value="">
                    <button type="button" class="btn-reject-action" onclick="submitWithNotes(<?= $req->id ?>, 'reject')" style="padding:0.6rem 1.5rem; border:none; border-radius:8px; background:linear-gradient(135deg,#ef4444,#dc2626); color:#fff; font-weight:700; font-size:0.85rem; cursor:pointer; display:inline-flex; align-items:center; gap:0.5rem; font-family:inherit;">
                        <i class="fas fa-times"></i> رفض
                    </button>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<script>
function submitWithNotes(requestId, action) {
    var notesEl = document.getElementById('admin_notes_' + requestId);
    var notes = notesEl ? notesEl.value.trim() : '';

    if (action === 'approve') {
        var hiddenInput = document.getElementById('approve_notes_' + requestId);
        if (hiddenInput) hiddenInput.value = notes;
        hiddenInput.form.submit();
    } else {
        var hiddenInput = document.getElementById('reject_notes_' + requestId);
        if (hiddenInput) hiddenInput.value = notes;
        hiddenInput.form.submit();
    }
}
</script>

<style>
.page-title { font-size: 1.25rem; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 0.5rem; }
.btn { padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.82rem; font-weight: 600; cursor: pointer; border: 1px solid #d1d5db; background: #fff; color: #475569; display: inline-flex; align-items: center; gap: 0.4rem; transition: all 0.2s; text-decoration: none; font-family: inherit; }
.btn:hover { background: #f1f5f9; }
.btn-primary { background: linear-gradient(135deg, #4f46e5, #7c3aed); color: #fff; border: none; }
.btn-primary:hover { box-shadow: 0 4px 12px rgba(79,70,229,0.3); }

@media (max-width: 768px) {
    div[style*="grid-template-columns:1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
}
</style>

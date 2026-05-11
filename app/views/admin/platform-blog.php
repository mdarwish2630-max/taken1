<?php
/**
 * Admin - Platform Blog Listing
 * إدارة مقالات مدونة المنصة
 */

$dir = Language::direction();
?>

<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-newspaper"></i>
        إدارة المدونة
    </h1>
    <a href="<?= url('/admin/blog/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> إضافة مقال جديد
    </a>
</div>

<?php if (Session::has('success')): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    <?= Session::getSuccess() ?>
</div>
<?php endif; ?>

<?php if (!empty($posts)): ?>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?= $dir === 'rtl' ? 'العنوان' : 'Title' ?></th>
                        <th><?= $dir === 'rtl' ? 'التصنيف' : 'Category' ?></th>
                        <th><?= $dir === 'rtl' ? 'الحالة' : 'Status' ?></th>
                        <th><?= $dir === 'rtl' ? 'المشاهدات' : 'Views' ?></th>
                        <th><?= $dir === 'rtl' ? 'التاريخ' : 'Date' ?></th>
                        <th><?= $dir === 'rtl' ? 'الإجراءات' : 'Actions' ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $p): ?>
                    <tr>
                        <td><?= $p->id ?></td>
                        <td>
                            <a href="<?= url('/blog/' . $p->slug) ?>" target="_blank" style="color:var(--primary);font-weight:600;">
                                <?= htmlspecialchars(mb_substr($p->title, 0, 60)) ?>
                            </a>
                        </td>
                        <td>
                            <?php if (!empty($p->category)): ?>
                            <span class="badge badge-info"><?= htmlspecialchars($p->category) ?></span>
                            <?php else: ?>
                            <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($p->status === 'published'): ?>
                                <span class="badge badge-success"><?= $dir === 'rtl' ? 'منشور' : 'Published' ?></span>
                            <?php else: ?>
                                <span class="badge badge-warning"><?= $dir === 'rtl' ? 'مسودة' : 'Draft' ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?= number_format($p->views ?? 0) ?></td>
                        <td><?= date('Y-m-d', strtotime($p->created_at)) ?></td>
                        <td>
                            <a href="<?= url('/admin/blog/edit/' . $p->id) ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i> <?= $dir === 'rtl' ? 'تعديل' : 'Edit' ?>
                            </a>
                            <button onclick="deletePost(<?= $p->id ?>)" class="btn btn-sm btn-danger" style="background:transparent;border:1px solid var(--danger,#dc3545);color:var(--danger,#dc3545);border-radius:0.25rem;padding:0.35rem 0.75rem;font-size:0.85rem;display:inline-flex;align-items:center;gap:0.35rem;">
                                <i class="fas fa-trash"></i> <?= $dir === 'rtl' ? 'حذف' : 'Delete' ?>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php else: ?>
<div class="card">
    <div class="card-body">
        <p class="text-muted text-center py-4"><i class="fas fa-info-circle"></i> لا توجد مقالات بعد.</p>
    </div>
</div>
<?php endif; ?>

<form id="deleteForm" method="POST" style="display:none;">
    <input type="hidden" name="_token" value="<?= Security::generateCsrfToken() ?>">
</form>

<script>
function deletePost(id) {
    if (confirm('هل أنت متأكد من حذف هذا المقال؟')) {
        const form = document.getElementById('deleteForm');
        form.action = '<?= url("/admin/blog/delete/" . 0) ?>'.replace('/0', '/' + id);
        form.submit();
    }
}
</script>

<style>
.badge-info { background: #17a2b8; color: white; display: inline-block; padding: 0.25rem 0.6rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 600; }
.badge-success { background: #28a745; color: white; display: inline-block; padding: 0.25rem 0.6rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 600; }
.badge-warning { background: #ffc107; color: #212529; display: inline-block; padding: 0.25rem 0.6rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 600; }
.text-muted { color: var(--text-muted, #64748b); }
.text-center { text-align: center; }
.py-4 { padding-top: 2rem; padding-bottom: 2rem; }
</style>

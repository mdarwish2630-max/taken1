<?php
/**
 * Dashboard - Pages List
 * لوحة التحكم - قائمة الصفحات
 */

?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title"><?= lang('pages') ?></h2>
        <a href="<?= url('/dashboard/pages/add') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            <?= lang('add_page') ?>
        </a>
    </div>
    
    <div class="card-body">
        <?php if (!empty($pages)): ?>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th><?= lang('title') ?></th>
                        <th><?= lang('status') ?></th>
                        <th><?= lang('show_in_menu') ?></th>
                        <th><?= lang('created_at') ?></th>
                        <th><?= lang('actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pages as $page): ?>
                    <tr>
                        <td>
                            <div style="font-weight: 500;">
                                <?= htmlspecialchars($page->title) ?>
                                <?php if ($page->is_home): ?>
                                    <span class="badge badge-info" style="margin-inline-start: 0.5rem;"><?= lang('home_page') ?></span>
                                <?php endif; ?>
                            </div>
                            <small style="color: var(--secondary);">/<?= $this->e($page->slug) ?></small>
                        </td>
                        <td>
                            <?php if ($page->status === 'published'): ?>
                                <span class="badge badge-success"><?= lang('published') ?></span>
                            <?php else: ?>
                                <span class="badge badge-warning"><?= lang('draft') ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($page->show_in_menu): ?>
                                <span class="badge badge-success"><i class="fas fa-check"></i></span>
                            <?php else: ?>
                                <span class="badge badge-secondary"><i class="fas fa-times"></i></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= date('Y/m/d', strtotime($page->created_at)) ?>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="<?= url('/dashboard/pages/edit/' . $page->id) ?>" class="btn btn-sm btn-outline" title="<?= lang('edit') ?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if (!$page->is_home): ?>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deletePage(<?= $page->id ?>)" title="<?= lang('delete') ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="text-center" style="padding: 3rem; color: var(--secondary);">
            <i class="fas fa-file-alt" style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.3;"></i>
            <p><?= lang('no_pages') ?></p>
            <a href="<?= url('/dashboard/pages/add') ?>" class="btn btn-primary mt-3">
                <i class="fas fa-plus"></i>
                <?= lang('add_page') ?>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function deletePage(id) {
    if (confirm('<?= lang('confirm_delete') ?>')) {
        fetch('<?= url('/dashboard/pages/delete/') ?>' + id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': '<?= Security::csrfToken() ?>'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || '<?= lang('error') ?>');
            }
        });
    }
}
</script>

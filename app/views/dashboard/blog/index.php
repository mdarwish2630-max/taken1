<?php
/**
 * Blog Posts Index View
 * صفحة قائمة مقالات المدونة
 */

$tenant = Auth::tenant();
?>

<div class="page-header d-flex justify-content-between align-items-center">
    <h1 class="h3 mb-0">
        <i class="fas fa-blog me-2"></i>
        <?= lang('blog_posts') ?>
    </h1>
    <a href="<?= url('/dashboard/blog/add') ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        <?= lang('add_post') ?>
    </a>
</div>

<?php if (empty($posts)): ?>
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
            <h4 class="text-muted"><?= lang('no_posts') ?></h4>
            <p class="text-muted"><?= lang('no_posts_desc') ?></p>
            <a href="<?= url('/dashboard/blog/add') ?>" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                <?= lang('add_first_post') ?>
            </a>
        </div>
    </div>
<?php else: ?>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="postsTable">
                    <thead>
                        <tr>
                            <th width="60"><?= lang('image') ?></th>
                            <th><?= lang('post_title') ?></th>
                            <th><?= lang('category') ?></th>
                            <th><?= lang('status') ?></th>
                            <th><?= lang('views') ?></th>
                            <th><?= lang('date') ?></th>
                            <th width="120"><?= lang('actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $post): ?>
                            <tr>
                                <td>
                                    <?php if ($post->featured_image): ?>
                                        <img src="<?= upload($post->featured_image) ?>" 
                                             alt="<?= htmlspecialchars($post->title) ?>"
                                             class="rounded" width="50" height="50" style="object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($post->title) ?></strong>
                                    <?php if ($post->show_on_home): ?>
                                        <span class="badge bg-info ms-1"><?= lang('home') ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($post->category): ?>
                                        <span class="badge bg-secondary"><?= $post->category ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($post->status === 'published'): ?>
                                        <span class="badge bg-success"><?= lang('published') ?></span>
                                    <?php elseif ($post->status === 'scheduled'): ?>
                                        <span class="badge bg-warning"><?= lang('scheduled') ?></span>
                                        <br><small><?= date('Y-m-d H:i', strtotime($post->published_at)) ?></small>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><?= lang('draft') ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <i class="fas fa-eye text-muted me-1"></i>
                                    <?= number_format($post->views ?? 0) ?>
                                </td>
                                <td>
                                    <?= date('Y-m-d', strtotime($post->created_at)) ?>
                                </td>
                                <td>
                                    <a href="<?= url('/dashboard/blog/edit/' . $post->id) ?>" 
                                       class="btn btn-sm btn-outline-primary" title="<?= lang('edit') ?>">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if ($post->status === 'published'): ?>
                                        <a href="<?= url('/' . $tenant->slug . '/blog/' . $post->slug) ?>" 
                                           class="btn btn-sm btn-outline-success" title="<?= lang('view') ?>" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    <?php endif; ?>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="deletePost(<?= $post->id ?>)" title="<?= lang('delete') ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
function deletePost(id) {
    if (confirm('<?= lang('confirm_delete') ?>')) {
        fetch('<?= url('/dashboard/blog/delete/') ?>' + id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="csrf_token"]')?.value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error');
            }
        });
    }
}

$(document).ready(function() {
    $('#postsTable').DataTable({
        order: [[5, 'desc']],
        language: {
            url: '<?= Language::current() === 'ar' ? 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json' : '' ?>'
        }
    });
});
</script>

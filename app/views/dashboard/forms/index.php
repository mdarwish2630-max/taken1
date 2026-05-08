<?php
/**
 * Custom Forms Index View
 * صفحة قائمة النماذج المخصصة
 */

$tenant = Auth::tenant();
?>

<div class="page-header d-flex justify-content-between align-items-center">
    <h1 class="h3 mb-0">
        <i class="fas fa-wpforms me-2"></i>
        <?= lang('custom_forms') ?>
    </h1>
    <a href="<?= url('/dashboard/forms/add') ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        <?= lang('create_form') ?>
    </a>
</div>

<?php if (empty($forms)): ?>
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-wpforms fa-4x text-muted mb-3"></i>
            <h4 class="text-muted"><?= lang('no_forms') ?></h4>
            <p class="text-muted"><?= lang('no_forms_desc') ?></p>
            <a href="<?= url('/dashboard/forms/add') ?>" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                <?= lang('create_first_form') ?>
            </a>
        </div>
    </div>
<?php else: ?>
    <div class="row">
        <?php foreach ($forms as $form): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title mb-0"><?= htmlspecialchars($form->name) ?></h5>
                            <?php if ($form->status === 'active'): ?>
                                <span class="badge bg-success"><?= lang('active') ?></span>
                            <?php else: ?>
                                <span class="badge bg-secondary"><?= lang('inactive') ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <?php if ($form->description): ?>
                            <p class="text-muted small"><?= htmlspecialchars($form->description) ?></p>
                        <?php endif; ?>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <i class="fas fa-list-ul text-muted me-1"></i>
                                <small class="text-muted">
                                    <?= count(json_decode($form->fields ?? '[]', true) ?: []) ?> <?= lang('fields') ?>
                                </small>
                            </div>
                            <div>
                                <i class="fas fa-inbox text-muted me-1"></i>
                                <small class="text-muted">
                                    <?= $form->submissions_count ?? 0 ?> <?= lang('submissions') ?>
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-white">
                        <div class="btn-group w-100">
                            <a href="<?= url('/dashboard/forms/edit/' . $form->id) ?>" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= url('/dashboard/forms/submissions/' . $form->id) ?>" 
                               class="btn btn-outline-success btn-sm">
                                <i class="fas fa-inbox"></i>
                            </a>
                            <button type="button" class="btn btn-outline-info btn-sm" 
                                    onclick="copyEmbedCode(<?= $form->id ?>, '<?= $form->slug ?>')">
                                <i class="fas fa-code"></i>
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm" 
                                    onclick="deleteForm(<?= $form->id ?>)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Embed Code Modal -->
<div class="modal fade" id="embedModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-code me-2"></i>
                    <?= lang('embed_code') ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted small"><?= lang('embed_desc') ?></p>
                <textarea class="form-control font-monospace" id="embedCode" rows="5" readonly></textarea>
                <button type="button" class="btn btn-primary mt-3 w-100" onclick="copyToClipboard()">
                    <i class="fas fa-copy me-2"></i>
                    <?= lang('copy_code') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function copyEmbedCode(formId, formSlug) {
    const code = `<div data-form-id="${formId}" data-form-slug="${formSlug}"></div>
<script src="<?= url('/js/form-embed.js') ?>"><\/script>`;
    
    document.getElementById('embedCode').value = code;
    new bootstrap.Modal(document.getElementById('embedModal')).show();
}

function copyToClipboard() {
    const textarea = document.getElementById('embedCode');
    textarea.select();
    document.execCommand('copy');
    
    alert('<?= lang('copied') ?>');
}

function deleteForm(id) {
    if (confirm('<?= lang('confirm_delete') ?>')) {
        fetch('<?= url('/dashboard/forms/delete/') ?>' + id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
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
</script>

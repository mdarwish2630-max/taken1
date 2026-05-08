<?php
/**
 * Form Submissions View
 * صفحة استجابات النموذج
 */

$tenant = Auth::tenant();
?>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="h3 mb-0">
            <i class="fas fa-inbox me-2"></i>
            <?= lang('form_submissions') ?>
        </h1>
        <p class="text-muted mb-0"><?= htmlspecialchars($form->name) ?></p>
    </div>
    <div>
        <a href="<?= url('/dashboard/forms') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-right me-2"></i>
            <?= lang('back') ?>
        </a>
        <button class="btn btn-success" onclick="exportSubmissions()">
            <i class="fas fa-download me-2"></i>
            <?= lang('export') ?>
        </button>
    </div>
</div>

<?php if (empty($submissions)): ?>
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
            <h4 class="text-muted"><?= lang('no_submissions') ?></h4>
            <p class="text-muted"><?= lang('no_submissions_desc') ?></p>
        </div>
    </div>
<?php else: ?>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="submissionsTable">
                    <thead>
                        <tr>
                            <th width="60">#</th>
                            <?php 
                            // Get all unique fields from submissions
                            $allFields = [];
                            foreach ($submissions as $submission) {
                                $data = json_decode($submission->data ?? '{}', true) ?: [];
                                $allFields = array_unique(array_merge($allFields, array_keys($data)));
                            }
                            foreach ($allFields as $field): 
                            ?>
                                <th><?= htmlspecialchars($field) ?></th>
                            <?php endforeach; ?>
                            <th width="150"><?= lang('date') ?></th>
                            <th width="80"><?= lang('actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($submissions as $index => $submission): 
                            $data = json_decode($submission->data ?? '{}', true) ?: [];
                        ?>
                            <tr>
                                <td><strong><?= $index + 1 ?></strong></td>
                                <?php foreach ($allFields as $field): ?>
                                    <td>
                                        <?php 
                                        $value = $data[$field] ?? '-';
                                        if (is_array($value)) {
                                            $value = implode(', ', $value);
                                        }
                                        echo htmlspecialchars(mb_substr($value, 0, 50) . (strlen($value) > 50 ? '...' : ''));
                                        ?>
                                    </td>
                                <?php endforeach; ?>
                                <td>
                                    <small><?= date('Y-m-d H:i', strtotime($submission->created_at)) ?></small>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            onclick="viewSubmission(<?= $submission->id ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="deleteSubmission(<?= $submission->id ?>)">
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

<!-- View Submission Modal -->
<div class="modal fade" id="submissionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-file-alt me-2"></i>
                    <?= lang('submission_details') ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="submissionContent">
                <!-- Content loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <?= lang('close') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
const submissionsData = <?= json_encode($submissions) ?>;

function viewSubmission(id) {
    const submission = submissionsData.find(s => s.id == id);
    if (!submission) return;
    
    const data = JSON.parse(submission.data || '{}');
    let html = '<table class="table"><tbody>';
    
    for (const [key, value] of Object.entries(data)) {
        html += `<tr>
            <th width="30%">${key}</th>
            <td>${Array.isArray(value) ? value.join(', ') : value}</td>
        </tr>`;
    }
    
    html += `<tr>
        <th><?= lang('ip_address') ?></th>
        <td>${submission.ip_address || '-'}</td>
    </tr>`;
    html += `<tr>
        <th><?= lang('date') ?></th>
        <td>${submission.created_at}</td>
    </tr>`;
    
    html += '</tbody></table>';
    
    document.getElementById('submissionContent').innerHTML = html;
    new bootstrap.Modal(document.getElementById('submissionModal')).show();
}

function deleteSubmission(id) {
    if (confirm('<?= lang('confirm_delete') ?>')) {
        fetch('<?= url('/dashboard/forms/submission/delete/') ?>' + id, {
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

function exportSubmissions() {
    // Export as CSV
    let csv = [];
    const headers = ['id', ...<?= json_encode(array_values($allFields)) ?>, 'date'];
    csv.push(headers.join(','));
    
    submissionsData.forEach(submission => {
        const data = JSON.parse(submission.data || '{}');
        const row = [
            submission.id,
            ...<?= json_encode(array_keys($allFields)) ?>.map(f => `"${(data[f] || '').replace(/"/g, '""')}"`),
            submission.created_at
        ];
        csv.push(row.join(','));
    });
    
    const blob = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'submissions_<?= $form->slug ?>_' + new Date().toISOString().split('T')[0] + '.csv';
    link.click();
}

$(document).ready(function() {
    $('#submissionsTable').DataTable({
        order: [[<?= count($allFields) + 1 ?>, 'desc']],
        language: {
            url: '<?= Language::current() === 'ar' ? 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json' : '' ?>'
        }
    });
});
</script>

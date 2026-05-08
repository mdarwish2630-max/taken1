<?php
/**
 * CMS Platform - Domain Management View
 * صفحة إدارة النطاقات
 */


$tenant = $tenant ?? Auth::tenant();
$plan = $plan ?? null;
$domainHistory = $domainHistory ?? [];
$mainDomain = $mainDomain ?? 'takweenweb.com';
?>

<div class="page-header">
    <h1>
        <i class="fas fa-globe"></i>
        <?= lang('domain_management') ?>
    </h1>
    <p class="text-muted"><?= lang('domain_management_desc') ?></p>
</div>

<div class="row">
    <!-- النطاق الفرعي -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-sitemap text-primary"></i>
                    <?= lang('subdomain') ?>
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted small">
                    <?= lang('subdomain_desc') ?>
                </p>

                <form id="subdomainForm" class="mt-3">
                    <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">

                    <div class="input-group">
                        <input type="text" class="form-control" name="subdomain"
                               id="subdomainInput"
                               value="<?= htmlspecialchars($tenant->subdomain ?? '') ?>"
                               placeholder="<?= lang('subdomain_placeholder') ?>"
                               pattern="[a-z0-9-]+"
                               style="direction: ltr; text-align: left;">
                        <span class="input-group-text">.<?= htmlspecialchars($mainDomain) ?></span>
                    </div>

                    <div id="subdomainStatus" class="mt-2"></div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            <?= lang('save_subdomain') ?>
                        </button>
                    </div>
                </form>

                <?php if ($tenant->subdomain): ?>
                <div class="mt-4 p-3 bg-light rounded">
                    <strong><?= lang('your_site_url') ?>:</strong><br>
                    <a href="http://<?= htmlspecialchars($tenant->subdomain) ?>.<?= htmlspecialchars($mainDomain) ?>"
                       target="_blank" class="text-primary">
                        <?= htmlspecialchars($tenant->subdomain) ?>.<?= htmlspecialchars($mainDomain) ?>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- النطاق المخصص -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-globe text-success"></i>
                    <?= lang('custom_domain') ?>
                    <?php if (!$plan || !isset($plan->allow_custom_domain) || !$plan->allow_custom_domain): ?>
                    <span class="badge bg-warning text-dark"><?= lang('upgrade_required') ?></span>
                    <?php endif; ?>
                </h5>
            </div>
            <div class="card-body">
                <?php if ($plan && isset($plan->allow_custom_domain) && $plan->allow_custom_domain): ?>

                <?php if ($tenant->custom_domain && $tenant->custom_domain_verified): ?>
                <!-- نطاق مخصص مُوثق -->
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?= lang('domain_verified') ?>
                </div>

                <div class="p-3 bg-light rounded mb-3">
                    <strong><?= lang('active_domain') ?>:</strong><br>
                    <a href="http://<?= htmlspecialchars($tenant->custom_domain) ?>" target="_blank" class="text-success">
                        <?= htmlspecialchars($tenant->custom_domain) ?>
                    </a>
                </div>

                <form id="removeDomainForm">
                    <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-times"></i>
                        <?= lang('remove_domain') ?>
                    </button>
                </form>

                <?php elseif ($tenant->custom_domain && !$tenant->custom_domain_verified): ?>
                <!-- نطاق يحتاج تحقق -->
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?= lang('domain_needs_verification') ?>
                </div>

                <div class="p-3 bg-light rounded mb-3">
                    <strong><?= lang('domain') ?>:</strong> <?= htmlspecialchars($tenant->custom_domain) ?><br>
                    <strong><?= lang('status') ?>:</strong>
                    <span class="badge bg-warning text-dark"><?= lang('pending_verification') ?></span>
                </div>

                <!-- طرق التحقق -->
                <div class="verification-methods mt-4">
                    <h6><?= lang('verification_methods') ?></h6>

                    <!-- طريقة DNS TXT -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <strong><?= lang('dns_txt_record') ?></strong>
                        </div>
                        <div class="card-body">
                            <p class="small text-muted"><?= lang('dns_txt_instructions') ?></p>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Type:</strong></td>
                                    <td><code>TXT</code></td>
                                </tr>
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td><code>@</code> أو <code>_verification</code></td>
                                </tr>
                                <tr>
                                    <td><strong>Value:</strong></td>
                                    <td><code>takween-verification=<?= htmlspecialchars($tenant->custom_domain_verification_token) ?></code></td>
                                </tr>
                                <tr>
                                    <td><strong>TTL:</strong></td>
                                    <td><code>3600</code></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- طريقة CNAME -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <strong><?= lang('dns_cname_record') ?></strong>
                        </div>
                        <div class="card-body">
                            <p class="small text-muted"><?= lang('dns_cname_instructions') ?></p>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Type:</strong></td>
                                    <td><code>CNAME</code></td>
                                </tr>
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td><code>www</code></td>
                                </tr>
                                <tr>
                                    <td><strong>Value:</strong></td>
                                    <td><code><?= htmlspecialchars($mainDomain) ?></code></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <form id="verifyDomainForm">
                        <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
                        <input type="hidden" name="method" value="dns_txt">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i>
                            <?= lang('verify_domain') ?>
                        </button>
                    </form>
                </div>

                <?php else: ?>
                <!-- إضافة نطاق جديد -->
                <p class="text-muted small">
                    <?= lang('custom_domain_desc') ?>
                </p>

                <form id="customDomainForm" class="mt-3">
                    <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">

                    <div class="mb-3">
                        <label class="form-label"><?= lang('domain_name') ?></label>
                        <input type="text" class="form-control" name="domain"
                               placeholder="example.com"
                               style="direction: ltr; text-align: left;">
                    </div>

                    <div id="domainStatus" class="mt-2"></div>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus"></i>
                        <?= lang('add_domain') ?>
                    </button>
                </form>
                <?php endif; ?>

                <?php else: ?>
                <!-- الترقية مطلوبة -->
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <?= lang('custom_domain_upgrade_message') ?>
                </div>
                <a href="/dashboard/subscription/upgrade" class="btn btn-primary">
                    <i class="fas fa-arrow-up"></i>
                    <?= lang('upgrade_now') ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- سجل النطاقات -->
<?php if (!empty($domainHistory)): ?>
<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-history"></i>
            <?= lang('domain_history') ?>
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th><?= lang('type') ?></th>
                        <th><?= lang('old_value') ?></th>
                        <th><?= lang('new_value') ?></th>
                        <th><?= lang('status') ?></th>
                        <th><?= lang('date') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($domainHistory as $record): ?>
                    <tr>
                        <td>
                            <?php $recType = $record->domain_type ?? ($record->type ?? 'custom'); ?>
                            <?php if ($recType === 'subdomain'): ?>
                            <span class="badge bg-info"><?= lang('subdomain') ?></span>
                            <?php else: ?>
                            <span class="badge bg-success"><?= lang('custom_domain') ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($record->old_value ?? '-') ?></td>
                        <td><?= htmlspecialchars($record->new_value ?? '-') ?></td>
                        <td>
                            <?php
                            $statusLabels = [
                                'added' => '<span class="badge bg-secondary">' . lang('added') . '</span>',
                                'verified' => '<span class="badge bg-success">' . lang('verified') . '</span>',
                                'removed' => '<span class="badge bg-danger">' . lang('removed') . '</span>',
                                'failed' => '<span class="badge bg-warning text-dark">' . lang('failed') . '</span>'
                            ];
                            $recStatus = $record->status ?? 'added';
                            echo $statusLabels[$recStatus] ?? htmlspecialchars($recStatus);
                            ?>
                        </td>
                        <td><?= date('Y-m-d H:i', strtotime($record->created_at)) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
// التحقق من توفر النطاق الفرعي
let subdomainCheckTimeout;
document.getElementById('subdomainInput')?.addEventListener('input', function() {
    clearTimeout(subdomainCheckTimeout);
    const subdomain = this.value.toLowerCase();
    const statusEl = document.getElementById('subdomainStatus');

    if (subdomain.length < 3) {
        statusEl.innerHTML = '';
        return;
    }

    statusEl.innerHTML = '<span class="text-muted"><i class="fas fa-spinner fa-spin"></i> جاري التحقق...</span>';

    subdomainCheckTimeout = setTimeout(() => {
        fetch('/dashboard/domains/check-subdomain?subdomain=' + encodeURIComponent(subdomain))
            .then(res => res.json())
            .then(data => {
                if (data.available) {
                    statusEl.innerHTML = '<span class="text-success"><i class="fas fa-check-circle"></i> ' + data.message + '</span>';
                } else {
                    statusEl.innerHTML = '<span class="text-danger"><i class="fas fa-times-circle"></i> ' + data.message + '</span>';
                }
            });
    }, 500);
});

// حفظ النطاق الفرعي
document.getElementById('subdomainForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const btn = form.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الحفظ...';

    fetch('/dashboard/domains/subdomain', {
        method: 'POST',
        body: new FormData(form)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast('success', data.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast('error', data.message);
        }
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-save"></i> <?= lang('save_subdomain') ?>';
    });
});

// إضافة نطاق مخصص
document.getElementById('customDomainForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const btn = form.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الإضافة...';

    fetch('/dashboard/domains/custom', {
        method: 'POST',
        body: new FormData(form)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast('success', data.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast('error', data.message);
        }
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-plus"></i> <?= lang('add_domain') ?>';
    });
});

// التحقق من النطاق
document.getElementById('verifyDomainForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const btn = form.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري التحقق...';

    fetch('/dashboard/domains/verify', {
        method: 'POST',
        body: new FormData(form)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast('success', data.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast('error', data.message);
        }
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-check"></i> <?= lang('verify_domain') ?>';
    });
});

// إزالة النطاق
document.getElementById('removeDomainForm')?.addEventListener('submit', function(e) {
    e.preventDefault();

    if (!confirm('<?= lang('confirm_remove_domain') ?>')) return;

    const form = this;
    const btn = form.querySelector('button[type="submit"]');
    btn.disabled = true;

    fetch('/dashboard/domains/remove', {
        method: 'POST',
        body: new FormData(form)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast('success', data.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast('error', data.message);
        }
    })
    .finally(() => {
        btn.disabled = false;
    });
});
</script>

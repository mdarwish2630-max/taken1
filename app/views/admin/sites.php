<?php
/**
 * Admin Sites List View
 * قائمة المواقع - لوحة المدير
 */

?>

<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-globe"></i>
        <?= lang('sites_management') ?? 'إدارة المواقع' ?>
    </h1>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?= url('/admin/sites') ?>" class="row g-3">
            <div class="col-md-4">
                <label class="form-label"><?= lang('status') ?? 'الحالة' ?></label>
                <select name="status" class="form-control">
                    <option value=""><?= lang('all') ?? 'الكل' ?></option>
                    <option value="trial" <?= ($status_filter ?? '') === 'trial' ? 'selected' : '' ?>><?= lang('trial') ?? 'فترة تجريبية' ?></option>
                    <option value="active" <?= ($status_filter ?? '') === 'active' ? 'selected' : '' ?>><?= lang('active') ?? 'نشط' ?></option>
                    <option value="expired" <?= ($status_filter ?? '') === 'expired' ? 'selected' : '' ?>><?= lang('expired') ?? 'منتهي' ?></option>
                    <option value="suspended" <?= ($status_filter ?? '') === 'suspended' ? 'selected' : '' ?>><?= lang('suspended') ?? 'معلق' ?></option>
                </select>
            </div>
            <div class="col-md-2" style="display: flex; align-items: flex-end; gap: 0.5rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i>
                    <?= lang('filter') ?? 'تصفية' ?>
                </button>
                <a href="<?= url('/admin/sites') ?>" class="btn btn-outline">
                    <?= lang('reset') ?? 'إعادة تعيين' ?>
                </a>
            </div>
        </form>
    </div>
</div>

<?php if (Session::has('success')): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    <?= Session::getSuccess() ?>
</div>
<?php endif; ?>

<!-- Sites Table -->
<div class="card">
    <div class="card-body">
        <?php if (!empty($sites)): ?>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?= lang('site_name') ?? 'اسم الموقع' ?></th>
                        <th><?= lang('slug') ?? 'المعرف' ?></th>
                        <th><?= lang('owner') ?? 'المالك' ?></th>
                        <th><?= lang('theme') ?? 'القالب' ?></th>
                        <th><?= lang('subscription_status') ?? 'حالة الاشتراك' ?></th>
                        <th><?= lang('expires_at') ?? 'تاريخ الانتهاء' ?></th>
                        <th><?= lang('created_at') ?? 'تاريخ الإنشاء' ?></th>
                        <th><?= lang('actions') ?? 'الإجراءات' ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sites as $site): ?>
                    <tr>
                        <td><?= $site->id ?></td>
                        <td><strong><?= $this->e($site->site_name) ?></strong></td>
                        <td>
                            <a href="<?= url('/' . $site->slug) ?>" target="_blank" title="<?= lang('view_site') ?? 'عرض الموقع' ?>">
                                <i class="fas fa-external-link-alt"></i>
                                <?= $this->e($site->slug) ?>
                            </a>
                        </td>
                        <td>
                            <?php if (!empty($site->owner_name)): ?>
                            <?= $this->e($site->owner_name) ?><br>
                            <small style="color: #94a3b8;"><?= $this->e($site->owner_email ?? '') ?></small>
                            <?php else: ?>
                            <span style="color: #94a3b8;">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($site->theme_name)): ?>
                            <span class="badge badge-info"><?= $this->e($site->theme_name) ?></span>
                            <?php else: ?>
                            <span class="badge badge-secondary"><?= lang('default') ?? 'افتراضي' ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php 
                            $statusClasses = [
                                'trial' => 'badge-info',
                                'active' => 'badge-success', 
                                'expired' => 'badge-danger',
                                'suspended' => 'badge-warning'
                            ];
                            $statusClass = $statusClasses[$site->subscription_status ?? ''] ?? 'badge-secondary';
                            ?>
                            <span class="badge <?= $statusClass ?>">
                                <?= lang($site->subscription_status ?? '') ?? $this->e($site->subscription_status ?? '') ?>
                            </span>
                        </td>
                        <td>
                            <?php if (!empty($site->subscription_end)): ?>
                                <?= date('Y-m-d', strtotime($site->subscription_end)) ?>
                            <?php elseif (!empty($site->trial_ends_at)): ?>
                                <small style="color: #94a3b8;"><?= lang('trial') ?? 'تجربة' ?>: <?= date('Y-m-d', strtotime($site->trial_ends_at)) ?></small>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><?= date('Y-m-d', strtotime($site->created_at)) ?></td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="<?= url('/admin/sites/view/' . $site->id) ?>" 
                                   class="btn btn-sm btn-outline" title="<?= lang('view') ?? 'عرض' ?>">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?= url('/admin/sites/renew/' . $site->id) ?>" 
                                   class="btn btn-sm btn-outline" title="<?= lang('renew') ?? 'تجديد' ?>">
                                    <i class="fas fa-sync"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if (!empty($pagination) && ($pagination['last_page'] ?? 1) > 1): ?>
        <div style="display: flex; justify-content: center; margin-top: 1.5rem;">
            <nav>
                <ul class="pagination">
                    <?php 
                    $currentPage = $pagination['current_page'] ?? 1;
                    $lastPage = $pagination['last_page'] ?? 1;
                    $statusParam = ($status_filter ?? '') ? '&status=' . urlencode($status_filter) : '';
                    ?>
                    <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $currentPage - 1 ?><?= $statusParam ?>">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php 
                    $start = max(1, $currentPage - 2);
                    $end = min($lastPage, $currentPage + 2);
                    if ($start > 1): ?>
                    <li class="page-item"><a class="page-link" href="?page=1<?= $statusParam ?>">1</a></li>
                    <?php if ($start > 2): ?><li class="page-item disabled"><span class="page-link">...</span></li><?php endif; ?>
                    <?php endif; ?>

                    <?php for ($i = $start; $i <= $end; $i++): ?>
                    <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?><?= $statusParam ?>"><?= $i ?></a>
                    </li>
                    <?php endfor; ?>

                    <?php if ($end < $lastPage - 1): ?><li class="page-item disabled"><span class="page-link">...</span></li><?php endif; ?>
                    <?php if ($end < $lastPage): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $lastPage ?><?= $statusParam ?>"><?= $lastPage ?></a></li>
                    <?php endif; ?>

                    <?php if ($currentPage < $lastPage): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $currentPage + 1 ?><?= $statusParam ?>">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <?php endif; ?>

        <?php else: ?>
        <div style="text-align: center; padding: 3rem;">
            <i class="fas fa-globe" style="font-size: 3rem; color: #94a3b8; margin-bottom: 1rem; display: block;"></i>
            <h5><?= lang('no_sites_found') ?? 'لم يتم العثور على مواقع' ?></h5>
            <p style="color: #94a3b8;"><?= lang('no_sites_found_desc') ?? 'لا توجد مواقع مسجلة حالياً' ?></p>
        </div>
        <?php endif; ?>
    </div>
</div>

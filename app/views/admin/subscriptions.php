<?php
/**
 * Admin Subscriptions View
 * الاشتراكات - لوحة المدير
 */

?>

<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-credit-card"></i>
        <?= lang('subscriptions') ?? 'الاشتراكات' ?>
    </h1>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?= url('/admin/subscriptions') ?>" class="row g-3">
            <div class="col-md-4">
                <label class="form-label"><?= lang('status') ?? 'الحالة' ?></label>
                <select name="status" class="form-control">
                    <option value=""><?= lang('all_status') ?? 'كل الحالات' ?></option>
                    <option value="active" <?= ($status_filter ?? '') === 'active' ? 'selected' : '' ?>><?= lang('active') ?? 'نشط' ?></option>
                    <option value="pending" <?= ($status_filter ?? '') === 'pending' ? 'selected' : '' ?>><?= lang('pending') ?? 'معلق' ?></option>
                    <option value="expired" <?= ($status_filter ?? '') === 'expired' ? 'selected' : '' ?>><?= lang('expired') ?? 'منتهي' ?></option>
                    <option value="cancelled" <?= ($status_filter ?? '') === 'cancelled' ? 'selected' : '' ?>><?= lang('cancelled') ?? 'ملغي' ?></option>
                </select>
            </div>
            <div class="col-md-2" style="display: flex; align-items: flex-end; gap: 0.5rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i>
                    <?= lang('filter') ?? 'تصفية' ?>
                </button>
                <a href="<?= url('/admin/subscriptions') ?>" class="btn btn-outline">
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

<!-- Subscriptions Table -->
<div class="card">
    <div class="card-body">
        <?php if (empty($subscriptions)): ?>
        <div style="text-align: center; padding: 3rem;">
            <i class="fas fa-credit-card" style="font-size: 3rem; color: #94a3b8; margin-bottom: 1rem; display: block;"></i>
            <p style="color: #94a3b8;"><?= lang('no_subscriptions_found') ?? 'لم يتم العثور على اشتراكات' ?></p>
        </div>
        <?php else: ?>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th><?= lang('site_name') ?? 'اسم الموقع' ?></th>
                        <th><?= lang('owner') ?? 'المالك' ?></th>
                        <th><?= lang('theme') ?? 'القالب' ?></th>
                        <th><?= lang('plan') ?? 'الخطة' ?></th>
                        <th><?= lang('status') ?? 'الحالة' ?></th>
                        <th><?= lang('created_at') ?? 'تاريخ الإنشاء' ?></th>
                        <th><?= lang('expires_at') ?? 'تاريخ الانتهاء' ?></th>
                        <th><?= lang('actions') ?? 'الإجراءات' ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subscriptions as $sub): ?>
                    <tr>
                        <td>
                            <strong><?= $this->e($sub->site_name ?? '') ?></strong>
                        </td>
                        <td>
                            <?= $this->e($sub->owner_name ?? '') ?>
                            <br>
                            <small style="color: #94a3b8;"><?= $this->e($sub->owner_email ?? '') ?></small>
                        </td>
                        <td>
                            <?php if (!empty($sub->theme_name)): ?>
                            <span class="badge badge-info"><?= $this->e($sub->theme_name) ?></span>
                            <?php else: ?>
                            <span class="badge badge-secondary"><?= lang('default') ?? 'افتراضي' ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?= $this->e($sub->plan_name ?? '-') ?></td>
                        <td>
                            <?php
                            $statusClasses = [
                                'active' => 'badge-success',
                                'pending' => 'badge-warning',
                                'expired' => 'badge-danger',
                                'cancelled' => 'badge-secondary',
                                'trial' => 'badge-info',
                                'suspended' => 'badge-warning',
                            ];
                            $statusClass = $statusClasses[$sub->subscription_status ?? $sub->status ?? ''] ?? 'badge-secondary';
                            ?>
                            <span class="badge <?= $statusClass ?>">
                                <?= lang($sub->subscription_status ?? $sub->status ?? '') ?? $this->e($sub->subscription_status ?? $sub->status ?? '') ?>
                            </span>
                        </td>
                        <td><?= isset($sub->created_at) ? date('Y-m-d', strtotime($sub->created_at)) : '-' ?></td>
                        <td>
                            <?php if (!empty($sub->subscription_end)): ?>
                                <?= date('Y-m-d', strtotime($sub->subscription_end)) ?>
                            <?php elseif (!empty($sub->trial_ends_at)): ?>
                                <small style="color: #94a3b8;"><?= date('Y-m-d', strtotime($sub->trial_ends_at)) ?></small>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= url('/admin/sites/view/' . $sub->id) ?>" class="btn btn-sm btn-outline" title="<?= lang('view') ?? 'عرض' ?>">
                                <i class="fas fa-eye"></i>
                            </a>
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
                    $currentPage = $pagination['page'] ?? $pagination['current_page'] ?? 1;
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

        <?php endif; ?>
    </div>
</div>

<?php
/**
 * Admin Users List View
 * قائمة المستخدمين - لوحة المدير
 */

?>

<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-users"></i>
        <?= lang('users_management') ?? 'إدارة المستخدمين' ?>
    </h1>
</div>

<!-- Search -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?= url('/admin/users') ?>" class="row g-3">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" 
                       value="<?= $this->e($search ?? '') ?>" 
                       placeholder="<?= lang('search_users') ?? 'البحث بالاسم أو البريد الإلكتروني' ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                    <?= lang('search') ?? 'بحث' ?>
                </button>
            </div>
            <?php if ($search ?? ''): ?>
            <div class="col-md-2">
                <a href="<?= url('/admin/users') ?>" class="btn btn-outline">
                    <?= lang('reset') ?? 'إعادة تعيين' ?>
                </a>
            </div>
            <?php endif; ?>
        </form>
    </div>
</div>

<?php if (Session::has('success')): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    <?= Session::getSuccess() ?>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th><?= lang('name') ?? 'الاسم' ?></th>
                        <th><?= lang('email') ?? 'البريد الإلكتروني' ?></th>
                        <th><?= lang('role') ?? 'الدور' ?></th>
                        <th><?= lang('site') ?? 'الموقع' ?></th>
                        <th><?= lang('status') ?? 'الحالة' ?></th>
                        <th><?= lang('registered') ?? 'التسجيل' ?></th>
                        <th><?= lang('actions') ?? 'الإجراءات' ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 36px; height: 36px; border-radius: 50%; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                    <?= mb_substr($user->full_name ?? $user->name ?? '?', 0, 1) ?>
                                </div>
                                <strong><?= $this->e($user->full_name ?? $user->name ?? '') ?></strong>
                            </div>
                        </td>
                        <td><?= $this->e($user->email ?? '') ?></td>
                        <td>
                            <span class="badge <?= ($user->role ?? '') === 'admin' ? 'badge-danger' : 'badge-info' ?>">
                                <?= lang($user->role ?? '') ?? $this->e($user->role ?? '') ?>
                            </span>
                        </td>
                        <td>
                            <?php if (!empty($user->tenant_id)): ?>
                            <a href="<?= url('/' . $user->slug) ?>" target="_blank">
                                <?= $this->e($user->site_name ?? '') ?>
                            </a>
                            <?php else: ?>
                            <span style="color: #94a3b8;">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge <?= ($user->status ?? '') === 'active' ? 'badge-success' : 'badge-secondary' ?>">
                                <?= lang($user->status ?? '') ?? $this->e($user->status ?? '') ?>
                            </span>
                        </td>
                        <td><?= date('Y-m-d', strtotime($user->created_at)) ?></td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="<?= url('/admin/users/edit/' . $user->id) ?>" 
                                   class="btn btn-sm btn-outline" title="<?= lang('edit') ?? 'تعديل' ?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if (($user->role ?? '') !== 'admin'): ?>
                                <form method="POST" 
                                      action="<?= url('/admin/users/delete/' . $user->id) ?>"
                                      style="display: inline;"
                                      onsubmit="return confirm('<?= lang('confirm_delete') ?? 'هل أنت متأكد من الحذف؟' ?>');">
                                    <?= $this->csrf() ?>
                                    <button type="submit" class="btn btn-sm btn-danger" title="<?= lang('delete') ?? 'حذف' ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 2rem; color: #64748b;">
                            <i class="fas fa-users" style="font-size: 2rem; margin-bottom: 0.5rem; display: block;"></i>
                            <?= lang('no_users') ?? 'لا يوجد مستخدمين' ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if (!empty($pagination) && ($pagination['last_page'] ?? 1) > 1): ?>
        <div style="display: flex; justify-content: center; margin-top: 1.5rem;">
            <nav>
                <ul class="pagination">
                    <?php if (($pagination['current_page'] ?? 1) > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= ($pagination['current_page'] ?? 1) - 1 ?><?= ($search ?? '') ? '&search=' . urlencode($search) : '' ?>">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php 
                    $currentPage = $pagination['current_page'] ?? 1;
                    $lastPage = $pagination['last_page'] ?? 1;
                    $start = max(1, $currentPage - 2);
                    $end = min($lastPage, $currentPage + 2);
                    if ($start > 1): ?>
                    <li class="page-item"><a class="page-link" href="?page=1">1</a></li>
                    <?php if ($start > 2): ?><li class="page-item disabled"><span class="page-link">...</span></li><?php endif; ?>
                    <?php endif; ?>

                    <?php for ($i = $start; $i <= $end; $i++): ?>
                    <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?><?= ($search ?? '') ? '&search=' . urlencode($search) : '' ?>"><?= $i ?></a>
                    </li>
                    <?php endfor; ?>

                    <?php if ($end < $lastPage - 1): ?><li class="page-item disabled"><span class="page-link">...</span></li><?php endif; ?>
                    <?php if ($end < $lastPage): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $lastPage ?>"><?= $lastPage ?></a></li>
                    <?php endif; ?>

                    <?php if ($currentPage < $lastPage): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $currentPage + 1 ?><?= ($search ?? '') ? '&search=' . urlencode($search) : '' ?>">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <?php endif; ?>
    </div>
</div>

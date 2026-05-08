<?php
/**
 * Admin Subscription Requests Page
 * صفحة إدارة طلبات الاشتراك والترقية - لوحة تحكم المدير
 */

$requests = $requests ?? [];
$statusFilter = $statusFilter ?? '';
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <h4 class="mb-0" style="font-weight: 700;">
        <i class="fas fa-paper-plane me-2" style="color: var(--primary);"></i>
        <?= lang('subscription_requests') ?? 'طلبات الاشتراك والترقية' ?>
    </h4>
    <div class="d-flex gap-2">
        <a href="<?= url('/admin/subscriptions') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-list me-1"></i><?= lang('all_subscriptions') ?? 'كل الاشتراكات' ?>
        </a>
    </div>
</div>

<!-- فلاتر الحالة -->
<div class="card mb-4">
    <div class="card-body py-3">
        <div class="d-flex gap-2 flex-wrap">
            <a href="<?= url('/admin/subscription-requests') ?>" class="btn btn-sm <?= empty($statusFilter) ? 'btn-primary' : 'btn-outline-primary' ?>">
                <?= lang('all') ?? 'الكل' ?>
                <?php if (empty($statusFilter)): ?><span class="badge bg-light text-primary ms-1"><?= count($requests) ?></span><?php endif; ?>
            </a>
            <a href="<?= url('/admin/subscription-requests?status=pending') ?>" class="btn btn-sm <?= $statusFilter === 'pending' ? 'btn-warning' : 'btn-outline-warning' ?>">
                <i class="fas fa-clock me-1"></i><?= lang('pending') ?? 'معلق' ?>
            </a>
            <a href="<?= url('/admin/subscription-requests?status=approved') ?>" class="btn btn-sm <?= $statusFilter === 'approved' ? 'btn-success' : 'btn-outline-success' ?>">
                <i class="fas fa-check me-1"></i><?= lang('approved') ?? 'مقبول' ?>
            </a>
            <a href="<?= url('/admin/subscription-requests?status=rejected') ?>" class="btn btn-sm <?= $statusFilter === 'rejected' ? 'btn-danger' : 'btn-outline-danger' ?>">
                <i class="fas fa-times me-1"></i><?= lang('rejected') ?? 'مرفوض' ?>
            </a>
        </div>
    </div>
</div>

<?php if (empty($requests)): ?>
<div class="card">
    <div class="card-body text-center py-5">
        <i class="fas fa-inbox fa-3x text-muted mb-3" style="display: block;"></i>
        <h5 style="color: #64748b;"><?= lang('no_requests') ?? 'لا توجد طلبات' ?></h5>
    </div>
</div>
<?php else: ?>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead style="background: var(--light);">
                <tr>
                    <th>#</th>
                    <th><?= lang('user') ?? 'المستخدم' ?></th>
                    <th><?= lang('site_name') ?? 'الموقع' ?></th>
                    <th><?= lang('plan') ?? 'الخطة' ?></th>
                    <th><?= lang('type') ?? 'النوع' ?></th>
                    <th><?= lang('status') ?? 'الحالة' ?></th>
                    <th><?= lang('date') ?? 'التاريخ' ?></th>
                    <th><?= lang('notes') ?? 'ملاحظات' ?></th>
                    <th><?= lang('actions') ?? 'إجراءات' ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $req): ?>
                <tr>
                    <td><?= $req->id ?></td>
                    <td>
                        <strong><?= htmlspecialchars($req->user_name ?? '') ?></strong>
                        <br><small style="color: #64748b;"><?= htmlspecialchars($req->user_email ?? '') ?></small>
                    </td>
                    <td><?= htmlspecialchars($req->site_name ?? '') ?></td>
                    <td>
                        <strong><?= htmlspecialchars($req->plan_name ?? '') ?></strong>
                        <?php if (isset($req->plan_price)): ?>
                        <br><small style="color: #64748b;"><?= htmlspecialchars($req->plan_price) ?> <?= lang('pricing_currency') ?? '$' ?></small>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($req->request_type === 'upgrade'): ?>
                            <span class="badge" style="background: #dbeafe; color: #1d4ed8;">
                                <i class="fas fa-arrow-up me-1"></i><?= lang('upgrade') ?? 'ترقية' ?>
                            </span>
                        <?php elseif ($req->request_type === 'renew'): ?>
                            <span class="badge" style="background: #d1fae5; color: #065f46;">
                                <i class="fas fa-redo me-1"></i><?= lang('renew') ?? 'تجديد' ?>
                            </span>
                        <?php else: ?>
                            <span class="badge" style="background: #f3e8ff; color: #7c3aed;">
                                <i class="fas fa-plus me-1"></i><?= lang('new') ?? 'جديد' ?>
                            </span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($req->status === 'pending'): ?>
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-clock me-1"></i><?= lang('pending') ?? 'معلق' ?>
                            </span>
                        <?php elseif ($req->status === 'approved'): ?>
                            <span class="badge bg-success">
                                <i class="fas fa-check me-1"></i><?= lang('approved') ?? 'مقبول' ?>
                            </span>
                        <?php elseif ($req->status === 'rejected'): ?>
                            <span class="badge bg-danger">
                                <i class="fas fa-times me-1"></i><?= lang('rejected') ?? 'مرفوض' ?>
                            </span>
                        <?php else: ?>
                            <span class="badge bg-secondary"><?= lang('cancelled') ?? 'ملغى' ?></span>
                        <?php endif; ?>
                    </td>
                    <td style="font-size: 0.85rem; color: #64748b; white-space: nowrap;">
                        <?= date('Y-m-d', strtotime($req->created_at)) ?>
                        <br><small><?= date('H:i', strtotime($req->created_at)) ?></small>
                    </td>
                    <td style="max-width: 150px;">
                        <small><?= htmlspecialchars($req->notes ?? '-') ?></small>
                        <?php if ($req->admin_notes): ?>
                            <br><span class="badge bg-light text-dark" style="font-size: 0.7rem;"><?= htmlspecialchars($req->admin_notes) ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($req->status === 'pending'): ?>
                        <div class="d-flex gap-1">
                            <form method="POST" action="<?= url('/admin/subscription-requests/approve/' . $req->id) ?>" onsubmit="return confirm('<?= lang('confirm_approve') ?? 'هل تريد قبول هذا الطلب؟' ?>')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-success" title="<?= lang('approve') ?? 'قبول' ?>">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <form method="POST" action="<?= url('/admin/subscription-requests/reject/' . $req->id) ?>" onsubmit="return showRejectForm(<?= $req->id ?>)">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-danger" title="<?= lang('reject') ?? 'رفض' ?>">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                        <?php elseif ($req->reviewed_at): ?>
                        <small style="color: #94a3b8;"><?= date('Y-m-d H:i', strtotime($req->reviewed_at)) ?></small>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

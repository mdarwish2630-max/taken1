<?php
/**
 * Admin Subscription Requests Page
 * صفحة إدارة طلبات الاشتراك والترقية - لوحة تحكم المدير
 * — إصلاح شامل: عرض البيانات الصحيحة مع fallback لكل قيمة —
 */

$requests = $requests ?? [];
$statusFilter = $statusFilter ?? '';
$debugMsg = $debugMsg ?? '';
$totalInTable = $totalInTable ?? 0;
?>

<!-- رسالة تنبيه للتصحيح -->
<?php if (!empty($debugMsg)): ?>
<div class="alert alert-warning mb-4" style="border-radius: 8px;">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>تنبيه:</strong> <?= htmlspecialchars($debugMsg) ?>
</div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <h4 class="mb-0" style="font-weight: 700;">
        <i class="fas fa-paper-plane me-2" style="color: var(--primary);"></i>
        <?= lang('subscription_requests') ?? 'طلبات الاشتراك والترقية' ?>
    </h4>
    <div class="d-flex gap-2">
        <a href="<?= url('/admin/purchases') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-shopping-cart me-1"></i><?= lang('purchases') ?? 'مشتريات الخدمات' ?>
        </a>
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
        <h5 style="color: #64748b;"><?= lang('no_requests') ?? 'لا توجد طلبات اشتراك' ?></h5>
        <p class="text-muted small mt-2">عندما يقوم عميل باختيار خطة وإرسال طلب اشتراك، ستظهر هنا</p>
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
                <?php foreach ($requests as $i => $req):
                    // استخراج البيانات مع fallback لكل قيمة
                    $reqId = $req->id ?? 0;
                    $reqType = $req->request_type ?? 'new';
                    $reqStatus = $req->status ?? '';
                    $reqCreatedAt = $req->created_at ?? '';
                    $reqNotes = $req->notes ?? '';
                    $reqAdminNotes = $req->admin_notes ?? '';
                    $reqReviewedAt = $req->reviewed_at ?? '';
                    $tenantId = $req->tenant_id ?? '';
                    $planId = $req->plan_id ?? '';
                    $userName = $req->user_name ?? '';
                    $userEmail = $req->user_email ?? '';
                    $siteName = $req->site_name ?? '';
                    $planName = $req->plan_name ?? '';
                    $planPrice = $req->plan_price ?? null;
                ?>
                <tr>
                    <td><strong><?= htmlspecialchars($reqId) ?></strong></td>
                    <td>
                        <?php if (!empty($userName)): ?>
                            <strong><?= htmlspecialchars($userName) ?></strong>
                            <?php if (!empty($userEmail)): ?>
                                <br><small style="color: #64748b;"><?= htmlspecialchars($userEmail) ?></small>
                            <?php endif; ?>
                        <?php elseif (!empty($tenantId)): ?>
                            <span class="text-muted small">مستأجر #<?= htmlspecialchars($tenantId) ?></span>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($siteName)): ?>
                            <?= htmlspecialchars($siteName) ?>
                        <?php elseif (!empty($tenantId)): ?>
                            <span class="text-muted small">موقع #<?= htmlspecialchars($tenantId) ?></span>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($planName)): ?>
                            <strong><?= htmlspecialchars($planName) ?></strong>
                            <?php if (!empty($planPrice) && floatval($planPrice) > 0): ?>
                            <br><small style="color: #64748b;"><?= htmlspecialchars($planPrice) ?> <?= lang('pricing_currency') ?? 'ر.س' ?>/شهر</small>
                            <?php endif; ?>
                        <?php elseif (!empty($planId)): ?>
                            <span class="text-muted small">خطة #<?= htmlspecialchars($planId) ?></span>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($reqType === 'upgrade'): ?>
                            <span class="badge" style="background: #dbeafe; color: #1d4ed8;">
                                <i class="fas fa-arrow-up me-1"></i><?= lang('upgrade') ?? 'ترقية' ?>
                            </span>
                        <?php elseif ($reqType === 'renew'): ?>
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
                        <?php if ($reqStatus === 'pending'): ?>
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-clock me-1"></i><?= lang('pending') ?? 'معلق' ?>
                            </span>
                        <?php elseif ($reqStatus === 'approved'): ?>
                            <span class="badge bg-success">
                                <i class="fas fa-check me-1"></i><?= lang('approved') ?? 'مقبول' ?>
                            </span>
                        <?php elseif ($reqStatus === 'rejected'): ?>
                            <span class="badge bg-danger">
                                <i class="fas fa-times me-1"></i><?= lang('rejected') ?? 'مرفوض' ?>
                            </span>
                        <?php elseif ($reqStatus === 'cancelled'): ?>
                            <span class="badge bg-secondary">
                                <i class="fas fa-ban me-1"></i>ملغى
                            </span>
                        <?php elseif (!empty($reqStatus)): ?>
                            <span class="badge bg-secondary"><?= htmlspecialchars($reqStatus) ?></span>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td style="font-size: 0.85rem; color: #64748b; white-space: nowrap;">
                        <?php if (!empty($reqCreatedAt)): ?>
                            <?= date('Y-m-d', strtotime($reqCreatedAt)) ?>
                            <br><small><?= date('H:i', strtotime($reqCreatedAt)) ?></small>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td style="max-width: 150px;">
                        <small><?= htmlspecialchars(!empty($reqNotes) ? $reqNotes : '-') ?></small>
                        <?php if (!empty($reqAdminNotes)): ?>
                            <br><span class="badge bg-light text-dark" style="font-size: 0.7rem;"><?= htmlspecialchars($reqAdminNotes) ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($reqStatus === 'pending' && !empty($reqId)): ?>
                        <div class="d-flex gap-1">
                            <form method="POST" action="<?= url('/admin/subscription-requests/approve/' . $reqId) ?>" onsubmit="return confirm('هل تريد قبول هذا الطلب؟')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-success" title="قبول">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <form method="POST" action="<?= url('/admin/subscription-requests/reject/' . $reqId) ?>" onsubmit="return confirm('هل تريد رفض هذا الطلب؟')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-danger" title="رفض">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                        <?php elseif (!empty($reqReviewedAt) && !empty($reqId)): ?>
                        <small style="color: #94a3b8;"><?= date('Y-m-d H:i', strtotime($reqReviewedAt)) ?></small>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

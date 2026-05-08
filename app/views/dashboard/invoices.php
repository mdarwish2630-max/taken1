<?php
/**
 * Invoices / Subscription History Page
 * صفحة الفواتير وسجل الاشتراكات والطلبات
 */

$tenant = $tenant ?? Auth::tenant();
$subscriptions = $subscriptions ?? [];
$requests = $requests ?? [];
?>

<div class="page-header" style="margin-bottom: 1.5rem;">
    <h1 style="font-size: 1.5rem; font-weight: 700; display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.25rem;">
        <i class="fas fa-file-invoice" style="color: var(--primary);"></i>
        <?= lang('invoices') ?? 'الفواتير والطلبات' ?>
    </h1>
    <p class="text-muted" style="margin: 0;"><?= lang('invoices_desc') ?? 'سجل اشتراكاتك وطلباتك السابقة' ?></p>
</div>

<!-- طلبات الاشتراك -->
<?php if (!empty($requests)): ?>
<div class="card mb-4" style="border-radius: 12px;">
    <div class="card-header" style="background: #fff; border-bottom: 2px solid var(--light); padding: 1.25rem 1.5rem;">
        <h5 style="margin: 0; font-weight: 700; color: var(--dark);">
            <i class="fas fa-paper-plane me-2" style="color: var(--primary);"></i>
            <?= lang('subscription_requests') ?? 'طلبات الاشتراك' ?>
            <span class="badge bg-primary" style="margin-right: 0.5rem;"><?= count($requests) ?></span>
        </h5>
    </div>
    <div class="card-body" style="padding: 0;">
        <div style="overflow-x: auto;">
            <table class="table" style="margin: 0;">
                <thead style="background: var(--light);">
                    <tr>
                        <th style="padding: 0.875rem 1rem; font-weight: 600; font-size: 0.85rem; color: #64748b; border: none;"><?= lang('plan') ?? 'الخطة' ?></th>
                        <th style="padding: 0.875rem 1rem; font-weight: 600; font-size: 0.85rem; color: #64748b; border: none;"><?= lang('type') ?? 'النوع' ?></th>
                        <th style="padding: 0.875rem 1rem; font-weight: 600; font-size: 0.85rem; color: #64748b; border: none;"><?= lang('status') ?? 'الحالة' ?></th>
                        <th style="padding: 0.875rem 1rem; font-weight: 600; font-size: 0.85rem; color: #64748b; border: none;"><?= lang('date') ?? 'التاريخ' ?></th>
                        <th style="padding: 0.875rem 1rem; font-weight: 600; font-size: 0.85rem; color: #64748b; border: none;"><?= lang('notes') ?? 'ملاحظات' ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($requests as $req): ?>
                    <tr style="border-bottom: 1px solid var(--light);">
                        <td style="padding: 0.875rem 1rem; vertical-align: middle;">
                            <strong><?= htmlspecialchars($req->plan_name ?? '') ?></strong>
                        </td>
                        <td style="padding: 0.875rem 1rem; vertical-align: middle;">
                            <?php if ($req->request_type === 'upgrade'): ?>
                                <span class="badge" style="background: #dbeafe; color: #1d4ed8; font-weight: 500;">
                                    <i class="fas fa-arrow-up me-1"></i><?= lang('upgrade') ?? 'ترقية' ?>
                                </span>
                            <?php elseif ($req->request_type === 'renew'): ?>
                                <span class="badge" style="background: #d1fae5; color: #065f46; font-weight: 500;">
                                    <i class="fas fa-redo me-1"></i><?= lang('renew') ?? 'تجديد' ?>
                                </span>
                            <?php else: ?>
                                <span class="badge" style="background: #f3e8ff; color: #7c3aed; font-weight: 500;">
                                    <i class="fas fa-plus me-1"></i><?= lang('new') ?? 'جديد' ?>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 0.875rem 1rem; vertical-align: middle;">
                            <?php if ($req->status === 'pending'): ?>
                                <span class="badge" style="background: #fef3c7; color: #92400e; font-weight: 600;">
                                    <i class="fas fa-clock me-1"></i><?= lang('pending') ?? 'قيد المراجعة' ?>
                                </span>
                            <?php elseif ($req->status === 'approved'): ?>
                                <span class="badge" style="background: #d1fae5; color: #065f46; font-weight: 600;">
                                    <i class="fas fa-check me-1"></i><?= lang('approved') ?? 'مقبول' ?>
                                </span>
                            <?php elseif ($req->status === 'rejected'): ?>
                                <span class="badge" style="background: #fee2e2; color: #991b1b; font-weight: 600;">
                                    <i class="fas fa-times me-1"></i><?= lang('rejected') ?? 'مرفوض' ?>
                                </span>
                            <?php else: ?>
                                <span class="badge bg-secondary">
                                    <i class="fas fa-ban me-1"></i><?= lang('cancelled') ?? 'ملغى' ?>
                                </span>
                            <?php endif; ?>
                            <?php if ($req->admin_notes): ?>
                                <br><small style="color: #64748b;"><?= htmlspecialchars($req->admin_notes) ?></small>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 0.875rem 1rem; vertical-align: middle; font-size: 0.875rem; color: #64748b;">
                            <?= date('Y-m-d H:i', strtotime($req->created_at)) ?>
                        </td>
                        <td style="padding: 0.875rem 1rem; vertical-align: middle; font-size: 0.85rem; color: #64748b;">
                            <?= htmlspecialchars($req->notes ?? '-') ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- سجل الاشتراكات -->
<?php if (!empty($subscriptions)): ?>
<div class="card" style="border-radius: 12px;">
    <div class="card-header" style="background: #fff; border-bottom: 2px solid var(--light); padding: 1.25rem 1.5rem;">
        <h5 style="margin: 0; font-weight: 700; color: var(--dark);">
            <i class="fas fa-history me-2" style="color: var(--primary);"></i>
            <?= lang('subscription_history') ?? 'سجل الاشتراكات' ?>
        </h5>
    </div>
    <div class="card-body" style="padding: 0;">
        <div style="overflow-x: auto;">
            <table class="table" style="margin: 0;">
                <thead style="background: var(--light);">
                    <tr>
                        <th style="padding: 0.875rem 1rem; font-weight: 600; font-size: 0.85rem; color: #64748b; border: none;"><?= lang('plan') ?? 'الخطة' ?></th>
                        <th style="padding: 0.875rem 1rem; font-weight: 600; font-size: 0.85rem; color: #64748b; border: none;"><?= lang('price') ?? 'السعر' ?></th>
                        <th style="padding: 0.875rem 1rem; font-weight: 600; font-size: 0.85rem; color: #64748b; border: none;"><?= lang('status') ?? 'الحالة' ?></th>
                        <th style="padding: 0.875rem 1rem; font-weight: 600; font-size: 0.85rem; color: #64748b; border: none;"><?= lang('start_date') ?? 'البداية' ?></th>
                        <th style="padding: 0.875rem 1rem; font-weight: 600; font-size: 0.85rem; color: #64748b; border: none;"><?= lang('end_date') ?? 'النهاية' ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subscriptions as $sub): ?>
                    <tr style="border-bottom: 1px solid var(--light);">
                        <td style="padding: 0.875rem 1rem; vertical-align: middle;">
                            <strong><?= htmlspecialchars($sub->plan_name ?? '') ?></strong>
                        </td>
                        <td style="padding: 0.875rem 1rem; vertical-align: middle;">
                            <?= htmlspecialchars($sub->plan_price ?? '0') ?> <?= lang('pricing_currency') ?? '$' ?>
                        </td>
                        <td style="padding: 0.875rem 1rem; vertical-align: middle;">
                            <?php if ($sub->status === 'active'): ?>
                                <span class="badge" style="background: #d1fae5; color: #065f46; font-weight: 600;">
                                    <i class="fas fa-check-circle me-1"></i><?= lang('active') ?? 'نشط' ?>
                                </span>
                            <?php elseif ($sub->status === 'expired'): ?>
                                <span class="badge bg-secondary">
                                    <i class="fas fa-clock me-1"></i><?= lang('expired') ?? 'منتهي' ?>
                                </span>
                            <?php else: ?>
                                <span class="badge" style="background: #fee2e2; color: #991b1b; font-weight: 600;">
                                    <i class="fas fa-times-circle me-1"></i><?= lang('cancelled') ?? 'ملغى' ?>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 0.875rem 1rem; vertical-align: middle; font-size: 0.875rem; color: #64748b;">
                            <?= $sub->start_date ? date('Y-m-d', strtotime($sub->start_date)) : '-' ?>
                        </td>
                        <td style="padding: 0.875rem 1rem; vertical-align: middle; font-size: 0.875rem; color: #64748b;">
                            <?= $sub->end_date ? date('Y-m-d', strtotime($sub->end_date)) : '-' ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php else: ?>
<?php if (empty($requests)): ?>
<div class="card" style="border-radius: 12px;">
    <div class="card-body text-center" style="padding: 3rem;">
        <i class="fas fa-inbox" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem; display: block;"></i>
        <h5 style="color: #64748b; font-weight: 600;"><?= lang('no_invoices') ?? 'لا توجد فواتير أو طلبات بعد' ?></h5>
        <a href="<?= url('/dashboard/subscription-plans') ?>" class="btn btn-primary mt-3" style="border-radius: 10px;">
            <i class="fas fa-credit-card me-1"></i><?= lang('view_plans') ?? 'عرض الخطط' ?>
        </a>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>

<div class="mt-4">
    <a href="<?= url('/dashboard/subscription') ?>" class="btn" style="background: #fff; color: var(--dark); border: 1px solid var(--border); padding: 0.625rem 1.25rem; border-radius: 10px; font-weight: 500; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none;">
        <i class="fas fa-arrow-right"></i>
        <?= lang('back') ?? 'رجوع' ?>
    </a>
</div>

<style>
.page-header h1 {
    background: none;
    -webkit-background-clip: unset;
    -webkit-text-fill-color: unset;
}
</style>

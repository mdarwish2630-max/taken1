<?php
/**
 * Subscription Payment Page
 * صفحة الدفع / تأكيد طلب الاشتراك أو الترقية
 */

$tenant = $tenant ?? Auth::tenant();
$plan = $plan ?? null;
$requestType = $requestType ?? 'new';
$currentSubscription = $currentSubscription ?? null;
?>

<div class="page-header" style="margin-bottom: 1.5rem;">
    <h1 style="font-size: 1.5rem; font-weight: 700; display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.25rem;">
        <i class="fas fa-file-invoice-dollar" style="color: var(--primary);"></i>
        <?= lang('subscription_payment') ?? 'إتمام الطلب' ?>
    </h1>
    <p class="text-muted" style="margin: 0;">
        <?php if ($requestType === 'upgrade'): ?>
            <?= lang('upgrade_payment_desc') ?? 'تأكيد طلب الترقية - سيتم مراجعته من قبل الإدارة' ?>
        <?php elseif ($requestType === 'renew'): ?>
            <?= lang('renew_payment_desc') ?? 'تأكيد طلب التجديد - سيتم مراجعته من قبل الإدارة' ?>
        <?php else: ?>
            <?= lang('new_payment_desc') ?? 'تأكيد طلب الاشتراك الجديد - سيتم مراجعته من قبل الإدارة' ?>
        <?php endif; ?>
    </p>
</div>

<?php if (!$plan): ?>
<div class="alert alert-danger">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <?= lang('plan_not_found') ?? 'الخطة غير موجودة' ?>
</div>
<a href="<?= url('/dashboard/subscription-plans') ?>" class="btn btn-primary"><?= lang('back') ?? 'رجوع' ?></a>
<?php else: ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- نوع الطلب -->
        <div class="card mb-4" style="border-radius: 12px; overflow: hidden;">
            <div style="padding: 1rem 1.5rem; background: linear-gradient(135deg, #4f46e5, #7c3aed); color: #fff; display: flex; align-items: center; gap: 0.75rem;">
                <?php if ($requestType === 'upgrade'): ?>
                    <i class="fas fa-arrow-up" style="font-size: 1.25rem;"></i>
                    <span style="font-weight: 600;"><?= lang('upgrade_request') ?? 'طلب ترقية الاشتراك' ?></span>
                <?php elseif ($requestType === 'renew'): ?>
                    <i class="fas fa-redo" style="font-size: 1.25rem;"></i>
                    <span style="font-weight: 600;"><?= lang('renew_request') ?? 'طلب تجديد الاشتراك' ?></span>
                <?php else: ?>
                    <i class="fas fa-plus-circle" style="font-size: 1.25rem;"></i>
                    <span style="font-weight: 600;"><?= lang('new_subscription_request') ?? 'طلب اشتراك جديد' ?></span>
                <?php endif; ?>
            </div>
        </div>

        <!-- ملخص الطلب -->
        <div class="card" style="border-radius: 12px;">
            <div class="card-header" style="background: #fff; border-bottom: 2px solid var(--light); padding: 1.25rem 1.5rem;">
                <h5 style="margin: 0; font-weight: 700; color: var(--dark);">
                    <i class="fas fa-receipt me-2" style="color: var(--primary);"></i>
                    <?= lang('order_summary') ?? 'ملخص الطلب' ?>
                </h5>
            </div>
            <div class="card-body" style="padding: 1.5rem;">
                <!-- تفاصيل الخطة المطلوبة -->
                <div style="background: var(--light); border-radius: 10px; padding: 1.25rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem;">
                        <h5 style="margin: 0; font-weight: 700; color: var(--dark);">
                            <?= htmlspecialchars($plan->name) ?>
                        </h5>
                        <div style="text-align: left;">
                            <?php if ($plan->is_free): ?>
                                <span style="font-size: 1.5rem; font-weight: 800; color: #22c55e;"><?= lang('free_plan') ?? 'مجاني' ?></span>
                            <?php else: ?>
                                <span style="font-size: 1.5rem; font-weight: 800; color: var(--primary);"><?= htmlspecialchars($plan->price) ?></span>
                                <small style="color: #64748b;"> <?= lang('pricing_currency') ?? '$' ?>/<?= $plan->duration ?? 30 ?> <?= lang('days') ?? 'يوم' ?></small>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (!empty($plan->description)): ?>
                    <p style="color: #64748b; margin: 0 0 1rem; font-size: 0.9rem;"><?= htmlspecialchars($plan->description) ?></p>
                    <?php endif; ?>

                    <?php
                    $features = [];
                    if (isset($plan->features)) {
                        $features = is_array($plan->features) ? $plan->features : json_decode($plan->features, true);
                    }
                    ?>
                    <?php if (!empty($features)): ?>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 0.4rem;">
                        <?php foreach ($features as $feature): ?>
                        <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #374151;">
                            <i class="fas fa-check" style="color: #22c55e; font-size: 0.75rem;"></i>
                            <?= htmlspecialchars($feature) ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if ($requestType === 'upgrade' && $currentSubscription): ?>
                <!-- مقارنة الترقية -->
                <div style="background: rgba(79,70,229,0.04); border: 1px solid rgba(79,70,229,0.15); border-radius: 10px; padding: 1rem; margin-bottom: 1.5rem;">
                    <h6 style="font-weight: 600; color: var(--primary); margin-bottom: 0.75rem;">
                        <i class="fas fa-exchange-alt me-1"></i>
                        <?= lang('plan_change') ?? 'تغيير الخطة' ?>
                    </h6>
                    <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                        <span style="padding: 0.4rem 1rem; background: #fef2f2; color: #dc2626; border-radius: 8px; font-weight: 600; font-size: 0.9rem;">
                            <?= htmlspecialchars($currentSubscription->plan_name ?? lang('current_plan')) ?>
                        </span>
                        <i class="fas fa-long-arrow-alt-left" style="color: var(--primary); font-size: 1.25rem;"></i>
                        <span style="padding: 0.4rem 1rem; background: #ecfdf5; color: #16a34a; border-radius: 8px; font-weight: 600; font-size: 0.9rem;">
                            <?= htmlspecialchars($plan->name) ?>
                        </span>
                    </div>
                </div>
                <?php endif; ?>

                <!-- ملاحظات -->
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label class="form-label" style="font-weight: 600; margin-bottom: 0.5rem;">
                        <i class="fas fa-comment-alt me-1" style="color: var(--primary);"></i>
                        <?= lang('request_notes') ?? 'ملاحظات (اختياري)' ?>
                    </label>
                    <textarea name="notes" class="form-control" rows="3"
                        placeholder="<?= lang('notes_placeholder') ?? 'أضف أي ملاحظات تود إيصالها للإدارة...' ?>"
                        style="border-radius: 10px; border: 1px solid var(--border); padding: 0.75rem; resize: vertical;"
                        id="requestNotes"></textarea>
                    <small class="text-muted"><?= lang('notes_help') ?? 'ملاحظاتك ستُرسل مع الطلب للإدارة' ?></small>
                </div>

                <!-- تنبيه -->
                <div style="padding: 1rem; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; margin-bottom: 1.5rem; display: flex; align-items: flex-start; gap: 0.75rem;">
                    <i class="fas fa-info-circle" style="color: #3b82f6; margin-top: 0.15rem; flex-shrink: 0;"></i>
                    <div>
                        <p style="margin: 0; color: #1e40af; font-size: 0.9rem; font-weight: 500;">
                            <?= lang('payment_info') ?? 'سيتم إرسال طلبك للإدارة للمراجعة والقبول. سيتم إشعارك بنتيجة الطلب.' ?>
                        </p>
                    </div>
                </div>

                <!-- أزرار -->
                <form method="POST" action="<?= url('/dashboard/subscription/payment') ?>" id="paymentForm">
                    <?= csrf_field() ?>
                    <input type="hidden" name="plan_id" value="<?= $plan->id ?>">
                    <input type="hidden" name="request_type" value="<?= $requestType ?>">

                    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                        <a href="<?= url('/dashboard/subscription-plans') ?>" class="btn" style="background: #fff; color: var(--dark); border: 1px solid var(--border); padding: 0.75rem 1.5rem; border-radius: 10px; font-weight: 500; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none;">
                            <i class="fas fa-arrow-right"></i>
                            <?= lang('cancel') ?? 'إلغاء' ?>
                        </a>
                        <button type="submit" class="btn" style="background: var(--gradient); color: #fff; border: none; padding: 0.75rem 2rem; border-radius: 10px; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 12px rgba(79,70,229,0.3); flex: 1; min-width: 200px; justify-content: center;">
                            <i class="fas fa-paper-plane"></i>
                            <?php if ($requestType === 'upgrade'): ?>
                                <?= lang('send_upgrade_request') ?? 'إرسال طلب الترقية' ?>
                            <?php elseif ($requestType === 'renew'): ?>
                                <?= lang('send_renew_request') ?? 'إرسال طلب التجديد' ?>
                            <?php else: ?>
                                <?= lang('send_subscription_request') ?? 'إرسال طلب الاشتراك' ?>
                            <?php endif; ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// نسخ ملاحظات النصي من textarea إلى النموذج عند الإرسال
document.getElementById('paymentForm').addEventListener('submit', function(e) {
    var notes = document.getElementById('requestNotes').value;
    if (notes) {
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'notes';
        input.value = notes;
        this.appendChild(input);
    }
});
</script>
<?php endif; ?>

<style>
.page-header h1 {
    background: none;
    -webkit-background-clip: unset;
    -webkit-text-fill-color: unset;
}
</style>

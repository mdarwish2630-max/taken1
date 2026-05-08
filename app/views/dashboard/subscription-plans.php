<?php
/**
 * Subscription Plans Page
 * صفحة خطط الاشتراك
 */

$tenant = $tenant ?? Auth::tenant();
$plans = $plans ?? [];
$currentPlan = $currentPlan ?? null;
$currentPlanId = $currentPlan->plan_id ?? null;
?>

<div class="page-header">
    <h1>
        <i class="fas fa-credit-card"></i>
        <?= lang('subscription_plans') ?>
    </h1>
    <p class="text-muted"><?= lang('choose_plan_desc') ?: 'اختر الخطة المناسبة لاحتياجاتك' ?></p>
</div>

<?php if (empty($plans)): ?>
<div class="card">
    <div class="card-body text-center py-5">
        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
        <h3><?= lang('no_plans') ?></h3>
        <p class="text-muted"><?= lang('no_plans_contact_admin') ?: 'لا توجد خطط اشتراك متاحة حالياً. يرجى التواصل مع الإدارة.' ?></p>
    </div>
</div>
<?php else: ?>
<div class="row">
    <?php foreach ($plans as $plan):
        // دعم أسماء أعمدة مختلفة (name / plan_name)
        $planName = $plan->name ?? $plan->plan_name ?? '';
        $planDesc = $plan->description ?? $plan->plan_description ?? '';
        $planPrice = $plan->price ?? 0;
        $planFree = $plan->is_free ?? ($planPrice == 0 ? 1 : 0);
        $planId = $plan->id ?? 0;
        $planDuration = $plan->duration ?? 30;
        $planPopular = $plan->is_popular ?? 0;
    ?>
    <div class="col-md-4 mb-4">
        <div class="card h-100 <?= $planId == $currentPlanId ? 'border-success' : '' ?>"
             style="<?= $planId == $currentPlanId ? 'border-width: 2px;' : '' ?>">

            <?php if ($planPopular): ?>
            <div class="card-header bg-primary text-white text-center py-2">
                <small class="fw-bold"><?= lang('recommended') ?></small>
            </div>
            <?php endif; ?>

            <div class="card-body text-center">
                <?php if ($planId == $currentPlanId): ?>
                <span class="badge bg-success mb-2"><?= lang('current_plan') ?></span>
                <?php endif; ?>

                <h4 class="mb-1"><?= htmlspecialchars($planName) ?></h4>
                <?php if ($planDesc): ?>
                <p class="text-muted small mb-3"><?= htmlspecialchars($planDesc) ?></p>
                <?php endif; ?>

                <div class="mb-4">
                    <?php if ($planFree): ?>
                        <span class="display-5 fw-bold"><?= lang('free_plan') ?></span>
                    <?php else: ?>
                        <span class="display-5 fw-bold"><?= htmlspecialchars($planPrice) ?></span>
                        <small class="text-muted"><?= lang('pricing_currency') ?>/<?= $planDuration ?> <?= lang('days') ?></small>
                    <?php endif; ?>
                </div>

                <ul class="list-unstyled text-start mb-4">
                    <?php
                    $features = [];
                    if (isset($plan->features)) {
                        $features = is_array($plan->features) ? $plan->features : json_decode($plan->features, true);
                    }
                    if (!empty($features)):
                        foreach ($features as $feature): ?>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i><?= htmlspecialchars($feature) ?></li>
                    <?php endforeach; else: ?>
                        <?php if (!empty($plan->max_services)): ?>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i><?= $plan->max_services == -1 ? '∞' : $plan->max_services ?> <?= lang('services') ?></li>
                        <?php endif; ?>
                        <?php if (!empty($plan->max_gallery)): ?>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i><?= $plan->max_gallery == -1 ? '∞' : $plan->max_gallery ?> <?= lang('gallery') ?></li>
                        <?php endif; ?>
                        <?php if (!empty($plan->allow_custom_domain)): ?>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i><?= lang('custom_domain') ?></li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>

                <?php if ($planId == $currentPlanId): ?>
                    <button class="btn btn-success w-100" disabled>
                        <i class="fas fa-check me-1"></i><?= lang('current_plan') ?>
                    </button>
                <?php else: ?>
                    <form method="POST" action="<?= url('/dashboard/subscription/plans/' . $planId) ?>">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn <?= $planPopular ? 'btn-primary' : 'btn-outline-primary' ?> w-100">
                            <?= lang('choose_this_plan') ?>
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

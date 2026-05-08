<?php
/**
 * Subscription Upgrade Page
 * صفحة ترقية الاشتراك
 */

$tenant = $tenant ?? Auth::tenant();
$currentPlan = $currentPlan ?? null;
$plans = $plans ?? [];
?>

<div class="page-header">
    <h1>
        <i class="fas fa-arrow-up"></i>
        <?= lang('upgrade_plan') ?>
    </h1>
    <p class="text-muted">
        <?= lang('upgrade_plan_desc') ?: 'اختر خطة أعلى للحصول على مميزات إضافية' ?>
    </p>
</div>

<?php if ($currentPlan): ?>
<div class="alert alert-info mb-4">
    <i class="fas fa-info-circle me-2"></i>
    <strong><?= lang('current_plan') ?>:</strong>
    <?= htmlspecialchars($currentPlan->plan_name) ?>
    <?php if (isset($currentPlan->end_date)): ?>
        - <?= lang('subscription_end_date') ?>: <?= date('Y-m-d', strtotime($currentPlan->end_date)) ?>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php if (empty($plans)): ?>
<div class="card">
    <div class="card-body text-center py-5">
        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
        <h3><?= lang('already_highest_plan') ?: 'أنت على أعلى خطة متاحة' ?></h3>
        <p class="text-muted"><?= lang('no_higher_plans') ?: 'لا توجد خطط أعلى من خطتك الحالية' ?></p>
        <a href="<?= url('/dashboard/subscription') ?>" class="btn btn-primary mt-3">
            <i class="fas fa-arrow-left"></i>
            <?= lang('back') ?>
        </a>
    </div>
</div>
<?php else: ?>
<div class="row">
    <?php foreach ($plans as $plan): ?>
    <div class="col-md-4 mb-4">
        <div class="card h-100 upgrade-plan-card <?= ($plan->is_popular ?? 0) ? 'border-primary' : '' ?>"
             style="<?= ($plan->is_popular ?? 0) ? 'border-width: 2px;' : '' ?>">

            <?php if ($plan->is_popular ?? 0): ?>
            <div class="card-header bg-primary text-white text-center">
                <span class="badge bg-light text-primary"><?= lang('popular') ?></span>
            </div>
            <?php endif; ?>

            <div class="card-body text-center">
                <h4 class="card-title"><?= htmlspecialchars($plan->name) ?></h4>

                <?php if ($plan->description): ?>
                <p class="text-muted small"><?= htmlspecialchars($plan->description) ?></p>
                <?php endif; ?>

                <div class="my-4">
                    <?php if ($plan->is_free): ?>
                        <span class="display-5 fw-bold"><?= lang('free_plan') ?></span>
                    <?php else: ?>
                        <span class="display-5 fw-bold"><?= htmlspecialchars($plan->price) ?></span>
                        <small class="text-muted">
                            <?= lang('pricing_currency') ?>
                            <?= isset($plan->duration) ? '/' . $plan->duration . ' ' . lang('days') : '' ?>
                        </small>
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
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            <?= htmlspecialchars($feature) ?>
                        </li>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <?php if (isset($plan->max_services) && $plan->max_services > 0): ?>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            <?= $plan->max_services ?> <?= lang('services') ?>
                        </li>
                        <?php endif; ?>
                        <?php if (isset($plan->max_gallery) && $plan->max_gallery > 0): ?>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            <?= $plan->max_gallery ?> <?= lang('gallery') ?>
                        </li>
                        <?php endif; ?>
                        <?php if (isset($plan->max_pages) && $plan->max_pages > 0): ?>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            <?= $plan->max_pages ?> <?= lang('pages') ?>
                        </li>
                        <?php endif; ?>
                        <?php if (!empty($plan->allow_custom_domain)): ?>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            <?= lang('custom_domain') ?>
                        </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>

                <form method="POST" action="<?= url('/dashboard/subscription/plans/' . $plan->id) ?>">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn <?= ($plan->is_popular ?? 0) ? 'btn-primary' : 'btn-outline-primary' ?> w-100">
                        <i class="fas fa-arrow-up me-1"></i>
                        <?= lang('upgrade_now') ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="mt-4">
    <a href="<?= url('/dashboard/subscription') ?>" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i>
        <?= lang('back') ?>
    </a>
</div>
<?php endif; ?>

<style>
.upgrade-plan-card {
    transition: transform 0.2s, box-shadow 0.2s;
}
.upgrade-plan-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}
</style>

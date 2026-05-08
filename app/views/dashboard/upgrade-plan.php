<?php
/**
 * Upgrade Plan View
 * صفحة ترقية الخطة
 */

$tenant = $tenant ?? Auth::tenant();
$currentPlan = null;
if ($tenant && $tenant->subscription_plan_id) {
    $planModel = new SubscriptionPlan();
    $currentPlan = $planModel->find($tenant->subscription_plan_id);
}
$plans = $plans ?? [];
?>

<div class="page-header">
    <h1 class="h3 mb-0">
        <i class="fas fa-arrow-up me-2"></i>
        <?= lang('upgrade_plan') ?>
    </h1>
    <p class="text-muted mb-0 mt-1"><?= lang('upgrade_plan_desc') ?></p>
</div>

<?php if ($currentPlan): ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-info d-flex align-items-center">
            <i class="fas fa-info-circle me-2 fa-lg"></i>
            <div>
                <strong><?= lang('current_plan') ?>:</strong> <?= htmlspecialchars($currentPlan->name) ?>
                <?php if (isset($currentPlan->price_monthly) && $currentPlan->price_monthly > 0): ?>
                — <?= htmlspecialchars($currentPlan->price_monthly) ?> <?= lang('sar') ?>/<?= lang('month') ?>
                <?php endif; ?>
                <br>
                <span class="small"><?= lang('upgrade_benefit') ?></span>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if (empty($plans)): ?>
<div class="row">
    <div class="col-12">
        <div class="alert alert-warning text-center">
            <i class="fas fa-crown me-2"></i>
            <?= lang('already_highest_plan') ?>
        </div>
    </div>
</div>
<?php else: ?>
<div class="row">
    <?php foreach ($plans as $plan): ?>
        <?php
        $isPopular = isset($plan->is_popular) && $plan->is_popular;
        $planPrice = $plan->price_monthly ?? $plan->price ?? 0;
        $planPriceYearly = $plan->price_yearly ?? 0;
        $hasCustomDomain = ($plan->custom_domain ?? 0) || ($plan->has_custom_domain ?? 0);
        $hasBlog = ($plan->blog_enabled ?? 0) || ($plan->has_blog ?? 0);
        $hasForms = ($plan->has_forms ?? 0);
        $maxPages = $plan->max_pages ?? lang('unlimited');
        $maxServices = $plan->max_services ?? lang('unlimited');
        $maxGallery = $plan->max_gallery_images ?? $plan->max_gallery ?? lang('unlimited');
        $maxBanners = $plan->max_banners ?? lang('unlimited');
        $maxTestimonials = $plan->max_testimonials ?? lang('unlimited');
        $hasRemoveBranding = ($plan->remove_branding ?? 0);
        $hasAnalytics = ($plan->analytics_access ?? 0) || ($plan->has_analytics ?? 0);
        $hasPriority = ($plan->priority_support ?? 0);
        ?>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 border <?= $isPopular ? 'border-primary shadow-lg' : '' ?>">
                <?php if ($isPopular): ?>
                <div class="position-absolute top-0 start-50 translate-middle">
                    <span class="badge bg-primary rounded-pill px-3 py-1 shadow-sm">
                        <i class="fas fa-star me-1"></i> <?= lang('popular') ?>
                    </span>
                </div>
                <?php endif; ?>

                <div class="card-body text-center pt-5">
                    <div class="plan-icon-large mb-3">
                        <?php if (!empty($plan->slug) && $plan->slug === 'free'): ?>
                            <i class="fas fa-gift"></i>
                        <?php elseif (!empty($plan->slug) && $plan->slug === 'basic'): ?>
                            <i class="fas fa-seedling"></i>
                        <?php elseif (!empty($plan->slug) && strpos($plan->slug, 'pro') !== false): ?>
                            <i class="fas fa-rocket"></i>
                        <?php elseif (!empty($plan->slug) && strpos($plan->slug, 'enterprise') !== false): ?>
                            <i class="fas fa-crown"></i>
                        <?php elseif (!empty($plan->slug) && strpos($plan->slug, 'premium') !== false): ?>
                            <i class="fas fa-gem"></i>
                        <?php else: ?>
                            <i class="fas fa-star"></i>
                        <?php endif; ?>
                    </div>

                    <h4 class="fw-bold"><?= htmlspecialchars($plan->name) ?></h4>
                    <p class="text-muted small"><?= htmlspecialchars($plan->description ?? '') ?></p>

                    <div class="my-3">
                        <?php if ($planPrice > 0): ?>
                            <span class="display-5 fw-bold text-primary"><?= htmlspecialchars($planPrice) ?></span>
                            <span class="text-muted"><?= lang('sar') ?></span>
                            <small class="text-muted d-block"><?= lang('month') ?></small>
                            <?php if ($planPriceYearly > 0): ?>
                            <small class="text-success d-block mt-1">
                                <i class="fas fa-tag me-1"></i>
                                <?= htmlspecialchars($planPriceYearly) ?> <?= lang('sar') ?>/<?= lang('year') ?>
                                <?php
                                $monthlyFromYearly = round($planPriceYearly / 12, 0);
                                if ($monthlyFromYearly < $planPrice):
                                ?>
                                <span class="badge bg-success ms-1"><?= lang('save') ?> <?= $planPrice - $monthlyFromYearly ?><?= lang('sar') ?></span>
                                <?php endif; ?>
                            </small>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="display-5 fw-bold text-success"><?= lang('free') ?></span>
                        <?php endif; ?>
                    </div>

                    <ul class="list-unstyled text-start mb-4">
                        <li class="py-1 border-bottom">
                            <i class="fas fa-check text-success me-2"></i>
                            <?= is_numeric($maxPages) ? $maxPages : htmlspecialchars($maxPages) ?> <?= lang('pages') ?>
                        </li>
                        <li class="py-1 border-bottom">
                            <i class="fas fa-check text-success me-2"></i>
                            <?= is_numeric($maxServices) ? $maxServices : htmlspecialchars($maxServices) ?> <?= lang('services') ?>
                        </li>
                        <li class="py-1 border-bottom">
                            <i class="fas fa-check text-success me-2"></i>
                            <?= is_numeric($maxGallery) ? $maxGallery : htmlspecialchars($maxGallery) ?> <?= lang('gallery_images') ?>
                        </li>
                        <li class="py-1 border-bottom">
                            <i class="fas fa-check text-success me-2"></i>
                            <?= is_numeric($maxBanners) ? $maxBanners : htmlspecialchars($maxBanners) ?> <?= lang('banners') ?>
                        </li>
                        <li class="py-1 border-bottom">
                            <i class="fas fa-check text-success me-2"></i>
                            <?= is_numeric($maxTestimonials) ? $maxTestimonials : htmlspecialchars($maxTestimonials) ?> <?= lang('testimonials') ?>
                        </li>
                        <?php if ($hasBlog): ?>
                        <li class="py-1 border-bottom">
                            <i class="fas fa-check text-success me-2"></i>
                            <?= lang('blog_posts') ?>
                        </li>
                        <?php endif; ?>
                        <?php if ($hasForms): ?>
                        <li class="py-1 border-bottom">
                            <i class="fas fa-check text-success me-2"></i>
                            <?= lang('forms') ?>
                        </li>
                        <?php endif; ?>
                        <?php if ($hasCustomDomain): ?>
                        <li class="py-1 border-bottom">
                            <i class="fas fa-check text-success me-2"></i>
                            <?= lang('custom_domain') ?>
                        </li>
                        <?php endif; ?>
                        <?php if ($hasRemoveBranding): ?>
                        <li class="py-1 border-bottom">
                            <i class="fas fa-check text-success me-2"></i>
                            <?= lang('remove_branding') ?>
                        </li>
                        <?php endif; ?>
                        <?php if ($hasAnalytics): ?>
                        <li class="py-1 border-bottom">
                            <i class="fas fa-check text-success me-2"></i>
                            <?= lang('analytics') ?>
                        </li>
                        <?php endif; ?>
                        <?php if ($hasPriority): ?>
                        <li class="py-1">
                            <i class="fas fa-check text-success me-2"></i>
                            <?= lang('priority_support') ?>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="card-footer bg-white border-0">
                    <?php if ($isPopular): ?>
                    <a href="<?= url('/dashboard/subscription/payment') ?>?plan=<?= $plan->id ?>"
                       class="btn btn-primary w-100 btn-lg">
                        <i class="fas fa-arrow-up me-1"></i> <?= lang('upgrade_now') ?>
                    </a>
                    <?php else: ?>
                    <a href="<?= url('/dashboard/subscription/payment') ?>?plan=<?= $plan->id ?>"
                       class="btn btn-outline-primary w-100 btn-lg">
                        <i class="fas fa-arrow-up me-1"></i> <?= lang('upgrade_now') ?>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<div class="text-center mt-3 mb-4">
    <a href="<?= url('/dashboard/subscription') ?>" class="text-muted">
        <i class="fas fa-arrow-right me-1"></i> <?= lang('back_to_subscription') ?>
    </a>
</div>

<style>
.plan-icon-large {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary, #4f46e5) 0%, var(--primary-dark, #3730a3) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    font-size: 2rem;
    color: #fff;
    box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
}
.card.h-100 {
    transition: transform 0.2s, box-shadow 0.2s;
}
.card.h-100:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}
</style>

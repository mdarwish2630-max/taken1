<?php
/**
 * Renew Subscription View
 * صفحة تجديد الاشتراك
 */


$tenant = $tenant ?? Auth::tenant();
?>

<div class="page-header">
    <h1 class="h3 mb-0">
        <i class="fas fa-redo me-2"></i>
        <?= lang('renew_subscription') ?>
    </h1>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <!-- Current Status -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="text-muted"><?= lang('current_plan') ?></h5>
                        <h3><?= $plan ? $plan->name : lang('no_plan') ?></h3>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-muted"><?= lang('expires_at') ?></h5>
                        <h3>
                            <?php if ($tenant->subscription_end): ?>
                                <?= date('Y-m-d', strtotime($tenant->subscription_end)) ?>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Renew Options -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>
                    <?= lang('select_renewal_period') ?>
                </h5>
            </div>
            <div class="card-body">
                <form id="renewForm" method="POST" action="<?= url('/dashboard/subscription/payment') ?>">
                    <?= $this->csrf() ?>
                    <input type="hidden" name="plan_id" value="<?= $plan ? $plan->id : '' ?>">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-check card p-3">
                                <input class="form-check-input" type="radio" name="billing_cycle" 
                                       id="cycle_1" value="1_month" data-price="<?= $plan ? $plan->price_monthly : 0 ?>">
                                <label class="form-check-label w-100" for="cycle_1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong><?= lang('1_month') ?></strong>
                                            <small class="d-block text-muted"><?= lang('monthly_billing') ?></small>
                                        </div>
                                        <strong class="text-primary"><?= $plan ? $plan->price_monthly : 0 ?> <?= lang('sar') ?></strong>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-check card p-3">
                                <input class="form-check-input" type="radio" name="billing_cycle" 
                                       id="cycle_3" value="3_months" data-price="<?= $plan ? $plan->price_monthly * 3 : 0 ?>">
                                <label class="form-check-label w-100" for="cycle_3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong><?= lang('3_months') ?></strong>
                                            <small class="d-block text-muted"><?= lang('quarterly_billing') ?></small>
                                        </div>
                                        <strong class="text-primary"><?= $plan ? $plan->price_monthly * 3 : 0 ?> <?= lang('sar') ?></strong>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-check card p-3 border-primary">
                                <input class="form-check-input" type="radio" name="billing_cycle" 
                                       id="cycle_6" value="6_months" checked data-price="<?= $plan ? $plan->price_monthly * 6 : 0 ?>">
                                <label class="form-check-label w-100" for="cycle_6">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong><?= lang('6_months') ?></strong>
                                            <small class="d-block text-muted"><?= lang('save_10_percent') ?></small>
                                        </div>
                                        <strong class="text-primary"><?= $plan ? round($plan->price_monthly * 6 * 0.9) : 0 ?> <?= lang('sar') ?></strong>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-check card p-3 border-success">
                                <input class="form-check-input" type="radio" name="billing_cycle" 
                                       id="cycle_12" value="12_months" data-price="<?= $plan ? $plan->price_yearly : 0 ?>">
                                <label class="form-check-label w-100" for="cycle_12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong><?= lang('12_months') ?></strong>
                                            <span class="badge bg-success ms-1"><?= lang('best_value') ?></span>
                                            <small class="d-block text-muted"><?= lang('save_20_percent') ?></small>
                                        </div>
                                        <strong class="text-primary"><?= $plan ? $plan->price_yearly : 0 ?> <?= lang('sar') ?></strong>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0"><?= lang('total') ?></h5>
                        <h3 class="text-primary mb-0" id="totalPrice"><?= $plan ? round($plan->price_monthly * 6 * 0.9) : 0 ?> <?= lang('sar') ?></h3>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" name="auto_renew" id="auto_renew" value="1" checked>
                        <label class="form-check-label" for="auto_renew">
                            <strong><?= lang('auto_renew') ?></strong>
                            <small class="d-block text-muted"><?= lang('auto_renew_benefit') ?></small>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-redo me-2"></i>
                        <?= lang('proceed_to_payment') ?>
                    </button>
                </form>
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-4">
            <a href="<?= url('/dashboard/subscription') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-right me-2"></i>
                <?= lang('back') ?>
            </a>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('input[name="billing_cycle"]').forEach(input => {
    input.addEventListener('change', function() {
        const price = this.dataset.price;
        document.getElementById('totalPrice').textContent = price + ' <?= lang('sar') ?>';
    });
});
</script>

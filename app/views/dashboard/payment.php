<?php
/**
 * Payment View
 * صفحة الدفع
 */


$tenant = $tenant ?? Auth::tenant();
?>

<div class="page-header">
    <h1 class="h3 mb-0">
        <i class="fas fa-credit-card me-2"></i>
        <?= lang('payment') ?>
    </h1>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <!-- Plan Summary -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-receipt me-2"></i>
                    <?= lang('order_summary') ?>
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="mb-1"><?= $plan->name ?></h5>
                        <p class="text-muted mb-0 small"><?= $plan->description ?></p>
                    </div>
                    <div class="text-end">
                        <h4 class="text-primary mb-0"><?= $plan->price_monthly ?> <?= lang('sar') ?></h4>
                        <small class="text-muted"><?= lang('monthly') ?></small>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <small class="text-muted d-block"><?= lang('pages') ?></small>
                        <strong><?= $plan->max_pages ?: lang('unlimited') ?></strong>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block"><?= lang('services') ?></small>
                        <strong><?= $plan->max_services ?: lang('unlimited') ?></strong>
                    </div>
                    <div class="col-6 mt-2">
                        <small class="text-muted d-block"><?= lang('gallery_images') ?></small>
                        <strong><?= $plan->max_gallery_images ?: lang('unlimited') ?></strong>
                    </div>
                    <div class="col-6 mt-2">
                        <small class="text-muted d-block"><?= lang('blog') ?></small>
                        <strong><?= $plan->blog_enabled ? lang('yes') : lang('no') ?></strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Form -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-money-bill me-2"></i>
                    <?= lang('payment_method') ?>
                </h5>
            </div>
            <div class="card-body">
                <form id="paymentForm" method="POST" action="<?= url('/dashboard/subscription/payment') ?>">
                    <?= $this->csrf() ?>
                    <input type="hidden" name="plan_id" value="<?= $plan->id ?>">
                    
                    <!-- Billing Cycle -->
                    <div class="mb-4">
                        <label class="form-label fw-bold"><?= lang('billing_cycle') ?></label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check card p-3">
                                    <input class="form-check-input" type="radio" name="billing_cycle" 
                                           id="monthly" value="monthly" checked
                                           onchange="updatePrice()">
                                    <label class="form-check-label w-100" for="monthly">
                                        <div class="d-flex justify-content-between">
                                            <span><?= lang('monthly') ?></span>
                                            <strong><?= $plan->price_monthly ?> <?= lang('sar') ?></strong>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check card p-3">
                                    <input class="form-check-input" type="radio" name="billing_cycle" 
                                           id="yearly" value="yearly"
                                           onchange="updatePrice()">
                                    <label class="form-check-label w-100" for="yearly">
                                        <div class="d-flex justify-content-between">
                                            <span>
                                                <?= lang('yearly') ?>
                                                <span class="badge bg-success ms-1"><?= lang('save_yearly') ?></span>
                                            </span>
                                            <strong><?= $plan->price_yearly ?> <?= lang('sar') ?></strong>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method Selection -->
                    <div class="mb-4">
                        <label class="form-label fw-bold"><?= lang('payment_method') ?></label>
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <div class="form-check card p-3 text-center">
                                    <input class="form-check-input" type="radio" name="payment_method" 
                                           id="bank" value="bank_transfer" checked>
                                    <label class="form-check-label w-100" for="bank">
                                        <i class="fas fa-university fa-2x mb-2 d-block text-primary"></i>
                                        <span><?= lang('bank_transfer') ?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="form-check card p-3 text-center">
                                    <input class="form-check-input" type="radio" name="payment_method" 
                                           id="apple" value="apple_pay">
                                    <label class="form-check-label w-100" for="apple">
                                        <i class="fab fa-apple-pay fa-2x mb-2 d-block"></i>
                                        <span>Apple Pay</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="form-check card p-3 text-center">
                                    <input class="form-check-input" type="radio" name="payment_method" 
                                           id="mada" value="mada">
                                    <label class="form-check-label w-100" for="mada">
                                        <i class="fas fa-credit-card fa-2x mb-2 d-block text-success"></i>
                                        <span>مدى</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Auto Renew -->
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" name="auto_renew" id="auto_renew" value="1">
                        <label class="form-check-label" for="auto_renew">
                            <?= lang('auto_renew_desc') ?>
                        </label>
                    </div>

                    <!-- Total -->
                    <div class="bg-light p-3 rounded mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold"><?= lang('total') ?></span>
                            <h3 class="text-primary mb-0" id="totalPrice"><?= $plan->price_monthly ?> <?= lang('sar') ?></h3>
                        </div>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-lock me-2"></i>
                        <?= lang('complete_payment') ?>
                    </button>
                </form>
            </div>
        </div>

        <!-- Bank Transfer Info -->
        <div class="card mt-4" id="bankInfo">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-university me-2"></i>
                    <?= lang('bank_account_info') ?>
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td class="text-muted"><?= lang('bank_name') ?></td>
                        <td><strong>البنك الأهلي السعودي</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted"><?= lang('account_number') ?></td>
                        <td><strong dir="ltr">SA1234567890123456789012</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted"><?= lang('account_holder') ?></td>
                        <td><strong>منصة المواقع</strong></td>
                    </tr>
                </table>
                <div class="alert alert-info mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    <?= lang('bank_transfer_note') ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updatePrice() {
    const monthly = <?= $plan->price_monthly ?>;
    const yearly = <?= $plan->price_yearly ?>;
    const isYearly = document.getElementById('yearly').checked;
    
    document.getElementById('totalPrice').textContent = 
        (isYearly ? yearly : monthly) + ' <?= lang('sar') ?>';
}

document.querySelectorAll('input[name="payment_method"]').forEach(input => {
    input.addEventListener('change', function() {
        document.getElementById('bankInfo').style.display = 
            this.value === 'bank_transfer' ? 'block' : 'none';
    });
});
</script>

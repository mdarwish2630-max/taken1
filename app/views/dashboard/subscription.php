<?php
/**
 * Subscription Overview Page
 * صفحة الاشتراك الرئيسية - عرض حالة الاشتراك والخطط المتاحة
 */

$tenant = $tenant ?? Auth::tenant();
$currentSubscription = $currentSubscription ?? null;
$currentPlan = $currentPlan ?? null;
$stats = $stats ?? (object)[];
$pendingRequest = $pendingRequest ?? null;
?>

<div class="page-header" style="margin-bottom: 1.5rem;">
    <h1 style="font-size: 1.5rem; font-weight: 700; display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.25rem;">
        <i class="fas fa-credit-card" style="color: var(--primary);"></i>
        <?= lang('subscription') ?? 'الاشتراك' ?>
    </h1>
    <p class="text-muted" style="margin: 0;"><?= lang('subscription_desc') ?? 'إدارة اشتراكك ومشاهدة الخطط المتاحة' ?></p>
</div>

<?php if ($pendingRequest): ?>
<!-- طلب معلق -->
<div class="card mb-4" style="border: 2px solid #f59e0b; border-radius: 12px;">
    <div class="card-body">
        <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
            <div style="width: 48px; height: 48px; border-radius: 50%; background: rgba(245,158,11,0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i class="fas fa-clock" style="color: #f59e0b; font-size: 1.25rem;"></i>
            </div>
            <div style="flex: 1; min-width: 200px;">
                <h5 style="margin: 0 0 0.25rem; font-weight: 700; color: #92400e;">
                    <?= lang('pending_request') ?? 'لديك طلب معلق' ?>
                </h5>
                <p style="margin: 0; color: #78716c; font-size: 0.9rem;">
                    <?php if (($pendingRequest->request_type ?? '') === 'upgrade'): ?>
                        <?= lang('pending_upgrade_msg') ?? 'طلب ترقية إلى خطة' ?>
                        <strong><?= htmlspecialchars($pendingRequest->plan_name ?? '') ?></strong>
                        <?php if (!empty($pendingRequest->notes)): ?>
                            <br><small><?= lang('notes') ?? 'ملاحظات' ?>: <?= htmlspecialchars($pendingRequest->notes) ?></small>
                        <?php endif; ?>
                    <?php else: ?>
                        <?= lang('pending_new_msg') ?? 'طلب اشتراك جديد بخطة' ?>
                        <strong><?= htmlspecialchars($pendingRequest->plan_name ?? '') ?></strong>
                        <?php if (!empty($pendingRequest->notes)): ?>
                            <br><small><?= lang('notes') ?? 'ملاحظات' ?>: <?= htmlspecialchars($pendingRequest->notes) ?></small>
                        <?php endif; ?>
                    <?php endif; ?>
                    <br><small style="color: #a8a29e;"><?= lang('request_date') ?? 'تاريخ الطلب' ?>: <?= !empty($pendingRequest->created_at) ? date('Y-m-d H:i', strtotime($pendingRequest->created_at)) : '-' ?></small>
                </p>
            </div>
            <span class="badge" style="background: #fbbf24; color: #78350f; padding: 0.5rem 1rem; font-size: 0.85rem; font-weight: 600;">
                <i class="fas fa-hourglass-half me-1"></i>
                <?= lang('pending') ?? 'قيد المراجعة' ?>
            </span>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- حالة الاشتراك الحالي -->
<?php if ($currentSubscription && $currentPlan): ?>
<div class="card mb-4" style="border-radius: 12px; overflow: hidden;">
    <div style="background: linear-gradient(135deg, #4f46e5, #7c3aed); padding: 1.5rem; color: #fff;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h3 style="margin: 0 0 0.5rem; font-weight: 700;"><?= lang('current_plan') ?? 'الخطة الحالية' ?></h3>
                <h2 style="margin: 0 0 0.5rem; font-weight: 800; font-size: 1.75rem;">
                    <?= htmlspecialchars($currentPlan->name ?? $currentPlan->plan_name) ?>
                </h2>
                <div style="display: flex; gap: 1rem; flex-wrap: wrap; font-size: 0.9rem; opacity: 0.9;">
                    <?php if ($currentSubscription->start_date): ?>
                    <span><i class="fas fa-calendar-alt me-1"></i><?= lang('start_date') ?? 'بداية' ?>: <?= date('Y-m-d', strtotime($currentSubscription->start_date)) ?></span>
                    <?php endif; ?>
                    <?php if ($currentSubscription->end_date): ?>
                    <span><i class="fas fa-calendar-check me-1"></i><?= lang('end_date') ?? 'نهاية' ?>: <?= date('Y-m-d', strtotime($currentSubscription->end_date)) ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div style="text-align: center;">
                <?php
                $remainingDays = 0;
                if ($currentSubscription->end_date) {
                    $remainingDays = max(0, ceil((strtotime($currentSubscription->end_date) - time()) / 86400));
                }
                ?>
                <div style="font-size: 2.5rem; font-weight: 900; line-height: 1;"><?= $remainingDays ?></div>
                <div style="font-size: 0.85rem; opacity: 0.8;"><?= lang('remaining_days') ?? 'يوم متبقي' ?></div>
            </div>
        </div>
    </div>

    <div class="card-body" style="padding: 1.5rem;">
        <!-- استخدام الموارد -->
        <h6 style="font-weight: 700; margin-bottom: 1rem; color: var(--dark);">
            <i class="fas fa-chart-pie me-1" style="color: var(--primary);"></i>
            <?= lang('usage') ?? 'استخدام الموارد' ?>
        </h6>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
            <!-- الخدمات -->
            <div style="text-align: center; padding: 1rem; background: var(--light); border-radius: 10px;">
                <i class="fas fa-concierge-bell" style="font-size: 1.5rem; color: var(--primary); margin-bottom: 0.5rem; display: block;"></i>
                <div style="font-size: 1.25rem; font-weight: 800; color: var(--dark);">
                    <?= $stats->services_count ?? 0 ?>
                    <?php if (isset($currentPlan->max_services) && $currentPlan->max_services > 0): ?>
                    / <?= $currentPlan->max_services ?>
                    <?php endif; ?>
                </div>
                <small style="color: #64748b;"><?= lang('services') ?></small>
            </div>

            <!-- المعرض -->
            <div style="text-align: center; padding: 1rem; background: var(--light); border-radius: 10px;">
                <i class="fas fa-photo-video" style="font-size: 1.5rem; color: var(--primary); margin-bottom: 0.5rem; display: block;"></i>
                <div style="font-size: 1.25rem; font-weight: 800; color: var(--dark);">
                    <?= $stats->gallery_count ?? 0 ?>
                    <?php if (isset($currentPlan->max_gallery) && $currentPlan->max_gallery > 0): ?>
                    / <?= $currentPlan->max_gallery ?>
                    <?php endif; ?>
                </div>
                <small style="color: #64748b;"><?= lang('gallery') ?? 'المعرض' ?></small>
            </div>

            <!-- البانرات -->
            <div style="text-align: center; padding: 1rem; background: var(--light); border-radius: 10px;">
                <i class="fas fa-images" style="font-size: 1.5rem; color: var(--primary); margin-bottom: 0.5rem; display: block;"></i>
                <div style="font-size: 1.25rem; font-weight: 800; color: var(--dark);">
                    <?= $stats->banners_count ?? 0 ?>
                    <?php if (isset($currentPlan->max_banners) && $currentPlan->max_banners > 0): ?>
                    / <?= $currentPlan->max_banners ?>
                    <?php endif; ?>
                </div>
                <small style="color: #64748b;"><?= lang('banners') ?? 'البنرات' ?></small>
            </div>

            <!-- الصفحات -->
            <div style="text-align: center; padding: 1rem; background: var(--light); border-radius: 10px;">
                <i class="fas fa-file-alt" style="font-size: 1.5rem; color: var(--primary); margin-bottom: 0.5rem; display: block;"></i>
                <div style="font-size: 1.25rem; font-weight: 800; color: var(--dark);">
                    <?= $stats->pages_count ?? 0 ?>
                    <?php if (isset($currentPlan->max_pages) && $currentPlan->max_pages > 0): ?>
                    / <?= $currentPlan->max_pages ?>
                    <?php endif; ?>
                </div>
                <small style="color: #64748b;"><?= lang('pages') ?? 'الصفحات' ?></small>
            </div>
        </div>

        <!-- مميزات الخطة -->
        <?php if (!empty($currentPlan->features)): ?>
        <div style="margin-bottom: 1.5rem;">
            <?php
            $features = is_array($currentPlan->features) ? $currentPlan->features : json_decode($currentPlan->features, true);
            if (!empty($features)):
            ?>
            <h6 style="font-weight: 700; margin-bottom: 0.75rem; color: var(--dark);">
                <i class="fas fa-list-check me-1" style="color: var(--primary);"></i>
                <?= lang('plan_features') ?? 'مميزات الخطة' ?>
            </h6>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 0.5rem;">
                <?php foreach ($features as $feature): ?>
                <div style="display: flex; align-items: center; gap: 0.5rem; padding: 0.4rem 0;">
                    <i class="fas fa-check-circle" style="color: #22c55e; flex-shrink: 0;"></i>
                    <span style="font-size: 0.9rem; color: #374151;"><?= htmlspecialchars($feature) ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if (isset($currentPlan->allow_custom_domain) && $currentPlan->allow_custom_domain): ?>
        <div style="padding: 0.75rem; background: rgba(34,197,94,0.08); border-radius: 8px; border: 1px solid rgba(34,197,94,0.2); display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
            <i class="fas fa-globe" style="color: #22c55e; font-size: 1.1rem;"></i>
            <span style="color: #166534; font-size: 0.9rem; font-weight: 500;">
                <i class="fas fa-check-circle me-1"></i>
                <?= lang('custom_domain_allowed') ?? 'الخطة تسمح بربط نطاق مخصص' ?>
            </span>
        </div>
        <?php endif; ?>

        <!-- أزرار الإجراءات -->
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <a href="<?= url('/dashboard/subscription/upgrade') ?>" class="btn" style="background: var(--gradient); color: #fff; border: none; padding: 0.625rem 1.5rem; border-radius: 10px; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; box-shadow: 0 4px 12px rgba(79,70,229,0.3);">
                <i class="fas fa-arrow-up"></i>
                <?= lang('upgrade_plan') ?? 'ترقية الخطة' ?>
            </a>
            <form method="POST" action="<?= url('/dashboard/subscription/renew') ?>" style="display: inline;">
                <?= csrf_field() ?>
                <button type="submit" class="btn" style="background: #fff; color: var(--primary); border: 2px solid var(--primary); padding: 0.625rem 1.5rem; border-radius: 10px; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-redo"></i>
                    <?= lang('renew_subscription') ?? 'تجديد الاشتراك' ?>
                </button>
            </form>
            <a href="<?= url('/dashboard/invoices') ?>" class="btn" style="background: #fff; color: var(--dark); border: 1px solid var(--border); padding: 0.625rem 1.5rem; border-radius: 10px; font-weight: 500; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none;">
                <i class="fas fa-file-invoice"></i>
                <?= lang('invoices') ?? 'الفواتير' ?>
            </a>
        </div>
    </div>
</div>

<?php else: ?>
<!-- لا يوجد اشتراك نشط -->
<div class="card mb-4" style="border-radius: 12px; overflow: hidden;">
    <div style="background: linear-gradient(135deg, #64748b, #475569); padding: 2rem; color: #fff; text-align: center;">
        <i class="fas fa-box-open" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.8; display: block;"></i>
        <h3 style="font-weight: 700; margin-bottom: 0.5rem;"><?= lang('no_active_subscription') ?? 'لا يوجد اشتراك نشط' ?></h3>
        <p style="margin: 0; opacity: 0.8;"><?= lang('choose_plan_to_start') ?? 'اختر خطة لبدء استخدام المنصة' ?></p>
    </div>
    <div class="card-body" style="padding: 1.5rem; text-align: center;">
        <a href="<?= url('/dashboard/subscription-plans') ?>" class="btn" style="background: var(--gradient); color: #fff; border: none; padding: 0.75rem 2rem; border-radius: 10px; font-weight: 600; font-size: 1rem; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; box-shadow: 0 4px 12px rgba(79,70,229,0.3);">
            <i class="fas fa-credit-card"></i>
            <?= lang('view_plans') ?? 'عرض الخطط والاشتراك' ?>
        </a>
    </div>
</div>
<?php endif; ?>

<style>
.page-header h1 {
    background: none;
    -webkit-background-clip: unset;
    -webkit-text-fill-color: unset;
}
</style>

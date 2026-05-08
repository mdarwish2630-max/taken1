<?php
/**
 * Admin - Subscription Plans Management
 * إدارة خطط الاشتراك - مصحح
 */

$plans = $plans ?? [];

function planFeat($plan, $feat) {
    if (!empty($plan->features)) {
        $arr = json_decode($plan->features, true);
        if (is_array($arr)) return in_array($feat, $arr);
    }
    return false;
}
?>

<div class="page-header">
    <h1 class="page-title"><?= lang('subscription_plans') ?? 'خطط الاشتراك' ?></h1>
    <div class="header-actions">
        <a href="<?= url('/admin/plans/add') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            <?= lang('add_plan') ?? 'إضافة خطة جديدة' ?>
        </a>
    </div>
</div>

<?php if (Session::has('success')): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    <?= Session::getSuccess() ?>
</div>
<?php endif; ?>

<?php if (Session::has('error')): ?>
<div class="alert alert-danger">
    <i class="fas fa-exclamation-circle"></i>
    <?= Session::getError() ?>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th><?= lang('plan_name') ?? 'اسم الخطة' ?></th>
                        <th>السعر الشهري</th>
                        <th>الخدمات</th>
                        <th>الصفحات</th>
                        <th>دومين مخصص</th>
                        <th>الحالة</th>
                        <th><?= lang('actions') ?? 'الإجراءات' ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($plans as $plan): ?>
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <?php if (!empty($plan->is_popular)): ?>
                                <span class="badge badge-warning" style="font-size: 0.7rem;">
                                    <i class="fas fa-star"></i>
                                </span>
                                <?php endif; ?>
                                <div>
                                    <strong><?= htmlspecialchars($plan->name ?? '') ?></strong>
                                    <div style="font-size: 0.75rem; color: #64748b;"><?= htmlspecialchars($plan->slug ?? '') ?></div>
                                    <?php if (!empty($plan->description)): ?>
                                    <div style="font-size: 0.7rem; color: #94a3b8;"><?= htmlspecialchars($plan->description) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <strong style="color: var(--primary);">
                                <?= number_format((float)($plan->price_monthly ?? 0), 0) ?> <?= htmlspecialchars($plan->currency ?? 'SAR') ?>
                            </strong>
                            <?php if (!empty($plan->price_yearly) && $plan->price_yearly > 0): ?>
                            <div style="font-size: 0.7rem; color: #94a3b8;">
                                سنوي: <?= number_format((float)$plan->price_yearly, 0) ?>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php $ms = $plan->max_services ?? -1; echo $ms == -1 ? '∞' : $ms; ?>
                        </td>
                        <td>
                            <?php $mp = $plan->max_pages ?? -1; echo $mp == -1 ? '∞' : $mp; ?>
                        </td>
                        <td>
                            <?php if (!empty($plan->custom_domain)): ?>
                            <span class="badge badge-success"><i class="fas fa-check"></i></span>
                            <?php else: ?>
                            <span class="badge badge-secondary"><i class="fas fa-times"></i></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($plan->is_active)): ?>
                            <span class="badge badge-success"><?= lang('active') ?? 'نشط' ?></span>
                            <?php else: ?>
                            <span class="badge badge-danger"><?= lang('inactive') ?? 'غير نشط' ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="<?= url('/admin/plans/edit/' . $plan->id) ?>" 
                                   class="btn btn-sm btn-outline" title="<?= lang('edit') ?? 'تعديل' ?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="<?= url('/admin/plans/delete/' . $plan->id) ?>" 
                                      style="display: inline;" 
                                      onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                    <?= $this->csrf() ?>
                                    <button type="submit" class="btn btn-sm btn-danger" title="<?= lang('delete') ?? 'حذف' ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                    <?php if (empty($plans)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 2rem; color: #64748b;">
                            <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 0.5rem; display: block;"></i>
                            <?= lang('no_plans') ?? 'لا توجد خطط. أضف خطة جديدة للبدء.' ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if (!empty($plans)): ?>
<!-- Plans Comparison -->
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title"><?= lang('plans_comparison') ?? 'مقارنة الخطط' ?></h3>
    </div>
    <div class="card-body" style="overflow-x: auto;">
        <table class="table" style="min-width: 800px;">
            <thead>
                <tr>
                    <th>الميزة</th>
                    <?php foreach ($plans as $plan): ?>
                    <th style="text-align: center;"><?= htmlspecialchars($plan->name ?? '') ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>دومين مخصص</td>
                    <?php foreach ($plans as $plan): ?>
                    <td style="text-align: center;">
                        <?= !empty($plan->custom_domain) ? '<i class="fas fa-check" style="color: #10b981;"></i>' : '<i class="fas fa-times" style="color: #ef4444;"></i>' ?>
                    </td>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <td>إزالة العلامة التجارية</td>
                    <?php foreach ($plans as $plan): ?>
                    <td style="text-align: center;">
                        <?= !empty($plan->remove_branding) ? '<i class="fas fa-check" style="color: #10b981;"></i>' : '<i class="fas fa-times" style="color: #ef4444;"></i>' ?>
                    </td>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <td>إحصائيات متقدمة</td>
                    <?php foreach ($plans as $plan): ?>
                    <td style="text-align: center;">
                        <?= !empty($plan->analytics_access) ? '<i class="fas fa-check" style="color: #10b981;"></i>' : '<i class="fas fa-times" style="color: #ef4444;"></i>' ?>
                    </td>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <td>دعم ذو أولوية</td>
                    <?php foreach ($plans as $plan): ?>
                    <td style="text-align: center;">
                        <?= !empty($plan->priority_support) ? '<i class="fas fa-check" style="color: #10b981;"></i>' : '<i class="fas fa-times" style="color: #ef4444;"></i>' ?>
                    </td>
                    <?php endforeach; ?>
                </tr>
                <tr style="background: var(--light, #f8fafc); font-weight: 600;">
                    <td>الخدمات</td>
                    <?php foreach ($plans as $plan): ?>
                    <td style="text-align: center;">
                        <?php $ms = $plan->max_services ?? -1; echo $ms == -1 ? '∞' : $ms; ?>
                    </td>
                    <?php endforeach; ?>
                </tr>
                <tr style="font-weight: 600;">
                    <td>الصفحات</td>
                    <?php foreach ($plans as $plan): ?>
                    <td style="text-align: center;">
                        <?php $mp = $plan->max_pages ?? -1; echo $mp == -1 ? '∞' : $mp; ?>
                    </td>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <td>معرض الصور</td>
                    <?php foreach ($plans as $plan): ?>
                    <td style="text-align: center;">
                        <?php $mg = $plan->max_gallery ?? -1; echo $mg == -1 ? '∞' : $mg; ?>
                    </td>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <td>البانرات</td>
                    <?php foreach ($plans as $plan): ?>
                    <td style="text-align: center;">
                        <?php $mb = $plan->max_banners ?? -1; echo $mb == -1 ? '∞' : $mb; ?>
                    </td>
                    <?php endforeach; ?>
                </tr>
                <?php if (!empty($plan->features)): ?>
                <tr>
                    <td>مميزات إضافية</td>
                    <?php foreach ($plans as $plan): ?>
                    <td style="text-align: center; font-size: 0.85em;">
                        <?php
                        if (!empty($plan->features)) {
                            $arr = json_decode($plan->features, true);
                            if (is_array($arr)) echo htmlspecialchars(implode(', ', $arr));
                            else echo '-';
                        } else {
                            echo '-';
                        }
                        ?>
                    </td>
                    <?php endforeach; ?>
                </tr>
                <?php endif; ?>
                <tr style="background: var(--light, #f8fafc); font-weight: 600; font-size: 1.1em;">
                    <td>السعر الشهري</td>
                    <?php foreach ($plans as $plan): ?>
                    <td style="text-align: center; color: var(--primary, #4f46e5);">
                        <?= number_format((float)($plan->price_monthly ?? 0), 0) ?> <?= htmlspecialchars($plan->currency ?? 'SAR') ?>
                    </td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

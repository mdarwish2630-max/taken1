<?php
/**
 * Admin - Paid Services Store Management
 * إدارة الخدمات المدفوعة
 */

$categoryLabels = [
    'domains'   => 'النطاقات',
    'features'  => 'ميزات إضافية',
    'marketing' => 'التسويق',
    'content'   => 'المحتوى',
    'design'    => 'التصميم',
    'support'   => 'الدعم',
    'general'   => 'عامة',
];

$categoryColors = [
    'domains'   => '#6366f1',
    'features'  => '#8b5cf6',
    'marketing' => '#ec4899',
    'content'   => '#f59e0b',
    'design'    => '#10b981',
    'support'   => '#3b82f6',
    'general'   => '#64748b',
];

$categoryIcons = [
    'domains'   => 'fas fa-globe',
    'features'  => 'fas fa-puzzle-piece',
    'marketing' => 'fas fa-bullhorn',
    'content'   => 'fas fa-file-alt',
    'design'    => 'fas fa-palette',
    'support'   => 'fas fa-headset',
    'general'   => 'fas fa-cube',
];

$totalServices  = count($services);
$totalRevenue   = 0;
$pendingCount   = 0;
foreach ($services as $s) {
    $totalRevenue += ($s->price ?? 0) * ($s->purchases_count ?? 0);
    if (isset($s->pending_purchases)) {
        $pendingCount += $s->pending_purchases;
    }
}
?>

<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--dark); margin: 0;">
            <i class="fas fa-store" style="color: var(--primary); margin-left: 0.5rem;"></i>
            الخدمات المدفوعة
        </h1>
        <p style="font-size: 0.875rem; color: #64748b; margin: 0.25rem 0 0 0;">إدارة جميع الخدمات المدفوعة المتاحة في المتجر</p>
    </div>
    <div class="header-actions">
        <a href="<?= url('/admin/services-store/add') ?>" class="btn btn-primary"
           style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.625rem 1.25rem; background: var(--primary); color: var(--white); border: none; border-radius: var(--radius); font-size: 0.875rem; font-weight: 600; cursor: pointer; text-decoration: none; transition: var(--transition);">
            <i class="fas fa-plus"></i>
            إضافة خدمة جديدة
        </a>
    </div>
</div>

<?php if (Session::has('success')): ?>
<div style="padding: 0.75rem 1rem; background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: var(--radius); color: #065f46; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
    <i class="fas fa-check-circle" style="color: var(--success);"></i>
    <?= Session::getSuccess() ?>
</div>
<?php endif; ?>

<?php if (Session::has('error')): ?>
<div style="padding: 0.75rem 1rem; background: #fef2f2; border: 1px solid #fecaca; border-radius: var(--radius); color: #991b1b; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
    <i class="fas fa-exclamation-circle" style="color: var(--danger);"></i>
    <?= Session::getError() ?>
</div>
<?php endif; ?>

<!-- Stats Row -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
    <!-- Total Services -->
    <div style="background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); padding: 1.25rem; display: flex; align-items: center; gap: 1rem; box-shadow: var(--shadow);">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #6366f1, #8b5cf6); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <i class="fas fa-boxes-stacked" style="color: #fff; font-size: 1.25rem;"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; color: #64748b; font-weight: 500; margin-bottom: 0.125rem;">إجمالي الخدمات</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: var(--dark);"><?= $totalServices ?></div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div style="background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); padding: 1.25rem; display: flex; align-items: center; gap: 1rem; box-shadow: var(--shadow);">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <i class="fas fa-coins" style="color: #fff; font-size: 1.25rem;"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; color: #64748b; font-weight: 500; margin-bottom: 0.125rem;">إجمالي الإيرادات</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: var(--success);"><?= number_format($totalRevenue, 0) ?> <span style="font-size: 0.875rem; font-weight: 500; color: #64748b;">ر.س</span></div>
        </div>
    </div>

    <!-- Pending Purchases -->
    <div style="background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); padding: 1.25rem; display: flex; align-items: center; gap: 1rem; box-shadow: var(--shadow);">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #f59e0b, #d97706); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <i class="fas fa-clock" style="color: #fff; font-size: 1.25rem;"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; color: #64748b; font-weight: 500; margin-bottom: 0.125rem;">طلبات معلقة</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: var(--warning);"><?= $pendingCount ?></div>
        </div>
    </div>
</div>

<!-- Services Table -->
<div class="card" style="background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden;">
    <div style="padding: 1rem 1.25rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem;">
        <h3 style="font-size: 1rem; font-weight: 600; color: var(--dark); margin: 0;">
            <i class="fas fa-list" style="color: var(--primary); margin-left: 0.5rem;"></i>
            قائمة الخدمات
        </h3>
        <span style="font-size: 0.8rem; color: #64748b; background: var(--light); padding: 0.25rem 0.75rem; border-radius: 50px;"><?= $totalServices ?> خدمة</span>
    </div>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: var(--light);">
                    <th style="padding: 0.875rem 1rem; text-align: right; font-size: 0.75rem; font-weight: 600; color: #64748b; text-transform: uppercase; border-bottom: 1px solid var(--border); white-space: nowrap;">الخدمة</th>
                    <th style="padding: 0.875rem 1rem; text-align: right; font-size: 0.75rem; font-weight: 600; color: #64748b; text-transform: uppercase; border-bottom: 1px solid var(--border); white-space: nowrap;">الفئة</th>
                    <th style="padding: 0.875rem 1rem; text-align: right; font-size: 0.75rem; font-weight: 600; color: #64748b; text-transform: uppercase; border-bottom: 1px solid var(--border); white-space: nowrap;">السعر</th>
                    <th style="padding: 0.875rem 1rem; text-align: right; font-size: 0.75rem; font-weight: 600; color: #64748b; text-transform: uppercase; border-bottom: 1px solid var(--border); white-space: nowrap;">الاشتراك</th>
                    <th style="padding: 0.875rem 1rem; text-align: right; font-size: 0.75rem; font-weight: 600; color: #64748b; text-transform: uppercase; border-bottom: 1px solid var(--border); white-space: nowrap;">المشتريات</th>
                    <th style="padding: 0.875rem 1rem; text-align: right; font-size: 0.75rem; font-weight: 600; color: #64748b; text-transform: uppercase; border-bottom: 1px solid var(--border); white-space: nowrap;">الحالة</th>
                    <th style="padding: 0.875rem 1rem; text-align: center; font-size: 0.75rem; font-weight: 600; color: #64748b; text-transform: uppercase; border-bottom: 1px solid var(--border); white-space: nowrap;">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $svc): ?>
                <?php
                    $catKey   = $svc->category ?? 'general';
                    $catLabel = $categoryLabels[$catKey] ?? $catKey;
                    $catColor = $categoryColors[$catKey] ?? '#64748b';
                    $catIcon  = $categoryIcons[$catKey] ?? 'fas fa-cube';
                    $svcIcon  = $svc->icon ?? $catIcon;
                ?>
                <tr style="border-bottom: 1px solid var(--border); transition: background 0.15s ease;"
                    onmouseenter="this.style.background='var(--light)'" onmouseleave="this.style.background='transparent'">
                    <!-- Service Info -->
                    <td style="padding: 1rem; vertical-align: middle;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 42px; height: 42px; border-radius: 10px; background: <?= $catColor ?>15; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="<?= $svcIcon ?>" style="color: <?= $catColor ?>; font-size: 1rem;"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--dark); font-size: 0.9rem;"><?= $this->e($svc->title) ?></div>
                                <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.125rem;"><?= $this->e($svc->slug ?? '') ?></div>
                            </div>
                        </div>
                    </td>

                    <!-- Category -->
                    <td style="padding: 1rem; vertical-align: middle;">
                        <span style="display: inline-flex; align-items: center; gap: 0.375rem; font-size: 0.8rem; font-weight: 500; color: <?= $catColor ?>; background: <?= $catColor ?>10; padding: 0.25rem 0.75rem; border-radius: 50px;">
                            <i class="<?= $catIcon ?>" style="font-size: 0.7rem;"></i>
                            <?= $catLabel ?>
                        </span>
                    </td>

                    <!-- Price -->
                    <td style="padding: 1rem; vertical-align: middle;">
                        <div style="font-weight: 700; color: var(--primary); font-size: 0.95rem;">
                            <?= number_format($svc->price ?? 0, 0) ?>
                            <span style="font-size: 0.75rem; font-weight: 500; color: #64748b; margin-right: 0.125rem;"><?= $svc->currency ?? 'SAR' ?></span>
                        </div>
                    </td>

                    <!-- Recurring -->
                    <td style="padding: 1rem; vertical-align: middle;">
                        <?php if (!empty($svc->is_recurring) && $svc->recurring_period !== 'onetime'): ?>
                            <?php
                                $periodLabels = [
                                    'monthly' => 'شهري',
                                    'yearly'  => 'سنوي',
                                ];
                                $periodLabel = $periodLabels[$svc->recurring_period] ?? $svc->recurring_period;
                                $periodIcon  = ($svc->recurring_period === 'yearly') ? 'fas fa-calendar-alt' : 'fas fa-sync-alt';
                            ?>
                            <span style="display: inline-flex; align-items: center; gap: 0.375rem; font-size: 0.8rem; color: #6366f1; background: #eef2ff; padding: 0.25rem 0.625rem; border-radius: 50px;">
                                <i class="<?= $periodIcon ?>" style="font-size: 0.7rem;"></i>
                                <?= $periodLabel ?>
                            </span>
                        <?php else: ?>
                            <span style="font-size: 0.8rem; color: #94a3b8; display: inline-flex; align-items: center; gap: 0.25rem;">
                                <i class="fas fa-shopping-cart" style="font-size: 0.7rem;"></i>
                                لمرة واحدة
                            </span>
                        <?php endif; ?>
                    </td>

                    <!-- Purchases Count -->
                    <td style="padding: 1rem; vertical-align: middle;">
                        <span style="display: inline-flex; align-items: center; justify-content: center; min-width: 32px; height: 28px; font-size: 0.8rem; font-weight: 600; color: var(--primary); background: var(--primary); color: var(--white); border-radius: 6px; padding: 0 0.5rem;">
                            <?= $svc->purchases_count ?? 0 ?>
                        </span>
                    </td>

                    <!-- Status -->
                    <td style="padding: 1rem; vertical-align: middle;">
                        <?php if (!empty($svc->is_active)): ?>
                            <span style="display: inline-flex; align-items: center; gap: 0.375rem; font-size: 0.8rem; font-weight: 500; color: #065f46; background: #ecfdf5; padding: 0.25rem 0.75rem; border-radius: 50px;">
                                <span style="width: 6px; height: 6px; border-radius: 50%; background: #10b981; display: inline-block;"></span>
                                نشط
                            </span>
                        <?php else: ?>
                            <span style="display: inline-flex; align-items: center; gap: 0.375rem; font-size: 0.8rem; font-weight: 500; color: #991b1b; background: #fef2f2; padding: 0.25rem 0.75rem; border-radius: 50px;">
                                <span style="width: 6px; height: 6px; border-radius: 50%; background: #ef4444; display: inline-block;"></span>
                                غير نشط
                            </span>
                        <?php endif; ?>
                    </td>

                    <!-- Actions -->
                    <td style="padding: 1rem; vertical-align: middle; text-align: center;">
                        <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                            <a href="<?= url('/admin/services-store/edit/' . $svc->id) ?>"
                               title="تعديل"
                               style="width: 34px; height: 34px; border-radius: 8px; border: 1px solid var(--border); background: var(--white); display: inline-flex; align-items: center; justify-content: center; color: #6366f1; text-decoration: none; transition: var(--transition); cursor: pointer;"
                               onmouseenter="this.style.background='#eef2ff';this.style.borderColor='#6366f1'"
                               onmouseleave="this.style.background='var(--white)';this.style.borderColor='var(--border)'">
                                <i class="fas fa-pen-to-square" style="font-size: 0.8rem;"></i>
                            </a>
                            <form method="POST" action="<?= url('/admin/services-store/delete/' . $svc->id) ?>" style="display:inline;" onsubmit="if(!confirm('هل أنت متأكد من حذف هذه الخدمة؟ لا يمكن التراجع عن هذا الإجراء.')) return false;">
                                <input type="hidden" name="csrf_token" value="<?= \Security::csrfToken() ?>">
                                <button type="submit" title="حذف"
                                   style="width: 34px; height: 34px; border-radius: 8px; border: 1px solid var(--border); background: var(--white); display: inline-flex; align-items: center; justify-content: center; color: var(--danger); transition: var(--transition); cursor: pointer;"
                                   onmouseenter="this.style.background='#fef2f2';this.style.borderColor='#ef4444'"
                                   onmouseleave="this.style.background='var(--white)';this.style.borderColor='var(--border)'">
                                    <i class="fas fa-trash-can" style="font-size: 0.8rem;"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>

                <?php if (empty($services)): ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 3rem 1rem; color: #94a3b8;">
                        <i class="fas fa-box-open" style="font-size: 2.5rem; margin-bottom: 0.75rem; display: block; color: #cbd5e1;"></i>
                        <div style="font-size: 0.95rem; font-weight: 500; color: #64748b; margin-bottom: 0.25rem;">لا توجد خدمات حالياً</div>
                        <div style="font-size: 0.8rem; color: #94a3b8;">أضف خدمة جديدة للبدء في عرضها في المتجر</div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

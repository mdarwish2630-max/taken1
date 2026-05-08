<?php
/**
 * My Purchases View
 * صفحة مشترياتي - لوحة تحكم العميل
 */

$tenant = $tenant ?? Auth::tenant();

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
    'features'  => '#3b82f6',
    'marketing' => '#f59e0b',
    'content'   => '#8b5cf6',
    'design'    => '#ec4899',
    'support'   => '#10b981',
    'general'   => '#64748b',
];

$statusConfig = [
    'active'    => ['label' => 'نشطة',      'color' => '#166534', 'bg' => '#dcfce7', 'border' => '#bbf7d0', 'icon' => 'fa-check-circle'],
    'pending'   => ['label' => 'معلّقة',     'color' => '#92400e', 'bg' => '#fef3c7', 'border' => '#fde68a', 'icon' => 'fa-clock'],
    'expired'   => ['label' => 'منتهية',     'color' => '#991b1b', 'bg' => '#fee2e2', 'border' => '#fecaca', 'icon' => 'fa-times-circle'],
    'cancelled' => ['label' => 'ملغاة',      'color' => '#7f1d1d', 'bg' => '#fee2e2', 'border' => '#fecaca', 'icon' => 'fa-ban'],
];

$activeCount   = count($grouped['active'] ?? []);
$pendingCount  = count($grouped['pending'] ?? []);
$totalSpent    = 0;
foreach ($purchases as $p) {
    if (in_array($p->status, ['paid', 'approved'])) {
        $totalSpent += ($p->amount * ($p->quantity ?? 1));
    }
}

$sectionOrder = ['active', 'pending', 'expired', 'cancelled'];
$sectionTitles = [
    'active'    => ['title' => 'الخدمات النشطة',    'icon' => 'fa-check-circle',  'desc' => 'الخدمات المفعّلة قيد الاستخدام'],
    'pending'   => ['title' => 'بانتظار المراجعة',   'icon' => 'fa-hourglass-half','desc' => 'طلبات قيد المراجعة من الإدارة'],
    'expired'   => ['title' => 'خدمات منتهية',       'icon' => 'fa-history',       'desc' => 'خدمات انتهت صلاحيتها'],
    'cancelled' => ['title' => 'خدمات ملغاة',        'icon' => 'fa-ban',           'desc' => 'طلبات تم إلغاؤها'],
];
?>

<!-- Page Header -->
<div style="margin-bottom: 28px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;">
        <div style="display: flex; align-items: center; gap: 14px;">
            <div style="width: 46px; height: 46px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); border-radius: var(--radius); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: var(--white); flex-shrink: 0;">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div>
                <h1 style="font-size: 1.55rem; font-weight: 700; color: var(--dark); margin: 0;">مشترياتي</h1>
                <p style="margin: 0; color: var(--secondary); font-size: 0.88rem;">عرض وإدارة جميع مشترياتك</p>
            </div>
        </div>
        <a href="<?= url('/dashboard/services-store') ?>" style="background: var(--white); color: var(--primary); border: 1px solid var(--border); padding: 9px 18px; border-radius: var(--radius); font-size: 0.86rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 7px; transition: var(--transition); box-shadow: var(--shadow);" onmouseover="this.style.borderColor='var(--primary)';this.style.background='var(--light)'" onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--white)'">
            <i class="fas fa-arrow-right"></i>
            متجر الخدمات
        </a>
    </div>
</div>

<!-- Stats Row -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 30px;">
    <!-- Active Count -->
    <div style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border: 1px solid #a7f3d0; border-radius: var(--radius); padding: 20px; display: flex; align-items: center; gap: 14px;">
        <div style="width: 44px; height: 44px; background: var(--success); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--white); font-size: 1.1rem; flex-shrink: 0;">
            <i class="fas fa-check-circle"></i>
        </div>
        <div>
            <div style="font-size: 0.78rem; color: #065f46; font-weight: 600; margin-bottom: 2px;">خدمات نشطة</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #065f46;"><?= $activeCount ?></div>
        </div>
    </div>
    <!-- Pending Count -->
    <div style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border: 1px solid #fde68a; border-radius: var(--radius); padding: 20px; display: flex; align-items: center; gap: 14px;">
        <div style="width: 44px; height: 44px; background: var(--warning); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--white); font-size: 1.1rem; flex-shrink: 0;">
            <i class="fas fa-clock"></i>
        </div>
        <div>
            <div style="font-size: 0.78rem; color: #92400e; font-weight: 600; margin-bottom: 2px;">بانتظار المراجعة</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #92400e;"><?= $pendingCount ?></div>
        </div>
    </div>
    <!-- Total Spent -->
    <div style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border: 1px solid #93c5fd; border-radius: var(--radius); padding: 20px; display: flex; align-items: center; gap: 14px;">
        <div style="width: 44px; height: 44px; background: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--white); font-size: 1.1rem; flex-shrink: 0;">
            <i class="fas fa-wallet"></i>
        </div>
        <div>
            <div style="font-size: 0.78rem; color: #1e40af; font-weight: 600; margin-bottom: 2px;">إجمالي المصروف</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #1e40af;"><?= number_format($totalSpent, 0) ?> <span style="font-size: 0.85rem; font-weight: 600;">ر.س</span></div>
        </div>
    </div>
</div>

<?php if (empty($purchases)): ?>
    <!-- Empty State -->
    <div style="background: var(--white); border-radius: var(--radius); box-shadow: var(--shadow); padding: 60px 20px; text-align: center;">
        <i class="fas fa-shopping-bag" style="font-size: 3rem; color: var(--border); margin-bottom: 16px; display: block;"></i>
        <h3 style="color: var(--dark); margin-bottom: 8px;">لا توجد مشتريات بعد</h3>
        <p style="color: var(--secondary); font-size: 0.92rem; margin-bottom: 20px;">لم تقم بشراء أي خدمات حتى الآن</p>
        <a href="<?= url('/dashboard/services-store') ?>" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: var(--white); padding: 10px 24px; border-radius: var(--radius); font-size: 0.9rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: var(--transition);" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
            <i class="fas fa-store"></i>
            تصفح المتجر
        </a>
    </div>
<?php else: ?>

    <?php foreach ($sectionOrder as $statusKey):
        $sectionPurchases = $grouped[$statusKey] ?? [];
        if (empty($sectionPurchases)) continue;
        $cfg = $statusConfig[$statusKey];
        $secInfo = $sectionTitles[$statusKey];
    ?>
        <!-- Section: <?= $secInfo['title'] ?> -->
        <div style="margin-bottom: 30px;">
            <!-- Section Heading -->
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 14px; padding-bottom: 10px; border-bottom: 2px solid var(--border);">
                <div style="width: 32px; height: 32px; background: <?= $cfg['bg'] ?>; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: <?= $cfg['color'] ?>; font-size: 0.85rem; flex-shrink: 0;">
                    <i class="fas <?= $secInfo['icon'] ?>"></i>
                </div>
                <h2 style="font-size: 1.05rem; font-weight: 700; color: var(--dark); margin: 0;"><?= $secInfo['title'] ?></h2>
                <span style="background: <?= $cfg['bg'] ?>; color: <?= $cfg['color'] ?>; font-size: 0.72rem; padding: 2px 10px; border-radius: 20px; font-weight: 700;"><?= count($sectionPurchases) ?></span>
                <span style="font-size: 0.8rem; color: var(--secondary); margin-right: auto;"><?= $secInfo['desc'] ?></span>
            </div>

            <!-- Purchases Cards -->
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 14px;">

                <?php foreach ($sectionPurchases as $purchase):
                    $catColor = $categoryColors[$purchase->category] ?? '#64748b';
                    $catLabel = $categoryLabels[$purchase->category] ?? $purchase->category;
                    $isActive = ($statusKey === 'active');
                ?>
                    <!-- Purchase Card -->
                    <div style="background: var(--white); border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden; transition: transform 0.2s ease, box-shadow 0.2s ease; <?= $isActive ? 'border: 2px solid #bbf7d0;' : 'border: 1px solid var(--border);' ?>" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(0,0,0,0.08)'" onmouseout="this.style.transform='';this.style.boxShadow='var(--shadow)'">
                        
                        <!-- Card Body -->
                        <div style="padding: 18px 20px;">
                            <div style="display: flex; align-items: flex-start; gap: 14px;">
                                <!-- Icon -->
                                <div style="width: 46px; height: 46px; min-width: 46px; background: <?= $catColor ?>15; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; color: <?= $catColor ?>;">
                                    <i class="fas <?= $purchase->service_icon ?: 'fa-cube' ?>"></i>
                                </div>
                                <!-- Info -->
                                <div style="flex: 1; min-width: 0;">
                                    <!-- Title + Status Badge -->
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-bottom: 6px; flex-wrap: wrap;">
                                        <h4 style="font-size: 0.98rem; font-weight: 700; color: var(--dark); margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">
                                            <?= htmlspecialchars($purchase->service_title) ?>
                                        </h4>
                                        <!-- Status Badge -->
                                        <span style="display: inline-flex; align-items: center; gap: 4px; background: <?= $cfg['bg'] ?>; color: <?= $cfg['color'] ?>; font-size: 0.72rem; padding: 4px 10px; border-radius: 6px; font-weight: 700; white-space: nowrap;">
                                            <i class="fas <?= $cfg['icon'] ?>" style="font-size: 0.65rem;"></i>
                                            <?= $cfg['label'] ?>
                                        </span>
                                    </div>

                                    <!-- Meta Row -->
                                    <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap; font-size: 0.8rem; color: var(--secondary); margin-bottom: 4px;">
                                        <!-- Category -->
                                        <span style="display: inline-flex; align-items: center; gap: 4px;">
                                            <span style="width: 7px; height: 7px; background: <?= $catColor ?>; border-radius: 50%; display: inline-block;"></span>
                                            <?= $catLabel ?>
                                        </span>
                                        <!-- Amount -->
                                        <span style="font-weight: 700; color: var(--dark);">
                                            <?= number_format($purchase->amount, 0) ?> ر.س
                                            <?php if (($purchase->quantity ?? 1) > 1): ?>
                                                <span style="font-weight: 400; color: var(--secondary);">× <?= $purchase->quantity ?></span>
                                            <?php endif; ?>
                                        </span>
                                    </div>

                                    <!-- Date -->
                                    <div style="font-size: 0.76rem; color: var(--secondary); display: flex; align-items: center; gap: 5px; margin-top: 2px;">
                                        <i class="fas fa-calendar-alt" style="font-size: 0.68rem;"></i>
                                        <?= date('Y/m/d', strtotime($purchase->created_at)) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Pending Message -->
                            <?php if ($statusKey === 'pending'): ?>
                                <div style="margin-top: 14px; background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 10px 14px; display: flex; align-items: center; gap: 8px;">
                                    <i class="fas fa-hourglass-half" style="color: #d97706; font-size: 0.9rem;"></i>
                                    <span style="font-size: 0.8rem; color: #92400e; font-weight: 600;">بانتظار مراجعة الإدارة — سيتم إشعارك عند الموافقة أو الرفض</span>
                                </div>
                            <?php endif; ?>

                            <!-- Cancelled/Rejected Message with Admin Notes -->
                            <?php if ($statusKey === 'cancelled' && !empty($purchase->admin_notes)): ?>
                                <div style="margin-top: 14px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 10px 14px;">
                                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                                        <i class="fas fa-info-circle" style="color: #dc2626; font-size: 0.85rem;"></i>
                                        <span style="font-size: 0.8rem; color: #991b1b; font-weight: 700;">سبب الرفض:</span>
                                    </div>
                                    <p style="margin: 0; font-size: 0.82rem; color: #7f1d1d; line-height: 1.6;"><?= htmlspecialchars($purchase->admin_notes) ?></p>
                                </div>
                            <?php endif; ?>

                            <!-- Approved with Admin Notes -->
                            <?php if ($isActive && !empty($purchase->admin_notes)): ?>
                                <div style="margin-top: 14px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 10px 14px;">
                                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                                        <i class="fas fa-sticky-note" style="color: #16a34a; font-size: 0.8rem;"></i>
                                        <span style="font-size: 0.78rem; color: #166534; font-weight: 600;">ملاحظة الإدارة:</span>
                                    </div>
                                    <p style="margin: 0; font-size: 0.8rem; color: #14532d; line-height: 1.5;"><?= htmlspecialchars($purchase->admin_notes) ?></p>
                                </div>
                            <?php endif; ?>

                            <!-- Expiry Date for Active/Recurring -->
                            <?php if ($isActive && $purchase->expires_at): ?>
                                <div style="margin-top: 14px; background: var(--light); border-radius: 8px; padding: 10px 14px; display: flex; align-items: center; justify-content: space-between;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-calendar-check" style="color: var(--primary); font-size: 0.85rem;"></i>
                                        <span style="font-size: 0.8rem; color: var(--secondary);">
                                            تاريخ الانتهاء
                                        </span>
                                    </div>
                                    <span style="font-size: 0.82rem; font-weight: 700; color: var(--dark);">
                                        <?= date('Y/m/d', strtotime($purchase->expires_at)) ?>
                                    </span>
                                </div>
                            <?php endif; ?>

                            <!-- Expired Note -->
                            <?php if ($statusKey === 'expired'): ?>
                                <div style="margin-top: 14px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 10px 14px; display: flex; align-items: center; gap: 8px;">
                                    <i class="fas fa-info-circle" style="color: #dc2626; font-size: 0.85rem;"></i>
                                    <span style="font-size: 0.8rem; color: #991b1b; font-weight: 600;">انتهت صلاحية هذه الخدمة في <?= date('Y/m/d', strtotime($purchase->expires_at)) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    <?php endforeach; ?>

<?php endif; ?>

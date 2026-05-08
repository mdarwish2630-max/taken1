<?php
/**
 * Admin Purchases View
 * إدارة المشتريات - لوحة المدير
 */

$statusConfig = [
    'pending'   => ['label' => 'معلّق',  'color' => 'var(--warning)',  'bg' => 'rgba(234, 179, 8, 0.12)',  'icon' => 'fas fa-clock'],
    'paid'      => ['label' => 'مدفوع',  'color' => 'var(--success)', 'bg' => 'rgba(34, 197, 94, 0.12)',  'icon' => 'fas fa-check-circle'],
    'approved'  => ['label' => 'معتمد',  'color' => 'var(--success)', 'bg' => 'rgba(34, 197, 94, 0.12)',  'icon' => 'fas fa-badge-check'],
    'cancelled' => ['label' => 'ملغي',   'color' => 'var(--danger)',  'bg' => 'rgba(239, 68, 68, 0.12)',  'icon' => 'fas fa-times-circle'],
    'refunded'  => ['label' => 'مسترد',  'color' => '#3b82f6',       'bg' => 'rgba(59, 130, 246, 0.12)', 'icon' => 'fas fa-undo'],
    'expired'   => ['label' => 'منتهي',  'color' => 'var(--secondary)','bg' => 'rgba(100, 116, 139, 0.12)','icon' => 'fas fa-hourglass-end'],
];

$statsCards = [
    [
        'key'   => 'total',
        'label' => 'إجمالي المشتريات',
        'icon'  => 'fas fa-shopping-cart',
        'value' => $stats->total_purchases ?? 0,
        'color' => 'var(--primary)',
        'bg'    => 'rgba(var(--primary), 0.08)',
    ],
    [
        'key'   => 'revenue',
        'label' => 'إجمالي الإيرادات',
        'icon'  => 'fas fa-coins',
        'value' => ($stats->total_revenue ?? 0) . ' ر.س',
        'color' => 'var(--success)',
        'bg'    => 'rgba(34, 197, 94, 0.08)',
    ],
    [
        'key'   => 'pending',
        'label' => 'قيد الانتظار',
        'icon'  => 'fas fa-hourglass-half',
        'value' => $stats->pending_count ?? 0,
        'color' => 'var(--warning)',
        'bg'    => 'rgba(234, 179, 8, 0.08)',
    ],
    [
        'key'   => 'completed',
        'label' => 'مكتمل',
        'icon'  => 'fas fa-check-double',
        'value' => $stats->completed_count ?? 0,
        'color' => 'var(--success)',
        'bg'    => 'rgba(34, 197, 94, 0.08)',
    ],
    [
        'key'   => 'cancelled',
        'label' => 'ملغي',
        'icon'  => 'fas fa-ban',
        'value' => $stats->cancelled_count ?? 0,
        'color' => 'var(--danger)',
        'bg'    => 'rgba(239, 68, 68, 0.08)',
    ],
];

$filterTabs = [
    ''           => ['label' => 'الكل',     'icon' => 'fas fa-border-all'],
    'pending'    => ['label' => 'معلّق',    'icon' => 'fas fa-clock'],
    'approved'   => ['label' => 'مكتمل',    'icon' => 'fas fa-check-circle'],
    'cancelled'  => ['label' => 'ملغي',     'icon' => 'fas fa-times-circle'],
];
?>

<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-shopping-bag"></i>
        إدارة المشتريات
    </h1>
</div>

<?php if (Session::has('success')): ?>
<div style="
    background: rgba(34, 197, 94, 0.08);
    border: 1px solid rgba(34, 197, 94, 0.2);
    border-radius: var(--radius);
    padding: 0.875rem 1.25rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.625rem;
    color: var(--success);
    font-size: 0.9rem;
">
    <i class="fas fa-check-circle"></i>
    <?= Session::getSuccess() ?>
</div>
<?php endif; ?>

<?php if (Session::has('error')): ?>
<div style="
    background: rgba(239, 68, 68, 0.08);
    border: 1px solid rgba(239, 68, 68, 0.2);
    border-radius: var(--radius);
    padding: 0.875rem 1.25rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.625rem;
    color: var(--danger);
    font-size: 0.9rem;
">
    <i class="fas fa-exclamation-circle"></i>
    <?= Session::getError() ?>
</div>
<?php endif; ?>

<!-- Stats Cards -->
<div style="
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
">
    <?php foreach ($statsCards as $card): ?>
    <div style="
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: var(--shadow);
        transition: transform var(--transition), box-shadow var(--transition);
    ">
        <div style="
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: <?= $card['bg'] ?>;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        ">
            <i class="<?= $card['icon'] ?>" style="color: <?= $card['color'] ?>; font-size: 1.2rem;"></i>
        </div>
        <div>
            <div style="font-size: 0.8rem; color: var(--secondary); margin-bottom: 0.25rem;"><?= $card['label'] ?></div>
            <div style="font-size: 1.35rem; font-weight: 700; color: var(--dark);"><?= $card['value'] ?></div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Filter Tabs -->
<div style="
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 0.5rem;
    margin-bottom: 1.5rem;
    display: flex;
    gap: 0.375rem;
    box-shadow: var(--shadow);
    flex-wrap: wrap;
">
    <?php foreach ($filterTabs as $status => $tab): ?>
    <?php $isActive = ($currentStatus ?? null) === $status; ?>
    <a href="<?= url('/admin/purchases') ?><?= $status !== '' ? '?status=' . $status : '' ?>"
       style="
           display: inline-flex;
           align-items: center;
           gap: 0.5rem;
           padding: 0.625rem 1.25rem;
           border-radius: calc(var(--radius) - 2px);
           font-size: 0.875rem;
           font-weight: 500;
           text-decoration: none;
           transition: all var(--transition);
           <?= $isActive ? '
               background: var(--primary);
               color: var(--white);
               box-shadow: 0 2px 8px rgba(var(--primary), 0.3);
           ' : '
               background: transparent;
               color: var(--secondary);
           ' ?>
       "
       <?= !$isActive ? 'onmouseover="this.style.background=\'var(--light)\'" onmouseout="this.style.background=\'transparent\'"' : '' ?>
    >
        <i class="<?= $tab['icon'] ?>" style="font-size: 0.8rem;"></i>
        <?= $tab['label'] ?>
    </a>
    <?php endforeach; ?>
</div>

<!-- Purchases Table -->
<div style="
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
            <thead>
                <tr style="background: var(--light);">
                    <th style="padding: 1rem 1.25rem; text-align: right; font-weight: 600; color: var(--dark); white-space: nowrap; border-bottom: 2px solid var(--border);">#</th>
                    <th style="padding: 1rem 1.25rem; text-align: right; font-weight: 600; color: var(--dark); white-space: nowrap; border-bottom: 2px solid var(--border);">
                        <i class="fas fa-user" style="margin-left: 0.375rem; color: var(--secondary);"></i>
                        العميل
                    </th>
                    <th style="padding: 1rem 1.25rem; text-align: right; font-weight: 600; color: var(--dark); white-space: nowrap; border-bottom: 2px solid var(--border);">
                        <i class="fas fa-globe" style="margin-left: 0.375rem; color: var(--secondary);"></i>
                        الموقع
                    </th>
                    <th style="padding: 1rem 1.25rem; text-align: right; font-weight: 600; color: var(--dark); white-space: nowrap; border-bottom: 2px solid var(--border);">
                        <i class="fas fa-concierge-bell" style="margin-left: 0.375rem; color: var(--secondary);"></i>
                        الخدمة
                    </th>
                    <th style="padding: 1rem 1.25rem; text-align: right; font-weight: 600; color: var(--dark); white-space: nowrap; border-bottom: 2px solid var(--border);">
                        <i class="fas fa-money-bill-wave" style="margin-left: 0.375rem; color: var(--secondary);"></i>
                        المبلغ
                    </th>
                    <th style="padding: 1rem 1.25rem; text-align: right; font-weight: 600; color: var(--dark); white-space: nowrap; border-bottom: 2px solid var(--border);">
                        <i class="fas fa-tag" style="margin-left: 0.375rem; color: var(--secondary);"></i>
                        الحالة
                    </th>
                    <th style="padding: 1rem 1.25rem; text-align: right; font-weight: 600; color: var(--dark); white-space: nowrap; border-bottom: 2px solid var(--border);">
                        <i class="fas fa-calendar-alt" style="margin-left: 0.375rem; color: var(--secondary);"></i>
                        التاريخ
                    </th>
                    <th style="padding: 1rem 1.25rem; text-align: center; font-weight: 600; color: var(--dark); white-space: nowrap; border-bottom: 2px solid var(--border);">
                        <i class="fas fa-cogs" style="margin-left: 0.375rem; color: var(--secondary);"></i>
                        الإجراءات
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($purchases)): ?>
                <tr>
                    <td colspan="8" style="text-align: center; padding: 3rem 1rem;">
                        <i class="fas fa-inbox" style="font-size: 2.5rem; color: var(--border); display: block; margin-bottom: 1rem;"></i>
                        <p style="color: var(--secondary); margin: 0; font-size: 0.95rem;">لا توجد مشتريات حالياً</p>
                    </td>
                </tr>
                <?php else: ?>
                <?php $counter = 1; ?>
                <?php foreach ($purchases as $purchase):
                    $pStatus  = $purchase->status ?? 'pending';
                    $sConfig  = $statusConfig[$pStatus] ?? $statusConfig['pending'];
                    $isPending = ($pStatus === 'pending');
                    $purchaseId = $purchase->id;
                ?>
                <tr style="
                    border-bottom: 1px solid var(--border);
                    transition: background var(--transition);
                " onmouseover="this.style.background='var(--light)'" onmouseout="this.style.background='transparent'">
                    <!-- # -->
                    <td style="padding: 0.875rem 1.25rem; color: var(--secondary); font-weight: 500;"><?= $counter++ ?></td>

                    <!-- Customer Name -->
                    <td style="padding: 0.875rem 1.25rem;">
                        <div style="display: flex; align-items: center; gap: 0.625rem;">
                            <div style="
                                width: 34px;
                                height: 34px;
                                border-radius: 50%;
                                background: linear-gradient(135deg, var(--primary), var(--primary-dark));
                                color: var(--white);
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                font-size: 0.8rem;
                                font-weight: 700;
                                flex-shrink: 0;
                            ">
                                <?= mb_substr($purchase->customer_name ?? '?', 0, 1) ?>
                            </div>
                            <span style="font-weight: 600; color: var(--dark);"><?= $this->e($purchase->customer_name ?? '-') ?></span>
                        </div>
                    </td>

                    <!-- Site Name -->
                    <td style="padding: 0.875rem 1.25rem;">
                        <?php if (!empty($purchase->site_name)): ?>
                        <span style="color: var(--dark);"><?= $this->e($purchase->site_name) ?></span>
                        <?php else: ?>
                        <span style="color: var(--border);">—</span>
                        <?php endif; ?>
                    </td>

                    <!-- Service Name -->
                    <td style="padding: 0.875rem 1.25rem;">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-cube" style="color: var(--primary); font-size: 0.85rem;"></i>
                            <span style="color: var(--dark);"><?= $this->e($purchase->service_title ?? '-') ?></span>
                        </div>
                    </td>

                    <!-- Amount -->
                    <td style="padding: 0.875rem 1.25rem;">
                        <span style="font-weight: 700; color: var(--dark);"><?= number_format($purchase->amount ?? 0, 2) ?></span>
                        <span style="color: var(--secondary); font-size: 0.8rem;"> ر.س</span>
                    </td>

                    <!-- Status Badge -->
                    <td style="padding: 0.875rem 1.25rem;">
                        <span style="
                            display: inline-flex;
                            align-items: center;
                            gap: 0.375rem;
                            padding: 0.3rem 0.75rem;
                            border-radius: 50px;
                            font-size: 0.8rem;
                            font-weight: 600;
                            background: <?= $sConfig['bg'] ?>;
                            color: <?= $sConfig['color'] ?>;
                        ">
                            <i class="<?= $sConfig['icon'] ?>" style="font-size: 0.7rem;"></i>
                            <?= $sConfig['label'] ?>
                        </span>
                        <?php if (!empty($purchase->admin_notes) && !$isPending): ?>
                        <div style="margin-top: 6px; font-size: 0.72rem; color: var(--secondary); max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= htmlspecialchars($purchase->admin_notes) ?>">
                            <i class="fas fa-sticky-note" style="margin-left: 3px;"></i>
                            <?= htmlspecialchars($purchase->admin_notes) ?>
                        </div>
                        <?php endif; ?>
                    </td>

                    <!-- Date -->
                    <td style="padding: 0.875rem 1.25rem;">
                        <span style="color: var(--secondary); font-size: 0.85rem;">
                            <?= isset($purchase->created_at) ? date('Y-m-d', strtotime($purchase->created_at)) : '-' ?>
                        </span>
                    </td>

                    <!-- Actions -->
                    <td style="padding: 0.875rem 1.25rem; text-align: center;">
                        <?php if ($isPending): ?>
                        <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                            <!-- Approve Button -->
                            <button type="button"
                                    onclick="openModal('approveModal<?= $purchaseId ?>')"
                                    style="
                                        display: inline-flex;
                                        align-items: center;
                                        gap: 0.375rem;
                                        padding: 0.4rem 0.875rem;
                                        border: none;
                                        border-radius: var(--radius);
                                        background: var(--success);
                                        color: var(--white);
                                        font-size: 0.8rem;
                                        font-weight: 600;
                                        cursor: pointer;
                                        transition: opacity var(--transition), transform var(--transition);
                                    "
                                    onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'"
                                    title="اعتماد">
                                <i class="fas fa-check"></i>
                                اعتماد
                            </button>

                            <!-- Reject Button -->
                            <button type="button"
                                    onclick="openModal('rejectModal<?= $purchaseId ?>')"
                                    style="
                                        display: inline-flex;
                                        align-items: center;
                                        gap: 0.375rem;
                                        padding: 0.4rem 0.875rem;
                                        border: none;
                                        border-radius: var(--radius);
                                        background: var(--danger);
                                        color: var(--white);
                                        font-size: 0.8rem;
                                        font-weight: 600;
                                        cursor: pointer;
                                        transition: opacity var(--transition), transform var(--transition);
                                    "
                                    onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'"
                                    title="رفض">
                                <i class="fas fa-times"></i>
                                رفض
                            </button>
                        </div>
                        <?php else: ?>
                        <span style="
                            display: inline-flex;
                            align-items: center;
                            gap: 0.375rem;
                            padding: 0.3rem 0.75rem;
                            border-radius: 50px;
                            font-size: 0.8rem;
                            font-weight: 600;
                            background: <?= $sConfig['bg'] ?>;
                            color: <?= $sConfig['color'] ?>;
                        ">
                            <i class="<?= $sConfig['icon'] ?>" style="font-size: 0.7rem;"></i>
                            <?= $sConfig['label'] ?>
                        </span>
                        <?php endif; ?>
                    </td>
                </tr>

                <!-- ========== Approve Modal ========== -->
                <?php if ($isPending): ?>
                <div id="approveModal<?= $purchaseId ?>" style="
                    display: none;
                    position: fixed;
                    top: 0; left: 0; right: 0; bottom: 0;
                    background: rgba(0, 0, 0, 0.5);
                    z-index: 9999;
                    align-items: center;
                    justify-content: center;
                    backdrop-filter: blur(4px);
                ">
                    <div style="
                        background: var(--white);
                        border-radius: var(--radius);
                        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
                        width: 100%;
                        max-width: 440px;
                        margin: 1rem;
                        overflow: hidden;
                    ">
                        <!-- Modal Header -->
                        <div style="
                            padding: 1.25rem 1.5rem;
                            background: linear-gradient(135deg, var(--success), #16a34a);
                            color: var(--white);
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                        ">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="
                                    width: 36px; height: 36px;
                                    border-radius: 50%;
                                    background: rgba(255,255,255,0.2);
                                    display: flex; align-items: center; justify-content: center;
                                ">
                                    <i class="fas fa-check-circle" style="font-size: 1rem;"></i>
                                </div>
                                <div>
                                    <div style="font-weight: 700; font-size: 1rem;">اعتماد المشتريّة</div>
                                    <div style="font-size: 0.8rem; opacity: 0.9;"><?= $this->e($purchase->customer_name ?? '') ?> — <?= $this->e($purchase->service_title ?? '') ?></div>
                                </div>
                            </div>
                            <button type="button" onclick="closeModal('approveModal<?= $purchaseId ?>')" style="
                                background: rgba(255,255,255,0.2);
                                border: none;
                                color: var(--white);
                                width: 32px; height: 32px;
                                border-radius: 50%;
                                cursor: pointer;
                                display: flex; align-items: center; justify-content: center;
                                font-size: 1rem;
                                transition: background var(--transition);
                            " onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <form method="POST" action="<?= url('/admin/purchases/approve/' . $purchaseId) ?>">
                            <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
                            <div style="padding: 1.5rem;">
                                <label style="
                                    display: block;
                                    font-size: 0.875rem;
                                    font-weight: 600;
                                    color: var(--dark);
                                    margin-bottom: 0.5rem;
                                ">
                                    <i class="fas fa-sticky-note" style="margin-left: 0.375rem; color: var(--primary);"></i>
                                    ملاحظات الإدارة <span style="color: var(--secondary); font-weight: 400;">(اختياري)</span>
                                </label>
                                <textarea name="admin_notes" rows="3" placeholder="أضف ملاحظات حول اعتماد هذه المشتريّة..." style="
                                    width: 100%;
                                    padding: 0.75rem 1rem;
                                    border: 1px solid var(--border);
                                    border-radius: var(--radius);
                                    font-family: inherit;
                                    font-size: 0.875rem;
                                    color: var(--dark);
                                    background: var(--white);
                                    resize: vertical;
                                    transition: border-color var(--transition);
                                    box-sizing: border-box;
                                    direction: rtl;
                                " onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'"></textarea>
                            </div>

                            <!-- Modal Footer -->
                            <div style="
                                padding: 0.75rem 1.5rem 1.5rem;
                                display: flex;
                                gap: 0.75rem;
                                justify-content: flex-start;
                            ">
                                <button type="submit" style="
                                    display: inline-flex;
                                    align-items: center;
                                    gap: 0.5rem;
                                    padding: 0.625rem 1.5rem;
                                    border: none;
                                    border-radius: var(--radius);
                                    background: var(--success);
                                    color: var(--white);
                                    font-size: 0.875rem;
                                    font-weight: 600;
                                    cursor: pointer;
                                    transition: opacity var(--transition);
                                " onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                                    <i class="fas fa-check"></i>
                                    تأكيد الاعتماد
                                </button>
                                <button type="button" onclick="closeModal('approveModal<?= $purchaseId ?>')" style="
                                    display: inline-flex;
                                    align-items: center;
                                    gap: 0.5rem;
                                    padding: 0.625rem 1.5rem;
                                    border: 1px solid var(--border);
                                    border-radius: var(--radius);
                                    background: var(--white);
                                    color: var(--secondary);
                                    font-size: 0.875rem;
                                    font-weight: 500;
                                    cursor: pointer;
                                    transition: background var(--transition);
                                " onmouseover="this.style.background='var(--light)'" onmouseout="this.style.background='var(--white)'">
                                    <i class="fas fa-arrow-right"></i>
                                    إلغاء
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endif; ?>

                <!-- ========== Reject Modal ========== -->
                <?php if ($isPending): ?>
                <div id="rejectModal<?= $purchaseId ?>" style="
                    display: none;
                    position: fixed;
                    top: 0; left: 0; right: 0; bottom: 0;
                    background: rgba(0, 0, 0, 0.5);
                    z-index: 9999;
                    align-items: center;
                    justify-content: center;
                    backdrop-filter: blur(4px);
                ">
                    <div style="
                        background: var(--white);
                        border-radius: var(--radius);
                        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
                        width: 100%;
                        max-width: 440px;
                        margin: 1rem;
                        overflow: hidden;
                    ">
                        <!-- Modal Header -->
                        <div style="
                            padding: 1.25rem 1.5rem;
                            background: linear-gradient(135deg, var(--danger), #dc2626);
                            color: var(--white);
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                        ">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="
                                    width: 36px; height: 36px;
                                    border-radius: 50%;
                                    background: rgba(255,255,255,0.2);
                                    display: flex; align-items: center; justify-content: center;
                                ">
                                    <i class="fas fa-times-circle" style="font-size: 1rem;"></i>
                                </div>
                                <div>
                                    <div style="font-weight: 700; font-size: 1rem;">رفض المشتريّة</div>
                                    <div style="font-size: 0.8rem; opacity: 0.9;"><?= $this->e($purchase->customer_name ?? '') ?> — <?= $this->e($purchase->service_title ?? '') ?></div>
                                </div>
                            </div>
                            <button type="button" onclick="closeModal('rejectModal<?= $purchaseId ?>')" style="
                                background: rgba(255,255,255,0.2);
                                border: none;
                                color: var(--white);
                                width: 32px; height: 32px;
                                border-radius: 50%;
                                cursor: pointer;
                                display: flex; align-items: center; justify-content: center;
                                font-size: 1rem;
                                transition: background var(--transition);
                            " onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <form method="POST" action="<?= url('/admin/purchases/reject/' . $purchaseId) ?>">
                            <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
                            <div style="padding: 1.5rem;">
                                <label style="
                                    display: block;
                                    font-size: 0.875rem;
                                    font-weight: 600;
                                    color: var(--dark);
                                    margin-bottom: 0.5rem;
                                ">
                                    <i class="fas fa-sticky-note" style="margin-left: 0.375rem; color: var(--danger);"></i>
                                    سبب الرفض <span style="color: var(--danger); font-weight: 400;">*</span>
                                </label>
                                <textarea name="admin_notes" rows="3" required placeholder="اكتب سبب رفض هذه المشتريّة..." style="
                                    width: 100%;
                                    padding: 0.75rem 1rem;
                                    border: 1px solid var(--border);
                                    border-radius: var(--radius);
                                    font-family: inherit;
                                    font-size: 0.875rem;
                                    color: var(--dark);
                                    background: var(--white);
                                    resize: vertical;
                                    transition: border-color var(--transition);
                                    box-sizing: border-box;
                                    direction: rtl;
                                " onfocus="this.style.borderColor='var(--danger)'" onblur="this.style.borderColor='var(--border)'"></textarea>
                                <p style="font-size: 0.75rem; color: var(--secondary); margin: 0.375rem 0 0;">
                                    <i class="fas fa-info-circle" style="margin-left: 0.25rem;"></i>
                                    سيتم إشعار العميل بسبب الرفض
                                </p>
                            </div>

                            <!-- Modal Footer -->
                            <div style="
                                padding: 0.75rem 1.5rem 1.5rem;
                                display: flex;
                                gap: 0.75rem;
                                justify-content: flex-start;
                            ">
                                <button type="submit" style="
                                    display: inline-flex;
                                    align-items: center;
                                    gap: 0.5rem;
                                    padding: 0.625rem 1.5rem;
                                    border: none;
                                    border-radius: var(--radius);
                                    background: var(--danger);
                                    color: var(--white);
                                    font-size: 0.875rem;
                                    font-weight: 600;
                                    cursor: pointer;
                                    transition: opacity var(--transition);
                                " onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                                    <i class="fas fa-times"></i>
                                    تأكيد الرفض
                                </button>
                                <button type="button" onclick="closeModal('rejectModal<?= $purchaseId ?>')" style="
                                    display: inline-flex;
                                    align-items: center;
                                    gap: 0.5rem;
                                    padding: 0.625rem 1.5rem;
                                    border: 1px solid var(--border);
                                    border-radius: var(--radius);
                                    background: var(--white);
                                    color: var(--secondary);
                                    font-size: 0.875rem;
                                    font-weight: 500;
                                    cursor: pointer;
                                    transition: background var(--transition);
                                " onmouseover="this.style.background='var(--light)'" onmouseout="this.style.background='var(--white)'">
                                    <i class="fas fa-arrow-right"></i>
                                    إلغاء
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endif; ?>

                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if (!empty($pagination) && ($pagination['last_page'] ?? 1) > 1): ?>
    <div style="
        display: flex;
        justify-content: center;
        padding: 1.25rem;
        border-top: 1px solid var(--border);
    ">
        <nav>
            <ul class="pagination">
                <?php
                $currentPage = $pagination['current_page'] ?? 1;
                $lastPage    = $pagination['last_page'] ?? 1;
                $statusParam = ($currentStatus ?? '') ? '&status=' . urlencode($currentStatus) : '';
                ?>
                <?php if ($currentPage > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $currentPage - 1 ?><?= $statusParam ?>">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
                <?php endif; ?>

                <?php
                $start = max(1, $currentPage - 2);
                $end   = min($lastPage, $currentPage + 2);
                if ($start > 1): ?>
                <li class="page-item"><a class="page-link" href="?page=1<?= $statusParam ?>">1</a></li>
                <?php if ($start > 2): ?><li class="page-item disabled"><span class="page-link">...</span></li><?php endif; ?>
                <?php endif; ?>

                <?php for ($i = $start; $i <= $end; $i++): ?>
                <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?><?= $statusParam ?>"><?= $i ?></a>
                </li>
                <?php endfor; ?>

                <?php if ($end < $lastPage - 1): ?><li class="page-item disabled"><span class="page-link">...</span></li><?php endif; ?>
                <?php if ($end < $lastPage): ?>
                <li class="page-item"><a class="page-link" href="?page=<?= $lastPage ?><?= $statusParam ?>"><?= $lastPage ?></a></li>
                <?php endif; ?>

                <?php if ($currentPage < $lastPage): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $currentPage + 1 ?><?= $statusParam ?>">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    <?php endif; ?>
</div>

<!-- Modal JavaScript -->
<script>
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
}

// Close modal on backdrop click
document.addEventListener('click', function(e) {
    if (e.target.style.position === 'fixed' && e.target.style.zIndex === '9999') {
        e.target.style.display = 'none';
        document.body.style.overflow = '';
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('[style*="z-index: 9999"]').forEach(function(modal) {
            if (modal.style.display === 'flex') {
                modal.style.display = 'none';
            }
        });
        document.body.style.overflow = '';
    }
});
</script>

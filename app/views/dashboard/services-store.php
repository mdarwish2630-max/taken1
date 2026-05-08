<?php
/**
 * Services Store View
 * صفحة متجر الخدمات - لوحة تحكم العميل
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

$categoryIcons = [
    'domains'   => 'fa-globe',
    'features'  => 'fa-puzzle-piece',
    'marketing' => 'fa-bullhorn',
    'content'   => 'fa-pen-fancy',
    'design'    => 'fa-palette',
    'support'   => 'fa-headset',
    'general'   => 'fa-store',
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

$periodLabels = [
    'monthly' => 'شهرياً',
    'yearly'  => 'سنوياً',
];
?>

<!-- Page Header -->
<div style="margin-bottom: 28px;">
    <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 6px;">
        <div style="width: 46px; height: 46px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); border-radius: var(--radius); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: var(--white); flex-shrink: 0;">
            <i class="fas fa-store"></i>
        </div>
        <div>
            <h1 style="font-size: 1.55rem; font-weight: 700; color: var(--dark); margin: 0;">متجر الخدمات</h1>
            <p style="margin: 0; color: var(--secondary); font-size: 0.88rem;">إضافة خدمات وميزات إضافية لموقعك</p>
        </div>
    </div>
</div>

<?php if (!empty($myPurchases)): ?>
    <!-- Active Purchases Bar -->
    <div style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border: 1px solid #a7f3d0; border-radius: var(--radius); padding: 14px 20px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-check-circle" style="color: var(--success); font-size: 1.15rem;"></i>
            <span style="color: #065f46; font-weight: 600; font-size: 0.92rem;">
                لديك <?= count($myPurchases) ?> خدمة نشطة
            </span>
        </div>
        <a href="<?= url('/dashboard/my-purchases') ?>" style="background: var(--success); color: var(--white); padding: 7px 18px; border-radius: var(--radius); font-size: 0.84rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: var(--transition);">
            <i class="fas fa-shopping-bag"></i>
            مشترياتي
        </a>
    </div>
<?php endif; ?>

<?php if (empty($services)): ?>
    <!-- Empty State -->
    <div style="background: var(--white); border-radius: var(--radius); box-shadow: var(--shadow); padding: 60px 20px; text-align: center;">
        <i class="fas fa-store-slash" style="font-size: 3rem; color: var(--secondary); margin-bottom: 16px; display: block;"></i>
        <h3 style="color: var(--dark); margin-bottom: 8px;">لا توجد خدمات متاحة حالياً</h3>
        <p style="color: var(--secondary); font-size: 0.92rem;">سيتم إضافة خدمات جديدة قريباً، تابعنا!</p>
    </div>
<?php else: ?>

    <?php foreach ($services as $category => $categoryServices): ?>
        <!-- Category Section -->
        <div style="margin-bottom: 32px;">
            <!-- Category Heading -->
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid var(--border);">
                <div style="width: 34px; height: 34px; background: <?= $categoryColors[$category] ?? '#64748b' ?>; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--white); font-size: 0.9rem; flex-shrink: 0;">
                    <i class="fas <?= $categoryIcons[$category] ?? 'fa-layer-group' ?>"></i>
                </div>
                <h2 style="font-size: 1.15rem; font-weight: 700; color: var(--dark); margin: 0;">
                    <?= $categoryLabels[$category] ?? $category ?>
                </h2>
                <span style="background: var(--light); color: var(--secondary); font-size: 0.75rem; padding: 3px 10px; border-radius: 20px; font-weight: 600;">
                    <?= count($categoryServices) ?> خدمة
                </span>
            </div>

            <!-- Services Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 18px;">

                <?php foreach ($categoryServices as $service):
                    $isPurchased = isset($purchasedIds[$service->id]);
                    $currentCount = $purchasedCounts[$service->id] ?? 0;
                    $canBuyMore = !$isPurchased || ($service->max_quantity && $currentCount < $service->max_quantity);
                    $isMaxed = $isPurchased && $service->max_quantity && $currentCount >= $service->max_quantity;
                ?>
                    <!-- Service Card -->
                    <div style="background: var(--white); border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden; transition: transform 0.25s ease, box-shadow 0.25s ease; display: flex; flex-direction: column; <?= $isPurchased && !$isMaxed ? 'border: 1px solid #bbf7d0;' : ($isMaxed ? 'border: 1px solid var(--border); opacity: 0.85;' : 'border: 1px solid transparent;') ?>" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 28px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='';this.style.boxShadow='var(--shadow)'">
                        
                        <!-- Card Top: Icon + Info -->
                        <div style="padding: 22px 20px 14px; flex: 1;">
                            <div style="display: flex; align-items: flex-start; gap: 14px; margin-bottom: 14px;">
                                <!-- Icon -->
                                <div style="width: 50px; height: 50px; min-width: 50px; background: <?= $categoryColors[$category] ?? '#64748b' ?>15; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: <?= $categoryColors[$category] ?? '#64748b' ?>;">
                                    <i class="fas <?= $service->icon ?: 'fa-cube' ?>"></i>
                                </div>
                                <!-- Title & Description -->
                                <div style="flex: 1; min-width: 0;">
                                    <h3 style="font-size: 1.02rem; font-weight: 700; color: var(--dark); margin: 0 0 6px; line-height: 1.4;">
                                        <?= htmlspecialchars($service->title) ?>
                                    </h3>
                                    <?php if ($service->description): ?>
                                        <p style="margin: 0; color: var(--secondary); font-size: 0.82rem; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                            <?= htmlspecialchars($service->description) ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Info Badge: All purchases need admin approval -->
                            <div style="display: inline-flex; align-items: center; gap: 5px; background: #eff6ff; color: #1e40af; font-size: 0.76rem; padding: 4px 10px; border-radius: 6px; font-weight: 600; margin-bottom: 12px;">
                                <i class="fas fa-shield-alt" style="font-size: 0.7rem;"></i>
                                جميع الطلبات تخضع لمراجعة الإدارة
                            </div>

                            <!-- Max Quantity Info -->
                            <?php if ($service->max_quantity && $service->max_quantity > 1): ?>
                                <div style="font-size: 0.76rem; color: var(--secondary); margin-bottom: 8px;">
                                    <i class="fas fa-layer-group" style="margin-left: 4px;"></i>
                                    الحد الأقصى: <?= $service->max_quantity ?>
                                    <?php if ($isPurchased): ?>
                                        (مُشترى: <?= $currentCount ?>/<?= $service->max_quantity ?>)
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Card Bottom: Price + Action -->
                        <div style="padding: 16px 20px; background: var(--light); border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 12px;">
                            <!-- Price -->
                            <div>
                                <?php if ($service->price > 0): ?>
                                    <div style="display: flex; align-items: baseline; gap: 4px;">
                                        <span style="font-size: 1.35rem; font-weight: 800; color: var(--primary);"><?= number_format($service->price, 0) ?></span>
                                        <span style="font-size: 0.82rem; color: var(--secondary); font-weight: 600;">ر.س</span>
                                    </div>
                                    <div style="font-size: 0.74rem; color: var(--secondary); margin-top: 2px;">
                                        <?php if ($service->is_recurring && $service->recurring_period): ?>
                                            <?= $periodLabels[$service->recurring_period] ?? $service->recurring_period ?>
                                        <?php else: ?>
                                            مرة واحدة
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <div style="font-size: 1.1rem; font-weight: 700; color: var(--success);">مجاني</div>
                                <?php endif; ?>
                            </div>

                            <!-- Action -->
                            <div>
                                <?php if ($isPurchased && !$isMaxed && $service->max_quantity <= 1): ?>
                                    <!-- Purchased Badge -->
                                    <span style="display: inline-flex; align-items: center; gap: 5px; background: #dcfce7; color: #166534; font-size: 0.82rem; padding: 8px 16px; border-radius: var(--radius); font-weight: 700;">
                                        <i class="fas fa-check-circle"></i>
                                        مفعّل ✓
                                    </span>
                                <?php elseif ($isMaxed): ?>
                                    <!-- Maxed Badge -->
                                    <span style="display: inline-flex; align-items: center; gap: 5px; background: var(--light); color: var(--secondary); font-size: 0.82rem; padding: 8px 16px; border-radius: var(--radius); font-weight: 600;">
                                        <i class="fas fa-ban"></i>
                                        الحد الأقصى
                                    </span>
                                <?php elseif ($canBuyMore): ?>
                                    <!-- Buy Button -->
                                    <form method="POST" action="<?= url('/dashboard/services-store/purchase/' . $service->id) ?>" style="margin: 0;">
                                        <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
                                        <button type="submit" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: var(--white); border: none; padding: 9px 20px; border-radius: var(--radius); font-size: 0.84rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: var(--transition); font-family: inherit;" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                                            <i class="fas <?= $service->payment_link ? 'fa-credit-card' : 'fa-cart-plus' ?>"></i>
                                            <?= $service->payment_link ? 'طلب ودفع' : 'إرسال طلب' ?>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    <?php endforeach; ?>

<?php endif; ?>

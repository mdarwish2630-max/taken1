<?php
/**
 * Admin Site Detail View
 * تفاصيل الموقع - لوحة المدير
 */

?>

<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <a href="<?= url('/admin/sites') ?>" class="btn btn-outline mb-2" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-arrow-right"></i>
                <?= lang('back') ?? 'رجوع' ?>
            </a>
            <h1 class="page-title">
                <i class="fas fa-globe"></i>
                <?= $this->e($tenant->site_name) ?>
            </h1>
        </div>
        <div>
            <a href="<?= url('/' . $tenant->slug) ?>" target="_blank" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-external-link-alt"></i>
                <?= lang('view_site') ?? 'عرض الموقع' ?>
            </a>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; flex-wrap: wrap;">
    <div>
        <!-- Site Info Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i>
                    <?= lang('site_info') ?? 'معلومات الموقع' ?>
                </h3>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <label style="color: #94a3b8;"><?= lang('site_name') ?? 'اسم الموقع' ?></label>
                        <p style="font-weight: bold; margin: 0.25rem 0 0;"><?= $this->e($tenant->site_name) ?></p>
                    </div>
                    <div>
                        <label style="color: #94a3b8;"><?= lang('slug') ?? 'المعرف' ?></label>
                        <p style="font-weight: bold; margin: 0.25rem 0 0;">
                            <a href="<?= url('/' . $tenant->slug) ?>" target="_blank"><?= $this->e($tenant->slug) ?></a>
                        </p>
                    </div>
                    <div>
                        <label style="color: #94a3b8;"><?= lang('created_at') ?? 'تاريخ الإنشاء' ?></label>
                        <p style="font-weight: bold; margin: 0.25rem 0 0;"><?= date('Y-m-d', strtotime($tenant->created_at)) ?></p>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
                    <div>
                        <label style="color: #94a3b8;"><?= lang('site_status') ?? 'حالة الموقع' ?></label>
                        <p style="margin: 0.25rem 0 0;">
                            <span class="badge <?= ($tenant->site_status ?? '') === 'published' ? 'badge-success' : 'badge-warning' ?>">
                                <?= lang($tenant->site_status ?? '') ?? $this->e($tenant->site_status ?? '') ?>
                            </span>
                        </p>
                    </div>
                    <div>
                        <label style="color: #94a3b8;"><?= lang('subscription_status') ?? 'حالة الاشتراك' ?></label>
                        <p style="margin: 0.25rem 0 0;">
                            <?php 
                            $statusClasses = [
                                'trial' => 'badge-info',
                                'active' => 'badge-success', 
                                'expired' => 'badge-danger',
                                'suspended' => 'badge-warning'
                            ];
                            ?>
                            <span class="badge <?= $statusClasses[$tenant->subscription_status ?? ''] ?? 'badge-secondary' ?>">
                                <?= lang($tenant->subscription_status ?? '') ?? $this->e($tenant->subscription_status ?? '') ?>
                            </span>
                        </p>
                    </div>
                    <div>
                        <label style="color: #94a3b8;"><?= lang('theme') ?? 'القالب' ?></label>
                        <p style="margin: 0.25rem 0 0;">
                            <?php if (!empty($tenant->theme_id)): ?>
                            <span class="badge badge-info"><?= lang('theme') ?? 'القالب' ?> #<?= $tenant->theme_id ?></span>
                            <?php else: ?>
                            <span class="badge badge-secondary"><?= lang('default') ?? 'افتراضي' ?></span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subscription Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-credit-card"></i>
                    <?= lang('subscription_info') ?? 'معلومات الاشتراك' ?>
                </h3>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <label style="color: #94a3b8;"><?= lang('trial_ends') ?? 'نهاية التجربة' ?></label>
                        <p style="font-weight: bold; margin: 0.25rem 0 0;">
                            <?= !empty($tenant->trial_ends_at) ? date('Y-m-d', strtotime($tenant->trial_ends_at)) : '-' ?>
                        </p>
                    </div>
                    <div>
                        <label style="color: #94a3b8;"><?= lang('subscription_start') ?? 'بداية الاشتراك' ?></label>
                        <p style="font-weight: bold; margin: 0.25rem 0 0;">
                            <?= !empty($tenant->subscription_start) ? date('Y-m-d', strtotime($tenant->subscription_start)) : '-' ?>
                        </p>
                    </div>
                    <div>
                        <label style="color: #94a3b8;"><?= lang('subscription_end') ?? 'نهاية الاشتراك' ?></label>
                        <p style="font-weight: bold; margin: 0.25rem 0 0;">
                            <?= !empty($tenant->subscription_end) ? date('Y-m-d', strtotime($tenant->subscription_end)) : '-' ?>
                        </p>
                    </div>
                </div>

                <!-- Renew Subscription -->
                <div style="border-top: 1px solid var(--border, #e2e8f0); padding-top: 1.5rem; margin-top: 1rem;">
                    <h4 style="font-size: 0.875rem; color: #94a3b8; margin-bottom: 1rem;"><?= lang('renew_subscription') ?? 'تجديد الاشتراك' ?></h4>
                    <form method="POST" action="<?= url('/admin/sites/renew/' . $tenant->id) ?>">
                        <?= $this->csrf() ?>
                        <div style="display: flex; gap: 0.75rem; align-items: center;">
                            <select name="months" class="form-control" style="width: auto;">
                                <option value="1"><?= lang('1_month') ?? 'شهر واحد' ?></option>
                                <option value="3"><?= lang('3_months') ?? '3 أشهر' ?></option>
                                <option value="6"><?= lang('6_months') ?? '6 أشهر' ?></option>
                                <option value="12"><?= lang('12_months') ?? '12 شهر' ?></option>
                            </select>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sync"></i>
                                <?= lang('renew') ?? 'تجديد' ?>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Change Status -->
                <div style="border-top: 1px solid var(--border, #e2e8f0); padding-top: 1.5rem; margin-top: 1.5rem;">
                    <h4 style="font-size: 0.875rem; color: #94a3b8; margin-bottom: 1rem;"><?= lang('change_status') ?? 'تغيير الحالة' ?></h4>
                    <form method="POST" action="<?= url('/admin/sites/status') ?>">
                        <?= $this->csrf() ?>
                        <input type="hidden" name="tenant_id" value="<?= $tenant->id ?>">
                        <div style="display: flex; gap: 0.75rem; align-items: center;">
                            <select name="status" class="form-control" style="width: auto;">
                                <option value="trial" <?= ($tenant->subscription_status ?? '') === 'trial' ? 'selected' : '' ?>><?= lang('trial') ?? 'فترة تجريبية' ?></option>
                                <option value="active" <?= ($tenant->subscription_status ?? '') === 'active' ? 'selected' : '' ?>><?= lang('active') ?? 'نشط' ?></option>
                                <option value="expired" <?= ($tenant->subscription_status ?? '') === 'expired' ? 'selected' : '' ?>><?= lang('expired') ?? 'منتهي' ?></option>
                                <option value="suspended" <?= ($tenant->subscription_status ?? '') === 'suspended' ? 'selected' : '' ?>><?= lang('suspended') ?? 'معلق' ?></option>
                            </select>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-edit"></i>
                                <?= lang('update') ?? 'تحديث' ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Stats Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar"></i>
                    <?= lang('statistics') ?? 'الإحصائيات' ?>
                </h3>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 1rem; text-align: center;">
                    <div>
                        <h3 style="color: var(--primary); margin: 0;"><?= $stats['services'] ?? 0 ?></h3>
                        <small style="color: #94a3b8;"><?= lang('services') ?? 'الخدمات' ?></small>
                    </div>
                    <div>
                        <h3 style="color: #10b981; margin: 0;"><?= $stats['gallery'] ?? 0 ?></h3>
                        <small style="color: #94a3b8;"><?= lang('gallery') ?? 'المعرض' ?></small>
                    </div>
                    <div>
                        <h3 style="color: #3b82f6; margin: 0;"><?= $stats['banners'] ?? 0 ?></h3>
                        <small style="color: #94a3b8;"><?= lang('banners') ?? 'البانرات' ?></small>
                    </div>
                    <div>
                        <h3 style="color: #f59e0b; margin: 0;"><?= $stats['testimonials'] ?? 0 ?></h3>
                        <small style="color: #94a3b8;"><?= lang('testimonials') ?? 'الشهادات' ?></small>
                    </div>
                    <div>
                        <h3 style="color: #ef4444; margin: 0;"><?= $stats['messages'] ?? 0 ?></h3>
                        <small style="color: #94a3b8;"><?= lang('messages') ?? 'الرسائل' ?></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div>
        <!-- Owner Info -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user"></i>
                    <?= lang('owner_info') ?? 'معلومات المالك' ?>
                </h3>
            </div>
            <div class="card-body">
                <?php if ($user): ?>
                <div style="text-align: center; margin-bottom: 1.5rem;">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: bold; margin: 0 auto;">
                        <?= mb_substr($user->full_name ?? $user->name ?? '?', 0, 1) ?>
                    </div>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="color: #94a3b8;"><?= lang('name') ?? 'الاسم' ?></label>
                    <p style="font-weight: bold; margin: 0.25rem 0 0;"><?= $this->e($user->full_name ?? $user->name ?? '') ?></p>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="color: #94a3b8;"><?= lang('email') ?? 'البريد الإلكتروني' ?></label>
                    <p style="font-weight: bold; margin: 0.25rem 0 0;">
                        <a href="mailto:<?= $this->e($user->email ?? '') ?>"><?= $this->e($user->email ?? '') ?></a>
                    </p>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="color: #94a3b8;"><?= lang('phone') ?? 'الهاتف' ?></label>
                    <p style="font-weight: bold; margin: 0.25rem 0 0;"><?= $this->e($user->phone ?? '-') ?></p>
                </div>
                <div>
                    <label style="color: #94a3b8;"><?= lang('registered') ?? 'التسجيل' ?></label>
                    <p style="font-weight: bold; margin: 0.25rem 0 0;"><?= date('Y-m-d', strtotime($user->created_at)) ?></p>
                </div>
                <?php else: ?>
                <p style="color: #94a3b8; text-align: center;"><?= lang('no_owner') ?? 'لا يوجد مالك' ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="card" style="margin-top: 1.5rem;">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-phone"></i>
                    <?= lang('contact_info') ?? 'معلومات التواصل' ?>
                </h3>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 1rem;">
                    <label style="color: #94a3b8;"><?= lang('email') ?? 'البريد الإلكتروني' ?></label>
                    <p style="font-weight: bold; margin: 0.25rem 0 0;"><?= $this->e($tenant->contact_email ?? '-') ?></p>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="color: #94a3b8;"><?= lang('phone') ?? 'الهاتف' ?></label>
                    <p style="font-weight: bold; margin: 0.25rem 0 0;"><?= $this->e($tenant->contact_phone ?? '-') ?></p>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="color: #94a3b8;"><?= lang('whatsapp') ?? 'واتساب' ?></label>
                    <p style="font-weight: bold; margin: 0.25rem 0 0;"><?= $this->e($tenant->contact_whatsapp ?? '-') ?></p>
                </div>
                <div>
                    <label style="color: #94a3b8;"><?= lang('address') ?? 'العنوان' ?></label>
                    <p style="font-weight: bold; margin: 0.25rem 0 0;"><?= $this->e($tenant->address ?? '-') ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

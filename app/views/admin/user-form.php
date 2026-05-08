<?php
/**
 * Admin - User Edit Form
 * نموذج تعديل بيانات المستخدم
 */

?>

<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-user-edit"></i>
        <?= lang('edit_user') ?? 'تعديل المستخدم' ?>
    </h1>
    <div class="page-actions">
        <a href="<?= url('/admin/users') ?>" class="btn btn-outline">
            <i class="fas fa-arrow-right"></i>
            <?= lang('back_to_users') ?? 'العودة للمستخدمين' ?>
        </a>
    </div>
</div>

<?php if (Session::has('error')): ?>
<div class="alert alert-danger">
    <i class="fas fa-exclamation-circle"></i>
    <?= Session::getError() ?>
</div>
<?php endif; ?>

<?php if (Session::has('success')): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    <?= Session::getSuccess() ?>
</div>
<?php endif; ?>

<form method="POST" action="<?= url('/admin/users/edit/' . $user->id) ?>">
    <?= $this->csrf() ?>

    <div class="d-flex gap-3" style="flex-wrap: wrap;">
        <!-- البيانات الأساسية -->
        <div class="card" style="flex: 2; min-width: 400px;">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user"></i>
                    <?= lang('user_info') ?? 'البيانات الأساسية' ?>
                </h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label"><?= lang('full_name') ?? 'الاسم الكامل' ?> *</label>
                    <input type="text" name="full_name" class="form-control"
                           value="<?= $this->e($user->full_name ?? $user->name ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label"><?= lang('email') ?? 'البريد الإلكتروني' ?> *</label>
                    <input type="email" name="email" class="form-control"
                           value="<?= $this->e($user->email ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label"><?= lang('phone') ?? 'رقم الهاتف' ?></label>
                    <input type="tel" name="phone" class="form-control"
                           value="<?= $this->e($user->phone ?? '') ?>"
                           placeholder="<?= lang('phone_placeholder') ?? '05xxxxxxxx' ?>">
                </div>

                <div class="d-flex gap-2">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label"><?= lang('role') ?? 'الدور' ?></label>
                        <select name="role" class="form-control">
                            <option value="customer" <?= ($user->role ?? '') === 'customer' ? 'selected' : '' ?>>
                                <?= lang('customer') ?? 'عميل (مستأجر)' ?>
                            </option>
                            <option value="admin" <?= ($user->role ?? '') === 'admin' ? 'selected' : '' ?>>
                                <?= lang('admin') ?? 'مدير' ?>
                            </option>
                        </select>
                    </div>

                    <div class="form-group" style="flex: 1;">
                        <label class="form-label"><?= lang('status') ?? 'الحالة' ?></label>
                        <select name="status" class="form-control">
                            <option value="active" <?= ($user->status ?? '') === 'active' ? 'selected' : '' ?>>
                                <?= lang('active') ?? 'نشط' ?>
                            </option>
                            <option value="inactive" <?= ($user->status ?? '') === 'inactive' ? 'selected' : '' ?>>
                                <?= lang('inactive') ?? 'غير نشط' ?>
                            </option>
                            <option value="suspended" <?= ($user->status ?? '') === 'suspended' ? 'selected' : '' ?>>
                                <?= lang('suspended') ?? 'معلق' ?>
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- تغيير كلمة المرور + معلومات إضافية -->
        <div style="flex: 1; min-width: 300px;">
            <!-- تغيير كلمة المرور -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-key"></i>
                        <?= lang('change_password') ?? 'تغيير كلمة المرور' ?>
                    </h3>
                </div>
                <div class="card-body">
                    <p style="color: #64748b; margin-bottom: 1rem; font-size: 0.875rem;">
                        <?= lang('password_hint') ?? 'اترك الحقول فارغة إذا لم ترد تغيير كلمة المرور' ?>
                    </p>

                    <div class="form-group">
                        <label class="form-label"><?= lang('new_password') ?? 'كلمة المرور الجديدة' ?></label>
                        <input type="password" name="new_password" class="form-control"
                               minlength="6" placeholder="<?= lang('min_6_chars') ?? '6 أحرف على الأقل' ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label"><?= lang('confirm_password') ?? 'تأكيد كلمة المرور' ?></label>
                        <input type="password" name="confirm_password" class="form-control"
                               minlength="6" placeholder="<?= lang('re_enter_password') ?? 'أعد إدخال كلمة المرور' ?>">
                    </div>
                </div>
            </div>

            <!-- معلومات التسجيل -->
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        <?= lang('account_info') ?? 'معلومات الحساب' ?>
                    </h3>
                </div>
                <div class="card-body">
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--border);">
                            <span style="color: #64748b;"><?= lang('user_id') ?? 'رقم المستخدم' ?></span>
                            <strong>#<?= $user->id ?></strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--border);">
                            <span style="color: #64748b;"><?= lang('registered') ?? 'تاريخ التسجيل' ?></span>
                            <strong><?= date('Y-m-d H:i', strtotime($user->created_at)) ?></strong>
                        </div>
                        <?php if (!empty($user->last_login)): ?>
                        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--border);">
                            <span style="color: #64748b;"><?= lang('last_login') ?? 'آخر دخول' ?></span>
                            <strong><?= date('Y-m-d H:i', strtotime($user->last_login)) ?></strong>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($user->email_verified)): ?>
                        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--border);">
                            <span style="color: #64748b;"><?= lang('email_verified') ?? 'تأكيد البريد' ?></span>
                            <span class="badge badge-success"><?= lang('verified') ?? 'مؤكد' ?></span>
                        </div>
                        <?php else: ?>
                        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--border);">
                            <span style="color: #64748b;"><?= lang('email_verified') ?? 'تأكيد البريد' ?></span>
                            <span class="badge badge-secondary"><?= lang('not_verified') ?? 'غير مؤكد' ?></span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php if ($tenant ?? null): ?>
                    <div style="margin-top: 1rem; padding: 0.75rem; background: var(--light); border-radius: var(--radius);">
                        <div style="font-weight: bold; margin-bottom: 0.5rem;">
                            <i class="fas fa-globe"></i>
                            <?= lang('linked_site') ?? 'الموقع المرتبط' ?>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.875rem;">
                            <div>
                                <span style="color: #64748b;"><?= lang('site_name') ?? 'اسم الموقع' ?>:</span>
                                <a href="<?= url('/' . ($tenant->slug ?? '')) ?>" target="_blank">
                                    <?= $this->e($tenant->site_name ?? '') ?>
                                </a>
                            </div>
                            <?php if (!empty($tenant->subscription_status)): ?>
                            <div>
                                <span style="color: #64748b;"><?= lang('subscription_status') ?? 'حالة الاشتراك' ?>:</span>
                                <span class="badge <?= in_array($tenant->subscription_status, ['active', 'trial']) ? 'badge-success' : 'badge-danger' ?>">
                                    <?= lang($tenant->subscription_status) ?? $this->e($tenant->subscription_status) ?>
                                </span>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($tenant->subscription_end)): ?>
                            <div>
                                <span style="color: #64748b;"><?= lang('subscription_end') ?? 'ينتهي في' ?>:</span>
                                <?= date('Y-m-d', strtotime($tenant->subscription_end)) ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i>
            <?= lang('save_changes') ?? 'حفظ التعديلات' ?>
        </button>
        <a href="<?= url('/admin/users') ?>" class="btn btn-outline">
            <?= lang('cancel') ?? 'إلغاء' ?>
        </a>
    </div>
</form>

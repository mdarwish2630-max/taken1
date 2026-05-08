<?php
/**
 * Admin Tenants List View (Legacy)
 * قائمة المواقع - لوحة المدير
 */

?>

<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-globe"></i>
        <?= lang('sites_management') ?? 'إدارة المواقع' ?>
    </h1>
</div>

<div class="card">
    <div class="card-body">
        <p style="color: #94a3b8; text-align: center; padding: 2rem;">
            <?= lang('manage_sites') ?? 'تم نقل إدارة المواقع إلى صفحة المواقع الرئيسية' ?>
            <br>
            <a href="<?= url('/admin/sites') ?>" class="btn btn-primary mt-3">
                <i class="fas fa-arrow-left"></i>
                <?= lang('go_to_sites') ?? 'الذهاب لإدارة المواقع' ?>
            </a>
        </p>
    </div>
</div>

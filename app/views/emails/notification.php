<!-- قالب: إشعار عام (للادمن) -->
<p style="font-size: 1.05rem;">مرحباً <strong style="color: #4f46e5;"><?= htmlspecialchars($user_name ?? 'المدير') ?></strong>،</p>

<div style="margin: 20px 0; padding: 20px; background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%); border-radius: 12px; border-right: 4px solid #4f46e5;">
    <p style="margin: 0; color: #1e40af; font-weight: 600; font-size: 1rem;">
        🔔 <?= htmlspecialchars($notification_title ?? 'إشعار جديد') ?>
    </p>
</div>

<?= $body ?? '' ?>

<div style="text-align: center; margin: 25px 0;">
    <a href="<?= fullUrl('/admin/purchases?status=pending') ?>" 
       style="display: inline-block; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: #ffffff; text-decoration: none; padding: 12px 32px; border-radius: 10px; font-weight: 700; font-size: 0.95rem;">
        📋 عرض الطلبات المعلقة
    </a>
</div>

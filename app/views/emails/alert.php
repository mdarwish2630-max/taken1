<!-- قالب: تنبيه (انتهاء اشتراك) -->
<p>مرحباً <strong style="color: #4f46e5;"><?= htmlspecialchars($user_name ?? '') ?></strong>،</p>

<div style="margin: 20px 0; padding: 20px; background: linear-gradient(135deg, #fef3c7 0%, #fef9c3 100%); border-radius: 12px; border-right: 4px solid #f59e0b;">
    <p style="margin: 0; color: #92400e; font-weight: 600;">
        ⚠️ تنبيه هام: انتهاء الاشتراك
    </p>
</div>

<?= $body ?? '' ?>

<?php if (!empty($show_button)): ?>
<div style="text-align: center; margin: 25px 0;">
    <a href="<?= $button_link ?? '' ?>" 
       style="display: inline-block; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #ffffff; text-decoration: none; padding: 14px 36px; border-radius: 10px; font-weight: 700; font-size: 1rem;">
        🔄 <?= $button_text ?? 'تجديد الاشتراك' ?>
    </a>
</div>
<?php endif; ?>

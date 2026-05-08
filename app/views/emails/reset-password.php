<!-- قالب: استعادة كلمة المرور -->
<p>مرحباً <strong style="color: #4f46e5;"><?= htmlspecialchars($user_name ?? '') ?></strong>،</p>

<div style="margin: 20px 0; padding: 20px; background: linear-gradient(135deg, #fef3c7 0%, #fef9c3 100%); border-radius: 12px; border-right: 4px solid #f59e0b;">
    <p style="margin: 0; color: #92400e; font-weight: 600;">
        🔑 طلب إعادة تعيين كلمة المرور
    </p>
</div>

<p>تلقينا طلباً لإعادة تعيين كلمة المرور لحسابك. اضغط على الزر أدناه لتعيين كلمة مرور جديدة:</p>

<div style="text-align: center; margin: 30px 0;">
    <a href="<?= $button_link ?? '' ?>" 
       style="display: inline-block; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #ffffff; text-decoration: none; padding: 14px 40px; border-radius: 10px; font-weight: 700; font-size: 1rem;">
        🔑 إعادة تعيين كلمة المرور
    </a>
</div>

<p style="font-size: 0.85rem; color: #94a3b8;">أو انسخ الرابط:</p>
<p style="font-size: 0.82rem; color: #64748b; word-break: break-all; background: #f1f5f9; padding: 8px 12px; border-radius: 6px;">
    <?= $button_link ?? '' ?>
</p>

<div style="margin-top: 25px; padding: 16px; background: #fef2f2; border-radius: 10px; border-right: 4px solid #ef4444;">
    <p style="margin: 0; color: #991b1b; font-size: 0.85rem;">
        ⏰ <strong>ملاحظة:</strong> هذا الرابط صالح لمدة <strong>ساعة واحدة</strong> فقط. إذا لم تكن أنت من طلب إعادة التعيين، يمكنك تجاهل هذا الإيميل بأمان.
    </p>
</div>

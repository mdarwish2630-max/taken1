<!-- قالب: تأكيد البريد الإلكتروني -->
<p>مرحباً <strong style="color: #4f46e5;"><?= htmlspecialchars($user_name ?? '') ?></strong>،</p>

<div style="margin: 20px 0; padding: 20px; background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%); border-radius: 12px; border-right: 4px solid #4f46e5;">
    <p style="margin: 0; color: #1e40af; font-weight: 600;">
        📧 يرجى تأكيد عنوان بريدك الإلكتروني
    </p>
</div>

<p>شكراً لتسجيلك في <?= SITE_NAME ?>. لإتمام عملية التسجيل، يرجى تأكيد بريدك الإلكتروني بالضغط على الزر أدناه:</p>

<div style="text-align: center; margin: 30px 0;">
    <a href="<?= $button_link ?? '' ?>" 
       style="display: inline-block; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: #ffffff; text-decoration: none; padding: 14px 40px; border-radius: 10px; font-weight: 700; font-size: 1rem; letter-spacing: 0.3px;">
        ✅ تأكيد البريد الإلكتروني
    </a>
</div>

<p style="font-size: 0.85rem; color: #94a3b8;">أو انسخ الرابط:</p>
<p style="font-size: 0.82rem; color: #64748b; word-break: break-all; background: #f1f5f9; padding: 8px 12px; border-radius: 6px;">
    <?= $button_link ?? '' ?>
</p>

<div style="margin-top: 30px; padding: 16px; background: #fef2f2; border-radius: 10px; border-right: 4px solid #ef4444;">
    <p style="margin: 0; color: #991b1b; font-size: 0.85rem;">
        ⏰ <strong>ملاحظة:</strong> هذا الرابط صالح لمدة 24 ساعة فقط. إذا انتهت صلاحيته، يمكنك طلب إرسال رابط جديد من صفحة تسجيل الدخول.
    </p>
</div>

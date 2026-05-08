<!-- قالب: رمز OTP -->
<p>مرحباً <strong style="color: #4f46e5;"><?= htmlspecialchars($user_name ?? '') ?></strong>،</p>

<div style="margin: 20px 0; padding: 20px; background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%); border-radius: 12px; border-right: 4px solid #4f46e5;">
    <p style="margin: 0; color: #1e40af; font-weight: 600;">
        🔐 رمز التحقق - <?= htmlspecialchars($otp_purpose ?? 'تسجيل الدخول') ?>
    </p>
</div>

<p>استخدم الرمز التالي لإتمام عملية التحقق:</p>

<div style="text-align: center; margin: 30px 0;">
    <div style="display: inline-block; background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); border: 2px dashed #94a3b8; border-radius: 16px; padding: 20px 50px; letter-spacing: 10px; font-size: 2.2rem; font-weight: 800; color: #1e293b; font-family: 'Courier New', monospace;">
        <?= htmlspecialchars($otp_code ?? '') ?>
    </div>
</div>

<div style="margin-top: 20px; padding: 16px; background: #fef2f2; border-radius: 10px; border-right: 4px solid #ef4444;">
    <p style="margin: 0; color: #991b1b; font-size: 0.85rem;">
        ⚠️ <strong>تنبيه:</strong> لا تشارك هذا الرمز مع أي شخص. إذا لم تكن أنت من طلبه، يمكنك تجاهل هذا الإيميل بأمان.
    </p>
</div>

<div style="margin-top: 16px; padding: 16px; background: #f0fdf4; border-radius: 10px; border-right: 4px solid #22c55e;">
    <p style="margin: 0; color: #166534; font-size: 0.85rem;">
        ⏱️ الرمز صالح لمدة <strong>10 دقائق</strong> فقط.
    </p>
</div>

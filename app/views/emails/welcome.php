<!-- قالب: ترحيب -->
<p style="font-size: 1.05rem;">مرحباً بك يا <strong style="color: #4f46e5;"><?= htmlspecialchars($user_name ?? '') ?></strong> 👋</p>

<div style="margin: 20px 0; padding: 20px; background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%); border-radius: 12px; border-right: 4px solid #4f46e5;">
    <p style="margin: 0; color: #1e40af; font-weight: 600; font-size: 1rem;">
        🎉 تم إنشاء حسابك بنجاح في <?= SITE_NAME ?>!
    </p>
</div>

<p>أهلاً بك في منصتنا! يمكنك الآن البدء بإنشاء موقعك الإلكتروني بسهولة وبسرعة.</p>

<?php if (!empty($show_verify_button)): ?>
<p style="color: #64748b;">لكي تتمكن من استخدام جميع الميزات، يرجى تأكيد عنوان بريدك الإلكتروني:</p>

<div style="text-align: center; margin: 25px 0;">
    <a href="<?= $button_link ?? '' ?>" 
       style="display: inline-block; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: #ffffff; text-decoration: none; padding: 14px 36px; border-radius: 10px; font-weight: 700; font-size: 1rem;">
        ✉️ <?= $button_text ?? 'تأكيد البريد الإلكتروني' ?>
    </a>
</div>

<p style="font-size: 0.85rem; color: #94a3b8;">أو انسخ الرابط التالي:</p>
<p style="font-size: 0.82rem; color: #64748b; word-break: break-all; background: #f1f5f9; padding: 8px 12px; border-radius: 6px;">
    <?= $button_link ?? '' ?>
</p>
<?php else: ?>
<p>تم تفعيل حسابك مباشرة. ابدأ الآن بإنشاء موقعك الأول!</p>

<div style="text-align: center; margin: 25px 0;">
    <a href="<?= fullUrl('/dashboard') ?>" 
       style="display: inline-block; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: #ffffff; text-decoration: none; padding: 14px 36px; border-radius: 10px; font-weight: 700; font-size: 1rem;">
        🚀 الذهاب للوحة التحكم
    </a>
</div>
<?php endif; ?>

<div style="margin-top: 30px; padding: 16px; background: #fefce8; border-radius: 10px; border-right: 4px solid #eab308;">
    <p style="margin: 0; color: #854d0e; font-size: 0.88rem;">
        💡 <strong>نصيحة:</strong> قم بملء بيانات موقعك بالكامل لتحسين ظهوره في محركات البحث.
    </p>
</div>

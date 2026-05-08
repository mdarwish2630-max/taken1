<!-- قالب: تحديث حالة الطلب -->
<p>مرحباً <strong style="color: #4f46e5;"><?= htmlspecialchars($user_name ?? '') ?></strong>،</p>

<?php if (!empty($is_approved)): ?>
<div style="margin: 20px 0; padding: 20px; background: linear-gradient(135deg, #dcfce7 0%, #d1fae5 100%); border-radius: 12px; border-right: 4px solid #22c55e;">
    <p style="margin: 0; color: #166534; font-weight: 600; font-size: 1.05rem;">
        ✅ تمت الموافقة على طلبك!
    </p>
</div>
<p>تم مراجعة طلبك والموافقة عليه بنجاح. يمكنك الآن الاستفادة من الخدمة المطلوبة.</p>
<?php else: ?>
<div style="margin: 20px 0; padding: 20px; background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border-radius: 12px; border-right: 4px solid #ef4444;">
    <p style="margin: 0; color: #991b1b; font-weight: 600; font-size: 1.05rem;">
        ❌ تم رفض طلبك
    </p>
</div>
<p>نأسف، تم رفض طلبك. يمكنك الاطلاع على السبب أدناه والتواصل مع الدعم الفني إذا كان لديك استفسار.</p>
<?php endif; ?>

<div style="text-align: center; margin: 25px 0;">
    <a href="<?= fullUrl('/dashboard/my-purchases') ?>" 
       style="display: inline-block; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: #ffffff; text-decoration: none; padding: 12px 32px; border-radius: 10px; font-weight: 700; font-size: 0.95rem;">
        📦 عرض مشترياتي
    </a>
</div>

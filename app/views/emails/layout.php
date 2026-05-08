<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $subject ?? 'إشعار' ?></title>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; direction: rtl;">
    <div style="max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08);">

        <!-- Header -->
        <div style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); padding: 30px 30px; text-align: center;">
            <h1 style="margin: 0; color: #ffffff; font-size: 1.5rem; font-weight: 700;">
                <?= $site_name ?? SITE_NAME ?>
            </h1>
            <p style="margin: 6px 0 0; color: rgba(255,255,255,0.8); font-size: 0.9rem;">
                منصة إنشاء المواقع
            </p>
        </div>

        <!-- Content -->
        <div style="padding: 35px 30px; color: #334155; font-size: 0.95rem; line-height: 1.8;">
            <?= $emailContent ?? $body ?? '' ?>
        </div>

        <!-- Footer -->
        <div style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px 30px; text-align: center;">
            <p style="margin: 0 0 6px; color: #94a3b8; font-size: 0.8rem;">
                تم الإرسال تلقائياً من <strong style="color: #64748b;"><?= $site_name ?? SITE_NAME ?></strong>
            </p>
            <p style="margin: 0; color: #cbd5e1; font-size: 0.75rem;">
                © <?= date('Y') ?> جميع الحقوق محفوظة
            </p>
        </div>
    </div>
</body>
</html>

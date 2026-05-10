<?php
/**
 * CleanPro Theme — Booking Page
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';
$whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
$waNumber = preg_replace('/[^0-9+]/', '', $whatsapp);
$phone    = $tenant->contact_phone ?? '';

$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'Book Appointment' : 'حجز موعد'));

require_once __DIR__ . '/partials/_head.php';
require_once __DIR__ . '/partials/_navbar.php';
?>

<!-- Breadcrumb -->
<div class="cpro-breadcrumb">
    <div class="cpro-container" style="display:flex;align-items:center;gap:4px">
        <a href="<?= url($siteBase) ?>"><?= $lang === 'en' ? 'Home' : 'الرئيسية' ?></a>
        <i class="fas fa-chevron-<?= $isRtl ? 'left' : 'right' ?>"></i>
        <span class="current"><?= htmlspecialchars($pageTitle) ?></span>
    </div>
</div>

<section class="cpro-section cpro-center" style="background:var(--light);padding:50px 0">
    <p class="cpro-eyebrow"><?= $lang === 'en' ? 'Easy Booking' : 'حجز سهل' ?></p>
    <h1 class="cpro-title"><?= htmlspecialchars($pageTitle) ?></h1>
    <p class="cpro-subtitle"><?= $lang === 'en'
        ? 'Fill in the form below and we will contact you to confirm your appointment.'
        : 'املأ النموذج أدناه وسنتواصل معك لتأكيد موعدك.' ?></p>
</section>

<section class="cpro-section" style="padding-top:0">
    <div class="cpro-container">
        <div class="cpro-booking-grid">
            <!-- Booking Form -->
            <div class="cpro-booking-form">
                <h3><?= $lang === 'en' ? 'Book Your Appointment' : 'احجز موعدك' ?></h3>
                <div class="cpro-form-row">
                    <input type="text" name="name" placeholder="<?= $lang === 'en' ? 'Full Name' : 'الاسم الكامل' ?>" required>
                    <input type="tel" name="phone" placeholder="<?= $lang === 'en' ? 'Phone Number' : 'رقم الهاتف' ?>" required>
                </div>
                <input type="email" name="email" placeholder="<?= $lang === 'en' ? 'Email' : 'البريد الإلكتروني' ?>">
                <select name="service" required>
                    <option><?= $lang === 'en' ? 'Select Service' : 'اختر الخدمة' ?></option>
                    <option><?= $lang === 'en' ? 'Steam Cleaning' : 'تنظيف بالبخار' ?></option>
                    <option><?= $lang === 'en' ? 'Dry Cleaning' : 'تنظيف جاف' ?></option>
                    <option><?= $lang === 'en' ? 'Stain Removal' : 'إزالة البقع' ?></option>
                    <option><?= $lang === 'en' ? 'Upholstery Cleaning' : 'تنظيف الكنب' ?></option>
                    <option><?= $lang === 'en' ? 'Curtain Cleaning' : 'غسيل ستائر' ?></option>
                </select>
                <div class="cpro-form-row">
                    <input type="date" name="date" required>
                    <input type="time" name="time" required>
                </div>
                <textarea name="notes" placeholder="<?= $lang === 'en' ? 'Additional Notes' : 'ملاحظات إضافية' ?>"></textarea>
                <button type="submit" class="cpro-btn"><?= $lang === 'en' ? 'Confirm Booking' : 'تأكيد الحجز' ?></button>
            </div>

            <!-- Info Side -->
            <div class="cpro-booking-info">
                <div class="cpro-booking-info-card">
                    <h4><i class="fas fa-clock"></i><?= $lang === 'en' ? 'Working Hours' : 'ساعات العمل' ?></h4>
                    <?php if (!empty($tenant->working_hours)): ?>
                        <p style="color:var(--muted);font-size:14px;white-space:pre-line"><?= htmlspecialchars($tenant->working_hours) ?></p>
                    <?php else: ?>
                        <p style="color:var(--muted);font-size:14px"><?= $lang === 'en' ? 'Saturday - Thursday: 8:00 AM - 8:00 PM' : 'السبت - الخميس: 8:00 صباحاً - 8:00 مساءً' ?></p>
                    <?php endif; ?>
                </div>
                <div class="cpro-booking-info-card">
                    <h4><i class="fas fa-phone-alt"></i><?= $lang === 'en' ? 'Call Us' : 'اتصل بنا' ?></h4>
                    <?php if ($phone): ?>
                        <a href="tel:<?= htmlspecialchars($phone) ?>" style="font-size:22px;font-weight:900;color:var(--blue)"><?= htmlspecialchars($phone) ?></a>
                    <?php endif; ?>
                </div>
                <div class="cpro-booking-info-card">
                    <h4><i class="fab fa-whatsapp"></i>WhatsApp</h4>
                    <?php if ($waNumber): ?>
                        <a href="https://wa.me/<?= $waNumber ?>" target="_blank" class="cpro-btn" style="margin-top:8px;background:#25D366;box-shadow:0 12px 24px rgba(37,211,102,.25)">
                            <i class="fab fa-whatsapp"></i> <?= $lang === 'en' ? 'Chat Now' : 'محادثة الآن' ?>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="cpro-booking-info-card" style="background:var(--blue);color:#fff">
                    <h4 style="color:#fff"><i class="fas fa-shield-halved" style="color:#fff"></i><?= $lang === 'en' ? 'Our Guarantee' : 'ضماننا' ?></h4>
                    <p style="color:rgba(255,255,255,.85);font-size:14px"><?= $lang === 'en'
                        ? 'We guarantee 100% satisfaction. If you are not happy with the result, we will redo the service for free.'
                        : 'نضمن لك رضا كامل 100%. إذا لم تكن سعيداً مع النتيجة سنعيد الخدمة مجاناً.' ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/partials/_footer.php'; ?>
<?php require_once __DIR__ . '/partials/_scripts.php'; ?>

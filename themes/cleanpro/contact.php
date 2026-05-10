<?php
/**
 * CleanPro Theme — Contact Page
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';
$whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
$waNumber = preg_replace('/[^0-9+]/', '', $whatsapp);
$phone    = $tenant->contact_phone ?? '';
$email    = $tenant->contact_email ?? '';
$address  = $tenant->address ?? '';

$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'Contact Us' : 'اتصل بنا'));

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

<!-- Contact Header -->
<section class="cpro-section cpro-center" style="background:var(--light);padding:50px 0">
    <p class="cpro-eyebrow"><?= $lang === 'en' ? 'Get In Touch' : 'تواصل معنا' ?></p>
    <h1 class="cpro-title"><?= htmlspecialchars($pageTitle) ?></h1>
    <p class="cpro-subtitle"><?= $lang === 'en'
        ? 'We are always here to give you the best service. Send us your request and we will respond quickly.'
        : 'نحن دائماً هنا لنقدم لك أفضل خدمة. أرسل طلبك وسنرد عليك بسرعة.' ?></p>
</section>

<!-- Contact Form Card -->
<section class="cpro-section" style="padding-top:0">
    <div class="cpro-container">
        <div class="cpro-contact-card">
            <form class="cpro-form" id="cproContactForm">
                <h3><?= $lang === 'en' ? 'Send Your Request' : 'أرسل طلبك' ?></h3>
                <div class="cpro-form-row">
                    <input type="text" name="name" placeholder="<?= $lang === 'en' ? 'Your Name' : 'الاسم' ?>" required>
                    <input type="tel" name="phone" placeholder="<?= $lang === 'en' ? 'Phone Number' : 'رقم الهاتف' ?>" required>
                </div>
                <input type="email" name="email" placeholder="<?= $lang === 'en' ? 'Email Address' : 'البريد الإلكتروني' ?>">
                <select name="service">
                    <option><?= $lang === 'en' ? 'Select Service' : 'اختر الخدمة' ?></option>
                    <option><?= $lang === 'en' ? 'Steam Cleaning' : 'تنظيف بالبخار' ?></option>
                    <option><?= $lang === 'en' ? 'Dry Cleaning' : 'تنظيف جاف' ?></option>
                    <option><?= $lang === 'en' ? 'Stain Removal' : 'إزالة البقع' ?></option>
                    <option><?= $lang === 'en' ? 'Upholstery Cleaning' : 'تنظيف الكنب' ?></option>
                </select>
                <textarea name="message" placeholder="<?= $lang === 'en' ? 'Your Message' : 'رسالتك' ?>"></textarea>
                <button type="submit" class="cpro-btn"><?= $lang === 'en' ? 'Send Request' : 'إرسال الطلب' ?></button>
            </form>
            <div class="cpro-contact-side">
                <img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=600&auto=format&fit=crop" alt="contact">
                <div>
                    <h4 style="font-weight:900;margin-top:16px;font-size:20px"><?= $lang === 'en' ? 'Contact Information' : 'معلومات التواصل' ?></h4>
                    <?php if ($phone): ?>
                        <p style="margin-top:12px"><i class="fas fa-phone-alt" style="margin-inline-end:8px"></i><?= htmlspecialchars($phone) ?></p>
                    <?php endif; ?>
                    <?php if ($email): ?>
                        <p style="margin-top:8px"><i class="fas fa-envelope" style="margin-inline-end:8px"></i><?= htmlspecialchars($email) ?></p>
                    <?php endif; ?>
                    <?php if ($address): ?>
                        <p style="margin-top:8px"><i class="fas fa-map-marker-alt" style="margin-inline-end:8px"></i><?= htmlspecialchars($address) ?></p>
                    <?php endif; ?>
                    <?php if ($waNumber): ?>
                        <a href="https://wa.me/<?= $waNumber ?>" target="_blank" class="cpro-btn" style="margin-top:16px;background:#25D366;width:100%;box-shadow:0 12px 24px rgba(37,211,102,.25)">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/partials/_footer.php'; ?>
<?php require_once __DIR__ . '/partials/_scripts.php'; ?>

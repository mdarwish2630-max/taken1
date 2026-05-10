<?php
/**
 * CleanPro Theme — Services Listing Page
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';
$whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
$waNumber = preg_replace('/[^0-9+]/', '', $whatsapp);

$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'Our Services' : 'خدماتنا'));
$pageContent = $lang === 'en' && !empty($page->content_en) ? $page->content_en : ($page->content ?? '');

$serviceImages = [
    'https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1621905252507-b35492cc74b4?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1585704032915-c3400ca199e7?q=80&w=900&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=900&auto=format&fit=crop',
];
$svcIcons = ['fas fa-wind', 'fas fa-spray-can', 'fas fa-broom', 'fas fa-soap', 'fas fa-fan', 'fas fa-hand-sparkles'];

if (empty($services)) {
    $services = [
        (object)['id'=>0,'slug'=>'service-1','title'=>'تنظيف بالبخار','title_en'=>'Steam Cleaning','description'=>'إزالة عميقة للأتربة والبقع مع تعقيم فعال باستخدام أحدث معدات البخار.','description_en'=>'Deep removal of dirt and stains with effective sanitizing using latest steam equipment.','icon'=>'fas fa-wind','image'=>'','price'=>'150 ₺','price_text'=>'150 ₺'],
        (object)['id'=>0,'slug'=>'service-2','title'=>'تنظيف جاف','title_en'=>'Dry Cleaning','description'=>'حل مثالي للسجاد الحساس وسريع الجفاف بدون استخدام الماء.','description_en'=>'Ideal for delicate carpets with fast drying results without water usage.','icon'=>'fas fa-spray-can','image'=>'','price'=>'100 ₺','price_text'=>'100 ₺'],
        (object)['id'=>0,'slug'=>'service-3','title'=>'إزالة البقع','title_en'=>'Stain Removal','description'=>'معالجة احترافية للبقع الصعبة والروائح بأنواعها.','description_en'=>'Professional treatment for tough stains and all types of odors.','icon'=>'fas fa-broom','image'=>'','price'=>'80 ₺','price_text'=>'80 ₺'],
        (object)['id'=>0,'slug'=>'service-4','title'=>'تنظيف الكنب','title_en'=>'Upholstery Cleaning','description'=>'تنظيف احترافي لجميع أنواع الكنب والمفروشات.','description_en'=>'Professional cleaning for all types of sofas and upholstery.','icon'=>'fas fa-soap','image'=>'','price'=>'200 ₺','price_text'=>'200 ₺'],
        (object)['id'=>0,'slug'=>'service-5','title'=>'غسيل ستائر','title_en'=>'Curtain Cleaning','description':'غسيل وتنظيف جميع أنواع الستائر بأحدث التقنيات.','description_en'=>'Washing and cleaning all curtain types using latest techniques.','icon'=>'fas fa-fan','image'=>'','price'=>'120 ₺','price_text'=>'120 ₺'],
        (object)['id'=>0,'slug'=>'service-6','title'=>'تجفيف سريع','title_en'=>'Fast Drying','description'=>'خدمة تجفيف سريع باستخدام معدات شفط احترافية.','description_en'=>'Fast drying service using professional extraction equipment.','icon'=>'fas fa-hand-sparkles','image'=>'','price'=>'90 ₺','price_text'=>'90 ₺'],
    ];
}

require_once __DIR__ . '/partials/_head.php';
require_once __DIR__ . '/partials/_navbar.php';
?>

<!-- ═══════ PAGE HEADER ═══════ -->
<section class="cpro-section cpro-center" style="background:var(--light);padding:60px 0">
    <p class="cpro-eyebrow"><?= $lang === 'en' ? 'What We Offer' : 'ما نقدمه' ?></p>
    <h1 class="cpro-title"><?= htmlspecialchars($pageTitle) ?></h1>
    <?php if ($pageContent): ?>
        <p class="cpro-subtitle"><?= htmlspecialchars($pageContent) ?></p>
    <?php else: ?>
        <p class="cpro-subtitle"><?= $lang === 'en'
            ? 'Discover our wide range of professional cleaning services designed for your needs.'
            : 'اكتشف مجموعتنا الواسعة من خدمات التنظيف الاحترافية المصممة لتلبية احتياجاتكم.' ?></p>
    <?php endif; ?>
</section>

<!-- ═══════ SERVICES GRID ═══════ -->
<section class="cpro-section">
    <div class="cpro-container">
        <div class="cpro-cards">
            <?php foreach ($services as $i => $svc):
                $svcTitle = $lang === 'en' && !empty($svc->title_en) ? $svc->title_en : ($svc->title ?? '');
                $svcDesc  = $lang === 'en' && !empty($svc->description_en) ? $svc->description_en : ($svc->description ?? '');
                $svcImg   = !empty($svc->image) ? (function_exists('upload') ? upload($svc->image) : $svc->image) : ($serviceImages[$i % count($serviceImages)] ?? '');
                $svcIcon  = $svc->icon ?? $svcIcons[$i % count($svcIcons)];
                $svcPrice = !empty($svc->price) ? $svc->price : '';
            ?>
                <div class="cpro-service-card">
                    <?php if ($svcImg): ?>
                        <img src="<?= htmlspecialchars($svcImg) ?>" alt="<?= htmlspecialchars($svcTitle) ?>" loading="lazy">
                    <?php endif; ?>
                    <div class="sicon"><i class="<?= htmlspecialchars($svcIcon) ?>"></i></div>
                    <h3><?= htmlspecialchars($svcTitle) ?></h3>
                    <?php if (!empty($svcPrice)): ?>
                        <p style="font-weight:900;color:var(--blue);margin-bottom:4px;font-size:18px"><?= htmlspecialchars($svcPrice) ?></p>
                    <?php endif; ?>
                    <p><?= htmlspecialchars($svcDesc) ?></p>
                    <div class="card-actions">
                        <a href="<?= url($siteBase . '/service/' . ($svc->slug ?? 'service-' . ($i + 1))) ?>" class="cpro-btn" style="padding:10px 20px;font-size:13px">
                            <?= $lang === 'en' ? 'Details' : 'التفاصيل' ?>
                        </a>
                        <a href="<?= url($siteBase . '/booking') ?>" class="cpro-btn cpro-btn-white" style="padding:10px 20px;font-size:13px;box-shadow:var(--shadow)">
                            <?= $lang === 'en' ? 'Book Now' : 'احجز الآن' ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════ CTA ═══════ -->
<section class="cpro-dark-band">
    <div class="cpro-container cpro-center" style="color:#fff">
        <h2 class="cpro-title" style="color:#fff"><?= $lang === 'en'
            ? 'Need a Custom Service?'
            : 'تحتاج خدمة مخصصة؟' ?></h2>
        <p class="cpro-subtitle" style="color:#cbd5e1;margin:16px auto 28px"><?= $lang === 'en'
            ? 'Contact us and we will tailor a solution that fits your requirements.'
            : 'تواصل معنا وسنصمم لك حلاً يتناسب مع متطلباتك.' ?></p>
        <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap">
            <?php if ($waNumber): ?>
            <a href="https://wa.me/<?= $waNumber ?>" target="_blank" class="cpro-btn" style="background:#25D366;box-shadow:0 12px 24px rgba(37,211,102,.25)">
                <i class="fab fa-whatsapp"></i> WhatsApp
            </a>
            <?php endif; ?>
            <a href="<?= url($siteBase . '/booking') ?>" class="cpro-btn cpro-btn-white">
                <?= $lang === 'en' ? 'Book Appointment' : 'احجز موعد' ?>
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/partials/_footer.php'; ?>
<?php require_once __DIR__ . '/partials/_scripts.php'; ?>

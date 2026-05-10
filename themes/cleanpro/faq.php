<?php
/**
 * CleanPro Theme — FAQ Page
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';

$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'FAQ' : 'الأسئلة الشائعة'));

if (empty($faqItems)) {
    $faqItems = $lang === 'en' ? [
        (object)['question'=>'How long does carpet cleaning take?','question_en'=>'How long does carpet cleaning take?','answer'=>'Most carpet cleaning jobs take between 1-3 hours depending on the carpet size and condition.','answer_en'=>'Most carpet cleaning jobs take between 1-3 hours depending on the carpet size and condition.'],
        (object)['question'=>'Is steam cleaning safe for all carpet types?','question_en'=>'Is steam cleaning safe for all carpet types?','answer'=>'Yes, our professional steam cleaning is safe for most carpet types. We always test a small area first.','answer_en'=>'Yes, our professional steam cleaning is safe for most carpet types. We always test a small area first.'],
        (object)['question'=>'How soon can I walk on the carpet after cleaning?','question_en'=>'How soon can I walk on the carpet after cleaning?','answer':'With our fast-drying technology, most carpets are dry within 2-4 hours.','answer_en':'With our fast-drying technology, most carpets are dry within 2-4 hours.'],
        (object)['question'=>'Do you offer a warranty on your work?','question_en':'Do you offer a warranty on your work?','answer':'Yes, we provide a 6-month warranty on all our cleaning services.','answer_en':'Yes, we provide a 6-month warranty on all our cleaning services.'],
        (object)['question'=>'What areas do you serve?','question_en':'What areas do you serve?','answer':'We serve most areas within the city and surrounding suburbs.','answer_en':'We serve most areas within the city and surrounding suburbs.'],
    ] : [
        (object)['question'=>'كم يستغرق تنظيف السجاد؟','question_en'=>'','answer':'معظم أعمال تنظيف السجاد تستغرق بين 1-3 ساعات حسب حجم السجاد وحالته.','answer_en'=>''],
        (object)['question'=>'هل التنظيف بالبخار آمن لجميع أنواع السجاد؟','question_en'=>'','answer':'نعم، التنظيف بالبخار الاحترافي آمن لمعظم أنواع السجاد. نختبر دائماً مساحة صغيرة أولاً.','answer_en'=>''],
        (object)['question'=>'متى يمكنني المشي على السجاد بعد التنظيف؟','question_en':'','answer':'بفضل تقنيتنا في التجفيف السريع، معظم السجادات تجف خلال 2-4 ساعات.','answer_en'=>''],
        (object)['question'=>'هل تقدمون ضماناً على العمل؟','question_en':'','answer':'نعم، نقدم ضماناً لمدة 6 أشهر على جميع خدماتنا.','answer_en'=>''],
        (object)['question'=>'ما المناطق التي تخدمونها؟','question_en':'','answer':'نخدم معظم مناطق المدينة والضواحي المحيطة بها.','answer_en'=>''],
    ];
}

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
    <p class="cpro-eyebrow"><?= $lang === 'en' ? 'Need Help?' : 'تحتاج مساعدة؟' ?></p>
    <h1 class="cpro-title"><?= htmlspecialchars($pageTitle) ?></h1>
    <p class="cpro-subtitle"><?= $lang === 'en'
        ? 'Find answers to the most commonly asked questions about our services.'
        : 'اعثر على إجابات لأكثر الأسئلة شيوعاً حول خدماتنا.' ?></p>
</section>

<section class="cpro-section" style="padding-top:0">
    <div class="cpro-container">
        <div class="cpro-faq-list">
            <?php foreach ($faqItems as $item):
                $q = $lang === 'en' && !empty($item->question_en) ? $item->question_en : ($item->question ?? '');
                $a = $lang === 'en' && !empty($item->answer_en) ? $item->answer_en : ($item->answer ?? '');
            ?>
                <div class="cpro-faq-item">
                    <div class="cpro-faq-q">
                        <?= htmlspecialchars($q) ?>
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="cpro-faq-a"><?= htmlspecialchars($a) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cpro-dark-band">
    <div class="cpro-container cpro-center" style="color:#fff">
        <h2 class="cpro-title" style="color:#fff"><?= $lang === 'en' ? 'Still Have Questions?' : 'لديك أسئلة أخرى؟' ?></h2>
        <p class="cpro-subtitle" style="color:#cbd5e1;margin:16px auto 28px"><?= $lang === 'en'
            ? 'Feel free to contact us and our team will be happy to help.'
            : 'لا تتردد في التواصل معنا وفريقنا سيكون سعيداً بمساعدتك.' ?></p>
        <a href="<?= url($siteBase . '/contact') ?>" class="cpro-btn cpro-btn-white"><?= $lang === 'en' ? 'Contact Us' : 'تواصل معنا' ?></a>
    </div>
</section>

<?php require_once __DIR__ . '/partials/_footer.php'; ?>
<?php require_once __DIR__ . '/partials/_scripts.php'; ?>

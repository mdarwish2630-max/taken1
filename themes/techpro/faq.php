<?php
/**
 * Tek Pro Theme — FAQ Page
 * Searchable FAQ accordion with category tabs
 * Light theme + Orange accents
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';

$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'FAQ' : 'الأسئلة الشائعة'));

$allFaqItems = !empty($faqItems) ? $faqItems : [];

if (empty($allFaqItems)) {
    $allFaqItems = [
        (object)['id' => 0, 'question' => 'ما هي خدماتكم؟', 'question_en' => 'What are your services?', 'answer' => 'نقدم خدمات تقنية شاملة تشمل الدعم التقني، حلول الشبكات، الصيانة، الأمن والحماية، الاستشارات، والتطوير. كل خدمة يقدمها فريق متخصص ومعتمد.', 'answer_en' => 'We offer comprehensive services including tech support, network solutions, maintenance, security, consulting, and development.', 'category' => 'services', 'sort_order' => 0],
        (object)['id' => 0, 'question' => 'ما هي أوقات العمل؟', 'question_en' => 'What are your working hours?', 'answer' => 'فريقنا متاح 24/7 للطوارئ، وخدمات المواعيد العادية من السبت إلى الخميس من 8 صباحاً حتى 8 مساءً.', 'answer_en' => 'Our team is available 24/7 for emergencies. Regular appointments: Saturday to Thursday, 8 AM to 8 PM.', 'category' => 'general', 'sort_order' => 1],
        (object)['id' => 0, 'question' => 'كيف أحجز موعد؟', 'question_en' => 'How do I book an appointment?', 'answer' => 'يمكنك الحجز عبر الموقع من صفحة "احجز الآن"، أو الاتصال المباشر، أو الواتساب. سيتواصل معك فريقنا خلال 15 دقيقة.', 'answer_en' => 'Book via our website, direct call, or WhatsApp. Our team will contact you within 15 minutes.', 'category' => 'booking', 'sort_order' => 2],
        (object)['id' => 0, 'question' => 'هل تقدمون ضماناً على الخدمات؟', 'question_en' => 'Do you offer warranty?', 'answer' => 'نعم، نقدم ضماناً على جميع أعمالنا لمدة تصل إلى 6 أشهر حسب نوع الخدمة.', 'answer_en' => 'Yes, we provide warranty on all work for up to 6 months depending on service type.', 'category' => 'services', 'sort_order' => 3],
        (object)['id' => 0, 'question' => 'ما هي مناطق التغطية؟', 'question_en' => 'Coverage areas?', 'answer' => 'نغطي جميع مناطق إسطنبول وضواحيها. للمناطق البعيدة يرجى التواصل معنا.', 'answer_en' => 'We cover all areas of Istanbul and suburbs. For remote areas, please contact us.', 'category' => 'general', 'sort_order' => 4],
        (object)['id' => 0, 'question' => 'كيف يتم تسعير الخدمات؟', 'question_en' => 'How are services priced?', 'answer' => 'نعمل على أساس تسعير عادل وشفاف. بعد الفحص الأولي المجاني يتم إبلاغك بالتكلفة النهائية بدون رسوم مخفية.', 'answer_en' => 'Fair and transparent pricing. After a free inspection, you will be informed of the final cost with no hidden fees.', 'category' => 'pricing', 'sort_order' => 5],
    ];
}

$categories = [];
if (!empty($faqCategories) && is_array($faqCategories)) {
    foreach ($faqCategories as $catKey => $catItems) {
        $categories[] = (object)['key' => $catKey, 'label' => $catKey, 'label_en' => $catKey, 'items' => $catItems];
    }
} elseif (!empty($allFaqItems)) {
    foreach ($allFaqItems as $faq) {
        $cat = $faq->category ?? 'general';
        if (!isset($categories[$cat])) { $categories[$cat] = (object)['key' => $cat, 'label' => $cat, 'label_en' => $cat, 'items' => []]; }
        $categories[$cat]->items[] = $faq;
    }
    $categories = array_values($categories);
}

$categoryLabels = [
    'general'   => (object)['label' => 'عام', 'label_en' => 'General'],
    'services'  => (object)['label' => 'الخدمات', 'label_en' => 'Services'],
    'pricing'   => (object)['label' => 'الأسعار', 'label_en' => 'Pricing'],
    'booking'   => (object)['label' => 'الحجز', 'label_en' => 'Booking'],
    'technical' => (object)['label' => 'تقني', 'label_en' => 'Technical'],
];

require_once __DIR__ . '/_head.php';
require_once __DIR__ . '/_navbar.php';
?>

<!-- ═══════ PAGE HEADER ═══════ -->
<section class="bg-[#f3f3f3] px-6 lg:px-16 py-16">
    <div class="max-w-4xl mx-auto fade-up">
        <p class="text-[#ff7a00] font-black mb-3"><?= $lang === 'en' ? 'FAQ' : 'الأسئلة الشائعة' ?></p>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight mb-6"><?= htmlspecialchars($pageTitle) ?></h1>
        <p class="text-gray-600 text-lg leading-relaxed max-w-3xl">
            <?= $lang === 'en' ? 'Find answers to commonly asked questions about our services.' : 'اعثر على إجابات لأكثر الأسئلة شيوعاً حول خدماتنا.' ?>
        </p>
    </div>
</section>

<!-- ═══════ SEARCH + FAQ ═══════ -->
<section class="px-6 lg:px-16 py-12 pb-20">
    <div class="max-w-4xl mx-auto">

        <!-- Search -->
        <?php if (!empty($allFaqItems)): ?>
        <div class="mb-10 fade-up">
            <div class="relative">
                <i class="fas fa-search absolute top-1/2 -translate-y-1/2 <?= $isRtl ? 'right-5' : 'left-5' ?> text-gray-400"></i>
                <input type="text" id="faqSearch"
                       class="w-full bg-[#f5f5f5] border border-gray-200 rounded-lg px-5 py-4 <?= $isRtl ? 'pr-14' : 'pl-14' ?> text-gray-800 placeholder-gray-400 focus:border-[#ff7a00] focus:ring-1 focus:ring-[#ff7a00]/30 outline-none transition"
                       placeholder="<?= $lang === 'en' ? 'Search for questions...' : 'ابحث عن سؤال...' ?>">
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($categories)): ?>

            <!-- Category Tabs -->
            <?php if (count($categories) > 1): ?>
            <div class="flex flex-wrap gap-3 justify-center mb-12 fade-up">
                <button data-faq-cat="all"
                        class="faq-cat-btn rounded-full px-5 py-2.5 text-sm font-bold transition bg-[#ff7a00]/10 border border-[#ff7a00]/30 text-[#ff7a00] active-cat">
                    <?= $lang === 'en' ? 'All' : 'الكل' ?>
                </button>
                <?php foreach ($categories as $ci => $cat):
                    $catKey = $cat->key ?? $ci;
                    $catDisplay = isset($categoryLabels[$catKey])
                        ? ($lang === 'en' ? $categoryLabels[$catKey]->label_en : $categoryLabels[$catKey]->label)
                        : ($lang === 'en' && !empty($cat->label_en) ? $cat->label_en : ($cat->label ?? $catKey));
                ?>
                    <button data-faq-cat="<?= htmlspecialchars($catKey) ?>"
                            class="faq-cat-btn rounded-full px-5 py-2.5 text-sm font-bold text-gray-500 transition bg-[#f5f5f5] border border-transparent hover:border-[#ff7a00]/30 hover:text-[#ff7a00]">
                        <?= htmlspecialchars($catDisplay) ?>
                    </button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- FAQ Accordion -->
            <div id="faqAccordion" class="space-y-4">
                <?php $faqIndex = 0; ?>
                <?php foreach ($categories as $ci => $cat):
                    $catKey = $cat->key ?? $ci;
                    $items  = !empty($cat->items) ? $cat->items : [];
                    if (empty($items)) continue;
                    if (count($categories) > 1):
                        $catDisplay = isset($categoryLabels[$catKey])
                            ? ($lang === 'en' ? $categoryLabels[$catKey]->label_en : $categoryLabels[$catKey]->label)
                            : ($lang === 'en' && !empty($cat->label_en) ? $cat->label_en : ($cat->label ?? $catKey));
                ?>
                    <div class="faq-category-section fade-up" data-faq-category="<?= htmlspecialchars($catKey) ?>">
                        <h3 class="text-xl font-black text-[#ff7a00] mb-4 flex items-center gap-2"><i class="fas fa-folder-open text-sm"></i> <?= htmlspecialchars($catDisplay) ?></h3>
                    <?php endif; ?>

                    <?php foreach ($items as $fi => $faq):
                        $faqQ = $lang === 'en' && !empty($faq->question_en) ? $faq->question_en : ($faq->question ?? '');
                        $faqA = $lang === 'en' && !empty($faq->answer_en) ? $faq->answer_en : ($faq->answer ?? '');
                        $faqId = 'faq-' . ($faq->id ?? $faqIndex);
                        $delay = 0.05 * min($faqIndex, 12);
                    ?>
                        <div class="faq-item bg-[#f5f5f5] rounded-lg overflow-hidden transition-all duration-300 fade-up faq-category-item"
                             data-faq-category="<?= htmlspecialchars($catKey) ?>"
                             data-faq-question="<?= htmlspecialchars(mb_strtolower($faqQ)) ?>"
                             data-faq-answer="<?= htmlspecialchars(mb_strtolower(strip_tags($faqA))) ?>"
                             style="transition-delay:<?= $delay ?>s">
                            <button class="faq-toggle w-full flex items-center justify-between gap-4 p-6 text-<?= $isRtl ? 'right' : 'left' ?> text-start hover:bg-[#ff7a00]/5 transition"
                                    aria-expanded="false" aria-controls="<?= $faqId ?>">
                                <span class="font-bold text-gray-800 text-base leading-relaxed"><?= htmlspecialchars($faqQ) ?></span>
                                <span class="faq-icon w-9 h-9 min-w-[36px] rounded-lg bg-[#ff7a00]/10 flex items-center justify-center transition-transform duration-300 text-[#ff7a00] text-sm">
                                    <i class="fas fa-plus"></i>
                                </span>
                            </button>
                            <div id="<?= $faqId ?>" class="faq-answer overflow-hidden max-h-0 transition-all duration-300 ease-in-out">
                                <div class="px-6 pb-6 text-gray-600 leading-relaxed text-sm border-t border-gray-200 pt-4"><?= htmlspecialchars($faqA) ?></div>
                            </div>
                        </div>
                        <?php $faqIndex++; ?>
                    <?php endforeach; ?>

                <?php if (count($categories) > 1): ?>
                    </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <div id="faqNoResults" class="hidden text-center py-16">
                <div class="w-20 h-20 rounded-full bg-[#f5f5f5] flex items-center justify-center text-3xl mx-auto mb-4"><i class="fas fa-search text-gray-400"></i></div>
                <h3 class="text-xl font-black text-gray-400 mb-2"><?= $lang === 'en' ? 'No Results' : 'لم يتم العثور على نتائج' ?></h3>
                <p class="text-gray-400"><?= $lang === 'en' ? 'Try a different search term.' : 'حاول مصطلح بحث مختلف.' ?></p>
            </div>

        <?php else: ?>
            <div class="text-center py-20 fade-up">
                <div class="w-24 h-24 rounded-full bg-[#f5f5f5] flex items-center justify-center text-4xl mx-auto mb-6"><i class="fas fa-circle-question text-gray-400"></i></div>
                <h3 class="text-2xl font-black text-gray-400 mb-3"><?= $lang === 'en' ? 'No FAQs Available' : 'لا توجد أسئلة شائعة' ?></h3>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- FAQ Category Filter Script -->
<script>
(() => {
    const catBtns = document.querySelectorAll('.faq-cat-btn');
    const sections = document.querySelectorAll('.faq-category-section');
    const items = document.querySelectorAll('.faq-category-item');

    if (catBtns.length > 0) {
        catBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                catBtns.forEach(b => {
                    b.classList.remove('active-cat', 'bg-[#ff7a00]/10', 'border-[#ff7a00]/30', 'text-[#ff7a00]');
                    b.classList.add('text-gray-500', 'bg-[#f5f5f5]');
                });
                btn.classList.add('active-cat', 'bg-[#ff7a00]/10', 'border-[#ff7a00]/30', 'text-[#ff7a00]');
                btn.classList.remove('text-gray-500', 'bg-[#f5f5f5]');

                const filter = btn.dataset.faqCat;
                sections.forEach(s => { s.style.display = (filter === 'all' || s.dataset.faqCategory === filter) ? '' : 'none'; });
                items.forEach(item => { item.style.display = (filter === 'all' || item.dataset.faqCategory === filter) ? '' : 'none'; });
            });
        });
    }
})();
</script>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

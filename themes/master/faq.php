<?php
/**
 * Master Theme — FAQ Page
 * Searchable FAQ accordion with category tabs
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';

// Page title
$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'FAQ' : 'الأسئلة الشائعة'));
$pageContent = $lang === 'en' && !empty($page->content_en) ? $page->content_en : ($page->content ?? '');

// Flatten FAQ items for search
$allFaqItems = !empty($faqItems) ? $faqItems : [];

// ── Fallback FAQ data (always show content even if DB is empty) ──
if (empty($allFaqItems)) {
    $allFaqItems = [
        (object)['id' => 0, 'question' => 'ما هي خدماتكم؟', 'question_en' => 'What are your services?',
            'answer' => 'نقدم خدمات صيانة شاملة تشمل الكهرباء، السباكة، التكييف، الدهانات، إصلاح المنازل، والأقفال والأبواب. كل خدمة يقدمها فني متخصص ومعتمد.',
            'answer_en' => 'We offer comprehensive maintenance including electrical, plumbing, AC, painting, home repair, and locks & doors. Each service is provided by a specialized certified technician.',
            'category' => 'services', 'sort_order' => 0, 'status' => 'active'],
        (object)['id' => 0, 'question' => 'ما هي أوقات العمل؟', 'question_en' => 'What are your working hours?',
            'answer' => 'فريقنا متاح 24/7 للطوارئ، وخدمات المواعيد العادية من السبت إلى الخميس من 8 صباحاً حتى 8 مساءً.',
            'answer_en' => 'Our team is available 24/7 for emergencies. Regular appointments: Saturday to Thursday, 8 AM to 8 PM.',
            'category' => 'general', 'sort_order' => 0, 'status' => 'active'],
        (object)['id' => 0, 'question' => 'كيف أحجز موعد؟', 'question_en' => 'How do I book an appointment?',
            'answer' => 'يمكنك الحجز عبر الموقع من صفحة "احجز الآن"، أو الاتصال المباشر، أو الواتساب. سيتواصل معك فريقنا خلال 15 دقيقة لتأكيد الموعد.',
            'answer_en' => 'You can book via our website "Book Now" page, direct call, or WhatsApp. Our team will contact you within 15 minutes to confirm.',
            'category' => 'booking', 'sort_order' => 0, 'status' => 'active'],
        (object)['id' => 0, 'question' => 'هل تقدمون ضماناً على الخدمات؟', 'question_en' => 'Do you offer service warranty?',
            'answer' => 'نعم، نقدم ضماناً على جميع أعمال الصيانة لمدة تصل إلى 6 أشهر حسب نوع الخدمة. في حالة تكرار العطل يتم الإصلاح مجاناً.',
            'answer_en' => 'Yes, we provide warranty on all maintenance work for up to 6 months. Recurring issues are fixed for free during warranty.',
            'category' => 'services', 'sort_order' => 0, 'status' => 'active'],
        (object)['id' => 0, 'question' => 'ما هي مناطق التغطية؟', 'question_en' => 'What are your coverage areas?',
            'answer' => 'نغطي جميع مناطق إسطنبول وضواحيها. بالنسبة للمناطق البعيدة يرجى التواصل معنا للتأكد من إمكانية الوصول.',
            'answer_en' => 'We cover all areas of Istanbul and suburbs. For remote areas, please contact us to confirm availability.',
            'category' => 'general', 'sort_order' => 0, 'status' => 'active'],
        (object)['id' => 0, 'question' => 'كيف يتم تسعير الخدمات؟', 'question_en' => 'How are services priced?',
            'answer' => 'نعمل على أساس تسعير عادل وشفاف. بعد الفحص الأولي المجاني يتم إبلاغك بالتكلفة النهائية قبل بدء العمل بدون أي رسوم مخفية.',
            'answer_en' => 'We work on fair and transparent pricing. After a free initial inspection, you will be informed of the final cost before work starts with no hidden fees.',
            'category' => 'pricing', 'sort_order' => 0, 'status' => 'active'],
    ];
}

// Extract categories from faqCategories or faqItems
$categories = [];
if (!empty($faqCategories) && is_array($faqCategories)) {
    foreach ($faqCategories as $catKey => $catItems) {
        $categories[] = (object)[
            'key'  => $catKey,
            'label' => $catKey,
            'label_en' => $catKey,
            'items' => $catItems,
        ];
    }
} elseif (!empty($allFaqItems)) {
    foreach ($allFaqItems as $faq) {
        $cat = $faq->category ?? 'general';
        if (!isset($categories[$cat])) {
            $categories[$cat] = (object)[
                'key'  => $cat,
                'label' => $cat,
                'label_en' => $cat,
                'items' => [],
            ];
        }
        $categories[$cat]->items[] = $faq;
    }
    $categories = array_values($categories);
}

// Hardcoded category labels (UI chrome only)
$categoryLabels = [
    'general'   => (object)['label' => 'عام', 'label_en' => 'General'],
    'services'  => (object)['label' => 'الخدمات', 'label_en' => 'Services'],
    'pricing'   => (object)['label' => 'الأسعار', 'label_en' => 'Pricing'],
    'booking'   => (object)['label' => 'الحجز', 'label_en' => 'Booking'],
    'technical' => (object)['label' => 'تقني', 'label_en' => 'Technical'],
    'support'   => (object)['label' => 'الدعم', 'label_en' => 'Support'],
];

require_once __DIR__ . '/_head.php';
require_once __DIR__ . '/_navbar.php';
?>

<!-- Background Effects -->
<div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
    <div class="absolute -top-20 -right-20 w-[500px] h-[500px] bg-cyan-500/15 blur-[120px] rounded-full"></div>
    <div class="absolute -bottom-20 -left-20 w-[500px] h-[500px] bg-blue-500/15 blur-[120px] rounded-full"></div>
</div>

<!-- ═══════ PAGE HEADER ═══════ -->
<section class="relative z-10 px-6 lg:px-20 pt-32 pb-8">
    <div class="max-w-4xl mx-auto fade-up">
        <div class="inline-flex items-center gap-2 glass rounded-full px-4 py-2 text-sm text-cyan-300 mb-6">
            <i class="fas fa-circle-question text-xs"></i>
            <span><?= $lang === 'en' ? 'FAQ' : 'الأسئلة الشائعة' ?></span>
        </div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight mb-6">
            <?= htmlspecialchars($pageTitle) ?>
        </h1>
        <?php if (!empty($pageContent)): ?>
            <p class="text-gray-300 text-lg leading-relaxed max-w-3xl"><?= $pageContent ?></p>
        <?php else: ?>
            <p class="text-gray-300 text-lg leading-relaxed max-w-3xl">
                <?= $lang === 'en'
                    ? 'Find answers to commonly asked questions about our services and processes.'
                    : 'اعثر على إجابات لأكثر الأسئلة شيوعاً حول خدماتنا وعملياتنا.' ?>
            </p>
        <?php endif; ?>
        <div class="w-24 h-1.5 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full mt-6"></div>
    </div>
</section>

<!-- ═══════ SEARCH + FAQ CONTENT ═══════ -->
<section class="relative z-10 px-6 lg:px-20 py-12 pb-20">
    <div class="max-w-4xl mx-auto">

        <!-- Search Input -->
        <?php if (!empty($allFaqItems)): ?>
        <div class="mb-10 fade-up">
            <div class="relative">
                <i class="fas fa-search absolute top-1/2 -translate-y-1/2 <?= $isRtl ? 'right-5' : 'left-5' ?> text-gray-400"></i>
                <input type="text" id="faqSearch"
                       class="w-full bg-white/5 border border-white/10 rounded-2xl px-5 py-4 <?= $isRtl ? 'pr-14' : 'pl-14' ?> text-white placeholder-gray-500 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400/30 outline-none transition"
                       placeholder="<?= $lang === 'en' ? 'Search for questions...' : 'ابحث عن سؤال...' ?>">
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($categories)): ?>

            <!-- Category Tabs -->
            <?php if (count($categories) > 1): ?>
            <div class="flex flex-wrap gap-3 justify-center mb-12 fade-up">
                <button data-faq-cat="all"
                        class="faq-cat-btn glass rounded-full px-5 py-2.5 text-sm font-semibold transition hover:border-cyan-400/40 active-cat bg-cyan-500/20 border-cyan-400/40 text-cyan-300">
                    <?= $lang === 'en' ? 'All' : 'الكل' ?>
                </button>
                <?php foreach ($categories as $ci => $cat):
                    $catKey = $cat->key ?? $ci;
                    $catDisplay = isset($categoryLabels[$catKey])
                        ? ($lang === 'en' ? $categoryLabels[$catKey]->label_en : $categoryLabels[$catKey]->label)
                        : ($lang === 'en' && !empty($cat->label_en) ? $cat->label_en : ($cat->label ?? $catKey));
                ?>
                    <button data-faq-cat="<?= htmlspecialchars($catKey) ?>"
                            class="faq-cat-btn glass rounded-full px-5 py-2.5 text-sm font-semibold text-gray-300 transition hover:border-cyan-400/40 hover:text-cyan-300">
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

                    // Category heading (if multiple categories)
                    if (count($categories) > 1):
                        $catDisplay = isset($categoryLabels[$catKey])
                            ? ($lang === 'en' ? $categoryLabels[$catKey]->label_en : $categoryLabels[$catKey]->label)
                            : ($lang === 'en' && !empty($cat->label_en) ? $cat->label_en : ($cat->label ?? $catKey));
                ?>
                    <div class="faq-category-section fade-up" data-faq-category="<?= htmlspecialchars($catKey) ?>">
                        <h3 class="text-xl font-bold text-cyan-400 mb-4 flex items-center gap-2">
                            <i class="fas fa-folder-open text-sm"></i>
                            <?= htmlspecialchars($catDisplay) ?>
                        </h3>
                <?php endif; ?>

                    <?php foreach ($items as $fi => $faq):
                        $faqQ = $lang === 'en' && !empty($faq->question_en) ? $faq->question_en : ($faq->question ?? '');
                        $faqA = $lang === 'en' && !empty($faq->answer_en) ? $faq->answer_en : ($faq->answer ?? '');
                        $faqId = 'faq-' . ($faq->id ?? $faqIndex);
                        $delay = 0.05 * min($faqIndex, 12);
                    ?>
                        <div class="faq-item glass rounded-2xl overflow-hidden transition-all duration-300 fade-up faq-category-item"
                             data-faq-category="<?= htmlspecialchars($catKey) ?>"
                             data-faq-question="<?= htmlspecialchars(mb_strtolower($faqQ)) ?>"
                             data-faq-answer="<?= htmlspecialchars(mb_strtolower(strip_tags($faqA))) ?>"
                             style="transition-delay:<?= $delay ?>s">
                            <!-- Question (Clickable) -->
                            <button class="faq-toggle w-full flex items-center justify-between gap-4 p-6 text-<?= $isRtl ? 'right' : 'left' ?> text-start hover:bg-white/5 transition"
                                    aria-expanded="false" aria-controls="<?= $faqId ?>">
                                <span class="font-semibold text-gray-100 text-base leading-relaxed"><?= htmlspecialchars($faqQ) ?></span>
                                <span class="faq-icon w-9 h-9 min-w-[36px] rounded-xl bg-cyan-500/15 flex items-center justify-center transition-transform duration-300 text-cyan-400 text-sm">
                                    <i class="fas fa-plus"></i>
                                </span>
                            </button>
                            <!-- Answer (Collapsible) -->
                            <div id="<?= $faqId ?>" class="faq-answer overflow-hidden max-h-0 transition-all duration-300 ease-in-out">
                                <div class="px-6 pb-6 text-gray-400 leading-relaxed text-sm border-t border-white/5 pt-4">
                                    <?= $faqA ?>
                                </div>
                            </div>
                        </div>
                        <?php $faqIndex++; ?>
                    <?php endforeach; ?>

                <?php if (count($categories) > 1): ?>
                    </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <!-- No results state -->
            <div id="faqNoResults" class="hidden text-center py-16">
                <div class="w-20 h-20 rounded-full bg-white/5 flex items-center justify-center text-3xl mx-auto mb-4">
                    <i class="fas fa-search text-gray-500"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-300 mb-2">
                    <?= $lang === 'en' ? 'No Results Found' : 'لم يتم العثور على نتائج' ?>
                </h3>
                <p class="text-gray-500">
                    <?= $lang === 'en' ? 'Try a different search term.' : 'حاول مصطلح بحث مختلف.' ?>
                </p>
            </div>

        <?php else: ?>
            <!-- Empty State -->
            <div class="text-center py-20 fade-up">
                <div class="w-24 h-24 rounded-full bg-cyan-500/10 border border-cyan-400/20 flex items-center justify-center text-4xl mx-auto mb-6">
                    <i class="fas fa-circle-question text-cyan-400/50"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-300 mb-3">
                    <?= $lang === 'en' ? 'No FAQs Available' : 'لا توجد أسئلة شائعة' ?>
                </h3>
                <p class="text-gray-500 mb-8">
                    <?= $lang === 'en' ? 'Frequently asked questions will appear here once added.' : 'ستظهر الأسئلة الشائعة هنا بمجرد إضافتها.' ?>
                </p>
            </div>
        <?php endif; ?>

        <!-- Still have questions CTA -->
        <?php if (!empty($allFaqItems)): ?>
        <div class="mt-16 text-center fade-up">
            <div class="glass rounded-2xl p-8 max-w-2xl mx-auto">
                <h3 class="text-xl font-bold mb-3">
                    <?= $lang === 'en' ? 'Still Have Questions?' : 'لا تزال لديك أسئلة؟' ?>
                </h3>
                <p class="text-gray-400 mb-6">
                    <?= $lang === 'en'
                        ? 'Feel free to reach out to us directly. We are here to help!'
                        : 'لا تتردد في التواصل معنا مباشرة. نحن هنا للمساعدة!' ?>
                </p>
                <div class="flex flex-wrap justify-center gap-3">
                    <?php
                        $whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
                        $waNumber = preg_replace('/[^0-9+]/', '', $whatsapp);
                    ?>
                    <?php if ($waNumber): ?>
                        <a href="https://wa.me/<?= $waNumber ?>" target="_blank"
                           class="inline-flex items-center gap-2 bg-[#25D366] hover:bg-[#20bd5a] transition px-6 py-3 rounded-xl font-bold text-sm shadow-lg shadow-green-500/30 text-white">
                            <i class="fab fa-whatsapp"></i>
                            <?= $lang === 'en' ? 'Ask on WhatsApp' : 'اسأل على واتساب' ?>
                        </a>
                    <?php endif; ?>
                    <a href="<?= url($siteBase . '/contact') ?>"
                       class="inline-flex items-center gap-2 glass hover:bg-cyan-500 hover:border-cyan-500 transition px-6 py-3 rounded-xl font-bold text-sm shadow-lg shadow-cyan-500/30">
                        <i class="fas fa-envelope"></i>
                        <?= $lang === 'en' ? 'Contact Us' : 'اتصل بنا' ?>
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>
</section>

<!-- FAQ Accordion Script -->
<script>
(() => {
    // Accordion toggle
    document.querySelectorAll('.faq-toggle').forEach(toggle => {
        toggle.addEventListener('click', () => {
            const item = toggle.closest('.faq-item');
            const answer = item.querySelector('.faq-answer');
            const icon = toggle.querySelector('.faq-icon');
            const isOpen = toggle.getAttribute('aria-expanded') === 'true';

            // Close all others
            document.querySelectorAll('.faq-item').forEach(other => {
                if (other !== item) {
                    other.querySelector('.faq-toggle').setAttribute('aria-expanded', 'false');
                    other.querySelector('.faq-answer').style.maxHeight = '0';
                    other.querySelector('.faq-icon').style.transform = 'rotate(0deg)';
                }
            });

            if (isOpen) {
                toggle.setAttribute('aria-expanded', 'false');
                answer.style.maxHeight = '0';
                icon.style.transform = 'rotate(0deg)';
            } else {
                toggle.setAttribute('aria-expanded', 'true');
                answer.style.maxHeight = answer.scrollHeight + 'px';
                icon.style.transform = 'rotate(45deg)';
            }
        });
    });

    // Search
    const searchInput = document.getElementById('faqSearch');
    const noResults = document.getElementById('faqNoResults');
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const term = searchInput.value.trim().toLowerCase();
            let visibleCount = 0;

            document.querySelectorAll('.faq-item').forEach(item => {
                const q = item.dataset.faqQuestion || '';
                const a = item.dataset.faqAnswer || '';
                const match = !term || q.includes(term) || a.includes(term);

                item.style.display = match ? '' : 'none';
                if (match) visibleCount++;
            });

            // Show/hide category sections
            document.querySelectorAll('.faq-category-section').forEach(sec => {
                const visibleItems = sec.querySelectorAll('.faq-item:not([style*="display: none"])');
                sec.style.display = visibleItems.length > 0 ? '' : 'none';
            });

            if (noResults) {
                noResults.classList.toggle('hidden', visibleCount > 0);
            }
        });
    }

    // Category tabs
    document.querySelectorAll('.faq-cat-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            // Update active state
            document.querySelectorAll('.faq-cat-btn').forEach(b => {
                b.classList.remove('active-cat', 'bg-cyan-500/20', 'border-cyan-400/40', 'text-cyan-300');
                b.classList.add('text-gray-300');
            });
            btn.classList.add('active-cat', 'bg-cyan-500/20', 'border-cyan-400/40', 'text-cyan-300');
            btn.classList.remove('text-gray-300');

            const cat = btn.dataset.faqCat;
            let visibleCount = 0;

            document.querySelectorAll('.faq-item').forEach(item => {
                const match = cat === 'all' || item.dataset.faqCategory === cat;
                item.style.display = match ? '' : 'none';
                if (match) visibleCount++;
            });

            // Show/hide category sections
            document.querySelectorAll('.faq-category-section').forEach(sec => {
                const secCat = sec.dataset.faqCategory;
                sec.style.display = (cat === 'all' || secCat === cat) ? '' : 'none';
            });

            // Clear search
            if (searchInput) searchInput.value = '';
            if (noResults) noResults.classList.add('hidden');
        });
    });
})();
</script>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

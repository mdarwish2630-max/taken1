<?php require_once __DIR__ . '/_head.php'; require_once __DIR__ . '/_navbar.php'; ?>

<!-- ==================== HERO BANNER ==================== -->
<section class="relative bg-[#111] pt-32 pb-24 overflow-hidden">
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="absolute top-10 left-10 w-48 h-48 bg-[#ff7a00]/10 rounded-full blur-3xl"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-20 text-center fade-up">
        <div class="orange-bar mx-auto mb-6"></div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white mb-5 uppercase">الأسئلة الشائعة</h1>
        <p class="text-white/70 text-lg max-w-2xl mx-auto">تجد هنا إجابات لأكثر الأسئلة شيوعاً حول خدماتنا</p>

        <nav class="mt-8 flex items-center justify-center gap-2 text-sm text-white/50">
            <a href="<?php echo htmlspecialchars($siteBase); ?>" class="hover:text-[#ff7a00] transition-colors">الرئيسية</a>
            <i class="fas fa-chevron-left text-[10px]"></i>
            <span class="text-[#ff7a00] font-bold">الأسئلة الشائعة</span>
        </nav>
    </div>
</section>

<!-- ==================== FAQ ==================== -->
<section class="bg-[#f4f4f4] py-24 px-6 lg:px-20">
    <div class="max-w-7xl mx-auto">
        <?php if (!empty($faqItems)): ?>

            <!-- Category Tabs -->
            <?php if (!empty($faqCategories) && count($faqCategories) > 1): ?>
            <div class="flex flex-wrap justify-center gap-3 mb-12 fade-up" id="faq-category-tabs">
                <button onclick="filterFAQ('all')" class="faq-cat-btn active bg-[#ff7a00] text-white font-black px-6 py-2.5 transition-all duration-300 text-sm" data-category="all">الكل</button>
                <?php foreach ($faqCategories as $cat): ?>
                <button onclick="filterFAQ('<?php echo htmlspecialchars($cat->id ?? $cat->slug ?? $cat); ?>')"
                        class="faq-cat-btn bg-white text-[#282828] font-black px-6 py-2.5 transition-all duration-300 hover:bg-[#ff7a00] hover:text-white text-sm"
                        data-category="<?php echo htmlspecialchars($cat->id ?? $cat->slug ?? $cat); ?>">
                    <?php echo htmlspecialchars($cat->name ?? $cat->title ?? $cat); ?>
                </button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- FAQ Accordion -->
            <div class="max-w-3xl mx-auto space-y-4" id="faq-container">
                <?php foreach ($faqItems as $index => $item): ?>
                <div class="faq-item bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 fade-up"
                     data-category="<?php echo htmlspecialchars($item->category_id ?? $item->category ?? 'all'); ?>">
                    <button onclick="toggleFAQ(<?php echo $index; ?>)" class="faq-toggle w-full flex items-center justify-between p-6 lg:p-7 text-right group" aria-expanded="false">
                        <h3 class="text-[#282828] font-black text-base lg:text-lg group-hover:text-[#ff7a00] transition-colors pr-2">
                            <?php echo htmlspecialchars($item->question ?? $item->title ?? ''); ?>
                        </h3>
                        <div class="faq-icon w-10 h-10 bg-[#f4f4f4] flex items-center justify-center shrink-0 transition-all duration-300">
                            <i class="fas fa-chevron-down text-[#ff7a00] transition-transform duration-300 faq-chevron text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-answer max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                        <div class="px-6 lg:px-7 pb-6 lg:pb-7 pt-0">
                            <div class="w-full h-px bg-[#f4f4f4] mb-5"></div>
                            <p class="text-gray-500 leading-relaxed text-sm lg:text-base pr-2">
                                <?php echo htmlspecialchars($item->answer ?? $item->content ?? $item->description ?? ''); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <script>
            function toggleFAQ(index) {
                document.querySelectorAll('.faq-item').forEach((item, i) => {
                    const answer = item.querySelector('.faq-answer');
                    const icon = item.querySelector('.faq-chevron');
                    if (i === index) {
                        const isOpen = answer.style.maxHeight && answer.style.maxHeight !== '0px';
                        if (isOpen) { answer.style.maxHeight = '0px'; icon.style.transform = 'rotate(0deg)'; }
                        else { answer.style.maxHeight = answer.scrollHeight + 'px'; icon.style.transform = 'rotate(180deg)'; }
                    } else { answer.style.maxHeight = '0px'; icon.style.transform = 'rotate(0deg)'; }
                });
            }
            function filterFAQ(category) {
                document.querySelectorAll('.faq-cat-btn').forEach(btn => {
                    if (btn.dataset.category === category) { btn.classList.remove('bg-white','text-[#282828]'); btn.classList.add('bg-[#ff7a00]','text-white','active'); }
                    else { btn.classList.remove('bg-[#ff7a00]','text-white','active'); btn.classList.add('bg-white','text-[#282828]'); }
                });
                document.querySelectorAll('.faq-item').forEach(item => {
                    if (category === 'all' || item.dataset.category === category) { item.style.display = ''; item.style.animation = 'fadeInUp 0.4s ease forwards'; }
                    else { item.style.display = 'none'; }
                });
            }
            </script>
            <style>@keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }</style>

        <?php else: ?>
        <div class="text-center py-20 fade-up">
            <div class="text-7xl mb-6"><i class="fas fa-question-circle text-[#ff7a00]/40"></i></div>
            <h3 class="text-2xl font-black text-[#282828] mb-3">لا توجد أسئلة حالياً</h3>
            <p class="text-gray-500 mb-8">يمكنك التواصل معنا مباشرة لأي استفسار</p>
            <a href="<?php echo htmlspecialchars($siteBase); ?>/contact" class="bg-[#ff7a00] text-white font-black px-8 py-4 hover:bg-[#282828] transition-all duration-300 inline-block">
                تواصل معنا
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ==================== CTA ==================== -->
<section class="bg-[#151515] py-28 px-6 lg:px-20 fade-up">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-[1fr_.75fr] gap-12 items-center">
        <div>
            <p class="text-[#ff7a00] font-black text-xl mb-5">لم تجد إجابتك؟</p>
            <h2 class="text-white text-5xl lg:text-7xl font-black leading-tight uppercase mb-8">تواصل معنا</h2>
            <p class="text-gray-300 text-xl leading-loose max-w-3xl">لا تتردد في التواصل معنا وسنجيب على جميع استفساراتك</p>
        </div>
        <div class="bg-[#ff7a00] p-10 text-center">
            <h3 class="text-[#282828] font-black text-2xl mb-6">نحن هنا لمساعدتك</h3>
            <a href="<?php echo htmlspecialchars($siteBase); ?>/contact" class="bg-white text-[#282828] px-10 py-5 font-black hover:bg-[#282828] hover:text-white transition-all duration-300 inline-block">
                تواصل معنا
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; require_once __DIR__ . '/_scripts.php'; ?>

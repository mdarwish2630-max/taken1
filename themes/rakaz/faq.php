<?php include __DIR__ . '/partials/_head.php'; ?>
<?php include __DIR__ . '/partials/_navbar.php'; ?>

<!-- Page Header -->
<section class="hero-gradient relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 right-20 w-60 h-60 bg-primary rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 relative z-10 text-center">
        <span class="inline-block bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full text-sm text-accent mb-6">
            <i class="fas fa-question-circle ml-2"></i> الأسئلة الشائعة
        </span>
        <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-4">
            <?php echo htmlspecialchars($page['heading'] ?? 'الأسئلة المتكررة'); ?>
        </h1>
        <p class="text-lg text-white/70 max-w-2xl mx-auto">
            <?php echo htmlspecialchars($page['subheading'] ?? 'إجابات على أكثر الأسئلة شيوعاً حول خدماتنا'); ?>
        </p>
    </div>
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 60" fill="none"><path d="M0 30L60 25C120 20 240 10 360 8.3C480 6.7 600 13.3 720 18.3C840 23.3 960 26.7 1080 25C1200 23.3 1320 16.7 1380 13.3L1440 10V60H1380C1320 60 1200 60 1080 60C960 60 840 60 720 60C600 60 480 60 360 60C240 60 120 60 60 60H0V30Z" fill="#f8f5f1"/></svg>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if (!empty($faqItems)): ?>
            <div class="space-y-4">
                <?php foreach ($faqItems as $idx => $faq): ?>
                    <div class="faq-item bg-white rounded-card overflow-hidden" data-aos="fade-up" data-aos-delay="<?php echo min($idx * 50, 300); ?>">
                        <button class="faq-question w-full text-right p-6 flex items-center justify-between gap-4 hover:bg-warm-50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-question text-primary text-sm"></i>
                                </div>
                                <h3 class="text-base font-bold text-secondary"><?php echo htmlspecialchars($faq['title'] ?? ''); ?></h3>
                            </div>
                            <i class="fas fa-chevron-down faq-icon text-primary text-sm transition-transform duration-300 flex-shrink-0"></i>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6">
                            <div class="pr-14 text-gray-600 text-sm leading-relaxed">
                                <?php echo $faq['content'] ?? ''; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-card p-12 text-center" data-aos="fade-up">
                <i class="fas fa-question-circle text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-400 text-lg">لا توجد أسئلة شائعة حالياً</p>
            </div>
        <?php endif; ?>

        <!-- Still have questions -->
        <div class="mt-14 bg-gradient-to-br from-primary to-accent rounded-card p-10 text-center text-white" data-aos="fade-up">
            <h3 class="text-2xl font-bold mb-3">لم تجد إجابتك؟</h3>
            <p class="text-white/80 mb-6">تواصل معنا مباشرة وسنجيب على جميع استفساراتك</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="<?php echo ($siteBase ?? '/') . '/contact'; ?>" class="bg-white text-primary px-8 py-3 rounded-full font-bold hover:bg-warm-100 transition-all duration-300 inline-flex items-center gap-2">
                    <span>تواصل معنا</span>
                    <i class="fas fa-arrow-left"></i>
                </a>
                <?php if (!empty($social_whatsapp)): ?>
                    <a href="<?php echo htmlspecialchars($social_whatsapp); ?>" target="_blank" class="bg-green-500 text-white px-8 py-3 rounded-full font-bold hover:bg-green-600 transition-all duration-300 inline-flex items-center gap-2">
                        <i class="fab fa-whatsapp"></i>
                        <span>واتساب</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/partials/_footer.php'; ?>
<?php include __DIR__ . '/partials/_scripts.php'; ?>

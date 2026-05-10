<?php include __DIR__ . '/partials/_head.php'; ?>
<?php include __DIR__ . '/partials/_navbar.php'; ?>

<!-- Page Header -->
<section class="hero-gradient relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 right-20 w-60 h-60 bg-primary rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 relative z-10 text-center">
        <span class="inline-block bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full text-sm text-accent mb-6">
            <i class="fas fa-handshake ml-2"></i> شركاؤنا
        </span>
        <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-4">
            <?php echo htmlspecialchars($page['heading'] ?? 'شركاء النجاح'); ?>
        </h1>
        <p class="text-lg text-white/70 max-w-2xl mx-auto">
            <?php echo htmlspecialchars($page['subheading'] ?? 'نفتخر بشراكتنا مع نخبة من الشركات والمؤسسات الرائدة'); ?>
        </p>
    </div>
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 60" fill="none"><path d="M0 30L60 25C120 20 240 10 360 8.3C480 6.7 600 13.3 720 18.3C840 23.3 960 26.7 1080 25C1200 23.3 1320 16.7 1380 13.3L1440 10V60H1380C1320 60 1200 60 1080 60C960 60 840 60 720 60C600 60 480 60 360 60C240 60 120 60 60 60H0V30Z" fill="#f8f5f1"/></svg>
    </div>
</section>

<!-- Partners Section -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if (!empty($partnerItems)): ?>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                <?php foreach ($partnerItems as $idx => $partner): ?>
                    <div class="partner-logo bg-white rounded-card p-8 flex flex-col items-center justify-center text-center border border-warm-200 hover:border-primary/30 transition-all duration-300" data-aos="fade-up" data-aos-delay="<?php echo min($idx * 80, 400); ?>">
                        <div class="w-16 h-16 bg-warm-100 rounded-2xl flex items-center justify-center mb-4">
                            <i class="<?php echo htmlspecialchars($partner['icon'] ?? 'fas fa-building'); ?> text-3xl text-primary/60"></i>
                        </div>
                        <h3 class="text-sm font-bold text-secondary"><?php echo htmlspecialchars($partner['title'] ?? ''); ?></h3>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <div class="bg-white rounded-card p-8 flex flex-col items-center justify-center text-center border border-warm-200" data-aos="fade-up">
                        <div class="w-16 h-16 bg-warm-100 rounded-2xl flex items-center justify-center mb-4">
                            <i class="fas fa-building text-3xl text-primary/40"></i>
                        </div>
                        <h3 class="text-sm font-bold text-gray-400">شريك <?php echo $i; ?></h3>
                    </div>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Why Partner With Us -->
<section class="py-16 bg-warm-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14" data-aos="fade-up">
            <span class="inline-block bg-primary/10 text-primary px-4 py-2 rounded-full text-sm font-semibold mb-4">شراكة ناجحة</span>
            <h2 class="text-3xl font-extrabold text-secondary mb-4">لماذا تختار الشراكة معنا؟</h2>
            <div class="section-divider mx-auto"></div>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-card p-8 text-center" data-aos="fade-up">
                <div class="w-16 h-16 mx-auto mb-5 bg-primary/10 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-trophy text-3xl text-primary"></i>
                </div>
                <h3 class="text-lg font-bold text-secondary mb-3">جودة عالية</h3>
                <p class="text-gray-500 text-sm leading-relaxed">نلتزم بأعلى معايير الجودة في جميع خدماتنا مما يعكس إيجابياً على شركائنا.</p>
            </div>
            <div class="bg-white rounded-card p-8 text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 mx-auto mb-5 bg-primary/10 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-handshake text-3xl text-primary"></i>
                </div>
                <h3 class="text-lg font-bold text-secondary mb-3">علاقات طويلة الأمد</h3>
                <p class="text-gray-500 text-sm leading-relaxed">نبني علاقات شراكة مستدامة مبنية على الثقة والشفافية والاحترام المتبادل.</p>
            </div>
            <div class="bg-white rounded-card p-8 text-center" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 mx-auto mb-5 bg-primary/10 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-chart-line text-3xl text-primary"></i>
                </div>
                <h3 class="text-lg font-bold text-secondary mb-3">نمو مشترك</h3>
                <p class="text-gray-500 text-sm leading-relaxed">نعمل على تحقيق نمو مشترك مع شركائنا من خلال التميز في الخدمات المقدمة.</p>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/partials/_footer.php'; ?>
<?php include __DIR__ . '/partials/_scripts.php'; ?>

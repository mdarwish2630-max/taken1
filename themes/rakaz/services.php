<?php include __DIR__ . '/partials/_head.php'; ?>
<?php include __DIR__ . '/partials/_navbar.php'; ?>

<!-- Page Header -->
<section class="hero-gradient relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 right-20 w-72 h-72 bg-primary rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 relative z-10 text-center">
        <span class="inline-block bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full text-sm text-accent mb-6">
            <i class="fas fa-th-large ml-2"></i> خدماتنا
        </span>
        <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-4">
            <?php echo htmlspecialchars($page['heading'] ?? 'خدماتنا المتميزة'); ?>
        </h1>
        <p class="text-lg text-white/70 max-w-2xl mx-auto">
            <?php echo htmlspecialchars($page['subheading'] ?? 'نقدم مجموعة واسعة من خدمات الصيانة المتخصصة'); ?>
        </p>
    </div>
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 60" fill="none"><path d="M0 30L60 25C120 20 240 10 360 8.3C480 6.7 600 13.3 720 18.3C840 23.3 960 26.7 1080 25C1200 23.3 1320 16.7 1380 13.3L1440 10V60H1380C1320 60 1200 60 1080 60C960 60 840 60 720 60C600 60 480 60 360 60C240 60 120 60 60 60H0V30Z" fill="#f8f5f1"/></svg>
    </div>
</section>

<!-- Services Grid -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if (!empty($services)): ?>
                <?php foreach ($services as $idx => $svc): ?>
                    <a href="<?php echo ($siteBase ?? '/') . '/service/' . ($svc['slug'] ?? ''); ?>" class="card-hover bg-white rounded-card overflow-hidden group" data-aos="fade-up" data-aos-delay="<?php echo ($idx % 3) * 100; ?>">
                        <!-- Service Icon Area -->
                        <div class="h-48 bg-gradient-to-br from-warm-100 to-warm-200 flex items-center justify-center relative">
                            <div class="service-icon-wrapper w-24 h-24 rounded-3xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="<?php echo htmlspecialchars($svc['icon'] ?? 'fas fa-cog'); ?> text-4xl text-primary"></i>
                            </div>
                            <div class="absolute top-4 left-4 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm">
                                <span class="text-primary font-bold text-sm"><?php echo $idx + 1; ?></span>
                            </div>
                        </div>
                        <!-- Service Info -->
                        <div class="p-7">
                            <h3 class="text-xl font-bold text-secondary mb-3 group-hover:text-primary transition-colors">
                                <?php echo htmlspecialchars($svc['title'] ?? ''); ?>
                            </h3>
                            <p class="text-gray-500 text-sm leading-relaxed mb-5 line-clamp-3">
                                <?php echo strip_tags($svc['content'] ?? ''); ?>
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-primary text-sm font-semibold flex items-center gap-2">
                                    <span>اطلب الخدمة</span>
                                    <i class="fas fa-arrow-left text-xs group-hover:-translate-x-1 transition-transform"></i>
                                </span>
                                <span class="text-gray-400 text-xs">
                                    <i class="fas fa-clock ml-1"></i> خدمة فورية
                                </span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full text-center py-16">
                    <i class="fas fa-tools text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-400 text-lg">لا توجد خدمات حالياً</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="fade-up">
        <div class="bg-secondary rounded-card p-10 relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-2xl lg:text-3xl font-extrabold text-white mb-3">لم تجد ما تبحث عنه؟</h2>
                <p class="text-white/70 mb-6">تواصل معنا وسنقدم لك الخدمة التي تحتاجها. نغطي جميع مجالات الصيانة.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="<?php echo ($siteBase ?? '/') . '/contact'; ?>" class="btn-primary text-white px-8 py-3 rounded-full font-bold inline-flex items-center gap-2">
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
    </div>
</section>

<?php include __DIR__ . '/partials/_footer.php'; ?>
<?php include __DIR__ . '/partials/_scripts.php'; ?>

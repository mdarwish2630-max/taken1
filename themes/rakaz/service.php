<?php 
// Service Detail Page
// $service = current service data, $services = all services list
?>
<?php include __DIR__ . '/partials/_head.php'; ?>
<?php include __DIR__ . '/partials/_navbar.php'; ?>

<!-- Page Header -->
<section class="hero-gradient relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 left-20 w-60 h-60 bg-primary rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 relative z-10">
        <div class="max-w-3xl">
            <!-- Breadcrumb -->
            <div class="flex items-center gap-2 text-white/60 text-sm mb-6">
                <a href="<?php echo $siteBase ?? '/'; ?>" class="hover:text-white transition-colors">الرئيسية</a>
                <i class="fas fa-chevron-left text-xs"></i>
                <a href="<?php echo ($siteBase ?? '/') . '/services'; ?>" class="hover:text-white transition-colors">خدماتنا</a>
                <i class="fas fa-chevron-left text-xs"></i>
                <span class="text-accent"><?php echo htmlspecialchars($service['title'] ?? ''); ?></span>
            </div>
            
            <div class="flex items-center gap-4 mb-6">
                <?php if (!empty($service['icon'])): ?>
                    <div class="w-16 h-16 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                        <i class="<?php echo htmlspecialchars($service['icon']); ?> text-3xl text-accent"></i>
                    </div>
                <?php endif; ?>
                <div>
                    <span class="inline-block bg-primary/20 text-accent px-3 py-1 rounded-full text-xs font-semibold mb-2">
                        خدمة متخصصة
                    </span>
                    <h1 class="text-3xl lg:text-5xl font-extrabold text-white">
                        <?php echo htmlspecialchars($service['title'] ?? ''); ?>
                    </h1>
                </div>
            </div>
            <p class="text-lg text-white/70 leading-relaxed max-w-xl">
                <?php echo htmlspecialchars($service['subheading'] ?? 'خدمة احترافية من فريق ركاز'); ?>
            </p>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 60" fill="none"><path d="M0 30L60 25C120 20 240 10 360 8.3C480 6.7 600 13.3 720 18.3C840 23.3 960 26.7 1080 25C1200 23.3 1320 16.7 1380 13.3L1440 10V60H1380C1320 60 1200 60 1080 60C960 60 840 60 720 60C600 60 480 60 360 60C240 60 120 60 60 60H0V30Z" fill="#f8f5f1"/></svg>
    </div>
</section>

<!-- Service Content -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-10">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Service Description -->
                <div class="bg-white rounded-card p-8 lg:p-10 mb-8" data-aos="fade-up">
                    <h2 class="text-2xl font-bold text-secondary mb-6 flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
                            <i class="fas fa-info-circle text-primary"></i>
                        </div>
                        نبذة عن الخدمة
                    </h2>
                    <div class="text-gray-600 leading-relaxed text-base">
                        <?php echo $service['content'] ?? '<p>تفاصيل الخدمة</p>'; ?>
                    </div>
                </div>

                <!-- Service Features -->
                <?php if (!empty($siteFeatures)): ?>
                <div class="bg-white rounded-card p-8 lg:p-10 mb-8" data-aos="fade-up">
                    <h2 class="text-2xl font-bold text-secondary mb-6 flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
                            <i class="fas fa-list-check text-primary"></i>
                        </div>
                        مميزات هذه الخدمة
                    </h2>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <?php foreach (array_slice($siteFeatures, 0, 6) as $feat): ?>
                            <div class="flex items-start gap-3 p-4 bg-warm-100 rounded-2xl">
                                <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i class="<?php echo htmlspecialchars($feat['icon'] ?? 'fas fa-check'); ?> text-primary text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-secondary text-sm mb-1"><?php echo htmlspecialchars($feat['title'] ?? ''); ?></h4>
                                    <p class="text-gray-500 text-xs leading-relaxed"><?php echo htmlspecialchars($feat['content'] ?? ''); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Testimonials -->
                <?php if (!empty($testimonials)): ?>
                <div class="bg-white rounded-card p-8 lg:p-10" data-aos="fade-up">
                    <h2 class="text-2xl font-bold text-secondary mb-6 flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
                            <i class="fas fa-comments text-primary"></i>
                        </div>
                        آراء العملاء
                    </h2>
                    <div class="space-y-4">
                        <?php foreach ($testimonials as $test): ?>
                            <div class="bg-warm-100 rounded-2xl p-5">
                                <div class="flex gap-1 mb-3">
                                    <?php for ($i = 0; $i < 5; $i++): ?>
                                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                                    <?php endfor; ?>
                                </div>
                                <p class="text-gray-600 text-sm leading-relaxed mb-3"><?php echo htmlspecialchars($test['content'] ?? ''); ?></p>
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-primary/20 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-primary text-xs"></i>
                                    </div>
                                    <span class="text-secondary font-semibold text-sm"><?php echo htmlspecialchars($test['title'] ?? ''); ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Quick Booking Card -->
                <div class="bg-gradient-to-br from-primary to-accent rounded-card p-8 text-white sticky top-28" data-aos="fade-up">
                    <h3 class="text-xl font-bold mb-2">هل تحتاج هذه الخدمة؟</h3>
                    <p class="text-white/80 text-sm mb-6">احجز موعد الآن واحصل على خدمة احترافية</p>
                    <a href="<?php echo ($siteBase ?? '/') . '/booking'; ?>" class="block bg-white text-primary text-center px-6 py-3 rounded-full font-bold hover:bg-warm-100 transition-all duration-300 mb-3">
                        احجز الآن
                    </a>
                    <?php if (!empty($contact_phone)): ?>
                        <a href="tel:<?php echo htmlspecialchars($contact_phone); ?>" class="block bg-white/10 backdrop-blur-sm text-white text-center px-6 py-3 rounded-full font-bold hover:bg-white/20 transition-all duration-300">
                            <i class="fas fa-phone-alt ml-2"></i> اتصل مباشرة
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($social_whatsapp)): ?>
                        <a href="<?php echo htmlspecialchars($social_whatsapp); ?>" target="_blank" class="block mt-3 bg-green-500 text-white text-center px-6 py-3 rounded-full font-bold hover:bg-green-600 transition-all duration-300">
                            <i class="fab fa-whatsapp ml-2"></i> واتساب
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Other Services -->
                <?php if (!empty($services)): ?>
                <div class="bg-white rounded-card p-7" data-aos="fade-up">
                    <h3 class="text-lg font-bold text-secondary mb-5 flex items-center gap-2">
                        <i class="fas fa-th-list text-primary"></i>
                        خدمات أخرى
                    </h3>
                    <div class="space-y-2">
                        <?php foreach ($services as $svc): ?>
                            <?php if (($svc['slug'] ?? '') !== ($service['slug'] ?? '')): ?>
                                <a href="<?php echo ($siteBase ?? '/') . '/service/' . ($svc['slug'] ?? ''); ?>" class="flex items-center gap-3 p-3 rounded-2xl hover:bg-warm-100 transition-all duration-300 group">
                                    <div class="w-10 h-10 bg-warm-100 group-hover:bg-primary/10 rounded-xl flex items-center justify-center transition-colors">
                                        <i class="<?php echo htmlspecialchars($svc['icon'] ?? 'fas fa-cog'); ?> text-primary text-sm"></i>
                                    </div>
                                    <span class="text-secondary text-sm font-medium group-hover:text-primary transition-colors">
                                        <?php echo htmlspecialchars($svc['title'] ?? ''); ?>
                                    </span>
                                    <i class="fas fa-chevron-left text-xs text-gray-400 mr-auto"></i>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Stats -->
                <?php if (!empty($siteStats)): ?>
                <div class="bg-secondary rounded-card p-7" data-aos="fade-up">
                    <h3 class="text-lg font-bold text-white mb-5 flex items-center gap-2">
                        <i class="fas fa-chart-bar text-accent"></i>
                        إنجازاتنا
                    </h3>
                    <div class="space-y-4">
                        <?php foreach ($siteStats as $stat): ?>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-primary/20 rounded-xl flex items-center justify-center">
                                    <i class="<?php echo htmlspecialchars($stat['icon'] ?? 'fas fa-chart-line'); ?> text-accent text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-white font-bold text-sm"><?php echo htmlspecialchars($stat['title'] ?? ''); ?></p>
                                    <p class="text-white/50 text-xs"><?php echo htmlspecialchars($stat['content'] ?? ''); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/partials/_footer.php'; ?>
<?php include __DIR__ . '/partials/_scripts.php'; ?>

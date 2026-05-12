<?php include __DIR__ . '/partials/_head.php'; ?>
<?php include __DIR__ . '/partials/_navbar.php'; ?>

<?php
// --- Hero Section Data ---
$heroTitle = '';
$heroSubtitle = '';
$heroBadge = $tenant->site_name ?? 'ركاز';
if (!empty($banners)) {
    $heroTitle = ($lang === 'en') ? ($banners[0]->title_en ?? $banners[0]->title ?? '') : ($banners[0]->title ?? '');
    $heroSubtitle = ($lang === 'en') ? ($banners[0]->subtitle_en ?? $banners[0]->subtitle ?? '') : ($banners[0]->subtitle ?? '');
}
if (empty($heroTitle)) {
    $heroTitle = ($lang === 'en') ? 'Reliable Maintenance Solutions for Your Home' : 'حلول صيانة موثوقة لمنزلك';
}
if (empty($heroSubtitle)) {
    $heroSubtitle = ($lang === 'en') ? 'We provide comprehensive maintenance services by professional technicians at competitive prices' : 'نقدم خدمات صيانة شاملة بأيدي فنيين محترفين وبأسعار تنافسية';
}
$heroBtnBook = ($lang === 'en') ? 'Book Now' : 'احجز موعد الآن';
$heroBtnServices = ($lang === 'en') ? 'Our Services' : 'خدماتنا';

// --- CTA Section Data ---
$ctaTitle = ($lang === 'en') ? ($tenant->cta_title_en ?? 'Need Professional Service?') : ($tenant->cta_title ?? 'هل تحتاج خدمة صيانة؟');
$ctaText = ($lang === 'en') ? ($tenant->cta_text_en ?? 'Contact our team now and get a free consultation. Our team is ready to serve you 24/7.') : ($tenant->cta_text ?? 'تواصل معنا الآن واحصل على استشارة مجانية. فريقنا جاهز لخدمتك على مدار الساعة.');
$ctaBtn = ($lang === 'en') ? ($tenant->cta_button_text_en ?? 'Book Now') : ($tenant->cta_button_text ?? 'احجز موعد');
$ctaActive = $tenant->cta_is_active ?? true;
$ctaBtnCall = ($lang === 'en') ? 'Call Now' : 'اتصل الآن';

// --- Helper: services section heading ---
$servicesHeading = ($lang === 'en') ? 'All You Need Under One Roof' : 'كل ما تحتاجه تحت سقف واحد';
if (!empty($banners)) {
    $servicesHeading = ($lang === 'en') ? ($banners[0]->title_en ?? $banners[0]->title ?? $servicesHeading) : ($banners[0]->title ?? $servicesHeading);
}

// --- Helper: localized field ---
function rakaz_field($obj, $field, $lang) {
    if ($lang === 'en') {
        return $obj->{$field . '_en'} ?? $obj->$field ?? '';
    }
    return $obj->$field ?? '';
}
?>

<!-- Hero Section -->
<section class="hero-gradient relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 right-20 w-72 h-72 bg-primary rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-20 w-96 h-96 bg-accent rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-36 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="text-white">
                <span class="inline-block bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full text-sm text-accent mb-6">
                    <i class="fas fa-tools ml-2"></i> <?php echo htmlspecialchars($heroBadge); ?>
                </span>
                <h1 class="text-4xl lg:text-6xl font-extrabold leading-tight mb-6">
                    <?php echo htmlspecialchars($heroTitle); ?>
                </h1>
                <p class="text-lg text-white/80 leading-relaxed mb-8 max-w-lg">
                    <?php echo htmlspecialchars($heroSubtitle); ?>
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="<?php echo url(($siteBase ?? '/') . '/booking'); ?>" class="btn-primary text-white px-8 py-4 rounded-full font-bold text-lg inline-flex items-center gap-2">
                        <span><?php echo htmlspecialchars($heroBtnBook); ?></span>
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <a href="<?php echo url(($siteBase ?? '/') . '/services'); ?>" class="bg-white/10 backdrop-blur-sm text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white/20 transition-all duration-300 inline-flex items-center gap-2">
                        <span><?php echo htmlspecialchars($heroBtnServices); ?></span>
                        <i class="fas fa-th-large"></i>
                    </a>
                </div>
            </div>
            <div class="hidden lg:flex justify-center">
                <div class="relative">
                    <div class="w-80 h-80 bg-primary/20 rounded-card flex items-center justify-center backdrop-blur-sm border border-white/10">
                        <i class="fas fa-tools text-9xl text-accent/60"></i>
                    </div>
                    <div class="absolute -bottom-4 -left-4 bg-white rounded-2xl p-4 shadow-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-secondary">+12000</p>
                                <p class="text-xs text-gray-500"><?php echo ($lang === 'en') ? 'Completed Services' : 'خدمة مكتملة'; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -top-4 -right-4 bg-white rounded-2xl p-4 shadow-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-star text-yellow-500"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-secondary">4.9/5</p>
                                <p class="text-xs text-gray-500"><?php echo ($lang === 'en') ? 'Customer Rating' : 'تقييم العملاء'; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Wave Divider -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 50L48 45.7C96 41.3 192 32.7 288 30.2C384 27.7 480 31.3 576 38.5C672 45.7 768 56.3 864 58.8C960 61.3 1056 55.7 1152 48.5C1248 41.3 1344 32.7 1392 28.3L1440 24V100H1392C1344 100 1248 100 1152 100C1056 100 960 100 864 100C768 100 672 100 576 100C480 100 384 100 288 100C192 100 96 100 48 100H0V50Z" fill="#f8f5f1"/>
        </svg>
    </div>
</section>

<!-- Stats Section -->
<?php if (!empty($siteStats)): ?>
<section class="py-16 bg-warm-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <?php foreach ($siteStats as $stat): ?>
                <div class="stat-card rounded-card p-8 text-center text-white" data-aos="fade-up">
                    <div class="w-14 h-14 mx-auto mb-4 bg-primary/20 rounded-2xl flex items-center justify-center">
                        <i class="<?php echo htmlspecialchars($stat->icon ?? 'fas fa-chart-line'); ?> text-2xl text-accent"></i>
                    </div>
                    <h3 class="text-3xl lg:text-4xl font-extrabold text-primary mb-2"><?php echo htmlspecialchars($stat->value ?? ''); ?></h3>
                    <p class="text-white/70 text-sm"><?php echo htmlspecialchars(rakaz_field($stat, 'label', $lang)); ?><?php if (!empty($stat->suffix)): echo ' ' . htmlspecialchars($stat->suffix); endif; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Services Section -->
<?php if (!empty($services)): ?>
<section class="py-20 bg-warm-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14" data-aos="fade-up">
            <span class="inline-block bg-primary/10 text-primary px-4 py-2 rounded-full text-sm font-semibold mb-4"><?php echo ($lang === 'en') ? 'Our Outstanding Services' : 'خدماتنا المتميزة'; ?></span>
            <h2 class="text-3xl lg:text-4xl font-extrabold text-secondary mb-4">
                <?php echo htmlspecialchars($servicesHeading); ?>
            </h2>
            <div class="section-divider mx-auto"></div>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach (array_slice($services, 0, 8) as $svc): ?>
                <a href="<?php echo url(($siteBase ?? '/') . '/service/' . ($svc->slug ?? '')); ?>" class="card-hover bg-white rounded-card p-7 block group" data-aos="fade-up">
                    <div class="service-icon-wrapper w-16 h-16 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-primary/20 transition-colors duration-300">
                        <i class="<?php echo htmlspecialchars($svc->icon ?? 'fas fa-cog'); ?> text-2xl text-primary"></i>
                    </div>
                    <h3 class="text-lg font-bold text-secondary mb-3 group-hover:text-primary transition-colors">
                        <?php echo htmlspecialchars(rakaz_field($svc, 'title', $lang)); ?>
                    </h3>
                    <p class="text-gray-500 text-sm leading-relaxed line-clamp-2">
                        <?php echo strip_tags(rakaz_field($svc, 'description', $lang)); ?>
                    </p>
                    <div class="mt-5 flex items-center gap-2 text-primary text-sm font-semibold">
                        <span><?php echo ($lang === 'en') ? 'Details' : 'التفاصيل'; ?></span>
                        <i class="fas fa-arrow-left text-xs group-hover:-translate-x-1 transition-transform"></i>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-12">
            <a href="<?php echo url(($siteBase ?? '/') . '/services'); ?>" class="btn-primary text-white px-8 py-4 rounded-full font-bold inline-flex items-center gap-2">
                <span><?php echo ($lang === 'en') ? 'View All Services' : 'عرض جميع الخدمات'; ?></span>
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Features Section -->
<?php if (!empty($siteFeatures)): ?>
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14" data-aos="fade-up">
            <span class="inline-block bg-primary/10 text-primary px-4 py-2 rounded-full text-sm font-semibold mb-4"><?php echo ($lang === 'en') ? 'Why Choose Us' : 'لماذا تختارنا'; ?></span>
            <h2 class="text-3xl lg:text-4xl font-extrabold text-secondary mb-4"><?php echo ($lang === 'en') ? 'Our Distinguishing Features' : 'مميزاتنا التي تفرقنا'; ?></h2>
            <div class="section-divider mx-auto"></div>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($siteFeatures as $feat): ?>
                <div class="bg-white rounded-card p-7 border border-warm-200 hover:border-primary/30 transition-all duration-300" data-aos="fade-up">
                    <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center mb-5">
                        <i class="<?php echo htmlspecialchars($feat->icon ?? 'fas fa-check'); ?> text-2xl text-primary"></i>
                    </div>
                    <h3 class="text-lg font-bold text-secondary mb-3"><?php echo htmlspecialchars(rakaz_field($feat, 'title', $lang)); ?></h3>
                    <p class="text-gray-500 text-sm leading-relaxed"><?php echo htmlspecialchars(rakaz_field($feat, 'description', $lang)); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Testimonials Section -->
<?php if (!empty($testimonials)): ?>
<section class="py-20 bg-secondary relative overflow-hidden">
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-10 right-10 w-60 h-60 bg-primary rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 left-10 w-80 h-80 bg-accent rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-14" data-aos="fade-up">
            <span class="inline-block bg-primary/20 text-accent px-4 py-2 rounded-full text-sm font-semibold mb-4"><?php echo ($lang === 'en') ? 'Our Clients Reviews' : 'آراء عملائنا'; ?></span>
            <h2 class="text-3xl lg:text-4xl font-extrabold text-white mb-4"><?php echo ($lang === 'en') ? 'What Our Clients Say' : 'ماذا يقول عملاؤنا'; ?></h2>
            <div class="section-divider mx-auto"></div>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($testimonials as $test): ?>
                <div class="bg-white/5 backdrop-blur-sm rounded-card p-7 border border-white/10 hover:border-primary/30 transition-all duration-300" data-aos="fade-up">
                    <div class="flex gap-1 mb-4">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <i class="fas fa-star text-sm <?php echo ($i < ($test->rating ?? 5)) ? 'text-yellow-400' : 'text-white/20'; ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="text-white/70 text-sm leading-relaxed mb-5"><?php echo htmlspecialchars(rakaz_field($test, 'content', $lang)); ?></p>
                    <div class="flex items-center gap-3">
                        <?php if (!empty($test->client_image)): ?>
                            <img src="<?php echo htmlspecialchars($test->client_image); ?>" alt="<?php echo htmlspecialchars($test->client_name ?? ''); ?>" class="w-10 h-10 rounded-full object-cover">
                        <?php else: ?>
                            <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-accent text-sm"></i>
                            </div>
                        <?php endif; ?>
                        <div>
                            <h4 class="text-white font-semibold text-sm"><?php echo htmlspecialchars($test->client_name ?? ''); ?></h4>
                            <?php if (!empty(rakaz_field($test, 'client_title', $lang))): ?>
                                <p class="text-white/50 text-xs"><?php echo htmlspecialchars(rakaz_field($test, 'client_title', $lang)); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA Section -->
<?php if ($ctaActive): ?>
<section class="py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="fade-up">
        <div class="bg-gradient-to-br from-primary to-accent rounded-card p-12 lg:p-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 right-0 w-40 h-40 bg-white rounded-full blur-2xl"></div>
                <div class="absolute bottom-0 left-0 w-60 h-60 bg-white rounded-full blur-2xl"></div>
            </div>
            <div class="relative z-10">
                <h2 class="text-3xl lg:text-4xl font-extrabold text-white mb-4"><?php echo htmlspecialchars($ctaTitle); ?></h2>
                <p class="text-white/80 text-lg mb-8 max-w-lg mx-auto"><?php echo htmlspecialchars($ctaText); ?></p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="<?php echo url(($siteBase ?? '/') . '/booking'); ?>" class="bg-white text-primary px-8 py-4 rounded-full font-bold text-lg hover:bg-warm-100 transition-all duration-300 inline-flex items-center gap-2">
                        <span><?php echo htmlspecialchars($ctaBtn); ?></span>
                        <i class="fas fa-calendar-check"></i>
                    </a>
                    <?php if (!empty($tenant->contact_phone)): ?>
                        <a href="tel:<?php echo htmlspecialchars(preg_replace('/[^0-9+]/', '', $tenant->contact_phone)); ?>" class="bg-white/10 backdrop-blur-sm text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white/20 transition-all duration-300 inline-flex items-center gap-2">
                            <i class="fas fa-phone-alt"></i>
                            <span><?php echo htmlspecialchars($ctaBtnCall); ?></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php include __DIR__ . '/partials/_footer.php'; ?>
<?php include __DIR__ . '/partials/_scripts.php'; ?>

<?php require_once __DIR__ . '/_head.php'; require_once __DIR__ . '/_navbar.php'; ?>

<?php if (empty($service)): ?>
<!-- Service Not Found -->
<section class="min-h-screen flex items-center justify-center bg-white">
    <div class="text-center">
        <div class="text-7xl mb-6"><i class="fas fa-search text-[#ff7a00]"></i></div>
        <h1 class="text-3xl font-black text-[#282828] mb-4">الخدمة غير موجودة</h1>
        <p class="text-gray-500 mb-8">لم نتمكن من العثور على الخدمة المطلوبة</p>
        <a href="<?php echo htmlspecialchars($siteBase); ?>/services"
           class="bg-[#ff7a00] text-white font-black px-8 py-4 hover:bg-[#282828] transition-all duration-300 inline-block">
            تصفح الخدمات
        </a>
    </div>
</section>
<?php else: ?>

<!-- ==================== BREADCRUMB ==================== -->
<section class="bg-white pt-28 pb-6">
    <div class="max-w-7xl mx-auto px-6 lg:px-20 fade-up">
        <nav class="flex items-center gap-2 text-sm text-gray-400">
            <a href="<?php echo htmlspecialchars($siteBase); ?>" class="hover:text-[#ff7a00] transition-colors">الرئيسية</a>
            <i class="fas fa-chevron-left text-[10px]"></i>
            <a href="<?php echo htmlspecialchars($siteBase); ?>/services" class="hover:text-[#ff7a00] transition-colors">خدماتنا</a>
            <i class="fas fa-chevron-left text-[10px]"></i>
            <span class="text-[#ff7a00] font-bold"><?php echo htmlspecialchars($service->title); ?></span>
        </nav>
    </div>
</section>

<!-- ==================== SERVICE HERO ==================== -->
<section class="bg-white pb-16">
    <div class="max-w-7xl mx-auto px-6 lg:px-20">
        <div class="bg-[#f4f4f4] overflow-hidden shadow-sm fade-up">
            <div class="grid lg:grid-cols-2 gap-0">
                <!-- Image Side -->
                <div class="h-72 lg:h-auto relative overflow-hidden">
                    <?php if (!empty($service->image)): ?>
                    <img src="<?php echo htmlspecialchars($service->image); ?>"
                         alt="<?php echo htmlspecialchars($service->title); ?>"
                         class="w-full h-full object-cover">
                    <?php else: ?>
                    <div class="w-full h-full bg-gradient-to-br from-[#ff7a00] to-[#e56d00] flex items-center justify-center min-h-[400px]">
                        <span class="text-9xl text-white/30"><?php echo htmlspecialchars($service->icon ?? '🏠'); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($service->price)): ?>
                    <div class="absolute bottom-4 right-4 bg-[#ff7a00] text-white font-black px-6 py-2.5 shadow-xl text-lg">
                        <?php echo htmlspecialchars($service->price); ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Content Side -->
                <div class="p-8 lg:p-12 flex flex-col justify-center">
                    <div class="orange-bar mb-6"></div>
                    <h1 class="text-3xl sm:text-4xl font-black text-[#282828] mb-4 uppercase">
                        <?php echo htmlspecialchars($service->title); ?>
                    </h1>
                    <p class="text-gray-600 text-lg leading-relaxed mb-8">
                        <?php echo htmlspecialchars($service->description); ?>
                    </p>

                    <!-- Features Checklist -->
                    <?php
                    $features = $service->features ?? $service->items ?? null;
                    $featureList = is_array($features) ? $features : (is_string($features) ? json_decode($features, true) : null);
                    $defaultFeatures = ['فريق عمل مدرب ومحترف', 'مواد تنظيف آمنة ومعتمدة', 'أسعار تنافسية وشفافة', 'ضمان الجودة والرضا'];
                    $displayFeatures = !empty($featureList) ? $featureList : $defaultFeatures;
                    ?>
                    <div class="space-y-4 mb-8">
                        <?php foreach ($displayFeatures as $feature): ?>
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-[#ff7a00] text-white flex items-center justify-center font-black shrink-0">
                                <i class="fas fa-check text-sm"></i>
                            </span>
                            <span class="text-[#282828] font-bold"><?php echo htmlspecialchars(is_string($feature) ? $feature : ($feature['title'] ?? '')); ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="flex flex-wrap gap-4">
                        <a href="<?php echo htmlspecialchars($siteBase); ?>/booking?service=<?php echo htmlspecialchars($service->slug ?? $service->id); ?>"
                           class="bg-[#ff7a00] text-white font-black px-8 py-4 hover:bg-[#e56d00] transition-all duration-300 inline-block">
                            احجز الآن
                        </a>
                        <a href="https://wa.me/<?php echo htmlspecialchars(preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '966000000000')); ?>?text=<?php echo urlencode('أرغب في الاستفسار عن خدمة: ' . $service->title); ?>"
                           class="bg-green-500 text-white font-black px-8 py-4 hover:bg-green-600 transition-all duration-300 inline-block"
                           target="_blank" rel="noopener">
                            <i class="fab fa-whatsapp ml-2"></i> واتساب
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== HOW IT WORKS ==================== -->
<section class="bg-[#f4f4f4] py-20 lg:py-24 fade-up">
    <div class="max-w-7xl mx-auto px-6 lg:px-20">
        <div class="text-center mb-14">
            <div class="orange-bar mx-auto mb-6"></div>
            <h2 class="text-4xl sm:text-5xl font-black text-[#282828] uppercase">كيف نعمل</h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php
            $steps = [
                ['step' => '01', 'icon' => 'fas fa-list-check', 'title' => 'اختر الخدمة', 'desc' => 'تصفح خدماتنا واختر ما يناسب احتياجاتك'],
                ['step' => '02', 'icon' => 'fas fa-calendar-check', 'title' => 'حدد الموعد', 'desc' => 'اختر الوقت والتاريخ المناسب لك'],
                ['step' => '03', 'icon' => 'fas fa-broom', 'title' => 'التنفيذ', 'desc' => 'يقوم فريقنا بتنفيذ الخدمة بأعلى جودة'],
                ['step' => '04', 'icon' => 'fas fa-circle-check', 'title' => 'الفحص والتسليم', 'desc' => 'نتأكد من رضاك التام عن النتيجة'],
            ];
            foreach ($steps as $i => $s): ?>
            <div class="text-center relative">
                <?php if ($i < 3): ?>
                <div class="hidden lg:block absolute top-12 -left-4 w-8 text-[#ff7a00]/20">
                    <i class="fas fa-chevron-left"></i>
                </div>
                <?php endif; ?>
                <div class="w-24 h-24 bg-white flex items-center justify-center mx-auto mb-5 relative shadow-sm">
                    <i class="<?php echo $s['icon']; ?> text-4xl text-[#ff7a00]"></i>
                    <span class="absolute -top-2 -right-2 w-8 h-8 bg-[#ff7a00] text-white text-xs font-black flex items-center justify-center"><?php echo $s['step']; ?></span>
                </div>
                <h3 class="text-lg font-black text-[#282828] mb-2"><?php echo $s['title']; ?></h3>
                <p class="text-gray-500 text-sm"><?php echo $s['desc']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==================== PRICING & CONTACT ==================== -->
<section class="bg-white py-20 lg:py-24 fade-up">
    <div class="max-w-7xl mx-auto px-6 lg:px-20">
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Price Card -->
            <div class="bg-[#f4f4f4] p-8 text-center lg:col-span-1">
                <i class="fas fa-tag text-5xl text-[#ff7a00] mb-4"></i>
                <h3 class="text-lg font-black text-[#282828] mb-2">السعر يبدأ من</h3>
                <div class="text-4xl font-black text-[#ff7a00] mb-4">
                    <?php echo htmlspecialchars($service->price ?? 'تواصل معنا'); ?>
                </div>
                <p class="text-gray-400 text-sm mb-6">الأسعار تختلف حسب المساحة والمتطلبات</p>
                <a href="<?php echo htmlspecialchars($siteBase); ?>/booking?service=<?php echo htmlspecialchars($service->slug ?? $service->id); ?>"
                   class="block w-full bg-[#ff7a00] hover:bg-[#e56d00] text-white font-black px-6 py-4 transition-all duration-300 text-center">
                    احجز الآن
                </a>
                <a href="https://wa.me/<?php echo htmlspecialchars(preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '966000000000')); ?>"
                   class="block w-full mt-3 bg-green-500 hover:bg-green-600 text-white font-black px-6 py-4 transition-all duration-300 text-center"
                   target="_blank" rel="noopener">
                    <i class="fab fa-whatsapp ml-2"></i> تواصل عبر واتساب
                </a>
            </div>

            <!-- Contact Info -->
            <div class="lg:col-span-2 bg-[#f4f4f4] p-8">
                <h3 class="text-xl font-black text-[#282828] mb-6">معلومات التواصل</h3>
                <div class="grid sm:grid-cols-2 gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-white flex items-center justify-center text-2xl shrink-0 shadow-sm">
                            <i class="fas fa-phone text-[#ff7a00]"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm mb-1">اتصل بنا</p>
                            <a href="tel:<?php echo htmlspecialchars($tenant->contact_phone ?? ''); ?>" class="text-[#282828] font-black hover:text-[#ff7a00] transition-colors" dir="ltr">
                                <?php echo htmlspecialchars($tenant->contact_phone ?? '+90 555 000 000'); ?>
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-white flex items-center justify-center text-2xl shrink-0 shadow-sm">
                            <i class="fas fa-envelope text-[#ff7a00]"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm mb-1">البريد الإلكتروني</p>
                            <a href="mailto:<?php echo htmlspecialchars($tenant->contact_email ?? ''); ?>" class="text-[#282828] font-black hover:text-[#ff7a00] transition-colors">
                                <?php echo htmlspecialchars($tenant->contact_email ?? 'info@nove-clean.com'); ?>
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-white flex items-center justify-center text-2xl shrink-0 shadow-sm">
                            <i class="fas fa-clock text-[#ff7a00]"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm mb-1">ساعات العمل</p>
                            <p class="text-[#282828] font-black">24/7 متواصلون</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-white flex items-center justify-center text-2xl shrink-0 shadow-sm">
                            <i class="fas fa-location-dot text-[#ff7a00]"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm mb-1">الموقع</p>
                            <p class="text-[#282828] font-black"><?php echo htmlspecialchars($tenant->address ?? 'إسطنبول - تركيا'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== CTA ==================== -->
<section class="bg-[#151515] py-20 lg:py-24 fade-up">
    <div class="max-w-7xl mx-auto px-6 lg:px-20 grid lg:grid-cols-[1fr_.75fr] gap-12 items-center">
        <div>
            <h2 class="text-white text-4xl lg:text-5xl font-black leading-tight uppercase mb-6">
                هل تحتاج هذه الخدمة؟
            </h2>
            <p class="text-gray-300 text-lg mb-8 leading-relaxed">
                لا تتردد في التواصل معنا للحصول على عرض سعر خاص. فريقنا جاهز لخدمتك.
            </p>
            <a href="<?php echo htmlspecialchars($siteBase); ?>/booking?service=<?php echo htmlspecialchars($service->slug ?? $service->id); ?>"
               class="bg-[#ff7a00] text-white font-black px-10 py-5 hover:bg-[#e56d00] transition-all duration-300 inline-block">
                احجز الآن
            </a>
        </div>
        <div class="bg-[#ff7a00] p-10 text-center">
            <h3 class="text-[#282828] font-black text-xl mb-3">اتصل بنا الآن</h3>
            <p class="text-white text-4xl font-black mb-6" dir="ltr"><?php echo htmlspecialchars($tenant->contact_phone ?? '+90 555 000 000'); ?></p>
            <a href="https://wa.me/<?php echo htmlspecialchars(preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '966000000000')); ?>"
               class="bg-green-500 text-white font-black px-8 py-4 hover:bg-green-600 transition-all duration-300 inline-block"
               target="_blank" rel="noopener">
                <i class="fab fa-whatsapp ml-2"></i> واتساب
            </a>
        </div>
    </div>
</section>

<?php endif; ?>

<?php require_once __DIR__ . '/_footer.php'; require_once __DIR__ . '/_scripts.php'; ?>

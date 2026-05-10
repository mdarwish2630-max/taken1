<?php require_once __DIR__ . '/_head.php'; require_once __DIR__ . '/_navbar.php'; ?>

<!-- ==================== HERO SECTION ==================== -->
<section class="relative min-h-[760px] bg-[#111] overflow-hidden">
    <!-- Background Image -->
    <?php if (!empty($banners) && isset($banners[0]->image)): ?>
        <img src="<?php echo htmlspecialchars($banners[0]->image); ?>" alt="cleaning service"
             class="absolute inset-0 w-full h-full object-cover">
    <?php else: ?>
        <img src="https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?q=80&w=1800&auto=format&fit=crop"
             alt="cleaning service" class="absolute inset-0 w-full h-full object-cover">
    <?php endif; ?>
    <div class="absolute inset-0 bg-black/70"></div>

    <!-- Hero Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-20 pt-20 pb-20 grid lg:grid-cols-[1.05fr_.95fr] gap-14 items-center min-h-[600px]">
        <!-- Text Content -->
        <div class="fade-up">
            <div class="orange-bar mb-6"></div>
            <p class="text-[#ff7a00] text-lg lg:text-xl font-extrabold tracking-wide mb-4">
                خدمات تنظيف احترافية
            </p>

            <h1 class="text-white text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-black leading-[1.15] mb-6 max-w-3xl">
                دع المكان يلمع من جديد
            </h1>

            <p class="text-white/90 text-xl md:text-2xl font-bold mb-6 leading-relaxed max-w-2xl">
                خلّي مكانك أنظف، أرقى، وأكثر راحة
            </p>

            <p class="text-gray-200 text-base md:text-lg max-w-2xl leading-loose mb-9">
                نقدم خدمات تنظيف وتعقيم احترافية للمنازل والشركات والسجاد والمساحات التجارية بأعلى جودة وسرعة تنفيذ.
            </p>

            <div class="flex flex-wrap gap-5">
                <a href="<?php echo htmlspecialchars($siteBase); ?>/booking"
                   class="bg-white text-[#282828] px-8 py-4 font-black text-base hover:bg-[#ff7a00] hover:text-white transition-all duration-300">
                    احجز خدمة
                </a>
                <a href="<?php echo htmlspecialchars($siteBase); ?>/services"
                   class="bg-[#ff7a00] text-white px-8 py-4 font-black text-base hover:bg-white hover:text-[#282828] transition-all duration-300">
                    خدماتنا
                </a>
            </div>
        </div>

        <!-- Floating Cards (Desktop Only) -->
        <div class="relative hidden lg:block">
            <!-- Card 1: Orange - 24/7 -->
            <div class="bg-[#ff7a00] p-8 shadow-2xl max-w-md mr-auto animate-float">
                <h3 class="text-4xl font-black text-[#1f2a3b] mb-3">24/7</h3>
                <p class="text-[#1f2a3b] text-xl font-black mb-6">دعم تنظيف طارئ</p>
                <p class="text-white text-lg leading-loose">دعم سريع وخدمة تنظيف طارئة في أي وقت من اليوم.</p>
            </div>
            <!-- Card 2: White -->
            <div class="bg-white p-8 shadow-2xl max-w-md mt-8">
                <p class="text-[#ff7a00] font-black text-lg mb-3">فريق موثوق</p>
                <h3 class="text-3xl font-black text-[#282828] mb-4">+8 آلاف عميل سعيد</h3>
                <p class="text-gray-600 leading-loose">عملاء يثقون بخدماتنا في التنظيف والتعقيم منذ سنوات.</p>
            </div>
        </div>
    </div>

    <!-- Social Strip -->
    <div class="absolute left-0 bottom-0 hidden lg:flex flex-col bg-black/60 text-white z-20">
        <a href="#" class="w-16 h-16 flex items-center justify-center border-t border-white/10 hover:bg-[#ff7a00] transition-all duration-300 font-black">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a href="#" class="w-16 h-16 flex items-center justify-center border-t border-white/10 hover:bg-[#ff7a00] transition-all duration-300 font-black">
            <i class="fab fa-x-twitter"></i>
        </a>
        <a href="#" class="w-16 h-16 flex items-center justify-center border-t border-white/10 hover:bg-[#ff7a00] transition-all duration-300 font-black">
            <i class="fab fa-linkedin-in"></i>
        </a>
    </div>
</section>

<!-- ==================== SERVICES INTRO ==================== -->
<section class="relative bg-white py-24 px-6 lg:px-20">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-16 items-center fade-up">
        <!-- Image -->
        <div class="relative">
            <img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=1200&auto=format&fit=crop"
                 alt="cleaning worker" class="w-full h-[560px] object-cover">
            <div class="absolute -bottom-10 -left-8 bg-[#ff7a00] p-8 w-72 hidden md:block shadow-2xl">
                <h3 class="text-5xl font-black text-white">12+</h3>
                <p class="text-[#1f2a3b] font-black text-xl mt-2">سنوات خبرة</p>
            </div>
        </div>

        <!-- Content -->
        <div>
            <p class="text-[#ff7a00] font-black text-xl mb-4">الخدمات التي نقدمها</p>
            <h2 class="text-5xl lg:text-7xl font-black leading-tight text-[#282828] mb-8 uppercase">
                سريع، نظيف، وموثوق
            </h2>
            <p class="text-gray-600 text-lg leading-loose mb-8">
                نقدم خدمات تنظيف حديثة بفريق محترف ومواد آمنة وجدولة مرنة حسب احتياجك. نلتزم بأعلى معايير الجودة والنظافة.
            </p>

            <div class="space-y-4 mb-10">
                <?php
                $heroFeatures = [
                    'سريع، موثوق، وبأسعار مناسبة',
                    'مواد تنظيف آمنة وصديقة للبيئة',
                    'فريق محترف ومدرب على أحدث التقنيات',
                    'متاحون 24/7 للطلبات العاجلة',
                ];
                foreach ($heroFeatures as $feature): ?>
                <div class="flex items-start gap-4">
                    <span class="w-8 h-8 bg-[#ff7a00] text-white flex items-center justify-center font-black shrink-0">
                        <i class="fas fa-check text-sm"></i>
                    </span>
                    <p class="text-lg font-bold text-[#282828]"><?php echo $feature; ?></p>
                </div>
                <?php endforeach; ?>
            </div>

            <a href="<?php echo htmlspecialchars($siteBase); ?>/about"
               class="bg-[#282828] text-white px-10 py-5 font-black hover:bg-[#ff7a00] transition-all duration-300 inline-block">
                المزيد عنا
            </a>
        </div>
    </div>
</section>

<!-- ==================== SERVICE CARDS ==================== -->
<section id="services" class="bg-[#f4f4f4] py-24 px-6 lg:px-20">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row justify-between items-end gap-8 mb-16 fade-up">
            <div>
                <p class="text-[#ff7a00] font-black text-xl mb-3">خدماتنا</p>
                <h2 class="text-5xl lg:text-7xl font-black text-[#282828] uppercase">حلول التنظيف</h2>
            </div>
            <p class="text-gray-600 text-lg max-w-xl leading-loose">
                اختر الخدمة المناسبة لمنزلك أو شركتك. كل خدماتنا بأسعار تنافسية وجودة مضمونة.
            </p>
        </div>

        <!-- Services Grid -->
        <?php if (!empty($services)): ?>
        <div class="grid md:grid-cols-3 gap-8">
            <?php foreach (array_slice($services, 0, 6) as $index => $svc): ?>
            <a href="<?php echo htmlspecialchars($siteBase); ?>/service/<?php echo htmlspecialchars($svc->slug ?? $svc->id); ?>"
               class="service-card group bg-white shadow-xl overflow-hidden fade-up">
                <!-- Image -->
                <?php if (!empty($svc->image)): ?>
                <div class="relative h-72 overflow-hidden bg-[#ff7a00]">
                    <img src="<?php echo htmlspecialchars($svc->image); ?>"
                         alt="<?php echo htmlspecialchars($svc->title); ?>"
                         class="service-img w-full h-full object-cover opacity-95 transition-transform duration-700">
                </div>
                <?php else: ?>
                <div class="relative h-72 overflow-hidden bg-gradient-to-br from-[#ff7a00] to-[#e56d00] flex items-center justify-center">
                    <span class="text-8xl text-white/30"><?php echo htmlspecialchars($svc->icon ?? '🏠'); ?></span>
                </div>
                <?php endif; ?>

                <!-- Number Badge -->
                <div class="absolute top-5 right-5 bg-[#ff7a00] text-white w-16 h-16 flex items-center justify-center font-black text-2xl shadow-lg" style="position:absolute;">
                    0<?php echo $index + 1; ?>
                </div>

                <!-- Content -->
                <div class="p-8">
                    <h3 class="text-3xl font-black text-[#282828] mb-2 group-hover:text-[#ff7a00] transition-colors">
                        <?php echo htmlspecialchars($svc->title); ?>
                    </h3>
                    <p class="text-[#ff7a00] text-xl font-black mb-5"><?php echo htmlspecialchars($svc->title); ?></p>
                    <p class="text-gray-600 leading-loose mb-8"><?php echo htmlspecialchars($svc->description); ?></p>
                    <span class="bg-[#282828] text-white px-7 py-4 font-black hover:bg-[#ff7a00] transition-all duration-300 w-full block text-center">
                        اقرأ المزيد
                    </span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- View All -->
        <div class="text-center mt-12 fade-up">
            <a href="<?php echo htmlspecialchars($siteBase); ?>/services"
               class="bg-[#ff7a00] text-white px-10 py-5 font-black hover:bg-[#282828] transition-all duration-300 inline-block">
                عرض جميع الخدمات
            </a>
        </div>
    </div>
</section>

<!-- ==================== STATS / TRUST SECTION ==================== -->
<section class="bg-white py-20 lg:py-28 fade-up">
    <div class="max-w-7xl mx-auto px-6 lg:px-20">
        <div class="text-center mb-14">
            <p class="text-[#ff7a00] font-black text-xl mb-3">لماذا نحن الأفضل</p>
            <h2 class="text-5xl lg:text-7xl font-black text-[#282828] uppercase">أرقام نفتخر بها</h2>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            <?php
            $defaultStats = [
                ['value' => '+12', 'label' => 'سنة خبرة', 'icon' => 'fas fa-trophy'],
                ['value' => '24/7', 'label' => 'دعم متواصل', 'icon' => 'fas fa-headset'],
                ['value' => '+8K', 'label' => 'عميل سعيد', 'icon' => 'fas fa-users'],
                ['value' => '100%', 'label' => 'رضا العملاء', 'icon' => 'fas fa-star'],
            ];
            $stats = !empty($siteStats) ? $siteStats : $defaultStats;
            ?>
            <?php foreach ($stats as $stat): ?>
            <div class="text-center bg-[#f4f4f4] p-8 group hover:bg-[#ff7a00] transition-all duration-500">
                <div class="text-3xl mb-4 text-[#ff7a00] group-hover:text-white transition-colors">
                    <i class="<?php echo htmlspecialchars($stat['icon'] ?? 'fas fa-chart-bar'); ?>"></i>
                </div>
                <div class="text-4xl sm:text-5xl font-black text-[#282828] group-hover:text-white mb-2 transition-colors">
                    <?php echo htmlspecialchars($stat['value']); ?>
                </div>
                <div class="text-gray-500 group-hover:text-white/80 text-sm font-bold transition-colors">
                    <?php echo htmlspecialchars($stat['label']); ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==================== FEATURES / WHY US ==================== -->
<?php if (!empty($siteFeatures)): ?>
<section class="bg-[#f4f4f4] py-20 lg:py-28 fade-up">
    <div class="max-w-7xl mx-auto px-6 lg:px-20">
        <div class="text-center mb-14">
            <p class="text-[#ff7a00] font-black text-xl mb-3">مميزاتنا</p>
            <h2 class="text-5xl lg:text-7xl font-black text-[#282828] uppercase">لماذا تختارنا؟</h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach ($siteFeatures as $feature): ?>
            <div class="bg-white p-8 text-center shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500">
                <div class="w-16 h-16 bg-[#ff7a00]/10 flex items-center justify-center mx-auto mb-5">
                    <i class="<?php echo htmlspecialchars($feature['icon'] ?? 'fas fa-check-circle'); ?> text-3xl text-[#ff7a00]"></i>
                </div>
                <h3 class="text-lg font-black text-[#282828] mb-3"><?php echo htmlspecialchars($feature['title']); ?></h3>
                <p class="text-gray-500 text-sm leading-relaxed"><?php echo htmlspecialchars($feature['description']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ==================== TESTIMONIALS ==================== -->
<?php if (!empty($testimonials)): ?>
<section class="bg-white py-20 lg:py-28 fade-up">
    <div class="max-w-7xl mx-auto px-6 lg:px-20">
        <div class="text-center mb-14">
            <p class="text-[#ff7a00] font-black text-xl mb-3">آراء العملاء</p>
            <h2 class="text-5xl lg:text-7xl font-black text-[#282828] uppercase">ماذا يقولون عنا</h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach (array_slice($testimonials, 0, 6) as $t): ?>
            <div class="bg-[#f4f4f4] p-8 hover:shadow-lg transition-all duration-500">
                <div class="flex gap-1 mb-4">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                    <i class="fas fa-star text-[#ff7a00]"></i>
                    <?php endfor; ?>
                </div>
                <p class="text-gray-600 leading-relaxed mb-6 text-sm">
                    "<?php echo htmlspecialchars($t->content ?? $t->text ?? $t->review ?? ''); ?>"
                </p>
                <div class="flex items-center gap-3">
                    <?php if (!empty($t->avatar ?? $t->image)): ?>
                    <img src="<?php echo htmlspecialchars($t->avatar ?? $t->image); ?>"
                         alt="<?php echo htmlspecialchars($t->name ?? ''); ?>"
                         class="w-12 h-12 object-cover">
                    <?php else: ?>
                    <div class="w-12 h-12 bg-[#ff7a00] flex items-center justify-center text-white font-bold text-lg">
                        <?php echo mb_substr(htmlspecialchars($t->name ?? 'ع'), 0, 1); ?>
                    </div>
                    <?php endif; ?>
                    <div>
                        <h4 class="font-black text-[#282828] text-sm"><?php echo htmlspecialchars($t->name ?? ''); ?></h4>
                        <p class="text-gray-400 text-xs"><?php echo htmlspecialchars($t->role ?? $t->position ?? 'عميل'); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ==================== DARK CTA ==================== -->
<section class="relative bg-[#151515] py-28 px-6 lg:px-20 overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <img src="https://images.unsplash.com/photo-1585421514284-efb74c2b69ba?q=80&w=1800&auto=format&fit=crop"
             alt="background" class="w-full h-full object-cover">
    </div>
    <div class="relative z-10 max-w-7xl mx-auto grid lg:grid-cols-[1fr_.75fr] gap-12 items-center fade-up">
        <div>
            <p class="text-[#ff7a00] font-black text-xl mb-5">هل تحتاج خدمة تنظيف؟</p>
            <h2 class="text-white text-5xl lg:text-7xl font-black leading-tight uppercase mb-8">
                جاهز لجعل مكانك يلمع؟
            </h2>
            <p class="text-gray-300 text-xl leading-loose max-w-3xl">
                احجز موعد التنظيف الآن واحصل على خدمة احترافية بجودة عالية وأسعار منافسة.
            </p>
        </div>
        <div class="bg-[#ff7a00] p-10 text-center">
            <p class="text-[#282828] font-black text-xl mb-3">اتصل بنا الآن</p>
            <h3 class="text-white text-4xl font-black mb-6" dir="ltr"><?php echo htmlspecialchars($tenant->contact_phone ?? '+90 555 000 000'); ?></h3>
            <a href="<?php echo htmlspecialchars($siteBase); ?>/contact"
               class="bg-white text-[#282828] px-10 py-5 font-black hover:bg-[#282828] hover:text-white transition-all duration-300 inline-block">
                تواصل معنا
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; require_once __DIR__ . '/_scripts.php'; ?>

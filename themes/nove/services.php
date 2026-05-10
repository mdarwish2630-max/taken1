<?php require_once __DIR__ . '/_head.php'; require_once __DIR__ . '/_navbar.php'; ?>

<!-- ==================== HERO BANNER ==================== -->
<section class="relative bg-[#111] pt-32 pb-24 overflow-hidden">
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="absolute top-10 left-10 w-48 h-48 bg-[#ff7a00]/10 rounded-full blur-3xl"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-20 text-center fade-up">
        <div class="orange-bar mx-auto mb-6"></div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white mb-5 uppercase">خدماتنا</h1>
        <p class="text-white/70 text-lg max-w-2xl mx-auto leading-relaxed">اكتشف مجموعتنا الواسعة من خدمات التنظيف والتعقيم الاحترافية المصممة لتلبية جميع احتياجاتك</p>

        <!-- Breadcrumb -->
        <nav class="mt-8 flex items-center justify-center gap-2 text-sm text-white/50">
            <a href="<?php echo htmlspecialchars($siteBase); ?>" class="hover:text-[#ff7a00] transition-colors">الرئيسية</a>
            <i class="fas fa-chevron-left text-[10px]"></i>
            <span class="text-[#ff7a00] font-bold">خدماتنا</span>
        </nav>
    </div>
</section>

<!-- ==================== SERVICES GRID ==================== -->
<section class="bg-[#f4f4f4] py-24 px-6 lg:px-20">
    <div class="max-w-7xl mx-auto">
        <?php if (!empty($services)): ?>
        <div class="grid md:grid-cols-3 gap-8">
            <?php foreach ($services as $index => $svc): ?>
            <a href="<?php echo htmlspecialchars($siteBase); ?>/service/<?php echo htmlspecialchars($svc->slug ?? $svc->id); ?>"
               class="service-card group bg-white shadow-xl overflow-hidden fade-up">
                <!-- Image -->
                <?php if (!empty($svc->image)): ?>
                <div class="relative h-72 overflow-hidden">
                    <img src="<?php echo htmlspecialchars($svc->image); ?>"
                         alt="<?php echo htmlspecialchars($svc->title); ?>"
                         class="service-img w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-95">
                    <!-- Price Badge -->
                    <?php if (!empty($svc->price)): ?>
                    <div class="absolute top-4 left-4 bg-[#ff7a00] text-white text-sm font-black px-4 py-1.5 shadow-lg">
                        <?php echo htmlspecialchars($svc->price); ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <div class="relative h-72 overflow-hidden bg-gradient-to-br from-[#ff7a00] to-[#e56d00] flex items-center justify-center">
                    <span class="text-8xl text-white/30"><?php echo htmlspecialchars($svc->icon ?? '🏠'); ?></span>
                </div>
                <?php endif; ?>

                <!-- Number Badge -->
                <div class="absolute top-5 right-5 bg-[#ff7a00] text-white w-16 h-16 flex items-center justify-center font-black text-2xl shadow-lg" style="position:absolute;">
                    0<?php echo ($index % 9) + 1; ?>
                </div>

                <!-- Content -->
                <div class="p-8">
                    <h3 class="text-3xl font-black text-[#282828] mb-2 group-hover:text-[#ff7a00] transition-colors">
                        <?php echo htmlspecialchars($svc->title); ?>
                    </h3>
                    <p class="text-gray-600 leading-loose mb-8"><?php echo htmlspecialchars($svc->description); ?></p>
                    <span class="bg-[#282828] text-white px-7 py-4 font-black hover:bg-[#ff7a00] transition-all duration-300 w-full block text-center">
                        التفاصيل
                    </span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <!-- Empty State -->
        <div class="text-center py-20 fade-up">
            <div class="text-7xl mb-6"><i class="fas fa-broom text-[#ff7a00]"></i></div>
            <h3 class="text-2xl font-black text-[#282828] mb-3">لا توجد خدمات حالياً</h3>
            <p class="text-gray-500">سيتم إضافة الخدمات قريباً. تابعنا!</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ==================== CTA SECTION ==================== -->
<section class="bg-[#151515] py-28 px-6 lg:px-20 fade-up">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-[1fr_.75fr] gap-12 items-center">
        <div>
            <p class="text-[#ff7a00] font-black text-xl mb-5">لم تجد ما تبحث عنه؟</p>
            <h2 class="text-white text-5xl lg:text-7xl font-black leading-tight uppercase mb-8">
                نقدم خدمة مخصصة لك
            </h2>
            <p class="text-gray-300 text-xl leading-loose max-w-3xl">
                تواصل معنا وسنقدم لك خدمة مخصصة تلبي جميع احتياجاتك بأعلى جودة وأفضل الأسعار.
            </p>
        </div>
        <div class="bg-[#ff7a00] p-10 text-center">
            <h3 class="text-[#282828] font-black text-2xl mb-6">تواصل معنا الآن</h3>
            <a href="<?php echo htmlspecialchars($siteBase); ?>/contact"
               class="bg-white text-[#282828] px-10 py-5 font-black hover:bg-[#282828] hover:text-white transition-all duration-300 inline-block">
                تواصل معنا
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; require_once __DIR__ . '/_scripts.php'; ?>

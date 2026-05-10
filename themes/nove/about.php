<?php require_once __DIR__ . '/_head.php'; require_once __DIR__ . '/_navbar.php'; ?>

<!-- ==================== HERO BANNER ==================== -->
<section class="relative bg-[#111] pt-32 pb-24 overflow-hidden">
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="absolute top-10 right-10 w-64 h-64 bg-[#ff7a00]/10 rounded-full blur-3xl"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-20 text-center fade-up">
        <div class="orange-bar mx-auto mb-6"></div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white mb-5 uppercase">من نحن</h1>
        <p class="text-white/70 text-lg max-w-2xl mx-auto">نحن لمعة كلين - شريكك الموثوق في عالم النظافة والتعقيم الاحترافي</p>

        <!-- Breadcrumb -->
        <nav class="mt-8 flex items-center justify-center gap-2 text-sm text-white/50">
            <a href="<?php echo htmlspecialchars($siteBase); ?>" class="hover:text-[#ff7a00] transition-colors">الرئيسية</a>
            <i class="fas fa-chevron-left text-[10px]"></i>
            <span class="text-[#ff7a00] font-bold">من نحن</span>
        </nav>
    </div>
</section>

<!-- ==================== COMPANY STORY ==================== -->
<section class="bg-white py-24 px-6 lg:px-20">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-12 lg:gap-16 items-center fade-up">
        <!-- Image -->
        <div class="relative">
            <img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=1200&auto=format&fit=crop"
                 alt="لمعة كلين" class="w-full h-[500px] object-cover shadow-2xl"
                 onerror="this.src='https://placehold.co/800x500/ff7a00/ffffff?text=Lumaa+Clean';">
            <!-- Floating Badge -->
            <div class="absolute -bottom-6 -left-6 bg-[#ff7a00] text-white p-6 w-72 hidden sm:block shadow-2xl">
                <h3 class="text-5xl font-black">12+</h3>
                <p class="text-white/80 font-bold text-lg mt-1">سنوات خبرة</p>
            </div>
        </div>

        <!-- Content -->
        <div>
            <p class="text-[#ff7a00] font-black text-xl mb-4">قصتنا</p>
            <h2 class="text-4xl lg:text-5xl font-black text-[#282828] mb-6 uppercase">
                شغفنا هو <span class="text-[#ff7a00]">النظافة</span>
            </h2>
            <p class="text-gray-600 text-lg leading-loose mb-6">
                تأسست شركة لمعة كلين بهدف تقديم خدمات تنظيف وتعقيم احترافية بمعايير عالمية. بدأنا رحلتنا بحلم بسيط: أن نوفر لكل منزل ومكتب بيئة نظيفة وصحية تعزز من جودة الحياة.
            </p>
            <p class="text-gray-600 text-lg leading-loose mb-8">
                على مر السنين، تطورنا وبنينا فريقاً من الخبراء المتخصصين الذين يستخدمون أحدث التقنيات والمواد الآمنة على البيئة. نحن نؤمن بأن النظافة ليست مجرد خدمة، بل هي أسلوب حياة.
            </p>

            <!-- Values -->
            <div class="grid grid-cols-2 gap-4">
                <?php foreach (['جودة عالية', 'مواد آمنة', 'فريق محترف', 'أسعار منافسة'] as $val): ?>
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 bg-[#ff7a00] text-white flex items-center justify-center font-black shrink-0">
                        <i class="fas fa-check text-sm"></i>
                    </span>
                    <span class="text-[#282828] font-bold text-sm"><?php echo $val; ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ==================== STATS ==================== -->
<section class="bg-[#f4f4f4] py-20 lg:py-28 fade-up">
    <div class="max-w-7xl mx-auto px-6 lg:px-20">
        <div class="text-center mb-14">
            <p class="text-[#ff7a00] font-black text-xl mb-3">إنجازاتنا</p>
            <h2 class="text-5xl lg:text-7xl font-black text-[#282828] uppercase">أرقام تتحدث عنّا</h2>
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
            <div class="text-center bg-white p-8 group hover:bg-[#ff7a00] transition-all duration-500 shadow-sm">
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

<!-- ==================== SERVICES OVERVIEW ==================== -->
<?php if (!empty($services)): ?>
<section class="bg-white py-20 lg:py-28 fade-up">
    <div class="max-w-7xl mx-auto px-6 lg:px-20">
        <div class="text-center mb-14">
            <p class="text-[#ff7a00] font-black text-xl mb-3">ما نقدمه</p>
            <h2 class="text-5xl lg:text-7xl font-black text-[#282828] uppercase">خدماتنا</h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach (array_slice($services, 0, 8) as $svc): ?>
            <a href="<?php echo htmlspecialchars($siteBase); ?>/service/<?php echo htmlspecialchars($svc->slug ?? $svc->id); ?>"
               class="group bg-[#f4f4f4] p-6 text-center hover:bg-[#ff7a00] transition-all duration-500 hover:shadow-xl">
                <div class="w-16 h-16 bg-white flex items-center justify-center mx-auto mb-4 text-3xl shadow-sm group-hover:bg-white/20">
                    <?php echo htmlspecialchars($svc->icon ?? '🏠'); ?>
                </div>
                <h3 class="font-black text-[#282828] group-hover:text-white transition-colors mb-2"><?php echo htmlspecialchars($svc->title); ?></h3>
                <p class="text-gray-400 text-sm group-hover:text-white/80 line-clamp-2 transition-colors"><?php echo htmlspecialchars($svc->description); ?></p>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ==================== TESTIMONIALS ==================== -->
<?php if (!empty($testimonials)): ?>
<section class="bg-[#f4f4f4] py-20 lg:py-28 fade-up">
    <div class="max-w-7xl mx-auto px-6 lg:px-20">
        <div class="text-center mb-14">
            <p class="text-[#ff7a00] font-black text-xl mb-3">آراء عملائنا</p>
            <h2 class="text-5xl lg:text-7xl font-black text-[#282828] uppercase">ماذا يقولون</h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach (array_slice($testimonials, 0, 6) as $t): ?>
            <div class="bg-white p-8 shadow-sm">
                <div class="flex gap-1 mb-4">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                    <i class="fas fa-star text-[#ff7a00]"></i>
                    <?php endfor; ?>
                </div>
                <p class="text-gray-600 leading-relaxed mb-6 text-sm">"<?php echo htmlspecialchars($t->content ?? $t->text ?? $t->review ?? ''); ?>"</p>
                <div class="flex items-center gap-3">
                    <?php if (!empty($t->avatar ?? $t->image)): ?>
                    <img src="<?php echo htmlspecialchars($t->avatar ?? $t->image); ?>" alt="" class="w-10 h-10 object-cover">
                    <?php else: ?>
                    <div class="w-10 h-10 bg-[#ff7a00] flex items-center justify-center text-white font-black"><?php echo mb_substr(htmlspecialchars($t->name ?? 'ع'), 0, 1); ?></div>
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

<!-- ==================== CTA ==================== -->
<section class="bg-[#151515] py-28 px-6 lg:px-20 fade-up">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-[1fr_.75fr] gap-12 items-center">
        <div>
            <p class="text-[#ff7a00] font-black text-xl mb-5">انضم لعملائنا السعداء</p>
            <h2 class="text-white text-5xl lg:text-7xl font-black leading-tight uppercase mb-8">
                جاهز للتجربة؟
            </h2>
            <p class="text-gray-300 text-xl leading-loose max-w-3xl">
                نحن هنا لخدمتك. تواصل معنا واكتشف الفرق في جودة خدماتنا.
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

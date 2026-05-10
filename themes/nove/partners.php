<?php require_once __DIR__ . '/_head.php'; require_once __DIR__ . '/_navbar.php'; ?>

<!-- ==================== HERO BANNER ==================== -->
<section class="relative bg-[#111] pt-32 pb-24 overflow-hidden">
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="absolute top-10 right-10 w-48 h-48 bg-[#ff7a00]/10 rounded-full blur-3xl"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-20 text-center fade-up">
        <div class="orange-bar mx-auto mb-6"></div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white mb-5 uppercase">شركاؤنا</h1>
        <p class="text-white/70 text-lg max-w-2xl mx-auto">نفتخر بشراكتنا مع نخبة من أفضل الشركات والمؤسسات</p>

        <nav class="mt-8 flex items-center justify-center gap-2 text-sm text-white/50">
            <a href="<?php echo htmlspecialchars($siteBase); ?>" class="hover:text-[#ff7a00] transition-colors">الرئيسية</a>
            <i class="fas fa-chevron-left text-[10px]"></i>
            <span class="text-[#ff7a00] font-bold">شركاؤنا</span>
        </nav>
    </div>
</section>

<!-- ==================== PARTNERS ==================== -->
<section class="bg-white py-24 px-6 lg:px-20">
    <div class="max-w-7xl mx-auto">
        <?php if (!empty($partnerItems)): ?>
        <div class="text-center mb-14 fade-up">
            <p class="text-[#ff7a00] font-black text-xl mb-3">ثقتنا المتبادلة</p>
            <h2 class="text-5xl lg:text-7xl font-black text-[#282828] uppercase">شركاء النجاح</h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            <?php foreach ($partnerItems as $partner): ?>
            <div class="fade-up">
                <?php if (!empty($partner->website)): ?>
                <a href="<?php echo htmlspecialchars($partner->website); ?>" target="_blank" rel="noopener"
                   class="block bg-[#f4f4f4] p-8 text-center hover:bg-[#ff7a00] group transition-all duration-500 hover:shadow-xl hover:-translate-y-2">
                <?php else: ?>
                <div class="bg-[#f4f4f4] p-8 text-center hover:bg-[#ff7a00] group transition-all duration-500">
                <?php endif; ?>
                    <?php if (!empty($partner->logo)): ?>
                    <div class="w-24 h-24 mx-auto mb-4 flex items-center justify-center">
                        <img src="<?php echo htmlspecialchars($partner->logo); ?>" alt="<?php echo htmlspecialchars($partner->name); ?>"
                             class="max-w-full max-h-full object-contain grayscale group-hover:grayscale-0 transition-all duration-500">
                    </div>
                    <?php else: ?>
                    <div class="w-24 h-24 mx-auto mb-4 bg-white flex items-center justify-center">
                        <span class="text-4xl font-black text-[#ff7a00] group-hover:text-white transition-colors"><?php echo mb_substr(htmlspecialchars($partner->name), 0, 1); ?></span>
                    </div>
                    <?php endif; ?>
                    <h3 class="text-[#282828] font-black text-sm group-hover:text-white transition-colors"><?php echo htmlspecialchars($partner->name); ?></h3>
                <?php if (!empty($partner->website)): ?>
                </a>
                <?php else: ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-20 fade-up">
            <div class="text-7xl mb-6"><i class="fas fa-handshake text-[#ff7a00]/40"></i></div>
            <h3 class="text-2xl font-black text-[#282828] mb-3">شركاؤنا قادمون</h3>
            <p class="text-gray-500">نحن نبني شراكات استراتيجية مع أفضل الشركات. تابعنا!</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ==================== WHY PARTNER ==================== -->
<section class="bg-[#f4f4f4] py-24 px-6 lg:px-20 fade-up">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-14">
            <p class="text-[#ff7a00] font-black text-xl mb-3">شراكة مثمرة</p>
            <h2 class="text-5xl lg:text-7xl font-black text-[#282828] uppercase">لماذا تشراك معنا؟</h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            $partnerBenefits = [
                ['icon' => 'fas fa-chart-line', 'title' => 'نمو مشترك', 'desc' => 'نسعى لتحقيق نمو مستدام ومتبادل المنفعة مع جميع شركائنا'],
                ['icon' => 'fas fa-bullseye', 'title' => 'جودة عالية', 'desc' => 'نلتزم بأعلى معايير الجودة في جميع خدماتنا ومنتجاتنا'],
                ['icon' => 'fas fa-lightbulb', 'title' => 'ابتكار مستمر', 'desc' => 'نعتمد على أحدث التقنيات والحلول المبتكرة لتقديم أفضل الخدمات'],
                ['icon' => 'fas fa-handshake', 'title' => 'علاقات طويلة', 'desc' => 'نبني علاقات شراكة مستدامة مبنية على الثقة والشفافية'],
                ['icon' => 'fas fa-globe', 'title' => 'انتشار واسع', 'desc' => 'نغطي مناطق واسعة لنضمن وصول خدماتنا لجميع العملاء'],
                ['icon' => 'fas fa-star', 'title' => 'سمعة ممتازة', 'desc' => 'نمتلك سمعة قوية في السوق مبنية على سنوات من التميز'],
            ];
            foreach ($partnerBenefits as $b): ?>
            <div class="bg-white p-8 text-center hover:shadow-xl hover:-translate-y-1 transition-all duration-500">
                <div class="w-16 h-16 bg-[#ff7a00]/10 flex items-center justify-center mx-auto mb-5">
                    <i class="<?php echo $b['icon']; ?> text-3xl text-[#ff7a00]"></i>
                </div>
                <h3 class="text-lg font-black text-[#282828] mb-3"><?php echo $b['title']; ?></h3>
                <p class="text-gray-500 text-sm leading-relaxed"><?php echo $b['desc']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==================== CTA ==================== -->
<section class="bg-[#151515] py-28 px-6 lg:px-20 fade-up">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-[1fr_.75fr] gap-12 items-center">
        <div>
            <p class="text-[#ff7a00] font-black text-xl mb-5">هل ترغب في الشراكة؟</p>
            <h2 class="text-white text-5xl lg:text-7xl font-black leading-tight uppercase mb-8">لنبدأ معاً</h2>
            <p class="text-gray-300 text-xl leading-loose max-w-3xl">نرحب بالشراكات الجديدة. تواصل معنا لمناقشة فرص التعاون</p>
        </div>
        <div class="bg-[#ff7a00] p-10 text-center">
            <h3 class="text-[#282828] font-black text-2xl mb-6">تواصل معنا</h3>
            <a href="<?php echo htmlspecialchars($siteBase); ?>/contact" class="bg-white text-[#282828] px-10 py-5 font-black hover:bg-[#282828] hover:text-white transition-all duration-300 inline-block">
                تواصل معنا
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; require_once __DIR__ . '/_scripts.php'; ?>

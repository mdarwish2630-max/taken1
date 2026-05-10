<?php include __DIR__ . '/partials/_head.php'; ?>
<?php include __DIR__ . '/partials/_navbar.php'; ?>

<!-- Page Header -->
<section class="hero-gradient relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 right-20 w-60 h-60 bg-primary rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 relative z-10 text-center">
        <span class="inline-block bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full text-sm text-accent mb-6">
            <i class="fas fa-building ml-2"></i> من نحن
        </span>
        <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-4">
            <?php echo htmlspecialchars($page['heading'] ?? 'عن شركة ركاز'); ?>
        </h1>
        <p class="text-lg text-white/70 max-w-2xl mx-auto">
            <?php echo htmlspecialchars($page['subheading'] ?? 'خبرة تتجاوز 15 عاماً في عالم الصيانة'); ?>
        </p>
    </div>
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 60" fill="none"><path d="M0 30L60 25C120 20 240 10 360 8.3C480 6.7 600 13.3 720 18.3C840 23.3 960 26.7 1080 25C1200 23.3 1320 16.7 1380 13.3L1440 10V60H1380C1320 60 1200 60 1080 60C960 60 840 60 720 60C600 60 480 60 360 60C240 60 120 60 60 60H0V30Z" fill="#f8f5f1"/></svg>
    </div>
</section>

<!-- About Content -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center mb-20">
            <!-- Image/Visual -->
            <div data-aos="fade-right">
                <div class="relative">
                    <div class="bg-gradient-to-br from-warm-200 to-warm-300 rounded-card h-96 flex items-center justify-center">
                        <i class="fas fa-building text-8xl text-primary/30"></i>
                    </div>
                    <div class="absolute -bottom-6 -right-6 bg-primary rounded-2xl p-6 text-white shadow-xl">
                        <p class="text-4xl font-extrabold">+15</p>
                        <p class="text-sm text-white/80">سنة خبرة</p>
                    </div>
                </div>
            </div>
            <!-- Text -->
            <div data-aos="fade-left">
                <span class="inline-block bg-primary/10 text-primary px-4 py-2 rounded-full text-sm font-semibold mb-4">قصتنا</span>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-secondary mb-6">شريكك الموثوق في الصيانة</h2>
                <div class="space-y-4 text-gray-600 leading-relaxed">
                    <?php if (!empty($page['content'])): ?>
                        <?php echo $page['content']; ?>
                    <?php else: ?>
                        <p>تأسست شركة ركاز للصيانة عام 2010 بهدف تقديم خدمات صيانة احترافية وموثوقة. نمتلك فريقاً من الفنيين المتخصصين والحاصلين على أعلى الشهادات المهنية.</p>
                        <p>نؤمن بأن الصيانة الجيدة هي أساس الراحة والسلامة في المنزل والمكتب. لذلك نحرص على تقديم خدمات عالية الجودة مع ضمان شامل على جميع أعمالنا.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Vision & Mission -->
        <div class="grid md:grid-cols-3 gap-8 mb-20">
            <div class="bg-white rounded-card p-8 text-center border border-warm-200" data-aos="fade-up">
                <div class="w-16 h-16 mx-auto mb-5 bg-primary/10 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-eye text-3xl text-primary"></i>
                </div>
                <h3 class="text-xl font-bold text-secondary mb-3">رؤيتنا</h3>
                <p class="text-gray-500 text-sm leading-relaxed">أن نكون الخيار الأول والأفضل في مجال الصيانة المنزلية والتجارية على مستوى المملكة العربية السعودية والمنطقة.</p>
            </div>
            <div class="bg-white rounded-card p-8 text-center border border-warm-200" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 mx-auto mb-5 bg-primary/10 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-bullseye text-3xl text-primary"></i>
                </div>
                <h3 class="text-xl font-bold text-secondary mb-3">مهمتنا</h3>
                <p class="text-gray-500 text-sm leading-relaxed">تقديم خدمات صيانة عالية الجودة تلبي توقعات عملائنا وتتجاوزها، مع الالتزام بالمواعيد والشفافية في التعامل.</p>
            </div>
            <div class="bg-white rounded-card p-8 text-center border border-warm-200" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 mx-auto mb-5 bg-primary/10 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-heart text-3xl text-primary"></i>
                </div>
                <h3 class="text-xl font-bold text-secondary mb-3">قيمنا</h3>
                <p class="text-gray-500 text-sm leading-relaxed">الجودة، الالتزام، الشفافية، والعمل الجماعي. نؤمن بأن نجاح عملائنا هو نجاحنا.</p>
            </div>
        </div>

        <!-- Stats -->
        <?php if (!empty($siteStats)): ?>
        <div class="bg-secondary rounded-card p-10 lg:p-14" data-aos="fade-up">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <?php foreach ($siteStats as $stat): ?>
                    <div class="text-center">
                        <div class="w-14 h-14 mx-auto mb-4 bg-primary/20 rounded-2xl flex items-center justify-center">
                            <i class="<?php echo htmlspecialchars($stat['icon'] ?? 'fas fa-chart-line'); ?> text-2xl text-accent"></i>
                        </div>
                        <h3 class="text-3xl font-extrabold text-primary mb-1"><?php echo htmlspecialchars($stat['title'] ?? ''); ?></h3>
                        <p class="text-white/60 text-sm"><?php echo htmlspecialchars($stat['content'] ?? ''); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/partials/_footer.php'; ?>
<?php include __DIR__ . '/partials/_scripts.php'; ?>

<?php
/**
 * Master Theme — About Page
 * Two-column layout: content + stats/features
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';
$whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
$waNumber = preg_replace('/[^0-9+]/', '', $whatsapp);

// Page title
$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'About Us' : 'من نحن'));
$pageContent = $lang === 'en' && !empty($page->content_en) ? $page->content_en : ($page->content ?? '');

// Stats
$stats = !empty($siteStats) ? $siteStats : [];
if (empty($stats)) {
    $stats = [
        (object)['value' => '10+', 'label' => 'سنوات خبرة', 'label_en' => 'Years Exp.', 'icon' => 'fas fa-clock'],
        (object)['value' => '5K+', 'label' => 'عميل سعيد', 'label_en' => 'Happy Clients', 'icon' => 'fas fa-users'],
        (object)['value' => '24/7', 'label' => 'دعم متواصل', 'label_en' => '24/7 Support', 'icon' => 'fas fa-headset'],
        (object)['value' => '98%', 'label' => 'نسبة الرضا', 'label_en' => 'Satisfaction', 'icon' => 'fas fa-chart-line'],
    ];
}

// Features
$features = !empty($siteFeatures) ? $siteFeatures : [];
if (empty($features)) {
    $features = [
        (object)['title' => 'استجابة سريعة', 'title_en' => 'Fast Response', 'description' => 'نصل إليكم بسرعة مع فريق مجهز وجاهز', 'description_en' => 'Quick arrival with equipped team', 'icon' => 'fas fa-bolt'],
        (object)['title' => 'فنيون محترفون', 'title_en' => 'Expert Technicians', 'description' => 'فريق معتمد بخبرة عملية واسعة', 'description_en' => 'Certified team with wide experience', 'icon' => 'fas fa-id-badge'],
        (object)['title' => 'أسعار منافسة', 'title_en' => 'Competitive Prices', 'description' => 'جودة عالية بأسعار مناسبة للجميع', 'description_en' => 'High quality at affordable prices', 'icon' => 'fas fa-tags'],
        (object)['title' => 'معدات حديثة', 'title_en' => 'Modern Equipment', 'description' => 'نستخدم أحدث الأدوات والتقنيات', 'description_en' => 'Latest tools and technology', 'icon' => 'fas fa-tools'],
    ];
}

require_once __DIR__ . '/_head.php';
require_once __DIR__ . '/_navbar.php';
?>

<!-- Background Effects -->
<div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
    <div class="absolute -top-20 -right-20 w-[500px] h-[500px] bg-cyan-500/15 blur-[120px] rounded-full"></div>
    <div class="absolute -bottom-20 -left-20 w-[500px] h-[500px] bg-blue-500/15 blur-[120px] rounded-full"></div>
</div>

<!-- ═══════ PAGE HEADER ═══════ -->
<section class="relative z-10 px-6 lg:px-20 pt-32 pb-12">
    <div class="max-w-4xl fade-up">
        <div class="inline-flex items-center gap-2 glass rounded-full px-4 py-2 text-sm text-cyan-300 mb-6">
            <i class="fas fa-building text-xs"></i>
            <span><?= $lang === 'en' ? 'About Us' : 'من نحن' ?></span>
        </div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight mb-6">
            <?= htmlspecialchars($pageTitle) ?>
        </h1>
        <div class="w-24 h-1.5 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full"></div>
    </div>
</section>

<!-- ═══════ MAIN CONTENT ═══════ -->
<section class="relative z-10 px-6 lg:px-20 py-12">
    <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-start">

        <!-- Left Column: About Content -->
        <div class="space-y-10">
            <!-- Main Content -->
            <div class="fade-up">
                <?php if (!empty($pageContent)): ?>
                    <div class="text-gray-300 text-lg leading-relaxed space-y-4">
                        <?= $pageContent ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-300 text-lg leading-relaxed">
                        <?= $lang === 'en'
                            ? 'We are a professional team dedicated to providing top-quality services. With years of experience and a passion for excellence, we deliver innovative solutions tailored to your needs.'
                            : 'نحن فريق محترف متخصص في تقديم أعلى مستويات الخدمة. بخبرة طويلة وشغف بالتميز، نقدم حلولاً مبتكرة مصممة خصيصاً لاحتياجاتكم.' ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Mission, Vision & Values — dynamic from CMS -->
            <?php if (!empty($page->content)): ?>
            <div class="glass rounded-2xl p-7 glow-border transition-all duration-300 fade-up" style="transition-delay:.1s">
                <div class="text-gray-300 text-lg leading-relaxed space-y-4">
                    <?= $page->content ?>
                </div>
            </div>
            <?php endif; ?>
            <?php if (!empty($page->content_en) && $lang === 'en'): ?>
            <div class="glass rounded-2xl p-7 glow-border transition-all duration-300 fade-up" style="transition-delay:.1s">
                <div class="text-gray-300 text-lg leading-relaxed space-y-4">
                    <?= $page->content_en ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Right Column: Stats + Features -->
        <div class="space-y-10">
            <!-- Stats Grid -->
            <div class="fade-up" style="transition-delay:.15s">
                <div class="relative">
                    <div class="absolute inset-0 bg-cyan-500/10 blur-[80px] rounded-full"></div>
                    <div class="relative bg-gradient-to-br from-cyan-500 to-blue-700 p-[2px] rounded-[40px]">
                        <div class="bg-[#111827] rounded-[38px] p-8">
                            <h3 class="text-2xl font-bold mb-6">
                                <?= $lang === 'en' ? 'Our Numbers' : 'إنجازاتنا بالأرقام' ?>
                            </h3>
                            <div class="grid grid-cols-2 gap-5">
                                <?php foreach ($stats as $i => $stat):
                                    $statLabel = $lang === 'en' && !empty($stat->label_en) ? $stat->label_en : ($stat->label ?? '');
                                    $statIcon = $stat->icon ?? 'fas fa-chart-bar';
                                ?>
                                    <div class="glass rounded-2xl p-5 text-center hover:border-cyan-400/30 transition">
                                        <div class="w-12 h-12 rounded-xl bg-cyan-500/15 flex items-center justify-center text-xl mx-auto mb-3">
                                            <i class="<?= htmlspecialchars($statIcon) ?> text-cyan-400"></i>
                                        </div>
                                        <h4 class="text-2xl sm:text-3xl font-black text-cyan-400"><?= $stat->value ?></h4>
                                        <p class="text-gray-400 mt-1 text-sm"><?= htmlspecialchars($statLabel) ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features List -->
            <div class="fade-up" style="transition-delay:.25s">
                <h3 class="text-2xl font-bold mb-6">
                    <?= $lang === 'en' ? 'Why Choose Us' : 'لماذا تختارنا' ?>
                </h3>
                <div class="space-y-4">
                    <?php foreach ($features as $fi => $feat):
                        $featTitle = $lang === 'en' && !empty($feat->title_en) ? $feat->title_en : ($feat->title ?? '');
                        $featDesc  = $lang === 'en' && !empty($feat->description_en) ? $feat->description_en : ($feat->description ?? '');
                        $featIcon  = $feat->icon ?? 'fas fa-check';
                    ?>
                        <div class="glass rounded-2xl p-5 flex items-start gap-4 glow-border transition-all duration-300 hover:-translate-y-0.5">
                            <div class="w-11 h-11 min-w-[44px] rounded-xl bg-cyan-500 flex items-center justify-center font-black text-black text-base flex-shrink-0">
                                <i class="<?= htmlspecialchars($featIcon) ?>"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-100"><?= htmlspecialchars($featTitle) ?></p>
                                <p class="text-gray-400 text-sm mt-1"><?= htmlspecialchars($featDesc) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════ CTA SECTION ═══════ -->
<section class="relative z-10 px-6 lg:px-20 py-20 fade-up">
    <div class="bg-gradient-to-r from-cyan-500 to-blue-700 rounded-[40px] p-10 lg:p-16 text-center shadow-2xl shadow-cyan-500/20 relative overflow-hidden">
        <div class="absolute -top-20 -right-20 w-60 h-60 bg-white/10 rounded-full blur-[60px]"></div>
        <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-white/10 rounded-full blur-[60px]"></div>

        <h2 class="relative text-3xl sm:text-4xl font-black leading-tight mb-6">
            <?= $lang === 'en' ? 'Ready to Get Started?' : 'هل أنت مستعد للبدء؟' ?>
        </h2>
        <p class="relative text-lg opacity-90 max-w-2xl mx-auto leading-relaxed mb-10">
            <?= $lang === 'en'
                ? 'Contact our team now and discover how we can help you achieve your goals.'
                : 'تواصل مع فريقنا الآن واكتشف كيف يمكننا مساعدتك في تحقيق أهدافك.' ?>
        </p>
        <div class="relative flex flex-wrap justify-center gap-4">
            <a href="https://wa.me/<?= $waNumber ?>" target="_blank"
               class="inline-flex items-center gap-2 bg-white text-[#0f172a] hover:scale-105 transition px-8 py-4 rounded-2xl font-black text-base shadow-xl">
                <i class="fab fa-whatsapp text-lg"></i>
                <?= $lang === 'en' ? 'Contact via WhatsApp' : 'تواصل عبر واتساب' ?>
            </a>
            <a href="<?= url($siteBase . '/contact') ?>"
               class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 transition px-8 py-4 rounded-2xl font-bold text-base border border-white/20">
                <i class="fas fa-envelope"></i>
                <?= $lang === 'en' ? 'Send a Message' : 'أرسل رسالة' ?>
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

<?php
/**
 * Master Theme — Contact Page
 * Two-column layout: contact info cards + contact form
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';
$whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
$waNumber = preg_replace('/[^0-9+]/', '', $whatsapp);
$waUrl    = $waNumber ? 'https://wa.me/' . $waNumber : '#';

// Page title
$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'Contact Us' : 'اتصل بنا'));

require_once __DIR__ . '/_head.php';
require_once __DIR__ . '/_navbar.php';
?>

<!-- Background Effects -->
<div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
    <div class="absolute -top-20 -right-20 w-[500px] h-[500px] bg-cyan-500/15 blur-[120px] rounded-full"></div>
    <div class="absolute -bottom-20 -left-20 w-[500px] h-[500px] bg-blue-500/15 blur-[120px] rounded-full"></div>
</div>

<!-- ═══════ PAGE HEADER ═══════ -->
<section class="relative z-10 px-6 lg:px-20 pt-32 pb-8">
    <div class="max-w-4xl fade-up">
        <div class="inline-flex items-center gap-2 glass rounded-full px-4 py-2 text-sm text-cyan-300 mb-6">
            <i class="fas fa-paper-plane text-xs"></i>
            <span><?= $lang === 'en' ? 'Contact Us' : 'اتصل بنا' ?></span>
        </div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight mb-6">
            <?= htmlspecialchars($pageTitle) ?>
        </h1>
        <p class="text-gray-300 text-lg leading-relaxed max-w-3xl">
            <?= $lang === 'en'
                ? 'We would love to hear from you. Reach out to us through any of the channels below or fill the form.'
                : 'يسعدنا التواصل معكم. تواصلوا معنا عبر أي من القنوات أدناه أو املأوا النموذج.' ?>
        </p>
        <div class="w-24 h-1.5 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full mt-6"></div>
    </div>
</section>

<!-- ═══════ CONTACT CONTENT ═══════ -->
<section class="relative z-10 px-6 lg:px-20 py-16">
    <div class="grid lg:grid-cols-5 gap-12">

        <!-- Left Column: Contact Info Cards (2/5) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Phone -->
            <?php if (!empty($tenant->contact_phone)): ?>
                <div class="glass rounded-2xl p-6 glow-border transition-all duration-300 hover:-translate-y-1 fade-up">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 min-w-[48px] rounded-xl bg-cyan-500/20 border border-cyan-400/20 flex items-center justify-center text-xl">
                            <i class="fas fa-phone text-cyan-400"></i>
                        </div>
                        <div>
                            <h3 class="font-bold mb-1"><?= $lang === 'en' ? 'Phone' : 'الهاتف' ?></h3>
                            <a href="tel:<?= htmlspecialchars($tenant->contact_phone) ?>" class="text-gray-300 hover:text-cyan-400 transition" dir="ltr">
                                <?= htmlspecialchars($tenant->contact_phone) ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- WhatsApp -->
            <?php if (!empty($tenant->contact_whatsapp) || !empty($tenant->contact_phone)): ?>
                <div class="glass rounded-2xl p-6 glow-border transition-all duration-300 hover:-translate-y-1 fade-up" style="transition-delay:.05s">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 min-w-[48px] rounded-xl bg-green-500/20 border border-green-400/20 flex items-center justify-center text-xl">
                            <i class="fab fa-whatsapp text-green-400"></i>
                        </div>
                        <div>
                            <h3 class="font-bold mb-1">WhatsApp</h3>
                            <a href="<?= $waUrl ?>" target="_blank"
                               class="text-gray-300 hover:text-green-400 transition" dir="ltr">
                                <?= htmlspecialchars($tenant->contact_whatsapp ?? $tenant->contact_phone) ?>
                            </a>
                            <div class="mt-3">
                                <a href="<?= $waUrl ?>" target="_blank"
                                   class="inline-flex items-center gap-2 bg-[#25D366] hover:bg-[#20bd5a] transition px-4 py-2 rounded-xl text-sm font-bold shadow-lg shadow-green-500/30 text-white">
                                    <i class="fab fa-whatsapp"></i>
                                    <?= $lang === 'en' ? 'Chat Now' : 'محادثة الآن' ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Email -->
            <?php if (!empty($tenant->contact_email)): ?>
                <div class="glass rounded-2xl p-6 glow-border transition-all duration-300 hover:-translate-y-1 fade-up" style="transition-delay:.1s">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 min-w-[48px] rounded-xl bg-blue-500/20 border border-blue-400/20 flex items-center justify-center text-xl">
                            <i class="fas fa-envelope text-blue-400"></i>
                        </div>
                        <div>
                            <h3 class="font-bold mb-1"><?= $lang === 'en' ? 'Email' : 'البريد الإلكتروني' ?></h3>
                            <a href="mailto:<?= htmlspecialchars($tenant->contact_email) ?>"
                               class="text-gray-300 hover:text-cyan-400 transition break-all" dir="ltr">
                                <?= htmlspecialchars($tenant->contact_email) ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Address -->
            <?php if (!empty($tenant->address)): ?>
                <div class="glass rounded-2xl p-6 glow-border transition-all duration-300 hover:-translate-y-1 fade-up" style="transition-delay:.15s">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 min-w-[48px] rounded-xl bg-purple-500/20 border border-purple-400/20 flex items-center justify-center text-xl">
                            <i class="fas fa-location-dot text-purple-400"></i>
                        </div>
                        <div>
                            <h3 class="font-bold mb-1"><?= $lang === 'en' ? 'Address' : 'العنوان' ?></h3>
                            <p class="text-gray-300"><?= htmlspecialchars($tenant->address) ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Working Hours -->
            <?php if (!empty($tenant->working_hours)): ?>
                <div class="glass rounded-2xl p-6 glow-border transition-all duration-300 hover:-translate-y-1 fade-up" style="transition-delay:.2s">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 min-w-[48px] rounded-xl bg-amber-500/20 border border-amber-400/20 flex items-center justify-center text-xl">
                            <i class="fas fa-clock text-amber-400"></i>
                        </div>
                        <div>
                            <h3 class="font-bold mb-1"><?= $lang === 'en' ? 'Working Hours' : 'ساعات العمل' ?></h3>
                            <p class="text-gray-300 whitespace-pre-line"><?= htmlspecialchars($tenant->working_hours) ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Social Media -->
            <?php if (!empty($tenant->facebook) || !empty($tenant->instagram) || !empty($tenant->twitter)): ?>
                <div class="glass rounded-2xl p-6 fade-up" style="transition-delay:.25s">
                    <h3 class="font-bold mb-4"><?= $lang === 'en' ? 'Follow Us' : 'تابعنا' ?></h3>
                    <div class="flex gap-3">
                        <?php if (!empty($tenant->facebook)): ?>
                            <a href="<?= htmlspecialchars($tenant->facebook) ?>" target="_blank"
                               class="w-11 h-11 rounded-xl glass flex items-center justify-center text-gray-400 hover:text-blue-400 hover:border-blue-400/30 transition">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($tenant->instagram)): ?>
                            <a href="<?= htmlspecialchars($tenant->instagram) ?>" target="_blank"
                               class="w-11 h-11 rounded-xl glass flex items-center justify-center text-gray-400 hover:text-pink-400 hover:border-pink-400/30 transition">
                                <i class="fab fa-instagram"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($tenant->twitter)): ?>
                            <a href="<?= htmlspecialchars($tenant->twitter) ?>" target="_blank"
                               class="w-11 h-11 rounded-xl glass flex items-center justify-center text-gray-400 hover:text-sky-400 hover:border-sky-400/30 transition">
                                <i class="fab fa-twitter"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right Column: Contact Form (3/5) -->
        <div class="lg:col-span-3 fade-up" style="transition-delay:.1s">
            <div class="glass-strong rounded-[30px] p-8 lg:p-10">
                <h2 class="text-2xl font-bold mb-2">
                    <?= $lang === 'en' ? 'Send Us a Message' : 'أرسل لنا رسالة' ?>
                </h2>
                <p class="text-gray-400 mb-8">
                    <?= $lang === 'en' ? 'Fill the form below and we will get back to you as soon as possible.' : 'املأ النموذج أدناه وسنتواصل معك في أقرب وقت ممكن.' ?>
                </p>

                <form action="<?= url($siteBase . '/contact') ?>" method="POST" class="space-y-5">
                    <?php if ($is_preview ?? false): ?>
                        <div class="bg-amber-500/10 border border-amber-400/30 rounded-xl p-4 text-amber-300 text-sm">
                            <i class="fas fa-eye <?= $isRtl ? 'ms-2' : 'mr-2' ?>"></i>
                            <?= $lang === 'en' ? 'Preview mode — form submission is disabled.' : 'وضع المعاينة — إرسال النموذج معطل.' ?>
                        </div>
                    <?php endif; ?>

                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-300 mb-2">
                            <?= $lang === 'en' ? 'Full Name' : 'الاسم الكامل' ?> <span class="text-cyan-400">*</span>
                        </label>
                        <input type="text" name="name" required
                               class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-3.5 text-white placeholder-gray-500 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400/30 outline-none transition"
                               placeholder="<?= $lang === 'en' ? 'Enter your full name' : 'أدخل اسمك الكامل' ?>">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-300 mb-2">
                            <?= $lang === 'en' ? 'Email Address' : 'البريد الإلكتروني' ?> <span class="text-cyan-400">*</span>
                        </label>
                        <input type="email" name="email" required
                               class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-3.5 text-white placeholder-gray-500 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400/30 outline-none transition"
                               placeholder="<?= $lang === 'en' ? 'Enter your email' : 'أدخل بريدك الإلكتروني' ?>" dir="ltr">
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-300 mb-2">
                            <?= $lang === 'en' ? 'Phone Number' : 'رقم الهاتف' ?>
                        </label>
                        <input type="tel" name="phone"
                               class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-3.5 text-white placeholder-gray-500 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400/30 outline-none transition"
                               placeholder="<?= $lang === 'en' ? 'Enter your phone number' : 'أدخل رقم هاتفك' ?>" dir="ltr">
                    </div>

                    <!-- Subject -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-300 mb-2">
                            <?= $lang === 'en' ? 'Subject' : 'الموضوع' ?> <span class="text-cyan-400">*</span>
                        </label>
                        <input type="text" name="subject" required
                               class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-3.5 text-white placeholder-gray-500 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400/30 outline-none transition"
                               placeholder="<?= $lang === 'en' ? 'What is this about?' : 'ما هو موضوع رسالتك؟' ?>">
                    </div>

                    <!-- Message -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-300 mb-2">
                            <?= $lang === 'en' ? 'Message' : 'الرسالة' ?> <span class="text-cyan-400">*</span>
                        </label>
                        <textarea name="message" rows="5" required
                                  class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-3.5 text-white placeholder-gray-500 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400/30 outline-none transition resize-none"
                                  placeholder="<?= $lang === 'en' ? 'Write your message here...' : 'اكتب رسالتك هنا...' ?>"></textarea>
                    </div>

                    <!-- Submit -->
                    <button type="submit" <?= ($is_preview ?? false) ? 'disabled' : '' ?>
                            class="w-full bg-cyan-500 hover:bg-cyan-400 disabled:opacity-50 disabled:cursor-not-allowed transition rounded-2xl py-4 font-bold text-lg shadow-lg shadow-cyan-500/30 flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i>
                        <?= $lang === 'en' ? 'Send Message' : 'إرسال الرسالة' ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

<?php
/**
 * Tek Pro Theme — Contact Page
 * Light theme + Orange accents
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';
$whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
$waNumber = preg_replace('/[^0-9+]/', '', $whatsapp);
$waUrl    = $waNumber ? 'https://wa.me/' . $waNumber : '#';

$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'Contact Us' : 'اتصل بنا'));

require_once __DIR__ . '/_head.php';
require_once __DIR__ . '/_navbar.php';
?>

<!-- ═══════ PAGE HEADER ═══════ -->
<section class="bg-[#f3f3f3] px-6 lg:px-16 py-16">
    <div class="max-w-4xl mx-auto fade-up">
        <p class="text-[#ff7a00] font-black mb-3"><?= $lang === 'en' ? 'Contact Us' : 'اتصل بنا' ?></p>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight mb-6"><?= htmlspecialchars($pageTitle) ?></h1>
        <p class="text-gray-600 text-lg leading-relaxed max-w-3xl">
            <?= $lang === 'en'
                ? 'We would love to hear from you. Reach out through any channel or fill the form.'
                : 'يسعدنا التواصل معكم. تواصلوا عبر أي من القنوات أدناه أو املأوا النموذج.' ?>
        </p>
    </div>
</section>

<!-- ═══════ CONTACT CONTENT ═══════ -->
<section class="px-6 lg:px-16 py-16">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-5 gap-12">

        <!-- Left: Contact Cards -->
        <div class="lg:col-span-2 space-y-6">
            <?php if (!empty($tenant->contact_phone)): ?>
                <div class="bg-[#f5f5f5] rounded-lg p-6 tekpro-card fade-up">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 min-w-[48px] rounded-lg bg-[#ff7a00]/10 flex items-center justify-center text-xl">
                            <i class="fas fa-phone text-[#ff7a00]"></i>
                        </div>
                        <div>
                            <h3 class="font-black mb-1"><?= $lang === 'en' ? 'Phone' : 'الهاتف' ?></h3>
                            <a href="tel:<?= htmlspecialchars($tenant->contact_phone) ?>" class="text-gray-600 hover:text-[#ff7a00] transition" dir="ltr"><?= htmlspecialchars($tenant->contact_phone) ?></a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($waNumber): ?>
                <div class="bg-[#f5f5f5] rounded-lg p-6 tekpro-card fade-up" style="transition-delay:.05s">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 min-w-[48px] rounded-lg bg-green-50 flex items-center justify-center text-xl">
                            <i class="fab fa-whatsapp text-green-500"></i>
                        </div>
                        <div>
                            <h3 class="font-black mb-1">WhatsApp</h3>
                            <a href="<?= $waUrl ?>" target="_blank" class="text-gray-600 hover:text-green-500 transition" dir="ltr"><?= htmlspecialchars($tenant->contact_whatsapp ?? $tenant->contact_phone ?? '') ?></a>
                            <div class="mt-3">
                                <a href="<?= $waUrl ?>" target="_blank"
                                   class="inline-flex items-center gap-2 bg-[#25D366] hover:bg-[#20bd5a] transition px-4 py-2 rounded-lg text-sm font-bold text-white shadow-lg">
                                    <i class="fab fa-whatsapp"></i> <?= $lang === 'en' ? 'Chat Now' : 'محادثة الآن' ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($tenant->contact_email)): ?>
                <div class="bg-[#f5f5f5] rounded-lg p-6 tekpro-card fade-up" style="transition-delay:.1s">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 min-w-[48px] rounded-lg bg-[#ff7a00]/10 flex items-center justify-center text-xl">
                            <i class="fas fa-envelope text-[#ff7a00]"></i>
                        </div>
                        <div>
                            <h3 class="font-black mb-1"><?= $lang === 'en' ? 'Email' : 'البريد الإلكتروني' ?></h3>
                            <a href="mailto:<?= htmlspecialchars($tenant->contact_email) ?>" class="text-gray-600 hover:text-[#ff7a00] transition break-all text-sm" dir="ltr"><?= htmlspecialchars($tenant->contact_email) ?></a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($tenant->address)): ?>
                <div class="bg-[#f5f5f5] rounded-lg p-6 tekpro-card fade-up" style="transition-delay:.15s">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 min-w-[48px] rounded-lg bg-[#ff7a00]/10 flex items-center justify-center text-xl">
                            <i class="fas fa-location-dot text-[#ff7a00]"></i>
                        </div>
                        <div>
                            <h3 class="font-black mb-1"><?= $lang === 'en' ? 'Address' : 'العنوان' ?></h3>
                            <p class="text-gray-600"><?= htmlspecialchars($tenant->address) ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($tenant->working_hours)): ?>
                <div class="bg-[#f5f5f5] rounded-lg p-6 tekpro-card fade-up" style="transition-delay:.2s">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 min-w-[48px] rounded-lg bg-amber-50 flex items-center justify-center text-xl">
                            <i class="fas fa-clock text-amber-500"></i>
                        </div>
                        <div>
                            <h3 class="font-black mb-1"><?= $lang === 'en' ? 'Working Hours' : 'ساعات العمل' ?></h3>
                            <p class="text-gray-600 whitespace-pre-line"><?= htmlspecialchars($tenant->working_hours) ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Social -->
            <?php if (!empty($tenant->facebook) || !empty($tenant->instagram) || !empty($tenant->twitter)): ?>
                <div class="bg-[#f5f5f5] rounded-lg p-6 fade-up" style="transition-delay:.25s">
                    <h3 class="font-black mb-4"><?= $lang === 'en' ? 'Follow Us' : 'تابعنا' ?></h3>
                    <div class="flex gap-3">
                        <?php if (!empty($tenant->facebook)): ?><a href="<?= htmlspecialchars($tenant->facebook) ?>" target="_blank" class="w-11 h-11 rounded-lg bg-white hover:bg-[#ff7a00] transition flex items-center justify-center text-gray-500 hover:text-white shadow-sm"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
                        <?php if (!empty($tenant->instagram)): ?><a href="<?= htmlspecialchars($tenant->instagram) ?>" target="_blank" class="w-11 h-11 rounded-lg bg-white hover:bg-[#ff7a00] transition flex items-center justify-center text-gray-500 hover:text-white shadow-sm"><i class="fab fa-instagram"></i></a><?php endif; ?>
                        <?php if (!empty($tenant->twitter)): ?><a href="<?= htmlspecialchars($tenant->twitter) ?>" target="_blank" class="w-11 h-11 rounded-lg bg-white hover:bg-[#ff7a00] transition flex items-center justify-center text-gray-500 hover:text-white shadow-sm"><i class="fab fa-twitter"></i></a><?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right: Contact Form -->
        <div class="lg:col-span-3 fade-up" style="transition-delay:.1s">
            <div class="bg-white shadow-xl rounded-lg p-8 lg:p-10">
                <h2 class="text-2xl font-black mb-2"><?= $lang === 'en' ? 'Send Us a Message' : 'أرسل لنا رسالة' ?></h2>
                <p class="text-gray-500 mb-8"><?= $lang === 'en' ? 'Fill the form below and we will get back to you soon.' : 'املأ النموذج وسنتواصل معك في أقرب وقت.' ?></p>

                <form action="<?= url($siteBase . '/contact') ?>" method="POST" class="space-y-5">
                    <?php if ($is_preview ?? false): ?>
                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 text-amber-700 text-sm">
                            <i class="fas fa-eye <?= $isRtl ? 'ms-2' : 'mr-2' ?>"></i>
                            <?= $lang === 'en' ? 'Preview mode — form disabled.' : 'وضع المعاينة — الإرسال معطل.' ?>
                        </div>
                    <?php endif; ?>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2"><?= $lang === 'en' ? 'Full Name' : 'الاسم الكامل' ?> <span class="text-[#ff7a00]">*</span></label>
                        <input type="text" name="name" required
                               class="w-full bg-[#f5f5f5] border border-gray-200 rounded-lg px-5 py-3.5 text-gray-800 placeholder-gray-400 focus:border-[#ff7a00] focus:ring-1 focus:ring-[#ff7a00]/30 outline-none transition"
                               placeholder="<?= $lang === 'en' ? 'Enter your full name' : 'أدخل اسمك الكامل' ?>">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2"><?= $lang === 'en' ? 'Email Address' : 'البريد الإلكتروني' ?> <span class="text-[#ff7a00]">*</span></label>
                        <input type="email" name="email" required
                               class="w-full bg-[#f5f5f5] border border-gray-200 rounded-lg px-5 py-3.5 text-gray-800 placeholder-gray-400 focus:border-[#ff7a00] focus:ring-1 focus:ring-[#ff7a00]/30 outline-none transition"
                               placeholder="<?= $lang === 'en' ? 'Enter your email' : 'أدخل بريدك الإلكتروني' ?>" dir="ltr">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2"><?= $lang === 'en' ? 'Phone Number' : 'رقم الهاتف' ?></label>
                        <input type="tel" name="phone"
                               class="w-full bg-[#f5f5f5] border border-gray-200 rounded-lg px-5 py-3.5 text-gray-800 placeholder-gray-400 focus:border-[#ff7a00] focus:ring-1 focus:ring-[#ff7a00]/30 outline-none transition"
                               placeholder="<?= $lang === 'en' ? 'Enter your phone number' : 'أدخل رقم هاتفك' ?>" dir="ltr">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2"><?= $lang === 'en' ? 'Subject' : 'الموضوع' ?> <span class="text-[#ff7a00]">*</span></label>
                        <input type="text" name="subject" required
                               class="w-full bg-[#f5f5f5] border border-gray-200 rounded-lg px-5 py-3.5 text-gray-800 placeholder-gray-400 focus:border-[#ff7a00] focus:ring-1 focus:ring-[#ff7a00]/30 outline-none transition"
                               placeholder="<?= $lang === 'en' ? 'What is this about?' : 'ما هو موضوع رسالتك؟' ?>">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2"><?= $lang === 'en' ? 'Message' : 'الرسالة' ?> <span class="text-[#ff7a00]">*</span></label>
                        <textarea name="message" rows="5" required
                                  class="w-full bg-[#f5f5f5] border border-gray-200 rounded-lg px-5 py-3.5 text-gray-800 placeholder-gray-400 focus:border-[#ff7a00] focus:ring-1 focus:ring-[#ff7a00]/30 outline-none transition resize-none"
                                  placeholder="<?= $lang === 'en' ? 'Write your message...' : 'اكتب رسالتك هنا...' ?>"></textarea>
                    </div>
                    <button type="submit" <?= ($is_preview ?? false) ? 'disabled' : '' ?>
                            class="w-full bg-[#ff7a00] hover:bg-[#e86e00] disabled:opacity-50 disabled:cursor-not-allowed transition rounded-lg py-4 font-black text-lg text-white flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i> <?= $lang === 'en' ? 'Send Message' : 'إرسال الرسالة' ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

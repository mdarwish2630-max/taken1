<?php
/**
 * TakPro Theme — Contact Page
 */
$siteBase  = $siteBase ?? ('/site/' . ($tenant->slug ?? 'demo'));
$dir       = $dir ?? 'rtl';
$lang      = $lang ?? 'ar';
$isRtl     = ($dir === 'rtl');

$whatsapp  = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
$waNumber  = preg_replace('/[^0-9+]/', '', $whatsapp);
$phone     = $tenant->contact_phone ?? '';
$email     = $tenant->contact_email ?? '';
$address   = $tenant->address ?? '';
$workingHours = $tenant->working_hours ?? '';

$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'Contact Us' : 'تواصل معنا'));

require_once __DIR__ . '/_head.php';
require_once __DIR__ . '/_navbar.php';
?>

<!-- ══════════════════════════════════════════════════════
     PAGE HEADER
     ══════════════════════════════════════════════════════ -->
<section class="relative bg-dark-section py-24 px-6 lg:px-16">
    <img src="https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?q=80&w=1800&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-20" alt="">
    <div class="relative z-10 max-w-7xl mx-auto text-center text-white fade-up">
        <h1 class="text-5xl lg:text-6xl font-black mb-4"><?= htmlspecialchars($pageTitle) ?></h1>
        <p class="text-lg text-gray-300 max-w-2xl mx-auto">
            <?= $lang === 'en'
                ? 'We are here to help. Reach out to us through any of the following channels.'
                : 'نحن هنا لمساعدتك. تواصل معنا عبر أي من القنوات التالية.' ?>
        </p>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════
     CONTACT INFO CARDS
     ══════════════════════════════════════════════════════ -->
<section class="px-6 lg:px-16 py-20 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
            <!-- Phone -->
            <div class="bg-[#f5f5f5] p-8 rounded-xl text-center hover:shadow-xl hover:-translate-y-1 transition duration-300 fade-up">
                <div class="w-16 h-16 bg-brand rounded-full mx-auto mb-5 flex items-center justify-center text-white text-2xl">
                    <i class="fas fa-phone"></i>
                </div>
                <h3 class="font-black text-lg mb-2"><?= $lang === 'en' ? 'Phone' : 'الهاتف' ?></h3>
                <p class="text-gray-600"><?= $phone ? htmlspecialchars($phone) : ($lang === 'en' ? 'Call us anytime' : 'اتصل بنا في أي وقت') ?></p>
            </div>
            <!-- WhatsApp -->
            <?php if ($waNumber): ?>
            <a href="https://wa.me/<?= $waNumber ?>" target="_blank" class="bg-[#f5f5f5] p-8 rounded-xl text-center hover:shadow-xl hover:-translate-y-1 transition duration-300 fade-up block" style="transition-delay:.08s">
                <div class="w-16 h-16 bg-[#25D366] rounded-full mx-auto mb-5 flex items-center justify-center text-white text-2xl">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <h3 class="font-black text-lg mb-2">WhatsApp</h3>
                <p class="text-gray-600"><?= htmlspecialchars($waNumber) ?></p>
            </a>
            <?php endif; ?>
            <!-- Email -->
            <div class="bg-[#f5f5f5] p-8 rounded-xl text-center hover:shadow-xl hover:-translate-y-1 transition duration-300 fade-up" style="transition-delay:.16s">
                <div class="w-16 h-16 bg-brand rounded-full mx-auto mb-5 flex items-center justify-center text-white text-2xl">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3 class="font-black text-lg mb-2"><?= $lang === 'en' ? 'Email' : 'البريد' ?></h3>
                <p class="text-gray-600"><?= $email ? htmlspecialchars($email) : ($lang === 'en' ? 'Send us an email' : 'أرسل لنا بريد') ?></p>
            </div>
            <!-- Address -->
            <div class="bg-[#f5f5f5] p-8 rounded-xl text-center hover:shadow-xl hover:-translate-y-1 transition duration-300 fade-up" style="transition-delay:.24s">
                <div class="w-16 h-16 bg-brand rounded-full mx-auto mb-5 flex items-center justify-center text-white text-2xl">
                    <i class="fas fa-location-dot"></i>
                </div>
                <h3 class="font-black text-lg mb-2"><?= $lang === 'en' ? 'Address' : 'العنوان' ?></h3>
                <p class="text-gray-600"><?= $address ? htmlspecialchars($address) : ($lang === 'en' ? 'Istanbul, Turkey' : 'إسطنبول، تركيا') ?></p>
            </div>
        </div>

        <!-- Contact Form + Map -->
        <div class="grid lg:grid-cols-2 gap-14">
            <!-- Form -->
            <div class="fade-up">
                <h2 class="text-4xl font-black mb-6"><?= $lang === 'en' ? 'Send a Message' : 'أرسل رسالة' ?></h2>
                <form class="space-y-5" onsubmit="event.preventDefault();">
                    <div class="grid sm:grid-cols-2 gap-5">
                        <input type="text" placeholder="<?= $lang === 'en' ? 'Full Name' : 'الاسم الكامل' ?>"
                               class="w-full p-4 bg-[#f5f5f5] rounded-xl border-none focus:ring-2 focus:ring-brand outline-none transition" required>
                        <input type="tel" placeholder="<?= $lang === 'en' ? 'Phone Number' : 'رقم الهاتف' ?>"
                               class="w-full p-4 bg-[#f5f5f5] rounded-xl border-none focus:ring-2 focus:ring-brand outline-none transition">
                    </div>
                    <input type="email" placeholder="<?= $lang === 'en' ? 'Email Address' : 'البريد الإلكتروني' ?>"
                           class="w-full p-4 bg-[#f5f5f5] rounded-xl border-none focus:ring-2 focus:ring-brand outline-none transition" required>
                    <select class="w-full p-4 bg-[#f5f5f5] rounded-xl border-none focus:ring-2 focus:ring-brand outline-none transition text-gray-500">
                        <option value=""><?= $lang === 'en' ? 'Select Service' : 'اختر الخدمة' ?></option>
                        <option><?= $lang === 'en' ? 'Technical Support' : 'الدعم التقني' ?></option>
                        <option><?= $lang === 'en' ? 'Network Solutions' : 'حلول الشبكات' ?></option>
                        <option><?= $lang === 'en' ? 'System Maintenance' : 'صيانة الأنظمة' ?></option>
                        <option><?= $lang === 'en' ? 'Full Sanitization' : 'تعقيم كامل' ?></option>
                        <option><?= $lang === 'en' ? 'Other' : 'أخرى' ?></option>
                    </select>
                    <textarea placeholder="<?= $lang === 'en' ? 'Your Message...' : 'رسالتك...' ?>" rows="5"
                              class="w-full p-4 bg-[#f5f5f5] rounded-xl border-none focus:ring-2 focus:ring-brand outline-none transition resize-none"></textarea>
                    <button type="submit"
                            class="w-full bg-brand text-white p-4 rounded-xl font-black text-lg hover:bg-brand-dark transition">
                        <?= $lang === 'en' ? 'Send Message' : 'إرسال الرسالة' ?>
                    </button>
                </form>
            </div>

            <!-- Map / Info -->
            <div class="fade-up" style="transition-delay:.1s">
                <h2 class="text-4xl font-black mb-6"><?= $lang === 'en' ? 'Find Us' : 'موقعنا' ?></h2>
                <div class="bg-[#f5f5f5] rounded-xl overflow-hidden h-[300px] mb-8 flex items-center justify-center">
                    <div class="text-center text-gray-400">
                        <i class="fas fa-map-marker-alt text-6xl mb-4 text-brand"></i>
                        <p class="text-lg font-bold text-dark"><?= $address ? htmlspecialchars($address) : ($lang === 'en' ? 'Istanbul, Turkey' : 'إسطنبول، تركيا') ?></p>
                    </div>
                </div>

                <!-- Working Hours -->
                <div class="bg-brand p-8 rounded-xl text-dark">
                    <h3 class="text-2xl font-black mb-4 flex items-center gap-3">
                        <i class="fas fa-clock"></i>
                        <?= $lang === 'en' ? 'Working Hours' : 'ساعات العمل' ?>
                    </h3>
                    <p class="font-bold text-lg">
                        <?= htmlspecialchars($workingHours ?: ($lang === 'en' ? 'Available 24/7 - All Week' : 'متاحون 24/7 - طوال الأسبوع')) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

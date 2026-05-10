<?php
/**
 * Tek Pro Theme — Booking Page
 * Light theme + Orange accents
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';
$whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
$waNumber = preg_replace('/[^0-9+]/', '', $whatsapp);
$waUrl    = $waNumber ? 'https://wa.me/' . $waNumber : '#';

$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'Book Now' : 'احجز الآن'));

$timeSlots = ['08:00', '09:00', '10:00', '11:00', '12:00', '01:00 م', '02:00 م', '03:00 م', '04:00 م', '05:00 م', '06:00 م', '07:00 م', '08:00 م'];

$whyBook = $lang === 'en' ? [
    (object)['title' => 'Easy Booking', 'description' => 'Book your appointment in just a few clicks.', 'icon' => 'fas fa-mouse-pointer'],
    (object)['title' => 'Instant Confirmation', 'description' => 'Get your booking confirmed immediately.', 'icon' => 'fas fa-circle-check'],
    (object)['title' => 'Expert Service', 'description' => 'Certified professionals handle your request.', 'icon' => 'fas fa-user-tie'],
    (object)['title' => 'Flexible Scheduling', 'description' => 'Choose a date and time that works for you.', 'icon' => 'fas fa-calendar-alt'],
] : [
    (object)['title' => 'حجز سهل', 'description' => 'احجز موعدك ببضع نقرات فقط.', 'icon' => 'fas fa-mouse-pointer'],
    (object)['title' => 'تأكيد فوري', 'description' => 'احصل على تأكيد حجزك فوراً.', 'icon' => 'fas fa-circle-check'],
    (object)['title' => 'خدمة محترفة', 'description' => 'محترفون معتمدون يتولون طلبك.', 'icon' => 'fas fa-user-tie'],
    (object)['title' => 'جدولة مرنة', 'description' => 'اختر التاريخ والوقت المناسب.', 'icon' => 'fas fa-calendar-alt'],
];

require_once __DIR__ . '/_head.php';
require_once __DIR__ . '/_navbar.php';
?>

<!-- ═══════ PAGE HEADER ═══════ -->
<section class="bg-[#f3f3f3] px-6 lg:px-16 py-16">
    <div class="max-w-4xl mx-auto fade-up">
        <p class="text-[#ff7a00] font-black mb-3"><?= $lang === 'en' ? 'Book Now' : 'احجز الآن' ?></p>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight mb-6"><?= htmlspecialchars($pageTitle) ?></h1>
        <p class="text-gray-600 text-lg leading-relaxed max-w-3xl">
            <?= $lang === 'en' ? 'Schedule your appointment easily. Fill the form and our team will confirm.' : 'احجز موعدك بسهولة. املأ النموذج وفريقنا سيؤكد حجزك.' ?>
        </p>
    </div>
</section>

<!-- ═══════ BOOKING CONTENT ═══════ -->
<section class="px-6 lg:px-16 py-12 pb-20">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-5 gap-10 lg:gap-14">

        <!-- Booking Form -->
        <div class="lg:col-span-3 fade-up">
            <div class="bg-white shadow-xl rounded-lg p-8 lg:p-10">
                <h2 class="text-2xl font-black mb-8"><?= $lang === 'en' ? 'Book an Appointment' : 'احجز موعد' ?></h2>

                <form action="<?= url($siteBase . '/booking') ?>" method="POST" class="space-y-5" id="bookingForm">
                    <?php if ($is_preview ?? false): ?>
                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 text-amber-700 text-sm">
                            <i class="fas fa-eye <?= $isRtl ? 'ms-2' : 'mr-2' ?>"></i>
                            <?= $lang === 'en' ? 'Preview mode — form disabled.' : 'وضع المعاينة — الإرسال معطل.' ?>
                        </div>
                    <?php endif; ?>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2"><?= $lang === 'en' ? 'Full Name' : 'الاسم الكامل' ?> <span class="text-[#ff7a00]">*</span></label>
                        <input type="text" name="name" required class="w-full bg-[#f5f5f5] border border-gray-200 rounded-lg px-5 py-3.5 text-gray-800 placeholder-gray-400 focus:border-[#ff7a00] focus:ring-1 focus:ring-[#ff7a00]/30 outline-none transition" placeholder="<?= $lang === 'en' ? 'Enter your full name' : 'أدخل اسمك الكامل' ?>">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2"><?= $lang === 'en' ? 'Email' : 'البريد الإلكتروني' ?> <span class="text-[#ff7a00]">*</span></label>
                        <input type="email" name="email" required class="w-full bg-[#f5f5f5] border border-gray-200 rounded-lg px-5 py-3.5 text-gray-800 placeholder-gray-400 focus:border-[#ff7a00] focus:ring-1 focus:ring-[#ff7a00]/30 outline-none transition" placeholder="<?= $lang === 'en' ? 'Enter your email' : 'أدخل بريدك الإلكتروني' ?>" dir="ltr">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2"><?= $lang === 'en' ? 'Phone' : 'رقم الهاتف' ?> <span class="text-[#ff7a00]">*</span></label>
                        <input type="tel" name="phone" required class="w-full bg-[#f5f5f5] border border-gray-200 rounded-lg px-5 py-3.5 text-gray-800 placeholder-gray-400 focus:border-[#ff7a00] focus:ring-1 focus:ring-[#ff7a00]/30 outline-none transition" placeholder="<?= $lang === 'en' ? 'Phone number' : 'رقم الهاتف' ?>" dir="ltr">
                    </div>

                    <?php if (!empty($services)): ?>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2"><?= $lang === 'en' ? 'Select Service' : 'اختر الخدمة' ?> <span class="text-[#ff7a00]">*</span></label>
                        <select name="service_id" required class="w-full bg-[#f5f5f5] border border-gray-200 rounded-lg px-5 py-3.5 text-gray-800 focus:border-[#ff7a00] outline-none transition">
                            <option value=""><?= $lang === 'en' ? '-- Choose a service --' : '-- اختر خدمة --' ?></option>
                            <?php foreach ($services as $svc):
                                $svcTitle = $lang === 'en' && !empty($svc->title_en) ? $svc->title_en : ($svc->title ?? '');
                            ?>
                                <option value="<?= $svc->id ?>"><?= htmlspecialchars($svcTitle) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>

                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2"><?= $lang === 'en' ? 'Date' : 'التاريخ' ?> <span class="text-[#ff7a00]">*</span></label>
                            <input type="date" name="date" required class="w-full bg-[#f5f5f5] border border-gray-200 rounded-lg px-5 py-3.5 text-gray-800 focus:border-[#ff7a00] outline-none transition" min="<?= date('Y-m-d') ?>">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2"><?= $lang === 'en' ? 'Time' : 'الوقت' ?> <span class="text-[#ff7a00]">*</span></label>
                            <select name="time" required class="w-full bg-[#f5f5f5] border border-gray-200 rounded-lg px-5 py-3.5 text-gray-800 focus:border-[#ff7a00] outline-none transition">
                                <option value=""><?= $lang === 'en' ? '-- Choose time --' : '-- اختر الوقت --' ?></option>
                                <?php foreach ($timeSlots as $slot): ?>
                                    <option value="<?= $slot ?>"><?= $slot ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2"><?= $lang === 'en' ? 'Notes' : 'ملاحظات' ?></label>
                        <textarea name="notes" rows="4" class="w-full bg-[#f5f5f5] border border-gray-200 rounded-lg px-5 py-3.5 text-gray-800 placeholder-gray-400 focus:border-[#ff7a00] outline-none transition resize-none" placeholder="<?= $lang === 'en' ? 'Any additional details...' : 'أي تفاصيل إضافية...' ?>"></textarea>
                    </div>

                    <button type="submit" <?= ($is_preview ?? false) ? 'disabled' : '' ?>
                            class="w-full bg-[#ff7a00] hover:bg-[#e86e00] disabled:opacity-50 disabled:cursor-not-allowed transition rounded-lg py-4 font-black text-lg text-white flex items-center justify-center gap-2">
                        <i class="fas fa-calendar-check"></i> <?= $lang === 'en' ? 'Confirm Booking' : 'تأكيد الحجز' ?>
                    </button>

                    <?php if ($waNumber): ?>
                        <div class="text-center">
                            <span class="text-gray-400 text-sm"><?= $lang === 'en' ? 'Or book quickly via' : 'أو احجز بسرعة عبر' ?></span>
                            <a href="<?= $waUrl ?>?text=<?= urlencode($lang === 'en' ? 'I would like to book a service.' : 'أرغب في حجز خدمة.') ?>" target="_blank"
                               class="inline-flex items-center gap-1.5 text-green-500 hover:text-green-600 font-bold text-sm transition <?= $isRtl ? 'mr-1' : 'ml-1' ?>">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Quick Contact -->
            <div class="bg-[#171717] rounded-lg p-8 text-white fade-up" style="transition-delay:.1s">
                <h3 class="text-xl font-black mb-6 flex items-center gap-2">
                    <i class="fas fa-phone-volume text-[#ff7a00]"></i>
                    <?= $lang === 'en' ? 'Quick Contact' : 'تواصل سريع' ?>
                </h3>
                <div class="space-y-5">
                    <?php if (!empty($tenant->contact_phone)): ?>
                        <div class="flex items-center gap-4">
                            <div class="w-11 h-11 min-w-[44px] rounded-lg bg-[#ff7a00]/20 flex items-center justify-center"><i class="fas fa-phone text-[#ff7a00]"></i></div>
                            <div><p class="text-xs text-gray-400"><?= $lang === 'en' ? 'Phone' : 'الهاتف' ?></p><a href="tel:<?= htmlspecialchars($tenant->contact_phone) ?>" class="text-white hover:text-[#ff7a00] transition font-bold" dir="ltr"><?= htmlspecialchars($tenant->contact_phone) ?></a></div>
                        </div>
                    <?php endif; ?>
                    <?php if ($waNumber): ?>
                        <div class="flex items-center gap-4">
                            <div class="w-11 h-11 min-w-[44px] rounded-lg bg-green-500/20 flex items-center justify-center"><i class="fab fa-whatsapp text-green-400"></i></div>
                            <div><p class="text-xs text-gray-400">WhatsApp</p><a href="<?= $waUrl ?>" target="_blank" class="text-white hover:text-green-400 transition font-bold" dir="ltr"><?= htmlspecialchars($tenant->contact_whatsapp ?? $tenant->contact_phone ?? '') ?></a></div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($tenant->contact_email)): ?>
                        <div class="flex items-center gap-4">
                            <div class="w-11 h-11 min-w-[44px] rounded-lg bg-[#ff7a00]/20 flex items-center justify-center"><i class="fas fa-envelope text-[#ff7a00]"></i></div>
                            <div><p class="text-xs text-gray-400"><?= $lang === 'en' ? 'Email' : 'البريد' ?></p><a href="mailto:<?= htmlspecialchars($tenant->contact_email) ?>" class="text-white hover:text-[#ff7a00] transition text-sm break-all" dir="ltr"><?= htmlspecialchars($tenant->contact_email) ?></a></div>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($waNumber): ?>
                <a href="<?= $waUrl ?>?text=<?= urlencode($lang === 'en' ? 'I would like to book a service.' : 'أرغب في حجز خدمة.') ?>" target="_blank"
                   class="mt-6 w-full flex items-center justify-center gap-2 bg-[#25D366] hover:bg-[#20bd5a] transition rounded-lg py-4 font-black text-white">
                    <i class="fab fa-whatsapp text-xl"></i> <?= $lang === 'en' ? 'Book via WhatsApp' : 'احجز عبر واتساب' ?>
                </a>
                <?php endif; ?>
            </div>

            <!-- Why Book With Us -->
            <div class="bg-white shadow-xl rounded-lg p-8 fade-up" style="transition-delay:.2s">
                <h3 class="text-xl font-black mb-6 flex items-center gap-2">
                    <i class="fas fa-star text-[#ff7a00]"></i>
                    <?= $lang === 'en' ? 'Why Book With Us' : 'لماذا تحجز معنا' ?>
                </h3>
                <div class="space-y-4">
                    <?php foreach ($whyBook as $item): ?>
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 min-w-[36px] rounded-lg bg-[#ff7a00]/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="<?= htmlspecialchars($item->icon) ?> text-[#ff7a00] text-sm"></i>
                            </div>
                            <div><p class="font-bold text-sm text-gray-800"><?= htmlspecialchars($item->title) ?></p><p class="text-gray-500 text-xs mt-0.5"><?= htmlspecialchars($item->description) ?></p></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

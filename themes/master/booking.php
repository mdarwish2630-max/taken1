<?php
/**
 * Master Theme — Booking Page
 * Two-column layout: booking form + sidebar info
 */
$siteBase = $siteBase ?? ('/site/' . $tenant->slug);
$isRtl    = ($dir ?? 'rtl') === 'rtl';
$lang     = $lang ?? 'ar';
$whatsapp = $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '';
$waNumber = preg_replace('/[^0-9+]/', '', $whatsapp);
$waUrl    = $waNumber ? 'https://wa.me/' . $waNumber : '#';

// Page title
$pageTitle = $lang === 'en' && !empty($page->title_en) ? $page->title_en : ($page->title ?? ($lang === 'en' ? 'Book Now' : 'احجز الآن'));
$pageContent = $lang === 'en' && !empty($page->content_en) ? $page->content_en : ($page->content ?? '');

// Time slots
$timeSlots = $lang === 'en' ? [
    '08:00', '09:00', '10:00', '11:00', '12:00',
    '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00',
] : [
    '08:00', '09:00', '10:00', '11:00', '12:00',
    '01:00 م', '02:00 م', '03:00 م', '04:00 م', '05:00 م', '06:00 م', '07:00 م', '08:00 م',
];

// Why book with us
$whyBook = $lang === 'en' ? [
    (object)['title' => 'Easy Booking', 'description' => 'Book your appointment in just a few clicks.', 'icon' => 'fas fa-mouse-pointer'],
    (object)['title' => 'Instant Confirmation', 'description' => 'Get your booking confirmed immediately.', 'icon' => 'fas fa-circle-check'],
    (object)['title' => 'Expert Service', 'description' => 'Certified professionals handle your request.', 'icon' => 'fas fa-user-tie'],
    (object)['title' => 'Flexible Scheduling', 'description' => 'Choose a date and time that works for you.', 'icon' => 'fas fa-calendar-alt'],
] : [
    (object)['title' => 'حجز سهل', 'description' => 'احجز موعدك ببضع نقرات فقط.', 'icon' => 'fas fa-mouse-pointer'],
    (object)['title' => 'تأكيد فوري', 'description' => 'احصل على تأكيد حجزك فوراً.', 'icon' => 'fas fa-circle-check'],
    (object)['title' => 'خدمة محترفة', 'description' => 'محترفون معتمدون يتولون طلبك.', 'icon' => 'fas fa-user-tie'],
    (object)['title' => 'جدولة مرنة', 'description' => 'اختر التاريخ والوقت المناسب لك.', 'icon' => 'fas fa-calendar-alt'],
];

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
            <i class="fas fa-calendar-check text-xs"></i>
            <span><?= $lang === 'en' ? 'Book Now' : 'احجز الآن' ?></span>
        </div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight mb-6">
            <?= htmlspecialchars($pageTitle) ?>
        </h1>
        <?php if (!empty($pageContent)): ?>
            <p class="text-gray-300 text-lg leading-relaxed max-w-3xl"><?= $pageContent ?></p>
        <?php else: ?>
            <p class="text-gray-300 text-lg leading-relaxed max-w-3xl">
                <?= $lang === 'en'
                    ? 'Schedule your appointment easily. Fill the form below and our team will confirm your booking.'
                    : 'احجز موعدك بسهولة. املأ النموذج أدناه وفريقنا سيؤكد حجزك.' ?>
            </p>
        <?php endif; ?>
        <div class="w-24 h-1.5 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full mt-6"></div>
    </div>
</section>

<!-- ═══════ BOOKING CONTENT ═══════ -->
<section class="relative z-10 px-6 lg:px-20 py-12 pb-20">
    <div class="grid lg:grid-cols-5 gap-10 lg:gap-14">

        <!-- Left Column: Booking Form (3/5) -->
        <div class="lg:col-span-3 fade-up">
            <div class="glass-strong rounded-[30px] p-8 lg:p-10">
                <h2 class="text-2xl font-bold mb-2">
                    <?= $lang === 'en' ? 'Book an Appointment' : 'احجز موعد' ?>
                </h2>
                <p class="text-gray-400 mb-8">
                    <?= $lang === 'en'
                        ? 'Complete the form to schedule your service appointment.'
                        : 'أكمل النموذج لجدولة موعد الخدمة الخاص بك.' ?>
                </p>

                <form action="<?= url($siteBase . '/booking') ?>" method="POST" class="space-y-5" id="bookingForm">
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
                            <?= $lang === 'en' ? 'Phone Number' : 'رقم الهاتف' ?> <span class="text-cyan-400">*</span>
                        </label>
                        <input type="tel" name="phone" required
                               class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-3.5 text-white placeholder-gray-500 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400/30 outline-none transition"
                               placeholder="<?= $lang === 'en' ? 'Enter your phone number' : 'أدخل رقم هاتفك' ?>" dir="ltr">
                    </div>

                    <!-- Service Selection -->
                    <?php if (!empty($services)): ?>
                    <div>
                        <label class="block text-sm font-semibold text-gray-300 mb-2">
                            <?= $lang === 'en' ? 'Select Service' : 'اختر الخدمة' ?> <span class="text-cyan-400">*</span>
                        </label>
                        <select name="service_id" required
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-3.5 text-white focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400/30 outline-none transition appearance-none"
                                style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22%239ca3af%22 viewBox=%220 0 24 24%22><path d=%22M7 10l5 5 5-5z%22/></svg>'); background-repeat: no-repeat; background-position: <?= $isRtl ? 'left 16px' : 'right 16px' ?> center; background-size: 20px;">
                            <option value="" class="bg-[#111827]">
                                <?= $lang === 'en' ? '-- Choose a service --' : '-- اختر خدمة --' ?>
                            </option>
                            <?php foreach ($services as $svc):
                                $svcTitle = $lang === 'en' && !empty($svc->title_en) ? $svc->title_en : ($svc->title ?? '');
                                $svcPrice = !empty($svc->price) ? ' — ' . $svc->price : '';
                            ?>
                                <option value="<?= $svc->id ?>" class="bg-[#111827]">
                                    <?= htmlspecialchars($svcTitle . $svcPrice) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>

                    <!-- Date + Time Row -->
                    <div class="grid sm:grid-cols-2 gap-5">
                        <!-- Date -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-300 mb-2">
                                <?= $lang === 'en' ? 'Preferred Date' : 'التاريخ المفضل' ?> <span class="text-cyan-400">*</span>
                            </label>
                            <input type="date" name="date" required
                                   class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-3.5 text-white focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400/30 outline-none transition"
                                   min="<?= date('Y-m-d') ?>">
                        </div>

                        <!-- Time Slot -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-300 mb-2">
                                <?= $lang === 'en' ? 'Preferred Time' : 'الوقت المفضل' ?> <span class="text-cyan-400">*</span>
                            </label>
                            <select name="time" required
                                    class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-3.5 text-white focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400/30 outline-none transition appearance-none"
                                    style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22%239ca3af%22 viewBox=%220 0 24 24%22><path d=%22M7 10l5 5 5-5z%22/></svg>'); background-repeat: no-repeat; background-position: <?= $isRtl ? 'left 16px' : 'right 16px' ?> center; background-size: 20px;">
                                <option value="" class="bg-[#111827]">
                                    <?= $lang === 'en' ? '-- Choose time --' : '-- اختر الوقت --' ?>
                                </option>
                                <?php foreach ($timeSlots as $slot): ?>
                                    <option value="<?= $slot ?>" class="bg-[#111827]"><?= $slot ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-300 mb-2">
                            <?= $lang === 'en' ? 'Additional Notes' : 'ملاحظات إضافية' ?>
                        </label>
                        <textarea name="notes" rows="4"
                                  class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-3.5 text-white placeholder-gray-500 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400/30 outline-none transition resize-none"
                                  placeholder="<?= $lang === 'en' ? 'Any additional details or special requests...' : 'أي تفاصيل إضافية أو طلبات خاصة...' ?>"></textarea>
                    </div>

                    <!-- Submit -->
                    <button type="submit" <?= ($is_preview ?? false) ? 'disabled' : '' ?>
                            class="w-full bg-cyan-500 hover:bg-cyan-400 disabled:opacity-50 disabled:cursor-not-allowed transition rounded-2xl py-4 font-bold text-lg shadow-lg shadow-cyan-500/30 flex items-center justify-center gap-2">
                        <i class="fas fa-calendar-check"></i>
                        <?= $lang === 'en' ? 'Confirm Booking' : 'تأكيد الحجز' ?>
                    </button>

                    <!-- Quick WhatsApp -->
                    <?php if ($waNumber): ?>
                        <div class="text-center">
                            <span class="text-gray-500 text-sm">
                                <?= $lang === 'en' ? 'Or book quickly via' : 'أو احجز بسرعة عبر' ?>
                            </span>
                            <a href="<?= $waUrl ?>?text=<?= urlencode($lang === 'en' ? 'I would like to book a service.' : 'أرغب في حجز خدمة.') ?>" target="_blank"
                               class="inline-flex items-center gap-1.5 text-green-400 hover:text-green-300 font-semibold text-sm transition <?= $isRtl ? 'mr-1' : 'ml-1' ?>">
                                <i class="fab fa-whatsapp"></i>
                                WhatsApp
                            </a>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Right Column: Sidebar (2/5) -->
        <div class="lg:col-span-2 space-y-8">

            <!-- Quick Contact Info -->
            <div class="glass-strong rounded-[30px] p-8 fade-up" style="transition-delay:.1s">
                <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <i class="fas fa-phone-volume text-cyan-400"></i>
                    <?= $lang === 'en' ? 'Quick Contact' : 'تواصل سريع' ?>
                </h3>

                <div class="space-y-5">
                    <!-- Phone -->
                    <?php if (!empty($tenant->contact_phone)): ?>
                        <div class="flex items-center gap-4">
                            <div class="w-11 h-11 min-w-[44px] rounded-xl bg-cyan-500/15 flex items-center justify-center">
                                <i class="fas fa-phone text-cyan-400"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500"><?= $lang === 'en' ? 'Phone' : 'الهاتف' ?></p>
                                <a href="tel:<?= htmlspecialchars($tenant->contact_phone) ?>" class="text-gray-200 hover:text-cyan-400 transition font-semibold" dir="ltr">
                                    <?= htmlspecialchars($tenant->contact_phone) ?>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- WhatsApp -->
                    <?php if ($waNumber): ?>
                        <div class="flex items-center gap-4">
                            <div class="w-11 h-11 min-w-[44px] rounded-xl bg-green-500/15 flex items-center justify-center">
                                <i class="fab fa-whatsapp text-green-400"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">WhatsApp</p>
                                <a href="<?= $waUrl ?>" target="_blank"
                                   class="text-gray-200 hover:text-green-400 transition font-semibold" dir="ltr">
                                    <?= htmlspecialchars($tenant->contact_whatsapp ?? $tenant->contact_phone ?? '') ?>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Email -->
                    <?php if (!empty($tenant->contact_email)): ?>
                        <div class="flex items-center gap-4">
                            <div class="w-11 h-11 min-w-[44px] rounded-xl bg-blue-500/15 flex items-center justify-center">
                                <i class="fas fa-envelope text-blue-400"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500"><?= $lang === 'en' ? 'Email' : 'البريد' ?></p>
                                <a href="mailto:<?= htmlspecialchars($tenant->contact_email) ?>" class="text-gray-200 hover:text-cyan-400 transition font-semibold text-sm break-all" dir="ltr">
                                    <?= htmlspecialchars($tenant->contact_email) ?>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Working Hours -->
                    <?php if (!empty($tenant->working_hours)): ?>
                        <div class="flex items-start gap-4 pt-4 border-t border-white/10">
                            <div class="w-11 h-11 min-w-[44px] rounded-xl bg-amber-500/15 flex items-center justify-center">
                                <i class="fas fa-clock text-amber-400"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500"><?= $lang === 'en' ? 'Working Hours' : 'ساعات العمل' ?></p>
                                <p class="text-gray-200 text-sm whitespace-pre-line mt-1"><?= htmlspecialchars($tenant->working_hours) ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Quick WhatsApp CTA -->
                <?php if ($waNumber): ?>
                <a href="<?= $waUrl ?>?text=<?= urlencode($lang === 'en' ? 'I would like to book a service.' : 'أرغب في حجز خدمة.') ?>" target="_blank"
                   class="mt-6 w-full flex items-center justify-center gap-2 bg-[#25D366] hover:bg-[#20bd5a] transition rounded-2xl py-4 font-bold shadow-lg shadow-green-500/30 text-white">
                    <i class="fab fa-whatsapp text-xl"></i>
                    <?= $lang === 'en' ? 'Book via WhatsApp' : 'احجز عبر واتساب' ?>
                </a>
                <?php endif; ?>
            </div>

            <!-- Why Book With Us -->
            <div class="glass-strong rounded-[30px] p-8 fade-up" style="transition-delay:.2s">
                <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <i class="fas fa-star text-yellow-400"></i>
                    <?= $lang === 'en' ? 'Why Book With Us' : 'لماذا تحجز معنا' ?>
                </h3>
                <div class="space-y-4">
                    <?php foreach ($whyBook as $i => $item): ?>
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 min-w-[36px] rounded-lg bg-cyan-500/15 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="<?= htmlspecialchars($item->icon) ?> text-cyan-400 text-sm"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-sm text-gray-100"><?= htmlspecialchars($item->title) ?></p>
                                <p class="text-gray-400 text-xs mt-0.5"><?= htmlspecialchars($item->description) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Address Card -->
            <?php if (!empty($tenant->address)): ?>
            <div class="glass rounded-2xl p-6 fade-up" style="transition-delay:.3s">
                <div class="flex items-start gap-3">
                    <div class="w-11 h-11 min-w-[44px] rounded-xl bg-purple-500/15 flex items-center justify-center">
                        <i class="fas fa-location-dot text-purple-400"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-sm mb-1"><?= $lang === 'en' ? 'Our Location' : 'موقعنا' ?></p>
                        <p class="text-gray-400 text-sm"><?= htmlspecialchars($tenant->address) ?></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/_footer.php'; ?>
<?php require_once __DIR__ . '/_scripts.php'; ?>

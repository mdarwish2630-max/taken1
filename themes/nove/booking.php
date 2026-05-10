<?php require_once __DIR__ . '/_head.php'; require_once __DIR__ . '/_navbar.php'; ?>

<!-- ==================== HERO BANNER ==================== -->
<section class="relative bg-[#111] pt-32 pb-24 overflow-hidden">
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="absolute top-10 right-10 w-64 h-64 bg-[#ff7a00]/10 rounded-full blur-3xl"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-20 text-center fade-up">
        <div class="orange-bar mx-auto mb-6"></div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white mb-5 uppercase">احجز خدمتك</h1>
        <p class="text-white/70 text-lg max-w-2xl mx-auto">احجز خدمة التنظيف المناسبة لك في خطوات بسيطة وسهلة</p>

        <nav class="mt-8 flex items-center justify-center gap-2 text-sm text-white/50">
            <a href="<?php echo htmlspecialchars($siteBase); ?>" class="hover:text-[#ff7a00] transition-colors">الرئيسية</a>
            <i class="fas fa-chevron-left text-[10px]"></i>
            <span class="text-[#ff7a00] font-bold">حجز خدمة</span>
        </nav>
    </div>
</section>

<!-- ==================== BOOKING ==================== -->
<section class="bg-[#f4f4f4] py-24 px-6 lg:px-20">
    <div class="max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-3 gap-10">

            <!-- Booking Form -->
            <div class="lg:col-span-2 fade-up">
                <div class="bg-white p-8 lg:p-10 shadow-sm">
                    <div class="orange-bar mb-4"></div>
                    <h2 class="text-3xl font-black text-[#282828] mb-2 uppercase">نموذج الحجز</h2>
                    <p class="text-gray-400 text-sm mb-8">املأ البيانات التالية وسنتواصل معك لتأكيد الحجز</p>

                    <form action="<?php echo htmlspecialchars($siteBase); ?>/booking" method="POST" class="space-y-6">
                        <?php echo csrf_field() ?? ''; ?>

                        <!-- Service Selection -->
                        <div>
                            <label class="block text-[#282828] font-black text-sm mb-2">الخدمة المطلوبة <span class="text-red-400">*</span></label>
                            <select name="service_id" required
                                    class="w-full bg-[#f4f4f4] border-2 border-transparent px-5 py-4 text-[#282828] focus:border-[#ff7a00] focus:outline-none transition-colors font-bold appearance-none">
                                <option value="">اختر الخدمة</option>
                                <?php if (!empty($services)): ?>
                                    <?php foreach ($services as $svc): ?>
                                    <option value="<?php echo htmlspecialchars($svc->id); ?>"
                                            <?php echo (isset($_GET['service']) && $_GET['service'] == ($svc->slug ?? $svc->id)) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($svc->icon ?? ''); ?> <?php echo htmlspecialchars($svc->title); ?>
                                        <?php echo !empty($svc->price) ? ' - ' . htmlspecialchars($svc->price) : ''; ?>
                                    </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- Date & Time -->
                        <div class="grid sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[#282828] font-black text-sm mb-2">تاريخ الحجز <span class="text-red-400">*</span></label>
                                <input type="date" name="booking_date" required min="<?php echo date('Y-m-d'); ?>"
                                       class="w-full bg-[#f4f4f4] border-2 border-transparent px-5 py-4 text-[#282828] focus:border-[#ff7a00] focus:outline-none transition-colors font-bold">
                            </div>
                            <div>
                                <label class="block text-[#282828] font-black text-sm mb-2">وقت الحجز <span class="text-red-400">*</span></label>
                                <select name="booking_time" required
                                        class="w-full bg-[#f4f4f4] border-2 border-transparent px-5 py-4 text-[#282828] focus:border-[#ff7a00] focus:outline-none transition-colors font-bold appearance-none">
                                    <option value="">اختر الوقت</option>
                                    <?php foreach (['08:00 صباحاً','09:00 صباحاً','10:00 صباحاً','11:00 صباحاً','12:00 ظهراً','01:00 مساءً','02:00 مساءً','03:00 مساءً','04:00 مساءً','05:00 مساءً','06:00 مساءً','07:00 مساءً','08:00 مساءً'] as $slot): ?>
                                    <option value="<?php echo htmlspecialchars($slot); ?>"><?php echo htmlspecialchars($slot); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="w-full h-px bg-gray-100 my-2"></div>
                        <h3 class="text-[#282828] font-black text-lg mb-4">معلوماتك الشخصية</h3>

                        <div class="grid sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[#282828] font-black text-sm mb-2">الاسم الكامل <span class="text-red-400">*</span></label>
                                <input type="text" name="name" required placeholder="أدخل اسمك الكامل"
                                       class="w-full bg-[#f4f4f4] border-2 border-transparent px-5 py-4 text-[#282828] placeholder-gray-400 focus:border-[#ff7a00] focus:outline-none transition-colors font-bold">
                            </div>
                            <div>
                                <label class="block text-[#282828] font-black text-sm mb-2">رقم الجوال <span class="text-red-400">*</span></label>
                                <input type="tel" name="phone" required placeholder="+90 5XX XXX XXXX" dir="ltr"
                                       class="w-full bg-[#f4f4f4] border-2 border-transparent px-5 py-4 text-[#282828] placeholder-gray-400 focus:border-[#ff7a00] focus:outline-none transition-colors text-left font-bold">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[#282828] font-black text-sm mb-2">البريد الإلكتروني</label>
                            <input type="email" name="email" placeholder="example@email.com" dir="ltr"
                                   class="w-full bg-[#f4f4f4] border-2 border-transparent px-5 py-4 text-[#282828] placeholder-gray-400 focus:border-[#ff7a00] focus:outline-none transition-colors text-left font-bold">
                        </div>

                        <div>
                            <label class="block text-[#282828] font-black text-sm mb-2">ملاحظات إضافية</label>
                            <textarea name="notes" rows="4" placeholder="أضف أي تفاصيل أو متطلبات خاصة..."
                                      class="w-full bg-[#f4f4f4] border-2 border-transparent px-5 py-4 text-[#282828] placeholder-gray-400 focus:border-[#ff7a00] focus:outline-none transition-colors resize-none font-bold"></textarea>
                        </div>

                        <button type="submit"
                                class="bg-[#ff7a00] text-white font-black px-12 py-4 hover:bg-[#e56d00] transition-all duration-300 w-full sm:w-auto">
                            <i class="fas fa-check-circle ml-2"></i> تأكيد الحجز
                        </button>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6 fade-up">
                <!-- Benefits -->
                <div class="bg-white p-7 shadow-sm">
                    <h3 class="text-lg font-black text-[#282828] mb-5">لماذا تحجز معنا؟</h3>
                    <div class="space-y-4">
                        <?php foreach ([['fas fa-check','تأكيد فوري للحجز'],['fas fa-tags','أسعار شفافة بلا مفاجآت'],['fas fa-users','فريق عمل مدرب ومحترف'],['fas fa-leaf','مواد تنظيف آمنة ومعتمدة'],['fas fa-clock','التزام بالمواعيد المحددة'],['fas fa-redo','ضمان إعادة الخدمة مجاناً']] as $b): ?>
                        <div class="flex items-center gap-3">
                            <i class="<?php echo $b[0]; ?> text-[#ff7a00]"></i>
                            <span class="text-[#282828] text-sm font-bold"><?php echo $b[1]; ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Quick Contact -->
                <div class="bg-[#151515] p-7 text-white relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-[#ff7a00]/20 rounded-full blur-2xl"></div>
                    <div class="relative z-10">
                        <h3 class="text-lg font-black mb-5">تحتاج مساعدة؟</h3>
                        <p class="text-white/60 text-sm mb-6">تواصل معنا مباشرة وسنساعدك في اختيار الخدمة المناسبة</p>

                        <a href="tel:<?php echo htmlspecialchars($tenant->contact_phone ?? ''); ?>"
                           class="flex items-center gap-3 mb-4 bg-white/10 p-3 hover:bg-white/15 transition-colors">
                            <div class="w-10 h-10 bg-[#ff7a00] flex items-center justify-center shrink-0"><i class="fas fa-phone text-white"></i></div>
                            <div>
                                <p class="text-white/60 text-xs">اتصل بنا</p>
                                <p class="font-black text-sm" dir="ltr"><?php echo htmlspecialchars($tenant->contact_phone ?? '+90 555 000 000'); ?></p>
                            </div>
                        </a>

                        <a href="https://wa.me/<?php echo htmlspecialchars(preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '966000000000')); ?>?text=<?php echo urlencode('مرحباً، أرغب في حجز خدمة تنظيف'); ?>"
                           class="flex items-center gap-3 bg-green-500 p-3 hover:bg-green-600 transition-colors" target="_blank" rel="noopener">
                            <div class="w-10 h-10 bg-white/20 flex items-center justify-center shrink-0"><i class="fab fa-whatsapp text-white"></i></div>
                            <div>
                                <p class="text-white/80 text-xs">واتساب</p>
                                <p class="font-black text-sm">تواصل الآن</p>
                            </div>
                        </a>

                        <a href="mailto:<?php echo htmlspecialchars($tenant->contact_email ?? ''); ?>"
                           class="flex items-center gap-3 bg-white/10 p-3 hover:bg-white/15 transition-colors mt-4">
                            <div class="w-10 h-10 bg-[#ff7a00] flex items-center justify-center shrink-0"><i class="fas fa-envelope text-white"></i></div>
                            <div>
                                <p class="text-white/60 text-xs">البريد الإلكتروني</p>
                                <p class="font-black text-sm"><?php echo htmlspecialchars($tenant->contact_email ?? 'info@nove-clean.com'); ?></p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Working Hours -->
                <div class="bg-white p-7 shadow-sm">
                    <h3 class="text-lg font-black text-[#282828] mb-5">ساعات العمل</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 text-sm">السبت - الخميس</span>
                            <span class="text-[#ff7a00] font-black text-sm">8:00 ص - 10:00 م</span>
                        </div>
                        <div class="w-full h-px bg-gray-100"></div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 text-sm">الجمعة</span>
                            <span class="text-[#ff7a00] font-black text-sm">2:00 م - 10:00 م</span>
                        </div>
                        <div class="w-full h-px bg-gray-100"></div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 text-sm">خدمة الطوارئ</span>
                            <span class="text-[#282828] font-black text-sm">24/7</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== WHATSAPP FLOATING ==================== -->
<a href="https://wa.me/<?php echo htmlspecialchars(preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '966000000000')); ?>?text=<?php echo urlencode('مرحباً، أرغب في الاستفسار عن حجز خدمة تنظيف'); ?>"
   target="_blank" rel="noopener"
   class="fixed bottom-6 left-6 z-50 w-16 h-16 bg-green-500 hover:bg-green-600 flex items-center justify-center shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-110 group"
   aria-label="تواصل عبر واتساب">
    <i class="fab fa-whatsapp text-white text-3xl"></i>
    <span class="absolute -top-12 left-1/2 -translate-x-1/2 bg-[#151515] text-white text-xs font-bold px-4 py-2 whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">تواصل عبر واتساب</span>
</a>

<?php require_once __DIR__ . '/_footer.php'; require_once __DIR__ . '/_scripts.php'; ?>

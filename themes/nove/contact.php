<?php require_once __DIR__ . '/_head.php'; require_once __DIR__ . '/_navbar.php'; ?>

<!-- ==================== HERO BANNER ==================== -->
<section class="relative bg-[#111] pt-32 pb-24 overflow-hidden">
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="absolute top-10 left-10 w-48 h-48 bg-[#ff7a00]/10 rounded-full blur-3xl"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-20 text-center fade-up">
        <div class="orange-bar mx-auto mb-6"></div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white mb-5 uppercase">تواصل معنا</h1>
        <p class="text-white/70 text-lg max-w-2xl mx-auto">نسعد بتواصلك معنا. اترك لنا رسالتك وسنرد عليك في أقرب وقت</p>

        <!-- Breadcrumb -->
        <nav class="mt-8 flex items-center justify-center gap-2 text-sm text-white/50">
            <a href="<?php echo htmlspecialchars($siteBase); ?>" class="hover:text-[#ff7a00] transition-colors">الرئيسية</a>
            <i class="fas fa-chevron-left text-[10px]"></i>
            <span class="text-[#ff7a00] font-bold">تواصل معنا</span>
        </nav>
    </div>
</section>

<!-- ==================== CONTACT FORM + INFO ==================== -->
<section class="bg-[#f4f4f4] py-24 px-6 lg:px-20">
    <div class="max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-5 gap-10">
            <!-- Contact Form -->
            <div class="lg:col-span-3 fade-up">
                <div class="bg-white p-8 lg:p-10 shadow-sm">
                    <div class="orange-bar mb-4"></div>
                    <h2 class="text-3xl font-black text-[#282828] mb-2 uppercase">أرسل لنا رسالة</h2>
                    <p class="text-gray-400 text-sm mb-8">املأ النموذج التالي وسنتواصل معك قريباً</p>

                    <form action="<?php echo htmlspecialchars($siteBase); ?>/contact" method="POST" class="space-y-6">
                        <?php echo csrf_field() ?? ''; ?>

                        <div class="grid sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[#282828] font-black text-sm mb-2">الاسم الكامل <span class="text-red-400">*</span></label>
                                <input type="text" name="name" required placeholder="أدخل اسمك الكامل"
                                       class="w-full bg-[#f4f4f4] border-2 border-transparent px-5 py-4 text-[#282828] placeholder-gray-400 focus:border-[#ff7a00] focus:outline-none transition-colors font-bold">
                            </div>
                            <div>
                                <label class="block text-[#282828] font-black text-sm mb-2">البريد الإلكتروني <span class="text-red-400">*</span></label>
                                <input type="email" name="email" required placeholder="example@email.com" dir="ltr"
                                       class="w-full bg-[#f4f4f4] border-2 border-transparent px-5 py-4 text-[#282828] placeholder-gray-400 focus:border-[#ff7a00] focus:outline-none transition-colors text-left font-bold">
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[#282828] font-black text-sm mb-2">رقم الجوال <span class="text-red-400">*</span></label>
                                <input type="tel" name="phone" required placeholder="+90 5XX XXX XXXX" dir="ltr"
                                       class="w-full bg-[#f4f4f4] border-2 border-transparent px-5 py-4 text-[#282828] placeholder-gray-400 focus:border-[#ff7a00] focus:outline-none transition-colors text-left font-bold">
                            </div>
                            <div>
                                <label class="block text-[#282828] font-black text-sm mb-2">الموضوع</label>
                                <select name="subject"
                                        class="w-full bg-[#f4f4f4] border-2 border-transparent px-5 py-4 text-[#282828] focus:border-[#ff7a00] focus:outline-none transition-colors font-bold appearance-none">
                                    <option value="">اختر الموضوع</option>
                                    <option value="inquiry">استفسار عام</option>
                                    <option value="booking">حجز خدمة</option>
                                    <option value="complaint">شكوى</option>
                                    <option value="partnership">شراكة</option>
                                    <option value="other">أخرى</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[#282828] font-black text-sm mb-2">الرسالة <span class="text-red-400">*</span></label>
                            <textarea name="message" rows="5" required placeholder="اكتب رسالتك هنا..."
                                      class="w-full bg-[#f4f4f4] border-2 border-transparent px-5 py-4 text-[#282828] placeholder-gray-400 focus:border-[#ff7a00] focus:outline-none transition-colors resize-none font-bold"></textarea>
                        </div>

                        <button type="submit"
                                class="bg-[#ff7a00] text-white font-black px-12 py-4 hover:bg-[#e56d00] transition-all duration-300 w-full sm:w-auto">
                            إرسال الرسالة <i class="fas fa-paper-plane mr-2"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Contact Info Cards -->
            <div class="lg:col-span-2 space-y-6 fade-up">
                <?php if (!empty($tenant->contact_phone)): ?>
                <div class="bg-white p-6 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-[#ff7a00] text-white flex items-center justify-center text-2xl shrink-0">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm mb-1">اتصل بنا</p>
                            <a href="tel:<?php echo htmlspecialchars($tenant->contact_phone); ?>" class="text-[#282828] font-black hover:text-[#ff7a00] transition-colors" dir="ltr">
                                <?php echo htmlspecialchars($tenant->contact_phone); ?>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($tenant->contact_whatsapp)): ?>
                <div class="bg-white p-6 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-green-500 text-white flex items-center justify-center text-2xl shrink-0">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm mb-1">واتساب</p>
                            <a href="https://wa.me/<?php echo htmlspecialchars(preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp)); ?>"
                               class="text-[#282828] font-black hover:text-green-500 transition-colors" target="_blank" rel="noopener">
                                تواصل عبر واتساب
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($tenant->contact_email)): ?>
                <div class="bg-white p-6 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-[#f4f4f4] text-[#ff7a00] flex items-center justify-center text-2xl shrink-0">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm mb-1">البريد الإلكتروني</p>
                            <a href="mailto:<?php echo htmlspecialchars($tenant->contact_email); ?>" class="text-[#282828] font-black hover:text-[#ff7a00] transition-colors">
                                <?php echo htmlspecialchars($tenant->contact_email); ?>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="bg-white p-6 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-[#f4f4f4] text-[#ff7a00] flex items-center justify-center text-2xl shrink-0">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm mb-1">ساعات العمل</p>
                            <p class="text-[#282828] font-black">24 ساعة / 7 أيام</p>
                        </div>
                    </div>
                </div>

                <?php if (!empty($tenant->address)): ?>
                <div class="bg-white p-6 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-[#f4f4f4] text-[#ff7a00] flex items-center justify-center text-2xl shrink-0">
                            <i class="fas fa-location-dot"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm mb-1">العنوان</p>
                            <p class="text-[#282828] font-black"><?php echo htmlspecialchars($tenant->address); ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- ==================== WHATSAPP FLOATING BUTTON ==================== -->
<a href="https://wa.me/<?php echo htmlspecialchars(preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp ?? $tenant->contact_phone ?? '966000000000')); ?>?text=<?php echo urlencode('مرحباً، أرغب في الاستفسار عن خدماتكم'); ?>"
   target="_blank" rel="noopener"
   class="fixed bottom-6 left-6 z-50 w-16 h-16 bg-green-500 hover:bg-green-600 flex items-center justify-center shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-110 group"
   aria-label="تواصل عبر واتساب">
    <i class="fab fa-whatsapp text-white text-3xl"></i>
    <span class="absolute -top-12 left-1/2 -translate-x-1/2 bg-[#151515] text-white text-xs font-bold px-4 py-2 whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
        تواصل عبر واتساب
    </span>
</a>

<?php require_once __DIR__ . '/_footer.php'; require_once __DIR__ . '/_scripts.php'; ?>

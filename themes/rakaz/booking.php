<?php include __DIR__ . '/partials/_head.php'; ?>
<?php include __DIR__ . '/partials/_navbar.php'; ?>

<!-- Page Header -->
<section class="hero-gradient relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 right-20 w-60 h-60 bg-primary rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 relative z-10 text-center">
        <span class="inline-block bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full text-sm text-accent mb-6">
            <i class="fas fa-calendar-check ml-2"></i> حجز موعد
        </span>
        <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-4">
            <?php echo htmlspecialchars($page['heading'] ?? 'احجز موعدك الآن'); ?>
        </h1>
        <p class="text-lg text-white/70 max-w-2xl mx-auto">
            <?php echo htmlspecialchars($page['subheading'] ?? 'احجز موعد لخدمة الصيانة بسهولة وسرعة'); ?>
        </p>
    </div>
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 60" fill="none"><path d="M0 30L60 25C120 20 240 10 360 8.3C480 6.7 600 13.3 720 18.3C840 23.3 960 26.7 1080 25C1200 23.3 1320 16.7 1380 13.3L1440 10V60H1380C1320 60 1200 60 1080 60C960 60 840 60 720 60C600 60 480 60 360 60C240 60 120 60 60 60H0V30Z" fill="#f8f5f1"/></svg>
    </div>
</section>

<!-- Booking Section -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-10">
            <!-- Booking Form -->
            <div class="lg:col-span-2" data-aos="fade-up">
                <div class="bg-white rounded-card p-8 lg:p-10">
                    <h2 class="text-2xl font-bold text-secondary mb-2">نموذج الحجز</h2>
                    <p class="text-gray-500 text-sm mb-8">املأ البيانات التالية لحجز موعد خدمة الصيانة</p>
                    
                    <!-- Steps -->
                    <div class="flex items-center gap-4 mb-10">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white text-sm font-bold">1</div>
                            <span class="text-sm font-semibold text-secondary">البيانات الشخصية</span>
                        </div>
                        <div class="flex-1 h-px bg-warm-200"></div>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white text-sm font-bold">2</div>
                            <span class="text-sm font-semibold text-secondary">تفاصيل الخدمة</span>
                        </div>
                        <div class="flex-1 h-px bg-warm-200"></div>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white text-sm font-bold">3</div>
                            <span class="text-sm font-semibold text-secondary">تأكيد</span>
                        </div>
                    </div>
                    
                    <form action="<?php echo $siteBase ?? '/'; ?>/booking" method="POST" data-ajax class="space-y-6">
                        <!-- Personal Info -->
                        <div class="bg-warm-50 rounded-2xl p-6">
                            <h3 class="text-lg font-bold text-secondary mb-4 flex items-center gap-2">
                                <i class="fas fa-user text-primary"></i> البيانات الشخصية
                            </h3>
                            <div class="grid md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-secondary mb-2">الاسم الكامل *</label>
                                    <input type="text" name="name" required placeholder="أدخل اسمك الكامل"
                                           class="w-full px-5 py-3.5 bg-white border border-warm-200 rounded-2xl text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-secondary mb-2">رقم الجوال *</label>
                                    <input type="tel" name="phone" required placeholder="05XXXXXXXX" dir="ltr"
                                           class="w-full px-5 py-3.5 bg-white border border-warm-200 rounded-2xl text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-secondary mb-2">البريد الإلكتروني</label>
                                    <input type="email" name="email" placeholder="example@email.com" dir="ltr"
                                           class="w-full px-5 py-3.5 bg-white border border-warm-200 rounded-2xl text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-secondary mb-2">المدينة *</label>
                                    <select name="city" required
                                            class="w-full px-5 py-3.5 bg-white border border-warm-200 rounded-2xl text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-gray-600">
                                        <option value="">اختر المدينة</option>
                                        <option value="riyadh">الرياض</option>
                                        <option value="jeddah">جدة</option>
                                        <option value="dammam">الدمام</option>
                                        <option value="makkah">مكة المكرمة</option>
                                        <option value="madinah">المدينة المنورة</option>
                                        <option value="other">أخرى</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Service Details -->
                        <div class="bg-warm-50 rounded-2xl p-6">
                            <h3 class="text-lg font-bold text-secondary mb-4 flex items-center gap-2">
                                <i class="fas fa-tools text-primary"></i> تفاصيل الخدمة
                            </h3>
                            <div class="grid md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-secondary mb-2">الخدمة المطلوبة *</label>
                                    <select name="service" required
                                            class="w-full px-5 py-3.5 bg-white border border-warm-200 rounded-2xl text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-gray-600">
                                        <option value="">اختر الخدمة</option>
                                        <?php if (!empty($services)): ?>
                                            <?php foreach ($services as $svc): ?>
                                                <option value="<?php echo htmlspecialchars($svc['title'] ?? ''); ?>">
                                                    <?php echo htmlspecialchars($svc['title'] ?? ''); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-secondary mb-2">التاريخ المفضل *</label>
                                    <input type="date" name="date" required
                                           class="w-full px-5 py-3.5 bg-white border border-warm-200 rounded-2xl text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-secondary mb-2">الوقت المفضل *</label>
                                    <select name="time" required
                                            class="w-full px-5 py-3.5 bg-white border border-warm-200 rounded-2xl text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-gray-600">
                                        <option value="">اختر الوقت</option>
                                        <option value="morning">صباحاً (8:00 - 12:00)</option>
                                        <option value="noon">ظهراً (12:00 - 4:00)</option>
                                        <option value="afternoon">عصراً (4:00 - 8:00)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-secondary mb-2">نوع العقار</label>
                                    <select name="property_type"
                                            class="w-full px-5 py-3.5 bg-white border border-warm-200 rounded-2xl text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-gray-600">
                                        <option value="">اختر النوع</option>
                                        <option value="apartment">شقة</option>
                                        <option value="villa">فيلا</option>
                                        <option value="office">مكتب</option>
                                        <option value="commercial">محل تجاري</option>
                                        <option value="building">مبنى</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-5">
                                <label class="block text-sm font-semibold text-secondary mb-2">وصف المشكلة / ملاحظات</label>
                                <textarea name="notes" rows="4" placeholder="اكتب وصفاً للمشكلة أو أي ملاحظات إضافية..."
                                          class="w-full px-5 py-3.5 bg-white border border-warm-200 rounded-2xl text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all resize-none"></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn-primary text-white px-10 py-4 rounded-full font-bold text-base w-full md:w-auto inline-flex items-center justify-center gap-2">
                            <i class="fas fa-calendar-check"></i>
                            <span>تأكيد الحجز</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Contact -->
                <div class="bg-secondary rounded-card p-7 text-white" data-aos="fade-up">
                    <h3 class="text-lg font-bold mb-5 flex items-center gap-2">
                        <i class="fas fa-headset text-accent"></i>
                        تحتاج مساعدة؟
                    </h3>
                    <p class="text-white/70 text-sm mb-5">تواصل معنا مباشرة وسنساعدك في حجز موعدك</p>
                    <?php if (!empty($contact_phone)): ?>
                        <a href="tel:<?php echo htmlspecialchars($contact_phone); ?>" class="block bg-primary text-white text-center px-6 py-3 rounded-full font-bold hover:bg-accent transition-all duration-300 mb-3">
                            <i class="fas fa-phone-alt ml-2"></i> اتصل الآن
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($social_whatsapp)): ?>
                        <a href="<?php echo htmlspecialchars($social_whatsapp); ?>" target="_blank" class="block bg-green-500 text-white text-center px-6 py-3 rounded-full font-bold hover:bg-green-600 transition-all duration-300">
                            <i class="fab fa-whatsapp ml-2"></i> واتساب
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Service Guarantee -->
                <div class="bg-white rounded-card p-7" data-aos="fade-up">
                    <h3 class="text-lg font-bold text-secondary mb-5 flex items-center gap-2">
                        <i class="fas fa-shield-alt text-primary"></i>
                        ضمان الخدمة
                    </h3>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-primary text-xs"></i>
                            </div>
                            <span class="text-gray-600 text-sm">ضمان 3 أشهر على جميع الأعمال</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-primary text-xs"></i>
                            </div>
                            <span class="text-gray-600 text-sm">فنيون معتمدون وذوو خبرة</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-primary text-xs"></i>
                            </div>
                            <span class="text-gray-600 text-sm">أسعار شفافة بدون مفاجآت</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-primary text-xs"></i>
                            </div>
                            <span class="text-gray-600 text-sm">مواد وقطع غيار أصلية</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-check text-primary text-xs"></i>
                            </div>
                            <span class="text-gray-600 text-sm">خدمة متابعة بعد الإنجاز</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/partials/_footer.php'; ?>
<?php include __DIR__ . '/partials/_scripts.php'; ?>

<?php include __DIR__ . '/partials/_head.php'; ?>
<?php include __DIR__ . '/partials/_navbar.php'; ?>

<!-- Page Header -->
<section class="hero-gradient relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 left-20 w-60 h-60 bg-primary rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 relative z-10 text-center">
        <span class="inline-block bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full text-sm text-accent mb-6">
            <i class="fas fa-envelope ml-2"></i> اتصل بنا
        </span>
        <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-4">
            <?php echo htmlspecialchars($page->heading ?? 'تواصل معنا'); ?>
        </h1>
        <p class="text-lg text-white/70 max-w-2xl mx-auto">
            <?php echo htmlspecialchars($page->subheading ?? 'نحن هنا لمساعدتك. تواصل معنا في أي وقت'); ?>
        </p>
    </div>
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 60" fill="none"><path d="M0 30L60 25C120 20 240 10 360 8.3C480 6.7 600 13.3 720 18.3C840 23.3 960 26.7 1080 25C1200 23.3 1320 16.7 1380 13.3L1440 10V60H1380C1320 60 1200 60 1080 60C960 60 840 60 720 60C600 60 480 60 360 60C240 60 120 60 60 60H0V30Z" fill="#f8f5f1"/></svg>
    </div>
</section>

<!-- Contact Section -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-10">
            <!-- Contact Info Cards -->
            <div class="space-y-6">
                <?php if (!empty($contact_phone)): ?>
                <div class="bg-white rounded-card p-7 flex items-start gap-5" data-aos="fade-up">
                    <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-phone-alt text-2xl text-primary"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-secondary mb-1">الهاتف</h3>
                        <p class="text-gray-500 text-sm mb-2">اتصل بنا مباشرة</p>
                        <a href="tel:<?php echo htmlspecialchars($contact_phone); ?>" class="text-primary font-semibold text-sm hover:text-accent transition-colors" dir="ltr">
                            <?php echo htmlspecialchars($contact_phone); ?>
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($contact_email)): ?>
                <div class="bg-white rounded-card p-7 flex items-start gap-5" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-envelope text-2xl text-primary"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-secondary mb-1">البريد الإلكتروني</h3>
                        <p class="text-gray-500 text-sm mb-2">راسلنا عبر البريد</p>
                        <a href="mailto:<?php echo htmlspecialchars($contact_email); ?>" class="text-primary font-semibold text-sm hover:text-accent transition-colors">
                            <?php echo htmlspecialchars($contact_email); ?>
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($contact_address)): ?>
                <div class="bg-white rounded-card p-7 flex items-start gap-5" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-map-marker-alt text-2xl text-primary"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-secondary mb-1">العنوان</h3>
                        <p class="text-gray-500 text-sm mb-2">زورونا في مقرنا</p>
                        <p class="text-primary font-semibold text-sm"><?php echo htmlspecialchars($contact_address); ?></p>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Social Links -->
                <div class="bg-white rounded-card p-7" data-aos="fade-up">
                    <h3 class="text-lg font-bold text-secondary mb-4">تابعنا</h3>
                    <div class="flex gap-3">
                        <?php if (!empty($social_facebook)): ?>
                            <a href="<?php echo htmlspecialchars($social_facebook); ?>" target="_blank" class="w-11 h-11 rounded-2xl bg-primary/10 hover:bg-primary text-primary hover:text-white flex items-center justify-center transition-all duration-300">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($social_twitter)): ?>
                            <a href="<?php echo htmlspecialchars($social_twitter); ?>" target="_blank" class="w-11 h-11 rounded-2xl bg-primary/10 hover:bg-primary text-primary hover:text-white flex items-center justify-center transition-all duration-300">
                                <i class="fab fa-twitter"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($social_instagram)): ?>
                            <a href="<?php echo htmlspecialchars($social_instagram); ?>" target="_blank" class="w-11 h-11 rounded-2xl bg-primary/10 hover:bg-primary text-primary hover:text-white flex items-center justify-center transition-all duration-300">
                                <i class="fab fa-instagram"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($social_whatsapp)): ?>
                            <a href="<?php echo htmlspecialchars($social_whatsapp); ?>" target="_blank" class="w-11 h-11 rounded-2xl bg-green-500/10 hover:bg-green-500 text-green-600 hover:text-white flex items-center justify-center transition-all duration-300">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:col-span-2" data-aos="fade-up">
                <div class="bg-white rounded-card p-8 lg:p-10">
                    <h2 class="text-2xl font-bold text-secondary mb-2">أرسل لنا رسالة</h2>
                    <p class="text-gray-500 text-sm mb-8">املأ النموذج التالي وسنتواصل معك في أقرب وقت ممكن</p>
                    
                    <form action="<?php echo $siteBase ?? '/'; ?>/contact" method="POST" data-ajax class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-secondary mb-2">الاسم الكامل</label>
                                <input type="text" name="name" required placeholder="أدخل اسمك الكامل"
                                       class="w-full px-5 py-3.5 bg-warm-100 border border-warm-200 rounded-2xl text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-secondary mb-2">رقم الجوال</label>
                                <input type="tel" name="phone" required placeholder="05XXXXXXXX" dir="ltr"
                                       class="w-full px-5 py-3.5 bg-warm-100 border border-warm-200 rounded-2xl text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-secondary mb-2">البريد الإلكتروني</label>
                            <input type="email" name="email" placeholder="example@email.com" dir="ltr"
                                   class="w-full px-5 py-3.5 bg-warm-100 border border-warm-200 rounded-2xl text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-secondary mb-2">الخدمة المطلوبة</label>
                            <select name="service"
                                    class="w-full px-5 py-3.5 bg-warm-100 border border-warm-200 rounded-2xl text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-gray-600">
                                <option value="">اختر الخدمة</option>
                                <?php if (!empty($services)): ?>
                                    <?php foreach ($services as $svc): ?>
                                        <option value="<?php echo htmlspecialchars($svc->title ?? ''); ?>">
                                            <?php echo htmlspecialchars($svc->title ?? ''); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-secondary mb-2">الرسالة</label>
                            <textarea name="message" rows="5" required placeholder="اكتب رسالتك هنا..."
                                      class="w-full px-5 py-3.5 bg-warm-100 border border-warm-200 rounded-2xl text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all resize-none"></textarea>
                        </div>
                        <button type="submit" class="btn-primary text-white px-10 py-4 rounded-full font-bold text-base w-full md:w-auto inline-flex items-center justify-center gap-2">
                            <span>إرسال الرسالة</span>
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/partials/_footer.php'; ?>
<?php include __DIR__ . '/partials/_scripts.php'; ?>

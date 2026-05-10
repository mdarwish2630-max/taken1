<!-- Rakaz Theme - Footer -->
<footer class="bg-secondary text-white">
    <!-- Main Footer -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
            <!-- Company Info -->
            <div class="lg:col-span-1">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary to-accent flex items-center justify-center">
                        <i class="fas fa-tools text-white text-xl"></i>
                    </div>
                    <span class="text-2xl font-bold"><?php echo htmlspecialchars($site_name ?? 'ركاز'); ?></span>
                </div>
                <p class="text-white/70 leading-relaxed text-sm mb-6">
                    <?php echo htmlspecialchars($site_description ?? 'شركة ركاز المتخصصة في خدمات الصيانة المنزلية والتجارية. نقدم خدمات موثوقة بأعلى جودة.'); ?>
                </p>
                <!-- Social Media -->
                <div class="flex gap-3">
                    <?php if (!empty($social_facebook)): ?>
                        <a href="<?php echo htmlspecialchars($social_facebook); ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 hover:bg-primary flex items-center justify-center transition-all duration-300">
                            <i class="fab fa-facebook-f text-sm"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($social_twitter)): ?>
                        <a href="<?php echo htmlspecialchars($social_twitter); ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 hover:bg-primary flex items-center justify-center transition-all duration-300">
                            <i class="fab fa-twitter text-sm"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($social_instagram)): ?>
                        <a href="<?php echo htmlspecialchars($social_instagram); ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 hover:bg-primary flex items-center justify-center transition-all duration-300">
                            <i class="fab fa-instagram text-sm"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($social_whatsapp)): ?>
                        <a href="<?php echo htmlspecialchars($social_whatsapp); ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 hover:bg-primary flex items-center justify-center transition-all duration-300">
                            <i class="fab fa-whatsapp text-sm"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-bold mb-6 text-primary">روابط سريعة</h4>
                <ul class="space-y-3">
                    <li><a href="<?php echo url($siteBase ?? '/'); ?>" class="text-white/70 hover:text-primary transition-colors text-sm flex items-center gap-2"><i class="fas fa-chevron-left text-xs text-primary/50"></i> الرئيسية</a></li>
                    <li><a href="<?php echo url(($siteBase ?? '/') . '/services'); ?>" class="text-white/70 hover:text-primary transition-colors text-sm flex items-center gap-2"><i class="fas fa-chevron-left text-xs text-primary/50"></i> خدماتنا</a></li>
                    <li><a href="<?php echo url(($siteBase ?? '/') . '/about'); ?>" class="text-white/70 hover:text-primary transition-colors text-sm flex items-center gap-2"><i class="fas fa-chevron-left text-xs text-primary/50"></i> من نحن</a></li>
                    <li><a href="<?php echo url(($siteBase ?? '/') . '/gallery'); ?>" class="text-white/70 hover:text-primary transition-colors text-sm flex items-center gap-2"><i class="fas fa-chevron-left text-xs text-primary/50"></i> أعمالنا</a></li>
                    <li><a href="<?php echo url(($siteBase ?? '/') . '/contact'); ?>" class="text-white/70 hover:text-primary transition-colors text-sm flex items-center gap-2"><i class="fas fa-chevron-left text-xs text-primary/50"></i> اتصل بنا</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div>
                <h4 class="text-lg font-bold mb-6 text-primary">خدماتنا</h4>
                <ul class="space-y-3">
                    <?php if (!empty($services)): ?>
                        <?php foreach (array_slice($services, 0, 5) as $svc): ?>
                            <li>
                                <a href="<?php echo url(($siteBase ?? '/') . '/service/' . ($svc->slug ?? '')); ?>" class="text-white/70 hover:text-primary transition-colors text-sm flex items-center gap-2">
                                    <i class="fas fa-chevron-left text-xs text-primary/50"></i>
                                    <?php echo htmlspecialchars($svc->title ?? ''); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-lg font-bold mb-6 text-primary">تواصل معنا</h4>
                <ul class="space-y-4">
                    <?php if (!empty($contact_phone)): ?>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-phone-alt text-primary mt-1"></i>
                            <div>
                                <p class="text-white/50 text-xs mb-1">الهاتف</p>
                                <p class="text-white/90 text-sm" dir="ltr"><?php echo htmlspecialchars($contact_phone); ?></p>
                            </div>
                        </li>
                    <?php endif; ?>
                    <?php if (!empty($contact_email)): ?>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-envelope text-primary mt-1"></i>
                            <div>
                                <p class="text-white/50 text-xs mb-1">البريد الإلكتروني</p>
                                <p class="text-white/90 text-sm"><?php echo htmlspecialchars($contact_email); ?></p>
                            </div>
                        </li>
                    <?php endif; ?>
                    <?php if (!empty($contact_address)): ?>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-primary mt-1"></i>
                            <div>
                                <p class="text-white/50 text-xs mb-1">العنوان</p>
                                <p class="text-white/90 text-sm"><?php echo htmlspecialchars($contact_address); ?></p>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-3">
                <p class="text-white/50 text-sm"><?php echo htmlspecialchars($footer_text ?? '&copy; ' . date('Y') . ' شركة ركاز للصيانة. جميع الحقوق محفوظة.'); ?></p>
                <a href="<?php echo url($siteBase ?? '/'); ?>" class="text-primary text-sm hover:text-accent transition-colors">ركاز للصيانة</a>
            </div>
        </div>
    </div>
</footer>

<!-- WhatsApp Float Button -->
<?php if (!empty($social_whatsapp)): ?>
    <a href="<?php echo htmlspecialchars($social_whatsapp); ?>" target="_blank"
       class="fixed bottom-6 left-6 z-50 w-14 h-14 bg-green-500 hover:bg-green-600 text-white rounded-full shadow-lg hover:shadow-xl flex items-center justify-center transition-all duration-300 hover:scale-110">
        <i class="fab fa-whatsapp text-2xl"></i>
    </a>
<?php endif; ?>

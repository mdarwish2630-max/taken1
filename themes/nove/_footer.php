<!-- Footer -->
<footer class="bg-[#151515] text-white px-6 lg:px-20 pt-20">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 pb-16">

        <!-- Column 1: Brand Info -->
        <div class="fade-up">
            <h3 class="text-4xl font-black mb-2" style="font-family: 'Tajawal', sans-serif;">Lumaa Clean</h3>
            <p class="text-[#ff7a00] font-black mb-4 text-lg">لمعة كلين</p>
            <p class="text-gray-400 leading-loose text-sm">
                شركة متخصصة في تقديم خدمات التنظيف الاحترافية للمنازل والشركات. نقدم أعلى معايير الجودة مع فريق مدرب ومعدات حديثة ونتائج مضمونة.
            </p>
            <div class="flex gap-3 mt-6">
                <?php if (!empty($tenant->contact_whatsapp)): ?>
                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp ?? '') ?>"
                   target="_blank"
                   class="w-10 h-10 bg-white/10 text-white flex items-center justify-center hover:bg-[#ff7a00] transition-all duration-300 rounded-sm">
                    <i class="fab fa-whatsapp text-lg"></i>
                </a>
                <?php endif; ?>
                <a href="#" class="w-10 h-10 bg-white/10 text-white flex items-center justify-center hover:bg-[#ff7a00] transition-all duration-300 rounded-sm">
                    <i class="fab fa-instagram text-lg"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-white/10 text-white flex items-center justify-center hover:bg-[#ff7a00] transition-all duration-300 rounded-sm">
                    <i class="fab fa-twitter text-lg"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-white/10 text-white flex items-center justify-center hover:bg-[#ff7a00] transition-all duration-300 rounded-sm">
                    <i class="fab fa-linkedin text-lg"></i>
                </a>
            </div>
        </div>

        <!-- Column 2: Services -->
        <div class="fade-up">
            <h4 class="text-2xl font-black mb-6 relative inline-block">
                الخدمات
                <span class="absolute -bottom-2 right-0 w-10 h-1 bg-[#ff7a00] rounded-sm"></span>
            </h4>
            <ul class="space-y-4 text-gray-400">
                <li><a href="#" class="hover:text-[#ff7a00] transition-colors text-sm">تنظيف المنازل</a></li>
                <li><a href="#" class="hover:text-[#ff7a00] transition-colors text-sm">تنظيف المكاتب</a></li>
                <li><a href="#" class="hover:text-[#ff7a00] transition-colors text-sm">تنظيف السجاد</a></li>
                <li><a href="#" class="hover:text-[#ff7a00] transition-colors text-sm">التعقيم الشامل</a></li>
                <li><a href="#" class="hover:text-[#ff7a00] transition-colors text-sm">تنظيف بعد البناء</a></li>
            </ul>
        </div>

        <!-- Column 3: Quick Links -->
        <div class="fade-up">
            <h4 class="text-2xl font-black mb-6 relative inline-block">
                روابط
                <span class="absolute -bottom-2 right-0 w-10 h-1 bg-[#ff7a00] rounded-sm"></span>
            </h4>
            <ul class="space-y-4 text-gray-400">
                <?php foreach ($menu ?? [] as $item): ?>
                <li>
                    <a href="<?= url($item->is_home ? '/' : $item->slug) ?>"
                       class="hover:text-[#ff7a00] transition-colors text-sm">
                        <?= $item->title ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Column 4: Contact Info -->
        <div class="fade-up">
            <h4 class="text-2xl font-black mb-6 relative inline-block">
                التواصل
                <span class="absolute -bottom-2 right-0 w-10 h-1 bg-[#ff7a00] rounded-sm"></span>
            </h4>
            <ul class="space-y-4 text-gray-400">
                <?php if (!empty($tenant->contact_phone)): ?>
                <li class="flex items-center gap-3 text-sm">
                    <i class="fas fa-phone text-[#ff7a00]"></i>
                    <a href="tel:<?= preg_replace('/[^0-9+]/', '', $tenant->contact_phone) ?>" class="hover:text-white transition-colors" dir="ltr">
                        <?= $tenant->contact_phone ?>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (!empty($tenant->contact_whatsapp)): ?>
                <li class="flex items-center gap-3 text-sm">
                    <i class="fab fa-whatsapp text-[#ff7a00]"></i>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp) ?>" target="_blank" class="hover:text-white transition-colors" dir="ltr">
                        <?= $tenant->contact_whatsapp ?>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (!empty($tenant->contact_email)): ?>
                <li class="flex items-center gap-3 text-sm">
                    <i class="fas fa-envelope text-[#ff7a00]"></i>
                    <a href="mailto:<?= htmlspecialchars($tenant->contact_email) ?>" class="hover:text-white transition-colors">
                        <?= $tenant->contact_email ?>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (!empty($tenant->address)): ?>
                <li class="flex items-center gap-3 text-sm">
                    <i class="fas fa-location-dot text-[#ff7a00]"></i>
                    <span><?= $tenant->address ?></span>
                </li>
                <?php endif; ?>
                <?php if (!empty($tenant->working_hours)): ?>
                <li class="flex items-center gap-3 text-sm">
                    <i class="fas fa-clock text-[#ff7a00]"></i>
                    <span><?= $tenant->working_hours ?></span>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <!-- Copyright -->
    <div class="bg-[#ff7a00] text-[#1f2a3b] text-center py-5 font-black text-sm">
        &copy; <?= date('Y') ?> <?= $tenant->site_name ?? 'لمعة كلين' ?> — جميع الحقوق محفوظة
    </div>
</footer>

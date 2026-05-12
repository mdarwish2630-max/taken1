<!-- Footer -->
<footer class="bg-[#151515] text-white px-6 lg:px-20 pt-20">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 pb-16">

        <!-- Column 1: Brand Info -->
        <div class="fade-up">
            <h3 class="text-4xl font-black mb-2" style="font-family: 'Tajawal', sans-serif;">
                <?php echo htmlspecialchars($tenant->site_name ?? ($lang === 'en' ? 'Nove Clean' : 'نوف كلين')); ?>
            </h3>
            <p class="text-[#ff7a00] font-black mb-4 text-lg"><?php echo $lang === 'en' ? 'Nove Clean' : 'نوف كلين'; ?></p>
            <p class="text-gray-400 leading-loose text-sm">
                <?php echo htmlspecialchars(!empty($tenant->meta_description) ? $tenant->meta_description : ($lang === 'en' ? 'A specialized company providing professional cleaning services for homes and businesses. We deliver the highest quality standards with a trained team, modern equipment, and guaranteed results.' : 'شركة متخصصة في تقديم خدمات التنظيف الاحترافية للمنازل والشركات. نقدم أعلى معايير الجودة مع فريق مدرب ومعدات حديثة ونتائج مضمونة.')); ?>
            </p>
            <div class="flex gap-3 mt-6">
                <?php if (!empty($tenant->contact_whatsapp)): ?>
                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp) ?>"
                   target="_blank" rel="noopener noreferrer"
                   class="w-10 h-10 bg-white/10 text-white flex items-center justify-center hover:bg-[#ff7a00] transition-all duration-300 rounded-sm">
                    <i class="fab fa-whatsapp text-lg"></i>
                </a>
                <?php endif; ?>
                <?php if (!empty($tenant->facebook)): ?>
                <a href="<?= htmlspecialchars($tenant->facebook) ?>" target="_blank" rel="noopener noreferrer"
                   class="w-10 h-10 bg-white/10 text-white flex items-center justify-center hover:bg-[#ff7a00] transition-all duration-300 rounded-sm">
                    <i class="fab fa-facebook-f text-lg"></i>
                </a>
                <?php endif; ?>
                <?php if (!empty($tenant->instagram)): ?>
                <a href="<?= htmlspecialchars($tenant->instagram) ?>" target="_blank" rel="noopener noreferrer"
                   class="w-10 h-10 bg-white/10 text-white flex items-center justify-center hover:bg-[#ff7a00] transition-all duration-300 rounded-sm">
                    <i class="fab fa-instagram text-lg"></i>
                </a>
                <?php endif; ?>
                <?php if (!empty($tenant->twitter)): ?>
                <a href="<?= htmlspecialchars($tenant->twitter) ?>" target="_blank" rel="noopener noreferrer"
                   class="w-10 h-10 bg-white/10 text-white flex items-center justify-center hover:bg-[#ff7a00] transition-all duration-300 rounded-sm">
                    <i class="fab fa-twitter text-lg"></i>
                </a>
                <?php endif; ?>
                <?php if (!empty($tenant->linkedin)): ?>
                <a href="<?= htmlspecialchars($tenant->linkedin) ?>" target="_blank" rel="noopener noreferrer"
                   class="w-10 h-10 bg-white/10 text-white flex items-center justify-center hover:bg-[#ff7a00] transition-all duration-300 rounded-sm">
                    <i class="fab fa-linkedin-in text-lg"></i>
                </a>
                <?php endif; ?>
                <?php if (!empty($tenant->youtube)): ?>
                <a href="<?= htmlspecialchars($tenant->youtube) ?>" target="_blank" rel="noopener noreferrer"
                   class="w-10 h-10 bg-white/10 text-white flex items-center justify-center hover:bg-[#ff7a00] transition-all duration-300 rounded-sm">
                    <i class="fab fa-youtube text-lg"></i>
                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Column 2: Services -->
        <div class="fade-up">
            <h4 class="text-2xl font-black mb-6 relative inline-block">
                <?php echo $lang === 'en' ? 'Services' : 'الخدمات'; ?>
                <span class="absolute -bottom-2 right-0 w-10 h-1 bg-[#ff7a00] rounded-sm"></span>
            </h4>
            <ul class="space-y-4 text-gray-400">
                <?php if (!empty($services)): ?>
                    <?php foreach (array_slice($services, 0, 6) as $svc): ?>
                    <li>
                        <a href="<?= url('/service/' . ($svc->slug ?? $svc->id)) ?>" class="hover:text-[#ff7a00] transition-colors text-sm">
                            <?php echo htmlspecialchars(($lang === 'en' && !empty($svc->title_en)) ? $svc->title_en : ($svc->title ?? '')); ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php
                    $fallbackServices = $lang === 'en'
                        ? ['Home Cleaning', 'Office Cleaning', 'Carpet Cleaning', 'Full Sanitization', 'Post-Construction Cleaning']
                        : ['تنظيف المنازل', 'تنظيف المكاتب', 'تنظيف السجاد', 'التعقيم الشامل', 'تنظيف بعد البناء'];
                    foreach ($fallbackServices as $svcName): ?>
                    <li><a href="#" class="hover:text-[#ff7a00] transition-colors text-sm"><?php echo htmlspecialchars($svcName); ?></a></li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Column 3: Quick Links -->
        <div class="fade-up">
            <h4 class="text-2xl font-black mb-6 relative inline-block">
                <?php echo $lang === 'en' ? 'Links' : 'روابط'; ?>
                <span class="absolute -bottom-2 right-0 w-10 h-1 bg-[#ff7a00] rounded-sm"></span>
            </h4>
            <ul class="space-y-4 text-gray-400">
                <?php foreach ($menu ?? [] as $item): ?>
                <li>
                    <a href="<?= url($item->is_home ? '/' : $item->slug) ?>"
                       class="hover:text-[#ff7a00] transition-colors text-sm">
                        <?= htmlspecialchars($item->title) ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Column 4: Contact Info -->
        <div class="fade-up">
            <h4 class="text-2xl font-black mb-6 relative inline-block">
                <?php echo $lang === 'en' ? 'Contact' : 'التواصل'; ?>
                <span class="absolute -bottom-2 right-0 w-10 h-1 bg-[#ff7a00] rounded-sm"></span>
            </h4>
            <ul class="space-y-4 text-gray-400">
                <?php if (!empty($tenant->contact_phone)): ?>
                <li class="flex items-center gap-3 text-sm">
                    <i class="fas fa-phone text-[#ff7a00]"></i>
                    <a href="tel:<?= preg_replace('/[^0-9+]/', '', $tenant->contact_phone) ?>" class="hover:text-white transition-colors" dir="ltr">
                        <?= htmlspecialchars($tenant->contact_phone) ?>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (!empty($tenant->contact_whatsapp)): ?>
                <li class="flex items-center gap-3 text-sm">
                    <i class="fab fa-whatsapp text-[#ff7a00]"></i>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $tenant->contact_whatsapp) ?>" target="_blank" class="hover:text-white transition-colors" dir="ltr">
                        <?= htmlspecialchars($tenant->contact_whatsapp) ?>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (!empty($tenant->contact_email)): ?>
                <li class="flex items-center gap-3 text-sm">
                    <i class="fas fa-envelope text-[#ff7a00]"></i>
                    <a href="mailto:<?= htmlspecialchars($tenant->contact_email) ?>" class="hover:text-white transition-colors">
                        <?= htmlspecialchars($tenant->contact_email) ?>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (!empty($tenant->address)): ?>
                <li class="flex items-center gap-3 text-sm">
                    <i class="fas fa-location-dot text-[#ff7a00]"></i>
                    <span><?= htmlspecialchars($tenant->address) ?></span>
                </li>
                <?php endif; ?>
                <?php if (!empty($tenant->working_hours)): ?>
                <li class="flex items-center gap-3 text-sm">
                    <i class="fas fa-clock text-[#ff7a00]"></i>
                    <span><?= htmlspecialchars($tenant->working_hours) ?></span>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <!-- Copyright -->
    <div class="bg-[#ff7a00] text-[#1f2a3b] text-center py-5 font-black text-sm">
        &copy; <?= date('Y') ?> <?= htmlspecialchars($tenant->site_name ?? ($lang === 'en' ? 'Nove Clean' : 'لمعة كلين')) ?> — <?php echo $lang === 'en' ? 'All rights reserved' : 'جميع الحقوق محفوظة'; ?>
    </div>
</footer>
